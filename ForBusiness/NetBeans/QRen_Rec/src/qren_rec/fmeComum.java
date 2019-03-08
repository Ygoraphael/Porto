package fme;

import java.awt.Color;
import java.awt.Desktop;
import java.awt.Dimension;
import java.awt.Font;
import java.io.BufferedReader;
import java.io.File;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.net.URI;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.ImageIcon;
import javax.swing.JFileChooser;
import javax.swing.JInternalFrame;
import javax.swing.JOptionPane;
import javax.swing.JScrollPane;
import javax.swing.JViewport;
import javax.swing.UIManager;
import javax.swing.border.Border;
import javax.swing.border.CompoundBorder;
import javax.swing.border.EmptyBorder;
import javax.swing.border.LineBorder;
import javax.swing.border.MatteBorder;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import org.xml.sax.helpers.DefaultHandler;








public class fmeComum
{
  public static String userDir = System.getProperty("user.dir");
  public static String tmpDir = System.getProperty("java.io.tmpdir");
  
  public static String title = "Formulário Portugal 2020";
  


  public static String atendedor = "http://pas.poci-compete2020.pt/atend-cand/";
  public static String atend_pas = "http://pas.poci-compete2020.pt/pas2/";
  
  public static boolean ON = false;
  
  public static boolean SUBMIT = true;
  
  public static ImageIcon arrow = new ImageIcon(fmeFrame.class.getResource("arrow.png"));
  
  private static final boolean windows = System.getProperty("os.name").toLowerCase().startsWith("windows");
  
  private static final String Trebuchet = windows ? "Trebuchet MS" : "DejaVu Sans Condensed";
  private static final String Tahoma = windows ? "Tahoma" : "DejaVu Sans Condensed";
  
  public static Font letra = new Font(Tahoma, 0, 11);
  public static Font letra_pequena = new Font(Tahoma, 0, 10);
  public static Font letra_bold = new Font(Tahoma, 1, 11);
  public static Font letra_italico = new Font(Tahoma, 2, 11);
  public static Font letra_titulo = new Font(Tahoma, 1, 12);
  public static Font letra_titulo3 = new Font(Trebuchet, 0, 14);
  public static Font letra_titulo2 = new Font(Trebuchet, 1, 15);
  public static Font letra_titulo1 = new Font(Trebuchet, 1, 18);
  
  public static ImageIcon search = new ImageIcon(fmeFrame.class.getResource("search.gif"));
  public static ImageIcon inserirLinha = new ImageIcon(fmeFrame.class.getResource("inserirlinha.gif"));
  public static ImageIcon copiarLinha = new ImageIcon(fmeFrame.class.getResource("copiarlinha.gif"));
  public static ImageIcon subirLinha = new ImageIcon(fmeFrame.class.getResource("subirlinha.gif"));
  public static ImageIcon novaLinha = new ImageIcon(fmeFrame.class.getResource("novalinha.gif"));
  public static ImageIcon apagarLinha = new ImageIcon(fmeFrame.class.getResource("apagarlinha.gif"));
  
  public static ImageIcon logoAcerca = new ImageIcon(fmeFrame.class.getResource("Portugal2020-acerca.gif"));
  public static ImageIcon logoUE = new ImageIcon(fmeFrame.class.getResource("UE2.gif"));
  public static ImageIcon logoPT2020 = new ImageIcon(fmeFrame.class.getResource("Portugal2020.gif"));
  public static ImageIcon logoPagina = new ImageIcon(fmeFrame.class.getResource("Portugal2020-2.gif"));
  
  public static MatteBorder blocoBorder = BorderFactory.createMatteBorder(2, 2, 2, 2, new ImageIcon(fmeFrame.class.getResource("border.gif")));
  public static LineBorder fieldBorder = new LineBorder(new Color(227, 227, 227));
  
  public static CompoundBorder fieldBorderCompound = new CompoundBorder(fieldBorder, new EmptyBorder(0, 4, 0, 4));
  
  public static LineBorder toolbarButtonBorder = new LineBorder(new Color(255, 255, 255), 0, false);
  
