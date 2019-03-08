package main_application;

import java.io.UnsupportedEncodingException;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

/**
 *
 * @author Tiago Loureiro
 */
public class Familia extends Db {

    public String ref;
    public String name;
    public String design2;
    public String famipai;
    public String imgqlook;
    public String u_pubsite;
    public String usrdata;

    public Familia() {
        super();
    }

    public Familia(String hostname, String instanceName, String port, String username, String password, String db) {
        super(hostname, instanceName, port, username, password, db);
    }

    public Familia(Connection con) {
        this.con = con;
    }

    public static String toTitleCase(String input) {
        StringBuilder titleCase = new StringBuilder();
        boolean nextTitleCase = true;
        for (char c : input.toCharArray()) {
            if (Character.isSpaceChar(c)) {
                nextTitleCase = true;
            } else if (nextTitleCase) {
                c = Character.toTitleCase(c);
                nextTitleCase = false;
            }
            titleCase.append(c);
        }
        return titleCase.toString();
    }

    public ArrayList<Familia> list(Date data) throws ParseException, UnsupportedEncodingException {

        DateFormat full = new SimpleDateFormat("yyyy-MM-dd");

        this.lastSQL
                = "SELECT "
                + "ref, "
                + "REPLACE(nome, char(34), '') name, "
                + "REPLACE(U_DESIGN2, char(34), '') design2, "
                + "REPLACE(u_famipai, char(254), '') famipai, "
                + "REPLACE(imgqlook, char(34), '') imgqlook, "
                + "u_pubsite, "
                + "usrdata "
                + "FROM stfami "
                + "WHERE usrdata >='" + full.format(data) + "' "
                + "ORDER BY stfami.ref";

        ArrayList<Familia> familias = new ArrayList<Familia>();
        Familia familia = null;
        ResultSet rs = null;
        Statement stmt = null;
        String[] tmp_array;

        System.out.println("QUERY: " + this.lastSQL);

        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);

            while (rs.next()) {
                familia = new Familia(this.con);
                familia.ref = this.toBase64(rs.getString("ref").replace("\\", "").replace("\"", "").replace("\'", "").trim());
                familia.name = this.toBase64(toTitleCase(rs.getString("name").replace("\\", "").replace("\"", "").replace("\'", "").trim().toLowerCase()));
                familia.design2 = this.toBase64(toTitleCase(rs.getString("design2").replace("\\", "").replace("\"", "").replace("\'", "").trim().toLowerCase()));
                familia.famipai = this.toBase64(rs.getString("famipai").replace("\\", "").replace("\"", "").replace("\'", "").trim());
                familia.u_pubsite = rs.getString("u_pubsite");
                familia.usrdata = rs.getString("usrdata");

                tmp_array = rs.getString("imgqlook").split("\\\\");
                familia.imgqlook = this.toBase64(tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim());

                familias.add(familia);
            }

            return familias;

        } catch (SQLException e) {
            this.log(e);
            return null;
        }
    }

    public ArrayList<Familia> list_rel(Date data) throws ParseException {

        DateFormat full = new SimpleDateFormat("yyyy-MM-dd");

        this.lastSQL
                = "SELECT "
                + "ref, "
                + "REPLACE(u_famipai, char(254), '') famipai, "
                + "usrdata "
                + "FROM stfami "
                + "WHERE usrdata >='" + full.format(data) + "' "
                + "ORDER BY stfami.ref";

        ArrayList<Familia> familias = new ArrayList<Familia>();
        Familia familia = null;
        ResultSet rs = null;
        Statement stmt = null;

        System.out.println("QUERY: " + this.lastSQL);

        try {
            stmt = this.con.createStatement();
            rs = stmt.executeQuery(this.lastSQL);

            while (rs.next()) {
                familia = new Familia(this.con);
                familia.ref = rs.getString("ref").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                familia.famipai = rs.getString("famipai").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                familia.usrdata = rs.getString("usrdata");

                familias.add(familia);
            }

            return familias;

        } catch (SQLException e) {
            this.log(e);
            return null;
        }
    }

    private void log(SQLException e) {
        System.out.println(this.lastSQL);
        System.out.println(e.toString());
    }

}
