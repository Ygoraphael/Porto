package main_application;
import java.io.UnsupportedEncodingException;
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
import java.util.Base64;

/**
 *
 * @author Tiago Loureiro
 */

public class Artigo extends Db {
    
    public String ststamp;      // stamp
    public String ref;          // referencia
    public String design;       // designacao
    public String langdes1;     // designacao ENG
    public String familia;      // familia
    public String stock;        // stock
    public String epv1;         // preco
    public String tabiva;       // tabela iva
    public String imgqlook;     // caminho imagem
    public String ousrdata;     // data modificacao
    public String ousrhora;     // hora modificacao
    public String usrdata;      // data criacao
    public String usrhora;      // hora criacao
    public String u_descst;     // descricao tecnica
    public String u_descst2;    // descricao tecnica ENG
    public String u_imgdctec;   // descricao tecnica imagem
    public String u_pubsite;    // publica site
    public String pbruto;       // peso bruto
    public String u_mospr;      // mostra preco
    public String u_desigeng;  // designacao eng
    public String u_desigpt;    // designacao pt
    public String inactivo;     // inactivo
    
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
   
   public ArrayList<Artigo>list(Date data) throws UnsupportedEncodingException 
   {
        DateFormat full = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        
        this.lastSQL = 
                  "SELECT "
                +   "ststamp, "
                +   "ref, "
                +   "REPLACE(langdes2, char(34), '') langdes2, "
                +   "REPLACE(langdes1, char(34), '') langdes1, "
                +   "u_famisite, "
                +   "case "
                +   "WHEN u_stkarmb > 0 THEN stock+u_stkarmb-qttcli " 
                +   "WHEN u_stkarmb <= 0 THEN stock-qttcli " 
                +   "end stock_calc, "
                +   "epv1, "
                +   "tabiva, "
                +   "imgqlook, "
                +   "ousrdata, "
                +   "ousrhora, "
                +   "usrdata, "
                +   "usrhora, "
                +   "replace(cast(u_descst as varchar(max)), CHAR(13) + CHAR(10) ,'<br />') u_descst, "
                +   "replace(cast(u_descst2 as varchar(max)), CHAR(13) + CHAR(10) ,'<br />') u_descst2, "
                +   "u_imgdctec, "
                +   "u_pubsite, "
                +   "pbruto, "
                +   "u_mospr, "
                +   "REPLACE(u_desigeng, char(34), '') u_desigeng, "
                +   "REPLACE(u_desigpt, char(34), '') u_desigpt, "
                +   "inactivo "
                +   "FROM st "
                +   "WHERE CONVERT(VARCHAR(19),usrdata + ' ' + usrhora,20) >= CONVERT(VARCHAR(19),'" + full.format( data ) + "',20) "
                +   "ORDER BY st.ref";

        ArrayList<Artigo> artigos = new ArrayList<Artigo>();
        Artigo artigo = null;
        ResultSet rs = null;
        Statement stmt = null;
        String[] tmp_array;
       
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
                
                artigo.ststamp = rs.getString("ststamp").trim();
                artigo.ref = new String(Base64.getEncoder().encode(rs.getString("ref").replace("\\", "").replace("\"", "").replace("\'", "").trim().getBytes()), "UTF-8");
                artigo.design = new String(Base64.getEncoder().encode(rs.getString("langdes2").replace("\\", "").replace("\"", "").replace("\'", "").trim().getBytes()), "UTF-8");
                artigo.langdes1 = new String(Base64.getEncoder().encode(rs.getString("langdes1").replace("\\", "").replace("\"", "").replace("\'", "").trim().getBytes()), "UTF-8");
                artigo.familia = new String(Base64.getEncoder().encode(rs.getString("u_famisite").replace("\\", "").replace("\"", "").replace("\'", "").trim().getBytes()), "UTF-8");
                artigo.stock = rs.getString("stock_calc").trim();
                artigo.epv1 = rs.getString("epv1").trim();
                artigo.tabiva = rs.getString("tabiva").trim();
                
                tmp_array = rs.getString("imgqlook").split("\\\\");
                artigo.imgqlook = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();
                
                artigo.ousrdata = rs.getString("ousrdata").trim();
                artigo.ousrhora = rs.getString("ousrhora").trim();
                artigo.usrdata = rs.getString("usrdata").trim();
                artigo.usrhora = rs.getString("usrhora").trim();
                artigo.u_descst = new String(Base64.getEncoder().encode(rs.getString("u_descst").replace("\\", "").replace("\"", "").replace("\'", "").trim().getBytes()), "UTF-8");
                artigo.u_descst2 = new String(Base64.getEncoder().encode(rs.getString("u_descst2").replace("\\", "").replace("\"", "").replace("\'", "").trim().getBytes()), "UTF-8");
                
                tmp_array = rs.getString("u_imgdctec").split("\\\\");
                artigo.u_imgdctec = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();
                artigo.u_pubsite = rs.getString("u_pubsite").trim();
                
                artigo.pbruto = rs.getString("pbruto").trim();
                artigo.u_mospr = rs.getString("u_mospr").trim();
                
                artigo.u_desigeng = new String(Base64.getEncoder().encode(rs.getString("u_desigeng").replace("\\", "").replace("\"", "").replace("\'", "").trim().getBytes()), "UTF-8");
                artigo.u_desigpt = new String(Base64.getEncoder().encode(rs.getString("u_desigpt").replace("\\", "").replace("\"", "").replace("\'", "").trim().getBytes()), "UTF-8");
                artigo.inactivo = rs.getString("inactivo").trim();
                
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
