package nctask;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.sql.Statement;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.DateFormat;
import java.text.DecimalFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
/**
 *
 * @author Tiago Loureiro
 */
public class Movimento extends PHCDB {
    
    public Integer id;
    public Integer utilizador;
    public Integer cliente;
    public String tarefa;
    public String data_i;
    public String data_f;
    public String hora_i;
    public String hora_f;
    public String relatorio;
    public String nome;
    public String tecnnm;
    public String cat;
    public Integer contador;
    public String facturar;
    public String projecto;
    public String data_pedido;
    public String hora_pedido;
    public String quem_pediu;
    
    public Movimento ( String hostname, String port, String username, String password, String db) {
        super( hostname, port, username, password, db );
    }
    
    public Movimento( Connection con ) {
        super( con );
    }
    
    private String genStamp() throws SQLException {

    this.lastSQL = "select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5) stamp";

    Statement stmt = this.con.createStatement();

    ResultSet rs = stmt.executeQuery( this.lastSQL );

    rs.next();

    return rs.getString("stamp");

    }
    
    public void get( String d ) throws UnsupportedEncodingException {
        
        this.lastSQL = "SELECT A.no, A.nome, A.tecnnm, A.u_movid, A.no, A.tecnico, B.dytablestamp, A.data, A.hora, A.horaf, replace(cast(A.relatorio as varchar(max)), CHAR(13) + CHAR(10) ,'\\n') relatorio, A.moh, A.ousrdata, A.usrdata, A.u_cat, A.facturar, A.fref, A.datapat, A.horapat, A.pquem " +
                       "FROM mh A (nolock) INNER JOIN dytable B (nolock) ON A.mhtipo = B.campo " +
                       "WHERE u_movid = " + d + " AND B.ENTITYNAME = 'A_MHTIPO'";      
		
        ResultSet rs = null;
        Statement stmt = null;
        Double hora_decimal = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {                
                this.id = rs.getInt("u_movid");
                this.utilizador = rs.getInt("tecnico");
                this.cliente = rs.getInt("no");
                this.tarefa = rs.getString("dytablestamp"); 
                this.data_i = rs.getString("data"); 
                this.data_f = rs.getString("data"); 
                this.hora_i = rs.getString("hora"); 
                this.hora_f = rs.getString("horaf"); 
                
                String newString = new String(rs.getString("relatorio").getBytes("UTF-8"), "UTF-8");
                String encodedValue= URLEncoder.encode(newString, "UTF-8");
                this.relatorio = encodedValue;
                
                this.nome = rs.getString("nome"); 
                this.tecnnm = rs.getString("tecnnm"); 
                this.cat = rs.getString("u_cat"); 
                this.facturar = rs.getString("facturar");  
                
                hora_decimal = rs.getDouble("moh");
                
                int tmp_horas = hora_decimal.intValue();
                Double t1 = (hora_decimal - tmp_horas) * 60;
                int tmp_minutos = t1.intValue();
                Double tmp_seconds = (t1 - tmp_minutos) * 60;
                tmp_horas = tmp_horas * 3600;
                tmp_minutos = tmp_minutos * 60;
        
                this.contador = tmp_seconds.intValue() + tmp_horas + tmp_minutos;
                
                this.projecto = rs.getString("fref"); 
                this.data_pedido = rs.getString("datapat"); 
                this.hora_pedido = rs.getString("horapat");
                if(this.hora_pedido.equals(""))
                    this.hora_pedido = "00:00";
                this.quem_pediu = rs.getString("pquem"); 
            }
            
        } catch (SQLException e) {
            System.out.println( e );
        }
    }
}
