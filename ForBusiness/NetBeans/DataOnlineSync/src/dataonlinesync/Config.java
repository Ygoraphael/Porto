/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package dataonlinesync;

import java.io.FileInputStream;
import java.io.InputStream;
import java.util.Properties;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author Tiago Loureiro
 */

public class Config {
    
    private Properties prop;
    String fileName = "config.properties";
    
    public Config() {
      
        this.prop = new Properties();
        InputStream is;

        try {
            is = new FileInputStream(fileName);
            prop.load(is);
        } catch ( Exception ex ) {
            Logger.getLogger(Config.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public String getPath() 
    {
        return prop.getProperty( "path" );
    }

    public String getDb() 
    {
        return prop.getProperty( "database" );
    }
    
    public String getPort() 
    {
        return prop.getProperty( "port" );
    }
}