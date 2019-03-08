package fme;

import javax.swing.tree.DefaultMutableTreeNode;



























































class CHValid_Grp
  extends DefaultMutableTreeNode
{
  CBData_Comum handler;
  String title;
  int msg_count = 0;
  int err_count = 0;
  char grp_tipo;
  
  CHValid_Grp(String _title) {
    handler = null;
    title = _title;
  }
  
  CHValid_Grp(CBData_Comum _handler, String _title) {
    super(_title);
    handler = _handler;
    title = _title;
    grp_tipo = 'G';
  }
  
  void add_msg(CHValid_Msg msg) {
    add(msg);
    msg_count += 1;
    if (tipo == 'E') CHValid.n_erros += 1;
    if (tipo == 'W') CHValid.n_avisos += 1;
    if (tipo == 'E') err_count += 1;
  }
  
  void add_grp(CHValid_Grp grp) {
    if (grp == null) return;
    if (msg_count > 0) add(grp);
  }
  
  public String toString() {
    return title;
  }
}
