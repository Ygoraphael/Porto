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

public class Frame_CriteriosSelecao3 extends javax.swing.JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_Criterio_C1 = null;
  public JLabel jLabel_Criterio_C1 = null;
  
  private JPanel jPanel_Desafios = null;
  private JLabel jLabel_Desafios = null;
  public JScrollPane jScrollPane_Desafios = null;
  public JTable_Tip jTable_Desafios = null;
  private JButton jButton_DesafiosSocietaisAdd = null;
  private JButton jButton_DesafiosSocietaisIns = null;
  private JButton jButton_DesafiosSocietaisDel = null;
  
  public JLabel jLabel_Desafios_Design = null;
  private JScrollPane jScrollPane_Desafios_Txt = null;
  private JTextArea jTextArea_Desafios_Txt = null;
  public JLabel jLabel_Desafios_Count = null;
  
  String texto_Desafios_Descricao;
  
  private JPanel jPanel_Criterios_C1_aux = null;
  public JLabel jLabel_Criterios_C1_aux = null;
  
  private JPanel jPanel_Dominios = null;
  private JLabel jLabel_Dominios = null;
  public JScrollPane jScrollPane_Dominios = null;
  public JTable_Tip jTable_Dominios = null;
  private JButton jButton_DominiosPrioritariosAdd = null;
  private JButton jButton_DominiosPrioritariosIns = null;
  private JButton jButton_DominiosPrioritariosDel = null;
  
  public JLabel jLabel_Dominios_Design = null;
  private JScrollPane jScrollPane_Dominios_Txt = null;
  private JTextArea jTextArea_Dominios_Txt = null;
  public JLabel jLabel_Dominios_Count = null;
  
  String texto_Dominios_Descricao;
  
  private JPanel jPanel_C1_Txt_1 = null;
  public JLabel jLabel_C1_Design_1 = null;
  public JScrollPane jScrollPane_C1_Txt_1 = null;
  public JTextArea jTextArea_C1_Txt_1 = null;
  public JLabel jLabel_Count_C1_1 = null;
  
  private JPanel jPanel_C1_Txt_2 = null;
  public JLabel jLabel_C1_Design_2 = null;
  public JScrollPane jScrollPane_C1_Txt_2 = null;
  public JTextArea jTextArea_C1_Txt_2 = null;
  public JLabel jLabel_Count_C1_2 = null;
  
  private JPanel jPanel_C1_Txt_3 = null;
  public JLabel jLabel_C1_Design_3 = null;
  public JScrollPane jScrollPane_C1_Txt_3 = null;
  public JTextArea jTextArea_C1_Txt_3 = null;
  public JLabel jLabel_Count_C1_3 = null;
  
  private JPanel jPanel_C1_Txt_4 = null;
  public JLabel jLabel_C1_Design_4 = null;
  public JScrollPane jScrollPane_C1_Txt_4 = null;
  public JTextArea jTextArea_C1_Txt_4 = null;
  public JLabel jLabel_Count_C1_4 = null;
  
  private JPanel jPanel_Criterio_C3 = null;
  public JLabel jLabel_Criterio_C3 = null;
  
  String tag = "";
  
  int y = 0; int h = 0;
  
  public Frame_CriteriosSelecao3()
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
    texto_Desafios_Descricao = jLabel_Desafios_Design.getText();
    texto_Dominios_Descricao = jLabel_Dominios_Design.getText();
  }
  
  public void setDescricao_Dominios(String design) {
    getJPanel_Dominios();
    if ((design == null) || (design.trim().equals("")))
      jLabel_Dominios_Design.setText(texto_Dominios_Descricao); else
      jLabel_Dominios_Design.setText(design + " — " + texto_Dominios_Descricao);
  }
  
  public void setDescricao_Desafios(String design) {
    getJPanel_Desafios();
    if ((design == null) || (design.trim().equals("")))
      jLabel_Desafios_Design.setText(texto_Desafios_Descricao); else
      jLabel_Desafios_Design.setText(design + " — " + texto_Desafios_Descricao);
  }
  
  private JPanel getJContentPane() {
    if (jContentPane == null) {
      jLabel_PT2020 = new Label2020();
      jLabel_Titulo = new LabelTitulo("CRITÉRIOS DE SELEÇÃO");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setOpaque(false);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_Criterio_C1(), null);
      jContentPane.add(getJPanel_Dominios(), null);
      jContentPane.add(getjPanel_Criterios_C1_aux(), null);
      jContentPane.add(getjPanel_C1_Txt_1(), null);
      jContentPane.add(getjPanel_C1_Txt_2(), null);
      jContentPane.add(getjPanel_C1_Txt_3(), null);
      jContentPane.add(getjPanel_C1_Txt_4(), null);
      

      jContentPane.add(getJPanel_Desafios(), null);
      






      jContentPane.add(getjPanel_Criterio_C3(), null);
    }
    return jContentPane;
  }
  
  public JPanel getjPanel_Criterio_C1() {
    if (jPanel_Criterio_C1 == null)
    {
      jLabel_Criterio_C1 = new JLabel("<html><strong>C1. Impacto estrutural do projeto: contributo para a Estratégia de I&I para uma Especialização Inteligente (RIS3/ENEI), restantes domínios temáticos do Portugal 2020 e desafios societais</strong></html>");
      jLabel_Criterio_C1.setBounds(new Rectangle(12, 10, fmeApp.width - 90, 36));
      jLabel_Criterio_C1.setVerticalAlignment(1);
      jLabel_Criterio_C1.setFont(fmeComum.letra);
      
      jPanel_Criterio_C1 = new JPanel();
      jPanel_Criterio_C1.setLayout(null);
      jPanel_Criterio_C1.setOpaque(false);
      jPanel_Criterio_C1.setBounds(new Rectangle(15, this.y = 50, fmeApp.width - 60, this.h = 50));
      jPanel_Criterio_C1.setBorder(fmeComum.blocoBorder);
      
      jPanel_Criterio_C1.add(jLabel_Criterio_C1, null);
    }
    return jPanel_Criterio_C1;
  }
  
  public JPanel getJPanel_Desafios() {
    if (jPanel_Desafios == null)
    {
      jLabel_Desafios = new JLabel();
      jLabel_Desafios.setBounds(new Rectangle(15, 10, 294, 18));
      jLabel_Desafios.setText("<html>O projeto dá resposta a desafios societais? Quais?</html>");
      jLabel_Desafios.setFont(fmeComum.letra_bold);
      
      jButton_DesafiosSocietaisAdd = new JButton(fmeComum.novaLinha);
      jButton_DesafiosSocietaisAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_DesafiosSocietaisAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_DesafiosSocietaisAdd.setToolTipText("Nova Linha");
      jButton_DesafiosSocietaisAdd.addMouseListener(new Frame_CriteriosSelecao3_jButton_DesafiosSocietaisAdd_mouseAdapter(this));
      jButton_DesafiosSocietaisIns = new JButton(fmeComum.inserirLinha);
      jButton_DesafiosSocietaisIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_DesafiosSocietaisIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_DesafiosSocietaisIns.setToolTipText("Inserir Linha");
      jButton_DesafiosSocietaisIns.addMouseListener(new Frame_CriteriosSelecao3_jButton_DesafiosSocietaisIns_mouseAdapter(this));
      jButton_DesafiosSocietaisDel = new JButton(fmeComum.apagarLinha);
      jButton_DesafiosSocietaisDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_DesafiosSocietaisDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_DesafiosSocietaisDel.setToolTipText("Apagar Linha");
      jButton_DesafiosSocietaisDel.addMouseListener(new Frame_CriteriosSelecao3_jButton_DesafiosSocietaisDel_mouseAdapter(this));
      
      jTable_Desafios = new JTable_Tip(40) {
        private static final long serialVersionUID = 1L;
        
        public void changeSelection(int rowIndex, int columnIndex, boolean toggle, boolean extend) { super.changeSelection(rowIndex, columnIndex, toggle, extend);
          CHTabela handler = (CHTabela)getModel();
          d.on_row(j.getSelectedRow());
        }
      };
      jTable_Desafios.setName("DesafiosSocietais_Tabela");
      


      jScrollPane_Desafios = new JScrollPane();
      jScrollPane_Desafios.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 170));
      jScrollPane_Desafios.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Desafios.setVerticalScrollBarPolicy(21);
      jScrollPane_Desafios.setHorizontalScrollBarPolicy(31);
      jScrollPane_Desafios.setBorder(fmeComum.blocoBorder);
      jScrollPane_Desafios.setViewportView(jTable_Desafios);
      
      jPanel_Desafios = new JPanel();
      jPanel_Desafios.setLayout(null);
      jPanel_Desafios.setOpaque(false);
      jPanel_Desafios.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'ż'));
      jPanel_Desafios.setBorder(fmeComum.blocoBorder);
      jPanel_Desafios.add(jLabel_Desafios, null);
      jPanel_Desafios.add(jScrollPane_Desafios, null);
      jPanel_Desafios.add(jButton_DesafiosSocietaisAdd, null);
      jPanel_Desafios.add(jButton_DesafiosSocietaisIns, null);
      jPanel_Desafios.add(jButton_DesafiosSocietaisDel, null);
      
      jLabel_Desafios_Design = new JLabel("Justificação");
      jLabel_Desafios_Design.setBounds(new Rectangle(30, 220, 620, 18));
      jLabel_Desafios_Design.setVerticalAlignment(1);
      jLabel_Desafios_Design.setFont(fmeComum.letra_bold);
      
      jLabel_Desafios_Count = new JLabel("");
      jLabel_Desafios_Count.setBounds(new Rectangle(getjScrollPane_Desafios_Txt().getWidth() + getjScrollPane_Desafios_Txt().getX() - 200, getjScrollPane_Desafios_Txt().getY() - 15, 200, 20));
      jLabel_Desafios_Count.setFont(fmeComum.letra_pequena);
      jLabel_Desafios_Count.setForeground(Color.GRAY);
      jLabel_Desafios_Count.setHorizontalAlignment(4);
      
      jPanel_Desafios.add(jLabel_Desafios_Design, null);
      jPanel_Desafios.add(jLabel_Desafios_Count, null);
      jPanel_Desafios.add(getjScrollPane_Desafios_Txt(), null);
    }
    
    return jPanel_Desafios;
  }
  
  public JScrollPane getjScrollPane_Desafios_Txt() {
    if (jScrollPane_Desafios_Txt == null) {
      jScrollPane_Desafios_Txt = new JScrollPane();
      jScrollPane_Desafios_Txt.setBounds(new Rectangle(25, 240, fmeApp.width - 90 - 20, 120));
      jScrollPane_Desafios_Txt.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Desafios_Txt.setVerticalScrollBarPolicy(20);
      
      jScrollPane_Desafios_Txt.setViewportView(getjTextArea_Desafios_Txt());
    }
    return jScrollPane_Desafios_Txt;
  }
  
  public JTextArea getjTextArea_Desafios_Txt() {
    if (jTextArea_Desafios_Txt == null) {
      jTextArea_Desafios_Txt = new JTextArea();
      jTextArea_Desafios_Txt.setFont(fmeComum.letra);
      jTextArea_Desafios_Txt.setLineWrap(true);
      jTextArea_Desafios_Txt.setWrapStyleWord(true);
      jTextArea_Desafios_Txt.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Desafios_Txt.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.DadosDesafioSocietal.on_update2();
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Desafios_Txt;
  }
  
  public JPanel getjPanel_Criterios_C1_aux() { if (jPanel_Criterios_C1_aux == null)
    {
      jLabel_Criterios_C1_aux = new JLabel("<html><strong>Contributo do projeto para as prioridades da RIS3</html>");
      jLabel_Criterios_C1_aux.setBounds(new Rectangle(12, 10, fmeApp.width - 60, 18));
      jLabel_Criterios_C1_aux.setVerticalAlignment(1);
      jLabel_Criterios_C1_aux.setFont(fmeComum.letra);
      
      jPanel_Criterios_C1_aux = new JPanel();
      jPanel_Criterios_C1_aux.setLayout(null);
      jPanel_Criterios_C1_aux.setOpaque(false);
      jPanel_Criterios_C1_aux.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 35));
      jPanel_Criterios_C1_aux.setBorder(fmeComum.blocoBorder);
      jPanel_Criterios_C1_aux.setName("evolucao_texto");
      jPanel_Criterios_C1_aux.add(jLabel_Criterios_C1_aux, null);
    }
    return jPanel_Criterios_C1_aux;
  }
  
  public JPanel getJPanel_Dominios()
  {
    if (jPanel_Dominios == null)
    {
      jLabel_Dominios = new JLabel();
      jLabel_Dominios.setBounds(new Rectangle(15, 10, 500, 18));
      jLabel_Dominios.setText("<html>Domínios prioritários de especialização inteligente (ENEI)</html>");
      jLabel_Dominios.setFont(fmeComum.letra_bold);
      
      jButton_DominiosPrioritariosAdd = new JButton(fmeComum.novaLinha);
      jButton_DominiosPrioritariosAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_DominiosPrioritariosAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosPrioritariosAdd.setToolTipText("Nova Linha");
      jButton_DominiosPrioritariosAdd.addMouseListener(new Frame_CriteriosSelecao3_jButton_DominiosPrioritariosAdd_mouseAdapter(this));
      jButton_DominiosPrioritariosIns = new JButton(fmeComum.inserirLinha);
      jButton_DominiosPrioritariosIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_DominiosPrioritariosIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosPrioritariosIns.setToolTipText("Inserir Linha");
      jButton_DominiosPrioritariosIns.addMouseListener(new Frame_CriteriosSelecao3_jButton_DominiosPrioritariosIns_mouseAdapter(this));
      jButton_DominiosPrioritariosDel = new JButton(fmeComum.apagarLinha);
      jButton_DominiosPrioritariosDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_DominiosPrioritariosDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosPrioritariosDel.setToolTipText("Apagar Linha");
      jButton_DominiosPrioritariosDel.addMouseListener(new Frame_CriteriosSelecao3_jButton_DominiosPrioritariosDel_mouseAdapter(this));
      
      jTable_Dominios = new JTable_Tip(40) {
        private static final long serialVersionUID = 1L;
        
        public void changeSelection(int rowIndex, int columnIndex, boolean toggle, boolean extend) { super.changeSelection(rowIndex, columnIndex, toggle, extend);
          CHTabela handler = (CHTabela)getModel();
          d.on_row(j.getSelectedRow());
        }
        
      };
      jTable_Dominios.setName("DominiosPrioritarios_Tabela");
      


      jScrollPane_Dominios = new JScrollPane();
      jScrollPane_Dominios.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 170));
      jScrollPane_Dominios.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Dominios.setVerticalScrollBarPolicy(21);
      jScrollPane_Dominios.setHorizontalScrollBarPolicy(31);
      jScrollPane_Dominios.setBorder(fmeComum.blocoBorder);
      jScrollPane_Dominios.setViewportView(jTable_Dominios);
      
      jPanel_Dominios = new JPanel();
      jPanel_Dominios.setLayout(null);
      jPanel_Dominios.setOpaque(false);
      jPanel_Dominios.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'ż'));
      jPanel_Dominios.setBorder(fmeComum.blocoBorder);
      jPanel_Dominios.add(jLabel_Dominios, null);
      jPanel_Dominios.add(jButton_DominiosPrioritariosAdd, null);
      jPanel_Dominios.add(jButton_DominiosPrioritariosIns, null);
      jPanel_Dominios.add(jButton_DominiosPrioritariosDel, null);
      jPanel_Dominios.add(jScrollPane_Dominios, null);
      
      jLabel_Dominios_Design = new JLabel("Justificação");
      jLabel_Dominios_Design.setBounds(new Rectangle(30, 220, 620, 18));
      jLabel_Dominios_Design.setVerticalAlignment(1);
      jLabel_Dominios_Design.setFont(fmeComum.letra_bold);
      
      jLabel_Dominios_Count = new JLabel("");
      jLabel_Dominios_Count.setBounds(new Rectangle(getjScrollPane_Dominios_Txt().getWidth() + getjScrollPane_Dominios_Txt().getX() - 200, getjScrollPane_Dominios_Txt().getY() - 15, 200, 20));
      jLabel_Dominios_Count.setFont(fmeComum.letra_pequena);
      jLabel_Dominios_Count.setForeground(Color.GRAY);
      jLabel_Dominios_Count.setHorizontalAlignment(4);
      
      jPanel_Dominios.add(jLabel_Dominios_Design, null);
      jPanel_Dominios.add(jLabel_Dominios_Count, null);
      jPanel_Dominios.add(getjScrollPane_Dominios_Txt(), null);
    }
    
    return jPanel_Dominios;
  }
  
  public JScrollPane getjScrollPane_Dominios_Txt() {
    if (jScrollPane_Dominios_Txt == null) {
      jScrollPane_Dominios_Txt = new JScrollPane();
      jScrollPane_Dominios_Txt.setBounds(new Rectangle(25, 240, fmeApp.width - 90 - 20, 120));
      jScrollPane_Dominios_Txt.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Dominios_Txt.setVerticalScrollBarPolicy(20);
      
      jScrollPane_Dominios_Txt.setViewportView(getjTextArea_Dominios_Txt());
    }
    return jScrollPane_Dominios_Txt;
  }
  
  public JTextArea getjTextArea_Dominios_Txt() {
    if (jTextArea_Dominios_Txt == null) {
      jTextArea_Dominios_Txt = new JTextArea();
      jTextArea_Dominios_Txt.setFont(fmeComum.letra);
      jTextArea_Dominios_Txt.setLineWrap(true);
      jTextArea_Dominios_Txt.setWrapStyleWord(true);
      jTextArea_Dominios_Txt.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Dominios_Txt.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.DadosDominioPrioritario.on_update2();
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Dominios_Txt;
  }
  
  public JPanel getjPanel_C1_Txt_1()
  {
    int n_linhas = 2;
    
    if (jPanel_C1_Txt_1 == null) {
      jLabel_C1_Design_1 = getJLabelDesign("O projeto insere-se, de que forma, numa lógica coerente e expedita de aprofundamento das áreas que devem ser de especialização de Portugal?", n_linhas);
      jTextArea_C1_Txt_1 = getjTextArea();
      jTextArea_C1_Txt_1.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.CritSelC1.on_update("texto_1");
        }
        

        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_C1_Txt_1 = getjScrollPane(n_linhas);
      jScrollPane_C1_Txt_1.setViewportView(jTextArea_C1_Txt_1);
      
      jPanel_C1_Txt_1 = getJPanel(n_linhas);
      
      jLabel_Count_C1_1 = new JLabel("");
      jLabel_Count_C1_1.setBounds(new Rectangle(jPanel_C1_Txt_1.getWidth() - 200 - 15, jScrollPane_C1_Txt_1.getY() - 15, 200, 20));
      jLabel_Count_C1_1.setFont(fmeComum.letra_pequena);
      jLabel_Count_C1_1.setForeground(Color.GRAY);
      jLabel_Count_C1_1.setHorizontalAlignment(4);
      
      jPanel_C1_Txt_1.setName("evolucao_texto");
      jPanel_C1_Txt_1.add(jLabel_C1_Design_1, null);
      jPanel_C1_Txt_1.add(jLabel_Count_C1_1, null);
      jPanel_C1_Txt_1.add(jScrollPane_C1_Txt_1, null);
    }
    return jPanel_C1_Txt_1;
  }
  
  public JPanel getjPanel_C1_Txt_2() {
    int n_linhas = 2;
    
    if (jPanel_C1_Txt_2 == null) {
      jLabel_C1_Design_2 = getJLabelDesign("O projeto ajuda a reter e a potenciar áreas de conhecimento e atuação, e de que forma, que devem fazer parte dos domínios de especialização de Portugal no futuro?", n_linhas);
      jTextArea_C1_Txt_2 = getjTextArea();
      jTextArea_C1_Txt_2.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.CritSelC1.on_update("texto_2");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_C1_Txt_2 = getjScrollPane(n_linhas);
      jScrollPane_C1_Txt_2.setViewportView(jTextArea_C1_Txt_2);
      
      jPanel_C1_Txt_2 = getJPanel(n_linhas);
      
      jLabel_Count_C1_2 = new JLabel("");
      jLabel_Count_C1_2.setBounds(new Rectangle(jPanel_C1_Txt_2.getWidth() - 200 - 15, jScrollPane_C1_Txt_2.getY() - 15, 200, 20));
      jLabel_Count_C1_2.setFont(fmeComum.letra_pequena);
      jLabel_Count_C1_2.setForeground(Color.GRAY);
      jLabel_Count_C1_2.setHorizontalAlignment(4);
      
      jPanel_C1_Txt_2.setName("evolucao_texto");
      jPanel_C1_Txt_2.add(jLabel_C1_Design_2, null);
      jPanel_C1_Txt_2.add(jLabel_Count_C1_2, null);
      jPanel_C1_Txt_2.add(jScrollPane_C1_Txt_2, null);
    }
    return jPanel_C1_Txt_2;
  }
  
  public JPanel getjPanel_C1_Txt_3() {
    int n_linhas = 2;
    
    if (jPanel_C1_Txt_3 == null) {
      jLabel_C1_Design_3 = getJLabelDesign("O projeto é clara e inequivocamente contribuinte para uma lógica de especialização de Portugal em áreas condizentes com o que deve ser o seu perfil de desenvolvimento?", n_linhas);
      jTextArea_C1_Txt_3 = getjTextArea();
      jTextArea_C1_Txt_3.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.CritSelC1.on_update("texto_3");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_C1_Txt_3 = getjScrollPane(n_linhas);
      jScrollPane_C1_Txt_3.setViewportView(jTextArea_C1_Txt_3);
      
      jPanel_C1_Txt_3 = getJPanel(n_linhas);
      
      jLabel_Count_C1_3 = new JLabel("");
      jLabel_Count_C1_3.setBounds(new Rectangle(jPanel_C1_Txt_3.getWidth() - 200 - 15, jScrollPane_C1_Txt_3.getY() - 15, 200, 20));
      jLabel_Count_C1_3.setFont(fmeComum.letra_pequena);
      jLabel_Count_C1_3.setForeground(Color.GRAY);
      jLabel_Count_C1_3.setHorizontalAlignment(4);
      
      jPanel_C1_Txt_3.setName("evolucao_texto");
      jPanel_C1_Txt_3.add(jLabel_C1_Design_3, null);
      jPanel_C1_Txt_3.add(jLabel_Count_C1_3, null);
      jPanel_C1_Txt_3.add(jScrollPane_C1_Txt_3, null);
    }
    return jPanel_C1_Txt_3;
  }
  
  public JPanel getjPanel_C1_Txt_4() {
    int n_linhas = 2;
    
    if (jPanel_C1_Txt_4 == null) {
      jLabel_C1_Design_4 = getJLabelDesign("O projeto está alinhado com práticas de empresas/industrias que potenciem, e de que forma, o desenvolvimento seletivo e especializado do território português, ajudando à criação de valor pela via da internacionalização?", n_linhas);
      jTextArea_C1_Txt_4 = getjTextArea();
      jTextArea_C1_Txt_4.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.CritSelC1.on_update("texto_4");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_C1_Txt_4 = getjScrollPane(n_linhas);
      jScrollPane_C1_Txt_4.setViewportView(jTextArea_C1_Txt_4);
      
      jPanel_C1_Txt_4 = getJPanel(n_linhas);
      
      jLabel_Count_C1_4 = new JLabel("");
      jLabel_Count_C1_4.setBounds(new Rectangle(jPanel_C1_Txt_4.getWidth() - 200 - 15, jScrollPane_C1_Txt_4.getY() - 15, 200, 20));
      jLabel_Count_C1_4.setFont(fmeComum.letra_pequena);
      jLabel_Count_C1_4.setForeground(Color.GRAY);
      jLabel_Count_C1_4.setHorizontalAlignment(4);
      
      jPanel_C1_Txt_4.setName("evolucao_texto");
      jPanel_C1_Txt_4.add(jLabel_C1_Design_4, null);
      jPanel_C1_Txt_4.add(jLabel_Count_C1_4, null);
      jPanel_C1_Txt_4.add(jScrollPane_C1_Txt_4, null);
    }
    return jPanel_C1_Txt_4;
  }
  
  public JPanel getjPanel_Criterio_C3() {
    if (jPanel_Criterio_C3 == null)
    {
      jLabel_Criterio_C3 = new JLabel("<html><strong>C2. Grau de Qualificação do emprego criado</strong> - parte quantitativa obtida a partir dos dados do quadro de postos de trabalho</html>");
      jLabel_Criterio_C3.setBounds(new Rectangle(12, 10, fmeApp.width - 60, 18));
      jLabel_Criterio_C3.setVerticalAlignment(1);
      jLabel_Criterio_C3.setFont(fmeComum.letra);
      
      jPanel_Criterio_C3 = new JPanel();
      jPanel_Criterio_C3.setLayout(null);
      jPanel_Criterio_C3.setOpaque(false);
      jPanel_Criterio_C3.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 35));
      jPanel_Criterio_C3.setBorder(fmeComum.blocoBorder);
      jPanel_Criterio_C3.setName("evolucao_texto");
      jPanel_Criterio_C3.add(jLabel_Criterio_C3, null);
    }
    return jPanel_Criterio_C3;
  }
  
  public JLabel getJLabelDesign(String texto)
  {
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
  
  void jButton_DesafiosSocietaisAdd_mouseClicked(MouseEvent e) {
    CBData.DesafiosSocietais.on_add_row();
  }
  
  void jButton_DesafiosSocietaisDel_mouseClicked(MouseEvent e) {
    CBData.DesafiosSocietais.on_del_row();
    CBData.DesafiosSocietais.numerar(0);
  }
  
  void jButton_DesafiosSocietaisIns_mouseClicked(MouseEvent e) {
    CBData.DesafiosSocietais.on_ins_row();
  }
  
  void jButton_DominiosPrioritariosAdd_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritarios.on_add_row();
  }
  
  void jButton_DominiosPrioritariosDel_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritarios.on_del_row();
    CBData.DominiosPrioritarios.numerar(0);
  }
  
  void jButton_DominiosPrioritariosIns_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritarios.on_ins_row();
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    

    print_handler.scaleToWidth((int)(1.05D * getJPanel_Desafios().getWidth()));
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
    CBData.DesafiosSocietais.Clear();
    CBData.DominiosPrioritarios.Clear();
    CBData.CritSelC1.Clear();
    CBData.CritSelC1.after_open();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.DominiosPrioritarios.validar(null));
    grp.add_grp(CBData.CritSelC1.validar(null));
    grp.add_grp(CBData.DesafiosSocietais.validar(null));
    return grp;
  }
}
