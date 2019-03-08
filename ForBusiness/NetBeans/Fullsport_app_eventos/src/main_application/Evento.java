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

public class Evento extends Db {
    
    public String obrano;       // numero evento
    public String dataopen;     // data inicio
    public String dataobra;     // data evento
    public String datafinal;    // data fim
    public String boano;        // ano
    public String obranome;     // responsavel fullsport
    public String nome;         // nome cliente
    public String no;           // numero cliente
    public String ncont;        // num contribuinte cliente
    public String morada;       // morada cliente
    public String local;        // localidade cliente
    public String codpost;      // cod postal cliente
    public String tabela1;      // modalidade
    public String tabela2;      // estado evento
    public String u_resp;       // responsavel cliente evento
    public String trab3;        // email responsavel cliente evento
    public String trab4;        // telf1 responsavel cliente evento
    public String trab5;        // telf2 responsavel cliente evento
    public String trab1;        // descricao evento
    public String u_obs;        // observacao evento
    public String u_idevento;   // id evento site
    
    public Evento() 
    {
        super();
    }
   
   public Evento(String hostname, String instanceName, String port, String username, String password, String db) 
   {
        super( hostname, instanceName, port, username, password, db );
   }
    
   public Evento(Connection con){
        this.con = con;
    }
   
   public ArrayList<Evento>list(Date data) 
   {
        DateFormat full = new SimpleDateFormat("YYYY-MM-dd");
        Config config = new Config();
        
        this.lastSQL = 
                  "SELECT "
                +   "obrano, "
                +   "dataopen, "
                +   "dataobra, "
                +   "datafinal, "
                +   "boano, "
                +   "REPLACE(obranome, char(34), '') obranome, "
                +   "REPLACE(nome, char(34), '') nome, "
                +   "no, "
                +   "ncont, "
                +   "REPLACE(morada, char(34), '') morada, "
                +   "REPLACE(local, char(34), '') local, "
                +   "REPLACE(codpost, char(34), '') codpost, "
                +   "tabela1, "
                +   "tabela2, "
                +   "u_resp, "
                +   "trab3, "
                +   "trab4, "
                +   "trab5, "
                +   "trab1, "
                +   "REPLACE(CONVERT(VARCHAR(8000), u_obs), char(34), '') u_obs, "
                +   "u_idevento "
                +   "FROM bo "
                +   "WHERE usrdata >='" + full.format( data ) + "' and ndos = " + config.getNDoc()
                +   " ORDER BY bo.obrano";

        ArrayList<Evento> eventos = new ArrayList<Evento>();
        Evento evento = null;
        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) 
            {
                evento = new Evento( this.con );
                
                evento.obrano = rs.getString("obrano");
                evento.dataopen = rs.getString("dataopen");
                evento.dataobra = rs.getString("dataobra");
                evento.datafinal = rs.getString("datafinal");
                evento.boano = rs.getString("boano");
                evento.obranome = rs.getString("obranome");
                evento.nome = rs.getString("nome");
                evento.no = rs.getString("no");
                evento.ncont = rs.getString("ncont");
                evento.morada = rs.getString("morada");
                evento.local = rs.getString("local");
                evento.codpost = rs.getString("codpost");
                evento.tabela1 = rs.getString("tabela1");
                evento.tabela2 = rs.getString("tabela2");
                evento.u_resp = rs.getString("u_resp");
                evento.trab3 = rs.getString("trab3");
                evento.trab4 = rs.getString("trab4");
                evento.trab5 = rs.getString("trab5");
                evento.trab1 = rs.getString("trab1");
                evento.u_obs = rs.getString("u_obs");
                evento.u_idevento = rs.getString("u_idevento");
                
                eventos.add(evento);
            }
            
