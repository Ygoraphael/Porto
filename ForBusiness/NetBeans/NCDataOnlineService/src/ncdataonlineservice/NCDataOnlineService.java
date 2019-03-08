/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ncdataonlineservice;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.URISyntaxException;
import java.util.Dictionary;
import java.util.HashMap;
import java.util.Hashtable;
import java.util.Iterator;
import java.util.Map;
import java.util.Properties;
import java.util.Timer;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author tml
 */
public class NCDataOnlineService {
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        File caminho = new File(NCDataOnlineService.class.getProtectionDomain().getCodeSource().getLocation().getPath() );
        String ficheiro = caminho.getName().toLowerCase();
        int pos = ficheiro.lastIndexOf(".");
        if (pos > 0) {
            ficheiro = ficheiro.substring(0, pos);
        }
        Sincronizador sinc = new Sincronizador();
        //ficheiro = "nc";
        sinc.StartSinc(ficheiro);
    }
}
