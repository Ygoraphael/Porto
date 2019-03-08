/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.math.BigInteger;
import java.security.SecureRandom;
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
public class Clientes extends PHCDB {
    
    public int no;
    public String nome;
    public String ncont;
    public String fax;
    public String telefone;
    public String morada;
    public String local;
    public String codpost;
    public String email;
    public String tlmvl;
    public int vencimento;
    public int clivd;
    public String descarga;
    
    public Clientes ( String hostname, String port, String username, String password, String db, String instancename) {
        super( hostname, port, username, password, db, instancename );
    }
    
    public Clientes( Connection con ) {
        super( con );
    }
    
    public ArrayList<String> list(String id) throws FileNotFoundException, IOException {
        
        ArrayList<String> FilesList = new ArrayList<String>();
        int num_files = 0;
        SecureRandom random = new SecureRandom();
        String random_string = null;
        File file = null;
        FileOutputStream fop = null;
        String content = null;
        byte[] contentInBytes = null;

        this.lastSQL = "SELECT nome, no, ncont, fax, telefone, morada, local,"
                + "codpost, email, tlmvl, vencimento, clivd, descarga FROM cl";

        Clientes cliente = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                
                if ( num_files == 0 ) {
                    //abre ficheiro
                    random = new SecureRandom();
                    random_string = new BigInteger(130, random).toString(32);

                    file = new File( random_string );
                    fop = new FileOutputStream( file );
                    if (!file.exists()) {
                        file.createNewFile();
                    }

                    content = id;
                    contentInBytes = content.getBytes();
                    fop.write(contentInBytes);
                    fop.flush();
                }
                
                cliente = new Clientes( this.con );
                cliente.no = rs.getInt("no");
                cliente.nome = rs.getString("nome");
                cliente.ncont = rs.getString("ncont");
                cliente.fax = rs.getString("fax");
                cliente.telefone = rs.getString("telefone");
                cliente.morada = rs.getString("morada");
                cliente.local = rs.getString("local");
                cliente.codpost = rs.getString("codpost");
                cliente.email = rs.getString("email");
                cliente.tlmvl = rs.getString("tlmvl");
                cliente.vencimento = rs.getInt("vencimento");
                cliente.clivd = rs.getInt("clivd");
                cliente.descarga = rs.getString("descarga");
                
                //escreve dados
                content = "\n" + cliente.no + "/-!-/" + cliente.nome + "/-!-/" + cliente.ncont + "/-!-/" + cliente.fax
                         + "/-!-/" + cliente.telefone + "/-!-/" + cliente.morada + "/-!-/" + cliente.local + "/-!-/" + cliente.codpost
                         + "/-!-/" + cliente.email + "/-!-/" + cliente.tlmvl + "/-!-/" + cliente.vencimento + "/-!-/" + cliente.clivd
                         + "/-!-/" + cliente.descarga;
                contentInBytes = content.getBytes();
                fop.write(contentInBytes);
                fop.flush();
                
                if ( num_files == 1000 ) {
                    if (fop != null) {
                        fop.close();
                        FilesList.add( random_string );
                        num_files = 0;
                    }
                }
                else {
                    num_files++;
                }
                
            }

            if (fop != null) {
                fop.close();
                FilesList.add( random_string );
            }
            
            return FilesList;
            
        } catch (SQLException e) {
            System.out.println( e );
            return null;
        }

    }
    
}
