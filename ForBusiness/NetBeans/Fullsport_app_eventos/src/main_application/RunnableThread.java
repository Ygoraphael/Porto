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
import Fullsport_app_eventos.Fullsport_app_eventosView;
import java.net.URLEncoder;
import java.util.List;
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
        String old_message = Fullsport_app_eventos.Fullsport_app_eventosView.jTextArea1.getText();
        Fullsport_app_eventos.Fullsport_app_eventosView.jTextArea1.setText(old_message + message + "\n");
        Fullsport_app_eventos.Fullsport_app_eventosView.jTextArea1.setCaretPosition(Fullsport_app_eventos.Fullsport_app_eventosView.jTextArea1.getDocument().getLength());
    }
    
    public void update_process() throws IOException, ClassNotFoundException {
        config = new Config();
        int time_interval = Integer.parseInt(config.getSyncInterval());
        
        try 
        {
            setOutput("A Actualizar Clientes");
            update_clientes();
            setOutput("A Exportar Eventos");
            update_eventos();
            setOutput("A Importar Eventos");
            import_eventos();
            
            Thread.sleep( time_interval*1000 );
        } 
        catch (InterruptedException ex) 
        {
            Logger.getLogger(RunnableThread.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public void update_clientes() throws IOException, ClassNotFoundException
    {
        site = new Site();
        config = new Config();

        String data; 
        String responseText; 
        GenericResponse gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");
        site.setUrl(config.getUrl());
        
        data = "task=checklastupdateclient";
        site.sendData( data );
        responseText = site.response.readLine();
        
        try 
        {
            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize( responseText ); 
        } 
        catch ( Exception e ) 
        {
            System.out.println( "Erro ao verificar mofificações dos clientes!!!");
            System.out.println( "O Servidor respondeu: " );
            while( (responseText = site.response.readLine()) != null ) 
            {
                System.out.println( responseText );
            }
            System.out.println( e.toString() );
            return; 
        }
        
        Date d = new Date( Long.parseLong(gr.mdate) * 1000 );
        
        Cliente cliente = new Cliente( config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        ArrayList<Cliente> clientes = cliente.list( d );
        
        if ( clientes != null ) 
        {
            if (clientes.size() > 0 ) 
            {
                try 
                {
                    int listSize = clientes.size();
                    System.out.println( "Clientes para actualizar:" +  listSize);

                    if (listSize > 20) {
                        
                        int page = 20;
                        int pos = 0;
                        int errors = 0;
                        List<Cliente> clientes2 = null; 

                        while (pos < listSize) 
                        {
                            if ((pos+page)> listSize) 
                            {
                                page = listSize - pos;
                            }
                            
                            clientes2 = clientes.subList(pos, pos+page);
                            System.out.println( "Meanwhile " +  pos);
                            data = "data=" + 
                            URLEncoder.encode(serializer.serialize( clientes2 ), "UTF-8") + 
                            "&task=updateclientes";
                                    
                            site.sendData(data);
                            pos = pos + page;
                             
                            responseText = site.response.readLine();
                            
                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).deserialize(responseText);
                                
                                if ( !gr.success )
                                {
                                    errors++;
                                }
                                
                            } catch ( Exception e ) {
                                
                                setOutput( "Ocorreu um erro ao sincronizar clientes!" );
                                System.out.println("Erro ao ler resposta na sincronização dos clientes!");
                                System.out.println("O servidor respondeu: ");
                                while ((responseText=site.response.readLine()) != null )
                                {
                                    System.out.println(responseText);
                                }
                                
                                System.out.println( "Excepção: " + e.toString() );
                            }
                        }
                        
                        if ( errors == 0 ) 
                        {
                            setOutput( "Clientes actualizados com sucesso." );
                        } 
                        else 
                        {
                            setOutput( "Ocorreram erros na actualização dos clientes." );
                        }
                        
                    } 
                    else 
                    {
                        data = "data=" + URLEncoder.encode(serializer.serialize( clientes ), "UTF-8") + 
                            "&task=updateclientes";

                        site.sendData(data);
                        responseText = site.response.readLine();
                        
                        try 
                        {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                deserialize(responseText);
                            
                            if ( gr.success ) 
                            {
                                setOutput( "Clientes actualizados com sucesso!" );
                            } 
                            else 
                            {
                                setOutput( "Ocorreu um erro ao sincronizar clientes!" );
                            }
                        
                        } catch ( Exception e ) {
                            
                            setOutput( "Erro ao ler resposta do servidor!" );
                            System.out.println( "Erro ao ler resposta do servidor à sincronização simples de clientes!");
                            
                            System.out.println( "O servidor respondeu: ");
                            while( (responseText = site.response.readLine()) != null ) 
                            {
                                System.out.println( responseText);
                            }
                            
                            System.out.println( "Excepção: " + e.toString() );   
                            return;
                        }   
                    }
                } 
                catch (IOException e )
                {
                    System.out.println( e.toString() );
                    return;
                }
            } 
            else 
            {
                setOutput( "Os clientes já se encontram actualizados" );
            }
        } else {
            setOutput( "Ocorreu um erro ao obter os dados dos clientes." );
        }
    }
    
    public void update_eventos() throws IOException, ClassNotFoundException
    {
        site = new Site();
        config = new Config();

        String data; 
        String responseText; 
        GenericResponse gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");
        site.setUrl(config.getUrl());
        
        data = "task=checklastupdateevent";
        site.sendData( data );
        responseText = site.response.readLine();
        
        try 
        {
            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize( responseText ); 
        } 
        catch ( Exception e ) 
        {
            System.out.println( "Erro ao verificar mofificações dos eventos!!!");
            System.out.println( "O Servidor respondeu: " );
            while( (responseText = site.response.readLine()) != null ) 
            {
                System.out.println( responseText );
            }
            System.out.println( e.toString() );
            return; 
        }
        
        Date d = new Date( Long.parseLong(gr.mdate) * 1000 );
        
        Evento evento = new Evento( config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        ArrayList<Evento> eventos = evento.list( d );

        if ( eventos != null ) 
        {
            if (eventos.size() > 0 ) 
            {
                try 
                {
                    int listSize = eventos.size();
                    System.out.println( "Evento para actualizar:" +  listSize);

                    if (listSize > 20) {
                        
                        int page = 20;
                        int pos = 0;
                        int errors = 0;
                        List<Evento> eventos2 = null; 

                        while (pos < listSize) 
                        {
                            if ((pos+page)> listSize) 
                            {
                                page = listSize - pos;
                            }
                            
                            eventos2 = eventos.subList(pos, pos+page);
                            System.out.println( "Meanwhile " +  pos);
                            data = "data=" + 
                            URLEncoder.encode(serializer.serialize( eventos2 ), "UTF-8") + 
                            "&task=updateeventos";
                                    
                            site.sendData(data);
                            pos = pos + page;
                             
                            responseText = site.response.readLine();
                            
                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).deserialize(responseText);
                                
                                if ( !gr.success )
                                {
                                    errors++;
                                }
                                
                            } catch ( Exception e ) {
                                
                                setOutput( "Ocorreu um erro ao sincronizar eventos!" );
                                System.out.println("Erro ao ler resposta na sincronização dos eventos!");
                                System.out.println("O servidor respondeu: ");
                                while ((responseText=site.response.readLine()) != null )
                                {
                                    System.out.println(responseText);
                                }
                                
                                System.out.println( "Excepção: " + e.toString() );
                            }
                        }
                        
                        if ( errors == 0 ) 
                        {
                            setOutput( "Eventos actualizados com sucesso." );
                        } 
                        else 
                        {
                            setOutput( "Ocorreram erros na actualização dos eventos." );
                        }
                        
                    } 
                    else 
                    {
                        data = "data=" + URLEncoder.encode(serializer.serialize( eventos ), "UTF-8") + 
                            "&task=updateeventos";

                        site.sendData(data);
                        responseText = site.response.readLine();
                        
                        try 
                        {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                deserialize(responseText);
                            
                            if ( gr.success ) 
                            {
                                setOutput( "Eventos actualizados com sucesso!" );
                            } 
                            else 
                            {
                                setOutput( "Ocorreu um erro ao sincronizar eventos!" );
                            }
                        
                        } catch ( Exception e ) {
                            
                            setOutput( "Erro ao ler resposta do servidor!" );
                            System.out.println( "Erro ao ler resposta do servidor à sincronização simples de eventos!");
                            
                            System.out.println( "O servidor respondeu: ");
                            while( (responseText = site.response.readLine()) != null ) 
                            {
                                System.out.println( responseText);
                            }
                            
                            System.out.println( "Excepção: " + e.toString() );   
                            return;
                        }   
                    }
                } 
                catch (IOException e )
                {
                    System.out.println( e.toString() );
                    return;
                }
            } 
            else 
            {
                setOutput( "Os eventos já se encontram actualizados" );
            }
        } else {
            setOutput( "Ocorreu um erro ao obter os dados dos eventos." );
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
    
    public void import_eventos() throws IOException, ClassNotFoundException
    {
        site = new Site();
        config = new Config();
        Evento evento = new Evento();
        String data = null;
        String responseText = null;
        ArrayList<Evento> oj = null;
        site.setUrl( config.getUrl() );
            
        try {
            
            data = "task=geteventos&data=" + evento.GetLastModification();
            
            site.sendData(data);
            responseText = site.response.readLine();
            responseText = unescapeUnicode(responseText);
            
            System.out.println( responseText );
            
           try {

            oj = new JSONDeserializer<ArrayList<Evento>>().use(null, ArrayList.class).
                    use( "values", Evento.class).
                    deserialize( responseText);
                    

           } catch( Exception e ) {
                
                setOutput("Não existem eventos para importar!");
                System.out.println( "Erro ao ler resposta do servidor.");
                
                
                System.out.println( "O servidor respondeu: ");
                System.out.println( responseText );
                while( (responseText = site.response.readLine()) != null ) {
                    System.out.println( responseText);
                }

                System.out.println( "Excepção: " + e.toString() );

                return;
           }

           int errors = 0;

           for( Evento event : oj) 
           {
               if ( !event.save( config ) ) 
               {
                   errors++;
               }
           }
            
           if ( errors > 0 ) 
           {
               setOutput("Ocorreram erros ao importar eventos! " + "Por favor verifique no PHC.");    
           } 
           else
           {
               setOutput("Eventos importados com sucesso!");
           }
             
        } catch (Exception e) {
            setOutput("Erro desconhecido.");
            System.out.println( e.toString() );
            return;
        }
        
    }
}
