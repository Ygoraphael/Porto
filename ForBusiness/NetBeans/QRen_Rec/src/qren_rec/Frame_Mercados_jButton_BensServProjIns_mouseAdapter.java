package fme;

import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;


















































































































































































































































































































































































































































































































































































































































































































































































class Frame_Mercados_jButton_BensServProjIns_mouseAdapter
  extends MouseAdapter
{
  Frame_Mercados adaptee;
  
  Frame_Mercados_jButton_BensServProjIns_mouseAdapter(Frame_Mercados adaptee)
  {
    this.adaptee = adaptee;
  }
  
  public void mouseClicked(MouseEvent e) { adaptee.jButton_BensServProjIns_mouseClicked(e); }
}