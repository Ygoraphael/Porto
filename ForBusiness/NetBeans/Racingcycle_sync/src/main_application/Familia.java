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

/**
 *
 * @author Tiago Loureiro
 */

public class Familia extends Db {
    
    public String ref;
    public String name;
    public String design2;
    public String famipai;
    public String u_logofami;
    public String u_pubfami;
    public String usrdata;
    
    public Familia() 
    {
        super();
    }
   
   public Familia(String hostname, String instanceName, String port, String username, String password, String db) 
   {
        super( hostname, instanceName, port, username, password, db );
   }
    
   public Familia(Connection con){
        this.con = con;
    }
   
   public static String toTitleCase(String input) 
   {
        StringBuilder titleCase = new StringBuilder();
        boolean nextTitleCase = true;
        for (char c : input.toCharArray()) 
        {
            if (Character.isSpaceChar(c)) 
            {
                nextTitleCase = true;
            } 
            else if (nextTitleCase) 
            {
                c = Character.toTitleCase(c);
                nextTitleCase = false;
            }
            titleCase.append(c);
        }
        return titleCase.toString();
    }
   
   public ArrayList<Familia>list( Date data ) throws ParseException 
   {
       
       DateFormat full = new SimpleDateFormat("yyyy-MM-dd");
       
//       this.lastSQL = 
//               "( " +
//                "select " +
//                "        mmstamp ref, " +
//                "        marca name, " +
//                "        marca design2, " +
//                "        '' famipai, " +
//                "        u_pubmarca u_pubsite, " +
//                "        usrdata, " +
//                "        u_logotipo imgqlook " +
//                "from " +
//                "        mm " +
//                "where " +
//                "        maquina = '' and usrdata >='" + full.format( data ) + "' " +
//                ")" +
//                "UNION ALL" +
//                "(" +
//                "SELECT " +
//                "        ref, " +
//                "        REPLACE(nome, char(34), '') name," +
//                "        REPLACE(nome, char(34), '') design2," +
//                "        isnull((select top 1 mmstamp ref from mm where maquina = '' and marca = stfami.usr1), '') famipai, " +
//                "        u_pubfami u_pubsite," +
//                "        usrdata," +
//                "        REPLACE(u_logofami, char(34), '') imgqlook " +
//                "FROM stfami " +
//                "WHERE usr1 <> '' and usrdata >='" + full.format( data ) + "' " +
//                ")";

       this.lastSQL = 
            "SELECT "
          +   "ref, "
          +   "REPLACE(nome, char(34), '') name, "
          +   "REPLACE(U_DESIGN2, char(34), '') design2, "
          +   "REPLACE(u_famipai, char(254), '') famipai, "
          +   "REPLACE(u_logofami, char(34), '') u_logofami, "
          +   "u_pubfami, "
          +   "usrdata "
          +   "FROM stfami "
          +   "WHERE usrdata >='" + full.format( data ) + "' "
          +   "ORDER BY stfami.ref";
       
        ArrayList<Familia> familias = new ArrayList<Familia>();
        Familia familia = null;
        ResultSet rs = null;
        Statement stmt = null;
        String[] tmp_array;
        
        System.out.println( "QUERY: " + this.lastSQL );
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) 
            {
                familia = new Familia( this.con );
                familia.ref = rs.getString("ref").replace("\\", "").replace("\"", "").replace("\'", "").trim();      
                familia.name = rs.getString("name").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                familia.design2 = rs.getString("design2").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                familia.famipai = rs.getString("famipai").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                familia.u_pubfami = rs.getString("u_pubfami"); 
                familia.usrdata = rs.getString("usrdata"); 
                
                tmp_array = rs.getString("u_logofami").split("\\\\"); 
                familia.u_logofami = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();
                
                familias.add(familia);
            }
            
            return familias;
            
        } 
        catch (SQLException e) 
        {
            this.log(e);
            return null;
        }
    }
   
   private void log(SQLException e) 
   {     
        System.out.println(this.lastSQL);
        System.out.println(e.toString());
   }
    
}
