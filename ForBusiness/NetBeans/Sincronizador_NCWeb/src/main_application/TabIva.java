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
public class TabIva extends PHCDB {
    
    public String codigo;
    public String taxa;
    
    public TabIva ( String hostname, String port, String username, String password, String db, String instancename) {
        super( hostname, port, username, password, db, instancename );
    }
    
    public TabIva( Connection con ) {
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

        this.lastSQL = "SELECT codigo, taxa  FROM taxasiva";

        TabIva tabiva = null;
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
                
                tabiva = new TabIva( this.con );
                tabiva.codigo = rs.getString("codigo");
                tabiva.taxa = rs.getString("taxa");
                
                //escreve dados
                content = "\n" + tabiva.codigo + "," + tabiva.taxa;
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
