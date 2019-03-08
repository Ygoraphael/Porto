/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ncdataonlineservice;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author tml
 */
public class SQL {
    public static ResultSet ExecutarSQL(String connType, String connString, String sql) {
        
        if (connType.equals("MSSQL")) {
            System.out.println("Ligação: MSSQL");
            try {
                Connection connection = DriverManager.getConnection(connString);
                Statement stmt = connection.createStatement();
                ResultSet rs = stmt.executeQuery(sql);
                return rs;
            } catch (SQLException ex) {
                Logger.getLogger(SQL.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        else if (connType.equals("SQLite")) {
            System.out.println("Ligação: SQLite");
            try {
                Connection connection = DriverManager.getConnection(connString);
                Statement statement = connection.createStatement();
                statement.setQueryTimeout(30);
                ResultSet rs = statement.executeQuery(sql);
                return rs;
            } catch (SQLException ex) {
                Logger.getLogger(SQL.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        return null;
    }
    
    public static String MakeMSSQLConnectionString(String server, String database, String user, String password) {
        String connectionUrl = "jdbc:sqlserver://" + server + ";" + 
                                "database=" + database + ";" + 
                                "user=" + user + ";" + 
                                "password=" + password + ""; 
        return connectionUrl;
    }
    
    public static String MakeSQLiteConnectionString(String database) {
        return ("jdbc:sqlite:" + database);
    }
}
