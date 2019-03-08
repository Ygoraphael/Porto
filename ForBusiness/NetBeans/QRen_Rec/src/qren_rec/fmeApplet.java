package fme;

import java.awt.BorderLayout;
import java.awt.Dimension;
import java.awt.event.ActionEvent;
import java.awt.event.ComponentEvent;
import java.io.File;
import java.io.PrintStream;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import javax.swing.JApplet;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.UIManager;










































public class fmeApplet
  extends JApplet
  implements appWindow
{
  static PgHandler Paginas;
  static String Config;
  private static final long serialVersionUID = 1L;
  private static JPanel jContentPane = null;
  public JScrollPane jScrollPane = null;
  public ToolBar jToolBar = null;
  
  public void destroy() {
    System.out.println("DESTROY APPLET");
  }
  
  public void init() {
    System.out.println("INIT APPLET");
    
    fmeApp.apw = this;
    

    PgHandler paginas = new PgHandler();
    Paginas = paginas;
    fmeApp.Paginas = Paginas;
    fmeApp p = new fmeApp("applet");
    
    String cfgfilename = "fme-default.xml";
    
    if (!fmeApp.comum.mount_config(cfgfilename)) {
      fmeApp.comum.mount_noconfig();
    }
    jToolBar = new ToolBar();
    jContentPane = null;
    setContentPane(getJContentPane());
    
    setSize(new Dimension(fmeApp.width, 663));
    
    fmeApp.jScrollPane = jScrollPane;
    fmeApp.toolBar = jToolBar;
    
    fmeApp.comum.menu(false);
    
    String origem = getParameter("origem");
    String nif = getParameter("nif");
    String ref_cand = getParameter("ref_cand");
    String read_url = getParameter("url");
    String ref_T = getParameter("T");
    String tem_cand = getParameter("tem_cand");
    String submit = getParameter("submit");
    






    if ((origem != null) && (origem.equals("PAS"))) {
      fmeApp.in_pas = true;
      fmeComum.ON = true;
      CBData.reg_pas = "1";
      if (ref_cand != null) CBData.reg_C = ref_cand;
      if (nif != null) CBData.reg_nif = nif;
    }
    else
    {
      fmeApp.in_pas = false;
      CBData.reg_pas = "";
      CBData.reg_C = "";
      CBData.reg_nif = "";
    }
    

    if ((submit != null) && (submit.equals("0"))) {
      fmeComum.SUBMIT = false;
    }
    if (read_url != null) {
      String regex = "://[^/]*";
      Matcher match = Pattern.compile(regex).matcher(read_url);
      if (match.find()) {
        String serv_port = match.group().substring(3);
        fmeComum.atendedor = fmeComum.atendedor.replaceFirst(regex, "://" + serv_port);
        fmeComum.atend_pas = fmeComum.atend_pas.replaceFirst(regex, "://" + serv_port);
      }
    }
    






    addComponentListener(new fmeApplet_this_componentAdapter(this));
    
    CTabelas t = new CTabelas();
    fmeApp.cb = null;
    if (fmeApp.Config == null) {
      JOptionPane.showMessageDialog(null, "Modelo = null");
      CBData_Noconfig dbnoconfig = new CBData_Noconfig();
      fmeApp.cb = dbnoconfig;
    }
    else {
      CBData dbconfig = new CBData();
      CBData.Clear();
      fmeApp.apw.updateTitle();
      fmeApp.cb = dbconfig;
    }
    
    if (fmeApp.in_pas) {
      if (read_url != null) {
        if ((tem_cand == null) || (!tem_cand.equals("1"))) {
          CBData.import_pas = true;
        } else {
          read_url = read_url + "&FME=1";
        }
        fmeComum.ON = false;
        CBData.reading_xml = true;
        XMLParser.Read(read_url);
        CBData.reading_xml = false;
        CBData.after_open_txt_limite();
        if (ref_T != null) {
          CBData.T = ref_T;
        } else {
          fmeComum.ON = true;
        }
        CBData.import_pas = false;
        System.out.println("#### REF_C (3)   " + CBData.reg_C);
      }
      CBData.import_data_adc();
    }
    





    fmeApp.toolBar.check_registo();
    fmeApp.toolBar.setPopupOpt();
  }
  




























































  public fmeApplet() {}
  



























































  void this_componentResized(ComponentEvent e)
  {
    for (int i = 0; i < Paginas.size(); i++) {
      String str = Paginas.getTag(i);
    }
  }
  












































































  public void updateTitle()
  {
    String name = "";
    if (CBData.LastFile != null) name = CBData.LastFile.getName();
    fmeApp.toolBar.getJLabel_File().setText(name);
  }
  
  private JPanel getJContentPane() {
    if (jContentPane == null) {
      jContentPane = new JPanel();
      jContentPane.setLayout(new BorderLayout());
      jContentPane.setMaximumSize(new Dimension(Integer.MAX_VALUE, Integer.MAX_VALUE));
      jContentPane.setLayout(new BorderLayout());
      
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
      jScrollPane.setOpaque(true);
      jScrollPane.setVerticalScrollBarPolicy(22);
    }
    return jScrollPane;
  }
  





  void jMenuAccoes_VersaoOk_actionPerformed(ActionEvent e) {}
  





  void changeUIManager(String operacao)
  {
    UIManager.put("FileChooser.font", fmeComum.letra);
    
    UIManager.put("FileChooser.fileNameLabelMnemonic", new Integer(78));
    UIManager.put("FileChooser.fileNameLabelText", "Nome do ficheiro:");
    
    UIManager.put("FileChooser.filesOfTypeLabelMnemonic", new Integer(84));
    UIManager.put("FileChooser.filesOfTypeLabelText", "Tipo do ficheiro:");
    
    UIManager.put("FileChooser.upFolderToolTipText", "Um nível acima");
    UIManager.put("FileChooser.upFolderAccessibleName", "Um nível acima");
    
    UIManager.put("FileChooser.homeFolderToolTipText", "Desktop");
    UIManager.put("FileChooser.homeFolderAccessibleName", "Desktop");
    
    UIManager.put("FileChooser.newFolderToolTipText", "Criar nova pasta");
    UIManager.put("FileChooser.newFolderAccessibleName", "Criar nova pasta");
    
    UIManager.put("FileChooser.listViewButtonToolTipText", "Lista");
    UIManager.put("FileChooser.listViewButtonAccessibleName", "Lista");
    
    UIManager.put("FileChooser.detailsViewButtonToolTipText", "Detalhes");
    UIManager.put("FileChooser.detailsViewButtonAccessibleName", "Detalhes");
    
    UIManager.put("FileChooser.cancelButtonToolTipText", "");
    UIManager.put("FileChooser.cancelButtonText", "Cancelar");
    
    if (operacao.equals("Open")) {
      UIManager.put("FileChooser.lookInLabelText", "Procurar em:");
      UIManager.put("FileChooser.openButtonToolTipText", "Abrir ficheiro selecionado");
      UIManager.put("FileChooser.openButtonText", "Abrir");
    }
    if (operacao.equals("Save")) {
      UIManager.put("FileChooser.saveInLabelText", "Guardar em:");
      UIManager.put("FileChooser.saveButtonToolTipText", "Guardar ficheiro selecionado");
      UIManager.put("FileChooser.saveButtonText", "Guardar");
    }
  }
}
