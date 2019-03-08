package fme;

import java.util.Date;
import java.util.HashMap;
import java.util.Vector;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JTextArea;
import javax.swing.JTextField;




































































































































































































































































































































































































































































































































































































































































































































































































































class CBRegisto_Params
  extends CBRegisto
{
  Frame_Params P;
  
  public String getPagina()
  {
    return "Params";
  }
  

  int limite = 300;
  
  CBRegisto_Params()
  {
    tag = "Parametros";
    
    P = ((Frame_Params)fmeApp.Paginas.getPage("Params"));
    if (P == null) return;
    started = true;
    
    Campos.add(new CHCampo_Text("ano_cand", P.getJTextField_AnoCand(), CFLib.VLD_ANO_CAND, this));
    
    Campos.add(new CHCampo_Text("aut_gestao", P.jTextField_ProgOperacional, null, this));
    Campos.add(new CHCampo_Text("aut_gestao_d", P.jTextField_ProgOperacionalD, null, this));
    Campos.add(new CHCampo_Text("obj_tema", P.jTextField_ObjTematico, null, this));
    Campos.add(new CHCampo_Text("obj_tema_d", P.jTextField_ObjTematicoD, null, this));
    Campos.add(new CHCampo_Text("prioridade", P.jTextField_Prioridade, null, this));
    Campos.add(new CHCampo_Text("prioridade_d", P.jTextField_PrioridadeD, null, this));
    Campos.add(new CHCampo_Text("tipologia", P.jTextField_Tipologia, null, this));
    Campos.add(new CHCampo_Text("tipologia_d", P.jTextField_TipologiaD, null, this));
    
    Campos.add(new CHCampo_Text("norte", P.getJTextField_Norte(), CFLib.VLD_PERC_0, this));
    Campos.add(new CHCampo_Text("centro", P.getJTextField_Centro(), CFLib.VLD_PERC_0, this));
    Campos.add(new CHCampo_Text("lisboa", P.getJTextField_Lisboa(), CFLib.VLD_PERC_0, this));
    Campos.add(new CHCampo_Text("alentejo", P.getJTextField_Alentejo(), CFLib.VLD_PERC_0, this));
    Campos.add(new CHCampo_Text("algarve", P.getJTextField_Algarve(), CFLib.VLD_PERC_0, this));
    
    Campos.add(new CHCampo_TextArea("txt_resumo", P.getJTextArea_Resumo(), null));
    
    if (CParseConfig.hconfig.get("ano_cand_inicial") != null)
      CFType_AnoCand.ano_inicial = Integer.parseInt(CParseConfig.hconfig.get("ano_cand_inicial").toString());
    if (CParseConfig.hconfig.get("ano_cand_final") != null) {
      CFType_AnoCand.ano_final = Integer.parseInt(CParseConfig.hconfig.get("ano_cand_final").toString());
    }
  }
  
  void Clear() {
    for (int i = 0; i < Campos.size(); i++) {
      if ((!Campos.elementAt(i)).tag.startsWith("aut_gestao")) && 
        (!Campos.elementAt(i)).tag.startsWith("obj_tema")) && 
        (!Campos.elementAt(i)).tag.startsWith("prioridade")) && 
        (!Campos.elementAt(i)).tag.startsWith("tipologia")))
      {
        if ((!Campos.elementAt(i)).tag.equals("norte")) && 
          (!Campos.elementAt(i)).tag.equals("centro")) && 
          (!Campos.elementAt(i)).tag.equals("lisboa")) && 
          (!Campos.elementAt(i)).tag.equals("alentejo")) && 
          (!Campos.elementAt(i)).tag.equals("algarve")))
          ((CHCampo)Campos.elementAt(i)).clear(); }
    }
  }
  
  CHValid_Grp validar(CHValid_Grp err_list) {
    if (err_list == null) {
      err_list = new CHValid_Grp(this, "Enquadramento no Aviso de Abertura");
    }
    extract();
    if (getByName("ano_cand").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("ano_cand", "Ano de Referência - %o"));
    } else {
      int ano = Integer.parseInt(getByName"ano_cand"v);
      if ((ano < CFType_AnoCand.ano_inicial) || (ano > CFType_AnoCand.ano_final)) {
        err_list.add_msg(new CHValid_Msg("ano_cand", "Ano de Candidatura inválido"));
      }
    }
    if (getByName("txt_resumo").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("txt_resumo", "Resumo - %o"));
    } else if (getByName"txt_resumo"v.length() > limite) {
      String erro = "Texto demasiado extenso. Por favor, abrevie até " + limite + " caracteres.";
      err_list.add_msg(new CHValid_Msg("txt_resumo", "Resumo - " + erro));
    }
    



    return err_list;
  }
  
  void init() {
    Date d = new Date();
    int ano = d.getYear() + 1900;
    if (CParseConfig.hconfig.get("ano_cand") != null) {
      getByName("ano_cand").setStringValue(CParseConfig.hconfig.get("ano_cand").toString());
      P.getJTextField_AnoCand().setEditable(false);
      P.getJTextField_AnoCand().setVisible(false);
      P.jLabel_LblAnoCand.setVisible(false);
    } else {
      getByName("ano_cand").setStringValue(ano);
      P.getJTextField_AnoCand().setEditable(true);
      P.getJTextField_AnoCand().setVisible(true);
      P.jLabel_LblAnoCand.setVisible(true);
    }
    

    on_update("ano_cand");
    
    getByName("aut_gestao").setStringValue("");
    getByName("obj_tema").setStringValue("");
    getByName("prioridade").setStringValue("");
    getByName("tipologia").setStringValue("");
    
    CBData.Params.getByName("obj_tema").setStringValue("03");
    if (CParseConfig.hconfig.get("tipologia2") != null) {
      if (CParseConfig.hconfig.get("tipologia2").toString().equals("Q")) {
        getByName("prioridade").setStringValue("0303");
        getByName("tipologia").setStringValue("53");
      } else if (CParseConfig.hconfig.get("tipologia2").toString().equals("I")) {
        getByName("prioridade").setStringValue("0302");
        getByName("tipologia").setStringValue("52");
      }
    }
  }
  
  void after_open() {
    if (CParseConfig.hconfig.get("ano_cand") == null) return;
    String old = getByName"ano_cand"v;
    String actual = CParseConfig.hconfig.get("ano_cand").toString();
    if (old.equals(actual)) return;
    getByName("ano_cand").setStringValue(actual);
    JOptionPane.showMessageDialog(null, "<html>O ficheiro que abriu foi preenchido com um formulário duma Fase anterior.<br>O ano pré-projeto foi alterado para " + (_lib.to_int(actual) - 1) + ",<br>p.f. <strong><u>corrija todos os campos e quadros indexados a este ano</u></strong>.</html>", "Aviso", 2);
  }
  
  void on_update(String tag) {
    if (tag.equals("txt_resumo")) {
      CHCampo chc = getByName(tag);
      if ((chc instanceof CHCampo_TextArea)) {
        JTextArea jta = jcomp;
        int n = jta.getText().length();
        P.jLabel_Count.setText(limite - n + "/" + limite);
      }
    }
    

    if (tag.equals("ano_cand")) {
      for (int i = 0; i < ano_cand_updates.size(); i++) {
        ((CBData_Comum)ano_cand_updates.elementAt(i)).on_external_update(tag);
      }
    }
    
    if (tag.equals("aut_gestao")) {
      String aut_gestao_d = "";
      if (getByNamev.length() > 0)
      {
        String[] POs = getByNamev.split(";");
        int count = POs.length;
        
        for (int i = 0; i < POs.length; i++) {
          if (aut_gestao_d.length() > 0) aut_gestao_d = aut_gestao_d + "; ";
          aut_gestao_d = aut_gestao_d + CTabelas.POs.lookup(0, POs[i], 1);
        }
      }
      P.jLabel_ProgOperacional.setText("<html>" + aut_gestao_d + "</html>");
      getByName("aut_gestao_d").setStringValue(aut_gestao_d);
    }
    if (tag.equals("obj_tema")) {
      String obj_tema_d = "";
      if (getByNamev.length() > 0) {
        obj_tema_d = obj_tema_d + CTabelas.ObjTematico.lookup(0, getByNamev, 1);
        obj_tema_d = obj_tema_d + " - " + CTabelas.ObjTematico.lookup(0, getByNamev, 2);
      }
      P.jLabel_ObjTematico.setText("<html>" + obj_tema_d + "</html>");
      getByName("obj_tema_d").setStringValue(obj_tema_d);
    }
    if (tag.equals("prioridade")) {
      String prioridade_d = "";
      if (getByNamev.length() > 0) {
        prioridade_d = prioridade_d + CTabelas.PrioridadeInvest.lookup(0, getByNamev, 1);
        prioridade_d = prioridade_d + " - " + CTabelas.PrioridadeInvest.lookup(0, getByNamev, 2);
      }
      P.jLabel_Prioridade.setText("<html>" + prioridade_d + "</html>");
      getByName("prioridade_d").setStringValue(prioridade_d);
    }
    if (tag.equals("tipologia")) {
      String tipologia_d = "";
      if (getByNamev.length() > 0) {
        tipologia_d = tipologia_d + CTabelas.TipologiaInterv.lookup(0, getByNamev, 1);
        tipologia_d = tipologia_d + " - " + CTabelas.TipologiaInterv.lookup(0, getByNamev, 2);
      }
      P.jLabel_Tipologia.setText("<html>" + tipologia_d + "</html>");
      getByName("tipologia_d").setStringValue(tipologia_d);
    }
  }
  
  Vector ano_cand_updates = new Vector();
  
  void bind_ano_cand_update(CBData_Comum d) { ano_cand_updates.add(d); }
}
