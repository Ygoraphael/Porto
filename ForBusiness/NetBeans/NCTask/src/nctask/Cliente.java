/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package nctask;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.nio.charset.Charset;
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
public class Cliente extends PHCDB {
    
    public String nome;
    public String email;
    public Integer no;
    public String morada;
    public String localidade;
    public String codpostal;
    public String telefone;
    public String fax;
    public String telemovel;
    public String contribuinte;
    public String saldo;
    public String obs;
    
    public Cliente ( String hostname, String port, String username, String password, String db) {
        super( hostname, port, username, password, db );
    }
    
    public Cliente( Connection con ) {
        super( con );
    }
    
    public void get( String d ) throws UnsupportedEncodingException {
        
        this.lastSQL = "SELECT DISTINCT no, nome, email, morada, local, codpost, telefone, " +
                       "fax, tlmvl, ncont, esaldo, " +
                       "replace(cast(obs as varchar(max)), CHAR(13) + CHAR(10) ,'\\n') obs, " +
                       "replace(cast(u_bakdesc as varchar(max)), CHAR(13) + CHAR(10) ,'\\n') u_bakdesc, " + 
                       "replace(cast(u_acessos as varchar(max)), CHAR(13) + CHAR(10) ,'\\n') u_acessos " +
                       "FROM cl (nolock) " +
                       "WHERE no = " + d + " and estab = 0;";
        
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                this.nome = new String(rs.getString("nome").getBytes("UTF-8"), "UTF-8");
                this.no = rs.getInt("no");
                this.email = rs.getString("email");    
                this.morada = rs.getString("morada");
                this.localidade = rs.getString("local");
                this.codpostal = rs.getString("codpost");
                this.telefone = rs.getString("telefone");
                this.fax = rs.getString("fax");
                this.telemovel = rs.getString("tlmvl");
                this.contribuinte = rs.getString("ncont");
                this.saldo = rs.getString("esaldo");
                
                String s01 = URLEncoder.encode("**Observações**\\n\\n" + rs.getString("obs"), "ISO-8859-1");
                String s02 = URLEncoder.encode("\\n\\n**Backups**\\n\\n" + rs.getString("u_bakdesc"), "ISO-8859-1");
                String s03 = URLEncoder.encode("\\n\\n**Acessos**\\n\\n" + rs.getString("u_acessos"), "ISO-8859-1");
                
                this.obs = s01 + s02 + s03;
                
            }
            
        } catch (SQLException e) {
            System.out.println( e );
        }
    }
    
    public ArrayList<Cliente> list( int d ) throws UnsupportedEncodingException {
        
        this.lastSQL = "SELECT DISTINCT no, nome, email " +
                       "FROM cl " +
                       "WHERE no > '" + d + "'";
        
        ArrayList<Cliente> clientes = new ArrayList<Cliente>();
        Cliente cliente = null;
        ResultSet rs = null;
        Statement stmt = null;
        String newString = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                cliente = new Cliente( this.con );
                cliente.nome = new String(rs.getString("nome").getBytes("UTF-8"), "UTF-8");
                cliente.no = rs.getInt("no");
                cliente.email = rs.getString("email");
                
                clientes.add(cliente);
                
            }
            
            System.out.println( "#Clientes a actualizar: " + clientes.size() );
            return clientes;
            
        } catch (SQLException e) {
            System.out.println( e );
            return null;
        }
    }
    
}
