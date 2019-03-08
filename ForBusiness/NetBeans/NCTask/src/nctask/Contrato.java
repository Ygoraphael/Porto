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
public class Contrato extends PHCDB {
    
    public int no;
    public Float u_horasc;
    public Float u_horasres;
    public String contrato_inicio;
    public String contrato_fim;
    public String contrato_fecho;
    
    public Contrato ( String hostname, String port, String username, String password, String db) {
        super( hostname, port, username, password, db );
    }
    
    public Contrato( Connection con ) {
        super( con );
    }
    
    public void get( String id_c ) {
        
        this.lastSQL = "SELECT no, u_horasc, u_horasres, (select dbo.UltDataRenovacaoContrato(csup.no)) data_inicial, " + 
                       "(select dbo.ProxDataRenovacaoContrato(csup.no)) data_final, datap FROM csup (nolock) " +
                       "WHERE no = " + id_c;
        
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                
                this.no = rs.getInt("no");
                this.u_horasc = Float.parseFloat( rs.getString("u_horasc") )  * 3600;
                this.u_horasres = Float.parseFloat( rs.getString("u_horasres") ) * 3600;
                this.contrato_inicio = rs.getString("data_inicial");
                this.contrato_fim = rs.getString("data_final");
                this.contrato_fecho = rs.getString("datap");
                
            }
            
        } catch (SQLException e) {
            System.out.println( e );
        }
    }
    
    public ArrayList<Contrato> list() {
        
        this.lastSQL = "SELECT no, u_horasc, u_horasres, (select dbo.UltDataRenovacaoContrato(csup.no)) data_inicial, (select dbo.ProxDataRenovacaoContrato(csup.no)) data_final FROM csup";
        
        ArrayList<Contrato> contratos = new ArrayList<Contrato>();
        Contrato contrato = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                
                contrato = new Contrato( this.con );
                contrato.no = rs.getInt("no");
                contrato.u_horasc = Float.parseFloat( rs.getString("u_horasc") )  * 3600;
                contrato.u_horasres = Float.parseFloat( rs.getString("u_horasres") ) * 3600;
                contrato.contrato_inicio = rs.getString("data_inicial");
                contrato.contrato_fim = rs.getString("data_final");
                
                contratos.add(contrato);
                
            }
            
            System.out.println( "#Contratos a actualizar: " + contratos.size() );
            return contratos;
            
        } catch (SQLException e) {
            System.out.println( e );
            return null;
        }
    }
    
}
