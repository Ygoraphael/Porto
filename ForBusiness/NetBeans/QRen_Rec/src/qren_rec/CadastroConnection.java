package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.Rectangle;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.PrintStream;
import java.io.StringReader;
import java.io.StringWriter;
import java.util.HashMap;
import java.util.Vector;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JDialog;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPasswordField;
import javax.swing.JTextField;
import javax.swing.UIManager;
import javax.swing.border.LineBorder;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import javax.xml.xpath.XPath;
import javax.xml.xpath.XPathConstants;
import javax.xml.xpath.XPathFactory;
import org.w3c.dom.Document;
import org.w3c.dom.NodeList;
import org.xml.sax.InputSource;









class CadastroConnection
  extends JDialog
{
  public static final String serverURL = fmeComum.atend_pas + "acesso/formulario/atend-import.php";
  




  private JTextField jText_nif = null;
  private JTextField jText_pwd = null;
  
  private JButton jButton_go = null;
  private JButton jButton_in = null;
  
  private JLabel jText_help = null;
  
  private Document doc = null;
  private static final String green_check = "<span style='color:green'>&#160;&#160;&#160;&#10004;&#160;&#160;</span>";
  private static final long serialVersionUID = 1L;
  
  CadastroConnection() { setModal(true);
    setSize(494, 390);
    setResizable(false);
    setTitle("Importar dados da PAS - Plataforma de Acesso Simplificado");
    
    JLabel jlbl_logo = new JLabel(new ImageIcon(fmeFrame.class.getResource("pas_logo.png")));
    jlbl_logo.setBounds(new Rectangle(250, 10, 216, 90));
    









    JLabel jlbl_nif = new JLabel("NIF:");
    jlbl_nif.setHorizontalAlignment(4);
    jlbl_nif.setBounds(new Rectangle(0, 25, 66, 18));
    
    jText_nif = new JTextField();
    
    jText_nif.setBounds(new Rectangle(70, 25, 140, 18));
    if ((!CBData.reg_C.equals("")) && (!CBData.reg_nif.equals(""))) {
      jText_nif.setText(CBData.reg_nif);
      jText_nif.setEditable(false);
      jText_nif.setFocusable(false);
    }
    JLabel jlbl_pwd = new JLabel("Password:");
    jlbl_pwd.setHorizontalAlignment(4);
    jlbl_pwd.setBounds(new Rectangle(0, 55, 66, 18));
    
    jText_pwd = new JPasswordField();
    
    jText_pwd.setBounds(new Rectangle(70, 55, 140, 18));
    
    jText_help = new JLabel();
    jText_help.setBackground((Color)UIManager.get("TextField.disabledBackground"));
    jText_help.setForeground((Color)UIManager.get("TextField.disabledForeground"));
    jText_help.setBorder(new LineBorder(new Color(200, 200, 200)));
    jText_help.setBounds(new Rectangle(15, 130, 460, 218));
    jText_help.setHorizontalAlignment(2);
    jText_help.setVerticalAlignment(1);
    
    jButton_go = new JButton("Login");
    jButton_go.setBounds(new Rectangle(90, 90, 100, 24));
    jButton_go.addActionListener(new ActionListener() {
      public void actionPerformed(ActionEvent e) {
        CadastroConnection.this.enable_face(false);
        new CadastroConnection.do_connect(CadastroConnection.this, null).start();
      }
      
    });
    jButton_in = new JButton("Importar");
    jButton_in.setBounds(new Rectangle(70, 90, 140, 24));
    jButton_in.addActionListener(new ActionListener()
    {
      public void actionPerformed(ActionEvent v) {
        Object[] options = { "   Sim   ", "   Não   " };
        if (JOptionPane.showOptionDialog(null, 
          "A informação importada irá sobrepor qualquer informação existente.\n\nQuer continuar?", 
          "Importar", 0, 3, 
          null, options, options[1]) != 0)
        {
          return;
        }
        try
        {
          CBData.__garbage_stop_editing();
          XPath xp = XPathFactory.newInstance().newXPath();
          for (XMLParser.xml_tag_handler th : cbxml_dh.tlist) {
            if (((handler instanceof CBTabela)) && 
              (xp.evaluate(path, doc, XPathConstants.NODE) != null)) {
              CBTabela cbt = (CBTabela)handler;
              if ((handler instanceof CHTabQuadro))
              {
                for (int n = 0; n < cols.length; n++) {
                  if ((cols[n].editable) && (xp.evaluate(path + "/Reg/" + 
                    cols[n].col_tag, doc, XPathConstants.NODE) != null)) {
                    for (int i = 0; i < dados.size(); i++) {
                      ((String[])dados.elementAt(i))[n] = "";
                    }
                  }
                }
              } else if ((handler instanceof CHTabela)) {
                cbt.Clear();
              }
            }
          }
          
          CBData.import_pas = true;
          DOMSource source = new DOMSource(doc);
          StringWriter xmlWriter = new StringWriter();
          StreamResult result = new StreamResult(xmlWriter);
          TransformerFactory.newInstance().newTransformer().transform(source, result);
          InputSource input = new InputSource(new StringReader(xmlWriter.toString()));
          SAXParserFactory.newInstance().newSAXParser().parse(input, new CParse());
          
          dispose();
          CBData.import_pas = false;
        } catch (Exception e) {
          e.printStackTrace();
          jText_help.setText(CadastroConnection.this.html("Não foi possível importar da Plataforma de Acesso Simplificado:\n\n" + e.getLocalizedMessage()));
        }
        
      }
    });
    setLayout(null);
    add(jlbl_logo);
    add(jlbl_nif);
    add(jlbl_pwd);
    add(jText_nif);
    add(jText_pwd);
    add(jButton_go);
    add(jButton_in);
    add(jText_help);
  }
  

  public void showDialog(Component parent)
  {
    if ((!CBData.reg_C.equals("")) && (CBData.reg_pas.equals("1"))) {
      enable_face(false);
      System.out.println("connect");
      new do_connect(null).start();
    }
    
    if (parent != null) {
      setLocation(getDefaultToolkitgetScreenSizewidth / 2 - getSizewidth / 2, 
        getDefaultToolkitgetScreenSizeheight / 2 - getSizeheight / 2);
    }
    
    jText_help.setText(html(
      "Bem-vindo à funcionalidade de importação de dados a partir do seu perfil registado na PAS.\n\nCaso ainda não tenha efetuado o registo na PAS, poderá fazê-lo clicando no logo acima.\n\n\nPara importar os seus dados deverá colocar o seu NIF e a Password de acesso utilizada na PAS, premindo de seguida na tecla “Login”."));
    


    jButton_go.setVisible(true);
    jButton_in.setVisible(false);
    setModal(true);
    setVisible(true);
    enable_face(true);
  }
  
  private void enable_face(boolean e) {
    if ((!CBData.reg_C.equals("")) && (!CBData.reg_nif.equals(""))) {
      jText_nif.setText(CBData.reg_nif);
      jText_nif.setEditable(false);
      jText_nif.setFocusable(false);
    } else {
      jText_nif.setEditable(e);
      jText_nif.setFocusable(e);
    }
    jText_pwd.setEditable(e);
    jText_pwd.setFocusable(e);
    jButton_go.setEnabled(e);
    revalidate();
    repaint();
  }
  

  private String html(String txt) { return "<html><div style='padding:6px'>" + txt.replaceAll("\\n", "<br>") + "</div></html>"; }
  
  private class do_connect extends Thread {
    private do_connect() {}
    
    public void run() {
      try { System.setProperty("java.net.useSystemProxies", "true");
        String nif = jText_nif.getText();
        String pwd = jText_pwd.getText();
        



        String xml = "<?xml version='1.0' encoding='ISO-8859-1'?>";
        xml = xml + "<iRequest>\n";
        xml = xml + "<PAS>\n";
        xml = xml + "<reg_c>" + CBData.reg_C + "</reg_c>\n";
        xml = xml + "<reg_nif>" + CBData.reg_nif + "</reg_nif>\n";
        xml = xml + "<reg_pas>" + CBData.reg_pas + "</reg_pas>\n";
        xml = xml + "<aviso>" + CParseConfig.hconfig.get("aviso").toString() + "</aviso>\n";
        xml = xml + "<nif>" + nif + "</nif>\n";
        xml = xml + "<pwd>" + pwd + "</pwd>\n";
        xml = xml + "</PAS>\n";
        xml = xml + "</iRequest>\n";
        
        Http http = new Http(CadastroConnection.serverURL);
        doc = http.doPostRequestDoc(xml);
        


        XPath xp = XPathFactory.newInstance().newXPath();
        

        String status = xp.evaluate("//fme/Login/status", doc);
        String msg = xp.evaluate("//fme/Login/msg", doc);
        if (!status.equals("OK")) {
          jText_help.setText(CadastroConnection.this.html("Não foi possível obter dados na Plataforma de Acesso Simplificado:\n\n" + msg));
          CadastroConnection.this.enable_face(true);
          return;
        }
        
        NodeList lista = (NodeList)xp.evaluate("//fme/Lista/Reg", doc, XPathConstants.NODESET);
        if (lista.getLength() == 0) {
          jText_help.setText(CadastroConnection.this.html("Não existe informação disponível para as credenciais apresentadas"));
        }
        else {
          msg = "Atualmente estão disponíveis na Plataforma de Acesso Simplificado, os seguintes dados:\n\n";
          for (int i = 0; i < lista.getLength(); i++) {
            String design = xp.evaluate("design", lista.item(i));
            design = design.replaceAll("\\s*\\(\\)\\s*$", "");
            msg = msg + "<span style='color:green'>&#160;&#160;&#160;&#10004;&#160;&#160;</span>" + design + "\n";
          }
          msg = msg + "\nPrima a tecla de “importar” para confirmar a importação da informação.";
          jButton_go.setVisible(false);
          jButton_in.setVisible(true);
          jText_help.setText(CadastroConnection.this.html(msg));
        }
      }
      catch (Exception e) {
        e.printStackTrace();
        CadastroConnection.this.enable_face(true);
        jText_help.setText(CadastroConnection.this.html("Não foi possível contactar a Plataforma de Acesso Simplificado:\n\n" + e.getLocalizedMessage()));
      }
    }
  }
}
