package fme;

import java.awt.Color;
import java.util.Vector;
import javax.swing.BorderFactory;
import javax.swing.DefaultCellEditor;
import javax.swing.JComboBox;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.table.AbstractTableModel;
import javax.swing.table.JTableHeader;
import javax.swing.table.TableColumn;
import javax.swing.table.TableColumnModel;






































































































































































































































































































































































































































































































































class CHTabela
  extends AbstractTableModel
{
  JTable j;
  CBTabela d;
  int width;
  int[] cdx;
  
  CHTabela() {}
  
  void setup(JTable _j, CBTabela _d)
  {
    d = _d;
    j = _j;
    j.setModel(this);
    j.getTableHeader().setResizingAllowed(false);
    j.getTableHeader().setReorderingAllowed(false);
    








    MultiLineHeaderRenderer renderer = new MultiLineHeaderRenderer();
  }
  




  void set_col(int nCol, double _pw, String _align)
  {
    nCol = d.cols[nCol].t_col;
    
    TableColumn c = j.getColumnModel().getColumn(nCol);
    c.setMaxWidth((int)(_pw * width));
    c.setMinWidth((int)(_pw * width));
    if ((_align != null) && (_align.equals("R"))) j.getColumnModel().getColumn(nCol).setCellRenderer(CFLib.TCRenderer_Rigth);
    if ((_align != null) && (_align.equals("C"))) j.getColumnModel().getColumn(nCol).setCellRenderer(CFLib.TCRenderer_Center);
  }
  
  SteppedComboBox set_col_comboS(int nCol, double _pw, String _align, CTabela _tab, int _col_tab, int _cw) {
    set_col(nCol, _pw, _align);
    nCol = d.cols[nCol].t_col;
    SteppedComboBox jComboBox = new SteppedComboBox();
    
    if (_tab != null) _tab._populateComboBox(jComboBox, _col_tab);
    jComboBox.setPopupWidth(_cw);
    jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
    j.getColumnModel().getColumn(nCol).setCellEditor(new DefaultCellEditor(jComboBox));
    return jComboBox;
  }
  
  SteppedComboBox set_col_comboL(int nCol, double _pw, String _align, String[] list, int _col_tab, int _cw) {
    set_col(nCol, _pw, _align);
    nCol = d.cols[nCol].t_col;
    SteppedComboBox jComboBox = new SteppedComboBox(list);
    

    jComboBox.setPopupWidth(_cw);
    jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
    j.getColumnModel().getColumn(nCol).setCellEditor(new DefaultCellEditor(jComboBox));
    return jComboBox;
  }
  

  JComboBox set_col_combo(int nCol, double _pw, String _align, CTabela _tab, int _col_tab)
  {
    set_col(nCol, _pw, _align);
    nCol = d.cols[nCol].t_col;
    JComboBox jComboBox = new JComboBox();
    
    jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
    if (_tab != null) _tab._populateComboBox(jComboBox, _col_tab);
    j.getColumnModel().getColumn(nCol).setCellEditor(new DefaultCellEditor(jComboBox));
    return jComboBox;
  }
  
  SteppedComboBox set_col_comboD(int nCol, double _pw, String _align, CTabela _tab, int _col_tab, int _cw) {
    set_col(nCol, _pw, _align);
    nCol = d.cols[nCol].t_col;
    SteppedComboBox jComboBox = new SteppedComboBox();
    jComboBox.setRenderer(new DesignCellRenderer(_tab));
    
    jComboBox.setName("cbo-estabs");
    
    if (_tab != null) _tab._populateComboBox(jComboBox, _col_tab);
    jComboBox.setPopupWidth(_cw);
    jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
    j.getColumnModel().getColumn(nCol).setCellEditor(new DefaultCellEditor(jComboBox));
    return jComboBox;
  }
  
  SteppedComboBox set_col_comboF(int nCol, double _pw, String _align, CTabela _tab, int _col_tab, int _cw) {
    set_col(nCol, _pw, _align);
    nCol = d.cols[nCol].t_col;
    SteppedComboBox jComboBox = new SteppedComboBox();
    
    if (_tab != null) _tab._populateComboBox(jComboBox, _col_tab);
    jComboBox.setPopupWidth(_cw);
    jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
    j.getColumnModel().getColumn(nCol).setCellEditor(new FreguesiaCellEditor(jComboBox));
    return jComboBox;
  }
  
  SteppedComboBox set_col_comboFD(int nCol, double _pw, String _align, CTabela _tab, int _col_tab, int _cw) {
    set_col(nCol, _pw, _align);
    nCol = d.cols[nCol].t_col;
    SteppedComboBox jComboBox = new SteppedComboBox();
    jComboBox.setRenderer(new DesignCellRenderer(_tab));
    
    if (_tab != null) _tab._populateComboBox(jComboBox, _col_tab);
    jComboBox.setPopupWidth(_cw);
    jComboBox.setBorder(BorderFactory.createLineBorder(Color.black));
    

    j.getColumnModel().getColumn(nCol).setCellEditor(new FreguesiaCellEditor(jComboBox));
    return jComboBox;
  }
  
  JTextField set_col_text(int nCol, double _pw, String _align) {
    set_col(nCol, _pw, _align);
    
    JTextField jText = new JTextField();
    

    jText.addKeyListener(new TypeKeyListener(d.cols[nCol].vld));
    jText.setBorder(BorderFactory.createLineBorder(Color.black));
    
    nCol = d.cols[nCol].t_col;
    if ((_align != null) && (_align.equals("R"))) jText.setHorizontalAlignment(4);
    j.getColumnModel().getColumn(nCol).setCellEditor(new StdCellEditor(jText));
    return jText;
  }
  
  void set_col_check(int nCol, double _pw) {
    set_col(nCol, _pw, null);
    nCol = d.cols[nCol].t_col;
  }
  
  public Object getValueAt(int i, int j)
  {
    j = cdx[j];
    String s = ((String[])d.dados.elementAt(i))[j];
    if (d.cols[j].is_check)
    {

      if ((!"CadeiaValor_Tabela".equals(this.j.getName())) || (i < 7)) {
        if (s.equals("S")) return Boolean.TRUE;
        return Boolean.FALSE;
      }
    }
    




    if (d.cols[j].vld != null) {
      d.cols[j].vld.setString(s);
      s = d.cols[j].vld.getText();
    }
    return s;
  }
  
  public int getRowCount() {
    return d.dados.size();
  }
  
  public int getColumnCount() {
    return cdx.length;
  }
  
  public String getColumnName(int j) {
    j = cdx[j];
    
    return d.cols[j].col_name;
  }
  
  public Class getColumnClass(int i) {
    i = cdx[i];
    Boolean b = new Boolean(true);
    String s = "";
    if (d.cols[i].is_check)
    {
      return b.getClass();
    }
    
    return super.getColumnClass(i);
  }
  
  public boolean isCellEditable(int i, int j) {
    j = cdx[j];
    

    if ((d instanceof CBTabela_PromCae)) { return ((CBTabela_PromCae)d).isCellEditable(i, j);
    }
    return d.cols[j].editable;
  }
  


  public void setValueAt(Object v, int i, int j)
  {
    j = cdx[j];
    

    if (i + 1 > d.dados.size()) { return;
    }
    if (d.cols[j].is_check)
    {

      if ((!"CadeiaValor_Tabela".equals(this.j.getName())) || (i < 7)) {
        String b;
        if (v == null) {
          String tmp82_79 = "";String b = tmp82_79;((String[])d.dados.elementAt(i))[j] = tmp82_79;
        } else if (v.toString().equals("true")) {
          String tmp120_117 = "S";String b = tmp120_117;((String[])d.dados.elementAt(i))[j] = tmp120_117;
        } else {
          String tmp145_142 = "";b = tmp145_142;((String[])d.dados.elementAt(i))[j] = tmp145_142; }
        CBData.setDirty();
        d.on_update(d.cols[j].col_tag, i, b);
        return;
      }
    }
    

    CFType vld = d.cols[j].vld;
    String a_value = ((String[])d.dados.elementAt(i))[j];
    String s = (String)v;
    
    boolean ok = true;
    if (s == null) s = "";
    if (s.length() == 0) {
      ((String[])d.dados.elementAt(i))[j] = s;

    }
    else if ((vld != null) && (vld.isnull(s))) {
      ((String[])d.dados.elementAt(i))[j] = "";
    }
    else if (vld != null) {
      ok = vld.setText(s, false);
      
      if (ok) {
        ((String[])d.dados.elementAt(i))[j] = vld.getString();
      }
    } else {
      ((String[])d.dados.elementAt(i))[j] = s;
    }
    
    CBData.setDirty();
    

    d.on_update(d.cols[j].col_tag, i, s);
    this.j.repaint();
  }
  
  public boolean valOnline(Object v, int i, int j)
  {
    j = cdx[j];
    CFType vld = d.cols[j].vld;
    String s = (String)v;
    


    boolean ok = true;
    if (s.length() == 0) {
      return true;
    }
    if (vld != null)
    {
      ok = vld.setText(s);
      return ok;
    }
    return true;
  }
  
  void repaint_col_names() {
    for (int i = 0; i < cdx.length; i++) {
      int c = cdx[i];
      String s = d.cols[c].col_name;
      j.getTableHeader().getColumnModel().getColumn(i).setHeaderValue(s);
    }
  }
  
  void __garbage_stop_editing()
  {
    if (!j.isEditing()) return;
    Object e = j.getCellEditor();
    if ((e instanceof StdCellEditor))
    {
      ((StdCellEditor)e).force_stopCellEditing();
      return;
    }
    if ((e instanceof DefaultCellEditor))
    {

      ((DefaultCellEditor)e).cancelCellEditing();
      return;
    }
  }
}
