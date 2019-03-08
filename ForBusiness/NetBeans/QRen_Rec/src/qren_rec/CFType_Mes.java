package fme;

import java.text.DecimalFormat;
import javax.swing.JOptionPane;














































































































































































































































class CFType_Mes
  extends CFTypeNumber
{
  CFType_Mes()
  {
    FMT = new DecimalFormat("00");
  }
  

  boolean setText(String _t, boolean interact)
  {
    boolean ok = super.setText(_t, interact);
    if (!ok) {
      return false;
    }
    
    ok = _lib.is_digitsOnly(_t);
    if (!ok) {
      if (interact) {
        JOptionPane.showMessageDialog(null, "Valor incorreto.", "Erro", 
          2);
      }
      return ok;
    }
    
    int n = v.intValue();
    
    if ((n < 1) || (n > 12)) {
      if (interact) {
        JOptionPane.showMessageDialog(null, 
          "Valor de Mês inválido " + 
          Integer.toString(n) + ".", "Erro", 
          2);
      }
      return false;
    }
    return ok;
  }
  
  String getString() {
    if (v == null) {
      return "";
    }
    
    return getText();
  }
  
  boolean isnull(String _t) {
    Number x = null;
    try {
      x = FMT.parse(_t);
    }
    catch (Exception p) {
      return false;
    }
    if (x.doubleValue() == 0.0D) {
      return true;
    }
    return false;
  }
}
