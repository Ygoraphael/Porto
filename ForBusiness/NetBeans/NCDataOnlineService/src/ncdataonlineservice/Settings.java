/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ncdataonlineservice;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.Dictionary;
import java.util.HashMap;
import java.util.Hashtable;
import java.util.Iterator;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.codehaus.jackson.map.ObjectMapper;

/**
 *
 * @author tml
 */
public class Settings {
    Map data = new HashMap<String,String>();
    String file = "settings";
    Boolean isCrypt = true;
    String key = "d2c7cb7s5a74a48c";
    String salt = "78x3s65a6de9d241";
    
    public Settings(Map whatData, String whatFile, Boolean isItCrypted, String whatSalt, String whatKey) throws FileNotFoundException, IOException
    {
        if (whatFile.equals(""))
        {
            System.out.println("whatFile tem que ser diferente de vazio");
        }
        if (isItCrypted)
        {
            if (whatSalt.length() != 16)
            {
                System.out.println("whatSalt tem que ter 16 caracteres");
            }
            if (whatKey.length() != 16)
            {
                System.out.println("whatKey tem que ter 16 caracteres");
            }
        }
        this.data = whatData;
        this.file = whatFile;
        this.isCrypt = isItCrypted;
        this.salt = whatSalt;
        this.key = whatKey;
        this.Load();
    }
    
    public void Load() 
    {
        String path = Util.GetDirectoryPath() + this.file;
        File f = new File(path);
        
        if (f.exists())
        {
            try {
                String cyphertext = Util.ReadAllText(path);
                if (this.isCrypt)
                {
                    cyphertext = StringCipher.Decrypt(cyphertext, this.salt, this.key);
                }
                this.data = new ObjectMapper().readValue(cyphertext, Map.class);
                
//            for (Iterator it = this.data.entrySet().iterator(); it.hasNext();) {
//                Map.Entry<String,String> entry = (Map.Entry<String,String>) it.next();
//                System.out.println(entry.getKey() + "/" + entry.getValue());
//            }
            } catch (IOException ex) {
                Logger.getLogger(Settings.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
    
    public String GetSetting(String name)
    {
        if (!this.data.containsKey(name))
        {
            System.out.println(name + " não é um indice de data");
        }
        
        return (String)this.data.get(name);
    }
    
    public boolean GetSetting(String name, boolean value)
    {
        if (!this.data.containsKey(name))
        {
            System.out.println(name + " não é um indice de data");
        }
        
        value = Boolean.parseBoolean(this.GetSetting(name));
        return value;
    }
    
    public String GetSettingFromFile(String name) 
    {
        this.Load();
        return this.GetSetting(name);
    }

    public boolean GetSettingFromFile(String name, boolean value) 
    {
        this.Load();
        return this.GetSetting(name, value);
    }
}
