package com.baijian.test.appdata;

import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;
import java.security.cert.CertificateException;
import java.security.cert.X509Certificate;

public class HttpsHandler {

    public static void trustAllHttpsCertificates() throws Exception {
        TrustManager[] tmArray = new TrustManager[1];
        TrustManager tm = new myTrustManager();
        tmArray[0] = tm;
        SSLContext sc = SSLContext.getInstance("SSL");
        sc.init(null, tmArray, null);
        HttpsURLConnection.setDefaultSSLSocketFactory(sc.getSocketFactory());
    }

    public static class myTrustManager implements TrustManager,X509TrustManager {
        @Override
        public void checkClientTrusted(X509Certificate[] x509Certificates, String s) throws CertificateException {
            return;
        }

        @Override
        public void checkServerTrusted(X509Certificate[] x509Certificates, String s) throws CertificateException {
            return;
        }

        public X509Certificate[] getAcceptedIssuers() {
            return null;
        }

        public boolean isServerTrusted(X509Certificate[] certs) {
            return true;
        }

        public boolean isClientTrusted(X509Certificate[] certs) {
            return true;
        }
    }
}
