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
 * @author Tiago Loureiro
 */
public class Diversos extends Db {

    public String stamp;      // stamp

    public Diversos() {
        super();
    }

    public Diversos(String hostname, String instanceName, String port, String username, String password, String db) {
        super(hostname, instanceName, port, username, password, db);
    }

    public Diversos(Connection con) {
        this.con = con;
    }

    public boolean setInicio() throws SQLException {
        Statement stmt = this.con.createStatement();
        
        this.lastSQL = "update e1 set u_ultsinc = convert(varchar(19), getdate(), 120)";
        
        try {
            stmt.execute(this.lastSQL);
            return true;
        } catch (Exception e) {
            System.out.println("Bi Error: " + e.toString());
            System.out.println(this.lastSQL);
            return false;
        }
    }

    private void log(SQLException e) {
        System.out.println(this.lastSQL);
        System.out.println(e.toString());
    }

}
