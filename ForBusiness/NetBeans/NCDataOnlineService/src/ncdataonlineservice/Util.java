/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ncdataonlineservice;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.Reader;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Calendar;
import java.util.Iterator;
import java.util.Map;
import java.util.Scanner;

/**
 *
 * @author tml
 */
public class Util {
    
    public static String CleanString(String texto)
    {
        return texto.replaceAll("[^a-z0-9]+", "");
    }
    
    public static void Print2ArrayList(ArrayList al) {
        Iterator it = al.iterator();
        while (it.hasNext()) {
            ArrayList current = (ArrayList)it.next();
            Iterator it2 = current.iterator();
            while (it2.hasNext()) {
                String current2 = (String)it2.next();
                System.out.print( current2 + "\t");
                it2.remove();
            }
            System.out.println( "" );
            it.remove();
        }
    }
    
    public static void PrintArrayList(ArrayList al) {
        Iterator it = al.iterator();
        while (it.hasNext()) {
            String current = (String)it.next();
            System.out.println( current );
            it.remove();
        }
    }
    
    public static ArrayList RS2AL(ResultSet rs) throws SQLException {
        ResultSetMetaData rsmd = rs.getMetaData();
        ArrayList<ArrayList<String>> arrayList = new ArrayList<ArrayList<String>>(); 
        while (rs.next()) {              
            int i = 1;
            ArrayList<String> arrayList2 = new ArrayList<String>(); 
            while(i <= rsmd.getColumnCount()) {
                arrayList2.add(rs.getString(i++));
            }
            arrayList.add(arrayList2);
        }
        return arrayList;
    }
    
    public static String GetDirectoryPath()
    {
        return System.getProperty("user.dir") + "\\";
    }
    
    public static String ReadAllText(String file) throws FileNotFoundException, IOException
    {
        byte[] encoded = Files.readAllBytes(Paths.get(file));
        String t = new String(encoded);

        byte[] bytes = t.getBytes();
        int length = bytes.length - 3;
        byte[] barray = new byte[length];
        System.arraycopy(bytes, 3, barray, 0, barray.length);
        
        return new String(barray);
    }
    
    public static void WriteAllText(String file, String text)
    {
        BufferedWriter writer = null;
        try {
            String timeLog = new SimpleDateFormat("yyyyMMdd_HHmmss").format(Calendar.getInstance().getTime());
            File logFile = new File(timeLog);
            writer = new BufferedWriter(new FileWriter(logFile));
            writer.write(text);
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            try {
                writer.close();
            } catch (Exception e) {
            }
        }
    }
    
}
