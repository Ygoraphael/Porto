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
import java.awt.event.MouseEvent;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextArea;
import javax.swing.JTextField;

public class Frame_Atividades extends javax.swing.JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_Atividades = null;
  private JLabel jLabel_Atividades = null;
  private JScrollPane jScrollPane_Atividades = null;
  private JTable_Tip jTable_Atividades = null;
  private JButton jButton_AtividadesAdd = null;
  private JButton jButton_AtividadesIns = null;
  private JButton jButton_AtividadesDel = null;
  
  public JLabel jLabel_Design = null;
  private JScrollPane jScrollPane_Txt = null;
  private JTextArea jTextArea_Txt = null;
  public JLabel jLabel_Count = null;
  
  private JPanel jPanel_Detalhe = null;
  private JLabel jLabel_NrAcao = null;
  private JTextField jTextField_NrAcao = null;
  
  int y = 0; int h = 0;
  
  String tag = "";
  
  String texto_Descricao;
  
  public Frame_Atividades()
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
    up_component(jPanel_Atividades, 40);
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
    texto_Descricao = jLabel_Design.getText();
  }
  
  public void setDescricao(String design) {
    getJPanel_Atividades();
    if ((design == null) || (design.trim().equals("")))
      jLabel_Design.setText(texto_Descricao); else
      jLabel_Design.setText(design + " — " + texto_Descricao);
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
      jContentPane.add(getJPanel_Atividades(), null);
    }
    
    return jContentPane;
  }
  
  public JPanel getJPanel_Atividades() {
    if (jPanel_Atividades == null) {
      jButton_AtividadesAdd = new JButton(fmeComum.novaLinha);
      jButton_AtividadesAdd.addMouseListener(new Frame_Atividades_jButton_AtividadesAdd_mouseAdapter(this));
      jButton_AtividadesAdd.setToolTipText("Nova Linha");
      jButton_AtividadesAdd.setBounds(new Rectangle(667, 11, 30, 22));
      jButton_AtividadesIns = new JButton(fmeComum.inserirLinha);
      jButton_AtividadesIns.addMouseListener(new Frame_Atividades_jButton_AtividadesIns_mouseAdapter(this));
      jButton_AtividadesIns.setToolTipText("Inserir Linha");
      jButton_AtividadesIns.setBounds(new Rectangle(707, 11, 30, 22));
      jButton_AtividadesDel = new JButton(fmeComum.apagarLinha);
      jButton_AtividadesDel.addMouseListener(new Frame_Atividades_jButton_AtividadesDel_mouseAdapter(this));
      jButton_AtividadesDel.setToolTipText("Apagar Linha");
      jButton_AtividadesDel.setBounds(new Rectangle(747, 11, 30, 22));
      
      jLabel_Atividades = new JLabel();
      jLabel_Atividades.setBounds(new Rectangle(12, 10, 294, 18));
      jLabel_Atividades.setText("<html>Descrição das Atividades de Inovação</html>");
      jLabel_Atividades.setFont(fmeComum.letra_bold);
      
      jPanel_Atividades = new JPanel();
      jPanel_Atividades.setLayout(null);
      jPanel_Atividades.setOpaque(false);
      jPanel_Atividades.setName("Atividades_Quadro");
      jPanel_Atividades.setBounds(new Rectangle(15, this.y = 50, fmeApp.width - 60, this.h = 'Ɛ'));
      jPanel_Atividades.setBorder(fmeComum.blocoBorder);
      jPanel_Atividades.add(jLabel_Atividades, null);
      jPanel_Atividades.add(jButton_AtividadesAdd, null);
      jPanel_Atividades.add(jButton_AtividadesIns, null);
      jPanel_Atividades.add(jButton_AtividadesDel, null);
      jPanel_Atividades.add(getJScrollPane_Atividades(), null);
      
      jLabel_Design = new JLabel("Justificação");
      jLabel_Design.setBounds(new Rectangle(30, 210, 620, 18));
      jLabel_Design.setVerticalAlignment(1);
      jLabel_Design.setFont(fmeComum.letra_bold);
      
      jLabel_Count = new JLabel("");
      jLabel_Count.setBounds(new Rectangle(getjScrollPane_Txt().getWidth() + getjScrollPane_Txt().getX() - 200, getjScrollPane_Txt().getY() - 15, 200, 20));
      jLabel_Count.setFont(fmeComum.letra_pequena);
      jLabel_Count.setForeground(Color.GRAY);
      jLabel_Count.setHorizontalAlignment(4);
      
      jPanel_Atividades.add(jLabel_Design, null);
      jPanel_Atividades.add(jLabel_Count, null);
      jPanel_Atividades.add(getjScrollPane_Txt(), null);
      jPanel_Atividades.add(getJPanel_Detalhe(), null);
    }
    return jPanel_Atividades;
  }
  
  public JScrollPane getJScrollPane_Atividades() {
    if (jScrollPane_Atividades == null) {
      jScrollPane_Atividades = new JScrollPane();
      jScrollPane_Atividades.setName("Atividades_ScrollPane");
      jScrollPane_Atividades.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 160));
      jScrollPane_Atividades.setViewportView(getJTable_Atividades());
      jScrollPane_Atividades.setHorizontalScrollBarPolicy(31);
      jScrollPane_Atividades.setVerticalScrollBarPolicy(22);
    }
    return jScrollPane_Atividades;
  }
  
  public JTable getJTable_Atividades() {
    if (jTable_Atividades == null)
    {
      jTable_Atividades = new JTable_Tip(50, jScrollPane_Atividades.getWidth()) {
        private static final long serialVersionUID = 1L;
        
        public void changeSelection(int rowIndex, int columnIndex, boolean toggle, boolean extend) { super.changeSelection(rowIndex, columnIndex, toggle, extend);
          CHTabela handler = (CHTabela)getModel();
          d.on_row(j.getSelectedRow());
        }
        
      };
      jTable_Atividades.setName("Atividades_Tabela");
    }
    return jTable_Atividades;
  }
  
  void jButton_AtividadesAdd_mouseClicked(MouseEvent e) {
    CBData.Atividades.on_add_row();
  }
  
  void jButton_AtividadesDel_mouseClicked(MouseEvent e) {
    CBData.Atividades.on_del_row();
  }
  
  void jButton_AtividadesIns_mouseClicked(MouseEvent e) {
    CBData.Atividades.on_ins_row();
  }
  
  public JScrollPane getjScrollPane_Txt() {
    if (jScrollPane_Txt == null) {
      jScrollPane_Txt = new JScrollPane();
      jScrollPane_Txt.setBounds(new Rectangle(25, 230, fmeApp.width - 90 - 20, 120));
      jScrollPane_Txt.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Txt.setVerticalScrollBarPolicy(20);
      
      jScrollPane_Txt.setViewportView(getjTextArea_Txt());
    }
    return jScrollPane_Txt;
  }
  
  public JTextArea getjTextArea_Txt() {
    if (jTextArea_Txt == null) {
      jTextArea_Txt = new JTextArea();
      jTextArea_Txt.setFont(fmeComum.letra);
      jTextArea_Txt.setLineWrap(true);
      jTextArea_Txt.setWrapStyleWord(true);
      jTextArea_Txt.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Txt.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.DadosAtividade.on_update2();
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Txt;
  }
  
  public JPanel getJPanel_Detalhe() {
    if (jPanel_Detalhe == null) {
      jLabel_NrAcao = new JLabel("Nº de ações de prospeção/promoção");
      jLabel_NrAcao.setBounds(new Rectangle(30, 5, 250, 18));
      jLabel_NrAcao.setFont(fmeComum.letra_bold);
      
      jPanel_Detalhe = new JPanel();
      jPanel_Detalhe.setLayout(null);
      jPanel_Detalhe.setBounds(new Rectangle(0, 360, 640, 50));
      jPanel_Detalhe.setOpaque(false);
      
      jPanel_Detalhe.add(jLabel_NrAcao, null);
      jPanel_Detalhe.add(getJTextField_NrAcao(), null);
    }
    return jPanel_Detalhe;
  }
  
  public JTextField getJTextField_NrAcao() {
    if (jTextField_NrAcao == null) {
      jTextField_NrAcao = new javax.swing.JFormattedTextField();
      jTextField_NrAcao.setBounds(new Rectangle(260, 5, 50, 18));
      jTextField_NrAcao.setHorizontalAlignment(0);
    }
    return jTextField_NrAcao;
  }
  


  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.dx_expand = (jTable_Atividades.getWidth() - jScrollPane_Atividades.getWidth());
    int w = jPanel_Atividades.getWidth() + print_handler.dx_expand;
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
    CBData.clear_pg = true;
    CBData.Atividades.Clear();
    

    CBData.clear_pg = false;
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.Atividades.validar(null));
    
    return grp;
  }
}
