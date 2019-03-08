package main_application;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
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
    
    public String getUrlClientesMdate() 
    {    
        return prop.getProperty( "urlClientesMdate" );   
    }
    
    public String getUrlClientes() 
    {    
        return prop.getProperty( "urlClientes" );   
    }
    
    public String getUrlFamilias_ini() 
    {   
        String[] split = prop.getProperty( "urlFamilias" ).split("/");
        String LastWord = split[split.length - 1];
        return prop.getProperty( "urlFamilias" ).substring(0, prop.getProperty( "urlFamilias" ).length() - LastWord.length()) + "familias_ini";
    }
    
    public String getUrlFamilias() 
    {    
        return prop.getProperty( "urlFamilias" );   
    }
    
    public String getUrlFamilias_end() 
    {   
        String[] split = prop.getProperty( "urlFamilias" ).split("/");
        String LastWord = split[split.length - 1];
        return prop.getProperty( "urlFamilias" ).substring(0, prop.getProperty( "urlFamilias" ).length() - LastWord.length()) + "familias_end";
    }
    
    public String getUrlFamiliasMdate() 
    {    
        return prop.getProperty( "urlFamiliasMdate" );
    }
    
    public String getUrlArtigos_ini() 
    {
        String[] split = prop.getProperty( "urlArtigos" ).split("/");
        String LastWord = split[split.length - 1];
        return prop.getProperty( "urlArtigos" ).substring(0, prop.getProperty( "urlArtigos" ).length() - LastWord.length()) + "artigos_ini";
    }
    
    public String getUrlArtigos() 
    {    
        return prop.getProperty( "urlArtigos" );   
    }
    
    public String getUrlArtigos_end() 
    {   
        String[] split = prop.getProperty( "urlArtigos" ).split("/");
        String LastWord = split[split.length - 1];
        return prop.getProperty( "urlArtigos" ).substring(0, prop.getProperty( "urlArtigos" ).length() - LastWord.length()) + "artigos_end";
    }
    
    public String getUrlDescontos() 
    {    
        return prop.getProperty( "urlDescontos" );   
    }
    
    public String getUrlArtigosMdate() 
    {    
        return prop.getProperty( "urlArtigosMdate" );
    }
    
    public String getUrlEncomendasMdate() 
    {    
        return prop.getProperty( "urlEncomendasMdate" );   
    }
    
    public String getUrlEstadoEncomendas() 
    {    
        return prop.getProperty( "urlEstadoEncomendas" );   
    }
    
    public String getUrlEncomendas() 
    {    
        return prop.getProperty( "urlEncomendas" );   
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
    
    public String getNDoc() 
    {
        return prop.getProperty( "ndocumento" );
    }
    
    public String getSyncInterval() 
    {
        return prop.getProperty( "syncinterval" );
    }
    
    public String getSyncElemArtigos() 
    {
        return prop.getProperty( "sinc_artigos" );
    }
    
    public String getSyncElemFamilias() 
    {
        return prop.getProperty( "sinc_familias" );
    }
    
    public String getSyncElemClientes() 
    {
        return prop.getProperty( "sinc_clientes" );
    }
    
    public String getSyncElemEncomendas() 
    {
        return prop.getProperty( "sinc_encomendas" );
    }
    
    public String getSyncElemEstadoEncomendas() 
    {
        return prop.getProperty( "sinc_estadoencomendas" );
    }
    
    public String getSyncElemDescontos() 
    {
        return prop.getProperty( "sinc_descontos" );
    }
    
    
    public void setSyncElemArtigos(String value) 
    {
        prop.setProperty("sinc_artigos", value);
    }
    
    public void setSyncElemFamilias(String value) 
    {
        prop.setProperty("sinc_familias", value);
    }
    
    public void setSyncElemClientes(String value) 
    {
        prop.setProperty("sinc_clientes", value);
    }
    
    public void setSyncElemEncomendas(String value) 
    {
        prop.setProperty("sinc_encomendas", value);
    }
    
    public void setSyncElemEstadoEncomendas(String value) 
    {
        prop.setProperty("sinc_estadoencomendas", value);
    }
    
    public void setSyncElemDescontos(String value) 
    {
        prop.setProperty("sinc_descontos", value);
    }
    
    public void save() 
    {
        FileOutputStream fos = null;
        try {
            fos = new FileOutputStream(fileName);
        } catch (FileNotFoundException ex) {
            Logger.getLogger(Config.class.getName()).log(Level.SEVERE, null, ex);
        }
        try {
            prop.store(fos, "");
        } catch (IOException ex) {
            Logger.getLogger(Config.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}