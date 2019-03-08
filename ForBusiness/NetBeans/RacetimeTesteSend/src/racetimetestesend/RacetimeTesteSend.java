/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package racetimetestesend;

import flexjson.JSONSerializer;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author tml
 */
public class RacetimeTesteSend {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        String data = null;
        String responseText = null;
        ArrayList<Integer> cool_ids = new ArrayList<Integer>();
        JSONSerializer serializer = new JSONSerializer();

        try {

            for (int i = 1; i < 11; i++) {
                cool_ids.add(i);
            }

            data = URLEncoder.encode(serializer.serialize(cool_ids), "UTF-8");
            System.out.println(data);

        } catch (Exception e) {
            System.out.println(e.toString());
            return;
        }
    }

}
