/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.TimeZone;
/**
 *
 * @author tml
 */
public class DataResult extends Db {
    public String u_ncsyncstamp;
    public int success;
    
    public DataResult() 
    {
        super();
    }
    
    public DataResult(String hostname, String instanceName, String port, String username, String password, String db) 
    {
        super( hostname, instanceName, port, username, password, db );
    }
    
    public DataResult(Connection con){
        this.con = con;
    }

    public boolean save(Config conf) throws SQLException, ParseException {

        if( this.success == 1 ) {

            this.lastSQL = "delete from u_ncsync where u_ncsyncstamp = '" + this.u_ncsyncstamp + "'";

            Statement stmt = null;

            try 
            {
                stmt = this.con.createStatement();
                stmt.executeUpdate(this.lastSQL);
            }
            catch (SQLException e) 
            {
                this.log(e);
                return false;
            }
            
            return true;
        }
        else {
            return false;
        }
    }
    
    private void log(SQLException e) 
    {     
        System.out.println(this.lastSQL);
        System.out.println(e.toString());    
    }
}
