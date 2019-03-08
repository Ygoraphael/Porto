/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package nctask;
import java.sql.Connection;
import java.sql.DriverManager;

/**
 *
 * @author Tiago Loureiro
 */
public class PHCDB {
    
    protected Connection con;
    protected String lastSQL;
    
        public PHCDB( String hostname, String port, String username, String password, 
            String db) {

        try {
            Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
            
            String connectionUrl = "jdbc:sqlserver://" + 
                     hostname + ":" + port + ";" +
                    "instanceName=SQLNC1;"+
                    "user=" + 
                    username + ";password=" + 
                    password + ";database=" +
                    db +";";

            con = DriverManager.getConnection(connectionUrl);
            System.out.println("Connected to database!");

        } catch (Exception e) {
            System.out.println("Erro de ligação à base de dados " + e.toString() );
        }
    }
    
    public PHCDB( Connection con ) {
        this.con = con;
    }
}
