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
import java.io.IOException;
import java.net.SocketTimeoutException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Timer;
import java.util.TimerTask;
import javax.swing.JOptionPane;
import sincronizador_ncweb.Sincronizador_NCWebView;

/**
 *
 * @author Tiago Loureiro
 */
public class RunnableThread implements Runnable {
    private boolean paused = true;
    private Site site = null;
    private final Object LOCK = new Object();
    Thread t;
    boolean running = true;
    int init = 0;
    
    public RunnableThread() {
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
                    }
                }
            }
        }
    }
    
    public void stop() throws UnknownHostException, IOException {
        t.stop();
        synchronized(LOCK) {
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
    
    public void setOutput(String message) {
        String old_message = sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getText();
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setText(old_message + message + "\n");
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setCaretPosition(sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getDocument().getLength());
    }
    
    public void update_process() throws IOException, ClassNotFoundException {
        site = new Site();
        
        String data; 
        String responseText; 
        ArrayList<GenericResponse> gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class"); 
        
        site.setUrl( "http://localhost/System_general/get_enterprises_array/" + gen_token(3) );
        data = "";
        site.sendData( data );
        responseText = site.response.readLine();
        
        try {
            gr = new JSONDeserializer<ArrayList<GenericResponse>>().use(null, ArrayList.class).
                        use( "values", GenericResponse.class).
                        deserialize( responseText );
        } catch ( Exception e ) {
            System.out.println( "Erro ao obter array empresas!");
            System.out.println( "O Servidor respondeu: " );
            while( (responseText = site.response.readLine()) != null ) {
                System.out.println( responseText );
            }
            System.out.println( e.toString() );
            return; 
        }
        
        final int time_interval = 3600 / gr.size();
        int num_empresas = gr.size();
        if (init != num_empresas) {
            setOutput("Nº Empresas: " + num_empresas);
            setOutput("Tempo Sincronização: 1 hora");
            setOutput("Intervalo Empresa a Empresa: " + time_interval + " segundos");
            init = num_empresas;
        }
        
        int i = 1;
        
        for( final GenericResponse key : gr) {
            try {
                setOutput("A Actualizar Empresa: " + key.name + "\tID: " + key.enterprise_id + "\t:::::######::::: " + i + " de " + num_empresas);
                i++;
                site.setUrl( "http://localhost/System_general/update_process/" + gen_token(3) + "/" + key.enterprise_id);
                data = "";
                site.sendData( data );
                Thread.sleep(time_interval*1000);
            } catch (InterruptedException ex) {
                Logger.getLogger(RunnableThread.class.getName()).log(Level.SEVERE, null, ex);
            }
            catch (SocketTimeoutException e) {
                System.out.println("TIMEOUT.");
            }
        }
        i = 1;
    }
    
    public static String gen_token (int len) {
        String token = "";
        
        for (int i = 0; i < len; i++) {
            int num = (int) (Math.random()*10);
            token += num;
        }
        
        DateFormat dateFormat = new SimpleDateFormat("HH:mm");
        Date date = new Date();
        
        String current_time = dateFormat.format(date);
        
        String first = current_time.substring(1, 2) + current_time.substring(0, 1);
        String second = current_time.substring(4, 5) + current_time.substring(3, 4);
        
        token += second;
        token += "_";
        
        for (int i = 0; i < len; i++) {
            int num = (int) (Math.random() * 10);
            token += num;
        }
        
        token += first;
        
        return token;
    }
}
