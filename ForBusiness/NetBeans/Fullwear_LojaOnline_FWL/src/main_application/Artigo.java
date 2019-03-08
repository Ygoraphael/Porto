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
import java.util.regex.Pattern;

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
    public String modalidade;   // modalidade
    public String genero;       // genero
    public String linha;        // linha
    public String imagem1;      // imagem1
    public String imagem2;      // imagem2
    public String imagem3;      // imagem3
    public String imagem4;      // imagem4
    public String descricao_pt; // descricao loja
    public String descricao_uk; // descricao loja uk
    public String categoria;    // categoria
    public String design_uk;    // categoria uk
    public String modalidade_uk;// modalidade uk
    public String desconto;     // desconto
    public String novidade;     // novidade
    public String destaque;     // destaque
    public String antibact;
    public String aqueci;
    public String carbono;
    public String confort;
    public String cortaven;
    public String dryclim;
    public String drystorm;
    public String elastic;
    public String flatlock;
    public String fresc;
    public String frio;
    public String ikk;
    public String imperme;
    public String multicam;
    public String reflet;
    public String respir;
    public String silico;
    public String termoreg;
    public String u_imgtam;

    public Artigo() {
        super();
    }

    public Artigo(String hostname, String instanceName, String port, String username, String password, String db) {
        super(hostname, instanceName, port, username, password, db);
    }

    public Artigo(Connection con) {
        this.con = con;
    }

    public ArrayList<Artigo> list() {
        this.lastSQL = "select  "
                + "	isnull(stock.ref, artigos.ref) ref,  "
                + "	isnull(stock.design, artigos.design) design,  "
                + "	isnull(stock.cor, artigos.cor) cor,  "
                + "	isnull(stock.tam, artigos.tam) tam,  "
                + "	isnull(stock.usr2, artigos.usr2) modalidade,  "
                + "	isnull(stock.usr5, artigos.usr5) genero,  "
                + "	isnull(stock.usr3, artigos.usr3) linha,  "
                + "	isnull(stock.familia, artigos.u_codproj) familia, "
                + "	isnull(stock.u_codproj, artigos.u_codproj) u_codproj,  "
                + "	isnull(stock.u_descproj, artigos.u_descproj) u_descproj,  "
                + "	isnull(stock.epv2, artigos.epv2) epv2,  "
                + "	isnull(stock.stock, 0) sa,  "
                + "	isnull(stock.stock, 0) - isnull(cativo.stock, 0) stock, "
                + "	isnull((select top 1 img1 from u_stproj where ststamp = isnull(stock.ststamp, artigos.ststamp) and u_codproj = isnull(stock.u_codproj, artigos.u_codproj)), 'X:\\\\logotipo.png') img1, "
                + "	isnull((select top 1 img2 from u_stproj where ststamp = isnull(stock.ststamp, artigos.ststamp) and u_codproj = isnull(stock.u_codproj, artigos.u_codproj)), '') img2, "
                + "	isnull((select top 1 img3 from u_stproj where ststamp = isnull(stock.ststamp, artigos.ststamp) and u_codproj = isnull(stock.u_codproj, artigos.u_codproj)), '') img3, "
                + "	isnull((select top 1 img4 from u_stproj where ststamp = isnull(stock.ststamp, artigos.ststamp) and u_codproj = isnull(stock.u_codproj, artigos.u_codproj)), '') img4, "
                + "	isnull(stock.categoria, artigos.categoria) categoria, "
                + "	isnull(stock.descricao_pt, artigos.descricao_pt) descricao_pt, "
                + "	(case when len(stock.descricao_uk) > 0 then stock.descricao_uk else isnull(stock.descricao_pt, artigos.descricao_pt) end) descricao_uk, "
                + "	(case when len(stock.design_uk) > 0 then stock.design_uk else isnull(stock.categoria, artigos.categoria) end) design_uk, "
                + "	isnull(stock.desconto, artigos.desconto) desconto, "
                + "	isnull(stock.novidade, artigos.novidade) novidade, "
                + "	isnull(stock.destaque, artigos.destaque) destaque, "
                + "	isnull(stock.antibact, artigos.antibact) antibact, "
                + "	isnull(stock.aqueci, artigos.aqueci) aqueci, "
                + "	isnull(stock.carbono, artigos.carbono) carbono, "
                + "	isnull(stock.confort, artigos.confort) confort, "
                + "	isnull(stock.cortaven, artigos.cortaven) cortaven, "
                + "	isnull(stock.dryclim, artigos.dryclim) dryclim, "
                + "	isnull(stock.drystorm, artigos.drystorm) drystorm, "
                + "	isnull(stock.elastic, artigos.elastic) elastic, "
                + "	isnull(stock.flatlock, artigos.flatlock) flatlock, "
                + "	isnull(stock.fresc, artigos.fresc) fresc, "
                + "	isnull(stock.frio, artigos.frio) frio, "
                + "	isnull(stock.ikk, artigos.ikk) ikk, "
                + "	isnull(stock.imperme, artigos.imperme) imperme, "
                + "	isnull(stock.multicam, artigos.multicam) multicam, "
                + "	isnull(stock.reflet, artigos.reflet) reflet, "
                + "	isnull(stock.respir, artigos.respir) respir, "
                + "	isnull(stock.silico, artigos.silico) silico, "
                + "	isnull(stock.termoreg, artigos.termoreg) termoreg, "
                + "	isnull(stock.u_imgtam, artigos.u_imgtam) u_imgtam "
                + "from "
                + "( "
                + "	select  "
                + "		rtrim(ltrim(bi.ref)) + '|||' + rtrim(ltrim(CONVERT(varchar(10), bo.trab1))) + '|||' + rtrim(ltrim(bi.tam)) + '|||' + rtrim(ltrim(bi.cor)) ref, "
                + "		bi.cor, bi.tam, bo.trab1 u_codproj, bo.trab3 u_descproj, bi.design, st.usr2, st.usr5, st.usr3, "
                + "		CONVERT(varchar(10), bo.trab1) familia, "
                + "		st.epv2, "
                + "		st.ststamp, "
                + "		isnull((select top 1 nome from stfami where ref = st.familia), '') categoria, "
                + "		convert(varchar(max), st.u_descloja) descricao_pt, "
                + "		convert(varchar(max), st.u_descljuk) descricao_uk, "
                + "		isnull((select top 1 u_desuk from stfami where ref = st.familia), '') design_uk, "
                + "		isnull((select top 1 desc1 from u_stproj where ststamp = st.ststamp and u_codproj = bo.trab1), 0) desconto, "
                + "		isnull((select top 1 novi from u_stproj where ststamp = st.ststamp and u_codproj = bo.trab1), 0) novidade, "
                + "		isnull((select top 1 dest from u_stproj where ststamp = st.ststamp and u_codproj = bo.trab1), 0) destaque, "
                + "		isnull(u_lojaprop.antibact, 0) antibact, "
                + "		isnull(u_lojaprop.aqueci, 0) aqueci, "
                + "		isnull(u_lojaprop.carbono, 0) carbono, "
                + "		isnull(u_lojaprop.confort, 0) confort, "
                + "		isnull(u_lojaprop.cortaven, 0) cortaven, "
                + "		isnull(u_lojaprop.dryclim, 0) dryclim, "
                + "		isnull(u_lojaprop.drystorm, 0) drystorm, "
                + "		isnull(u_lojaprop.elastic, 0) elastic, "
                + "		isnull(u_lojaprop.flatlock, 0) flatlock, "
                + "		isnull(u_lojaprop.fresc, 0) fresc, "
                + "		isnull(u_lojaprop.frio, 0) frio, "
                + "		isnull(u_lojaprop.ikk, 0) ikk, "
                + "		isnull(u_lojaprop.imperme, 0) imperme, "
                + "		isnull(u_lojaprop.multicam, 0) multicam, "
                + "		isnull(u_lojaprop.reflet, 0) reflet, "
                + "		isnull(u_lojaprop.respir, 0) respir, "
                + "		isnull(u_lojaprop.silico, 0) silico, "
                + "		isnull(u_lojaprop.termoreg, 0) termoreg, "
                + "		isnull(st.u_imgtam, '') u_imgtam, "
                + "		st.u_publ "
                + "	from bi  "
                + "	inner join st on bi.ref = st.ref  "
                + "	inner join bo on bo.bostamp = bi.bostamp "
                + "	left join u_lojaprop on bi.ref = u_lojaprop.ref "
                + "	where st.usr2 <> '' and st.usr5 <> '' and st.usr3 <> '' and st.ref like 'FL-%' and bo.ndos = 7 "
                + ") artigos "
                + "left join ( "
                + "		select "
                + "			rtrim(ltrim(st.ref)) + '|||' + rtrim(ltrim(CONVERT(varchar(10), sl.u_codproj))) + '|||' + rtrim(ltrim(sl.tam)) + '|||' + rtrim(ltrim(sl.cor)) ref, "
                + "			st.ststamp, "
                + "			st.design, "
                + "			sl.cor, "
                + "			sl.tam, "
                + "			st.usr2, "
                + "			st.usr5, "
                + "			st.usr3, "
                + "			CONVERT(varchar(10), sl.u_codproj) familia, "
                + "			sl.u_codproj, "
                + "			sl.u_descproj, "
                + "			st.epv2, "
                + "			SUM(case when cm > 50 then -sl.qtt else sl.qtt end) stock, "
                + "			isnull((select top 1 nome from stfami where ref = st.familia), '') categoria, "
                + "			convert(varchar(max), st.u_descloja) descricao_pt, "
                + "			convert(varchar(max), st.u_descljuk) descricao_uk, "
                + "			isnull((select top 1 u_desuk from stfami where ref = st.familia), '') design_uk, "
                + "			isnull((select top 1 desc1 from u_stproj where ststamp = st.ststamp and u_codproj = sl.u_codproj), 0) desconto, "
                + "			isnull((select top 1 novi from u_stproj where ststamp = st.ststamp and u_codproj = sl.u_codproj), 0) novidade, "
                + "			isnull((select top 1 dest from u_stproj where ststamp = st.ststamp and u_codproj = sl.u_codproj), 0) destaque, "
                + "			isnull(u_lojaprop.antibact, 0) antibact, "
                + "			isnull(u_lojaprop.aqueci, 0) aqueci, "
                + "			isnull(u_lojaprop.carbono, 0) carbono, "
                + "			isnull(u_lojaprop.confort, 0) confort, "
                + "			isnull(u_lojaprop.cortaven, 0) cortaven, "
                + "			isnull(u_lojaprop.dryclim, 0) dryclim, "
                + "			isnull(u_lojaprop.drystorm, 0) drystorm, "
                + "			isnull(u_lojaprop.elastic, 0) elastic, "
                + "			isnull(u_lojaprop.flatlock, 0) flatlock, "
                + "			isnull(u_lojaprop.fresc, 0) fresc, "
                + "			isnull(u_lojaprop.frio, 0) frio, "
                + "			isnull(u_lojaprop.ikk, 0) ikk, "
                + "			isnull(u_lojaprop.imperme, 0) imperme, "
                + "			isnull(u_lojaprop.multicam, 0) multicam, "
                + "			isnull(u_lojaprop.reflet, 0) reflet, "
                + "			isnull(u_lojaprop.respir, 0) respir, "
                + "			isnull(u_lojaprop.silico, 0) silico, "
                + "			isnull(u_lojaprop.termoreg, 0) termoreg, "
                + "			isnull(st.u_imgtam, '') u_imgtam, "
                + "			st.u_publ "
                + "		from st "
                + "		left join sl on st.ref = sl.ref "
                + "		left join u_lojaprop on st.ref = u_lojaprop.ref "
                + "		where "
                + "			st.usr2 <> '' and st.usr5 <> '' and st.usr3 <> '' and st.ref like 'FL-%' "
                + "		group by "
                + "			st.ststamp, "
                + "			st.ref, "
                + "			st.design, "
                + "			sl.cor, "
                + "			sl.tam, "
                + "			st.epv2, "
                + "			st.usr2, "
                + "			st.usr5, "
                + "			st.usr3, "
                + "			sl.u_codproj, "
                + "			sl.u_descproj, "
                + "			st.familia, "
                + "			convert(varchar(max), st.u_descloja), "
                + "			convert(varchar(max), st.u_descljuk), "
                + "			st.usr6, "
                + "			u_lojaprop.antibact, "
                + "			u_lojaprop.aqueci, "
                + "			u_lojaprop.carbono, "
                + "			u_lojaprop.confort, "
                + "			u_lojaprop.cortaven, "
                + "			u_lojaprop.dryclim, "
                + "			u_lojaprop.drystorm, "
                + "			u_lojaprop.elastic, "
                + "			u_lojaprop.flatlock, "
                + "			u_lojaprop.fresc, "
                + "			u_lojaprop.frio, "
                + "			u_lojaprop.ikk, "
                + "			u_lojaprop.imperme, "
                + "			u_lojaprop.multicam, "
                + "			u_lojaprop.reflet, "
                + "			u_lojaprop.respir, "
                + "			u_lojaprop.silico, "
                + "			u_lojaprop.termoreg, "
                + "			st.u_imgtam, "
                + "			st.u_publ "
                + "	) stock on artigos.ref = stock.ref "
                + "left join "
                + "( "
                + "	select "
                + "		rtrim(ltrim(st.ref)) + '|||' + CONVERT(varchar(10), bi.u_codproj) ref, "
                + "		st.design, "
                + "		bi.cor, "
                + "		bi.tam, "
                + "		ltrim(rtrim(st.usr2)) + '|||' + ltrim(rtrim(st.usr5)) + '|||' + ltrim(rtrim(st.usr3)) familia, "
                + "		bi.u_codproj, "
                + "		bi.u_descproj, "
                + "		SUM(isnull(bi.qtt, 0)) stock "
                + "	from st "
                + "	inner join bi on st.ref = bi.ref "
                + "	where "
                + "		bi.ndos = 36 and bi.fechada = 0 and bi.cativo = 1 and st.usr2 <> '' and st.usr5 <> '' and st.usr3 <> '' and st.ref like 'FL-%' "
                + "	group by "
                + "		st.ref, "
                + "		st.design, "
                + "		bi.cor, "
                + "		bi.tam, "
                + "		st.usr2, "
                + "		st.usr5, "
                + "		st.usr3, "
                + "		bi.u_codproj, "
                + "		bi.u_descproj "
                + "	having "
                + "		SUM(isnull(bi.qtt, 0)) > 0 "
                + ") cativo on cativo.u_codproj = stock.u_codproj and stock.cor = cativo.cor and stock.tam = cativo.tam "
                + "where isnull((select top 1 pub from u_stproj where ststamp = artigos.ststamp and u_codproj = stock.u_codproj), 0) = 1 AND artigos.u_publ = 1";

        ArrayList<Artigo> artigos = new ArrayList<Artigo>();
        Artigo artigo = null;
        ResultSet rs = null;
        Statement stmt = null;
        String[] tmp_array;
        String[] modalidades;

        System.out.println("QUERY: " + this.lastSQL);

        try {
            stmt = this.con.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE, ResultSet.CONCUR_READ_ONLY);
            rs = stmt.executeQuery(this.lastSQL);

            rs.last();
            int total_lines = rs.getRow();
            rs.beforeFirst();

            RunnableThread.setOutput("A Importar dados da base dados:");
            RunnableThread.setOutputReg(0, total_lines);

            while (rs.next()) {
                artigo = new Artigo(this.con);

                artigo.ref = rs.getString("ref").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                artigo.design = rs.getString("design").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                artigo.familia = rs.getString("familia").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                artigo.stock = rs.getString("stock").trim();
                artigo.epv2 = rs.getString("epv2").trim();

                if (rs.getString("modalidade").trim().indexOf("|") >= 0) {
                    modalidades = rs.getString("modalidade").trim().split(Pattern.quote("|"));
                    artigo.modalidade = modalidades[0].trim(); // rs.getString("modalidade").trim();
                    artigo.modalidade_uk = modalidades[1].trim(); //rs.getString("modalidade_uk").trim();
                } else {
                    artigo.modalidade = rs.getString("modalidade").trim();
                    artigo.modalidade_uk = rs.getString("modalidade").trim();
                }

                artigo.genero = rs.getString("genero").trim();
                artigo.linha = rs.getString("linha").trim();
                artigo.categoria = rs.getString("categoria").trim();
                artigo.design_uk = rs.getString("design_uk").trim();
                artigo.descricao_uk = rs.getString("descricao_uk").trim();
                artigo.descricao_pt = rs.getString("descricao_pt").trim();
                artigo.desconto = rs.getString("desconto").trim();
                artigo.novidade = rs.getString("novidade").trim();
                artigo.destaque = rs.getString("destaque").trim();

                tmp_array = rs.getString("img1").split("\\\\");
                artigo.imagem1 = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();

                tmp_array = rs.getString("img2").split("\\\\");
                artigo.imagem2 = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();

                tmp_array = rs.getString("img3").split("\\\\");
                artigo.imagem3 = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();

                tmp_array = rs.getString("img4").split("\\\\");
                artigo.imagem4 = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();

                //tmp_array = rs.getString("u_imgdctec").split("\\\\");
                //artigo.u_imgdctec = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();
                artigo.antibact = rs.getString("antibact");
                artigo.aqueci = rs.getString("aqueci");
                artigo.carbono = rs.getString("carbono");
                artigo.confort = rs.getString("confort");
                artigo.cortaven = rs.getString("cortaven");
                artigo.dryclim = rs.getString("dryclim");
                artigo.drystorm = rs.getString("drystorm");
                artigo.elastic = rs.getString("elastic");
                artigo.flatlock = rs.getString("flatlock");
                artigo.fresc = rs.getString("fresc");
                artigo.frio = rs.getString("frio");
                artigo.ikk = rs.getString("ikk");
                artigo.imperme = rs.getString("imperme");
                artigo.multicam = rs.getString("multicam");
                artigo.reflet = rs.getString("reflet");
                artigo.respir = rs.getString("respir");
                artigo.silico = rs.getString("silico");
                artigo.termoreg = rs.getString("termoreg");

                tmp_array = rs.getString("u_imgtam").split("\\\\");
                artigo.u_imgtam = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();

                artigos.add(artigo);
                RunnableThread.setOutputReg(rs.getRow(), total_lines);
            }

            RunnableThread.setOutput("\n");
            return artigos;

        } catch (SQLException e) {
            this.log(e);
            return null;
        }
    }

    private void log(SQLException e) {
        System.out.println(this.lastSQL);
        System.out.println(e.toString());
    }

}
