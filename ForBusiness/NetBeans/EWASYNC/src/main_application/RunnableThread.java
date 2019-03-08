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
import prototype_sync.PHC_websyncView;
import java.net.URLEncoder;
import java.sql.SQLException;
import java.text.ParseException;
import java.util.Arrays;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;
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
                    } catch (SQLException ex) {
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
    
    public static void setOutput(String message) 
    {
        String old_message = prototype_sync.PHC_websyncView.jTextArea1.getText();
        int str_len = old_message.length();
        int str_begin = 0;
        
        if( str_len >= 500 ) {
            str_begin = str_len - str_begin;
        }
        prototype_sync.PHC_websyncView.jTextArea1.setText(old_message.substring(str_begin, str_len) + message + "\n");
        prototype_sync.PHC_websyncView.jTextArea1.setCaretPosition(prototype_sync.PHC_websyncView.jTextArea1.getDocument().getLength());
    }
    
    public static void setOutputReg(int cur, int tot) 
    {
        if(tot >0)
        {
            String old_message = prototype_sync.PHC_websyncView.jTextArea1.getText();
            old_message = old_message.substring(0, old_message.lastIndexOf("\n"));

            int max = 30;
            int val = (cur*max) / tot;
            int rest = max - val;

            char[] myChar = new char[val];
            Arrays.fill(myChar, '|');
            char[] myChar2 = new char[rest];
            Arrays.fill(myChar2, '_');

            String message = "[" + (new String(myChar)) + (new String(myChar2)) + "]";
            prototype_sync.PHC_websyncView.jTextArea1.setText(old_message + "\n" + message );
            prototype_sync.PHC_websyncView.jTextArea1.setCaretPosition(prototype_sync.PHC_websyncView.jTextArea1.getDocument().getLength());
        }
    }
    
    public void update_process() throws IOException, ClassNotFoundException, ParseException, SQLException 
    {
        config = new Config();
        int time_interval = Integer.parseInt(config.getSyncInterval());
        
        try 
        {
            setOutput("A exportar dados -----");
            export_dados();
            
            System.gc();
            
            setOutput("A aguardar " + time_interval + " segundos-----");
            Thread.sleep( time_interval*1000 );
        } 
        catch (InterruptedException ex) 
        {
            Logger.getLogger(RunnableThread.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
        
    public void export_dados() throws IOException, ClassNotFoundException, ParseException, SQLException
    {
        site = new Site();
        config = new Config();

        String data = "";
        String responseText = ""; 
        GenericResponse gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");
        site.setUrl(config.getUrl());
        
        Dados dados = new Dados( config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb(), config.getNumRows());
        ArrayList<DataObject> Ldados = dados.list();
        
        if ( Ldados != null ) 
        {
            if (Ldados.size() > 0 )
            {
                try 
                {
                    int listSize = Ldados.size();
                    setOutput( "Dados para atualizar: " +  listSize);
                    
                    data = "data=" + URLEncoder.encode(serializer.deepSerialize( Ldados ), "UTF-8");

                    site.sendData(data);
                    
                    System.out.println(config.getUrl());

                    System.out.println(site.response);
                    
                    responseText = site.response.readLine();

                    ArrayList<DataResult> results;
                            
                    try 
                    {
                        results = new JSONDeserializer<ArrayList<DataResult>>().use(null, ArrayList.class).
                            use( "values", DataResult.class).
                            deserialize( responseText);
                    } 
                    catch( Exception e ) 
                    {     
                        setOutput( "Erro na sincronização dos dados" );
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
                    for( DataResult result : results) 
                    {
                        if ( !result.save( config ) ) 
                        {
                            errors++;
                        }
                    }
                    
                    //limpa memoria
                    results = null;
                    dados = null;
                    Ldados = null;
                    serializer = null;
                    site = null;
                    config = null;
                    data = null;
                    responseText = null;
                    gr = null;

                    if ( errors > 0 ) 
                    {
                        setOutput( "Ocorreu um erro ao sincronizar os dados! Verificar log." );
                    } 
                    else
                    {
                        setOutput( "Dados atualizados com sucesso!" );
                    } 
                }
                catch (IOException e )
                {
                    WriteToLog("Erro na sincronização dos dados");
                    WriteToLog("Detalhes");
                    WriteToLog( e.toString() );
                    Ldados = null;
                    return;
                }
            } 
            else 
            {
                setOutput( "Todos os dados estão atualizados" );
                Ldados = null;
            }
        } 
        else 
        {
            setOutput( "Ocorreu um erro ao obter os dados! Verificar log." );
            Ldados = null;
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
}
