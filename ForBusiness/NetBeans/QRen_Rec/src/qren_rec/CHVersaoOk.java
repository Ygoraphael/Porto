package fme;

import java.awt.Dimension;
import java.awt.Toolkit;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.util.HashMap;
import java.util.Properties;
import javax.swing.JCheckBox;
import javax.swing.JOptionPane;
import javax.swing.JTextField;

class CHVersaoOk
{
  static String proxyHost = null; static String proxyPort = null;
  static boolean proxySet = false;
  static CVersaoOk dlg;
  
  CHVersaoOk() {}
  
  static void ligacao() { dlg = new CVersaoOk("Verificar versão...", true);
    
    dlg.setSize(new Dimension(440, 233));
    dlg.setLocation(getDefaultToolkitgetScreenSizewidth / 2 - dlggetSizewidth / 2, 
      getDefaultToolkitgetScreenSizeheight / 2 - dlggetSizeheight / 2);
    
    Properties systemSettings = System.getProperties();
    proxyHost = (String)systemSettings.get("proxyHost");
    proxyPort = (String)systemSettings.get("proxyPort");
    proxySet = proxyHost != null;
    if ((proxySet) && (proxyPort == null)) { proxyPort = "80";
    }
    
    String file_proxy = "";
    String file_porta = "";
    String file_autom = "";
    try {
      BufferedReader in = new BufferedReader(new java.io.FileReader(fmeComum.userDir + "\\qrenvs"));
      String str;
      while ((str = in.readLine()) != null) { String str;
        if (str.startsWith("###proxy=")) file_proxy = str.substring(9);
        if (str.startsWith("###porta=")) file_porta = str.substring(9);
        if (str.startsWith("###automatico=")) file_autom = str.substring(14);
      }
      in.close();
      
      if (file_proxy.length() > 0) {
        dlgjTextField_proxy.setText(file_proxy);
      } else {
        dlgjTextField_proxy.setText(proxyHost);
      }
      if (file_porta.length() > 0) {
        dlgjTextField_porta.setText(file_porta);
      } else {
        dlgjTextField_porta.setText(proxyPort);
      }
      if (file_autom.length() > 0) {
        if (file_autom.equals("1")) {
          dlgjCheckBox_Proxy1.setSelected(true);
        } else if (file_autom.equals("0")) {
          dlgjCheckBox_Proxy1.setSelected(false);
        }
      } else {
        dlgjCheckBox_Proxy.setSelected(proxySet);
      }
    }
    catch (IOException e) {
      dlgjCheckBox_Proxy1.setSelected(true);
    }
    



    dlgjCheckBox_Proxy.setSelected(proxySet);
    
    dlg.show();
    dlg = null;
  }
  






  static void internet()
  {
    try
    {
      System.setProperty("java.net.useSystemProxies", "true");
      









































































      String name = fmeComum.atendedor + "atend.php?";
      name = name + "OP=VS";
      name = name + "&AVISO=" + CParseConfig.hconfig.get("aviso");
      name = name + "&CLASSE=" + CParseConfig.hconfig.get("extensao");
      name = name + "&VS=" + java.net.URLEncoder.encode(CBData.vs);
      
      URL url = new URL(name);
      URLConnection conn = url.openConnection();
      
      String msg = "";
      BufferedReader r = new BufferedReader(new java.io.InputStreamReader(conn.getInputStream()));
      String s; while ((s = r.readLine()) != null) { String s;
        msg = msg + s + "\n"; }
      r.close();
      


      String ggp_stat = "";String ggp_vs = "";String ggp_msg = "";
      String[] tok = msg.split("###");
      for (int i = 0; i < tok.length; i++) {
        if (tok[i].startsWith("STAT=")) ggp_stat = tok[i].substring(5);
        if (tok[i].startsWith("VS=")) ggp_vs = tok[i].substring(3);
        if (tok[i].startsWith("MSG=")) ggp_msg = tok[i].substring(4);
      }
      ggp_stat = ggp_stat.replaceAll("\n", "");
      ggp_vs = ggp_vs.replaceAll("\n", "");
      
      String m = "";
      if (ggp_stat.equals("NOK")) {
        m = ggp_msg;
        JOptionPane.showMessageDialog(null, m, "Erro", 0);
      }
      else if (ggp_stat.equals("OK!")) {
        m = ggp_msg;
        JOptionPane.showMessageDialog(null, m, "Aviso", 1);




      }
      else
      {




        m = "Não foi possível verificar se a versão está atualizada!";
        JOptionPane.showMessageDialog(null, m, "Aviso", 2);
      }
      try
      {
        BufferedWriter out = new BufferedWriter(new java.io.FileWriter(fmeComum.userDir + "\\qrenvs"));
        if (ggp_stat.equals("OK!")) {
          out.write("###proxy=" + dlgjTextField_proxy.getText() + "\n");
          out.write("###porta=" + dlgjTextField_porta.getText() + "\n");
        }
        
        if (dlgjCheckBox_Proxy1.isSelected()) {
          out.write("###automatico=1");
        } else
          out.write("###automatico=0");
        out.close();
      }
      catch (IOException localIOException1) {}
      











      return;
    }
    catch (MalformedURLException e)
    {
      JOptionPane.showMessageDialog(null, "Erro na ligação (1): " + get_error(e.getMessage()));
    } catch (IOException e) {
      JOptionPane.showMessageDialog(null, "Erro na ligação (2): " + get_error(e.getMessage()));
    } catch (Exception e) {
      JOptionPane.showMessageDialog(null, "Erro na ligação (3): " + get_error(e.getMessage()));
    }
  }
  
  static String get_error(String e1)
  {
    String atend = fmeComum.atendedor;
    if (e1.contains(atend)) {
      int i = e1.indexOf(atend);
      e1 = e1.substring(0, i - 1);
    }
    return e1;
  }
}
