package fme;

import java.awt.Color;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.KeyEvent;
import java.awt.event.MouseEvent;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

public class Frame_QuadrosTecn_2 extends javax.swing.JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_QuadrosTecn_1 = null;
  private JLabel jLabel_QuadrosTecn_1 = null;
  private JScrollPane jScrollPane_QuadrosTecn_1 = null;
  private JTable_Tip jTable_QuadrosTecn_1 = null;
  private JButton jButton_QuadrosTecn_1Add = null;
  private JButton jButton_QuadrosTecn_1Ins = null;
  private JButton jButton_QuadrosTecn_1Del = null;
  
  private JPanel jPanel_Fundam = null;
  private JLabel jLabel_Fundam = null;
  private JScrollPane jScrollPane_Fundam = null;
  private JTextArea jTextArea_Fundam = null;
  public JLabel jLabel_Count = null;
  
  String tag = "";
  
  public Frame_QuadrosTecn_2()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(fmeApp.width - 35, 610);
  }
  
  String coluna_coop = "N";
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (params.get("coop") != null) {
      coluna_coop = ((String)params.get("coop"));
    }
  }
  
  private void initialize() {
    setSize(fmeApp.width - 35, 1000);
    setContentPane(getJContentPane());
    setResizable(false);
    setBorder(null);
    getContentPane().setLayout(null);
    setDebugGraphicsOptions(0);
    setMaximumSize(new Dimension(Integer.MAX_VALUE, Integer.MAX_VALUE));
  }
  
  private JPanel getJContentPane() {
    if (jContentPane == null) {
      jLabel_PT2020 = new Label2020();
      jLabel_Titulo = new LabelTitulo("DADOS DO PROJETO");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_QuadrosTecn_1(), null);
      jContentPane.add(getJPanel_Fundam(), null);
    }
    return jContentPane;
  }
  
  private JPanel getjPanel_QuadrosTecn_1() {
    if (jPanel_QuadrosTecn_1 == null) {
      jButton_QuadrosTecn_1Add = new JButton(fmeComum.novaLinha);
      jButton_QuadrosTecn_1Add.setBorder(BorderFactory.createEtchedBorder());
      jButton_QuadrosTecn_1Add.addMouseListener(new Frame_QuadrosTecn_2_jButton_QuadrosTecn_1Add_mouseAdapter(this));
      jButton_QuadrosTecn_1Add.setToolTipText("Nova Linha");
      jButton_QuadrosTecn_1Add.setBounds(new Rectangle(667, 11, 30, 22));
      jButton_QuadrosTecn_1Ins = new JButton(fmeComum.inserirLinha);
      jButton_QuadrosTecn_1Ins.setBorder(BorderFactory.createEtchedBorder());
      jButton_QuadrosTecn_1Ins.addMouseListener(new Frame_QuadrosTecn_2_jButton_QuadrosTecn_1Ins_mouseAdapter(this));
      jButton_QuadrosTecn_1Ins.setToolTipText("Inserir Linha");
      jButton_QuadrosTecn_1Ins.setBounds(new Rectangle(707, 11, 30, 22));
      jButton_QuadrosTecn_1Del = new JButton(fmeComum.apagarLinha);
      jButton_QuadrosTecn_1Del.setBorder(BorderFactory.createEtchedBorder());
      jButton_QuadrosTecn_1Del.addMouseListener(new Frame_QuadrosTecn_2_jButton_QuadrosTecn_1Del_mouseAdapter(this));
      jButton_QuadrosTecn_1Del.setToolTipText("Apagar Linha");
      jButton_QuadrosTecn_1Del.setBounds(new Rectangle(747, 11, 30, 22));
      jLabel_QuadrosTecn_1 = new JLabel();
      jLabel_QuadrosTecn_1.setBounds(new Rectangle(12, 10, 301, 18));
      jLabel_QuadrosTecn_1.setText("<html>Contratação de quadros técnicos</html>");
      jLabel_QuadrosTecn_1.setFont(fmeComum.letra_bold);
      
      jPanel_QuadrosTecn_1 = new JPanel();
      jPanel_QuadrosTecn_1.setLayout(null);
      jPanel_QuadrosTecn_1.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 230));
      jPanel_QuadrosTecn_1.setBorder(fmeComum.blocoBorder);
      jPanel_QuadrosTecn_1.add(jLabel_QuadrosTecn_1, null);
      jPanel_QuadrosTecn_1.add(jButton_QuadrosTecn_1Add, null);
      jPanel_QuadrosTecn_1.add(jButton_QuadrosTecn_1Ins, null);
      jPanel_QuadrosTecn_1.add(jButton_QuadrosTecn_1Del, null);
      jPanel_QuadrosTecn_1.add(getJScrollPane_QuadrosTecn_1(), null);
    }
    return jPanel_QuadrosTecn_1;
  }
  
  public JScrollPane getJScrollPane_QuadrosTecn_1() {
    if (jScrollPane_QuadrosTecn_1 == null) {
      jScrollPane_QuadrosTecn_1 = new JScrollPane();
      jScrollPane_QuadrosTecn_1.setBounds(new Rectangle(10, 40, fmeApp.width - 90, 170));
      jScrollPane_QuadrosTecn_1.setViewportView(getJTable_QuadrosTecn_1());
      
      jScrollPane_QuadrosTecn_1.setVerticalScrollBarPolicy(22);
    }
    
    return jScrollPane_QuadrosTecn_1;
  }
  
  public javax.swing.JTable getJTable_QuadrosTecn_1() {
    if (jTable_QuadrosTecn_1 == null) {
      jTable_QuadrosTecn_1 = new JTable_Tip(40, jScrollPane_QuadrosTecn_1.getWidth());
      jTable_QuadrosTecn_1.setName("QuadrosTecn_Tabela");
      jTable_QuadrosTecn_1.addExcelButton(jPanel_QuadrosTecn_1, 627, 11, 14);
    }
    return jTable_QuadrosTecn_1;
  }
  
  void jButton_QuadrosTecn_1Add_mouseClicked(MouseEvent e) { CBData.QuadrosTecn.on_add_row(); }
  
  void jButton_QuadrosTecn_1Del_mouseClicked(MouseEvent e)
  {
    CBData.QuadrosTecn.on_del_row();
  }
  
  void jButton_QuadrosTecn_1Ins_mouseClicked(MouseEvent e) {
    CBData.QuadrosTecn.on_ins_row();
  }
  
  private JPanel getJPanel_Fundam() {
    if (jPanel_Fundam == null) {
      jLabel_Fundam = new JLabel();
      jLabel_Fundam.setBounds(new Rectangle(12, 10, fmeApp.width - 90, 18));
      jLabel_Fundam.setText("Fundamentação");
      jLabel_Fundam.setFont(fmeComum.letra_bold);
      
      jPanel_Fundam = new JPanel();
      jPanel_Fundam.setLayout(null);
      jPanel_Fundam.setBounds(new Rectangle(15, 290, fmeApp.width - 60, 310));
      jPanel_Fundam.setBorder(fmeComum.blocoBorder);
      
      jLabel_Count = new JLabel("");
      jLabel_Count.setBounds(new Rectangle(jPanel_Fundam.getWidth() - 200 - 15, getJScrollPane_Fundam().getY() - 15, 200, 20));
      jLabel_Count.setFont(fmeComum.letra_pequena);
      jLabel_Count.setForeground(Color.GRAY);
      jLabel_Count.setHorizontalAlignment(4);
      
      jPanel_Fundam.setName("quadros_tecnicos_texto");
      jPanel_Fundam.add(jLabel_Fundam, null);
      jPanel_Fundam.add(jLabel_Count, null);
      jPanel_Fundam.add(getJScrollPane_Fundam(), null);
    }
    
    return jPanel_Fundam;
  }
  
  public JScrollPane getJScrollPane_Fundam() {
    if (jScrollPane_Fundam == null) {
      jScrollPane_Fundam = new JScrollPane();
      jScrollPane_Fundam.setBounds(new Rectangle(15, 36, fmeApp.width - 90, 255));
      jScrollPane_Fundam.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Fundam.setVerticalScrollBarPolicy(20);
      jScrollPane_Fundam.setViewportView(getJTextArea_Fundam());
    }
    return jScrollPane_Fundam;
  }
  
  public JTextArea getJTextArea_Fundam() { if (jTextArea_Fundam == null) {
      jTextArea_Fundam = new JTextArea();
      jTextArea_Fundam.setFont(fmeComum.letra);
      jTextArea_Fundam.setLineWrap(true);
      jTextArea_Fundam.setWrapStyleWord(true);
      jTextArea_Fundam.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Fundam.addKeyListener(new java.awt.event.KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.QuadrosTecnTxt.on_update("texto");
        }
        

        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Fundam;
  }
  


  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.dx_expand = (jTable_QuadrosTecn_1.getWidth() - jScrollPane_QuadrosTecn_1.getWidth());
    int w = jPanel_QuadrosTecn_1.getWidth() + print_handler.dx_expand;
    print_handler.scaleToWidth((int)(1.15D * w));
    print_handler.margem_x = 10;
    print_handler.margem_y = 50;
    
    print_handler.header = _lib.get_titulo(caption);
    print_handler.footer_medida = fmeComum.title;
    print_handler.footer_pag = _lib.get_pagina(caption);
    print_handler.footer_promotor = PromotorgetByName"nome"v;
    
    print_handler.print_page();
  }
  
  public int print(Graphics g, PageFormat pf, int pageIndex) {
    return print_handler.print(g, pf, pageIndex);
  }
  
  public void clear_page()
  {
    CBData.QuadrosTecn.Clear();
    CBData.QuadrosTecnTxt.Clear();
    CBData.QuadrosTecnTxt.on_update("texto");
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.QuadrosTecn.validar(null));
    grp.add_grp(CBData.QuadrosTecnTxt.validar(null));
    return grp;
  }
}
