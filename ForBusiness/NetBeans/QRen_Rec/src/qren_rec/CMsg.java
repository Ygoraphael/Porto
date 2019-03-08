package fme;

import java.awt.Rectangle;
import javax.swing.JButton;
import javax.swing.JDialog;
import javax.swing.JLabel;
import javax.swing.JPanel;

public class CMsg extends JDialog
{
  String msg;
  JPanel panel1;
  JLabel jLabel_Msg;
  JButton jButton1;
  JLabel jLabel1;
  
  public CMsg(CEnvio frame, String title, boolean modal)
  {
    super(frame, title, modal);
  }
  
  public CMsg(CEnvio f, String _msg) {
    this(f, "", false);
    msg = _msg;
    try {
      jbInit();
    }
    catch (Exception ex) {
      ex.printStackTrace();
    }
  }
  
  private void jbInit() throws Exception {
    panel1 = new JPanel();
    jLabel_Msg = new JLabel();
    jButton1 = new JButton();
    jLabel1 = new JLabel();
    setTitle("Resultado do Envio de Ficheiro de Candidatura");
    
    panel1.setLayout(null);
    jLabel_Msg.setLocale(java.util.Locale.getDefault());
    jLabel_Msg.setBorder(null);
    jLabel_Msg.setHorizontalTextPosition(0);
    jLabel_Msg.setVerticalAlignment(1);
    jLabel_Msg.setVerticalTextPosition(1);
    jLabel_Msg.setBounds(new Rectangle(20, 20, 400, 280));
    
    jButton1.setBounds(new Rectangle(350, 310, 80, 25));
    jButton1.setText("Fechar");
    jButton1.setFont(fmeComum.letra);
    jButton1.addActionListener(new CMsg_jButton1_actionAdapter(this));
    jLabel1.setEnabled(false);
    jLabel1.setBorder(javax.swing.BorderFactory.createEtchedBorder());
    jLabel1.setText("");
    jLabel1.setBounds(new Rectangle(10, 10, 420, 290));
    getContentPane().add(panel1);
    jLabel_Msg.setText(msg);
    jLabel_Msg.setFont(fmeComum.letra);
    panel1.add(jLabel_Msg, null);
    panel1.add(jLabel1, null);
    panel1.add(jButton1, null);
    


    setModal(true);
    setResizable(false);
    pack();
  }
  
  void jButton1_actionPerformed(java.awt.event.ActionEvent e)
  {
    hide();
  }
}
