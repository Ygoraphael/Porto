/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fmefme;

import java.io.File;
import fme;

/**
 *
 * @author tml
 */
public class FMEFME extends fme {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        
         try {
            File f = new File(new File(".").getCanonicalPath());
            jFileChooser.setCurrentDirectory(f);
            jFileChooser.setDialogTitle("Abrir Candidatura");
            jFileChooser.addChoosableFileFilter(new XmlFileFilter());
            int returnVal = jFileChooser.showOpenDialog(null);

              File file = "c:/bicafe_int.q11";
              if (fmeApp.Config == null) {
                JOptionPane.showMessageDialog(null, "parse noconfig");
                XMLParser.Open(file);

                if (fmeApp.Config != null) {
                  JOptionPane.showMessageDialog(null, "montar: " + fmeApp.Config);
                  fmeApp.comum.mount_new_config(fmeApp.Config);
                }
              }
              if (fmeApp.Config == null) {
                JOptionPane.showMessageDialog(null, "não deu...");
                return;
              }

              CBData.before_open();
              CBData.corrompido = false;
              XMLParser.Open(file);
              if (CBData.corrompido) {
                CBData.Clear();
                CBData.LastFile = null;
                CBData.corrompido = false;
                JOptionPane.showMessageDialog(null, "Ficheiro corrompido!");
              }
              if ((fmeApp.in_pas) && 
                (!reg_C_ori.equals(CBData.reg_C))) {
                CBData.Clear();
                CBData.reg_C = reg_C_ori;
                CBData.reg_nif = reg_nif_ori;
                CBData.reg_pas = reg_pas_ori;
                JOptionPane.showMessageDialog(null, "Ficheiro inválido!\nEste ficheiro não é da Refª " + reg_C_ori + ".");
              }

              CBData.after_open();
          } catch (Exception e2) {
            System.out.print(e2);
            JOptionPane.showMessageDialog(null, "Erro ao abrir o ficheiro!");
          }       
                
    }
    
}
