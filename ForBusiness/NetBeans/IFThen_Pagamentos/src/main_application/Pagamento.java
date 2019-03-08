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

public class Pagamento extends Db {
    
    public String Entidade;
    public String Referencia;
    public double Valor;
    public String Id;
    public String DtHrPagamento;
    public String Processamento;
    public String Terminal;
    public String Tarifa;
    public double ValorLiquido;
    public String CodigoErro;
    public String MensagemErro;
    
    public Pagamento() 
    {
        super();
    }
   
    public Pagamento(String hostname, String instanceName, String port, String username, String password, String db) 
    {
        super( hostname, instanceName, port, username, password, db );
    }
    
    public Pagamento(Connection con){
        this.con = con;
    }
   
    public boolean update(Config conf, String from, String host, String user, String password, String subject ) throws SQLException, ParseException 
    {
        Bo bo = new Bo( conf.getDbHost(), conf.getDbInstance(), conf.getDbPort(), conf.getDbUser(), conf.getDbPass(), conf.getDb() );
        
        bo.ndos = Integer.parseInt(conf.getNDoc());
        bo.Referencia = this.Referencia;
        
        DateFormat format = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
        Date date = format.parse(this.DtHrPagamento);
        
        bo.DtHrPagamento = date;
        
        return bo.update( from, host, user, password, subject );
    }

    public String GetLastModification( Config conf ) 
    {     
        this.lastSQL = "select isnull(MAX(obrano), 0) nummax from bo where ndos = " + conf.getNDoc();
        ResultSet rs = null;
        Statement stmt = null;
        
        try 
        {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery( this.lastSQL );
            
            while (rs.next()) 
            {
                return rs.getString("nummax");
            }
        }
        catch (SQLException e) 
        {
            this.log(e);
            return null;
        }
        
        return "";
    }
   
   private void log(SQLException e) 
   {     
        System.out.println(this.lastSQL);
        System.out.println(e.toString());    
   }
    
}
