package fme;

import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.JComboBox;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;

public class Frame_DescFisica extends javax.swing.JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_DescFisica = null;
  private JLabel jLabel_DescFisica = null;
  private JLabel jLabel_Areas = null;
  private JScrollPane jScrollPane_Areas = null;
  private JTable_Tip jTable_Areas = null;
  private JLabel jLabel_GrupoEmp = null;
  private SteppedComboBox jComboBox_GrupoEmp = null;
  private JLabel jLabel_Empreendimento = null;
  private SteppedComboBox jComboBox_Empreendimento = null;
  private JLabel jLabel_Regime = null;
  private SteppedComboBox jComboBox_Regime = null;
  private JLabel jLabel_Capacidade = null;
  private JScrollPane jScrollPane_Capacidade = null;
  private JTable_Tip jTable_Capacidade = null;
  
  String tag = "";
  
  public Frame_DescFisica()
  {
    initialize();
  }
  
  public Dimension getSize()
  {
    return new Dimension(660, 1045);
  }
  
  private void initialize() {
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
      jContentPane.setOpaque(false);
      jContentPane.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_DescFisica(), null);
    }
    return jContentPane;
  }
  
  private JPanel getjPanel_DescFisica() {
    if (jPanel_DescFisica == null) {
      jLabel_Areas = new JLabel();
      jLabel_Areas.setBounds(new Rectangle(12, 35, 209, 18));
      jLabel_Areas.setText("Áreas");
      jLabel_Areas.setFont(fmeComum.letra_bold);
      jLabel_DescFisica = new JLabel();
      jLabel_DescFisica.setBounds(new Rectangle(12, 10, 301, 18));
      jLabel_DescFisica.setText("Descrição Física do Empreendimento");
      jLabel_DescFisica.setFont(fmeComum.letra_bold);
      jLabel_GrupoEmp = new JLabel();
      jLabel_GrupoEmp.setText("Grupo de Empreendimento");
      jLabel_GrupoEmp.setFont(fmeComum.letra);
      jLabel_GrupoEmp.setBounds(new Rectangle(25, 211, 146, 18));
      jLabel_Empreendimento = new JLabel();
      jLabel_Empreendimento.setText("Empreendimento");
      jLabel_Empreendimento.setFont(fmeComum.letra);
      jLabel_Empreendimento.setBounds(new Rectangle(25, 243, 146, 18));
      jLabel_Regime = new JLabel();
      jLabel_Regime.setBounds(new Rectangle(25, 275, 146, 18));
      jLabel_Regime.setFont(fmeComum.letra);
      jLabel_Regime.setText("Regime de Construção");
      jLabel_Capacidade = new JLabel();
      jLabel_Capacidade.setFont(fmeComum.letra_bold);
      jLabel_Capacidade.setText("Capacidade");
      jLabel_Capacidade.setBounds(new Rectangle(12, 315, 209, 18));
      
      jPanel_DescFisica = new JPanel();
      jPanel_DescFisica.setLayout(null);
      jPanel_DescFisica.setOpaque(false);
      jPanel_DescFisica.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 985));
      jPanel_DescFisica.setBorder(fmeComum.blocoBorder);
      jPanel_DescFisica.add(jLabel_DescFisica, null);
      jPanel_DescFisica.add(jLabel_Areas, null);
      jPanel_DescFisica.add(getJScrollPane_Areas(), null);
      jPanel_DescFisica.add(jLabel_GrupoEmp, null);
      jPanel_DescFisica.add(getJComboBox_GrupoEmp(), null);
      jPanel_DescFisica.add(jLabel_Empreendimento, null);
      jPanel_DescFisica.add(getJComboBox_Empreendimento(), null);
      jPanel_DescFisica.add(jLabel_Regime, null);
      jPanel_DescFisica.add(getJComboBox_Regime(), null);
      jPanel_DescFisica.add(jLabel_Capacidade, null);
      jPanel_DescFisica.add(getJScrollPane_Capacidade(), null);
    }
    return jPanel_DescFisica;
  }
  
  public JScrollPane getJScrollPane_Areas() {
    if (jScrollPane_Areas == null) {
      jScrollPane_Areas = new JScrollPane();
      jScrollPane_Areas.setBounds(new Rectangle(10, 55, 619, 136));
      jScrollPane_Areas.setViewportView(getJTable_Areas());
      jScrollPane_Areas.setHorizontalScrollBarPolicy(31);
      jScrollPane_Areas.setVerticalScrollBarPolicy(21);
    }
    
    return jScrollPane_Areas;
  }
  
  public JTable getJTable_Areas() {
    if (jTable_Areas == null) {
      jTable_Areas = new JTable_Tip(25);
      jTable_Areas.setRowHeight(18);
      jTable_Areas.setFont(fmeComum.letra);
      jTable_Areas.setAutoResizeMode(0);
    }
    return jTable_Areas;
  }
  
  public JComboBox getJComboBox_GrupoEmp() {
    if (jComboBox_GrupoEmp == null) {
      jComboBox_GrupoEmp = new SteppedComboBox();
      

      jComboBox_GrupoEmp.setBounds(new Rectangle(166, 211, 455, 18));
      

      jComboBox_GrupoEmp.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { CBData.Emp.getByName("grupo_empreend").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jComboBox_GrupoEmp;
  }
  
  public JComboBox getJComboBox_Empreendimento() { if (jComboBox_Empreendimento == null) {
      jComboBox_Empreendimento = new SteppedComboBox();
      

      jComboBox_Empreendimento.setBounds(new Rectangle(166, 243, 455, 18));
      

      jComboBox_Empreendimento.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { CBData.Emp.getByName("empreendimento").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jComboBox_Empreendimento;
  }
  
  public JComboBox getJComboBox_Regime() { if (jComboBox_Regime == null) {
      jComboBox_Regime = new SteppedComboBox();
      

      jComboBox_Regime.setBounds(new Rectangle(166, 275, 455, 18));
    }
    

    return jComboBox_Regime;
  }
  
  public JScrollPane getJScrollPane_Capacidade() {
    if (jScrollPane_Capacidade == null) {
      jScrollPane_Capacidade = new JScrollPane();
      jScrollPane_Capacidade.setBounds(new Rectangle(10, 335, 619, 640));
      jScrollPane_Capacidade.setViewportView(getJTable_Capacidade());
      jScrollPane_Capacidade.setHorizontalScrollBarPolicy(31);
      jScrollPane_Capacidade.setVerticalScrollBarPolicy(21);
    }
    
    return jScrollPane_Capacidade;
  }
  
  public JTable getJTable_Capacidade() {
    if (jTable_Capacidade == null) {
      jTable_Capacidade = new JTable_Tip(25);
      jTable_Capacidade.setRowHeight(18);
      jTable_Capacidade.setFont(fmeComum.letra);
      jTable_Capacidade.setAutoResizeMode(0);
    }
    return jTable_Capacidade;
  }
  

  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.scaleToWidth((int)(1.3D * jPanel_DescFisica.getWidth()));
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
    CBData.Areas.Clear();
    CBData.Emp.Clear();
    CBData.Capacidade.Clear();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.Areas.validar(null));
    grp.add_grp(CBData.Capacidade.validar(null));
    return grp;
  }
  
  public void set_params(String _tag, HashMap params) { tag = _tag; }
}
