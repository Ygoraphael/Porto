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

public class Encomenda extends Db {
    
    private String bostamp;
    public String estado;
    public double etotaldeb;
    public double edesc;
    public double etotal;
    public int obrano; //num. de obra
    public String dataobra;
    public String nome;
    public String tipo;
    public int no; //num. de cliente
    public Date boano;
    public Date dataopen;
    public int ndos; //num. interno do dossier
    public String moeda;
    public String morada;
    public String local;
    public String codpost;
    public String ncont; //num. contribuinte
    public double esdeb4; //total sem iva
    public double ebo2tdesc1; //desconto
    public double edescc;
    public double desc;
    public double ebo2tvall; 
    public double ebo22bins; //base de incidencia iva
    public double ebo21bins; //base de incidencia iva
    public double ebo22_iva; //valor do iva
    public double ebototp2; //total sem iva
    public String memissao; //moeda 
    public String origem = "BO";
    public int ocupacao = 4;
    public String email;
    public String inome; 
    public String ousrinis = "Site";
    public Date ousrdata; 
    public Date ousrhora;
    public String usrinis = "Site";
    public Date usrdata;
    public Date usrhora;
    public String trab4 = "Site";//Origem do Pedido
    public String tpdesc;
    public String obranome;//Tipo de Expedição
    public String u_obs;//Observações
    public String vendedor;
    public String vendedor_nome;
    public String pagamento;
    public String envio;
    public String order_number;
    int fechada = 0;
    
    public String nmdos;
    public String obs;
    
    private String bo2stamp;
    public int autotipo = 1;
    public int pdtipo = 1;
    public String telefone;
    public String pais_origem;
    public String descricao_orcamento;
    public double etotalciva; //total com iva
    
    //tabela bot 
    private String botstamp;
    public int codigo; //codigo iva
    public float taxa; //taxa de iva
    public double ebaseinc; //base incid. iva
    public double evalor; //valor iva incluido
    
    public String nome_entrega;
    public String morada_entrega;
    public String local_entrega;
    public String telefone_entrega;
    public String pais_origem_entrega;
    public String codpost_entrega;
    
    public ArrayList<Encomenda_linha> Itens = new ArrayList<Encomenda_linha>();
    
    public Encomenda() 
    {
        super();
    }
   
   public Encomenda(String hostname, String instanceName, String port, String username, String password, String db) 
   {
        super( hostname, instanceName, port, username, password, db );
   }
    
   public Encomenda(Connection con){
        this.con = con;
    }
   
   public String checkPelicas(String s){

        if(s.contains("'")){
            s=s.replace("'", "''");
        }
        return s;
    }
   
   public boolean save(Config conf) throws SQLException, ParseException 
   {
        Bo bo = new Bo( conf.getDbHost(), conf.getDbInstance(), conf.getDbPort(), conf.getDbUser(), 
                conf.getDbPass(), conf.getDb() );
        
        bo.ndos = Integer.parseInt(conf.getNDoc());
        //bo.obrano = bo.getLastObraNo(Integer.parseInt(conf.getNDoc())) + 1;
        bo.obrano = this.obrano;

        bo.no = this.no;
        bo.nome = checkPelicas(this.nome);
        bo.ncont = this.ncont;
        bo.morada = checkPelicas(this.morada);
        bo.codpost = checkPelicas(this.codpost);
        bo.local = checkPelicas(this.local);
        bo.pais_origem = checkPelicas(this.pais_origem);
        bo.email = checkPelicas(this.email);
        bo.telefone = checkPelicas(this.telefone);
        
        bo.nome_entrega = checkPelicas(this.nome_entrega);
        bo.morada_entrega = checkPelicas(this.morada_entrega);
        bo.local_entrega = checkPelicas(this.local_entrega);
        bo.telefone_entrega = checkPelicas(this.telefone_entrega);
        bo.pais_origem_entrega = checkPelicas(this.pais_origem_entrega);
        bo.codpost_entrega = checkPelicas(this.codpost_entrega);
        
        bo.edescc = this.edescc;
        bo.etotal = this.etotal;
        bo.etotaldeb = this.etotaldeb;

        bo.tpdesc = checkPelicas(this.pagamento);
        bo.envio = checkPelicas(this.envio);
        bo.order_number = checkPelicas(this.order_number);
        
        Date d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse( this.dataobra );
        bo.dataobra = d;
        
        d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse( this.dataobra );
        bo.boano = d;
        
        d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse( this.dataobra );
        bo.dataopen = d;
        
        bo.estado = "Em Processamento";
        
        bo.moeda = "EURO"; 
        
        bo.ebo2tdesc1 = 0;
        bo.ebo2tvall = this.etotal;
        
        bo.ebo21bins = this.etotal;
        bo.ebo22bins = this.etotal;
        
        bo.ebo22_iva = this.ebo22_iva;
        bo.ebototp2 = 0;
        
        bo.memissao = "EURO";
        bo.obs = checkPelicas(this.obs);
        
        d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse( this.dataobra );
        bo.ousrdata = d;
        
        d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse( this.dataobra );
        bo.ousrhora = d;
        
        d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse( this.dataobra );
        bo.usrdata = d;
        
        d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse( this.dataobra );
        bo.usrhora = d;
        
        bo.orderItems = this.Itens;
        
        return bo.save();
   }

   public String GetLastModification( Config conf ) 
   {     
        this.lastSQL = "select isnull(MAX(obrano), 0) nummax from bo where ndos = " + conf.getNDoc();
        ResultSet rs = null;
        Statement stmt = null;
        
        try 
        {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery( this.lastSQL );
            
            while (rs.next()) 
            {
                return rs.getString("nummax"); 
            }
        }
        catch (SQLException e) 
        {
            this.log(e);
            return null;
        }
        
        return "";
   }
   
   private void log(SQLException e) 
   {     
        System.out.println(this.lastSQL);
        System.out.println(e.toString());    
   }
    
}
