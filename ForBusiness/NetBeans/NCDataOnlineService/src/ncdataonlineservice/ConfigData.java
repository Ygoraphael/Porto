/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ncdataonlineservice;

import java.util.HashMap;
import java.util.Map;

/**
 *
 * @author tml
 */
public class ConfigData {
    public HashMap<String, HashMap<String, String>> conexao = new HashMap<String, HashMap<String, String>>();
    public HashMap ficheiroJson = new HashMap<>();
    public HashMap ficheiroXls = new HashMap<>();
    public HashMap geral = new HashMap<>();
    public HashMap<String, HashMap<String, String>> query = new HashMap<String, HashMap<String, String>>();
    public String name = "";
    
    public boolean HasName() {
        return (this.name != "");
    }
}
