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
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

public class Frame_AnaliseInterna extends JInternalFrame implements Pagina_Base
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
  
  private JPanel jPanel_Swot = null;
  private JLabel jLabel_Swot = null;
  private JLabel jLabel_FactInternos = null;
  private JLabel jLabel_FactExternos = null;
  private JLabel jLabel_FactPositivos = null;
  private JLabel jLabel_FactNegativos = null;
  
  private JLabel jLabel_S = null;
  private JScrollPane jScrollPane_S = null;
  public JTextArea jTextArea_S = null;
  public JLabel jLabel_Count_S = null;
  
  private JLabel jLabel_W = null;
  private JScrollPane jScrollPane_W = null;
  public JTextArea jTextArea_W = null;
  public JLabel jLabel_Count_W = null;
  
  private JLabel jLabel_O = null;
  private JScrollPane jScrollPane_O = null;
  public JTextArea jTextArea_O = null;
  public JLabel jLabel_Count_O = null;
  
  private JLabel jLabel_T = null;
  private JScrollPane jScrollPane_T = null;
  public JTextArea jTextArea_T = null;
  public JLabel jLabel_Count_T = null;
  
  private JLabel jLabel_Swot2 = null;
  private JLabel jLabel_PFortes = null;
  private JLabel jLabel_PFracos = null;
  private JLabel jLabel_Oportunidades = null;
  private JLabel jLabel_Ameacas = null;
  
  private JLabel jLabel_Apostas = null;
  private JScrollPane jScrollPane_Apostas = null;
  public JTextArea jTextArea_Apostas = null;
  public JLabel jLabel_Count_Apostas = null;
  
  private JLabel jLabel_Avisos = null;
  private JScrollPane jScrollPane_Avisos = null;
  public JTextArea jTextArea_Avisos = null;
  public JLabel jLabel_Count_Avisos = null;
  
  private JLabel jLabel_Restricoes = null;
  private JScrollPane jScrollPane_Restricoes = null;
  public JTextArea jTextArea_Restricoes = null;
  public JLabel jLabel_Count_Restricoes = null;
  
  private JLabel jLabel_Riscos = null;
  private JScrollPane jScrollPane_Riscos = null;
  public JTextArea jTextArea_Riscos = null;
  public JLabel jLabel_Count_Riscos = null;
  











  int y = 0; int h = 0;
  
  String tag = "";
  
  public Frame_AnaliseInterna()
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
    up_component(jPanel_Swot, 40);
  }
  
  int n_anos = 4;
  String alinea = "";
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (params.get("alinea") != null) alinea = ("<br>" + (String)params.get("alinea"));
    jLabel_SubDesign.setText(jLabel_SubDesign.getText().replaceAll("###alinea###", alinea));
    
    if (alinea.length() > 0) {
      int dif = 18;
      
      Rectangle r = jLabel_SubDesign.getBounds();
      height += dif;
      setBounds(r);
      
      r = getjScrollPane_Txt().getBounds();
      y += dif;
      height -= dif;
      getjScrollPane_Txt().setBounds(r);
      




      r = jLabel_Count.getBounds();
      y += dif;
      jLabel_Count.setBounds(r);
    }
  }
  


  private void initialize()
  {
    setSize(fmeApp.width - 35, 3000);
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
      jContentPane.add(getjPanel_Txt(), null);
      jContentPane.add(getJPanel_Swot(), null);
    }
    
    return jContentPane;
  }
  
  public JPanel getjPanel_Txt() {
    if (jPanel_Txt == null)
    {
      jLabel_Design = new JLabel("Análise Interna");
      jLabel_Design.setBounds(new Rectangle(12, 10, 620, 18));
      jLabel_Design.setVerticalAlignment(1);
      jLabel_Design.setFont(fmeComum.letra_bold);
      
      String label = "<html>(i) Situação da empresa nas áreas de competitividade críticas;<br>(ii) Posicionamento na cadeia de valor (atual e perspetiva futura);<br>(iii) Identificar os principais pontos fortes e pontos fracos da empresa face aos seus concorrentes;<br>(iv) Caracterizar a organização interna dos recursos da empresa e sua articulação na atividade da empresa/projeto###alinea###.</html>";
      





      jLabel_SubDesign = new JLabel(label);
      jLabel_SubDesign.setBounds(new Rectangle(15, 25, fmeApp.width - 90, 73));
      jLabel_SubDesign.setFont(fmeComum.letra);
      
      jPanel_Txt = new JPanel();
      jPanel_Txt.setLayout(null);
      jPanel_Txt.setOpaque(false);
      jPanel_Txt.setBounds(new Rectangle(15, this.y = 50, fmeApp.width - 60, this.h = 'Ŗ'));
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
      jScrollPane_Txt.setBounds(new Rectangle(15, 97, fmeApp.width - 90, 230));
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
          CBData.AnaliseInterna.on_update("txt_descricao");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Txt;
  }
  
  public JPanel getJPanel_Swot() {
    if (jPanel_Swot == null) {
      int x = 30;int y1 = 40;int w0 = 80;int w = 320;int h1 = 25;int h2 = 150;
      jLabel_Swot = new JLabel();
      jLabel_Swot.setBounds(new Rectangle(15, 10, 294, 18));
      jLabel_Swot.setText("<html>Análise SWOT</html>");
      jLabel_Swot.setFont(fmeComum.letra_bold);
      
      jLabel_FactInternos = new JLabel();
      jLabel_FactInternos.setBackground(fmeComum.colorBorder);
      jLabel_FactInternos.setOpaque(true);
      jLabel_FactInternos.setBounds(new Rectangle(x, y1 + h1 + 5, w0, h2));
      jLabel_FactInternos.setText("<html><center>Fatores<br>Internos</center></html>");
      jLabel_FactInternos.setHorizontalAlignment(0);
      jLabel_FactInternos.setBorder(fmeComum.blocoBorder);
      jLabel_FactExternos = new JLabel();
      jLabel_FactExternos.setBackground(fmeComum.colorBorder);
      jLabel_FactExternos.setOpaque(true);
      jLabel_FactExternos.setBounds(new Rectangle(x, y1 + h1 + 5 + h2 + 5, w0, h2));
      jLabel_FactExternos.setText("<html><center>Fatores<br>Externos</center></html>");
      jLabel_FactExternos.setHorizontalAlignment(0);
      jLabel_FactExternos.setBorder(fmeComum.blocoBorder);
      
      jLabel_FactPositivos = new JLabel();
      jLabel_FactPositivos.setBackground(fmeComum.colorBorder);
      jLabel_FactPositivos.setOpaque(true);
      jLabel_FactPositivos.setBounds(new Rectangle(x + w0 + 5, y1, w, h1));
      jLabel_FactPositivos.setText("<html><center></center></html>");
      jLabel_FactPositivos.setHorizontalAlignment(0);
      jLabel_FactPositivos.setBorder(fmeComum.blocoBorder);
      jLabel_FactNegativos = new JLabel();
      jLabel_FactNegativos.setBackground(fmeComum.colorBorder);
      jLabel_FactNegativos.setOpaque(true);
      
      jLabel_FactNegativos.setBounds(new Rectangle(x + w0 + 5 + w + 5, y1, w, h1));
      jLabel_FactNegativos.setText("<html><center></center></html>");
      jLabel_FactNegativos.setHorizontalAlignment(0);
      jLabel_FactNegativos.setBorder(fmeComum.blocoBorder);
      
      jTextArea_S = new JTextArea();
      jTextArea_S.setFont(fmeComum.letra);
      jTextArea_S.setLineWrap(true);
      jTextArea_S.setWrapStyleWord(true);
      jTextArea_S.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_S.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.AnaliseInterna.on_update("txt_pfortes");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_S = new JScrollPane();
      jScrollPane_S.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5 + 18, w, h2 - 18));
      jScrollPane_S.setPreferredSize(new Dimension(250, 250));
      jScrollPane_S.setVerticalScrollBarPolicy(20);
      jScrollPane_S.setBorder(fmeComum.blocoBorder);
      jScrollPane_S.setViewportView(jTextArea_S);
      jLabel_S = new JLabel("Pontos Fortes");
      jLabel_S.setFont(fmeComum.letra_bold);
      jLabel_S.setVerticalAlignment(1);
      jLabel_S.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5, w, h2));
      jLabel_S.setHorizontalAlignment(0);
      jLabel_S.setBorder(fmeComum.blocoBorder);
      jLabel_Count_S = new JLabel("");
      jLabel_Count_S.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5, w - 5, 20));
      jLabel_Count_S.setFont(fmeComum.letra_pequena);
      jLabel_Count_S.setForeground(Color.GRAY);
      jLabel_Count_S.setHorizontalAlignment(4);
      
      jTextArea_W = new JTextArea();
      jTextArea_W.setFont(fmeComum.letra);
      jTextArea_W.setLineWrap(true);
      jTextArea_W.setWrapStyleWord(true);
      jTextArea_W.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_W.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.AnaliseInterna.on_update("txt_pfracos");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_W = new JScrollPane();
      jScrollPane_W.setBounds(new Rectangle(x + w0 + 5 + w + 5, y1 + h1 + 5 + 18, w, h2 - 18));
      jScrollPane_W.setPreferredSize(new Dimension(250, 250));
      jScrollPane_W.setVerticalScrollBarPolicy(20);
      jScrollPane_W.setBorder(fmeComum.blocoBorder);
      jScrollPane_W.setViewportView(jTextArea_W);
      jLabel_W = new JLabel("Pontos Fracos");
      jLabel_W.setFont(fmeComum.letra_bold);
      jLabel_W.setVerticalAlignment(1);
      jLabel_W.setBounds(new Rectangle(x + w0 + 5 + w + 5, y1 + h1 + 5, w, h2));
      jLabel_W.setHorizontalAlignment(0);
      jLabel_W.setBorder(fmeComum.blocoBorder);
      jLabel_Count_W = new JLabel("");
      jLabel_Count_W.setBounds(new Rectangle(x + w0 + 5 + w + 5, y1 + h1 + 5, w - 5, 20));
      jLabel_Count_W.setFont(fmeComum.letra_pequena);
      jLabel_Count_W.setForeground(Color.GRAY);
      jLabel_Count_W.setHorizontalAlignment(4);
      
      jTextArea_O = new JTextArea();
      jTextArea_O.setFont(fmeComum.letra);
      jTextArea_O.setLineWrap(true);
      jTextArea_O.setWrapStyleWord(true);
      jTextArea_O.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_O.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.AnaliseInterna.on_update("txt_oportunidades");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_O = new JScrollPane();
      jScrollPane_O.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5 + h2 + 5 + 18, w, h2 - 18));
      jScrollPane_O.setPreferredSize(new Dimension(250, 250));
      jScrollPane_O.setVerticalScrollBarPolicy(20);
      jScrollPane_O.setBorder(fmeComum.blocoBorder);
      jScrollPane_O.setViewportView(jTextArea_O);
      jLabel_O = new JLabel("Oportunidades");
      jLabel_O.setFont(fmeComum.letra_bold);
      jLabel_O.setVerticalAlignment(1);
      jLabel_O.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5 + h2 + 5, w, h2));
      jLabel_O.setHorizontalAlignment(0);
      jLabel_O.setBorder(fmeComum.blocoBorder);
      jLabel_Count_O = new JLabel("");
      jLabel_Count_O.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5 + h2 + 5, w - 5, 20));
      jLabel_Count_O.setFont(fmeComum.letra_pequena);
      jLabel_Count_O.setForeground(Color.GRAY);
      jLabel_Count_O.setHorizontalAlignment(4);
      
      jTextArea_T = new JTextArea();
      jTextArea_T.setFont(fmeComum.letra);
      jTextArea_T.setLineWrap(true);
      jTextArea_T.setWrapStyleWord(true);
      jTextArea_T.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_T.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.AnaliseInterna.on_update("txt_ameacas");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_T = new JScrollPane();
      jScrollPane_T.setBounds(new Rectangle(x + w0 + w + 10, y1 + h1 + 5 + h2 + 5 + 18, w, h2 - 18));
      jScrollPane_T.setPreferredSize(new Dimension(250, 250));
      jScrollPane_T.setVerticalScrollBarPolicy(20);
      jScrollPane_T.setBorder(fmeComum.blocoBorder);
      jScrollPane_T.setViewportView(jTextArea_T);
      jLabel_T = new JLabel("Ameaças");
      jLabel_T.setFont(fmeComum.letra_bold);
      jLabel_T.setVerticalAlignment(1);
      jLabel_T.setBounds(new Rectangle(x + w0 + w + 10, y1 + h1 + 5 + h2 + 5, w, h2));
      jLabel_T.setHorizontalAlignment(0);
      jLabel_T.setBorder(fmeComum.blocoBorder);
      jLabel_Count_T = new JLabel("");
      jLabel_Count_T.setBounds(new Rectangle(x + w0 + w + 10, y1 + h1 + 5 + h2 + 5, w - 5, 20));
      jLabel_Count_T.setFont(fmeComum.letra_pequena);
      jLabel_Count_T.setForeground(Color.GRAY);
      jLabel_Count_T.setHorizontalAlignment(4);
      

      y1 += h1 + 5 + h2 + 5 + h2 + 20;
      h1 = 35;
      
      jLabel_Swot2 = new JLabel();
      jLabel_Swot2.setBounds(new Rectangle(x, y1, fmeApp.width - 90, 18));
      jLabel_Swot2.setText("<html>Desenvolva uma análise qualificada/dinâmica baseada na SWOT referida:</html>");
      jLabel_Swot2.setFont(fmeComum.letra);
      
      y1 += 25;
      
      jLabel_PFortes = new JLabel();
      jLabel_PFortes.setBackground(fmeComum.colorBorder);
      jLabel_PFortes.setOpaque(true);
      jLabel_PFortes.setBounds(new Rectangle(x, y1 + h1 + 5, w0, h2));
      jLabel_PFortes.setText("<html><center>Pontos<br>Fortes</center></html>");
      jLabel_PFortes.setHorizontalAlignment(0);
      jLabel_PFortes.setBorder(fmeComum.blocoBorder);
      jLabel_PFracos = new JLabel();
      jLabel_PFracos.setBackground(fmeComum.colorBorder);
      jLabel_PFracos.setOpaque(true);
      jLabel_PFracos.setBounds(new Rectangle(x, y1 + h1 + 5 + h2 + 5, w0, h2));
      jLabel_PFracos.setText("<html><center>Pontos<br>Fracos</center></html>");
      jLabel_PFracos.setHorizontalAlignment(0);
      jLabel_PFracos.setBorder(fmeComum.blocoBorder);
      
      jLabel_Oportunidades = new JLabel();
      jLabel_Oportunidades.setBackground(fmeComum.colorBorder);
      jLabel_Oportunidades.setOpaque(true);
      jLabel_Oportunidades.setBounds(new Rectangle(x + w0 + 5, y1, w, h1));
      jLabel_Oportunidades.setText("<html><center>Oportunidades</center></html>");
      jLabel_Oportunidades.setHorizontalAlignment(0);
      jLabel_Oportunidades.setBorder(fmeComum.blocoBorder);
      jLabel_Ameacas = new JLabel();
      jLabel_Ameacas.setBackground(fmeComum.colorBorder);
      jLabel_Ameacas.setOpaque(true);
      jLabel_Ameacas.setBounds(new Rectangle(x + w0 + 5 + w + 5, y1, w, h1));
      jLabel_Ameacas.setText("<html><center>Ameaças</center></html>");
      jLabel_Ameacas.setHorizontalAlignment(0);
      jLabel_Ameacas.setBorder(fmeComum.blocoBorder);
      
      jTextArea_Apostas = new JTextArea();
      jTextArea_Apostas.setFont(fmeComum.letra);
      jTextArea_Apostas.setLineWrap(true);
      jTextArea_Apostas.setWrapStyleWord(true);
      jTextArea_Apostas.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Apostas.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.AnaliseInterna.on_update("txt_apostas");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_Apostas = new JScrollPane();
      jScrollPane_Apostas.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5 + 18, w, h2 - 18));
      jScrollPane_Apostas.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Apostas.setVerticalScrollBarPolicy(20);
      jScrollPane_Apostas.setBorder(fmeComum.blocoBorder);
      jScrollPane_Apostas.setViewportView(jTextArea_Apostas);
      jLabel_Apostas = new JLabel("Apostas");
      jLabel_Apostas.setFont(fmeComum.letra_bold);
      jLabel_Apostas.setVerticalAlignment(1);
      jLabel_Apostas.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5, w, h2));
      jLabel_Apostas.setHorizontalAlignment(0);
      jLabel_Apostas.setBorder(fmeComum.blocoBorder);
      jLabel_Count_Apostas = new JLabel("");
      jLabel_Count_Apostas.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5, w - 5, 20));
      jLabel_Count_Apostas.setFont(fmeComum.letra_pequena);
      jLabel_Count_Apostas.setForeground(Color.GRAY);
      jLabel_Count_Apostas.setHorizontalAlignment(4);
      
      jTextArea_Avisos = new JTextArea();
      jTextArea_Avisos.setFont(fmeComum.letra);
      jTextArea_Avisos.setLineWrap(true);
      jTextArea_Avisos.setWrapStyleWord(true);
      jTextArea_Avisos.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Avisos.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.AnaliseInterna.on_update("txt_avisos");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_Avisos = new JScrollPane();
      jScrollPane_Avisos.setBounds(new Rectangle(x + w0 + 5 + w + 5, y1 + h1 + 5 + 18, w, h2 - 18));
      jScrollPane_Avisos.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Avisos.setVerticalScrollBarPolicy(20);
      jScrollPane_Avisos.setBorder(fmeComum.blocoBorder);
      jScrollPane_Avisos.setViewportView(jTextArea_Avisos);
      jLabel_Avisos = new JLabel("Avisos");
      jLabel_Avisos.setFont(fmeComum.letra_bold);
      jLabel_Avisos.setVerticalAlignment(1);
      jLabel_Avisos.setBounds(new Rectangle(x + w0 + 5 + w + 5, y1 + h1 + 5, w, h2));
      jLabel_Avisos.setHorizontalAlignment(0);
      jLabel_Avisos.setBorder(fmeComum.blocoBorder);
      jLabel_Count_Avisos = new JLabel("");
      jLabel_Count_Avisos.setBounds(new Rectangle(x + w0 + 5 + w + 5, y1 + h1 + 5, w - 5, 20));
      jLabel_Count_Avisos.setFont(fmeComum.letra_pequena);
      jLabel_Count_Avisos.setForeground(Color.GRAY);
      jLabel_Count_Avisos.setHorizontalAlignment(4);
      
      jTextArea_Restricoes = new JTextArea();
      jTextArea_Restricoes.setFont(fmeComum.letra);
      jTextArea_Restricoes.setLineWrap(true);
      jTextArea_Restricoes.setWrapStyleWord(true);
      jTextArea_Restricoes.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Restricoes.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.AnaliseInterna.on_update("txt_restricoes");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_Restricoes = new JScrollPane();
      jScrollPane_Restricoes.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5 + h2 + 5 + 18, w, h2 - 18));
      jScrollPane_Restricoes.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Restricoes.setVerticalScrollBarPolicy(20);
      jScrollPane_Restricoes.setBorder(fmeComum.blocoBorder);
      jScrollPane_Restricoes.setViewportView(jTextArea_Restricoes);
      jLabel_Restricoes = new JLabel("Restrições");
      jLabel_Restricoes.setFont(fmeComum.letra_bold);
      jLabel_Restricoes.setVerticalAlignment(1);
      jLabel_Restricoes.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5 + h2 + 5, w, h2));
      jLabel_Restricoes.setHorizontalAlignment(0);
      jLabel_Restricoes.setBorder(fmeComum.blocoBorder);
      jLabel_Count_Restricoes = new JLabel("");
      jLabel_Count_Restricoes.setBounds(new Rectangle(x + w0 + 5, y1 + h1 + 5 + h2 + 5, w - 5, 20));
      jLabel_Count_Restricoes.setFont(fmeComum.letra_pequena);
      jLabel_Count_Restricoes.setForeground(Color.GRAY);
      jLabel_Count_Restricoes.setHorizontalAlignment(4);
      
      jTextArea_Riscos = new JTextArea();
      jTextArea_Riscos.setFont(fmeComum.letra);
      jTextArea_Riscos.setLineWrap(true);
      jTextArea_Riscos.setWrapStyleWord(true);
      jTextArea_Riscos.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Riscos.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.AnaliseInterna.on_update("txt_riscos");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_Riscos = new JScrollPane();
      jScrollPane_Riscos.setBounds(new Rectangle(x + w0 + w + 10, y1 + h1 + 5 + h2 + 5 + 18, w, h2 - 18));
      jScrollPane_Riscos.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Riscos.setVerticalScrollBarPolicy(20);
      jScrollPane_Riscos.setBorder(fmeComum.blocoBorder);
      jScrollPane_Riscos.setViewportView(jTextArea_Riscos);
      jLabel_Riscos = new JLabel("Riscos");
      jLabel_Riscos.setFont(fmeComum.letra_bold);
      jLabel_Riscos.setVerticalAlignment(1);
      jLabel_Riscos.setBounds(new Rectangle(x + w0 + w + 10, y1 + h1 + 5 + h2 + 5, w, h2));
      jLabel_Riscos.setHorizontalAlignment(0);
      jLabel_Riscos.setBorder(fmeComum.blocoBorder);
      jLabel_Count_Riscos = new JLabel("");
      jLabel_Count_Riscos.setBounds(new Rectangle(x + w0 + w + 10, y1 + h1 + 5 + h2 + 5, w - 5, 20));
      jLabel_Count_Riscos.setFont(fmeComum.letra_pequena);
      jLabel_Count_Riscos.setForeground(Color.GRAY);
      jLabel_Count_Riscos.setHorizontalAlignment(4);
      



      jPanel_Swot = new JPanel();
      jPanel_Swot.setLayout(null);
      jPanel_Swot.setOpaque(false);
      jPanel_Swot.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = y1 + h1 + 5 + h2 + 5 + h2 + 20));
      jPanel_Swot.setBorder(fmeComum.blocoBorder);
      jPanel_Swot.add(jLabel_Swot, null);
      jPanel_Swot.add(jLabel_FactInternos, null);
      jPanel_Swot.add(jLabel_FactExternos, null);
      jPanel_Swot.add(jLabel_FactPositivos, null);
      jPanel_Swot.add(jLabel_FactNegativos, null);
      jPanel_Swot.add(jLabel_S, null);
      jPanel_Swot.add(jScrollPane_S, null);
      jPanel_Swot.add(jLabel_Count_S, null);
      jPanel_Swot.add(jLabel_W, null);
      jPanel_Swot.add(jScrollPane_W, null);
      jPanel_Swot.add(jLabel_Count_W, null);
      jPanel_Swot.add(jLabel_O, null);
      jPanel_Swot.add(jScrollPane_O, null);
      jPanel_Swot.add(jLabel_Count_O, null);
      jPanel_Swot.add(jLabel_T, null);
      jPanel_Swot.add(jScrollPane_T, null);
      jPanel_Swot.add(jLabel_Count_T, null);
      
      jPanel_Swot.add(jLabel_Swot2, null);
      jPanel_Swot.add(jLabel_PFortes, null);
      jPanel_Swot.add(jLabel_PFracos, null);
      jPanel_Swot.add(jLabel_Oportunidades, null);
      jPanel_Swot.add(jLabel_Ameacas, null);
      jPanel_Swot.add(jLabel_Apostas, null);
      jPanel_Swot.add(jScrollPane_Apostas, null);
      jPanel_Swot.add(jLabel_Count_Apostas, null);
      jPanel_Swot.add(jLabel_Avisos, null);
      jPanel_Swot.add(jScrollPane_Avisos, null);
      jPanel_Swot.add(jLabel_Count_Avisos, null);
      jPanel_Swot.add(jLabel_Restricoes, null);
      jPanel_Swot.add(jScrollPane_Restricoes, null);
      jPanel_Swot.add(jLabel_Count_Restricoes, null);
      jPanel_Swot.add(jLabel_Riscos, null);
      jPanel_Swot.add(jScrollPane_Riscos, null);
      jPanel_Swot.add(jLabel_Count_Riscos, null);
    }
    
    return jPanel_Swot;
  }
  



















































































  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    


    int w = jPanel_Txt.getWidth() + print_handler.dx_expand;
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
    CBData.AnaliseInterna.Clear();
    CBData.AnaliseInterna.after_open();
  }
  
  public CHValid_Grp validar_pg()
  {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.AnaliseInterna.validar_1(null, ""));
    grp.add_grp(CBData.AnaliseInterna.validar_2(null, ""));
    
    return grp;
  }
}
