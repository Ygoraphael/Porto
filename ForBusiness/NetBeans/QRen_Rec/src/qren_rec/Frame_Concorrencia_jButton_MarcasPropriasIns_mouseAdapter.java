package fme;

import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;






















































































































































































































































































































































































class Frame_Concorrencia_jButton_MarcasPropriasIns_mouseAdapter
  extends MouseAdapter
{
  Frame_Concorrencia adaptee;
  
  Frame_Concorrencia_jButton_MarcasPropriasIns_mouseAdapter(Frame_Concorrencia adaptee)
  {
    this.adaptee = adaptee;
  }
  
  public void mouseClicked(MouseEvent e) {
    adaptee.jButton_MarcasPropriasIns_mouseClicked(e);
  }
}