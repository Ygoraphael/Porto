/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package dataonlinesync;

import java.net.URLEncoder;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import flexjson.JSONSerializer;
import java.io.UnsupportedEncodingException;
import java.util.HashMap;
import java.util.Map;

/**
 *
 * @author Tiago Loureiro
 */
public class SQLiteJDBC {
    
    Config conf = new Config();
    Connection c = null;
    Statement stmt = null;
    
    public SQLiteJDBC( ) {        
        try {
            Class.forName("org.sqlite.JDBC");
            System.out.println(conf.getPath() + conf.getDb());
            c = DriverManager.getConnection("jdbc:sqlite:" + conf.getPath() + conf.getDb());
        } 
        catch ( ClassNotFoundException | SQLException e ) {
            System.err.println( e.getClass().getName() + ": " + e.getMessage() );
            System.exit(0);
        }
        System.out.println("Opened database successfully");
    }
    
    public String getData(String query) throws SQLException, UnsupportedEncodingException {
        
        List<Map<String, String>> result = null;
        JSONSerializer serializer = new JSONSerializer().exclude("class");
        stmt = c.createStatement();
        
        try (ResultSet rs = stmt.executeQuery( query )) {

            int numcols = rs.getMetaData().getColumnCount();
            result = new ArrayList<>();
            
            while ( rs.next() ) {
                Map<String, String> map = new HashMap<>();
                int i = 1;
                while (i <= numcols) {
                    map.put(rs.getMetaData().getColumnName(i), rs.getString(i));
                    i++;
                }
                result.add(map);
            }

        }
        catch(Exception e) {
            System.out.println("Error: " + e);
        }
        
        stmt.close();
        String data;
        data = URLEncoder.encode(serializer.serialize( result ), "UTF-8");
        
        return data;
    }
    
}
