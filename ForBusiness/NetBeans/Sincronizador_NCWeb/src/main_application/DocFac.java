/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.math.BigInteger;
import java.security.SecureRandom;
import java.sql.Statement;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

/**
 *
 * @author Tiago Loureiro
 */
public class DocFac extends PHCDB {
    
    //ft
    
    public int cl_destino;
    public int num_doc_phc;
    public String stamp_doc_phc;
    public String data;
    public double valor_c_iva;
    public double valor_s_iva;
    public double desc_fin;
    public double desc_com;
    public double taxaiva1;
    public double taxaiva2;
    public double taxaiva3;
    public double taxaiva4;
    public double taxaiva5;
    public double taxaiva6;
    public double taxaiva7;
    public double taxaiva8;
    public double taxaiva9;
    public double custo;
    public int fno;
    public int anulado;
    public String carga;
    public String cdata; 
    public String chora; 
    public String cobranca;
    public String codpost;
    public String descar;
    public double eivain1;
    public double eivain2;
    public double eivain3;
    public double eivain4;
    public double eivain5;
    public double eivain6;
    public double eivain7;
    public double eivain8;
    public double eivain9;
    public double evirs;
    public int facturada;
    public int impresso;
    public String local;
    public String matricula;
    public String morada;
    public String ncont;
    public String nome;
    public int pais;
    public String pdata;
    public String telefone;
    public String tipo;
    public double ettiva;
    public String ousrdata;
    public String ousrhora;
    public String usrdata;
    public String usrhora;
    public String assinatura;
    public String codmotiseimp;
    public String formapag;
    public String motiseimp;
    
    //fi
    
    public String fistamp;
    public String nmdoc;
    //public int fno;
    public String ref;
    public String design;
    public double qtt;
    public double tiliquido;
    public double etiliquido;
    public double iva;
    public int ivaincl;
    public int tabiva;
    public int ndoc;
    public int armazem;
    public String ftstamp;
    public double desconto;
    //public double custo;
    public double ecusto;
    public double pv;
    public double epv; 
    
    ArrayList< String > lista_ftstamp = new ArrayList< String >();
    
    public DocFac ( String hostname, String port, String username, String password, String db, String instancename) {
        super( hostname, port, username, password, db, instancename );
    }
    
    public DocFac( Connection con ) {
        super( con );
    }
    
