package fme;

import javax.swing.JLabel;
import javax.swing.JPanel;

public class fmeAcerca extends javax.swing.JDialog
{
  private JPanel jPanel1;
  private JLabel lblStatusText;
  private JLabel lblTitulo;
  private JLabel jLabel_PT2020;
  private JLabel jLabel_UE;
  private JLabel jLabel_Txt;
  private JLabel lblUE;
  JLabel jLabel_SIDER;
  
  public fmeAcerca()
  {
    try
    {
      jbInit();
    }
    catch (Exception e) {
      e.printStackTrace();
    }
  }
  
  private void jbInit() throws Exception {
    jPanel1 = new JPanel();
    lblStatusText = new JLabel();
    lblTitulo = new JLabel();
    lblUE = new JLabel();
    jLabel_PT2020 = new Label2020();
    jLabel_UE = new JLabel();
    jLabel_Txt = new JLabel();
    jLabel_SIDER = new JLabel();
    getContentPane().setLayout(null);
    
    jPanel1.setBackground(java.awt.Color.white);
    jPanel1.setBounds(new java.awt.Rectangle(2, 4, 350, 348));
    jPanel1.setLayout(null);
    jPanel1.setBackground(java.awt.Color.white);
    jPanel1.setBorder(null);
    setSize(new java.awt.Dimension(360, 390));
    setTitle("Acerca do Formulário");
    setLocation(getDefaultToolkitgetScreenSizewidth / 2 - 
      getSizewidth / 2, 
      getDefaultToolkitgetScreenSizeheight / 2 - 
      getSizeheight / 2);
    jLabel_PT2020.setHorizontalAlignment(0);
    jLabel_PT2020.setVerticalAlignment(3);
    jLabel_PT2020.setBounds(new java.awt.Rectangle(195, 287, 145, 54));
    jLabel_PT2020.setFont(fmeComum.letra_bold);
    jLabel_PT2020.setIcon(fmeComum.logoAcerca);
    jLabel_UE.setHorizontalAlignment(2);
    jLabel_UE.setBounds(new java.awt.Rectangle(7, 287, 194, 54));
    jLabel_UE.setFont(fmeComum.letra_bold);
    jLabel_UE.setVerticalAlignment(3);
    jLabel_UE.setIcon(fmeComum.logoUE);
    
    String aviso_s = (String)CParseConfig.hconfig.get("aviso_d");
    aviso_s = aviso_s.replace("\\n", "<br>");
    
    String msg = "";
    msg = msg + "<html>";
    msg = msg + "<div align='center' >";
    msg = msg + "<strong><font size=3>Formulário Eletrónico de Candidatura</font>";
    msg = msg + "<br><font size=3>&nbsp;</font>";
    msg = msg + "<br><font size=4>" + aviso_s + "</font>";
    msg = msg + "<br><br><font size=3>" + (String)CParseConfig.hconfig.get("tipologia") + "</font></strong>";
    msg = msg + "<br><br>";
    msg = msg + "Versão " + CBData.vs;
    msg = msg + "<br><br>";
    msg = msg + "Java V.M.: " + System.getProperty("java.vm.version");
    msg = msg + "<br><br>";
    msg = msg + "COMPETE 2020 ©   2015";
    msg = msg + "</div>";
    msg = msg + "</html>";
    
    lblStatusText.setHorizontalAlignment(0);
    lblStatusText.setBounds(new java.awt.Rectangle(39, 31, 244, 18));
    lblStatusText.setVisible(false);
    
    jLabel_Txt.setBounds(new java.awt.Rectangle(6, 6, 339, 276));
    jLabel_Txt.setHorizontalTextPosition(0);
    jLabel_Txt.setHorizontalAlignment(0);
    jLabel_Txt.setFont(fmeComum.letra);
    jLabel_Txt.setText(msg);
    jLabel_SIDER.setFont(fmeComum.letra_bold);
    jLabel_SIDER.setBounds(new java.awt.Rectangle(5, 0, 343, 112));
    jLabel_SIDER.setHorizontalAlignment(0);
    jPanel1.add(lblStatusText, null);
    jPanel1.add(jLabel_Txt, null);
    jPanel1.add(jLabel_SIDER, null);
    jPanel1.add(jLabel_PT2020, null);
    jPanel1.add(jLabel_UE, null);
    getContentPane().add(jPanel1, null);
    setModal(true);
    setVisible(true);
  }
}
