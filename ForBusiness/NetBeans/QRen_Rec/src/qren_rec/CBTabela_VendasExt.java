package fme;

import java.util.HashMap;
import java.util.Vector;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.table.JTableHeader;




















































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class CBTabela_VendasExt
  extends CBTabela
{
  Frame_VendasExt P12;
  
  public String getPagina()
  {
    return "VendasExt";
  }
  

  int tab_index = 0;
  int n_anos = CParseConfig.hconfig.get("extensao").equals("i20") ? 3 : 1;
  
  CBTabela_VendasExt() {
    tag = "VendasExt";
    P12 = ((Frame_VendasExt)fmeApp.Paginas.getPage("VendasExt"));
    if (P12 == null) return;
    initialize();
  }
  
  CBTabela_VendasExt(Frame_VendasExt p, int idx) {
    tag = "VendasExt";
    tab_index = idx;
    P12 = p;
    initialize();
  }
  




  void initialize()
  {
    P12.cbd_vendas_ext = this;
    started = true;
    
    cols = new CHTabColModel[8];
    cols[0] = new CHTabColModel("nif", "NIF", true, true, true, CFLib.VLD_NIF);
    cols[1] = new CHTabColModel("design", "Designação do Cliente Exportador", true, true, true, null);
    cols[2] = new CHTabColModel("vendas_pre", "Vendas do Beneficiário ao Cliente (Ano Pré-Proj.)", true, true, true, CFLib.VLD_VALOR_0);
    cols[3] = new CHTabColModel("vol_neg_int_pre", "Volume de Negócios do Cliente Internacional (Ano Pré-Proj.)", true, true, true, CFLib.VLD_VALOR_0);
    cols[4] = new CHTabColModel("vol_neg_tt_pre", "Volume de Negócios do Cliente Total (Ano Pré-Proj.)", true, true, true, CFLib.VLD_VALOR_0);
    cols[5] = new CHTabColModel("vendas_pos", "Vendas do Beneficiário ao Cliente (Ano Pós-Proj.)", true, true, true, CFLib.VLD_VALOR_0);
    cols[6] = new CHTabColModel("vol_neg_int_pos", "Volume de Negócios do Cliente Internacional (Ano Pós-Proj.)", true, true, true, CFLib.VLD_VALOR_0);
    cols[7] = new CHTabColModel("vol_neg_tt_pos", "Volume de Negócios do Cliente Total (Ano Pós-Proj.)", true, true, true, CFLib.VLD_VALOR_0);
    
    init_dados(12);
    

    init_handler(P12.getJTable_VendasExt());
    P12.getJTable_VendasExt().addKeyListener(new TableKeyListener(this));
    handler.width = P12.getJScrollPane_VendasExt().getWidth();
    
    ui = new GroupableTableHeaderUI();
    ui.setH(3, P12.getJTable_VendasExt());
    
    ui.add_col(0, 0, 1, 3, "NIF");
    ui.add_col(1, 0, 1, 3, "Designação do Cliente Exportador");
    ui.add_col(2, 0, 3, 1, "Ano Pré-Proj.");
    ui.add_col(2, 1, 1, 2, "<html><div align='center'>Vendas do<br>Beneficiário<br>ao Cliente</div></html>");
    ui.add_col(3, 1, 2, 1, "<html><div align='center'>Volume de Negócios do Cliente</div></html>");
    ui.add_col(3, 2, 1, 1, "Internacional");
    ui.add_col(4, 2, 1, 1, "Total");
    ui.add_col(5, 0, 3, 1, "Ano Pós-Proj.");
    ui.add_col(5, 1, 1, 2, "<html><div align='center'>Vendas do<br>Beneficiário<br>ao Cliente</div></html>");
    ui.add_col(6, 1, 2, 1, "<html><div align='center'>Volume de Negócios do Cliente</div></html>");
    ui.add_col(6, 2, 1, 1, "Internacional");
    ui.add_col(7, 2, 1, 1, "Total");
    
    P12.getJTable_VendasExt().getTableHeader().setUI(ui);
    
    handler.set_col_text(0, 0.08D, "C");
    handler.set_col_text(1, 0.295D, null);
    handler.set_col_text(2, 0.1D, "R");
    handler.set_col_text(3, 0.1D, "R");
    handler.set_col_text(4, 0.1D, "R");
    handler.set_col_text(5, 0.1D, "R");
    handler.set_col_text(6, 0.1D, "R");
    handler.set_col_text(7, 0.1D, "R");
  }
  
  String on_xml(String tag, int row, String v)
  {
    String s = "";
    return s;
  }
  


















































  CHValid_Grp validar(CHValid_Grp err_list, String cp)
  {
    String titulo = "Vendas ao Exterior Indiretas";
    if (cp.length() > 0) { titulo = titulo + cp;
    }
    if (err_list == null)
      err_list = new CHValid_Grp(this, titulo);
    if (!started) { return err_list;
    }
    


    int ano_cand = (int)CBData.Params.getByName("ano_cand").valueAsDouble();
    int ano_inicial = ano_cand;
    

    String v = PromotorgetByName"dt_inicio_act"v;
    if (v.length() == 10)
      ano_inicial = Integer.parseInt(v.substring(0, 4));
    int idx_i = 2 - (ano_cand - ano_inicial - 1) * 3;
    if (idx_i < 0) { idx_i = 0;
    }
    String nif_promotor = PromotorgetByName"nif"v;
    
    for (int j = 0; j < dados.size(); j++) {
      String mask = "RR------";
      
      TabError[] e = isIncompletAll(j, mask.toString());
      for (int ii = 0; (e != null) && (ii < e.length); ii++) {
        err_list.add_msg(new CHValid_Msg("incomplet", e[ii].msg("Linha %L incompleta: %T - %o")));
      }
      if (!isRowEmpty(j)) {
        for (int i = 2; i <= 7; i++) {
          String ano_s = cols[i].col_name;
          String s = ((String[])dados.elementAt(j))[i];
          String _msg = ano_s;
          _msg = _msg.replaceAll("\n", " ");
          _msg = _msg.replaceAll("<br>", " ");
          _msg = _msg.replaceAll("<html>", "");
          _msg = _msg.replaceAll("</html>", "");
          _msg = _msg.replaceAll("<div align='center'>", "");
          _msg = _msg.replaceAll("</div>", "");
          if (((s.length() == 0) && (i >= idx_i) && (i <= 4)) || ((s.length() == 0) && (i > 4))) {
            _msg = "Linha " + (j + 1) + " incompleta: " + _msg + " - %o";
            err_list.add_msg(new CHValid_Msg("vendas_ext", _msg));
          }
          else if ((i == 4) || (i == 7)) {
            String s_aux = ((String[])dados.elementAt(j))[(i - 1)];
            if (!s_aux.equals("")) {
              double vn_tt = _lib.to_double(s);
              double vn_int = _lib.to_double(s_aux);
              if (vn_int > vn_tt) {
                String _msg_aux = cols[(i - 1)].col_name;
                _msg_aux = _msg_aux.replaceAll("\n", " ");
                _msg_aux = _msg_aux.replaceAll("<br>", " ");
                _msg_aux = _msg_aux.replaceAll("<html>", "");
                _msg_aux = _msg_aux.replaceAll("</html>", "");
                _msg_aux = _msg_aux.replaceAll("<div align='center'>", "");
                _msg_aux = _msg_aux.replaceAll("</div>", "");
                
                _msg = "Linha " + (j + 1) + ": " + _msg + " não pode ser inferior ao " + _msg_aux;
                err_list.add_msg(new CHValid_Msg("vendas_ext", _msg));
              }
            }
          }
        }
      }
      
      if ((!nif_promotor.equals("")) && (nif_promotor.equals(getColValue("nif", j)))) {
        err_list.add_msg(new CHValid_Msg("vendas_ext", "Linha " + (j + 1) + ": NIF do próprio Promotor"));
      }
    }
    if (!isUnique("nif")) {
      err_list.add_msg(new CHValid_Msg("unique", 
        "Não podem existir NIF's repetidos"));
    }
    return err_list;
  }
}