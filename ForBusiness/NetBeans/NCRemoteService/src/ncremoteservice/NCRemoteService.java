/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package ncremoteservice;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.reflect.TypeToken;
import java.io.IOException;
import java.net.InetSocketAddress;
import java.net.URLEncoder;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.java_websocket.WebSocket;
import org.java_websocket.handshake.ClientHandshake;
import org.java_websocket.server.WebSocketServer;

/**
 *
 * @author Tiago Loureiro
 */
public class NCRemoteService extends WebSocketServer {

    private final DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
    private Config config = null;
 
    public NCRemoteService(int port) {
        super(new InetSocketAddress(port));
        //System.out.println("Websocket server running... Listening on port " + port);
    }

    @Override
    public void onOpen(WebSocket ws, ClientHandshake ch) {
        //Date date = new Date();
        //System.out.println("");
        //System.out.println(dateFormat.format(date) + " : " + ws.getRemoteSocketAddress() + " connected!");
        config = new Config();
    }

    @Override
    public void onClose(WebSocket ws, int i, String string, boolean bln) {
        //Date date = new Date();
        //System.out.println(dateFormat.format(date) + " : " + ws.getRemoteSocketAddress() + " disconnected!");
    }

    public void selectFunction( WebSocket ws, String string ) {
        Gson gson = new GsonBuilder().create();
                
        StrQuery sql_query = new StrQuery( config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        ArrayList<String[]> dados_query;
        dados_query = new ArrayList<String[]>();
        
        System.out.println("query: " + string);
        
        try {
            dados_query = sql_query.list( string );
        } 
        catch (ParseException ex) {
            Logger.getLogger(NCRemoteService.class.getName()).log(Level.SEVERE, null, ex);
            dados_query = new ArrayList<String[]>();
        }

        String data = "";
        String dadosjson = "";
        
        if( dados_query.size() == 0 ) {
            dadosjson = "[]";
        }
        else {
            dadosjson = gson.toJson(dados_query);
        }
        
        try {
            System.out.println( dadosjson );
            data = URLEncoder.encode(dadosjson, "UTF-8");
            ws.send( data );
        } 
        catch (UnsupportedEncodingException ex) {
            Logger.getLogger(NCRemoteService.class.getName()).log(Level.SEVERE, null, ex);
            data = "";
            ws.send( data );
        }
    }
        
    public void insertFunction( WebSocket ws, String string ) {
        Gson gson = new GsonBuilder().create();
                
        StrQuery sql_query = new StrQuery( config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
        int resultado = 0;
        
        try {
            resultado = sql_query.runQuery ( string );
        } 
        catch (ParseException ex) {
            Logger.getLogger(NCRemoteService.class.getName()).log(Level.SEVERE, null, ex);
            resultado = 0;
        }

        String data = "";
        String dadosjson = "";
        try {
            dadosjson = gson.toJson(resultado);
            System.out.println( "Resultado: " + dadosjson );
            data = URLEncoder.encode(dadosjson, "UTF-8");
            ws.send( data );
        } 
        catch (UnsupportedEncodingException ex) {
            Logger.getLogger(NCRemoteService.class.getName()).log(Level.SEVERE, null, ex);
            data = "";
            ws.send( data );
        }
    }
    
    @Override
    public void onMessage(WebSocket ws, String string) {
        try {
            String url = URLDecoder.decode(string, "UTF-8");
            ArrayList pedido = new Gson().fromJson(url, ArrayList.class);
            StrQuery sql_query = new StrQuery( config.getDbHost(), config.getDbInstance(), config.getDbPort(), config.getDbUser(), config.getDbPass(), config.getDb());
            
            ArrayList<String[]> dados_query;
//            try {
//                System.out.println( pedido.get(2).toString().trim() );
//                dados_query = sql_query.list( "select * from dytable where entityname = 'NC_REM' and campo = '" + pedido.get(2).toString().trim() + "'" );
//            } 
//            catch (ParseException ex) {
//                Logger.getLogger(NCRemoteService.class.getName()).log(Level.SEVERE, null, ex);
//                dados_query = new ArrayList<String[]>();
//            }
            
//            if( dados_query.size() > 0 ) {
                switch( pedido.get(0).toString().trim() ) {
                    case "select":
                        selectFunction(ws, pedido.get(1).toString().trim());
                        break;
                    case "insert":
                        insertFunction(ws, pedido.get(1).toString().trim());
                        break;
                }
//            }
        }
        catch (Exception ex) {
            Logger.getLogger(NCRemoteService.class.getName()).log(Level.SEVERE, null, ex);
            System.out.println(ex);
        }
    }

    @Override
    public void onError(WebSocket ws, Exception excptn) {
        //Date date = new Date();
        //System.out.println(dateFormat.format(date) + " : " + ws.getRemoteSocketAddress() + " Error!");
    }
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws IOException {
        int port = 4444;
        new NCRemoteService(port).start();
    }
}
