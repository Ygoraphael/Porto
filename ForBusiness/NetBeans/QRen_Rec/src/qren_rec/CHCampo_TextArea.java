package fme;

import javax.swing.JTextArea;
































































































































































































































class CHCampo_TextArea
  extends CHCampo
{
  JTextArea jcomp;
  
  public CHCampo_TextArea(String _tag, JTextArea _jcomp, CBRegisto _dh)
  {
    tag = _tag;
    v = "";
    
    setComponent(_jcomp);
    

    dh = _dh;
  }
  
  public void setComponent(JTextArea _jcomp) {
    jcomp = _jcomp;
    jcomp.setInputVerifier(CFLib.CHInputVerifier);
    jcomp.putClientProperty("handler", this);
  }
  
  void extract() {
    v = jcomp.getText();
  }
  
  boolean vldOnline()
  {
    String b = v;
    extract();
    if (!b.equals(v)) CBData.setDirty();
    if (dh != null) dh.on_update(tag);
    return true;
  }
  
  void clear() {
    v = "";
    jcomp.setText(v);
  }
  
  void setStringValue(String _v)
  {
    v = _v;
    String t = v;
    jcomp.setText(t);
  }
}
