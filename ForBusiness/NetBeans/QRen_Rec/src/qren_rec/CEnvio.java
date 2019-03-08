package fme;

import java.awt.Color;
import java.awt.Container;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import java.awt.event.WindowEvent;
import javax.swing.BorderFactory;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JDialog;
import javax.swing.JLabel;
import javax.swing.JPanel;
















































































































































































































































class CEnvio
  extends JDialog
{
  JPanel panel1 = new JPanel();
  JPanel jPanel0 = new JPanel();
  JLabel jLabel0 = new JLabel();
  JPanel jPanel1 = new JPanel();
  JLabel jLabel1 = new JLabel();
  







  JButton jButton_Post = new JButton();
  
  JButton jButton_Cancel = new JButton();
  JLabel jLabel_T = new JLabel();
  JLabel jLabel_Exportada = new JLabel();
  






  ImageIcon apagarLinha = new ImageIcon(fmeFrame.class.getResource("apagarlinha.gif"));
  
  public CEnvio(String title, boolean modal)
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
    
    String txt = "<html>A submissão da candidatura só será considerada após receção no servidor de receção de candidaturas.<br>Para finalizar o processo clique em Enviar Candidatura.<br>Clique em Cancelar apenas se desejar anular o processo de exportação.<br>A candidatura apenas será aceite após conclusão do processo de exportação. A conclusão do processo de exportação após encerramento do concurso não é da responsabilidade da(s) Autoridade(s) de Gestão envolvida(s), inviabilizando a aceitação da candidatura.</html>";
    







    jLabel0.setText(txt);
    jLabel0.setBounds(new Rectangle(15, 10, 505, 100));
    jLabel0.setFont(fmeComum.letra);
    


    jPanel0.setBorder(BorderFactory.createEtchedBorder());
    jPanel0.setBounds(new Rectangle(16, 20, 528, 120));
    jPanel0.setLayout(null);
    jPanel0.add(jLabel0, null);
    
    jPanel1.setBorder(BorderFactory.createEtchedBorder());
    jPanel1.setBounds(new Rectangle(16, 150, 528, 150));
    jPanel1.setLayout(null);
    
    jLabel1.setText("Envio da Candidatura");
    jLabel1.setBounds(new Rectangle(18, 18, 276, 15));
    jLabel1.setFont(fmeComum.letra_titulo);
    


















    jButton_Post.setFont(fmeComum.letra);
    jButton_Post.setBounds(new Rectangle(335, 104, 175, 28));
    jButton_Post.setText("Enviar Candidatura");
    jButton_Post.addActionListener(new CEnvio_jButton_Post_actionAdapter(this));
    
    jButton_Cancel.setFont(fmeComum.letra);
    jButton_Cancel.setBounds(new Rectangle(464, 310, 80, 26));
    jButton_Cancel.setText("Cancelar");
    jButton_Cancel.addActionListener(new CEnvio_jButton_Cancel_actionAdapter(this));
    jLabel_T.setBounds(new Rectangle(335, 60, 175, 20));
    jLabel_T.setHorizontalAlignment(0);
    jLabel_T.setOpaque(true);
    jLabel_T.setBorder(null);
    jLabel_T.setForeground(Color.white);
    jLabel_T.setFont(fmeComum.letra_bold);
    jLabel_T.setBackground(Color.red);
    jLabel_Exportada.setFont(fmeComum.letra_bold);
    jLabel_Exportada.setHorizontalAlignment(0);
    jLabel_Exportada.setText("Candidatura Exportada");
    jLabel_Exportada.setBounds(new Rectangle(335, 40, 175, 15));
    getContentPane().add(panel1, null);
    
    jPanel1.add(jButton_Post, null);
    

    jPanel1.add(jLabel_T, null);
    jPanel1.add(jLabel_Exportada, null);
    


    jPanel1.add(jLabel1, null);
    getContentPane().add(jButton_Cancel, null);
    getContentPane().add(jPanel0, null);
    getContentPane().add(jPanel1, null);
    
    setModal(true);
    setResizable(false);
  }
  



  void jButton_Post_actionPerformed(ActionEvent e) {}
  



  void jButton_Cancel_actionPerformed(ActionEvent e)
  {
    hide();
    if ((!CBData.exportado.equals("2")) && (!CHEnvio.sent_ok))
      fmeFrame.cancelar_send();
  }
  
  protected void processWindowEvent(WindowEvent e) {
    if (e.getID() == 201) {
      jButton_Cancel_actionPerformed(null);
    }
  }
}
