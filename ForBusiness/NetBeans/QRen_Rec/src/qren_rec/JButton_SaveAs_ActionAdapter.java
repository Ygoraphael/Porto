package fme;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
























































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class JButton_SaveAs_ActionAdapter
  implements ActionListener
{
  JButton_SaveAs_ActionAdapter() {}
  
  public void actionPerformed(ActionEvent e)
  {
    fmeApp.comum.guardar(true, false, false, false, false);
  }
}