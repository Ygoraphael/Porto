package fme;

import java.awt.Color;
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
import javax.swing.JFormattedTextField;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;
import javax.swing.JTextField;











public class Frame_Params
  extends JInternalFrame
  implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JPanel jPanel_Params = null;
  private JLabel jLabel_UE = null;
  private JLabel jLabel_PT2020 = null;
  
  public JLabel jLabel_LblAnoCand = null;
  private JTextField jTextField_AnoCand = null;
  private JLabel jLabel_Aviso = null;
  private JLabel jLabel_LblAviso = null;
  private JLabel jLabel_Designacao = null;
  private JLabel jLabel_LblDesignacao = null;
  public JLabel jLabel_ProgOperacional = null;
  public JTextField jTextField_ProgOperacional = null;
  public JTextField jTextField_ProgOperacionalD = null;
  private JLabel jLabel_LblProgOperacional = null;
  public JLabel jLabel_ObjTematico = null;
  public JTextField jTextField_ObjTematico = null;
  public JTextField jTextField_ObjTematicoD = null;
  private JLabel jLabel_LblObjTematico = null;
  public JLabel jLabel_Prioridade = null;
  public JTextField jTextField_Prioridade = null;
  public JTextField jTextField_PrioridadeD = null;
  private JLabel jLabel_LblPrioridade = null;
  public JLabel jLabel_Tipologia = null;
  public JTextField jTextField_Tipologia = null;
  public JTextField jTextField_TipologiaD = null;
  private JLabel jLabel_LblTipologia = null;
  private JLabel jLabel_LblLocalizacao = null;
  private JLabel jLabel_LblLocNorte = null;
  private JLabel jLabel_LblLocCentro = null;
  private JLabel jLabel_LblLocLisboa = null;
  private JLabel jLabel_LblLocAlentejo = null;
  private JLabel jLabel_LblLocAlgarve = null;
  private JLabel jLabel_LblLocNortePerc = null;
  private JLabel jLabel_LblLocCentroPerc = null;
  private JLabel jLabel_LblLocLisboaPerc = null;
  private JLabel jLabel_LblLocAlentejoPerc = null;
  private JLabel jLabel_LblLocAlgarvePerc = null;
  private JFormattedTextField jTextField_Norte = null;
  private JFormattedTextField jTextField_Centro = null;
  private JFormattedTextField jTextField_Lisboa = null;
  private JFormattedTextField jTextField_Alentejo = null;
  private JFormattedTextField jTextField_Algarve = null;
  
  private JLabel jLabel_LblResumo = null;
  private JScrollPane jScrollPane_Resumo = null;
  private JTextArea jTextArea_Resumo = null;
  public JLabel jLabel_Count = null;
  
  String tag = "";
  private int altura = 0;
  private int h = 0;
  
  int w_Lbl = 200; int x_Lbl = 15;
  int y = 100; int h2 = 30;
  int y_loc; int h_loc = 25;
  
  public Frame_Params()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(fmeApp.width - 35, h);
  }
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (((String)CParseConfig.hconfig.get("nuts_invest") != null) && 
      (((String)CParseConfig.hconfig.get("nuts_invest")).equals("n_pode_lx_alg"))) {
      jLabel_LblLocLisboa.setForeground(Color.LIGHT_GRAY);
      jLabel_LblLocLisboaPerc.setForeground(Color.LIGHT_GRAY);
      jLabel_LblLocAlgarve.setForeground(Color.LIGHT_GRAY);
      jLabel_LblLocAlgarvePerc.setForeground(Color.LIGHT_GRAY);
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
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(getJPanel_Params(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_Params() {
    if (jPanel_Params == null) {
      jLabel_UE = new JLabel();
      jLabel_UE.setIcon(fmeComum.logoUE);
      jLabel_UE.setBounds(new Rectangle(14, 6, 195, 53));
      
      jPanel_Params = new JPanel();
      jPanel_Params.setBounds(new Rectangle(this.y = 15, 10, fmeApp.width - 60, 245));
      jPanel_Params.setLayout(null);
      jPanel_Params.setBorder(fmeComum.blocoBorder);
      
      jLabel_PT2020 = new JLabel();
      jLabel_PT2020.setIcon(fmeComum.logoPT2020);
      jLabel_PT2020.setBounds(new Rectangle(jPanel_Params.getWidth() - 162 - 5, 6, 162, 53));
      
      jLabel_LblAnoCand = new JLabel();
      jLabel_LblAnoCand.setBounds(new Rectangle(x_Lbl, this.y = 60, w_Lbl, h2));
      jLabel_LblAnoCand.setText("Ano Referência:");
      jLabel_LblAnoCand.setVerticalAlignment(1);
      jLabel_LblAnoCand.setFont(fmeComum.letra_bold);
      
      jLabel_LblAviso = new JLabel();
      jLabel_LblAviso.setBounds(new Rectangle(x_Lbl, this.y += h2 + 5, w_Lbl, h2));
      jLabel_LblAviso.setText("Código:");
      jLabel_LblAviso.setVerticalAlignment(1);
      jLabel_LblAviso.setFont(fmeComum.letra_bold);
      
      jLabel_Aviso = new JLabel();
      jLabel_Aviso.setBounds(new Rectangle(w_Lbl, y, jPanel_Params.getWidth() - w_Lbl, h2));
      jLabel_Aviso.setVerticalAlignment(1);
      jLabel_Aviso.setText("<html>" + fmeApp.comum.aviso() + "</html>");
      jLabel_Aviso.setFont(fmeComum.letra);
      
      jLabel_LblDesignacao = new JLabel();
      jLabel_LblDesignacao.setBounds(new Rectangle(x_Lbl, this.y += h2 + 5, w_Lbl, h2));
      jLabel_LblDesignacao.setText("Designação:");
      jLabel_LblDesignacao.setVerticalAlignment(1);
      jLabel_LblDesignacao.setFont(fmeComum.letra_bold);
      
      jLabel_Designacao = new JLabel();
      jLabel_Designacao.setBounds(new Rectangle(w_Lbl, y, jPanel_Params.getWidth() - w_Lbl, h2));
      jLabel_Designacao.setVerticalAlignment(1);
      jLabel_Designacao.setText("<html>" + (String)CParseConfig.hconfig.get("aviso_d") + "</html>");
      jLabel_Designacao.setFont(fmeComum.letra);
      
      jLabel_LblProgOperacional = new JLabel();
      jLabel_LblProgOperacional.setBounds(new Rectangle(x_Lbl, this.y += h2 + 5, w_Lbl, h2));
      jLabel_LblProgOperacional.setText("Programa Operacional:");
      jLabel_LblProgOperacional.setVerticalAlignment(1);
      jLabel_LblProgOperacional.setFont(fmeComum.letra_bold);
      
      String POs = (String)CParseConfig.hconfig.get("aut_gestao");
      int count = (POs.length() - POs.replace("\\n", "").length()) / 2 + 1;
      int hPOs = h2 + count * 11 - (count == 1 ? 11 : 0);
      
      jLabel_ProgOperacional = new JLabel();
      jLabel_ProgOperacional.setBounds(new Rectangle(w_Lbl, y, jPanel_Params.getWidth() - w_Lbl, hPOs));
      jLabel_ProgOperacional.setVerticalAlignment(1);
      jLabel_ProgOperacional.setText("<html>" + POs.replace("\\n", "<br>") + "</html>");
      jLabel_ProgOperacional.setFont(fmeComum.letra);
      
      jTextField_ProgOperacional = new JTextField();
      jTextField_ProgOperacional.setBounds(new Rectangle(x_Lbl, y + 15, 100, 18));
      jTextField_ProgOperacional.setFont(fmeComum.letra);
      jTextField_ProgOperacional.setEditable(false);
      jTextField_ProgOperacional.setVisible(false);
      jTextField_ProgOperacional.setHorizontalAlignment(0);
      
      jTextField_ProgOperacionalD = new JTextField();
      jTextField_ProgOperacionalD = jTextField_ProgOperacional;
      
      jLabel_LblObjTematico = new JLabel();
      jLabel_LblObjTematico.setBounds(new Rectangle(x_Lbl, this.y += hPOs + 5, w_Lbl, h2));
      jLabel_LblObjTematico.setText("Objetivo Temático:");
      jLabel_LblObjTematico.setVerticalAlignment(1);
      jLabel_LblObjTematico.setFont(fmeComum.letra_bold);
      
      jLabel_ObjTematico = new JLabel();
      jLabel_ObjTematico.setBounds(new Rectangle(w_Lbl, y, jPanel_Params.getWidth() - w_Lbl, h2));
      jLabel_ObjTematico.setVerticalAlignment(1);
      jLabel_ObjTematico.setText("<html>" + (String)CParseConfig.hconfig.get("obj_tema") + "</html>");
      jLabel_ObjTematico.setFont(fmeComum.letra);
      
      jTextField_ObjTematico = new JTextField();
      jTextField_ObjTematico.setBounds(new Rectangle(x_Lbl, y + 15, 100, 18));
      jTextField_ObjTematico.setFont(fmeComum.letra);
      jTextField_ObjTematico.setEditable(false);
      jTextField_ObjTematico.setVisible(false);
      jTextField_ObjTematico.setHorizontalAlignment(0);
      
      jTextField_ObjTematicoD = new JTextField();
      jTextField_ObjTematicoD = jTextField_ObjTematico;
      
      jLabel_LblPrioridade = new JLabel();
      jLabel_LblPrioridade.setBounds(new Rectangle(x_Lbl, this.y += h2 + 5, w_Lbl, h2));
      jLabel_LblPrioridade.setText("Prioridade de Investimento:");
      jLabel_LblPrioridade.setVerticalAlignment(1);
      jLabel_LblPrioridade.setFont(fmeComum.letra_bold);
      
      jLabel_Prioridade = new JLabel();
      jLabel_Prioridade.setBounds(new Rectangle(w_Lbl, y, jPanel_Params.getWidth() - w_Lbl, h2));
      jLabel_Prioridade.setVerticalAlignment(1);
      jLabel_Prioridade.setText("<html>" + (String)CParseConfig.hconfig.get("prioridade") + "</html>");
      jLabel_Prioridade.setFont(fmeComum.letra);
      
      jTextField_Prioridade = new JTextField();
      jTextField_Prioridade.setBounds(new Rectangle(x_Lbl, y + 15, 100, 18));
      jTextField_Prioridade.setFont(fmeComum.letra);
      jTextField_Prioridade.setEditable(false);
      jTextField_Prioridade.setVisible(false);
      jTextField_Prioridade.setHorizontalAlignment(0);
      
      jTextField_PrioridadeD = new JTextField();
      jTextField_PrioridadeD = jTextField_Prioridade;
      
      jLabel_LblTipologia = new JLabel();
      jLabel_LblTipologia.setBounds(new Rectangle(x_Lbl, this.y += h2 + 5, w_Lbl, h2));
      jLabel_LblTipologia.setText("Tipologia de Intervenção:");
      jLabel_LblTipologia.setVerticalAlignment(1);
      jLabel_LblTipologia.setFont(fmeComum.letra_bold);
      
      jLabel_Tipologia = new JLabel();
      jLabel_Tipologia.setBounds(new Rectangle(w_Lbl, y, jPanel_Params.getWidth() - w_Lbl, h2));
      jLabel_Tipologia.setVerticalAlignment(1);
      jLabel_Tipologia.setText("<html>" + (String)CParseConfig.hconfig.get("tipologia") + "</html>");
      jLabel_Tipologia.setFont(fmeComum.letra);
      
      jTextField_Tipologia = new JTextField();
      jTextField_Tipologia.setBounds(new Rectangle(x_Lbl, y + 15, 100, 18));
      jTextField_Tipologia.setFont(fmeComum.letra);
      jTextField_Tipologia.setEditable(false);
      jTextField_Tipologia.setVisible(false);
      jTextField_Tipologia.setHorizontalAlignment(0);
      
      jTextField_TipologiaD = new JTextField();
      jTextField_TipologiaD = jTextField_Tipologia;
      
      jLabel_LblLocalizacao = new JLabel();
      jLabel_LblLocalizacao.setBounds(new Rectangle(x_Lbl, this.y += h2 + 5, w_Lbl, h2));
      jLabel_LblLocalizacao.setText("Localização do Projeto (NUTS II):");
      jLabel_LblLocalizacao.setVerticalAlignment(1);
      jLabel_LblLocalizacao.setFont(fmeComum.letra_bold);
      
      jLabel_LblLocNorte = new JLabel();
      jLabel_LblLocNorte.setBounds(new Rectangle(w_Lbl + 50, this.y_loc = y, 100, h_loc));
      jLabel_LblLocNorte.setText("Norte");
      jLabel_LblLocNorte.setVerticalAlignment(1);
      jLabel_LblLocNorte.setFont(fmeComum.letra);
      
      jLabel_LblLocNortePerc = new JLabel();
      jLabel_LblLocNortePerc.setBounds(new Rectangle(w_Lbl + 100 + 55, y_loc, 50, h_loc));
      jLabel_LblLocNortePerc.setText("%");
      jLabel_LblLocNortePerc.setVerticalAlignment(1);
      jLabel_LblLocNortePerc.setFont(fmeComum.letra);
      
      jLabel_LblLocCentro = new JLabel();
      jLabel_LblLocCentro.setBounds(new Rectangle(w_Lbl + 50, this.y += h_loc, 100, h_loc));
      jLabel_LblLocCentro.setText("Centro");
      jLabel_LblLocCentro.setVerticalAlignment(1);
      jLabel_LblLocCentro.setFont(fmeComum.letra);
      
      jLabel_LblLocCentroPerc = new JLabel();
      jLabel_LblLocCentroPerc.setBounds(new Rectangle(w_Lbl + 100 + 55, y, 50, h_loc));
      jLabel_LblLocCentroPerc.setText("%");
      jLabel_LblLocCentroPerc.setVerticalAlignment(1);
      jLabel_LblLocCentroPerc.setFont(fmeComum.letra);
      
      jLabel_LblLocLisboa = new JLabel();
      jLabel_LblLocLisboa.setBounds(new Rectangle(w_Lbl + 50, this.y += h_loc, 100, h_loc));
      jLabel_LblLocLisboa.setText("Lisboa");
      jLabel_LblLocLisboa.setVerticalAlignment(1);
      jLabel_LblLocLisboa.setFont(fmeComum.letra);
      
      jLabel_LblLocLisboaPerc = new JLabel();
      jLabel_LblLocLisboaPerc.setBounds(new Rectangle(w_Lbl + 100 + 55, y, 50, h_loc));
      jLabel_LblLocLisboaPerc.setText("%");
      jLabel_LblLocLisboaPerc.setVerticalAlignment(1);
      jLabel_LblLocLisboaPerc.setFont(fmeComum.letra);
      
      jLabel_LblLocAlentejo = new JLabel();
      jLabel_LblLocAlentejo.setBounds(new Rectangle(w_Lbl + 50, this.y += h_loc, 100, h_loc));
      jLabel_LblLocAlentejo.setText("Alentejo");
      jLabel_LblLocAlentejo.setVerticalAlignment(1);
      jLabel_LblLocAlentejo.setFont(fmeComum.letra);
      
      jLabel_LblLocAlentejoPerc = new JLabel();
      jLabel_LblLocAlentejoPerc.setBounds(new Rectangle(w_Lbl + 100 + 55, y, 50, h_loc));
      jLabel_LblLocAlentejoPerc.setText("%");
      jLabel_LblLocAlentejoPerc.setVerticalAlignment(1);
      jLabel_LblLocAlentejoPerc.setFont(fmeComum.letra);
      
      jLabel_LblLocAlgarve = new JLabel();
      jLabel_LblLocAlgarve.setBounds(new Rectangle(w_Lbl + 50, this.y += h_loc, 100, h_loc));
      jLabel_LblLocAlgarve.setText("Algarve");
      jLabel_LblLocAlgarve.setVerticalAlignment(1);
      jLabel_LblLocAlgarve.setFont(fmeComum.letra);
      
      jLabel_LblLocAlgarvePerc = new JLabel();
      jLabel_LblLocAlgarvePerc.setBounds(new Rectangle(w_Lbl + 100 + 55, y, 50, h_loc));
      jLabel_LblLocAlgarvePerc.setText("%");
      jLabel_LblLocAlgarvePerc.setVerticalAlignment(1);
      jLabel_LblLocAlgarvePerc.setFont(fmeComum.letra);
      
      Rectangle r = jPanel_Params.getBounds();
      height = (y + h2 + 15);
      jPanel_Params.setBounds(r);
      
      h = (height + y + 15);
      
      jPanel_Params.add(jLabel_UE, null);
      jPanel_Params.add(jLabel_PT2020, null);
      jPanel_Params.add(jLabel_LblAviso, null);
      jPanel_Params.add(jLabel_LblAnoCand, null);
      jPanel_Params.add(getJTextField_AnoCand(), null);
      jPanel_Params.add(jLabel_Aviso, null);
      jPanel_Params.add(jLabel_LblDesignacao, null);
      jPanel_Params.add(jLabel_Designacao, null);
      jPanel_Params.add(jLabel_LblProgOperacional, null);
      jPanel_Params.add(jLabel_ProgOperacional, null);
      jPanel_Params.add(jTextField_ProgOperacional, null);
      jPanel_Params.add(jTextField_ProgOperacionalD, null);
      jPanel_Params.add(jLabel_LblObjTematico, null);
      jPanel_Params.add(jLabel_ObjTematico, null);
      jPanel_Params.add(jTextField_ObjTematico, null);
      jPanel_Params.add(jTextField_ObjTematicoD, null);
      jPanel_Params.add(jLabel_LblPrioridade, null);
      jPanel_Params.add(jLabel_Prioridade, null);
      jPanel_Params.add(jTextField_Prioridade, null);
      jPanel_Params.add(jTextField_PrioridadeD, null);
      jPanel_Params.add(jLabel_LblTipologia, null);
      jPanel_Params.add(jLabel_Tipologia, null);
      jPanel_Params.add(jTextField_Tipologia, null);
      jPanel_Params.add(jTextField_TipologiaD, null);
      jPanel_Params.add(jLabel_LblLocalizacao, null);
      jPanel_Params.add(jLabel_LblLocNorte, null);
      jPanel_Params.add(jLabel_LblLocNortePerc, null);
      jPanel_Params.add(getJTextField_Norte(), null);
      jPanel_Params.add(jLabel_LblLocCentro, null);
      jPanel_Params.add(jLabel_LblLocCentroPerc, null);
      jPanel_Params.add(getJTextField_Centro(), null);
      jPanel_Params.add(jLabel_LblLocLisboa, null);
      jPanel_Params.add(jLabel_LblLocLisboaPerc, null);
      jPanel_Params.add(getJTextField_Lisboa(), null);
      jPanel_Params.add(jLabel_LblLocAlentejo, null);
      jPanel_Params.add(jLabel_LblLocAlentejoPerc, null);
      jPanel_Params.add(getJTextField_Alentejo(), null);
      jPanel_Params.add(jLabel_LblLocAlgarve, null);
      jPanel_Params.add(jLabel_LblLocAlgarvePerc, null);
      jPanel_Params.add(getJTextField_Algarve(), null);
      
      jLabel_LblResumo = new JLabel();
      jLabel_LblResumo.setBounds(new Rectangle(x_Lbl, this.y += h2 + 15, w_Lbl * 3, h2));
      jLabel_LblResumo.setText("<html><strong>Resumo:</strong><br>(breve descrição do projeto para efeitos de divulgação, que evidencie de forma clara o seu objetivo)</html>");
      jLabel_LblResumo.setVerticalAlignment(1);
      jLabel_LblResumo.setFont(fmeComum.letra);
      
      jLabel_Count = new JLabel("");
      jLabel_Count.setBounds(new Rectangle(jPanel_Params.getWidth() - 200 - 15, getJScrollPane_Resumo().getY() - 15, 200, 20));
      jLabel_Count.setFont(fmeComum.letra_pequena);
      jLabel_Count.setForeground(Color.GRAY);
      jLabel_Count.setHorizontalAlignment(4);
      
      r = jPanel_Params.getBounds();
      height = (y + h2 + 15 + 50 + 5 - 30);
      jPanel_Params.setBounds(r);
      
      h = (height + y + 15);
      
      jPanel_Params.add(jLabel_LblResumo, null);
      jPanel_Params.add(jLabel_Count, null);
      jPanel_Params.add(getJScrollPane_Resumo(), null);
    }
    return jPanel_Params;
  }
  
  public JTextField getJTextField_AnoCand()
  {
    if (jTextField_AnoCand == null) {
      jTextField_AnoCand = new JTextField();
      jTextField_AnoCand.setBounds(new Rectangle(w_Lbl, 60, 42, 18));
      
      jTextField_AnoCand.setFont(fmeComum.letra);
      jTextField_AnoCand.setEditable(false);
      jTextField_AnoCand.setHorizontalAlignment(0);
    }
    
    return jTextField_AnoCand;
  }
  
  public JFormattedTextField getJTextField_Norte() {
    if (jTextField_Norte == null) {
      jTextField_Norte = new JFormattedTextField();
      jTextField_Norte.setBounds(new Rectangle(w_Lbl + 100, this.y_loc -= 2, 50, 18));
      jTextField_Norte.setFont(fmeComum.letra);
      jTextField_Norte.setEditable(false);
      jTextField_Norte.setHorizontalAlignment(4);
    }
    return jTextField_Norte;
  }
  
  public JFormattedTextField getJTextField_Centro() {
    if (jTextField_Centro == null) {
      jTextField_Centro = new JFormattedTextField();
      jTextField_Centro.setBounds(new Rectangle(w_Lbl + 100, this.y_loc += h_loc, 50, 18));
      jTextField_Centro.setFont(fmeComum.letra);
      jTextField_Centro.setEditable(false);
      jTextField_Centro.setHorizontalAlignment(4);
    }
    return jTextField_Centro;
  }
  
  public JFormattedTextField getJTextField_Lisboa() {
    if (jTextField_Lisboa == null) {
      jTextField_Lisboa = new JFormattedTextField();
      jTextField_Lisboa.setBounds(new Rectangle(w_Lbl + 100, this.y_loc += h_loc, 50, 18));
      jTextField_Lisboa.setFont(fmeComum.letra);
      jTextField_Lisboa.setEditable(false);
      jTextField_Lisboa.setHorizontalAlignment(4);
    }
    return jTextField_Lisboa;
  }
  
  public JFormattedTextField getJTextField_Alentejo() {
    if (jTextField_Alentejo == null) {
      jTextField_Alentejo = new JFormattedTextField();
      jTextField_Alentejo.setBounds(new Rectangle(w_Lbl + 100, this.y_loc += h_loc, 50, 18));
      jTextField_Alentejo.setFont(fmeComum.letra);
      jTextField_Alentejo.setEditable(false);
      jTextField_Alentejo.setHorizontalAlignment(4);
    }
    return jTextField_Alentejo;
  }
  
  public JFormattedTextField getJTextField_Algarve() {
    if (jTextField_Algarve == null) {
      jTextField_Algarve = new JFormattedTextField();
      jTextField_Algarve.setBounds(new Rectangle(w_Lbl + 100, this.y_loc += h_loc, 50, 18));
      jTextField_Algarve.setFont(fmeComum.letra);
      jTextField_Algarve.setEditable(false);
      jTextField_Algarve.setHorizontalAlignment(4);
    }
    return jTextField_Algarve;
  }
  
  public JScrollPane getJScrollPane_Resumo() {
    if (jScrollPane_Resumo == null) {
      jScrollPane_Resumo = new JScrollPane();
      jScrollPane_Resumo.setBounds(new Rectangle(x_Lbl, this.y += h2, fmeApp.width - 90, 50));
      jScrollPane_Resumo.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Resumo.setVerticalScrollBarPolicy(20);
      jScrollPane_Resumo.setViewportView(getJTextArea_Resumo());
    }
    return jScrollPane_Resumo;
  }
  
  public JTextArea getJTextArea_Resumo() {
    if (jTextArea_Resumo == null) {
      jTextArea_Resumo = new JTextArea();
      jTextArea_Resumo.setLineWrap(true);
      jTextArea_Resumo.setWrapStyleWord(true);
      jTextArea_Resumo.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Resumo.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.Params.on_update("txt_resumo");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Resumo;
  }
  
  public void print_page() {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.scaleToWidth((int)(1.05D * jPanel_Params.getWidth()));
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
    CBData.Params.Clear();
    CBData.Params.init();
    CBData.Params.on_update("txt_resumo");
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.Params.validar(null));
    return grp;
  }
}
