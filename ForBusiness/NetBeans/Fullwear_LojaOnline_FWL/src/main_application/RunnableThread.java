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
import onlinestore_sync.Onlinestore_syncView;
import java.net.URLEncoder;
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
        String old_message = onlinestore_sync.Onlinestore_syncView.jTextArea1.getText();
        onlinestore_sync.Onlinestore_syncView.jTextArea1.setText(old_message + message + "\n");
        onlinestore_sync.Onlinestore_syncView.jTextArea1.setCaretPosition(onlinestore_sync.Onlinestore_syncView.jTextArea1.getDocument().getLength());
    }
    
    public static void setOutputReg(int cur, int tot) 
    {
        if(tot >0)
        {
            String old_message = onlinestore_sync.Onlinestore_syncView.jTextArea1.getText();
            old_message = old_message.substring(0, old_message.lastIndexOf("\n"));

            int max = 30;
            int val = (cur*max) / tot;
            int rest = max - val;

            char[] myChar = new char[val];
            Arrays.fill(myChar, '|');
            char[] myChar2 = new char[rest];
            Arrays.fill(myChar2, '_');

            String message = "[" + (new String(myChar)) + (new String(myChar2)) + "]";
            onlinestore_sync.Onlinestore_syncView.jTextArea1.setText(old_message + "\n" + message );
            onlinestore_sync.Onlinestore_syncView.jTextArea1.setCaretPosition(onlinestore_sync.Onlinestore_syncView.jTextArea1.getDocument().getLength());
        }
    }
    
    public void update_process() throws IOException, ClassNotFoundException, ParseException 
    {
        config = new Config();
        int time_interval = Integer.parseInt(config.getSyncInterval());
        
        try 
        {
            if( config.getSyncElemEncomendas().equals("1") ) {
                setOutput("A Importar Encomendas-----");
                import_encomendas();
            }
            if( config.getSyncElemFamilias().equals("1") ) {
                setOutput("A Exportar Familias-----");
                export_familias();
            }
            if( config.getSyncElemArtigos().equals("1") ) {
                setOutput("A Exportar Artigos-----");
                export_artigos();
            }
            if( config.getSyncElemEstadoEncomendas().equals("1") ) {
                setOutput("A Atualizar Estado das Encomendas-----");
                export_encomendas();
            }
            setOutput("A Aguardar " + time_interval + " segundos-----");
            Thread.sleep( time_interval*1000 );
        } 
        catch (InterruptedException ex) 
        {
            Logger.getLogger(RunnableThread.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public void export_encomendas() throws IOException, ClassNotFoundException, ParseException
    {
        site = new Site();
        config = new Config();

        String data;
        String responseText; 
        GenericResponse gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");
        
        site.setUrl(config.getUrlEncomendasMdate());
        data = "";
        site.sendData( data );
        responseText = site.response.readLine();
        site.setUrl( config.getUrlEstadoEncomendas() );
        
        try 
        {
            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).deserialize( responseText ); 
        } 
        catch ( Exception e ) 
        {
            WriteToLog("Erro: verificar data encomendas");
            WriteToLog("Detalhes:");
            
            while( (responseText = site.response.readLine()) != null ) 
            {
                WriteToLog( responseText );
            }
            WriteToLog( e.toString() );
            return; 
        }
        
        Date d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse( gr.mdate );
        
        Estado_Encomenda estado_encomenda = new Estado_Encomenda( config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        ArrayList<Estado_Encomenda> estado_encomendas = estado_encomenda.list( d, config );
        
        if ( estado_encomendas != null ) 
        {
            if (estado_encomendas.size() > 0 ) 
            {
                try 
                {
                    int listSize = estado_encomendas.size();
                    setOutput( "A enviar " + listSize + " estado das encomendas:");
                    
                    if (listSize > 20) 
                    {    
                        setOutputReg(0, listSize);
                        int page = 20;
                        int pos = 0;
                        int errors = 0;
                        List<Estado_Encomenda> estado_encomendas2 = null; 

                        while (pos < listSize) 
                        {
                            if ((pos+page)> listSize) 
                            {
                                page = listSize - pos;
                            }
                            
                            estado_encomendas2 = estado_encomendas.subList(pos, pos+page);
                            
                            data = "data=" + 
                            URLEncoder.encode(serializer.serialize( estado_encomendas2 ), "UTF-8");
                                    
                            site.sendData(data);
                            pos = pos + page;
                             
                            responseText = site.response.readLine();
                            
                            try 
                            {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).deserialize(responseText);
                                if ( !gr.success )
                                {
                                    errors++;
                                }
                                
                            } 
                            catch ( Exception e ) 
                            {
                                WriteToLog( "Erro: sincronizar estado das encomendas!" );
                                WriteToLog("Detalhes:");
                                while ((responseText=site.response.readLine()) != null )
                                {
                                    WriteToLog(responseText);
                                }
                                WriteToLog( "Excepção: " + e.toString() );
                                
                                for( Estado_Encomenda est_enc : estado_encomendas2) 
                                {
                                    WriteToLog( est_enc.obrano );
                                }
                            }
                            
                            setOutputReg(pos, listSize);
                        }
                        
                        setOutput("\n");
                        
                        if ( errors == 0 ) 
                        {
                            setOutput( "Estado das encomendas actualizados com sucesso." );
                        } 
                        else 
                        {
                            setOutput( "Ocorreram erros na actualização do estado das encomendas. Verificar log." );
                        }
                    } 
                    else 
                    {
                        data = "data=" + URLEncoder.encode(serializer.serialize( estado_encomendas ), "UTF-8");

                        site.sendData(data);
                        responseText = site.response.readLine();
                        
                        try 
                        {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                deserialize(responseText);
                            
                            if ( gr.success ) 
                            {
                                setOutput( "Estado das encomendas actualizados com sucesso!" );
                            } 
                            else 
                            {
                                setOutput( "Ocorreu um erro ao sincronizar estado das encomendas! Verificar log." );
                            }
                        
                        } 
                        catch ( Exception e ) 
                        {
                        
                            for( Estado_Encomenda est_enc : estado_encomendas) 
                            {
                                WriteToLog(est_enc.obrano);
                            }
                            
                            WriteToLog( "Erro: sincronização simples do estado das encomendas" );
                            WriteToLog("Detalhes:");
                            while( (responseText = site.response.readLine()) != null ) 
                            {
                                WriteToLog( responseText);
                            }
                            
                            WriteToLog( "Excepção: " + e.toString() );   
                            return;
                        }   
                    }
                } 
                catch (IOException e )
                {
                    WriteToLog("Erro: sincronização geral estado das encomendas");
                    WriteToLog("Detalhes");
                    WriteToLog( e.toString() );
                    return;
                }
            } 
            else 
            {
                setOutput( "Os estados das encomendas já se encontram actualizados" );
            }
        }
    }
    
    public void export_artigos() throws IOException, ClassNotFoundException, ParseException
    {
        site = new Site();
        config = new Config();

        String data;
        String responseText; 
        GenericResponse gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");
        
        site.setUrl(config.getUrlArtigos_ini());
        
        data = "";
        site.sendData( data );
        responseText = site.response.readLine();
        
        site.setUrl( config.getUrlArtigos() );
        
        Artigo artigo = new Artigo( config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        ArrayList<Artigo> artigos = artigo.list( );
        
        if ( artigos != null ) 
        {
            if (artigos.size() > 0 ) 
            {
                try 
                {
                    int listSize = artigos.size();
                    setOutput( "A enviar " + listSize + " artigos:");
                    
                    if (listSize > 20) 
                    {    
                        setOutputReg(0, listSize);
                        int page = 20;
                        int pos = 0;
                        int errors = 0;
                        List<Artigo> artigos2 = null; 

                        while (pos < listSize) 
                        {
                            if ((pos+page)> listSize) 
                            {
                                page = listSize - pos;
                            }
                            
                            artigos2 = artigos.subList(pos, pos+page);
                            
                            //criar barra de progresso
                            //System.out.println( "Meanwhile " +  pos);
                            
                            data = "data=" + 
                            URLEncoder.encode(serializer.serialize( artigos2 ), "UTF-8");
                                    
                            site.sendData(data);
                            pos = pos + page;
                             
                            responseText = site.response.readLine();
                            
                            try 
                            {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).deserialize(responseText);
                                if ( !gr.success )
                                {
                                    errors++;
                                }
                                
                            } 
                            catch ( Exception e ) 
                            {
                                WriteToLog( "Erro: sincronizar artigos!" );
                                WriteToLog("Detalhes:");
                                while ((responseText=site.response.readLine()) != null )
                                {
                                    WriteToLog(responseText);
                                }
                                WriteToLog( "Excepção: " + e.toString() );
                                
                                for( Artigo art : artigos2) 
                                {
                                    WriteToLog( art.ref );
                                }
                            }
                            
                            setOutputReg(pos, listSize);
                        }
                        
                        setOutput("\n");
                        
                        if ( errors == 0 ) 
                        {
                            setOutput( "Artigos actualizados com sucesso." );
                            artigos = null;
                        } 
                        else 
                        {
                            setOutput( "Ocorreram erros na actualização dos artigos. Verificar log." );
                            artigos = null;
                        }
                    } 
                    else 
                    {
                        data = "data=" + URLEncoder.encode(serializer.serialize( artigos ), "UTF-8");

                        site.sendData(data);
                        responseText = site.response.readLine();
                        
                        try 
                        {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                deserialize(responseText);
                            
                            if ( gr.success ) 
                            {
                                setOutput( "Artigos actualizados com sucesso!" );
                                artigos = null;
                            } 
                            else 
                            {
                                setOutput( "Ocorreu um erro ao sincronizar artigos! Verificar log." );
                                artigos = null;
                            }
                        
                        } 
                        catch ( Exception e ) 
                        {
                        
                            for( Artigo event : artigos) 
                            {
                                WriteToLog(event.ref);
                            }
                            
                            WriteToLog( "Erro: sincronização simples artigos" );
                            WriteToLog("Detalhes:");
                            while( (responseText = site.response.readLine()) != null ) 
                            {
                                WriteToLog( responseText);
                            }
                            
                            WriteToLog( "Excepção: " + e.toString() );   
                            artigos = null;
                            return;
                        }   
                    }
                } 
                catch (IOException e )
                {
                    WriteToLog("Erro: sincronização geral artigos");
                    WriteToLog("Detalhes");
                    WriteToLog( e.toString() );
                    artigos = null;
                    return;
                }
            } 
            else 
            {
                setOutput( "Os artigos já se encontram actualizados" );
                artigos = null;
            }
        } 
        else 
        {
            setOutput( "Ocorreu um erro ao obter os dados dos artigos. Verificar log." );
            artigos = null;
        }
        
        site.setUrl(config.getUrlArtigos_end());
        data = "";
        site.sendData( data );
        responseText = site.response.readLine();
    }
    
    public void export_familias() throws IOException, ClassNotFoundException, ParseException
    {
        site = new Site();
        config = new Config();

        String data;
        String responseText; 
        GenericResponse gr = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");
        
        site.setUrl(config.getUrlFamilias_ini());
        data = "";
        site.sendData( data );
        System.out.println(site.toString());
        responseText = site.response.readLine();
        
        site.setUrl( config.getUrlFamilias() );
        
        Familia familia = new Familia( config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        ArrayList<Familia> familias = familia.list( );
        
        if ( familias != null ) 
        {
            if (familias.size() > 0 ) 
            {
                try 
                {
                    int listSize = familias.size();
                    setOutput( "Familias para actualizar: " +  listSize);

                    if (listSize > 20) 
                    {    
                        int page = 20;
                        int pos = 0;
                        int errors = 0;
                        List<Familia> familias2 = null; 

                        while (pos < listSize) 
                        {
                            if ((pos+page)> listSize) 
                            {
                                page = listSize - pos;
                            }
                            
                            familias2 = familias.subList(pos, pos+page);
                            
                            //criar barra de progresso
                            //System.out.println( "Meanwhile " +  pos);
                            
                            data = "data=" + 
                            URLEncoder.encode(serializer.serialize( familias2 ), "UTF-8");
                                    
                            site.sendData(data);
                            pos = pos + page;
                             
                            responseText = site.response.readLine();
                            
                            try 
                            {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).deserialize(responseText);
                                if ( !gr.success )
                                {
                                    errors++;
                                }
                                
                            } 
                            catch ( Exception e ) 
                            {
                                WriteToLog( "Erro: sincronizar familias!" );
                                WriteToLog("Detalhes:");
                                while ((responseText=site.response.readLine()) != null )
                                {
                                    WriteToLog(responseText);
                                }
                                WriteToLog( "Excepção: " + e.toString() );
                            }
                        }
                        
                        if ( errors == 0 ) {
                            setOutput( "Familias actualizadas com sucesso." );
                            familias = null;
                        } 
                        else {
                            setOutput( "Ocorreram erros na actualização das familias. Verificar log." );
                            familias = null;
                        }
                        
                    } 
                    else 
                    {
                        data = "data=" + URLEncoder.encode(serializer.serialize( familias ), "UTF-8");

                        site.sendData(data);
                        responseText = site.response.readLine();
                        
                        try 
                        {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                deserialize(responseText);
                            
                            if ( gr.success ) 
                            {
                                setOutput( "Familias actualizadas com sucesso!" );
                                familias = null;
                            } 
                            else 
                            {
                                setOutput( "Ocorreu um erro ao sincronizar familias! Verificar log." );
                                familias = null;
                            }
                        
                        } 
                        catch ( Exception e ) {
                            
                            WriteToLog( "Erro: sincronização simples familias" );
                            WriteToLog("Detalhes:");
                            while( (responseText = site.response.readLine()) != null ) 
                            {
                                WriteToLog( responseText);
                            }
                            
                            WriteToLog( "Excepção: " + e.toString() );  
                            familias = null;
                            return;
                        }   
                    }
                } 
                catch (IOException e )
                {
                    WriteToLog("Erro: sincronização geral familias");
                    WriteToLog("Detalhes");
                    WriteToLog( e.toString() );
                    familias = null;
                    return;
                }
            } 
            else 
            {
                setOutput( "As familias já se encontram actualizados" );
                familias = null;
            }
        } 
        else 
        {
            setOutput( "Ocorreu um erro ao obter os dados das familias. Verificar log." );
            familias = null;
        }
        
        site.setUrl(config.getUrlFamilias_end());
        data = "";
        site.sendData( data );
        responseText = site.response.readLine();
    }
    
    public static String unescapeUnicode(String string) {
        Matcher matcher = Pattern.compile("\\\\u((?i)[0-9a-f]{4})").matcher(string);
        while (matcher.find()) {
            int codepoint = Integer.valueOf(matcher.group(1), 16);
            string = string.replaceAll("\\" + matcher.group(0), String.valueOf((char) codepoint));
        }
        return string;
    }
    
    public void import_encomendas() throws IOException, ClassNotFoundException
    {
        site = new Site();
        config = new Config();
        Encomenda encomenda = new Encomenda();
        String data = null;
        String responseText = null;
        ArrayList<Encomenda> encs = null;
        site.setUrl( config.getUrlEncomendas() );
        String LastObrano = encomenda.GetLastModification(config);

        try {
            data = "data=" + LastObrano;
            site.sendData(data);
            
            responseText = site.response.readLine();
            responseText = unescapeUnicode(responseText);

            try 
            {
            encs = new JSONDeserializer<ArrayList<Encomenda>>().use(null, ArrayList.class).
                    use( "values", Encomenda.class).
                    deserialize( responseText);
            } 
            catch( Exception e ) 
            {     
                setOutput("Não existem encomendas para importar!");
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
           for( Encomenda enc : encs) 
           {
               if ( !enc.save( config ) ) 
               {
                   errors++;
               }
           }
            
           if ( errors > 0 ) 
           {
               setOutput("Ocorreram erros ao importar encomendas! " + "Por favor verifique no PHC.");    
           } 
           else
           {
               LastObrano = encomenda.GetLastModification(config);
               site.setUrl( config.getUrlEncomendas_end() );
               data = "data=" + LastObrano;
               site.sendData(data);

               responseText = site.response.readLine();
               responseText = unescapeUnicode(responseText);

               setOutput("Encomendas importados com sucesso!");
           }     
        } 
        catch (Exception e) 
        {
            setOutput("Erro desconhecido.");
            WriteToLog( e.toString() );
            return;
        }
    }
}
