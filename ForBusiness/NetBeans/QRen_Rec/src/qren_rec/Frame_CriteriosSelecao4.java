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

public class Frame_CriteriosSelecao4 extends javax.swing.JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_Criterio_D1 = null;
  public JLabel jLabel_Criterio_D1 = null;
  
  private JPanel jPanel_DominiosNorte = null;
  private JLabel jLabel_DominiosNorte = null;
  public JScrollPane jScrollPane_DominiosNorte = null;
  public JTable_Tip jTable_DominiosNorte = null;
  private JButton jButton_DominiosNorteAdd = null;
  private JButton jButton_DominiosNorteIns = null;
  private JButton jButton_DominiosNorteDel = null;
  
  private JPanel jPanel_DominiosCentro = null;
  private JLabel jLabel_DominiosCentro = null;
  public JScrollPane jScrollPane_DominiosCentro = null;
  public JTable_Tip jTable_DominiosCentro = null;
  private JButton jButton_DominiosCentroAdd = null;
  private JButton jButton_DominiosCentroIns = null;
  private JButton jButton_DominiosCentroDel = null;
  
  private JPanel jPanel_DominiosLisboa = null;
  private JLabel jLabel_DominiosLisboa = null;
  public JScrollPane jScrollPane_DominiosLisboa = null;
  public JTable_Tip jTable_DominiosLisboa = null;
  private JButton jButton_DominiosLisboaAdd = null;
  private JButton jButton_DominiosLisboaIns = null;
  private JButton jButton_DominiosLisboaDel = null;
  
  private JPanel jPanel_DominiosAlentejo = null;
  private JLabel jLabel_DominiosAlentejo = null;
  public JScrollPane jScrollPane_DominiosAlentejo = null;
  public JTable_Tip jTable_DominiosAlentejo = null;
  private JButton jButton_DominiosAlentejoAdd = null;
  private JButton jButton_DominiosAlentejoIns = null;
  private JButton jButton_DominiosAlentejoDel = null;
  
  private JPanel jPanel_DominiosAlgarve = null;
  private JLabel jLabel_DominiosAlgarve = null;
  public JScrollPane jScrollPane_DominiosAlgarve = null;
  public JTable_Tip jTable_DominiosAlgarve = null;
  private JButton jButton_DominiosAlgarveAdd = null;
  private JButton jButton_DominiosAlgarveIns = null;
  private JButton jButton_DominiosAlgarveDel = null;
  






  private JPanel jPanel_D2_Txt = null;
  public JLabel jLabel_D2_Design = null;
  public JScrollPane jScrollPane_D2_Txt = null;
  public JTextArea jTextArea_D2_Txt = null;
  public JLabel jLabel_Count_D2 = null;
  
  String tag = "";
  
  int y = 40; int h = 0;
  
  public Frame_CriteriosSelecao4()
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
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getjPanel_Criterio_D1(), null);
      
      jContentPane.add(getJPanel_DominiosNorte(), null);
      jContentPane.add(getJPanel_DominiosCentro(), null);
      jContentPane.add(getJPanel_DominiosLisboa(), null);
      jContentPane.add(getJPanel_DominiosAlentejo(), null);
      jContentPane.add(getJPanel_DominiosAlgarve(), null);
      jContentPane.add(getjPanel_D2_Txt(), null);
    }
    return jContentPane;
  }
  
  public JPanel getjPanel_Criterio_D1() {
    if (jPanel_Criterio_D1 == null)
    {
      jLabel_Criterio_D1 = new JLabel("<html><strong>D1. Nível de enquadramento na RIS3</strong> - grau de alinhamento/pertinência nos domínios definidos na <strong>RIS3 regional</strong>, através de matrizes específicas para cada NUTS II</html>");
      jLabel_Criterio_D1.setBounds(new Rectangle(15, 10, fmeApp.width - 90, 33));
      jLabel_Criterio_D1.setVerticalAlignment(1);
      jLabel_Criterio_D1.setFont(fmeComum.letra);
      
      jPanel_Criterio_D1 = new JPanel();
      jPanel_Criterio_D1.setLayout(null);
      jPanel_Criterio_D1.setOpaque(false);
      jPanel_Criterio_D1.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 50));
      jPanel_Criterio_D1.setBorder(fmeComum.blocoBorder);
      jPanel_Criterio_D1.setName("evolucao_texto");
      jPanel_Criterio_D1.add(jLabel_Criterio_D1, null);
    }
    return jPanel_Criterio_D1;
  }
  


































  public JPanel getJPanel_DominiosNorte()
  {
    if (jPanel_DominiosNorte == null)
    {
      jLabel_DominiosNorte = new JLabel();
      jLabel_DominiosNorte.setBounds(new Rectangle(15, 10, 500, 18));
      jLabel_DominiosNorte.setText("<html>Domínios prioritários de especialização inteligente (EREI) - Norte</html>");
      jLabel_DominiosNorte.setFont(fmeComum.letra_bold);
      
      jButton_DominiosNorteAdd = new JButton(fmeComum.novaLinha);
      jButton_DominiosNorteAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_DominiosNorteAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosNorteAdd.setToolTipText("Nova Linha");
      jButton_DominiosNorteAdd.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosNorteAdd_mouseAdapter(this));
      jButton_DominiosNorteIns = new JButton(fmeComum.inserirLinha);
      jButton_DominiosNorteIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_DominiosNorteIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosNorteIns.setToolTipText("Inserir Linha");
      jButton_DominiosNorteIns.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosNorteIns_mouseAdapter(this));
      jButton_DominiosNorteDel = new JButton(fmeComum.apagarLinha);
      jButton_DominiosNorteDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_DominiosNorteDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosNorteDel.setToolTipText("Apagar Linha");
      jButton_DominiosNorteDel.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosNorteDel_mouseAdapter(this));
      
      jTable_DominiosNorte = new JTable_Tip(40);
      jTable_DominiosNorte.setName("DominiosPrioritariosNorte_Tabela");
      


      jScrollPane_DominiosNorte = new JScrollPane();
      jScrollPane_DominiosNorte.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 170));
      jScrollPane_DominiosNorte.setPreferredSize(new Dimension(250, 250));
      jScrollPane_DominiosNorte.setVerticalScrollBarPolicy(22);
      jScrollPane_DominiosNorte.setHorizontalScrollBarPolicy(31);
      jScrollPane_DominiosNorte.setBorder(fmeComum.blocoBorder);
      jScrollPane_DominiosNorte.setViewportView(jTable_DominiosNorte);
      
      jPanel_DominiosNorte = new JPanel();
      jPanel_DominiosNorte.setLayout(null);
      jPanel_DominiosNorte.setOpaque(false);
      jPanel_DominiosNorte.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'Ü'));
      jPanel_DominiosNorte.setBorder(fmeComum.blocoBorder);
      jPanel_DominiosNorte.add(jLabel_DominiosNorte, null);
      jPanel_DominiosNorte.add(jButton_DominiosNorteAdd, null);
      jPanel_DominiosNorte.add(jButton_DominiosNorteIns, null);
      jPanel_DominiosNorte.add(jButton_DominiosNorteDel, null);
      jPanel_DominiosNorte.add(jScrollPane_DominiosNorte, null);
    }
    return jPanel_DominiosNorte;
  }
  
  public JPanel getJPanel_DominiosCentro() {
    if (jPanel_DominiosCentro == null)
    {
      jLabel_DominiosCentro = new JLabel();
      jLabel_DominiosCentro.setBounds(new Rectangle(15, 10, 500, 18));
      jLabel_DominiosCentro.setText("<html>Domínios prioritários de especialização inteligente (EREI) - Centro</html>");
      jLabel_DominiosCentro.setFont(fmeComum.letra_bold);
      
      jButton_DominiosCentroAdd = new JButton(fmeComum.novaLinha);
      jButton_DominiosCentroAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_DominiosCentroAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosCentroAdd.setToolTipText("Nova Linha");
      jButton_DominiosCentroAdd.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosCentroAdd_mouseAdapter(this));
      jButton_DominiosCentroIns = new JButton(fmeComum.inserirLinha);
      jButton_DominiosCentroIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_DominiosCentroIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosCentroIns.setToolTipText("Inserir Linha");
      jButton_DominiosCentroIns.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosCentroIns_mouseAdapter(this));
      jButton_DominiosCentroDel = new JButton(fmeComum.apagarLinha);
      jButton_DominiosCentroDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_DominiosCentroDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosCentroDel.setToolTipText("Apagar Linha");
      jButton_DominiosCentroDel.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosCentroDel_mouseAdapter(this));
      
      jTable_DominiosCentro = new JTable_Tip(40);
      jTable_DominiosCentro.setName("DominiosPrioritariosCentro_Tabela");
      


      jScrollPane_DominiosCentro = new JScrollPane();
      jScrollPane_DominiosCentro.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 170));
      jScrollPane_DominiosCentro.setPreferredSize(new Dimension(250, 250));
      jScrollPane_DominiosCentro.setVerticalScrollBarPolicy(22);
      jScrollPane_DominiosCentro.setHorizontalScrollBarPolicy(31);
      jScrollPane_DominiosCentro.setBorder(fmeComum.blocoBorder);
      jScrollPane_DominiosCentro.setViewportView(jTable_DominiosCentro);
      
      jPanel_DominiosCentro = new JPanel();
      jPanel_DominiosCentro.setLayout(null);
      jPanel_DominiosCentro.setOpaque(false);
      jPanel_DominiosCentro.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'Ü'));
      jPanel_DominiosCentro.setBorder(fmeComum.blocoBorder);
      jPanel_DominiosCentro.add(jLabel_DominiosCentro, null);
      jPanel_DominiosCentro.add(jButton_DominiosCentroAdd, null);
      jPanel_DominiosCentro.add(jButton_DominiosCentroIns, null);
      jPanel_DominiosCentro.add(jButton_DominiosCentroDel, null);
      jPanel_DominiosCentro.add(jScrollPane_DominiosCentro, null);
    }
    return jPanel_DominiosCentro;
  }
  
  public JPanel getJPanel_DominiosLisboa() {
    if (jPanel_DominiosLisboa == null)
    {
      jLabel_DominiosLisboa = new JLabel();
      jLabel_DominiosLisboa.setBounds(new Rectangle(15, 10, 500, 18));
      jLabel_DominiosLisboa.setText("<html>Domínios prioritários de especialização inteligente (EREI) - Lisboa</html>");
      jLabel_DominiosLisboa.setFont(fmeComum.letra_bold);
      
      jButton_DominiosLisboaAdd = new JButton(fmeComum.novaLinha);
      jButton_DominiosLisboaAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_DominiosLisboaAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosLisboaAdd.setToolTipText("Nova Linha");
      jButton_DominiosLisboaAdd.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosLisboaAdd_mouseAdapter(this));
      jButton_DominiosLisboaIns = new JButton(fmeComum.inserirLinha);
      jButton_DominiosLisboaIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_DominiosLisboaIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosLisboaIns.setToolTipText("Inserir Linha");
      jButton_DominiosLisboaIns.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosLisboaIns_mouseAdapter(this));
      jButton_DominiosLisboaDel = new JButton(fmeComum.apagarLinha);
      jButton_DominiosLisboaDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_DominiosLisboaDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosLisboaDel.setToolTipText("Apagar Linha");
      jButton_DominiosLisboaDel.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosLisboaDel_mouseAdapter(this));
      
      jTable_DominiosLisboa = new JTable_Tip(40);
      jTable_DominiosLisboa.setName("DominiosPrioritariosLisboa_Tabela");
      


      jScrollPane_DominiosLisboa = new JScrollPane();
      jScrollPane_DominiosLisboa.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 170));
      jScrollPane_DominiosLisboa.setPreferredSize(new Dimension(250, 250));
      jScrollPane_DominiosLisboa.setVerticalScrollBarPolicy(22);
      jScrollPane_DominiosLisboa.setHorizontalScrollBarPolicy(31);
      jScrollPane_DominiosLisboa.setBorder(fmeComum.blocoBorder);
      jScrollPane_DominiosLisboa.setViewportView(jTable_DominiosLisboa);
      
      jPanel_DominiosLisboa = new JPanel();
      jPanel_DominiosLisboa.setLayout(null);
      jPanel_DominiosLisboa.setOpaque(false);
      jPanel_DominiosLisboa.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'Ü'));
      jPanel_DominiosLisboa.setBorder(fmeComum.blocoBorder);
      jPanel_DominiosLisboa.add(jLabel_DominiosLisboa, null);
      jPanel_DominiosLisboa.add(jButton_DominiosLisboaAdd, null);
      jPanel_DominiosLisboa.add(jButton_DominiosLisboaIns, null);
      jPanel_DominiosLisboa.add(jButton_DominiosLisboaDel, null);
      jPanel_DominiosLisboa.add(jScrollPane_DominiosLisboa, null);
    }
    return jPanel_DominiosLisboa;
  }
  
  public JPanel getJPanel_DominiosAlentejo() {
    if (jPanel_DominiosAlentejo == null)
    {
      jLabel_DominiosAlentejo = new JLabel();
      jLabel_DominiosAlentejo.setBounds(new Rectangle(15, 10, 500, 18));
      jLabel_DominiosAlentejo.setText("<html>Domínios prioritários de especialização inteligente (EREI) - Alentejo</html>");
      jLabel_DominiosAlentejo.setFont(fmeComum.letra_bold);
      
      jButton_DominiosAlentejoAdd = new JButton(fmeComum.novaLinha);
      jButton_DominiosAlentejoAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_DominiosAlentejoAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosAlentejoAdd.setToolTipText("Nova Linha");
      jButton_DominiosAlentejoAdd.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosAlentejoAdd_mouseAdapter(this));
      jButton_DominiosAlentejoIns = new JButton(fmeComum.inserirLinha);
      jButton_DominiosAlentejoIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_DominiosAlentejoIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosAlentejoIns.setToolTipText("Inserir Linha");
      jButton_DominiosAlentejoIns.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosAlentejoIns_mouseAdapter(this));
      jButton_DominiosAlentejoDel = new JButton(fmeComum.apagarLinha);
      jButton_DominiosAlentejoDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_DominiosAlentejoDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosAlentejoDel.setToolTipText("Apagar Linha");
      jButton_DominiosAlentejoDel.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosAlentejoDel_mouseAdapter(this));
      
      jTable_DominiosAlentejo = new JTable_Tip(40);
      jTable_DominiosAlentejo.setName("DominiosPrioritariosAlentejo_Tabela");
      


      jScrollPane_DominiosAlentejo = new JScrollPane();
      jScrollPane_DominiosAlentejo.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 170));
      jScrollPane_DominiosAlentejo.setPreferredSize(new Dimension(250, 250));
      jScrollPane_DominiosAlentejo.setVerticalScrollBarPolicy(22);
      jScrollPane_DominiosAlentejo.setHorizontalScrollBarPolicy(31);
      jScrollPane_DominiosAlentejo.setBorder(fmeComum.blocoBorder);
      jScrollPane_DominiosAlentejo.setViewportView(jTable_DominiosAlentejo);
      
      jPanel_DominiosAlentejo = new JPanel();
      jPanel_DominiosAlentejo.setLayout(null);
      jPanel_DominiosAlentejo.setOpaque(false);
      jPanel_DominiosAlentejo.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'Ü'));
      jPanel_DominiosAlentejo.setBorder(fmeComum.blocoBorder);
      jPanel_DominiosAlentejo.add(jLabel_DominiosAlentejo, null);
      jPanel_DominiosAlentejo.add(jButton_DominiosAlentejoAdd, null);
      jPanel_DominiosAlentejo.add(jButton_DominiosAlentejoIns, null);
      jPanel_DominiosAlentejo.add(jButton_DominiosAlentejoDel, null);
      jPanel_DominiosAlentejo.add(jScrollPane_DominiosAlentejo, null);
    }
    return jPanel_DominiosAlentejo;
  }
  
  public JPanel getJPanel_DominiosAlgarve() {
    if (jPanel_DominiosAlgarve == null)
    {
      jLabel_DominiosAlgarve = new JLabel();
      jLabel_DominiosAlgarve.setBounds(new Rectangle(15, 10, 500, 18));
      jLabel_DominiosAlgarve.setText("<html>Domínios prioritários de especialização inteligente (EREI) - Algarve</html>");
      jLabel_DominiosAlgarve.setFont(fmeComum.letra_bold);
      
      jButton_DominiosAlgarveAdd = new JButton(fmeComum.novaLinha);
      jButton_DominiosAlgarveAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_DominiosAlgarveAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosAlgarveAdd.setToolTipText("Nova Linha");
      jButton_DominiosAlgarveAdd.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosAlgarveAdd_mouseAdapter(this));
      jButton_DominiosAlgarveIns = new JButton(fmeComum.inserirLinha);
      jButton_DominiosAlgarveIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_DominiosAlgarveIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosAlgarveIns.setToolTipText("Inserir Linha");
      jButton_DominiosAlgarveIns.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosAlgarveIns_mouseAdapter(this));
      jButton_DominiosAlgarveDel = new JButton(fmeComum.apagarLinha);
      jButton_DominiosAlgarveDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_DominiosAlgarveDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_DominiosAlgarveDel.setToolTipText("Apagar Linha");
      jButton_DominiosAlgarveDel.addMouseListener(new Frame_CriteriosSelecao4_jButton_DominiosAlgarveDel_mouseAdapter(this));
      
      jTable_DominiosAlgarve = new JTable_Tip(40);
      jTable_DominiosAlgarve.setName("DominiosPrioritariosAlgarve_Tabela");
      


      jScrollPane_DominiosAlgarve = new JScrollPane();
      jScrollPane_DominiosAlgarve.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 170));
      jScrollPane_DominiosAlgarve.setPreferredSize(new Dimension(250, 250));
      jScrollPane_DominiosAlgarve.setVerticalScrollBarPolicy(22);
      jScrollPane_DominiosAlgarve.setHorizontalScrollBarPolicy(31);
      jScrollPane_DominiosAlgarve.setBorder(fmeComum.blocoBorder);
      jScrollPane_DominiosAlgarve.setViewportView(jTable_DominiosAlgarve);
      
      jPanel_DominiosAlgarve = new JPanel();
      jPanel_DominiosAlgarve.setLayout(null);
      jPanel_DominiosAlgarve.setOpaque(false);
      jPanel_DominiosAlgarve.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'Ü'));
      jPanel_DominiosAlgarve.setBorder(fmeComum.blocoBorder);
      jPanel_DominiosAlgarve.add(jLabel_DominiosAlgarve, null);
      jPanel_DominiosAlgarve.add(jButton_DominiosAlgarveAdd, null);
      jPanel_DominiosAlgarve.add(jButton_DominiosAlgarveIns, null);
      jPanel_DominiosAlgarve.add(jButton_DominiosAlgarveDel, null);
      jPanel_DominiosAlgarve.add(jScrollPane_DominiosAlgarve, null);
    }
    return jPanel_DominiosAlgarve;
  }
  
  public JPanel getjPanel_D2_Txt() {
    int n_linhas = 2;
    
    if (jPanel_D2_Txt == null) {
      jLabel_D2_Design = getJLabelDesign("<html><strong>D2. Contributo para o desenvolvimento regional</strong> - Este subcritério avalia a criação líquida de emprego originada pelo projeto em função das características do mercado local (NUTS III) de trabalho no contexto da respetiva NUTS II</html>", n_linhas);
      jTextArea_D2_Txt = getjTextArea();
      jTextArea_D2_Txt.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.CritSelD2.on_update("texto");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
      jScrollPane_D2_Txt = getjScrollPane(n_linhas);
      jScrollPane_D2_Txt.setViewportView(jTextArea_D2_Txt);
      
      jPanel_D2_Txt = getJPanel(n_linhas);
      
      jLabel_Count_D2 = new JLabel("");
      jLabel_Count_D2.setBounds(new Rectangle(jPanel_D2_Txt.getWidth() - 200 - 15, jScrollPane_D2_Txt.getY() - 15, 200, 20));
      jLabel_Count_D2.setFont(fmeComum.letra_pequena);
      jLabel_Count_D2.setForeground(Color.GRAY);
      jLabel_Count_D2.setHorizontalAlignment(4);
      
      jPanel_D2_Txt.setName("evolucao_texto");
      jPanel_D2_Txt.add(jLabel_D2_Design, null);
      jPanel_D2_Txt.add(jLabel_Count_D2, null);
      jPanel_D2_Txt.add(jScrollPane_D2_Txt, null);
    }
    return jPanel_D2_Txt;
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
    scrollpane.setBounds(new Rectangle(15, 25, fmeApp.width - 90, 220));
    scrollpane.setPreferredSize(new Dimension(250, 250));
    scrollpane.setVerticalScrollBarPolicy(20);
    return scrollpane;
  }
  
  public JScrollPane getjScrollPane(int n_linhas) {
    JScrollPane scrollpane = getjScrollPane();
    scrollpane.setBounds(new Rectangle(15, 25 + (n_linhas - 1) * 18, fmeApp.width - 90, 200));
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
    panel.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 240 + (n_linhas - 1) * 18));
    panel.setBorder(fmeComum.blocoBorder);
    
    return panel;
  }
  
  void jButton_DominiosNorteAdd_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosNorte.on_add_row();
  }
  
  void jButton_DominiosNorteDel_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosNorte.on_del_row();
    CBData.DominiosPrioritariosNorte.numerar(0);
  }
  
  void jButton_DominiosNorteIns_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosNorte.on_ins_row();
  }
  
  void jButton_DominiosCentroAdd_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosCentro.on_add_row();
  }
  
  void jButton_DominiosCentroDel_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosCentro.on_del_row();
    CBData.DominiosPrioritariosCentro.numerar(0);
  }
  
  void jButton_DominiosCentroIns_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosCentro.on_ins_row();
  }
  
  void jButton_DominiosLisboaAdd_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosLisboa.on_add_row();
  }
  
  void jButton_DominiosLisboaDel_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosLisboa.on_del_row();
    CBData.DominiosPrioritariosLisboa.numerar(0);
  }
  
  void jButton_DominiosLisboaIns_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosLisboa.on_ins_row();
  }
  
  void jButton_DominiosAlentejoAdd_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosAlentejo.on_add_row();
  }
  
  void jButton_DominiosAlentejoDel_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosAlentejo.on_del_row();
    CBData.DominiosPrioritariosAlentejo.numerar(0);
  }
  
  void jButton_DominiosAlentejoIns_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosAlentejo.on_ins_row();
  }
  
  void jButton_DominiosAlgarveAdd_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosAlgarve.on_add_row();
  }
  
  void jButton_DominiosAlgarveDel_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosAlgarve.on_del_row();
    CBData.DominiosPrioritariosAlgarve.numerar(0);
  }
  
  void jButton_DominiosAlgarveIns_mouseClicked(MouseEvent e) {
    CBData.DominiosPrioritariosAlgarve.on_ins_row();
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    

    print_handler.scaleToWidth((int)(1.05D * getjPanel_D2_Txt().getWidth()));
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
    CBData.DominiosPrioritariosNorte.Clear();
    CBData.DominiosPrioritariosCentro.Clear();
    CBData.DominiosPrioritariosLisboa.Clear();
    CBData.DominiosPrioritariosAlentejo.Clear();
    CBData.DominiosPrioritariosAlgarve.Clear();
    CBData.CritSelD2.Clear();
    CBData.CritSelD2.after_open();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.DominiosPrioritariosNorte.validar(null));
    grp.add_grp(CBData.DominiosPrioritariosCentro.validar(null));
    grp.add_grp(CBData.DominiosPrioritariosLisboa.validar(null));
    grp.add_grp(CBData.DominiosPrioritariosAlentejo.validar(null));
    grp.add_grp(CBData.DominiosPrioritariosAlgarve.validar(null));
    grp.add_grp(CBData.CritSelD2.validar(null));
    return grp;
  }
}
