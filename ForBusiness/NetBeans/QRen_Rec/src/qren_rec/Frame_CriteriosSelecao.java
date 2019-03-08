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

public class Frame_CriteriosSelecao extends JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_Txt_A1 = null;
  public JLabel jLabel_Design_A1 = null;
  public JScrollPane jScrollPane_Txt_A1 = null;
  public JTextArea jTextArea_Txt_A1 = null;
  public JLabel jLabel_Count_A1 = null;
  
  private JPanel jPanel_Txt_A2 = null;
  public JLabel jLabel_Design_A2 = null;
  public JScrollPane jScrollPane_Txt_A2 = null;
  public JTextArea jTextArea_Txt_A2 = null;
  public JLabel jLabel_Count_A2 = null;
  
  private JPanel jPanel_Txt_B1 = null;
  public JLabel jLabel_Design_B1 = null;
  public JScrollPane jScrollPane_Txt_B1 = null;
  public JTextArea jTextArea_Txt_B1 = null;
  public JLabel jLabel_Count_B1 = null;
  
  private JPanel jPanel_Criterio_B2 = null;
  public JLabel jLabel_Criterio_B2 = null;
  
  String tag = "";
  
  int y = 0; int h = 0;
  
  public Frame_CriteriosSelecao()
  {
    initialize();
  }
  

  public Dimension getSize() { return new Dimension(fmeApp.width - 60, y + h + 10); }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void set_params(String _tag, HashMap params) { tag = _tag; }
  

  private void initialize()
  {
    setSize(fmeApp.width - 35, h);
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
      jLabel_Titulo = new LabelTitulo("CRITÉRIOS DE SELEÇÃO");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setOpaque(false);
      jContentPane.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_Txt_A1(), null);
      jContentPane.add(getjPanel_Txt_A2(), null);
    }
    

    return jContentPane;
  }
  
  public JPanel getjPanel_Txt_A1() {
    int n_linhas = 1;
    
    y = 40;
    
    if (jPanel_Txt_A1 == null) {
      jLabel_Design_A1 = getJLabelDesign("<strong>A1. Coerência e racionalidade do projeto</strong>", n_linhas);
      jTextArea_Txt_A1 = getjTextArea();
      jTextArea_Txt_A1.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.CritSelA.on_update("texto_1");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_Txt_A1 = getjScrollPane(n_linhas);
      jScrollPane_Txt_A1.setViewportView(jTextArea_Txt_A1);
      
      jPanel_Txt_A1 = getJPanel(n_linhas);
      jPanel_Txt_A1.setName("evolucao_texto");
      
      jLabel_Count_A1 = new JLabel("");
      jLabel_Count_A1.setBounds(new Rectangle(jPanel_Txt_A1.getWidth() - 200 - 15, 10, 200, 20));
      jLabel_Count_A1.setFont(fmeComum.letra_pequena);
      jLabel_Count_A1.setForeground(Color.GRAY);
      jLabel_Count_A1.setHorizontalAlignment(4);
      
      jPanel_Txt_A1.add(jLabel_Design_A1, null);
      jPanel_Txt_A1.add(jLabel_Count_A1, null);
      jPanel_Txt_A1.add(jScrollPane_Txt_A1, null);
    }
    return jPanel_Txt_A1;
  }
  
  public JPanel getjPanel_Txt_A2() {
    int n_linhas = 1;
    


    if (jPanel_Txt_A2 == null) {
      jLabel_Design_A2 = getJLabelDesign("<strong>A2. Grau de Inovação</strong> (se necessário argumentação adicional sobre o grau de inovação)", n_linhas);
      jTextArea_Txt_A2 = getjTextArea();
      jTextArea_Txt_A2.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.CritSelA.on_update("texto_2");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_Txt_A2 = getjScrollPane(n_linhas);
      jScrollPane_Txt_A2.setViewportView(jTextArea_Txt_A2);
      
      jPanel_Txt_A2 = getJPanel(n_linhas);
      jPanel_Txt_A2.setName("evolucao_texto");
      
      jLabel_Count_A2 = new JLabel("");
      jLabel_Count_A2.setBounds(new Rectangle(jPanel_Txt_A2.getWidth() - 200 - 15, 10, 200, 20));
      jLabel_Count_A2.setFont(fmeComum.letra_pequena);
      jLabel_Count_A2.setForeground(Color.GRAY);
      jLabel_Count_A2.setHorizontalAlignment(4);
      
      jPanel_Txt_A2.add(jLabel_Design_A2, null);
      jPanel_Txt_A2.add(jLabel_Count_A2, null);
      jPanel_Txt_A2.add(jScrollPane_Txt_A2, null);
    }
    return jPanel_Txt_A2;
  }
  



















































  public JLabel getJLabelDesign(String texto)
  {
    JLabel label = new JLabel(texto);
    label.setBounds(new Rectangle(15, 10, fmeApp.width - 90, 18));
    label.setVerticalAlignment(1);
    label.setFont(fmeComum.letra);
    return label;
  }
  
  public JLabel getJLabelDesign(String texto, int n_linhas) { JLabel label = getJLabelDesign("<html>" + texto + "</html>");
    label.setBounds(new Rectangle(15, 10, fmeApp.width - 90, n_linhas * 18));
    return label;
  }
  
  public JScrollPane getjScrollPane() {
    JScrollPane scrollpane = new JScrollPane();
    scrollpane.setBounds(new Rectangle(15, 25, fmeApp.width - 90, 170));
    scrollpane.setPreferredSize(new Dimension(250, 250));
    scrollpane.setVerticalScrollBarPolicy(20);
    return scrollpane;
  }
  
  public JScrollPane getjScrollPane(int n_linhas) {
    JScrollPane scrollpane = getjScrollPane();
    scrollpane.setBounds(new Rectangle(15, 25 + (n_linhas - 1) * 18, fmeApp.width - 90, 150));
    return scrollpane;
  }
  
  public JTextArea getjTextArea() { JTextArea textarea = new JTextArea();
    textarea.setFont(fmeComum.letra);
    textarea.setLineWrap(true);
    textarea.setWrapStyleWord(true);
    textarea.setMargin(new Insets(5, 5, 5, 5));
    return textarea;
  }
  
  public JPanel getJPanel(int n_linhas) { JPanel panel = new JPanel();
    panel.setLayout(null);
    panel.setOpaque(false);
    panel.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 190 + (n_linhas - 1) * 18));
    panel.setBorder(fmeComum.blocoBorder);
    
    return panel;
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    

    print_handler.scaleToWidth((int)(1.05D * getjPanel_Txt_A1().getWidth()));
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
    CBData.CritSelA.Clear();
    CBData.CritSelA.after_open();
  }
  

  public CHValid_Grp validar_pg()
  {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.CritSelA.validar(null));
    
    return grp;
  }
}
