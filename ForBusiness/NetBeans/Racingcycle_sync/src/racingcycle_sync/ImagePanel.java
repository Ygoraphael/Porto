package racingcycle_sync;

import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Image;
import javax.swing.ImageIcon;
import javax.swing.JFrame;
import javax.swing.JPanel;

/**
 *
 * @author Tiago Loureiro
 */
public class ImagePanel extends JPanel {

  private Image img;

  public ImagePanel(String img) 
  {
    this.img = new ImageIcon(img).getImage();
    Dimension size = new Dimension(this.img.getWidth(null), this.img.getHeight(null));
    setPreferredSize(size);
    setMinimumSize(size);
    setMaximumSize(size);
    setSize(size);
    setLayout(null);
  }

  public void paintComponent(Graphics g)
  {
    g.drawImage(this.img, 0, 0, null);
  }

}