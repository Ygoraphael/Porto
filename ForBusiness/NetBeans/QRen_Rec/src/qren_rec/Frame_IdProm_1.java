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
import javax.swing.JComboBox;
import javax.swing.JFormattedTextField;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.border.Border;

public class Frame_IdProm_1 extends JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  private JPanel jPanel_Promotor = null;
  private JLabel jLabel_Promotor = null;
  Border border_1 = BorderFactory.createLineBorder(SystemColor.inactiveCaption, 1);
  public JCheckBox jCheckBox_PessoaClear = new JCheckBox();
  public JCheckBox jCheckBox_EmpresaClear = new JCheckBox();
  private ButtonGroup jButtonGroup_Empresa = null;
  public JCheckBox jCheckBox_DimensaoClear = new JCheckBox();
  private JLabel jLabel_NIF = null;
  private JTextField jTextField_NIF = null;
  private JLabel jLabel_Nome = null;
  private JTextField jTextField_Nome = null;
  private JLabel jLabel_Morada = null;
  private JTextField jTextField_Morada = null;
  private JLabel jLabel_Localidade = null;
  private JTextField jTextField_Localidade = null;
  private JLabel jLabel_CodPostal = null;
  private JTextField jTextField_CodPostal = null;
  private JTextField jTextField_CodPostalLocal = null;
  private JLabel jLabel_Distrito = null;
  
  private SteppedComboBox jComboBox_Distrito = null;
  private JLabel jLabel_Concelho = null;
  private SteppedComboBox jComboBox_Concelho = null;
  private JLabel jLabel_Telefone = null;
  private JTextField jTextField_Telefone = null;
  private JLabel jLabel_Telefax = null;
  private JTextField jTextField_Telefax = null;
  private JLabel jLabel_Email = null;
  private JTextField jTextField_Email = null;
  private JLabel jLabel_Url = null;
  private JTextField jTextField_Url = null;
  private JLabel jLabel_NatJur = null;
  private SteppedComboBox jComboBox_NatJur = null;
  private JLabel jLabel_FinsLucro = null;
  private JCheckBox jCheckBox_FinsLucro_Sim = null;
  private JCheckBox jCheckBox_FinsLucro_Nao = null;
  public JCheckBox jCheckBox_FinsLucro_Clear = new JCheckBox();
  private ButtonGroup jButtonGroup_FinsLucro = null;
  private JLabel jLabel_DtConst = null;
  private JFormattedTextField jTextField_DtConst = null;
  private JLabel jLabel_DtInicioAct = null;
  private JFormattedTextField jTextField_DtInicioAct = null;
  public JLabel jLabel_CapSocial = null;
  private JFormattedTextField jTextField_CapSocial = null;
  private JLabel jLabel_€ = null;
  private JLabel jLabel_Matricula = null;
  private JFormattedTextField jTextField_Matricula = null;
  private JLabel jLabel_Conservatoria = null;
  private JFormattedTextField jTextField_Conservatoria = null;
  private JLabel jLabel_IES = null;
  public JLabel jLabel_IES_p1 = null;
  public JLabel jLabel_IES_p1_nota = null;
  private JFormattedTextField jTextField_IES_p1 = null;
  public JLabel jLabel_IES_p2 = null;
  private JFormattedTextField jTextField_IES_p2 = null;
  public JLabel jLabel_IES_p3 = null;
  private JFormattedTextField jTextField_IES_p3 = null;
  
  private JPanel jPanel_Contacto = null;
  private JLabel jLabel_Contacto = null;
  private JLabel jLabel_CContacto = null;
  private JCheckBox jCheckBox_CSim = null;
  private JCheckBox jCheckBox_CNao = null;
  public JCheckBox jCheckBox_CContactoClear = new JCheckBox();
  private ButtonGroup jButtonGroup_CContacto = null;
  private JLabel jLabel_CMorada = null;
  private JTextField jTextField_CMorada = null;
  private JLabel jLabel_CLocalidade = null;
  private JTextField jTextField_CLocalidade = null;
  private JLabel jLabel_CCodPostal = null;
  private JTextField jTextField_CCodPostal = null;
  private JTextField jTextField_CCodPostalLocal = null;
  private JLabel jLabel_CDistrito = null;
  
  private SteppedComboBox jComboBox_CDistrito = null;
  private JLabel jLabel_CConcelho = null;
  private SteppedComboBox jComboBox_CConcelho = null;
  private JLabel jLabel_CTelefone = null;
  private JTextField jTextField_CTelefone = null;
  private JLabel jLabel_CTelefax = null;
  private JTextField jTextField_CTelefax = null;
  private JLabel jLabel_CEmail = null;
  private JTextField jTextField_CEmail = null;
  private JLabel jLabel_CUrl = null;
  private JTextField jTextField_CUrl = null;
  
  private JPanel jPanel_Consultora = null;
  private JLabel jLabel_Consultora = null;
  private JLabel jLabel_ConsNIF = null;
  private JTextField jTextField_ConsNIF = null;
  private JLabel jLabel_ConsNome = null;
  private JTextField jTextField_ConsNome = null;
  private JLabel jLabel_ConsMorada = null;
  private JTextField jTextField_ConsMorada = null;
  private JLabel jLabel_ConsCodPostal = null;
  private JTextField jTextField_ConsCodPostal = null;
  private JTextField jTextField_ConsCodPostalLocal = null;
  private JLabel jLabel_ConsContacto = null;
  private JTextField jTextField_ConsContacto = null;
  private JLabel jLabel_ConsTelefone = null;
  private JTextField jTextField_ConsTelefone = null;
  private JLabel jLabel_ConsEmail = null;
  private JTextField jTextField_ConsEmail = null;
  
  private JPanel jPanel_CAE = null;
  private JLabel jLabel_CAE = null;
  private JScrollPane jScrollPane_CAE = null;
  private JTable_Tip jTable_CAE = null;
  private JLabel jLabel_notaCAE = null;
  private JPanel jPanel_PromLocal = null;
  private JLabel jLabel_PromLocal = null;
  private JScrollPane jScrollPane_PromLocal = null;
  private JTable_Tip jTable_PromLocal = null;
  private JButton jButton_PromLocalAdd = null;
  private JButton jButton_PromLocalIns = null;
  private JButton jButton_PromLocalDel = null;
  
  public String tag = "";
  int y = 0; int h = 0;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  public CBRegisto_Promotor cbd_promotor;
  
  public Frame_IdProm_1() {
    initialize();
  }
  
  void up_component(Component c, int n)
  {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void tirar_titulo() {
    jLabel_Titulo.setVisible(false);
    jLabel_PT2020.setVisible(false);
    up_component(jPanel_Promotor, 40);
    up_component(jPanel_Contacto, 40);
    up_component(jPanel_Consultora, 40);
    up_component(jPanel_CAE, 40);
    up_component(jPanel_PromLocal, 40);
  }
  
  public Dimension getSize() {
    return new Dimension(660, y + h + 10);
  }
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (params.get("capital") != null) {
      jLabel_CapSocial.setText(params.get("capital"));
    }
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
  
  private JPanel getJContentPane()
  {
    if (jContentPane == null) {
      jLabel_PT2020 = new Label2020();
      jLabel_Titulo = new LabelTitulo("CARACTERIZAÇÃO DO BENEFICIÁRIO");
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setOpaque(false);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.setSize(new Dimension(700, 1200));
      jContentPane.add(getJPanel_Promotor(), null);
      jContentPane.add(getJPanel_Contacto(), null);
      jContentPane.add(getJPanel_Consultora(), null);
      jContentPane.add(getJPanel_PromLocal(), null);
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_CAE(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_Promotor() {
    if (jPanel_Promotor == null) {
      jLabel_€ = new JLabel();
      jLabel_€.setBounds(new Rectangle(522, 286, 16, 18));
      jLabel_€.setText("€");
      jLabel_DtInicioAct = new JLabel();
      jLabel_DtInicioAct.setBounds(new Rectangle(229, 211, 179, 18));
      jLabel_DtInicioAct.setText("Data de Início de Atividade");
      
      jLabel_DtInicioAct.setHorizontalAlignment(4);
      jLabel_DtConst = new JLabel();
      jLabel_DtConst.setBounds(new Rectangle(17, 211, 120, 18));
      jLabel_DtConst.setText("Data de Constituição");
      
      jLabel_NatJur = new JLabel();
      jLabel_NatJur.setBounds(new Rectangle(17, 261, 123, 18));
      jLabel_NatJur.setText("Natureza Jurídica");
      
      jLabel_FinsLucro = new JLabel();
      jLabel_FinsLucro.setBounds(new Rectangle(17, 286, 95, 18));
      jLabel_FinsLucro.setText("Fins Lucrativos");
      
      jLabel_Url = new JLabel();
      jLabel_Url.setBounds(new Rectangle(324, 186, 84, 18));
      jLabel_Url.setText("URL");
      
      jLabel_Url.setHorizontalAlignment(4);
      jLabel_Email = new JLabel();
      jLabel_Email.setBounds(new Rectangle(325, 161, 83, 18));
      jLabel_Email.setText("E-mail");
      jLabel_Email.setHorizontalAlignment(4);
      
      jLabel_Telefax = new JLabel();
      jLabel_Telefax.setBounds(new Rectangle(17, 186, 84, 18));
      jLabel_Telefax.setText("Telefax");
      
      jLabel_Telefax.setHorizontalAlignment(10);
      jLabel_Telefone = new JLabel();
      jLabel_Telefone.setBounds(new Rectangle(17, 161, 85, 18));
      jLabel_Telefone.setText("Telefone(s)");
      
      jLabel_Concelho = new JLabel();
      jLabel_Concelho.setBounds(new Rectangle(326, 136, 83, 18));
      jLabel_Concelho.setText("Concelho");
      
      jLabel_Concelho.setHorizontalAlignment(4);
      jLabel_Distrito = new JLabel();
      jLabel_Distrito.setBounds(new Rectangle(17, 136, 84, 18));
      jLabel_Distrito.setText("Distrito");
      
      jLabel_CodPostal = new JLabel();
      jLabel_CodPostal.setBounds(new Rectangle(326, 111, 83, 18));
      jLabel_CodPostal.setText("Código Postal");
      jLabel_CodPostal.setHorizontalAlignment(4);
      
      jLabel_Localidade = new JLabel();
      jLabel_Localidade.setBounds(new Rectangle(17, 111, 83, 18));
      jLabel_Localidade.setText("Localidade");
      
      jLabel_Morada = new JLabel();
      jLabel_Morada.setBounds(new Rectangle(17, 86, 142, 18));
      jLabel_Morada.setText("Morada (Sede Social)");
      
      jLabel_Nome = new JLabel();
      jLabel_Nome.setBounds(new Rectangle(17, 61, 142, 18));
      jLabel_Nome.setText("Nome ou Designação Social");
      
      jLabel_NIF = new JLabel();
      jLabel_NIF.setBounds(new Rectangle(17, 36, 142, 18));
      jLabel_NIF.setText("Nº de Identificação Fiscal");
      
      GridBagConstraints gridBagConstraints3 = new GridBagConstraints();
      gridx = 0;
      gridy = 0;
      jLabel_Promotor = new JLabel();
      jLabel_Promotor.setText("Identificação do Beneficiário");
      jLabel_Promotor.setBounds(new Rectangle(12, 10, 242, 18));
      jLabel_Promotor.setFont(fmeComum.letra_bold);
      
      jLabel_Matricula = new JLabel();
      jLabel_Matricula.setBounds(new Rectangle(17, 236, 120, 18));
      jLabel_Matricula.setText("Matriculada sob o Nº");
      

      jLabel_Conservatoria = new JLabel();
      jLabel_Conservatoria.setBounds(new Rectangle(229, 236, 179, 18));
      jLabel_Conservatoria.setText("Conservatória do Registo Comercial");
      
      jLabel_Conservatoria.setHorizontalAlignment(4);
      
      jLabel_CapSocial = new JLabel();
      jLabel_CapSocial.setBounds(new Rectangle(288, 286, 120, 18));
      jLabel_CapSocial.setText("Capital Social");
      
      jLabel_CapSocial.setHorizontalAlignment(4);
      
      jLabel_IES = new JLabel();
      jLabel_IES.setBounds(new Rectangle(17, 311, 602, 33));
      jLabel_IES.setText("<html>Identificação dos códigos de validação da IES - Informação Empresarial Simplificada/Declaração anual dos 3 anos anteriores ao ano de candidatura</html>");
      
      jLabel_IES_p1 = new JLabel();
      jLabel_IES_p1.setBounds(new Rectangle(207, 335, 52, 18));
      jLabel_IES_p1.setText("Ano -1");
      jLabel_IES_p1.setHorizontalAlignment(4);
      
      jLabel_IES_p2 = new JLabel();
      jLabel_IES_p2.setBounds(new Rectangle(207, 355, 52, 18));
      jLabel_IES_p2.setText("Ano -2");
      jLabel_IES_p2.setHorizontalAlignment(4);
      
      jLabel_IES_p3 = new JLabel();
      jLabel_IES_p3.setBounds(new Rectangle(207, 375, 52, 18));
      jLabel_IES_p3.setText("Ano -3");
      jLabel_IES_p3.setHorizontalAlignment(4);
      
      jLabel_IES_p1_nota = new JLabel();
      jLabel_IES_p1_nota.setBounds(new Rectangle(17, 395, 602, 33));
      jLabel_IES_p1_nota.setText("<html>(*) Quando ainda não houver IES do ano de " + (_lib.to_int(CParseConfig.hconfig.get("ano_cand").toString()) - 1) + " e o campo de 2016 não for preenchido, deve ser obrigatório o upload na página “Documentos a Submeter” das contas aprovadas da entidade beneficiária, que têm de ser aprovadas até 31 de Março de " + CParseConfig.hconfig.get("ano_cand").toString() + ".</html>");
      jLabel_IES_p1_nota.setFont(fmeComum.letra_pequena);
      
      jPanel_Promotor = new JPanel();
      jPanel_Promotor.setLayout(null);
      jPanel_Promotor.setOpaque(false);
      jPanel_Promotor.setBounds(new Rectangle(15, this.y = 50, fmeApp.width - 60, this.h = 'Ʃ'));
      jPanel_Promotor.setBorder(fmeComum.blocoBorder);
      jPanel_Promotor.add(jLabel_Promotor, gridBagConstraints3);
      jPanel_Promotor.add(jLabel_NIF, null);
      jPanel_Promotor.add(getJTextField_NIF(), null);
      jPanel_Promotor.add(jLabel_Nome, null);
      jPanel_Promotor.add(getJTextField_Nome(), null);
      jPanel_Promotor.add(jLabel_Morada, null);
      jPanel_Promotor.add(getJTextField_Morada(), null);
      jPanel_Promotor.add(jLabel_Localidade, null);
      jPanel_Promotor.add(getJTextField_Localidade(), null);
      jPanel_Promotor.add(jLabel_CodPostal, null);
      jPanel_Promotor.add(getJTextField_CodPostal(), null);
      jPanel_Promotor.add(getJTextField_CodPostalLocal(), null);
      jPanel_Promotor.add(jLabel_Distrito, null);
      jPanel_Promotor.add(getJComboBox_Distrito(), null);
      jPanel_Promotor.add(jLabel_Concelho, null);
      jPanel_Promotor.add(getJComboBox_Concelho(), null);
      jPanel_Promotor.add(jLabel_Telefone, null);
      jPanel_Promotor.add(getJTextField_Telefone(), null);
      jPanel_Promotor.add(jLabel_Telefax, null);
      jPanel_Promotor.add(getJTextField_Telefax(), null);
      jPanel_Promotor.add(jLabel_Email, null);
      jPanel_Promotor.add(getJTextField_Email(), null);
      jPanel_Promotor.add(jLabel_Url, null);
      jPanel_Promotor.add(getJTextField_Url(), null);
      jPanel_Promotor.add(jLabel_NatJur, null);
      jPanel_Promotor.add(getJComboBox_NatJur(), null);
      jPanel_Promotor.add(jLabel_FinsLucro, null);
      jPanel_Promotor.add(getJCheckBox_FinsLucro_Sim(), null);
      jPanel_Promotor.add(getJCheckBox_FinsLucro_Nao(), null);
      getJButtonGroup_FinsLucro();
      jPanel_Promotor.add(jLabel_CapSocial, null);
      jPanel_Promotor.add(jLabel_€, null);
      jPanel_Promotor.add(getJTextField_CapSocial(), null);
      jPanel_Promotor.add(jLabel_DtConst, null);
      jPanel_Promotor.add(jLabel_DtInicioAct, null);
      jPanel_Promotor.add(getJTextField_DtConst(), null);
      jPanel_Promotor.add(getJTextField_DtInicioAct(), null);
      jPanel_Promotor.add(jLabel_Matricula, null);
      jPanel_Promotor.add(getJTextField_Matricula(), null);
      jPanel_Promotor.add(jLabel_Conservatoria, null);
      jPanel_Promotor.add(getJTextField_Conservatoria(), null);
      jPanel_Promotor.add(jLabel_IES, null);
      jPanel_Promotor.add(jLabel_IES_p1, null);
      jPanel_Promotor.add(jLabel_IES_p1_nota, null);
      jPanel_Promotor.add(getJTextField_IES_p1(), null);
      jPanel_Promotor.add(jLabel_IES_p2, null);
      jPanel_Promotor.add(getJTextField_IES_p2(), null);
      jPanel_Promotor.add(jLabel_IES_p3, null);
      jPanel_Promotor.add(getJTextField_IES_p3(), null);
      jPanel_Promotor.add(jLabel_€, null);
    }
    return jPanel_Promotor;
  }
  
  private JPanel getJPanel_Contacto()
  {
    if (jPanel_Contacto == null) {
      jLabel_Contacto = new JLabel();
      jLabel_Contacto.setBounds(new Rectangle(17, 300, 117, 18));
      jLabel_Contacto.setText("Pessoa a contactar");
      
      jLabel_CUrl = new JLabel();
      jLabel_CUrl.setBounds(new Rectangle(327, 162, 83, 18));
      jLabel_CUrl.setText("URL");
      
      jLabel_CUrl.setHorizontalAlignment(4);
      jLabel_CEmail = new JLabel();
      jLabel_CEmail.setBounds(new Rectangle(327, 137, 83, 18));
      jLabel_CEmail.setText("E-mail");
      jLabel_CEmail.setHorizontalAlignment(4);
      
      jLabel_CTelefax = new JLabel();
      jLabel_CTelefax.setBounds(new Rectangle(17, 162, 84, 18));
      jLabel_CTelefax.setText("Telefax");
      
      jLabel_CTelefax.setHorizontalAlignment(10);
      jLabel_CTelefone = new JLabel();
      jLabel_CTelefone.setBounds(new Rectangle(17, 137, 85, 18));
      jLabel_CTelefone.setText("Telefone(s)");
      
      jLabel_CConcelho = new JLabel();
      jLabel_CConcelho.setBounds(new Rectangle(327, 111, 83, 18));
      jLabel_CConcelho.setText("Concelho");
      
      jLabel_CConcelho.setHorizontalAlignment(4);
      jLabel_CDistrito = new JLabel();
      jLabel_CDistrito.setBounds(new Rectangle(18, 111, 84, 18));
      jLabel_CDistrito.setText("Distrito");
      
      jLabel_CCodPostal = new JLabel();
      jLabel_CCodPostal.setBounds(new Rectangle(327, 86, 83, 18));
      jLabel_CCodPostal.setText("Código Postal");
      jLabel_CCodPostal.setHorizontalAlignment(4);
      
      jLabel_CLocalidade = new JLabel();
      jLabel_CLocalidade.setBounds(new Rectangle(18, 86, 83, 18));
      jLabel_CLocalidade.setText("Localidade");
      
      jLabel_CContacto = new JLabel();
      jLabel_CContacto.setBounds(new Rectangle(18, 36, 266, 18));
      jLabel_CContacto.setText("Dados de contacto diferentes dos da Sede Social?");
      
      jLabel_CMorada = new JLabel();
      jLabel_CMorada.setBounds(new Rectangle(18, 61, 83, 18));
      jLabel_CMorada.setText("Morada");
      
      GridBagConstraints gridBagConstraints3 = new GridBagConstraints();
      gridx = 0;
      gridy = 0;
      jLabel_Contacto = new JLabel();
      jLabel_Contacto.setText("Contactos do Beneficiário para efeitos do projeto");
      jLabel_Contacto.setBounds(new Rectangle(12, 10, 458, 18));
      jLabel_Contacto.setFont(fmeComum.letra_bold);
      
      jPanel_Contacto = new JPanel();
      jPanel_Contacto.setLayout(null);
      jPanel_Contacto.setOpaque(false);
      jPanel_Contacto.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'Ã'));
      jPanel_Contacto.setBorder(fmeComum.blocoBorder);
      jPanel_Contacto.add(jLabel_Contacto, gridBagConstraints3);
      jPanel_Contacto.add(jLabel_CContacto, null);
      jPanel_Contacto.add(getJCheckBox_CSim(), null);
      jPanel_Contacto.add(getJCheckBox_CNao(), null);
      getJButtonGroup_CContacto();
      jPanel_Contacto.add(jLabel_CMorada, null);
      jPanel_Contacto.add(getJTextField_CMorada(), null);
      jPanel_Contacto.add(jLabel_CLocalidade, null);
      jPanel_Contacto.add(getJTextField_CLocalidade(), null);
      jPanel_Contacto.add(jLabel_CCodPostal, null);
      jPanel_Contacto.add(getJTextField_CCodPostal(), null);
      jPanel_Contacto.add(getJTextField_CCodPostalLocal(), null);
      jPanel_Contacto.add(jLabel_CDistrito, null);
      jPanel_Contacto.add(getJComboBox_CDistrito(), null);
      jPanel_Contacto.add(jLabel_CConcelho, null);
      jPanel_Contacto.add(getJComboBox_CConcelho(), null);
      jPanel_Contacto.add(jLabel_CTelefone, null);
      jPanel_Contacto.add(getJTextField_CTelefone(), null);
      jPanel_Contacto.add(jLabel_CTelefax, null);
      jPanel_Contacto.add(getJTextField_CTelefax(), null);
      jPanel_Contacto.add(jLabel_CEmail, null);
      jPanel_Contacto.add(getJTextField_CEmail(), null);
      jPanel_Contacto.add(jLabel_CUrl, null);
      jPanel_Contacto.add(getJTextField_CUrl(), null);
      jPanel_Contacto.add(jLabel_Contacto, null);
    }
    return jPanel_Contacto;
  }
  
  private JPanel getJPanel_Consultora() {
    if (jPanel_Consultora == null) {
      jLabel_ConsEmail = new JLabel();
      jLabel_ConsEmail.setBounds(new Rectangle(325, 163, 83, 18));
      jLabel_ConsEmail.setText("E-mail");
      jLabel_ConsEmail.setHorizontalAlignment(4);
      
      jLabel_ConsContacto = new JLabel();
      jLabel_ConsContacto.setBounds(new Rectangle(17, 139, 85, 18));
      jLabel_ConsContacto.setText("Contacto");
      
      jLabel_ConsTelefone = new JLabel();
      jLabel_ConsTelefone.setBounds(new Rectangle(17, 163, 85, 18));
      jLabel_ConsTelefone.setText("Telefone(s)");
      
      jLabel_ConsCodPostal = new JLabel();
      jLabel_ConsCodPostal.setBounds(new Rectangle(17, 114, 83, 18));
      jLabel_ConsCodPostal.setText("Código Postal");
      
      jLabel_ConsMorada = new JLabel();
      jLabel_ConsMorada.setBounds(new Rectangle(17, 88, 153, 18));
      jLabel_ConsMorada.setText("Morada (Sede Social)");
      
      jLabel_ConsNome = new JLabel();
      jLabel_ConsNome.setBounds(new Rectangle(17, 63, 163, 18));
      jLabel_ConsNome.setText("Nome ou Designação Social");
      
      jLabel_ConsNIF = new JLabel();
      jLabel_ConsNIF.setBounds(new Rectangle(17, 38, 163, 18));
      jLabel_ConsNIF.setText("Nº de Identificação Fiscal");
      
      GridBagConstraints gridBagConstraints3 = new GridBagConstraints();
      gridx = 0;
      gridy = 0;
      jLabel_Consultora = new JLabel();
      jLabel_Consultora.setText("Entidade consultora responsável pela elaboração da candidatura");
      jLabel_Consultora.setBounds(new Rectangle(12, 10, 517, 18));
      jLabel_Consultora.setFont(fmeComum.letra_bold);
      
      jPanel_Consultora = new JPanel();
      jPanel_Consultora.setLayout(null);
      jPanel_Consultora.setOpaque(false);
      jPanel_Consultora.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'Ã'));
      jPanel_Consultora.setBorder(fmeComum.blocoBorder);
      jPanel_Consultora.add(jLabel_Consultora, null);
      jPanel_Consultora.add(jLabel_ConsNIF, null);
      jPanel_Consultora.add(getJTextField_ConsNIF(), null);
      jPanel_Consultora.add(jLabel_ConsNome, null);
      jPanel_Consultora.add(getJTextField_ConsNome(), null);
      jPanel_Consultora.add(jLabel_ConsMorada, null);
      jPanel_Consultora.add(getJTextField_ConsMorada(), null);
      jPanel_Consultora.add(jLabel_ConsCodPostal, null);
      jPanel_Consultora.add(getJTextField_ConsCodPostal(), null);
      jPanel_Consultora.add(getJTextField_ConsCodPostalLocal(), null);
      jPanel_Consultora.add(jLabel_ConsContacto, null);
      jPanel_Consultora.add(getJTextField_ConsContacto(), null);
      jPanel_Consultora.add(jLabel_ConsTelefone, null);
      jPanel_Consultora.add(getJTextField_ConsTelefone(), null);
      jPanel_Consultora.add(jLabel_ConsEmail, null);
      jPanel_Consultora.add(getJTextField_ConsEmail(), null);
    }
    return jPanel_Consultora;
  }
  
  public JTextField getJTextField_NIF() {
    if (jTextField_NIF == null) {
      jTextField_NIF = new JTextField();
      jTextField_NIF.setBounds(new Rectangle(160, 36, 80, 18));
      jTextField_NIF.setEditable(false);
      jTextField_NIF.setFocusable(false);
    }
    return jTextField_NIF;
  }
  
  public JTextField getJTextField_Nome() {
    if (jTextField_Nome == null) {
      jTextField_Nome = new JTextField();
      jTextField_Nome.setBounds(new Rectangle(160, 61, 463, 18));
      jTextField_Nome.setEditable(false);
      jTextField_Nome.setFocusable(false);
    }
    return jTextField_Nome;
  }
  
  public JTextField getJTextField_Morada() {
    if (jTextField_Morada == null) {
      jTextField_Morada = new JTextField();
      jTextField_Morada.setBounds(new Rectangle(160, 86, 463, 18));
      jTextField_Morada.setEditable(false);
      jTextField_Morada.setFocusable(false);
    }
    return jTextField_Morada;
  }
  
  public JTextField getJTextField_Localidade() {
    if (jTextField_Localidade == null) {
      jTextField_Localidade = new JTextField();
      jTextField_Localidade.setBounds(new Rectangle(100, 111, 210, 18));
      jTextField_Localidade.setEditable(false);
      jTextField_Localidade.setFocusable(false);
    }
    return jTextField_Localidade;
  }
  
  public JTextField getJTextField_CodPostal() {
    if (jTextField_CodPostal == null) {
      jTextField_CodPostal = new JTextField();
      jTextField_CodPostal.setBounds(new Rectangle(412, 111, 60, 18));
      jTextField_CodPostal.setEditable(false);
      jTextField_CodPostal.setFocusable(false);
    }
    return jTextField_CodPostal;
  }
  
  public JTextField getJTextField_CodPostalLocal() {
    if (jTextField_CodPostalLocal == null) {
      jTextField_CodPostalLocal = new JTextField();
      jTextField_CodPostalLocal.setBounds(new Rectangle(477, 111, 146, 18));
      jTextField_CodPostalLocal.setEditable(false);
      jTextField_CodPostalLocal.setFocusable(false);
    }
    return jTextField_CodPostalLocal;
  }
  
  public JComboBox getJComboBox_Distrito()
  {
    if (jComboBox_Distrito == null) {
      jComboBox_Distrito = new SteppedComboBox();
      jComboBox_Distrito.setBounds(new Rectangle(100, 136, 210, 18));
      jComboBox_Distrito.setEditable(false);
      jComboBox_Distrito.setFocusable(false);
      jComboBox_Distrito.setEnabled(false);
      jComboBox_Distrito.addActionListener(new ActionListener()
      {
        public void actionPerformed(ActionEvent e) {
          try {
            cbd_promotor.getByName("distrito").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jComboBox_Distrito;
  }
  
  public JComboBox getJComboBox_Concelho() {
    if (jComboBox_Concelho == null) {
      jComboBox_Concelho = new SteppedComboBox();
      jComboBox_Concelho.setPopupWidth(210);
      jComboBox_Concelho.setBounds(new Rectangle(412, 136, 211, 18));
      jComboBox_Concelho.setEditable(false);
      jComboBox_Concelho.setFocusable(false);
      jComboBox_Concelho.setEnabled(false);
      jComboBox_Concelho.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { cbd_promotor.getByName("concelho").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jComboBox_Concelho;
  }
  
  public JTextField getJTextField_Telefone() {
    if (jTextField_Telefone == null) {
      jTextField_Telefone = new JTextField();
      jTextField_Telefone.setBounds(new Rectangle(100, 161, 210, 18));
      jTextField_Telefone.setEditable(false);
      jTextField_Telefone.setFocusable(false);
    }
    return jTextField_Telefone;
  }
  
  public JTextField getJTextField_Telefax() {
    if (jTextField_Telefax == null) {
      jTextField_Telefax = new JTextField();
      jTextField_Telefax.setBounds(new Rectangle(100, 186, 210, 18));
      jTextField_Telefax.setEditable(false);
      jTextField_Telefax.setFocusable(false);
    }
    return jTextField_Telefax;
  }
  
  public JTextField getJTextField_Email() {
    if (jTextField_Email == null) {
      jTextField_Email = new JTextField();
      jTextField_Email.setBounds(new Rectangle(412, 161, 211, 18));
      jTextField_Email.setEditable(false);
      jTextField_Email.setFocusable(false);
    }
    return jTextField_Email;
  }
  
  public JTextField getJTextField_Url() {
    if (jTextField_Url == null) {
      jTextField_Url = new JTextField();
      jTextField_Url.setBounds(new Rectangle(412, 186, 211, 18));
      jTextField_Url.setEditable(false);
      jTextField_Url.setFocusable(false);
    }
    return jTextField_Url;
  }
  
  public JComboBox getJComboBox_NatJur() {
    if (jComboBox_NatJur == null) {
      jComboBox_NatJur = new SteppedComboBox();
      jComboBox_NatJur.setBounds(new Rectangle(140, 261, 483, 18));
      jComboBox_NatJur.setEditable(false);
      jComboBox_NatJur.setFocusable(false);
      jComboBox_NatJur.setEnabled(false);
    }
    return jComboBox_NatJur;
  }
  
  public JCheckBox getJCheckBox_FinsLucro_Sim() {
    if (jCheckBox_FinsLucro_Sim == null) {
      jCheckBox_FinsLucro_Sim = new JCheckBox();
      jCheckBox_FinsLucro_Sim.setOpaque(false);
      jCheckBox_FinsLucro_Sim.setBounds(new Rectangle(135, 288, 47, 15));
      jCheckBox_FinsLucro_Sim.setText("Sim");
      jCheckBox_FinsLucro_Sim.setFont(fmeComum.letra);
    }
    






    return jCheckBox_FinsLucro_Sim;
  }
  
  public JCheckBox getJCheckBox_FinsLucro_Nao() {
    if (jCheckBox_FinsLucro_Nao == null) {
      jCheckBox_FinsLucro_Nao = new JCheckBox();
      jCheckBox_FinsLucro_Nao.setOpaque(false);
      jCheckBox_FinsLucro_Nao.setBounds(new Rectangle(180, 288, 54, 15));
      jCheckBox_FinsLucro_Nao.setText("Não");
      jCheckBox_FinsLucro_Nao.setFont(fmeComum.letra);
    }
    





    return jCheckBox_FinsLucro_Nao;
  }
  
  private ButtonGroup getJButtonGroup_FinsLucro() { if (jButtonGroup_FinsLucro == null) {
      jButtonGroup_FinsLucro = new ButtonGroup();
      jButtonGroup_FinsLucro.add(jCheckBox_FinsLucro_Sim);
      jButtonGroup_FinsLucro.add(jCheckBox_FinsLucro_Nao);
      jButtonGroup_FinsLucro.add(jCheckBox_FinsLucro_Clear);
    }
    return jButtonGroup_FinsLucro;
  }
  
  public JFormattedTextField getJTextField_DtConst()
  {
    if (jTextField_DtConst == null) {
      jTextField_DtConst = new JFormattedTextField();
      jTextField_DtConst.setBounds(new Rectangle(140, 211, 80, 18));
      jTextField_DtConst.setEditable(false);
      jTextField_DtConst.setFocusable(false);
    }
    return jTextField_DtConst;
  }
  
  public JFormattedTextField getJTextField_DtInicioAct() {
    if (jTextField_DtInicioAct == null) {
      jTextField_DtInicioAct = new JFormattedTextField();
      jTextField_DtInicioAct.setBounds(new Rectangle(412, 211, 80, 18));
      jTextField_DtInicioAct.setEditable(false);
      jTextField_DtInicioAct.setFocusable(false);
    }
    return jTextField_DtInicioAct;
  }
  
  public JFormattedTextField getJTextField_CapSocial() {
    if (jTextField_CapSocial == null) {
      jTextField_CapSocial = new JFormattedTextField();
      jTextField_CapSocial.setBounds(new Rectangle(412, 286, 106, 18));
      jTextField_CapSocial.setHorizontalAlignment(4);
      jTextField_CapSocial.setEditable(false);
      jTextField_CapSocial.setFocusable(false);
    }
    return jTextField_CapSocial;
  }
  
  public JFormattedTextField getJTextField_Matricula() {
    if (jTextField_Matricula == null) {
      jTextField_Matricula = new JFormattedTextField();
      jTextField_Matricula.setBounds(new Rectangle(140, 236, 80, 18));
      jTextField_Matricula.setEditable(false);
      jTextField_Matricula.setFocusable(false);
    }
    return jTextField_Matricula;
  }
  
  public JFormattedTextField getJTextField_Conservatoria() { if (jTextField_Conservatoria == null) {
      jTextField_Conservatoria = new JFormattedTextField();
      jTextField_Conservatoria.setBounds(new Rectangle(412, 236, 211, 18));
      jTextField_Conservatoria.setEditable(false);
      jTextField_Conservatoria.setFocusable(false);
    }
    return jTextField_Conservatoria;
  }
  
  public JFormattedTextField getJTextField_IES_p1() {
    if (jTextField_IES_p1 == null) {
      jTextField_IES_p1 = new JFormattedTextField();
      jTextField_IES_p1.setBounds(new Rectangle(263, 335, 109, 18));
    }
    return jTextField_IES_p1;
  }
  
  public JFormattedTextField getJTextField_IES_p2() { if (jTextField_IES_p2 == null) {
      jTextField_IES_p2 = new JFormattedTextField();
      jTextField_IES_p2.setBounds(new Rectangle(263, 355, 109, 18));
    }
    return jTextField_IES_p2;
  }
  
  public JFormattedTextField getJTextField_IES_p3() { if (jTextField_IES_p3 == null) {
      jTextField_IES_p3 = new JFormattedTextField();
      jTextField_IES_p3.setBounds(new Rectangle(263, 375, 109, 18));
    }
    return jTextField_IES_p3;
  }
  
  public JCheckBox getJCheckBox_CSim() {
    if (jCheckBox_CSim == null) {
      jCheckBox_CSim = new JCheckBox();
      jCheckBox_CSim.setOpaque(false);
      jCheckBox_CSim.setBounds(new Rectangle(287, 38, 50, 15));
      jCheckBox_CSim.setText("Sim");
      jCheckBox_CSim.setFont(fmeComum.letra);
    }
    






    return jCheckBox_CSim;
  }
  
  public JCheckBox getJCheckBox_CNao() {
    if (jCheckBox_CNao == null) {
      jCheckBox_CNao = new JCheckBox();
      jCheckBox_CNao.setOpaque(false);
      jCheckBox_CNao.setBounds(new Rectangle(338, 37, 68, 17));
      jCheckBox_CNao.setText("Não");
      jCheckBox_CNao.setFont(fmeComum.letra);
    }
    





    return jCheckBox_CNao;
  }
  
  private ButtonGroup getJButtonGroup_CContacto() { if (jButtonGroup_CContacto == null) {
      jButtonGroup_CContacto = new ButtonGroup();
      jButtonGroup_CContacto.add(jCheckBox_CSim);
      jButtonGroup_CContacto.add(jCheckBox_CNao);
      jButtonGroup_CContacto.add(jCheckBox_CContactoClear);
    }
    return jButtonGroup_CContacto;
  }
  
  public JTextField getJTextField_CMorada() {
    if (jTextField_CMorada == null) {
      jTextField_CMorada = new JTextField();
      jTextField_CMorada.setBounds(new Rectangle(101, 61, 523, 18));
    }
    


    return jTextField_CMorada;
  }
  
  public JTextField getJTextField_CLocalidade() {
    if (jTextField_CLocalidade == null) {
      jTextField_CLocalidade = new JTextField();
      jTextField_CLocalidade.setBounds(new Rectangle(101, 86, 210, 18));
    }
    

    return jTextField_CLocalidade;
  }
  
  public JTextField getJTextField_CCodPostal() {
    if (jTextField_CCodPostal == null) {
      jTextField_CCodPostal = new JTextField();
      jTextField_CCodPostal.setBounds(new Rectangle(415, 86, 60, 18));
    }
    

    return jTextField_CCodPostal;
  }
  
  public JTextField getJTextField_CCodPostalLocal() {
    if (jTextField_CCodPostalLocal == null) {
      jTextField_CCodPostalLocal = new JTextField();
      jTextField_CCodPostalLocal.setBounds(new Rectangle(480, 86, 145, 18));
    }
    

    return jTextField_CCodPostalLocal;
  }
  
  public JComboBox getJComboBox_CDistrito() {
    if (jComboBox_CDistrito == null) {
      jComboBox_CDistrito = new SteppedComboBox();
      jComboBox_CDistrito.setBounds(new Rectangle(101, 111, 210, 18));
      



      jComboBox_CDistrito.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { cbd_contacto.getByName("distrito").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jComboBox_CDistrito;
  }
  
  public JComboBox getJComboBox_CConcelho() {
    if (jComboBox_CConcelho == null) {
      jComboBox_CConcelho = new SteppedComboBox();
      jComboBox_CConcelho.setPopupWidth(210);
      
      jComboBox_CConcelho.setBounds(new Rectangle(415, 111, 210, 18));
      

      jComboBox_CConcelho.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          try { cbd_contacto.getByName("concelho").vldOnline();
          } catch (Exception localException) {}
        }
      });
    }
    return jComboBox_CConcelho;
  }
  
  public JTextField getJTextField_CTelefone() {
    if (jTextField_CTelefone == null) {
      jTextField_CTelefone = new JTextField();
      jTextField_CTelefone.setBounds(new Rectangle(101, 137, 210, 18));
    }
    

    return jTextField_CTelefone;
  }
  
  public JTextField getJTextField_CTelefax() {
    if (jTextField_CTelefax == null) {
      jTextField_CTelefax = new JTextField();
      jTextField_CTelefax.setBounds(new Rectangle(101, 162, 210, 18));
    }
    

    return jTextField_CTelefax;
  }
  
  public JTextField getJTextField_CEmail() {
    if (jTextField_CEmail == null) {
      jTextField_CEmail = new JTextField();
      jTextField_CEmail.setBounds(new Rectangle(415, 137, 210, 18));
    }
    

    return jTextField_CEmail;
  }
  
  public JTextField getJTextField_CUrl() {
    if (jTextField_CUrl == null) {
      jTextField_CUrl = new JTextField();
      jTextField_CUrl.setBounds(new Rectangle(415, 162, 210, 18));
    }
    

    return jTextField_CUrl;
  }
  
  public JTextField getJTextField_ConsNIF() {
    if (jTextField_ConsNIF == null) {
      jTextField_ConsNIF = new JTextField();
      jTextField_ConsNIF.setBounds(new Rectangle(181, 38, 95, 18));
    }
    return jTextField_ConsNIF;
  }
  
  public JTextField getJTextField_ConsNome() {
    if (jTextField_ConsNome == null) {
      jTextField_ConsNome = new JTextField();
      jTextField_ConsNome.setBounds(new Rectangle(181, 63, 442, 18));
      jTextField_ConsNome.setEditable(false);
      jTextField_ConsNome.setFocusable(false);
    }
    return jTextField_ConsNome;
  }
  
  public JTextField getJTextField_ConsMorada() {
    if (jTextField_ConsMorada == null) {
      jTextField_ConsMorada = new JTextField();
      jTextField_ConsMorada.setBounds(new Rectangle(181, 88, 442, 18));
      jTextField_ConsMorada.setEditable(false);
      jTextField_ConsMorada.setFocusable(false);
    }
    return jTextField_ConsMorada;
  }
  
  public JTextField getJTextField_ConsCodPostal() {
    if (jTextField_ConsCodPostal == null) {
      jTextField_ConsCodPostal = new JTextField();
      jTextField_ConsCodPostal.setBounds(new Rectangle(116, 114, 60, 18));
      jTextField_ConsCodPostal.setEditable(false);
      jTextField_ConsCodPostal.setFocusable(false);
    }
    return jTextField_ConsCodPostal;
  }
  
  public JTextField getJTextField_ConsCodPostalLocal() {
    if (jTextField_ConsCodPostalLocal == null) {
      jTextField_ConsCodPostalLocal = new JTextField();
      jTextField_ConsCodPostalLocal.setBounds(new Rectangle(181, 114, 146, 18));
      jTextField_ConsCodPostalLocal.setEditable(false);
      jTextField_ConsCodPostalLocal.setFocusable(false);
    }
    return jTextField_ConsCodPostalLocal;
  }
  
  public JTextField getJTextField_ConsContacto() {
    if (jTextField_ConsContacto == null) {
      jTextField_ConsContacto = new JTextField();
      jTextField_ConsContacto.setBounds(new Rectangle(116, 139, 507, 18));
    }
    

    return jTextField_ConsContacto;
  }
  
  public JTextField getJTextField_ConsTelefone() {
    if (jTextField_ConsTelefone == null) {
      jTextField_ConsTelefone = new JTextField();
      jTextField_ConsTelefone.setBounds(new Rectangle(116, 163, 210, 18));
    }
    

    return jTextField_ConsTelefone;
  }
  
  public JTextField getJTextField_ConsEmail() {
    if (jTextField_ConsEmail == null) {
      jTextField_ConsEmail = new JTextField();
      jTextField_ConsEmail.setBounds(new Rectangle(412, 163, 211, 18));
    }
    

    return jTextField_ConsEmail;
  }
  
  private JPanel getJPanel_CAE() {
    if (jPanel_CAE == null) {
      jLabel_CAE = new JLabel();
      jLabel_CAE.setBounds(new Rectangle(11, 9, 267, 16));
      jLabel_CAE.setText("Atividade(s) Económica(s) do Beneficiário");
      jLabel_CAE.setFont(fmeComum.letra_bold);
      jLabel_notaCAE = new JLabel();
      jLabel_notaCAE.setBounds(new Rectangle(232, 130, 550, 16));
      jLabel_notaCAE.setText("A % é relativa ao volume de negócios");
      jLabel_notaCAE.setHorizontalAlignment(4);
      jLabel_notaCAE.setFont(fmeComum.letra_pequena);
      jPanel_CAE = new JPanel();
      jPanel_CAE.setLayout(null);
      jPanel_CAE.setOpaque(false);
      jPanel_CAE.setBorder(fmeComum.blocoBorder);
      jPanel_CAE.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = ''));
      jPanel_CAE.add(jLabel_CAE, null);
      jPanel_CAE.add(getJScrollPane_CAE(), null);
      jPanel_CAE.add(jLabel_notaCAE, null);
    }
    return jPanel_CAE;
  }
  
  public JScrollPane getJScrollPane_CAE() {
    if (jScrollPane_CAE == null) {
      jScrollPane_CAE = new JScrollPane();
      jScrollPane_CAE.setBounds(new Rectangle(14, 30, fmeApp.width - 90, 101));
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
      jTable_CAE.setFont(fmeComum.letra);
    }
    return jTable_CAE;
  }
  
  private JPanel getJPanel_PromLocal() {
    if (jPanel_PromLocal == null) {
      jButton_PromLocalAdd = new JButton(fmeComum.novaLinha);
      jButton_PromLocalAdd.setBounds(new Rectangle(667, 10, 30, 22));
      jButton_PromLocalAdd.setBorder(BorderFactory.createEtchedBorder());
      jButton_PromLocalAdd.setToolTipText("Nova Linha");
      jButton_PromLocalAdd.addMouseListener(new Frame_IdProm_1_jButton_PromLocalAdd_mouseAdapter(this));
      jButton_PromLocalIns = new JButton(fmeComum.inserirLinha);
      jButton_PromLocalIns.setBounds(new Rectangle(707, 10, 30, 22));
      jButton_PromLocalIns.setBorder(BorderFactory.createEtchedBorder());
      jButton_PromLocalIns.setToolTipText("Inserir Linha");
      jButton_PromLocalIns.addMouseListener(new Frame_IdProm_1_jButton_PromLocalIns_mouseAdapter(this));
      jButton_PromLocalDel = new JButton(fmeComum.apagarLinha);
      jButton_PromLocalDel.setBounds(new Rectangle(747, 10, 30, 22));
      jButton_PromLocalDel.setBorder(BorderFactory.createEtchedBorder());
      jButton_PromLocalDel.setToolTipText("Apagar Linha");
      jButton_PromLocalDel.addMouseListener(new Frame_IdProm_1_jButton_PromLocalDel_mouseAdapter(this));
      
      jLabel_PromLocal = new JLabel();
      jLabel_PromLocal.setBounds(new Rectangle(11, 9, 336, 16));
      jLabel_PromLocal.setText("Localização dos Estabelecimentos do Beneficiário");
      jLabel_PromLocal.setFont(fmeComum.letra_bold);
      jPanel_PromLocal = new JPanel();
      jPanel_PromLocal.setLayout(null);
      jPanel_PromLocal.setOpaque(false);
      jPanel_PromLocal.setBounds(new Rectangle(15, this.y += h + 10, fmeApp.width - 60, this.h = 'ª'));
      jPanel_PromLocal.setBorder(fmeComum.blocoBorder);
      jPanel_PromLocal.add(jLabel_PromLocal, null);
      jPanel_PromLocal.add(jButton_PromLocalAdd, null);
      jPanel_PromLocal.add(jButton_PromLocalDel, null);
      jPanel_PromLocal.add(jButton_PromLocalIns, null);
      jPanel_PromLocal.add(getJScrollPane_PromLocal(), null);
    }
    return jPanel_PromLocal;
  }
  
  public JScrollPane getJScrollPane_PromLocal() { if (jScrollPane_PromLocal == null) {
      jScrollPane_PromLocal = new JScrollPane();
      jScrollPane_PromLocal.setBounds(new Rectangle(14, 36, fmeApp.width - 90, 121));
      jScrollPane_PromLocal.setViewportView(getJTable_PromLocal());
      jScrollPane_PromLocal.setHorizontalScrollBarPolicy(31);
      jScrollPane_PromLocal.setVerticalScrollBarPolicy(22);
    }
    
    return jScrollPane_PromLocal;
  }
  
  public JTable getJTable_PromLocal() { if (jTable_PromLocal == null) {
      jTable_PromLocal = new JTable_Tip(25, jScrollPane_PromLocal.getWidth());
      jTable_PromLocal.setRowHeight(18);
      jTable_PromLocal.setFont(fmeComum.letra);
      jTable_PromLocal.setAutoResizeMode(0);
      jTable_PromLocal.setSelectionMode(0);
      jTable_PromLocal.setName("PromLocal");
    }
    
    return jTable_PromLocal;
  }
  



  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    


    print_handler.dx_expand = (jTable_PromLocal.getWidth() - jScrollPane_PromLocal.getWidth());
    int w = jPanel_PromLocal.getWidth() + print_handler.dx_expand;
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
    CBData.Promotor.Clear();
    CBData.Contacto.Clear();
    CBData.Consultora.Clear();
    CBData.PromCae.Clear();
    if (!fmeApp.contexto.equals("toolbar"))
      CBData.PromLocal.Clear();
    if (!CBData.is_cleaning) { CBData.import_data_adc();
    }
  }
  





  public CBRegisto_Contacto cbd_contacto;
  




  public CBTabela_PromLocal cbd_promlocal;
  




  public CHValid_Grp validar_pg()
  {
    
    




    if (ConsultoragetByName"nif"v.length() == 9) {
      CBData.Consultora.get_dados_adc(ConsultoragetByName"nif"v);
    }
    
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.Promotor.validar(null, ""));
    grp.add_grp(CBData.Contacto.validar(null, ""));
    grp.add_grp(CBData.Consultora.validar(null, ""));
    grp.add_grp(CBData.PromCae.validar(null, ""));
    grp.add_grp(CBData.PromLocal.validar(null, ""));
    return grp;
  }
  
  void jButton_PromLocalAdd_mouseClicked(MouseEvent e)
  {
    cbd_promlocal.on_add_row();
  }
  
  void jButton_PromLocalDel_mouseClicked(MouseEvent e) {
    if (cbd_promlocal.del_ins_ok("Apagar")) {
      cbd_promlocal.on_del_row();
      cbd_promlocal.numerar(0);
      CTabelas.Estabs.refresh();
    }
  }
  
  void jButton_PromLocalIns_mouseClicked(MouseEvent e) {
    if (cbd_promlocal.del_ins_ok("Inserir")) {
      cbd_promlocal.on_ins_row();
      CTabelas.Estabs.refresh();
    }
  }
}
