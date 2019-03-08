/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;
import java.io.IOException;
import java.io.PrintWriter;
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
import static javax.swing.JOptionPane.showMessageDialog;
/**
 *
 * @author tml
 */
public class SchemaCloner extends Db {
    
    String table;
    String createTable;
    String column_name;
    String is_nullable;
    String char_max;
    String numeric_precision;
    String numeric_scale;
    
    String trigger_query;
    
    public SchemaCloner() 
    {
        super();
    }

    public SchemaCloner(String hostname, String instanceName, String port, String username, String password, String db, String man_table) 
    {
        super( hostname, instanceName, port, username, password, db );
        this.table = man_table;
    }

    public SchemaCloner(Connection con){
        this.con = con;
    }
    
    public void cloneTable() throws ParseException {
        this.createTable = "DROP TABLE " + this.table + ";\n";
        this.createTable += "CREATE TABLE " + this.table + " (\n";
        
        this.lastSQL = "select " +
            "	COLUMN_NAME, " +
            "	IS_NULLABLE, " +
            "	DATA_TYPE, " +
            "	isnull(character_maximum_length, '') character_maximum_length, " +
            "	isnull(numeric_precision, '') numeric_precision, " +
            "	isnull(NUMERIC_SCALE, '') NUMERIC_SCALE " +
            "from INFORMATION_SCHEMA.COLUMNS " +
            "where table_name = '" + this.table + "' " +
            "order by ORDINAL_POSITION asc";

        ResultSet rs = null;
        Statement stmt = null;
        
        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            
            while (rs.next()) 
            {
                this.column_name = rs.getString("COLUMN_NAME").toString().trim().toLowerCase();
                this.is_nullable = rs.getString("IS_NULLABLE").toString().trim().toLowerCase();
                this.char_max = rs.getString("character_maximum_length").toString().trim().toLowerCase();
                this.numeric_precision = rs.getString("numeric_precision").toString().trim().toLowerCase();
                this.numeric_scale = rs.getString("NUMERIC_SCALE").toString().trim().toLowerCase();
                
                switch( rs.getString("DATA_TYPE").toString().trim().toUpperCase() )
                {
                    case "INT":
                        this.createTable += "`" + this.column_name + "` INT ";
                        break;
                    case "TINYINT":
                        this.createTable += "`" + this.column_name + "` TINYINT ";
                        break;
                    case "SMALLINT":
                        this.createTable += "`" + this.column_name + "` SMALLINT ";
                        break;
                    case "BIGINT":
                        this.createTable += "`" + this.column_name + "` BIGINT ";
                        break;
                    case "FLOAT":
                        this.createTable += "`" + this.column_name + "` NUMERIC(" + this.numeric_precision + "," + this.numeric_scale + ") ";
                        break;
                    case "REAL":
                        this.createTable += "`" + this.column_name + "` NUMERIC(" + this.numeric_precision + "," + this.numeric_scale + ") ";
                        break;
                    case "DECIMAL":
                        this.createTable += "`" + this.column_name + "` NUMERIC(" + this.numeric_precision + "," + this.numeric_scale + ") ";
                        break;
                    case "MONEY":
                        this.createTable += "`" + this.column_name + "` NUMERIC(" + this.numeric_precision + "," + this.numeric_scale + ") ";
                        break;
                    case "SMALLMONEY":
                        this.createTable += "`" + this.column_name + "` NUMERIC(" + this.numeric_precision + "," + this.numeric_scale + ") ";
                        break;
                    case "CHAR":
                        this.createTable += "`" + this.column_name + "` CHAR(" + this.char_max + ") ";
                        break;
                    case "VARCHAR":
                        this.createTable += "`" + this.column_name + "` VARCHAR(" + this.char_max + ") ";
                        break;
                    case "NCHAR":
                        this.createTable += "`" + this.column_name + "` TEXT ";
                        break;
                    case "NUMERIC":
                        this.createTable += "`" + this.column_name + "` NUMERIC(" + this.numeric_precision + "," + this.numeric_scale + ") ";
                        break;
                    case "DATETIME":
                        this.createTable += "`" + this.column_name + "` DATETIME(3) ";
                        break;
                    case "BIT":
                        this.createTable += "`" + this.column_name + "` TINYINT(4) ";
                        break;
                    case "TEXT":
                        this.createTable += "`" + this.column_name + "` LONGTEXT ";
                        break;
                    case "DATE":
                        this.createTable += "`" + this.column_name + "` DATE ";
                        break;
                    case "TIME":
                        this.createTable += "`" + this.column_name + "` TIME ";
                        break;
                    default:
                        System.out.println("Unknown type");
                    break;
                }
                
                if( this.is_nullable.equals("no") ) {
                    this.createTable += "NOT NULL, ";
                }
                else {
                    this.createTable += ", ";
                }
                
                this.createTable += "\n";
            }
            this.createTable = this.createTable.substring(0, this.createTable.length() - 3) + ");";
            
            //criar triggers
            this.trigger_query = "IF EXISTS (SELECT * FROM sys.triggers WHERE object_id = OBJECT_ID(N'[dbo].[ttabelaadelete]'))\n" +
            "DROP TRIGGER [dbo].[ttabelaadelete]\n";
            
            this.lastSQL = this.trigger_query.replaceAll("ttabelaa", this.table);
            stmt = null;
            try 
            {
                stmt = this.con.createStatement();
                stmt.executeUpdate(this.lastSQL);
            }
            catch (SQLException e) 
            {
                this.log(e);
            }
            
            this.trigger_query = "CREATE TRIGGER [dbo].[ttabelaadelete] \n" +
            "   ON  [dbo].[ttabelaa]\n" +
            "   AFTER DELETE\n" +
            "AS \n" +
            "BEGIN\n" +
            "	SET NOCOUNT ON;\n" +
            "\n" +
            "	INSERT INTO u_ncsync ([u_ncsyncstamp], [stamp], [table], [type], [done], [ousrdata], [ousrhora]) \n" +
            "	SELECT \n" +
            "	CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))), \n" +
            "	ttabelaastamp, \n" +
            "	'ttabelaa', \n" +
            "	'DELETE', \n" +
            "	0, \n" +
            "	CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', \n" +
            "	CONVERT(VARCHAR(8), GETDATE(), 8)\n" +
            "	FROM deleted left join u_ncsync on deleted.ttabelaastamp=u_ncsync.stamp and u_ncsync.[table] = 'ttabelaa' and u_ncsync.type = 'DELETE'\n" +
            "	WHERE isnull(u_ncsync.stamp,'') = ''\n" +
            "END\n";
            
            this.lastSQL = this.trigger_query.replaceAll("ttabelaa", this.table);
            stmt = null;
            try 
            {
                stmt = this.con.createStatement();
                stmt.executeUpdate(this.lastSQL);
            }
            catch (SQLException e) 
            {
                this.log(e);
            }
            
            this.trigger_query = "IF EXISTS (SELECT * FROM sys.triggers WHERE object_id = OBJECT_ID(N'[dbo].[ttabelaainsert]'))\n" +
            "DROP TRIGGER [dbo].[ttabelaainsert]\n";
            
            this.lastSQL = this.trigger_query.replaceAll("ttabelaa", this.table);
            stmt = null;
            try 
            {
                stmt = this.con.createStatement();
                stmt.executeUpdate(this.lastSQL);
            }
            catch (SQLException e) 
            {
                this.log(e);
            }
            
            this.trigger_query = "CREATE TRIGGER [dbo].[ttabelaainsert] \n" +
            "   ON  [dbo].[ttabelaa]\n" +
            "   AFTER INSERT\n" +
            "AS \n" +
            "BEGIN\n" +
            "	SET NOCOUNT ON;\n" +
            "\n" +
            "	INSERT INTO u_ncsync ([u_ncsyncstamp], [stamp], [table], [type], [done], [ousrdata], [ousrhora]) \n" +
            "	SELECT \n" +
            "	CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))), \n" +
            "	ttabelaastamp, \n" +
            "	'ttabelaa', \n" +
            "	'INSERT', \n" +
            "	0, \n" +
            "	CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', \n" +
            "	CONVERT(VARCHAR(8), GETDATE(), 8)\n" +
            "	FROM inserted left join u_ncsync on inserted.ttabelaastamp=u_ncsync.stamp and u_ncsync.[table] = 'ttabelaa' and u_ncsync.type = 'INSERT'\n" +
            "	WHERE isnull(u_ncsync.stamp,'') = ''\n" +
            "END\n";
            
            this.lastSQL = this.trigger_query.replaceAll("ttabelaa", this.table);
            stmt = null;
            try 
            {
                stmt = this.con.createStatement();
                stmt.executeUpdate(this.lastSQL);
            }
            catch (SQLException e) 
            {
                this.log(e);
            }
            
            this.trigger_query = "IF EXISTS (SELECT * FROM sys.triggers WHERE object_id = OBJECT_ID(N'[dbo].[ttabelaaupdate]'))\n" +
            "DROP TRIGGER [dbo].[ttabelaaupdate]\n";
            
            this.lastSQL = this.trigger_query.replaceAll("ttabelaa", this.table);
            stmt = null;
            try 
            {
                stmt = this.con.createStatement();
                stmt.executeUpdate(this.lastSQL);
            }
            catch (SQLException e) 
            {
                this.log(e);
            }
            
            this.trigger_query = "CREATE TRIGGER [dbo].[ttabelaaupdate] \n" +
            "   ON  [dbo].[ttabelaa]\n" +
            "   AFTER UPDATE\n" +
            "AS \n" +
            "BEGIN\n" +
            "	SET NOCOUNT ON;\n" +
            "\n" +
            "	UPDATE \n" +
            "		u_ncsync \n" +
            "	set \n" +
            "		ousrdata = CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', \n" +
            "		ousrhora = CONVERT(VARCHAR(8), GETDATE(), 8) \n" +
            "	from u_ncsync inner join inserted on u_ncsync.stamp = inserted.ttabelaastamp\n" +
            "	WHERE \n" +
            "		u_ncsync.[table] = 'ttabelaa' and \n" +
            "		u_ncsync.type = 'UPDATE'\n" +
            "\n" +
            "	INSERT INTO u_ncsync ([u_ncsyncstamp], [stamp], [table], [type], [done], [ousrdata], [ousrhora]) \n" +
            "	SELECT \n" +
            "	CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))), \n" +
            "	ttabelaastamp, \n" +
            "	'ttabelaa', \n" +
            "	'UPDATE', \n" +
            "	0, \n" +
            "	CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', \n" +
            "	CONVERT(VARCHAR(8), GETDATE(), 8)\n" +
            "	FROM inserted left join u_ncsync on inserted.ttabelaastamp=u_ncsync.stamp and u_ncsync.[table] = 'ttabelaa' and u_ncsync.type = 'UPDATE'\n" +
            "	WHERE isnull(u_ncsync.stamp,'') = ''\n" +
            "END";
            
            this.lastSQL = this.trigger_query.replaceAll("ttabelaa", this.table);
            stmt = null;
            try 
            {
                stmt = this.con.createStatement();
                stmt.executeUpdate(this.lastSQL);
            }
            catch (SQLException e) 
            {
                this.log(e);
            }
            
            //eliminar dados do ncsync
            this.trigger_query = "DELETE FROM u_ncsync WHERE [table] = '" + this.table + "'";
            
            this.lastSQL = this.trigger_query;
            stmt = null;
            try 
            {
                stmt = this.con.createStatement();
                stmt.executeUpdate(this.lastSQL);
            }
            catch (SQLException e) 
            {
                this.log(e);
            }
            
            //forcar importacao no ncsync
            this.trigger_query = 
            "	INSERT INTO u_ncsync ([u_ncsyncstamp], [stamp], [table], [type], [done], [ousrdata], [ousrhora]) \n" +
            "	SELECT \n" +
            "	CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))), \n" +
            "	" + this.table + "stamp, \n" +
            "	'" + this.table + "', \n" +
            "	'INSERT', \n" +
            "	0, \n" +
            "	CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', \n" +
            "	CONVERT(VARCHAR(8), GETDATE(), 8)\n" +
            "	FROM " + this.table + "\n";
            
            this.lastSQL = this.trigger_query;
            
            stmt = null;
            try 
            {
                stmt = this.con.createStatement();
                stmt.executeUpdate(this.lastSQL);
            }
            catch (SQLException e) 
            {
                this.log(e);
            }
            
            //criar ficheiro
            try{
                PrintWriter writer = new PrintWriter("query_" + this.table + ".txt", "UTF-8");
                writer.println(this.createTable);
                writer.close();
            } catch (IOException e) {
               // do something
            }
            System.out.println("Fim");
            showMessageDialog(null, "Triggers instalados e ficheiro com query de importação no MySQL criado.");
        }
        catch (SQLException e) 
        {
            this.log(e);
        }
    }
    
    private void log(SQLException e) 
    {     
        System.out.println(this.lastSQL);
        System.out.println(e.toString());
    }

}
