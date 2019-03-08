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
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

public class Frame_Texto1B_1 extends JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  private JPanel jPanel_Txt = null;
  private JLabel jLabel_Design = null;
  private JLabel jLabel_SubDesign = null;
  private int n_linhas = 0;
  private JScrollPane jScrollPane_Txt = null;
  private JTextArea jTextArea_Txt = null;
  public JLabel jLabel_Count = null;
  
  String tag = "";
  
  public Frame_Texto1B_1()
  {
    initialize();
  }
  

  public Dimension getSize() { return new Dimension(fmeApp.width - 35, 730 + n_linhas * 18); }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void tirar_titulo() { jLabel_Titulo.setVisible(false);
    jLabel_PT2020.setVisible(false);
    up_component(jPanel_Txt, 40);
  }
  
  public void set_params(String _tag, HashMap params) { tag = _tag;
    if (params.get("TITULO") != null) {
      jLabel_Titulo.setText((String)params.get("TITULO"));
    }
    if (params.get("DESIGN") != null) {
      String s = (String)params.get("DESIGN");
      s = s.replace("\\n", "<br>");
      s = "<html>" + s + "</html>";
      jLabel_Design.setText(s);
    }
    if (params.get("SUBDESIGN") != null) {
      String s = (String)params.get("SUBDESIGN");
      s = s.replace("\\n", "<br>");
      s = "<html>" + s + "</html>";
      
      jLabel_SubDesign.setText(s);
    }
    if (params.get("L_SUBDESIGN") != null) {
      n_linhas = Integer.parseInt((String)params.get("L_SUBDESIGN"));
      jLabel_SubDesign.setBounds(new Rectangle(15, 30, fmeApp.width - 90, 1 + n_linhas * 18));
      jLabel_Count.setBounds(new Rectangle(jPanel_Txt.getWidth() - 200 - 15, 35 + n_linhas * 18 - 15, 200, 20));
      jScrollPane_Txt.setBounds(new Rectangle(15, 35 + n_linhas * 18, fmeApp.width - 90, 620));
      jPanel_Txt.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 670 + n_linhas * 18));
      setSize(getSize());
      setPreferredSize(getSize());
    }
  }
  

  private void initialize()
  {
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
      jContentPane.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_Txt(), null);
    }
    return jContentPane;
  }
  
  public JPanel getjPanel_Txt() {
    if (jPanel_Txt == null)
    {
      jLabel_Design = new JLabel();
      jLabel_Design.setBounds(new Rectangle(12, 10, fmeApp.width - 90, 32));
      jLabel_Design.setVerticalAlignment(1);
      jLabel_Design.setFont(fmeComum.letra_bold);
      
      jLabel_SubDesign = new JLabel();
      jLabel_SubDesign.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 1 + n_linhas * 18));
      jLabel_SubDesign.setFont(fmeComum.letra);
      
      jPanel_Txt = new JPanel();
      jPanel_Txt.setLayout(null);
      jPanel_Txt.setOpaque(false);
      jPanel_Txt.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 670 + n_linhas * 18));
      jPanel_Txt.setBorder(fmeComum.blocoBorder);
      jPanel_Txt.setName("evolucao_texto");
      
      jLabel_Count = new JLabel("");
      jLabel_Count.setBounds(new Rectangle(jPanel_Txt.getWidth() - 200 - 15, getjScrollPane_Txt().getY() - 15, 200, 20));
      jLabel_Count.setFont(fmeComum.letra_pequena);
      jLabel_Count.setForeground(Color.GRAY);
      jLabel_Count.setHorizontalAlignment(4);
      
      jPanel_Txt.add(jLabel_Design, null);
      jPanel_Txt.add(jLabel_SubDesign, null);
      jPanel_Txt.add(jLabel_Count, null);
      jPanel_Txt.add(getjScrollPane_Txt(), null);
    }
    
    return jPanel_Txt;
  }
  
  public JScrollPane getjScrollPane_Txt() {
    if (jScrollPane_Txt == null) {
      jScrollPane_Txt = new JScrollPane();
      jScrollPane_Txt.setBounds(new Rectangle(15, 35 + n_linhas * 18, fmeApp.width - 90, 620));
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
      jTextArea_Txt.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {}
        
        public void keyPressed(KeyEvent arg0) {}
      });
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
