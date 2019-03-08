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
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

/**
 *
 * @author Tiago Loureiro
 */
public class Projecto extends PHCDB {
    
    public String referencia;
    public String descricao;
    public Integer no;
    public String data_inicio;
    public String horas_previstas;
    public String data_fim;
    public Integer fechado;
    public Integer horas_real;
    
    public Projecto ( String hostname, String port, String username, String password, String db) {
        super( hostname, port, username, password, db );
    }
    
    public Projecto( Connection con ) {
        super( con );
    }
    
    public void get( String d ) throws UnsupportedEncodingException {
        
        this.lastSQL = "SELECT DISTINCT fref, nmfref, u_no, u_dataini, u_nhoraso, u_datafim, u_fechado, u_nhorasr " +
                       "FROM fref (nolock) " +
                       "WHERE fref = " + "'" + d + "'";
        
        ResultSet rs = null;
        Statement stmt = null;
        DateFormat format = new SimpleDateFormat("yyyy-MM-dd 00:00:00.0");
        Long date1 = null;
        Long date2 = null;
        Double hora_decimal = 0.0;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                this.referencia = rs.getString("fref"); 
                this.descricao = new String(rs.getString("nmfref").getBytes("UTF-8"), "UTF-8");
                this.no = rs.getInt("u_no");
                try
                {
                    date1 = (format.parse(rs.getString("u_dataini")).getTime() / 1000);
                    date2 = (format.parse(rs.getString("u_datafim")).getTime() / 1000);
                }
                catch(ParseException e)
                {
                    System.out.println(e);
                }
                this.data_inicio = Long.toString(date1);
                this.horas_previstas = rs.getString("u_nhoraso");
                this.data_fim = Long.toString(date2);
                this.fechado = rs.getInt("u_fechado");
                
                hora_decimal = rs.getDouble("u_nhorasr");
                
                int tmp_horas = hora_decimal.intValue();
                Double t1 = (hora_decimal - tmp_horas) * 60;
                int tmp_minutos = t1.intValue();
                Double tmp_seconds = (t1 - tmp_minutos) * 60;
                tmp_horas = tmp_horas * 3600;
                tmp_minutos = tmp_minutos * 60;
        
                this.horas_real = tmp_seconds.intValue() + tmp_horas + tmp_minutos;
            }
            
        } catch (SQLException e) {
            System.out.println( e );
        }
    }
    
}
