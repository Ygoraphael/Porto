/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package ncremoteservice;

import java.io.FileInputStream;
import java.io.FileOutputStream;
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
    
    public String getDbUser() 
    {
        return prop.getProperty( "username" );
    }
    
    public String getDbPass() 
    {
        return prop.getProperty( "password" );
    }
    
    public String getDbHost() 
    {
        return prop.getProperty( "hostname" );
    }
    
    public String getDbPort() 
    {
        return prop.getProperty( "port" );
    }
    
    public String getDbInstance() 
    {
        return prop.getProperty( "instanceName" );
    }

    public String getDb() 
    {
        return prop.getProperty( "database" );
    }
}