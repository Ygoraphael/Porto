package fme;

import java.awt.Dimension;
import java.awt.print.Printable;
import java.util.HashMap;

abstract interface Pagina_Base
  extends Printable
{
  public abstract void print_page();
  
  public abstract void clear_page();
  
  public abstract CHValid_Grp validar_pg();
  
  public abstract Dimension getSize();
  
  public abstract void set_params(String paramString, HashMap paramHashMap);
}
