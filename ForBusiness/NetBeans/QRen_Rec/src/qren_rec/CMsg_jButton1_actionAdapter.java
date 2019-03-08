package fme;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;




































































class CMsg_jButton1_actionAdapter
  implements ActionListener
{
  CMsg adaptee;
  
  CMsg_jButton1_actionAdapter(CMsg adaptee)
  {
    this.adaptee = adaptee;
  }
  
  public void actionPerformed(ActionEvent e) { adaptee.jButton1_actionPerformed(e); }
}
