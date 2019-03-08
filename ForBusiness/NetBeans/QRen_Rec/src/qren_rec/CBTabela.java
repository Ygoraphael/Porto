package fme;

import java.awt.Component;
import java.awt.Toolkit;
import java.awt.datatransfer.Clipboard;
import java.awt.datatransfer.DataFlavor;
import java.awt.datatransfer.StringSelection;
import java.io.PrintStream;
import java.util.HashMap;
import java.util.Vector;
import javax.swing.JCheckBox;
import javax.swing.JComboBox;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.table.TableCellEditor;






























































































































































































































































































































































































































































































































































































































































class CBTabela
  extends XMLDataHandler
  implements CBData_Comum
{
  CHTabColModel[] cols;
  Vector dados = new Vector();
  int df_nlines;
  int keyCol;
  int idx_xml;
  int idx_xml_corrompido;
  CHTabela handler = null;
  boolean force_xml = false;
  GroupableTableHeaderUI ui = null;
  boolean started = false;
  
  public CBTabela()
  {
    idx_xml = -1;
    idx_xml_corrompido = -1;
    keyCol = -1;
  }
  
  void init_handler(JTable _j)
  {
    handler = new CHTabela();
    _init_handler(_j);
  }
  
  void init_handler(CHTabela _handler, JTable _j)
  {
    handler = _handler;
    _init_handler(_j);
  }
  
  void init_handler(CHTabela _handler, JTable _j1, JTable _j2) { handler = _handler;
    _init_handler(_j1);
    _init_handler(_j2);
  }
  
  void _init_handler(JTable _j) {
    _j.setCellSelectionEnabled(false);
    _j.setRowSelectionAllowed(true);
    _j.setColumnSelectionAllowed(false);
    
    int nt_cols = 0;
    for (int i = 0; i < cols.length; i++) {
      if (cols[i].visible) cols[i].t_col = (nt_cols++);
    }
    handler.cdx = new int[nt_cols];
    int n = 0;
    for (int i = 0; i < cols.length; i++) {
      if (cols[i].visible) handler.cdx[(n++)] = i;
    }
    handler.setup(_j, this);
  }
  
  public String xmlPrint()
  {
    if (!started) { return "";
    }
    int nRows = dados.size();
    int nCols = cols.length;
    String xml = new String();
    


    xml = "";
    for (int i = 0; i < nRows; i++) {
      String xml_reg = new String();
      boolean has_data = false;
      xml_reg = "<Reg>\n";
      for (int j = 0; j < nCols; j++) {
        if (cols[j].xml_enabled)
        {


          String v = ((String[])dados.elementAt(i))[j];
          if (((force_xml) || (cols[j].editable)) && (v.length() > 0)) has_data = true;
          if ((cols[j].vld != null) && (((cols[j].vld instanceof CFType_Perc)) || ((cols[j].vld instanceof CFType_Perc0))) && 
            (v.length() > 0)) { v = _lib.round4(_lib.to_double(v) / 100.0D);
          }
          xml_reg = xml_reg + _lib.xml_encode(cols[j].col_tag, v);
          xml_reg = xml_reg + on_xml(cols[j].col_tag, i, v);
        }
      }
      
      xml_reg = xml_reg + xmlPrintInternal(i);
      
      xml_reg = xml_reg + "</Reg>\n";
      if (has_data) xml = xml + "\n" + xml_reg;
    }
    return xml;
  }
  
  String xmlPrintInternal(int row) {
    return "";
  }
  
  public void xmlBegin(String path)
  {
    if (!started) return;
    idx_xml += 1;
    if ((idx_xml >= dados.size()) && (keyCol == -1)) add_row();
  }
  
  public void xmlEnd(String path) {
    idx_xml_corrompido = -1;
  }
  
  public void xmlValue(String path, String tag, String v) {
    if (!started) return;
    String _v = v;
    

    int i = idx_xml;
    
    int j = getColIndex(tag);
    if (j < 0) return;
    if (idx_xml_corrompido == idx_xml)
    {
      return;
    }
    
    if (j == keyCol)
    {
      for (int k = 0; k < dados.size(); k++)
      {



        if (v.equals(((String[])dados.elementAt(k))[keyCol])) {
          idx_xml = k;
          
          return;
        }
      }
      



      if ((((String)CParseConfig.hconfig.get("reg_especial")).equals("1")) && 
        (path.indexOf("Balanco_SNC") != -1) && (tag.equals("conta")) && (v.equals("s21")))
      {
        idx_xml_corrompido = idx_xml;
        return;
      }
      


      idx_xml_corrompido = idx_xml;
      CBData.corrompido = true;
      return;
    }
    

    if (!cols[j].xml_enabled) { return;
    }
    

    if ((v.equals("0")) && (cols[j].vld != null) && ((cols[j].vld instanceof CFType_ValorS)))
    {
      v = "";
    }
    
    if ((cols[j].vld != null) && (((cols[j].vld instanceof CFType_Perc)) || ((cols[j].vld instanceof CFType_Perc0))) && (!CBData.import_pas) && 
      (v.length() > 0)) { v = _lib.round4(_lib.to_double(v) * 100.0D);
    }
    


    if (((handler instanceof CHTabQuadro)) && (handler).row_vld[i] != null)) {
      handler).row_vld[i].setString(v);
      v = handler).row_vld[i].getString();

    }
    else if (cols[j].vld != null) {
      cols[j].vld.setString(v);
      v = cols[j].vld.getString();
    }
    

    ((String[])dados.elementAt(i))[j] = v;
    

    on_update(tag, i, v);
  }
  
  CHTabColModel getCol(String name) {
    for (int i = 0; i < cols.length; i++) {
      if (cols[i].col_tag.equals(name)) return cols[i];
    }
    return null;
  }
  
  int getColIndex(String name) {
    for (int i = 0; i < cols.length; i++) {
      if (cols[i].col_tag.equals(name)) return i;
    }
    return -1;
  }
  
  int getColIndexByName(String name) {
    for (int i = 0; i < cols.length; i++) {
      if (cols[i].col_name.equals(name)) return i;
    }
    return -1;
  }
  
  void setColValue(String name, int i, String v) {
    int n = getColIndex(name);
    ((String[])dados.elementAt(i))[n] = v;
  }
  
  String getColValue(String name, int i) {
    int n = getColIndex(name);
    return ((String[])dados.elementAt(i))[n];
  }
  
  public void add_row() {
    String[] col = new String[cols.length];
    for (int j = 0; j < cols.length; j++)
      col[j] = "";
    dados.addElement(col);
  }
  
  public void ins_row_at(int n) { ins_row_at(n, true); }
  
  public void ins_row_at(int n, boolean remove_empty) { String[] col = new String[cols.length];
    for (int j = 0; j < cols.length; j++)
      col[j] = "";
    dados.insertElementAt(col, n);
    if (!remove_empty) return;
    for (int i = dados.size() - 1; i > n; i--) {
      if (isRowEmpty(i)) {
        del_row_at(i);
        break;
      }
    }
    int x = dados.size();
  }
  
  public void del_row_at(int n)
  {
    dados.removeElementAt(n);
    if (dados.size() < df_nlines) {
      String[] col = new String[cols.length];
      for (int j = 0; j < cols.length; j++)
        col[j] = "";
      dados.addElement(col);
    }
  }
  
  void init_dados(int n) {
    df_nlines = n;
    dados = new Vector();
    for (int i = 0; i < df_nlines; i++) {
      String[] col = new String[cols.length];
      for (int j = 0; j < cols.length; j++) {
        if (cols[j].editable) col[j] = "";
        if (col[j] == null) col[j] = "";
      }
      dados.addElement(col);
    }
  }
  
  public void Clear() {
    for (int i = 0; i < dados.size(); i++)
      clearRow(i);
    idx_xml = -1;
    
    handler.j.repaint();
  }
  
  void clearRow(int i) {
    for (int j = 0; j < cols.length; j++) {
      if (cols[j].editable) ((String[])dados.elementAt(i))[j] = "";
      if (((String[])dados.elementAt(i))[j] == null) ((String[])dados.elementAt(i))[j] = "";
      on_update(cols[j].col_tag, i, "");
    }
  }
  

  void on_update(String colname, int nRow, String v) {}
  
  public void on_external_update(String tag) {}
  
  String on_xml(String colname, int row, String v)
  {
    return "";
  }
  
  void validar() {}
  
  double getSum(String colName)
  {
    double v = 0.0D;
    int n = getColIndex(colName);
    int classe = getColIndex("classe");
    


    int nRows = dados.size();
    




    for (int i = 0; i < nRows; i++) {
      String s = ((String[])dados.elementAt(i))[n];
      if ((s.length() > 0) && (
        (!colName.equals("elegivel")) || 
        (!((String[])dados.elementAt(i))[classe].equals("999"))))
      {


        v = _lib.round(v + Double.parseDouble(s));
      }
    }
    return v;
  }
  
  double getSum(String colName, String ano) {
    double v = 0.0D;
    int n = getColIndex(colName);
    int classe = getColIndex("classe");
    
    int calend = getColIndex("calendario");
    

    int nRows = dados.size();
    




    for (int i = 0; i < nRows; i++) {
      String s = ((String[])dados.elementAt(i))[n];
      if ((s.length() > 0) && (
        (!colName.equals("elegivel")) || 
        (!((String[])dados.elementAt(i))[classe].equals("999"))))
      {



        String s1 = ((String[])dados.elementAt(i))[calend];
        if ((s1.length() > 0) && (s1.substring(0, 4).equals(ano)))
          v = _lib.round(v + Double.parseDouble(s));
      }
    }
    return v;
  }
  
  double getSumIf(String colName, String ifColName, String ifColValue) {
    double v = 0.0D;
    for (int i = 0; i < dados.size(); i++)
      if (((String[])dados.elementAt(i))[getColIndex(ifColName)].matches(ifColValue))
      {
        String s = ((String[])dados.elementAt(i))[getColIndex(colName)];
        if (s.length() > 0)
          v = _lib.round(v) + _lib.round(Double.parseDouble(s));
      }
    return _lib.round(v);
  }
  
  double getSumNotIf(String colName, String ifColName, String ifColValue) {
    double v = 0.0D;
    for (int i = 0; i < dados.size(); i++)
      if ((!((String[])dados.elementAt(i))[getColIndex(ifColName)].equals("")) && 
        (!((String[])dados.elementAt(i))[getColIndex(ifColName)].matches(ifColValue))) {
        String s = ((String[])dados.elementAt(i))[getColIndex(colName)];
        if (s.length() > 0)
          v = _lib.round(v) + _lib.round(Double.parseDouble(s));
      }
    return _lib.round(v);
  }
  
  double getSumIf(String colName, String ano, String ifColName, String ifColValue) {
    double v = 0.0D;
    int calend = getColIndex("calendario");
    for (int i = 0; i < dados.size(); i++)
      if (((String[])dados.elementAt(i))[getColIndex(ifColName)].matches(ifColValue))
      {
        String s = ((String[])dados.elementAt(i))[getColIndex(colName)];
        if (s.length() > 0) {
          String s1 = ((String[])dados.elementAt(i))[calend];
          if ((s1.length() > 0) && (s1.substring(0, 4).equals(ano)))
            v = _lib.round(v) + _lib.round(Double.parseDouble(s));
        }
      }
    return _lib.round(v);
  }
  
  double getColSum(String colRef, String valRef, String colSum) {
    int idx_1 = getColIndex(colRef);
    int idx_2 = getColIndex(colSum);
    double sum = 0.0D;
    for (int i = 0; i < dados.size(); i++) {
      if (((String[])dados.elementAt(i))[idx_1].equals(valRef)) {
        sum += _lib.to_double(((String[])dados.elementAt(i))[idx_2]);
      }
    }
    
    return sum;
  }
  
  double getMax(String colName) {
    double v = 0.0D;
    int n = getColIndex(colName);
    


    int nRows = dados.size();
    
    for (int i = 0; i < nRows; i++) {
      String s = ((String[])dados.elementAt(i))[n];
      if (s.length() > 0) {
        double vx = Double.parseDouble(s);
        if (vx > v) v = vx;
      }
    }
    return v;
  }
  
  boolean isUnique(String colName) {
    int n = getColIndex(colName);
    


    int nRows = dados.size();
    
    for (int i = 0; i < nRows; i++) {
      for (int k = i + 1; k < nRows; k++) {
        String s1 = ((String[])dados.elementAt(i))[n];
        String s2 = ((String[])dados.elementAt(k))[n];
        
        if ((s1.length() > 0) && (s1.equals(s2))) return false;
      }
    }
    return true;
  }
  

  TabError isIncomplet(String mask)
  {
    int nRows = dados.size();
    
    for (int i = 0; i < nRows; i++) {
      TabError e = isIncomplet(i, mask);
      if (e != null) return e;
    }
    return null;
  }
  
  TabError isIncomplet(int row, String mask) {
    int nCols = cols.length;
    boolean has_line = false;
    

    for (int j = 0; (j < nCols) && (!has_line); j++) {
      String s = ((String[])dados.elementAt(row))[j];
      if ((s != null) && (s.length() > 0)) {
        has_line = true;
      }
    }
    
    for (j = 0; j < nCols; j++) {
      String s = ((String[])dados.elementAt(row))[j];
      
      if ((has_line) && (s.length() == 0) && (mask.charAt(j) == 'R'))
        return new TabError(row, j, 'R', cols[j].col_tag, cols[j].col_name);
      if ((s.length() > 0) && (mask.charAt(j) == 'N'))
        return new TabError(row, j, 'N', cols[j].col_tag, cols[j].col_name);
    }
    return null;
  }
  
  TabError[] isIncompletAll(int row, String mask) {
    int nCols = cols.length;
    boolean has_line = false;
    

    for (int j = 0; (j < nCols) && (!has_line); j++) {
      String s = ((String[])dados.elementAt(row))[j];
      if ((s != null) && (s.length() > 0)) {
        has_line = true;
      }
    }
    TabError[] elist = new TabError[nCols];
    int nErros = 0;
    for (j = 0; j < nCols; j++) {
      String s = ((String[])dados.elementAt(row))[j];
      if ((has_line) && (s.length() == 0) && (mask.charAt(j) == 'R'))
        elist[(nErros++)] = new TabError(row, j, 'R', cols[j].col_tag, cols[j].col_name);
      if ((s.length() > 0) && (mask.charAt(j) == 'N')) {
        elist[(nErros++)] = new TabError(row, j, 'N', cols[j].col_tag, cols[j].col_name);
      }
    }
    TabError[] rlist = new TabError[nErros];
    System.arraycopy(elist, 0, rlist, 0, nErros);
    return rlist;
  }
  


  boolean isRowEmpty(int row)
  {
    for (int j = 0; j < cols.length; j++) {
      if (cols[j].editable) {
        String s = ((String[])dados.elementAt(row))[j];
        if (s.length() > 0) return false;
      }
    }
    return true;
  }
  
  boolean isColEmpty(int col) {
    if (!cols[col].editable) { return false;
    }
    for (int j = 0; j < dados.size(); j++)
      if (handler).row_editable[j] != 0) {
        String s = ((String[])dados.elementAt(j))[col];
        if (s.length() > 0) return false;
      }
    return true;
  }
  
  boolean isEmpty() {
    int nRows = dados.size();
    int nCols = cols.length;
    


    for (int i = 0; i < nRows; i++)
      if (!isRowEmpty(i)) return false;
    return true;
  }
  



















  public void locate(CHValid_Msg m) {}
  



















  public String getPagina()
  {
    return null;
  }
  
  void numerar(int nCol) {
    int n = 1;
    for (int i = 0; i < dados.size(); i++) {
      if (!isRowEmpty(i)) ((String[])dados.elementAt(i))[nCol] = Integer.toString(n++); else {
        ((String[])dados.elementAt(i))[nCol] = "";
      }
    }
  }
  




  void autocalc()
  {
    for (int i = 0; i < cols.length; i++) {
      if (cols[i].autocalc != null) {
        String formula = cols[i].autocalc;
        if (formula.startsWith("$soma")) {
          String conta = formula.substring(6, formula.length() - 1);
          
          _autocalc_soma(i, conta);
        }
        if (formula.startsWith("$perc")) {
          String conta = formula.substring(6, formula.length() - 1);
          
          _autocalc_perc(i, conta);
        }
      }
    }
    


    if ((handler != null) && ((handler instanceof CHTabQuadro))) {
      _autocalc_rows();
    }
  }
  
  void _autocalc_soma(int nCol, String formula) {
    String[] termos = formula.split(",");
    

    for (int r = 0; r < dados.size(); r++)
    {
      double v = 0.0D;double sv = 0.0D;
      for (int t = 0; t < termos.length; t++)
      {
        if ((!termos[t].equals("+x")) && 
          (!termos[t].equals("-x"))) {
          int n = Integer.parseInt(termos[t].substring(1));
          char conta = termos[t].charAt(0);
          
          sv = 0.0D;
          
          String s = ((String[])dados.elementAt(r))[n];
          if (s.length() > 0) { sv = Double.parseDouble(s);
          }
          if ((s.length() > 0) && (conta == '+')) v += sv;
          if ((s.length() > 0) && (conta == '-')) { v -= sv;
          }
          if (v != 0.0D) { v = _lib.round(v);
          }
        }
      }
      











      if (v == 0.0D) {
        ((String[])dados.elementAt(r))[nCol] = "";
      } else
        ((String[])dados.elementAt(r))[nCol] = _lib.to_string(v);
    }
  }
  
  void _autocalc_perc(int nCol, String formula) {
    String[] termos = formula.split(",");
    double base = 0.0D;
    if (termos[1].charAt(0) == '@') {
      String s = getParam(termos[1].substring(1));
      if (s.length() > 0) { base = Double.parseDouble(s);
      }
    }
    
    for (int r = 0; r < dados.size(); r++)
    {
      double v = 0.0D;
      if (base != 0.0D) {
        int n = Integer.parseInt(termos[0].substring(1));
        String s = ((String[])dados.elementAt(r))[n];
        if (s.length() > 0) v = Double.parseDouble(s);
        v /= base;
      }
      



      if (v == 0.0D) {
        ((String[])dados.elementAt(r))[nCol] = "";
      } else
        ((String[])dados.elementAt(r))[nCol] = _lib.to_string(v * 100.0D);
    }
  }
  
  void _autocalc_rows() {
    CHTabQuadro h = (CHTabQuadro)handler;
    
    for (int i = 0; i < row_autocalc.length; i++) {
      if (row_autocalc[i] != null) {
        String formula = row_autocalc[i];
        
        if (formula.startsWith("$soma")) {
          String conta = formula.substring(6, formula.length() - 1);
          
          _autocalc_rows_soma(i, conta);
        }
      }
    }
  }
  
  void _autocalc_rows_soma(int nRow, String formula) {
    String[] termos = formula.split(",");
    
    for (int c = 0; c < cols.length; c++)
    {
      if ((cols[c].vld != null) && 
        (!cols[c].disable_row_calc))
      {

        double v = 0.0D;double sv = 0.0D;
        String msg = "";
        for (int t = 0; t < termos.length; t++)
        {
          if ((!termos[t].equals("+x")) && 
            (!termos[t].equals("-x"))) {
            int n = Integer.parseInt(termos[t].substring(1));
            char conta = termos[t].charAt(0);
            



            String s = ((String[])dados.elementAt(n))[c];
            

            sv = 0.0D;
            if (s.length() > 0) { sv = Double.parseDouble(s);
            }
            if (sv != 0.0D) { sv = _lib.round(sv);
            }
            


            if ((s.length() > 0) && (conta == '+')) v += sv;
            if ((s.length() > 0) && (conta == '-')) { v -= sv;
            }
            if (v != 0.0D) { v = _lib.round(v);
            }
          }
        }
        











        if (v == 0.0D) {
          ((String[])dados.elementAt(nRow))[c] = "";
        } else {
          ((String[])dados.elementAt(nRow))[c] = _lib.to_string(v);
        }
      }
    }
  }
  


  public String getParam(String param)
  {
    return null;
  }
  




  boolean on_del_row() { return on_del_row(false); }
  
  boolean on_del_row(boolean cascade) { handler.__garbage_stop_editing();
    int n = handler.j.getSelectedRow();
    int m = handler.j.getRowCount();
    if ((n < m) && (n != -1)) {
      Object[] options = { "   Sim   ", "   Não   " };
      int q = JOptionPane.showOptionDialog(null, 
        "<html>A linha selecionada " + (
        cascade ? "<strong><u>e toda a informação associada</u></strong> " : "") + 
        "será eliminada. Pretende continuar?</html>", 
        "Apagar Linha", 
        0, 
        3, 
        null, 
        options, 
        options[1]);
      if (q == 0) {
        del_row_at(n);
        handler.j.revalidate();
        handler.j.repaint();
        return true;
      }
    }
    else {
      JOptionPane.showMessageDialog(null, 
        "Não selecionou nenhuma linha na tabela!", 
        "Apagar Linha", 
        1, 
        null);
    }
    return false;
  }
  
  boolean on_add_row() {
    add_row();
    handler.j.revalidate();
    handler.j.repaint();
    return true;
  }
  












  boolean on_ins_row() { return on_ins_row(true); }
  
  boolean on_ins_row(boolean remove_empty) { handler.__garbage_stop_editing();
    int n = handler.j.getSelectedRow();
    if (n >= 0) {
      ins_row_at(n, remove_empty);
      handler.j.revalidate();
      handler.j.repaint();
      return true;
    }
    return false;
  }
  
  boolean on_up_row() {
    handler.__garbage_stop_editing();
    int n = handler.j.getSelectedRow();
    if (n >= 1) {
      String[] line_1 = (String[])dados.elementAt(n - 1);
      String[] line_2 = (String[])dados.elementAt(n);
      dados.setElementAt(line_2, n - 1);
      dados.setElementAt(line_1, n);
      
      handler.j.revalidate();
      handler.j.repaint();
      return true;
    }
    return false;
  }
  
  boolean on_copy_row() {
    handler.__garbage_stop_editing();
    int n = handler.j.getSelectedRow();
    if (n >= 0) {
      ins_row_at(n + 1);
      String[] col_ = (String[])dados.elementAt(n);
      String[] col = new String[cols.length];
      for (int j = 0; j < cols.length; j++)
        col[j] = col_[j];
      dados.setElementAt(col, n + 1);
      handler.j.revalidate();
      handler.j.repaint();
      
      return true;
    }
    return false;
  }
  

  double getAsValue(int i, int j)
  {
    String s = ((String[])dados.elementAt(i))[j];
    


    return _lib.to_double(s);
  }
  



  void on_row(int i) {}
  



  public CBTabela fixed_buddy = null;
  public boolean on_fixed_buddy = false;
  public static String excel_password = null;
  
  public void on_copy_data() {
    CHTabQuadro quadro = (handler instanceof CHTabQuadro) ? (CHTabQuadro)handler : null;
    handler.__garbage_stop_editing();
    int true_size = dados.size();
    if ((quadro == null) && (fixed_buddy == null) && (!force_xml)) {
      while ((true_size > 0) && (isRowEmpty(true_size - 1))) true_size--;
    }
    StringBuffer sb = new StringBuffer();
    for (int i = 0; i < true_size; i++) {
      if (fixed_buddy != null)
        fixed_buddy.copy_data_row(i, sb);
      copy_data_row(i, sb);
      sb.setCharAt(sb.length() - 1, '\n');
    }
    
    StringSelection s = new StringSelection(sb.toString());
    Toolkit.getDefaultToolkit().getSystemClipboard().setContents(s, null);
  }
  
  private void copy_data_row(int i, StringBuffer sb) {
    CHTabQuadro quadro = (handler instanceof CHTabQuadro) ? (CHTabQuadro)handler : null;
    String[] row = (String[])dados.elementAt(i);
    for (int h = 0; h < handler.cdx.length; h++) {
      int j = handler.cdx[h];
      String cell = row[j];
      boolean qv = (quadro != null) && (row_vld[i] != null) && (cols[j].editable);
      CFType vld = qv ? row_vld[i] : cols[j].vld;
      if ((cell.length() != 0) && (vld != null)) {
        try {
          vld.setString(cell);
          cell = vld.getText();
        } catch (Exception localException) {}
      }
      sb.append(cell);
      sb.append('\t');
    }
  }
  
  public void on_paste_data() {
    Clipboard cb = Toolkit.getDefaultToolkit().getSystemClipboard();
    if (cb.isDataFlavorAvailable(DataFlavor.stringFlavor))
    {
      try {
        String[] rows = ((String)cb.getData(DataFlavor.stringFlavor)).split("\n", 0);
        if ((rows.length == 0) || ((rows.length == 1) && (rows[0].length() == 0))) {
          JOptionPane.showMessageDialog(null, "Não existe texto na área de transferência.", 
            "Colar", 1);
          return;
        }
        
        CHTabQuadro quadro = (handler instanceof CHTabQuadro) ? (CHTabQuadro)handler : null;
        int col_size = rows[0].split("\t", -1).length;
        if (quadro == null) System.out.println("null: rows=" + dados.size() + "/" + rows.length + ", cols=" + cols.length + "/" + col_size); else
          System.out.println("CHTabQuadro: rows=" + dados.size() + "/" + rows.length + ", cols=" + cols.length + "/" + col_size);
        if ((quadro != null) && (dados.size() != rows.length)) {
          JOptionPane.showMessageDialog(null, 
            "A estrutura que está a copiar do Clipboard não coincide com a da tabela.\nP.f. respeite o nº de linhas.", 
            "Copiar do Clipboard", 0, null);
          return;
        }
        handler.__garbage_stop_editing();
        int true_size = dados.size();
        if ((quadro == null) && (!force_xml))
          while ((true_size > 0) && (isRowEmpty(true_size - 1))) true_size--;
        String msg;
        String msg;
        if (true_size == 0) {
          msg = "colar " + rows.length + " linha" + (rows.length == 1 ? "" : "s");
        } else {
          int replace = Math.min(true_size, rows.length);
          msg = "substituir " + replace + " linha" + (replace == 1 ? "" : "s");
          if (rows.length > true_size) msg = msg + " e adicionar " + (rows.length - true_size);
          if (true_size > rows.length) msg = msg + " e apagar " + (true_size - rows.length);
        }
        String[] opt = { "   Sim   ", "   Não   " };
        int d = JOptionPane.showOptionDialog(null, "Confirma que quer " + msg + "?", "Colar", 
          0, 3, null, opt, opt[1]);
        if (d == 1) { return;
        }
        

        int i = 0;
        for (String row : rows) {
          if (i == dados.size())
          {
            on_add_row();
          }
          String[] cells = row.split("\t", -1);
          int c = 0;
          if (((fixed_buddy != null) && 
            ((c = fixed_buddy.paste_data_row(i, 0, cells, c, 0)) == -1)) || 
            ((c = paste_data_row(i, 0, cells, c, 1)) == -1)) break;
          i++;
        }
        for (; i < dados.size(); i++) {
          if (fixed_buddy != null)
            fixed_buddy.clear_data_row(i);
          clear_data_row(i);
        }
      } catch (Exception e) { e.printStackTrace();
      }
      
      handler.j.revalidate();
      handler.j.repaint();
    }
  }
  
  public void on_paste_data2() {
    Clipboard cb = Toolkit.getDefaultToolkit().getSystemClipboard();
    if (cb.isDataFlavorAvailable(DataFlavor.stringFlavor))
    {
      try {
        String[] rows = ((String)cb.getData(DataFlavor.stringFlavor)).split("\n", 0);
        if ((rows.length == 0) || ((rows.length == 1) && (rows[0].length() == 0))) {
          JOptionPane.showMessageDialog(null, "Não existe texto na área de transferência.", 
            "Colar", 1);
          return;
        }
        CHTabQuadro quadro = (handler instanceof CHTabQuadro) ? (CHTabQuadro)handler : null;
        int col_size = rows[0].split("\t", -1).length;
        



        if ((handler.j.getSelectedRow() == -1) && (
          ((fixed_buddy == null) && (handler.j.getSelectedColumn() == -1)) || (
          (fixed_buddy != null) && (handler.j.getSelectedColumn() == -1) && (fixed_buddy.handler.j.getSelectedColumn() == -1)))) {
          JOptionPane.showMessageDialog(null, 
            "P.f. posicione-se na célula para onde pretende copiar os dados.", "Copiar do Clipboard", 0, null);
          return;
        }
        
        handler.__garbage_stop_editing();
        int true_size = dados.size();
        if ((quadro == null) && (!force_xml))
          while ((true_size > 0) && (isRowEmpty(true_size - 1))) true_size--;
        String msg;
        String msg;
        if (true_size == 0) {
          msg = "colar " + rows.length + " linha" + (rows.length == 1 ? "" : "s");
        } else {
          int replace = Math.min(true_size, rows.length);
          msg = "substituir " + replace + " linha" + (replace == 1 ? "" : "s");
        }
        String[] opt = { "   Sim   ", "   Não   " };
        int d = JOptionPane.showOptionDialog(null, "Confirma que quer " + msg + "?", "Colar", 
          0, 3, null, opt, opt[1]);
        if ((d == 1) || (d == -1)) { return;
        }
        

        int i = handler.j.getSelectedRow();
        int h = handler.j.getSelectedColumn();
        for (String row : rows) {
          if (i == dados.size()) {
            if (quadro != null) break;
            on_add_row();
          }
          String[] cells = row.split("\t", -1);
          int c = 0;
          if (fixed_buddy != null)
            if (on_fixed_buddy) {
              h = -1;
              
              if ((c = fixed_buddy.paste_data_row(i, 0, cells, c, 0)) == -1)
                break;
            } else {
              if ((c = paste_data_row(i, h, cells, c, 0)) == -1)
                break;
            }
          if ((c = paste_data_row(i, h == -1 ? 0 : h, cells, c, 0)) == -1) break;
          i++;
        }
      } catch (Exception e) { e.printStackTrace();
      }
      
      handler.j.revalidate();
      handler.j.repaint();
    }
  }
  
  private int paste_data_row(int i, int h, String[] cells, int c, int all) throws Exception {
    CHTabQuadro quadro = (handler instanceof CHTabQuadro) ? (CHTabQuadro)handler : null;
    int n_cols = handler.cdx.length - h + all;
    for (; 
        


        (h < handler.cdx.length) && (c < cells.length) && (c < n_cols); c++)
    {


      if (h == handler.cdx.length) break;
      if (handler.j.isCellEditable(i, h)) {
        String cell = cells[c];
        int j = handler.cdx[h];
        if (cell.length() != 0) {
          boolean valid = false;
          Component e = handler.j.getCellEditor(i, h)
            .getTableCellEditorComponent(handler.j, null, false, i, h);
          if ((e instanceof JComboBox)) {
            for (int k = 0; k < ((JComboBox)e).getItemCount(); k++) {
              if (((JComboBox)e).getItemAt(k).toString().equals(cell)) {
                valid = true;
                break;
              }
            }
          }
          else if ((e instanceof JTextField)) {
            boolean qv = (quadro != null) && (row_vld[i] != null) && (cols[j].editable);
            CFType vld = qv ? row_vld[i] : cols[j].vld;
            if (vld == null) {
              valid = true;
            } else if (vld.setText(cell, false)) {
              cell = vld.getString();
              valid = true;
            }
          }
          else if ((e instanceof JCheckBox)) {
            cell = cell.matches("(?i)(|0|f.*)") ? "" : "S";
            valid = true;
          } else {
            throw new Exception("Unhandled component type"); }
          if (!valid) {
            String[] opt = { "   Sim   ", "   Não   " };
            int d = JOptionPane.showOptionDialog(null, "Não foi possível colar '" + cell + "' na coluna '" + 
              cols[j].col_name.replaceAll("<.*?>", " ").replaceAll("\\s+?", " ").trim() + 
              "'.\n\nPretende continuar?", "Colar", 
              0, 3, null, opt, opt[1]);
            if ((d == 1) || (d == -1)) return -1;
            cell = "";
          }
        }
        ((String[])dados.elementAt(i))[j] = cell;
        CBData.reading_xml = true;
        on_update(cols[j].col_tag, i, cell);
        CBData.reading_xml = false;
      }
      h++;
    }
    
















































    return c;
  }
  
  private void clear_data_row(int i)
  {
    for (int h = 0; h < handler.cdx.length; h++) {
      int j = handler.cdx[h];
      if (handler.j.isCellEditable(i, h)) {
        ((String[])dados.elementAt(i))[j] = "";
        on_update(cols[j].col_tag, i, "");
      }
    }
  }
  
  public String get_caption() { Component p = handler.j;
    while ((p != null) && (!(p instanceof JPanel))) p = p.getParent();
    if (p != null) for (Component c : ((JPanel)p).getComponents()) {
        if ((c instanceof JLabel)) return clean_escape(((JLabel)c).getText());
      }
    return "";
  }
  
  private static String clean_escape(String html) {
    return html.replaceAll("<br>", "\n").replaceAll("<.*?>", "").replaceAll("&", "&amp;").replaceAll("<", "&lt;");
  }
  
  private static String cell_encode(String tag, String value) {
    if ((value == null) || (value.length() == 0)) return "<" + tag + "/>\n";
    return "<" + tag + ">" + value.replaceAll("&", "&amp;").replaceAll("<", "&lt;") + "</" + tag + ">\n";
  }
}
