/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;

import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.Date;

/**
 *
 * @author Tiago Loureiro
 */
public class Bi {
    
    private String lastSQL;
    
    public String ref;
    public String design;
    public double qtt;
    public double edebito;
    public double desconto;
    public double ettdeb;
    public double iva;
    public int ivaincl;
    public double etotal;
    public String tam = "";
    public String cor = "";
    
    public int lordem;
    
    public String bistamp;
    public String bostamp; 
    public float txiva;
    public int tabiva; 
    public int armazem = 1;
    public double pu;
    public int stipo;
    public int no; 
    public int ndos; 
    public Date dataopen;
    public String local;
    public String morada;
    public String codpost;
    public double eprorc;
    public double debito;
    public double prorc;
    public double ttdeb;
    public String ousrinis;
    public Date ousrdata;
    public Date ousrhora;
    public String usrinis;
    public Date usrdata;
    public Date usrhora;
    public Date dataobra;
    public int obrano;
    
    public boolean save( Statement stmt ) {
        

        SimpleDateFormat data = new SimpleDateFormat("yyyy-MM-dd");
        SimpleDateFormat hora = new SimpleDateFormat("H:m:s");
        
        this.lastSQL = "INSERT INTO bi(bistamp, bostamp, ref, design, qtt, iva, "
                + "tabiva, armazem, pu, stipo, ndos, dataobra, dataopen, "
                + "local, morada, codpost, edebito, epu, eprorc, ettdeb, ousrinis, ousrdata, "
                + "ousrhora, usrinis, usrdata, usrhora, desconto, ivaincl, tam, cor, unidade, lordem) "
                + "VALUES('" + this.bistamp + "', '" + this.bostamp + "', '"
                + this.ref + "', '" + this.design + "', '" + this.qtt + "', '"
                + this.iva + "', '" + this.tabiva + "', '" + this.armazem + "', '"
                + this.pu + "', '" + this.stipo + "', '"
                + this.ndos + "', '" + data.format(this.dataobra)+"', '"
                + data.format(this.dataopen) + "', '" + this.local+ "', '"
                + this.morada + "', '" + this.codpost + "', '" + this.edebito + "', '"
                + this.edebito + "', '" + this.eprorc + "', '"
                + this.ettdeb + "', '" + this.ousrinis + "', '"
                + data.format(this.ousrdata) + "', '" + hora.format(this.ousrhora) + "', '"
                + this.usrinis + "', '" + data.format(this.usrdata) + "', '"
                + hora.format(this.usrhora) + "', '" + this.desconto + "', '" + this.ivaincl + "',"
                + "'" + this.tam + "', '" + this.cor +  "', 'UNI', "+this.lordem+")";

        System.out.println( "QUERY: " + this.lastSQL );
        
        try {
            stmt.execute( this.lastSQL );
            
            this.lastSQL = "INSERT INTO bi2(bi2stamp,bostamp, ousrdata, morada, local, "
                    + "codpost) VALUES('" + this.bistamp + "', '"
                    + this.bostamp + "', '" + data.format(this.ousrdata) + "', '"
                    + this.morada+ "', '" + this.local+ "', '" + this.codpost+ "')";
         
            System.out.println( "QUERY: " + this.lastSQL );
            
            stmt.execute( this.lastSQL );
            return true;
            
        } catch (Exception e) {
            
            System.out.println("Bi Error: " + e.toString() );
            System.out.println(this.lastSQL);
            return false;
        }
    }
}
