package fme;

import java.awt.Component;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Rectangle;
import java.util.Enumeration;
import java.util.Hashtable;
import java.util.Vector;
import javax.swing.CellRendererPane;
import javax.swing.JComponent;
import javax.swing.JLabel;
import javax.swing.JTable;
import javax.swing.UIManager;
import javax.swing.plaf.basic.BasicTableHeaderUI;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.JTableHeader;
import javax.swing.table.TableCellRenderer;
import javax.swing.table.TableColumn;
import javax.swing.table.TableColumnModel;








































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class GroupableTableHeaderUI
  extends BasicTableHeaderUI
{
  JTable t;
  public int H;
  int[] col_width;
  
  GroupableTableHeaderUI() {}
  
  public Vector hcols = new Vector();
  
  public void setH(int h, JTable t) {
    this.t = t;
    H = h;
  }
  
  public void add_col(int ix, int iy, int dx, int dy, String tag) { Col c = new Col();
    ix = ix;iy = iy;
    dx = dx;dy = dy;
    tag = tag;
    hcols.add(c);
  }
  

  public void paint(Graphics g, JComponent c)
  {
    Enumeration enumeration = t.getColumnModel().getColumns();
    col_width = new int[t.getColumnModel().getColumnCount() + 1];
    col_width[0] = 0;
    int n = 1;int width = 0;
    while (enumeration.hasMoreElements()) {
      TableColumn ct = (TableColumn)enumeration.nextElement();
      
      width += ct.getWidth();
      col_width[n] = width;
      
      n++;
    }
    


    Rectangle clipBounds = g.getClipBounds();
    if (header.getColumnModel() == null) { return;
    }
    int column = 0;
    Dimension size = header.getSize();
    Rectangle cellRect = new Rectangle(0, 0, width, height);
    Hashtable h = new Hashtable();
    int columnMargin = header.getColumnModel().getColumnMargin();
    


    int dh = height / H;
    
    Rectangle cell = new Rectangle();
    
    String save_col0 = (String)header.getColumnModel().getColumn(0).getHeaderValue();
    

    for (int i = 0; i < hcols.size(); i++)
    {
      Col col = (Col)hcols.elementAt(i);
      
      cell.setLocation(col_width[ix], iy * dh);
      cell.setSize(col_width[(dx + ix)] - col_width[ix], dy * dh);
      header.getColumnModel().getColumn(0).setHeaderValue(tag);
      
      paintCell(g, cell, 0);
    }
  }
  
  private void paintCell(Graphics g, Rectangle cellRect, int columnIndex) {
    TableColumn aColumn = header.getColumnModel().getColumn(columnIndex);
    TableCellRenderer renderer = aColumn.getHeaderRenderer();
    
    renderer = new DefaultTableCellRenderer() {
      public Component getTableCellRendererComponent(JTable table, Object value, boolean isSelected, boolean hasFocus, int row, int column) {
        JLabel header = new JLabel();
        header.setForeground(table.getTableHeader().getForeground());
        header.setBackground(table.getTableHeader().getBackground());
        header.setFont(table.getTableHeader().getFont());
        
        header.setHorizontalAlignment(0);
        header.setText(value.toString());
        header.setBorder(UIManager.getBorder("TableHeader.cellBorder"));
        return header;
      }
      
    };
    Component c = renderer.getTableCellRendererComponent(
      header.getTable(), aColumn.getHeaderValue(), false, false, -1, columnIndex);
    
    c.setBackground(UIManager.getColor("control"));
    
    rendererPane.add(c);
    rendererPane.paintComponent(g, c, header, x, y, 
      width, height, true);
    rendererPane.remove(c);
  }
  
  private int getHeaderHeight() {
    int height = 0;
    TableColumnModel columnModel = header.getColumnModel();
    for (int column = 0; column < columnModel.getColumnCount(); column++) {
      TableColumn aColumn = columnModel.getColumn(column);
      TableCellRenderer renderer = aColumn.getHeaderRenderer();
      
      if (renderer == null) {
        return 60;
      }
      
      Component comp = renderer.getTableCellRendererComponent(
        header.getTable(), aColumn.getHeaderValue(), false, false, -1, column);
      int cHeight = getPreferredSizeheight;
      









      height = Math.max(height, cHeight);
    }
    return height;
  }
  
  private Dimension createHeaderSize(long width) {
    TableColumnModel columnModel = header.getColumnModel();
    width += columnModel.getColumnMargin() * columnModel.getColumnCount();
    if (width > 2147483647L) {
      width = 2147483647L;
    }
    return new Dimension((int)width, getHeaderHeight());
  }
  
  public Dimension getPreferredSize(JComponent c) {
    long width = 0L;
    Enumeration enumeration = header.getColumnModel().getColumns();
    while (enumeration.hasMoreElements()) {
      TableColumn aColumn = (TableColumn)enumeration.nextElement();
      width += aColumn.getPreferredWidth();
    }
    return createHeaderSize(width);
  }
  
  class Col
  {
    int ix;
    int iy;
    int dx;
    int dy;
    String tag;
    
    Col() {}
  }
}
