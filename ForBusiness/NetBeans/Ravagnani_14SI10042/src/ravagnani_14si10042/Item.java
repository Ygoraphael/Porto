/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package ravagnani_14si10042;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

/**
 *
 * @author Tiago Loureiro
 */
public class Item extends Db{
    
    private int getRowCount(ResultSet resultSet) {
        if (resultSet == null) {
            return 0;
        }
        try {
            resultSet.last();
            return resultSet.getRow();
        } catch (SQLException exp) {
            exp.printStackTrace();
        } finally {
            try {
                resultSet.beforeFirst();
            } catch (SQLException exp) {
                exp.printStackTrace();
            }
        }
        return 0;
    }
    
    public void change() {
        Statement stmt = null;
        ResultSet rs = null;
        
        Statement stmt2 = null;
        
        String tmp = "";
        
        this.lastSQL = "SELECT A.ItemID, B.Description, A.LabelIngredients "
                + "FROM (( Item A inner join ItemNames B on A.ItemID = B.ItemID) "
                + "inner join ItemSellingPrices C on A.ItemID = C.ItemID) "
                + "WHERE C.PriceLineID = 3 "
                + "ORDER BY A.ItemID";
        
        try {
            stmt = this.con.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE, ResultSet.CONCUR_READ_ONLY);
            stmt2 = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);
            String description = "";
            String ingredients = "";
            String item_id = "";
            int num = 1;
            
            int num_total = getRowCount(rs);
            
            while ( rs.next() )
            {
                item_id = rs.getString("ItemID");
                description = rs.getString("Description");
                ingredients = rs.getString("LabelIngredients");
                
                if( description.length() >= 2 )
                {
                    tmp = description.trim();
                    
                    if ( tmp.substring(tmp.length()-1, tmp.length()).equals("_") ) {
                        
                        tmp = description.trim().substring(0, tmp.length()-1);
                        
                        this.lastSQL = "UPDATE Item set LabelIngredients = '"+ ingredients + "_' WHERE ItemID = '"+item_id+"'";
                        stmt2.executeUpdate(this.lastSQL);
                        
                        this.lastSQL = "UPDATE ItemNames set Description = '"+tmp+"' WHERE ItemID = '"+item_id+"'";
                        stmt2.executeUpdate(this.lastSQL);
                    }
//                    tmp = description.substring(0, 7);
//                    if( tmp.substring(0, 1).equals("#") && tmp.substring(6, 7).equals("#") )
//                    {                        
//                        if (description.substring(description.length() - 1, description.length()).equals("_")) {
//                            this.lastSQL = "UPDATE ItemNames set Description = '"+description.substring(7, description.length()-1)+"' WHERE ItemID = '"+item_id+"'";
//                            stmt2.executeUpdate(this.lastSQL);
//                            
//                            this.lastSQL = "UPDATE Item set LabelIngredients = '"+description.substring(0, 7)+"_' WHERE ItemID = '"+item_id+"'";
//                            stmt2.executeUpdate(this.lastSQL);
//                        }
//                        else {
//                            this.lastSQL = "UPDATE ItemNames set Description = '"+description.substring(7, description.length())+"' WHERE ItemID = '"+item_id+"'";
//                            stmt2.executeUpdate(this.lastSQL);
//                            
//                            this.lastSQL = "UPDATE Item set LabelIngredients = '"+description.substring(0, 7)+"' WHERE ItemID = '"+item_id+"'";
//                            stmt2.executeUpdate(this.lastSQL);
//                        }
//                    }
                }
                System.out.println("Atualizados " + num + " de " + num_total + " artigos");
                num++;
            }
            
        } catch (SQLException e) {
            System.out.println( "1. " + e );
        }
    }
}
