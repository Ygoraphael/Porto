package fme;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;





































































class CMsgInfoSim_jButton1_actionAdapter
  implements ActionListener
{
  CMsgInfoSim adaptee;
  
  CMsgInfoSim_jButton1_actionAdapter(CMsgInfoSim adaptee)
  {
    this.adaptee = adaptee;
  }
  
  public void actionPerformed(ActionEvent e) { adaptee.jButton1_actionPerformed(e); }
}
