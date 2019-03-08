package main_application;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

/**
 *
 * @author Tiago Loureiro
 */

public class Dados extends Db {

    String numRows = "20";
    
    public Dados() 
    {
        super();
    }
   
   public Dados(String hostname, String instanceName, String port, String username, String password, String db, String NumRows) 
   {
        super( hostname, instanceName, port, username, password, db );
        numRows = NumRows;
   }
    
   public Dados(Connection con){
        this.con = con;
   }
   
   public ArrayList<DataObject>list() throws ParseException 
   {
        this.lastSQL = "SELECT top " + numRows + " * from u_ncsync (nolock) where done = 0 order by ousrdata asc, ousrhora asc";

        ArrayList<DataObject> lista = new ArrayList<DataObject>();
        DataObject registo = null;
        
        ResultSet rs = null;
        ResultSet rs2 = null;
        Statement stmt = null;
        Statement stmt2 = null;
        int num_colunas;
        int rowCount = 0;
        ResultSetMetaData rsmd;
        ArrayList<ArrayList<String>> tmp;
        java.lang.Object ob;
        
        System.out.println( "QUERY: " + this.lastSQL );
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) 
            {
                registo = new DataObject();
                this.lastSQL = "SELECT * from " + rs.getString("table") + " (nolock) where " + rs.getString("table") + "stamp = '" + rs.getString("stamp") + "'";
                tmp = new ArrayList<ArrayList<String>>();
                
                switch( rs.getString("type").toString().trim() )
                {
                    case "INSERT":
                        stmt2 = this.con.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE, ResultSet.CONCUR_READ_ONLY);
                        rs2 = stmt2.executeQuery(this.lastSQL);
                        rowCount = rs2.last() ? rs2.getRow() : 0;
                        
                        stmt2 = this.con.createStatement();
                        rs2 = stmt2.executeQuery(this.lastSQL);
                        rsmd = rs2.getMetaData();
                        num_colunas = rsmd.getColumnCount();
                        
                        if( rowCount > 0 ) {
                            while (rs2.next())
                            {
                                for(int x = 1; x <= num_colunas; x++) {
                                    ArrayList<String> tmp_list = new ArrayList<String>();

                                    if( rsmd.getColumnTypeName(x).toString().trim().equals("bit") ) {
                                        if( rs2.getObject(x).toString().trim().toLowerCase().equals("true") ) {
                                            tmp_list.add( "1" );
                                        }
                                        else if( rs2.getObject(x).toString().trim().toLowerCase().equals("false") ) {
                                            tmp_list.add( "0" );
                                        }
                                        else {
                                            ob = rs2.getObject(x);
                                            if (rs2.wasNull()) {
                                                tmp_list.add( "" );
                                            }
                                            else {
                                                tmp_list.add( ob.toString().trim() );
                                            }
                                        }
                                    }
                                    else {
                                        ob = rs2.getObject(x);
                                        if (rs2.wasNull()) {
                                            tmp_list.add( "" );
                                        }
                                        else {
                                            tmp_list.add( ob.toString().trim() );
                                        }
                                    }

                                    tmp_list.add( rsmd.getColumnName(x).toString().trim() );
                                    tmp_list.add( rsmd.getColumnTypeName(x).toString().trim() );

                                    tmp.add(tmp_list);
                                }
                            }
                        }

                        break;
                    case "UPDATE":
                        stmt2 = this.con.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE, ResultSet.CONCUR_READ_ONLY);
                        rs2 = stmt2.executeQuery(this.lastSQL);
                        rowCount = rs2.last() ? rs2.getRow() : 0;
                        
                        stmt2 = this.con.createStatement();
                        rs2 = stmt2.executeQuery(this.lastSQL);
                        rsmd = rs2.getMetaData();
                        num_colunas = rsmd.getColumnCount();
                        
                        if( rowCount > 0 ) {
                            while (rs2.next())
                            {
                                for(int x = 1; x <= num_colunas; x++) {
                                    ArrayList<String> tmp_list = new ArrayList<String>();

                                    if( rsmd.getColumnTypeName(x).toString().trim().equals("bit") ) {
                                        if( rs2.getObject(x).toString().trim().toLowerCase().equals("true") ) {
                                            tmp_list.add( "1" );
                                        }
                                        else if( rs2.getObject(x).toString().trim().toLowerCase().equals("false") ) {
                                            tmp_list.add( "0" );
                                        }
                                        else {
                                           tmp_list.add( rs2.getObject(x).toString().trim() ); 
                                        }
                                    }
                                    else {
                                        tmp_list.add( rs2.getObject(x).toString().trim() );
                                    }

                                    tmp_list.add( rsmd.getColumnName(x).toString().trim() );
                                    tmp_list.add( rsmd.getColumnTypeName(x).toString().trim() );

                                    tmp.add(tmp_list);
                                }
                            }
                        }
                        break;
                    case "DELETE":
                        rowCount = 1;
                        break;
                    default:
                        System.out.println("Unknown type: " + rs.getString("type").toString().trim() );
                    break;
                }
                
                registo.datarow = tmp;
                registo.table = rs.getString("table").toString().trim();
                if( rowCount > 0 ) {
                    registo.type = rs.getString("type").toString().trim();
                }
                else {
                    registo.type = "MAKEITSUCCESS";
                }
                registo.stamp = rs.getString("stamp").toString().trim();
                registo.u_ncsyncstamp = rs.getString("u_ncsyncstamp").toString().trim();

                lista.add(registo);
            }

            return lista;
        } 
        catch (SQLException e) 
        {
            this.log(e);
            return null;
        }
    }
   
   private void log(SQLException e) 
   {     
        System.out.println("Query erro: " + this.lastSQL);
        System.out.println(e.toString());
   }
    
}
