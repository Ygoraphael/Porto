package fme;

import java.io.PrintStream;
import java.util.Vector;
import javax.xml.xpath.XPath;
import javax.xml.xpath.XPathFactory;
import org.w3c.dom.Document;






































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































class CBRegisto_Consultora
  extends CBRegisto
{
  Frame_IdProm_1 P01;
  
  public String getPagina()
  {
    return "IdProm_1";
  }
  

  int tab_index = 0;
  
  CBRegisto_Consultora() {
    P01 = ((Frame_IdProm_1)fmeApp.Paginas.getPage("IdProm_1"));
    if (P01 == null) return;
    initialize();
  }
  
  CBRegisto_Consultora(Frame_IdProm_1 p, int idx) {
    P01 = p;
    tab_index = idx;
    initialize();
  }
  
  void initialize()
  {
    tag = "Consultora";
    started = true;
    
    Campos.add(new CHCampo_Text("nif", P01.getJTextField_ConsNIF(), CFLib.VLD_NIF, this));
    Campos.add(new CHCampo_Text("nome", P01.getJTextField_ConsNome(), null));
    Campos.add(new CHCampo_Text("morada", P01.getJTextField_ConsMorada(), null));
    Campos.add(new CHCampo_Text("cod_postal", P01.getJTextField_ConsCodPostal(), CFLib.VLD_COD_POSTAL));
    Campos.add(new CHCampo_Text("cod_postal_loc", P01.getJTextField_ConsCodPostalLocal(), null));
    Campos.add(new CHCampo_Text("contacto", P01.getJTextField_ConsContacto(), null));
    Campos.add(new CHCampo_Text("telefone", P01.getJTextField_ConsTelefone(), null));
    Campos.add(new CHCampo_Text("email", P01.getJTextField_ConsEmail(), CFLib.VLD_EMAIL));
  }
  
  void on_update(String tag) {
    if ((tag.equals("nif")) && (!CBData.reading_xml) && (CBData.T.equals(""))) {
      getByName("nome").setStringValue("");
      getByName("morada").setStringValue("");
      getByName("cod_postal").setStringValue("");
      getByName("cod_postal_loc").setStringValue("");
      
      if (getByNamev.length() == 9) {
        get_dados_adc(getByNamev);
      }
    }
  }
  
  void after_open() {
    on_update("nif");
  }
  
  void get_dados_adc(String nif) {
    if ((!CBData.T.equals("")) || (!fmeComum.ON)) return;
    String url = fmeComum.atend_pas + "acesso/formulario/atend-import-adc.php?NIF=" + nif + "&QDR=" + tag;
    
    System.out.println("consultora " + nif);
    Http http = new Http(url);
    Document doc = http.doPostRequestDoc("");
    try
    {
      XPath xp = XPathFactory.newInstance().newXPath();
      String nome = xp.evaluate("//fme/" + tag + "/nome", doc);
      String morada = xp.evaluate("//fme/" + tag + "/morada", doc);
      String cod_postal = xp.evaluate("//fme/" + tag + "/cod_postal", doc);
      String cod_postal_loc = xp.evaluate("//fme/" + tag + "/cod_postal_loc", doc);
      
      getByName("nome").setStringValue(nome);
      getByName("morada").setStringValue(morada);
      getByName("cod_postal").setStringValue(cod_postal);
      getByName("cod_postal_loc").setStringValue(cod_postal_loc);
    }
    catch (Exception e) {
      e.printStackTrace();
    }
  }
  
  CHValid_Grp validar(CHValid_Grp err_list, String cp)
  {
    String titulo = "Entidade Consultora";
    if (cp.length() > 0) titulo = titulo + cp;
    if (err_list == null) {
      err_list = new CHValid_Grp(this, titulo);
    }
    extract();
    
    if (((!getByName("nif").isEmpty()) || 
      (!getByName("morada").isEmpty()) || 
      (!getByName("cod_postal").isEmpty()) || 
      (!getByName("cod_postal_loc").isEmpty()) || 
      (!getByName("contacto").isEmpty()) || 
      (!getByName("telefone").isEmpty()) || 
      (!getByName("email").isEmpty())) && 
      (getByName("nome").isEmpty())) {
      err_list.add_msg(new CHValid_Msg("nome", "Nome ou Designação Social - %o"));
    }
    

















    return err_list;
  }
}