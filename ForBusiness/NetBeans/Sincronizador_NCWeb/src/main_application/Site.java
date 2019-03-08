/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.logging.Level;
import java.util.logging.Logger;

public class Site {
    
    private URL url = null; 
    private HttpURLConnection conn = null;
    public BufferedReader response = null;
    
    public Site() {
    }
    
    public Site( String addr ) throws MalformedURLException  {
        setUrl( addr );
    }
    
    
    public final void setUrl( String url )  {
        try {
            this.url = new URL( url );
        } catch (MalformedURLException ex) {
            System.out.println( "Erro com o endereço do servidor!!!");
        }
    }

    public void sendData( String data ) throws IOException {
        
        this.conn =  (HttpURLConnection) url.openConnection();
        
        conn.setDoOutput(true);
        conn.setRequestMethod("POST");
        conn.setDoInput(true);
        conn.setUseCaches(false);
        conn.setAllowUserInteraction(false);
        conn.setRequestProperty("Content-Type", "application/x-www-form-urlencoded;charset=utf8");
        conn.setRequestProperty("User-Agent", "Mozilla 5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.11)");
        conn.setReadTimeout(5000);
        conn.setConnectTimeout(5000);

        DataOutputStream wr = new DataOutputStream(conn.getOutputStream());
        wr.writeBytes(data);
        wr.flush();
        
        this.response = new BufferedReader(new InputStreamReader(conn.getInputStream()));
        
    }
}