  public static LineBorder tableHeaderBorder = new LineBorder(new Color(227, 227, 227));
  public static Color tableHeaderBg = new Color(195, 200, 212);
  
  public static Border paddingBorder = BorderFactory.createEmptyBorder(2, 4, 2, 2);
  

  public static Color rosa_cinza = new Color(232, 242, 254);
  public static Color color_1 = new Color(51, 51, 51);
  public static Color color_2 = new Color(153, 153, 153);
  
  public static Color corLabel = new Color(90, 90, 90);
  public static Color corletraBLCTitle = new Color(72, 72, 72);
  public static Color corLetraTableHeader = new Color(51, 51, 51);
  
  public static Color colorBorder = new Color(227, 227, 227);
  public static Color tableBodyBgNE = new Color(247, 247, 247);
  public static Color tableBodyBg = new Color(255, 255, 255);
  
  public static CompoundBorder tableBodyBorderCompound = new CompoundBorder(fieldBorder, new EmptyBorder(0, 4, 0, 4));
  public static CompoundBorder tableBodyBorderCompound2 = new CompoundBorder(fieldBorder, new EmptyBorder(0, 0, 0, 0));
  
  public static Color simpleTableBodyBorder = new Color(227, 227, 227);
  
  public static Color pageBg = new Color(255, 255, 255);
  public static Color toolbarButtonBg = new Color(255, 255, 255);
  
  public static CompoundBorder buttonBorder = new CompoundBorder(fieldBorder, new EmptyBorder(2, 5, 2, 5));
  public static CompoundBorder tableHeaderCellBorder = new CompoundBorder(new MatteBorder(1, 1, 1, 2, new Color(230, 230, 230)), new EmptyBorder(2, 5, 2, 5));
  
  public fmeComum() {}
  
  void menu(boolean make)
  {
    fmeApp.Paginas.Select(0);
    fmeApp.apw.updateTitle();
    
    fmeApp.jScrollPane.getViewport().add(fmeApp.Paginas.getFrame());
    if (make)
      fmeApp.Paginas.make_menu(toolBarbt_pages_popup);
    fmeApp.toolBar.updateMenu();
  }
  
  String aviso()
  {
    String[] aviso_aux = ((String)CParseConfig.hconfig.get("aviso")).split("-");
    return aviso_aux[2] + "/" + aviso_aux[1] + "/" + aviso_aux[0];
  }
  
  public void select_page(String tag)
  {
    fmeApp.Paginas.SelectTag(tag);
    fmeApp.apw.updateTitle();
    fmeApp.jScrollPane.getViewport().add(fmeApp.Paginas.getFrame());
    fmeApp.toolBar.updateMenu();
  }
  

  public void pagina(String cmd)
  {
    
    
    if (cmd.equals("Primeiro")) { fmeApp.Paginas.SelectFirst();
    } else if (cmd.equals("Anterior")) { fmeApp.Paginas.SelectPrevious();
    } else if (cmd.equals("Seguinte")) { fmeApp.Paginas.SelectNext();
    } else if (cmd.equals("Ultimo")) fmeApp.Paginas.SelectLast(); else
      fmeApp.Paginas.SelectTag(cmd);
    fmeApp.apw.updateTitle();
    


    fmeApp.jScrollPane.getViewport().add(fmeApp.Paginas.getFrame());
    fmeApp.toolBar.updateMenu();
  }
  
