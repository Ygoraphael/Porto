package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
import javax.swing.JComponent;
import javax.swing.JTable;
import javax.swing.table.JTableHeader;
import javax.swing.table.TableCellEditor;
import javax.swing.table.TableCellRenderer;






















































































































































































































































































































































































































































































class JTable_Tip2
  extends JTable
{
  public JTable_Tip2() {}
  
  public JTable_Tip2(int altura, int largura)
  {
    getTableHeader().setPreferredSize(new Dimension(5000, altura));
    getTableHeader().setFont(fmeComum.letra);
  }
  
  public TableCellEditor getCellEditor(int row, int column)
  {
    return super.getCellEditor(row, column);
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
      }
      else if (isCellSelected(rowIndex, vColIndex)) {
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
    if (isCellEditable(rowIndex, columnIndex)) return;
    editCellAt(rowIndex, columnIndex);
  }
}
