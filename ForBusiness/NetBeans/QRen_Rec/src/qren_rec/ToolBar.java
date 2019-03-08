package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.BorderFactory;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JMenuItem;
import javax.swing.JPanel;
import javax.swing.JPopupMenu;
import javax.swing.JTextField;











































































































































































































































































































































































































































































































































































































































































































class ToolBar
  extends JPanel
{
  private JButton jButton_Primeiro = null;
  private JButton jButton_Anterior = null;
  private JButton jButton_Paginas = null;
  private JButton jButton_Seguinte = null;
  private JButton jButton_Ultimo = null;
  private JButton jButton_Abrir = null;
  private JButton jButton_Guardar = null;
  private JButton jButton_Guardar_Exp = null;
  private JButton jButton_Enviar = null;
  private JButton jButton_Validar = null;
  private JButton jButton_Validar_Exp = null;
  private JButton jButton_Imprimir = null;
  private JButton jButton_Imprimir_Exp = null;
  private JButton jButton_Limpar = null;
  private JButton jButton_Limpar_Exp = null;
  private JButton jButton_VersaoOk = null;
  private JButton jButton_Exit = null;
  private JButton jButton_Settings = null;
  private JButton jButton_Settings_Exp = null;
  public JPopupMenu bt_save_popup;
  public JPopupMenu bt_valid_popup; public JPopupMenu bt_clear_popup; public JPopupMenu bt_print_popup; public JPopupMenu bt_about_popup; public JPopupMenu bt_pages_popup; private JButton jButton_PAS = null;
  private JLabel jLabel_File = null;
  private JLabel jLabel_Registo = null;
  private JTextField jTextField_Registo = null;
  
  int y = 7;
  int x = 5;
  int h = 20;
  int w = 25;
  
  ToolBar() {
    int h = 0;
    if (fmeApp.ambiente.equals("applet")) h = 10;
    setLayout(null);
    setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
    setPreferredSize(new Dimension(900, 34 + h));
    setBackground(fmeComum.pageBg);
    setBounds(0, 0, 900, 34 + h);
    y += h;
    add(getJLabel_File());
    add(getJButton_Primeiro());
    add(getJButton_Anterior());
    add(getJButton_Paginas());
    add(getJButton_Seguinte());
    add(getJButton_Ultimo());
    add(getJButton_Guardar());
    add(getJButton_Abrir());
    if (!fmeApp.ambiente.equals("applet"))
      add(getJButton_Imprimir());
    add(getJButton_Limpar());
    add(getJButton_Validar());
    add(getJButton_Enviar());
    add(getJButton_VersaoOk());
    add(getJButton_Exit());
    add(getJButton_Settings());
    
    add(getJButton_PAS());
    add(getJTextField_Registo());
    add(getJButton_Registo());
  }
  

  public void setPopupOpt()
  {
    boolean edit = CBData.T.equals("");
    boolean on = fmeComum.ON;
    

    jButton_Guardar.setEnabled((edit) && (on));
    
    for (Component child : bt_save_popup.getComponents()) {
      if ((child instanceof JMenuItem)) {
        JMenuItem item = (JMenuItem)child;
        if ((fmeApp.in_pas) && (item.getName() != null) && (item.getName().equals("bt_saveas_sreg"))) item.setEnabled(false); else {
          item.setEnabled((edit) && (on));
        }
      }
    }
    
    jButton_Abrir.setEnabled((edit) && (on));
    

    jButton_Validar.setEnabled(edit);
    
    for (Component child : bt_valid_popup.getComponents()) {
      if ((child instanceof JMenuItem)) {
        JMenuItem item = (JMenuItem)child;
        item.setEnabled(edit);
      }
    }
    

    jButton_Limpar.setEnabled(edit);
    
    for (Component child : bt_clear_popup.getComponents()) {
      if ((child instanceof JMenuItem)) {
        JMenuItem item = (JMenuItem)child;
        item.setEnabled(edit);
      }
    }
    
    jButton_Enviar.setEnabled((edit) && (on) && (fmeComum.SUBMIT));
    
    jButton_VersaoOk.setEnabled((!fmeApp.in_pas) && (on));
    
    jButton_Exit.setEnabled(!fmeApp.in_pas);
    
    jButton_PAS.setEnabled((edit) && (on));
  }
  
  public JLabel getJLabel_File() {
    if (jLabel_File == null) {
      jLabel_File = new JLabel();
      jLabel_File.setBounds(10, 0, 500, 15);
      jLabel_File.setForeground(new Color(0, 88, 176));
    }
    return jLabel_File;
  }
  
  private JButton getJButton_Primeiro()
  {
    if (jButton_Primeiro == null) {
      jButton_Primeiro = new JButton();
      jButton_Primeiro.setIcon(new ImageIcon(fmeFrame.class.getResource("gobegin.gif")));
      jButton_Primeiro.addActionListener(new JButton_Page_ActionAdapter("Primeiro"));
      jButton_Primeiro.setBounds(x, y, w, h);
      jButton_Primeiro.setToolTipText("Primeira Página");
      jButton_Primeiro.setActionCommand("Primeiro");
      jButton_Primeiro.setBackground(fmeComum.toolbarButtonBg);
      jButton_Primeiro.setBorder(fmeComum.toolbarButtonBorder);
      jButton_Primeiro.addMouseListener(new ToolBar_MouseAdapter(jButton_Primeiro));
    }
    return jButton_Primeiro;
  }
  
  private JButton getJButton_Anterior() {
    if (jButton_Anterior == null) {
      jButton_Anterior = new JButton();
      jButton_Anterior.setIcon(new ImageIcon(fmeFrame.class.getResource("gorev.gif")));
      jButton_Anterior.addActionListener(new JButton_Page_ActionAdapter("Anterior"));
      jButton_Anterior.setBounds(this.x += w, y, w, h);
      jButton_Anterior.setToolTipText("Página Anterior");
      jButton_Anterior.setActionCommand("Anterior");
      jButton_Anterior.setBackground(fmeComum.toolbarButtonBg);
      jButton_Anterior.setBorder(fmeComum.toolbarButtonBorder);
      jButton_Anterior.addMouseListener(new ToolBar_MouseAdapter(jButton_Anterior));
    }
    return jButton_Anterior;
  }
  
  private JButton getJButton_Paginas() {
    if (jButton_Paginas == null) {
      jButton_Paginas = new JButton();
      jButton_Paginas.setIcon(new ImageIcon(fmeFrame.class.getResource("gopages.gif")));
      jButton_Paginas.addActionListener(new JButton_Page_ActionAdapter("Paginas"));
      jButton_Paginas.setBounds(this.x += w, y, w, h);
      jButton_Paginas.setToolTipText("Páginas");
      jButton_Paginas.setActionCommand("Paginas");
      jButton_Paginas.setBackground(fmeComum.toolbarButtonBg);
      jButton_Paginas.setBorder(fmeComum.toolbarButtonBorder);
      jButton_Paginas.addMouseListener(new ToolBar_MouseAdapter(jButton_Paginas));
      
      bt_pages_popup = new JPopupMenu();
      jButton_Paginas.addMouseListener(new Popup_MouseAdapter(bt_pages_popup, 0));
      fmeApp.Paginas.make_menu(bt_pages_popup);
    }
    

    return jButton_Paginas;
  }
  
  private JButton getJButton_Seguinte() {
    if (jButton_Seguinte == null) {
      jButton_Seguinte = new JButton();
      jButton_Seguinte.setIcon(new ImageIcon(fmeFrame.class.getResource("goforw.gif")));
      jButton_Seguinte.addActionListener(new JButton_Page_ActionAdapter("Seguinte"));
      jButton_Seguinte.setBounds(this.x += w, y, w, h);
      jButton_Seguinte.setToolTipText("Página Seguinte");
      jButton_Seguinte.setActionCommand("Seguinte");
      jButton_Seguinte.setBackground(fmeComum.toolbarButtonBg);
      jButton_Seguinte.setBorder(fmeComum.toolbarButtonBorder);
      jButton_Seguinte.addMouseListener(new ToolBar_MouseAdapter(jButton_Seguinte));
    }
    return jButton_Seguinte;
  }
  
  private JButton getJButton_Ultimo() {
    if (jButton_Ultimo == null) {
      jButton_Ultimo = new JButton();
      jButton_Ultimo.setIcon(new ImageIcon(fmeFrame.class.getResource("goend.gif")));
      jButton_Ultimo.addActionListener(new JButton_Page_ActionAdapter("Ultimo"));
      jButton_Ultimo.setBounds(this.x += w, y, w, h);
      jButton_Ultimo.setToolTipText("Última Página");
      jButton_Ultimo.setActionCommand("Ultimo");
      jButton_Ultimo.setBackground(fmeComum.toolbarButtonBg);
      jButton_Ultimo.setBorder(fmeComum.toolbarButtonBorder);
      jButton_Ultimo.addMouseListener(new ToolBar_MouseAdapter(jButton_Ultimo));
    }
    return jButton_Ultimo;
  }
  
  private JButton getJButton_Guardar() {
    if (jButton_Guardar == null) {
      jButton_Guardar = new JButton();
      jButton_Guardar.setIcon(new ImageIcon(fmeFrame.class.getResource("guardar.gif")));
      jButton_Guardar.addActionListener(new JButton_Save_ActionAdapter());
      jButton_Guardar.setBounds(this.x += w + 35, y, this.w = 20, h);
      jButton_Guardar.setToolTipText("Guardar");
      jButton_Guardar.setBackground(fmeComum.toolbarButtonBg);
      jButton_Guardar.setBorder(fmeComum.toolbarButtonBorder);
      
      jButton_Guardar_Exp = new JButton();
      jButton_Guardar_Exp.setIcon(fmeComum.arrow);
      jButton_Guardar_Exp.setBounds(this.x += w, y, this.w = 11, h);
      jButton_Guardar_Exp.setBackground(fmeComum.toolbarButtonBg);
      jButton_Guardar_Exp.setBorder(fmeComum.toolbarButtonBorder);
      
      jButton_Guardar.addMouseListener(new ToolBar_MouseAdapter(jButton_Guardar, jButton_Guardar_Exp));
      jButton_Guardar_Exp.addMouseListener(new ToolBar_MouseAdapter(jButton_Guardar, jButton_Guardar_Exp));
      
      add(jButton_Guardar_Exp);
      
      bt_save_popup = new JPopupMenu();
      jButton_Guardar_Exp.addMouseListener(new Popup_MouseAdapter(bt_save_popup, jButton_Guardar.getBounds().x - 
        jButton_Guardar_Exp.getBounds().x));
      
      JMenuItem item;
      bt_save_popup.add(item = new JMenuItem("Guardar"));
      item.addActionListener(new JButton_Save_ActionAdapter());
      bt_save_popup.add(item = new JMenuItem("Guardar como..."));
      item.addActionListener(new JButton_SaveAs_ActionAdapter());
      bt_save_popup.add(item = new JMenuItem("Guardar como (Limpar Registo)..."));
      item.setName("bt_saveas_sreg");
      item.addActionListener(new JButton_SaveAsNoReg_ActionAdapter());
    }
    return jButton_Guardar;
  }
  
  private JButton getJButton_Abrir() {
    if (jButton_Abrir == null) {
      jButton_Abrir = new JButton();
      jButton_Abrir.setIcon(new ImageIcon(fmeFrame.class.getResource("openfile.gif")));
      jButton_Abrir.addActionListener(new JButton_Open_ActionAdapter());
      jButton_Abrir.setSize(40, 30);
      jButton_Abrir.setBounds(this.x += w + 10, y, this.w = 20, h);
      jButton_Abrir.setToolTipText("Abrir");
      jButton_Abrir.setBackground(fmeComum.toolbarButtonBg);
      jButton_Abrir.setBorder(fmeComum.toolbarButtonBorder);
      jButton_Abrir.addMouseListener(new ToolBar_MouseAdapter(jButton_Abrir));
    }
    return jButton_Abrir;
  }
  
  private JButton getJButton_Imprimir() {
    if (jButton_Imprimir == null) {
      jButton_Imprimir = new JButton();
      jButton_Imprimir.setIcon(new ImageIcon(fmeFrame.class.getResource("impressora.gif")));
      jButton_Imprimir.addActionListener(new JButton_PrintPg_ActionAdapter());
      jButton_Imprimir.setBounds(this.x += w + 10 + 5, y, this.w = 20, h);
      jButton_Imprimir.setToolTipText("Imprimir Página");
      jButton_Imprimir.setBackground(fmeComum.toolbarButtonBg);
      jButton_Imprimir.setBorder(fmeComum.toolbarButtonBorder);
      
      jButton_Imprimir_Exp = new JButton();
      jButton_Imprimir_Exp.setIcon(fmeComum.arrow);
      jButton_Imprimir_Exp.setBounds(this.x += w, y, this.w = 11, h);
      jButton_Imprimir_Exp.setBackground(fmeComum.toolbarButtonBg);
      jButton_Imprimir_Exp.setBorder(fmeComum.toolbarButtonBorder);
      
      jButton_Imprimir.addMouseListener(new ToolBar_MouseAdapter(jButton_Imprimir, jButton_Imprimir_Exp));
      jButton_Imprimir_Exp.addMouseListener(new ToolBar_MouseAdapter(jButton_Imprimir, jButton_Imprimir_Exp));
      
      add(jButton_Imprimir_Exp);
      
      bt_print_popup = new JPopupMenu();
      jButton_Imprimir_Exp.addMouseListener(new Popup_MouseAdapter(bt_print_popup, jButton_Imprimir.getBounds().x - 
        jButton_Imprimir_Exp.getBounds().x));
      
      JMenuItem item;
      bt_print_popup.add(item = new JMenuItem("Imprimir Página"));
      item.addActionListener(new JButton_PrintPg_ActionAdapter());
      bt_print_popup.add(item = new JMenuItem("Imprimir Formulário"));
      item.addActionListener(new JButton_Print_ActionAdapter());
    }
    return jButton_Imprimir;
  }
  
  private JButton getJButton_Limpar() {
    if (jButton_Limpar == null) {
      jButton_Limpar = new JButton();
      jButton_Limpar.setIcon(new ImageIcon(fmeFrame.class.getResource("limpar.gif")));
      jButton_Limpar.addActionListener(new JButton_ClearPg_ActionAdapter());
      jButton_Limpar.setBounds(this.x += w + 10, y, this.w = 20, h);
      jButton_Limpar.setToolTipText("Limpar Página");
      jButton_Limpar.setBackground(fmeComum.toolbarButtonBg);
      jButton_Limpar.setBorder(fmeComum.toolbarButtonBorder);
      
      jButton_Limpar_Exp = new JButton();
      jButton_Limpar_Exp.setIcon(fmeComum.arrow);
      jButton_Limpar_Exp.setBounds(this.x += w, y, this.w = 11, h);
      jButton_Limpar_Exp.setBackground(fmeComum.toolbarButtonBg);
      jButton_Limpar_Exp.setBorder(fmeComum.toolbarButtonBorder);
      
      jButton_Limpar.addMouseListener(new ToolBar_MouseAdapter(jButton_Limpar, jButton_Limpar_Exp));
      jButton_Limpar_Exp.addMouseListener(new ToolBar_MouseAdapter(jButton_Limpar, jButton_Limpar_Exp));
      
      add(jButton_Limpar_Exp);
      
      bt_clear_popup = new JPopupMenu();
      jButton_Limpar_Exp.addMouseListener(new Popup_MouseAdapter(bt_clear_popup, jButton_Limpar.getBounds().x - 
        jButton_Limpar_Exp.getBounds().x));
      
      JMenuItem item;
      bt_clear_popup.add(item = new JMenuItem("Limpar Página"));
      item.addActionListener(new JButton_ClearPg_ActionAdapter());
      bt_clear_popup.add(item = new JMenuItem("Limpar Formulário"));
      item.addActionListener(new JButton_Clear_ActionAdapter());
    }
    return jButton_Limpar;
  }
  
  private JButton getJButton_Validar() {
    if (jButton_Validar == null) {
      jButton_Validar = new JButton();
      jButton_Validar.setIcon(new ImageIcon(fmeFrame.class.getResource("validar.gif")));
      jButton_Validar.addActionListener(new JButton_ValidPg_ActionAdapter());
      jButton_Validar.setBounds(this.x += w + 10, y, this.w = 20, h);
      jButton_Validar.setToolTipText("Validar Página");
      jButton_Validar.setBackground(fmeComum.toolbarButtonBg);
      jButton_Validar.setBorder(fmeComum.toolbarButtonBorder);
      
      jButton_Validar_Exp = new JButton();
      jButton_Validar_Exp.setIcon(fmeComum.arrow);
      jButton_Validar_Exp.setBounds(this.x += w, y, this.w = 11, h);
      jButton_Validar_Exp.setBackground(fmeComum.toolbarButtonBg);
      jButton_Validar_Exp.setBorder(fmeComum.toolbarButtonBorder);
      
      jButton_Validar.addMouseListener(new ToolBar_MouseAdapter(jButton_Validar, jButton_Validar_Exp));
      jButton_Validar_Exp.addMouseListener(new ToolBar_MouseAdapter(jButton_Validar, jButton_Validar_Exp));
      
      add(jButton_Validar_Exp);
      
      bt_valid_popup = new JPopupMenu();
      jButton_Validar_Exp.addMouseListener(new Popup_MouseAdapter(bt_valid_popup, jButton_Validar.getBounds().x - 
        jButton_Validar_Exp.getBounds().x));
      
      JMenuItem item;
      bt_valid_popup.add(item = new JMenuItem("Validar Página"));
      item.addActionListener(new JButton_ValidPg_ActionAdapter());
      bt_valid_popup.add(item = new JMenuItem("Validar Formulário"));
      item.addActionListener(new JButton_Valid_ActionAdapter());
    }
    return jButton_Validar;
  }
  
  private JButton getJButton_Enviar()
  {
    if (jButton_Enviar == null) {
      jButton_Enviar = new JButton();
      jButton_Enviar.setIcon(new ImageIcon(fmeFrame.class.getResource("world6.gif")));
      jButton_Enviar.addActionListener(new JButton_Send_ActionAdapter());
      jButton_Enviar.setBounds(this.x += w + 10, y, this.w = 22, h);
      jButton_Enviar.setToolTipText("Exportar Candidatura");
      jButton_Enviar.setBackground(fmeComum.toolbarButtonBg);
      jButton_Enviar.setBorder(fmeComum.toolbarButtonBorder);
      jButton_Enviar.addMouseListener(new ToolBar_MouseAdapter(jButton_Enviar));
    }
    return jButton_Enviar;
  }
  
  private JButton getJButton_VersaoOk()
  {
    if (jButton_VersaoOk == null) {
      jButton_VersaoOk = new JButton();
      jButton_VersaoOk.setIcon(new ImageIcon(fmeFrame.class.getResource("world8.gif")));
      jButton_VersaoOk.addActionListener(new ActionListener()
      {
        public void actionPerformed(ActionEvent e) {}

      });
      jButton_VersaoOk.setToolTipText("Verificar versão...");
      jButton_VersaoOk.setMargin(new Insets(0, 0, 0, 0));
      jButton_VersaoOk.setBounds(this.x += w + 10 + 5, y, this.w = 20, h);
      jButton_VersaoOk.setBackground(fmeComum.toolbarButtonBg);
      jButton_VersaoOk.setBorder(fmeComum.toolbarButtonBorder);
      jButton_VersaoOk.addMouseListener(new ToolBar_MouseAdapter(jButton_VersaoOk));
    }
    return jButton_VersaoOk;
  }
  
  private JButton getJButton_Exit() {
    if (jButton_Exit == null) {
      jButton_Exit = new JButton();
      jButton_Exit.setIcon(new ImageIcon(fmeFrame.class.getResource("exit.png")));
      jButton_Exit.addActionListener(new JButton_Exit_ActionAdapter());
      jButton_Exit.setToolTipText("Sair");
      jButton_Exit.setEnabled(!fmeApp.in_pas);
      jButton_Exit.setMargin(new Insets(0, 0, 0, 0));
      jButton_Exit.setBounds(this.x += w + 10 + 5, y, this.w = 20, h);
      jButton_Exit.setBackground(fmeComum.toolbarButtonBg);
      jButton_Exit.setBorder(fmeComum.toolbarButtonBorder);
      jButton_Exit.addMouseListener(new ToolBar_MouseAdapter(jButton_Exit));
    }
    return jButton_Exit;
  }
  
  private JButton getJButton_Settings() {
    if (jButton_Settings == null) {
      jButton_Settings = new JButton();
      jButton_Settings.setIcon(new ImageIcon(fmeFrame.class.getResource("settings.gif")));
      jButton_Settings.setToolTipText("Definições");
      jButton_Settings.setMargin(new Insets(0, 0, 0, 0));
      jButton_Settings.setBounds(this.x += w + 10, y, this.w = 20, h);
      jButton_Settings.setBackground(fmeComum.toolbarButtonBg);
      jButton_Settings.setBorder(fmeComum.toolbarButtonBorder);
      
      jButton_Settings_Exp = new JButton();
      jButton_Settings_Exp.setIcon(fmeComum.arrow);
      jButton_Settings_Exp.setBounds(this.x += w, y, this.w = 11, h);
      jButton_Settings_Exp.setBackground(fmeComum.toolbarButtonBg);
      jButton_Settings_Exp.setBorder(fmeComum.toolbarButtonBorder);
      
      jButton_Settings.addMouseListener(new ToolBar_MouseAdapter(jButton_Settings, jButton_Settings_Exp));
      jButton_Settings_Exp.addMouseListener(new ToolBar_MouseAdapter(jButton_Settings, jButton_Settings_Exp));
      
      add(jButton_Settings_Exp);
      
      bt_about_popup = new JPopupMenu();
      jButton_Settings_Exp.addMouseListener(new Popup_MouseAdapter(bt_about_popup, jButton_Settings.getBounds().x - 
        jButton_Settings_Exp.getBounds().x));
      
      JMenuItem item;
      bt_about_popup.add(item = new JMenuItem("Acerca..."));
      
      item.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          fmeApp.comum.acerca();
        }
      });
    }
    return jButton_Settings;
  }
  
  private JButton getJButton_PAS() {
    if (jButton_PAS == null) {
      jButton_PAS = new CadastroButton(y);
      jButton_PAS.setBounds(this.x += w + 10, y, this.w = 42, h);
      jButton_PAS.addMouseListener(new ToolBar_MouseAdapter(jButton_PAS));
    }
    return jButton_PAS;
  }
  
  public JLabel getJButton_Registo() {
    if (jLabel_Registo == null) {
      jLabel_Registo = new JLabel("Sem Registo", new ImageIcon(fmeFrame.class.getResource("red.png")), 2);
      jLabel_Registo.setBounds(755, y, 20, h);
      jLabel_Registo.setForeground(Color.RED);
      jLabel_Registo.setHorizontalTextPosition(2);
      jLabel_Registo.setIconTextGap(0);
      jLabel_Registo.setHorizontalAlignment(4);
      jLabel_Registo.addMouseListener(new Registo_MouseAdapter(this));
    }
    return jLabel_Registo;
  }
  
  public JTextField getJTextField_Registo() {
    if (jTextField_Registo == null) {
      jTextField_Registo = new JTextField("Sem Registo", 2);
      jTextField_Registo.setBounds(575, y, 180, h);
      jTextField_Registo.setForeground(Color.RED);
      jTextField_Registo.setOpaque(false);
      jTextField_Registo.setBorder(null);
      jTextField_Registo.setEditable(false);
      jTextField_Registo.setHorizontalAlignment(4);
      jTextField_Registo.addMouseListener(new Registo_MouseAdapter(this));
    }
    return jTextField_Registo;
  }
  
  public void updateMenu() { jButton_Primeiro.setEnabled(!fmeApp.Paginas.isFirst());
    jButton_Anterior.setEnabled(!fmeApp.Paginas.isFirst());
    jButton_Seguinte.setEnabled(!fmeApp.Paginas.isLast());
    jButton_Ultimo.setEnabled(!fmeApp.Paginas.isLast());
  }
  
  public void check_registo()
  {
    jTextField_Registo.setText("Sem Registo");
    jTextField_Registo.setForeground(Color.RED);
    jLabel_Registo.setIcon(new ImageIcon(fmeFrame.class.getResource("red.png")));
    
    Frame_IdProm_1 P01 = (Frame_IdProm_1)fmeApp.Paginas.getPage("IdProm_1");
    


    if (CBData.reg_C.equals("")) { return;
    }
    if (!CBData.T.equals(""))
    {
      jTextField_Registo.setText(CBData.T);
      jTextField_Registo.setForeground(new Color(29, 87, 255));
      jTextField_Registo.setToolTipText("Candidatura exportada");
      jLabel_Registo.setIcon(new ImageIcon(fmeFrame.class.getResource("blue.png")));
      jLabel_Registo.setToolTipText("Candidatura exportada");
      return;
    }
    
    jTextField_Registo.setText("Refª: " + CBData.reg_C);
    jTextField_Registo.setForeground(new Color(114, 167, 16));
    jLabel_Registo.setIcon(new ImageIcon(fmeFrame.class.getResource("green.png")));
  }
}
