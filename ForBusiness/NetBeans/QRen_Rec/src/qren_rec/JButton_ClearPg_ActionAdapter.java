package fme;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;






















































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class JButton_ClearPg_ActionAdapter
  implements ActionListener
{
  JButton_ClearPg_ActionAdapter() {}
  
  public void actionPerformed(ActionEvent e)
  {
    fmeApp.comum.limpar_pg();
  }
}