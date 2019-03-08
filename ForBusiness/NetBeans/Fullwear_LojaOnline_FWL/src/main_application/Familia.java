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

/**
 *
 * @author Tiago Loureiro
 */
public class Familia extends Db {

    public String ref;
    public String name;
    public String famipai;
    public String imagem;

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

    public ArrayList<Familia> list() throws ParseException {
        this.lastSQL = "select distinct "
                + "	A.trab1 u_codproj,  "
                + "	A.trab3 u_descproj, "
                + "	CASE isnull((select top 1 bo2.u_imgloja from bo inner join bo2 on bo.bostamp = bo2.bo2stamp where obrano = A.trab1 and bo.ndos = 7), 'X:\\\\\\\\logotipo.png') WHEN '' THEN 'X:\\\\\\\\logotipo.png' ELSE isnull((select top 1 bo2.u_imgloja from bo inner join bo2 on bo.bostamp = bo2.bo2stamp where obrano = A.trab1 and bo.ndos = 7), 'X:\\\\\\\\logotipo.png') END imagem  "
                + "from st  "
                + "	inner join bi on st.ref = bi.ref "
                + "	inner join bo A on bi.bostamp = A.bostamp "
                + "where  "
                + "	A.ndos = 7 and st.usr2 <> '' and st.usr5 <> '' and st.usr3 <> '' and st.ref like 'FL-%' and st.u_publ = 1";

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
                //projecto
                familia = new Familia(this.con);
                familia.ref = rs.getString("u_codproj").replace("\\", "").replace("\"", "").replace("\'", "").trim();
                familia.name = toTitleCase(rs.getString("u_descproj").replace("\\", "").replace("\"", "").replace("\'", "").trim().toLowerCase());
                familia.famipai = "";

                tmp_array = rs.getString("imagem").split("\\\\");
                familia.imagem = tmp_array[tmp_array.length - 1].replace("\\", "").replace("\"", "").replace("\'", "").trim();
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