  public void abrir() {
    if (CBData.dirty) {
      Object[] options = { "   Sim   ", "   Não   ", " Cancelar " };
      int n = JOptionPane.showOptionDialog(null, 
        "Pretende guardar as alterações efetuadas?", 
        "Antes de abrir...", 
        1, 
        3, 
        null, 
        options, 
        options[0]);
      if (n == 2) return;
      if (n == 0)
        guardar(false, false, false, false, false);
      if (n == 1)
        CBData.LastFile = null;
      CBData.Clear();
    }
    


    changeUIManager("Open");
    
    JFileChooser jFileChooser = new JFileChooser();
    try {
      File f = new File(new File(".").getCanonicalPath());
      jFileChooser.setCurrentDirectory(f);
      jFileChooser.setDialogTitle("Abrir Candidatura");
      jFileChooser.addChoosableFileFilter(new XmlFileFilter());
      int returnVal = jFileChooser.showOpenDialog(null);
      if (returnVal == 0) {
        String reg_C_ori = CBData.reg_C;
        String reg_nif_ori = CBData.reg_nif;
        String reg_pas_ori = CBData.reg_pas;
        CBData.Clear();
        File file = jFileChooser.getSelectedFile();
        if (fmeApp.Config == null) {
          JOptionPane.showMessageDialog(null, "parse noconfig");
          XMLParser.Open(file);
          
          if (fmeApp.Config != null) {
            JOptionPane.showMessageDialog(null, "montar: " + fmeApp.Config);
            fmeApp.comum.mount_new_config(fmeApp.Config);
          }
        }
        if (fmeApp.Config == null) {
          JOptionPane.showMessageDialog(null, "não deu...");
          return;
        }
        
        CBData.before_open();
        CBData.corrompido = false;
        XMLParser.Open(file);
        if (CBData.corrompido) {
          CBData.Clear();
          CBData.LastFile = null;
          CBData.corrompido = false;
          JOptionPane.showMessageDialog(null, "Ficheiro corrompido!");
        }
        if ((fmeApp.in_pas) && 
          (!reg_C_ori.equals(CBData.reg_C))) {
          CBData.Clear();
          CBData.reg_C = reg_C_ori;
          CBData.reg_nif = reg_nif_ori;
          CBData.reg_pas = reg_pas_ori;
          JOptionPane.showMessageDialog(null, "Ficheiro inválido!\nEste ficheiro não é da Refª " + reg_C_ori + ".");
        }
        
        CBData.after_open();
      }
    } catch (Exception e2) {
      System.out.print(e2);
      JOptionPane.showMessageDialog(null, "Erro ao abrir o ficheiro!");
    }
    fmeApp.apw.updateTitle();
  }
  
  public int guardar(boolean saveAs, boolean after_send, boolean export, boolean on_send, boolean sem_registo)
  {
    String path = "";
    XmlFileFilter fileFilter = new XmlFileFilter();
    CBData.__garbage_stop_editing();
    CBData.extract();
    changeUIManager("Save");
    if (((CBData.exportado.equals("2")) || (CBData.ficheiro.equals("1"))) && (!after_send) && (!saveAs)) {
      JOptionPane.showMessageDialog(null, "Esta candidatura já foi exportada!", "Guardar", 2);
      return 0;
    }
    try
    {
      if (((CBData.LastFile == null) || (saveAs)) && (!after_send)) {
        if ((saveAs) && (!export) && (!CBData.reg_C.equals("")) && (sem_registo)) {
          Object[] options = { "   Sim   ", "   Não   " };
          int n = JOptionPane.showOptionDialog(null, 
            "Esta operação elimina os dados de registo da sua Candidatura.\nDeseja continuar?", 
            "Guardar como", 
            0, 
            3, 
            null, 
            options, 
            options[1]);
          if ((n == 1) || (n == -1)) { return -1;
          }
        }
        JFileChooser jFileChooser = new JFileChooser();
        File f = new File(new File(".").getCanonicalPath());
        jFileChooser.setCurrentDirectory(f);
        jFileChooser.setDialogTitle("Guardar Candidatura");
        jFileChooser.addChoosableFileFilter(fileFilter);
        int returnVal = jFileChooser.showSaveDialog(null);
        if (returnVal == 0) {
          File file = jFileChooser.getSelectedFile();
          if (!file.getAbsolutePath().endsWith(fileFilter.getExtension())) {
            path = file.getAbsolutePath() + fileFilter.getExtension();
          } else
            path = file.getAbsolutePath();
          File file2 = new File(path);
          if (file2.exists()) {
            Object[] options = { "   Sim   ", "   Não   " };
            int n = JOptionPane.showOptionDialog(null, 
              "Já existe um ficheiro com esse nome.\nDeseja sobrepor?", 
              "Guardar como", 
              0, 
              3, 
              null, 
              options, 
              options[1]);
            if ((n == 1) || (n == -1)) return -1;
          }
          if ((saveAs) && (!export)) {
            CBData.exportado = "0";
            CBData.T = "";
            CBData.ficheiro = "0";
            if (sem_registo) {
              CBData.reg_nif = "";
              CBData.reg_C = "";
              CBData.reg_pas = "";
              CBData.Uploads.limpar_registo();
              fmeApp.toolBar.check_registo();
            }
            CBData.vs_old = CBData.vs;
          }
          CBData.xml_parser.saveInFile(file2);
          CBData.LastFile = file2;
          fmeApp.apw.updateTitle();
          return 1; }
        if ((returnVal == 1) && (on_send)) {
          fmeFrame.cancelar_send();
        }
      }
      else {
        CBData.xml_parser.saveInFile(CBData.LastFile);
        return 1;
      }
    }
    catch (Exception e3) {
      e3.printStackTrace();
      JOptionPane.showMessageDialog(null, "Erro a guardar ficheiro!");
    }
    return 0;
  }
  
