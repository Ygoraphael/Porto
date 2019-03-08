/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package phcshrink;

import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.InputStreamReader;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.Statement;

/**
 *
 * @author tml
 */
public class PHCShrink {

    public static String hostName = "";
    public static String instanceName = "";
    public static String user = "";
    public static String password = "";
    public static String database = "";
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        
        if ( args.length == 6 ) {
            hostName = args[0];
            instanceName = args[1];
            user = args[2];
            password = args[3];
            database = args[4];
            
            String argumento = args[5];
            String[] modulos = argumento.split(";");
            
            if( conexao_efetuada() ) {
                for ( String modulo : modulos ) {
                    delete_mod(modulo);
                }
            }
        }
        else {
            System.out.println("Preencher com hostname instancename user password database modulo_1;modulo_2;...;modulo_n");
        }
    }
    
    public static void delete_mod(String modulo_a_morrer) {
        try {
            String lastSQL;
            String temp;
            Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
            String connectionUrl = 
                    "jdbc:sqlserver://" + hostName + //":" + port + ";" +
                    ";instanceName="+ instanceName +
                    ";user=" + user + ";" +
                    "password=" + password + ";" +
                    "database=" + database +";";
            Connection con;
            System.out.println(connectionUrl);
            con = DriverManager.getConnection(connectionUrl);
            System.out.println("Ligado a Base de Dados!");
            
            //apagar tabelas
            FileInputStream fstream = new FileInputStream("tabelas_phc_2015.csv"); 
            InputStreamReader isr=new InputStreamReader(fstream, "iso-8859-1");
            BufferedReader br=new BufferedReader(isr);
            while((temp=br.readLine())!=null){
                String[] tokens = temp.split(";");
                if(tokens[2].equals(modulo_a_morrer)) {
                    lastSQL = "DROP TABLE " + tokens[1].trim();
                    System.out.println("A APAGAR: " + tokens[1].trim());
                    try {
                        Statement stmt = con.createStatement(); 
                        stmt.executeQuery( lastSQL );
                    }
                    catch (Exception e) {
                        System.out.println(tokens[1].trim() + " apagado");
                    }
                }
            }
            fstream.close();

        } catch (Exception e) {
            System.out.println( e.toString() );
        }
    }
    
    public static Boolean conexao_efetuada() {
        try {
            Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
            String connectionUrl = 
                    "jdbc:sqlserver://" + hostName +
                    ";instanceName="+ instanceName +
                    ";user=" + user + ";" +
                    "password=" + password + ";" +
                    "database=" + database +";";
            Connection con;
            con = DriverManager.getConnection(connectionUrl);
            return true;
        } catch (Exception e) {
            System.out.println("Erro de ligação à base de dados " + e.toString() );
            return false;
        }
    }
    
}
