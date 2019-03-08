/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package outlookbackupcleanerroutine;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.*;

/**
 *
 * @author tml
 */
public class OutlookBackupCleanerRoutine {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws ParseException, IOException {

        String path = "E:\\Fileserver\\Outlook";
        File[] files = new File(path).listFiles();
        processFiles(files);
    }

    public static void processFiles(File[] files) throws ParseException, IOException {
        ArrayList<ArrayList<String>> goodFiles = new ArrayList<ArrayList<String>>();
        ArrayList<String> badFiles = new ArrayList<String>();
        String fileName = "";
        String fileExt = "";
        String fileData = "";
        String fileRoot = "";
        int fileNameNumChar = 0;
        DateFormat format = new SimpleDateFormat("dd-MM-yyyy");

        for (File file : files) {
            if (file.isDirectory()) {
                processFiles(file.listFiles());
            } //analisar ficheiros
            else {
                fileName = file.getName();
                fileNameNumChar = fileName.length();

                if (fileNameNumChar > 15) {
                    fileExt = fileName.substring(fileNameNumChar - 4).toUpperCase();
                    if (fileExt.equals(".PST")) {
                        fileRoot = fileName.substring(0, fileNameNumChar - 15).toUpperCase();
                        fileData = fileName.substring(fileNameNumChar - 14, fileNameNumChar - 4).toUpperCase();
                        Date filedate = format.parse(fileData);

                        boolean found = false;
                        for (ArrayList<String> curFile : goodFiles) {
                            if (curFile.get(0).equals(fileRoot)) {
                                found = true;
                                if (format.parse(curFile.get(1)).before(filedate)) {
                                    badFiles.add(file.getParent() + "\\" + curFile.get(2));
                                    curFile.set(0, fileRoot);
                                    curFile.set(1, fileData);
                                    curFile.set(2, fileName);
                                }
                                else {
                                    badFiles.add(file.getParent() + "\\" + fileName);
                                }
                            }
                        }

                        if (!found) {
                            ArrayList<String> tmp = new ArrayList<String>();
                            tmp.add(0, fileRoot);
                            tmp.add(1, fileData);
                            tmp.add(2, fileName);
                            tmp.add(3, file.getParent() + "\\");
                            goodFiles.add(tmp);
                        }
                    }
                }
            }
        }

        for (String curFile : badFiles) {
            System.out.println("A apagar ficheiro " + curFile);
            File file = new File(curFile);
            Files.deleteIfExists(file.toPath());
        }
    }
}
