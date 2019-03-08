package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextArea;

public class Frame_Indic extends javax.swing.JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_IndicCertif = null;
  private JLabel jLabel_IndicCertif = null;
  private JScrollPane jScrollPane_IndicCertif = null;
  private JTable_Tip3 jTable_IndicCertif = null;
  private JPanel jPanel_IndicIDT = null;
  private JLabel jLabel_IndicIDT = null;
  private JScrollPane jScrollPane_IndicIDT = null;
  private JTable_Tip jTable_IndicIDT = null;
  
  private JPanel jPanel_Fundam = null;
  private JLabel jLabel_Fundam = null;
  private JScrollPane jScrollPane_Fundam = null;
  private JTextArea jTextArea_Fundam = null;
  public JLabel jLabel_Count = null;
  
  String tag = "";
  
  public Frame_Indic()
  {
    initialize();
  }
  
  public Dimension getSize()
  {
    return new Dimension(fmeApp.width - 35, 913);
  }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void set_params(String _tag, HashMap params) { tag = _tag;
    if ((params.get("IDT") != null) && (params.get("IDT").equals("0"))) {
      jPanel_IndicIDT.setVisible(false);
      up_component(jPanel_Fundam, jPanel_IndicIDT.getHeight() + 10);
      Dimension d = new Dimension(getWidth(), getHeight() - jPanel_IndicIDT.getHeight() - 10);
      setSize(d);
      setPreferredSize(d);
    }
  }
  
  private void initialize()
  {
    setSize(fmeApp.width - 35, 1400);
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
      jContentPane.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_IndicCertif(), null);
      jContentPane.add(getJPanel_IndicIDT(), null);
      jContentPane.add(getJPanel_Fundam(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_IndicCertif() {
    if (jPanel_IndicCertif == null) {
      jLabel_IndicCertif = new JLabel();
      jLabel_IndicCertif.setBounds(new Rectangle(12, 10, fmeApp.width - 90, 18));
      jLabel_IndicCertif.setText("A empresa tem ou espera vir a ter no pós projeto algum tipo de certificação? Se sim, identifique quais:");
      jLabel_IndicCertif.setFont(fmeComum.letra_bold);
      jLabel_IndicIDT = new JLabel();
      jLabel_IndicIDT.setFont(fmeComum.letra_bold);
      jLabel_IndicIDT.setText("Indicadores de I&DT");
      jLabel_IndicIDT.setBounds(new Rectangle(12, 335, 209, 18));
      
      jPanel_IndicCertif = new JPanel();
      jPanel_IndicCertif.setLayout(null);
      jPanel_IndicCertif.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 543));
      jPanel_IndicCertif.setBorder(fmeComum.blocoBorder);
      jPanel_IndicCertif.add(jLabel_IndicCertif, null);
      jPanel_IndicCertif.add(getJScrollPane_IndicCertif(), null);
    }
    return jPanel_IndicCertif;
  }
  
  public JScrollPane getJScrollPane_IndicCertif() {
    if (jScrollPane_IndicCertif == null) {
      jScrollPane_IndicCertif = new JScrollPane();
      jScrollPane_IndicCertif.setBounds(new Rectangle(10, 34, 619, 495));
      jScrollPane_IndicCertif.setViewportView(getJTable_IndicCertif());
      jScrollPane_IndicCertif.setHorizontalScrollBarPolicy(31);
      jScrollPane_IndicCertif.setVerticalScrollBarPolicy(21);
    }
    return jScrollPane_IndicCertif;
  }
  
  public JTable getJTable_IndicCertif() {
    if (jTable_IndicCertif == null) {
      jTable_IndicCertif = new JTable_Tip3(25);
      jTable_IndicCertif.setName("IndicCertif_Tabela");
    }
    return jTable_IndicCertif;
  }
  
  private JPanel getJPanel_IndicIDT() {
    if (jPanel_IndicIDT == null) {
      jLabel_IndicIDT = new JLabel();
      jLabel_IndicIDT.setFont(fmeComum.letra_bold);
      jLabel_IndicIDT.setText("Indicadores de I&DT");
      jLabel_IndicIDT.setBounds(new Rectangle(12, 10, 287, 18));
      
      jPanel_IndicIDT = new JPanel();
      jPanel_IndicIDT.setLayout(null);
      jPanel_IndicIDT.setBounds(new Rectangle(15, 603, fmeApp.width - 60, 100));
      jPanel_IndicIDT.setBorder(fmeComum.blocoBorder);
      jPanel_IndicIDT.add(jLabel_IndicIDT, null);
      jPanel_IndicIDT.add(getJScrollPane_IndicIDT(), null);
    }
    return jPanel_IndicIDT;
  }
  
  public JScrollPane getJScrollPane_IndicIDT()
  {
    if (jScrollPane_IndicIDT == null) {
      jScrollPane_IndicIDT = new JScrollPane();
      jScrollPane_IndicIDT.setBounds(new Rectangle(10, 34, fmeApp.width - 80, 51));
      jScrollPane_IndicIDT.setViewportView(getJTable_IndicIDT());
      jScrollPane_IndicIDT.setHorizontalScrollBarPolicy(31);
      jScrollPane_IndicIDT.setVerticalScrollBarPolicy(21);
    }
    return jScrollPane_IndicIDT;
  }
  
  public JTable getJTable_IndicIDT() {
    if (jTable_IndicIDT == null) {
      jTable_IndicIDT = new JTable_Tip(30);
    }
    return jTable_IndicIDT;
  }
  
  private JPanel getJPanel_Fundam() {
    if (jPanel_Fundam == null) {
      jLabel_Fundam = new JLabel();
      jLabel_Fundam.setBounds(new Rectangle(12, 10, 446, 18));
      jLabel_Fundam.setText("Fundamentação dos Indicadores");
      jLabel_Fundam.setFont(fmeComum.letra_bold);
      
      jPanel_Fundam = new JPanel();
      jPanel_Fundam.setLayout(null);
      jPanel_Fundam.setBounds(new Rectangle(15, 713, fmeApp.width - 60, 190));
      jPanel_Fundam.setBorder(fmeComum.blocoBorder);
      jPanel_Fundam.setName("cond_eleg_texto");
      
      jLabel_Count = new JLabel("");
      jLabel_Count.setBounds(new Rectangle(jPanel_Fundam.getWidth() - 200 - 15, getJScrollPane_Fundam().getY() - 15, 200, 20));
      jLabel_Count.setFont(fmeComum.letra_pequena);
      jLabel_Count.setForeground(Color.GRAY);
      jLabel_Count.setHorizontalAlignment(4);
      
      jPanel_Fundam.add(jLabel_Fundam, null);
      jPanel_Fundam.add(jLabel_Count, null);
      jPanel_Fundam.add(getJScrollPane_Fundam(), null);
    }
    
    return jPanel_Fundam;
  }
  
  public JScrollPane getJScrollPane_Fundam() {
    if (jScrollPane_Fundam == null) {
      jScrollPane_Fundam = new JScrollPane();
      jScrollPane_Fundam.setBounds(new Rectangle(15, 36, fmeApp.width - 90, 140));
      jScrollPane_Fundam.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Fundam.setVerticalScrollBarPolicy(20);
      jScrollPane_Fundam.setViewportView(getJTextArea_Fundam());
    }
    return jScrollPane_Fundam;
  }
  
  public JTextArea getJTextArea_Fundam() {
    if (jTextArea_Fundam == null) {
      jTextArea_Fundam = new JTextArea();
      jTextArea_Fundam.setLineWrap(true);
      jTextArea_Fundam.setWrapStyleWord(true);
      jTextArea_Fundam.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Fundam.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.IndicTxt.on_update("texto");
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
    
    print_handler.scaleToWidth((int)(1.15D * jPanel_IndicCertif.getWidth()));
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
    CBData.IndicCertif.Clear();
    CBData.IndicIDT.Clear();
    CBData.IndicTxt.Clear();
    CBData.IndicTxt.on_update("texto");
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.IndicCertif.validar(null));
    grp.add_grp(CBData.IndicIDT.validar(null));
    grp.add_grp(CBData.IndicTxt.validar(null));
    return grp;
  }
}
