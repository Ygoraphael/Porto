package fme;

import java.io.File;
import java.io.PrintStream;
import java.io.StringReader;
import java.io.StringWriter;
import java.util.HashMap;
import java.util.Vector;
import javax.swing.JOptionPane;
import javax.swing.JTable;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import javax.xml.xpath.XPath;
import javax.xml.xpath.XPathConstants;
import javax.xml.xpath.XPathFactory;
import org.w3c.dom.Document;
import org.xml.sax.InputSource;










class CBData
  extends XMLDataHandler
{
  static String vs = "1.24 de 2017-04-18";
  static String vs_old = "";
  static String config_old = "";
  static boolean config_ok = true;
  static String exportado = "0";
  static String T = "";
  static String reg_nif = "";
  static String reg_C = "";
  static String reg_pas = "";
  static String ficheiro = "0";
  static String reg_adc_data_url = "";
  
  public static File LastFile = null;
  
  static String turismo = "0";
  static String cae = "";
  static String investimento = "";
  static String elegivel = "";
  static String conjuntos_nac = "";
  static String conjuntos_nute = "";
  static String perc_internac = "";
  static String nuts_ii_norte = "";
  static String nuts_ii_centro = "";
  static String nuts_ii_lisboa = "";
  static String nuts_ii_alentejo = "";
  static String nuts_ii_algarve = "";
  
  static String vol_neg_pos = "";
  
  static boolean dirty = false;
  static boolean reading_xml = false;
  static boolean clear_pg = false;
  static boolean import_pas = false;
  static boolean corrompido = false;
  static boolean is_cleaning = false;
  

  static XMLParser xml_parser;
  

  public static CBRegisto_Params Params;
  
  public static CBRegisto_Decl Decl;
  
  public static CBRegisto_Promotor Promotor;
  
  public static CBRegisto_Contacto Contacto;
  
  public static CBRegisto_Consultora Consultora;
  
  public static CBTabela_PromCae PromCae;
  
  public static CBTabela_PromLocal PromLocal;
  
  public static CBTabela_Socios Socios;
  
  public static CBTabela_Part Part;
  
  public static CBRegisto_Dimensao Dimensao;
  
  public static CBRegisto_ParamProj ParamProj;
  
  public static CBRegisto_Evolucao TxtEvolucao;
  
  public static CBRegisto_Visao TxtVisao;
  
  public static CBRegisto_AnaliseMercados AnaliseMercados;
  
  public static CBTabela_BensServProj BensServProj;
  
  public static CBRegisto_DadosBensServProj DadosBensServProj;
  
  public static CBTabela_Mercados Mercados;
  
  public static CBTabela_Mercados2 Mercados2;
  
  public static CBTabela_Mercados3 Mercados3;
  
  public static CBTabela_VendasExt VendasExt;
  
  public static CBRegisto_VendasExtTxt VendasExtTxt;
  
  public static CBRegisto_AnaliseConcorrencia AnaliseConcorrencia;
  
  public static CBTabela_MarcasProprias MarcasProprias;
  
  public static CBTabela_MarcasOutras MarcasOutras;
  
  public static CBRegisto_AnaliseInterna AnaliseInterna;
  
  public static CBTabela_DR_SNCFixed DR_SNCFixed;
  
  public static CBTabela_DR_SNC DR_SNC;
  
  public static CBTabela_Balanco_SNCFixed Balanco_SNCFixed;
  
  public static CBTabela_Balanco_SNC Balanco_SNC;
  
  public static CBTabela_PTrabalho PTrabalho;
  
  public static CBRegisto_Responsavel Responsavel;
  
  public static CBRegisto_DadosProjecto DadosProjecto;
  
  public static CBTabela_Tipologia Tipologia;
  
  public static CBTabela_ProjCae ProjCae;
  
  public static CBRegisto_Dominios Dominios;
  
  public static CBRegisto_Emp Emp;
  public static CBTabela_Areas Areas;
  public static CBTabela_Capacidade Capacidade;
  public static CBRegisto_DescProj DescProj;
  public static CBTabela_Atividades Atividades;
  public static CBRegisto_DadosAtividade DadosAtividade;
  public static CBRegisto_CritSelA CritSelA;
  public static CBRegisto_CritSelB CritSelB;
  public static CBTabela_DesafiosSocietais DesafiosSocietais;
  public static CBRegisto_DadosDesafioSocietal DadosDesafioSocietal;
  public static CBTabela_DominiosPrioritarios DominiosPrioritarios;
  public static CBRegisto_DadosDominioPrioritario DadosDominioPrioritario;
  public static CBRegisto_CritSelC1 CritSelC1;
  public static CBTabela_DominiosPrioritariosNorte DominiosPrioritariosNorte;
  public static CBTabela_DominiosPrioritariosCentro DominiosPrioritariosCentro;
  public static CBTabela_DominiosPrioritariosLisboa DominiosPrioritariosLisboa;
  public static CBTabela_DominiosPrioritariosAlentejo DominiosPrioritariosAlentejo;
  public static CBTabela_DominiosPrioritariosAlgarve DominiosPrioritariosAlgarve;
  public static CBRegisto_CritSelD2 CritSelD2;
  public static CBTabela_QInv QInv;
  public static CBTabela_QuadrosTecn QuadrosTecn;
  public static CBRegisto_QuadrosTecnTxt QuadrosTecnTxt;
  public static CBTabela_Finan Finan;
  public static CBRegisto_FinanTxt FinanTxt;
  public static CBTabela_IndicCertif IndicCertif;
  public static CBTabela_IndicIDT IndicIDT;
  public static CBRegisto_IndicTxt IndicTxt;
  public static CBRegisto_Uploads Uploads;
  
  public static void setDirty() { dirty = true; }
  public static void resetDirty() { dirty = false; }
  

  public CBData()
  {
    tag = "fme";
    Params = new CBRegisto_Params();
    Decl = new CBRegisto_Decl();
    
    Promotor = new CBRegisto_Promotor();
    Contacto = new CBRegisto_Contacto();
    Consultora = new CBRegisto_Consultora();
    PromCae = new CBTabela_PromCae();
    PromLocal = new CBTabela_PromLocal();
    
    Socios = new CBTabela_Socios();
    Part = new CBTabela_Part();
    Dimensao = new CBRegisto_Dimensao();
    ParamProj = new CBRegisto_ParamProj();
    
    TxtEvolucao = new CBRegisto_Evolucao();
    TxtVisao = new CBRegisto_Visao();
    
    AnaliseMercados = new CBRegisto_AnaliseMercados();
    BensServProj = new CBTabela_BensServProj();
    DadosBensServProj = new CBRegisto_DadosBensServProj();
    Mercados = new CBTabela_Mercados();
    Mercados2 = new CBTabela_Mercados2();
    Mercados3 = new CBTabela_Mercados3();
    VendasExt = new CBTabela_VendasExt();
    VendasExtTxt = new CBRegisto_VendasExtTxt();
    
    AnaliseConcorrencia = new CBRegisto_AnaliseConcorrencia();
    MarcasProprias = new CBTabela_MarcasProprias();
    MarcasOutras = new CBTabela_MarcasOutras();
    
    AnaliseInterna = new CBRegisto_AnaliseInterna();
    

    DR_SNCFixed = new CBTabela_DR_SNCFixed();
    DR_SNC = new CBTabela_DR_SNC();
    DR_SNCfixed_buddy = DR_SNCFixed;
    Balanco_SNCFixed = new CBTabela_Balanco_SNCFixed();
    Balanco_SNC = new CBTabela_Balanco_SNC();
    Balanco_SNCfixed_buddy = Balanco_SNCFixed;
    PTrabalho = new CBTabela_PTrabalho();
    
    Responsavel = new CBRegisto_Responsavel();
    DadosProjecto = new CBRegisto_DadosProjecto();
    Tipologia = new CBTabela_Tipologia();
    ProjCae = new CBTabela_ProjCae();
    
    Dominios = new CBRegisto_Dominios();
    
    Emp = new CBRegisto_Emp();
    Areas = new CBTabela_Areas();
    Capacidade = new CBTabela_Capacidade();
    
    DescProj = new CBRegisto_DescProj();
    
    Atividades = new CBTabela_Atividades();
    DadosAtividade = new CBRegisto_DadosAtividade();
    
    CritSelA = new CBRegisto_CritSelA();
    CritSelB = new CBRegisto_CritSelB();
    

    DesafiosSocietais = new CBTabela_DesafiosSocietais();
    DadosDesafioSocietal = new CBRegisto_DadosDesafioSocietal();
    DominiosPrioritarios = new CBTabela_DominiosPrioritarios();
    DadosDominioPrioritario = new CBRegisto_DadosDominioPrioritario();
    
    CritSelC1 = new CBRegisto_CritSelC1();
    

    DominiosPrioritariosNorte = new CBTabela_DominiosPrioritariosNorte();
    DominiosPrioritariosCentro = new CBTabela_DominiosPrioritariosCentro();
    DominiosPrioritariosLisboa = new CBTabela_DominiosPrioritariosLisboa();
    DominiosPrioritariosAlentejo = new CBTabela_DominiosPrioritariosAlentejo();
    DominiosPrioritariosAlgarve = new CBTabela_DominiosPrioritariosAlgarve();
    
    CritSelD2 = new CBRegisto_CritSelD2();
    
    Finan = new CBTabela_Finan();
    FinanTxt = new CBRegisto_FinanTxt();
    
    QInv = new CBTabela_QInv();
    
    QuadrosTecn = new CBTabela_QuadrosTecn();
    QuadrosTecnTxt = new CBRegisto_QuadrosTecnTxt();
    
    IndicCertif = new CBTabela_IndicCertif();
    IndicIDT = new CBTabela_IndicIDT();
    IndicTxt = new CBRegisto_IndicTxt();
    










    Uploads = new CBRegisto_Uploads();
    

    xml_dh = new XMLParser(this);
    xml_parser = xml_dh;
    

    Params.init();
    Atividades.after_update();
    

    bind_updates();
  }
  



  static void bind_updates() {}
  


  static void extract()
  {
    if ((Promotor != null) && (Promotorstarted)) Promotor.extract();
    if ((Responsavel != null) && (Responsavelstarted)) Responsavel.extract();
    if ((DadosProjecto != null) && (DadosProjectostarted)) DadosProjecto.extract();
    if ((DescProj != null) && (DescProjstarted)) DescProj.extract();
    if ((ParamProj != null) && (ParamProjstarted)) ParamProj.extract();
    if ((Emp != null) && (Empstarted)) Emp.extract();
    if ((DadosAtividade != null) && (DadosAtividadestarted)) DadosAtividade.extract();
    if ((DadosDesafioSocietal != null) && (DadosDesafioSocietalstarted)) DadosDesafioSocietal.extract();
    if ((DadosDominioPrioritario != null) && (DadosDominioPrioritariostarted)) DadosDominioPrioritario.extract();
    if ((DadosBensServProj != null) && (DadosBensServProjstarted)) DadosBensServProj.extract();
  }
  
  static void Clear() {
    is_cleaning = true;
    exportado = "0";
    T = "";
    if (!fmeApp.in_pas) {
      reg_nif = "";
      reg_C = "";
      reg_pas = "";
    }
    ficheiro = "0";
    
    turismo = "0";
    cae = "";
    investimento = "";
    elegivel = "";
    

    perc_internac = "";
    nuts_ii_norte = "";
    nuts_ii_centro = "";
    nuts_ii_lisboa = "";
    nuts_ii_alentejo = "";
    nuts_ii_algarve = "";
    
    fmeApp.contexto = "menu";
    
    LastFile = null;
    
    __garbage_stop_editing();
    
    for (int i = 0; i < fmeApp.Paginas.size(); i++) {
      Pagina_Base p = (Pagina_Base)fmeApp.Paginas.getPage(i);
      p.clear_page();
    }
    CTabelas.clear();
    resetDirty();
    is_cleaning = false;
  }
  
  static void before_open() {
    reading_xml = true;
  }
  
  static void after_open() {
    reading_xml = false;
    
    compara_vs();
    if (exportado.equals("")) exportado = "0";
    if (ficheiro.equals("")) { ficheiro = "0";
    }
    

    if (Paramsstarted) Params.after_open();
    if (DadosProjectostarted) { DadosProjecto.after_open();
    }
    after_open_txt_limite();
    
    if (Tipologiastarted) Tipologia.after_open();
    if (Mercadosstarted) Mercados.calc_mercados();
    if (Uploadsstarted) { Uploads.after_open();
    }
    if (CritSelBstarted) { CritSelB.after_open();
    }
    import_data_adc();
    Consultora.after_open();
    

    if (PromCaestarted) {
      PromCaehandler.j.revalidate();
      PromCaehandler.j.repaint();
    }
    if (PromLocalstarted) {
      PromLocalhandler.j.revalidate();
      PromLocalhandler.j.repaint();
    }
    if (Sociosstarted) {
      Socioshandler.j.revalidate();
      Socioshandler.j.repaint();
    }
    if (Partstarted) {
      Parthandler.j.revalidate();
      Parthandler.j.repaint();
    }
    if (Mercadosstarted) {
      Mercadoshandler.j.revalidate();
      Mercadoshandler.j.repaint();
    }
    if (VendasExtstarted) {
      VendasExthandler.j.revalidate();
      VendasExthandler.j.repaint();
    }
    if (MarcasPropriasstarted) {
      MarcasPropriashandler.j.revalidate();
      MarcasPropriashandler.j.repaint();
    }
    if (MarcasOutrasstarted) {
      MarcasOutrashandler.j.revalidate();
      MarcasOutrashandler.j.repaint();
    }
    



    if (DR_SNCstarted) {
      DR_SNChandler.j.revalidate();
      DR_SNChandler.j.repaint();
    }
    if (Balanco_SNCstarted) {
      Balanco_SNChandler.j.revalidate();
      Balanco_SNChandler.j.repaint();
    }
    if (PTrabalhostarted) {
      PTrabalhohandler.j.revalidate();
      PTrabalhohandler.j.repaint();
    }
    if (Tipologiastarted) {
      Tipologiahandler.j.revalidate();
      Tipologiahandler.j.repaint();
    }
    if (ProjCaestarted) {
      ProjCaehandler.j.revalidate();
      ProjCaehandler.j.repaint();
    }
    if (Areasstarted) {
      Areashandler.j.revalidate();
      Areashandler.j.repaint();
    }
    if (Capacidadestarted) {
      Capacidadehandler.j.revalidate();
      Capacidadehandler.j.repaint();
    }
    if (Atividadesstarted) {
      Atividadeshandler.j.revalidate();
      Atividadeshandler.j.repaint();
      Atividades.after_update();
    }
    



    if (DesafiosSocietaisstarted) {
      DesafiosSocietaishandler.j.revalidate();
      DesafiosSocietaishandler.j.repaint();
    }
    if (DominiosPrioritariosstarted) {
      DominiosPrioritarioshandler.j.revalidate();
      DominiosPrioritarioshandler.j.repaint();
    }
    if (DominiosPrioritariosNortestarted) {
      DominiosPrioritariosNortehandler.j.revalidate();
      DominiosPrioritariosNortehandler.j.repaint();
    }
    if (DominiosPrioritariosCentrostarted) {
      DominiosPrioritariosCentrohandler.j.revalidate();
      DominiosPrioritariosCentrohandler.j.repaint();
    }
    if (DominiosPrioritariosLisboastarted) {
      DominiosPrioritariosLisboahandler.j.revalidate();
      DominiosPrioritariosLisboahandler.j.repaint();
    }
    if (DominiosPrioritariosAlentejostarted) {
      DominiosPrioritariosAlentejohandler.j.revalidate();
      DominiosPrioritariosAlentejohandler.j.repaint();
    }
    if (DominiosPrioritariosAlgarvestarted) {
      DominiosPrioritariosAlgarvehandler.j.revalidate();
      DominiosPrioritariosAlgarvehandler.j.repaint();
    }
    if (QInvstarted) {
      QInvhandler.j.revalidate();
      QInvhandler.j.repaint();
    }
    if (QuadrosTecnstarted) {
      QuadrosTecnhandler.j.revalidate();
      QuadrosTecnhandler.j.repaint();
    }
    if (Finanstarted) {
      Finanhandler.j.revalidate();
      Finanhandler.j.repaint();
    }
    if (IndicCertifstarted) {
      IndicCertifhandler.j.revalidate();
      IndicCertifhandler.j.repaint();
    }
    if (IndicIDTstarted) {
      IndicIDThandler.j.revalidate();
      IndicIDThandler.j.repaint();
    }
    

















    resetDirty();
    
    fmeApp.toolBar.check_registo();
    
    fmeApp.toolBar.setPopupOpt();
  }
  
  static void after_open_txt_limite() {
    if (Paramsstarted) Params.on_update("txt_resumo");
    if (Declstarted) Decl.after_open();
    if (TxtEvolucaostarted) TxtEvolucao.on_update("texto");
    if (TxtVisaostarted) TxtVisao.on_update("texto");
    if (AnaliseConcorrenciastarted) AnaliseConcorrencia.on_update("txt_descricao");
    if (AnaliseInternastarted) AnaliseInterna.after_open();
    if (AnaliseMercadosstarted) AnaliseMercados.after_open();
    if (VendasExtTxtstarted) VendasExtTxt.after_open();
    if (DadosProjectostarted) DadosProjecto.on_update("fundamento");
    if (DadosProjectostarted) DadosProjecto.on_update("txt_fse");
    if (DescProjstarted) { DescProj.on_update("texto");
    }
    if (CritSelAstarted) CritSelA.after_open();
    if (CritSelC1started) { CritSelC1.after_open();
    }
    if (CritSelD2started) CritSelD2.after_open();
    if (TxtEvolucaostarted) TxtEvolucao.on_update("texto");
    if (QuadrosTecnTxtstarted) QuadrosTecnTxt.on_update("texto");
    if (FinanTxtstarted) FinanTxt.on_update("texto");
    if (IndicTxtstarted) IndicTxt.on_update("texto");
  }
  
  static void import_data_adc() {
    String url = fmeComum.atend_pas + "acesso/formulario/atend-import-adc.php?NIF=" + reg_nif;
    import_data_adc(url);
  }
  
  static void import_data_adc(String url) {
    if (url == "") return;
    if (!T.equals("")) { return;
    }
    System.out.println("promotor " + reg_nif);
    
    boolean read_caes = false;
    
    Http http = new Http(url);
    Document doc = http.doPostRequestDoc("");
    try
    {
      PromCae.before_get_dados_adc();
      

      XPath xp = XPathFactory.newInstance().newXPath();
      for (XMLParser.xml_tag_handler th : cbxml_dh.tlist) {
        if (((handler instanceof CBTabela)) && 
          (xp.evaluate(path, doc, XPathConstants.NODE) != null)) {
          if (path.equals("//fme/PromCae")) read_caes = true;
          CBTabela cbt = (CBTabela)handler;
          if ((handler instanceof CHTabQuadro))
          {
            for (int n = 0; n < cols.length; n++) {
              if ((cols[n].editable) && (xp.evaluate(path + "/Reg/" + 
                cols[n].col_tag, doc, XPathConstants.NODE) != null)) {
                for (int i = 0; i < dados.size(); i++) {
                  ((String[])dados.elementAt(i))[n] = "";
                }
              }
            }
          } else if ((handler instanceof CHTabela)) {
            cbt.Clear();
          }
        }
      }
      

      DOMSource source = new DOMSource(doc);
      StringWriter xmlWriter = new StringWriter();
      StreamResult result = new StreamResult(xmlWriter);
      TransformerFactory.newInstance().newTransformer().transform(source, result);
      InputSource input = new InputSource(new StringReader(xmlWriter.toString()));
      SAXParserFactory.newInstance().newSAXParser().parse(input, new CParse());
      
      if (read_caes) { PromCae.after_get_dados_adc();
      }
      if (!DimensaogetByName"dimensao"v.matches("1|2|3|4"))
        Dimensao.Clear();
      Dimensao.on_update("dimensao");
    }
    catch (Exception e)
    {
      e.printStackTrace();
    }
  }
  
  static void compara_vs()
  {
    if (vs_old.compareTo(vs) > 0) {
      String msg = "O ficheiro de candidatura que abriu é de uma versão posterior (" + 
        vs_old + ") à do formulário (" + vs + 
        ").\nPoderão ocorrer alguns problemas!";
      JOptionPane.showMessageDialog(null, msg, "Aviso", 2);
    }
  }
  
  public String xmlPrint()
  {
    String xml = "\n<Header>\n";
    xml = xml + "<fme-config>" + fmeApp.Config + "</fme-config>\n";
    xml = xml + "<aviso>" + CParseConfig.hconfig.get("aviso") + "</aviso>\n";
    xml = xml + "<extensao>" + CParseConfig.hconfig.get("extensao") + "</extensao>\n";
    xml = xml + "<vs>" + vs + "</vs>\n";
    xml = xml + "<exportado>" + exportado + "</exportado>\n";
    xml = xml + "<T>" + T + "</T>\n";
    xml = xml + "<Reg_nif>" + reg_nif + "</Reg_nif>\n";
    xml = xml + "<Reg_C>" + reg_C + "</Reg_C>\n";
    xml = xml + "<Reg_pas>" + reg_pas + "</Reg_pas>\n";
    
    xml = xml + "</Header>\n";
    xml = xml + "<Resumo>\n";
    xml = xml + _lib.xml_encode("nif", PromotorgetByName"nif"v);
    xml = xml + _lib.xml_encode("nome", PromotorgetByName"nome"v);
    if (ContactogetByName"contacto"v.equals("N")) {
      xml = xml + _lib.xml_encode("morada", PromotorgetByName"morada"v);
      xml = xml + _lib.xml_encode("localidade", PromotorgetByName"localidade"v);
      xml = xml + _lib.xml_encode("cod_postal", PromotorgetByName"cod_postal"v);
      xml = xml + _lib.xml_encode("cod_postal_loc", PromotorgetByName"cod_postal_loc"v);
      xml = xml + _lib.xml_encode("distrito", PromotorgetByName"distrito"v);
      if (PromotorgetByName"distrito"v.length() > 0) {
        xml = xml + _lib.xml_encode("distrito_d", CTabelas.Distritos.getDesign(PromotorgetByName"distrito"v));
      } else
        xml = xml + "<distrito_d/>\n";
      xml = xml + _lib.xml_encode("concelho", PromotorgetByName"concelho"v);
      if (PromotorgetByName"concelho"v.length() > 0) {
        xml = xml + _lib.xml_encode("concelho_d", CTabelas.Concelhos.getDesign(PromotorgetByName"concelho"v));
      } else
        xml = xml + "<concelho_d/>\n";
    } else {
      xml = xml + _lib.xml_encode("morada", ContactogetByName"morada"v);
      xml = xml + _lib.xml_encode("localidade", ContactogetByName"localidade"v);
      xml = xml + _lib.xml_encode("cod_postal", ContactogetByName"cod_postal"v);
      xml = xml + _lib.xml_encode("cod_postal_loc", ContactogetByName"cod_postal_loc"v);
      xml = xml + _lib.xml_encode("distrito", ContactogetByName"distrito"v);
      if (ContactogetByName"distrito"v.length() > 0) {
        xml = xml + _lib.xml_encode("distrito_d", CTabelas.Distritos.getDesign(ContactogetByName"distrito"v));
      } else
        xml = xml + "<distrito_d/>\n";
      xml = xml + _lib.xml_encode("concelho", ContactogetByName"concelho"v);
      if (ContactogetByName"concelho"v.length() > 0) {
        xml = xml + _lib.xml_encode("concelho_d", CTabelas.Concelhos.getDesign(ContactogetByName"concelho"v));
      } else
        xml = xml + "<concelho_d/>\n";
    }
    xml = xml + _lib.xml_encode("resp_nome", ResponsavelgetByName"nome"v);
    xml = xml + _lib.xml_encode("resp_funcao", ResponsavelgetByName"funcao"v);
    xml = xml + _lib.xml_encode("resp_email", ResponsavelgetByName"email"v);
    xml = xml + _lib.xml_encode("resp_telemovel", ResponsavelgetByName"telemovel"v);
    xml = xml + _lib.xml_encode("cae", cae);
    xml = xml + _lib.xml_encode("investimento", investimento);
    xml = xml + _lib.xml_encode("elegivel", elegivel);
    xml = xml + _lib.xml_encode("dimensao", DimensaogetByName"dimensao"v);
    xml = xml + _lib.xml_encode("lst_po", ParamsgetByName"aut_gestao"v);
    xml = xml + _lib.xml_encode("ot", ParamsgetByName"obj_tema"v);
    xml = xml + _lib.xml_encode("pi", ParamsgetByName"prioridade"v);
    xml = xml + _lib.xml_encode("ti", ParamsgetByName"tipologia"v);
    xml = xml + "<conjuntos_reg/>\n";
    xml = xml + "<conjuntos_nute/>\n";
    xml = xml + _lib.xml_encode("internacional", perc_internac);
    xml = xml + _lib.xml_encode("icep_75", ParamProjgetByName"param_1"v);
    xml = xml + _lib.xml_encode("turismo", new StringBuilder(String.valueOf(_lib.round4(_lib.to_double(turismo) / 100.0D))).toString());
    xml = xml + _lib.xml_encode("nute_norte", new StringBuilder(String.valueOf(_lib.round4(_lib.to_double(nuts_ii_norte) / 100.0D))).toString());
    xml = xml + _lib.xml_encode("nute_centro", new StringBuilder(String.valueOf(_lib.round4(_lib.to_double(nuts_ii_centro) / 100.0D))).toString());
    xml = xml + _lib.xml_encode("nute_lisboa", new StringBuilder(String.valueOf(_lib.round4(_lib.to_double(nuts_ii_lisboa) / 100.0D))).toString());
    xml = xml + _lib.xml_encode("nute_alentejo", new StringBuilder(String.valueOf(_lib.round4(_lib.to_double(nuts_ii_alentejo) / 100.0D))).toString());
    xml = xml + _lib.xml_encode("nute_algarve", new StringBuilder(String.valueOf(_lib.round4(_lib.to_double(nuts_ii_algarve) / 100.0D))).toString());
    if (PTrabalhostarted) {
      xml = xml + _lib.xml_encode("n_pt_pos", new StringBuilder(String.valueOf((int)PTrabalho.getSum("val_tt_pos"))).toString());
    } else {
      xml = xml + _lib.xml_encode("n_pt_pos", "");
    }
    
    xml = xml + _lib.xml_encode("dt_inicio_act", PromotorgetByName"dt_inicio_act"v);
    xml = xml + "<email_export>";
    xml = xml + PromotorgetByName"email"v;
    if ((ContactogetByName"contacto"v.equals("S")) && 
      (PromotorgetByName"email"v.compareTo(ContactogetByName"email"v) != 0) && 
      (ContactogetByName"email"v.compareTo("") != 0))
      xml = xml + "," + ContactogetByName"email"v;
    if ((ResponsavelgetByName"email"v.compareTo("") != 0) && 
      (ResponsavelgetByName"email"v.compareTo(PromotorgetByName"email"v) != 0) && 
      (ResponsavelgetByName"email"v.compareTo(ContactogetByName"email"v) != 0))
    {
      xml = xml + "," + ResponsavelgetByName"email"v; }
    xml = xml + "</email_export>\n";
    xml = xml + "</Resumo>\n";
    return xml;
  }
  
  public void xmlValue(String path, String tag, String v) {
    if (tag.equals("exportado")) exportado = v;
    if (tag.equals("T")) T = v;
    if (tag.equals("Reg_nif")) reg_nif = v;
    if (tag.equals("Reg_C")) reg_C = v;
    if (tag.equals("Reg_pas")) reg_pas = v;
    if (tag.equals("ficheiro")) ficheiro = v;
    if (tag.equals("vs")) vs_old = v;
    if (tag.equals("fme-config")) { config_old = v;
    }
    if ((((String)CParseConfig.hconfig.get("reg_especial")).equals("1")) && (config_old.equals("fme-config-23.xml")))
      config_old = (String)CParseConfig.hconfig.get("fme-config");
  }
  
  static void __garbage_stop_editing() {
    if ((PromCae != null) && (PromCaestarted))
      PromCaehandler.__garbage_stop_editing();
    if ((PromLocal != null) && (PromLocalstarted))
      PromLocalhandler.__garbage_stop_editing();
    if ((Socios != null) && (Sociosstarted))
      Socioshandler.__garbage_stop_editing();
    if ((Part != null) && (Partstarted))
      Parthandler.__garbage_stop_editing();
    if ((BensServProj != null) && (BensServProjstarted))
      BensServProjhandler.__garbage_stop_editing();
    if ((Mercados != null) && (Mercadosstarted))
      Mercadoshandler.__garbage_stop_editing();
    if ((VendasExt != null) && (VendasExtstarted))
      VendasExthandler.__garbage_stop_editing();
    if ((MarcasProprias != null) && (MarcasPropriasstarted))
      MarcasPropriashandler.__garbage_stop_editing();
    if ((MarcasOutras != null) && (MarcasOutrasstarted)) {
      MarcasOutrashandler.__garbage_stop_editing();
    }
    
    if ((DR_SNC != null) && (DR_SNCstarted))
      DR_SNChandler.__garbage_stop_editing();
    if ((Balanco_SNC != null) && (Balanco_SNCstarted))
      Balanco_SNChandler.__garbage_stop_editing();
    if ((PTrabalho != null) && (PTrabalhostarted))
      PTrabalhohandler.__garbage_stop_editing();
    if ((Tipologia != null) && (Tipologiastarted))
      Tipologiahandler.__garbage_stop_editing();
    if ((ProjCae != null) && (ProjCaestarted))
      ProjCaehandler.__garbage_stop_editing();
    if ((Areas != null) && (Areasstarted))
      Areashandler.__garbage_stop_editing();
    if ((Capacidade != null) && (Capacidadestarted))
      Capacidadehandler.__garbage_stop_editing();
    if ((Atividades != null) && (Atividadesstarted)) {
      Atividadeshandler.__garbage_stop_editing();
    }
    
    if ((DesafiosSocietais != null) && (DesafiosSocietaisstarted))
      DesafiosSocietaishandler.__garbage_stop_editing();
    if ((DominiosPrioritarios != null) && (DominiosPrioritariosstarted))
      DominiosPrioritarioshandler.__garbage_stop_editing();
    if ((DominiosPrioritariosNorte != null) && (DominiosPrioritariosNortestarted))
      DominiosPrioritariosNortehandler.__garbage_stop_editing();
    if ((DominiosPrioritariosCentro != null) && (DominiosPrioritariosCentrostarted))
      DominiosPrioritariosCentrohandler.__garbage_stop_editing();
    if ((DominiosPrioritariosLisboa != null) && (DominiosPrioritariosLisboastarted))
      DominiosPrioritariosLisboahandler.__garbage_stop_editing();
    if ((DominiosPrioritariosAlentejo != null) && (DominiosPrioritariosAlentejostarted))
      DominiosPrioritariosAlentejohandler.__garbage_stop_editing();
    if ((DominiosPrioritariosAlgarve != null) && (DominiosPrioritariosAlgarvestarted)) {
      DominiosPrioritariosAlgarvehandler.__garbage_stop_editing();
    }
    if ((QInv != null) && (QInvstarted))
      QInvhandler.__garbage_stop_editing();
    if ((QuadrosTecn != null) && (QuadrosTecnstarted))
      QuadrosTecnhandler.__garbage_stop_editing();
    if ((Finan != null) && (Finanstarted))
      Finanhandler.__garbage_stop_editing();
    if ((IndicCertif != null) && (IndicCertifstarted))
      IndicCertifhandler.__garbage_stop_editing();
    if ((IndicIDT != null) && (IndicIDTstarted)) {
      IndicIDThandler.__garbage_stop_editing();
    }
    
















    if (CHCampo_InputVerifier.editing != null) {
      CHCampo_InputVerifier.editing.cancel_editing();
    }
  }
}
