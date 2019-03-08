/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package documentprocessor;

import java.awt.Color;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import javax.imageio.ImageIO;

/**
 *
 * @author tml
 */
public class ImageProcessor {
    
    BufferedImage img;
    Color mycolor;
    
    public void init() {
        try {
            img = ImageIO.read(new File("C:\\Users\\tml\\Desktop\\imageprocessing\\img.PNG"));
            for(int x = 0; x < img.getWidth(); x++) {
                for(int y = 0; y < img.getHeight(); y++) {
                    mycolor = new Color(img.getRGB(x, y));
                    //System.out.println("R:"+mycolor.getRed()+"G:"+mycolor.getGreen()+"B:"+mycolor.getBlue());
                }
            }
            
        }
        catch (IOException e) {
        }
    }
}
