package fme;

import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.print.PageFormat;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;


public class Frame_TextoCriterios
  extends JInternalFrame
  implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  private JPanel jPanel_Crit = null;
  private JPanel jPanel_Txt = null;
  private JScrollPane jScrollPane_Txt = null;
  public JLabel jLabel_Lista = null;
  
  private JLabel jLabel_Factores = null;
  
  private JLabel jLabel_Design = null;
  
  private JLabel jLabel_Fundamento = null;
  
  private JTextArea jTextArea_Txt = null;
  
  String tag = "";
  private int altura = 0;
  private int h = 0;
  
  public Frame_TextoCriterios()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(fmeApp.width - 35, 971 - h);
  }
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (params.get("TITULO") != null) {
      jLabel_Titulo.setText((String)params.get("TITULO"));
    }
    if (params.get("DESIGN") != null) {
      jLabel_Design.setText((String)params.get("DESIGN"));
    }
    if (params.get("CRITERIOS") != null)
    {

      String s = "";
      String filename = (String)params.get("CRITERIOS");
      try {
        BufferedReader in = new BufferedReader(
          new InputStreamReader(getClass().getResourceAsStream(filename), "ISO-8859-15"));
        
        String s1 = in.readLine();
        while (s1 != null) {
          s = s + s1;
          s1 = in.readLine();
        }
      }
      catch (IOException e1)
      {
        JOptionPane.showMessageDialog(null, e1.getMessage());
      }
      
      jLabel_Lista.setText(s);
    }
    
    if (params.get("ALTURA") != null) {
      altura = Integer.parseInt((String)params.get("ALTURA"));
      h = (jLabel_Lista.getHeight() - altura);
      jLabel_Lista.setBounds(new Rectangle(13, 43, 612, 186 - h));
      jPanel_Crit.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 231 - h));
      jPanel_Txt.setBounds(new Rectangle(15, 291 - h, fmeApp.width - 60, 670));
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
      jLabel_Titulo = new LabelTitulo("%TITULO%");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setOpaque(false);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_Crit(), null);
      jContentPane.add(getJPanel_Txt(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_Crit() {
    if (jPanel_Crit == null) {
      jLabel_Design = new JLabel();
      jLabel_Design.setBounds(new Rectangle(12, 5, 603, 18));
      jLabel_Design.setText("%DESIGN%");
      jLabel_Design.setFont(fmeComum.letra_bold);
      jLabel_Factores = new JLabel();
      jLabel_Factores.setBounds(new Rectangle(12, 26, 214, 18));
      jLabel_Factores.setText("Fatores a abordar");
      jLabel_Factores.setFont(fmeComum.letra_bold);
      jLabel_Lista = new JLabel();
      jLabel_Lista.setBounds(new Rectangle(13, 43, 612, 186));
      jLabel_Lista.setText("%INDICE%");
      jLabel_Lista.setVerticalAlignment(1);
      jLabel_Lista.setVerticalTextPosition(1);
      
      jLabel_Lista.setFont(fmeComum.letra);
      jPanel_Crit = new JPanel();
      jPanel_Crit.setLayout(null);
      jPanel_Crit.setOpaque(false);
      jPanel_Crit.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 231));
      jPanel_Crit.setBorder(fmeComum.blocoBorder);
      jPanel_Crit.add(jLabel_Lista, null);
      jPanel_Crit.add(jLabel_Factores, null);
      jPanel_Crit.add(jLabel_Design, null);
    }
    
    return jPanel_Crit;
  }
  
  private JPanel getJPanel_Txt() {
    if (jPanel_Txt == null) {
      jLabel_Fundamento = new JLabel();
      jLabel_Fundamento.setBounds(new Rectangle(14, 8, 243, 21));
      jLabel_Fundamento.setText("Fundamentação");
      jLabel_Fundamento.setFont(fmeComum.letra_bold);
      jPanel_Txt = new JPanel();
      jPanel_Txt.setLayout(null);
      jPanel_Txt.setOpaque(false);
      jPanel_Txt.setBounds(new Rectangle(15, 291, fmeApp.width - 60, 670));
      jPanel_Txt.setBorder(fmeComum.blocoBorder);
      jPanel_Txt.setName("evolucao_texto");
      jPanel_Txt.add(getJScrollPane_Txt(), null);
      jPanel_Txt.add(jLabel_Fundamento, null);
    }
    
    return jPanel_Txt;
  }
  
  public JScrollPane getJScrollPane_Txt() {
    if (jScrollPane_Txt == null) {
      jScrollPane_Txt = new JScrollPane();
      jScrollPane_Txt.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 620));
      jScrollPane_Txt.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Txt.setVerticalScrollBarPolicy(20);
      
      jScrollPane_Txt.setViewportView(getJTextArea_Txt());
    }
    return jScrollPane_Txt;
  }
  
  public void print_page() {
    String caption = fmeApp.Paginas.getCaption(tag);
    System.out.println(caption);
    print_handler = new CHPrint(this);
    print_handler.start();
    

    print_handler.scaleToWidth((int)(1.15D * getJPanel_Txt().getWidth()));
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
  




  public JTextArea getJTextArea_Txt()
  {
    if (jTextArea_Txt == null) {
      jTextArea_Txt = new JTextArea();
      jTextArea_Txt.setFont(fmeComum.letra);
      jTextArea_Txt.setLineWrap(true);
      jTextArea_Txt.setWrapStyleWord(true);
      jTextArea_Txt.setMargin(new Insets(5, 5, 5, 5));
    }
    return jTextArea_Txt;
  }
}
