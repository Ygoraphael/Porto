package fme;

import java.awt.Color;
import java.awt.Dimension;
import java.awt.Toolkit;
import javax.swing.BorderFactory;
import javax.swing.ImageIcon;
import javax.swing.JScrollPane;
import javax.swing.UIManager;
import javax.swing.UnsupportedLookAndFeelException;


























public class fmeApp
{
  static XMLDataHandler cb = null;
  

  public static fmeComum comum = null;
  static String contexto = null;
  public static JScrollPane jScrollPane = null;
  public static ToolBar toolBar = null;
  
  static PgHandler Paginas = null;
  static appWindow apw = null;
  public static String Config = null;
  
  public static String ambiente;
  
  static int n_max_pag = 5;
  static int n_max_no = 10;
  
  static String backoffice = "0";
  
  static int width = 850;
  

  public static boolean in_pas = false;
  
  public fmeApp(String ambiente)
  {
    comum = new fmeComum();
    
    ambiente = ambiente;
    


    try
    {
      UIManager.setLookAndFeel(UIManager.getCrossPlatformLookAndFeelClassName());
      


      UIManager.put("Button.font", fmeComum.letra);
      UIManager.put("Button.background", new Color(238, 242, 243));
      UIManager.put("Button.border", fmeComum.buttonBorder);
      UIManager.put("ToggleButton.font", fmeComum.letra);
      UIManager.put("RadioButton.font", fmeComum.letra);
      UIManager.put("CheckBox.font", fmeComum.letra);
      UIManager.put("CheckBox.background", Color.WHITE);
      UIManager.put("CheckBox.foreground", fmeComum.corLabel);
      

      UIManager.put("ColorChooser.font", fmeComum.letra);
      UIManager.put("ComboBox.font", fmeComum.letra);
      UIManager.put("ComboBox.background", Color.WHITE);
      UIManager.put("ComboBox.border", fmeComum.fieldBorder);
      UIManager.put("ComboBox.selectionBackground", new Color(212, 222, 225));
      UIManager.put("ComboBox.disabledBackground", new Color(238, 242, 243));
      UIManager.put("ComboBox.disabledForeground", new Color(84, 91, 92));
      UIManager.put("Label.font", fmeComum.letra);
      UIManager.put("Label.foreground", fmeComum.corLabel);
      UIManager.put("List.font", fmeComum.letra);
      UIManager.put("MenuBar.font", fmeComum.letra);
      UIManager.put("MenuItem.border", BorderFactory.createEmptyBorder(1, 1, 1, 1));
      UIManager.put("MenuItem.selectionBackground", new Color(200, 200, 200));
      UIManager.put("MenuItem.font", fmeComum.letra);
      UIManager.put("MenuItem.background", new Color(245, 245, 245));
      UIManager.put("MenuItem.foreground", new Color(80, 80, 80));
      UIManager.put("RadioButtonMenuItem.font", fmeComum.letra);
      UIManager.put("CheckBoxMenuItem.font", fmeComum.letra);
      UIManager.put("CheckBoxMenuItem.background", Color.WHITE);
      UIManager.put("Menu.font", fmeComum.letra);
      UIManager.put("PopupMenu.font", fmeComum.letra);
      UIManager.put("PopupMenu.border", fmeComum.fieldBorder);
      UIManager.put("OptionPane.font", fmeComum.letra);
      UIManager.put("OptionPane.background", Color.white);
      UIManager.put("Panel.font", fmeComum.letra);
      UIManager.put("Panel.background", Color.white);
      UIManager.put("EditorPane.font", fmeComum.letra);
      UIManager.put("ProgressBar.font", fmeComum.letra);
      UIManager.put("ScrollPane.font", fmeComum.letra);
      

      UIManager.put("ScrollPane.border", fmeComum.tableBodyBorderCompound2);
      
      UIManager.put("Viewport.font", fmeComum.letra);
      UIManager.put("TabbedPane.font", fmeComum.letra);
      UIManager.put("Slider.background", Color.WHITE);
      
      UIManager.put("Table.font", fmeComum.letra);
      UIManager.put("Table.background", Color.WHITE);
      UIManager.put("Table.gridColor", fmeComum.colorBorder);
      UIManager.put("Table.rowHeight", Integer.valueOf(30));
      

      UIManager.put("TableHeader.font", fmeComum.letra);
      UIManager.put("TableHeader.foreground", new Color(100, 100, 100));
      UIManager.put("TableHeader.background", new Color(240, 240, 240));
      UIManager.put("TableHeader.cellBorder", fmeComum.tableHeaderCellBorder);
      
      UIManager.put("FormattedTextField.font", fmeComum.letra);
      UIManager.put("FormattedTextField.border", fmeComum.fieldBorderCompound);
      UIManager.put("TextField.font", fmeComum.letra);
      UIManager.put("TextField.border", fmeComum.fieldBorderCompound);
      UIManager.put("PasswordField.font", fmeComum.letra);
      UIManager.put("PasswordField.border", fmeComum.fieldBorderCompound);
      UIManager.put("PasswordField.font", fmeComum.letra);
      UIManager.put("TextArea.font", fmeComum.letra);
      UIManager.put("TextPane.font", fmeComum.letra);
      UIManager.put("EditorPane.font", fmeComum.letra);
      UIManager.put("TitledBorder.font", fmeComum.letra);
      UIManager.put("ToolBar.font", fmeComum.letra);
      UIManager.put("ToolTip.font", fmeComum.letra);
      UIManager.put("ToolTip.foreground", Color.WHITE);
      UIManager.put("ToolTip.background", new Color(0, 140, 229));
      UIManager.put("Tree.font", fmeComum.letra);
      UIManager.put("Tree.collapsedIcon", new ImageIcon(fmeFrame.class.getResource("plus-12.png")));
      UIManager.put("Tree.expandedIcon", new ImageIcon(fmeFrame.class.getResource("minus-12.png")));
      UIManager.put("Tree.paintLines", Boolean.valueOf(true));
      UIManager.put("Tree.textForeground", fmeComum.corLabel);
    }
    catch (InstantiationException localInstantiationException) {}catch (ClassNotFoundException localClassNotFoundException) {}catch (UnsupportedLookAndFeelException localUnsupportedLookAndFeelException) {}catch (IllegalAccessException localIllegalAccessException) {}
    








    if (ambiente.equals("frame"))
    {

      System.setProperty("java.net.preferIPv4Stack", "true");
      

      fmeFrame frame = new fmeFrame();
      

      CTabelas t = new CTabelas();
      
      if (Config == null)
      {
        CBData_Noconfig dbnoconfig = new CBData_Noconfig();
        cb = dbnoconfig;
      } else {
        CBData dbconfig = new CBData();
        CBData.Clear();
        cb = dbconfig;
      }
      
      frame.validate();
      


      Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();
      Dimension frameSize = frame.getSize();
      if (height > height) {
        height = height;
      }
      if (width > width) {
        width = width;
      }
      frame.setSize(frameSize);
      frame.setLocation((width - width) / 2, (height - height) / 2);
      frame.setVisible(true);
    }
  }
  












  public static void main(String[] args)
  {
    new fmeApp("frame");
  }
  
  void changeUIManager(String operacao) {
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
