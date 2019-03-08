/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package dataonlinesync;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.ServerSocket;
import java.net.Socket;

/**
 *
 * @author Tiago Loureiro
 */
public class DataOnlineSync {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws IOException {
        try (ServerSocket listener = new ServerSocket(9090)) {
            listener.setSoTimeout(1);
            System.out.println("Initialized");
            while (true) {
                try (Socket socket = listener.accept()) {
                    BufferedReader in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
                    PrintWriter out = new PrintWriter(socket.getOutputStream(), true);
                    String input = "";
                    String tmp;
                    
                    while ((tmp = in.readLine()) != null && in.ready()) {
                        input += tmp;
                    }
                    
                    input = java.net.URLDecoder.decode(input, "UTF-8");
                    SQLiteJDBC basedados = new SQLiteJDBC();
                    
                    System.out.println("Query: " + input);
                    
                    String result;
                    result = basedados.getData(input);
                    
                    System.out.println("Result: " + result);
                    out.println(result);
                }
                catch(Exception e) {
                    continue;
                }
            }
        }
    }
}
