package fme;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
































































































































































































































































































































































































































class CEnvio_jButton_Cancel_actionAdapter
  implements ActionListener
{
  CEnvio adaptee;
  
  CEnvio_jButton_Cancel_actionAdapter(CEnvio adaptee)
  {
    this.adaptee = adaptee;
  }
  
  public void actionPerformed(ActionEvent e) { adaptee.jButton_Cancel_actionPerformed(e); }
}