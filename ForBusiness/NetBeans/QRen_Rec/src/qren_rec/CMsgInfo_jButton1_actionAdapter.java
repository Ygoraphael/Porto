package fme;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;


















































































class CMsgInfo_jButton1_actionAdapter
  implements ActionListener
{
  CMsgInfo adaptee;
  
  CMsgInfo_jButton1_actionAdapter(CMsgInfo adaptee)
  {
    this.adaptee = adaptee;
  }
  
  public void actionPerformed(ActionEvent e) {
    adaptee.jButton1_actionPerformed(e);
  }
}
