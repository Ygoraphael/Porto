package fme;

import java.text.DecimalFormat;
import java.text.DecimalFormatSymbols;
import javax.swing.JOptionPane;























































































































































































































































































































































































class CFType_Perc0
  extends CFTypeNumber
{
  CFType_Perc0()
  {
    FMT = new DecimalFormat("#0.00");
  }
  
  boolean setText(String _t, boolean interact) {
    boolean ok = super.setText(_t, interact);
    if (!ok) {
      return false;
    }
    
    ok = _lib.is_perc(_t, FMT.getDecimalFormatSymbols().getDecimalSeparator());
    if (!ok) {
      if (interact) {
        JOptionPane.showMessageDialog(null, "Valor incorreto.", "Erro", 
          2);
      }
      return ok;
    }
    
    if (ok) {
      double d = v.doubleValue();
      if ((d < 0.0D) || (d > 100.0D)) {
        String msg = v + " - Valor inválido para este campo!\n" + 
          "Por favor, introduza um valor entre 0,00 e 100,00.";
        
        if (interact) {
          JOptionPane.showMessageDialog(null, msg, "Percentagem inválida", 
            2);
        }
        return false;
      }
    }
    return true;
  }
  
  boolean acceptKey(char c)
  {
    if (Character.isDigit(c)) {
      return true;
    }
    if (c == ',') {
      return true;
    }
    if (c == '.') {
      return true;
    }
    return false;
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
    if (v == null) {
      return "";
    }
    
    if (v.doubleValue() == 0.0D) {
      return "0";
    }
    return super.getText();
  }
  
  boolean setString(String s)
  {
    if (s.length() == 0) {
      v = null;
      return true;
    }
    v = new Double(Double.parseDouble(s));
    
    return true;
  }
  
  String getString()
  {
    if (v == null) {
      return "";
    }
    return _lib.to_string(v.doubleValue());
  }
}
