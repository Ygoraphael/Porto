/*
 * PHCMyShrinkApp.java
 */

package phcmyshrink;

import java.awt.Component;
import java.io.BufferedReader;
import org.jdesktop.application.Application;
import org.jdesktop.application.SingleFrameApplication;
import java.io.*;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Date; 
import org.jdesktop.application.Action;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
import javax.swing.JOptionPane;

/**
 * The main class of the application.
 */
public class PHCMyShrinkApp extends SingleFrameApplication {

    /**
     * At startup create and show the main frame of the application.
     */
    @Override protected void startup() {
        show(new PHCMyShrinkView(this));
    }

    /**
     * This method is to initialize the specified window by injecting resources.
     * Windows shown in our application come fully initialized from the GUI
     * builder, so this additional configuration is not needed.
     */
    @Override protected void configureWindow(java.awt.Window root) {
    }

    /**
     * A convenient static getter for the application instance.
     * @return the instance of PHCMyShrinkApp
     */
    public static PHCMyShrinkApp getApplication() {
        return Application.getInstance(PHCMyShrinkApp.class);
    }

    /**
     * Main method launching the application.
     */
    public static void main(String[] args) throws FileNotFoundException, UnsupportedEncodingException, IOException {
        launch(PHCMyShrinkApp.class, args);
    }

    public void delete_mod(String modulo_a_morrer) {
        try {
            String lastSQL;
            String temp;
            Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
            String connectionUrl = 
                    "jdbc:sqlserver://" + PHCMyShrinkView.hostname.getText() + //":" + port + ";" +
                    ";instanceName="+ PHCMyShrinkView.instanceName.getText() +
                    ";user=" + PHCMyShrinkView.username.getText() + ";" +
                    "password=" + PHCMyShrinkView.password.getText() + ";" +
                    "database=" + PHCMyShrinkView.db.getText() +";";
            Connection con;
            System.out.println(connectionUrl);
            con = DriverManager.getConnection(connectionUrl);
            System.out.println("Ligado a Base de Dados!");
            
            //apagar tabelas
            FileInputStream fstream = new FileInputStream("tabelas_phc_2013.csv"); 
            InputStreamReader isr=new InputStreamReader(fstream, "iso-8859-1");
            BufferedReader br=new BufferedReader(isr);
            while((temp=br.readLine())!=null){
                String[] tokens = temp.split(";");
                if(tokens[2].equals(modulo_a_morrer)) {
                    lastSQL = "DROP TABLE " + tokens[1].trim();
                    System.out.println("A APAGAR: " + tokens[1].trim());
                    PHCMyShrinkView.outputext.setText("A APAGAR: " + tokens[1].trim());
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
            System.out.println("Erro de ligação à base de dados " + e.toString() );
        }
    }
    
    public void delete_out() {
        try {
            String lastSQL;
            String temp;
            Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
            String connectionUrl = 
                    "jdbc:sqlserver://" + PHCMyShrinkView.hostname.getText() + //":" + port + ";" +
                    ";instanceName="+ PHCMyShrinkView.instanceName.getText() +
                    ";user=" + PHCMyShrinkView.username.getText() + ";" +
                    "password=" + PHCMyShrinkView.password.getText() + ";" +
                    "database=" + PHCMyShrinkView.db.getText() +";";
            Connection con;
            System.out.println(connectionUrl);
            con = DriverManager.getConnection(connectionUrl);
            System.out.println("Ligado a Base de Dados!");
            
            //apagar tabelas
            FileInputStream fstream = new FileInputStream("tabelas_phc_2013.csv"); 
            InputStreamReader isr=new InputStreamReader(fstream, "iso-8859-1");
            BufferedReader br=new BufferedReader(isr);
            ArrayList<String> stringList = new ArrayList<String>();
            
            while((temp=br.readLine())!=null){
                String[] tokens = temp.split(";");
                stringList.add(tokens[1].trim());
            }
            fstream.close();
            
            lastSQL = "SELECT name FROM sys.tables ORDER BY name";
            ResultSet rs = null;
            try {
                Statement stmt = con.createStatement();
                rs = stmt.executeQuery(lastSQL);

                while (rs.next()) {
                    if(!stringList.contains(rs.getString("name").trim().toUpperCase())) {
                        try {
                            lastSQL = "DROP TABLE " + rs.getString("name").trim();
                            stmt = con.createStatement(); 
                            stmt.executeQuery( lastSQL );
                            System.out.println("A APAGAR: " + rs.getString("name").trim());
                        }
                        catch (Exception e) {
                            System.out.println(e);
                            PHCMyShrinkView.outputext.setText("A APAGAR: " + rs.getString("name").trim());
                            System.out.println("A APAGAR: " + rs.getString("name").trim());
                            continue;
                        }
                    }
                }
            }
            catch (Exception e) {
                System.out.println(e);
            }

        } catch (Exception e) {
            System.out.println("Erro de ligação à base de dados " + e.toString() );
        }
    }
    
    
    @Action
    public void apaga_modulos() {

        if(PHCMyShrinkView.jCheckBox1.isSelected()) {
            delete_mod("CRM Comercial");
        }
        if(PHCMyShrinkView.jCheckBox2.isSelected()) {
            delete_mod("Contabilidade");
        }
        if(PHCMyShrinkView.jCheckBox3.isSelected()) {
            delete_mod("ControlDoc");
        }
        if(PHCMyShrinkView.jCheckBox4.isSelected()) {
            delete_mod("Ecovalor");
        }
        if(PHCMyShrinkView.jCheckBox5.isSelected()) {
            delete_mod("Suporte");
        }
        if(PHCMyShrinkView.jCheckBox6.isSelected()) {
            delete_mod("Tabelas do Utilizador");
        }
        if(PHCMyShrinkView.jCheckBox7.isSelected()) {
            delete_mod("TeamControl");
        }
        if(PHCMyShrinkView.jCheckBox8.isSelected()) {
            delete_mod("Vários");
        }
        if(PHCMyShrinkView.jCheckBox9.isSelected()) {
            delete_mod("Frota");
        }
        if(PHCMyShrinkView.jCheckBox10.isSelected()) {
            delete_mod("Imobilizado");
        }
        if(PHCMyShrinkView.jCheckBox11.isSelected()) {
            delete_mod("Gestão");
        }
        if(PHCMyShrinkView.jCheckBox12.isSelected()) {
            delete_mod("InterOp");
        }
        if(PHCMyShrinkView.jCheckBox13.isSelected()) {
            delete_mod("POS");
        }
        if(PHCMyShrinkView.jCheckBox14.isSelected()) {
            delete_mod("Pessoal");
        }
        if(PHCMyShrinkView.jCheckBox15.isSelected()) {
            delete_mod("Restauração");
        }
        if(PHCMyShrinkView.jCheckBox16.isSelected()) {
            delete_mod("Sistema");
        }
        if(PHCMyShrinkView.outros_del.isSelected()) {
            delete_out();
        }
        Component frame = null;
        JOptionPane.showMessageDialog(frame, "Concluido!");
    }
}
