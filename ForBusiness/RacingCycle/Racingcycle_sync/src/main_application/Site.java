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
    private final String USER_AGENT = "Mozilla/5.0";
    
    public Site() {
    }
    
    public Site( String addr ) throws MalformedURLException, IOException  {
        setUrl( addr );
    }
    
    
    public final void setUrl( String url ) throws IOException  {
        try 
        {
            this.url = new URL( url );
        } 
        catch (MalformedURLException ex) {
            main_application.RunnableThread.WriteToLog( "Erro: comunicação servidor!" );
            main_application.RunnableThread.WriteToLog( "Detalhes:" );
            main_application.RunnableThread.WriteToLog( ex.toString() );
            return;
        }
    }

    public void sendData( String data ) throws IOException {
        
        try
        {
            this.conn =  (HttpURLConnection) url.openConnection();

            conn.setDoOutput(true);
            conn.setRequestMethod("POST");
            conn.setDoInput(true);
            conn.setUseCaches(false);
            conn.setAllowUserInteraction(false);
            conn.setRequestProperty("Content-Type", "application/x-www-form-urlencoded;charset=utf8");
            conn.setRequestProperty("User-Agent", USER_AGENT);
            

            DataOutputStream wr = new DataOutputStream(conn.getOutputStream());
            wr.writeBytes(data);
            wr.flush();

            this.response = new BufferedReader(new InputStreamReader(conn.getInputStream()));
        }
        catch(Exception e)
        {  
            main_application.RunnableThread.WriteToLog( "Erro: comunicação servidor envio!" );
            main_application.RunnableThread.WriteToLog( "Detalhes:" );
            main_application.RunnableThread.WriteToLog( e.toString() );
            if(e.toString().contains("Could not connect to SMTP host") || e.toString().contains("java.net.ConnectException") || e.toString().contains("java.net.SocketTimeoutException") || e.toString().equals("java.net.SocketException")){
               main_application.RunnableThread.WriteToLog( "Erro de ligação. Poderá ser exporádico." );
            } else{
                return;
            }
        }
    }
}
