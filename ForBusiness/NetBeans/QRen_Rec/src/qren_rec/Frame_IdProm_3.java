package fme;

import java.awt.Component;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.GridBagConstraints;
import java.awt.Rectangle;
import java.awt.SystemColor;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseEvent;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.ButtonGroup;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.border.Border;






public class Frame_IdProm_3
  extends JInternalFrame
  implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  public JCheckBox jCheckBox_AutClear = new JCheckBox();
  private ButtonGroup jButtonGroup_Aut = null;
  
  private JPanel jPanel_Socios = null;
  private JLabel jLabel_Socios = null;
  private JScrollPane jScrollPane_Socios = null;
  private JTable_Tip jTable_Socios = null;
  private JButton jButton_SociosAdd = null;
  private JButton jButton_SociosIns = null;
  private JButton jButton_SociosDel = null;
  
  private JPanel jPanel_Part = null;
  private JLabel jLabel_Part = null;
  private JScrollPane jScrollPane_Part = null;
  private JTable_Tip jTable_Part = null;
  private JButton jButton_PartAdd = null;
  private JButton jButton_PartIns = null;
  private JButton jButton_PartDel = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  private JPanel jPanel_Dimensao = null;
  private JLabel jLabel_Dimensao_1 = null;
  public JCheckBox jCheckBox_sociosClear = new JCheckBox();
  private ButtonGroup jButtonGroup_socios = null;
  
  public JCheckBox jCheckBox_partClear = new JCheckBox();
  private ButtonGroup jButtonGroup_part = null;
  
  Border border_1 = BorderFactory.createLineBorder(SystemColor.inactiveCaption, 1);
  public JCheckBox jCheckBox_PessoaClear = new JCheckBox();
  public JCheckBox jCheckBox_EmpresaClear = new JCheckBox();
  private ButtonGroup jButtonGroup_Empresa = null;
  private JLabel jLabel_Dimensao = null;
  private JLabel jLabel_Dimensao_ = null;
  private JCheckBox jCheckBox_Micro = null;
  private JCheckBox jCheckBox_Pequena = null;
  private JCheckBox jCheckBox_Media = null;
  private JCheckBox jCheckBox_NaoPME = null;
  public JCheckBox jCheckBox_DimensaoClear = new JCheckBox();
  private ButtonGroup jButtonGroup_Dimensao = null;
  
  public JCheckBox jCheckBox_vistoClear = new JCheckBox();
  
  private JTable_Tip jTable_SociosPart = null;
  private JTable_Tip jTable_RelCapital = null;
  private JPanel jPanel_ParamProj = null;
  private JLabel jLabel_ParamProj = null;
  private JLabel jLabel_Sim = null;
  private JLabel jLabel_Nao = null;
  private JLabel jLabel_param_1 = null;
  private JCheckBox jCheckBox_Sim_1 = null;
  private JCheckBox jCheckBox_Nao_1 = null;
  public JCheckBox jCheckBox_1Clear = new JCheckBox();
  private ButtonGroup jButtonGroup_1 = null;
  private JLabel jLabel_param_2 = null;
  private JCheckBox jCheckBox_Sim_2 = null;
  private JCheckBox jCheckBox_Nao_2 = null;
  public JCheckBox jCheckBox_2Clear = new JCheckBox();
  private ButtonGroup jButtonGroup_2 = null;
  
  private JPanel jPanel_PTrabalho = null;
  private JLabel jLabel_PTrabalho = null;
  private JScrollPane jScrollPane_PTrabalho = null;
  private JTable_Tip jTable_PTrabalho = null;
  private JButton jButton_PTrabalhoCopy = null;
  private JButton jButton_PTrabalhoUp = null;
  private JButton jButton_PTrabalhoAdd = null;
  private JButton jButton_PTrabalhoIns = null;
  private JButton jButton_PTrabalhoDel = null;
  
  String tag = "";
  
  HashMap hs;
  
  int y = 50; int h = 0;
  public CBTabela_PTrabalho cbd_ptrabalho;
  
  public Frame_IdProm_3() {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(655, y + h + 10);
  }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void tirar_titulo() {
    jLabel_Titulo.setVisible(false);
    jLabel_PT2020.setVisible(false);
    up_component(jPanel_Socios, 40);
    up_component(jPanel_Part, 40);
    up_component(jPanel_Dimensao, 40);
    up_component(jPanel_ParamProj, 40);
    up_component(jPanel_PTrabalho, 40);
  }
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    hs = params;
  }
  
  private void initialize() {
    setSize(680, 1500);
    setContentPane(getJContentPane());
    setResizable(false);
    setBorder(null);
    getContentPane().setLayout(null);
    setDebugGraphicsOptions(0);
    setMaximumSize(new Dimension(Integer.MAX_VALUE, Integer.MAX_VALUE));
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
      jContentPane.setAutoscrolls(true);
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_Socios(), null);
      jContentPane.add(getJPanel_Part(), null);
      jContentPane.add(getJPanel_Dimensao(), null);
      
      jContentPane.add(getJPanel_PTrabalho(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_Socios() {
    if (jPanel_Socios == null) {
      jButton_SociosAdd = new JButton(fmeComum.novaLinha);
      jButton_SociosAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_SociosAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_SociosAdd.setToolTipText("Nova Linha");
      jButton_SociosAdd.addMouseListener(new Frame_IdProm_3_jButton_SociosAdd_mouseAdapter(this));
      jButton_SociosIns = new JButton(fmeComum.inserirLinha);
      jButton_SociosIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_SociosIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_SociosIns.setToolTipText("Inserir Linha");
      jButton_SociosIns.addMouseListener(new Frame_IdProm_3_jButton_SociosIns_mouseAdapter(this));
      jButton_SociosDel = new JButton(fmeComum.apagarLinha);
      jButton_SociosDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_SociosDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_SociosDel.setToolTipText("Apagar Linha");
      jButton_SociosDel.addMouseListener(new Frame_IdProm_3_jButton_SociosDel_mouseAdapter(this));
      
      jLabel_Socios = new JLabel();
      jLabel_Socios.setBounds(new Rectangle(12, 10, 256, 18));
      jLabel_Socios.setText("Participantes no Capital do Beneficiário");
      jLabel_Socios.setFont(fmeComum.letra_bold);
      jPanel_Socios = new JPanel();
      jPanel_Socios.setLayout(null);
      jPanel_Socios.setOpaque(false);
      jPanel_Socios.setBounds(new Rectangle(15, this.y = 50, fmeApp.width - 60, this.h = '¹'));
      jPanel_Socios.setBorder(fmeComum.blocoBorder);
      jPanel_Socios.add(jLabel_Socios, null);
      jPanel_Socios.add(jButton_SociosAdd, null);
      jPanel_Socios.add(jButton_SociosDel, null);
      jPanel_Socios.add(jButton_SociosIns, null);
      jPanel_Socios.add(getJScrollPane_Socios(), null);
    }
    return jPanel_Socios;
  }
  
  public JScrollPane getJScrollPane_Socios() { if (jScrollPane_Socios == null) {
      jScrollPane_Socios = new JScrollPane();
      jScrollPane_Socios.setBounds(new Rectangle(14, 36, fmeApp.width - 90, 134));
      jScrollPane_Socios.setViewportView(getJTable_Socios());
      
      jScrollPane_Socios.setVerticalScrollBarPolicy(22);
    }
    
    return jScrollPane_Socios;
  }
  
  public JTable getJTable_Socios() { if (jTable_Socios == null) {
      jTable_Socios = new JTable_Tip(40, jScrollPane_Socios.getWidth());
      jTable_Socios.setRowHeight(18);
      jTable_Socios.setFont(fmeComum.letra);
      jTable_Socios.setAutoResizeMode(0);
      jTable_Socios.setSelectionMode(0);
      jTable_Socios.addExcelButton(jPanel_Socios, 627, 10, 14);
    }
    
    return jTable_Socios;
  }
  
  private JPanel getJPanel_Part() {
    if (jPanel_Part == null) {
      jButton_PartAdd = new JButton(fmeComum.novaLinha);
      jButton_PartAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_PartAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_PartAdd.setToolTipText("Nova Linha");
      jButton_PartAdd.addMouseListener(new Frame_IdProm_3_jButton_PartAdd_mouseAdapter(this));
      jButton_PartIns = new JButton(fmeComum.inserirLinha);
      jButton_PartIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_PartIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_PartIns.setToolTipText("Inserir Linha");
      jButton_PartIns.addMouseListener(new Frame_IdProm_3_jButton_PartIns_mouseAdapter(this));
      jButton_PartDel = new JButton(fmeComum.apagarLinha);
      jButton_PartDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_PartDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_PartDel.setToolTipText("Apagar Linha");
      jButton_PartDel.addMouseListener(new Frame_IdProm_3_jButton_PartDel_mouseAdapter(this));
      
      jLabel_Part = new JLabel();
      jLabel_Part.setBounds(new Rectangle(12, 10, fmeApp.width - 90, 18));
      jLabel_Part.setText("Participações do Beneficiário no Capital de Outras Entidades");
      jLabel_Part.setFont(fmeComum.letra_bold);
      jPanel_Part = new JPanel();
      jPanel_Part.setLayout(null);
      jPanel_Part.setOpaque(false);
      jPanel_Part.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = '¹'));
      jPanel_Part.setBorder(fmeComum.blocoBorder);
      jPanel_Part.add(jLabel_Part, null);
      jPanel_Part.add(jButton_PartAdd, null);
      jPanel_Part.add(jButton_PartDel, null);
      jPanel_Part.add(jButton_PartIns, null);
      jPanel_Part.add(getJScrollPane_Part(), null);
    }
    return jPanel_Part;
  }
  
  public JScrollPane getJScrollPane_Part() { if (jScrollPane_Part == null) {
      jScrollPane_Part = new JScrollPane();
      jScrollPane_Part.setBounds(new Rectangle(14, 36, fmeApp.width - 90, 134));
      jScrollPane_Part.setViewportView(getJTable_Part());
      
      jScrollPane_Part.setVerticalScrollBarPolicy(22);
    }
    
    return jScrollPane_Part;
  }
  
  public JTable getJTable_Part() { if (jTable_Part == null) {
      jTable_Part = new JTable_Tip(40, jScrollPane_Part.getWidth());
      jTable_Part.setRowHeight(18);
      jTable_Part.setFont(fmeComum.letra);
      jTable_Part.setAutoResizeMode(0);
      jTable_Part.setSelectionMode(0);
      jTable_Part.addExcelButton(jPanel_Part, 627, 10, 14);
    }
    
    return jTable_Part;
  }
  
  private JPanel getJPanel_Dimensao() {
    if (jPanel_Dimensao == null) {
      jLabel_Dimensao_ = new JLabel();
      jLabel_Dimensao_.setBounds(new Rectangle(36, 46, 63, 16));
      jLabel_Dimensao_.setText("Dimensão");
      jLabel_Dimensao_.setFont(fmeComum.letra);
      jLabel_Dimensao = new JLabel();
      jLabel_Dimensao.setBounds(new Rectangle(22, 38, 353, 51));
      jLabel_Dimensao.setText("");
      jLabel_Dimensao.setBorder(fmeComum.fieldBorder);
      
      GridBagConstraints gridBagConstraints3 = new GridBagConstraints();
      gridx = 0;
      gridy = 0;
      jLabel_Dimensao_1 = new JLabel();
      jLabel_Dimensao_1.setText("Escalão dimensional da empresa");
      jLabel_Dimensao_1.setBounds(new Rectangle(12, 10, 363, 18));
      jLabel_Dimensao_1.setFont(fmeComum.letra_bold);
      
      jPanel_Dimensao = new JPanel();
      jPanel_Dimensao.setLayout(null);
      jPanel_Dimensao.setOpaque(false);
      jPanel_Dimensao.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 105));
      jPanel_Dimensao.setBorder(fmeComum.blocoBorder);
      
      jPanel_Dimensao.add(jLabel_Dimensao_1, null);
      jPanel_Dimensao.add(jLabel_Dimensao, null);
      jPanel_Dimensao.add(jLabel_Dimensao_, null);
      jPanel_Dimensao.add(getJCheckBox_Micro(), null);
      jPanel_Dimensao.add(getJCheckBox_Pequena(), null);
      jPanel_Dimensao.add(getJCheckBox_Media(), null);
      jPanel_Dimensao.add(getJCheckBox_NaoPME(), null);
      getJButtonGroup_Dimensao();
    }
    return jPanel_Dimensao;
  }
  
  public JCheckBox getJCheckBox_Micro() {
    if (jCheckBox_Micro == null) {
      jCheckBox_Micro = new JCheckBox();
      jCheckBox_Micro.setOpaque(false);
      jCheckBox_Micro.setBounds(new Rectangle(121, 44, 119, 21));
      jCheckBox_Micro.setText("Micro empresa");
      jCheckBox_Micro.setFont(fmeComum.letra);
      jCheckBox_Micro.setEnabled(false);
      jCheckBox_Micro.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { CBData.Dimensao.getByName("dimensao").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jCheckBox_Micro;
  }
  
  public JCheckBox getJCheckBox_Pequena() {
    if (jCheckBox_Pequena == null) {
      jCheckBox_Pequena = new JCheckBox();
      jCheckBox_Pequena.setOpaque(false);
      jCheckBox_Pequena.setBounds(new Rectangle(121, 63, 124, 21));
      jCheckBox_Pequena.setText("Pequena empresa");
      jCheckBox_Pequena.setFont(fmeComum.letra);
      jCheckBox_Pequena.setEnabled(false);
      jCheckBox_Pequena.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { CBData.Dimensao.getByName("dimensao").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jCheckBox_Pequena;
  }
  
  public JCheckBox getJCheckBox_Media() {
    if (jCheckBox_Media == null) {
      jCheckBox_Media = new JCheckBox();
      jCheckBox_Media.setOpaque(false);
      jCheckBox_Media.setBounds(new Rectangle(266, 44, 103, 21));
      jCheckBox_Media.setText("Média empresa");
      jCheckBox_Media.setFont(fmeComum.letra);
      jCheckBox_Media.setEnabled(false);
      jCheckBox_Media.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { CBData.Dimensao.getByName("dimensao").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jCheckBox_Media;
  }
  
  public JCheckBox getJCheckBox_NaoPME() {
    if (jCheckBox_NaoPME == null) {
      jCheckBox_NaoPME = new JCheckBox();
      jCheckBox_NaoPME.setOpaque(false);
      jCheckBox_NaoPME.setBounds(new Rectangle(266, 63, 89, 21));
      jCheckBox_NaoPME.setText("Não PME");
      jCheckBox_NaoPME.setFont(fmeComum.letra);
      jCheckBox_NaoPME.setEnabled(false);
      jCheckBox_NaoPME.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { CBData.Dimensao.getByName("dimensao").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jCheckBox_NaoPME;
  }
  
  private ButtonGroup getJButtonGroup_Dimensao() {
    if (jButtonGroup_Dimensao == null) {
      jButtonGroup_Dimensao = new ButtonGroup();
      jButtonGroup_Dimensao.add(jCheckBox_Micro);
      jButtonGroup_Dimensao.add(jCheckBox_Pequena);
      jButtonGroup_Dimensao.add(jCheckBox_Media);
      jButtonGroup_Dimensao.add(jCheckBox_NaoPME);
      jButtonGroup_Dimensao.add(jCheckBox_DimensaoClear);
    }
    return jButtonGroup_Dimensao;
  }
  
  private JPanel getJPanel_ParamProj() { if (jPanel_ParamProj == null) {
      jLabel_param_1 = new JLabel();
      jLabel_param_1.setBounds(new Rectangle(16, 34, 545, 21));
      jLabel_param_1.setText("Possui ou pertence a um grupo empresarial com faturação anual consolidada superior a 75 milhões de Euros?");
      jLabel_param_1.setFont(fmeComum.letra);
      
      jLabel_param_2 = new JLabel();
      jLabel_param_2.setBounds(new Rectangle(16, 59, 545, 21));
      jLabel_param_2.setText("O presente projeto de investimento apresentou ou pretende apresentar candidatura a beneficios fiscais?");
      jLabel_param_2.setFont(fmeComum.letra);
      
      jLabel_Sim = new JLabel();
      jLabel_Sim.setBounds(new Rectangle(550, 14, 40, 19));
      jLabel_Sim.setText("Sim");
      jLabel_Sim.setFont(fmeComum.letra);
      jLabel_Sim.setHorizontalAlignment(0);
      
      jLabel_Nao = new JLabel();
      jLabel_Nao.setBounds(new Rectangle(590, 14, 40, 19));
      jLabel_Nao.setText("Não");
      jLabel_Nao.setFont(fmeComum.letra);
      jLabel_Nao.setHorizontalAlignment(0);
      
      jLabel_ParamProj = new JLabel();
      jLabel_ParamProj.setText("Outros dados de caracterização");
      jLabel_ParamProj.setBounds(new Rectangle(12, 6, 304, 18));
      jLabel_ParamProj.setFont(fmeComum.letra_bold);
      
      jPanel_ParamProj = new JPanel();
      jPanel_ParamProj.setLayout(null);
      jPanel_ParamProj.setOpaque(false);
      jPanel_ParamProj.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 95));
      jPanel_ParamProj.setBorder(fmeComum.blocoBorder);
      jPanel_ParamProj.add(jLabel_ParamProj);
      jPanel_ParamProj.add(jLabel_Sim);
      jPanel_ParamProj.add(jLabel_Nao);
      jPanel_ParamProj.add(jLabel_param_1);
      jPanel_ParamProj.add(getJCheckBox_Sim_1(), null);
      jPanel_ParamProj.add(getJCheckBox_Nao_1(), null);
      getJButtonGroup_1();
      jPanel_ParamProj.add(jLabel_param_2);
      jPanel_ParamProj.add(getJCheckBox_Sim_2(), null);
      jPanel_ParamProj.add(getJCheckBox_Nao_2(), null);
      getJButtonGroup_2();
    }
    return jPanel_ParamProj;
  }
  
  public JCheckBox getJCheckBox_Sim_1() {
    if (jCheckBox_Sim_1 == null) {
      jCheckBox_Sim_1 = new JCheckBox();
      jCheckBox_Sim_1.setOpaque(false);
      jCheckBox_Sim_1.setBounds(new Rectangle(550, 34, 38, 21));
      jCheckBox_Sim_1.setText("");
      jCheckBox_Sim_1.setFont(fmeComum.letra);
      jCheckBox_Sim_1.setHorizontalAlignment(0);
    }
    return jCheckBox_Sim_1;
  }
  
  public JCheckBox getJCheckBox_Nao_1() {
    if (jCheckBox_Nao_1 == null) {
      jCheckBox_Nao_1 = new JCheckBox();
      jCheckBox_Nao_1.setOpaque(false);
      jCheckBox_Nao_1.setBounds(new Rectangle(590, 34, 38, 21));
      jCheckBox_Nao_1.setText("");
      jCheckBox_Nao_1.setFont(fmeComum.letra);
      jCheckBox_Nao_1.setHorizontalAlignment(0);
    }
    return jCheckBox_Nao_1;
  }
  
  private ButtonGroup getJButtonGroup_1() { if (jButtonGroup_1 == null) {
      jButtonGroup_1 = new ButtonGroup();
      jButtonGroup_1.add(jCheckBox_Sim_1);
      jButtonGroup_1.add(jCheckBox_Nao_1);
      jButtonGroup_1.add(jCheckBox_1Clear);
    }
    return jButtonGroup_1;
  }
  
  public JCheckBox getJCheckBox_Sim_2() {
    if (jCheckBox_Sim_2 == null) {
      jCheckBox_Sim_2 = new JCheckBox();
      jCheckBox_Sim_2.setOpaque(false);
      jCheckBox_Sim_2.setBounds(new Rectangle(550, 59, 38, 21));
      jCheckBox_Sim_2.setText("");
      jCheckBox_Sim_2.setFont(fmeComum.letra);
      jCheckBox_Sim_2.setHorizontalAlignment(0);
    }
    return jCheckBox_Sim_2;
  }
  
  public JCheckBox getJCheckBox_Nao_2() {
    if (jCheckBox_Nao_2 == null) {
      jCheckBox_Nao_2 = new JCheckBox();
      jCheckBox_Nao_2.setOpaque(false);
      jCheckBox_Nao_2.setBounds(new Rectangle(590, 59, 38, 21));
      jCheckBox_Nao_2.setText("");
      jCheckBox_Nao_2.setFont(fmeComum.letra);
      jCheckBox_Nao_2.setHorizontalAlignment(0);
    }
    return jCheckBox_Nao_2;
  }
  
  private ButtonGroup getJButtonGroup_2() { if (jButtonGroup_2 == null) {
      jButtonGroup_2 = new ButtonGroup();
      jButtonGroup_2.add(jCheckBox_Sim_2);
      jButtonGroup_2.add(jCheckBox_Nao_2);
      jButtonGroup_2.add(jCheckBox_2Clear);
    }
    return jButtonGroup_2;
  }
  
  private JPanel getJPanel_PTrabalho()
  {
    if (jPanel_PTrabalho == null) {
      jButton_PTrabalhoCopy = new JButton(fmeComum.copiarLinha);
      jButton_PTrabalhoCopy.setBorder(BorderFactory.createEtchedBorder());
      jButton_PTrabalhoCopy.addMouseListener(new Frame_IdProm_3_jButton_PTrabalhoCopy_mouseAdapter(this));
      jButton_PTrabalhoCopy.setToolTipText("Copiar Linha");
      jButton_PTrabalhoCopy.setBounds(new Rectangle(587, 11, 30, 22));
      jButton_PTrabalhoUp = new JButton(fmeComum.subirLinha);
      jButton_PTrabalhoUp.setBorder(BorderFactory.createEtchedBorder());
      jButton_PTrabalhoUp.addMouseListener(new Frame_IdProm_3_jButton_PTrabalhoUp_mouseAdapter(this));
      jButton_PTrabalhoUp.setToolTipText("Trocar Linhas");
      jButton_PTrabalhoUp.setBounds(new Rectangle(627, 11, 30, 22));
      jButton_PTrabalhoAdd = new JButton(fmeComum.novaLinha);
      jButton_PTrabalhoAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_PTrabalhoAdd.addMouseListener(new Frame_IdProm_3_jButton_PTrabalhoAdd_mouseAdapter(this));
      jButton_PTrabalhoAdd.setToolTipText("Nova Linha");
      jButton_PTrabalhoAdd.setBounds(new Rectangle(667, 11, 30, 22));
      jButton_PTrabalhoIns = new JButton(fmeComum.inserirLinha);
      jButton_PTrabalhoIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_PTrabalhoIns.addMouseListener(new Frame_IdProm_3_jButton_PTrabalhoIns_mouseAdapter(this));
      jButton_PTrabalhoIns.setToolTipText("Inserir Linha");
      jButton_PTrabalhoIns.setBounds(new Rectangle(707, 11, 30, 22));
      jButton_PTrabalhoDel = new JButton(fmeComum.apagarLinha);
      jButton_PTrabalhoDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_PTrabalhoDel.addMouseListener(new Frame_IdProm_3_jButton_PTrabalhoDel_mouseAdapter(this));
      jButton_PTrabalhoDel.setToolTipText("Apagar Linha");
      jButton_PTrabalhoDel.setBounds(new Rectangle(747, 11, 30, 22));
      jLabel_PTrabalho = new JLabel();
      jLabel_PTrabalho.setBounds(new Rectangle(12, 10, 280, 18));
      jLabel_PTrabalho.setText("<html>Postos de Trabalho do Beneficiário</html>");
      jLabel_PTrabalho.setFont(fmeComum.letra_bold);
      jPanel_PTrabalho = new JPanel();
      jPanel_PTrabalho.setName("PTrabalho_Quadro");
      jPanel_PTrabalho.setLayout(null);
      jPanel_PTrabalho.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'Ş'));
      jPanel_PTrabalho.setBorder(fmeComum.blocoBorder);
      jPanel_PTrabalho.add(jLabel_PTrabalho, null);
      jPanel_PTrabalho.add(jButton_PTrabalhoCopy, null);
      jPanel_PTrabalho.add(jButton_PTrabalhoUp, null);
      jPanel_PTrabalho.add(jButton_PTrabalhoAdd, null);
      jPanel_PTrabalho.add(jButton_PTrabalhoIns, null);
      jPanel_PTrabalho.add(jButton_PTrabalhoDel, null);
      jPanel_PTrabalho.add(getJScrollPane_PTrabalho(), null);
    }
    return jPanel_PTrabalho;
  }
  
  public JScrollPane getJScrollPane_PTrabalho() {
    if (jScrollPane_PTrabalho == null) {
      jScrollPane_PTrabalho = new JScrollPane();
      jScrollPane_PTrabalho.setName("PTrabalho_ScrollPane");
      jScrollPane_PTrabalho.setBounds(new Rectangle(16, 36, fmeApp.width - 90, 300));
      jScrollPane_PTrabalho.setViewportView(getJTable_PTrabalho());
      jScrollPane_PTrabalho.setVerticalScrollBarPolicy(22);
      jScrollPane_PTrabalho.setHorizontalScrollBarPolicy(31);
    }
    return jScrollPane_PTrabalho;
  }
  
  public JTable getJTable_PTrabalho() {
    if (jTable_PTrabalho == null)
    {
      jTable_PTrabalho = new JTable_Tip(40, jScrollPane_PTrabalho.getWidth());
      jTable_PTrabalho.addExcelButton(jPanel_PTrabalho, 547, 11, 14);
      jTable_PTrabalho.setFont(fmeComum.letra);
      jTable_PTrabalho.setName("PTrabalho_Tabela");
      jTable_PTrabalho.setRowHeight(18);
      jTable_PTrabalho.setAutoResizeMode(0);
      jTable_PTrabalho.setSelectionMode(0);
    }
    return jTable_PTrabalho;
  }
  
  void jButton_PTrabalhoCopy_mouseClicked(MouseEvent e)
  {
    cbd_ptrabalho.on_copy_row();
  }
  
  void jButton_PTrabalhoUp_mouseClicked(MouseEvent e) {
    cbd_ptrabalho.on_up_row();
  }
  
  void jButton_PTrabalhoAdd_mouseClicked(MouseEvent e) {
    cbd_ptrabalho.on_add_row();
  }
  
  void jButton_PTrabalhoDel_mouseClicked(MouseEvent e) {
    cbd_ptrabalho.on_del_row();
  }
  
  void jButton_PTrabalhoIns_mouseClicked(MouseEvent e) {
    cbd_ptrabalho.on_ins_row();
  }
  
  public CBTabela_Socios cbd_socios;
  public CBTabela_Part cbd_part;
  public void print_page() {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    


    print_handler.dx_expand = (jTable_Socios.getWidth() - jScrollPane_Socios.getWidth());
    int w = jPanel_Socios.getWidth() + print_handler.dx_expand;
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
  
  public void clear_page() {
    CBData.Socios.Clear();
    CBData.Part.Clear();
    

    CBData.PTrabalho.Clear();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.Socios.validar(null, ""));
    grp.add_grp(CBData.Part.validar(null));
    grp.add_grp(CBData.Dimensao.validar(null, ""));
    
    grp.add_grp(CBData.PTrabalho.validar(null, ""));
    return grp;
  }
  
  void jButton_SociosAdd_mouseClicked(MouseEvent e)
  {
    cbd_socios.on_add_row();
  }
  
  void jButton_SociosDel_mouseClicked(MouseEvent e) {
    cbd_socios.on_del_row();
  }
  
  void jButton_SociosIns_mouseClicked(MouseEvent e) {
    cbd_socios.on_ins_row();
  }
  
  void jButton_PartAdd_mouseClicked(MouseEvent e)
  {
    cbd_part.on_add_row();
  }
  
  void jButton_PartDel_mouseClicked(MouseEvent e) {
    cbd_part.on_del_row();
  }
  
  void jButton_PartIns_mouseClicked(MouseEvent e) {
    cbd_part.on_ins_row();
  }
}
