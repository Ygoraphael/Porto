package fme;

import java.util.Date;
import java.util.GregorianCalendar;
import java.util.Vector;
import javax.swing.JLabel;
import javax.swing.JTextField;



















































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class CBRegisto_Promotor
  extends CBRegisto
{
  Frame_IdProm_1 P01;
  
  public String getPagina()
  {
    return "IdProm_01";
  }
  

  int tab_index = 0;
  
  CBRegisto_Promotor() {
    P01 = ((Frame_IdProm_1)fmeApp.Paginas.getPage("IdProm_1"));
    if (P01 == null) return;
    initialize();
  }
  
  CBRegisto_Promotor(Frame_IdProm_1 p, int idx) {
    P01 = p;
    tab_index = idx;
    initialize();
  }
  
  void initialize() {
    tag = "Promotor";
    started = true;
    P01.cbd_promotor = this;
    
    Campos.add(new CHCampo_Text("nif", P01.getJTextField_NIF(), CFLib.VLD_NIF));
    Campos.add(new CHCampo_Text("nome", P01.getJTextField_Nome(), null, this));
    Campos.add(new CHCampo_Text("morada", P01.getJTextField_Morada(), null));
    Campos.add(new CHCampo_Text("localidade", P01.getJTextField_Localidade(), null));
    Campos.add(new CHCampo_Text("cod_postal", P01.getJTextField_CodPostal(), CFLib.VLD_COD_POSTAL));
    Campos.add(new CHCampo_Text("cod_postal_loc", P01.getJTextField_CodPostalLocal(), null));
    Campos.add(new CHCampo_Combo("distrito", "Distritos", P01.getJComboBox_Distrito(), this));
    Campos.add(new CHCampo_Combo("concelho", "ConcelhosF1", P01.getJComboBox_Concelho(), this));
    Campos.add(new CHCampo_Text("telefone", P01.getJTextField_Telefone(), null));
    Campos.add(new CHCampo_Text("telefax", P01.getJTextField_Telefax(), null));
    Campos.add(new CHCampo_Text("email", P01.getJTextField_Email(), CFLib.VLD_EMAIL));
    Campos.add(new CHCampo_Text("url", P01.getJTextField_Url(), null));
    Campos.add(new CHCampo_Combo("nat_jur", "NatJuridica", P01.getJComboBox_NatJur(), this));
    
    CHCampo_Opt opt_fins = new CHCampo_Opt("fins_lucro");
    opt_fins.setOptions("S", "N");
    opt_fins.addComponent(P01.getJCheckBox_FinsLucro_Sim());
    opt_fins.addComponent(P01.getJCheckBox_FinsLucro_Nao());
    dummy = P01.jCheckBox_FinsLucro_Clear;
    Campos.add(opt_fins);
    
    Campos.add(new CHCampo_Text("dt_const", P01.getJTextField_DtConst(), CFLib.VLD_DATA));
    Campos.add(new CHCampo_Text("dt_inicio_act", P01.getJTextField_DtInicioAct(), CFLib.VLD_DATA, this));
    Campos.add(new CHCampo_Text("cap_social", P01.getJTextField_CapSocial(), CFLib.VLD_VALOR));
    
    Campos.add(new CHCampo_Text("rgc_num", P01.getJTextField_Matricula(), null));
    Campos.add(new CHCampo_Text("rgc_cons", P01.getJTextField_Conservatoria(), null));
    
    Campos.add(new CHCampo_Text("cod_ies1", P01.getJTextField_IES_p1(), null, this));
    Campos.add(new CHCampo_Text("cod_ies2", P01.getJTextField_IES_p2(), null, this));
    Campos.add(new CHCampo_Text("cod_ies3", P01.getJTextField_IES_p3(), null, this));
    
    CBData.Params.bind_ano_cand_update(this);
  }
  
  void Clear()
  {
    for (int i = 0; i < Campos.size(); i++) {
      if ((!Campos.elementAt(i)).tag.equals("nif")) || (!fmeApp.contexto.equals("toolbar")) || (CBData.reg_C.equals("")))
        ((CHCampo)Campos.elementAt(i)).clear();
    }
  }
  
  void Clear2() {
    for (int i = 0; i < Campos.size(); i++) {
      if ((!Campos.elementAt(i)).tag.equals("nat_jur")) && 
        (!Campos.elementAt(i)).tag.equals("fins_lucro")) && 
        (!Campos.elementAt(i)).tag.equals("cont_publica")) && 
        (!Campos.elementAt(i)).tag.equals("cod_ies1")) && 
        (!Campos.elementAt(i)).tag.equals("cod_ies2")) && 
        (!Campos.elementAt(i)).tag.equals("cod_ies3")))
        ((CHCampo)Campos.elementAt(i)).clear();
    }
  }
  
  void on_update(String tag) {
    if (tag.equals("concelho"))
    {
      String concelho = getByName("concelho").getStringValue();
      if (concelho.length() > 0) {
        getByName("distrito").setStringValue(concelho.substring(0, 2));
      }
    }
    if (tag.equals("distrito")) {
      String distrito = getByName("distrito").getStringValue();
      String concelho = getByName("concelho").getStringValue();
      if ((concelho.length() > 0) && (!concelho.substring(0, 2).equals(distrito)))
      {
        getByName("concelho").setStringValue("");
      }
    }
  }
  













  String ano_val = "ano_cand";
  
  public void on_external_update(String tag) { if (!tag.startsWith("ano_")) return;
    String anoCand = ParamsgetByNamev;
    if (anoCand.length() > 0) {
      int ano = Integer.parseInt(anoCand);
      P01.jLabel_IES_p1.setText(ano - 1 + " (*)");
      P01.jLabel_IES_p2.setText(ano - 2);
      P01.jLabel_IES_p3.setText(ano - 3);
    } else {
      P01.jLabel_IES_p1.setText("Ano -1");
      P01.jLabel_IES_p2.setText("Ano -2");
      P01.jLabel_IES_p3.setText("Ano -3");
    }
    ano_val = tag;
  }
  
  String on_xml(String tag)
  {
    String s = "";
    if (tag.equals("concelho")) {
      String c = getByName(tag).getStringValue();
      
      if (c.length() == 0) {
        s = s + "<concelho_d/>\n";
      } else
        s = s + _lib.xml_encode("concelho_d", CTabelas.Concelhos.getDesign(c));
    }
    if (tag.equals("distrito")) {
      String d = getByName(tag).getStringValue();
      if (d.length() == 0) {
        s = s + "<distrito_d/>\n";
      } else {
        s = s + _lib.xml_encode("distrito_d", CTabelas.Distritos.getDesign(d));
      }
    }
    if (tag.equals("nat_jur")) {
      String c = getByName(tag).getStringValue();
      if (c.length() == 0) {
        s = s + "<nat_jur_d/>\n";
      } else
        s = s + _lib.xml_encode("nat_jur_d", CTabelas.NatJuridica.getDesign(c));
    }
    return s;
  }
  
  boolean isEmpty() {
    for (int i = 0; i < Campos.size();) {
      CHCampo c = (CHCampo)Campos.elementAt(i);
      try {
        CHCampo_Text c1 = (CHCampo_Text)Campos.elementAt(i);
        if (jcomp.isEditable()) {}
        i++;

      }
      catch (Exception localException)
      {

        if (!c.isEmpty()) return false;
      } }
    return true;
  }
  
  CHValid_Grp validar(CHValid_Grp err_list, String cp) {
    String titulo = "Identificação do Beneficiário";
    if (cp.length() > 0) titulo = titulo + cp;
    if (err_list == null) {
      err_list = new CHValid_Grp(this, titulo);
    }
    extract();
    

    if ((tab_index > 0) && (isEmpty())) { return err_list;
    }
    
    if (getByName("nif").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("nif", "Nº de Identificação Fiscal - %o"));
    }
    if (getByName("nome").isEmpty())
      err_list.add_msg(new CHValid_Msg("nome", "Nome ou Designação Social - %o"));
    if (getByName("morada").isEmpty())
      err_list.add_msg(new CHValid_Msg("morada", "Morada (Sede Social) - %o"));
    if (getByName("localidade").isEmpty())
      err_list.add_msg(new CHValid_Msg("localidade", "Localidade - %o"));
    if (getByName("cod_postal").isEmpty())
      err_list.add_msg(new CHValid_Msg("cod_postal", "Código Postal - %o"));
    if (getByName("cod_postal_loc").isEmpty())
      err_list.add_msg(new CHValid_Msg("cod_postal_loc", 
        "Código Postal (localidade) - %o"));
    if (getByName("distrito").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("distrito", "Distrito - %o"));
    }
    else if (getByName"distrito"v.equals("99")) {
      err_list.add_msg(new CHValid_Msg("distrito", "Distrito inválido"));
    }
    if (getByName("concelho").isEmpty())
      err_list.add_msg(new CHValid_Msg("concelho", "Concelho - %o"));
    if (getByName("telefone").isEmpty())
      err_list.add_msg(new CHValid_Msg("telefone", "Telefone - %o"));
    if (getByName("email").isEmpty())
      err_list.add_msg(new CHValid_Msg("email", "E-mail - %o"));
    if (getByName("nat_jur").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("nat_jur", "Natureza Jurídica - %o"));
    } else {
      if (getByName"nat_jur"v.equals("42")) {
        err_list.add_msg(new CHValid_Msg("nat_jur", "A natureza jurídica da entidade não é elegível no âmbito do presente Concurso"));
      }
      if (!getByName"nat_jur"v.equals("10")) {
        if (getByName("dt_const").isEmpty())
          err_list.add_msg(new CHValid_Msg("dt_const", "Data de Constituição - %o"));
        if (getByName("rgc_num").isEmpty())
          err_list.add_msg(new CHValid_Msg("rgc_num", "Matriculada sob o n.º - %o"));
        if (getByName("rgc_cons").isEmpty())
          err_list.add_msg(new CHValid_Msg("rgc_cons", "Conservatória do Registo Comercial - %o"));
        if (getByName("cap_social").isEmpty())
          err_list.add_msg(new CHValid_Msg("cap_social", P01.jLabel_CapSocial.getText() + " - %o"));
      }
    }
    if (getByName("fins_lucro").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("fins_lucro", "Fins Lucrativos - %o"));
    }
    Date today = new Date();
    Date dt_const = CFType_Data.parse_date(getByName"dt_const"v);
    Date dt_act = CFType_Data.parse_date(getByName"dt_inicio_act"v);
    
    if (getByName("dt_inicio_act").isEmpty()) {
      err_list.add_msg(new CHValid_Msg("dt_inicio_act", "Data de Início de Atividade - %o"));
    } else {
      int ano_c = _lib.to_int(ParamsgetByName"ano_cand"v);
      
      int ano_i = _lib.to_int(getByName"dt_inicio_act"v.substring(0, 4));
      if (ano_i > ano_c + 1) {
        err_list.add_msg(new CHValid_Msg("dt_inicio_act", "Data de Início de Atividade - fora do intervalo de referência aceitável"));
      }
    }
    if ((dt_const != null) && (dt_const.after(today)))
      err_list.add_msg(new CHValid_Msg("dt_const", 'W', "Data de Constituição ?"));
    if ((dt_const != null) && (dt_act != null) && (dt_act.before(dt_const))) {
      err_list.add_msg(new CHValid_Msg("dt_const", 
        "Data de Início de Atividade anterior à Data de Constituição"));
    }
    if (!getByName("dt_inicio_act").isEmpty()) {
      int ano_cand = (int)CBData.Params.getByName("ano_cand").valueAsDouble();
      int ano = ano_cand;
      String v = getByName"dt_inicio_act"v;
      if (v.length() == 10) {
        ano = Integer.parseInt(v.substring(0, 4));
      }
      if ((ano <= ano_cand - 1) && (getByName("cod_ies1").isEmpty()))
        err_list.add_msg(new CHValid_Msg("", 'W', "IES (" + P01.jLabel_IES_p1.getText() + ") - P.f. preencha este campo"));
      if ((ano <= ano_cand - 2) && (getByName("cod_ies2").isEmpty()))
        err_list.add_msg(new CHValid_Msg("", 'W', "IES (" + P01.jLabel_IES_p2.getText() + ") - P.f. preencha este campo"));
      if ((ano <= ano_cand - 3) && (getByName("cod_ies3").isEmpty())) {
        err_list.add_msg(new CHValid_Msg("", 'W', "IES (" + P01.jLabel_IES_p3.getText() + ") - P.f. preencha este campo"));
      }
    }
    
    return err_list;
  }
  
  boolean is_criacao() {
    if (getByName("dt_inicio_act").isEmpty()) return false;
    Date today = new Date();
    Date dt_act = CFType_Data.parse_date(getByName"dt_inicio_act"v);
    
    GregorianCalendar gc = new GregorianCalendar();
    gc.setTime(today);
    gc.add(1, -3);
    Date result = gc.getTime();
    
    if (dt_act.before(result)) return false;
    return true;
  }
}
