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
public class DocTipos extends PHCDB {
    
    public int ndoc;
    public String nmdoc;
    public int tipodoc;
    public String tiposaft;
    
    public DocTipos ( String hostname, String port, String username, String password, String db, String instancename) {
        super( hostname, port, username, password, db, instancename );
    }
    
    public DocTipos( Connection con ) {
        super( con );
    }
    
    ArrayList<String> list(String id) throws FileNotFoundException, IOException {
        
        
        ArrayList<String> FilesList = new ArrayList<String>();
        int num_files = 0;
        SecureRandom random = new SecureRandom();
        String random_string = null;
        File file = null;
        FileOutputStream fop = null;
        String content = null;
        byte[] contentInBytes = null;
        
        this.lastSQL = "SELECT ndoc, nmdoc, tipodoc, tiposaft FROM td";
        
        DocTipos doctipo = null;
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
                
                doctipo = new DocTipos( this.con );
                doctipo.ndoc = rs.getInt("ndoc");
                doctipo.nmdoc = rs.getString("nmdoc");
                doctipo.tipodoc = rs.getInt("tipodoc");
                doctipo.tiposaft = rs.getString("tiposaft");
                
                //escreve dados
                content = "\n" + doctipo.ndoc + "," + doctipo.nmdoc + "," + doctipo.tipodoc + "," + doctipo.tiposaft;
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
