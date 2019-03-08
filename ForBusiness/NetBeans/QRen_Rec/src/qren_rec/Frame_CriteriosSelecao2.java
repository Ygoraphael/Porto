package fme;

import java.awt.Component;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.KeyEvent;
import java.util.HashMap;
import javax.swing.ButtonGroup;
import javax.swing.ButtonModel;
import javax.swing.JCheckBox;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

public class Frame_CriteriosSelecao2 extends javax.swing.JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_CriterioB = null;
  public JLabel jLabel_CriterioB = null;
  
  private JPanel jPanel_MercInternac = null;
  private JLabel jLabel_MercInternac = null;
  
  private JLabel jLabel_Presenca = null;
  private JCheckBox jCheckBox_Presenca_Sim = null;
  private JCheckBox jCheckBox_Presenca_Nao = null;
  public JCheckBox jCheckBox_Presenca_Clear = new JCheckBox();
  private ButtonGroup jButtonGroup_Presenca = null;
  
  private JLabel jLabel_SeNao = null;
  
  private JLabel jLabel_NumMercExt = null;
  private JCheckBox jCheckBox_NumMercExt_2_3 = null;
  private JCheckBox jCheckBox_NumMercExt_mais_de_3 = null;
  public JCheckBox jCheckBox_NumMercExt_Clear = new JCheckBox();
  private ButtonGroup jButtonGroup_NumMercExt = null;
  
  private JLabel jLabel_NumClientes = null;
  private JCheckBox jCheckBox_NumClientes_Restrito = null;
  private JCheckBox jCheckBox_NumClientes_Diversificado = null;
  public JCheckBox jCheckBox_NumClientes_Clear = new JCheckBox();
  private ButtonGroup jButtonGroup_NumClientes = null;
  
  private JLabel jLabel_NumProdutos = null;
  private JCheckBox jCheckBox_NumProdutos_Inferior = null;
  private JCheckBox jCheckBox_NumProdutos_Superior = null;
  public JCheckBox jCheckBox_NumProdutos_Clear = new JCheckBox();
  private ButtonGroup jButtonGroup_NumProdutos = null;
  
  private JLabel jLabel_Justificacao = null;
  private JScrollPane jScrollPane_Justificacao = null;
  public JTextArea jTextArea_Justificacao = null;
  public JLabel jLabel_Count = null;
  

  String tag = "";
  
  int y = 0; int h = 0;
  
  public Frame_CriteriosSelecao2()
  {
    initialize();
  }
  

  public Dimension getSize() { return new Dimension(fmeApp.width - 60, y + h + 10); }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void set_params(String _tag, HashMap params) { tag = _tag; }
  

  private void initialize()
  {
    setSize(fmeApp.width - 35, h);
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
      jLabel_Titulo = new LabelTitulo("CRITÉRIOS DE SELEÇÃO");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setOpaque(false);
      jContentPane.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_CriterioB(), null);
      jContentPane.add(getJPanel_MercInternac(), null);
    }
    
    return jContentPane;
  }
  
  public JPanel getjPanel_CriterioB() {
    if (jPanel_CriterioB == null)
    {
      jLabel_CriterioB = new JLabel("<html><strong>B. Impacto do projeto na competitividade da empresa</strong> - para além da argumentação recolhida noutras páginas é relevante justificar os seguintes pontos:</html>");
      jLabel_CriterioB.setBounds(new Rectangle(12, 10, fmeApp.width - 60, 18));
      jLabel_CriterioB.setVerticalAlignment(1);
      jLabel_CriterioB.setFont(fmeComum.letra);
      
      jPanel_CriterioB = new JPanel();
      jPanel_CriterioB.setLayout(null);
      jPanel_CriterioB.setOpaque(false);
      jPanel_CriterioB.setBounds(new Rectangle(15, this.y = 50, fmeApp.width - 60, this.h = 35));
      jPanel_CriterioB.setBorder(fmeComum.blocoBorder);
      
      jPanel_CriterioB.add(jLabel_CriterioB, null);
    }
    return jPanel_CriterioB;
  }
  
  private JPanel getJPanel_MercInternac() {
    if (jPanel_MercInternac == null) {
      jLabel_MercInternac = new JLabel();
      jLabel_MercInternac.setBounds(new Rectangle(12, 10, 458, 18));
      jLabel_MercInternac.setText("Qualificação dos Mercados Internacionais");
      jLabel_MercInternac.setFont(fmeComum.letra_bold);
      
      jLabel_Presenca = new JLabel();
      jLabel_Presenca.setFont(fmeComum.letra);
      jLabel_Presenca.setText("A empresa com o projeto evidencia uma presença internacional concentrada num único mercado?");
      jLabel_Presenca.setBounds(new Rectangle(25, 40, 600, 16));
      
      jLabel_SeNao = new JLabel();
      jLabel_SeNao.setFont(fmeComum.letra);
      jLabel_SeNao.setText("Se não, classifique a presença internacional da empresa com o projeto, quanto:");
      jLabel_SeNao.setBounds(new Rectangle(25, 65, 400, 16));
      
      jLabel_NumMercExt = new JLabel();
      jLabel_NumMercExt.setFont(fmeComum.letra);
      jLabel_NumMercExt.setText("Nº de mercados externos explorados");
      jLabel_NumMercExt.setBounds(new Rectangle(320, 90, 200, 16));
      
      jLabel_NumClientes = new JLabel();
      jLabel_NumClientes.setFont(fmeComum.letra);
      jLabel_NumClientes.setText("Nº de clientes internacionais");
      jLabel_NumClientes.setBounds(new Rectangle(320, 115, 200, 16));
      
      jLabel_NumProdutos = new JLabel();
      jLabel_NumProdutos.setFont(fmeComum.letra);
      jLabel_NumProdutos.setText("Nº de produtos internacionalizados");
      jLabel_NumProdutos.setBounds(new Rectangle(320, 140, 200, 16));
      

      jLabel_Justificacao = new JLabel("<html>Justificação</html>");
      jLabel_Justificacao.setBounds(new Rectangle(30, 175, fmeApp.width - 90, 19));
      jLabel_Justificacao.setFont(fmeComum.letra);
      
      jTextArea_Justificacao = new JTextArea();
      jTextArea_Justificacao.setFont(fmeComum.letra);
      jTextArea_Justificacao.setLineWrap(true);
      jTextArea_Justificacao.setWrapStyleWord(true);
      jTextArea_Justificacao.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Justificacao.addKeyListener(new java.awt.event.KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.CritSelB.on_update("justificacao");
        }
        

        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_Justificacao = new JScrollPane();
      jScrollPane_Justificacao.setBounds(new Rectangle(30, 193, fmeApp.width - 90 - 30, 150));
      jScrollPane_Justificacao.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Justificacao.setVerticalScrollBarPolicy(20);
      jScrollPane_Justificacao.setViewportView(jTextArea_Justificacao);
      
      jLabel_Count = new JLabel("");
      jLabel_Count.setBounds(new Rectangle(jScrollPane_Justificacao.getX() + jScrollPane_Justificacao.getWidth() - 200, jScrollPane_Justificacao.getY() - 15, 200, 20));
      jLabel_Count.setFont(fmeComum.letra_pequena);
      jLabel_Count.setForeground(java.awt.Color.GRAY);
      jLabel_Count.setHorizontalAlignment(4);
      
      jPanel_MercInternac = new JPanel();
      jPanel_MercInternac.setBorder(fmeComum.blocoBorder);
      jPanel_MercInternac.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'Ų'));
      jPanel_MercInternac.setLayout(null);
      jPanel_MercInternac.add(jLabel_MercInternac, null);
      jPanel_MercInternac.add(jLabel_Presenca, null);
      jPanel_MercInternac.add(getJCheckBox_Presenca_Sim(), null);
      jPanel_MercInternac.add(getJCheckBox_Presenca_Nao(), null);
      getJButtonGroup_Presenca();
      jPanel_MercInternac.add(jLabel_SeNao, null);
      jPanel_MercInternac.add(jLabel_NumMercExt, null);
      jPanel_MercInternac.add(getJCheckBox_NumMercExt_2_3(), null);
      jPanel_MercInternac.add(getJCheckBox_NumMercExt_mais_de_3(), null);
      getJButtonGroup_NumMercExt();
      jPanel_MercInternac.add(jLabel_NumClientes, null);
      jPanel_MercInternac.add(getJCheckBox_NumClientes_Restrito(), null);
      jPanel_MercInternac.add(getJCheckBox_NumClientes_Diversificado(), null);
      getJButtonGroup_NumClientes();
      jPanel_MercInternac.add(jLabel_NumProdutos, null);
      jPanel_MercInternac.add(getJCheckBox_NumProdutos_Inferior(), null);
      jPanel_MercInternac.add(getJCheckBox_NumProdutos_Superior(), null);
      getJButtonGroup_NumProdutos();
      
      jPanel_MercInternac.add(jLabel_Justificacao, null);
      jPanel_MercInternac.add(jScrollPane_Justificacao, null);
      jPanel_MercInternac.add(jLabel_Count, null);
    }
    
    return jPanel_MercInternac;
  }
  
  public JCheckBox getJCheckBox_Presenca_Sim() {
    if (jCheckBox_Presenca_Sim == null) {
      jCheckBox_Presenca_Sim = new JCheckBox();
      jCheckBox_Presenca_Sim.setBounds(new Rectangle(520, 40, 55, 16));
      jCheckBox_Presenca_Sim.setText("Sim");
      jCheckBox_Presenca_Sim.setFont(fmeComum.letra);
      jCheckBox_Presenca_Sim.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { CBData.CritSelB.getByName("presenca").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jCheckBox_Presenca_Sim;
  }
  
  public JCheckBox getJCheckBox_Presenca_Nao() {
    if (jCheckBox_Presenca_Nao == null) {
      jCheckBox_Presenca_Nao = new JCheckBox();
      jCheckBox_Presenca_Nao.setBounds(new Rectangle(575, 40, 55, 16));
      jCheckBox_Presenca_Nao.setText("Não");
      jCheckBox_Presenca_Nao.setFont(fmeComum.letra);
      jCheckBox_Presenca_Nao.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { CBData.CritSelB.getByName("presenca").vldOnline();
          }
          catch (Exception localException) {}
        }
      });
    }
    return jCheckBox_Presenca_Nao;
  }
  
  private ButtonGroup getJButtonGroup_Presenca() {
    if (jButtonGroup_Presenca == null) {
      jButtonGroup_Presenca = new MyButtonGroup();
      jButtonGroup_Presenca.add(jCheckBox_Presenca_Sim);
      jButtonGroup_Presenca.add(jCheckBox_Presenca_Nao);
      jButtonGroup_Presenca.add(jCheckBox_Presenca_Clear);
    }
    return jButtonGroup_Presenca;
  }
  
  public JCheckBox getJCheckBox_NumMercExt_2_3() {
    if (jCheckBox_NumMercExt_2_3 == null) {
      jCheckBox_NumMercExt_2_3 = new JCheckBox();
      jCheckBox_NumMercExt_2_3.setBounds(new Rectangle(520, 90, 100, 16));
      jCheckBox_NumMercExt_2_3.setText("Entre 2 a 3");
      jCheckBox_NumMercExt_2_3.setFont(fmeComum.letra);
    }
    return jCheckBox_NumMercExt_2_3;
  }
  
  public JCheckBox getJCheckBox_NumMercExt_mais_de_3() {
    if (jCheckBox_NumMercExt_mais_de_3 == null) {
      jCheckBox_NumMercExt_mais_de_3 = new JCheckBox();
      jCheckBox_NumMercExt_mais_de_3.setBounds(new Rectangle(640, 90, 100, 16));
      jCheckBox_NumMercExt_mais_de_3.setText("Mais de 3");
      jCheckBox_NumMercExt_mais_de_3.setFont(fmeComum.letra);
    }
    return jCheckBox_NumMercExt_mais_de_3;
  }
  
  private ButtonGroup getJButtonGroup_NumMercExt() {
    if (jButtonGroup_NumMercExt == null) {
      jButtonGroup_NumMercExt = new MyButtonGroup();
      jButtonGroup_NumMercExt.add(jCheckBox_NumMercExt_2_3);
      jButtonGroup_NumMercExt.add(jCheckBox_NumMercExt_mais_de_3);
      jButtonGroup_NumMercExt.add(jCheckBox_NumMercExt_Clear);
    }
    return jButtonGroup_NumMercExt;
  }
  
  public JCheckBox getJCheckBox_NumClientes_Restrito() {
    if (jCheckBox_NumClientes_Restrito == null) {
      jCheckBox_NumClientes_Restrito = new JCheckBox();
      jCheckBox_NumClientes_Restrito.setBounds(new Rectangle(520, 115, 100, 16));
      jCheckBox_NumClientes_Restrito.setText("Restrito");
      jCheckBox_NumClientes_Restrito.setFont(fmeComum.letra);
    }
    return jCheckBox_NumClientes_Restrito;
  }
  
  public JCheckBox getJCheckBox_NumClientes_Diversificado() {
    if (jCheckBox_NumClientes_Diversificado == null) {
      jCheckBox_NumClientes_Diversificado = new JCheckBox();
      jCheckBox_NumClientes_Diversificado.setBounds(new Rectangle(640, 115, 100, 16));
      jCheckBox_NumClientes_Diversificado.setText("Diversificado");
      jCheckBox_NumClientes_Diversificado.setFont(fmeComum.letra);
    }
    return jCheckBox_NumClientes_Diversificado;
  }
  
  private ButtonGroup getJButtonGroup_NumClientes() {
    if (jButtonGroup_NumClientes == null) {
      jButtonGroup_NumClientes = new MyButtonGroup();
      jButtonGroup_NumClientes.add(jCheckBox_NumClientes_Restrito);
      jButtonGroup_NumClientes.add(jCheckBox_NumClientes_Diversificado);
      jButtonGroup_NumClientes.add(jCheckBox_NumClientes_Clear);
    }
    return jButtonGroup_NumClientes;
  }
  
  public JCheckBox getJCheckBox_NumProdutos_Inferior() {
    if (jCheckBox_NumProdutos_Inferior == null) {
      jCheckBox_NumProdutos_Inferior = new JCheckBox();
      jCheckBox_NumProdutos_Inferior.setBounds(new Rectangle(520, 140, 100, 16));
      jCheckBox_NumProdutos_Inferior.setText("Inferior a 50%");
      jCheckBox_NumProdutos_Inferior.setFont(fmeComum.letra);
    }
    return jCheckBox_NumProdutos_Inferior;
  }
  
  public JCheckBox getJCheckBox_NumProdutos_Superior() {
    if (jCheckBox_NumProdutos_Superior == null) {
      jCheckBox_NumProdutos_Superior = new JCheckBox();
      jCheckBox_NumProdutos_Superior.setBounds(new Rectangle(640, 140, 100, 16));
      jCheckBox_NumProdutos_Superior.setText("Superior a 50%");
      jCheckBox_NumProdutos_Superior.setFont(fmeComum.letra);
    }
    return jCheckBox_NumProdutos_Superior;
  }
  
  private ButtonGroup getJButtonGroup_NumProdutos() {
    if (jButtonGroup_NumProdutos == null) {
      jButtonGroup_NumProdutos = new MyButtonGroup();
      jButtonGroup_NumProdutos.add(jCheckBox_NumProdutos_Inferior);
      jButtonGroup_NumProdutos.add(jCheckBox_NumProdutos_Superior);
      jButtonGroup_NumProdutos.add(jCheckBox_NumProdutos_Clear);
    }
    return jButtonGroup_NumProdutos;
  }
  
  class MyButtonGroup extends ButtonGroup { MyButtonGroup() {}
    
    public void setSelected(ButtonModel m, boolean b) { if ((b) && (m != null) && (m != getSelection())) {
        super.setSelected(m, b);
      } else if ((!b) && (m == getSelection())) {
        clearSelection();
      }
    }
  }
  
  public JLabel getJLabelDesign(String texto) {
    JLabel label = new JLabel(texto);
    label.setBounds(new Rectangle(15, 10, fmeApp.width - 90, 18));
    label.setVerticalAlignment(1);
    label.setFont(fmeComum.letra);
    return label;
  }
  
  public JLabel getJLabelDesign(String texto, int n_linhas) { JLabel label = getJLabelDesign("<html>" + texto + "</html>");
    label.setBounds(new Rectangle(15, 10, fmeApp.width - 90, n_linhas * 18));
    return label;
  }
  
  public JScrollPane getjScrollPane() {
    JScrollPane scrollpane = new JScrollPane();
    scrollpane.setBounds(new Rectangle(15, 25, fmeApp.width - 90, 120));
    scrollpane.setPreferredSize(new Dimension(250, 250));
    scrollpane.setVerticalScrollBarPolicy(20);
    return scrollpane;
  }
  
  public JScrollPane getjScrollPane(int n_linhas) {
    JScrollPane scrollpane = getjScrollPane();
    scrollpane.setBounds(new Rectangle(15, 25 + (n_linhas - 1) * 18, fmeApp.width - 90, 100));
    return scrollpane;
  }
  
  public JTextArea getjTextArea() { JTextArea textarea = new JTextArea();
    textarea.setFont(fmeComum.letra);
    textarea.setLineWrap(true);
    textarea.setWrapStyleWord(true);
    textarea.setMargin(new Insets(5, 5, 5, 5));
    return textarea;
  }
  
  public JPanel getJPanel(int n_linhas) { JPanel panel = new JPanel();
    panel.setLayout(null);
    panel.setOpaque(false);
    panel.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 140 + (n_linhas - 1) * 18));
    panel.setBorder(fmeComum.blocoBorder);
    
    return panel;
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    

    print_handler.scaleToWidth((int)(1.05D * jPanel_CriterioB.getWidth()));
    print_handler.margem_y = 50;
    
    print_handler.header = _lib.get_titulo(caption);
    print_handler.footer_medida = fmeComum.title;
    print_handler.footer_pag = _lib.get_pagina(caption);
    print_handler.footer_promotor = PromotorgetByName"nome"v;
    
    print_handler.print_page();
  }
  
  public int print(Graphics g, java.awt.print.PageFormat pf, int pageIndex) {
    return print_handler.print(g, pf, pageIndex);
  }
  
  public void clear_page()
  {
    CBData.CritSelB.Clear();
    CBData.CritSelB.after_open();
  }
  
  public CHValid_Grp validar_pg()
  {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.CritSelB.validar(null));
    return grp;
  }
}
