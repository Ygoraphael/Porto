/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package documentprocessor;

import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import javax.imageio.ImageIO;

/**
 *
 * @author tml
 */
public class DocumentProcessor {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        ImageProcessor ip = new ImageProcessor();
        ip.init();
    }
    
    
}