    public ArrayList<String> list_ft(String id) throws FileNotFoundException, IOException {
        
        ArrayList<String> FilesList = new ArrayList<String>();
        int num_files = 0;
        SecureRandom random = new SecureRandom();
        String random_string = null;
        File file = null;
        FileOutputStream fop = null;
        String content = null;
        byte[] contentInBytes = null;

        this.lastSQL = "select "
                + "no cl_destino, "
                + "ft.ndoc num_doc_phc, "
                + "ft.ftstamp stamp_doc_phc, "
                + "ft.fdata data, "
                + "ft.etotal valor_c_iva, "
                + "ft.ettiliq valor_s_iva, "
                + "ft.efinv desc_fin, "
                + "ft.edescc desc_com, "
                + "ft.EIVAV1 taxaiva1, "
                + "ft.EIVAV2 taxaiva2, "
                + "ft.EIVAV3 taxaiva3, "
                + "ft.EIVAV4 taxaiva4, "
                + "ft.EIVAV5 taxaiva5, "
                + "ft.EIVAV6 taxaiva6, "
                + "ft.EIVAV7 taxaiva7, "
                + "ft.EIVAV8 taxaiva8, "
                + "ft.EIVAV9 taxaiva9, "
                + "ft.ecusto custo, "
                + "ft.fno, "
                + "ft.anulado, "
                + "ft.carga, "
                + "ft.cdata, "
                + "ft.chora, "
                + "ft.cobranca, "
                + "ft.codpost, "
                + "ft.descar, "
                + "ft.eivain1, "
                + "ft.eivain2, "
                + "ft.eivain3, "
                + "ft.eivain4, "
                + "ft.eivain5, "
                + "ft.eivain6, "
                + "ft.eivain7, "
                + "ft.eivain8, "
                + "ft.eivain9, "
                + "ft.evirs, "
                + "ft.facturada, "
                + "ft.impresso, "
                + "ft.local, "
                + "ft.matricula, "
                + "ft.morada, "
                + "ft.ncont, "
                + "ft.nome, "
                + "ft.pais, "
                + "ft.pdata, "
                + "ft.telefone, "
                + "ft.tipo, "
                + "ft.ettiva, "
                + "ft.ousrdata, "
                + "ft.ousrhora, "
                + "ft.usrdata, "
                + "ft.usrhora, "
                + "ft2.assinatura, "
                + "ft2.codmotiseimp, "
                + "ft2.formapag, "
                + "ft2.motiseimp "
                + "from ft inner join ft2 on ft.ftstamp = ft2.ft2stamp";

        DocFac docfac = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                
                if ( num_files == 0 ) {
                    //abre ficheiro
                    random = new SecureRandom();
                    random_string = new BigInteger(130, random).toString(32);

                    file = new File( random_string );
                    fop = new FileOutputStream( file );
                    if (!file.exists()) {
                        file.createNewFile();
                    }

                    content = id;
                    contentInBytes = content.getBytes();
                    fop.write(contentInBytes);
                    fop.flush();
                }
                
                docfac = new DocFac( this.con );
                docfac.cl_destino = rs.getInt("cl_destino");
                docfac.num_doc_phc = rs.getInt("num_doc_phc");
                docfac.stamp_doc_phc = rs.getString("stamp_doc_phc");
                docfac.data = rs.getString("data");
                docfac.valor_c_iva = rs.getDouble("valor_c_iva");
                docfac.valor_s_iva = rs.getDouble("valor_s_iva");
                docfac.desc_fin = rs.getDouble("desc_fin");
                docfac.desc_com = rs.getDouble("desc_com");
                docfac.taxaiva1 = rs.getDouble("taxaiva1");
                docfac.taxaiva2 = rs.getDouble("taxaiva2");
                docfac.taxaiva3 = rs.getDouble("taxaiva3");
                docfac.taxaiva4 = rs.getDouble("taxaiva4");
                docfac.taxaiva5 = rs.getDouble("taxaiva5");
                docfac.taxaiva6 = rs.getDouble("taxaiva6");
                docfac.taxaiva7 = rs.getDouble("taxaiva7");
                docfac.taxaiva8 = rs.getDouble("taxaiva8");
                docfac.taxaiva9 = rs.getDouble("taxaiva9");
                docfac.custo = rs.getDouble("custo");
                docfac.fno = rs.getInt("fno");
                docfac.anulado = rs.getInt("anulado");
                docfac.carga = rs.getString("carga");
                docfac.cdata = rs.getString("cdata");
                docfac.chora = rs.getString("chora");
                docfac.cobranca = rs.getString("cobranca");
                docfac.codpost = rs.getString("codpost");
                docfac.descar = rs.getString("descar");
                docfac.eivain1 = rs.getDouble("eivain1");
                docfac.eivain2 = rs.getDouble("eivain2");
                docfac.eivain3 = rs.getDouble("eivain3");
                docfac.eivain4 = rs.getDouble("eivain4");
                docfac.eivain5 = rs.getDouble("eivain5");
                docfac.eivain6 = rs.getDouble("eivain6");
                docfac.eivain7 = rs.getDouble("eivain7");
                docfac.eivain8 = rs.getDouble("eivain8");
                docfac.eivain9 = rs.getDouble("eivain9");
                docfac.evirs = rs.getDouble("evirs");
                docfac.facturada = rs.getInt("facturada");
                docfac.impresso = rs.getInt("impresso");
                docfac.local = rs.getString("local");
                docfac.matricula = rs.getString("matricula");
                docfac.morada = rs.getString("morada");
                docfac.ncont = rs.getString("ncont");
                docfac.nome = rs.getString("nome");
                docfac.pais = rs.getInt("pais");
                docfac.pdata = rs.getString("pdata");
                docfac.telefone = rs.getString("telefone");
                docfac.tipo = rs.getString("tipo");
                docfac.ettiva = rs.getDouble("ettiva");
                docfac.ousrdata = rs.getString("ousrdata");
                docfac.ousrhora = rs.getString("ousrhora");
                docfac.usrdata = rs.getString("usrdata");
                docfac.usrhora = rs.getString("usrhora");
                docfac.assinatura = rs.getString("assinatura");
                docfac.codmotiseimp = rs.getString("codmotiseimp");
                docfac.formapag = rs.getString("formapag");
                docfac.motiseimp = rs.getString("motiseimp");
                
                //escreve dados
                content = "\n" + docfac.cl_destino + "/-!-/" + docfac.num_doc_phc + "/-!-/" + docfac.stamp_doc_phc + "/-!-/" + docfac.data
                         + "/-!-/" + docfac.valor_c_iva + "/-!-/" + docfac.valor_s_iva + "/-!-/" + docfac.desc_fin + "/-!-/" + docfac.desc_com
                         + "/-!-/" + docfac.taxaiva1 + "/-!-/" + docfac.taxaiva2 + "/-!-/" + docfac.taxaiva3 + "/-!-/" + docfac.taxaiva4
                         + "/-!-/" + docfac.taxaiva5 + "/-!-/" + docfac.taxaiva6 + "/-!-/" + docfac.taxaiva7 + "/-!-/" + docfac.taxaiva8
                         + "/-!-/" + docfac.taxaiva9 + "/-!-/" + docfac.custo + "/-!-/" + docfac.fno + "/-!-/" + docfac.anulado + "/-!-/" + docfac.carga
                         + "/-!-/" + docfac.cdata + "/-!-/" + docfac.chora + "/-!-/" + docfac.cobranca + "/-!-/" + docfac.codpost + "/-!-/" + docfac.descar
                         + "/-!-/" + docfac.eivain1 + "/-!-/" + docfac.eivain2 + "/-!-/" + docfac.eivain3 + "/-!-/" + docfac.eivain4 + "/-!-/" + docfac.eivain5
                         + "/-!-/" + docfac.eivain6 + "/-!-/" + docfac.eivain7 + "/-!-/" + docfac.eivain8 + "/-!-/" + docfac.eivain9 + "/-!-/" + docfac.evirs
                         + "/-!-/" + docfac.facturada + "/-!-/" + docfac.impresso + "/-!-/" + docfac.local + "/-!-/" + docfac.matricula + "/-!-/" + docfac.morada
                         + "/-!-/" + docfac.ncont + "/-!-/" + docfac.nome + "/-!-/" + docfac.pais + "/-!-/" + docfac.pdata + "/-!-/" + docfac.telefone
                         + "/-!-/" + docfac.tipo + "/-!-/" + docfac.ettiva + "/-!-/" + docfac.ousrdata + "/-!-/" + docfac.ousrhora + "/-!-/" + docfac.usrdata + "/-!-/" + docfac.usrhora
                         + "/-!-/" + docfac.assinatura + "/-!-/" + docfac.codmotiseimp + "/-!-/" + docfac.formapag + "/-!-/" + docfac.motiseimp;
                contentInBytes = content.getBytes();
                fop.write(contentInBytes);
                fop.flush();
                
                if ( num_files == 1000 ) {
                    if (fop != null) {
                        fop.close();
                        FilesList.add( random_string );
                        num_files = 0;
                    }
                }
                else {
                    num_files++;
                }

            }

