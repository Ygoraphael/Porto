package fme;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.Proxy;

class Http
{
  private HttpURLConnection httpConn;
  int timeout = 0;
  
  Http(String requestURL) {
    this(requestURL, 0);
  }
  
  Http(String requestURL, int timeout)
  {
    this.timeout = timeout;
    try {
      java.net.URL url = new java.net.URL(requestURL);
      httpConn = ((HttpURLConnection)url.openConnection());
      httpConn.setUseCaches(false);
      if (timeout > 0) { httpConn.setConnectTimeout(timeout);
      }
    }
    catch (Exception localException) {}
    

    httpConn.setDoInput(true);
    httpConn.setDoOutput(true);
  }
  
  public String doPostRequest(java.io.File f)
  {
    try
    {
      byte[] result = new byte[(int)f.length()];
      int totalBytesRead = 0;
      
      InputStream input = new java.io.BufferedInputStream(new java.io.FileInputStream(f));
      
      while (totalBytesRead < result.length) {
        int bytesRemaining = result.length - totalBytesRead;
        int bytesRead = input.read(result, totalBytesRead, bytesRemaining);
        if (bytesRead > 0) {
          totalBytesRead += bytesRead;
        }
      }
      
      input.close();
      
      OutputStream writer = new java.io.BufferedOutputStream(httpConn.getOutputStream());
      writer.write(result);
      writer.flush();
      
      InputStream inputStream = httpConn.getInputStream();
      BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
      
      String resp = "";String line = "";
      while ((line = reader.readLine()) != null) {
        resp = resp + line;
      }
      reader.close();
      return resp;
    }
    catch (Exception localException) {}
    

    return "";
  }
  
  public String doPostRequest(String s)
  {
    try
    {
      OutputStreamWriter writer = new OutputStreamWriter(httpConn.getOutputStream());
      writer.write(s);
      writer.flush();
      
      InputStream inputStream = httpConn.getInputStream();
      BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
      
      String resp = "";String line = "";
      while ((line = reader.readLine()) != null) {
        resp = resp + line;
      }
      reader.close();
      return resp;
    }
    catch (Exception localException) {}
    

    return "";
  }
  
  public String doPostRequest(java.io.ByteArrayOutputStream s)
  {
    try {
      OutputStream writer = new java.io.BufferedOutputStream(httpConn.getOutputStream());
      writer.write(s.toByteArray());
      writer.flush();
      
      InputStream inputStream = httpConn.getInputStream();
      BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
      
      String resp = "";String line = "";
      while ((line = reader.readLine()) != null) {
        resp = resp + line;
      }
      reader.close();
      return resp;
    }
    catch (Exception localException) {}
    

    return "";
  }
  
  public org.w3c.dom.Document doPostRequestDoc(String s)
  {
    try {
      OutputStreamWriter writer = new OutputStreamWriter(httpConn.getOutputStream());
      writer.write(s);
      writer.flush();
      
      return javax.xml.parsers.DocumentBuilderFactory.newInstance().newDocumentBuilder().parse(httpConn.getInputStream());
    }
    catch (Exception localException) {}
    

    return null;
  }
  

  static boolean ping(String url)
  {
    Http http = new Http(url, 1000);
    String s = http.doPostRequest("ping");
    
    if (s.equals("(reply)")) return true;
    return false;
  }
  
  static Proxy teste_proxy(String uri) {
    java.util.List<Proxy> lista = null;
    try {
      System.setProperty("java.net.useSystemProxies", "true");
      lista = java.net.ProxySelector.getDefault().select(new java.net.URI(uri));
    }
    catch (Exception e)
    {
      return null;
    }
    
    if (lista != null) {
      java.util.Iterator<Proxy> iter = lista.iterator(); if (iter.hasNext()) {
        Proxy proxy = (Proxy)iter.next();
        
        return proxy;
      }
    }
    else
    {
      return null;
    }
    return null;
  }
}
