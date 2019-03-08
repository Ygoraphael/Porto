package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Desktop;
import java.awt.Desktop.Action;
import java.awt.Dimension;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import javax.swing.BorderFactory;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JComponent;
import javax.swing.JMenuItem;
import javax.swing.JPanel;
import javax.swing.JPopupMenu;
import javax.swing.JSeparator;
import javax.swing.JTable;
import javax.swing.table.JTableHeader;
import javax.swing.table.TableCellRenderer;














































































































































































































































class JTable_Tip
  extends JTable
{
  public static final int EXCEL_FILE = 1;
  public static final int EXCEL_CLIP = 2;
  public static final int EXCEL_HELP = 4;
  public static final int EXCEL_CLIP2 = 8;
  public static final int EXCEL_CLIPS = 10;
  public static final int EXCEL_ALL = 15;
  
  public JTable_Tip()
  {
    int w = getTableHeadergetPreferredSizewidth;
    getTableHeader().setPreferredSize(new Dimension(w, 25));
    getTableHeader().setFont(fmeComum.letra);
    setRowHeight(18);
    setBorder(fmeComum.tableBodyBorderCompound);
    setFont(fmeComum.letra);
    setAutoResizeMode(0);
    setSelectionMode(0);
  }
  
  public JTable_Tip(int altura)
  {
    int w = getTableHeadergetPreferredSizewidth;
    getTableHeader().setPreferredSize(new Dimension(w, altura));
    getTableHeader().setFont(fmeComum.letra);
    setRowHeight(18);
    setBorder(fmeComum.tableBodyBorderCompound);
    setFont(fmeComum.letra);
    setAutoResizeMode(0);
    setSelectionMode(0);
  }
  

  public JTable_Tip(int altura, int largura)
  {
    getTableHeader().setPreferredSize(new Dimension(5000, altura));
    getTableHeader().setFont(fmeComum.letra);
    setRowHeight(18);
    setBorder(fmeComum.tableBodyBorderCompound);
    setFont(fmeComum.letra);
    setAutoResizeMode(0);
    setSelectionMode(0);
  }
  
  public Component prepareRenderer(TableCellRenderer renderer, int rowIndex, int vColIndex) {
    Color cinza = new Color(247, 247, 247);
    Color branco = new Color(255, 255, 255);
    
    Component c = super.prepareRenderer(renderer, rowIndex, vColIndex);
    if ((c instanceof JComponent)) {
      JComponent jc = (JComponent)c;
      jc.setToolTipText(getValueAt(rowIndex, vColIndex).toString());
      
      if ((rowIndex == getEditingRow()) && (vColIndex == getEditingColumn())) {
        jc.setBackground(branco);
      } else if (isCellSelected(rowIndex, vColIndex)) {
        jc.setBackground(fmeComum.rosa_cinza);

      }
      else if (isCellEditable(rowIndex, vColIndex)) {
        jc.setBackground(branco);
      } else {
        jc.setBackground(cinza);
      }
      jc.setForeground(Color.BLACK);
    }
    return c;
  }
  


  public void changeSelection(int rowIndex, int columnIndex, boolean toggle, boolean extend)
  {
    if ((isEditing()) && (
      (rowIndex != getEditingRow()) || (columnIndex != getEditingColumn())))
    {
      return;
    }
    
    super.changeSelection(rowIndex, columnIndex, toggle, extend);
    if (editCellAt(rowIndex, columnIndex)) {
      getEditorComponent().requestFocusInWindow();
    }
    
    if (isCellEditable(rowIndex, columnIndex)) return;
    editCellAt(rowIndex, columnIndex);
  }
  






  public void addExcelButton(JPanel jp, int left, int top) { addExcelButton(jp, left, top, 15); }
  
  public void addExcelButton(JPanel jp, int left, int top, int sel) {
    if ((sel & 0xB) == 0) return;
    SecurityManager sm = System.getSecurityManager();
    if (sm != null)
      try { if ((sel & 0xA) != 0) sm.checkSystemClipboardAccess();
        if ((sel & 0x1) != 0) sm.checkWrite("<<ALL FILES>>");
      } catch (Exception e) { return;
      }
    ExcelButton jb = new ExcelButton(sel);
    jb.setBorder(BorderFactory.createEtchedBorder());
    jb.setBounds(left, top, 30, 22);
    jb.setDisabledIcon(w_icon);
    jb.setIcon(x_icon);
    jp.add(jb);
  }
  




  private static final ImageIcon x_icon = new ImageIcon(fmeFrame.class.getResource("table_excel.png"));
  private static final ImageIcon c_icon = new ImageIcon(fmeFrame.class.getResource("copy.png"));
  private static final ImageIcon p_icon = new ImageIcon(fmeFrame.class.getResource("paste.png"));
  private static final ImageIcon p2_icon = new ImageIcon(fmeFrame.class.getResource("paste2.png"));
  private static final ImageIcon h_icon = new ImageIcon(fmeFrame.class.getResource("help.png"));
  private static final ImageIcon w_icon = new ImageIcon(fmeFrame.class.getResource("wait.gif"));
  
  class ExcelButton extends JButton { JPopupMenu popup;
    JMenuItem export;
    JMenuItem copiar;
    JMenuItem colar;
    JMenuItem colar2;
    JMenuItem ajuda;
    
    ExcelButton() { this(15); }
    
    ExcelButton(int sel) { JButton face = this;
      if (sel == 1) {
        setToolTipText("Exportar para Excel");
        addActionListener(new ActionListener() {
          public void actionPerformed(ActionEvent e) {
            CBTabela cbt = JTable_Tip.ExcelButton.this.getCBTabela();
          }
        });
      }
      else {
        popup = new JPopupMenu();
        setToolTipText("Clique para ver a lista de opções");
        addMouseListener(new MouseAdapter() {
          public void mousePressed(MouseEvent e) {
            popup.show(e.getComponent(), e.getX(), e.getY());
          }
        });
        if ((sel & 0x1) != 0) {
          export = new JMenuItem("Exportar para Excel");
          export.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
              CBTabela cbt = JTable_Tip.ExcelButton.this.getCBTabela();
            }
            
          });
          export.setFont(fmeComum.letra);
          popup.add(export);
        }
        if ((sel & 0x2) != 0) {
          copiar = new JMenuItem("Copiar o Quadro completo para o Clipboard", JTable_Tip.c_icon);
          copiar.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
              CBTabela cbt = JTable_Tip.ExcelButton.this.getCBTabela();
              if (cbt != null) cbt.on_copy_data();
            }
          });
          copiar.setFont(fmeComum.letra);
          popup.add(copiar);
          colar = new JMenuItem("Colar o Quadro completo do Clipboard", JTable_Tip.p_icon);
          colar.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
              CBTabela cbt = JTable_Tip.ExcelButton.this.getCBTabela();
              if (cbt != null) cbt.on_paste_data();
            }
          });
          colar.setFont(fmeComum.letra);
          popup.add(colar);
        }
        if ((sel & 0x8) != 0) {
          colar2 = new JMenuItem("Colar parte do Quadro do Clipboard", JTable_Tip.p2_icon);
          colar2.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
              CBTabela cbt = JTable_Tip.ExcelButton.this.getCBTabela();
              if (cbt != null) cbt.on_paste_data2();
            }
          });
          colar2.setFont(fmeComum.letra);
          popup.add(colar2);
        }
        if (((sel & 0x4) != 0) && (Desktop.isDesktopSupported()) && 
          (Desktop.getDesktop().isSupported(Desktop.Action.BROWSE))) {
          popup.add(new JSeparator());
          ajuda = new JMenuItem("Ajuda", JTable_Tip.h_icon);
          ajuda.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
              CMsgInfo m = new CMsgInfo("ajuda_xls.html");
              m.setSize(new Dimension(550, 450));
              m.setLocation(getDefaultToolkitgetScreenSizewidth / 2 - getSizewidth / 2, 
                getDefaultToolkitgetScreenSizeheight / 2 - getSizeheight / 2);
              m.show();
            }
          });
          ajuda.setFont(fmeComum.letra);
          popup.add(ajuda);
        }
      }
    }
    
    private CBTabela getCBTabela() { return (getModel() instanceof CHTabela) ? 
        getModel()).d : null;
    }
  }
}
