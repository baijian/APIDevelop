package com.baijian.test.appdata;


import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLSession;
import java.io.FileOutputStream;
import java.io.OutputStream;
import java.io.PrintStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;

public class Test {

    public static void main(String[] args) throws Exception
    {
        OutputStream outputStream = new FileOutputStream("/tmp/log.txt");
        PrintStream printStream = new PrintStream(outputStream);

        System.setOut(printStream);
        System.out.println("HelloWorld");

    }

    public void HttpResponse(String urlStr) throws Exception {
        URL url = new URL(urlStr);
        int statusCode = 0;
        if (urlStr.contains("https://")) {
            HttpsHandler.trustAllHttpsCertificates();
            HostnameVerifier hv = new HostnameVerifier() {
                @Override
                public boolean verify(String s, SSLSession sslSession) {
                    return true;
                }
            };
            HttpsURLConnection.setDefaultHostnameVerifier(hv);
            HttpsURLConnection httpsURLConnection = (HttpsURLConnection)url.openConnection();
            statusCode = httpsURLConnection.getResponseCode();
        } else {
            URLConnection urlConnection = url.openConnection();
            HttpURLConnection httpURLConnection = (HttpURLConnection)urlConnection;
            statusCode = httpURLConnection.getResponseCode();
        }
    }
}
