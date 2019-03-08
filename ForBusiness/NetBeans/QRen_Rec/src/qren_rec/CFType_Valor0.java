package fme;

import javax.swing.JOptionPane;































































































































































































































































































































































































































































































































































































































































































































































































































































































class CFType_Valor0
  extends CFType_ValorS0
{
  CFType_Valor0() {}
  
  boolean setText(String _t, boolean interact)
  {
    boolean ok = super.setText(_t, interact);
    
    if ((ok) && (v != null) && (v.doubleValue() < 0.0D)) {
      if (interact) {
        JOptionPane.showMessageDialog(null, "Valor inválido (" + _t + ").\n" + 
          "O valor não pode ser negativo!", 
          "Erro", 
          0);
      }
      return false;
    }
    

    return ok;
  }
  
  boolean acceptKey(char c) {
    if (Character.isDigit(c))
      return true;
    if (c == ',')
      return true;
    if (c == '.')
      return true;
    if (c == '-')
      return true;
    return false;
  }
}