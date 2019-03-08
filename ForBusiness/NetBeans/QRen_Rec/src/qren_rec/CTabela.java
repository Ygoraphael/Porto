package fme;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.Vector;
import javax.swing.JComboBox;






































































































































































































































class CTabela
{
  String name;
  String[] titles;
  Vector data_table = new Vector();
  int cCol;
  int dCol;
  
  public CTabela() {}
  
  public CTabela(String nome) {
    _init_tab(nome);
    cCol = 0;
    dCol = 1;
  }
  
  public CTabela(String nome, String filename) {
    _init_tab(nome, filename);
    cCol = 0;
    dCol = 1;
  }
  










  public String getCodeFromIndex(int idx)
  {
    return getColFromIndex(idx, cCol);
  }
  
  public String getDesignFromIndex(int idx) {
    return getColFromIndex(idx, dCol);
  }
  
  public String getColFromIndex(int idx, int nCol)
  {
    String[] item = (String[])data_table.elementAt(idx - 1);
    
    return item[nCol];
  }
  
  String lookup(String codigo) {
    return lookup(cCol, codigo, dCol);
  }
  

  String lookup(int _cCol, String codigo, int _dCol)
  {
    for (int i = 0; i < data_table.size(); i++) {
      String[] item = (String[])data_table.elementAt(i);
      if (item[_cCol].equals(codigo))
        return item[_dCol];
    }
    return null;
  }
  
  int getIndexFromCode(String codigo)
  {
    return getIndexFromCol(cCol, codigo);
  }
  
  int getIndexFromDesign(String codigo) {
    return getIndexFromCol(dCol, codigo);
  }
  
  String getCodeFromDesign(String codigo) {
    int n = getIndexFromCol(dCol, codigo);
    return getCodeFromIndex(n);
  }
  
  int getIndexFromCol(int col, String codigo)
  {
    if ((codigo == null) || (codigo.length() == 0)) { return 0;
    }
    
    for (int i = 0; i < data_table.size(); i++) {
      String[] item = (String[])data_table.elementAt(i);
      if (item[col].equals(codigo))
        return i;
    }
    return 0;
  }
  
  String getDesign(String code) {
    int n = getIndexFromCode(code);
    return getDesignFromIndex(n + 1);
  }
  



  public boolean _populateComboBox(JComboBox cbo)
  {
    return _populateComboBox(cbo, dCol);
  }
  
  public boolean _populateComboBox(JComboBox cbo, int nCol) {
    cbo.removeAllItems();
    cbo.addItem("");
    

    for (int i = 0; i < data_table.size(); i++) {
      String[] item = (String[])data_table.elementAt(i);
      cbo.addItem(item[nCol]);
    }
    return true;
  }
  



  public boolean _init_tab(String tabname)
  {
    return _init_tab(tabname, tabname + ".tab");
  }
  



  public boolean _init_tab(String tabname, String filename)
  {
    name = tabname;
    







    try
    {
      BufferedReader in = new BufferedReader(
      
        new InputStreamReader(getClass().getResourceAsStream(filename), "CP1252"));
      


      String s = in.readLine();
      if (s == null) return false;
      titles = explode(s);
      for (;;)
      {
        s = in.readLine();
        if (s == null) {
          break;
        }
        data_table.add(explode(s));
      }
      




      return true;
    } catch (IOException localIOException) {}
  }
  
  public String[] explode(String s) {
    int n_elem = 0;
    String[] temp = new String[20];
    int i = s.indexOf('|', 0);
    
    while (i > 0) {
      temp[n_elem] = new String(s.substring(0, i));
      
      n_elem++;
      s = s.substring(i + 1);
      i = s.indexOf('|', 0);
    }
    if (s.length() > 0) {
      temp[n_elem] = new String(s);
      
      n_elem++;
    }
    
    String[] a_row = new String[n_elem];
    for (i = 0; i < n_elem; i++) {
      a_row[i] = temp[i];
    }
    return a_row;
  }
}
