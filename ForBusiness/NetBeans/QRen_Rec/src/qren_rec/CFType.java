package fme;

import javax.swing.text.InternationalFormatter;





















































class CFType
  extends InternationalFormatter
{
  CFType() {}
  
  boolean setText(String _t) { return setText(_t, true); }
  boolean setText(String _t, boolean interact) { return false; }
  boolean setString(String _s) { return false; }
  boolean setValue(Object _v) { return false; }
  String getText() { return ""; }
  String getString() { return ""; }
  Object getValue() { return null; }
  boolean acceptKey(char c) { return true; }
  boolean isnull(String s) { return s.length() == 0; }
}
