package fme;

import java.awt.Dimension;
import java.awt.Toolkit;
import java.net.URLEncoder;
import java.util.HashMap;
import javax.swing.JOptionPane;
import javax.swing.JTextField;








class CHRegisto
{
  static String proxyHost = null; static String proxyPort = null;
  static boolean proxySet = false;
  static CRegisto dlg;
  
  CHRegisto() {}
  
  static void ligacao() {
    dlg = new CRegisto("Registar candidatura...", true);
    
    String nif_prom = PromotorgetByName"nif"v;
    if (!nif_prom.equals("")) {
      dlgjTextField_nif.setText(nif_prom);
      dlgjTextField_nif.setEditable(false);
      dlgjTextField_nif.setFocusable(false);
    }
    
    dlg.setSize(new Dimension(440, 343));
    dlg.setLocation(getDefaultToolkitgetScreenSizewidth / 2 - dlggetSizewidth / 2, 
      getDefaultToolkitgetScreenSizeheight / 2 - dlggetSizeheight / 2);
    

    dlg.show();
    dlg = null;
  }
  
  static void registo(String nif, boolean pas, String pwd, String ref_cand)
  {
    try
    {
      System.setProperty("java.net.useSystemProxies", "true");
      
      String serv1 = fmeComum.atendedor + "atend.php?";
      serv1 = serv1 + "OP=REG-CAND";
      serv1 = serv1 + "&AVISO=" + CParseConfig.hconfig.get("aviso");
      serv1 = serv1 + "&CLASSE=" + CParseConfig.hconfig.get("extensao");
      serv1 = serv1 + "&VS=" + URLEncoder.encode(CBData.vs);
      if (ref_cand != null) {
        serv1 = serv1 + "&REFC=" + URLEncoder.encode(ref_cand);
      }
      String xml = "<?xml version='1.0' encoding='ISO-8859-1'?>";
      xml = xml + "<iRequest>\n";
      xml = xml + "<RegCand>\n";
      xml = xml + "<aviso>" + CParseConfig.hconfig.get("aviso") + "</aviso>";
      xml = xml + "<vs>" + URLEncoder.encode(CBData.vs) + "</vs>";
      xml = xml + "<nif>" + nif + "</nif>";
      xml = xml + "<pas>" + (pas ? "1" : "0") + "</pas>";
      xml = xml + "<pwd>" + pwd + "</pwd>";
      xml = xml + "</RegCand>\n";
      xml = xml + "</iRequest>\n";
      
      Http http = new Http(serv1);
      String msg = http.doPostRequest(xml);
      


      String ggp_stat = "";String ggp_ref = "";String ggp_msg = "";
      String[] tok = msg.split("###");
      for (int i = 0; i < tok.length; i++) {
        if (tok[i].startsWith("STAT=")) ggp_stat = tok[i].substring(5);
        if (tok[i].startsWith("REF=")) ggp_ref = tok[i].substring(4);
        if (tok[i].startsWith("MSG=")) ggp_msg = tok[i].substring(4);
      }
      ggp_stat = ggp_stat.replaceAll("\n", "");
      ggp_ref = ggp_ref.replaceAll("\n", "");
      
      String m = "";
      if (ggp_stat.equals("NOK")) {
        m = ggp_msg;
        JOptionPane.showMessageDialog(null, m, "Erro", 0);
      }
      else if (ggp_stat.equals("OK!")) {
        CBData.reg_nif = nif;
        CBData.reg_C = ggp_ref;
        CBData.reg_pas = pas ? "1" : "0";
        CBData.Promotor.getByName("nif").setStringValue(nif);
        
        fmeApp.comum.guardar(false, true, false, false, false);
        

        dlg.close();
        


        fmeApp.toolBar.check_registo();
        m = ggp_msg;
        JOptionPane.showMessageDialog(null, m, "Aviso", 1);
      }
      else {
        m = "Não foi possível verificar se a versão está atualizada!";
        JOptionPane.showMessageDialog(null, m, "Aviso", 2);
      }
      

    }
    catch (Exception e)
    {

      JOptionPane.showMessageDialog(null, "Erro na ligação (3): " + get_error(e.getMessage()));
    }
  }
  
  static String get_error(String e1)
  {
    String atend = "http://atendqren.compete-pofc.org";
    if (e1.contains(atend)) {
      int i = e1.indexOf(atend);
      e1 = e1.substring(0, i - 1);
    }
    return e1;
  }
}
