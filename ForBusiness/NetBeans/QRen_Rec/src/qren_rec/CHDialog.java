package fme;

import java.awt.Color;
import java.awt.Dimension;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.WindowEvent;
import javax.swing.JButton;
import javax.swing.JDialog;
import javax.swing.JEditorPane;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;
import javax.swing.border.LineBorder;














class CHDialog
  extends JDialog
{
  JPanel contentPane;
  JButton cmdCancelar;
  JButton cmdSair;
  JButton cmdConfirmar;
  public String form;
  public String campo;
  public int row;
  public int col;
  public boolean global;
  JScrollPane scrollPane = new JScrollPane();
  JPanel pnlMails = new JPanel();
  JLabel lblAlerta = new JLabel();
  
  JLabel lblMails = new JLabel();
  JTextArea jTextArea_Mails = new JTextArea();
  JEditorPane jEditorPane_Mails = new JEditorPane();
  int nodes_total = 0;
  JPanel pnl = new JPanel();
  
  String cmd = "";
  
  public CHDialog() {
    try {
      jbInit();
      pack();
    }
    catch (Exception ex) {
      ex.printStackTrace();
    }
  }
  
  private void jbInit() throws Exception {
    JPanel contentPane = (JPanel)getContentPane();
    contentPane.setLayout(null);
    form = null;
    campo = null;
    
    cmdCancelar = new JButton();
    cmdSair = new JButton();
    cmdConfirmar = new JButton();
    
    cmdCancelar.setText("Cancelar");
    cmdCancelar.setBounds(new Rectangle(390, 120, 80, 25));
    cmdCancelar.addActionListener(new CHDialog_jButton_Cancelar_actionAdapter(this));
    cmdCancelar.setMargin(new Insets(1, 1, 1, 1));
    


    cmdSair.setText("Seguinte");
    cmdSair.setBounds(new Rectangle(477, 120, 80, 25));
    cmdSair.addActionListener(new CHDialog_jButton_Close_actionAdapter(this));
    

    scrollPane.setBounds(new Rectangle(4, 4, 562, 280));
    
    String mailContacto = "";
    if (ContactogetByName"contacto"v.equals("S")) {
      mailContacto = "E-mail de Contacto do Promotor para efeitos do projeto:\n    " + ContactogetByName"email"v + "\n\n";
    }
    String txtMails = "Após a conclusão com êxito do processo de exportação será remetida uma chave/referência provisória de confirmação da receção da candidatura para o(s) seguinte(s) endereço(s) de correio eletrónico:\n\nE-mail de Identificação do Promotor:\n    " + 
    
      PromotorgetByName"email"v + "\n\n" + 
      mailContacto + 
      "E-mail do Responsável Técnico pelo Projeto:\n" + 
      "    " + ResponsavelgetByName"email"v + "\n\n" + 
      "\n\n" + 
      "No ecrã seguinte deverá Guardar a versão final do ficheiro, a fim de prosseguir para a finalização do processo de exportação de candidatura.";
    
    String txtAlerta = "<html>Para submissão da candidatura deve concluir o processo de exportação.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;Clique em Seguinte para avançar no processo de exportação.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;Clique em Cancelar apenas se desejar anular o processo de exportação.<br>A candidatura apenas será aceite após conclusão do processo de exportação. A conclusão do processo de exportação após encerramento do concurso não é da responsabilidade da(s) Autoridade(s) de Gestão envolvida(s), inviabilizando a aceitação da candidatura.</html>";
    

















    lblAlerta.setBounds(new Rectangle(5, 13, 550, 100));
    lblAlerta.setText(txtAlerta);
    
    pnlMails.setAlignmentY(0.0F);
    pnlMails.setLayout(null);
    pnlMails.setBounds(new Rectangle(4, 4, 562, 370));
    
    pnlMails.setBorder(new LineBorder(new Color(227, 0, 0)));
    


    jTextArea_Mails.setFont(fmeComum.letra);
    jTextArea_Mails.setText(txtMails);
    jTextArea_Mails.setLineWrap(true);
    jTextArea_Mails.setWrapStyleWord(true);
    jTextArea_Mails.setMargin(new Insets(5, 5, 5, 5));
    jTextArea_Mails.setEditable(false);
    jTextArea_Mails.setOpaque(true);
    








    scrollPane.setViewportView(jTextArea_Mails);
    scrollPane.setBorder(fmeComum.blocoBorder);
    

    scrollPane.setVerticalScrollBarPolicy(20);
    scrollPane.setHorizontalScrollBarPolicy(31);
    contentPane.add(scrollPane, "North");
    contentPane.add(pnl, "South");
    pnl.setLayout(null);
    pnl.setBounds(new Rectangle(5, 275, 560, 150));
    pnl.add(lblAlerta, null);
    pnl.add(cmdCancelar, null);
    pnl.add(cmdSair, null);
    
    setTitle("Validações - Endereço(s) de correio eletrónico para confirmação de submissão");
    setModal(true);
    setResizable(false);
    setSize(575, 455);
    setLocation(getDefaultToolkitgetScreenSizewidth / 2 - 
      getSizewidth / 2, 
      getDefaultToolkitgetScreenSizeheight / 2 - 
      getSizeheight / 2);
    setVisible(true);
  }
  
  void jButton_Close_actionPerformed(ActionEvent e) {
    cmd = "X";
    hide();
  }
  
  void jButton_Cancelar_actionPerformed(ActionEvent e) {
    cmd = "G";
    hide();
    fmeFrame.cancelar_send();
  }
  
  protected void processWindowEvent(WindowEvent e) { if (e.getID() == 201) {
      jButton_Cancelar_actionPerformed(null);
    }
  }
}
