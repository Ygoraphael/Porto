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

public class Encomenda_linha extends Db {
    
    public String ref;
    public String design;
    public double qtt;
    public double edebito;
    public double desconto;
    public double ettdeb;
    public double iva;
    public int ivaincl;
    public double etotal;
    public String tam;
    public String cor;
    
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
    
    
    public Encomenda_linha() 
    {
        super();
    }
   
   public Encomenda_linha(String hostname, String instanceName, String port, String username, String password, String db) 
   {
        super( hostname, instanceName, port, username, password, db );
   }
    
   public Encomenda_linha(Connection con){
        this.con = con;
    }
   
   private void log(SQLException e) 
   {     
        System.out.println(this.lastSQL);
        System.out.println(e.toString());    
    }
    
}