  void registar() {
    if (CBData.reg_C.equals("")) {
      JOptionPane.showMessageDialog(null, "Antes do Registo é necessário Guardar a sua candidatura.\nP.f., siga os passos.", 
        "Aviso", 
        2);
      int s = -1;
      while (s == -1) {
        s = guardar(true, false, false, false, false);
      }
      if (s == 0) return;
    }
    CHRegisto.ligacao();
  }
  
  public void upload(String ref) {
    if (!UploadsgetByName"aplicavel_"v.equals("S")) return;
    if (CBData.reg_C.equals("")) {
      JOptionPane.showMessageDialog(null, "P.f., registe a sua candidatura primeiro!", "Erro", 0);
      return;
    }
    if (CBData.LastFile == null) {
      JOptionPane.showMessageDialog(null, "Antes do upload do documento é necessário Guardar a sua candidatura.\nP.f., siga os passos.", 
        "Aviso", 
        2);
      int s = -1;
      while (s == -1) {
        s = fmeApp.comum.guardar(true, false, false, false, false);
      }
      if (s == 0) { return;
      }
    }
    

    JFileChooser fc = new JFileChooser();
    fc.setDialogTitle("Abrir ficheiro para Upload");
    fc.setApproveButtonText("Upload");
    fc.setApproveButtonToolTipText("Fazer upload do ficheiro selecionado");
    int returnVal = fc.showOpenDialog(null);
    if (returnVal == 0) {
      File file = fc.getSelectedFile();
      
      if (file.exists()) {
        if (file.length() > 31457280L) {
          JOptionPane.showMessageDialog(null, "Ficheiro muito grande! Por favor, limite o tamanho do ficheiro a 30 MB.", "Erro", 0);
          return;
        }
        System.setProperty("java.net.useSystemProxies", "true");
        String atend = atendedor + "atend.php";
        String name = atend + "?OP=REG-DOC";
        name = name + "&AVISO=" + CParseConfig.hconfig.get("aviso");
        name = name + "&CLASSE=" + CParseConfig.hconfig.get("extensao");
        name = name + "&VS=" + URLEncoder.encode(CBData.vs);
        name = name + "&REFC=" + CBData.reg_C;
        name = name + "&DOC=" + ref;
        
        String msg = "";
        try {
          URL url = new URL(name);
          URLConnection conn = url.openConnection();
          
          BufferedReader r = new BufferedReader(new InputStreamReader(conn.getInputStream()));
          String s; while ((s = r.readLine()) != null) { String s;
            msg = msg + s + "\n"; }
          r.close();
        } catch (Exception ee) {
          ee.printStackTrace();
        }
        
        System.out.println(msg);
        
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
        else if (ggp_stat.equals("OK!"))
        {
          FileSender fs = new FileSender(atend, CBData.reg_C, ref, file.getAbsolutePath());
          ArrayList<String> tok2 = fs.SendFile();
          String ggp_stat_upl = "";String ggp_ref_upl = "";String ggp_msg_upl = "";
          
          for (int i = 0; i < tok2.size(); i++) {
            if (((String)tok2.get(i)).startsWith("###STAT=")) ggp_stat_upl = ((String)tok2.get(i)).substring(8);
            if (((String)tok2.get(i)).startsWith("###REF=")) ggp_ref_upl = ((String)tok2.get(i)).substring(7);
            if (((String)tok2.get(i)).startsWith("###MSG=")) ggp_msg_upl = ((String)tok2.get(i)).substring(7);
          }
          ggp_stat_upl = ggp_stat_upl.replaceAll("\n", "");
          ggp_ref_upl = ggp_ref_upl.replaceAll("\n", "");
          
          if ((sent) && (ggp_stat_upl.equals("OK!"))) {
            CBData.Uploads.getByName("file_" + ref).setStringValue(file.getName());
            CBData.Uploads.getByName("file_srv_" + ref).setStringValue(ggp_ref);
            CBData.Uploads.getByName("upload_" + ref).setStringValue("S");
            CBData.Uploads.on_update("upload_" + ref);
            CBData.xml_parser.saveInFile(CBData.LastFile);
            System.out.println("FILE = " + CBData.LastFile.getAbsolutePath());
            
            JOptionPane.showMessageDialog(null, ggp_msg_upl, "Aviso", 1);
          }
          else if (ggp_stat_upl.equals("NOK")) {
            JOptionPane.showMessageDialog(null, ggp_msg_upl, "Erro", 0);
          }
        }
        else
        {
          m = "Ocorreu um problema no envio do ficheiro.";
          JOptionPane.showMessageDialog(null, m, "Aviso", 2);
        }
      } else {
        JOptionPane.showMessageDialog(null, "O ficheiro indicado não existe!");
      }
    }
  }
  
