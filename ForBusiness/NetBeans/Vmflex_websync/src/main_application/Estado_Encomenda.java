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

public class Estado_Encomenda extends Db {
    
    public String obrano;
    public String estado;
    public String datamodificacao;
    
    public Estado_Encomenda() 
    {
        super();
    }
   
   public Estado_Encomenda(String hostname, String instanceName, String port, String username, String password, String db) 
   {
        super( hostname, instanceName, port, username, password, db );
   }
    
   public Estado_Encomenda(Connection con)
   {
        this.con = con;
   }
   
   public ArrayList<Estado_Encomenda>list(Date data, Config conf) throws ParseException 
   {
        DateFormat full = new SimpleDateFormat("yyyy-MM-dd");
        
        this.lastSQL = 
                  "SELECT "
                +   "obrano, "
                +   "REPLACE(U_ESTADENC, char(34), '') estado, "
                +   "CONVERT(varchar, usrdata, 121) datamodificacao "
                +   "FROM bo "
                +   "WHERE usrdata >='" + full.format( data ) + "' AND ndos = " + conf.getNDoc();

        ArrayList<Estado_Encomenda> estado_encomendas = new ArrayList<Estado_Encomenda>();
        Estado_Encomenda estado_encomenda = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        System.out.println( "QUERY: " + this.lastSQL );
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) 
            {
                estado_encomenda = new Estado_Encomenda( this.con );
                estado_encomenda.obrano = rs.getString("obrano");      
                estado_encomenda.estado = rs.getString("estado");
                
                if( estado_encomenda.estado.equals("Em Processamento") )
                        estado_encomenda.estado = "COM_VIRTUEMART_ORDER_STATUS_EM_PROCESSAMENTO";
                else if ( estado_encomenda.estado.equals("Confirmado") )
                        estado_encomenda.estado = "COM_VIRTUEMART_ORDER_STATUS_CONFIRMADO";
                else if ( estado_encomenda.estado.equals("A Aguardar Pagamento") )
                        estado_encomenda.estado = "COM_VIRTUEMART_ORDER_STATUS_A_AGUARDAR_PAGAMENTO";
                else if ( estado_encomenda.estado.equals("Expedido") )
                        estado_encomenda.estado = "COM_VIRTUEMART_ORDER_STATUS_EXPEDIDO";
                else if ( estado_encomenda.estado.equals("Entregue") )
                        estado_encomenda.estado = "COM_VIRTUEMART_ORDER_STATUS_ENTREGUE";
                else if ( estado_encomenda.estado.equals("Cancelado") )
                        estado_encomenda.estado = "COM_VIRTUEMART_ORDER_STATUS_CANCELADO";
                
                estado_encomenda.datamodificacao = rs.getString("datamodificacao");
                
                estado_encomendas.add(estado_encomenda);
            }
            
            return estado_encomendas;
            
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
