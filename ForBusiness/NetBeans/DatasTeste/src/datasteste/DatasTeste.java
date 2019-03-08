/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package datasteste;

import java.text.SimpleDateFormat;
import java.util.Date;

/**
 *
 * @author tml
 */
public class DatasTeste {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        SimpleDateFormat data = new SimpleDateFormat("yyyy-MM-dd");
        String dataobra = "1479578917";
        long timestamp = Long.parseLong(dataobra);

        Date Bodataobra = new java.util.Date(timestamp*1000);
        System.out.println(data.format(Bodataobra));
    }
    
}
