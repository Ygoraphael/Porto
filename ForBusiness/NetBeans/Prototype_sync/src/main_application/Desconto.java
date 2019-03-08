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
import java.util.TimeZone;

/**
 *
 * @author Tiago Loureiro
 */

public class Desconto extends Db {
    
    public String desconto;     // desconto em percentagem
    public String cliente;      // num cliente
    public String artigo;       // ref artigo
    
    public Desconto() 
    {
        super();
    }
   
   public Desconto(String hostname, String instanceName, String port, String username, String password, String db) 
   {
        super( hostname, instanceName, port, username, password, db );
   }
    
   public Desconto(Connection con)
   {
        this.con = con;
   }
   
   public ArrayList<Desconto>list() 
   {
        this.lastSQL = "select "
                    + "A.desc1 desconto, "
                    + "A.tipodesc cliente, "
                    + "B.ref artigo "
                    + "from "
                    + "dfcl A INNER JOIN st B on A.ref = B.tipodesc "
                    + "where "
                    + "A.tipodesc in "
                    + "(select CONVERT(VARCHAR(15), no) from cl WHERE u_pubsite = 1) AND "
                    + "B.u_pubsite = 1";
 
        ArrayList<Desconto> descontos = new ArrayList<Desconto>();
        Desconto desconto = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        System.out.println( "QUERY: " + this.lastSQL );
        
        try {
            stmt = this.con.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,ResultSet.CONCUR_READ_ONLY);
            rs = stmt.executeQuery(this.lastSQL);
            
            rs.last();
            int total_lines = rs.getRow();
            rs.beforeFirst();
            
            RunnableThread.setOutput("A Importar dados da base dados:");
            RunnableThread.setOutputReg(0, total_lines);
            
            while (rs.next()) 
            {
                desconto = new Desconto( this.con );
                
                desconto.desconto = rs.getString("desconto").trim();
                desconto.cliente = rs.getString("cliente").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                desconto.artigo = rs.getString("artigo").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                
                descontos.add(desconto);
                RunnableThread.setOutputReg(rs.getRow(), total_lines);
            }
            
            RunnableThread.setOutput("\n");
            return descontos;
            
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
