/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package ncremoteservice;

import java.sql.Connection;
import java.sql.DriverManager;
import ncremoteservice.Config;

/**
 *
 * @author Tiago Loureiro
 */
public class Db {
    protected Connection con;
    protected String lastSQL; 

    public Db( String hostname, String instanceName, String port, String username, String password, String db) {
        this.connect( hostname, instanceName, port, username, password, db);
    }
    
    public Db( Connection con ) {
        this.con = con;
    }
    
    public Db() {
         Config conf = new Config();
         connect( conf.getDbHost(), conf.getDbInstance(), conf.getDbPort(), conf.getDbUser(), conf.getDbPass(), conf.getDb());
    }
    
    public void connect( String hostname, String instanceName, String port, String username, String password, String db ) {
        try {
            Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");            
            String connectionUrl = "";
            
            if( port == "0" ) {
                connectionUrl = 
                    "jdbc:sqlserver://" + 
                     hostname + 
                    ";instanceName="+instanceName+
                    ";user=" + username + ";" +
                    "password=" + password + ";" +
                    "database=" + db +";";
            }
            else {
                connectionUrl = 
                    "jdbc:sqlserver://" + 
                     hostname + //":" + port + ";" +
                    ";instanceName="+instanceName+
                    ";user=" + username + ";" +
                    "password=" + password + ";" +
                    "database=" + db +";";
            }

            con = DriverManager.getConnection(connectionUrl);
            System.out.println("Conectado a base dados!");

        } 
        catch (Exception e) {
            System.out.println("Erro de ligação à base de dados " + e.toString() );
        }
    }
}
