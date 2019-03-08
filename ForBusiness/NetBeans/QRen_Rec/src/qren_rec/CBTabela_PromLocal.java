package fme;

import java.util.Vector;
import javax.swing.JComboBox;
import javax.swing.JOptionPane;
import javax.swing.JScrollPane;
import javax.swing.JTable;









































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class CBTabela_PromLocal
  extends CBTabela
{
  Frame_IdProm_1 P01;
  
  public String getPagina()
  {
    return "IdProm_1";
  }
  

  int tab_index = 0;
  JComboBox cbo_freguesias;
  
  CBTabela_PromLocal()
  {
    P01 = ((Frame_IdProm_1)fmeApp.Paginas.getPage("IdProm_1"));
    if (P01 == null) return;
    initialize();
  }
  
  CBTabela_PromLocal(Frame_IdProm_1 p, int idx) {
    P01 = p;
    tab_index = idx;
    initialize();
  }
  
  void initialize() {
    P01.cbd_promlocal = this;
    tag = "PromLocal";
    started = true;
    
    cols = new CHTabColModel[12];
    cols[0] = new CHTabColModel("n_estab", "Nº", true, false, true, null);
    cols[1] = new CHTabColModel("estab", "Designação", true, true, true, null);
    cols[2] = new CHTabColModel("cae", "CAE", true, true, true, null);
    cols[3] = new CHTabColModel("pais", "País (id)", true, true, false, null);
    cols[4] = new CHTabColModel("pais_d", "País", false, true, true, null);
    cols[5] = new CHTabColModel("concelho", "Concelho (id)", true, true, false, null);
    cols[6] = new CHTabColModel("concelho_d", "Concelho", false, true, true, null);
    cols[7] = new CHTabColModel("freguesia", "Freguesia (id)", true, true, false, null);
    cols[8] = new CHTabColModel("freguesia_d", "Freguesia", false, true, true, null);
    cols[9] = new CHTabColModel("morada", "Morada<br>(Rua, Nº/Lote, Cód. Postal e Localidade)", true, true, true, null);
    cols[10] = new CHTabColModel("nuts_ii", "NUTS II (id)", false, true, false, null);
    cols[11] = new CHTabColModel("nuts_ii_d", "NUTS II", false, false, true, null);
    
    init_dados(5);
    

    init_handler(P01.getJTable_PromLocal());
    P01.getJTable_PromLocal().addKeyListener(new TableKeyListener(this));
    handler.width = (P01.getJScrollPane_PromLocal().getWidth() - 20);
    
    P01.getJTable_PromLocal().setName(P01.getJTable_PromLocal().getName() + "_" + tab_index);
    
    handler.set_col_text(0, 0.05D, "C");
    handler.set_col_text(1, 0.235D, null);
    handler.set_col_comboD(2, 0.07D, null, CTabelas.Cae, 0, 450);
    handler.set_col_comboS(4, 0.15D, null, CTabelas.Pais, 1, 200);
    handler.set_col_comboS(6, 0.2D, null, CTabelas.Concelhos, 1, 200);
    cbo_freguesias = handler.set_col_comboF(8, 0.2D, null, null, 1, 300);
    handler.set_col_text(9, 0.35D, null);
    handler.set_col_text(11, 0.1D, null);
  }
  
  void _filter_populate_freguesias(SteppedComboBox cbo_freguesias, int row)
  {
    String concelho = P01.cbd_promlocal.getColValue("concelho", row);
    String freguesia = P01.cbd_promlocal.getColValue("freguesia", row);
    
    if (concelho.length() == 0) {
      cbo_freguesias.removeAllItems();
    } else {
      CTabelas.FreguesiasF1.set_filter(2, concelho);
      CTabelas.FreguesiasF1._populateComboBox(cbo_freguesias);
    }
    if (freguesia.length() > 0) {
      int n = CTabelas.FreguesiasF1.getIndexFromCode(freguesia);
      if (n >= 0) cbo_freguesias.setSelectedIndex(n + 1);
    }
  }
  
  boolean del_ins_ok(String option) {
    handler.__garbage_stop_editing();
    int n = handler.j.getSelectedRow();
    int m = handler.j.getRowCount();
    boolean estab_ok = false;
    
    String msg = "";
    if ((n < m) && (n != -1)) {
      String estab = getColValue("n_estab", n);
      
      if (estab.length() > 0) {
        int e = Integer.parseInt(estab);
        
        for (int i = 0; i < QuadrosTecndados.size(); i++) {
          String estab_qi = CBData.QuadrosTecn.getColValue("estab", i);
          if ((estab_qi.length() > 0) && 
            (e <= Integer.parseInt(estab_qi))) {
            estab_ok = true;
            msg = "Já existem Quadros Técnicos definidos para Estabelecimento Nº " + estab + 
              " e/ou superior.\n" + 
              "Impossível " + option + " Linha!";
            break;
          }
        }
        

        if (estab_ok) {
          JOptionPane.showMessageDialog(null, msg, option + " Linha", 
            0, null);
          return false;
        }
        
        estab_ok = false;
        for (int i = 0; i < QInvdados.size(); i++) {
          String estab_qi = CBData.QInv.getColValue("estab", i);
          if ((estab_qi.length() > 0) && 
            (e <= Integer.parseInt(estab_qi))) {
            estab_ok = true;
            msg = "Já existem linhas no Quadro de Investimentos com o Estabelecimento Nº " + estab + 
              " e/ou superior.\n" + 
              "Impossível " + option + " Linha!";
            break;
          }
        }
        
        if (estab_ok) {
          JOptionPane.showMessageDialog(null, msg, option + " Linha", 
            0, null);
          return false;
        }
      }
    }
    




















    return true;
  }
  
  void on_update(String colname, int nRow, String v) {
    if (colname.equals("freguesia_d")) {
      String freguesia = "";
      String concelho_old = getColValue("concelho_d", nRow);
      if (v.length() > 0) {
        freguesia = CTabelas.FreguesiasF1.lookup(1, v, 0);
        String concelho_d = CTabelas.Concelhos.lookup(0, freguesia.substring(0, 4), 1);
        if (!concelho_old.equals(concelho_d))
          setColValue("concelho_d", nRow, "");
      }
      setColValue("freguesia", nRow, freguesia);
    }
    if (colname.equals("freguesia")) {
      String freguesia_d = "";
      if (v.length() > 0) freguesia_d = CTabelas.Freguesias.lookup(0, v, 1);
      setColValue("freguesia_d", nRow, freguesia_d);
    }
    
    if (colname.equals("concelho_d")) {
      String concelho = "";
      String concelho_old = "";
      if (getColValue("freguesia", nRow).length() > 0)
        concelho_old = getColValue("freguesia", nRow).substring(0, 4);
      if (v.length() == 0) {
        on_update("freguesia_d", nRow, "");
        setColValue("freguesia_d", nRow, "");
      }
      else {
        concelho = CTabelas.Concelhos.lookup(1, v, 0);
        if (!concelho_old.equals(concelho)) {
          on_update("freguesia_d", nRow, "");
          setColValue("freguesia_d", nRow, "");
        }
      }
      if (v.length() > 0) {
        concelho = CTabelas.Concelhos.lookup(1, v, 0);
        int idx = CTabelas.Concelhos.getIndexFromCode(concelho) + 1;
        String nuts = CTabelas.Concelhos.getColFromIndex(idx, 2).substring(0, 2);
        if ((nuts.length() > 0) && (!nuts.equals("99"))) {
          setColValue("nuts_ii", nRow, nuts);
          setColValue("nuts_ii_d", nRow, CTabelas.NUTS_II.getDesign(nuts));
        } else {
          setColValue("nuts_ii", nRow, "");
          setColValue("nuts_ii_d", nRow, "");
        }
      }
      else {
        setColValue("nuts_ii", nRow, "");
        setColValue("nuts_ii_d", nRow, "");
      }
      
      setColValue("concelho", nRow, concelho);
      if (v.length() > 0) {
        if (!v.equals("Estrangeiro")) {
          setColValue("pais", nRow, "PT");
          setColValue("pais_d", nRow, "Portugal");
        }
        else if (getColValue("pais_d", nRow).equals("Portugal")) {
          setColValue("pais", nRow, "");
          setColValue("pais_d", nRow, "");
        }
      }
      
      String estab = getColValue("n_estab", nRow);
      if (estab.length() > 0) {
        for (int i = 0; i < QInvdados.size(); i++) {
          int c_estab = CBData.QInv.getColIndex("estab");
          if (((String[])QInvdados.elementAt(i))[c_estab].equals(estab)) {
            int c_concelho = CBData.QInv.getColIndex("concelho");
            ((String[])QInvdados.elementAt(i))[c_concelho] = concelho;
            CBData.QInv.on_update("concelho", i, concelho);
          }
        }
      }
    }
    









    if (colname.equals("concelho")) {
      String concelho_d = "";
      if (v.length() > 0)
        concelho_d = CTabelas.Concelhos.lookup(0, v, 1);
      setColValue("concelho_d", nRow, concelho_d);
      on_update("concelho_d", nRow, concelho_d);
    }
    
    if (colname.equals("pais_d")) {
      String pais = "";
      if (v.length() > 0) {
        pais = CTabelas.Pais.lookup(1, v, 0);
      }
      setColValue("pais", nRow, pais);
      if ((v.length() > 0) && (!v.equals("Portugal"))) {
        setColValue("concelho", nRow, "9999");
        setColValue("concelho_d", nRow, "Estrangeiro");
        setColValue("freguesia", nRow, "999999");
        setColValue("freguesia_d", nRow, "Estrangeiro");
        setColValue("nuts_ii", nRow, "");
        setColValue("nuts_ii_d", nRow, "");
      }
      else if (getColValue("concelho_d", nRow).equals("Estrangeiro")) {
        setColValue("concelho", nRow, "");
        setColValue("concelho_d", nRow, "");
        setColValue("freguesia", nRow, "");
        setColValue("freguesia_d", nRow, "");
        setColValue("nuts_ii", nRow, "");
        setColValue("nuts_ii_d", nRow, "");
      }
    }
    
    if (colname.equals("pais")) {
      String pais_d = "";
      if (v.length() > 0) {
        pais_d = CTabelas.Pais.lookup(0, v, 1);
      }
      setColValue("pais_d", nRow, pais_d);
    }
    
    if (colname.equals("nuts_ii")) {
      String nuts_d = "";
      if (v.length() > 0) {
        nuts_d = CTabelas.NUTS_II.lookup(0, v, 1);
      }
      setColValue("nuts_ii_d", nRow, nuts_d);
    }
    if (colname.equals("nuts_ii_d")) {
      String nuts = "";
      if (v.length() > 0) {
        nuts = CTabelas.NUTS_II.lookup(1, v, 0);
      }
      setColValue("nuts_ii", nRow, nuts);
    }
    numerar(0);
    
    CTabelas.Estabs.refresh();
    handler.j.repaint();
  }
  
  boolean existe_estab(String estab) {
    for (int i = 0; i < dados.size(); i++) {
      String e = getColValue("n_estab", i);
      if ((e.length() > 0) && (e.equals(estab)))
        return true;
    }
    return false;
  }
  
  CHValid_Grp validar(CHValid_Grp err_list, String cp) {
    String titulo = "Localização dos Estabelecimentos do Beneficiário";
    if (cp.length() > 0) titulo = titulo + cp;
    if (err_list == null) {
      err_list = new CHValid_Grp(this, titulo);
    }
    
    if ((isEmpty()) && (tab_index == 0)) {
      err_list.add_msg(new CHValid_Msg("local", "Lista vazia"));
    }
    for (int i = 0; i < dados.size(); i++) {
      String mask = "-RR-R-R-RR---";
      TabError[] e = isIncompletAll(i, mask.toString());
      for (int ii = 0; (e != null) && (ii < e.length); ii++)
        err_list.add_msg(new CHValid_Msg("incomplet", e[ii].msg("Linha %L incompleta: %T - %o")));
    }
    return err_list;
  }
  
  String on_xml(String tag, int row, String v) {
    String s = "";
    if (tag.equals("concelho")) {
      s = s + _lib.xml_encode("concelho_d", getColValue("concelho_d", row));
      s = s + _lib.xml_encode("nuts_ii", getColValue("nuts_ii", row));
      s = s + _lib.xml_encode("nuts_ii_d", getColValue("nuts_ii_d", row));
    }
    if (tag.equals("freguesia"))
      s = s + _lib.xml_encode("freguesia_d", getColValue("freguesia_d", row));
    if (tag.equals("pais"))
      s = s + _lib.xml_encode("pais_d", getColValue("pais_d", row));
    return s;
  }
}