  public void download_ie(String ref)
  {
    String uri = atendedor + "atend.php" + "?OP=DOWNLOAD";
    uri = uri + "&AVISO=" + CParseConfig.hconfig.get("aviso");
    uri = uri + "&CLASSE=" + CParseConfig.hconfig.get("extensao");
    uri = uri + "&VS=" + URLEncoder.encode(CBData.vs);
    uri = uri + "&REFC=" + CBData.reg_C;
    uri = uri + "&DOC=" + ref;
    try
    {
      if (Desktop.isDesktopSupported()) {
        Desktop.getDesktop().browse(new URI(uri));
      }
    }
    catch (Exception e) {
      try {
        if (Desktop.isDesktopSupported()) {
          Desktop.getDesktop().browse(new URI("http://www.poci-compete2020.pt/"));
        }
      }
      catch (Exception localException1) {}
    }
  }
  

  String validar(boolean on_send)
  {
    fmeApp.contexto = "menu";
    CBData.__garbage_stop_editing();
    CHValid.reset(title);
    for (int i = 0; i < fmeApp.Paginas.size(); i++) {
      Pagina_Base p = (Pagina_Base)fmeApp.Paginas.getPage(i);
      CHValid.add_pg_grp(p.validar_pg());
    }
    return CHValid.show(true, on_send);
  }
  
  String validar_pg() {
    fmeApp.contexto = "toolbar";
    CBData.__garbage_stop_editing();
    CHValid.reset(title);
    CHValid.add_pg_grp(((Pagina_Base)fmeApp.Paginas.getFrame()).validar_pg());
    return CHValid.show(false, false);
  }
  
  void limpar() {
    fmeApp.contexto = "menu";
    Object[] options = { "   Sim   ", "   Não   " };
    int n = JOptionPane.showOptionDialog(null, 
      "Os dados do formulário vão ser eliminados.\nPretende continuar?", 
      "Limpar Formulário", 
      0, 
      3, 
      null, 
      options, 
      options[1]);
    
    if (n == 0) {
      CBData.Clear();
      CBData.import_data_adc();
      fmeApp.toolBar.check_registo();
      CBData.LastFile = null;
      fmeApp.apw.updateTitle();
    }
  }
  
