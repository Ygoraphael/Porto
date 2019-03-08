package fme;

import javax.swing.JButton;
import javax.swing.JPanel;
import javax.swing.JScrollPane;

public class CMsgInfoSim extends javax.swing.JDialog
{
  String html;
  JPanel panel1;
  JButton jButton_Fechar;
  javax.swing.JEditorPane jEditorPane_Guia = null;
  private JScrollPane jScrollPane_Guia = null;
  
  public CMsgInfoSim(String _html) {
    super(new javax.swing.JDialog(), "Guia de Preenchimento", false);
    html = _html;
    try {
      jbInit();
    }
    catch (Exception ex) {
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
      jScrollPane_Guia.setBounds(new java.awt.Rectangle(9, 10, 475, 275));
      jScrollPane_Guia.setVerticalScrollBarPolicy(20);
      jScrollPane_Guia.setBorder(javax.swing.BorderFactory.createLineBorder(java.awt.Color.black));
      jScrollPane_Guia.setViewportView(getJEditorPane_Guia());
    }
    return jScrollPane_Guia;
  }
  
  public javax.swing.JEditorPane getJEditorPane_Guia() {
    if (jEditorPane_Guia == null) {
      jEditorPane_Guia = new javax.swing.JEditorPane();
      jEditorPane_Guia.setEditable(false);
      try {
        jEditorPane_Guia.setPage(html);
      } catch (java.io.IOException e) {
        System.err.println("Attempted to read a bad html...");
      }
    }
    return jEditorPane_Guia;
  }
  
  public JButton getJButton_Fechar() {
    if (jButton_Fechar == null) {
      jButton_Fechar = new JButton();
      jButton_Fechar = new JButton();
      jButton_Fechar.setBounds(new java.awt.Rectangle(404, 292, 80, 25));
      jButton_Fechar.setText("Fechar");
      jButton_Fechar.addActionListener(new CMsgInfoSim_jButton1_actionAdapter(this));
    }
    return jButton_Fechar;
  }
  
  void jButton1_actionPerformed(java.awt.event.ActionEvent e) {
    hide();
  }
}
