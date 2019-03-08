package fme;

import javax.swing.JComboBox;










































































































































































































































































































































































































class CHCampo_Combo
  extends CHCampo
{
  String tabname;
  JComboBox jcomp;
  int v_idx;
  String v_text;
  
  public CHCampo_Combo(String _tag, String _tabname, JComboBox _jcomp)
  {
    tag = _tag;
    tabname = _tabname;
    jcomp = _jcomp;
    v = "";
    
    CTabela t = CTabelas.getTabByName(tabname);
    t._populateComboBox(jcomp);
    






    dh = null;
  }
  
  public CHCampo_Combo(String _tag, String _tabname, JComboBox _jcomp, CBRegisto _dh) {
    tag = _tag;
    tabname = _tabname;
    jcomp = _jcomp;
    v = "";
    

    CTabela t = CTabelas.getTabByName(tabname);
    t._populateComboBox(jcomp);
    


    jcomp.putClientProperty("handler", this);
    jcomp.setInputVerifier(CFLib.CHInputVerifier);
    

    dh = _dh;
  }
  
  public CHCampo_Combo(String _tag, String _tabname, JComboBox _jcomp, CBRegisto _dh, boolean d) {
    tag = _tag;
    tabname = _tabname;
    jcomp = _jcomp;
    v = "";
    

    CTabela t = CTabelas.getTabByName(tabname);
    if (d) jcomp.setRenderer(new RegiaoCellRenderer(t));
    t._populateComboBox(jcomp, d ? 0 : dCol);
    



    jcomp.putClientProperty("handler", this);
    jcomp.setInputVerifier(CFLib.CHInputVerifier);
    

    dh = _dh;
  }
  






  void extract()
  {
    v_idx = jcomp.getSelectedIndex();
    v_text = ((String)jcomp.getSelectedItem());
    v = "";
    if (v_idx > 0)
    {
      v = CTabelas.getTabByName(tabname).getCodeFromIndex(v_idx);
    }
  }
  










  void clear()
  {
    if (jcomp.getItemCount() > 0)
      jcomp.setSelectedIndex(0);
    v = "";
  }
  
  void setStringValue(String _v)
  {
    v = _v;
    if (v.length() > 0) {
      v_idx = (CTabelas.getTabByName(tabname).getIndexFromCode(v) + 1);
      jcomp.setSelectedIndex(v_idx);
    }
  }
  





  boolean vldOnline()
  {
    String b = v;
    extract();
    if (!b.equals(v)) CBData.setDirty();
    if (dh != null) dh.on_update(tag);
    return true;
  }
}
