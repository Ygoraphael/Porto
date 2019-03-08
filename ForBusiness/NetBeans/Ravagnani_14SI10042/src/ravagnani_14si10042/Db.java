/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package ravagnani_14si10042;

import java.sql.Connection;
import java.sql.DriverManager;
import java.util.Properties;

/**
 *
 * @author Tiago Loureiro
 */
public class Db {
    protected Connection con;
    protected String lastSQL; //armazenar a última query (for debugging)

    public Db( String db ) {

        this.connect(db);
    }
    
    public Db( Connection con ) {
        
        this.con = con;
    }
    
    public Db() {
        
         Config conf = new Config();
         connect( conf.getDb());
       
    }
    
    public void connect( String db ) {
        
        try {
            Properties p = new Properties();
            p.put("charSet", "iso-8859-1");
            Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
            String connectionUrl = "jdbc:odbc:Driver={Microsoft Access Driver (*.mdb)};DBQ=" + db + ";";            
            con = DriverManager.getConnection(connectionUrl, p);
            
            //System.out.println("Connected to database!");

        } catch (Exception e) {
            System.out.println("Erro de ligação à base de dados " + e.toString() );
            
        }     
                
    }
}
