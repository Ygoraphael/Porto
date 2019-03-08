package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
import javax.swing.Icon;
import javax.swing.ImageIcon;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTree;
import javax.swing.tree.DefaultMutableTreeNode;
import javax.swing.tree.TreeCellRenderer;













































































































































































































































































































class MyTreeRenderer
  implements TreeCellRenderer
{
  protected JLabel theLabel;
  protected TreeTextArea theTextArea;
  protected JPanel thePanel;
  
  public MyTreeRenderer()
  {
    theTextArea = new TreeTextArea();
    theLabel = new JLabel();
    thePanel = new JPanel();
    theLabel.setOpaque(false);
    theTextArea.setOpaque(false);
    thePanel.setOpaque(false);
    thePanel.add(theLabel, "West");
    thePanel.add(theTextArea, "West");
  }
  





  public Component getTreeCellRendererComponent(JTree tree, Object value, boolean selected, boolean expanded, boolean leaf, int row, boolean hasFocus)
  {
    Icon raizIcon = new ImageIcon(fmeFrame.class.getResource("Portugal2020-2.gif"));
    Icon paginaIcon = new ImageIcon(fmeFrame.class.getResource("pagina.gif"));
    Icon grupoIcon = new ImageIcon(fmeFrame.class.getResource("grupo.gif"));
    Icon erroIcon = new ImageIcon(fmeFrame.class.getResource("erro.gif"));
    Icon avisoIcon = new ImageIcon(fmeFrame.class.getResource("aviso.gif"));
    
    theTextArea.setText(value.toString());
    
    if (selected) {
      thePanel.setOpaque(true);
      

      thePanel.setBackground(new Color(227, 227, 227));
      theTextArea.setForeground(fmeComum.corLabel);
    }
    else {
      thePanel.setOpaque(false);
    }
    

    if ((value instanceof DefaultMutableTreeNode)) {
      theLabel.setIcon(raizIcon);
      theTextArea.setFont(fmeComum.letra_bold);
    }
    if ((value instanceof CHValid_Grp)) {
      theTextArea.setFont(fmeComum.letra_bold);
      char tipo = grp_tipo;
      if (tipo == 'G') theLabel.setIcon(null);
      if (tipo == 'P') theLabel.setIcon(null);
      theTextArea.setFont(fmeComum.letra_bold);
    }
    if ((value instanceof CHValid_Msg)) {
      if (tipo == 'E') theLabel.setIcon(erroIcon); else
        theLabel.setIcon(avisoIcon);
      theTextArea.setFont(fmeComum.letra);
    }
    
    return thePanel;
  }
  
  public Dimension getPreferredSize() {
    return new Dimension(thePanel.getPreferredSize());
  }
}
