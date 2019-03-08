package fme;

import java.awt.Component;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Rectangle;
import java.awt.event.AdjustmentListener;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollBar;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.event.ListSelectionEvent;

public class Frame_Balanco_SNC extends JInternalFrame implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  private JLabel jLabel_Nota = null;
  
  private JPanel jPanel_Balanco = null;
  private JLabel jLabel_Balanco = null;
  private JScrollPane jScrollPane_Balanco_Fixed = null;
  private JScrollPane jScrollPane_Balanco = null;
  private JTable_Tip jTable_Balanco_Fixed = null;
  private JTable_Tip jTable_Balanco = null;
  
  String tag = "";
  
  public Frame_Balanco_SNC()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(925, 1322);
  }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void tirar_titulo() {
    jLabel_Titulo.setVisible(false);
    jLabel_PT2020.setVisible(false);
    up_component(jPanel_Balanco, 40);
  }
  
  int n_anos = 4;
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (params.get("n_anos") != null) {
      n_anos = Integer.parseInt((String)params.get("n_anos"));
    }
  }
  
  private void initialize() {
    setSize(1500, 1500);
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
      
      jLabel_Nota = new JLabel();
      jLabel_Nota.setText("(*) utilização exclusiva pelas pequenas entidades e microentidades");
      jLabel_Nota.setBounds(new Rectangle(15, 1238, 366, 18));
      jLabel_Nota.setFont(fmeComum.letra);
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setBorder(javax.swing.BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_Balanco(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_Balanco() {
    if (jPanel_Balanco == null)
    {
      jLabel_Balanco = new JLabel();
      jLabel_Balanco.setBounds(new Rectangle(12, 10, 541, 18));
      jLabel_Balanco.setText("<html>Balanços Históricos e Previsionais</html>");
      jLabel_Balanco.setFont(fmeComum.letra_bold);
      
      jPanel_Balanco = new JPanel();
      jPanel_Balanco.setLayout(null);
      jPanel_Balanco.setBounds(new Rectangle(15, 50, 900, 1262));
      jPanel_Balanco.setBorder(fmeComum.blocoBorder);
      jPanel_Balanco.add(jLabel_Balanco, null);
      jPanel_Balanco.add(getJScrollPane_Balanco_Fixed(), null);
      jPanel_Balanco.add(getJScrollPane_Balanco(), null);
      jPanel_Balanco.add(jLabel_Nota, null);
    }
    return jPanel_Balanco;
  }
  
  public JScrollPane getJScrollPane_Balanco_Fixed() {
    if (jScrollPane_Balanco_Fixed == null) {
      jScrollPane_Balanco_Fixed = new JScrollPane();
      jScrollPane_Balanco_Fixed.setBounds(new Rectangle(16, 36, 325, 1181));
      jScrollPane_Balanco_Fixed.setViewportView(getJTable_Balanco_Fixed());
      jScrollPane_Balanco_Fixed.setName("BalancoF_ScrollPane");
      jScrollPane_Balanco_Fixed.setHorizontalScrollBarPolicy(31);
    }
    








    return jScrollPane_Balanco_Fixed;
  }
  
  public JScrollPane getJScrollPane_Balanco() { if (jScrollPane_Balanco == null) {
      jScrollPane_Balanco = new JScrollPane();
      jScrollPane_Balanco.setBounds(new Rectangle(338, 36, 551, 1198));
      jScrollPane_Balanco.setViewportView(getJTable_Balanco());
      jScrollPane_Balanco.setName("Balanco_ScrollPane");
      


      AdjustmentListener listener = new MyAdjustmentListener();
      jScrollPane_Balanco.getHorizontalScrollBar().addAdjustmentListener(listener);
    }
    







    return jScrollPane_Balanco;
  }
  
  public JTable getJTable_Balanco_Fixed() {
    if (jTable_Balanco_Fixed == null) {
      jTable_Balanco_Fixed = new JTable_Tip(25, jScrollPane_Balanco_Fixed.getWidth()) {
        public void valueChanged(ListSelectionEvent e) {
          super.valueChanged(e);
          Frame_Balanco_SNC.this.checkSelection(true);
        }
      };
      jTable_Balanco_Fixed.addMouseListener(new MouseAdapter() {
        public void mouseClicked(MouseEvent e) {
          Balanco_SNChandler.__garbage_stop_editing();
          Balanco_SNCon_fixed_buddy = true;
        }
      });
      jTable_Balanco_Fixed.setName("BalancoF_Tabela");
      jTable_Balanco_Fixed.setRowHeight(18);
      jTable_Balanco_Fixed.setFont(fmeComum.letra);
      jTable_Balanco_Fixed.setAutoResizeMode(0);
      jTable_Balanco_Fixed.setSelectionMode(0);
    }
    return jTable_Balanco_Fixed;
  }
  
  public JTable getJTable_Balanco() { if (jTable_Balanco == null) {
      jTable_Balanco = new JTable_Tip(25, jScrollPane_Balanco.getWidth()) {
        public void valueChanged(ListSelectionEvent e) {
          super.valueChanged(e);
          Frame_Balanco_SNC.this.checkSelection(false);
        }
      };
      jTable_Balanco.addMouseListener(new MouseAdapter() {
        public void mouseClicked(MouseEvent e) {
          Balanco_SNCon_fixed_buddy = false;
        }
      });
      jTable_Balanco.addExcelButton(jPanel_Balanco, 600, 10, 14);
      jTable_Balanco.setName("Balanco_Tabela");
      jTable_Balanco.setRowHeight(18);
      jTable_Balanco.setFont(fmeComum.letra);
      jTable_Balanco.setAutoResizeMode(0);
      jTable_Balanco.setSelectionMode(0);
    }
    return jTable_Balanco;
  }
  
  private void checkSelection(boolean isFixedTable) { int fixedSelectedIndex = jTable_Balanco_Fixed.getSelectedRow();
    int selectedIndex = jTable_Balanco.getSelectedRow();
    if (fixedSelectedIndex != selectedIndex) {
      if (isFixedTable) {
        jTable_Balanco.setRowSelectionInterval(fixedSelectedIndex, fixedSelectedIndex);
      } else {
        jTable_Balanco_Fixed.setRowSelectionInterval(selectedIndex, selectedIndex);
      }
    }
  }
  



















































  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    
    print_handler.dx_expand = (jTable_Balanco.getWidth() - jScrollPane_Balanco.getWidth());
    int w = jPanel_Balanco.getWidth() + print_handler.dx_expand;
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
    CBData.Balanco_SNC.Clear();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.Balanco_SNC.validar(null, ""));
    return grp;
  }
}
