package main_application;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

/**
 *
 * @author Tiago Loureiro
 */

public class Cliente extends Db {
    
    public String no;
    public String name;
    public String ncont;
    public String address;
    public String zip;
    public String city;
    public String phone;
    public String shoppergroup;
    public String fax;
    public String email;
    public String username;
    public String password;
    public String cdate;
    public String mdate;
    public String locked;
    public String country;
    
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
   
   public ArrayList<Cliente>list(Date data) throws ParseException 
   {
        DateFormat full = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        
        this.lastSQL = 
                  "SELECT "
                +   "no, "
                +   "REPLACE(nome, char(34), '') name, "
                +   "REPLACE(u_user, char(34), '') username, "
                +   "REPLACE(email, char(254), '') email, "
                +   "REPLACE(fax, char(34), '') fax, "
                +   "REPLACE(u_pass, char(34), '') password, "
                +   "CONVERT(varchar, ousrdata, 121) cdate, "
                +   "CONVERT(VARCHAR(19),usrdata + ' ' + usrhora,20) mdate, "
                +   "REPLACE(ncont, char(34), '') ncont, "
                +   "REPLACE(telefone, char(34), '') phone, "
                +   "REPLACE(morada, char(34), '') address, "
                +   "REPLACE(local, char(34), '') city, "
                +   "REPLACE(codpost, char(34), '') zip, "
                +   "REPLACE(pncont, char(34), '') country, "
                +   "preco as shoppergroup, "
                +   "u_pubsite as locked "
                +   "FROM cl "
                +   "WHERE CONVERT(VARCHAR(19),usrdata + ' ' + usrhora,20) >= CONVERT(VARCHAR(19),'" + full.format( data ) + "',20) "
                +   "ORDER BY cl.no";

        ArrayList<Cliente> clientes = new ArrayList<Cliente>();
        Cliente cliente = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        System.out.println( "QUERY: " + this.lastSQL );
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) 
            {
                cliente = new Cliente( this.con );
                cliente.no = rs.getString("no");      
                cliente.name = rs.getString("name");
                cliente.ncont = rs.getString("ncont");
                cliente.address = rs.getString("address");
                cliente.city = rs.getString("city");
                cliente.zip = rs.getString("zip");
                cliente.phone = rs.getString("phone");
                cliente.email = rs.getString("email");
                cliente.fax = rs.getString("fax");
                cliente.username = rs.getString("username");
                cliente.password = rs.getString("password");
                cliente.cdate = rs.getString("cdate");
                cliente.mdate = rs.getString("mdate");
                cliente.shoppergroup = rs.getString("shoppergroup");
                cliente.locked = rs.getString("locked");
                cliente.country = rs.getString("country");
                
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
   
   private void log(SQLException e) 
   {     
        System.out.println(this.lastSQL);
        System.out.println(e.toString());
   }
    
}
