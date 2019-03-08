package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.event.MouseEvent;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

public class Frame_VendasExt extends javax.swing.JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_VendasExt = null;
  private JLabel jLabel_VendasExt = null;
  private JScrollPane jScrollPane_VendasExt = null;
  private JTable_Tip jTable_VendasExt = null;
  private JButton jButton_VendasExtCopy = null;
  private JButton jButton_VendasExtUp = null;
  private JButton jButton_VendasExtAdd = null;
  private JButton jButton_VendasExtIns = null;
  private JButton jButton_VendasExtDel = null;
  
  private JPanel jPanel_Fundam = null;
  private JLabel jLabel_Fundam = null;
  private JScrollPane jScrollPane_Fundam = null;
  private JTextArea jTextArea_Fundam = null;
  public JLabel jLabel_Count = null;
  
  private JPanel jPanel_TxtImportacoes = null;
  private JLabel jLabel_TxtImportacoes = null;
  private JScrollPane jScrollPane_TxtImportacoes = null;
  private JTextArea jTextArea_TxtImportacoes = null;
  public JLabel jLabel_Count2 = null;
  
  String tag = "";
  
  int w = 945;
  
  public Frame_VendasExt()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(w, 850);
  }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void tirar_titulo() {
    jLabel_Titulo.setVisible(false);
    jLabel_PT2020.setVisible(false);
    up_component(jPanel_VendasExt, 40);
  }
  
  int n_anos = 4;
  public CBTabela_VendasExt cbd_vendas_ext;
  
  public void set_params(String _tag, HashMap params) { tag = _tag;
    if (params.get("n_anos") != null) {
      n_anos = Integer.parseInt((String)params.get("n_anos"));
    }
  }
  
  private void initialize() {
    setSize(1000, 1000);
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
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_VendasExt(), null);
      jContentPane.add(getJPanel_Fundam(), null);
      jContentPane.add(getJPanel_TxtImportacoes(), null);
    }
    return jContentPane;
  }
  
  public JPanel getJPanel_VendasExt() {
    if (jPanel_VendasExt == null) {
      jButton_VendasExtCopy = new JButton(fmeComum.copiarLinha);
      jButton_VendasExtCopy.setBorder(BorderFactory.createEtchedBorder());
      jButton_VendasExtCopy.addMouseListener(new Frame_VendasExt_jButton_VendasExtCopy_mouseAdapter(this));
      jButton_VendasExtCopy.setToolTipText("Copiar Linha");
      jButton_VendasExtCopy.setBounds(new Rectangle(437, 11, 30, 22));
      jButton_VendasExtUp = new JButton(fmeComum.subirLinha);
      jButton_VendasExtUp.setBorder(BorderFactory.createEtchedBorder());
      jButton_VendasExtUp.addMouseListener(new Frame_VendasExt_jButton_VendasExtUp_mouseAdapter(this));
      jButton_VendasExtUp.setToolTipText("Trocar Linhas");
      jButton_VendasExtUp.setBounds(new Rectangle(477, 11, 30, 22));
      jButton_VendasExtAdd = new JButton(fmeComum.novaLinha);
      jButton_VendasExtAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_VendasExtAdd.addMouseListener(new Frame_VendasExt_jButton_VendasExtAdd_mouseAdapter(this));
      jButton_VendasExtAdd.setToolTipText("Nova Linha");
      jButton_VendasExtAdd.setBounds(new Rectangle(517, 11, 30, 22));
      jButton_VendasExtIns = new JButton(fmeComum.inserirLinha);
      jButton_VendasExtIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_VendasExtIns.addMouseListener(new Frame_VendasExt_jButton_VendasExtIns_mouseAdapter(this));
      jButton_VendasExtIns.setToolTipText("Inserir Linha");
      jButton_VendasExtIns.setBounds(new Rectangle(557, 11, 30, 22));
      jButton_VendasExtDel = new JButton(fmeComum.apagarLinha);
      jButton_VendasExtDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_VendasExtDel.addMouseListener(new Frame_VendasExt_jButton_VendasExtDel_mouseAdapter(this));
      jButton_VendasExtDel.setToolTipText("Apagar Linha");
      jButton_VendasExtDel.setBounds(new Rectangle(597, 11, 30, 22));
      
      jLabel_VendasExt = new JLabel();
      jLabel_VendasExt.setBounds(new Rectangle(12, 10, 294, 18));
      jLabel_VendasExt.setText("<html>Vendas ao Exterior Indiretas</html>");
      jLabel_VendasExt.setFont(fmeComum.letra_bold);
      jPanel_VendasExt = new JPanel();
      jPanel_VendasExt.setLayout(null);
      jPanel_VendasExt.setOpaque(false);
      jPanel_VendasExt.setName("Mercados_Quadro");
      jPanel_VendasExt.setBounds(new Rectangle(15, 50, 920, 350));
      jPanel_VendasExt.setBorder(fmeComum.blocoBorder);
      jPanel_VendasExt.add(jLabel_VendasExt, null);
      jPanel_VendasExt.add(jButton_VendasExtCopy, null);
      jPanel_VendasExt.add(jButton_VendasExtUp, null);
      jPanel_VendasExt.add(jButton_VendasExtAdd, null);
      jPanel_VendasExt.add(jButton_VendasExtIns, null);
      jPanel_VendasExt.add(jButton_VendasExtDel, null);
      jPanel_VendasExt.add(getJScrollPane_VendasExt(), null);
    }
    return jPanel_VendasExt;
  }
  
  public JScrollPane getJScrollPane_VendasExt() {
    if (jScrollPane_VendasExt == null) {
      jScrollPane_VendasExt = new JScrollPane();
      jScrollPane_VendasExt.setName("Mercados_ScrollPane");
      jScrollPane_VendasExt.setBounds(new Rectangle(16, 36, 890, 300));
      jScrollPane_VendasExt.setViewportView(getJTable_VendasExt());
      jScrollPane_VendasExt.setHorizontalScrollBarPolicy(31);
      jScrollPane_VendasExt.setVerticalScrollBarPolicy(22);
    }
    
    return jScrollPane_VendasExt;
  }
  
  public javax.swing.JTable getJTable_VendasExt() {
    if (jTable_VendasExt == null)
    {
      jTable_VendasExt = new JTable_Tip(75, jScrollPane_VendasExt.getWidth());
      

      jTable_VendasExt.addExcelButton(jPanel_VendasExt, 397, 11, 14);
      jTable_VendasExt.setFont(fmeComum.letra);
      jTable_VendasExt.setRowHeight(18);
      jTable_VendasExt.setName("Mercados_Tabela");
      jTable_VendasExt.setAutoResizeMode(0);
      jTable_VendasExt.setSelectionMode(0);
    }
    return jTable_VendasExt;
  }
  
  void jButton_VendasExtCopy_mouseClicked(MouseEvent e)
  {
    cbd_vendas_ext.on_copy_row();
  }
  
  void jButton_VendasExtUp_mouseClicked(MouseEvent e)
  {
    cbd_vendas_ext.on_up_row();
  }
  
  void jButton_VendasExtAdd_mouseClicked(MouseEvent e) {
    cbd_vendas_ext.on_add_row();
  }
  
  void jButton_VendasExtDel_mouseClicked(MouseEvent e) {
    cbd_vendas_ext.on_del_row();
  }
  
  void jButton_VendasExtIns_mouseClicked(MouseEvent e)
  {
    cbd_vendas_ext.on_ins_row();
  }
  
  private JPanel getJPanel_Fundam() {
    if (jPanel_Fundam == null) {
      jLabel_Fundam = new JLabel();
      jLabel_Fundam.setBounds(new Rectangle(12, 10, fmeApp.width - 90, 18));
      jLabel_Fundam.setText("Fundamentação e caracterização das Vendas ao Exterior Indiretas");
      jLabel_Fundam.setFont(fmeComum.letra_bold);
      
      jPanel_Fundam = new JPanel();
      jPanel_Fundam.setLayout(null);
      jPanel_Fundam.setOpaque(false);
      jPanel_Fundam.setBounds(new Rectangle(15, 410, fmeApp.width - 60, 210));
      jPanel_Fundam.setBorder(fmeComum.blocoBorder);
      
      jLabel_Count = new JLabel("");
      jLabel_Count.setBounds(new Rectangle(jPanel_Fundam.getWidth() - 200 - 15, getJScrollPane_Fundam().getY() - 15, 200, 20));
      jLabel_Count.setFont(fmeComum.letra_pequena);
      jLabel_Count.setForeground(Color.GRAY);
      jLabel_Count.setHorizontalAlignment(4);
      
      jPanel_Fundam.setName("cond_eleg_texto");
      jPanel_Fundam.add(jLabel_Fundam, null);
      jPanel_Fundam.add(getJScrollPane_Fundam(), null);
      jPanel_Fundam.add(jLabel_Count, null);
    }
    return jPanel_Fundam;
  }
  
  public JScrollPane getJScrollPane_Fundam() {
    if (jScrollPane_Fundam == null) {
      jScrollPane_Fundam = new JScrollPane();
      jScrollPane_Fundam.setBounds(new Rectangle(15, 36, fmeApp.width - 90, 155));
      jScrollPane_Fundam.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Fundam.setVerticalScrollBarPolicy(22);
      
      jScrollPane_Fundam.setViewportView(getJTextArea_Fundam());
    }
    return jScrollPane_Fundam;
  }
  
  public JTextArea getJTextArea_Fundam() { if (jTextArea_Fundam == null) {
      jTextArea_Fundam = new JTextArea();
      jTextArea_Fundam.setFont(fmeComum.letra);
      jTextArea_Fundam.setLineWrap(true);
      jTextArea_Fundam.setWrapStyleWord(true);
      jTextArea_Fundam.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Fundam.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.VendasExtTxt.on_update("texto");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Fundam;
  }
  
  private JPanel getJPanel_TxtImportacoes() {
    if (jPanel_TxtImportacoes == null) {
      jLabel_TxtImportacoes = new JLabel();
      jLabel_TxtImportacoes.setBounds(new Rectangle(12, 10, fmeApp.width - 90, 18));
      jLabel_TxtImportacoes.setText("Substituição das Importações");
      jLabel_TxtImportacoes.setFont(fmeComum.letra_bold);
      
      jPanel_TxtImportacoes = new JPanel();
      jPanel_TxtImportacoes.setLayout(null);
      jPanel_TxtImportacoes.setOpaque(false);
      jPanel_TxtImportacoes.setBounds(new Rectangle(15, 630, fmeApp.width - 60, 210));
      jPanel_TxtImportacoes.setBorder(fmeComum.blocoBorder);
      
      jLabel_Count2 = new JLabel("");
      jLabel_Count2.setBounds(new Rectangle(jPanel_TxtImportacoes.getWidth() - 200 - 15, getJScrollPane_TxtImportacoes().getY() - 15, 200, 20));
      jLabel_Count2.setFont(fmeComum.letra_pequena);
      jLabel_Count2.setForeground(Color.GRAY);
      jLabel_Count2.setHorizontalAlignment(4);
      
      jPanel_TxtImportacoes.setName("cond_eleg_texto");
      jPanel_TxtImportacoes.add(jLabel_TxtImportacoes, null);
      jPanel_TxtImportacoes.add(getJScrollPane_TxtImportacoes(), null);
      jPanel_TxtImportacoes.add(jLabel_Count2, null);
    }
    return jPanel_TxtImportacoes;
  }
  
  public JScrollPane getJScrollPane_TxtImportacoes() {
    if (jScrollPane_TxtImportacoes == null) {
      jScrollPane_TxtImportacoes = new JScrollPane();
      jScrollPane_TxtImportacoes.setBounds(new Rectangle(15, 36, fmeApp.width - 90, 155));
      jScrollPane_TxtImportacoes.setPreferredSize(new Dimension(250, 250));
      jScrollPane_TxtImportacoes.setVerticalScrollBarPolicy(22);
      
      jScrollPane_TxtImportacoes.setViewportView(getJTextArea_TxtImportacoes());
    }
    return jScrollPane_TxtImportacoes;
  }
  
  public JTextArea getJTextArea_TxtImportacoes() { if (jTextArea_TxtImportacoes == null) {
      jTextArea_TxtImportacoes = new JTextArea();
      jTextArea_TxtImportacoes.setFont(fmeComum.letra);
      jTextArea_TxtImportacoes.setLineWrap(true);
      jTextArea_TxtImportacoes.setWrapStyleWord(true);
      jTextArea_TxtImportacoes.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_TxtImportacoes.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.VendasExtTxt.on_update("txt_import");
        }
        

        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_TxtImportacoes;
  }
  

  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.dx_expand = (jTable_VendasExt.getWidth() - jScrollPane_VendasExt.getWidth());
    int w = jPanel_VendasExt.getWidth() + print_handler.dx_expand;
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
    CBData.VendasExt.Clear();
    CBData.VendasExtTxt.Clear();
    CBData.VendasExtTxt.after_open();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.VendasExt.validar(null, ""));
    grp.add_grp(CBData.VendasExtTxt.validar_1(null));
    grp.add_grp(CBData.VendasExtTxt.validar_2(null));
    return grp;
  }
}
