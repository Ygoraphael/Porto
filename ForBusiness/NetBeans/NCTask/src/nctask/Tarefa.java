/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package nctask;
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
public class Tarefa extends PHCDB {
    
    public String campo;
    public String dytablestamp;
    
    public Tarefa ( String hostname, String port, String username, String password, String db) {
        super( hostname, port, username, password, db );
    }
    
    public Tarefa( Connection con ) {
        super( con );
    }
    
    public void get(String id) {
        
        this.lastSQL = "SELECT DISTINCT dytablestamp, campo FROM dytable (nolock) WHERE ENTITYNAME = 'A_MHTIPO' AND dytablestamp = '"+id+"'";
        
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                
                this.dytablestamp = rs.getString("dytablestamp");
                this.campo = rs.getString("campo");
                
            }
            
        } catch (SQLException e) {
            System.out.println( e );
        }
    }
    
    public ArrayList<Tarefa> list() {
        
        this.lastSQL = "SELECT DISTINCT dytablestamp, campo FROM dytable WHERE ENTITYNAME = 'A_MHTIPO'";
        
        ArrayList<Tarefa> tarefas = new ArrayList<Tarefa>();
        Tarefa tarefa = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                
                tarefa = new Tarefa( this.con );
                tarefa.dytablestamp = rs.getString("dytablestamp");
                tarefa.campo = rs.getString("campo");
                
                tarefas.add(tarefa);
                
            }
            
            System.out.println( "#Tarefas a actualizar: " + tarefas.size() );
            return tarefas;
            
        } catch (SQLException e) {
            System.out.println( e );
            return null;
        }
    }
    
}
