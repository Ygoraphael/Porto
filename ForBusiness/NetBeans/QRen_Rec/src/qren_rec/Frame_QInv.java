package fme;

import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Rectangle;
import java.awt.event.MouseEvent;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;

public class Frame_QInv extends JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_QInv = null;
  private JLabel jLabel_QInv = null;
  private JScrollPane jScrollPane_QInv = null;
  private JTable_Tip jTable_QInv = null;
  private JButton jButton_QInvCopy = null;
  private JButton jButton_QInvUp = null;
  private JButton jButton_QInvAdd = null;
  private JButton jButton_QInvIns = null;
  private JButton jButton_QInvDel = null;
  
  String tag = "";
  
  public Frame_QInv()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(fmeApp.width - 35, 570);
  }
  
  String coluna_coop = "N";
  String coluna_conj = "N";
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (params.get("coop") != null) {
      coluna_coop = ((String)params.get("coop"));
    }
    if (params.get("conj") != null) {
      coluna_conj = ((String)params.get("conj"));
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
      jContentPane.add(getJPanel_QInv(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_QInv() {
    if (jPanel_QInv == null) {
      jButton_QInvCopy = new JButton(fmeComum.copiarLinha);
      jButton_QInvCopy.setBorder(BorderFactory.createEtchedBorder());
      jButton_QInvCopy.addMouseListener(new Frame_QInv_jButton_QInvCopy_mouseAdapter(this));
      jButton_QInvCopy.setToolTipText("Copiar Linha");
      jButton_QInvCopy.setBounds(new Rectangle(587, 11, 30, 22));
      jButton_QInvUp = new JButton(fmeComum.subirLinha);
      jButton_QInvUp.setBorder(BorderFactory.createEtchedBorder());
      jButton_QInvUp.addMouseListener(new Frame_QInv_jButton_QInvUp_mouseAdapter(this));
      jButton_QInvUp.setToolTipText("Trocar Linhas");
      jButton_QInvUp.setBounds(new Rectangle(627, 11, 30, 22));
      jButton_QInvAdd = new JButton(fmeComum.novaLinha);
      jButton_QInvAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_QInvAdd.addMouseListener(new Frame_QInv_jButton_QInvAdd_mouseAdapter(this));
      jButton_QInvAdd.setToolTipText("Nova Linha");
      jButton_QInvAdd.setBounds(new Rectangle(667, 11, 30, 22));
      jButton_QInvIns = new JButton(fmeComum.inserirLinha);
      jButton_QInvIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_QInvIns.addMouseListener(new Frame_QInv_jButton_QInvIns_mouseAdapter(this));
      jButton_QInvIns.setToolTipText("Inserir Linha");
      jButton_QInvIns.setBounds(new Rectangle(707, 11, 30, 22));
      jButton_QInvDel = new JButton(fmeComum.apagarLinha);
      jButton_QInvDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_QInvDel.addMouseListener(new Frame_QInv_jButton_QInvDel_mouseAdapter(this));
      jButton_QInvDel.setToolTipText("Apagar Linha");
      jButton_QInvDel.setBounds(new Rectangle(747, 11, 30, 22));
      
      jLabel_QInv = new JLabel();
      jLabel_QInv.setBounds(new Rectangle(12, 10, 262, 18));
      jLabel_QInv.setText("Quadro de Investimentos");
      jLabel_QInv.setFont(fmeComum.letra_bold);
      
      jPanel_QInv = new JPanel();
      jPanel_QInv.setLayout(null);
      jPanel_QInv.setOpaque(false);
      jPanel_QInv.setName("QInv_Quadro");
      jPanel_QInv.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 500));
      jPanel_QInv.setBorder(fmeComum.blocoBorder);
      jPanel_QInv.add(jLabel_QInv, null);
      jPanel_QInv.add(jButton_QInvCopy, null);
      jPanel_QInv.add(jButton_QInvUp, null);
      jPanel_QInv.add(jButton_QInvAdd, null);
      jPanel_QInv.add(jButton_QInvIns, null);
      jPanel_QInv.add(jButton_QInvDel, null);
      jPanel_QInv.add(getJScrollPane_QInv(), null);
    }
    return jPanel_QInv;
  }
  
  public JScrollPane getJScrollPane_QInv() {
    if (jScrollPane_QInv == null) {
      jScrollPane_QInv = new JScrollPane();
      jScrollPane_QInv.setBounds(new Rectangle(10, 40, fmeApp.width - 90, 448));
      jScrollPane_QInv.setViewportView(getJTable_QInv());
      jScrollPane_QInv.setName("QInv_ScrollPane");
      
      jScrollPane_QInv.setVerticalScrollBarPolicy(22);
    }
    

    return jScrollPane_QInv;
  }
  
  public JTable getJTable_QInv() {
    if (jTable_QInv == null) {
      jTable_QInv = new JTable_Tip(40, jScrollPane_QInv.getWidth());
      jTable_QInv.setRowHeight(18);
      jTable_QInv.setFont(fmeComum.letra);
      jTable_QInv.setName("QInv_Tabela");
      jTable_QInv.setAutoResizeMode(0);
      jTable_QInv.addExcelButton(jPanel_QInv, 547, 11, 14);
    }
    return jTable_QInv;
  }
  
  void jButton_QInvCopy_mouseClicked(MouseEvent e) { if (CBData.QInv.on_copy_row()) {
      CBData.QInv.calc_dados_projecto();
    }
  }
  
  void jButton_QInvUp_mouseClicked(MouseEvent e) {
    CBData.QInv.on_up_row();
  }
  
  void jButton_QInvAdd_mouseClicked(MouseEvent e) {
    CBData.QInv.on_add_row();
  }
  
  void jButton_QInvDel_mouseClicked(MouseEvent e) {
    if (CBData.QInv.on_del_row()) {
      CBData.QInv.calc_dados_projecto();
    }
    QInvhandler.j.revalidate();
    QInvhandler.j.repaint();
  }
  
  void jButton_QInvIns_mouseClicked(MouseEvent e) {
    CBData.QInv.on_ins_row();
  }
  
  void on_resize()
  {
    int pw = getContentPane().getWidth();
    int org = 640;
    int margem_x = jPanel_QInv.getX();
    int i_margem_x = jScrollPane_QInv.getX();
    int max = jTable_QInv.getWidth() + 2 * i_margem_x + 20;
    

    int w;
    

    int w;
    

    if (pw > org + 2 * margem_x) {
      int dw = pw - (org + 2 * margem_x);
      w = org + dw > max ? max : org + dw;
    } else {
      w = org;
    }
    

    jPanel_QInv.setBounds(jPanel_QInv.getX(), jPanel_QInv.getY(), w, 
      jPanel_QInv.getHeight());
    jScrollPane_QInv.setBounds(jScrollPane_QInv.getX(), jScrollPane_QInv.getY(), 
      w - 2 * i_margem_x, jScrollPane_QInv.getHeight());
    
    jPanel_QInv.revalidate();
    jPanel_QInv.repaint();
    jScrollPane_QInv.revalidate();
    jScrollPane_QInv.repaint();
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.setOrientation(0);
    
    print_handler.dx_expand = (jTable_QInv.getWidth() - jScrollPane_QInv.getWidth());
    int w = jPanel_QInv.getWidth() + print_handler.dx_expand;
    print_handler.scaleToWidth((int)(1.05D * w));
    print_handler.margem_x = 10;
    print_handler.margem_y = 50;
    
    print_handler.header = _lib.get_titulo(caption);
    print_handler.footer_medida = fmeComum.title;
    print_handler.footer_pag = _lib.get_pagina(caption);
    print_handler.footer_promotor = PromotorgetByName"nome"v;
    
    print_handler.print_page();
  }
  
  public int print(Graphics g, PageFormat pf, int pageIndex)
  {
    return print_handler.print(g, pf, pageIndex);
  }
  
  public void clear_page()
  {
    CBData.QInv.Clear();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.QInv.validar(null));
    return grp;
  }
}
