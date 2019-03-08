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
public class Artigo extends PHCDB {
    
    public String ststamp;
    public String ref;
    public String design;
    public Double epv1;
    public int iva1incl;
    public Double epcusto;
    public int ivapcincl;
    public int stns;
    public int tabiva;
    
    public Artigo ( String hostname, String port, String username, String password, String db, String instancename) {
        super( hostname, port, username, password, db, instancename );
    }
    
    public Artigo( Connection con ) {
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

        this.lastSQL = "SELECT "
                + "ststamp," +
                "ref," +
                "design," +
                "epv1," +
                "iva1incl," +
                "epcusto," +
                "ivapcincl," +
                "stns," +
                "tabiva"
                + " FROM st";

        Artigo artigo = null;
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
                
                artigo = new Artigo( this.con );
                artigo.ststamp = rs.getString("ststamp");
                artigo.ref = rs.getString("ref");
                artigo.design = rs.getString("design");
                artigo.epv1 = rs.getDouble("epv1");
                artigo.iva1incl = rs.getInt("iva1incl");
                artigo.epcusto = rs.getDouble("epcusto");
                artigo.ivapcincl = rs.getInt("ivapcincl");
                artigo.stns = rs.getInt("stns");
                artigo.tabiva = rs.getInt("tabiva");
                
                //escreve dados
                content = "\n" + artigo.ststamp + "/-!-/" + artigo.ref + "/-!-/" + artigo.design + "/-!-/" + artigo.epv1
                         + "/-!-/" + artigo.iva1incl + "/-!-/" + artigo.epcusto + "/-!-/" + artigo.ivapcincl + "/-!-/" + artigo.stns
                         + "/-!-/" + artigo.tabiva;
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
