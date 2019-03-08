package fme;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.PrintWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;

public class FileSender
{
  private static final String LINE_FEED = "\r\n";
  private String urlToConnect;
  private File fileToUpload;
  private String filename;
  private String mimeType;
  public boolean sent = false;
  
  public FileSender(String uri, String candRef, String docRef, String file_location) {
    initialize(uri, candRef, docRef, file_location);
  }
  
  public void initialize(String uri, String candRef, String docRef, String file_location) {
    urlToConnect = (uri + "?OP=UPLOAD");
    urlToConnect = (urlToConnect + "&AVISO=" + CParseConfig.hconfig.get("aviso"));
    urlToConnect = (urlToConnect + "&CLASSE=" + CParseConfig.hconfig.get("extensao"));
    urlToConnect = (urlToConnect + "&VS=" + java.net.URLEncoder.encode(CBData.vs));
    urlToConnect = (urlToConnect + "&REFC=" + candRef);
    urlToConnect = (urlToConnect + "&DOC=" + docRef);
    

    fileToUpload = new File(file_location);
    String[] fnp = file_location.split("\\\\");
    filename = fnp[(fnp.length - 1)];
    mimeType = java.net.URLConnection.guessContentTypeFromName(filename);
  }
  
  public ArrayList<String> SendFile() {
    ArrayList<String> buffer_out = null;
    try
    {
      String boundary = Long.toHexString(System.currentTimeMillis());
      
      HttpURLConnection conn = (HttpURLConnection)new URL(urlToConnect).openConnection();
      conn.setRequestMethod("POST");
      conn.setUseCaches(false);
      conn.setDoInput(true);
      conn.setDoOutput(true);
      conn.setRequestProperty("Content-Type", "multipart/form-data; boundary=" + boundary);
      OutputStream os = null;
      PrintWriter writer = null;
      try {
        os = conn.getOutputStream();
        writer = new PrintWriter(new OutputStreamWriter(os));
        writer.append("--" + boundary).append("\r\n");
        writer.append("Content-Disposition: form-data; name=\"file\"; filename=\"" + filename + "\"").append("\r\n");
        writer.append("Content-Type: " + mimeType).append("\r\n");
        writer.append("Content-Transfer-Encoding: binary").append("\r\n");
        writer.append("\r\n");
        writer.flush();
        FileInputStream inputStream = new FileInputStream(fileToUpload);
        byte[] buffer = new byte['က'];
        int bytesRead = -1;
        while ((bytesRead = inputStream.read(buffer)) != -1) {
          os.write(buffer, 0, bytesRead);
        }
        os.flush();
        inputStream.close();
        
        writer.append("\r\n");
        writer.flush();
        
        writer.append("\r\n");
        writer.append("--" + boundary + "--").append("\r\n");
      } finally {
        if (writer != null) { writer.close();
        }
      }
      
      int responseCode = conn.getResponseCode();
      BufferedReader in = null;
      if (responseCode == 200) {
        in = new BufferedReader(new InputStreamReader(conn.getInputStream()));
        sent = true;
      } else if (responseCode >= 400) {
        in = new BufferedReader(new InputStreamReader(conn.getErrorStream()));
      }
      if (in != null) {
        buffer_out = new ArrayList();
        String line; while ((line = in.readLine()) != null) { String line;
          buffer_out.add(line);
          System.out.println(line);
        }
      }
    } catch (MalformedURLException e) {
      e.printStackTrace();
    } catch (IOException e) {
      e.printStackTrace();
    }
    return buffer_out;
  }
}
