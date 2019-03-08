/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;

import flexjson.JSONDeserializer;
import flexjson.JSONSerializer;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.UnsupportedEncodingException;
import java.math.BigInteger;
import java.net.URLEncoder;
import java.security.SecureRandom;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import javax.swing.JOptionPane;
import org.apache.commons.net.ftp.FTPClient;

/**
 *
 * @author Tiago Loureiro
 */
public class PHC {
    
    private Site site = null;
    private Config conf = null;
    
    public PHC() throws FileNotFoundException, IOException {
        
        site = new Site();
        conf = new Config();
        
    }
    
    public void execute_command( String message ) throws IOException {
        
        String[] tokens = message.split("_");
        
        System.out.println(message);
        
        if ( tokens[0].equals("exptbliva") ) {
            export_tab_iva(tokens[1]);
        }
        else if ( tokens[0].equals("expdoctipos") ) {
            export_doc_tipos(tokens[1]);
        }
        else if ( tokens[0].equals("expclientes") ) {
            export_clientes(tokens[1]);
        }
        else if ( tokens[0].equals("expdocfac") ) {
            export_doc_fac(tokens[1]);
        }
        else if ( tokens[0].equals("expartigos") ) {
            export_artigos(tokens[1]);
        }
        
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
    
    public void setOutput(String message) {
        String old_message = sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getText();
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setText(old_message + message + "\n");
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setCaretPosition(sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getDocument().getLength());
    }
    
    public void set_bar_output(int now, int max) {
        String old_message = sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getText();
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setText( old_message.substring(0,old_message.lastIndexOf('\n')) );
        old_message = sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getText();
        
        old_message = old_message + "\n[";
        for (int i=0; i < 20; i++) {
            if ( i < now ) {
                old_message = old_message + "|";
            }
            else if ( i == max ) {
                old_message = old_message + "|";
            }
            else {
                old_message = old_message + "_";
            }
        }
        old_message = old_message + "]";
        
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setText(old_message);
        
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setCaretPosition(sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getDocument().getLength());
    }
    
    public int envia_ftp(ArrayList<String> filename) {
        FTPClient client = new FTPClient();
        FileInputStream fis = null;
        File file = null;

        for (String t : filename) {
            try {
            
            client.connect("127.0.0.1");
            client.login("defeito", "quase");

            fis = new FileInputStream(t);

            client.storeFile(t, fis);
            client.logout();
            
            } catch (IOException e) {
            
            e.printStackTrace();
            return 0;
            
            } finally {
                try {
                    if (fis != null) {
                        fis.close();
                    }

                    file = new File( t );
                    file.delete();
                    client.disconnect();

                 } catch (IOException e) {
                        e.printStackTrace();
                        return 0;
                 }
            }
        }
        return 1;
    }
    
    public void export_tab_iva( String id ) throws FileNotFoundException, IOException  {
        
        String data; 
        String responseText; 
        GenericResponse gr = null;
        
        site.setUrl( "http://localhost/system_general/export_tab_iva" );
        TabIva tabiva = new TabIva( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB(), conf.getDbInstance() );
        
        ArrayList<String> tabivas = new ArrayList<String>();
        tabivas = tabiva.list(id);
        
        envia_ftp( tabivas );
        
        for (String t : tabivas) {
            try {
                data = "data=" + t + "&token="+ gen_token(3) +"&id=" + id;
                site.sendData(data);

                responseText = site.response.readLine();
                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                    deserialize(responseText);

                if ( gr.success ) {
                    setOutput("Tabelas iva enviadas com sucesso!");
                }
                else {
                    setOutput("Erro ao ler resposta do servidor!");
                }  
            }
            catch ( Exception e ) {
                setOutput("Erro ao enviar tabelas iva!");
            }
        }
    }
    
    public void export_doc_tipos( String id ) throws FileNotFoundException, IOException  {
        
        String data; 
        String responseText; 
        GenericResponse gr = null;
        
        site.setUrl( "http://localhost/system_general/export_doc_tipos" );
        DocTipos doctipo = new DocTipos( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB(), conf.getDbInstance() );
        
        ArrayList<String> doctipos = new ArrayList<String>();
        doctipos = doctipo.list(id);
        
        envia_ftp( doctipos );
        
        for (String t : doctipos) {
        
            try {
                data = "data=" + t + "&token="+ gen_token(3) +"&id=" + id;
                site.sendData(data);

                responseText = site.response.readLine();
                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                    deserialize(responseText);

                if ( gr.success ) {
                    setOutput("Doc Tipos enviados com sucesso!");
                }
                else {
                    setOutput("Erro ao ler resposta do servidor!");
                }  
            }
            catch ( Exception e ) {
                setOutput("Erro ao enviar doc tipos!");
            }
        
        }

    }
    
    
    public void export_clientes( String id ) throws FileNotFoundException, IOException  {
        
        String data; 
        String responseText; 
        GenericResponse gr = null;
        
        site.setUrl( "http://localhost/system_general/export_clientes" );
        Clientes cliente = new Clientes( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB(), conf.getDbInstance() );
        
        ArrayList<String> clientes = new ArrayList<String>();
        clientes = cliente.list(id);
        
        envia_ftp( clientes );
        
        for (String t : clientes) {
        
            try {
                data = "data=" + t + "&token="+ gen_token(3) +"&id=" + id;
                site.sendData(data);

                responseText = site.response.readLine();
                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                    deserialize(responseText);

                if ( gr.success ) {
                    setOutput("Clientes enviados com sucesso!");
                }
                else {
                    setOutput("Erro ao ler resposta do servidor!");
                }  
            }
            catch ( Exception e ) {
                setOutput("Erro ao enviar clientes!");
            }
        
        }
        
        
        
    }
    
    public void export_doc_fac( String id ) throws UnsupportedEncodingException, IOException  {
        
        String data; 
        String responseText; 
        GenericResponse gr = null;
        
        site.setUrl( "http://localhost/system_general/export_doc_fac" );
        DocFac docfac = new DocFac( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB(), conf.getDbInstance() );
        
        //ft
        
        ArrayList<String> docfacs = new ArrayList<String>();
        docfacs = docfac.list_ft(id);
        
        envia_ftp( docfacs );
        
        for (String t : docfacs) {
        
            try {
                data = "data=" + t + "&token="+ gen_token(3) +"&id=" + id;

                site.sendData(data);

            }
            catch ( Exception e ) {
                //
            }
        
        }
        
        //fi
        setOutput("Docs Fac enviadas com sucesso!");
        
        docfacs = docfac.list_fi(id);
        
        envia_ftp( docfacs );

        for (String t : docfacs) {
        
            try {
                data = "datai=" + t + "&token="+ gen_token(3) +"&id=" + id;
                site.sendData(data);
            }
        catch ( Exception e ) {
            //
        }
        
        }
        
        setOutput("Docs Fac Linhas enviadas com sucesso!");
        
    }
 
    public void export_artigos( String id ) throws UnsupportedEncodingException, IOException  {
        
        String data; 
        String responseText; 
        GenericResponse gr = null;
        
        site.setUrl( "http://localhost/system_general/export_artigos" );
        Artigo artigo = new Artigo( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB(), conf.getDbInstance() );
        
        ArrayList<String> artigos = new ArrayList<String>();
        artigos = artigo.list(id);
        
        envia_ftp( artigos );
        
        
        for (String t : artigos) {
        
            try {
                data = "data=" + t + "&token="+ gen_token(3) +"&id=" + id;

                site.sendData(data);

            }
            catch ( Exception e ) {
                //
            }
        
        }
        
        
        setOutput("Artigos enviados com sucesso!");
        
    }
    
}
