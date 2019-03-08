package fme;

import javax.swing.tree.DefaultMutableTreeNode;































































































class CHValid_Msg
  extends DefaultMutableTreeNode
{
  String tag;
  char tipo;
  int row;
  int col;
  
  CHValid_Msg(String _tag, char _tipo, String _msg)
  {
    super(_msg.replaceAll("%o", "Preenchimento Obrigatório"));
    tag = _tag;
    tipo = _tipo;
    row = -1;col = -1;
  }
  
  CHValid_Msg(String _tag, String _msg)
  {
    super(_msg.replaceAll("\n", " ").replaceAll("<br>", " ").replaceAll("<html>", "").replaceAll("</html>", "").replaceAll("<div align='center'>", "").replaceAll("</div>", "").replaceAll("%o", "Preenchimento Obrigatório"));
    
    tag = _tag;
    tipo = 'E';
    row = -1;col = -1;
  }
  
  CHValid_Msg(String _tag, String _msg, int _row, int _col)
  {
    super(_msg.replaceAll("%o", "Preenchimento Obrigatório"));
    tag = _tag;
    tipo = 'E';
    row = _row;col = _col;
  }
}
