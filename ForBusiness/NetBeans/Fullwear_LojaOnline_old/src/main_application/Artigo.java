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

public class Artigo extends Db {
    
    public String ref;          // referencia
    public String design;       // designacao
    public String familia;      // familia
    public String stock;        // stock
    public String epv2;         // preco
    
    public Artigo() 
    {
        super();
    }
   
   public Artigo(String hostname, String instanceName, String port, String username, String password, String db) 
   {
        super( hostname, instanceName, port, username, password, db );
   }
    
   public Artigo(Connection con){
        this.con = con;
    }
   
   public ArrayList<Artigo>list() 
   {    
        this.lastSQL = ""
            + "select stock.ref, stock.design, stock.cor, stock.tam, stock.familia, stock.u_codproj, stock.u_descproj, stock.epv2, stock.stock - isnull(cativo.stock, 0) stock "
            + "from "
            + "( "
            + "       select "
            + "                rtrim(ltrim(st.ref)) + '|||' + rtrim(ltrim(CONVERT(varchar(10), sl.u_codproj))) + '|||' + rtrim(ltrim(sl.tam)) + '|||' + rtrim(ltrim(sl.cor)) ref, "
            + "                st.design, "
            + "                sl.cor, "
            + "                sl.tam, "
            + "                ltrim(rtrim(st.usr4)) + '|||' + ltrim(rtrim(st.usr5)) + '|||' + ltrim(rtrim(st.usr3)) + '|||' + CONVERT(varchar(10), sl.u_codproj) familia, "
            + "                sl.u_codproj, "
            + "                sl.u_descproj, "
            + "                st.epv2, "
            + "                SUM(case when cm > 50 then -sl.qtt else sl.qtt end)stock "
            + "       from st "
            + "                inner join sl on st.ref = sl.ref "
            + "       where "
            + "                sl.armazem = 2 and st.usr4 <> '' and st.usr5 <> '' and st.usr3 <> '' "
            + "       group by "
            + "                st.ref, "
            + "                st.design, "
            + "                sl.cor, "
            + "                sl.tam, "
            + "                st.epv2, "
            + "                st.usr4, "
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
            + "                ltrim(rtrim(st.usr4)) + '|||' + ltrim(rtrim(st.usr5)) + '|||' + ltrim(rtrim(st.usr3)) familia, "
            + "                bi.u_codproj, "
            + "                bi.u_descproj, "
            + "                SUM(isnull(bi.qtt, 0)) stock "
            + "       from st "
            + "                inner join bi on st.ref = bi.ref "
            + "       where "
            + "                bi.ndos = 30 and bi.fechada = 0 and bi.cativo = 1 and st.usr4 <> '' and st.usr5 <> '' and st.usr3 <> '' "
            + "       group by "
            + "                st.ref, "
            + "                st.design, "
            + "                bi.cor, "
            + "                bi.tam, "
            + "                st.usr4, "
            + "                st.usr5, "
            + "                st.usr3, "
            + "                bi.u_codproj, "
            + "                bi.u_descproj "
            + "       having "
            + "                SUM(isnull(bi.qtt, 0)) > 0 and "
            + "                st.ref like 'FW-%' "
            + ") cativo on cativo.u_codproj = stock.u_codproj and stock.cor = cativo.cor and stock.tam = cativo.tam "
            + "where stock.stock - isnull(cativo.stock, 0) > 0 ";

        ArrayList<Artigo> artigos = new ArrayList<Artigo>();
        Artigo artigo = null;
        ResultSet rs = null;
        Statement stmt = null;
        //String[] tmp_array;
       
        System.out.println( "QUERY: " + this.lastSQL );
        
        try {
            stmt = this.con.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,ResultSet.CONCUR_READ_ONLY);
            rs = stmt.executeQuery(this.lastSQL);
            
            rs.last();
            int total_lines = rs.getRow();
            rs.beforeFirst();
            
            RunnableThread.setOutput("A Importar dados da base dados:");
            RunnableThread.setOutputReg(0, total_lines);
            
            while (rs.next()) 
            {
                artigo = new Artigo( this.con );
                
                artigo.ref = rs.getString("ref").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                artigo.design = rs.getString("design").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                artigo.familia = rs.getString("familia").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                artigo.stock = rs.getString("stock").trim();
                artigo.epv2 = rs.getString("epv2").trim();
                
                //tmp_array = rs.getString("imgqlook").split("\\\\");
                //artigo.imgqlook = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();
                
                //tmp_array = rs.getString("u_imgdctec").split("\\\\");
                //artigo.u_imgdctec = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();
                
                artigos.add(artigo);
                RunnableThread.setOutputReg(rs.getRow(), total_lines);
            }
            
            RunnableThread.setOutput("\n");
            return artigos;
            
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
