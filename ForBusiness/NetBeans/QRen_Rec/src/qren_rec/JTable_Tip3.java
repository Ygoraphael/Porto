package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
import java.util.ArrayList;
import javax.swing.BorderFactory;
import javax.swing.DefaultCellEditor;
import javax.swing.JComponent;
import javax.swing.JTable;
import javax.swing.table.JTableHeader;
import javax.swing.table.TableCellEditor;
import javax.swing.table.TableCellRenderer;


















































































































































































































































































































































































































































































































































class JTable_Tip3
  extends JTable
{
  public JTable_Tip3() {}
  
  public JTable_Tip3(int altura)
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
  
  public TableCellRenderer getCellRenderer(int row, int column) {
    if ((!"CadeiaValor_Tabela".equals(getName())) || (row < 7) || (column < 2))
      return super.getCellRenderer(row, column);
    return CFLib.TCRenderer_Center;
  }
  
  public TableCellEditor getCellEditor(int row, int column) {
    if ((getName().equals("IndicCertif_Tabela")) && 
      (row != getRowCount() - 1) && (
      (column == 2) || (column == 3))) {
      SteppedComboBox jComboBox = new SteppedComboBox();
      CTabelas.SimNao._populateComboBox(jComboBox, 1);
      jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
      return new DefaultCellEditor(jComboBox);
    }
    

    if ("CadeiaValor_Tabela".equals(getName()))
    {

      if (row >= 7) {
        if ((column == 2) || (column == 3))
        {
          ArrayList editors = new ArrayList(10);
          SteppedComboBox jComboBox = new SteppedComboBox();
          CTabelas.Escala1a5._populateComboBox(jComboBox, 1);
          jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
          DefaultCellEditor dce = new DefaultCellEditor(jComboBox);
          editors.add(dce);
          return (TableCellEditor)editors.get(0);
        }
        
        return super.getCellEditor(row, column);
      }
      return super.getCellEditor(row, column);
    }
    if (("AmbitoNov_Tabela".equals(getName())) && 
      (column == 2)) {
      if (row == 0) {
        ArrayList editors = new ArrayList(10);
        SteppedComboBox jComboBox = new SteppedComboBox();
        CTabelas.SimNao._populateComboBox(jComboBox, 1);
        

        jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
        DefaultCellEditor dce = new DefaultCellEditor(jComboBox);
        editors.add(dce);
        
        return (TableCellEditor)editors.get(0);
      }
      if (row == 1) {
        ArrayList editors = new ArrayList(10);
        String[] resp = { "", "Produto", "Mercado" };
        SteppedComboBox jComboBox = new SteppedComboBox(resp);
        DefaultCellEditor dce = new DefaultCellEditor(jComboBox);
        editors.add(dce);
        return (TableCellEditor)editors.get(0);
      }
      if (row == 2) {
        ArrayList editors = new ArrayList(10);
        String[] resp = { "", "Empresa", "Mercado", "Mundo" };
        SteppedComboBox jComboBox = new SteppedComboBox(resp);
        DefaultCellEditor dce = new DefaultCellEditor(jComboBox);
        editors.add(dce);
        return (TableCellEditor)editors.get(0);
      }
      return super.getCellEditor(row, column);
    }
    
    if (("Propensao_Tabela".equals(getName())) && 
      (column == 2)) {
      if ((row == 0) || (row == 1)) {
        ArrayList editors = new ArrayList(10);
        SteppedComboBox jComboBox = new SteppedComboBox();
        CTabelas.SimNao._populateComboBox(jComboBox, 1);
        

        jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
        DefaultCellEditor dce = new DefaultCellEditor(jComboBox);
        editors.add(dce);
        
        return (TableCellEditor)editors.get(0);
      }
      if (row == 2) {
        ArrayList editors = new ArrayList(10);
        String[] resp = { "", "Diretas", "Intermédias", "Estruturantes" };
        SteppedComboBox jComboBox = new SteppedComboBox(resp);
        DefaultCellEditor dce = new DefaultCellEditor(jComboBox);
        editors.add(dce);
        return (TableCellEditor)editors.get(0);
      }
      if (row == 3) {
        ArrayList editors = new ArrayList(10);
        String[] resp = { "", "Marcas terceiras", "Marcas próprias" };
        SteppedComboBox jComboBox = new SteppedComboBox(resp);
        jComboBox.setPopupWidth(100);
        DefaultCellEditor dce = new DefaultCellEditor(jComboBox);
        editors.add(dce);
        return (TableCellEditor)editors.get(0);
      }
      return super.getCellEditor(row, column);
    }
    
    if (("ResultadosPO_Tabela".equals(getName())) && (
      (column == 2) || (column == 3))) {
      if (row <= 2) {
        ArrayList editors = new ArrayList(10);
        SteppedComboBox jComboBox = new SteppedComboBox();
        CTabelas.SimNao._populateComboBox(jComboBox, 1);
        

        jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
        DefaultCellEditor dce = new DefaultCellEditor(jComboBox);
        editors.add(dce);
        
        return (TableCellEditor)editors.get(0);
      }
      if (row == 3) {
        ArrayList editors = new ArrayList(10);
        String[] resp = { "", "Fraco", "Alguma expressão", "Forte" };
        SteppedComboBox jComboBox = new SteppedComboBox(resp);
        jComboBox.setPopupWidth(100);
        DefaultCellEditor dce = new DefaultCellEditor(jComboBox);
        editors.add(dce);
        return (TableCellEditor)editors.get(0);
      }
      return super.getCellEditor(row, column);
    }
    
    if (("Reforco_Tabela".equals(getName())) && (
      (column == 2) || (column == 3))) {
      if (row == 3) {
        ArrayList editors = new ArrayList(10);
        String[] resp = { "", "Não temos", "Universidades", "Outras empresas", "Outros centros de saber" };
        SteppedComboBox jComboBox = new SteppedComboBox(resp);
        jComboBox.setPopupWidth(130);
        DefaultCellEditor dce = new DefaultCellEditor(jComboBox);
        editors.add(dce);
        return (TableCellEditor)editors.get(0);
      }
      return super.getCellEditor(row, column);
    }
    
    return super.getCellEditor(row, column);
  }
  
  public Component prepareRenderer(TableCellRenderer renderer, int rowIndex, int vColIndex) {
    Color cinza = new Color(247, 247, 247);
    Color branco = new Color(255, 255, 255);
    
    if ("CadeiaValor_Tabela".equals(getName())) {
      setRowHeight(0, 55);
      setRowHeight(1, 40);
      setRowHeight(2, 40);
      setRowHeight(3, 55);
    }
    if ("Propensao_Tabela".equals(getName())) {
      setRowHeight(3, 50);
    }
    if ("ResultadosPO_Tabela".equals(getName())) {
      setRowHeight(1, 35);
      setRowHeight(2, 35);
    }
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
