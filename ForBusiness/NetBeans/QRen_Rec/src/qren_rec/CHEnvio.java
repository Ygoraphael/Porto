package fme;

import java.awt.Dimension;
import java.awt.Toolkit;
import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;
import java.util.HashMap;
import java.util.Properties;
import javax.swing.JLabel;
import javax.swing.JOptionPane;

class CHEnvio
{
  static String proxyHost = null; static String proxyPort = null;
  static boolean proxySet = false;
  
  static boolean sent_ok = false;
  
  CHEnvio() {}
  
  static void envio(boolean sent) { dlg = new CEnvio("Exportar Candidatura", true);
    
    if (sent) dlgjLabel0.setText("Esta candidatura já foi exportada.");
    dlg.setSize(new Dimension(565, 385));
    dlg.setLocation(getDefaultToolkitgetScreenSizewidth / 2 - dlggetSizewidth / 2, 
      getDefaultToolkitgetScreenSizeheight / 2 - dlggetSizeheight / 2);
    
    Properties systemSettings = System.getProperties();
    proxyHost = (String)systemSettings.get("proxyHost");
    proxyPort = (String)systemSettings.get("proxyPort");
    proxySet = proxyHost != null;
    if ((proxySet) && (proxyPort == null)) { proxyPort = "80";
    }
    



    _show_envio();
    
    dlg.show();
    dlg = null;
  }
  


  static void internet()
  {
    System.setProperty("java.net.useSystemProxies", "true");
    























    try
    {
      File f_zip = new File(CBData.LastFile.getCanonicalPath());
      
      String name = fmeComum.atendedor + "atend.php?";
      name = name + "OP=SUBMIT";
      name = name + "&AVISO=" + CParseConfig.hconfig.get("aviso");
      name = name + "&CLASSE=" + CParseConfig.hconfig.get("extensao");
      name = name + "&VS=" + URLEncoder.encode(CBData.vs);
      name = name + "&FILE=" + URLEncoder.encode(f_zip.getName());
      name = name + "&REFC=" + URLEncoder.encode(CBData.reg_C);
      






      URL url = new URL(name);
      URLConnection conn = url.openConnection();
      conn.setDoOutput(true);
      
      byte[] data = new byte['ࠀ'];
      BufferedInputStream in = new BufferedInputStream(new java.io.DataInputStream(new java.io.FileInputStream(f_zip)));
      BufferedOutputStream out = new BufferedOutputStream(new java.io.DataOutputStream(conn.getOutputStream()));
      while (in.read(data) != -1)
        out.write(data);
      in.close();
      out.close();
      
      String msg = "";
      BufferedReader r = new BufferedReader(new java.io.InputStreamReader(conn.getInputStream()));
      String s; while ((s = r.readLine()) != null) { String s;
        msg = msg + s + "\n"; }
      r.close();
      


      String ggp_stat = "";String ggp_msg = "";String ggp_t = "";String ggp_time = "";
      String[] tok = msg.split("###");
      for (int i = 0; i < tok.length; i++) {
        if (tok[i].startsWith("STAT=")) ggp_stat = tok[i].substring(5);
        if (tok[i].startsWith("REF=")) ggp_t = tok[i].substring(4);
        if (tok[i].startsWith("MSG=")) ggp_msg = tok[i].substring(4);
        if (tok[i].startsWith("TIME=")) ggp_time = tok[i].substring(5);
      }
      ggp_stat = ggp_stat.replaceAll("\n", "");
      ggp_t = ggp_t.replaceAll("\n", "");
      
      msg = _make_msg(ggp_stat, ggp_t, ggp_msg, ggp_time);
      
      CMsg m = new CMsg(dlg, msg);
      m.setSize(new Dimension(445, 370));
      m.setLocation(getDefaultToolkitgetScreenSizewidth / 2 - getSizewidth / 2, 
        getDefaultToolkitgetScreenSizeheight / 2 - getSizeheight / 2);
      m.show();
      
      if (ggp_stat.equals("OK!")) {
        CBData.exportado = "2";
        CBData.T = ggp_t;
        _show_envio();
        dlgjLabel0.setText("A sua candidatura foi enviada com sucesso.");
        dlgjButton_Cancel.setText("Fechar");
        fmeApp.comum.guardar(false, true, false, false, false);
        fmeApp.toolBar.check_registo();
        fmeApp.toolBar.setPopupOpt();
      }
      sent_ok = true;
    } catch (MalformedURLException e) {
      JOptionPane.showMessageDialog(null, "Erro na ligação (1): " + get_error(e.getMessage()));
    } catch (IOException e) {
      JOptionPane.showMessageDialog(null, "Erro na ligação (2): " + get_error(e.getMessage()));
    } catch (Exception e) {
      JOptionPane.showMessageDialog(null, "Erro na ligação (3): " + get_error(e.getMessage()));
    }
  }
  
  static String get_error(String e1) {
    String atend = "http://atendqren.compete-pofc.org";
    if (e1.contains(atend)) {
      int i = e1.indexOf(atend);
      e1 = e1.substring(0, i - 1);
    }
    return e1;
  }
  
  static String _make_msg(String ggp_stat, String ggp_T, String ggp_msg, String ggp_time)
  {
    String msg = "<html>";
    msg = msg + "<table width='400' border='0' cellspacing='0' cellpadding='0'>";
    
    if (!ggp_stat.equals("OK!")) {
      msg = msg + "<tr><td align='center'><font color=red size=3><strong>O ficheiro não foi exportado!</strong></font><br><br></td></tr>";
    }
    else {
      msg = msg + "<tr><td align='center'><font color=green size=3><strong>O ficheiro foi exportado com sucesso!</strong></font><br><br></td></tr>";
      msg = msg + "<tr><td>O seu ficheiro de candidatura foi aceite e recebeu a referência provisória:<br><br></td></tr>";
      msg = msg + "<tr><td align='center'><font size=3><strong>" + ggp_T + "</strong></font><br><br></td></tr>";
    }
    msg = msg + "<tr><td><strong>Observações:</strong> <br><br>";
    ggp_msg = ggp_msg.replaceAll("\n", "<br>");
    msg = msg + ggp_msg;
    
    if (ggp_stat.equals("OK!")) {
      msg = msg + "<br>Ficheiro de candidatura recebido em " + ggp_time.trim() + ".";
      msg = msg + "<br><br>Será enviado um e-mail de confirmação da submissão da candidatura para os seguintes endereços de correio eletrónico: ";
      msg = msg + PromotorgetByName"email"v;
      if (ContactogetByName"contacto"v.equals("S"))
        msg = msg + ", " + ContactogetByName"email"v;
      msg = msg + " e " + ResponsavelgetByName"email"v + ".";
    }
    msg = msg + "</td></tr>";
    msg = msg + "</table>";
    msg = msg + "</html>";
    return msg;
  }
  

  static CEnvio dlg;
  
  static fmeFrame f;
  static void _show_envio()
  {
    dlgjLabel_Exportada.setVisible(false);
    dlgjLabel_T.setVisible(false);
    
    if (CBData.exportado.equals("2"))
    {


      dlgjLabel_Exportada.setVisible(true);
      dlgjLabel_T.setVisible(true);
      dlgjLabel_T.setText(CBData.T);
      dlgjButton_Post.setEnabled(false);
    }
  }
}
