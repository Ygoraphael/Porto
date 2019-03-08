package fme;




class CHCampo
{
  public String tag;
  


  String v;
  


  CBRegisto dh;
  

  boolean xml_enabled;
  


  public CHCampo()
  {
    dh = null;
    xml_enabled = true;
    v = "";
    tag = "";
  }
  
  public CHCampo(String _tag) {
    dh = null;
    xml_enabled = true;
    v = "";
    tag = _tag;
  }
  
  void extract() {}
  
  void clear()
  {
    v = "";
  }
  
  void setStringValue(String _v)
  {
    v = _v;
  }
  
  String getStringValue() {
    return v;
  }
  
  boolean vldOnline() {
    return true;
  }
  
  void show() {}
  
  boolean isEmpty()
  {
    if (v == null) return true;
    return v.trim().length() == 0;
  }
  
  double valueAsDouble() {
    return 0.0D;
  }
  
  void set_focus() {}
  
  void setValue(Object v) {}
  
  void cancel_editing() {}
}
