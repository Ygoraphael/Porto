package fme;

import java.awt.Color;
import java.awt.Container;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.AbstractButton;
import javax.swing.ButtonModel;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JDialog;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JPasswordField;
import javax.swing.JTextField;














































































































class CRegisto
  extends JDialog
{
  JPanel jPanel1 = new JPanel();
  JLabel jLabel_titulo = new JLabel();
  JLabel jLabel_logo = new JLabel();
  JLabel jLabel_nif = new JLabel();
  JTextField jTextField_nif = new JTextField();
  JLabel jLabel_chk_nif = new JLabel();
  JCheckBox jCheckBox_nif = new JCheckBox();
  JLabel jLabel_chk_pas = new JLabel();
  JCheckBox jCheckBox_pas = new JCheckBox();
  JLabel jLabel_pwd = new JLabel();
  JTextField jTextField_pwd = new JPasswordField();
  JLabel jLabel_ref = new JLabel();
  JButton jButton_RegCand = new JButton();
  JButton jButton_RegPAS = new JButton();
  JButton jButton_Cancel = new JButton();
  
  public CRegisto(String title, boolean modal)
  {
    try {
      jbInit();
      close();
      pack();
    }
    catch (Exception ex) {
      ex.printStackTrace();
    }
  }
  



  public void close()
  {
    if (CBData.reg_C.equals("")) { return;
    }
    jTextField_nif.setText(CBData.reg_nif);
    jTextField_nif.setEditable(false);
    jTextField_nif.setFocusable(false);
    
    jCheckBox_nif.setEnabled(false);
    
    jCheckBox_nif.setSelected(true);
    

    jCheckBox_pas.setSelected(CBData.reg_pas.equals("1"));
    
    if (CBData.reg_pas.equals("0")) {
      jCheckBox_pas.setEnabled(true);
      jTextField_pwd.setEditable(true);
      jTextField_pwd.setFocusable(true);
      jButton_RegPAS.setVisible(true);
    } else {
      jCheckBox_pas.setEnabled(false);
      jTextField_pwd.setVisible(false);
      jLabel_pwd.setVisible(false);
      jButton_RegPAS.setVisible(false);
    }
    
    jLabel_ref.setText("Refª: " + CBData.reg_C);
    jLabel_ref.setVisible(true);
    
    jButton_RegCand.setVisible(false);
    jButton_Cancel.setText("Fechar");
  }
  
  private void jbInit() throws Exception {
    getContentPane().setLayout(null);
    
    jPanel1.setBorder(fmeComum.blocoBorder);
    jPanel1.setBounds(new Rectangle(10, 11, 414, 297));
    jPanel1.setLayout(null);
    
    jLabel_titulo.setFont(fmeComum.letra_bold);
    jLabel_titulo.setText("REGISTO DA CANDIDATURA");
    jLabel_titulo.setBounds(new Rectangle(12, 7, 290, 21));
    
    jLabel_logo.setText("");
    jLabel_logo.setBounds(new Rectangle(303, 1, 100, 49));
    jLabel_logo.setHorizontalAlignment(4);
    jLabel_logo.setIcon(new ImageIcon(fmeFrame.class.getResource("Portugal2020-2.gif")));
    
    jLabel_nif.setBounds(new Rectangle(32, 50, 150, 15));
    jLabel_nif.setFont(fmeComum.letra_bold);
    jLabel_nif.setText("NIF do Promotor");
    
    jTextField_nif.setText("");
    jTextField_nif.setBounds(new Rectangle(30, 65, 90, 19));
    

    jCheckBox_nif.setFont(fmeComum.letra);
    jCheckBox_nif.setForeground(Color.RED);
    jCheckBox_nif.setBackground(Color.white);
    jCheckBox_nif.setBounds(new Rectangle(13, 90, 20, 38));
    jCheckBox_nif.setVerticalTextPosition(1);
    
    jLabel_chk_nif.setText("<html>Tomei conhecimento de que o NIF do Promotor, indicado no campo acima, não pode ser alterado após o Registo da Candidatura<html>");
    jLabel_chk_nif.setBounds(new Rectangle(36, 97, 355, 38));
    




    jCheckBox_pas.setBounds(new Rectangle(13, 140, 20, 48));
    jCheckBox_pas.setVerticalTextPosition(1);
    jCheckBox_pas.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent e) {
        try {
          AbstractButton abstractButton = (AbstractButton)e.getSource();
          boolean selected = abstractButton.getModel().isSelected();
          
          jTextField_pwd.setEditable(selected);
          jTextField_pwd.setFocusable(selected);
          if (!selected) { jTextField_pwd.setText("");
          }
        }
        catch (Exception localException) {}
      }
    });
    jLabel_chk_pas.setText("<html><strong>Registar candidatura na PAS?</strong><br>(Esta operação só é possível se o NIF já estiver registado na PAS e exige a inserção da respetiva password)<html>");
    jLabel_chk_pas.setBounds(new Rectangle(36, 154, 355, 48));
    

    jLabel_pwd.setFont(fmeComum.letra);
    jLabel_pwd.setText("Password de acesso à PAS");
    jLabel_pwd.setBounds(new Rectangle(232, 195, 150, 15));
    
    jTextField_pwd.setBounds(new Rectangle(230, 210, 150, 19));
    jTextField_pwd.setText("");
    jTextField_pwd.setEditable(false);
    jTextField_pwd.setFocusable(false);
    
    jLabel_ref.setBounds(new Rectangle(12, 260, 200, 26));
    jLabel_ref.setForeground(new Color(114, 167, 16));
    jLabel_ref.setVisible(false);
    jLabel_ref.setHorizontalAlignment(0);
    jLabel_ref.setBorder(fmeComum.fieldBorder);
    
    jButton_RegCand.setBounds(new Rectangle(243, 260, 75, 26));
    jButton_RegCand.setText("Registar");
    jButton_RegCand.setFont(fmeComum.letra);
    jButton_RegCand.addActionListener(new CRegisto_jButton_RegCand_actionAdapter(this));
    
    jButton_RegPAS.setBounds(new Rectangle(223, 260, 95, 26));
    jButton_RegPAS.setText("Registar na PAS");
    jButton_RegPAS.setFont(fmeComum.letra);
    jButton_RegPAS.addActionListener(new CRegisto_jButton_RegPAS_actionAdapter(this));
    jButton_RegPAS.setVisible(false);
    
    jButton_Cancel.setBounds(new Rectangle(325, 260, 75, 26));
    jButton_Cancel.setMargin(new Insets(0, 0, 0, 0));
    jButton_Cancel.setFont(fmeComum.letra);
    jButton_Cancel.setText("Cancelar");
    jButton_Cancel.addActionListener(new CRegisto_jButton_Cancel_actionAdapter(this));
    
    getContentPane().add(jPanel1, null);
    
    jPanel1.add(jLabel_titulo, null);
    jPanel1.add(jLabel_logo, null);
    jPanel1.add(jLabel_nif, null);
    jPanel1.add(jTextField_nif, null);
    jPanel1.add(jCheckBox_nif, null);
    jPanel1.add(jLabel_chk_nif, null);
    jPanel1.add(jCheckBox_pas, null);
    jPanel1.add(jLabel_chk_pas, null);
    jPanel1.add(jLabel_pwd, null);
    jPanel1.add(jTextField_pwd, null);
    jPanel1.add(jLabel_ref, null);
    jPanel1.add(jButton_RegCand, null);
    jPanel1.add(jButton_RegPAS, null);
    jPanel1.add(jButton_Cancel, null);
    
    setModal(true);
    setResizable(false);
  }
  
  void jButton_RegCand_actionPerformed(ActionEvent e) {
    String nif = jTextField_nif.getText().trim();
    String pwd = jTextField_pwd.getText();
    if (nif.equals("")) {
      JOptionPane.showMessageDialog(null, "NIF do Promotor - campo de preenchimento obrigatório!", "Erro", 0);
      return;
    }
    if (!new CFType_Nif().setText(nif, false)) {
      JOptionPane.showMessageDialog(null, "NIF do Promotor inválido!", "Erro", 0);
      return;
    }
    if (!jCheckBox_nif.isSelected()) {
      JOptionPane.showMessageDialog(null, "Tomei conhecimento de que o NIF do Promotor, indicado no campo acima,\nnão pode ser alterado após o Registo da Candidatura\n- campo de preenchimento obrigatório!", "Erro", 0);
      return;
    }
    if ((jCheckBox_pas.isSelected()) && 
      (pwd.equals(""))) {
      JOptionPane.showMessageDialog(null, "Password de acesso à PAS - campo de preenchimento obrigatório!", "Erro", 0);
      return;
    }
    

    CHRegisto.registo(nif, jCheckBox_pas.isSelected(), pwd, null);
  }
  
  void jButton_RegPAS_actionPerformed(ActionEvent e)
  {
    String pwd = jTextField_pwd.getText();
    







    if (!jCheckBox_pas.isSelected()) {
      JOptionPane.showMessageDialog(null, "Registar candidatura na PAS? - campo de preenchimento obrigatório!", "Erro", 0);
      return;
    }
    
    if (pwd.equals("")) {
      JOptionPane.showMessageDialog(null, "Password de acesso à PAS - campo de preenchimento obrigatório!", "Erro", 0);
      return;
    }
    

    CHRegisto.registo(CBData.reg_nif, true, pwd, CBData.reg_C);
  }
  
  void jButton_Cancel_actionPerformed(ActionEvent e) {
    hide();
  }
}
