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

public class Frame_Financ extends javax.swing.JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_Financ = null;
  private JLabel jLabel_Financ = null;
  private JLabel jLabel_nota = null;
  private JScrollPane jScrollPane_Financ = null;
  private JTable_Tip jTable_Financ = null;
  private JPanel jPanel_Fundam = null;
  private JLabel jLabel_Fundam = null;
  private JScrollPane jScrollPane_Fundam = null;
  private JTextArea jTextArea_Fundam = null;
  public JLabel jLabel_Count = null;
  
  String tag = "";
  
  public Frame_Financ()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(fmeApp.width - 35, 930);
  }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void tirar_titulo()
  {
    jLabel_Titulo.setVisible(false);
  }
  

  String hide_cols = "";
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (params.get("hide") != null) {
      hide_cols = ((String)params.get("hide"));
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
      jContentPane.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_Financ(), null);
      jContentPane.add(getJPanel_Fundam(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_Financ() {
    if (jPanel_Financ == null) {
      jLabel_Financ = new JLabel();
      jLabel_Financ.setBounds(new Rectangle(12, 10, 301, 18));
      jLabel_Financ.setText("Estrutura de Financiamento (Recursos Financeiros)");
      jLabel_Financ.setFont(fmeComum.letra_bold);
      

      jLabel_nota = new JLabel();
      jLabel_nota.setBounds(new Rectangle(9, 488, fmeApp.width - 90, 58));
      jLabel_nota.setFont(fmeComum.letra_pequena);
      jLabel_nota.setText("<html>(1) Novos capitais próprios<br>(2) Resultados Líquidos do Período +/- Gastos/Reversões de Depreciação e de Amortização + Imparidades + Provisões -/+ Aumentos/Reduções de Justo Valor<br>(3) Novos suprimentos a incorporar em capital próprio até ao encerramento do projeto</html>");
      


      jPanel_Financ = new JPanel();
      jPanel_Financ.setLayout(null);
      jPanel_Financ.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 550));
      jPanel_Financ.setBorder(fmeComum.blocoBorder);
      jPanel_Financ.add(jLabel_nota, null);
      jPanel_Financ.add(jLabel_Financ, null);
      jPanel_Financ.add(getJScrollPane_Financ(), null);
    }
    return jPanel_Financ;
  }
  
  public JScrollPane getJScrollPane_Financ() { if (jScrollPane_Financ == null) {
      jScrollPane_Financ = new JScrollPane();
      jScrollPane_Financ.setBounds(new Rectangle(9, 40, fmeApp.width - 90, 450));
      jScrollPane_Financ.setViewportView(getJTable_Financ());
    }
    return jScrollPane_Financ;
  }
  
  public JTable getJTable_Financ() { if (jTable_Financ == null) {
      jTable_Financ = new JTable_Tip(30, jScrollPane_Financ.getWidth());
      jTable_Financ.addExcelButton(jPanel_Financ, 597, 11, 14);
      jTable_Financ.setRowHeight(18);
      jTable_Financ.setFont(fmeComum.letra);
      jTable_Financ.setAutoResizeMode(0);
      jTable_Financ.setSelectionMode(0);
    }
    return jTable_Financ;
  }
  
  private JPanel getJPanel_Fundam()
  {
    if (jPanel_Fundam == null) {
      jLabel_Fundam = new JLabel();
      jLabel_Fundam.setBounds(new Rectangle(12, 10, fmeApp.width - 90, 18));
      jLabel_Fundam.setText("Descrição das Fontes de Financiamento");
      jLabel_Fundam.setFont(fmeComum.letra_bold);
      
      jPanel_Fundam = new JPanel();
      jPanel_Fundam.setLayout(null);
      jPanel_Fundam.setBounds(new Rectangle(15, 610, fmeApp.width - 60, 310));
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
      jTextArea_Fundam.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.FinanTxt.on_update("texto");
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
    
    print_handler.dx_expand = (jTable_Financ.getWidth() - jScrollPane_Financ.getWidth());
    int w = jPanel_Financ.getWidth() + print_handler.dx_expand;
    print_handler.scaleToWidth((int)(1.05D * w));
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
    CBData.Finan.Clear();
    CBData.QInv.calc_dados_projecto();
    CBData.FinanTxt.Clear();
    CBData.FinanTxt.on_update("texto");
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.Finan.validar(null));
    grp.add_grp(CBData.FinanTxt.validar(null));
    return grp;
  }
}
