package fme;

import java.util.Vector;
import javax.swing.JOptionPane;



public class CTabelas
{
  static Vector Tabelas = new Vector();
  
  static CTabela Escala1a5;
  
  static CTabela SimNao;
  
  static CTabela Genero;
  
  static CTabela Dimensao;
  
  static CTabela POs;
  
  static CTabela ObjTematico;
  
  static CTabela PrioridadeInvest;
  
  static CTabela TipologiaInterv;
  
  static CTabela Distritos;
  
  static CTabela Concelhos;
  
  static CTabela Freguesias;
  
  static CTabela NUTS_II;
  
  static CTabela Pais;
  
  static CTabela Cae;
  
  static CTabela SistemaIncentivos;
  
  static CTabela Modalidades;
  
  static CTabela NatJuridica;
  
  static CTabela TipoPart;
  static CTabela AreasFunc;
  static CTabela AreasInv;
  static CTabela TipoMercado;
  static CTabela Mercado;
  static CTabela BensServicos;
  static CTabela NiveisQual;
  static CTabela NivelEtario;
  static CTabela GrupoEmpreend;
  static CTabela Empreendimentos;
  static CTabela RegimeConstrucao;
  static CTabela ImpCustos;
  static CTabela RubricasSNC;
  static CTabela TipoDesp;
  static CTabela TipoProj;
  static CTabela ObjectivosDom;
  static CTabela TipoRPI;
  static CTabela TipoRegisto;
  static CTabela TipoInovacao;
  static CTabela GrauNovidade;
  static CTabela Sustentacao;
  static CTabela PercepcaoMercado;
  static CTabela ImpactoFinanceiro;
  static CTabela DesafiosSocietais;
  static CTabela LinhasAtuacao;
  static CTabela ENEIDominio;
  static CTabela ENEIArea;
  static CTabelaF1 ENEIAreaF1;
  static CTabela ENEIDominioLisboa;
  static CTabela ENEIAreaLisboa;
  static CTabelaF1 ENEIAreaLisboaF1;
  static CTabela ENEIDominioAlgarve;
  static CTabela ENEIAreaAlgarve;
  static CTabelaF1 ENEIAreaAlgarveF1;
  static CTabela ENEIDominioCentro;
  static CTabela ENEIAreaCentro;
  static CTabelaF1 ENEIAreaCentroF1;
  static CTabela ENEIDominioNorte;
  static CTabela ENEIDominioAlentejo;
  static CTabela B1Mercados;
  static CTabela B1Clientes;
  static CTabela B1Produtos;
  static CTabela NiveisCursos;
  static CTabela EntidadeCertif;
  static CTabela AreasFormacao;
  static CTabela OrigemFormadores;
  static CTabela EEC;
  static CEECs EECProvere;
  static CTabelaF1 ConcelhosF1;
  static CTabelaF2 ConcelhosF2;
  static CTabelaF1 FreguesiasF1;
  static CTabelaF1 EmpreendimentosF1;
  static CTabelaF1 LinhasAtuacaoF1;
  static CEstabs Estabs;
  static CTabelaF1 EstabsF1;
  static CAtividades Atividades;
  static CTabelaF1 FormadoresF1;
  static CTabela TipoFormador;
  static CTabela TipoFormando;
  static CNUTS_II_Continente NUTS_II_Continente;
  
