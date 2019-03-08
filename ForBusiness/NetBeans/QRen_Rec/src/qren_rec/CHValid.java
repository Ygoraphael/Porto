package fme;

import javax.swing.tree.DefaultMutableTreeNode;














class CHValid
{
  static int n_erros = 0;
  static int n_avisos = 0;
  
  static DefaultMutableTreeNode root = null;
  
  CHValid() {}
  
  static void reset(String _s) {
    root = new DefaultMutableTreeNode(_s);
    n_erros = 0;
    n_avisos = 0;
  }
  
  static void add_grp(CHValid_Grp grp) {
    if (grp.getChildCount() > 0) root.add(grp);
  }
  
  static void add_pg_grp(CHValid_Grp grp) {
    if (grp == null) return;
    grp_tipo = 'P';
    add_grp(grp);
  }
  




  static String show(boolean global, boolean on_send)
  {
    if (root.isLeaf())
    {
      return "-";
    }
    Dialog_Valid d = new Dialog_Valid(root, n_erros, n_avisos, global, on_send);
    return cmd;
  }
}
