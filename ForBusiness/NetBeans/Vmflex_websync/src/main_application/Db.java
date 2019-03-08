package main_application;

/**
 *
 * @author Tiago Loureiro
 */
import java.io.UnsupportedEncodingException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.util.Base64;
import main_application.Config;

public class Db {
    
    protected Connection con;
    protected String lastSQL; 

    public Db( String hostname, String instanceName, String port, String username, String password, 
            String db) {
        this.connect( hostname, instanceName, port, username, password, db);
    }
    
    public Db( Connection con ) {
        this.con = con;
    }
    
    public Db() {
         Config conf = new Config();
         connect( conf.getDbHost(), conf.getDbInstance(), conf.getDbPort(), conf.getDbUser(), conf.getDbPass(), 
                 conf.getDb());
    }
    
    public String toBase64(String value) throws UnsupportedEncodingException {
        return new String(Base64.getEncoder().encode(value.replace("\\", "").replace("\"", "").replace("\'", "").trim().getBytes()), "UTF-8");
    }
    
    public void connect( String hostname, String instanceName, String port, String username, String password, 
            String db ) {
        try {
            
            Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
            
            String connectionUrl = 
                    "jdbc:sqlserver://" + 
                     hostname + //":" + port + ";" +
                    ";instanceName="+instanceName+
                    ";user=" + username + ";" +
                    "password=" + password + ";" +
                    "database=" + db +";";
                 
            con = DriverManager.getConnection(connectionUrl);
            //System.out.println("Connected to database!");

        } catch (Exception e) {
            System.out.println("Erro de ligação à base de dados " + e.toString() );
        }     
    }
}