  void limpar_pg() {
    fmeApp.contexto = "toolbar";
    String msg = "Os dados desta página vão ser eliminados.\nPretende continuar?";
    Object[] options = { "   Sim   ", "   Não   " };
    int n = JOptionPane.showOptionDialog(null, msg, 
      "Limpar Página", 
      0, 
      3, 
      null, 
      options, 
      options[1]);
    if (n == 0) {
      ((Pagina_Base)fmeApp.Paginas.getFrame()).clear_page();
      CBData.setDirty();
    }
  }
  

  void imprimir()
  {
    fmeApp.contexto = "menu";
    CHPrint.show();
  }
  
  void imprimir_pg() {
    fmeApp.contexto = "toolbar";
    ((Pagina_Base)fmeApp.Paginas.getFrame()).print_page();
  }
  
  void enviar()
  {
    if ((!CBData.exportado.equals("2")) && (CBData.ficheiro.equals("1")) && 
      (CBData.vs_old.substring(0, 4).compareTo(CBData.vs.substring(0, 4)) < 0)) {
      JOptionPane.showMessageDialog(null, "Foi criado um ficheiro com uma versão anterior à do formulário atual!\nPara exportar a sua candidatura deverá:\n   1) utilizar a opção \"Ficheiro|Guardar como...\" para gravar um novo ficheiro;\n   2) proceder à exportação do mesmo.", 
      


        "Aviso", 
        2);
      return;
    }
    
    if ((CBData.exportado.equals("2")) || (CBData.ficheiro.equals("1"))) {
      CHEnvio.envio(true);
      return;
    }
    String vld = validar(true);
    
    if ((CHValid.n_erros > 0) || (vld.equals("G"))) { return;
    }
    CHDialog d = new CHDialog();
    if (cmd.equals("G")) { return;
    }
    CBData.exportado = "1";
    int s = -1;
    while (s == -1) {
      s = guardar(true, false, true, true, false);
    }
    if (s == 0) return;
    CHEnvio.sent_ok = false;
    CHEnvio.envio(false);
  }
  
  void acerca() {
    fmeAcerca acerca = new fmeAcerca();
  }
  
  boolean sair() {
    Object[] options = { "   Sim   ", "   Não   " };
    int n = JOptionPane.showOptionDialog(null, 
      "Pretende encerrar o formulário?", 
      "Sair", 
      0, 
      3, 
      null, 
      options, 
      options[0]);
    if (n == 0) {
      System.exit(0);
      return true;
    }
    return false;
  }
  
  boolean mount_config(String cfgfilename) {
    DefaultHandler handler = new CParseConfig();
    SAXParserFactory factory = SAXParserFactory.newInstance();
    try {
      SAXParser saxParser = factory.newSAXParser();
      
      saxParser.parse(getClass().getResourceAsStream(cfgfilename), handler);
    }
    catch (Exception e) {
      JOptionPane.showMessageDialog(null, "Erro de configuração: " + cfgfilename);
      return false;
    }
    

    return true;
  }
  
  public void mount_new_config(String cfgfilename)
  {
    clearconfig();
    mount_config(cfgfilename);
    menu(true);
    






    CBData db = new CBData();
    CBData.Clear();
    fmeApp.cb = db;
  }
  









  void mount_noconfig()
  {
    try
    {
      Object p = Class.forName("fme.Frame_Params").newInstance();
      Dimension d = ((Pagina_Base)p).getSize();
      ((JInternalFrame)p).setPreferredSize(d);
      fmeApp.Paginas.add((JInternalFrame)p, "Params", "Parametrização");
    }
    catch (Exception e) {
      JOptionPane.showMessageDialog(null, e.toString());
    }
  }
  
  void clearconfig() {
    fmeApp.Paginas.clear();
  }
  
  void changeUIManager(String operacao) {
    UIManager.put("FileChooser.font", letra);
    
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
