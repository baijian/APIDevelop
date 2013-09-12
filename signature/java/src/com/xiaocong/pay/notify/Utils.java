package com.xiaocong.pay.notify;

import java.security.*;
import java.security.spec.PKCS8EncodedKeySpec;
import java.security.spec.X509EncodedKeySpec;

import sun.misc.BASE64Encoder;
import sun.misc.BASE64Decoder;



public class Utils {

	/*
	 * MD5 
	 */
	public String create_sig(String in, String private_key) throws Exception{
		String str = private_key + in + private_key;
		byte[] bytes = str.getBytes("UTF-8");
		MessageDigest md = MessageDigest.getInstance("MD5");
		md.update(bytes);
		byte byteData[] = md.digest(); 
		StringBuffer sb = new StringBuffer();
		for(int i = 0; i < byteData.length; i++){
			sb.append(Integer.toString((byteData[i] & 0xff) + 0x100, 16).substring(1));
		}
		return sb.toString();
	}
	
	/*
	 * RSA
	 */
	public String sign(byte[] data, String privateKey) throws Exception{
		byte[] keyBytes =(new BASE64Decoder()).decodeBuffer(privateKey);
		PKCS8EncodedKeySpec pkcs8KeySpec = new PKCS8EncodedKeySpec(keyBytes);
		KeyFactory keyFactory = KeyFactory.getInstance("RSA");
		PrivateKey prikey = keyFactory.generatePrivate(pkcs8KeySpec);
		Signature signature = Signature.getInstance("MD5withRSA");
		signature.initSign(prikey);
		signature.update(data);
		return (new BASE64Encoder()).encode(signature.sign());
	}
	
	public boolean verify(byte[] data, String publickey, String sign)throws Exception {
		byte[] keyBytes = (new BASE64Decoder()).decodeBuffer(publickey);
		X509EncodedKeySpec keySpec = new X509EncodedKeySpec(keyBytes);
		KeyFactory keyFactory = KeyFactory.getInstance("RSA");
		PublicKey pubKey = keyFactory.generatePublic(keySpec);
		Signature signature = Signature.getInstance("MD5withRSA");
		signature.initVerify(pubKey);
		signature.update(data);
		return signature.verify((new BASE64Decoder()).decodeBuffer(sign));
	}
	
}
