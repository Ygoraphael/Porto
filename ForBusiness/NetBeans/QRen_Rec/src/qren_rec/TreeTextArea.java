package fme;

import java.awt.Color;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.FontMetrics;
import java.util.StringTokenizer;
import java.util.Vector;
import javax.swing.BorderFactory;
import javax.swing.JPanel;
import javax.swing.JTextArea;
import javax.swing.UIManager;
import javax.swing.plaf.ColorUIResource;


















































































































































































































































































































































































class TreeTextArea
  extends JTextArea
{
  Dimension preferredSize;
  
  TreeTextArea()
  {
    setLineWrap(true);
    setWrapStyleWord(true);
    setOpaque(true);
  }
  
  public void setBackground(Color color) {
    if ((color instanceof ColorUIResource))
      color = null;
    super.setBackground(color);
  }
  
  public void setPreferredSize(Dimension d) {
    if (d != null)
      preferredSize = d;
  }
  
  public Dimension getPreferredSize() {
    return preferredSize;
  }
  
  public void setText(String str)
  {
    Vector resultado = new Vector();
    int maxWidth = 415;
    JPanel pn = new JPanel();
    FontMetrics fm = pn.getFontMetrics(getFont());
    resultado = quebraLinhas(getFont(), str, maxWidth);
    int lines = resultado.toArray().length;
    lines = lines >= 1 ? lines : 1;
    int height = fm.getHeight() * lines;
    setPreferredSize(new Dimension(maxWidth + 6, height));
    str = "";
    for (int i = 0; i < lines; i++) {
      str = str + resultado.elementAt(i);
    }
    super.setText(str);
  }
  
  void setSelect(boolean isSelected) { Color bColor;
    Color bColor;
    if (isSelected) {
      bColor = UIManager.getColor(Color.GREEN);
    } else
      bColor = UIManager.getColor(Color.BLUE);
    super.setBackground(bColor);
  }
  
  void setFocus(boolean hasFocus) {
    if (hasFocus) {
      Color lineColor = UIManager.getColor("Tree.selectionBorderColor");
      setBorder(BorderFactory.createLineBorder(lineColor));
    }
    else {
      setBorder(BorderFactory.createEmptyBorder(1, 1, 1, 1));
    }
  }
  
  public Vector quebraLinhas(Font fonte, String texto, int largura) {
    Vector resultado = new Vector();
    JPanel metrica = new JPanel();
    if ((fonte == null) || (texto == null) || (texto.length() == 0))
      return resultado;
    if (largura <= 0)
      largura = 415;
    String esta = "";
    String anterior = "";
    if (texto.lastIndexOf("\n") < 0) {
      StringTokenizer trataString = new StringTokenizer(texto);
      while (trataString.hasMoreTokens()) {
        String parte = trataString.nextToken();
        if (esta.length() == 0) {
          esta = parte;
        } else
          esta = esta + " " + parte;
        if (metrica.getFontMetrics(fonte).stringWidth(esta) > largura) {
          resultado.addElement(new String(anterior + "\n"));
          esta = parte;
        }
        anterior = esta;
      }
      
      if (anterior.length() > 0) {
        resultado.addElement(new String(anterior + "\n"));
      }
    } else {
      StringTokenizer trataString = new StringTokenizer(texto, "\n");
      while (trataString.hasMoreTokens())
        resultado.addElement(new String(trataString.nextToken()));
    }
    return resultado;
  }
}
