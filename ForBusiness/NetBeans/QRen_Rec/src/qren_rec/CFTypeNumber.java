package fme;

import java.text.DecimalFormat;
import javax.swing.JOptionPane;


































































class CFTypeNumber
  extends CFType
{
  DecimalFormat FMT;
  Number v;
  
  CFTypeNumber() {}
  
  boolean setText(String _t, boolean interact)
  {
    v = null;
    try
    {
      v = FMT.parse(_t);
    }
    catch (Exception p) {
      if (interact) {
        JOptionPane.showMessageDialog(null, "Valor incorreto.", "ERRO", 
          0);
      }
      return false;
    }
    return true;
  }
  
  boolean setString(String s)
  {
    if (s.length() == 0) {
      v = null;
      return true;
    }
    
    v = new Long(Long.parseLong(s));
    
    return true;
  }
  
  boolean setValue(Object _v) {
    v = ((Number)_v);
    return true;
  }
  
  String getText() {
    if (v == null) { return "";
    }
    
    if (v.doubleValue() == 0.0D) return "";
    return FMT.format(v);
  }
  
  String getString()
  {
    if (v == null) {
      return "";
    }
    if (v.doubleValue() == 0.0D)
      return "";
    return _lib.to_string(v.doubleValue());
  }
  
  Object getValue() {
    return v;
  }
  
  boolean acceptKey(char c) {
    if (Character.isDigit(c)) {
      return true;
    }
    
    if (c == ',') {
      return true;
    }
    if (c == '.') {
      return true;
    }
    if (c == '-') {
      return true;
    }
    return false;
  }
}
