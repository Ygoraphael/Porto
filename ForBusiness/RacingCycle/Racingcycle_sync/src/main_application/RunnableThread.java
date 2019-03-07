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
import racingcycle_sync.PHC_websyncView;
import java.net.URLEncoder;
import java.text.ParseException;
import java.util.Arrays;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;
import java.util.Properties;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.util.*;
import javax.mail.*;
import javax.mail.internet.*;
import javax.activation.*;

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
    int connectionErrors=0;
    int time=3600;
    Thread threadTimer;
    boolean skip=false;

    public RunnableThread() {
        t = new Thread(this);
        t.start();
    }

    public static void WriteToLog(String message) throws IOException {
        String app_path = System.getProperty("user.dir") + "\\log.txt";
        Calendar cal = Calendar.getInstance();
        cal.getTime();
        SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");

        try {
            PrintWriter out = new PrintWriter(new BufferedWriter(new FileWriter(app_path, true)));
            out.println(sdf.format(cal.getTime()) + " - " + message);
            out.close();
        } catch (IOException e) {
            System.out.println(e);
        }
    }

    public static void EnviaEmail() throws IOException {
        final String user = "noreply@racingcycle.net";
        final String password = "wycO$@-E{MV^";
        final String SSL_FACTORY = "javax.net.ssl.SSLSocketFactory";
        //String to = "ricardo@racingcycle.net";
        String to = "nuno.castilho@novoscanais.com";
        String from = "noreply@racingcycle.net";
        String host = "mail.racingcycle.net";
        Properties properties = System.getProperties();
        properties.setProperty("mail.smtp.host", host);
        properties.setProperty("mail.smtp.port", "465");
        properties.setProperty("mail.smtp.socketFactory.class", SSL_FACTORY);
        properties.setProperty("mail.smtp.socketFactory.fallback", "false");
        properties.setProperty("mail.smtp.auth", "true");
        Session session = Session.getDefaultInstance(properties,
                new javax.mail.Authenticator() {
                    protected PasswordAuthentication getPasswordAuthentication() {
                        return new PasswordAuthentication(user, password);
                    }
                });
        try {
            MimeMessage message = new MimeMessage(session);
            message.setFrom(new InternetAddress(from));
            message.addRecipient(Message.RecipientType.TO, new InternetAddress(to));
            message.addRecipient(Message.RecipientType.BCC, new InternetAddress("nuno.castilho@novoscanais.com"));
            message.setSubject("ERRO SINCRONIZADOR RACINGCYCLE");
            message.setText("Erro ao fazer a sincronização. Verificar sincronizador ou enviar email para nuno.castilho@novoscanais.com!");
            Transport.send(message);
            setOutput("Erro na sincronização. Email enviado!");
        } catch (MessagingException mex) {
            mex.printStackTrace();
        }
    }

    public void run() {
        while (running) {
            synchronized (LOCK) {
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
                    } catch (Exception ex) {
                        try {
                            System.out.println(ex);
                            EnviaEmail();
                            return;
                        } catch (IOException ex1) {
                            Logger.getLogger(RunnableThread.class.getName()).log(Level.SEVERE, null, ex1);
                        }
                        Logger.getLogger(RunnableThread.class.getName()).log(Level.SEVERE, null, ex);
                        return;
                    }
                }
            }
        }
    }

    public void stop() throws UnknownHostException, IOException {
        t.stop();
        synchronized (LOCK) {
            paused = true;
            running = false;
            LOCK.notify();
        }
    }

    public void resume() {
        synchronized (LOCK) {
            paused = false;
            LOCK.notify();
        }
    }

    public static void setOutput(String message) {
        try {
            String old_message = racingcycle_sync.PHC_websyncView.jTextArea1.getText();
            racingcycle_sync.PHC_websyncView.jTextArea1.setText(old_message + message + "\n");
            racingcycle_sync.PHC_websyncView.jTextArea1.setCaretPosition(racingcycle_sync.PHC_websyncView.jTextArea1.getDocument().getLength());
        }
        catch(Exception e) {
            
        }
    }
    
    public void createThreadTimer(){
        time=3600;
        threadTimer = new Thread(){
            public void run (){
                while (time>0 && running && connectionErrors<=58){
                    System.out.println("Remaining: "+time+" seconds");
                    try {
                        time--;
                        threadTimer.sleep(1000L);    // 1000L = 1000ms = 1 second
                    }
                    catch (InterruptedException e) {
                        //I don't think you need to do anything for your particular problem
                    }
                }
                connectionErrors=0;
            }
        };
    }


    public static void setOutputReg(int cur, int tot) {
        if (tot > 0) {
            String old_message = racingcycle_sync.PHC_websyncView.jTextArea1.getText();
            old_message = old_message.substring(0, old_message.lastIndexOf("\n"));

            int max = 30;
            int val = (cur * max) / tot;
            int rest = max - val;

            char[] myChar = new char[val];
            Arrays.fill(myChar, '|');
            char[] myChar2 = new char[rest];
            Arrays.fill(myChar2, '_');

            String message = "[" + (new String(myChar)) + (new String(myChar2)) + "]";
            racingcycle_sync.PHC_websyncView.jTextArea1.setText(old_message + "\n" + message);
            racingcycle_sync.PHC_websyncView.jTextArea1.setCaretPosition(racingcycle_sync.PHC_websyncView.jTextArea1.getDocument().getLength());
        }
    }

    public void update_process() throws IOException, ClassNotFoundException, ParseException, InterruptedException, Exception {
        config = new Config();
        int time_interval = Integer.parseInt(config.getSyncInterval());

        if (config.getSyncElemClientes().equals("1") && !skip) {
            setOutput("A Exportar Clientes-----");
            export_clientes();
        }
        
        if (config.getSyncElemFamilias().equals("1") && !skip) {
            setOutput("A Exportar Familias-----");
            export_familias();
        }
        if (config.getSyncElemArtigos().equals("1") && !skip) {
            setOutput("A Exportar Artigos-----");
            export_artigos();
        }

        if (config.getSyncElemEncomendas().equals("1") && !skip) {
            setOutput("A Importar Encomendas-----");
            import_encomendas();
        }
        if (config.getSyncElemEstadoEncomendas().equals("1") && !skip) {
            setOutput("A Atualizar Estado das Encomendas-----");
            export_encomendas();
        }
      
        setOutput("A Aguardar " + time_interval + " segundos-----");
        skip=false;
        Thread.sleep(time_interval * 1000);
        
    }

    public void export_encomendas() throws IOException, ClassNotFoundException, ParseException, Exception {
        site = new Site();
        config = new Config();

        String data;
        String responseText;
        GenericResponse gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl(config.getUrlEncomendasMdate());
        data = "";
        site.sendData(data);
        responseText = "";

        try {
            responseText = site.response.readLine();
        } catch (NullPointerException e) {
            throw new Exception("Something bad happened.");
        }
        site.setUrl(config.getUrlEstadoEncomendas());

        try {
            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);
        } catch (Exception e) {
            
            WriteToLog("e.toString() Encomendas : "+e.toString());
            
            if(e.toString().contains("Server returned HTTP response code: 500") || e.toString().contains("Server returned HTTP response code: 503") || e.toString().contains("Could not connect to SMTP host") || e.toString().contains("java.net.ConnectException") || e.toString().contains("java.net.SocketTimeoutException") || e.toString().contains("java.net.SocketException") && connectionErrors<=58){
      
                if(connectionErrors==0){
                    createThreadTimer();
                    threadTimer.start();
                }
                
                connectionErrors++;
                setOutput("Erro de ligação. Poderá ser um erro esporádico. Passo ignorado"); 
                setOutput("Erro de ligação na última hora: "+connectionErrors);
                skip=true;
                Thread.sleep(5000);
                
            }else{
                
                time=0;
                connectionErrors=0;

                WriteToLog("Erro: verificar data encomendas");
                WriteToLog("Detalhes:");

                while ((responseText = site.response.readLine()) != null) {
                    WriteToLog(responseText);
                }
                WriteToLog(e.toString());
                throw new Exception("Something bad happened.");
            }
  
        }

        Date d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(gr.mdate);

        Estado_Encomenda estado_encomenda = new Estado_Encomenda(config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        ArrayList<Estado_Encomenda> estado_encomendas = estado_encomenda.list(d, config);

        if (estado_encomendas != null) {
            if (estado_encomendas.size() > 0) {
                try {
                    int listSize = estado_encomendas.size();
                    setOutput("A enviar " + listSize + " estado das encomendas:");

                    if (listSize > 20) {
                        setOutputReg(0, listSize);
                        int page = 20;
                        int pos = 0;
                        int errors = 0;
                        List<Estado_Encomenda> estado_encomendas2 = null;

                        while (pos < listSize) {
                            if ((pos + page) > listSize) {
                                page = listSize - pos;
                            }

                            estado_encomendas2 = estado_encomendas2.subList(pos, pos + page);

                            data = "data=" + URLEncoder.encode(serializer.serialize(estado_encomendas2), "UTF-8");

                            site.sendData(data);
                            pos = pos + page;

                            responseText = "";

                            try {
                                responseText = site.response.readLine();
                            } catch (NullPointerException e) {
                                throw new Exception("Something bad happened.");
                            }

                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);
                                if (!gr.success) {
                                    errors++;
                                }

                            } catch (Exception e) {
                                WriteToLog("Erro: sincronizar estado das encomendas!");
                                WriteToLog("Detalhes:");
                                while ((responseText = site.response.readLine()) != null) {
                                    WriteToLog(responseText);
                                }
                                WriteToLog("Excepção: " + e.toString());

                                for (Estado_Encomenda est_enc : estado_encomendas2) {
                                    WriteToLog(est_enc.obrano);
                                }
                                throw new Exception("Something bad happened.");
                            }

                            setOutputReg(pos, listSize);
                        }

                        setOutput("\n");

                        if (errors == 0) {
                            setOutput("Estado das encomendas actualizados com sucesso.");
                        } else {
                            setOutput("Ocorreram erros na actualização do estado das encomendas. Verificar log.");
                        }
                    } else {
                        data = "data=" + URLEncoder.encode(serializer.serialize(estado_encomendas), "UTF-8");

                        site.sendData(data);
                        responseText = site.response.readLine();

                        try {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);

                            if (gr.success) {
                                setOutput("Estado das encomendas actualizados com sucesso!");
                            } else {
                                setOutput("Ocorreu um erro ao sincronizar estado das encomendas! Verificar log.");
                            }

                        } catch (Exception e) {

                            for (Estado_Encomenda est_enc : estado_encomendas) {
                                WriteToLog(est_enc.obrano);
                            }

                            WriteToLog("Erro: sincronização simples do estado das encomendas");
                            WriteToLog("Detalhes:");
                            while ((responseText = site.response.readLine()) != null) {
                                WriteToLog(responseText);
                            }

                            WriteToLog("Excepção: " + e.toString());
                            throw new Exception("Something bad happened.");
                        }
                    }
                } catch (IOException e) {
                    WriteToLog("Erro: sincronização geral estado das encomendas");
                    WriteToLog("Detalhes");
                    WriteToLog(e.toString());
                    throw new Exception("Something bad happened.");
                }
            } else {
                setOutput("Os estados das encomendas já se encontram actualizados");
            }
        }
    }

    public void export_artigos() throws IOException, ClassNotFoundException, ParseException, Exception {
        site = new Site();
        config = new Config();

        String data;
        String responseText;
        GenericResponse gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl(config.getUrlArtigosMdate());
        data = "";
        site.sendData(data);
        responseText = site.response.readLine();
        site.setUrl(config.getUrlArtigos());

        try {
            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);
        } catch (Exception e) {
            WriteToLog("e.toString() Artigos : "+e.toString());
            if(e.toString().contains("Server returned HTTP response code: 500") || e.toString().contains("Server returned HTTP response code: 503") || e.toString().contains("Could not connect to SMTP host") || e.toString().contains("java.net.ConnectException") || e.toString().contains("java.net.SocketTimeoutException") || e.toString().contains("java.net.SocketException") && connectionErrors<=58){
                
                if(connectionErrors==0){

                    createThreadTimer();
                    threadTimer.start();
                }
                connectionErrors++;
                setOutput("Erro de ligação. Poderá ser um erro esporádico. Passo ignorado"); 
                setOutput("Erro de ligação na última hora: "+connectionErrors);
                skip=true;
                Thread.sleep(5000);
                
            }else{
                time=0;
                connectionErrors=0;
                WriteToLog("Erro: verificar data artigos");
                WriteToLog("Detalhes:");

                while ((responseText = site.response.readLine()) != null) {
                    WriteToLog(responseText);
                }
                WriteToLog(e.toString());
                throw new Exception("Something bad happened.");
            }
        }

        Date d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(gr.mdate);

        Artigo artigo = new Artigo(config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        ArrayList<Artigo> artigos = artigo.list(d);

        if (artigos != null) {
            if (artigos.size() > 0) {
                try {
                    int listSize = artigos.size();
                    setOutput("A enviar " + listSize + " artigos:");

                    if (listSize > 20) {
                        setOutputReg(0, listSize);
                        int page = 20;
                        int pos = 0;
                        int errors = 0;
                        List<Artigo> artigos2 = null;

                        while (pos < listSize) {
                            if ((pos + page) > listSize) {
                                page = listSize - pos;
                            }

                            artigos2 = artigos.subList(pos, pos + page);
                            data = "data=" + URLEncoder.encode(serializer.serialize(artigos2), "UTF-8");

                            site.sendData(data);
                            pos = pos + page;

                            responseText = site.response.readLine();

                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);
                                if (!gr.success) {
                                    errors++;
                                }

                            } catch (Exception e) {
                                
                                if(e.toString().contains("Server returned HTTP response code: 500") || e.toString().contains("Server returned HTTP response code: 503") || e.toString().contains("Could not connect to SMTP host") || e.toString().contains("java.net.ConnectException") || e.toString().contains("java.net.SocketTimeoutException") || e.toString().contains("java.net.SocketException") && connectionErrors<=58){
                
                                    if(connectionErrors==0){

                                        createThreadTimer();
                                        threadTimer.start();
                                    }

                                    connectionErrors++;
                                    setOutput("Erro de ligação. Poderá ser um erro esporádico. Passo ignorado"); 
                                    setOutput("Erro de ligação na última hora: "+connectionErrors);
                                    skip=true;
                                    Thread.sleep(5000);
                                    
                                }else{

                                    time=0;
                                    connectionErrors=0;
                                    WriteToLog("Erro: sincronizar artigos!");
                                    WriteToLog("Detalhes:");
                                    while ((responseText = site.response.readLine()) != null) {
                                        WriteToLog(responseText);
                                    }
                                    WriteToLog("Excepção: " + e.toString());

                                    for (Artigo art : artigos2) {
                                        WriteToLog(art.ref);
                                    }
                                    throw new Exception("Something bad happened.");
                                } 
                            }
                            setOutputReg(pos, listSize);
                        }

                        setOutput("\n");

                        if (errors == 0) {
                            setOutput("Artigos actualizados com sucesso.");
                            artigos = null;
                        } else {
                            setOutput("Ocorreram erros na actualização dos artigos. Verificar log.");
                            artigos = null;
                        }
                    } else {
                        data = "data=" + URLEncoder.encode(serializer.serialize(artigos), "UTF-8");

                        site.sendData(data);
                        responseText = site.response.readLine();

                        try {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);

                            if (gr.success) {
                                setOutput("Artigos actualizados com sucesso!");
                                artigos = null;
                            } else {
                                setOutput("Ocorreu um erro ao sincronizar artigos! Verificar log.");
                                artigos = null;
                            }

                        } catch (Exception e) {

                            if(e.toString().contains("Server returned HTTP response code: 500") || e.toString().contains("Server returned HTTP response code: 503") || e.toString().contains("Could not connect to SMTP host") || e.toString().contains("java.net.ConnectException") || e.toString().contains("java.net.SocketTimeoutException") || e.toString().contains("java.net.SocketException") && connectionErrors<=58){
                
                                if(connectionErrors==0){

                                    createThreadTimer();
                                    threadTimer.start();
                                }

                                connectionErrors++;
                                setOutput("Erro de ligação. Poderá ser um erro esporádico. Passo ignorado"); 
                                setOutput("Erro de ligação na última hora: "+connectionErrors);
                                skip=true;
                                Thread.sleep(5000);
                                
                            }else{

                                time=0;
                                connectionErrors=0;
                                for (Artigo event : artigos) {
                                    WriteToLog(event.u_descst);
                                }

                                WriteToLog("Erro: sincronização simples artigos");
                                WriteToLog("Detalhes:");
                                while ((responseText = site.response.readLine()) != null) {
                                    WriteToLog(responseText);
                                }

                                WriteToLog("Excepção: " + e.toString());
                                artigos = null;
                                throw new Exception("Something bad happened.");
                            }  
                        }
                    }
                } catch (IOException e) {
                    WriteToLog("Erro: sincronização geral artigos");
                    WriteToLog("Detalhes");
                    WriteToLog(e.toString());
                    artigos = null;
                    throw new Exception("Something bad happened.");
                }
            } else {
                setOutput("Os artigos já se encontram actualizados");
                artigos = null;
            }
        } else {
            setOutput("Ocorreu um erro ao obter os dados dos artigos. Verificar log.");
            artigos = null;
            throw new Exception("Something bad happened.");
        }
    }

    public void export_clientes() throws IOException, ClassNotFoundException, ParseException, NullPointerException, RuntimeException, Exception {
        site = new Site();
        config = new Config();

        String data;
        String responseText;
        GenericResponse gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");
        site.setUrl(config.getUrlClientesMdate());

        data = "";
        site.sendData(data);
        responseText = "";

        WriteToLog("Connection Error nº: "+connectionErrors);
        
        try {
            responseText = site.response.readLine();

        } catch (Exception e) {
            WriteToLog("e.toString() Encomendas : "+e.toString());
            /*if(e.toString().contains("java.lang.NullPointerException")){
            
                throw new Exception("Something bad happened.");
            
            }else*/ if(e.toString().contains("java.lang.NullPointerException") || e.toString().contains("Server returned HTTP response code: 500") || e.toString().contains("Server returned HTTP response code: 503") || e.toString().contains("Could not connect to SMTP host") || e.toString().contains("java.net.ConnectException") || e.toString().contains("java.net.SocketTimeoutException") || e.toString().contains("java.net.SocketException") && connectionErrors<=58){
            
                if(connectionErrors==0){
                    createThreadTimer();
                    threadTimer.start();
                }

                connectionErrors++;
                setOutput("Erro de ligação. Poderá ser um erro esporádico. Passo ignorado"); 
                setOutput("Erro de ligação na última hora: "+connectionErrors);
                skip=true;
                return;
            }
        }
        site.setUrl(config.getUrlClientes());

        try {
            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);
        } catch (Exception e) {
            
            if(e.toString().contains("Server returned HTTP response code: 500") || e.toString().contains("Server returned HTTP response code: 503") || e.toString().contains("Could not connect to SMTP host") || e.toString().contains("java.net.ConnectException") || e.toString().contains("java.net.SocketTimeoutException") || e.toString().contains("java.net.SocketException") && connectionErrors<=58){
                
                if(connectionErrors==0){

                    createThreadTimer();
                    threadTimer.start();
                }

                connectionErrors++;
                setOutput("Erro de ligação. Poderá ser um erro esporádico. Passo ignorado"); 
                setOutput("Erro de ligação na última hora: "+connectionErrors);
                skip=true;
                Thread.sleep(5000);
                
            }else{

                time=0;
                connectionErrors=0;
                
                WriteToLog("Erro: verificar data clientes");
                WriteToLog("Detalhes:");

                while ((responseText = site.response.readLine()) != null) {
                    WriteToLog(responseText);
                }
                WriteToLog(e.toString());
                throw new Exception("Something bad happened.");
              
            }
        }

        Date d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(gr.mdate);

        Cliente cliente = new Cliente(config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        ArrayList<Cliente> clientes = cliente.list(d);

        if (clientes != null) {
            if (clientes.size() > 0) {
                try {
                    int listSize = clientes.size();
                    setOutput("Clientes para actualizar: " + listSize);

                    if (listSize > 20) {
                        int page = 20;
                        int pos = 0;
                        int errors = 0;
                        List<Cliente> clientes2 = null;

                        while (pos < listSize) {
                            if ((pos + page) > listSize) {
                                page = listSize - pos;
                            }

                            clientes2 = clientes.subList(pos, pos + page);
                            data = "data=" + URLEncoder.encode(serializer.serialize(clientes2), "UTF-8");

                            site.sendData(data);
                            pos = pos + page;

                            responseText = "";

                            try {
                                responseText = site.response.readLine();
                            } catch (NullPointerException e) {
                                throw new Exception("Something bad happened.");
                            }

                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);
                                if (!gr.success) {
                                    errors++;
                                }
                            } catch (Exception e) {
                                WriteToLog("Erro: sincronizar clientes!");
                                WriteToLog("Detalhes:");
                                while ((responseText = site.response.readLine()) != null) {
                                    WriteToLog(responseText);
                                }
                                WriteToLog("Excepção: " + e.toString());
                                throw new Exception("Something bad happened.");
                            }
                        }

                        if (errors == 0) {
                            setOutput("Clientes actualizados com sucesso.");
                            clientes = null;
                        } else {
                            setOutput("Ocorreram erros na actualização dos clientes. Verificar log.");
                            clientes = null;
                        }
                    } else {
                        data = "data=" + URLEncoder.encode(serializer.serialize(clientes), "UTF-8");

                        site.sendData(data);
                        responseText = "";

                        try {
                            responseText = site.response.readLine();
                        } catch (NullPointerException e) {
                            throw new Exception("Something bad happened.");
                        }

                        try {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);

                            if (gr.success) {
                                setOutput("Clientes actualizados com sucesso!");
                                clientes = null;
                            } else {
                                setOutput("Ocorreu um erro ao sincronizar clientes! Verificar log.");
                                clientes = null;
                            }
                        } catch (Exception e) {
                            WriteToLog("Erro: sincronização simples clientes");
                            WriteToLog("Detalhes:");
                            while ((responseText = site.response.readLine()) != null) {
                                WriteToLog(responseText);
                            }

                            WriteToLog("Excepção: " + e.toString());
                            clientes = null;
                            throw new Exception("Something bad happened.");
                        }
                    }
                } catch (IOException e) {
                    WriteToLog("Erro: sincronização geral clientes");
                    WriteToLog("Detalhes");
                    WriteToLog(e.toString());
                    clientes = null;
                    throw new Exception("Something bad happened.");
                }
            } else {
                setOutput("Os clientes já se encontram actualizados");
                clientes = null;
            }
        } else {
            setOutput("Ocorreu um erro ao obter os dados dos clientes. Verificar log.");
            clientes = null;
            throw new Exception("Something bad happened.");
        }
    }

    public void export_familias() throws IOException, ClassNotFoundException, ParseException, Exception {
        site = new Site();
        config = new Config();

        String data;
        String responseText;
        GenericResponse gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl(config.getUrlFamiliasMdate());
        data = "";
        site.sendData(data);
        responseText = "";

        try {
            responseText = site.response.readLine();
        } catch (NullPointerException e) {
            
            if(e.toString().contains("Server returned HTTP response code: 500") || e.toString().contains("Server returned HTTP response code: 503") || e.toString().contains("Could not connect to SMTP host") || e.toString().contains("java.net.ConnectException") || e.toString().contains("java.net.SocketTimeoutException") || e.toString().contains("java.net.SocketException") && connectionErrors<=58){
                
                if(connectionErrors==0){

                    createThreadTimer();
                    threadTimer.start();
                }

                connectionErrors++;
                setOutput("Erro de ligação. Poderá ser um erro esporádico. Passo ignorado"); 
                setOutput("Erro de ligação na última hora: "+connectionErrors);
                skip=true;
                Thread.sleep(5000);
                
            }else{

                time=0;
                connectionErrors=0;
                
                WriteToLog("Erro: verificar data clientes");
                WriteToLog("Detalhes:");

                while ((responseText = site.response.readLine()) != null) {
                    WriteToLog(responseText);
                }
                WriteToLog(e.toString());
                throw new Exception("Something bad happened.");
              
            }
            
            
            //throw new Exception("Something bad happened.");
        }
        site.setUrl(config.getUrlFamilias());

        try {
            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);
        } catch (Exception e) {
            WriteToLog("Erro: verificar data familias");
            WriteToLog("Detalhes:");

            while ((responseText = site.response.readLine()) != null) {
                WriteToLog(responseText);
            }
            WriteToLog(e.toString());
            throw new Exception("Something bad happened.");
        }

        Date d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(gr.mdate);

        Familia familia = new Familia(config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        ArrayList<Familia> familias = familia.list(d);

        if (familias != null) {
            if (familias.size() > 0) {
                int errors = 0;
                //enviar familias
                try {
                    int listSize = familias.size();
                    setOutput("Familias para actualizar: " + listSize);

                    if (listSize > 20) {
                        int page = 20;
                        int pos = 0;
                        List<Familia> familias2 = null;

                        while (pos < listSize) {
                            if ((pos + page) > listSize) {
                                page = listSize - pos;
                            }

                            familias2 = familias.subList(pos, pos + page);
                            data = "data=" + URLEncoder.encode(serializer.serialize(familias2), "UTF-8");

                            site.sendData(data);
                            pos = pos + page;

                            responseText = "";

                            try {
                                responseText = site.response.readLine();
                            } catch (NullPointerException e) {
                                throw new Exception("Something bad happened.");
                            }

                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);
                                if (!gr.success) {
                                    errors++;
                                }

                            } catch (Exception e) {
                                WriteToLog("Erro: sincronizar familias!");
                                WriteToLog("Detalhes:");
                                while ((responseText = site.response.readLine()) != null) {
                                    WriteToLog(responseText);
                                }
                                WriteToLog("Excepção: " + e.toString());
                                throw new Exception("Something bad happened.");
                            }
                        }
                    } else {
                        data = "data=" + URLEncoder.encode(serializer.serialize(familias), "UTF-8");

                        site.sendData(data);
                        responseText = "";

                        try {
                            responseText = site.response.readLine();
                        } catch (NullPointerException e) {
                            throw new Exception("Something bad happened.");
                        }

                        try {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);

                            if (gr.success) {
                                setOutput("Familias actualizadas com sucesso!");
                            } else {
                                setOutput("Ocorreu um erro ao sincronizar familias! Verificar log.");
                                familias = null;
                            }

                        } catch (Exception e) {

                            WriteToLog("Erro: sincronização simples familias");
                            WriteToLog("Detalhes:");
                            while ((responseText = site.response.readLine()) != null) {
                                WriteToLog(responseText);
                            }

                            WriteToLog("Excepção: " + e.toString());
                            familias = null;
                            throw new Exception("Something bad happened.");
                        }
                    }
                } catch (Exception e) {
                    WriteToLog("Erro: sincronização geral familias");
                    WriteToLog("Detalhes");
                    WriteToLog(e.toString());
                    throw new Exception("Something bad happened.");
                }

                site.setUrl(config.getUrlFamiliasRel());
                //enviar relacoes
                try {
                    int listSize = familias.size();

                    if (listSize > 20) {
                        int page = 20;
                        int pos = 0;
                        List<Familia> familias2 = null;

                        while (pos < listSize) {
                            if ((pos + page) > listSize) {
                                page = listSize - pos;
                            }

                            familias2 = familias.subList(pos, pos + page);
                            data = "data=" + URLEncoder.encode(serializer.serialize(familias2), "UTF-8");

                            site.sendData(data);
                            pos = pos + page;

                            responseText = "";

                            try {
                                responseText = site.response.readLine();
                            } catch (NullPointerException e) {
                                throw new Exception("Something bad happened.");
                            }

                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);
                                if (!gr.success) {
                                    errors++;
                                }
                            } catch (Exception e) {
                                WriteToLog("Erro: sincronizar familias!");
                                WriteToLog("Detalhes:");
                                while ((responseText = site.response.readLine()) != null) {
                                    WriteToLog(responseText);
                                }
                                WriteToLog("Excepção: " + e.toString());
                                throw new Exception("Something bad happened.");
                            }
                        }

                        if (errors == 0) {
                            setOutput("Familias actualizadas com sucesso.");
                            familias = null;
                        } else {
                            setOutput("Ocorreram erros na actualização das familias. Verificar log.");
                            familias = null;
                        }

                    } else {
                        data = "data=" + URLEncoder.encode(serializer.serialize(familias), "UTF-8");

                        site.sendData(data);
                        responseText = "";

                        try {
                            responseText = site.response.readLine();
                        } catch (NullPointerException e) {
                            throw new Exception("Something bad happened.");
                        }

                        try {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize(responseText);

                            if (gr.success) {
                                setOutput("Familias actualizadas com sucesso!");
                                familias = null;
                            } else {
                                setOutput("Ocorreu um erro ao sincronizar familias! Verificar log.");
                                familias = null;
                            }

                        } catch (Exception e) {
                            WriteToLog("Erro: sincronização simples familias");
                            WriteToLog("Detalhes:");
                            while ((responseText = site.response.readLine()) != null) {
                                WriteToLog(responseText);
                            }

                            WriteToLog("Excepção: " + e.toString());
                            familias = null;
                            throw new Exception("Something bad happened.");
                        }
                    }
                } catch (Exception e) {
                    WriteToLog("Erro: sincronização geral familias");
                    WriteToLog("Detalhes");
                    WriteToLog(e.toString());
                    familias = null;
                    throw new Exception("Something bad happened.");
                }
            } else {
                setOutput("As familias já se encontram actualizados");
                familias = null;
            }
        } else {
            setOutput("Ocorreu um erro ao obter os dados das familias. Verificar log.");
            familias = null;
            throw new Exception("Something bad happened.");
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

    public void import_encomendas() throws IOException, ClassNotFoundException, Exception {
        site = new Site();
        config = new Config();
        Encomenda encomenda = new Encomenda();
        String data = null;
        String responseText = null;
        ArrayList<Encomenda> encs = null;
        site.setUrl(config.getUrlEncomendas());

        try {
            data = "data=" + encomenda.GetLastModification(config);
            site.sendData(data);

            responseText = "";

            try {
                responseText = site.response.readLine();
            } catch (NullPointerException e) {
                throw new Exception("Something bad happened.");
            }
            responseText = unescapeUnicode(responseText);

            try {
                encs = new JSONDeserializer<ArrayList<Encomenda>>().use(null, ArrayList.class).use("values", Encomenda.class).deserialize(responseText);
            } catch (Exception e) {
                setOutput("Não existem encomendas para importar!");
                WriteToLog("Erro ao ler resposta do servidor.");
                WriteToLog("O servidor respondeu: ");
                WriteToLog(responseText);
                while ((responseText = site.response.readLine()) != null) {
                    WriteToLog(responseText);
                }
                WriteToLog("Excepção: " + e.toString());
                throw new Exception("Something bad happened.");
            }

            int errors = 0;
            for (Encomenda enc : encs) {
                if (!enc.save(config)) {
                    errors++;
                }
            }

            if (errors > 0) {
                setOutput("Ocorreram erros ao importar encomendas! " + "Por favor verifique no PHC.");
            } else {
                setOutput("Encomendas importados com sucesso!");
            }
        } catch (Exception e) {
            setOutput("Erro desconhecido.");
            WriteToLog(e.toString());
            throw new Exception("Something bad happened.");
        }

    }
}
