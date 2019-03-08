package fme;

import java.util.Vector;
import javax.swing.ButtonGroup;
import javax.swing.JCheckBox;


















































































































































































































































































class CHCampo_Opt
  extends CHCampo
{
  String[] opts;
  Vector jcomps = new Vector();
  JCheckBox dummy;
  
  public CHCampo_Opt(String _tag) {
    tag = _tag;
    v = "";
    opts = null;
  }
  
  public CHCampo_Opt(String _tag, CBRegisto _dh) { tag = _tag;
    v = "";
    opts = null;
    dh = _dh;
  }
  
  public CHCampo_Opt(String _tag, String[] _opts) {
    tag = _tag;
    v = "";
    opts = _opts;
  }
  
  public CHCampo_Opt(String _tag, String[] _opts, CBRegisto _dh) { tag = _tag;
    v = "";
    opts = _opts;
    dh = _dh;
  }
  
  public CHCampo_Opt(String _tag, String _opt, CBRegisto _dh, JCheckBox _jcomp) { tag = _tag;
    v = "";
    opts = new String[] { _opt };
    addComponent(_jcomp);
    dummy = new JCheckBox();
    dh = _dh;
  }
  
  public CHCampo_Opt(String _tag, String[] _opts, CBRegisto _dh, JCheckBox... _jcomp) {
    tag = _tag;
    v = "";
    opts = _opts;
    ButtonGroup bg = new ButtonGroup();
    for (int i = 0; i < _opts.length; i++) {
      addComponent(_jcomp[i]);
      bg.add(_jcomp[i]);
    }
    dummy = new JCheckBox();
    bg.add(dummy);
    dh = _dh;
  }
  
  public void setOptions(String opt1, String opt2) { opts = new String[2];
    opts[0] = opt1;
    opts[1] = opt2;
  }
  
  public void addComponent(JCheckBox _jcomp) {
    jcomps.addElement(_jcomp);
    _jcomp.setInputVerifier(CFLib.CHInputVerifier);
    _jcomp.putClientProperty("handler", this);
  }
  
  public void addDummy(JCheckBox _jcomp) {
    dummy = _jcomp;
  }
  
  void extract() {
    v = "";
    
    for (int i = 0; i < jcomps.size(); i++) {
      if (((JCheckBox)jcomps.elementAt(i)).isSelected())
        v = opts[i];
    }
  }
  
  void clear() {
    v = "";
    
    for (int i = 0; i < jcomps.size(); i++) {
      if (((JCheckBox)jcomps.elementAt(i)).isSelected())
      {
        ((JCheckBox)jcomps.elementAt(i)).setSelected(false);
        
        dummy.setSelected(true);
      }
    }
  }
  
  void setStringValue(String _v)
  {
    v = _v;
    
    for (int i = 0; i < jcomps.size(); i++)
    {
      boolean c = opts[i].equals(v);
      ((JCheckBox)jcomps.elementAt(i)).setSelected(c);
    }
  }
  
  String getStringValue() {
    extract();
    return v;
  }
  
  boolean vldOnline() {
    String b = v;
    extract();
    if (!b.equals(v)) CBData.setDirty();
    if (dh != null) dh.on_update(tag);
    return true;
  }
}
