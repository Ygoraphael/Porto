package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.KeyEvent;
import java.awt.event.MouseEvent;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextArea;

public class Frame_Concorrencia extends javax.swing.JInternalFrame implements Pagina_Base
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
  
  private JPanel jPanel_MarcasProprias = null;
  private JLabel jLabel_MarcasProprias = null;
  private JScrollPane jScrollPane_MarcasProprias = null;
  private JTable_Tip jTable_MarcasProprias = null;
  private JButton jButton_MarcasPropriasAdd = null;
  private JButton jButton_MarcasPropriasIns = null;
  private JButton jButton_MarcasPropriasDel = null;
  
  private JPanel jPanel_MarcasOutras = null;
  private JLabel jLabel_MarcasOutras = null;
  private JScrollPane jScrollPane_MarcasOutras = null;
  private JTable_Tip jTable_MarcasOutras = null;
  private JButton jButton_MarcasOutrasAdd = null;
  private JButton jButton_MarcasOutrasIns = null;
  private JButton jButton_MarcasOutrasDel = null;
  
  int y = 0; int h = 0;
  
  String tag = "";
  
  public Frame_Concorrencia()
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
    up_component(jPanel_MarcasProprias, 40);
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
      jLabel_Titulo = new LabelTitulo("CARACTERIZAÇÃO DO BENEFICIÁRIO");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setOpaque(false);
      jContentPane.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_Txt(), null);
      jContentPane.add(getJPanel_MarcasProprias(), null);
      jContentPane.add(getJPanel_MarcasOutras(), null);
    }
    return jContentPane;
  }
  
  public JPanel getjPanel_Txt() {
    if (jPanel_Txt == null)
    {
      jLabel_Design = new JLabel("Análise da Concorrência");
      jLabel_Design.setBounds(new Rectangle(12, 10, 620, 18));
      jLabel_Design.setVerticalAlignment(1);
      jLabel_Design.setFont(fmeComum.letra_bold);
      
      jLabel_SubDesign = new JLabel("<html>Posicionamento da empresa perante os principais desafios concorrenciais, identificando principais concorrentes e segmentos de mercado.</html>");
      jLabel_SubDesign.setBounds(new Rectangle(15, 25, fmeApp.width - 90, 19));
      jLabel_SubDesign.setFont(fmeComum.letra);
      
      jPanel_Txt = new JPanel();
      jPanel_Txt.setLayout(null);
      jPanel_Txt.setOpaque(false);
      jPanel_Txt.setBounds(new Rectangle(15, this.y = 50, fmeApp.width - 60, this.h = 'Ġ'));
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
      jScrollPane_Txt.setBounds(new Rectangle(15, 43, fmeApp.width - 90, 220));
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
      jTextArea_Txt.addKeyListener(new java.awt.event.KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.AnaliseConcorrencia.on_update("txt_descricao");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Txt;
  }
  
  public JPanel getJPanel_MarcasProprias() {
    if (jPanel_MarcasProprias == null) {
      jButton_MarcasPropriasAdd = new JButton(fmeComum.novaLinha);
      jButton_MarcasPropriasAdd.addMouseListener(new Frame_Concorrencia_jButton_MarcasPropriasAdd_mouseAdapter(this));
      jButton_MarcasPropriasAdd.setToolTipText("Nova Linha");
      jButton_MarcasPropriasAdd.setBounds(new Rectangle(405, 11, 30, 22));
      jButton_MarcasPropriasIns = new JButton(fmeComum.inserirLinha);
      jButton_MarcasPropriasIns.addMouseListener(new Frame_Concorrencia_jButton_MarcasPropriasIns_mouseAdapter(this));
      jButton_MarcasPropriasIns.setToolTipText("Inserir Linha");
      jButton_MarcasPropriasIns.setBounds(new Rectangle(445, 11, 30, 22));
      jButton_MarcasPropriasDel = new JButton(fmeComum.apagarLinha);
      jButton_MarcasPropriasDel.addMouseListener(new Frame_Concorrencia_jButton_MarcasPropriasDel_mouseAdapter(this));
      jButton_MarcasPropriasDel.setToolTipText("Apagar Linha");
      jButton_MarcasPropriasDel.setBounds(new Rectangle(485, 11, 30, 22));
      
      jLabel_MarcasProprias = new JLabel();
      jLabel_MarcasProprias.setBounds(new Rectangle(12, 10, 294, 18));
      jLabel_MarcasProprias.setText("<html>Marcas Próprias</html>");
      jLabel_MarcasProprias.setFont(fmeComum.letra_bold);
      
      jPanel_MarcasProprias = new JPanel();
      jPanel_MarcasProprias.setLayout(null);
      jPanel_MarcasProprias.setOpaque(false);
      jPanel_MarcasProprias.setName("MarcasProprias_Quadro");
      jPanel_MarcasProprias.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = '¶'));
      jPanel_MarcasProprias.setBorder(fmeComum.blocoBorder);
      jPanel_MarcasProprias.add(jLabel_MarcasProprias, null);
      jPanel_MarcasProprias.add(jButton_MarcasPropriasAdd, null);
      jPanel_MarcasProprias.add(jButton_MarcasPropriasIns, null);
      jPanel_MarcasProprias.add(jButton_MarcasPropriasDel, null);
      jPanel_MarcasProprias.add(getJScrollPane_MarcasProprias(), null);
    }
    return jPanel_MarcasProprias;
  }
  
  public JScrollPane getJScrollPane_MarcasProprias() {
    if (jScrollPane_MarcasProprias == null) {
      jScrollPane_MarcasProprias = new JScrollPane();
      jScrollPane_MarcasProprias.setName("Mercados_ScrollPane");
      jScrollPane_MarcasProprias.setBounds(new Rectangle(15, 35, 500, 132));
      jScrollPane_MarcasProprias.setViewportView(getJTable_MarcasProprias());
      jScrollPane_MarcasProprias.setHorizontalScrollBarPolicy(31);
      jScrollPane_MarcasProprias.setVerticalScrollBarPolicy(22);
    }
    return jScrollPane_MarcasProprias;
  }
  
  public JTable getJTable_MarcasProprias() {
    if (jTable_MarcasProprias == null) {
      jTable_MarcasProprias = new JTable_Tip(40);
      jTable_MarcasProprias.setName("Mercados_Tabela");
    }
    return jTable_MarcasProprias;
  }
  
  void jButton_MarcasPropriasAdd_mouseClicked(MouseEvent e) {
    CBData.MarcasProprias.on_add_row();
  }
  
  void jButton_MarcasPropriasDel_mouseClicked(MouseEvent e) {
    CBData.MarcasProprias.on_del_row();
  }
  
  void jButton_MarcasPropriasIns_mouseClicked(MouseEvent e) {
    CBData.MarcasProprias.on_ins_row();
  }
  
  public JPanel getJPanel_MarcasOutras() {
    if (jPanel_MarcasOutras == null) {
      jButton_MarcasOutrasAdd = new JButton(fmeComum.novaLinha);
      jButton_MarcasOutrasAdd.addMouseListener(new Frame_Concorrencia_jButton_MarcasOutrasAdd_mouseAdapter(this));
      jButton_MarcasOutrasAdd.setToolTipText("Nova Linha");
      jButton_MarcasOutrasAdd.setBounds(new Rectangle(310, 11, 30, 22));
      jButton_MarcasOutrasIns = new JButton(fmeComum.inserirLinha);
      jButton_MarcasOutrasIns.addMouseListener(new Frame_Concorrencia_jButton_MarcasOutrasIns_mouseAdapter(this));
      jButton_MarcasOutrasIns.setToolTipText("Inserir Linha");
      jButton_MarcasOutrasIns.setBounds(new Rectangle(350, 11, 30, 22));
      jButton_MarcasOutrasDel = new JButton(fmeComum.apagarLinha);
      jButton_MarcasOutrasDel.addMouseListener(new Frame_Concorrencia_jButton_MarcasOutrasDel_mouseAdapter(this));
      jButton_MarcasOutrasDel.setToolTipText("Apagar Linha");
      jButton_MarcasOutrasDel.setBounds(new Rectangle(390, 11, 30, 22));
      
      jLabel_MarcasOutras = new JLabel();
      jLabel_MarcasOutras.setBounds(new Rectangle(12, 10, 294, 18));
      jLabel_MarcasOutras.setText("<html>Principais marcas da área de negócio</html>");
      jLabel_MarcasOutras.setFont(fmeComum.letra_bold);
      
      jPanel_MarcasOutras = new JPanel();
      jPanel_MarcasOutras.setLayout(null);
      jPanel_MarcasOutras.setOpaque(false);
      jPanel_MarcasOutras.setName("MarcasOutras_Quadro");
      jPanel_MarcasOutras.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'À'));
      jPanel_MarcasOutras.setBorder(fmeComum.blocoBorder);
      jPanel_MarcasOutras.add(jLabel_MarcasOutras, null);
      jPanel_MarcasOutras.add(jButton_MarcasOutrasAdd, null);
      jPanel_MarcasOutras.add(jButton_MarcasOutrasIns, null);
      jPanel_MarcasOutras.add(jButton_MarcasOutrasDel, null);
      jPanel_MarcasOutras.add(getJScrollPane_MarcasOutras(), null);
    }
    return jPanel_MarcasOutras;
  }
  
  public JScrollPane getJScrollPane_MarcasOutras() {
    if (jScrollPane_MarcasOutras == null) {
      jScrollPane_MarcasOutras = new JScrollPane();
      jScrollPane_MarcasOutras.setName("MarcasOutras_ScrollPane");
      jScrollPane_MarcasOutras.setBounds(new Rectangle(15, 35, 405, 142));
      jScrollPane_MarcasOutras.setViewportView(getJTable_MarcasOutras());
      jScrollPane_MarcasOutras.setHorizontalScrollBarPolicy(31);
      jScrollPane_MarcasOutras.setVerticalScrollBarPolicy(22);
    }
    return jScrollPane_MarcasOutras;
  }
  
  public JTable getJTable_MarcasOutras() {
    if (jTable_MarcasOutras == null) {
      jTable_MarcasOutras = new JTable_Tip(50);
      jTable_MarcasOutras.setName("MarcasOutras_Tabela");
    }
    return jTable_MarcasOutras;
  }
  
  void jButton_MarcasOutrasAdd_mouseClicked(MouseEvent e) {
    CBData.MarcasOutras.on_add_row();
  }
  
  void jButton_MarcasOutrasDel_mouseClicked(MouseEvent e) {
    CBData.MarcasOutras.on_del_row();
  }
  
  void jButton_MarcasOutrasIns_mouseClicked(MouseEvent e) {
    CBData.MarcasOutras.on_ins_row();
  }
  

  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.dx_expand = (jTable_MarcasProprias.getWidth() - jScrollPane_MarcasProprias.getWidth());
    int w = jPanel_MarcasProprias.getWidth() + print_handler.dx_expand;
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
    CBData.AnaliseConcorrencia.Clear();
    CBData.AnaliseConcorrencia.on_update("txt_descricao");
    CBData.MarcasProprias.Clear();
    CBData.MarcasOutras.Clear();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.AnaliseConcorrencia.validar(null, ""));
    grp.add_grp(CBData.MarcasProprias.validar(null, ""));
    grp.add_grp(CBData.MarcasOutras.validar(null, ""));
    return grp;
  }
}
