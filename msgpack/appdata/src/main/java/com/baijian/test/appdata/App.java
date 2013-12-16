package com.baijian.test.appdata;

import org.msgpack.MessagePack;
import org.msgpack.template.Template;
import org.msgpack.unpacker.Unpacker;

import java.io.*;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import static org.msgpack.template.Templates.tList;
import static org.msgpack.template.Templates.TString;

/**
 * Hello world!
 *
 */
public class App 
{
    public static void main( String[] args ) throws Exception
    {
        App app = new App();

        byte[] res = app.get();
        MessagePack msgpack = new MessagePack();
        List<String> list = new ArrayList<String>();
        ByteArrayInputStream in = new ByteArrayInputStream(res);
        Template<List<String>> listTemplate = tList(TString);
        Unpacker unpacker = msgpack.createUnpacker(in);
        list = unpacker.read(listTemplate);
        System.out.println(list.get(0));
    }

    private byte[] get() throws Exception {
        String url = "http://demo.up.com/?type=array";
        //String url = "http://demo.up.com/?type=obj";
        URL obj = new URL(url);
        HttpURLConnection con = (HttpURLConnection) obj.openConnection();
        con.setRequestMethod("GET");
        int statusCode = con.getResponseCode();
        //System.out.println("ResponseCode: " + statusCode);
        InputStream inputStream = con.getInputStream();
        //int a = inputStream.read();
        byte[] data = new byte[1000];
        int chunk = inputStream.read(data);
        while(chunk != -1){
            chunk = inputStream.read(data);
        }
        inputStream.close();
        return data;
    }

    private void post(String url) throws Exception {
        URL obj = new URL(url);
        HttpURLConnection con = (HttpURLConnection)obj.openConnection();
        con.setRequestMethod("POST");
        String urlParams = "type=array&name=baijian";
        con.setDoOutput(true);
        DataOutputStream wr = new DataOutputStream(con.getOutputStream());
        wr.writeBytes(urlParams);
        wr.flush();
        wr.close();
        int statusCode = con.getResponseCode();
        BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
        String inputLine;
        StringBuffer response = new StringBuffer();
        while((inputLine = in.readLine()) != null){
            response.append(inputLine);
        }
        in.close();
        System.out.println(response.toString());
    }
}
