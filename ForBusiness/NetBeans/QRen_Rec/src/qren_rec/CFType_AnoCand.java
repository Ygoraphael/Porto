package fme;

import java.text.DecimalFormat;
import javax.swing.JOptionPane;

































































































































































































class CFType_AnoCand
  extends CFTypeNumber
{
  CFType_AnoCand()
  {
    FMT = new DecimalFormat("####");
  }
  
  static int ano_inicial = 2014;
  static int ano_final = 2020;
  
  boolean setText(String _t, boolean interact) {
    boolean ok = super.setText(_t, interact);
    if (!ok) {
      return ok;
    }
    
    ok = _lib.is_digitsOnly(_t);
    if (!ok) {
      if (interact) {
        JOptionPane.showMessageDialog(null, "Valor incorrecto. " + _t, "Erro", 
          0);
      }
      return ok;
    }
    
    int n = v.intValue();
    

    if ((n < ano_inicial) || (n > ano_final)) {
      if (interact) {
        JOptionPane.showMessageDialog(null, 
          "Valor de Ano inválido (" + 
          Integer.toString(n) + ").", "Erro", 
          2);
      }
      return false;
    }
    return ok;
  }
  
  boolean acceptKey(char c) {
    return Character.isDigit(c);
  }
}
