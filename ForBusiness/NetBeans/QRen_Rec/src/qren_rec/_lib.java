package fme;

import java.text.DecimalFormat;





























































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class _lib
{
  _lib() {}
  
  static boolean is_digitsOnly(String s)
  {
    for (int i = 0; i < s.length(); i++) {
      if (!Character.isDigit(s.charAt(i))) {
        return false;
      }
    }
    return true;
  }
  
  static boolean is_number(String s, char g_sep)
  {
    int cg = 0;
    for (int i = s.length() - 1; i >= 0; i--)
      if ((s.charAt(i) != '-') || (i != 0))
      {

        cg++;
        if (!Character.isDigit(s.charAt(i))) {
          if (cg != 4) {
            return false;
          }
          if (s.charAt(i) != g_sep) {
            return false;
          }
          cg = 0;
        }
        else if (cg == 4) {
          cg = 0;
        }
      }
    return true;
  }
  
  static boolean is_perc(String s, char d_sep) {
    int n = s.indexOf(d_sep);
    if (n >= 0) {
      return (is_digitsOnly(s.substring(0, n))) && 
        (is_digitsOnly(s.substring(n + 1, s.length())));
    }
    return is_digitsOnly(s);
  }
  
  static boolean is_value(String s, char d_sep, char g_sep)
  {
    if (s.startsWith("-")) {
      s = s.substring(1);
    }
    int n = s.indexOf(d_sep);
    if (n >= 0) {
      return (is_number(s.substring(0, n), g_sep)) && 
        (is_digitsOnly(s.substring(n + 1, s.length())));
    }
    return is_number(s, g_sep);
  }
  
  static boolean is_date(String s) {
    int n = s.indexOf('-');
    if (n <= 0) {
      return false;
    }
    if (!is_digitsOnly(s.substring(0, n))) {
      return false;
    }
    int ano = Integer.parseInt(s.substring(0, n));
    if ((ano < 1800) || (ano > 2025)) {
      return false;
    }
    
    int n1 = s.indexOf('-', n + 1);
    if (n1 <= 0) {
      return false;
    }
    if (!is_digitsOnly(s.substring(n + 1, n1))) {
      return false;
    }
    int mes = Integer.parseInt(s.substring(n + 1, n1));
    if ((mes < 1) || (mes > 12)) {
      return false;
    }
    
    if (s.length() <= n1) {
      return false;
    }
    if (!is_digitsOnly(s.substring(n1 + 1, s.length()))) {
      return false;
    }
    int dia = Integer.parseInt(s.substring(n1 + 1, s.length()));
    if ((dia < 1) || (dia > 31)) {
      return false;
    }
    if ((dia == 31) && ((mes == 2) || (mes == 4) || (mes == 6) || (mes == 11))) {
      return false;
    }
    if ((mes == 2) && (dia > 29)) {
      return false;
    }
    if ((mes == 2) && (dia == 29)) {
      return ano % 4 == 0;
    }
    return true;
  }
  
  static boolean exact_match(String v, String p)
  {
    if (v.length() != p.length()) {
      return false;
    }
    for (int i = 0; i < v.length(); i++) {
      if (p.charAt(i) == '#') {
        if (!Character.isDigit(v.charAt(i))) {
          return false;
        }
      }
      else if (p.charAt(i) != v.charAt(i)) {
        return false;
      }
    }
    return true;
  }
  
  static double get_double(String s)
  {
    Number v = null;
    try {
      v = VLD_VALOR_SFMT.parse(s);
    }
    catch (Exception localException) {}
    
    if (v == null) {
      return 0.0D;
    }
    return v.doubleValue();
  }
  
  static String xml_encode(String tag, String v)
  {
    String xml = null;
    v = v.replaceAll("&", "&amp;");
    v = v.replaceAll("<", "&lt;");
    
    for (int i = 0; i < v.length(); i++) {
      char c = v.charAt(i);
      if ((c >= '') && (c <= '')) v = v.replace(c, '?');
      if ((c < ' ') && (c != '\t') && (c != '\n') && (c != '\r')) { v = v.replace(c, '?');
      }
    }
    xml = "<" + tag + ">";
    xml = xml + v;
    xml = xml + "</" + tag + ">\n";
    
    return xml;
  }
  
  static String to_string(double v) {
    v = round(v);
    String s = Double.toString(v);
    if (v == (int)v) s = Integer.toString((int)v);
    if ((v != v) || (s.indexOf('E') > 0) || (s.indexOf('e') > 0)) {
      DecimalFormat f = new DecimalFormat("######################0.##");
      s = f.format(round(v));
      s = s.replace(',', '.');
    }
    return s;
  }
  
  static double round(double x) { long l;
    long l;
    if (x >= 0.0D) {
      l = ((x + 0.005D) * 100.0D);
    } else
      l = ((x - 0.005D) * 100.0D);
    if ((x.endsWith(".005")) && (l.endsWith("0"))) {
      if (x > 0.0D) l += 1L; else
        l -= 1L;
    }
    return l / 100.0D;
  }
  
  static double round4(double x) { long l;
    long l;
    if (x >= 0.0D) {
      l = ((x + 5.0E-5D) * 10000.0D);
    } else
      l = ((x - 5.0E-5D) * 10000.0D);
    if ((x.endsWith(".00005")) && (l.endsWith("0"))) {
      if (x > 0.0D) l += 1L; else
        l -= 1L;
    }
    return l / 10000.0D;
  }
  
  static double to_double(String s) {
    double x = 0.0D;
    if (s.length() == 0) {
      return x;
    }
    x = Double.parseDouble(s);
    return x;
  }
  
  static String to_format(double d) {
    return VLD_VALORFMT.format(d);
  }
  
  static int to_int(String s) {
    int x = 0;
    if (s.length() == 0) {
      return x;
    }
    x = Integer.parseInt(s);
    return x;
  }
  
  static String get_pagina(String s) {
    int n = s.indexOf("-");
    String pagina = s.substring(0, n - 1);
    return pagina;
  }
  
  static String get_titulo(String s) {
    int n = s.indexOf("-");
    String titulo = s.substring(n + 1, s.length());
    return titulo;
  }
  
  static int numUnNull(String t) {
    if (t == null) return 0;
    if (t.length() == 0) return 0;
    return Integer.parseInt(t);
  }
}
