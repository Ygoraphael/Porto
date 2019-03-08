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
import sincronizador_ncweb.Sincronizador_NCWebView;

/**
 *
 * @author Tiago Loureiro
 */
public class RunnableThread implements Runnable {
    private boolean paused = true;
    private final Object LOCK = new Object();
    Thread t;
    ServerSocket server = null;
    boolean init = false;
    boolean running = true;
    
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
                        server_listening();
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
            server.close();
            LOCK.notifyAll();
        }
    }

    public void resume() {
        synchronized(LOCK) {
            paused = false;
            LOCK.notifyAll();
        }
    }
    
    public void setOutput(String message) {
        String old_message = sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getText();
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setText(old_message + message + "\n");
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setCaretPosition(sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getDocument().getLength());
    }
    
    public void init_socket() throws IOException {
        int port = 9876;
        server = new ServerSocket(port);
        server.setSoTimeout(1);
    }
    
    public void server_listening() throws IOException, ClassNotFoundException {
        if (init == false) {
            init_socket();
            init = true;
        }
        Socket socket = null;
        BufferedReader ois = null;
        PHC phc = new PHC();
        try {
            socket = server.accept();
            ois = new BufferedReader(new InputStreamReader(socket.getInputStream()));
            String message = "";
            String line = "";
            while ((line = ois.readLine()) != null){
                message += line;
            }
            Date date_current = new Date();
            setOutput("FROM: " + socket.getInetAddress() + ":" + socket.getPort() +
                      " MSG: " + message + " DATE: " + date_current);
            
            phc.execute_command(message);
            
            ois.close();
            socket.close();
        }
        catch (Exception  e) {
            
        }
        //ObjectOutputStream oos = new ObjectOutputStream(socket.getOutputStream());
        //oos.writeObject("Hi Client " + message);
        //oos.close();
    }
}
