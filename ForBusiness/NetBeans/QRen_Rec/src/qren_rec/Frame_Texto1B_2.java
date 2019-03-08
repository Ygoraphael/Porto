package fme;

import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

public class Frame_Texto1B_2 extends JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  private JPanel jPanel_Txt = null;
  private JLabel jLabel_Design = null;
  private JLabel jLabel_Subdesign = null;
  private JScrollPane jScrollPane_Txt = null;
  private JTextArea jTextArea_Txt = null;
  
  String tag = "";
  
  public Frame_Texto1B_2()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(fmeApp.width - 35, 750);
  }
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (params.get("TITULO") != null) {
      jLabel_Titulo.setText((String)params.get("TITULO"));
    }
    if (params.get("DESIGN") != null) {
      jLabel_Design.setText((String)params.get("DESIGN"));
    }
    if (params.get("SUBDESIGN") != null) {
      jLabel_Subdesign.setText((String)params.get("SUBDESIGN"));
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
      jLabel_Titulo = new LabelTitulo("");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setOpaque(false);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_Txt(), null);
    }
    return jContentPane;
  }
  
  private JPanel getjPanel_Txt() {
    if (jPanel_Txt == null) {
      jLabel_Design = new JLabel();
      jLabel_Design.setBounds(new Rectangle(14, 10, fmeApp.width - 90, 18));
      jLabel_Design.setFont(fmeComum.letra_bold);
      
      jLabel_Subdesign = new JLabel();
      jLabel_Subdesign.setBounds(new Rectangle(25, 33, 598, 18));
      jLabel_Subdesign.setFont(fmeComum.letra);
      
      jPanel_Txt = new JPanel();
      jPanel_Txt.setLayout(null);
      jPanel_Txt.setOpaque(false);
      jPanel_Txt.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 690));
      jPanel_Txt.setBorder(fmeComum.blocoBorder);
      jPanel_Txt.setName("evolucao_texto");
      jPanel_Txt.add(jLabel_Design, null);
      jPanel_Txt.add(jLabel_Subdesign, null);
      jPanel_Txt.add(getJScrollPane_Txt(), null);
    }
    
    return jPanel_Txt;
  }
  
  public JScrollPane getJScrollPane_Txt() {
    if (jScrollPane_Txt == null) {
      jScrollPane_Txt = new JScrollPane();
      jScrollPane_Txt.setBounds(new Rectangle(15, 55, fmeApp.width - 90, 620));
      jScrollPane_Txt.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Txt.setVerticalScrollBarPolicy(20);
      
      jScrollPane_Txt.setViewportView(getJTextArea_Txt());
    }
    return jScrollPane_Txt;
  }
  
  public JTextArea getJTextArea_Txt() { if (jTextArea_Txt == null) {
      jTextArea_Txt = new JTextArea();
      jTextArea_Txt.setFont(fmeComum.letra);
      jTextArea_Txt.setLineWrap(true);
      jTextArea_Txt.setWrapStyleWord(true);
      jTextArea_Txt.setMargin(new Insets(5, 5, 5, 5));
    }
    return jTextArea_Txt;
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    

    print_handler.scaleToWidth((int)(1.05D * getjPanel_Txt().getWidth()));
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
  

  public void clear_page() {}
  
  public CHValid_Grp validar_pg()
  {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    return grp;
  }
}
