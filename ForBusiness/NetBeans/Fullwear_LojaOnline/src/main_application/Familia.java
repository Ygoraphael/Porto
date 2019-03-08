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
    public String famipai;
    public String imagem;
    
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
   
   public ArrayList<Familia>list( ) throws ParseException 
   {
       this.lastSQL = ""
            + "select distinct stock.u_codproj, stock.u_descproj, isnull((select top 1 u_imgloja from bo2 where bo2stamp = (select bostamp from bo where obrano = stock.u_codproj and ndos = 7)), 'X:\\logotipo.png') imagem "
            + "from "
            + "( "
            + "       select "
            + "                rtrim(ltrim(st.ref)) + '|||' + CONVERT(varchar(10), sl.u_codproj) ref, "
            + "                st.design, "
            + "                sl.cor, "
            + "                sl.tam, "
            + "                st.usr2, "
            + "                st.usr5, "
            + "                st.usr3, "
            + "                ltrim(rtrim(st.usr2)) + '|||' + ltrim(rtrim(st.usr5)) + '|||' + ltrim(rtrim(st.usr3)) familia, "
            + "                sl.u_codproj, "
            + "                sl.u_descproj, "
            + "                SUM(case when cm > 50 then -sl.qtt else sl.qtt end)stock "
            + "       from st "
            + "                inner join sl on st.ref = sl.ref "
            + "       where "
            + "                sl.armazem = 2 and st.usr2 <> '' and st.usr5 <> '' and st.usr3 <> '' "
            + "       group by "
            + "                st.ref, "
            + "                st.design, "
            + "                sl.cor, "
            + "                sl.tam, "
            + "                st.usr2, "
            + "                st.usr5, "
            + "                st.usr3, "
            + "                sl.u_codproj, "
            + "                sl.u_descproj "
            + "       having "
            + "                SUM(case when cm > 50 then -sl.qtt else sl.qtt end)  > 0 and st.ref like 'FW-%' "
            + ")stock "
            + "left join "
            + "( "
            + "       select "
            + "                rtrim(ltrim(st.ref)) + '|||' + CONVERT(varchar(10), bi.u_codproj) ref, "
            + "                st.design, "
            + "                bi.cor, "
            + "                bi.tam, "
            + "                ltrim(rtrim(st.usr2)) + '|||' + ltrim(rtrim(st.usr5)) + '|||' + ltrim(rtrim(st.usr3)) familia, "
            + "                bi.u_codproj, "
            + "                bi.u_descproj, "
            + "                SUM(isnull(bi.qtt, 0)) stock "
            + "       from st "
            + "                inner join bi on st.ref = bi.ref "
            + "       where "
            + "                bi.ndos = 30 and bi.fechada = 0 and bi.cativo = 1 and st.usr2 <> '' and st.usr5 <> '' and st.usr3 <> '' "
            + "       group by "
            + "                st.ref, "
            + "                st.design, "
            + "                bi.cor, "
            + "                bi.tam, "
            + "                st.usr2, "
            + "                st.usr5, "
            + "                st.usr3, "
            + "                bi.u_codproj, "
            + "                bi.u_descproj "
            + "       having "
            + "                SUM(isnull(bi.qtt, 0)) > 0 and "
            + "                st.ref like 'FW-%' "
            + ") cativo on cativo.u_codproj = stock.u_codproj and stock.cor = cativo.cor and stock.tam = cativo.tam "
            + "where stock.stock - isnull(cativo.stock, 0) > 0 ";

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
                //projecto
                familia = new Familia( this.con );
                familia.ref = rs.getString("u_codproj").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                familia.name = toTitleCase(rs.getString("u_descproj").replace("\\", "").replace("\"", "").replace("\'", "").trim().toLowerCase());
                familia.famipai = "";
                
                tmp_array = rs.getString("imagem").split("\\\\"); 
                familia.imagem = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();
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
