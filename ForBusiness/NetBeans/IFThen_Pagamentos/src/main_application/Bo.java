/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;

import java.io.File;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Scanner;

/**
 *
 * @author Tiago Loureiro
 */
public class Bo extends Db {
    
    public String Referencia;
    public Date DtHrPagamento;
    public int ndos;
    public String bostamp;
    
    public String getEncomenda( int ndos, Date DtHrPagamento, String Referencia ) throws SQLException 
    {    
        this.lastSQL = "SELECT bostamp FROM bo WHERE ndos=" + ndos + " and u_refloja = '' and dataobra >= 1900-01-01 and dataobra <= 1900-01-31";
        Statement stmt = this.con.createStatement();
        ResultSet rs = stmt.executeQuery( this.lastSQL );
        try  
        {
            if (rs.next() ) {
                String n = rs.getString("bostamp");
                return n;
            }
        } 
        catch (Exception e) 
        {    
            return "";
        }
        return "";
    }
    
    public ResultSet getDados( String bostamp ) throws SQLException 
    {    
        this.lastSQL = "SELECT bo.nome, bo2.email, bo.obrano FROM bo inner join bo2 on bo.bostamp = bo2.bo2stamp WHERE bo.bostamp='" + bostamp + "'";
        Statement stmt = this.con.createStatement();
        ResultSet rs = stmt.executeQuery( this.lastSQL );
        return rs;
    }
    
    public Bo(Connection con)
    {    
        super( con );   
    }
    
    public Bo(String hostname, String instanceName, String port, String username, String password, String db ) 
    {    
        super( hostname, instanceName, port, username, password, db);   
    }
    
    public boolean update( String from, String host, String user, String password, String subject ) 
    {    
        Statement stmt = null;
        
        try {

            this.bostamp = this.getEncomenda(this.ndos, this.DtHrPagamento, this.Referencia);
            stmt = this.con.createStatement();

            this.lastSQL = "update bo set u_pagef = 1 and u_pagdt = '" + DtHrPagamento.toString() + "' where bostamp = '" + this.bostamp + "'";
            System.out.println( "QUERY: " + this.lastSQL );
            stmt.execute( this.lastSQL );
            System.out.println( "QUERY EXECUTADA" );

            ResultSet rs = this.getDados(this.bostamp);
            
            try  
            {
                if (rs.next() ) {
                    String to = rs.getString("email");
                    String nome = rs.getString("nome");
                    int encomenda = rs.getInt("obrano");
                    
                    String html = new Scanner(new File( System.getProperty("user.dir") + "\\mail.html" )).useDelimiter("\\Z").next();
                    html = html.replaceAll("CLIENTE_NOME", nome);
                    html = html.replaceAll("NUM_ENCOMENDA", Integer.toString(encomenda) );
                    
                    if( !to.trim().equals("") ) {
                        Email em = new Email(to, from, host, user, password, subject, html);
                        if( em.send() ) {
                            System.out.println("Email enviado com sucesso....");
                        }
                        else {
                            System.out.println("Email não foi enviado....");
                        }
                    }
                }
            } 
            catch (Exception e) 
            {    
                System.out.println(e);
            }
            
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
