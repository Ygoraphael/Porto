/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;

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
        
        public String getURL() {
            return prop.getProperty( "url" );
        }
        
        public String getHostname() {
            return prop.getProperty( "hostname" );
        }
        
        public String getInstance() {
            return prop.getProperty( "instance" );
        }
        
        public String getPort() {
            return prop.getProperty( "port" );
        }
        
        public String getDB() {
            return prop.getProperty( "db" );
        }
        
        public String getUtilizador() {
            return prop.getProperty( "utilizador" );
        }
        
        public String getPassword() {
            return prop.getProperty( "password" );
        }
        
        public String getDbInstance() {
            return prop.getProperty( "instanceName" );
        }
}