            if (fop != null) {
                fop.close();
                FilesList.add( random_string );
            }
            
            return FilesList;
            
        } catch (SQLException e) {
            System.out.println( e );
            return null;
        }

    }
    
    public ArrayList<String> list_fi(String id) throws FileNotFoundException, IOException {
        
        ArrayList<String> FilesList = new ArrayList<String>();
        int num_files = 0;
        SecureRandom random = new SecureRandom();
        String random_string = null;
        File file = null;
        FileOutputStream fop = null;
        String content = null;
        byte[] contentInBytes = null;

        this.lastSQL = "select " +
                    "fistamp," +
                    "nmdoc," +
                    "fno," +
                    "ref," +
                    "design," +
                    "qtt," +
                    "tiliquido," +
                    "etiliquido," +
                    "iva," +
                    "ivaincl," +
                    "tabiva," +
                    "ndoc," +
                    "armazem," +
                    "ftstamp," +
                    "desconto," +
                    "custo," +
                    "ecusto," +
                    "pv," +
                    "epv "
                    + "from fi";
        
        DocFac docfac_i = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) {
                
               if ( num_files == 0 ) {

                    //abre ficheiro
                    random = new SecureRandom();
                    random_string = new BigInteger(130, random).toString(32);

                    file = new File( random_string );
                    fop = new FileOutputStream( file );
                    if (!file.exists()) {
                        file.createNewFile();
                    }

                    content = id;
                    contentInBytes = content.getBytes();
                    fop.write(contentInBytes);
                    fop.flush();
                }

                docfac_i = new DocFac( this.con );  
                docfac_i.fistamp = rs.getString("fistamp");
                docfac_i.nmdoc = rs.getString("nmdoc");
                docfac_i.fno = rs.getInt("fno");
                docfac_i.ref = rs.getString("ref");
                docfac_i.design = rs.getString("design");
                docfac_i.qtt = rs.getDouble("qtt");
                docfac_i.tiliquido = rs.getDouble("tiliquido");
                docfac_i.etiliquido = rs.getDouble("etiliquido");
                docfac_i.iva = rs.getDouble("iva");
                docfac_i.ivaincl = rs.getInt("ivaincl");
                docfac_i.tabiva = rs.getInt("tabiva");
                docfac_i.ndoc = rs.getInt("ndoc");
                docfac_i.armazem = rs.getInt("armazem");
                docfac_i.ftstamp = rs.getString("ftstamp");
                docfac_i.desconto = rs.getInt("desconto");
                docfac_i.custo = rs.getDouble("custo");
                docfac_i.ecusto = rs.getDouble("ecusto");
                docfac_i.pv = rs.getDouble("pv");
                docfac_i.epv = rs.getDouble("epv");
                
                //escreve dados
                content = "\n" + docfac_i.fistamp + "/-!-/" + docfac_i.nmdoc + "/-!-/" + docfac_i.fno + "/-!-/" + docfac_i.ref
                         + "/-!-/" + docfac_i.design + "/-!-/" + docfac_i.qtt + "/-!-/" + docfac_i.tiliquido + "/-!-/" + docfac_i.etiliquido
                         + "/-!-/" + docfac_i.iva + "/-!-/" + docfac_i.ivaincl + "/-!-/" + docfac_i.tabiva + "/-!-/" + docfac_i.ndoc
                         + "/-!-/" + docfac_i.armazem + "/-!-/" + docfac_i.ftstamp + "/-!-/" + docfac_i.desconto + "/-!-/" + docfac_i.custo
                         + "/-!-/" + docfac_i.ecusto + "/-!-/" + docfac_i.pv + "/-!-/" + docfac_i.epv;
                
                contentInBytes = content.getBytes();
                fop.write(contentInBytes);
                fop.flush();
                
                if ( num_files == 1000 ) {

                    if (fop != null) {

                        fop.close();
                        FilesList.add( random_string );
                        num_files = 0;
                    }
                }
                else {
                    num_files++;
                }

                
            }

            if (fop != null) {
                fop.close();
                FilesList.add( random_string );
            }
            
            return FilesList;
            
        } catch (SQLException e) {
            System.out.println( e );
            return null;
        }
    }
    
}
