/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ncdataonlineservice;

import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;

/**
 *
 * @author tml
 */
public class Log {
    public static void Write(String str, String logfile) throws IOException
    {
        File info = new File(logfile);
        if(info.exists()){
            if (info.length() > 1048576)
            {
                String contents = Util.ReadAllText(logfile);
                Util.WriteAllText(logfile + ".old", contents);
                Util.WriteAllText(logfile, "");
            }
        }
        
        try
        {
            DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
            Calendar cal = Calendar.getInstance();
            FileWriter fw = new FileWriter(logfile, true);
            fw.write(dateFormat.format(cal.getTime()) + " - " + str);
            fw.write(System.getProperty("line.separator"));
            fw.close();
        }
        catch(IOException ioe)
        {
            System.err.println("IOException: " + ioe.getMessage());
        }
    }
}
