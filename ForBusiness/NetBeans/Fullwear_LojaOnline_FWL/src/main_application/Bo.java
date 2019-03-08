/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import main_application.Encomenda_linha;

/**
 *
 * @author Tiago Loureiro
 */
public class Bo extends Db {
    
    private String bostamp;             //stamp
    public String nmdos;                //nome dossier
    
    public double etotaldeb;            //base incidencia
    public int obrano;                  //num. de encomenda
    public Date dataobra;               //data encomenda
    public String nome;                 //nome cliente
    public int no;                      //num. de cliente
    public Date boano;                  //ano encomenda
    public Date dataopen;               //data encomenda
    public int ndos;                    //num. dossier
    public String moeda = "PTE ou EURO";
    public String morada;               //morada cliente
    public String local;                //localidade cliente
    public String codpost;              //codigo postal cliente
    public String ncont;                //num. contribuinte cliente
    public double esdeb4;               //total sem iva
    public double ebo2tdesc1;           //desconto
    public double edescc;               //
    public double desc;                 //
    public double ebo2tvall;            //
    public double ebo21bins;            //base de incidencia iva
    public double ebo22bins;            //base de incidencia iva
    public double ebo22_iva;             //valor do iva
    public double ebototp2;             //total sem iva
    public String memissao = "EURO";
    public String origem = "BO";
    public int ocupacao = 4;            //
    public String email;                //
    public String inome;                // 
    public String ousrinis = "Site";
    public Date ousrdata;               //data criacao
    public Date ousrhora;               //hora criacao
    public String usrinis = "Site";
    public Date usrdata;                //data modificacao
    public Date usrhora;                //hora criacao
    public double etotal;               //
    public String trab4 = "Site"; 
    public String tipo = "GERAL";
    public String obs = "";
    public String envio = "";
    public String pagamento = "";
    public String order_number = "";
    
    public String estado;
    public double edesc;                //valor desconto comercial
    int fechada = 0;

    private String bo2stamp;            //
    public int autotipo = 1;            //
    public int pdtipo = 1;              //
    public String telefone;             //
    public String pais_origem;          //
    public double etotalciva;           //total com iva
    
    //tabela bot 
    public int codigo;                  //codigo iva
    public float taxa;                  //taxa de iva
    public double ebaseinc;             //base incid. iva
    public double evalor;               //valor iva incluido

    //dados para entrega
    public String nome_entrega;
    public String ncont_entrega;
    public String morada_entrega;
    public String codpost_entrega;
    public String local_entrega;
    public String telefone_entrega;
    public String pais_origem_entrega;
    public String order_shipment;
    
    //linhas
    public ArrayList<Encomenda_linha> orderItems;
    
    private String genStamp() throws SQLException 
    {    
        this.lastSQL = "select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5) stamp";   
        Statement stmt = this.con.createStatement();
        ResultSet rs = stmt.executeQuery( this.lastSQL );
        rs.next();
        return rs.getString("stamp");
    }
    
    public String getNmdos( int ndos ) throws SQLException 
    {    
        this.lastSQL = "SELECT nmdos FROM ts WHERE ndos = " + ndos;   
        Statement stmt = this.con.createStatement(); 
        ResultSet rs = stmt.executeQuery( this.lastSQL ); 
        rs.next();
        return rs.getString("nmdos");
    }
    
    public int getLastObraNo( int ndos ) throws SQLException 
    {    
        this.lastSQL = "SELECT MAX(obrano) obrano FROM bo WHERE ndos=" + ndos;
        Statement stmt = this.con.createStatement();
        ResultSet rs = stmt.executeQuery( this.lastSQL ); 
        try  
        {
            rs.next();
            int n = rs.getInt("obrano");
            return n;
        } 
        catch (Exception e) 
        {    
            return 0;
        }
    }
    
    public Bo(Connection con)
    {    
        super( con );   
    }
    
    public Bo(String hostname, String instanceName, String port, String username, String password, String db ) 
    {    
        super( hostname, instanceName, port, username, password, db);   
    }
    
