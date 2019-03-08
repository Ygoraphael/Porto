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

public class Frame_Evolucao_Visao extends JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_Txt_1 = null;
  public JLabel jLabel_Design_1 = null;
  private JLabel jLabel_SubDesign_1 = null;
  private JScrollPane jScrollPane_Txt_1 = null;
  private JTextArea jTextArea_Txt_1 = null;
  public JLabel jLabel_Count_1 = null;
  
  private JPanel jPanel_Txt_2 = null;
  public JLabel jLabel_Design_2 = null;
  private JLabel jLabel_SubDesign_2 = null;
  private JScrollPane jScrollPane_Txt_2 = null;
  private JTextArea jTextArea_Txt_2 = null;
  public JLabel jLabel_Count_2 = null;
  
  String tag = "";
  
  public Frame_Evolucao_Visao()
  {
    initialize();
  }
  

  public Dimension getSize() { return new Dimension(fmeApp.width - 60, 954); }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void set_params(String _tag, HashMap params) { tag = _tag; }
  

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
      jLabel_Titulo = new LabelTitulo("CARACTERIZAÇÃO DO BENEFICIÁRIO");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setOpaque(false);
      jContentPane.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_Txt_1(), null);
      jContentPane.add(getjPanel_Txt_2(), null);
    }
    return jContentPane;
  }
  
  public JPanel getjPanel_Txt_1() {
    if (jPanel_Txt_1 == null)
    {
      jLabel_Design_1 = new JLabel("Evolução da Entidade Beneficiária");
      jLabel_Design_1.setBounds(new Rectangle(12, 10, 620, 18));
      jLabel_Design_1.setVerticalAlignment(1);
      jLabel_Design_1.setFont(fmeComum.letra_bold);
      
      jLabel_SubDesign_1 = new JLabel("<html>Breve historial da empresa assinalando:<br>(i) o perfil dos seus criadores, alterações ao capital social, participações e relações de grupo da empresa;<br>(ii) os pontos chave na evolução da sua atividade (houve mudanças ao longo do tempo? qual a atividade atual?), fases críticas e soluções implementadas;<br>(iii) Alterações de tecnologias e principais investimentos realizados.</html>");
      jLabel_SubDesign_1.setBounds(new Rectangle(15, 25, fmeApp.width - 90, 73));
      jLabel_SubDesign_1.setFont(fmeComum.letra);
      
      jPanel_Txt_1 = new JPanel();
      jPanel_Txt_1.setLayout(null);
      jPanel_Txt_1.setOpaque(false);
      jPanel_Txt_1.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 442));
      jPanel_Txt_1.setBorder(fmeComum.blocoBorder);
      jPanel_Txt_1.setName("evolucao_texto");
      
      jLabel_Count_1 = new JLabel("");
      jLabel_Count_1.setBounds(new Rectangle(jPanel_Txt_1.getWidth() - 200 - 15, getjScrollPane_Txt_1().getY() - 15, 200, 20));
      jLabel_Count_1.setFont(fmeComum.letra_pequena);
      jLabel_Count_1.setForeground(Color.GRAY);
      jLabel_Count_1.setHorizontalAlignment(4);
      
      jPanel_Txt_1.add(jLabel_Design_1, null);
      jPanel_Txt_1.add(jLabel_SubDesign_1, null);
      jPanel_Txt_1.add(jLabel_Count_1, null);
      jPanel_Txt_1.add(getjScrollPane_Txt_1(), null);
    }
    
    return jPanel_Txt_1;
  }
  
  public JScrollPane getjScrollPane_Txt_1() {
    if (jScrollPane_Txt_1 == null) {
      jScrollPane_Txt_1 = new JScrollPane();
      jScrollPane_Txt_1.setBounds(new Rectangle(15, 97, fmeApp.width - 90, 320));
      jScrollPane_Txt_1.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Txt_1.setVerticalScrollBarPolicy(20);
      
      jScrollPane_Txt_1.setViewportView(getjTextArea_Txt_1());
    }
    return jScrollPane_Txt_1;
  }
  
  public JTextArea getjTextArea_Txt_1() { if (jTextArea_Txt_1 == null) {
      jTextArea_Txt_1 = new JTextArea();
      jTextArea_Txt_1.setFont(fmeComum.letra);
      jTextArea_Txt_1.setLineWrap(true);
      jTextArea_Txt_1.setWrapStyleWord(true);
      jTextArea_Txt_1.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Txt_1.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.TxtEvolucao.on_update("texto");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Txt_1;
  }
  
  public JPanel getjPanel_Txt_2() {
    if (jPanel_Txt_2 == null)
    {
      jLabel_Design_2 = new JLabel("Visão, Missão e Objetivos Estratégicos");
      jLabel_Design_2.setBounds(new Rectangle(12, 10, 620, 18));
      jLabel_Design_2.setVerticalAlignment(1);
      jLabel_Design_2.setFont(fmeComum.letra_bold);
      
      jLabel_SubDesign_2 = new JLabel("<html>Breve descrição:<br>(i) Qual visão definida para a empresa;<br>(ii) Como definem a sua missão;<br>(iii) Quais os grandes objetivos estratégicos (máximo de 5 objetivos estratégicos).</html>");
      jLabel_SubDesign_2.setBounds(new Rectangle(15, 25, fmeApp.width - 90, 73));
      jLabel_SubDesign_2.setFont(fmeComum.letra);
      
      jPanel_Txt_2 = new JPanel();
      jPanel_Txt_2.setLayout(null);
      jPanel_Txt_2.setOpaque(false);
      jPanel_Txt_2.setBounds(new Rectangle(15, 502, fmeApp.width - 60, 442));
      jPanel_Txt_2.setBorder(fmeComum.blocoBorder);
      jPanel_Txt_2.setName("evolucao_texto");
      
      jLabel_Count_2 = new JLabel("");
      jLabel_Count_2.setBounds(new Rectangle(jPanel_Txt_2.getWidth() - 200 - 15, getjScrollPane_Txt_2().getY() - 15, 200, 20));
      jLabel_Count_2.setFont(fmeComum.letra_pequena);
      jLabel_Count_2.setForeground(Color.GRAY);
      jLabel_Count_2.setHorizontalAlignment(4);
      
      jPanel_Txt_2.add(jLabel_Design_2, null);
      jPanel_Txt_2.add(jLabel_SubDesign_2, null);
      jPanel_Txt_2.add(jLabel_Count_2, null);
      jPanel_Txt_2.add(getjScrollPane_Txt_2(), null);
    }
    
    return jPanel_Txt_2;
  }
  
  public JScrollPane getjScrollPane_Txt_2() {
    if (jScrollPane_Txt_2 == null) {
      jScrollPane_Txt_2 = new JScrollPane();
      jScrollPane_Txt_2.setBounds(new Rectangle(15, 97, fmeApp.width - 90, 320));
      jScrollPane_Txt_2.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Txt_2.setVerticalScrollBarPolicy(20);
      
      jScrollPane_Txt_2.setViewportView(getjTextArea_Txt_2());
    }
    return jScrollPane_Txt_2;
  }
  
  public JTextArea getjTextArea_Txt_2() { if (jTextArea_Txt_2 == null) {
      jTextArea_Txt_2 = new JTextArea();
      jTextArea_Txt_2.setFont(fmeComum.letra);
      jTextArea_Txt_2.setLineWrap(true);
      jTextArea_Txt_2.setWrapStyleWord(true);
      jTextArea_Txt_2.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Txt_2.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.TxtVisao.on_update("texto");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Txt_2;
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    

    print_handler.scaleToWidth((int)(1.05D * getjPanel_Txt_1().getWidth()));
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
    CBData.TxtEvolucao.Clear();
    CBData.TxtVisao.Clear();
    CBData.TxtEvolucao.on_update("texto");
    CBData.TxtVisao.on_update("texto");
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.TxtEvolucao.validar(null, ""));
    grp.add_grp(CBData.TxtVisao.validar(null, ""));
    return grp;
  }
}
