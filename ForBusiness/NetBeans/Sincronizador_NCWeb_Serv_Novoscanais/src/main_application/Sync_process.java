/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;

import flexjson.JSONDeserializer;
import flexjson.JSONSerializer;
import java.io.IOException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Timer;
import java.util.TimerTask;
import javax.swing.JOptionPane;

/**
 *
 * @author Tiago Loureiro
 */
public class Sync_process {
    
    private Site site = null;
    
    public Sync_process() throws IOException, InterruptedException {
    
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
        setOutput("Nº Empresas: " + num_empresas);
        setOutput("Tempo Sincronização: 1 hora");
        setOutput("Intervalo Empresa a Empresa: " + time_interval + " segundos");
        
        int i = 1;
        
        for( final GenericResponse key : gr) {
            setOutput("A Actualizar Empresa: " + key.name + " ID: " + key.enterprise_id + " - " + i + " de " + num_empresas);
            System.out.println(key.enterprise_id + " " + time_interval);
            Thread.sleep(2*1000);
        }
    }
    
    public void setOutput(String message) {
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setText(sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getText() + message + "\n");
        sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.setCaretPosition(sincronizador_ncweb.Sincronizador_NCWebView.jTextArea1.getDocument().getLength());
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
