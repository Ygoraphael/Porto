package fme;

import java.awt.Component;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Rectangle;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.awt.print.PageFormat;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.event.ListSelectionEvent;


public class Frame_DR_SNC
  extends JInternalFrame
  implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JLabel jLabel_Titulo = null;
  private JLabel jLabel_PT2020 = null;
  private JLabel jLabel_Nota = null;
  
  private JPanel jPanel_DR_SNC = null;
  private JLabel jLabel_DR_SNC = null;
  private JScrollPane jScrollPane_DR_SNC = null;
  private JTable_Tip jTable_DR_SNC = null;
  private JScrollPane jScrollPane_DR_SNC_Fixed = null;
  private JTable_Tip jTable_DR_SNC_Fixed = null;
  
  String tag = "";
  
  public Frame_DR_SNC()
  {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(925, 693);
  }
  
  int n_anos = 3;
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
    if (params.get("n_anos") != null)
      n_anos = Integer.parseInt((String)params.get("n_anos"));
  }
  
  void up_component(Component c, int n) {
    Rectangle r = c.getBounds();
    y -= n;
    c.setBounds(r);
  }
  
  public void tirar_titulo() {
    jLabel_Titulo.setVisible(false);
    jLabel_PT2020.setVisible(false);
    up_component(jPanel_DR_SNC, 40);
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
      
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setOpaque(false);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(jLabel_Titulo, null);
      jContentPane.add(jLabel_PT2020, null);
      jContentPane.add(getJPanel_DR_SNC(), null);
    }
    return jContentPane;
  }
  
  private JPanel getJPanel_DR_SNC() {
    if (jPanel_DR_SNC == null)
    {
      jLabel_DR_SNC = new JLabel();
      jLabel_DR_SNC.setBounds(new Rectangle(12, 10, 541, 18));
      jLabel_DR_SNC.setText("<html>Demonstrações de Resultados Históricas e Previsionais</html>");
      jLabel_DR_SNC.setFont(fmeComum.letra_bold);
      
      jLabel_Nota = new JLabel();
      jLabel_Nota.setBounds(new Rectangle(15, 611, 366, 18));
      jLabel_Nota.setText("(*) utilização exclusiva pelas pequenas entidades e microentidades");
      jLabel_Nota.setFont(fmeComum.letra);
      
      jPanel_DR_SNC = new JPanel();
      jPanel_DR_SNC.setLayout(null);
      jPanel_DR_SNC.setOpaque(false);
      jPanel_DR_SNC.setBounds(new Rectangle(15, 50, 900, 635));
      jPanel_DR_SNC.setBorder(fmeComum.blocoBorder);
      jPanel_DR_SNC.add(jLabel_DR_SNC, null);
      jPanel_DR_SNC.add(getJScrollPane_DR_SNC_Fixed(), null);
      jPanel_DR_SNC.add(getJScrollPane_DR_SNC(), null);
      jPanel_DR_SNC.add(jLabel_Nota, null);
    }
    return jPanel_DR_SNC;
  }
  
  public JScrollPane getJScrollPane_DR_SNC_Fixed() {
    if (jScrollPane_DR_SNC_Fixed == null) {
      jScrollPane_DR_SNC_Fixed = new JScrollPane();
      jScrollPane_DR_SNC_Fixed.setBounds(new Rectangle(16, 36, 384, 569));
      jScrollPane_DR_SNC_Fixed.setViewportView(getJTable_DR_SNC_Fixed());
      jScrollPane_DR_SNC_Fixed.setHorizontalScrollBarPolicy(31);
      jScrollPane_DR_SNC_Fixed.setName("DR_SNCF_ScrollPane");
    }
    

    return jScrollPane_DR_SNC_Fixed;
  }
  
  public JScrollPane getJScrollPane_DR_SNC() {
    if (jScrollPane_DR_SNC == null) {
      jScrollPane_DR_SNC = new JScrollPane();
      jScrollPane_DR_SNC.setBounds(new Rectangle(397, 36, 490, 586));
      jScrollPane_DR_SNC.setViewportView(getJTable_DR_SNC());
      jScrollPane_DR_SNC.setName("DR_SNC_ScrollPane");
    }
    







    return jScrollPane_DR_SNC;
  }
  
  public JTable getJTable_DR_SNC_Fixed() {
    if (jTable_DR_SNC_Fixed == null) {
      jTable_DR_SNC_Fixed = new JTable_Tip(25, jScrollPane_DR_SNC_Fixed.getWidth()) {
        public void valueChanged(ListSelectionEvent e) {
          super.valueChanged(e);
          Frame_DR_SNC.this.checkSelection(true);
        }
      };
      jTable_DR_SNC_Fixed.addMouseListener(new MouseAdapter() {
        public void mouseClicked(MouseEvent e) {
          DR_SNChandler.__garbage_stop_editing();
          DR_SNCon_fixed_buddy = true;
        }
        
      });
      jTable_DR_SNC_Fixed.setName("DR_SNCF_Tabela");
      jTable_DR_SNC_Fixed.setRowHeight(18);
      jTable_DR_SNC_Fixed.setFont(fmeComum.letra);
      jTable_DR_SNC_Fixed.setAutoResizeMode(0);
      jTable_DR_SNC_Fixed.setSelectionMode(0);
    }
    return jTable_DR_SNC_Fixed;
  }
  
  public JTable getJTable_DR_SNC() { if (jTable_DR_SNC == null) {
      jTable_DR_SNC = new JTable_Tip(25, jScrollPane_DR_SNC.getWidth()) {
        public void valueChanged(ListSelectionEvent e) {
          super.valueChanged(e);
          Frame_DR_SNC.this.checkSelection(false);
        }
      };
      jTable_DR_SNC.addMouseListener(new MouseAdapter() {
        public void mouseClicked(MouseEvent e) {
          DR_SNCon_fixed_buddy = false;
        }
        
      });
      jTable_DR_SNC.addExcelButton(jPanel_DR_SNC, 857, 10, 14);
      jTable_DR_SNC.setName("DR_SNC_Tabela");
      jTable_DR_SNC.setRowHeight(18);
      jTable_DR_SNC.setFont(fmeComum.letra);
      jTable_DR_SNC.setAutoResizeMode(0);
      jTable_DR_SNC.setSelectionMode(0);
    }
    return jTable_DR_SNC;
  }
  
  private void checkSelection(boolean isFixedTable) {
    int fixedSelectedIndex = jTable_DR_SNC_Fixed.getSelectedRow();
    int selectedIndex = jTable_DR_SNC.getSelectedRow();
    if (fixedSelectedIndex != selectedIndex) {
      if (isFixedTable) {
        jTable_DR_SNC.setRowSelectionInterval(fixedSelectedIndex, fixedSelectedIndex);
      } else {
        jTable_DR_SNC_Fixed.setRowSelectionInterval(selectedIndex, selectedIndex);
      }
    }
  }
  
  void on_resize() {
    int pw = getContentPane().getWidth();
    int org = 640;
    int margem_x = jPanel_DR_SNC.getX();
    int i_margem_x = jScrollPane_DR_SNC.getX();
    int max = jTable_DR_SNC.getWidth() + i_margem_x + 20;
    

    int w;
    

    int w;
    

    if (pw > org + 2 * margem_x) {
      int dw = pw - (org + 2 * margem_x);
      w = org + dw > max ? max : org + dw;
    } else {
      w = org;
    }
    

    jPanel_DR_SNC.setBounds(jPanel_DR_SNC.getX(), jPanel_DR_SNC.getY(), w, 
      jPanel_DR_SNC.getHeight());
    jScrollPane_DR_SNC.setBounds(jScrollPane_DR_SNC.getX(), jScrollPane_DR_SNC.getY(), 
      w - i_margem_x - 20, jScrollPane_DR_SNC.getHeight());
  }
  
  public void print_page()
  {
    String caption = fmeApp.Paginas.getCaption(tag);
    
    print_handler = new CHPrint(this);
    print_handler.start();
    print_handler.setOrientation(0);
    
    print_handler.dx_expand = (jTable_DR_SNC.getWidth() - jScrollPane_DR_SNC.getWidth());
    int w = jPanel_DR_SNC.getWidth() + print_handler.dx_expand;
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
    CBData.DR_SNC.Clear();
  }
  
  public CHValid_Grp validar_pg() {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.DR_SNC.validar(null, ""));
    return grp;
  }
}
