package fme;

import java.awt.Dimension;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.JCheckBox;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

public class Frame_Dominios extends javax.swing.JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_Dom = null;
  private JLabel jLabel_Dom = null;
  private JLabel jLabel_Dom2 = null;
  private JCheckBox jCheckBox_Dom_1Sim = null;
  public JCheckBox jCheckBox_Dom_1Clear = new JCheckBox();
  private JCheckBox jCheckBox_Dom_1_1Sim = null;
  public JCheckBox jCheckBox_Dom_1_1Clear = new JCheckBox();
  private JCheckBox jCheckBox_Dom_1_2Sim = null;
  public JCheckBox jCheckBox_Dom_1_2Clear = new JCheckBox();
  private JCheckBox jCheckBox_Dom_1_3Sim = null;
  public JCheckBox jCheckBox_Dom_1_3Clear = new JCheckBox();
  private JCheckBox jCheckBox_Dom_1_4Sim = null;
  public JCheckBox jCheckBox_Dom_1_4Clear = new JCheckBox();
  
  private JCheckBox jCheckBox_Dom_2Sim = null;
  public JCheckBox jCheckBox_Dom_2Clear = new JCheckBox();
  
  private JPanel jPanel_Fundamenta = null;
  private JLabel jLabel_Fundamenta = null;
  private JScrollPane jScrollPane_Fundamenta = null;
  private JTextArea jTextArea_Fundamenta = null;
  
  String tag = "";
  
  public Frame_Dominios()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(fmeApp.width - 35, 655);
  }
  
  void up_component(java.awt.Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void tirar_titulo() {
    jLabel_Titulo.setVisible(false);
    jLabel_PT2020.setVisible(false);
    up_component(jPanel_Dom, 30);
    up_component(jPanel_Fundamenta, 30);
  }
  
  public void set_params(String _tag, java.util.HashMap params) {
    tag = _tag;
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
      jLabel_Titulo = new LabelTitulo("CARACTERIZAÇÃO DO PROJETO");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_Dom(), null);
      jContentPane.add(getJPanel_Fundamenta(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_Dom() {
    if (jPanel_Dom == null) {
      jLabel_Dom = new JLabel();
      jLabel_Dom.setBounds(new Rectangle(12, 10, 616, 18));
      jLabel_Dom.setText("Domínios de Investimento");
      jLabel_Dom.setFont(fmeComum.letra_bold);
      
      jLabel_Dom2 = new JLabel();
      jLabel_Dom2.setBounds(new Rectangle(23, 36, 449, 18));
      jLabel_Dom2.setText("<html>Justificação da inserção do projeto nos seguintes domínios de investimento:</html>");
      jLabel_Dom2.setFont(fmeComum.letra);
      
      jPanel_Dom = new JPanel();
      jPanel_Dom.setLayout(null);
      jPanel_Dom.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 235));
      jPanel_Dom.setBorder(javax.swing.BorderFactory.createEtchedBorder());
      jPanel_Dom.add(jLabel_Dom, null);
      jPanel_Dom.add(jLabel_Dom2, null);
      jPanel_Dom.add(getJCheckBox_Dom_1Sim());
      jPanel_Dom.add(getJCheckBox_Dom_1_1Sim());
      jPanel_Dom.add(getJCheckBox_Dom_1_2Sim());
      jPanel_Dom.add(getJCheckBox_Dom_1_3Sim());
      jPanel_Dom.add(getJCheckBox_Dom_1_4Sim());
      jPanel_Dom.add(getJCheckBox_Dom_2Sim());
    }
    return jPanel_Dom;
  }
  
  public JCheckBox getJCheckBox_Dom_1Sim() { if (jCheckBox_Dom_1Sim == null) {
      jCheckBox_Dom_1Sim = new JCheckBox();
      jCheckBox_Dom_1Sim.setBounds(new Rectangle(49, 62, 381, 18));
      jCheckBox_Dom_1Sim.setText("Novos Produtos ou Processos, nas seguintes áreas:");
      jCheckBox_Dom_1Sim.setFont(fmeComum.letra);
      jCheckBox_Dom_1Sim.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try {
            CBData.Dominios.getByName("dom_1").vldOnline();
          } catch (Exception localException) {}
        }
      }); }
    return jCheckBox_Dom_1Sim;
  }
  
  public JCheckBox getJCheckBox_Dom_1_1Sim() {
    if (jCheckBox_Dom_1_1Sim == null) {
      jCheckBox_Dom_1_1Sim = new JCheckBox();
      jCheckBox_Dom_1_1Sim.setBounds(new Rectangle(76, 87, 447, 18));
      jCheckBox_Dom_1_1Sim.setText("Aquisição e transferência de tecnologia");
      jCheckBox_Dom_1_1Sim.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try {
            CBData.Dominios.getByName("dom_1_1").vldOnline();
          } catch (Exception localException) {}
        }
      });
      jCheckBox_Dom_1_1Sim.setFont(fmeComum.letra);
    }
    return jCheckBox_Dom_1_1Sim;
  }
  
  public JCheckBox getJCheckBox_Dom_1_2Sim() {
    if (jCheckBox_Dom_1_2Sim == null) {
      jCheckBox_Dom_1_2Sim = new JCheckBox();
      jCheckBox_Dom_1_2Sim.setBounds(new Rectangle(76, 112, 447, 18));
      jCheckBox_Dom_1_2Sim.setText("Engenharia e desenvolvimento");
      jCheckBox_Dom_1_2Sim.setFont(fmeComum.letra);
      jCheckBox_Dom_1_2Sim.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try {
            CBData.Dominios.getByName("dom_1_2").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jCheckBox_Dom_1_2Sim;
  }
  
  public JCheckBox getJCheckBox_Dom_1_3Sim() {
    if (jCheckBox_Dom_1_3Sim == null) {
      jCheckBox_Dom_1_3Sim = new JCheckBox();
      jCheckBox_Dom_1_3Sim.setBounds(new Rectangle(76, 137, 447, 18));
      jCheckBox_Dom_1_3Sim.setText("Novos produtos e soluções inovadoras");
      jCheckBox_Dom_1_3Sim.setFont(fmeComum.letra);
      jCheckBox_Dom_1_3Sim.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try {
            CBData.Dominios.getByName("dom_1_3").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jCheckBox_Dom_1_3Sim;
  }
  
  public JCheckBox getJCheckBox_Dom_1_4Sim() {
    if (jCheckBox_Dom_1_4Sim == null) {
      jCheckBox_Dom_1_4Sim = new JCheckBox();
      jCheckBox_Dom_1_4Sim.setBounds(new Rectangle(76, 162, 447, 18));
      jCheckBox_Dom_1_4Sim.setText("Internacionalização, incluindo participação em redes de fornecimento integrado");
      jCheckBox_Dom_1_4Sim.setFont(fmeComum.letra);
      jCheckBox_Dom_1_4Sim.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try {
            CBData.Dominios.getByName("dom_1_4").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jCheckBox_Dom_1_4Sim;
  }
  
  public JCheckBox getJCheckBox_Dom_2Sim() {
    if (jCheckBox_Dom_2Sim == null) {
      jCheckBox_Dom_2Sim = new JCheckBox();
      jCheckBox_Dom_2Sim.setBounds(new Rectangle(49, 192, 381, 18));
      jCheckBox_Dom_2Sim.setText("Redes de empresas para internacionalização");
      jCheckBox_Dom_2Sim.setFont(fmeComum.letra);
    }
    return jCheckBox_Dom_2Sim;
  }
  
  private JPanel getJPanel_Fundamenta() {
    if (jPanel_Fundamenta == null) {
      jLabel_Fundamenta = new JLabel();
      jLabel_Fundamenta.setBounds(new Rectangle(12, 10, 616, 18));
      jLabel_Fundamenta.setText("Demonstrar a inserção no(s) domínio(s) selecionado(s)");
      jLabel_Fundamenta.setFont(fmeComum.letra_bold);
      
      jPanel_Fundamenta = new JPanel();
      jPanel_Fundamenta.setLayout(null);
      jPanel_Fundamenta.setBounds(new Rectangle(15, 295, fmeApp.width - 60, 350));
      jPanel_Fundamenta.setBorder(javax.swing.BorderFactory.createEtchedBorder());
      jPanel_Fundamenta.setName("fundamenta_texto");
      jPanel_Fundamenta.add(jLabel_Fundamenta, null);
      jPanel_Fundamenta.add(getJScrollPane_Fundamenta(), null);
    }
    return jPanel_Fundamenta;
  }
  
  private JScrollPane getJScrollPane_Fundamenta() { if (jScrollPane_Fundamenta == null) {
      jScrollPane_Fundamenta = new JScrollPane();
      jScrollPane_Fundamenta.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 300));
      jScrollPane_Fundamenta.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Fundamenta.setVerticalScrollBarPolicy(20);
      jScrollPane_Fundamenta.setBorder(javax.swing.BorderFactory.createLineBorder(java.awt.Color.black));
      jScrollPane_Fundamenta.setViewportView(getJTextArea_Fundamenta());
    }
    return jScrollPane_Fundamenta;
  }
  
  public JTextArea getJTextArea_Fundamenta() { if (jTextArea_Fundamenta == null) {
      jTextArea_Fundamenta = new JTextArea();
      jTextArea_Fundamenta.setFont(fmeComum.letra);
      jTextArea_Fundamenta.setLineWrap(true);
      jTextArea_Fundamenta.setWrapStyleWord(true);
      jTextArea_Fundamenta.setMargin(new java.awt.Insets(5, 5, 5, 5));
    }
    return jTextArea_Fundamenta;
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.scaleToWidth((int)(1.05D * jPanel_Dom.getWidth()));
    print_handler.margem_y = 50;
    
    print_handler.header = _lib.get_titulo(caption);
    print_handler.footer_medida = fmeComum.title;
    print_handler.footer_pag = _lib.get_pagina(caption);
    print_handler.footer_promotor = PromotorgetByName"nome"v;
    
    print_handler.print_page();
  }
  
  public int print(java.awt.Graphics g, java.awt.print.PageFormat pf, int pageIndex) {
    return print_handler.print(g, pf, pageIndex);
  }
  
  public void clear_page()
  {
    CBData.Dominios.Clear();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.Dominios.validar(null));
    return grp;
  }
}