    public boolean save() 
    {    
        System.out.println( "4" );
        Statement stmt = null;
        SimpleDateFormat data = new SimpleDateFormat("yyyy-MM-dd");
        SimpleDateFormat anod = new SimpleDateFormat("yyyy");
        SimpleDateFormat hora = new SimpleDateFormat("H:m:s");


        if( this.codpost == null ) {
            this.codpost = "";
        }

        try {

            this.bostamp = this.genStamp();
            this.nmdos = this.getNmdos( this.ndos );

            System.out.println( "5" );
            
            this.bo2stamp = this.bostamp;
            stmt = this.con.createStatement();

            this.lastSQL = 
                    "INSERT INTO bo"
                    + "("
                    + "bostamp,"
                    + "nmdos,"
                    + "etotaldeb,"
                    + "obrano,"
                    + "dataobra,"
                    + "nome,"
                    + "no,"
                    + "boano,"
                    + "dataopen,"
                    + "ndos,"
                    + "moeda,"
                    + "morada,"
                    + "local,"
                    + "codpost,"
                    + "ncont,"
                    + "esdeb4,"
                    + "ebo_2tdes1,"
                    + "edescc,"
                    + "ebo_2tvall,"
                    + "ebo22_bins,"
                    + "ebo21_bins,"
                    + "ebo22_iva,"
                    + "ebo_totp2,"
                    + "memissao,"
                    + "origem,"
                    + "ocupacao,"
                    + "inome,"
                    + "ousrinis,"
                    + "ousrdata,"
                    + "ousrhora,"
                    + "usrinis,"
                    + "usrdata,"
                    + "usrhora,"
                    + "etotal,"
                    + "trab4,"
                    + "tipo,"
                    + "vendedor,"
                    + "u_obscli,"
                    + "tpdesc,"
                    + "trab2,"
                    + "tabela2"
                    + ") "
                    + "VALUES('" 
                    + this.bostamp +"', '" 
                    + this.nmdos + "', '"
                    + this.etotaldeb + "', '" 
                    + this.obrano + "', '"
                    + data.format(this.dataobra) + "', '"
                    + this.nome + "', '" 
                    + this.no + "', '"
                    + anod.format(this.boano) + "', '" 
                    + data.format(this.dataopen) + "', '"
                    + this.ndos + "', '" 
                    + this.moeda + "', '" 
                    + this.morada + "', '"
                    + this.local + "', '" 
                    + this.codpost + "', '" 
                    + this.ncont + "', '" 
                    + this.esdeb4 + "', '" 
                    + this.ebo2tdesc1 + "', '" 
                    + this.edescc +"', '"
                    + this.ebo2tvall + "', '" 
                    + this.ebo22bins + "', '"
                    + this.ebo21bins + "', '"
                    + this.ebo22_iva + "', '" 
                    + this.ebototp2 + "', '"
                    + this.memissao + "', '" 
                    + this.origem + "', '"
                    + this.ocupacao + "', '" 
                    + this.inome + "', '" 
                    + this.ousrinis + "', '"
                    + data.format(this.ousrdata) + "', '" 
                    + hora.format(this.ousrhora) + "', '"
                    + this.usrinis + "', '" 
                    + data.format(this.usrdata) + "','"
                    + hora.format(this.usrhora) + "', '" 
                    + this.etotal + "', '" 
                    + this.trab4 + "', '"  
                    + this.tipo+ "', " 
                    + "'3', '" 
                    + this.obs + "', '" 
                    + this.pagamento + "', '" 
                    + this.order_number + "', '" 
                    + this.envio + " " 
                    +"')";
            
            System.out.println( "QUERY: " + this.lastSQL );
            
            stmt.execute( "BEGIN TRAN bo1");
            stmt.execute( this.lastSQL );
            
            this.lastSQL = "INSERT INTO bo2(bo2stamp, autotipo, pdtipo, "
                    + "ousrdata, usrdata, morada, local, codpost, email, telefone, "
                    + "etotalciva, area, u_entnome, u_entncont, u_entmorad, u_entcodp, u_entlocal, u_entpais, u_enttelef, u_estadenc) VALUES('" + this.bo2stamp + "', '"
                    + this.autotipo + "', '" + this.pdtipo + "', '"
                    + data.format(this.ousrdata) + "', '" + hora.format(this.usrdata) + "', '"
                    + this.morada + "', '" + this.local + "', '"
                    + this.codpost + "', '" + this.email + "', '"
                    + this.telefone + "', '"
                    + this.etotalciva + "', '"
                    + this.trab4 + "', '"
                    + this.nome_entrega + "', '"
                    + this.ncont_entrega + "', '"
                    + this.morada_entrega + "', '"
                    + this.codpost_entrega + "', '"
                    + this.local_entrega + "', '"
                    + this.pais_origem_entrega + "', '"
                    + this.telefone_entrega + "', 'Em Processamento')"; 

            System.out.println( "QUERY: " + this.lastSQL );
            
            stmt.execute( this.lastSQL );
            
            String botstamp = this.genStamp();

            this.lastSQL = "INSERT into bot(botstamp, bostamp, codigo, "
                    + "ousrdata, ousrhora, usrinis, usrdata, usrhora) "
                    + "VALUES('" + this.bostamp + "', '" + botstamp + "', "
                    + "'2', '" + data.format(this.usrdata) + "', '"
                    + hora.format(this.usrhora) + "', '" + this.usrinis +"', '"
                    + data.format(this.usrdata) + "','" + hora.format(this.usrhora) +"')";

            System.out.println( "QUERY: " + this.lastSQL );
            
            stmt.execute( this.lastSQL );
            
            Bi bi = null;
            Integer i = 0;

            System.out.println( "tamanho " + this.orderItems.size());
            int last_lordem = 0;
            
            for( Encomenda_linha oi : this.orderItems ) {

                System.out.println("Save items");
                System.out.println("Valor i " + i);

                bi = new Bi();

                bi.iva = 0;
                bi.tabiva = 2;
                bi.pu = 0; //?
                bi.stipo = 0; //?

                bi.bistamp = this.genStamp(); 
                bi.bostamp = this.bostamp;
                String[] parts = oi.ref.split("\\|\\|\\|");
                bi.ref = parts[0];
                bi.u_codproj = parts[1];
                bi.tam = parts[2];
                bi.cor = parts[3];
                bi.design = oi.design;
                bi.qtt = oi.qtt;
                bi.dataobra = this.dataobra;
                bi.dataopen = this.dataopen;
                bi.local = this.local;
                bi.morada = this.morada;
                bi.codpost = this.codpost;
                bi.edebito = oi.edebito; 
                bi.eprorc = 0; 
                bi.desconto = oi.desconto;
                bi.debito = bi.edebito*200.481999987; 
                bi.pu = bi.edebito*200.481999987; 
                bi.prorc = bi.eprorc*200.481999987; 
                bi.ttdeb = bi.ettdeb*200.481999987; 
                
                bi.ettdeb = (bi.qtt*bi.edebito) * (1 - (bi.desconto / 100));
                
                bi.lordem = oi.lordem;
                
                bi.ousrinis = this.ousrinis;
                bi.ousrdata = this.ousrdata; 
                bi.ousrhora = this.ousrhora;
                bi.usrinis = this.usrinis;
                bi.usrdata = this.usrdata;
                bi.usrhora = this.usrhora;
                bi.ndos = this.ndos;
                bi.obrano = this.obrano;

                last_lordem = oi.lordem;
                
                if (bi.save(stmt) == false) { 
                    return false;
                }
            }

            double value = Double.parseDouble(order_shipment);
            
            if( value > 0 )
            {
                bi = new Bi();

                bi.iva = 0;
                bi.tabiva = 2;
                bi.pu = 0; //?
                bi.stipo = 0; //?

                bi.bistamp = this.genStamp(); 
                bi.bostamp = this.bostamp;
                
                bi.ref = "FW-0379";
                bi.u_codproj = "0";
                bi.tam = "";
                bi.cor = "";
                bi.design = "Portes de Envio";
                bi.qtt = 1;
                bi.dataobra = this.dataobra;
                bi.dataopen = this.dataopen;
                bi.local = this.local;
                bi.morada = this.morada;
                bi.codpost = this.codpost;
                bi.edebito = value; 
                bi.eprorc = 0; 
                bi.desconto = 0;
                bi.debito = bi.edebito*200.481999987; 
                bi.pu = bi.edebito*200.481999987; 
                bi.prorc = bi.eprorc*200.481999987; 
                bi.ttdeb = bi.ettdeb*200.481999987; 
                bi.ettdeb = (bi.qtt*bi.edebito) * (1 - (bi.desconto / 100));
                bi.lordem = last_lordem + 10000;
                bi.ousrinis = this.ousrinis;
                bi.ousrdata = this.ousrdata; 
                bi.ousrhora = this.ousrhora;
                bi.usrinis = this.usrinis;
                bi.usrdata = this.usrdata;
                bi.usrhora = this.usrhora;
                bi.ndos = this.ndos;
                bi.obrano = this.obrano;

                if (bi.save(stmt) == false) { 
                    return false;
                }
            }
            
            System.out.println("will execute");
            stmt.execute( "COMMIT TRAN bo1");

            return true; 

        } 
        catch (Exception e) 
        {
            System.out.println("Bo error: " + e.toString());
            System.out.println("Last query: " + this.lastSQL);
            return false;
        }
    }
}