            return eventos;
            
        } 
        catch (SQLException e) 
        {
            this.log(e);
            return null;
        }
    }
   
   private String genStamp() throws SQLException {
        this.lastSQL = "select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5) stamp";
        Statement stmt = this.con.createStatement();
        ResultSet rs = stmt.executeQuery( this.lastSQL );
        rs.next();
        return rs.getString("stamp");

    }
   
   public String getNmdos( String ndos ) throws SQLException {
        this.lastSQL = "SELECT nmdos FROM ts WHERE ndos = " + ndos;
        Statement stmt = this.con.createStatement(); 
        ResultSet rs = stmt.executeQuery( this.lastSQL ); 
        rs.next();
        return rs.getString("nmdos");     
    }
   
   public int getLastObraNo( String ndos ) throws SQLException {
        this.lastSQL = "SELECT MAX(obrano) + 1 obrano FROM bo WHERE ndos=" + ndos;
        Statement stmt = this.con.createStatement();
        ResultSet rs = stmt.executeQuery( this.lastSQL ); 
        try  {
            rs.next();
            int n = rs.getInt("obrano");
            return n;
        } catch (Exception e) {
            return 0;
        }
    }
   
   public boolean save( Config conf ) throws SQLException {
       Date d = new Date();
       String GenStamp = genStamp();
       String NextObraNo = Integer.toString(getLastObraNo(conf.getNDoc()));
       
       Statement stmt = null;
       SimpleDateFormat data = new SimpleDateFormat("yyyy-MM-dd");
       SimpleDateFormat anod = new SimpleDateFormat("yyyy");
       SimpleDateFormat hora = new SimpleDateFormat("H:m:s");
       Config config = new Config();
       
       try {
            stmt = this.con.createStatement();
            
            this.lastSQL = 
                    "INSERT INTO bo"
                    + "("
                    + "ndos,"
                    + "nmdos,"
                    + "bostamp,"
                    + "obrano,"
                    + "dataopen,"
                    + "dataobra,"
                    + "datafinal,"
                    + "boano,"
                    + "obranome,"
                    + "nome,"
                    + "no,"
                    + "ncont,"
                    + "morada,"
                    + "local,"
                    + "codpost,"
                    + "tabela1,"
                    + "tabela2,"
                    + "u_resp,"
                    + "trab3,"
                    + "trab4,"
                    + "trab5,"
                    + "trab1,"
                    + "u_obs,"
                    + "u_idevento,"
                    + "ousrinis,"
                    + "ousrdata,"
                    + "ousrhora,"
                    + "usrinis,"
                    + "usrdata,"
                    + "usrhora"
                    + ") "
                    + "VALUES('" 
                    + config.getNDoc() +"', '" 
                    + getNmdos(config.getNDoc()) +"', '" 
                    + GenStamp +"', '" 
                    + NextObraNo +"', '" 
                    + data.format( new java.util.Date(Long.valueOf(this.dataopen)*1000) ) + "', '"
                    + data.format(new java.util.Date(Long.valueOf(this.dataobra)*1000)) + "', '"
                    + data.format(new java.util.Date(Long.valueOf(this.datafinal)*1000)) + "', '"
                    + this.boano + "', '" 
                    + this.obranome + "', '" 
                    + this.nome + "', '" 
                    + this.no + "', '"
                    + this.ncont + "', '"
                    + this.morada + "', '"
                    + this.local + "', '"
                    + this.codpost + "', '"
                    + this.tabela1 + "', '"
                    + this.tabela2 + "', '"
                    + this.u_resp + "', '"
                    + this.trab3 + "', '"
                    + this.trab4 + "', '"
                    + this.trab5 + "', '"
                    + this.trab1 + "', '"
                    + this.u_obs + "', '"
                    + this.u_idevento + "', '"
                    + "APP Eventos" + "', '"
                    + data.format(d) + "', '" 
                    + hora.format(d) + "', '"
                    + "APP Eventos" + "', '" 
                    + data.format(d) + "','"
                    + hora.format(d) + "')";
            
            System.out.println(this.lastSQL);

            if(stmt.execute( this.lastSQL ))
            {
                this.lastSQL = "insert into u_etapas (bostamp, etapa, local) values('"+GenStamp+"', 'Partida','')";
                stmt.execute( this.lastSQL );
                this.lastSQL = "insert into u_etapas (bostamp, etapa, local) values('"+GenStamp+"', 'Chegada’','')";
                stmt.execute( this.lastSQL );
            }
            return true; 
       }
       catch (Exception e) {
        System.out.println("Event error: " + e.toString());
        System.out.println("Last query: " + this.lastSQL);
        return false;
       }
   }
   
   public String GetLastModification() throws ParseException
   {
       Config config = new Config();
        
        this.lastSQL = 
                  "SELECT "
                +   "MAX(usrdata + usrhora) mdate  "
                +   "FROM bo "
                +   "WHERE ndos = " + config.getNDoc();

        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) 
            {
                long unixtime;
                DateFormat dfm = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.0");
                dfm.setTimeZone(TimeZone.getTimeZone("GMT"));
                unixtime = dfm.parse(rs.getString("mdate")).getTime();
                unixtime=unixtime/1000;
                
                return Long.toString(unixtime);
            }
            
        } 
        catch (SQLException e) 
        {
            this.log(e);
            return null;
        }
        
        return "0";
   }
   
   private void log(SQLException e) {
        
        System.out.println(this.lastSQL);
        System.out.println(e.toString());
        
    }
    
}
