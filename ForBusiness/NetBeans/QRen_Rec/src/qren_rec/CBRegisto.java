package fme;

import java.util.Vector;

























class CBRegisto
  extends XMLDataHandler
  implements CBData_Comum
{
  CBRegisto() {}
  
  Vector Campos = new Vector();
  boolean started = false;
  
  public void add(CHCampo c) {
    Campos.addElement(c);
  }
  

  public void xmlValue(String path, String tag, String v)
  {
    CHCampo c = getByName(tag);
    if (c == null) return;
    if (!xml_enabled) { return;
    }
    if (((c instanceof CHCampo_Text)) && 
      (((vld instanceof CFType_Perc)) || ((vld instanceof CFType_Perc0))) && 
      (v.length() > 0)) { v = _lib.round4(_lib.to_double(v) * 100.0D);
    }
    
    if (((c instanceof CHCampo_Combo)) && 
      (tabname != null) && (!tabname.equals(""))) {
      CTabela t = CTabelas.getTabByName(tabname);
      if (t.lookup(v) == null) { v = "";
      }
    }
    c.setStringValue(v);
  }
  


  public CHCampo getByName(String s)
  {
    for (int i = 0; i < Campos.size(); i++)
    {
      String tag = Campos.elementAt(i)).tag;
      if (tag.equals(s)) return (CHCampo)Campos.elementAt(i);
    }
    return null;
  }
  
  public String xmlPrintBegin() {
    return super.xmlPrintBegin() + "\n";
  }
  
  public String xmlPrint()
  {
    String s = new String();
    

    s = "";
    
    for (int i = 0; i < Campos.size(); i++) {
      CHCampo c = (CHCampo)Campos.elementAt(i);
      if (xml_enabled) {
        String v = v;
        if (((c instanceof CHCampo_Text)) && 
          (((vld instanceof CFType_Perc)) || ((vld instanceof CFType_Perc0))) && 
          (v.length() > 0)) { v = _lib.round4(_lib.to_double(v) / 100.0D);
        }
        
        s = s + _lib.xml_encode(tag, v);
      }
      if (dh != null) {
        s = s + dh.on_xml(tag);
      }
    }
    
    return s;
  }
  
  void extract() {
    for (int i = 0; i < Campos.size(); i++) {
      ((CHCampo)Campos.elementAt(i)).extract();
    }
  }
  
  void Clear() {
    for (int i = 0; i < Campos.size(); i++) {
      ((CHCampo)Campos.elementAt(i)).clear();
    }
  }
  

  void on_update(String tag) {}
  

  String on_xml(String tag)
  {
    return "";
  }
  
  CHValid_Grp validar() {
    return null;
  }
  







  public void on_external_update(String tag) {}
  







  public void locate(CHValid_Msg m) {}
  






  public String getParam(String param)
  {
    return null;
  }
  
  public String getPagina() {
    return null;
  }
  
  boolean isEmpty() {
    for (int i = 0; i < Campos.size(); i++) {
      CHCampo c = (CHCampo)Campos.elementAt(i);
      if (!c.isEmpty()) return false;
    }
    return true;
  }
}
