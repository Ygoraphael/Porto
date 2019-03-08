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
import javax.swing.ButtonGroup;
import javax.swing.JCheckBox;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;







public class Frame_Decl
  extends JInternalFrame
  implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  private JPanel jPanel_Declaracoes = null;
  private JPanel jPanel_Obs = null;
  private JLabel jLabel_Obs = null;
  private JScrollPane jScrollPane_Obs = null;
  private JTextArea jTextArea_Obs = null;
  public JLabel jLabel_Count = null;
  
  private JLabel jLabel_Sim = null;
  private JLabel jLabel_Nao = null;
  private JLabel jLabel_NaoAplic = null;
  private JLabel jLabel_Sim_l = null;
  private JLabel jLabel_Sim_l2 = null;
  private JLabel jLabel_Nao_l = null;
  private JLabel jLabel_NaoAplic_l = null;
  
  private JLabel jLabel_Geral = null;
  private JLabel jLabel_Geral_1 = null;
  private JLabel jLabel_Geral_1_l = null;
  private JLabel jLabel_Geral_2 = null;
  private JLabel jLabel_Geral_2_l = null;
  public JCheckBox jCheckBox_Geral_1_Sim = null;
  public JCheckBox jCheckBox_Geral_1_Nao = null;
  public JCheckBox jCheckBox_Geral_1_Clear = new JCheckBox();
  private ButtonGroup jButtonGroup_Geral_1 = null;
  public JCheckBox jCheckBox_Geral_2_Sim = null;
  public JCheckBox jCheckBox_Geral_2_Clear = new JCheckBox();
  
  private JLabel jLabel_ElegProm = null;
  private JLabel jLabel_ElegProm_1 = null;
  private JLabel jLabel_ElegProm_2 = null;
  private JLabel jLabel_ElegProm_3 = null;
  private JLabel jLabel_ElegProm_4 = null;
  private JLabel jLabel_ElegProm_5 = null;
  private JLabel jLabel_ElegProm_6 = null;
  private JLabel jLabel_ElegProm_7 = null;
  private JLabel jLabel_ElegProm_8 = null;
  private JLabel jLabel_ElegProm_9 = null;
  private JLabel jLabel_ElegProm_1_l = null;
  private JLabel jLabel_ElegProm_2_l = null;
  private JLabel jLabel_ElegProm_3_l = null;
  private JLabel jLabel_ElegProm_4_l = null;
  private JLabel jLabel_ElegProm_5_l = null;
  private JLabel jLabel_ElegProm_6_l = null;
  private JLabel jLabel_ElegProm_7_l = null;
  private JLabel jLabel_ElegProm_8_l = null;
  private JLabel jLabel_ElegProm_9_l = null;
  public JCheckBox jCheckBox_ElegProm_1_Sim = null;
  public JCheckBox jCheckBox_ElegProm_1_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProm_2_Sim = null;
  public JCheckBox jCheckBox_ElegProm_2_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProm_3_Sim = null;
  public JCheckBox jCheckBox_ElegProm_3_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProm_4_Sim = null;
  public JCheckBox jCheckBox_ElegProm_4_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProm_5_Sim = null;
  public JCheckBox jCheckBox_ElegProm_5_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProm_6_Sim = null;
  public JCheckBox jCheckBox_ElegProm_6_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProm_7_Sim = null;
  public JCheckBox jCheckBox_ElegProm_7_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProm_8_Sim = null;
  public JCheckBox jCheckBox_ElegProm_8_NaoAplic = null;
  public JCheckBox jCheckBox_ElegProm_8_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProm_9_Sim = null;
  public JCheckBox jCheckBox_ElegProm_9_NaoAplic = null;
  public JCheckBox jCheckBox_ElegProm_9_Clear = new JCheckBox();
  
  private JLabel jLabel_ElegProj = null;
  private JLabel jLabel_ElegProj_1 = null;
  private JLabel jLabel_ElegProj_2 = null;
  private JLabel jLabel_ElegProj_3 = null;
  private JLabel jLabel_ElegProj_4 = null;
  private JLabel jLabel_ElegProj_5 = null;
  private JLabel jLabel_ElegProj_1_l = null;
  private JLabel jLabel_ElegProj_2_l = null;
  private JLabel jLabel_ElegProj_3_l = null;
  private JLabel jLabel_ElegProj_4_l = null;
  private JLabel jLabel_ElegProj_5_l = null;
  public JCheckBox jCheckBox_ElegProj_1_Sim = null;
  public JCheckBox jCheckBox_ElegProj_1_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProj_2_Sim = null;
  public JCheckBox jCheckBox_ElegProj_2_NaoAplic = null;
  public JCheckBox jCheckBox_ElegProj_2_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProj_3_Sim = null;
  public JCheckBox jCheckBox_ElegProj_3_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProj_4_Sim = null;
  public JCheckBox jCheckBox_ElegProj_4_NaoAplic = null;
  public JCheckBox jCheckBox_ElegProj_4_Clear = new JCheckBox();
  public JCheckBox jCheckBox_ElegProj_5_Sim = null;
  public JCheckBox jCheckBox_ElegProj_5_Clear = new JCheckBox();
  
  private JLabel jLabel_Obrig = null;
  private JLabel jLabel_Obrig_1 = null;
  private JLabel jLabel_Obrig_2 = null;
  private JLabel jLabel_Obrig_3 = null;
  private JLabel jLabel_Obrig_1_l = null;
  private JLabel jLabel_Obrig_2_l = null;
  private JLabel jLabel_Obrig_3_l = null;
  public JCheckBox jCheckBox_Obrig_1_Sim = null;
  public JCheckBox jCheckBox_Obrig_1_Clear = new JCheckBox();
  public JCheckBox jCheckBox_Obrig_2_Sim = null;
  public JCheckBox jCheckBox_Obrig_2_NaoAplic = null;
  public JCheckBox jCheckBox_Obrig_2_Clear = new JCheckBox();
  public JCheckBox jCheckBox_Obrig_3_Sim = null;
  public JCheckBox jCheckBox_Obrig_3_NaoAplic = null;
  public JCheckBox jCheckBox_Obrig_3_Clear = new JCheckBox();
  
  private JLabel jLabel_Nota = null;
  


























  String tag = "";
  
  int h = 0;
  int y = 0;
  
  boolean obrig_3 = true;
  private HashMap _params;
  
  public Frame_Decl() {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(fmeApp.width - 35, h);
  }
  

  void up_component(Component c, int n)
  {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    _params = params;
  }
  
  public HashMap get_params()
  {
    return _params;
  }
  
  private void initialize() {
    setSize(fmeApp.width - 35, 1500);
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
      jLabel_Titulo = new LabelTitulo("DECLARAÇÕES DE COMPROMISSO");
      
      jContentPane = new JPanel();
      
      jContentPane.setOpaque(false);
      jContentPane.setLayout(null);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_Declaracoes(), null);
      jContentPane.add(getJPanel_Obs(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_Declaracoes() {
    if (jPanel_Declaracoes == null)
    {
      jPanel_Declaracoes = new JPanel();
      jPanel_Declaracoes.setOpaque(false);
      jPanel_Declaracoes.setLayout(null);
      jPanel_Declaracoes.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 785));
      jPanel_Declaracoes.setBorder(fmeComum.blocoBorder);
      



      int h = 1;
      y = 15;
      

      jLabel_Geral = getJLabel_Titulo(this.y += h - 1, h = 17, "1. Geral");
      jPanel_Declaracoes.add(jLabel_Geral, null);
      
      jLabel_Geral_1 = getJLabel_Decl(this.y += h + 10, h = 30, "<html>Declaro que autorizo a utilização dos dados constantes desta candidatura para outros sistemas no âmbito do PT 2020, salvaguardando o sigilo para o exterior.</html>");
      jLabel_Geral_1_l = getJLabel_Linha(this.y += h);
      jCheckBox_Geral_1_Sim = getJCheckBox_Sim(y - 20);
      jCheckBox_Geral_1_Nao = getJCheckBox_Nao(y - 20);
      jPanel_Declaracoes.add(jLabel_Geral_1, null);
      jPanel_Declaracoes.add(jLabel_Geral_1_l, null);
      jPanel_Declaracoes.add(jCheckBox_Geral_1_Sim, null);
      jPanel_Declaracoes.add(jCheckBox_Geral_1_Nao, null);
      getJButtonGroup(jCheckBox_Geral_1_Sim, jCheckBox_Geral_1_Nao, jCheckBox_Geral_1_Clear);
      
      jLabel_Geral_2 = getJLabel_Decl(this.y += 15, h = 30, "<html>Declaro que todas as informações constantes neste formulário são verdadeiras, incluindo a veracidade dos pressupostos utilizados na definição do projeto de investimento apresentado.</html>");
      jLabel_Geral_2_l = getJLabel_Linha(this.y += h);
      jCheckBox_Geral_2_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_Geral_2, null);
      jPanel_Declaracoes.add(jLabel_Geral_2_l, null);
      jPanel_Declaracoes.add(jCheckBox_Geral_2_Sim, null);
      


      jLabel_ElegProm = getJLabel_Titulo(this.y += 20, h = 17, "2. Critérios de elegibilidade dos beneficiários");
      jPanel_Declaracoes.add(jLabel_ElegProm, null);
      
      jLabel_ElegProm_1 = getJLabel_Decl(this.y += h + 10, h = 44, "<html>Declaro, e comprometo-me a apresentar a documentação que me for solicitada para efeitos de comprovação, que a empresa está em condições legais para desenvolver as atividades no território abrangido pelo PO e pela tipologia das operações e investimentos a que me candidato – alínea c) do artigo 13º do DL nº 159/2014 de 27 de outubro.</html>");
      jLabel_ElegProm_1_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProm_1_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProm_1, null);
      jPanel_Declaracoes.add(jLabel_ElegProm_1_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_1_Sim, null);
      
      jLabel_ElegProm_2 = getJLabel_Decl(this.y += 15, h = 55, "<html>Para efeitos do cumprimento do disposto alínea i) do artigo 13º do DL nº 159/2014, de 27 de outubro, declara-se que a entidade beneficária deste projeto não detém nem deteve capital numa percentagem superior a 50%, direta ou indiretamente, em empresa que não tenha cumprido notificação para devolução de apoios no âmbito de uma operação apoiada por fundos europeus.</html>");
      jLabel_ElegProm_2_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProm_2_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProm_2, null);
      jPanel_Declaracoes.add(jLabel_ElegProm_2_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_2_Sim, null);
      
      jLabel_ElegProm_3 = getJLabel_Decl(this.y += 15, h = 30, "<html>Declaro que a empresa dispõe de contabilidade organizada nos termos da legislação aplicável (alínea a) do nº 1 do artigo 5º da Portaria nº 57-A/2015, de 27 de fevereiro – RECI).</html>");
      jLabel_ElegProm_3_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProm_3_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProm_3, null);
      jPanel_Declaracoes.add(jLabel_ElegProm_3_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_3_Sim, null);
      
      jLabel_ElegProm_4 = getJLabel_Decl(this.y += 15, h = 30, "<html>Declaro que não sou uma empresa sujeita a uma injunção de recuperação, ainda pendente, na sequência de uma decisão anterior da Comissão que declara um auxílio ilegal e incompatível com o mercado interno (alínea c) do nº 1 do artigo 5º do RECI).</html>");
      jLabel_ElegProm_4_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProm_4_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProm_4, null);
      jPanel_Declaracoes.add(jLabel_ElegProm_4_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_4_Sim, null);
      
      jLabel_ElegProm_5 = getJLabel_Decl(this.y += 15, h = 18, "<html>Declaro que a empresa não tem salários em atraso (alínea d) do nº 1 do artigo 5º do RECI).</html>");
      jLabel_ElegProm_5_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProm_5_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProm_5, null);
      jPanel_Declaracoes.add(jLabel_ElegProm_5_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_5_Sim, null);
      
      jLabel_ElegProm_6 = getJLabel_Decl(this.y += 15, h = 44, "<html>Declaro que, a empresa reúne as condições quanto ao cumprimento do critério de elegibilidade previsto na alínea b) do artigo 13º do DL nº 159/2014, de 27 de outubro relativo à situação tributária e contributiva regularizada perante, respetivamente, a administração fiscal e a segurança social.</html>");
      jLabel_ElegProm_6_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProm_6_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProm_6, null);
      jPanel_Declaracoes.add(jLabel_ElegProm_6_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_6_Sim, null);
      
      jLabel_ElegProm_7 = getJLabel_Decl(this.y += 15, h = 44, "<html>Tomei conhecimento e declaro cumprir ou estar em condições de cumprir nos prazos fixados os critérios de elegibilidade do beneficiário de acordo com o artigo 13º do DL nº 159/2014, de 27 de outubro, com o RECI e presente Aviso, sob pena de operar a caducidade e consequente anulação da candidatura.</html>");
      jLabel_ElegProm_7_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProm_7_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProm_7, null);
      jPanel_Declaracoes.add(jLabel_ElegProm_7_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_7_Sim, null);
      
      jLabel_ElegProm_8 = getJLabel_Decl(this.y += 15, h = 30, "<html>Declaro que, para aferir o rácio de autonomia financeira, conforme previsto no n.º 4 do Anexo C do RECI, caso seja aplicável à presente candidatura, apresento um balanço intercalar certificado por um ROC, não sendo admitido exame simplificado.</html>");
      jLabel_ElegProm_8_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProm_8_Sim = getJCheckBox_Sim(y - 20);
      




      jCheckBox_ElegProm_8_NaoAplic = getJCheckBox_NaoAplic(y - 20);
      




      jPanel_Declaracoes.add(jLabel_ElegProm_8, null);
      jPanel_Declaracoes.add(jLabel_ElegProm_8_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_8_Sim, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_8_NaoAplic, null);
      getJButtonGroup(jCheckBox_ElegProm_8_Sim, jCheckBox_ElegProm_8_NaoAplic, jCheckBox_ElegProm_8_Clear);
      
      jLabel_ElegProm_9 = getJLabel_Decl(this.y += 15, h = 18, "<html>Apresentar o Balanço Social referente ao ano pré-projeto.</html>");
      jLabel_ElegProm_9_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProm_9_Sim = getJCheckBox_Sim(y - 20);
      jCheckBox_ElegProm_9_NaoAplic = getJCheckBox_NaoAplic(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProm_9, null);
      jPanel_Declaracoes.add(jLabel_ElegProm_9_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_9_Sim, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProm_9_NaoAplic, null);
      getJButtonGroup(jCheckBox_ElegProm_9_Sim, jCheckBox_ElegProm_9_NaoAplic, jCheckBox_ElegProm_9_Clear);
      



      jLabel_ElegProj = getJLabel_Titulo(this.y += 20, h = 17, "3. Critérios de elegibilidade dos projetos");
      jPanel_Declaracoes.add(jLabel_ElegProj, null);
      
      jLabel_ElegProj_1 = getJLabel_Decl(this.y += h + 10, h = 30, "<html>Declaro não ter dado início ao presente projeto nos termos do estabelecido na alínea a) do nº 1 do artigo 45º do RECI e do Ponto 6 do Aviso.</html>");
      jLabel_ElegProj_1_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProj_1_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProj_1, null);
      jPanel_Declaracoes.add(jLabel_ElegProj_1_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProj_1_Sim, null);
      
      jLabel_ElegProj_2 = getJLabel_Decl(this.y += 15, h = 44, "<html>Declaro que o projeto apresentado nesta candidatura não tem investimentos incluídos no âmbito dos contratos de concessão com o Estado (nº 4 do artigo 4º do RECI) e que o projeto não está inserido numa atividade económica de interesse geral (nº 1 do artigo 4º do RECI).</html>");
      jLabel_ElegProj_2_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProj_2_Sim = getJCheckBox_Sim(y - 20);
      jCheckBox_ElegProj_2_NaoAplic = getJCheckBox_NaoAplic(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProj_2, null);
      jPanel_Declaracoes.add(jLabel_ElegProj_2_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProj_2_Sim, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProj_2_NaoAplic, null);
      getJButtonGroup(jCheckBox_ElegProj_2_Sim, jCheckBox_ElegProj_2_NaoAplic, jCheckBox_ElegProj_2_Clear);
      
      jLabel_ElegProj_3 = getJLabel_Decl(this.y += 15, h = 18, "<html>Declaro que não estão incluídas neste projeto ações apoiadas no âmbito de projetos conjuntos.</html>");
      jLabel_ElegProj_3_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProj_3_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProj_3, null);
      jPanel_Declaracoes.add(jLabel_ElegProj_3_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProj_3_Sim, null);
      










      jLabel_ElegProj_5 = getJLabel_Decl(this.y += 15, h = 44, "<html>Tomei conhecimento e declaro cumprir ou estar em condições de cumprir nos prazos fixados os critérios de elegibilidade do projeto de acordo com previsto no RECI e no presente Aviso, sob pena de operar a caducidade e consequente anulação da candidatura.</html>");
      jLabel_ElegProj_5_l = getJLabel_Linha(this.y += h);
      jCheckBox_ElegProj_5_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_ElegProj_5, null);
      jPanel_Declaracoes.add(jLabel_ElegProj_5_l, null);
      jPanel_Declaracoes.add(jCheckBox_ElegProj_5_Sim, null);
      


      jLabel_Obrig = getJLabel_Titulo(this.y += 20, h = 17, "4. Obrigações dos beneficiários");
      jPanel_Declaracoes.add(jLabel_Obrig, null);
      
      jLabel_Obrig_1 = getJLabel_Decl(this.y += h + 10, h = 30, "<html>Tomei conhecimento e declaro estar em condições de cumprir com as obrigações estabelecidas no artigo 24º do DL nº 159/2014, de 27 de outubro, nos artigos 12º  e 54º do RECI e no Aviso de concurso.</html>");
      jLabel_Obrig_1_l = getJLabel_Linha(this.y += h);
      jCheckBox_Obrig_1_Sim = getJCheckBox_Sim(y - 20);
      jPanel_Declaracoes.add(jLabel_Obrig_1, null);
      jPanel_Declaracoes.add(jLabel_Obrig_1_l, null);
      jPanel_Declaracoes.add(jCheckBox_Obrig_1_Sim, null);
      
      jLabel_Obrig_2 = getJLabel_Decl(this.y += 15, h = 30, "<html>No caso de ser uma entidade adjudicante nos termos do artigo 2º do Código de Contratação Pública, declaro cumprir o regime legal de contratação pública aplicável.</html>");
      jLabel_Obrig_2_l = getJLabel_Linha(this.y += h);
      jCheckBox_Obrig_2_Sim = getJCheckBox_Sim(y - 20);
      jCheckBox_Obrig_2_NaoAplic = getJCheckBox_NaoAplic(y - 20);
      jPanel_Declaracoes.add(jLabel_Obrig_2, null);
      jPanel_Declaracoes.add(jLabel_Obrig_2_l, null);
      jPanel_Declaracoes.add(jCheckBox_Obrig_2_Sim, null);
      jPanel_Declaracoes.add(jCheckBox_Obrig_2_NaoAplic, null);
      getJButtonGroup(jCheckBox_Obrig_2_Sim, jCheckBox_Obrig_2_NaoAplic, jCheckBox_Obrig_2_Clear);
      








































































      jLabel_Sim = new JLabel();
      jLabel_Sim.setBounds(new Rectangle(666, 18, 34, 25));
      jLabel_Sim.setText("Sim");
      jLabel_Sim.setHorizontalAlignment(0);
      jLabel_Sim.setFont(fmeComum.letra);
      jLabel_Nao = new JLabel();
      jLabel_Nao.setBounds(new Rectangle(702, 18, 33, 25));
      jLabel_Nao.setText("Não");
      jLabel_Nao.setHorizontalAlignment(0);
      jLabel_Nao.setFont(fmeComum.letra);
      jLabel_NaoAplic = new JLabel();
      jLabel_NaoAplic.setBounds(new Rectangle(736, 3, 34, 40));
      jLabel_NaoAplic.setText("<html><div align='center'>Não<br>Aplic.</div></html>");
      jLabel_NaoAplic.setHorizontalAlignment(0);
      jLabel_NaoAplic.setFont(fmeComum.letra);
      
      jLabel_Sim_l = getJLabel_LinhaV(663, y);
      jLabel_Sim_l2 = getJLabel_LinhaV(699, y);
      jLabel_Nao_l = getJLabel_LinhaV(735, y);
      jLabel_NaoAplic_l = getJLabel_LinhaV(770, y);
      
      jPanel_Declaracoes.add(jLabel_Sim, null);
      jPanel_Declaracoes.add(jLabel_Nao, null);
      jPanel_Declaracoes.add(jLabel_NaoAplic, null);
      jPanel_Declaracoes.add(jLabel_Sim_l, null);
      jPanel_Declaracoes.add(jLabel_Sim_l2, null);
      jPanel_Declaracoes.add(jLabel_Nao_l, null);
      jPanel_Declaracoes.add(jLabel_NaoAplic_l, null);
      

      jLabel_Nota = new JLabel("<html><strong><u>Nota Importante</u>:</strong><br>Nos termos do previsto na alínea k) do nº 3 do artigo 23º do DL nº 159/2014, constitui fundamento para a revogação do apoio concedido a prestação de falsas declarações.</html>");
      jLabel_Nota.setBounds(new Rectangle(15, this.y += 20, fmeApp.width - 90, h = 44));
      jPanel_Declaracoes.add(jLabel_Nota, null);
      


      jPanel_Declaracoes.setBounds(new Rectangle(15, 50, fmeApp.width - 60, this.y += 20 + h));
    }
    
    return jPanel_Declaracoes;
  }
  
  private JPanel getJPanel_Obs() {
    if (jPanel_Obs == null) {
      jLabel_Obs = new JLabel();
      jLabel_Obs.setBounds(new Rectangle(14, 8, fmeApp.width - 90, 20));
      jLabel_Obs.setText("Observações");
      jLabel_Obs.setFont(fmeComum.letra_bold);
      
      jPanel_Obs = new JPanel();
      jPanel_Obs.setLayout(null);
      jPanel_Obs.setOpaque(false);
      jPanel_Obs.setBounds(new Rectangle(15, this.y += 60, fmeApp.width - 60, 200));
      jPanel_Obs.setBorder(fmeComum.blocoBorder);
      jPanel_Obs.setName("cond_eleg_texto");
      
      jLabel_Count = new JLabel("");
      jLabel_Count.setBounds(new Rectangle(jPanel_Obs.getWidth() - 200 - 15, getJjScrollPane_Obs().getY() - 15, 200, 20));
      jLabel_Count.setFont(fmeComum.letra_pequena);
      jLabel_Count.setForeground(Color.GRAY);
      jLabel_Count.setHorizontalAlignment(4);
      
      jPanel_Obs.add(jLabel_Obs, null);
      jPanel_Obs.add(jLabel_Count, null);
      jPanel_Obs.add(getJjScrollPane_Obs(), null);
      
      h = (this.y += 210);
    }
    return jPanel_Obs;
  }
  
  public JScrollPane getJjScrollPane_Obs() {
    if (jScrollPane_Obs == null) {
      jScrollPane_Obs = new JScrollPane();
      jScrollPane_Obs.setBounds(new Rectangle(15, 35, fmeApp.width - 90, 150));
      jScrollPane_Obs.setPreferredSize(new Dimension(250, 250));
      jScrollPane_Obs.setVerticalScrollBarPolicy(22);
      
      jScrollPane_Obs.setViewportView(getJTextArea_Obs());
    }
    return jScrollPane_Obs;
  }
  
  public JTextArea getJTextArea_Obs() { if (jTextArea_Obs == null) {
      jTextArea_Obs = new JTextArea();
      jTextArea_Obs.setFont(fmeComum.letra);
      jTextArea_Obs.setLineWrap(true);
      jTextArea_Obs.setWrapStyleWord(true);
      jTextArea_Obs.setMargin(new Insets(5, 5, 5, 5));
      jTextArea_Obs.addKeyListener(new KeyListener() {
        public void keyTyped(KeyEvent arg0) {}
        
        public void keyReleased(KeyEvent arg0) {
          CBData.Decl.on_update("observacoes");
        }
        
        public void keyPressed(KeyEvent arg0) {}
      });
    }
    return jTextArea_Obs;
  }
  
  public JLabel getJLabel_Titulo(int y, int h, String titulo) {
    JLabel label = new JLabel(titulo);
    
    label.setBounds(new Rectangle(13, y, 497, h));
    label.setFont(fmeComum.letra_bold);
    return label;
  }
  
  public JLabel getJLabel_Decl(int y, int h, String texto) {
    JLabel label = new JLabel(texto);
    label.setBounds(new Rectangle(30, y, 620, h));
    return label;
  }
  
  public JLabel getJLabel_Linha(int y) {
    JLabel label = new JLabel();
    label.setBounds(new Rectangle(28, y, 742, 1));
    label.setBorder(BorderFactory.createLineBorder(new Color(211, 211, 211)));
    return label;
  }
  
  public JLabel getJLabel_LinhaV(int x, int h) {
    JLabel label = new JLabel();
    label.setBounds(new Rectangle(x, 7, 1, h - 7));
    label.setBorder(BorderFactory.createLineBorder(new Color(211, 211, 211)));
    return label;
  }
  
  public JCheckBox getJCheckBox_Sim(int y) { JCheckBox check = new JCheckBox();
    check.setOpaque(false);
    check.setBounds(new Rectangle(667, y, 28, 17));
    check.setHorizontalAlignment(0);
    return check;
  }
  
  public JCheckBox getJCheckBox_Nao(int y) { JCheckBox check = new JCheckBox();
    check.setOpaque(false);
    check.setBounds(new Rectangle(703, y, 28, 17));
    check.setHorizontalAlignment(0);
    return check;
  }
  
  public JCheckBox getJCheckBox_NaoAplic(int y) { JCheckBox check = new JCheckBox();
    check.setOpaque(false);
    check.setBounds(new Rectangle(739, y, 28, 17));
    check.setHorizontalAlignment(0);
    return check;
  }
  
  private ButtonGroup getJButtonGroup(JCheckBox sim, JCheckBox nao, JCheckBox clear) { ButtonGroup group = new ButtonGroup();
    group.add(sim);
    group.add(nao);
    group.add(clear);
    return group;
  }
  
  private ButtonGroup getJButtonGroup(JCheckBox sim, JCheckBox nao, JCheckBox nao_aplic, JCheckBox clear) { ButtonGroup group = new ButtonGroup();
    group.add(sim);
    group.add(nao);
    group.add(nao_aplic);
    group.add(clear);
    return group;
  }
  
  private JScrollPane getJScrollPane(int y, int h, JTextArea text_area) {
    JScrollPane scroll = new JScrollPane();
    scroll.setBounds(new Rectangle(45, y, 600, h));
    scroll.setPreferredSize(new Dimension(250, 250));
    scroll.setVerticalScrollBarPolicy(22);
    scroll.setViewportView(text_area);
    return scroll;
  }
  
  private JTextArea getJTextArea(final String tag_xml) { JTextArea text_area = new JTextArea();
    text_area.setFont(fmeComum.letra);
    text_area.setLineWrap(true);
    text_area.setWrapStyleWord(true);
    text_area.setMargin(new Insets(5, 5, 5, 5));
    text_area.addKeyListener(new KeyListener() {
      public void keyTyped(KeyEvent arg0) {}
      
      public void keyReleased(KeyEvent arg0) {
        CBData.Decl.on_update(tag_xml);
      }
      
      public void keyPressed(KeyEvent arg0) {}
    });
    return text_area;
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    

    print_handler.scaleToWidth((int)(1.05D * jPanel_Declaracoes.getWidth()));
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
    CBData.Decl.Clear();
    CBData.Decl.after_open();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.Decl.validar(null));
    return grp;
  }
  

















  private ButtonGroup getJButtonGroup_Geral_1()
  {
    if (jButtonGroup_Geral_1 == null) {
      jButtonGroup_Geral_1 = new ButtonGroup();
      jButtonGroup_Geral_1.add(jCheckBox_Geral_1_Sim);
      jButtonGroup_Geral_1.add(jCheckBox_Geral_1_Nao);
      jButtonGroup_Geral_1.add(jCheckBox_Geral_1_Clear);
    }
    return jButtonGroup_Geral_1;
  }
  
  public JCheckBox getjCheckBox_Geral_2_Sim() {
    if (jCheckBox_Geral_2_Sim == null) {
      jCheckBox_Geral_2_Sim = new JCheckBox();
      jCheckBox_Geral_2_Sim.setOpaque(false);
      jCheckBox_Geral_2_Sim.setBounds(new Rectangle(668, 94, 28, 20));
      jCheckBox_Geral_2_Sim.setHorizontalAlignment(0);
    }
    return jCheckBox_Geral_2_Sim;
  }
}
