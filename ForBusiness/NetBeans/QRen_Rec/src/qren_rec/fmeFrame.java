package fme;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.Image;
import java.awt.Toolkit;
import java.awt.event.ComponentEvent;
import java.awt.event.WindowEvent;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import javax.swing.JFrame;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JViewport;

























public class fmeFrame
  extends JFrame
  implements appWindow
{
  PgHandler Paginas;
  static String Config;
  private static final long serialVersionUID = 1L;
  private static JPanel jContentPane = null;
  public JScrollPane jScrollPane = null;
  public ToolBar jToolBar = null;
  
  public static Image icon = Toolkit.getDefaultToolkit().getImage(fmeFrame.class.getResource("form_icon.gif"));
  
  void init()
  {
    fmeApp.apw = this;
    

    PgHandler paginas = new PgHandler();
    Paginas = paginas;
    fmeApp.Paginas = Paginas;
    
    String cfgfilename = "fme-default.xml";
    

    if (!fmeApp.comum.mount_config(cfgfilename)) {
      fmeApp.comum.mount_noconfig();
    }
    jToolBar = new ToolBar();
    
    setContentPane(getJContentPane());
    setTitle(fmeComum.title);
    



    setSize(new Dimension(fmeApp.width, 563));
    setIconImage(icon);
    
    fmeApp.jScrollPane = jScrollPane;
    fmeApp.toolBar = jToolBar;
    

    fmeApp.comum.menu(false);
    fmeApp.toolBar.setPopupOpt();
    
    addComponentListener(new fmeFrame_this_componentAdapter(this));
  }
  
  public fmeFrame()
  {
    init();
  }
  
  void this_componentResized(ComponentEvent e) {
    for (int i = 0; i < fmeApp.Paginas.size(); i++) {
      String str = fmeApp.Paginas.getTag(i);
    }
  }
  





















  void verifyConnection()
  {
    String file_autom = "";
    try {
      BufferedReader in = new BufferedReader(new FileReader(fmeComum.userDir + "\\qrenvs"));
      String str;
      while ((str = in.readLine()) != null) { String str;
        if (str.startsWith("###automatico=")) file_autom = str.substring(14); }
      in.close();
      if ((file_autom.length() > 0) && 
        (file_autom.equals("0"))) { return;
      }
    }
    catch (IOException localIOException)
    {
      CHVersaoOk.ligacao();
    }
  }
  
  public static void cancelar_send() { Object[] options = { "  Ok  " };
    JOptionPane.showOptionDialog(jContentPane, 
      "<html>Informamos que o processo de exportação da candidatura foi cancelado.<br>Caso pretenda submeter a candidatura deverá iniciar novamente o processo<br>e seguir todos os passos identificados no guia de formulário de candidatura.</html>", 
      

      "Submissão de candidatura cancelada", 
      -1, 
      2, 
      null, 
      options, 
      options[0]);
  }
  
  public void updateTitle() {
    String titulo = fmeComum.title + " - " + Paginas.getCaption();
    if (CBData.LastFile != null) {
      String fileName = CBData.LastFile.getName();
      if (!fileName.endsWith(new XmlFileFilter().getExtension()))
        fileName = fileName + new XmlFileFilter().getExtension();
      titulo = titulo + " - " + fileName;
    }
    setTitle(titulo);
  }
  
  private JPanel getJContentPane() {
    if (jContentPane == null) {
      jContentPane = new JPanel();
      jContentPane.setLayout(new BorderLayout());
      jContentPane.setMaximumSize(new Dimension(Integer.MAX_VALUE, Integer.MAX_VALUE));
      
      jContentPane.add(getJScrollPane(), "Center");
      jContentPane.add(jToolBar, "North");
    }
    return jContentPane;
  }
  
  private JScrollPane getJScrollPane() {
    if (jScrollPane == null) {
      jScrollPane = new JScrollPane();
      jScrollPane.setAlignmentX(0.5F);
      jScrollPane.setAutoscrolls(false);
      jScrollPane.setDebugGraphicsOptions(0);
      jScrollPane.setDoubleBuffered(false);
      jScrollPane.getViewport().setOpaque(false);
      jScrollPane.getViewport().setBackground(Color.WHITE);
      jScrollPane.setVerticalScrollBarPolicy(22);
    }
    return jScrollPane;
  }
  
  protected void processWindowEvent(WindowEvent e) {
    if (e.getID() == 201)
    {
      if (fmeApp.comum.sair())
        super.processWindowEvent(e);
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
}
