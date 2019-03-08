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
import javax.swing.BorderFactory;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

public class Frame_DescProj extends JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_Txt = null;
  public JLabel jLabel_Design = null;
  private JLabel jLabel_SubDesign = null;
  private JScrollPane jScrollPane_Txt = null;
  private JTextArea jTextArea_Txt = null;
  public JLabel jLabel_Count = null;
  
  int y = 0; int h = 0; int n_linhas = 0;
  
  String tag = "";
  
  public Frame_DescProj()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(fmeApp.width - 30, y + h + 10);
  }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void tirar_titulo() {
    jLabel_Titulo.setVisible(false);
    jLabel_PT2020.setVisible(false);
  }
  
  int n_anos = 4;
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (params.get("n_anos") != null) {
      n_anos = Integer.parseInt((String)params.get("n_anos"));
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
      jContentPane.setOpaque(false);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_Txt(), null);
    }
    
    return jContentPane;
  }
  
  public JPanel getjPanel_Txt() {
    if (jPanel_Txt == null)
    {
      jLabel_Design = new JLabel("Descrição do Projeto");
      jLabel_Design.setBounds(new Rectangle(12, 10, 620, 18));
      jLabel_Design.setVerticalAlignment(1);
      jLabel_Design.setFont(fmeComum.letra_bold);
      
      String txt = "";
      if (CParseConfig.hconfig.get("tipologia2") != null) {
        if (CParseConfig.hconfig.get("tipologia2").toString().equals("Q")) {
          n_linhas += 3;
          txt = "Descrição do projeto de investimento nos domínios imateriais de competitividade.<br>";
          txt = txt + "Descrição do objetivo de qualificação competitiva da empresa.<br>";
          txt = txt + "Identificação dos impactos previsto com o projeto.";
        } else if (CParseConfig.hconfig.get("tipologia2").toString().equals("I")) {
          n_linhas += 4;
          txt = "Descrição do plano de internacionalização.<br>";
          txt = txt + "Associação de objetivos de vendas e de captação de novos clientes a cada mercado.<br>";
          txt = txt + "Justificação dos mercados selecionados.<br>";
          txt = txt + "Descrição dos modelos associados ao processo de internacionalização.";
        }
      }
      
      jLabel_SubDesign = new JLabel("<html>" + txt + "</html>");
      jLabel_SubDesign.setBounds(new Rectangle(15, 25, fmeApp.width - 90, 1 + n_linhas * 18));
      jLabel_SubDesign.setFont(fmeComum.letra);
      
      jPanel_Txt = new JPanel();
      jPanel_Txt.setLayout(null);
      jPanel_Txt.setOpaque(false);
      jPanel_Txt.setBounds(new Rectangle(15, this.y = 50, fmeApp.width - 60, this.h = 470 + n_linhas * 18));
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
      jScrollPane_Txt.setBounds(new Rectangle(15, 25 + n_linhas * 18, fmeApp.width - 90, 420));
      jScrollPane_Txt.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Txt.setVerticalScrollBarPolicy(20);
      
      jScrollPane_Txt.setViewportView(getjTextArea_Txt());
    }
    return jScrollPane_Txt;
  }
  
  public JTextArea getjTextArea_Txt() { if (jTextArea_Txt == null) {
      jTextArea_Txt = new JTextArea();
      jTextArea_Txt.setFont(fmeComum.letra);
      jTextArea_Txt.setLineWrap(true);
      jTextArea_Txt.setWrapStyleWord(true);
      jTextArea_Txt.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Txt.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.DescProj.on_update("texto");
        }
        
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
    
    int w = jPanel_Txt.getWidth() + print_handler.dx_expand;
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
    CBData.DescProj.Clear();
    CBData.DescProj.on_update("texto");
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.DescProj.validar_1(null));
    
    return grp;
  }
}
