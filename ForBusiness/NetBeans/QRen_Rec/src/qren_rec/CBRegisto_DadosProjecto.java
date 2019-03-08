package fme;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Vector;
import javax.swing.JCheckBox;
import javax.swing.JLabel;
import javax.swing.JTextArea;








































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class CBRegisto_DadosProjecto
  extends CBRegisto
{
  Frame_Proj_1 P07;
  
  public String getPagina()
  {
    return "Proj_1";
  }
  

  int limite = 1000;
  int limite2 = 1500;
  
  CBRegisto_DadosProjecto() {
    tag = "DadosProjecto";
    
    P07 = ((Frame_Proj_1)fmeApp.Paginas.getPage("Proj_1"));
    if (P07 == null) return;
    started = true;
    
    Campos.add(new CHCampo_Text("designacao", P07.getJTextField_Designacao(), null, this));
    

    Campos.add(new CHCampo_Text("dt_inicio", P07.getJTextField_Inicio(), CFLib.VLD_DATA, this));
    Campos.add(new CHCampo_Text("n_meses", P07.getJTextField_Meses(), CFLib.VLD_VALOR_S, this));
    Campos.add(new CHCampo_Text("dt_fim", P07.getJTextField_Fim(), CFLib.VLD_DATA, this));
    
    Campos.add(new CHCampo_Opt("decl_inicio", "S", this, P07.getJCheckBox_DeclInicio()));
    


    Campos.add(new CHCampo_Text("investimento", P07.getJTextField_Inv(), CFLib.VLD_VALOR, null));
    Campos.add(new CHCampo_Text("elegivel", P07.getJTextField_Eleg(), CFLib.VLD_VALOR, null));
    
    Campos.add(new CHCampo_TextArea("fundamento", P07.getJTextArea_Fundam(), this));
  }
  










  void after_open()
  {
    on_update("dt_inicio");
    on_update("fundamento");
  }
  
  void on_update(String tag)
  {
    if (tag.equals("dt_fim")) {
      for (int i = 0; i < dt_fim_updates.size(); i++) {
        ((CBData_Comum)dt_fim_updates.elementAt(i)).on_external_update(tag);
      }
      CBData.DR_SNC.calc_vol_neg_tt();
    }
    if ((tag.equals("dt_inicio")) || (tag.equals("dt_fim"))) {
      String dt_inicio = getByName"dt_inicio"v;
      String dt_fim = getByName"dt_fim"v;
      
      if ((dt_inicio.length() == 0) || 
        (dt_fim.length() == 0) || 
        (dt_fim.compareTo(dt_inicio) < 0)) {
        getByName("n_meses").setStringValue("");
        return;
      }
      
      int ano_i = Integer.parseInt(dt_inicio.substring(0, 4));
      int ano_f = Integer.parseInt(dt_fim.substring(0, 4));
      int mes_i = Integer.parseInt(dt_inicio.substring(5, 7));
      int mes_f = Integer.parseInt(dt_fim.substring(5, 7));
      int dia_i = Integer.parseInt(dt_inicio.substring(8, 10));
      int dia_f = Integer.parseInt(dt_fim.substring(8, 10));
      


      double n_meses = (ano_f - ano_i) * 12 + (mes_f - mes_i - 1);
      

      double mes = mes_i;
      double d = 0.0D;
      if ((mes == 1.0D) || (mes == 3.0D) || (mes == 5.0D) || (mes == 7.0D) || (mes == 8.0D) || (mes == 10.0D) || (mes == 12.0D))
        d = 31.0D;
      if ((mes == 4.0D) || (mes == 6.0D) || (mes == 9.0D) || (mes == 11.0D))
        d = 30.0D;
      if ((mes == 2.0D) && (ano_i % 4 == 0))
        d = 29.0D;
      if ((mes == 2.0D) && (ano_i % 4 != 0))
        d = 28.0D;
      n_meses += (d - dia_i + 1.0D) / d;
      
      mes = mes_f;
      if ((mes == 1.0D) || (mes == 3.0D) || (mes == 5.0D) || (mes == 7.0D) || (mes == 8.0D) || (mes == 10.0D) || (mes == 12.0D))
        d = 31.0D;
      if ((mes == 4.0D) || (mes == 6.0D) || (mes == 9.0D) || (mes == 11.0D))
        d = 30.0D;
      if ((mes == 2.0D) && (ano_f % 4 == 0))
        d = 29.0D;
      if ((mes == 2.0D) && (ano_f % 4 != 0))
        d = 28.0D;
      n_meses += dia_f / d;
      
      getByName("n_meses").setStringValue(Double.toString(n_meses));
    }
    

    if (tag.equals("fundamento")) {
      CHCampo chc = getByName(tag);
      if ((chc instanceof CHCampo_TextArea)) {
        JTextArea jta = jcomp;
        int n = jta.getText().length();
        P07.jLabel_Fundam_Count.setText(limite - n + "/" + limite);
      }
    }
  }
  












  void Clear()
  {
    for (int i = 0; i < Campos.size(); i++) {
      if ((!Campos.elementAt(i)).tag.equals("investimento")) && 
        (!Campos.elementAt(i)).tag.equals("elegivel"))) {
        ((CHCampo)Campos.elementAt(i)).clear();
      }
    }
    on_update("dt_fim");
  }
  
  CHValid_Grp validar_1(CHValid_Grp err_list) {
    if (err_list == null) {
      err_list = new CHValid_Grp(this, "Designação do Projeto e Tipologia(s)");
    }
    extract();
    if (getByName("designacao").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("designacao", "Designação - %o"));
    }
    

    CBData.Tipologia.validar(err_list);
    













    String erro = "Texto demasiado extenso. Por favor, abrevie até " + limite + " caracteres.";
    
    if (getByName("fundamento").isEmpty())
      err_list.add_msg(new CHValid_Msg("fundamento", "Enquadramento do projeto na(s) tipologia(s) selecionada(s) - %o"));
    if ((!getByName("fundamento").isEmpty()) && (getByName"fundamento"v.length() > limite)) {
      err_list.add_msg(new CHValid_Msg("fundamento", erro));
    }
    return err_list;
  }
  
  CHValid_Grp validar_2(CHValid_Grp err_list) {
    if (err_list == null) {
      err_list = new CHValid_Grp(this, "Calendarização");
    }
    extract();
    int ano_c = _lib.to_int(ParamsgetByName"ano_cand"v);
    
    if (getByName("dt_inicio").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("dt_inicio", "Data de Início do Projeto - %o"));
    }
    else {
      SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd");
      
      Date dt_ini = CFType_Data.parse_date(getByName"dt_inicio"v);
      String dt_i = format.format(dt_ini);
      String dt_today = format.format(new Date());
      if ((dt_ini != null) && (dt_i.compareTo(dt_today) < 0)) {
        err_list.add_msg(new CHValid_Msg("dt_const", "A Data de Início do Projeto não pode ser anterior à da candidatura"));
      }
      int ano_i = _lib.to_int(getByName"dt_inicio"v.substring(0, 4));
      if ((ano_i < ano_c) || (ano_i > ano_c + 2)) {
        err_list.add_msg(new CHValid_Msg("dt_inicio", "Data de Início do Projeto - fora do intervalo de referência aceitável"));
      }
    }
    
    if (getByName("dt_fim").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("dt_fim", "Data de Fim do Projeto - %o"));
    }
    else if (!getByName("dt_inicio").isEmpty()) {
      Date today = new Date();
      Date dt_inicio = CFType_Data.parse_date(getByName"dt_inicio"v);
      Date dt_fim = CFType_Data.parse_date(getByName"dt_fim"v);
      
      if ((dt_inicio != null) && (dt_fim != null) && (dt_fim.before(dt_inicio))) {
        err_list.add_msg(new CHValid_Msg("dt_inicio", 
          "Data de Início não pode ser posterior à Data de Fim do Projeto"));
      } else {
        int ano_i = _lib.to_int(getByName"dt_inicio"v.substring(0, 4));
        int ano_f = _lib.to_int(getByName"dt_fim"v.substring(0, 4));
        int limite = 3;
        if (CParseConfig.hconfig.get("extensao").equals("i20")) limite = 4;
        if (ano_f > ano_i + limite) {
          err_list.add_msg(new CHValid_Msg("dt_inicio", "Data de Fim do Projeto - fora do intervalo de referência aceitável"));
        }
      }
    }
    
    if ((!getByName("n_meses").isEmpty()) && (_lib.to_double(getByName"n_meses"v) > 24.0D)) {
      err_list.add_msg(new CHValid_Msg("dt_fim", 'W', "Duração do projeto superior a 2 anos"));
    }
    if (getByName("decl_inicio").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("decl_inicio", P07.getJCheckBox_DeclInicio().getText().replaceAll("<html>", "").replaceAll("</html>", "") + " - %o"));
    }
    return err_list;
  }
  




















  Vector dt_fim_updates = new Vector();
  
  void bind_dt_fim_update(CBData_Comum d) { dt_fim_updates.add(d); }
}