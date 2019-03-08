/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package ncremoteservice;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.ParseException;
import java.util.ArrayList;

/**
 *
 * @author Tiago Loureiro
 */
public class StrQuery extends Db {
    
    public StrQuery() 
    {
        super();
    }
    
    public StrQuery(String hostname, String instanceName, String port, String username, String password, String db) 
    {
        super( hostname, instanceName, port, username, password, db );
    }
    
    public StrQuery(Connection con){
        this.con = con;
    }
    
    public ArrayList<String[]>list( String str_sql ) throws ParseException 
    {
        ArrayList<String[]> dados = new ArrayList<String[]>();
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery( str_sql );
            int columnCount = rs.getMetaData().getColumnCount();
            
            while(rs.next())
            {
                String[] row = new String[columnCount];
                for (int i=0; i <columnCount ; i++)
                {
                   row[i] = rs.getString(i + 1).trim();
                }
                dados.add(row);
            }
            
            return dados;
        } 
        catch (SQLException e) 
        {
            return null;
        }
    }
    
    public int runQuery( String str_sql ) throws ParseException 
    {
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            System.out.println( str_sql );
            
            PreparedStatement ps = this.con.prepareStatement(str_sql);
            
            return ps.executeUpdate();
        } 
        catch (SQLException e) 
        {
            System.out.println(e);
            return 0;
        }
    }
}
