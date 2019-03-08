package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
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
import javax.swing.JTable;
import javax.swing.JTextArea;

public class Frame_Mercados extends javax.swing.JInternalFrame implements Pagina_Base
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
  
  private JPanel jPanel_BensServProj = null;
  private JLabel jLabel_BensServProj = null;
  public JScrollPane jScrollPane_BensServProj = null;
  public JTable_Tip jTable_BensServProj = null;
  private JButton jButton_BensServProjAdd = null;
  private JButton jButton_BensServProjIns = null;
  private JButton jButton_BensServProjDel = null;
  
  public JLabel jLabel_BensServProj_Txt = null;
  private JScrollPane jScrollPane_BensServProj_Txt = null;
  private JTextArea jTextArea_BensServProj_Txt = null;
  public JLabel jLabel_BensServProj_Txt_Count = null;
  



  String texto_BensServProj_Txt;
  



  private JPanel jPanel_Mercados = null;
  private JLabel jLabel_Mercados = null;
  private JScrollPane jScrollPane_Mercados = null;
  private JTable_Tip jTable_Mercados = null;
  private JButton jButton_MercadosCopy = null;
  private JButton jButton_MercadosUp = null;
  private JButton jButton_MercadosAdd = null;
  private JButton jButton_MercadosIns = null;
  private JButton jButton_MercadosDel = null;
  private JScrollPane jScrollPane_Mercados2 = null;
  private JTable_Tip jTable_Mercados2 = null;
  private JScrollPane jScrollPane_Mercados3 = null;
  private JTable_Tip jTable_Mercados3 = null;
  






















  int y = 0; int h = 0;
  
  String tag = "";
  
  public Frame_Mercados()
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
    up_component(jPanel_Mercados, 40);
  }
  
  int n_anos = 4;
  public CBTabela_Mercados cbd_mercados;
  
  public void set_params(String _tag, HashMap params) { tag = _tag;
    if (params.get("n_anos") != null) {
      n_anos = Integer.parseInt((String)params.get("n_anos"));
    }
    
    if (!CParseConfig.hconfig.get("tipologia2").toString().equals("I")) {
      getJPanel_BensServProj().setVisible(false);
      up_component(getJPanel_Mercados(), getJPanel_BensServProj().getHeight() + 10);
      h = getJPanel_Mercados().getHeight();
      y = getJPanel_Mercados().getY();
    }
  }
  
  private void initialize() {
    setSize(fmeApp.width - 35, 3000);
    setContentPane(getJContentPane());
    setResizable(false);
    setBorder(null);
    getContentPane().setLayout(null);
    setDebugGraphicsOptions(0);
    setMaximumSize(new Dimension(Integer.MAX_VALUE, Integer.MAX_VALUE));
    
    texto_BensServProj_Txt = jLabel_BensServProj_Txt.getText();
  }
  

  public void setDescricao_BensServProj(String design)
  {
    getJPanel_BensServProj();
    if ((design == null) || (design.trim().equals(""))) {
      jLabel_BensServProj_Txt.setText("<html>" + texto_BensServProj_Txt.replaceAll("\n", "<br>") + "</html>");
    }
    else
    {
      jLabel_BensServProj_Txt.setText("<html><strong>" + design + "</strong>  " + texto_BensServProj_Txt.replaceAll("\n", "<br>") + "</html>");
    }
  }
  

  private JPanel getJContentPane()
  {
    if (jContentPane == null) {
      jLabel_PT2020 = new Label2020();
      jLabel_Titulo = new LabelTitulo("CARACTERIZAÇÃO DO BENEFICIÁRIO");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setOpaque(false);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_Txt(), null);
      jContentPane.add(getJPanel_BensServProj(), null);
      jContentPane.add(getJPanel_Mercados(), null);
    }
    
    return jContentPane;
  }
  
  public JPanel getjPanel_Txt() {
    if (jPanel_Txt == null)
    {
      jLabel_Design = new JLabel("Análise do Mercado");
      jLabel_Design.setBounds(new Rectangle(12, 10, 620, 18));
      jLabel_Design.setVerticalAlignment(1);
      jLabel_Design.setFont(fmeComum.letra_bold);
      
      jLabel_SubDesign = new JLabel("<html>Mercados mais relevantes, situação atual e perspetiva futura<br>(Principais clientes, canais de distribuição, segmentação e evolução do mercado)</html>");
      jLabel_SubDesign.setBounds(new Rectangle(15, 25, fmeApp.width - 90, 37));
      jLabel_SubDesign.setFont(fmeComum.letra);
      
      jPanel_Txt = new JPanel();
      jPanel_Txt.setLayout(null);
      jPanel_Txt.setOpaque(false);
      jPanel_Txt.setBounds(new Rectangle(15, this.y = 50, fmeApp.width - 60, this.h = 'Ĳ'));
      jPanel_Txt.setBorder(fmeComum.blocoBorder);
      jPanel_Txt.setName("evolucao_texto");
      
      jLabel_Count = new JLabel("");
      jLabel_Count.setBounds(new Rectangle(jPanel_Txt.getWidth() - 200 - 15, getjScrollPane_Txt().getY() - 15, 200, 20));
      jLabel_Count.setFont(fmeComum.letra_pequena);
      jLabel_Count.setForeground(Color.GRAY);
      jLabel_Count.setHorizontalAlignment(4);
      
      jPanel_Txt.add(jLabel_Design, null);
      jPanel_Txt.add(jLabel_SubDesign, null);
      jPanel_Txt.add(getjScrollPane_Txt(), null);
      jPanel_Txt.add(jLabel_Count, null);
    }
    
    return jPanel_Txt;
  }
  
  public JScrollPane getjScrollPane_Txt() {
    if (jScrollPane_Txt == null) {
      jScrollPane_Txt = new JScrollPane();
      jScrollPane_Txt.setBounds(new Rectangle(15, 61, fmeApp.width - 90, 220));
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
          CBData.AnaliseMercados.on_update("txt_descricao");
        }
        

        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Txt;
  }
  
  public JPanel getJPanel_BensServProj() {
    if (jPanel_BensServProj == null)
    {
      jLabel_BensServProj = new JLabel();
      jLabel_BensServProj.setBounds(new Rectangle(15, 10, 500, 18));
      jLabel_BensServProj.setText("<html>Análise Bens / Serviços objeto do Projeto</html>");
      jLabel_BensServProj.setFont(fmeComum.letra_bold);
      
      jButton_BensServProjAdd = new JButton(fmeComum.novaLinha);
      jButton_BensServProjAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_BensServProjAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_BensServProjAdd.setToolTipText("Nova Linha");
      jButton_BensServProjAdd.addMouseListener(new Frame_Mercados_jButton_BensServProjAdd_mouseAdapter(this));
      jButton_BensServProjIns = new JButton(fmeComum.inserirLinha);
      jButton_BensServProjIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_BensServProjIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_BensServProjIns.setToolTipText("Inserir Linha");
      jButton_BensServProjIns.addMouseListener(new Frame_Mercados_jButton_BensServProjIns_mouseAdapter(this));
      jButton_BensServProjDel = new JButton(fmeComum.apagarLinha);
      jButton_BensServProjDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_BensServProjDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_BensServProjDel.setToolTipText("Apagar Linha");
      jButton_BensServProjDel.addMouseListener(new Frame_Mercados_jButton_BensServProjDel_mouseAdapter(this));
      
      jTable_BensServProj = new JTable_Tip(40) {
        private static final long serialVersionUID = 1L;
        
        public void changeSelection(int rowIndex, int columnIndex, boolean toggle, boolean extend) { super.changeSelection(rowIndex, columnIndex, toggle, extend);
          CHTabela handler = (CHTabela)getModel();
          d.on_row(j.getSelectedRow());
        }
        
      };
      jTable_BensServProj.setName("BensServProj_Tabela");
      


      jScrollPane_BensServProj = new JScrollPane();
      jScrollPane_BensServProj.setBounds(new Rectangle(15, 35, fmeApp.width - 90 - 200, 170));
      jScrollPane_BensServProj.setPreferredSize(new Dimension(250, 250));
      jScrollPane_BensServProj.setVerticalScrollBarPolicy(22);
      jScrollPane_BensServProj.setHorizontalScrollBarPolicy(31);
      jScrollPane_BensServProj.setBorder(fmeComum.blocoBorder);
      jScrollPane_BensServProj.setViewportView(jTable_BensServProj);
      
      jPanel_BensServProj = new JPanel();
      jPanel_BensServProj.setLayout(null);
      jPanel_BensServProj.setOpaque(false);
      jPanel_BensServProj.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'ż'));
      jPanel_BensServProj.setBorder(fmeComum.blocoBorder);
      jPanel_BensServProj.add(jLabel_BensServProj, null);
      jPanel_BensServProj.add(jButton_BensServProjAdd, null);
      jPanel_BensServProj.add(jButton_BensServProjIns, null);
      jPanel_BensServProj.add(jButton_BensServProjDel, null);
      jPanel_BensServProj.add(jScrollPane_BensServProj, null);
      
      jLabel_BensServProj_Txt = new JLabel("\n- Caraterizar os bens/serviços;\n- Demonstrar o Caráter Transacionável e Internacionalizável dos bens/serviços.");
      jLabel_BensServProj_Txt.setBounds(new Rectangle(30, 220, 620, 45));
      jLabel_BensServProj_Txt.setVerticalAlignment(1);
      jLabel_BensServProj_Txt.setFont(fmeComum.letra);
      
      jLabel_BensServProj_Txt_Count = new JLabel("");
      jLabel_BensServProj_Txt_Count.setBounds(new Rectangle(getjScrollPane_BensServProj_Txt().getWidth() + getjScrollPane_BensServProj_Txt().getX() - 200, getjScrollPane_BensServProj_Txt().getY() - 15, 200, 20));
      jLabel_BensServProj_Txt_Count.setFont(fmeComum.letra_pequena);
      jLabel_BensServProj_Txt_Count.setForeground(Color.GRAY);
      jLabel_BensServProj_Txt_Count.setHorizontalAlignment(4);
      
      jPanel_BensServProj.add(jLabel_BensServProj_Txt, null);
      jPanel_BensServProj.add(jLabel_BensServProj_Txt_Count, null);
      jPanel_BensServProj.add(getjScrollPane_BensServProj_Txt(), null);
    }
    















    return jPanel_BensServProj;
  }
  
  public JScrollPane getjScrollPane_BensServProj_Txt() {
    if (jScrollPane_BensServProj_Txt == null) {
      jScrollPane_BensServProj_Txt = new JScrollPane();
      jScrollPane_BensServProj_Txt.setBounds(new Rectangle(25, 270, fmeApp.width - 90 - 20, 100));
      jScrollPane_BensServProj_Txt.setPreferredSize(new Dimension(250, 250));
      jScrollPane_BensServProj_Txt.setVerticalScrollBarPolicy(20);
      
      jScrollPane_BensServProj_Txt.setViewportView(getjTextArea_BensServProj_Txt());
    }
    return jScrollPane_BensServProj_Txt;
  }
  
  public JTextArea getjTextArea_BensServProj_Txt() {
    if (jTextArea_BensServProj_Txt == null) {
      jTextArea_BensServProj_Txt = new JTextArea();
      jTextArea_BensServProj_Txt.setFont(fmeComum.letra);
      jTextArea_BensServProj_Txt.setLineWrap(true);
      jTextArea_BensServProj_Txt.setWrapStyleWord(true);
      jTextArea_BensServProj_Txt.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_BensServProj_Txt.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.DadosBensServProj.on_update2();
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_BensServProj_Txt;
  }
  
































  public JPanel getJPanel_Mercados()
  {
    if (jPanel_Mercados == null) {
      jButton_MercadosCopy = new JButton(fmeComum.copiarLinha);
      jButton_MercadosCopy.addMouseListener(new Frame_Mercados_jButton_MercadosCopy_mouseAdapter(this));
      jButton_MercadosCopy.setToolTipText("Copiar Linha");
      jButton_MercadosCopy.setBounds(new Rectangle(587, 11, 30, 22));
      jButton_MercadosUp = new JButton(fmeComum.subirLinha);
      jButton_MercadosUp.addMouseListener(new Frame_Mercados_jButton_MercadosUp_mouseAdapter(this));
      jButton_MercadosUp.setToolTipText("Trocar Linhas");
      jButton_MercadosUp.setBounds(new Rectangle(627, 11, 30, 22));
      jButton_MercadosAdd = new JButton(fmeComum.novaLinha);
      jButton_MercadosAdd.addMouseListener(new Frame_Mercados_jButton_MercadosAdd_mouseAdapter(this));
      jButton_MercadosAdd.setToolTipText("Nova Linha");
      jButton_MercadosAdd.setBounds(new Rectangle(667, 11, 30, 22));
      jButton_MercadosIns = new JButton(fmeComum.inserirLinha);
      jButton_MercadosIns.addMouseListener(new Frame_Mercados_jButton_MercadosIns_mouseAdapter(this));
      jButton_MercadosIns.setToolTipText("Inserir Linha");
      jButton_MercadosIns.setBounds(new Rectangle(707, 11, 30, 22));
      jButton_MercadosDel = new JButton(fmeComum.apagarLinha);
      jButton_MercadosDel.addMouseListener(new Frame_Mercados_jButton_MercadosDel_mouseAdapter(this));
      jButton_MercadosDel.setToolTipText("Apagar Linha");
      jButton_MercadosDel.setBounds(new Rectangle(747, 11, 30, 22));
      
      jLabel_Mercados = new JLabel();
      jLabel_Mercados.setBounds(new Rectangle(12, 10, 500, 18));
      jLabel_Mercados.setText("<html>Atividade económica por mercado (volume de negócios)</html>");
      jLabel_Mercados.setFont(fmeComum.letra_bold);
      
      jPanel_Mercados = new JPanel();
      jPanel_Mercados.setLayout(null);
      jPanel_Mercados.setOpaque(false);
      jPanel_Mercados.setName("Mercados_Quadro");
      jPanel_Mercados.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'Ⱥ'));
      jPanel_Mercados.setBorder(fmeComum.blocoBorder);
      jPanel_Mercados.add(jLabel_Mercados, null);
      jPanel_Mercados.add(jButton_MercadosCopy, null);
      jPanel_Mercados.add(jButton_MercadosUp, null);
      jPanel_Mercados.add(jButton_MercadosAdd, null);
      jPanel_Mercados.add(jButton_MercadosIns, null);
      jPanel_Mercados.add(jButton_MercadosDel, null);
      jPanel_Mercados.add(getJScrollPane_Mercados(), null);
      jPanel_Mercados.add(getJScrollPane_Mercados2(), null);
      jPanel_Mercados.add(getJScrollPane_Mercados3(), null);
    }
    return jPanel_Mercados;
  }
  
  public JScrollPane getJScrollPane_Mercados() {
    if (jScrollPane_Mercados == null) {
      jScrollPane_Mercados = new JScrollPane();
      jScrollPane_Mercados.setName("Mercados_ScrollPane");
      jScrollPane_Mercados.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 300));
      jScrollPane_Mercados.setViewportView(getJTable_Mercados());
      jScrollPane_Mercados.setHorizontalScrollBarPolicy(31);
      jScrollPane_Mercados.setVerticalScrollBarPolicy(22);
    }
    return jScrollPane_Mercados;
  }
  
  public JTable getJTable_Mercados() {
    if (jTable_Mercados == null)
    {

      jTable_Mercados = new JTable_Tip();
      jTable_Mercados.addExcelButton(jPanel_Mercados, 547, 11, 14);
      jTable_Mercados.getTableHeader().setPreferredSize(new Dimension(50, 40));
      jTable_Mercados.setFont(fmeComum.letra);
      jTable_Mercados.setRowHeight(18);
      jTable_Mercados.setName("Mercados_Tabela");
      jTable_Mercados.setAutoResizeMode(0);
      jTable_Mercados.setSelectionMode(0);
    }
    return jTable_Mercados;
  }
  
  void jButton_BensServProjAdd_mouseClicked(MouseEvent e) {
    CBData.BensServProj.on_add_row();
  }
  
  void jButton_BensServProjDel_mouseClicked(MouseEvent e) {
    CBData.BensServProj.on_del_row();
    CBData.BensServProj.numerar(0);
  }
  
  void jButton_BensServProjIns_mouseClicked(MouseEvent e) {
    CBData.BensServProj.on_ins_row();
  }
  
  void jButton_MercadosCopy_mouseClicked(MouseEvent e)
  {
    if (cbd_mercados.on_copy_row()) {
      CBData.Mercados.calc_mercados();
    }
  }
  
  void jButton_MercadosUp_mouseClicked(MouseEvent e) {
    cbd_mercados.on_up_row();
  }
  
  void jButton_MercadosAdd_mouseClicked(MouseEvent e) {
    cbd_mercados.on_add_row();
  }
  
  void jButton_MercadosDel_mouseClicked(MouseEvent e) {
    if (cbd_mercados.on_del_row()) {
      CBData.Mercados.calc_mercados();
    }
  }
  
  void jButton_MercadosIns_mouseClicked(MouseEvent e) {
    cbd_mercados.on_ins_row();
  }
  
  public JScrollPane getJScrollPane_Mercados2() {
    if (jScrollPane_Mercados2 == null) {
      jScrollPane_Mercados2 = new JScrollPane();
      jScrollPane_Mercados2.setName("Mercados2_ScrollPane");
      jScrollPane_Mercados2.setBounds(new Rectangle(15, 350, 350, 78));
      jScrollPane_Mercados2.setViewportView(getJTable_Mercados2());
      jScrollPane_Mercados2.setHorizontalScrollBarPolicy(31);
      jScrollPane_Mercados2.setVerticalScrollBarPolicy(21);
    }
    return jScrollPane_Mercados2;
  }
  
  public JTable getJTable_Mercados2() {
    if (jTable_Mercados2 == null) {
      jTable_Mercados2 = new JTable_Tip(40);
      
      jTable_Mercados2.setName("Mercados2_Tabela");
    }
    return jTable_Mercados2;
  }
  
  public JScrollPane getJScrollPane_Mercados3() {
    if (jScrollPane_Mercados3 == null) {
      jScrollPane_Mercados3 = new JScrollPane();
      jScrollPane_Mercados3.setName("Mercados3_ScrollPane");
      jScrollPane_Mercados3.setBounds(new Rectangle(380, 350, 390, 200));
      jScrollPane_Mercados3.setViewportView(getJTable_Mercados3());
      jScrollPane_Mercados3.setHorizontalScrollBarPolicy(31);
      jScrollPane_Mercados3.setVerticalScrollBarPolicy(22);
    }
    return jScrollPane_Mercados3;
  }
  
  public JTable getJTable_Mercados3() {
    if (jTable_Mercados3 == null) {
      jTable_Mercados3 = new JTable_Tip(40);
      jTable_Mercados3.setName("Mercados3_Tabela");
    }
    return jTable_Mercados3;
  }
  










































































































































  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.dx_expand = (jTable_Mercados.getWidth() - jScrollPane_Mercados.getWidth());
    int w = jPanel_Mercados.getWidth() + print_handler.dx_expand;
    print_handler.scaleToWidth((int)(1.05D * w));
    print_handler.margem_x = 10;
    print_handler.margem_y = 50;
    
    print_handler.header = _lib.get_titulo(caption);
    print_handler.footer_medida = fmeComum.title;
    print_handler.footer_pag = _lib.get_pagina(caption);
    print_handler.footer_promotor = PromotorgetByName"nome"v;
    
    print_handler.print_page();
  }
  
  public int print(java.awt.Graphics g, PageFormat pf, int pageIndex) {
    return print_handler.print(g, pf, pageIndex);
  }
  
  public void clear_page()
  {
    CBData.BensServProj.Clear();
    CBData.Mercados.Clear();
    CBData.Mercados3.Clear();
    CBData.AnaliseMercados.Clear();
    CBData.AnaliseMercados.after_open();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.AnaliseMercados.validar_1(null, ""));
    if (CParseConfig.hconfig.get("tipologia2").toString().equals("I"))
      grp.add_grp(CBData.BensServProj.validar(null));
    grp.add_grp(CBData.Mercados.validar(null, ""));
    
    return grp;
  }
}
