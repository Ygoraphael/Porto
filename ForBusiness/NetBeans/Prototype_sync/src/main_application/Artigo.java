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
    
    public String ststamp;      // stamp
    public String ref;          // referencia
    public String ref_for;      // referencia fornecedor
    public String design;       // designacao
    public String langdes1;     // designacao ENG
    public String langdes2;     // designacao Outra
    public String familia;      // familia
    public String stock;        // stock
    public String stock_min;    // stock minimo
    public String baixr;        // baixr
    public String epv1;         // preco 1
    public String epv2;         // preco 2
    public String epv3;         // preco 3
    public String epv4;         // preco 4
    public String epv5;         // preco 5
    public String epv1_ivaincl; // preco 1 iva incl
    public String epv2_ivaincl; // preco 2 iva incl
    public String epv3_ivaincl; // preco 3 iva incl
    public String epv4_ivaincl; // preco 4 iva incl
    public String epv5_ivaincl; // preco 5 iva incl
    public String tabiva;       // tabela iva
    public String imgqlook;     // caminho imagem
    public String imagem2;      // caminho imagem
    public String imagem3;      // caminho imagem
    public String imagem4;      // caminho imagem
    public String ousrdata;     // data modificacao
    public String ousrhora;     // hora modificacao
    public String usrdata;      // data criacao
    public String usrhora;      // hora criacao
    public String u_descst;     // descricao tecnica
    public String u_descst2;    // descricao tecnica ENG
    public String u_descst3;    // descricao tecnica outra
    public String u_imgdctec;   // descricao tecnica imagem
    public String u_pubsite;    // publica site
    public String pbruto;       // peso bruto
    public String u_mospr;      // mostra preco
    public String inactivo;     // inactivo
    public String unidade;      // unidade
    public String marca;        // marca
    public String modelo;       // modelo
    public String ref_alternativa;// referencias alternativas
    public String url;          // url artigo
    public String sup_tec;      // url suporte tecnico
    public String montagem;     // url montagem
    public String fabricante;   // url fabricante
    public String product_special;   // Produto em destaque
    
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
   
   public ArrayList<Artigo>list(Date data) 
   {
        DateFormat full = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        
        this.lastSQL = 
                "    SELECT "
                +   "    ststamp, "
                +   "    ref, "
                +   "    forref,"
                +   "    REPLACE(design, char(34), '') design, "
                +   "    REPLACE(langdes1, char(34), '') langdes1, "
                +   "    REPLACE(langdes2, char(34), '') langdes2, "
                +   "    u_famweb1 + ';;' + u_famweb2 u_famisite, "
                +   "    stock stock_calc, "
                +   "    stmin stock_min, "
                +   "    baixr, "
                +   "    epv1, "
                +   "    epv2, "
                +   "    epv3, "
                +   "    epv4, "
                +   "    epv5, "
                +   "    iva1incl, "
                +   "    iva2incl, "
                +   "    iva3incl, "
                +   "    iva4incl, "
                +   "    iva5incl, "
                +   "    tabiva, "
                +   "    imagem, "
                +   "    u_img2, "
                +   "    u_img3, "
                +   "    u_img4, "
                +   "    ousrdata, "
                +   "    ousrhora, "
                +   "    usrdata, "
                +   "    usrhora, "
                +   "    replace(replace(replace(cast(u_txtweb as varchar(max)), CHAR(13) ,'<br />'), CHAR(10), '<br />'), CHAR(13)+CHAR(10), '<br />') u_descst, "
                +   "    replace(replace(replace(cast(u_txtweb2 as varchar(max)), CHAR(13) ,'<br />'), CHAR(10), '<br />'), CHAR(13)+CHAR(10), '<br />') u_descst2, "
                +   "    replace(replace(replace(cast(u_txtweb3 as varchar(max)), CHAR(13) ,'<br />'), CHAR(10), '<br />'), CHAR(13)+CHAR(10), '<br />') u_descst3, "
                +   "    '' u_imgdctec, "
                +   "    u_site u_pubsite, "
                +   "    peso pbruto, "
                +   "    1 u_mospr, "
                +   "    inactivo, "
                +   "    unidade, "
                +   "    usr1 marca, "
                +   "    usr2 modelo, "
                +   "    isnull(STUFF((select distinct ',' + char(39) + refb + char(39) from rt where ref = st.ref FOR XML PATH('')), 1, 1, ''), '') ref_alternativa, "
                +   "    url, "
                +   "    u_url2 sup_tec, "
                +   "    u_url3 montagem, "
                +   "    isnull((select top 1 u_url from stfami where ref = st.U_FAMWEB1), '') url_fabricante, "
                +   "    u_proddest "
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
                artigo.ref = rs.getString("ref").replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                artigo.ref_for = rs.getString("forref").replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                
                artigo.design = rs.getString("design").replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                artigo.langdes1 = rs.getString("langdes1").replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                artigo.langdes2 = rs.getString("langdes2").replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                
                artigo.familia = rs.getString("u_famisite").replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                artigo.stock = rs.getString("stock_calc").trim();
                artigo.stock_min = rs.getString("stock_min").trim();
                artigo.baixr = rs.getString("baixr").trim();
                artigo.epv1 = rs.getString("epv1").trim();
                artigo.epv2 = rs.getString("epv2").trim();
                artigo.epv3 = rs.getString("epv3").trim();
                artigo.epv4 = rs.getString("epv4").trim();
                artigo.epv5 = rs.getString("epv5").trim();
                artigo.epv1_ivaincl = rs.getString("iva1incl").trim();
                artigo.epv2_ivaincl = rs.getString("iva2incl").trim();
                artigo.epv3_ivaincl = rs.getString("iva3incl").trim();
                artigo.epv4_ivaincl = rs.getString("iva4incl").trim();
                artigo.epv5_ivaincl = rs.getString("iva5incl").trim();
                artigo.tabiva = rs.getString("tabiva").trim();
                
                artigo.product_special = rs.getString("u_proddest").trim();
                
                tmp_array = rs.getString("imagem").split("\\\\");
                artigo.imgqlook = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                
                tmp_array = rs.getString("u_img2").split("\\\\");
                artigo.imagem2 = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                
                tmp_array = rs.getString("u_img3").split("\\\\");
                artigo.imagem3 = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                
                tmp_array = rs.getString("u_img4").split("\\\\");
                artigo.imagem4 = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                
                artigo.ousrdata = rs.getString("ousrdata").trim();
                artigo.ousrhora = rs.getString("ousrhora").trim();
                artigo.usrdata = rs.getString("usrdata").trim();
                artigo.usrhora = rs.getString("usrhora").trim();
                artigo.u_descst = rs.getString("u_descst").replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                artigo.u_descst2 = rs.getString("u_descst2").replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                artigo.u_descst3 = rs.getString("u_descst3").replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                
                tmp_array = rs.getString("u_imgdctec").split("\\\\");
                artigo.u_imgdctec = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").replace("	", "").trim();
                artigo.u_pubsite = rs.getString("u_pubsite").trim();
                
                artigo.pbruto = rs.getString("pbruto").trim();
                artigo.u_mospr = rs.getString("u_mospr").trim();
                
                artigo.inactivo = rs.getString("inactivo").trim();
                artigo.unidade = rs.getString("unidade").trim();
                artigo.marca = rs.getString("marca").trim();
                artigo.modelo = rs.getString("modelo").trim();
                artigo.ref_alternativa = rs.getString("ref_alternativa").trim();
                
                artigo.url = rs.getString("url").trim();
                artigo.sup_tec = rs.getString("sup_tec").trim();
                artigo.montagem = rs.getString("montagem").trim();
                artigo.fabricante = rs.getString("url_fabricante").trim();
                
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
