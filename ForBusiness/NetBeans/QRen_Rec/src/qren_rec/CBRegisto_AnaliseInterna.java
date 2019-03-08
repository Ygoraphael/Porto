package fme;

import java.util.Vector;
import javax.swing.JLabel;
import javax.swing.JTextArea;













































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class CBRegisto_AnaliseInterna
  extends CBRegisto
{
  Frame_AnaliseInterna P;
  
  public String getPagina()
  {
    return "AnaliseInterna";
  }
  

  int limite1 = 3000;
  int limite2 = 500;
  
  CBRegisto_AnaliseInterna() {
    P = ((Frame_AnaliseInterna)fmeApp.Paginas.getPage("AnaliseInterna"));
    if (P == null) return;
    initialize();
  }
  
  void initialize() {
    tag = "AnaliseInterna";
    started = true;
    
    Campos.add(new CHCampo_TextArea("txt_descricao", P.getjTextArea_Txt(), this));
    
    Campos.add(new CHCampo_TextArea("txt_pfortes", P.jTextArea_S, this));
    Campos.add(new CHCampo_TextArea("txt_pfracos", P.jTextArea_W, this));
    Campos.add(new CHCampo_TextArea("txt_oportunidades", P.jTextArea_O, this));
    Campos.add(new CHCampo_TextArea("txt_ameacas", P.jTextArea_T, this));
    
    Campos.add(new CHCampo_TextArea("txt_apostas", P.jTextArea_Apostas, this));
    Campos.add(new CHCampo_TextArea("txt_avisos", P.jTextArea_Avisos, this));
    Campos.add(new CHCampo_TextArea("txt_restricoes", P.jTextArea_Restricoes, this));
    Campos.add(new CHCampo_TextArea("txt_riscos", P.jTextArea_Riscos, this));
  }
  
  void after_open()
  {
    on_update("txt_descricao");
    on_update("txt_pfortes");
    on_update("txt_pfracos");
    on_update("txt_oportunidades");
    on_update("txt_ameacas");
    on_update("txt_apostas");
    on_update("txt_avisos");
    on_update("txt_restricoes");
    on_update("txt_riscos");
  }
  
  void on_update(String tag) {
    CHCampo chc = getByName(tag);
    if ((chc instanceof CHCampo_TextArea)) {
      JTextArea jta = jcomp;
      int n = jta.getText().length();
      if (tag.equals("txt_descricao"))
        P.jLabel_Count.setText(limite1 - n + "/" + limite1);
      if (tag.equals("txt_pfortes"))
        P.jLabel_Count_S.setText(limite2 - n + "/" + limite2);
      if (tag.equals("txt_pfracos"))
        P.jLabel_Count_W.setText(limite2 - n + "/" + limite2);
      if (tag.equals("txt_oportunidades"))
        P.jLabel_Count_O.setText(limite2 - n + "/" + limite2);
      if (tag.equals("txt_ameacas"))
        P.jLabel_Count_T.setText(limite2 - n + "/" + limite2);
      if (tag.equals("txt_apostas"))
        P.jLabel_Count_Apostas.setText(limite2 - n + "/" + limite2);
      if (tag.equals("txt_avisos"))
        P.jLabel_Count_Avisos.setText(limite2 - n + "/" + limite2);
      if (tag.equals("txt_restricoes"))
        P.jLabel_Count_Restricoes.setText(limite2 - n + "/" + limite2);
      if (tag.equals("txt_riscos"))
        P.jLabel_Count_Riscos.setText(limite2 - n + "/" + limite2);
    }
  }
  
  CHValid_Grp validar_1(CHValid_Grp err_list, String cp) {
    String tit = "Análise Interna";
    if (cp.length() > 0) tit = tit + cp;
    if (err_list == null) {
      err_list = new CHValid_Grp(this, tit);
    }
    extract();
    String erro = "Texto demasiado extenso. Por favor, abrevie até " + limite1 + " caracteres.";
    
    if (getByName("txt_descricao").isEmpty())
      err_list.add_msg(new CHValid_Msg("txt_descricao", "%o"));
    if ((!getByName("txt_descricao").isEmpty()) && (getByName"txt_descricao"v.length() > limite1)) {
      err_list.add_msg(new CHValid_Msg("txt_descricao", erro));
    }
    return err_list;
  }
  
  CHValid_Grp validar_2(CHValid_Grp err_list, String cp) {
    String tit = "Análise SWOT";
    if (cp.length() > 0) tit = tit + cp;
    if (err_list == null) {
      err_list = new CHValid_Grp(this, tit);
    }
    extract();
    String erro = "Texto demasiado extenso. Por favor, abrevie até " + limite2 + " caracteres.";
    
    if (getByName("txt_pfortes").isEmpty())
      err_list.add_msg(new CHValid_Msg("txt_pfortes", "Pontos Fortes - %o"));
    if ((!getByName("txt_pfortes").isEmpty()) && (getByName"txt_pfortes"v.length() > limite2)) {
      err_list.add_msg(new CHValid_Msg("txt_pfortes", erro));
    }
    if (getByName("txt_pfracos").isEmpty())
      err_list.add_msg(new CHValid_Msg("txt_pfracos", "Pontos Fracos - %o"));
    if ((!getByName("txt_pfracos").isEmpty()) && (getByName"txt_pfracos"v.length() > limite2)) {
      err_list.add_msg(new CHValid_Msg("txt_pfracos", erro));
    }
    if (getByName("txt_oportunidades").isEmpty())
      err_list.add_msg(new CHValid_Msg("txt_oportunidades", "Oportunidades - %o"));
    if ((!getByName("txt_oportunidades").isEmpty()) && (getByName"txt_oportunidades"v.length() > limite2)) {
      err_list.add_msg(new CHValid_Msg("txt_oportunidades", erro));
    }
    if (getByName("txt_ameacas").isEmpty())
      err_list.add_msg(new CHValid_Msg("txt_ameacas", "Ameaças - %o"));
    if ((!getByName("txt_ameacas").isEmpty()) && (getByName"txt_ameacas"v.length() > limite2)) {
      err_list.add_msg(new CHValid_Msg("txt_ameacas", erro));
    }
    if (getByName("txt_apostas").isEmpty())
      err_list.add_msg(new CHValid_Msg("txt_apostas", "Apostas - %o"));
    if ((!getByName("txt_apostas").isEmpty()) && (getByName"txt_apostas"v.length() > limite2)) {
      err_list.add_msg(new CHValid_Msg("txt_apostas", erro));
    }
    if (getByName("txt_avisos").isEmpty())
      err_list.add_msg(new CHValid_Msg("txt_avisos", "Avisos - %o"));
    if ((!getByName("txt_avisos").isEmpty()) && (getByName"txt_avisos"v.length() > limite2)) {
      err_list.add_msg(new CHValid_Msg("txt_avisos", erro));
    }
    if (getByName("txt_restricoes").isEmpty())
      err_list.add_msg(new CHValid_Msg("txt_restricoes", "Restrições - %o"));
    if ((!getByName("txt_restricoes").isEmpty()) && (getByName"txt_restricoes"v.length() > limite2)) {
      err_list.add_msg(new CHValid_Msg("txt_restricoes", erro));
    }
    if (getByName("txt_riscos").isEmpty())
      err_list.add_msg(new CHValid_Msg("txt_riscos", "Riscos - %o"));
    if ((!getByName("txt_riscos").isEmpty()) && (getByName"txt_riscos"v.length() > limite2)) {
      err_list.add_msg(new CHValid_Msg("txt_riscos", erro));
    }
    return err_list;
  }
}