  public CTabelas()
  {
    Tabelas.addElement(CTabelas.POs = new CTabela("PO"));
    Tabelas.addElement(CTabelas.ObjTematico = new CTabela("ObjTematico"));
    Tabelas.addElement(CTabelas.PrioridadeInvest = new CTabela("PrioridadeInvest"));
    Tabelas.addElement(CTabelas.TipologiaInterv = new CTabela("TipologiaInterv"));
    
    Tabelas.addElement(CTabelas.Dimensao = new CTabela("Dimensao"));
    Tabelas.addElement(CTabelas.Escala1a5 = new CTabela("Escala-1a5"));
    Tabelas.addElement(CTabelas.SimNao = new CTabela("SimNao"));
    Tabelas.addElement(CTabelas.Genero = new CTabela("Genero"));
    Tabelas.addElement(CTabelas.Distritos = new CTabela("Distritos"));
    Tabelas.addElement(CTabelas.Concelhos = new CTabela("Concelhos"));
    Tabelas.addElement(CTabelas.Freguesias = new CTabela("Freguesias"));
    Tabelas.addElement(CTabelas.NUTS_II = new CTabela("NUTS_II"));
    Tabelas.addElement(CTabelas.Pais = new CTabela("Pais"));
    Tabelas.addElement(CTabelas.Cae = new CTabela("Cae"));
    
    Tabelas.addElement(CTabelas.SistemaIncentivos = new CTabela("SistemaIncentivos"));
    Tabelas.addElement(CTabelas.Modalidades = new CTabela("Modalidades"));
    
    Tabelas.addElement(CTabelas.NatJuridica = new CTabela("NatJuridica"));
    Tabelas.addElement(CTabelas.TipoPart = new CTabela("TipoPart"));
    Tabelas.addElement(CTabelas.AreasFunc = new CTabela("AreasFunc"));
    Tabelas.addElement(CTabelas.AreasInv = new CTabela("AreasInv"));
    Tabelas.addElement(CTabelas.TipoMercado = new CTabela("TipoMercado"));
    Tabelas.addElement(CTabelas.Mercado = new CTabela("Mercado"));
    Tabelas.addElement(CTabelas.BensServicos = new CTabela("BensServicos"));
    Tabelas.addElement(CTabelas.NiveisQual = new CTabela("NiveisQual"));
    Tabelas.addElement(CTabelas.NivelEtario = new CTabela("NivelEtario"));
    Tabelas.addElement(CTabelas.RubricasSNC = new CTabela("RubricasSNC"));
    Tabelas.addElement(CTabelas.TipoDesp = new CTabela("TipoDesp"));
    
    Tabelas.addElement(CTabelas.Empreendimentos = new CTabela("Empreendimentos"));
    Tabelas.addElement(CTabelas.GrupoEmpreend = new CTabela("GrupoEmpreend"));
    Tabelas.addElement(CTabelas.RegimeConstrucao = new CTabela("RegimeConstrucao"));
    Tabelas.addElement(CTabelas.ImpCustos = new CTabela("ImpCustos"));
    
    Tabelas.addElement(CTabelas.ObjectivosDom = new CTabela("ObjectivosDom"));
    Tabelas.addElement(CTabelas.TipoRPI = new CTabela("TipoRPI"));
    Tabelas.addElement(CTabelas.TipoRegisto = new CTabela("TipoRegisto"));
    
    Tabelas.addElement(CTabelas.EEC = new CTabela("EEC"));
    
    Tabelas.addElement(CTabelas.NiveisCursos = new CTabela("NiveisCursos"));
    Tabelas.addElement(CTabelas.EntidadeCertif = new CTabela("EntidadeCertif"));
    Tabelas.addElement(CTabelas.AreasFormacao = new CTabela("AreasFormacao"));
    Tabelas.addElement(CTabelas.OrigemFormadores = new CTabela("OrigemFormadores"));
    
    Tabelas.addElement(CTabelas.TipoInovacao = new CTabela("TipoInovacao"));
    Tabelas.addElement(CTabelas.GrauNovidade = new CTabela("GrauNovidade"));
    Tabelas.addElement(CTabelas.Sustentacao = new CTabela("Sustentacao"));
    Tabelas.addElement(CTabelas.PercepcaoMercado = new CTabela("PercepcaoMercado"));
    Tabelas.addElement(CTabelas.ImpactoFinanceiro = new CTabela("ImpactoFinanceiro"));
    
    Tabelas.addElement(CTabelas.DesafiosSocietais = new CTabela("DesafiosSocietais"));
    Tabelas.addElement(CTabelas.LinhasAtuacao = new CTabela("LinhasAtuacao"));
    
    Tabelas.addElement(CTabelas.ENEIDominio = new CTabela("ENEIDominio"));
    Tabelas.addElement(CTabelas.ENEIArea = new CTabela("ENEIArea"));
    Tabelas.addElement(CTabelas.ENEIAreaF1 = new CTabelaF1(ENEIArea));
    
    Tabelas.addElement(CTabelas.ENEIDominioLisboa = new CTabela("ENEIDominioLisboa"));
    Tabelas.addElement(CTabelas.ENEIAreaLisboa = new CTabela("ENEIAreaLisboa"));
    Tabelas.addElement(CTabelas.ENEIAreaLisboaF1 = new CTabelaF1(ENEIAreaLisboa));
    
    Tabelas.addElement(CTabelas.ENEIDominioAlgarve = new CTabela("ENEIDominioAlgarve"));
    Tabelas.addElement(CTabelas.ENEIAreaAlgarve = new CTabela("ENEIAreaAlgarve"));
    Tabelas.addElement(CTabelas.ENEIAreaAlgarveF1 = new CTabelaF1(ENEIAreaAlgarve));
    
    Tabelas.addElement(CTabelas.ENEIDominioCentro = new CTabela("ENEIDominioCentro"));
    Tabelas.addElement(CTabelas.ENEIAreaCentro = new CTabela("ENEIAreaCentro"));
    Tabelas.addElement(CTabelas.ENEIAreaCentroF1 = new CTabelaF1(ENEIAreaCentro));
    
    Tabelas.addElement(CTabelas.ENEIDominioNorte = new CTabela("ENEIDominioNorte"));
    Tabelas.addElement(CTabelas.ENEIDominioAlentejo = new CTabela("ENEIDominioAlentejo"));
    Tabelas.addElement(CTabelas.B1Mercados = new CTabela("B1Mercados"));
    Tabelas.addElement(CTabelas.B1Clientes = new CTabela("B1Clientes"));
    Tabelas.addElement(CTabelas.B1Produtos = new CTabela("B1Produtos"));
    

    Tabelas.addElement(CTabelas.ConcelhosF1 = new CTabelaF1(Concelhos));
    Tabelas.addElement(CTabelas.ConcelhosF2 = new CTabelaF2(Concelhos));
    Tabelas.addElement(CTabelas.FreguesiasF1 = new CTabelaF1(Freguesias));
    Tabelas.addElement(CTabelas.EmpreendimentosF1 = new CTabelaF1(Empreendimentos));
    Tabelas.addElement(CTabelas.LinhasAtuacaoF1 = new CTabelaF1(LinhasAtuacao));
    Tabelas.addElement(CTabelas.ENEIAreaF1 = new CTabelaF1(ENEIArea));
    

    Tabelas.addElement(CTabelas.Estabs = new CEstabs());
    Tabelas.addElement(CTabelas.EstabsF1 = new CTabelaF1(Estabs));
    
    Tabelas.addElement(CTabelas.Atividades = new CAtividades());
    
    Tabelas.addElement(CTabelas.TipoFormador = new CTabela("TipoFormador"));
    Tabelas.addElement(CTabelas.TipoFormando = new CTabela("TipoFormando"));
  }
  
  public static void clear()
  {
    Estabsdata_table.removeAllElements();
    EstabsF1data_table.removeAllElements();
  }
  


  public static void mount_cfg_table(String id, String filename)
  {
    if (id.equals("TipoProj"))
      Tabelas.addElement(CTabelas.TipoProj = new CTabela(id, filename));
    if (id.equals("EECProvere")) {
      Tabelas.addElement(CTabelas.EECProvere = new CEECs(id, filename));
    }
  }
  
  public static CTabela getTabByName(String _name)
  {
    for (int i = 0; i < Tabelas.size(); i++) {
      CTabela ctab = (CTabela)Tabelas.elementAt(i);
      if (name.equals(_name))
        return ctab;
    }
    JOptionPane.showMessageDialog(null, "tabela " + _name + " ?");
    return null;
  }
}
