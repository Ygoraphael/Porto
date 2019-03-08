package fme;

import java.util.Vector;
import javax.swing.JLabel;
import javax.swing.JTextArea;













































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class CBRegisto_Decl
  extends CBRegisto
{
  Frame_Decl P;
  
  public String getPagina()
  {
    return "Decl";
  }
  
  int limite = 2000;
  
  CBRegisto_Decl() {
    P = ((Frame_Decl)fmeApp.Paginas.getPage("Decl"));
    if (P == null) return;
    initialize();
  }
  
  CBRegisto_Decl(Frame_Decl p1) {
    P = p1;
    initialize();
  }
  
  void initialize() {
    tag = "Declaracoes";
    


    CHCampo_Opt opt_g_1 = new CHCampo_Opt("geral_1", this);
    opt_g_1.setOptions("S", "N");
    opt_g_1.addComponent(P.jCheckBox_Geral_1_Sim);
    opt_g_1.addComponent(P.jCheckBox_Geral_1_Nao);
    dummy = P.jCheckBox_Geral_1_Clear;
    Campos.add(opt_g_1);
    
    String[] opt_v = { "S" };
    
    CHCampo_Opt opt_g_2 = new CHCampo_Opt("geral_2", opt_v, this);
    opt_g_2.addComponent(P.jCheckBox_Geral_2_Sim);
    dummy = P.jCheckBox_Geral_2_Clear;
    Campos.add(opt_g_2);
    


    CHCampo_Opt opt_el_1 = new CHCampo_Opt("eleg_prom_1", opt_v, this);
    opt_el_1.addComponent(P.jCheckBox_ElegProm_1_Sim);
    dummy = P.jCheckBox_ElegProm_1_Clear;
    Campos.add(opt_el_1);
    
    CHCampo_Opt opt_el_2 = new CHCampo_Opt("eleg_prom_2", opt_v, this);
    opt_el_2.addComponent(P.jCheckBox_ElegProm_2_Sim);
    dummy = P.jCheckBox_ElegProm_2_Clear;
    Campos.add(opt_el_2);
    
    CHCampo_Opt opt_el_3 = new CHCampo_Opt("eleg_prom_3", opt_v, this);
    opt_el_3.addComponent(P.jCheckBox_ElegProm_3_Sim);
    dummy = P.jCheckBox_ElegProm_3_Clear;
    Campos.add(opt_el_3);
    
    CHCampo_Opt opt_el_4 = new CHCampo_Opt("eleg_prom_4", opt_v, this);
    opt_el_4.addComponent(P.jCheckBox_ElegProm_4_Sim);
    dummy = P.jCheckBox_ElegProm_4_Clear;
    Campos.add(opt_el_4);
    
    CHCampo_Opt opt_el_5 = new CHCampo_Opt("eleg_prom_5", opt_v, this);
    opt_el_5.addComponent(P.jCheckBox_ElegProm_5_Sim);
    dummy = P.jCheckBox_ElegProm_5_Clear;
    Campos.add(opt_el_5);
    
    CHCampo_Opt opt_el_6 = new CHCampo_Opt("eleg_prom_6", opt_v, this);
    opt_el_6.addComponent(P.jCheckBox_ElegProm_6_Sim);
    dummy = P.jCheckBox_ElegProm_6_Clear;
    Campos.add(opt_el_6);
    
    CHCampo_Opt opt_el_7 = new CHCampo_Opt("eleg_prom_7", opt_v, this);
    opt_el_7.addComponent(P.jCheckBox_ElegProm_7_Sim);
    dummy = P.jCheckBox_ElegProm_7_Clear;
    Campos.add(opt_el_7);
    
    CHCampo_Opt opt_el_prom_8 = new CHCampo_Opt("eleg_prom_8", this);
    opt_el_prom_8.setOptions("S", "NA");
    opt_el_prom_8.addComponent(P.jCheckBox_ElegProm_8_Sim);
    opt_el_prom_8.addComponent(P.jCheckBox_ElegProm_8_NaoAplic);
    dummy = P.jCheckBox_ElegProm_8_Clear;
    Campos.add(opt_el_prom_8);
    
    CHCampo_Opt opt_el_prom_9 = new CHCampo_Opt("eleg_prom_9", this);
    opt_el_prom_9.setOptions("S", "NA");
    opt_el_prom_9.addComponent(P.jCheckBox_ElegProm_9_Sim);
    opt_el_prom_9.addComponent(P.jCheckBox_ElegProm_9_NaoAplic);
    dummy = P.jCheckBox_ElegProm_9_Clear;
    Campos.add(opt_el_prom_9);
    


    CHCampo_Opt opt_el_proj_1 = new CHCampo_Opt("eleg_proj_1", opt_v, this);
    opt_el_proj_1.addComponent(P.jCheckBox_ElegProj_1_Sim);
    dummy = P.jCheckBox_ElegProj_1_Clear;
    Campos.add(opt_el_proj_1);
    
    CHCampo_Opt opt_el_proj_2 = new CHCampo_Opt("eleg_proj_2", this);
    opt_el_proj_2.setOptions("S", "NA");
    opt_el_proj_2.addComponent(P.jCheckBox_ElegProj_2_Sim);
    opt_el_proj_2.addComponent(P.jCheckBox_ElegProj_2_NaoAplic);
    dummy = P.jCheckBox_ElegProj_2_Clear;
    Campos.add(opt_el_proj_2);
    
    CHCampo_Opt opt_el_proj_3 = new CHCampo_Opt("eleg_proj_3", opt_v, this);
    opt_el_proj_3.addComponent(P.jCheckBox_ElegProj_3_Sim);
    dummy = P.jCheckBox_ElegProj_3_Clear;
    Campos.add(opt_el_proj_3);
    







    CHCampo_Opt opt_el_proj_5 = new CHCampo_Opt("eleg_proj_5", opt_v, this);
    opt_el_proj_5.addComponent(P.jCheckBox_ElegProj_5_Sim);
    dummy = P.jCheckBox_ElegProj_5_Clear;
    Campos.add(opt_el_proj_5);
    


    CHCampo_Opt opt_ob_1 = new CHCampo_Opt("obrig_1", opt_v, this);
    opt_ob_1.addComponent(P.jCheckBox_Obrig_1_Sim);
    dummy = P.jCheckBox_Obrig_1_Clear;
    Campos.add(opt_ob_1);
    
    CHCampo_Opt opt_ob_2 = new CHCampo_Opt("obrig_2", this);
    opt_ob_2.setOptions("S", "NA");
    opt_ob_2.addComponent(P.jCheckBox_Obrig_2_Sim);
    opt_ob_2.addComponent(P.jCheckBox_Obrig_2_NaoAplic);
    dummy = P.jCheckBox_Obrig_2_Clear;
    Campos.add(opt_ob_2);
    
































    Campos.add(new CHCampo_TextArea("observacoes", P.getJTextArea_Obs(), null));
    started = true;
  }
  
  CHValid_Grp validar(CHValid_Grp err_list) {
    if (err_list == null) {
      err_list = new CHValid_Grp(this, "Declarações de Compromisso");
    }
    extract();
    
    if (getByName("geral_1").isEmpty())
      err_list.add_msg(new CHValid_Msg("geral_1", "1. Geral (1) - %o"));
    if (getByName("geral_2").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("geral_2", "1. Geral (2) - %o"));
    }
    if (getByName("eleg_prom_1").isEmpty())
      err_list.add_msg(new CHValid_Msg("eleg_prom_1", "2. Critérios de elegibilidade dos beneficiários (1) - %o"));
    if (getByName("eleg_prom_2").isEmpty())
      err_list.add_msg(new CHValid_Msg("eleg_prom_2", "2. Critérios de elegibilidade dos beneficiários (2) - %o"));
    if (getByName("eleg_prom_3").isEmpty())
      err_list.add_msg(new CHValid_Msg("eleg_prom_3", "2. Critérios de elegibilidade dos beneficiários (3) - %o"));
    if (getByName("eleg_prom_4").isEmpty())
      err_list.add_msg(new CHValid_Msg("eleg_prom_4", "2. Critérios de elegibilidade dos beneficiários (4) - %o"));
    if (getByName("eleg_prom_5").isEmpty())
      err_list.add_msg(new CHValid_Msg("eleg_prom_5", "2. Critérios de elegibilidade dos beneficiários (5) - %o"));
    if (getByName("eleg_prom_6").isEmpty())
      err_list.add_msg(new CHValid_Msg("eleg_prom_6", "2. Critérios de elegibilidade dos beneficiários (6) - %o"));
    if (getByName("eleg_prom_7").isEmpty())
      err_list.add_msg(new CHValid_Msg("eleg_prom_7", "2. Critérios de elegibilidade dos beneficiários (7) - %o"));
    if (getByName("eleg_prom_8").isEmpty())
      err_list.add_msg(new CHValid_Msg("eleg_prom_8", "2. Critérios de elegibilidade dos beneficiários (8) - %o"));
    if (getByName("eleg_prom_9").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("eleg_prom_9", "2. Critérios de elegibilidade dos beneficiários (9) - %o"));
    }
    if (getByName("eleg_proj_1").isEmpty())
      err_list.add_msg(new CHValid_Msg("eleg_proj_1", "3. Critérios de elegibilidade dos projetos (1) - %o"));
    if (getByName("eleg_proj_2").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("eleg_proj_2", "3. Critérios de elegibilidade dos projetos (2) - %o"));
    } else {
      if ((getByName"eleg_proj_2"v.equals("S")) && (CBData.Dimensao.is_pme()))
        err_list.add_msg(new CHValid_Msg("eleg_prom_2", "3. Critérios de elegibilidade dos projetos (2) - opção inválida, aplicável a Não PME"));
      if ((getByName"eleg_proj_2"v.equals("NA")) && (!CBData.Dimensao.is_pme()))
        err_list.add_msg(new CHValid_Msg("eleg_prom_2", "3. Critérios de elegibilidade dos projetos (2) - opção inválida, aplicável a Não PME"));
    }
    if (getByName("eleg_proj_3").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("eleg_proj_3", "3. Critérios de elegibilidade dos projetos (3) - %o"));
    }
    
    if (getByName("eleg_proj_5").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("eleg_proj_5", "3. Critérios de elegibilidade dos projetos (4) - %o"));
    }
    if (getByName("obrig_1").isEmpty())
      err_list.add_msg(new CHValid_Msg("obrig_1", "4. Obrigações dos beneficiários (1) - %o"));
    if (getByName("obrig_2").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("obrig_2", "4. Obrigações dos beneficiários (2) - %o"));
    }
    

    String erro = "Texto demasiado extenso. Por favor, abrevie até " + limite + " caracteres.";
    















    if ((!getByName("observacoes").isEmpty()) && (getByName"observacoes"v.length() > limite)) {
      err_list.add_msg(new CHValid_Msg("observacoes", erro));
    }
    return err_list;
  }
  
  void after_open() {
    on_update("eleg_prom_8");
    on_update("eleg_prom_9");
    on_update("licenc_1_obs");
    on_update("licenc_2_obs");
    on_update("observacoes");
  }
  


  void on_update(String tag)
  {
    if ((tag.equals("eleg_prom_8")) && (CBData.Uploads.getByName("aplicavel_03") != null)) {
      if (getByName"eleg_prom_8"v.equals("S")) {
        CBData.Uploads.getByName("aplicavel_03").setStringValue("S");
        CBData.Uploads.on_update("upload_03");
      } else {
        CBData.Uploads.getByName("aplicavel_03").setStringValue("");
        CBData.Uploads.on_update("upload_03");
      }
    }
    
    if ((tag.equals("eleg_prom_9")) && (CBData.Uploads.getByName("aplicavel_04") != null)) {
      if (getByName"eleg_prom_9"v.equals("S")) {
        CBData.Uploads.getByName("aplicavel_04").setStringValue("S");
        CBData.Uploads.on_update("upload_04");
      } else {
        CBData.Uploads.getByName("aplicavel_04").setStringValue("");
        CBData.Uploads.on_update("upload_04");
      }
    }
    

    if (!tag.equals("observacoes")) return;
    CHCampo chc = getByName(tag);
    if ((chc instanceof CHCampo_TextArea)) {
      JTextArea jta = jcomp;
      int n = jta.getText().length();
      



      if (tag.equals("observacoes")) {
        P.jLabel_Count.setText(limite - n + "/" + limite);
      }
    }
  }
}
