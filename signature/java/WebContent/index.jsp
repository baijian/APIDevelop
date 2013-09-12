<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ page import="java.util.HashMap" %>
<%@ page import="java.util.Enumeration" %>
<%@ page import="com.xiaocong.pay.notify.*" %>
<%@ page import="tv.xiaocong.appstore.common.security.rsa.*" %>
<%@ page import="java.security.*" %>
<%@ page import="java.io.*" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>NotifyInterfaceDemo</title>
</head>
<body>
<%
//获取签名方式好进行验签工作,默认RSA,返回结果签名方式同验签方式
String sign_type = request.getParameter("sign_type");//签名类型 MD5或RSA
if(sign_type != null && sign_type.equals("MD5")){
	sign_type = "MD5";
}else {
	sign_type = "RSA";//如果不指明为MD5,默认采用RSA方式
}
//获取请求方的标识ID以获得对应的公钥,私钥来进行验签与签名(没有标识id采用默认公钥与私钥)
String partner_id = request.getParameter("partner_id");
String md5key="2c8480d73b789a87b4a41cea2feb52ca";//默认的key
String rsapubkey="";//client
String rsaprikey="";//server
ServletContext sc = config.getServletContext();
if(sign_type.equals("MD5")){
	if(partner_id != null){
		md5key = "2c8480d73b789a87b4a41cea2feb52ca";//写死->写配置,对应与partner_id
	}
}else {//RSA
	String fileid;
	if(partner_id != null){
		fileid = partner_id;
	}else {
		fileid = "1342";//default
	}
	try{
		InputStream in = sc.getResourceAsStream("/WEB-INF/keys/client/rsa_public_key_" + partner_id + ".pem");
		BufferedReader br = new BufferedReader(new InputStreamReader(new BufferedInputStream(in)));
		String s = br.readLine(); 
		StringBuffer keyBuf = new StringBuffer();
		s = br.readLine();
		while(s.charAt(0) != '-'){
			keyBuf.append(s + "\r");
			s = br.readLine();
		}
		rsapubkey = keyBuf.toString();
		br.close();
		in.close();
		out.flush();
		in = sc.getResourceAsStream("/WEB-INF/keys/server/rsa_private_key_" + partner_id + "_pkcs8.pem");
		br = new BufferedReader(new InputStreamReader(new BufferedInputStream(in)));
		s = br.readLine(); 
		keyBuf = new StringBuffer();
		s = br.readLine();
		while(s.charAt(0) != '-'){
			keyBuf.append(s + "\r");
			s = br.readLine();
		}
		rsaprikey = keyBuf.toString();
		br.close();
		in.close();
		out.flush();
	}catch(Exception e){
		e.printStackTrace();
	}
}
String result;//返回结果字符串声明
//先进行参数检查
Utils u = new Utils(); 
if(request.getParameter("order_no") == null 
|| request.getParameter("amount") == null
|| request.getParameter("partner_id") == null
|| request.getParameter("sign") == null
|| request.getParameter("sign_type") == null
|| request.getParameter("goods_desc") == null
|| request.getParameter("status") == null)
{//参数检查不通过
	String sig;
	if(sign_type.equals("MD5")){
		String in = "message=参数有误&partner_id="+partner_id+"&status=400001";
		sig = u.create_sig(in, md5key);
	} else {//RSA
		String in = "message=参数有误&partner_id="+partner_id+"&status=400001";
		sig = u.sign(in.getBytes(), rsaprikey);
	}
	result = "{\"status\":\"400001\",\"message\":\"参数有误\",\"partner_id\":\"" + partner_id 
		+ "\",\"sign_type\":\""+sign_type+"\",\"sign\":\"" + sig + "\"}";
}else {//参数检查通过,进行验签工作
	String current_sig = request.getParameter("sign");
	String return_sig;
    String in = "amount=" + request.getParameter("amount")
            + "&goods_desc" + request.getParameter("goods_desc")
            + "&order_no=" + request.getParameter("order_no")
            + "&partner_id=" + request.getParameter("partner_id")
            + "&status=" + request.getParameter("status");
	if(sign_type.equals("MD5")){
		String n_sig = u.create_sig(in, md5key);
		if(current_sig.equals(n_sig)){
			return_sig = u.create_sig("message=success&partner_id="+ partner_id +"&status=200", md5key);
			result = "{\"status\":\"200\",\"message\":\"success\",\"partner_id\":\""
                + partner_id+"\",\"sign_type\":\""
			    + sign_type +"\",\"sign\":\""+ return_sig +"\"}";
		} else { //签名失败
			return_sig = u.create_sig("message=sign_fail&partner_id=" + partner_id + "&status=400002",md5key);
			result = "{\"status\":\"400002\",\"message\":\"sign_fail\"," 
                + "\"partner_id\":\"" + partner_id + "\"," 
                + "\"sign_type\":\"" 
				+ sign_type + "\",\"sign\":\"" + return_sig + "\"}";
		}
	} else {//RSA
		if(u.verify(in.getBytes(), rsapubkey, request.getParameter("sign"))){
			String return_to_sign = "message=success&partner_id=" + partner_id + "&status=200";
			return_sig = u.sign(return_to_sign.getBytes(), rsaprikey);
			result = "{\"status\":\"200\",\"message\":\"success\",\"partner_id\":\""
				+partner_id+"\",\"sign_type\":\""
			 	+ sign_type +"\",\"sign\":\""+return_sig+"\"}";
		} else {//签名失败
            String return_to_sign = "message=sign_fail&partner_id=" + partner_id + "&status=400002";
			return_sig = u.sign(return_to_sign.getBytes(), rsaprikey);
            result = "{\"status\":\"400002\",\"message\":\"sign_fail\"," 
                + "\"partner_id\":\"" + partner_id + "\","
                + "\"sign_type\":\"" 
				+ sign_type + "\",\"sign\":\"" + return_sig + "\"}";
		}
	}
}
out.println(result);
%>
</body>
</html>
