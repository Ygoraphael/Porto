/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.InetAddress;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.UnknownHostException;
import java.util.Date;
import java.util.logging.Level;
import java.util.logging.Logger;
import flexjson.JSONDeserializer;
import flexjson.JSONSerializer;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.net.SocketTimeoutException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Timer;
import java.util.TimerTask;
import javax.swing.JOptionPane;
import java.net.URLEncoder;
import java.text.ParseException;
import java.util.Arrays;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;
import java.util.Scanner;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 *
 * @author Tiago Loureiro
 */
public class RunnableThread implements Runnable {
    
    private Site site = null;
    private Config config = null;
    
    private boolean paused = true;
    private final Object LOCK = new Object();
    Thread t;
    boolean running = true;
    int init = 0;
    
    public RunnableThread() 
    {
        t = new Thread(this);
        t.start();
    }
    
    public void run() {
        while (running) {
            synchronized(LOCK) {
                if (paused) {
                    try {
                        System.out.println("Exit");
                        LOCK.wait();
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                } else {
                    try {
                        update_process();
                    }
                    catch (ClassNotFoundException ex) {
                        Logger.getLogger(RunnableThread.class.getName()).log(Level.SEVERE, null, ex);
                    } catch (IOException ex) {
                        Logger.getLogger(RunnableThread.class.getName()).log(Level.SEVERE, null, ex);
                    } catch (ParseException ex) {
                        Logger.getLogger(RunnableThread.class.getName()).log(Level.SEVERE, null, ex);
                    }
                }
            }
        }
    }
    
    public static void WriteToLog(String message) throws IOException
    {
        String app_path = System.getProperty("user.dir") + "\\log.txt";
        Calendar cal = Calendar.getInstance();
    	cal.getTime();
    	SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
        
        try {
            PrintWriter out = new PrintWriter(new BufferedWriter(new FileWriter(app_path, true)));
            out.println( sdf.format(cal.getTime()) + " - " + message );
            out.close();
        } 
        catch (IOException e) 
        {
            System.out.println(e);
        }
    }
    
    public void stop() throws UnknownHostException, IOException 
    {
        t.stop();
        synchronized(LOCK) 
        {
            paused = true;
            running = false;
            LOCK.notify();
        }
    }

    public void resume() {
        synchronized(LOCK) {
            paused = false;
            LOCK.notify();
        }
    }
    
    public void update_process() throws IOException, ClassNotFoundException, ParseException 
    {
        config = new Config();
        int time_interval = Integer.parseInt(config.getSyncInterval());
        String from = "noreply@fullwear.pt";
        String host = "mail.novoscanais.com";
        String user = "tiago.loureiro@novoscanais.com";
        String password = "tl123";
        String subject = "Fullwear - Pagamento efectuado com sucesso";
        
        try 
        {
            System.out.println("A Importar Pagamentos-----");
            import_pagamentos(from, host, user, password, subject);
            System.out.println("A Aguardar " + time_interval + " segundos-----");
            Thread.sleep( time_interval*1000 );
        } 
        catch (InterruptedException ex) 
        {
            Logger.getLogger(RunnableThread.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
   
    public static String unescapeUnicode(String string) {
        Matcher matcher = Pattern.compile("\\\\u((?i)[0-9a-f]{4})").matcher(string);
        while (matcher.find()) {
            int codepoint = Integer.valueOf(matcher.group(1), 16);
            string = string.replaceAll("\\" + matcher.group(0), String.valueOf((char) codepoint));
        }
        return string;
    }
    
    public void import_pagamentos(String from, String host, String user, String password, String subject) throws IOException, ClassNotFoundException
    {
        site = new Site();
        config = new Config();
        String data = null;
        String responseText = null;
        ArrayList<Pagamento> pags = null;
        site.setUrl( config.getUrlPagamentos() );
        
        try {
            data = "chavebackoffice=0000-0000-0000-0000&entidade=11604&subentidade=999&dtHrInicio= &dtHrFim=&referencia=&valor=&sandbox=1";
            site.sendData(data);
            
            responseText = site.response.readLine();
            responseText = unescapeUnicode(responseText);

            try 
            {
                pags = new JSONDeserializer<ArrayList<Pagamento>>().use(null, ArrayList.class).
                    use( "values", Pagamento.class).
                    deserialize( responseText);
            } 
            catch( Exception e ) 
            {     
                System.out.println("Não existem encomendas para importar!");
                WriteToLog( "Erro ao ler resposta do servidor.");
                WriteToLog( "O servidor respondeu: ");
                WriteToLog( responseText );
                while( (responseText = site.response.readLine()) != null ) 
                {
                    WriteToLog( responseText);
                }
                WriteToLog( "Excepção: " + e.toString() );
                return;
            }

           int errors = 0;
           for( Pagamento pag : pags) 
           {
               if ( !pag.update( config, from, host, user, password, subject ) ) 
               {
                   errors++;
               }
           }
            
           if ( errors > 0 ) 
           {
               System.out.println("Ocorreram erros ao importar pagamentos! " + "Por favor verifique no PHC.");    
           } 
           else
           {
               System.out.println("Pagamentos importados com sucesso!");
           }     
        } 
        catch (Exception e) 
        {
            System.out.println("Erro desconhecido.");
            WriteToLog( e.toString() );
            return;
        }
    }
}
