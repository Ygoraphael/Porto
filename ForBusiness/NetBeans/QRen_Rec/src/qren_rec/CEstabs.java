package fme;

import java.util.Vector;
import javax.swing.JComboBox;




















































































































































































































































































































































































































































































































































class CEstabs
  extends CTabela
{
  CTabela base;
  JComboBox j;
  
  CEstabs()
  {
    name = "Estabs";
    
    cCol = 0;
    dCol = 1;
    
    String[] d = new String[3];
    d[0] = "";
    d[1] = "";
    d[2] = "";
    data_table.add(d);
    

    j = null;
  }
  
  public boolean _populateComboBox(JComboBox cbo, int cCol)
  {
    int n = data_table.size();
    int m = dCol;
    


    j = cbo;
    

    return super._populateComboBox(cbo, 0);
  }
  
  public boolean _populateComboBox(JComboBox cbo) {
    j = cbo;
    return super._populateComboBox(cbo);
  }
  


  void refresh()
  {
    data_table.clear();
    












    data_table.removeAllElements();
    
    String[] d = new String[4];
    d[0] = "";
    d[1] = "";
    d[2] = "";
    d[3] = "";
    


    for (int i = 0; i < PromLocaldados.size(); i++)
    {
      String n_estab = CBData.PromLocal.getColValue("n_estab", i);
      if (n_estab.length() > 0)
      {
        d = new String[4];
        d[0] = n_estab;
        d[1] = CBData.PromLocal.getColValue("estab", i);
        d[2] = CBData.PromLocal.getColValue("concelho", i);
        d[3] = "0";
        
        data_table.add(d);
      }
    }
    
    if ((QInvstarted) && (QInvcboEstabs != null)) {
      QInvcboEstabs.removeAllItems();
      QInvcboEstabs.addItem("");
      
      for (int i = 0; i < data_table.size(); i++) {
        String[] item = (String[])data_table.elementAt(i);
        QInvcboEstabs.addItem(item[0]);
      }
    }
    
    if ((QuadrosTecnstarted) && (QuadrosTecncboEstabs != null)) {
      QuadrosTecncboEstabs.removeAllItems();
      QuadrosTecncboEstabs.addItem("");
      for (int i = 0; i < data_table.size(); i++) {
        String[] item = (String[])data_table.elementAt(i);
        QuadrosTecncboEstabs.addItem(item[0]);
      }
    }
  }
}
