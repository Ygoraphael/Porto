package fme;

import javax.swing.JFormattedTextField;
import javax.swing.JTextField;














































































class CHCampo_Text
  extends CHCampo
{
  JTextField jcomp;
  CFType vld;
  String undo_v;
  
  public CHCampo_Text(String _tag, JTextField _jcomp, CFType _vld)
  {
    tag = _tag;
    v = "";
    setComponent(_jcomp);
    vld = _vld;
    dh = null;
  }
  
  public CHCampo_Text(String _tag, JTextField _jcomp, CFType _vld, CBRegisto _dh) {
    tag = _tag;
    v = "";
    setComponent(_jcomp);
    vld = _vld;
    dh = _dh;
  }
  
  public void setComponent(JTextField _jcomp)
  {
    jcomp = _jcomp;
    jcomp.setInputVerifier(CFLib.CHInputVerifier);
    jcomp.putClientProperty("handler", this);
  }
  
  void extract() {
    if (jcomp.getInputVerifier() != null) return;
    v = jcomp.getText();
  }
  
  void clear() {
    v = "";
    jcomp.setText(v);
  }
  




  void setStringValue(String _v)
  {
    v = _v;
    if ((v == null) || (_v.equals("0.0"))) v = "";
    String t = v;
    if ((vld != null) && (_v.length() > 0)) {
      vld.setString(_v);
      t = vld.getText();
      
      v = vld.getString();
    }
    jcomp.setText(t);
    if (dh != null) dh.on_update(tag);
  }
  
  boolean vldOnline() {
    if (CHCampo_InputVerifier.editing == null) undo_v = v;
    String b = v;
    



    if ((jcomp instanceof JFormattedTextField))
      try { ((JFormattedTextField)jcomp).commitEdit();
      } catch (Exception localException) {}
    v = jcomp.getText();
    
    if ((v.length() == 0) && 
      ((jcomp instanceof JFormattedTextField))) {
      ((JFormattedTextField)jcomp).setValue(null);
      if (dh != null) dh.on_update(tag);
      if (!b.equals(v)) CBData.setDirty();
      return true;
    }
    


    if ((vld != null) && (vld.isnull(v))) {
      jcomp.setText("");
      v = "";
      if (dh != null) dh.on_update(tag);
      if (!b.equals(jcomp.getText())) CBData.setDirty();
      return true;
    }
    
    if (vld == null)
    {
      if (dh != null) dh.on_update(tag);
      if (!b.equals(v)) CBData.setDirty();
      return true;
    }
    

    boolean ok = vld.setText(v);
    if (ok) {
      v = vld.getString();
      
      if ((jcomp instanceof JFormattedTextField))
      {
        ((JFormattedTextField)jcomp).setText(vld.getText());
      }
    }
    if ((dh != null) && (ok)) { dh.on_update(tag);
    }
    if ((ok) && (!b.equals(v))) CBData.setDirty();
    return ok;
  }
  
  double valueAsDouble() {
    if (v.length() == 0) { return 0.0D;
    }
    return _lib.to_double(v);
  }
  
  void set_focus()
  {
    jcomp.requestFocus();
  }
  
  void setValue(Object _v) {
    v = _v.toString();
    String s = v;
    if (vld != null) {
      vld.setValue(_v);
      v = vld.getString();
      s = vld.getText();
    }
    jcomp.setText(s);
  }
  
  void cancel_editing()
  {
    setStringValue(undo_v);
    CHCampo_InputVerifier.editing = null;
  }
}
