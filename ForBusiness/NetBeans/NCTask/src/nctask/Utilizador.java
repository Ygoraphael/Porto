/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package nctask;
import java.io.UnsupportedEncodingException;
import java.sql.Statement;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
/**
 *
 * @author Tiago Loureiro
 */
public class Utilizador extends PHCDB {
    
    
    public String username;
    public Integer userno;
    
    public Utilizador ( String hostname, String port, String username, String password, String db) {
        super( hostname, port, username, password, db );
    }
    
    public Utilizador( Connection con ) {
        super( con );
    }
    
    public void get( String d ) throws UnsupportedEncodingException {
        
        this.lastSQL = "SELECT DISTINCT cm, cmdesc " +
                       "FROM CM4 (nolock) " +
                       "WHERE cm = '" + d + "'";
        
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                this.username = rs.getString("cmdesc");
                this.userno = rs.getInt("cm");                
            }
            
        } catch (SQLException e) {
            System.out.println( e );
        }
    }
    
    public ArrayList<Utilizador> list( int d ) {
        
        this.lastSQL = "SELECT DISTINCT cm, cmdesc " +
                       "FROM CM4 " +
                       "WHERE cm > '" + d + "'";
        
        ArrayList<Utilizador> utilizadores = new ArrayList<Utilizador>();
        Utilizador utilizador = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                
                utilizador = new Utilizador( this.con );
                utilizador.username = rs.getString("cmdesc");
                utilizador.userno = rs.getInt("cm");
                
                utilizadores.add(utilizador);
                
            }
            
            System.out.println( "#Utilizadores a actualizar: " + utilizadores.size() );
            return utilizadores;
            
        } catch (SQLException e) {
            System.out.println( e );
            return null;
        }
    }
}
