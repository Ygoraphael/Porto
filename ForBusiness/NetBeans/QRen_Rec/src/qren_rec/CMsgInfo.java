package fme;

import javax.swing.JButton;
import javax.swing.JEditorPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;

public class CMsgInfo extends javax.swing.JDialog
{
  String file;
  JPanel panel1;
  JButton jButton_Fechar;
  JEditorPane jEditorPane_Guia = null;
  private JScrollPane jScrollPane_Guia = null;
  
  public CMsgInfo(String _file) {
    super(new javax.swing.JDialog(), "Ajuda", false);
    file = _file;
    try {
      jbInit();
    } catch (Exception ex) {
      ex.printStackTrace();
    }
  }
  
  private void jbInit() throws Exception {
    panel1 = new JPanel();
    panel1.setLayout(null);
    panel1.add(getJScrollPane_Guia(), null);
    panel1.add(getJButton_Fechar(), null);
    getContentPane().add(panel1);
    setModal(true);
    setResizable(false);
    pack();
  }
  
  public JScrollPane getJScrollPane_Guia() {
    if (jScrollPane_Guia == null) {
      jScrollPane_Guia = new JScrollPane();
      jScrollPane_Guia.setBounds(new java.awt.Rectangle(10, 10, 525, 370));
      jScrollPane_Guia
        .setVerticalScrollBarPolicy(20);
      jScrollPane_Guia.setBorder(
        javax.swing.BorderFactory.createLineBorder(java.awt.Color.black));
      jScrollPane_Guia.setViewportView(getJEditorPane_Guia());
    }
    return jScrollPane_Guia;
  }
  
  public JEditorPane getJEditorPane_Guia() {
    if (jEditorPane_Guia == null) {
      jEditorPane_Guia = new JEditorPane();
      jEditorPane_Guia.setEditable(false);
      jEditorPane_Guia.setContentType("text/html");
      String s = "";
      try {
        java.io.BufferedReader in = new java.io.BufferedReader(new java.io.InputStreamReader(
          getClass().getResourceAsStream(file), 
          "CP1252"));
        String s1 = in.readLine();
        while (s1 != null) {
          s = s + s1;
          s1 = in.readLine();
        }
      } catch (java.io.IOException e1) {
        javax.swing.JOptionPane.showMessageDialog(null, e1.getMessage());
      }
      jEditorPane_Guia.setText(s);
    }
    return jEditorPane_Guia;
  }
  
  public JButton getJButton_Fechar() {
    if (jButton_Fechar == null) {
      jButton_Fechar = new JButton();
      jButton_Fechar = new JButton();
      jButton_Fechar.setBounds(new java.awt.Rectangle(455, 390, 80, 25));
      jButton_Fechar.setText("Fechar");
      jButton_Fechar
        .addActionListener(new CMsgInfo_jButton1_actionAdapter(this));
    }
    return jButton_Fechar;
  }
  
  void jButton1_actionPerformed(java.awt.event.ActionEvent e) {
    hide();
  }
}
