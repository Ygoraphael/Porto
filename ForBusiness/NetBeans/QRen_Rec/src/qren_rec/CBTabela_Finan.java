package fme;

import java.util.HashMap;
import java.util.Vector;
import javax.swing.JScrollPane;
import javax.swing.JTable;


























































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class CBTabela_Finan
  extends CBTabela
{
  public String getPagina()
  {
    return "Financ";
  }
  
  String p3 = "";
  String p2 = "";
  String rubrica = "";
  boolean is_inov = CParseConfig.hconfig.get("extensao").equals("i20");
  


  Frame_Financ P13 = null;
  
  void get_hide() {
    if (P13.hide_cols.length() == 0) return;
    String[] hlist = P13.hide_cols.split(";");
    hide = new int[hlist.length];
    for (int i = 0; i < hlist.length; i++)
      hide[i] = Integer.parseInt(hlist[i]);
  }
  
  int[] hide = null;
  
  int h(int n) {
    if (hide == null) return n;
    int m = n;
    for (int i = 0; i < hide.length; i++) {
      if (hide[i] < n) m--;
    }
    return m;
  }
  
  String hs(int n) {
    if (hide == null) return h(n);
    for (int i = 0; i < hide.length; i++) {
      if (hide[i] == n) return "x";
    }
    return h(n);
  }
  
  CBTabela_Finan() {
    P13 = ((Frame_Financ)fmeApp.Paginas.getPage("Financ"));
    if (P13 == null) return;
    initialize();
  }
  
  CBTabela_Finan(Frame_Financ p) {
    P13 = p;
    initialize();
  }
  
  void initialize() {
    tag = "Financ";
    started = true;
    get_hide();
    



    cols = new CHTabColModel[13];
    cols[0] = new CHTabColModel("rubrica", "Rubricas", true, false, false, null);
    cols[1] = new CHTabColModel("rubrica_d", "Rubricas", false, false, true, null);
    cols[2] = new CHTabColModel("val_p1", "Ano -1", true, true, true, CFLib.VLD_VALOR_S);
    cols[3] = new CHTabColModel("val_0", "Ano 0", true, true, true, CFLib.VLD_VALOR_S);
    cols[4] = new CHTabColModel("val_1", "Ano 1", true, true, true, CFLib.VLD_VALOR_S);
    cols[5] = new CHTabColModel("val_2", "Ano 2", true, true, true, CFLib.VLD_VALOR_S);
    cols[6] = new CHTabColModel("val_3", "Ano 3", true, true, true, CFLib.VLD_VALOR_S);
    cols[7] = new CHTabColModel("val_4", "Ano 4", true, true, true, CFLib.VLD_VALOR_S);
    cols[8] = new CHTabColModel("val_5", "Ano 5", true, true, true, CFLib.VLD_VALOR_S);
    cols[9] = new CHTabColModel("val_6", "Ano 6", true, true, is_inov, CFLib.VLD_VALOR_S);
    cols[10] = new CHTabColModel("val_7", "Ano 7", true, true, false, CFLib.VLD_VALOR_S);
    cols[11] = new CHTabColModel("total", "Total", false, false, true, CFLib.VLD_VALOR_S);
    cols[12] = new CHTabColModel("perc", "%", true, false, false, CFLib.VLD_VALOR_S);
    
    init_dados(h(22));
    

    init_handler(new CHTabQuadro(), P13.getJTable_Financ());
    P13.getJTable_Financ().addKeyListener(new TableKeyListener(this));
    handler.width = (P13.getJScrollPane_Financ().getWidth() - 1);
    
    cols[0].disable_row_calc = true;
    cols[1].disable_row_calc = true;
    cols[12].disable_row_calc = true;
    
    ((CHTabQuadro)handler).start_rows();
    handler).row_editable[h(0)] = false;
    handler).row_editable[h(6)] = false;
    handler).row_editable[h(9)] = false;
    handler).row_editable[h(15)] = false;
    handler).row_editable[h(19)] = false;
    handler).row_editable[h(20)] = false;
    handler).row_editable[h(21)] = false;
    
    keyCol = 0;
    
    ((String[])dados.elementAt(h(0)))[0] = "01";
    ((String[])dados.elementAt(h(1)))[0] = "0101";
    ((String[])dados.elementAt(h(2)))[0] = "0102";
    ((String[])dados.elementAt(h(3)))[0] = "02";
    ((String[])dados.elementAt(h(4)))[0] = "03";
    ((String[])dados.elementAt(h(5)))[0] = "05";
    ((String[])dados.elementAt(h(6)))[0] = "04";
    ((String[])dados.elementAt(h(7)))[0] = "0401";
    ((String[])dados.elementAt(h(8)))[0] = "0402";
    ((String[])dados.elementAt(h(9)))[0] = "0403";
    ((String[])dados.elementAt(h(10)))[0] = "040301";
    ((String[])dados.elementAt(h(11)))[0] = "040302";
    ((String[])dados.elementAt(h(12)))[0] = "0404";
    ((String[])dados.elementAt(h(13)))[0] = "0405";
    ((String[])dados.elementAt(h(14)))[0] = "0406";
    ((String[])dados.elementAt(h(15)))[0] = "0407";
    ((String[])dados.elementAt(h(16)))[0] = "040701";
    ((String[])dados.elementAt(h(17)))[0] = "040702";
    ((String[])dados.elementAt(h(18)))[0] = "0499";
    ((String[])dados.elementAt(h(19)))[0] = "90";
    ((String[])dados.elementAt(h(20)))[0] = "91";
    ((String[])dados.elementAt(h(21)))[0] = "92";
    
    ((String[])dados.elementAt(h(0)))[1] = "Capitais Próprios (1)";
    ((String[])dados.elementAt(h(1)))[1] = "    Capital";
    ((String[])dados.elementAt(h(2)))[1] = "    Prestações Suplementares Capital";
    ((String[])dados.elementAt(h(3)))[1] = "Autofinanciamento (2)";
    ((String[])dados.elementAt(h(4)))[1] = "Outros (3)";
    ((String[])dados.elementAt(h(5)))[1] = "Fundos Próprios de Natureza Pública";
    ((String[])dados.elementAt(h(6)))[1] = "Financiamentos";
    ((String[])dados.elementAt(h(7)))[1] = "    Financiamento de Instituições de Crédito";
    ((String[])dados.elementAt(h(8)))[1] = "    Empréstimos por Obrigações";
    ((String[])dados.elementAt(h(9)))[1] = "    Financiamento de Sócios/Acionistas";
    ((String[])dados.elementAt(h(10)))[1] = "        Suprimentos Consolidados (3)";
    ((String[])dados.elementAt(h(11)))[1] = "        Outras dívidas a Sócios/Acionistas";
    ((String[])dados.elementAt(h(12)))[1] = "    Fornecedores de Investimentos";
    ((String[])dados.elementAt(h(13)))[1] = "    Locação Financeira";
    ((String[])dados.elementAt(h(14)))[1] = "    Financiamento das empresas";
    ((String[])dados.elementAt(h(15)))[1] = "    Incentivo";
    ((String[])dados.elementAt(h(16)))[1] = "        Não Reembolsável (INR)";
    ((String[])dados.elementAt(h(17)))[1] = "        Reembolsável (IR)";
    ((String[])dados.elementAt(h(18)))[1] = "    Outros";
    ((String[])dados.elementAt(h(19)))[1] = "FINANCIAMENTO TOTAL";
    ((String[])dados.elementAt(h(20)))[1] = "INVESTIMENTO TOTAL";
    ((String[])dados.elementAt(h(21)))[1] = "INVESTIMENTO ELEGÍVEL TOTAL";
    
    handler.set_col_text(1, 0.35D, null);
    handler.set_col_text(2, 0.15D, "R");
    handler.set_col_text(3, 0.15D, "R");
    handler.set_col_text(4, 0.15D, "R");
    handler.set_col_text(5, 0.15D, "R");
    handler.set_col_text(6, 0.15D, "R");
    handler.set_col_text(7, 0.15D, "R");
    handler.set_col_text(8, 0.15D, "R");
    if (is_inov) {
      handler.set_col_text(9, 0.15D, "R");
    }
    
    handler.set_col_text(11, 0.15D, "R");
    


    handler).row_autocalc[h(0)] = ("$soma(+" + hs(1) + ",+" + hs(2) + ")");
    handler).row_autocalc[h(6)] = ("$soma(+" + hs(7) + ",+" + hs(8) + ",+" + hs(10) + ",+" + hs(11) + ",+" + hs(12) + ",+" + hs(13) + ",+" + hs(14) + ",+" + hs(16) + ",+" + hs(17) + ",+" + hs(18) + ")");
    handler).row_autocalc[h(9)] = ("$soma(+" + hs(10) + ",+" + hs(11) + ")");
    handler).row_autocalc[h(15)] = ("$soma(+" + hs(16) + ",+" + hs(17) + ")");
    handler).row_autocalc[h(19)] = ("$soma(+" + hs(1) + ",+" + hs(2) + ",+" + hs(3) + ",+" + hs(4) + ",+" + hs(5) + ",+" + hs(7) + ",+" + hs(8) + ",+" + hs(10) + ",+" + hs(11) + ",+" + hs(12) + ",+" + hs(13) + ",+" + hs(14) + ",+" + hs(16) + ",+" + hs(17) + ",+" + hs(18) + ")");
    

    CBData.Params.bind_ano_cand_update(this);
  }
  
  public void on_external_update(String tag)
  {
    if (!started) return;
    if (tag.equals("ano_cand")) {
      int ano = (int)CBData.Params.getByName("ano_cand").valueAsDouble();
      cols[2].col_name = Integer.toString(ano - 1);
      cols[3].col_name = Integer.toString(ano);
      cols[4].col_name = Integer.toString(ano + 1);
      cols[5].col_name = Integer.toString(ano + 2);
      cols[6].col_name = Integer.toString(ano + 3);
      cols[7].col_name = Integer.toString(ano + 4);
      cols[8].col_name = Integer.toString(ano + 5);
      cols[9].col_name = Integer.toString(ano + 6);
      
      handler.repaint_col_names();
    }
  }
  








  void on_update(String colname, int nRow, String v)
  {
    if (colname.startsWith("val_")) {
      double total = 0.0D;
      double v_1 = _lib.to_double(((String[])dados.elementAt(nRow))[2]);
      double v0 = _lib.to_double(((String[])dados.elementAt(nRow))[3]);
      double v1 = _lib.to_double(((String[])dados.elementAt(nRow))[4]);
      double v2 = _lib.to_double(((String[])dados.elementAt(nRow))[5]);
      double v3 = _lib.to_double(((String[])dados.elementAt(nRow))[6]);
      double v4 = _lib.to_double(((String[])dados.elementAt(nRow))[7]);
      double v5 = _lib.to_double(((String[])dados.elementAt(nRow))[8]);
      double v6 = _lib.to_double(((String[])dados.elementAt(nRow))[9]);
      double v7 = _lib.to_double(((String[])dados.elementAt(nRow))[10]);
      total = _lib.round(v_1 + v0 + v1 + v2 + v3 + v4 + v5 + v6 + v7);
      ((String[])dados.elementAt(nRow))[getColIndex("total")] = Double.toString(total);
      
      autocalc();
      handler.j.repaint();
      
      double financiamento = _lib.to_double(((String[])dados.elementAt(h(19)))[2]) + 
        _lib.to_double(((String[])dados.elementAt(h(19)))[3]) + 
        _lib.to_double(((String[])dados.elementAt(h(19)))[4]) + 
        _lib.to_double(((String[])dados.elementAt(h(19)))[5]) + 
        _lib.to_double(((String[])dados.elementAt(h(19)))[6]) + 
        _lib.to_double(((String[])dados.elementAt(h(19)))[7]) + 
        _lib.to_double(((String[])dados.elementAt(h(19)))[8]) + 
        _lib.to_double(((String[])dados.elementAt(h(19)))[9]) + 
        _lib.to_double(((String[])dados.elementAt(h(19)))[10]);
      ((String[])dados.elementAt(h(19)))[getColIndex("total")] = Double.toString(financiamento);
      
      for (int i = 0; i < dados.size() - 2; i++) {
        double perc = 0.0D;
        total = 0.0D;
        v_1 = _lib.to_double(((String[])dados.elementAt(i))[2]);
        v0 = _lib.to_double(((String[])dados.elementAt(i))[3]);
        v1 = _lib.to_double(((String[])dados.elementAt(i))[4]);
        v2 = _lib.to_double(((String[])dados.elementAt(i))[5]);
        v3 = _lib.to_double(((String[])dados.elementAt(i))[6]);
        v4 = _lib.to_double(((String[])dados.elementAt(i))[7]);
        v5 = _lib.to_double(((String[])dados.elementAt(i))[8]);
        v6 = _lib.to_double(((String[])dados.elementAt(i))[9]);
        v7 = _lib.to_double(((String[])dados.elementAt(i))[10]);
        total = _lib.round(v_1 + v0 + v1 + v2 + v3 + v4 + v5 + v6 + v7);
        if (_lib.round(financiamento) > 0.0D) {
          perc = _lib.round(total / financiamento * 100.0D);
          ((String[])dados.elementAt(i))[getColIndex("perc")] = Double.toString(perc);
        } else {
          ((String[])dados.elementAt(i))[getColIndex("perc")] = "";
        }
      }
    }
    autocalc();
    handler.j.repaint();
  }
  
  String on_xml(String tag, int row, String v) {
    String s = "";
    if (tag.equals("rubrica"))
      s = s + _lib.xml_encode("rubrica_d", ((String[])dados.elementAt(row))[1]);
    return s;
  }
  
  CHValid_Grp validar(CHValid_Grp err_list) {
    if (err_list == null) {
      err_list = new CHValid_Grp(this, "Estrutura de Financiamento (Recursos Financeiros)");
    }
    double fin_total = _lib.round(_lib.to_double(getColValue("total", h(19))));
    double inv_total = _lib.round(_lib.to_double(getColValue("total", h(20))));
    if (fin_total == 0.0D)
      err_list.add_msg(new CHValid_Msg("finan", "%o"));
    if (inv_total > fin_total) {
      err_list.add_msg(new CHValid_Msg("finan", 'W', "O Financiamento Total é inferior ao Investimento Total"));
    }
    for (int j = 2; j <= 10; j++) {
      double inv = _lib.round(_lib.to_double(((String[])dados.elementAt(h(20)))[j]));
      double fin = _lib.round(_lib.to_double(((String[])dados.elementAt(h(19)))[j]));
      if (inv > fin) {
        err_list.add_msg(new CHValid_Msg("finan", 'W', 
          "Financiamento inferior ao Investimento Total (" + cols[j].col_name + ")"));
      }
    }
    

    if (!CBData.Promotor.getByName("dt_inicio_act").isEmpty()) {
      int ano_c = _lib.to_int(ParamsgetByName"ano_cand"v);
      int ano_i = _lib.to_int(PromotorgetByName"dt_inicio_act"v.substring(0, 4));
      
      if (ano_i <= ano_c - 1) {
        double meios_lib = CBData.DR_SNC.calc_meios_lib("val_p1");
        for (int c = 2; c <= 10; c++) {
          double autofin = _lib.round(_lib.to_double(((String[])dados.elementAt(h(3)))[c]));
          if ((autofin > 0.0D) && (autofin > meios_lib)) {
            err_list.add_msg(new CHValid_Msg("finan", 'W', 
              "Autofinanciamento " + cols[c].col_name + " (" + _lib.to_format(autofin) + ") superior aos Meios Libertos (" + _lib.to_format(meios_lib) + ")"));
          }
        }
      }
    }
    return err_list;
  }
}