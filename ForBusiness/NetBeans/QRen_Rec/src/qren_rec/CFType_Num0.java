package fme;

import java.text.DecimalFormat;
import java.text.DecimalFormatSymbols;
import javax.swing.JOptionPane;




























































































































































































































































































































































































































































































































































class CFType_Num0
  extends CFTypeNumber
{
  CFType_Num0()
  {
    FMT = new DecimalFormat("#0");
  }
  
  boolean setText(String _t, boolean interact)
  {
    boolean ok = super.setText(_t, interact);
    if (!ok) {
      return false;
    }
    ok = _lib.is_number(_t, FMT.getDecimalFormatSymbols().getGroupingSeparator());
    if (!ok) {
      if (interact) {
        JOptionPane.showMessageDialog(null, "Valor incorreto.", "Erro", 
          2);
      }
      return ok;
    }
    
    int n = v.intValue();
    if (n < 0) {
      if (interact) {
        JOptionPane.showMessageDialog(null, 
          "Valor inválido (" + Integer.toString(n) + 
          ").\n" + 
          "O valor não pode ser negativo!", 
          "Erro", 
          0);
      }
      return false;
    }
    return ok;
  }
  
  boolean setString(String s)
  {
    if (s.length() == 0) {
      v = null;
      return true;
    }
    if (s.indexOf('.') > 0)
      s = s.substring(0, s.indexOf('.'));
    super.setString(s);
    return true;
  }
  
  String getString()
  {
    if (v == null) {
      return "";
    }
    return _lib.to_string(v.doubleValue());
  }
  
  boolean isnull(String _t) {
    Number x = null;
    try {
      x = FMT.parse(_t);
    }
    catch (Exception p) {
      return false;
    }
    
    return false;
  }
  
  String getText() {
    if (v == null) { return "";
    }
    
    if (v.doubleValue() == 0.0D) { return "0";
    }
    return super.getText();
  }
}
