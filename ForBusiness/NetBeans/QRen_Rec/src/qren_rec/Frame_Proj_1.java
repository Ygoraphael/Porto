package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.ButtonGroup;
import javax.swing.JCheckBox;
import javax.swing.JFormattedTextField;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;
import javax.swing.JTextField;
import javax.swing.border.EmptyBorder;










public class Frame_Proj_1
  extends JInternalFrame
  implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_Responsavel = null;
  private JLabel jLabel_Responsavel = null;
  private JLabel jLabel_Nome = null;
  private JTextField jTextField_Nome = null;
  private JLabel jLabel_Funcao = null;
  private JTextField jTextField_Funcao = null;
  public JCheckBox jCheckBox_GeneroClear = new JCheckBox();
  private ButtonGroup jButtonGroup_Genero = null;
  
  private JLabel jLabel_Telemovel = null;
  private JTextField jTextField_Telemovel = null;
  private JLabel jLabel_Email = null;
  private JTextField jTextField_Email = null;
  
  private JPanel jPanel_Projecto = null;
  private JLabel jLabel_Projecto = null;
  private JLabel jLabel_Designacao = null;
  private JTextField jTextField_Designacao = null;
  private JLabel jLabel_Tipologia = null;
  private JScrollPane jScrollPane_Tipologia = null;
  private JTable_Tip jTable_Tipologia = null;
  



  private JPanel jPanel_Fundam = null;
  private JLabel jLabel_Fundam = null;
  private JScrollPane jScrollPane_Fundam = null;
  private JTextArea jTextArea_Fundam = null;
  public JLabel jLabel_Fundam_Count = null;
  
  private JPanel jPanel_Calendar = null;
  private JLabel jLabel_Calendar = null;
  private JLabel jLabel_Inicio = null;
  private JFormattedTextField jTextField_Inicio = null;
  private JLabel jLabel_Fim = null;
  private JFormattedTextField jTextField_Fim = null;
  private JLabel jLabel_Meses = null;
  private JFormattedTextField jTextField_Meses = null;
  private JCheckBox jCheckBox_DeclInicio = null;
  private JLabel jLabel_Inv = null;
  private JFormattedTextField jTextField_Inv = null;
  private JLabel jLabel_Eleg = null;
  private JFormattedTextField jTextField_Eleg = null;
  





  private JPanel jPanel_CAE = null;
  private JLabel jLabel_CAE = null;
  private JScrollPane jScrollPane_CAE = null;
  private JTable_Tip jTable_CAE = null;
  















  String tag = "";
  
  int y = 50; int h = 0;
  

  public Frame_Proj_1()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(660, y + h + 10);
  }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  void repaint_panels(int n) {
    Rectangle r = getJScrollPane_Tipologia().getBounds();
    int dif = n * 18 - height + 4;
    height = (n * 18 + 4);
    getJScrollPane_Tipologia().setBounds(r);
    r = getJPanel_Projecto().getBounds();
    int dif2 = 0;
    if (!((String)CParseConfig.hconfig.get("reg_especial")).equals("1")) dif2 = 40;
    height = (height + dif - dif2);
    getJPanel_Projecto().setBounds(r);
    
    Rectangle r1 = getJPanel_Fundam().getBounds();
    int new_y = y + height + 10;
    int dif3 = y - new_y;
    
    up_component(getJPanel_Fundam(), dif3);
    

    up_component(getJPanel_Calendar(), dif3);
    up_component(getJPanel_Responsavel(), dif3);
    up_component(getJPanel_CAE(), dif3);
    



    h -= dif3;
    

    repaint();
  }
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
  }
  
  public void x(Dimension d) {
    setPreferredSize(d);
    revalidate();
    repaint();
  }
  
  private void initialize() {
    setSize(690, 1950);
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
      jContentPane.add(getJPanel_Projecto(), null);
      jContentPane.add(getJPanel_Fundam(), null);
      

      jContentPane.add(getJPanel_Calendar(), null);
      jContentPane.add(getJPanel_Responsavel(), null);
      jContentPane.add(getJPanel_CAE(), null);
    }
    return jContentPane;
  }
  
  public JPanel getJPanel_Responsavel() {
    if (jPanel_Responsavel == null) {
      jLabel_Nome = new JLabel();
      jLabel_Nome.setBounds(new Rectangle(29, 38, 150, 19));
      jLabel_Nome.setText("Nome");
      jLabel_Nome.setFont(fmeComum.letra);
      
      jLabel_Funcao = new JLabel();
      jLabel_Funcao.setBounds(new Rectangle(29, 65, 150, 19));
      jLabel_Funcao.setText("Função no beneficiário");
      jLabel_Funcao.setFont(fmeComum.letra);
      
      jLabel_Telemovel = new JLabel();
      jLabel_Telemovel.setBounds(new Rectangle(418, 38, 65, 19));
      jLabel_Telemovel.setText("Telefone");
      jLabel_Telemovel.setHorizontalAlignment(4);
      jLabel_Telemovel.setFont(fmeComum.letra);
      
      jLabel_Email = new JLabel();
      jLabel_Email.setBounds(new Rectangle(418, 65, 65, 19));
      jLabel_Email.setText("E-mail");
      jLabel_Email.setHorizontalAlignment(4);
      jLabel_Email.setFont(fmeComum.letra);
      
      jLabel_Responsavel = new JLabel();
      jLabel_Responsavel.setText("Responsável Técnico pelo Projeto");
      jLabel_Responsavel.setBounds(new Rectangle(12, 10, 301, 18));
      jLabel_Responsavel.setFont(fmeComum.letra_bold);
      
      jPanel_Responsavel = new JPanel();
      jPanel_Responsavel.setLayout(null);
      jPanel_Responsavel.setOpaque(false);
      jPanel_Responsavel.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 100));
      jPanel_Responsavel.setBorder(fmeComum.blocoBorder);
      jPanel_Responsavel.add(jLabel_Responsavel);
      jPanel_Responsavel.add(jLabel_Nome);
      jPanel_Responsavel.add(getJTextField_Nome());
      jPanel_Responsavel.add(jLabel_Funcao);
      jPanel_Responsavel.add(getJTextField_Funcao());
      jPanel_Responsavel.add(jLabel_Telemovel);
      jPanel_Responsavel.add(getJTextField_Telemovel());
      jPanel_Responsavel.add(jLabel_Email);
      jPanel_Responsavel.add(getJTextField_Email());
    }
    return jPanel_Responsavel;
  }
  
  public JTextField getJTextField_Nome() {
    if (jTextField_Nome == null) {
      jTextField_Nome = new JTextField();
      jTextField_Nome.setBounds(new Rectangle(161, 38, 227, 18));
    }
    

    return jTextField_Nome;
  }
  
  public JTextField getJTextField_Funcao() {
    if (jTextField_Funcao == null) {
      jTextField_Funcao = new JTextField();
      jTextField_Funcao.setBounds(new Rectangle(161, 65, 227, 18));
    }
    

    return jTextField_Funcao;
  }
  
  public JTextField getJTextField_Telemovel()
  {
    if (jTextField_Telemovel == null) {
      jTextField_Telemovel = new JTextField();
      jTextField_Telemovel.setBounds(new Rectangle(488, 38, 188, 18));
    }
    

    return jTextField_Telemovel;
  }
  
  public JTextField getJTextField_Email() {
    if (jTextField_Email == null) {
      jTextField_Email = new JTextField();
      jTextField_Email.setBounds(new Rectangle(488, 65, 188, 18));
    }
    

    return jTextField_Email;
  }
  
  public JPanel getJPanel_Projecto() {
    if (jPanel_Projecto == null) {
      jLabel_Designacao = new JLabel();
      jLabel_Designacao.setBounds(new Rectangle(29, 38, 66, 19));
      jLabel_Designacao.setText("Designação");
      jLabel_Designacao.setFont(fmeComum.letra);
      
      jLabel_Tipologia = new JLabel();
      jLabel_Tipologia.setBounds(new Rectangle(29, 65, 66, 19));
      jLabel_Tipologia.setText("Tipologia");
      jLabel_Tipologia.setFont(fmeComum.letra);
      










      jLabel_Projecto = new JLabel();
      
      jLabel_Projecto.setText("Designação do Projeto e Tipologia(s)");
      jLabel_Projecto.setBounds(new Rectangle(12, 10, 358, 18));
      jLabel_Projecto.setFont(fmeComum.letra_bold);
      
      jPanel_Projecto = new JPanel();
      jPanel_Projecto.setLayout(null);
      jPanel_Projecto.setOpaque(false);
      jPanel_Projecto.setBounds(new Rectangle(15, this.y = 50, fmeApp.width - 60, this.h = 'Ü'));
      jPanel_Projecto.setBorder(fmeComum.blocoBorder);
      jPanel_Projecto.add(jLabel_Projecto);
      jPanel_Projecto.add(jLabel_Designacao);
      jPanel_Projecto.add(getJTextField_Designacao());
      jPanel_Projecto.add(jLabel_Tipologia);
      jPanel_Projecto.add(getJScrollPane_Tipologia(), null);
    }
    


    return jPanel_Projecto;
  }
  
  public JScrollPane getJScrollPane_Tipologia() {
    if (jScrollPane_Tipologia == null) {
      jScrollPane_Tipologia = new JScrollPane();
      jScrollPane_Tipologia.setBounds(new Rectangle(99, 65, 526, 101));
      jScrollPane_Tipologia.setViewportView(getJTable_Tipologia());
      jScrollPane_Tipologia.setHorizontalScrollBarPolicy(31);
      jScrollPane_Tipologia.setVerticalScrollBarPolicy(20);
      jScrollPane_Tipologia.setBorder(new EmptyBorder(0, 0, 0, 0));
    }
    return jScrollPane_Tipologia;
  }
  
  public JTable_Tip getJTable_Tipologia() {
    if (jTable_Tipologia == null) {
      jTable_Tipologia = new JTable_Tip(0);
    }
    return jTable_Tipologia;
  }
  














  public JTextField getJTextField_Designacao()
  {
    if (jTextField_Designacao == null) {
      jTextField_Designacao = new JTextField();
      jTextField_Designacao.setBounds(new Rectangle(99, 38, 526, 18));
    }
    

    return jTextField_Designacao;
  }
  
  public JPanel getJPanel_Fundam() {
    if (jPanel_Fundam == null) {
      jLabel_Fundam = new JLabel();
      jLabel_Fundam.setBounds(new Rectangle(12, 10, 609, 18));
      jLabel_Fundam.setText("Enquadramento do projeto na(s) tipologia(s) selecionada(s)");
      jLabel_Fundam.setFont(fmeComum.letra_bold);
      
      jPanel_Fundam = new JPanel();
      jPanel_Fundam.setLayout(null);
      jPanel_Fundam.setOpaque(false);
      jPanel_Fundam.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'È'));
      jPanel_Fundam.setBorder(fmeComum.blocoBorder);
      jPanel_Fundam.setName("cond_eleg_texto");
      
      jLabel_Fundam_Count = new JLabel("");
      jLabel_Fundam_Count.setBounds(new Rectangle(jPanel_Fundam.getWidth() - 200 - 15, getJScrollPane_Fundam().getY() - 15, 200, 20));
      jLabel_Fundam_Count.setFont(fmeComum.letra_pequena);
      jLabel_Fundam_Count.setForeground(Color.GRAY);
      jLabel_Fundam_Count.setHorizontalAlignment(4);
      
      jPanel_Fundam.add(jLabel_Fundam, null);
      jPanel_Fundam.add(jLabel_Fundam_Count, null);
      jPanel_Fundam.add(getJScrollPane_Fundam(), null);
    }
    
    return jPanel_Fundam;
  }
  
  public JScrollPane getJScrollPane_Fundam() {
    if (jScrollPane_Fundam == null) {
      jScrollPane_Fundam = new JScrollPane();
      jScrollPane_Fundam.setBounds(new Rectangle(15, 36, fmeApp.width - 90, 150));
      jScrollPane_Fundam.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Fundam.setVerticalScrollBarPolicy(20);
      
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
          CBData.DadosProjecto.on_update("fundamento");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Fundam;
  }
  






















































































































  public JPanel getJPanel_Calendar()
  {
    if (jPanel_Calendar == null)
    {
      jLabel_Inicio = new JLabel();
      jLabel_Inicio.setBounds(new Rectangle(30, 40, 74, 18));
      jLabel_Inicio.setText("Data de Início");
      jLabel_Inicio.setFont(fmeComum.letra);
      
      jLabel_Meses = new JLabel();
      jLabel_Meses.setBounds(new Rectangle(30, 65, 58, 18));
      jLabel_Meses.setText("Nº meses");
      jLabel_Meses.setFont(fmeComum.letra);
      
      jLabel_Fim = new JLabel();
      jLabel_Fim.setBounds(new Rectangle(30, 90, 72, 18));
      jLabel_Fim.setText("Data de Fim");
      jLabel_Fim.setFont(fmeComum.letra);
      
      jLabel_Inv = new JLabel();
      jLabel_Inv.setBounds(new Rectangle(399, 40, 110, 18));
      jLabel_Inv.setText("Investimento Total");
      jLabel_Inv.setFont(fmeComum.letra);
      










      jLabel_Eleg = new JLabel();
      jLabel_Eleg.setBounds(new Rectangle(399, 65, 110, 18));
      jLabel_Eleg.setText("Investimento Elegível");
      jLabel_Eleg.setFont(fmeComum.letra);
      
      jLabel_Calendar = new JLabel();
      jLabel_Calendar.setText("Calendarização e Investimento");
      jLabel_Calendar.setBounds(new Rectangle(12, 10, 301, 18));
      jLabel_Calendar.setFont(fmeComum.letra_bold);
      
      jPanel_Calendar = new JPanel();
      jPanel_Calendar.setLayout(null);
      jPanel_Calendar.setOpaque(false);
      jPanel_Calendar.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = ' '));
      jPanel_Calendar.setBorder(fmeComum.blocoBorder);
      jPanel_Calendar.add(jLabel_Calendar);
      jPanel_Calendar.add(jLabel_Inicio);
      jPanel_Calendar.add(getJTextField_Inicio());
      jPanel_Calendar.add(jLabel_Fim);
      jPanel_Calendar.add(getJTextField_Fim());
      jPanel_Calendar.add(jLabel_Meses, null);
      jPanel_Calendar.add(getJTextField_Meses(), null);
      jPanel_Calendar.add(getJCheckBox_DeclInicio(), null);
      jPanel_Calendar.add(jLabel_Inv, null);
      jPanel_Calendar.add(getJTextField_Inv(), null);
      



      jPanel_Calendar.add(jLabel_Eleg, null);
      jPanel_Calendar.add(getJTextField_Eleg(), null);
    }
    return jPanel_Calendar;
  }
  
  public JFormattedTextField getJTextField_Inicio() {
    if (jTextField_Inicio == null) {
      jTextField_Inicio = new JFormattedTextField();
      jTextField_Inicio.setBounds(new Rectangle(100, 40, 81, 18));
      

      jTextField_Inicio.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { CBData.DadosProjecto.getByName("dt_inicio").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jTextField_Inicio;
  }
  
  public JFormattedTextField getJTextField_Meses() {
    if (jTextField_Meses == null) {
      jTextField_Meses = new JFormattedTextField();
      jTextField_Meses.setBounds(new Rectangle(100, 65, 48, 18));
      

      jTextField_Meses.setEditable(false);
    }
    

    return jTextField_Meses;
  }
  
  public JFormattedTextField getJTextField_Fim() { if (jTextField_Fim == null) {
      jTextField_Fim = new JFormattedTextField();
      jTextField_Fim.setBounds(new Rectangle(100, 90, 81, 18));
    }
    


    return jTextField_Fim;
  }
  
  public JCheckBox getJCheckBox_DeclInicio() {
    if (jCheckBox_DeclInicio == null) {
      jCheckBox_DeclInicio = new JCheckBox();
      jCheckBox_DeclInicio.setOpaque(false);
      jCheckBox_DeclInicio.setBounds(new Rectangle(25, 115, fmeApp.width - 90 - 20, 45));
      jCheckBox_DeclInicio.setText("<html>Declaro que todo o investimento apresentado será realizado em data posterior à data da candidatura, não existindo trabalhos de construção já iniciados, nem compromissos firmes de encomendas de equipamentos ou quaisquer outros compromissos que tornem o investimento irreversível.</html>");
      jCheckBox_DeclInicio.setFont(fmeComum.letra);
      jCheckBox_DeclInicio.setHorizontalAlignment(0);
      jCheckBox_DeclInicio.setVerticalTextPosition(1);
    }
    return jCheckBox_DeclInicio;
  }
  
  public JPanel getJPanel_CAE() {
    if (jPanel_CAE == null) {
      jLabel_CAE = new JLabel();
      jLabel_CAE.setBounds(new Rectangle(12, 10, 301, 18));
      jLabel_CAE.setText("Atividade(s) Económica(s) do Projeto");
      jLabel_CAE.setFont(fmeComum.letra_bold);
      jPanel_CAE = new JPanel();
      jPanel_CAE.setLayout(null);
      jPanel_CAE.setOpaque(false);
      jPanel_CAE.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = ' '));
      jPanel_CAE.setBorder(fmeComum.blocoBorder);
      jPanel_CAE.add(jLabel_CAE, null);
      jPanel_CAE.add(getJScrollPane_CAE(), null);
    }
    
    return jPanel_CAE;
  }
  
  public JScrollPane getJScrollPane_CAE() {
    if (jScrollPane_CAE == null) {
      jScrollPane_CAE = new JScrollPane();
      jScrollPane_CAE.setBounds(new Rectangle(15, 36, 610, 101));
      jScrollPane_CAE.setViewportView(getJTable_CAE());
      jScrollPane_CAE.setHorizontalScrollBarPolicy(31);
      jScrollPane_CAE.setVerticalScrollBarPolicy(21);
    }
    
    return jScrollPane_CAE;
  }
  
  public JTable_Tip getJTable_CAE() {
    if (jTable_CAE == null) {
      jTable_CAE = new JTable_Tip();
      jTable_CAE.setRowHeight(18);
      jTable_CAE.setBounds(new Rectangle(18, 26, 610, 101));
      jTable_CAE.setFont(fmeComum.letra);
    }
    return jTable_CAE;
  }
  

  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.scaleToWidth((int)(1.05D * jPanel_CAE.getWidth()));
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
    CBData.DadosProjecto.Clear();
    CBData.DadosProjecto.on_update("fundamento");
    CBData.DadosProjecto.on_update("txt_fse");
    CBData.Tipologia.Clear();
    CBData.Responsavel.Clear();
    CBData.ProjCae.Clear();
  }
  
  public CHValid_Grp validar_pg()
  {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.DadosProjecto.validar_1(null));
    
    grp.add_grp(CBData.DadosProjecto.validar_2(null));
    grp.add_grp(CBData.Responsavel.validar(null));
    grp.add_grp(CBData.ProjCae.validar(null));
    
    return grp;
  }
  





  public JFormattedTextField getJTextField_Inv()
  {
    if (jTextField_Inv == null) {
      jTextField_Inv = new JFormattedTextField();
      jTextField_Inv.setEditable(false);
      jTextField_Inv.setFocusable(false);
      jTextField_Inv.setBounds(new Rectangle(515, 40, 118, 18));
      

      jTextField_Inv.setHorizontalAlignment(4);
    }
    return jTextField_Inv;
  }
  
























  public JFormattedTextField getJTextField_Eleg()
  {
    if (jTextField_Eleg == null) {
      jTextField_Eleg = new JFormattedTextField();
      jTextField_Eleg.setEditable(false);
      jTextField_Eleg.setFocusable(false);
      jTextField_Eleg.setBounds(new Rectangle(515, 65, 118, 18));
      

      jTextField_Eleg.setHorizontalAlignment(4);
    }
    return jTextField_Eleg;
  }
}
