package main_application;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

/**
 *
 * @author Tiago Loureiro
 */

public class Cliente extends Db {
    
    public String no;
    public String nome;
    public String nif;
    public String morada;
    public String codpostal;
    public String local;
    public String telefone;
    public String telemovel;
    public String email;
    
    public Cliente() 
    {
        super();
    }
   
   public Cliente(String hostname, String instanceName, String port, String username, String password, String db) 
   {
        super( hostname, instanceName, port, username, password, db );
   }
    
   public Cliente(Connection con){
        this.con = con;
    }
   
   public ArrayList<Cliente>list(Date data) 
   {
        DateFormat full = new SimpleDateFormat("YYYY-MM-dd");
        
        this.lastSQL = 
                  "SELECT "
                +   "no, "
                +   "REPLACE(nome, char(34), '') nome, "
                +   "ncont, "
                +   "REPLACE(morada, char(34), '') morada, "
                +   "REPLACE(local, char(34), '') local, "
                +   "REPLACE(codpost, char(34), '') codpost, "
                +   "telefone, "
                +   "tlmvl, "
                +   "email "
                +   "FROM cl "
                +   "WHERE usrdata >='" + full.format( data ) + "' "
                +   "ORDER BY cl.no";

        ArrayList<Cliente> clientes = new ArrayList<Cliente>();
        Cliente cliente = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) 
            {
                cliente = new Cliente( this.con );
                cliente.no = rs.getString("no");      
                cliente.nome = rs.getString("nome");
                cliente.nif = rs.getString("ncont");
                cliente.morada = rs.getString("morada");
                cliente.local = rs.getString("local");
                cliente.codpostal = rs.getString("codpost");
                cliente.telefone = rs.getString("telefone");
                cliente.telemovel = rs.getString("tlmvl");
                cliente.email = rs.getString("email");
                
                clientes.add(cliente);
            }
            
            return clientes;
            
        } 
        catch (SQLException e) 
        {
            this.log(e);
            return null;
        }
    }
   
   private void log(SQLException e) {
        
        System.out.println(this.lastSQL);
        System.out.println(e.toString());
        
    }
    
}
