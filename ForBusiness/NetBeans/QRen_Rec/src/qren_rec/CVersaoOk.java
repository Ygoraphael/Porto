package fme;

import java.awt.Color;
import java.awt.Container;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JDialog;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextField;

















































































































































































































































class CVersaoOk
  extends JDialog
{
  JPanel panel1 = new JPanel();
  JPanel jPanel1 = new JPanel();
  JLabel jLabel1 = new JLabel();
  
  JCheckBox jCheckBox_Proxy = new JCheckBox();
  JLabel jLabel2 = new JLabel();
  JLabel jLabel3 = new JLabel();
  
  JTextField jTextField_proxy = new JTextField();
  JTextField jTextField_porta = new JTextField();
  
  JButton jButton_Post = new JButton();
  
  JButton jButton_Cancel = new JButton();
  JLabel jLabel5 = new JLabel();
  
  JCheckBox jCheckBox_Proxy1 = new JCheckBox();
  
  public CVersaoOk(String title, boolean modal)
  {
    try {
      jbInit();
      pack();
    }
    catch (Exception ex) {
      ex.printStackTrace();
    }
  }
  



  private void jbInit()
    throws Exception
  {
    panel1.setLayout(null);
    getContentPane().setLayout(null);
    panel1.setBounds(new Rectangle(0, 299, 1, 1));
    jPanel1.setBorder(fmeComum.blocoBorder);
    jPanel1.setBounds(new Rectangle(10, 11, 414, 187));
    jPanel1.setLayout(null);
    jLabel1.setFont(fmeComum.letra_bold);
    jLabel1.setText("Verificar se a versão do formulário está atualizada");
    jLabel1.setBounds(new Rectangle(12, 7, 290, 21));
    
    jCheckBox_Proxy.setBorder(BorderFactory.createLineBorder(Color.black));
    jCheckBox_Proxy.setText("<html>Usar um servidor proxy para a LAN (não aplicável a ligações por modem/ADSL ou VPN)<html>");
    
    jCheckBox_Proxy.setFont(fmeComum.letra);
    jCheckBox_Proxy.setBounds(new Rectangle(13, 49, 350, 38));
    
    jLabel2.setBounds(new Rectangle(67, 98, 58, 15));
    jLabel2.setFont(fmeComum.letra);
    jLabel2.setText("Endereço");
    
    jLabel3.setFont(fmeComum.letra);
    jLabel3.setText("Porta");
    jLabel3.setBounds(new Rectangle(234, 98, 34, 15));
    
    jTextField_proxy.setText("");
    jTextField_proxy.setBounds(new Rectangle(123, 96, 90, 19));
    jTextField_porta.setBounds(new Rectangle(269, 96, 37, 19));
    
    jTextField_porta.setText("");
    jButton_Post.setBounds(new Rectangle(243, 150, 75, 26));
    jButton_Post.setText("Verificar");
    jButton_Post.setFont(fmeComum.letra);
    jButton_Post.addActionListener(new CVersaoOk_jButton_Post_actionAdapter(this));
    
    jButton_Cancel.setBounds(new Rectangle(325, 150, 75, 26));
    jButton_Cancel.setMargin(new Insets(0, 0, 0, 0));
    jButton_Cancel.setFont(fmeComum.letra);
    jButton_Cancel.setText("Cancelar");
    jButton_Cancel.addActionListener(new CVersaoOk_jButton_Cancel_actionAdapter(this));
    jLabel5.setText("");
    jLabel5.setBounds(new Rectangle(303, 1, 100, 49));
    jLabel5.setHorizontalAlignment(4);
    jLabel5.setIcon(fmeComum.logoPagina);
    jCheckBox_Proxy1.setBounds(new Rectangle(12, 145, 200, 40));
    jCheckBox_Proxy1.setText("<html>Mostrar esta janela no arranque<br>do formulário<html>");
    jCheckBox_Proxy1.setFont(fmeComum.letra_pequena);
    jCheckBox_Proxy1.setVerticalTextPosition(0);
    jCheckBox_Proxy1.setBorder(BorderFactory.createLineBorder(Color.black));
    getContentPane().add(panel1, null);
    getContentPane().add(jPanel1, null);
    
    jPanel1.add(jLabel1, null);
    jPanel1.add(jLabel5, null);
    jPanel1.add(jCheckBox_Proxy, null);
    jPanel1.add(jTextField_porta, null);
    jPanel1.add(jLabel2, null);
    jPanel1.add(jTextField_proxy, null);
    jPanel1.add(jLabel3, null);
    jPanel1.add(jButton_Cancel, null);
    jPanel1.add(jCheckBox_Proxy1, null);
    jPanel1.add(jButton_Post, null);
    
    setModal(true);
    setResizable(false);
  }
  

  void jButton_Post_actionPerformed(ActionEvent e) {}
  
  void jButton_Cancel_actionPerformed(ActionEvent e)
  {
    hide();
  }
}
