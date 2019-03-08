package fme;

import java.text.SimpleDateFormat;
import java.util.Date;
import javax.swing.JOptionPane;
































































































































































































































































































































































































































































































































































































































































































































































































































































































































class CFType_Data
  extends CFType
{
  Date d;
  static SimpleDateFormat FMT;
  
  CFType_Data()
  {
    FMT = new SimpleDateFormat("yyyy-MM-dd");
  }
  
  boolean setText(String _t, boolean interact)
  {
    _t = _t.replace(' ', '-');
    _t = _t.replace('/', '-');
    _t = _t.replace('.', '-');
    
    if (_lib.exact_match(_t, "#-#-####")) {
      _t = "0" + _t;
    }
    if (_lib.exact_match(_t, "#-##-####")) {
      _t = "0" + _t;
    }
    if (_lib.exact_match(_t, "##-#-####")) {
      _t = _t.substring(0, 3) + "0" + _t.substring(3, 9);
    }
    if (_lib.exact_match(_t, "##-##-####")) {
      _t = 
        _t.substring(6, 10) + "-" + _t.substring(3, 5) + "-" + _t.substring(0, 2);
    }
    
    if ((_t.length() >= 3) && (_lib.exact_match(_t.substring(0, 3), "##-"))) {
      _t = "20" + _t;
    }
    if ((_t.length() == 8) && (_lib.is_digitsOnly(_t))) {
      _t = 
        _t.substring(0, 4) + "-" + _t.substring(4, 6) + "-" + _t.substring(6, 8);
    }
    
    try
    {
      d = FMT.parse(_t);
    }
    catch (Exception p) {
      if (interact) {
        JOptionPane.showMessageDialog(null, "Data inválida.", "Erro", 
          0);
      }
      return false;
    }
    
    String erro = "Data incorreta.";
    








    boolean ok = _lib.is_date(_t);
    if (!ok) {
      if (interact) {
        JOptionPane.showMessageDialog(null, erro, "Erro", 
          0);
      }
      return ok;
    }
    
    if (_t.length() != 10) {
      ok = false;
    }
    if (!ok) {
      if (interact) {
        JOptionPane.showMessageDialog(null, erro, "Erro", 
          0);
      }
      return ok;
    }
    
    return ok;
  }
  
  String getText() {
    if (d == null) {
      return "";
    }
    return FMT.format(d);
  }
  
  String getString() {
    return getText();
  }
  
  boolean setString(String _t) {
    if (_t.length() == 0) {
      d = null;
      return true;
    }
    boolean ok = true;
    try {
      d = FMT.parse(_t);
    }
    catch (Exception e) {
      ok = false;
    }
    
    return ok;
  }
  
  static Date parse_date(String s) {
    Date d = null;
    try {
      d = FMT.parse(s);
    }
    catch (Exception localException) {}
    

    return d;
  }
  
  static String to_string(Date d) {
    String s = "";
    if (d == null) {
      return s;
    }
    return FMT.format(d);
  }
  
  boolean acceptKey(char c) {
    if (Character.isDigit(c)) {
      return true;
    }
    if (c == '/') {
      return true;
    }
    if (c == '-') {
      return true;
    }
    return false;
  }
}
