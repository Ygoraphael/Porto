package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Container;
import java.awt.Cursor;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.ImageIcon;
import javax.swing.JCheckBox;
import javax.swing.JComponent;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;
import javax.swing.JTextField;
import javax.swing.border.CompoundBorder;
import javax.swing.border.EmptyBorder;




















public class Frame_Uploads
  extends JInternalFrame
  implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private CompoundBorder docBorder;
  
  private JLabel jLabel_P16 = null;
  private JLabel jLabel_PT2020 = null;
  
  private JPanel jPanel_Visto = null;
  private JLabel jLabel_Visto = null;
  private JCheckBox jCheckBox_Visto = null;
  
  private JLabel jLabel_Doc = null;
  private JLabel jLabel_Chk = null;
  private JLabel jLabel_Upld = null;
  
  private JPanel jPanel_Documentos = null;
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_Aplic = null;
  private JLabel jLabel_File = null;
  
  public JCheckBox jCheckBox_Aplicavel_1 = null;
  public JCheckBox jCheckBox_Aplicavel_1_Clear = new JCheckBox();
  public JCheckBox jCheckBox_Upload_1 = null;
  public JCheckBox jCheckBox_Upload_1_Clear = new JCheckBox();
  public JTextField jTextField_FileUpld_1 = null;
  public JTextField jTextField_FileSrvUpld_1 = null;
  
  public JCheckBox jCheckBox_Aplicavel_2 = null;
  public JCheckBox jCheckBox_Aplicavel_2_Clear = new JCheckBox();
  public JCheckBox jCheckBox_Upload_2 = null;
  public JCheckBox jCheckBox_Upload_2_Clear = new JCheckBox();
  public JTextField jTextField_FileUpld_2 = null;
  public JTextField jTextField_FileSrvUpld_2 = null;
  
  public JCheckBox jCheckBox_Aplicavel_3 = null;
  public JCheckBox jCheckBox_Aplicavel_3_Clear = new JCheckBox();
  public JCheckBox jCheckBox_Upload_3 = null;
  public JCheckBox jCheckBox_Upload_3_Clear = new JCheckBox();
  public JTextField jTextField_FileUpld_3 = null;
  public JTextField jTextField_FileSrvUpld_3 = null;
  
  public JCheckBox jCheckBox_Aplicavel_4 = null;
  public JCheckBox jCheckBox_Aplicavel_4_Clear = new JCheckBox();
  public JCheckBox jCheckBox_Upload_4 = null;
  public JCheckBox jCheckBox_Upload_4_Clear = new JCheckBox();
  public JTextField jTextField_FileUpld_4 = null;
  public JTextField jTextField_FileSrvUpld_4 = null;
  
  public JCheckBox jCheckBox_Aplicavel_5 = null;
  public JCheckBox jCheckBox_Aplicavel_5_Clear = new JCheckBox();
  public JCheckBox jCheckBox_Upload_5 = null;
  public JCheckBox jCheckBox_Upload_5_Clear = new JCheckBox();
  public JTextField jTextField_FileUpld_5 = null;
  public JTextField jTextField_FileSrvUpld_5 = null;
  
  private JPanel jPanel_Obs = null;
  private JLabel jLabel_Obs = null;
  private JScrollPane jScrollPane_Obs = null;
  private JTextArea jTextArea_Obs = null;
  
  String tag = "";
  
  int h = 0;
  
  int y = 0;
  String uploads;
  private HashMap _params;
  
  public Frame_Uploads()
  {
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
  
  public void update_icon(String tag, String aplicavel, String v) {
    for (JPanel jp : new JPanel[] { jPanel_Documentos, jPanel_Documentos }) {
      Component[] component = jp.getComponents();
      for (int i = 0; i < component.length; i++) {
        if ((component[i] instanceof JLabel)) {
          JLabel l = (JLabel)component[i];
          if ((l.getName() != null) && (l.getName().equals("label_" + tag))) {
            l.setIcon(null);
            if (!aplicavel.equals("S")) return;
            if (v.equals("S")) {
              l.setIcon(new ImageIcon(fmeFrame.class.getResource("green.png")));
            } else
              l.setIcon(new ImageIcon(fmeFrame.class.getResource("red.png")));
            return;
          }
        }
      }
    }
  }
  
  private int stack(JComponent jc) {
    return jc.getY() + jc.getHeight() + 10;
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
    if (jContentPane == null)
    {
      jLabel_PT2020 = new Label2020();
      
      docBorder = new CompoundBorder(fmeComum.fieldBorder, new EmptyBorder(10, 10, 10, 10));
      
      jLabel_P16 = new JLabel();
      jLabel_P16.setBounds(new Rectangle(15, 10, 540, 30));
      jLabel_P16.setText("   DOCUMENTAÇÃO A APRESENTAR");
      jLabel_P16.setFont(fmeComum.letra_titulo);
      jLabel_P16.setBorder(fmeComum.blocoBorder);
      jContentPane = new JPanel();
      
      jContentPane.setOpaque(false);
      jContentPane.setLayout(null);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_P16, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_Visto(), null);
      jContentPane.add(getJPanel_Documentos(), null);
      jContentPane.add(getJPanel_Obs(), null);
      h = stack(jPanel_Obs);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_Visto() {
    if (jPanel_Visto == null)
    {
      jPanel_Visto = new JPanel();
      jPanel_Visto.setOpaque(false);
      jPanel_Visto.setLayout(null);
      jPanel_Visto.setBorder(fmeComum.blocoBorder);
      
      jLabel_Visto = new JLabel();
      jLabel_Visto.setBounds(new Rectangle(12, 15, 520, 18));
      jLabel_Visto.setText("Tomei conhecimento e declaro estar em condições de enviar os elementos assinalados via upload");
      jLabel_Visto.setFont(fmeComum.letra);
      
      jPanel_Visto.add(jLabel_Visto, null);
      jPanel_Visto.add(getJCheckBox_Visto(), null);
      
      jPanel_Visto.setBounds(new Rectangle(15, 50, fmeApp.width - 60, 48));
    }
    return jPanel_Visto;
  }
  
  public JCheckBox getJCheckBox_Visto() {
    if (jCheckBox_Visto == null) {
      jCheckBox_Visto = new JCheckBox();
      jCheckBox_Visto.setOpaque(false);
      jCheckBox_Visto.setBounds(new Rectangle(718, 10, 50, 28));
      jCheckBox_Visto.setHorizontalAlignment(0);
    }
    return jCheckBox_Visto;
  }
  
  private JPanel getJPanel_Documentos() {
    if (jPanel_Documentos == null)
    {
      jPanel_Documentos = new JPanel();
      jPanel_Documentos.setOpaque(false);
      jPanel_Documentos.setLayout(null);
      jPanel_Documentos.setBorder(fmeComum.blocoBorder);
      
      String titulo = "<html><strong>Deverá submeter os documentos abaixo indicados quando aplicável.</strong><br><br><strong><u>Atenção</u></strong>:<br>Caso seja necessário submeter informação suplementar e se esta for constituída por mais do que um documento, então esta deverá ser agrupada num único ficheiro a submeter.<br>Se não for respeitado este procedimento, cada nova submissão substituirá o ficheiro anterior.</html>";
      





      jLabel_Titulo = new JLabel();
      jLabel_Titulo.setBounds(new Rectangle(12, 10, 760, 90));
      jLabel_Titulo.setText(titulo);
      jLabel_Titulo.setFont(fmeComum.letra);
      
      jLabel_Aplic = new JLabel();
      jLabel_Aplic.setBounds(new Rectangle(669, 108, 50, 25));
      jLabel_Aplic.setText("Aplicável");
      jLabel_Aplic.setHorizontalAlignment(0);
      jLabel_Aplic.setFont(fmeComum.letra);
      
      jLabel_File = new JLabel();
      jLabel_File.setBounds(new Rectangle(718, 108, 50, 25));
      jLabel_File.setText("Ficheiro");
      jLabel_File.setHorizontalAlignment(0);
      jLabel_File.setFont(fmeComum.letra);
      
      jPanel_Documentos.add(jLabel_Titulo, null);
      jPanel_Documentos.add(jLabel_Aplic, null);
      jPanel_Documentos.add(jLabel_File, null);
      
      int h = 1;
      y = 130;
      
      uploads = (CParseConfig.hconfig.get("uploads") == null ? "" : CParseConfig.hconfig.get("uploads").toString());
      

      if ("01".matches(uploads)) {
        jLabel_Doc = getJLabel_Doc(this.y += h - 1, h = 73);
        jLabel_Doc.setText("<html><strong>" + getDocN("01") + " - </strong>Apresentar o documento que legitima a empresa a executar o investimento e explorar o empreendimento/estabelecimento/ animação (exemplo: contrato de compra e venda, contrato de arrendamento, contrato de comodato…).</html>");
        jLabel_Chk = getJLabel_Chk(y, h);
        jLabel_Upld = getJLabel_Upld(y, h, "01");
        jCheckBox_Aplicavel_1 = getJCheckBox_Aplic(y, h, "01");
        jCheckBox_Upload_1 = getJCheckBox_File(y, h);
        jTextField_FileUpld_1 = getJTextField_File(y + h, "01");
        jTextField_FileSrvUpld_1 = getJTextField_FileSrv(y + h);
        jPanel_Documentos.add(jLabel_Doc, null);
        jPanel_Documentos.add(jLabel_Chk, null);
        jPanel_Documentos.add(jLabel_Upld, null);
        jPanel_Documentos.add(jCheckBox_Aplicavel_1, null);
        jPanel_Documentos.add(jCheckBox_Upload_1, null);
        jPanel_Documentos.add(jTextField_FileUpld_1, null);
        jPanel_Documentos.add(jTextField_FileSrvUpld_1, null);
      }
      
      if ("02".matches(uploads)) {
        jLabel_Doc = getJLabel_Doc(this.y += h - 1, h = 73);
        jLabel_Doc.setText("<html><strong>" + getDocN("02") + " - </strong>Apresentar o estudo de viabilidade económico-financeira que suporta os dados constantes das Demonstrações de Resultados e Balanços Previsionais.</html>");
        jLabel_Chk = getJLabel_Chk(y, h);
        jLabel_Upld = getJLabel_Upld(y, h, "02");
        jCheckBox_Aplicavel_2 = getJCheckBox_Aplic(y, h, "02");
        jCheckBox_Upload_2 = getJCheckBox_File(y, h);
        jTextField_FileUpld_2 = getJTextField_File(y + h, "02");
        jTextField_FileSrvUpld_2 = getJTextField_FileSrv(y + h);
        jPanel_Documentos.add(jLabel_Doc, null);
        jPanel_Documentos.add(jLabel_Chk, null);
        jPanel_Documentos.add(jLabel_Upld, null);
        jPanel_Documentos.add(jCheckBox_Aplicavel_2, null);
        jPanel_Documentos.add(jCheckBox_Upload_2, null);
        jPanel_Documentos.add(jTextField_FileUpld_2, null);
        jPanel_Documentos.add(jTextField_FileSrvUpld_2, null);
      }
      
      if ("03".matches(uploads)) {
        jLabel_Doc = getJLabel_Doc(this.y += h - 1, h = 73);
        jLabel_Doc.setText("<html><strong>" + getDocN("03") + " - </strong>Caso aplicável à presente candidatura, e para aferir o rácio de autonomia financeira, conforme previsto no n.º 4 do Anexo C do RECI, apresentar o balanço intercalar certificado por um ROC, não sendo admitido exame simplificado.</html>");
        jLabel_Chk = getJLabel_Chk(y, h);
        jLabel_Upld = getJLabel_Upld(y, h, "03");
        jCheckBox_Aplicavel_3 = getJCheckBox_Aplic(y, h);
        jCheckBox_Upload_3 = getJCheckBox_File(y, h);
        jTextField_FileUpld_3 = getJTextField_File(y + h, "03");
        jTextField_FileSrvUpld_3 = getJTextField_FileSrv(y + h);
        jPanel_Documentos.add(jLabel_Doc, null);
        jPanel_Documentos.add(jLabel_Chk, null);
        jPanel_Documentos.add(jLabel_Upld, null);
        jPanel_Documentos.add(jCheckBox_Aplicavel_3, null);
        jPanel_Documentos.add(jCheckBox_Upload_3, null);
        jPanel_Documentos.add(jTextField_FileUpld_3, null);
        jPanel_Documentos.add(jTextField_FileSrvUpld_3, null);
      }
      
      if ("04".matches(uploads)) {
        jLabel_Doc = getJLabel_Doc(this.y += h - 1, h = 59);
        jLabel_Doc.setText("<html><strong>" + getDocN("04") + " - </strong>Apresentar o Balanço Social referente ao ano pré-projeto.</html>");
        jLabel_Chk = getJLabel_Chk(y, h);
        jLabel_Upld = getJLabel_Upld(y, h, "04");
        jCheckBox_Aplicavel_4 = getJCheckBox_Aplic(y, h);
        jCheckBox_Upload_4 = getJCheckBox_File(y, h);
        jTextField_FileUpld_4 = getJTextField_File(y + h, "04");
        jTextField_FileSrvUpld_4 = getJTextField_FileSrv(y + h);
        jPanel_Documentos.add(jLabel_Doc, null);
        jPanel_Documentos.add(jLabel_Chk, null);
        jPanel_Documentos.add(jLabel_Upld, null);
        jPanel_Documentos.add(jCheckBox_Aplicavel_4, null);
        jPanel_Documentos.add(jCheckBox_Upload_4, null);
        jPanel_Documentos.add(jTextField_FileUpld_4, null);
        jPanel_Documentos.add(jTextField_FileSrvUpld_4, null);
      }
      
      if ("05".matches(uploads)) {
        jLabel_Doc = getJLabel_Doc(this.y += h - 1, h = 59);
        jLabel_Doc.setText("<html><strong>" + getDocN("05") + " - </strong>No caso de ainda não existirem IES relativas ao ano de " + (_lib.to_int(CParseConfig.hconfig.get("ano_cand").toString()) - 1) + ", submeter Relatório e Contas aprovadas de " + (_lib.to_int(CParseConfig.hconfig.get("ano_cand").toString()) - 1) + ".</html>");
        jLabel_Chk = getJLabel_Chk(y, h);
        jLabel_Upld = getJLabel_Upld(y, h, "05");
        jCheckBox_Aplicavel_5 = getJCheckBox_Aplic(y, h, "05");
        jCheckBox_Upload_5 = getJCheckBox_File(y, h);
        jTextField_FileUpld_5 = getJTextField_File(y + h, "05");
        jTextField_FileSrvUpld_5 = getJTextField_FileSrv(y + h);
        jPanel_Documentos.add(jLabel_Doc, null);
        jPanel_Documentos.add(jLabel_Chk, null);
        jPanel_Documentos.add(jLabel_Upld, null);
        jPanel_Documentos.add(jCheckBox_Aplicavel_5, null);
        jPanel_Documentos.add(jCheckBox_Upload_5, null);
        jPanel_Documentos.add(jTextField_FileUpld_5, null);
        jPanel_Documentos.add(jTextField_FileSrvUpld_5, null);
      }
      
      jPanel_Documentos.setBounds(new Rectangle(15, stack(getJPanel_Visto()), fmeApp.width - 60, this.y += h - 1 + 20));
    }
    return jPanel_Documentos;
  }
  
  private JPanel getJPanel_Obs() {
    if (jPanel_Obs == null) {
      jLabel_Obs = new JLabel();
      jLabel_Obs.setBounds(new Rectangle(14, 8, 609, 20));
      jLabel_Obs.setText("Observações");
      jLabel_Obs.setFont(fmeComum.letra_bold);
      
      jPanel_Obs = new JPanel();
      jPanel_Obs.setLayout(null);
      jPanel_Obs.setOpaque(false);
      jPanel_Obs.setBounds(new Rectangle(15, stack(getJPanel_Documentos()), fmeApp.width - 60, 200));
      jPanel_Obs.setBorder(fmeComum.blocoBorder);
      jPanel_Obs.setName("cond_eleg_texto");
      jPanel_Obs.add(jLabel_Obs, null);
      jPanel_Obs.add(getJScrollPane_Pos_Proj(), null);
    }
    return jPanel_Obs;
  }
  
  public JScrollPane getJScrollPane_Pos_Proj() {
    if (jScrollPane_Obs == null) {
      jScrollPane_Obs = new JScrollPane();
      jScrollPane_Obs.setBounds(new Rectangle(15, 35, 759, 150));
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
    }
    return jTextArea_Obs;
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    

    print_handler.scaleToWidth((int)(1.05D * jPanel_Documentos.getWidth()));
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
    CBData.Uploads.Clear();
    CBData.Uploads.update_aplicaveis();
    CBData.Uploads.after_open();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.Uploads.validar(null));
    return grp;
  }
  
  public JTextField getJTextField_File(int y, final String ref) {
    JTextField field = new JTextField();
    field.setBounds(new Rectangle(new Rectangle(20, y - 20, 650, 20)));
    field.setHorizontalAlignment(4);
    field.setForeground(new Color(0, 88, 176));
    field.setText("");
    field.setFocusable(false);
    field.setOpaque(false);
    field.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 5));
    
    field.addMouseListener(new MouseAdapter() {
      public void mouseClicked(MouseEvent e) {
        if (!CBData.T.equals("")) return;
        if (((JTextField)e.getComponent()).getText().equals("")) return;
        fmeApp.comum.download_ie(ref);
      }
      
      public void mouseEntered(MouseEvent e) { if (!CBData.T.equals("")) return;
        if (((JTextField)e.getComponent()).getText().equals("")) return;
        setCursor(Cursor.getPredefinedCursor(12));
        ((JTextField)e.getComponent()).setToolTipText("Download do ficheiro");
        e.getComponent().setBackground(Color.LIGHT_GRAY);
      }
      
      public void mouseExited(MouseEvent e) { setCursor(Cursor.getPredefinedCursor(0));
        e.getComponent().setBackground(Color.WHITE);
      }
    });
    return field;
  }
  
  public JTextField getJTextField_FileSrv(int y) {
    JTextField field = getJTextField_File(y - 20, "");
    field.setVisible(false);
    return field;
  }
  

  public JCheckBox getJCheckBox_Aplic(int y, int h) { return getJCheckBox_Aplic(y, h, null); }
  
  public JCheckBox getJCheckBox_Aplic(int y, int h, final String ref) {
    JCheckBox check = new JCheckBox();
    check.setOpaque(false);
    check.setEnabled(ref != null);
    check.setBounds(new Rectangle(669, y, 50, h));
    check.setHorizontalAlignment(0);
    if (check.isEnabled()) {
      check.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          if ((CBData.Uploads != null) && (Uploadsstarted)) {
            CBData.Uploads.getByName("aplicavel_" + ref).vldOnline();
            CBData.Uploads.getByName("upload_" + ref).vldOnline();
          }
        }
      });
    }
    return check;
  }
  
  public JCheckBox getJCheckBox_File(int y, int h) { JCheckBox check = new JCheckBox();
    check.setOpaque(false);
    check.setEnabled(false);
    check.setVisible(false);
    check.setBounds(new Rectangle(754, y, 50, h));
    check.setHorizontalAlignment(0);
    return check;
  }
  
  public JLabel getJLabel_Doc(int y, int h) { JLabel label = new JLabel();
    label.setBounds(new Rectangle(20, y, 650, h));
    label.setBorder(docBorder);
    label.setVerticalAlignment(1);
    return label;
  }
  
  public JLabel getJLabel_Chk(int y, int h) { JLabel label = new JLabel();
    label.setBounds(new Rectangle(669, y, 50, h));
    label.setBorder(docBorder);
    label.setVerticalAlignment(1);
    return label;
  }
  
  public JLabel getJLabel_Upld(int y, int h, final String ref) {
    JLabel label = new JLabel();
    label.setBounds(new Rectangle(718, y, 50, h));
    label.setBorder(docBorder);
    label.setHorizontalAlignment(0);
    label.setName("label_upload_" + ref);
    label.setOpaque(true);
    label.setBackground(Color.WHITE);
    label.addMouseListener(new MouseAdapter() {
      public void mouseClicked(MouseEvent e) {
        if (!CBData.T.equals("")) return;
        fmeApp.comum.upload(ref);
      }
      
      public void mouseEntered(MouseEvent e) { if (!CBData.T.equals("")) return;
        if (((JLabel)e.getComponent()).getIcon() == null) return;
        setCursor(Cursor.getPredefinedCursor(12));
        ((JLabel)e.getComponent()).setToolTipText("Upload do ficheiro");
        e.getComponent().setBackground(Color.LIGHT_GRAY);
      }
      
      public void mouseExited(MouseEvent e) { setCursor(Cursor.getPredefinedCursor(0));
        e.getComponent().setBackground(Color.WHITE);
      }
    });
    return label;
  }
  





  Integer getDocN(String interno)
  {
    int p = uploads.indexOf(interno);
    return p == -1 ? null : Integer.valueOf(p / 3 + 1);
  }
}
