package fme;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.PrintStream;
import java.util.Random;
import java.util.Stack;
import java.util.Vector;
import java.util.zip.ZipEntry;
import java.util.zip.ZipInputStream;
import java.util.zip.ZipOutputStream;
import javax.swing.JOptionPane;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import org.xml.sax.helpers.DefaultHandler;
































































































































































































class XMLParser
{
  Vector tlist = new Vector();
  Stack stk = new Stack();
  XMLDataHandler cdata;
  
  class xml_tag_handler {
    public String path;
    public XMLDataHandler handler;
    
    xml_tag_handler(String p, XMLDataHandler o) {
      path = p;
      handler = o;
    }
  }
  
  XMLParser(CBData_Noconfig d) {
    cdata = d;
    
    tlist.add(new xml_tag_handler("//fme", d));
  }
  
  XMLParser(CBData d) {
    cdata = d;
    
    tlist.add(new xml_tag_handler("//fme", d));
    
    tlist.add(new xml_tag_handler("//fme/Parametros", CBData.Params));
    tlist.add(new xml_tag_handler("//fme/Declaracoes", CBData.Decl));
    
    tlist.add(new xml_tag_handler("//fme/Promotor", CBData.Promotor));
    tlist.add(new xml_tag_handler("//fme/Contacto", CBData.Contacto));
    tlist.add(new xml_tag_handler("//fme/Consultora", CBData.Consultora));
    tlist.add(new xml_tag_handler("//fme/PromCae", CBData.PromCae));
    tlist.add(new xml_tag_handler("//fme/PromLocal", CBData.PromLocal));
    
    tlist.add(new xml_tag_handler("//fme/Socios", CBData.Socios));
    tlist.add(new xml_tag_handler("//fme/Part", CBData.Part));
    tlist.add(new xml_tag_handler("//fme/Dimensao", CBData.Dimensao));
    tlist.add(new xml_tag_handler("//fme/ParamProj", CBData.ParamProj));
    
    tlist.add(new xml_tag_handler("//fme/TxtEvolucao", CBData.TxtEvolucao));
    tlist.add(new xml_tag_handler("//fme/TxtVisao", CBData.TxtVisao));
    
    tlist.add(new xml_tag_handler("//fme/AnaliseConcorrencia", CBData.AnaliseConcorrencia));
    tlist.add(new xml_tag_handler("//fme/MarcasProprias", CBData.MarcasProprias));
    tlist.add(new xml_tag_handler("//fme/MarcasOutras", CBData.MarcasOutras));
    
    tlist.add(new xml_tag_handler("//fme/AnaliseInterna", CBData.AnaliseInterna));
    

    tlist.add(new xml_tag_handler("//fme/AnaliseMercados", CBData.AnaliseMercados));
    tlist.add(new xml_tag_handler("//fme/BensServProj", CBData.BensServProj));
    tlist.add(new xml_tag_handler("//fme/Mercados", CBData.Mercados));
    tlist.add(new xml_tag_handler("//fme/Mercados2", CBData.Mercados2));
    tlist.add(new xml_tag_handler("//fme/Mercados3", CBData.Mercados3));
    tlist.add(new xml_tag_handler("//fme/VendasExt", CBData.VendasExt));
    tlist.add(new xml_tag_handler("//fme/TxtVendasExt", CBData.VendasExtTxt));
    
    tlist.add(new xml_tag_handler("//fme/Balanco_SNC", CBData.Balanco_SNC));
    tlist.add(new xml_tag_handler("//fme/DR_SNC", CBData.DR_SNC));
    tlist.add(new xml_tag_handler("//fme/PTrabalho", CBData.PTrabalho));
    
    tlist.add(new xml_tag_handler("//fme/Responsavel", CBData.Responsavel));
    tlist.add(new xml_tag_handler("//fme/DadosProjecto", CBData.DadosProjecto));
    tlist.add(new xml_tag_handler("//fme/Tipologia", CBData.Tipologia));
    tlist.add(new xml_tag_handler("//fme/ProjCae", CBData.ProjCae));
    
    tlist.add(new xml_tag_handler("//fme/Dominios", CBData.Dominios));
    
    tlist.add(new xml_tag_handler("//fme/DescFisicaEmp", CBData.Emp));
    tlist.add(new xml_tag_handler("//fme/Areas", CBData.Areas));
    tlist.add(new xml_tag_handler("//fme/Capacidade", CBData.Capacidade));
    
    tlist.add(new xml_tag_handler("//fme/DescProj", CBData.DescProj));
    
    tlist.add(new xml_tag_handler("//fme/Atividades", CBData.Atividades));
    
    tlist.add(new xml_tag_handler("//fme/CritSelA", CBData.CritSelA));
    tlist.add(new xml_tag_handler("//fme/CritSelB", CBData.CritSelB));
    

    tlist.add(new xml_tag_handler("//fme/DesafiosSocietais", CBData.DesafiosSocietais));
    tlist.add(new xml_tag_handler("//fme/DominiosPrioritarios", CBData.DominiosPrioritarios));
    
    tlist.add(new xml_tag_handler("//fme/CritSelC1", CBData.CritSelC1));
    

    tlist.add(new xml_tag_handler("//fme/DominiosPrioritariosNorte", CBData.DominiosPrioritariosNorte));
    tlist.add(new xml_tag_handler("//fme/DominiosPrioritariosCentro", CBData.DominiosPrioritariosCentro));
    tlist.add(new xml_tag_handler("//fme/DominiosPrioritariosLisboa", CBData.DominiosPrioritariosLisboa));
    tlist.add(new xml_tag_handler("//fme/DominiosPrioritariosAlentejo", CBData.DominiosPrioritariosAlentejo));
    tlist.add(new xml_tag_handler("//fme/DominiosPrioritariosAlgarve", CBData.DominiosPrioritariosAlgarve));
    
    tlist.add(new xml_tag_handler("//fme/CritSelD2", CBData.CritSelD2));
    
    tlist.add(new xml_tag_handler("//fme/Inv", CBData.QInv));
    tlist.add(new xml_tag_handler("//fme/Financ", CBData.Finan));
    tlist.add(new xml_tag_handler("//fme/TxtFinanc", CBData.FinanTxt));
    tlist.add(new xml_tag_handler("//fme/QuadrosTecn", CBData.QuadrosTecn));
    tlist.add(new xml_tag_handler("//fme/TxtQuadrosTecn", CBData.QuadrosTecnTxt));
    
    tlist.add(new xml_tag_handler("//fme/IndicCertif", CBData.IndicCertif));
    tlist.add(new xml_tag_handler("//fme/IndicadoresIDT", CBData.IndicIDT));
    tlist.add(new xml_tag_handler("//fme/TxtIndic", CBData.IndicTxt));
    









    tlist.add(new xml_tag_handler("//fme/Uploads", CBData.Uploads));
  }
  


  public void xmlBegin(String path)
  {
    for (int i = 0; i < tlist.size(); i++) {
      String s = tlist.elementAt(i)).path;
      if (path.equals(s)) {
        stk.push(tlist.elementAt(i));
        
        return;
      }
    }
    

    XMLDataHandler h = stk.peek()).handler.getHandler(path);
    if (h != null)
    {
      xml_tag_handler xtg = new xml_tag_handler(path, h);
      stk.push(xtg);
      return;
    }
    

    stk.peek()).handler.xmlBegin(path);
  }
  


  public void xmlEnd(String path)
  {
    String s = stk.peek()).path;
    if (path.equals(s))
    {
      stk.pop();
      return;
    }
    stk.peek()).handler.xmlEnd(path);
  }
  

  public void xmlValue(String path, String tag, String v)
  {
    if (stk.size() >= 1) {
      String s = stk.peek()).path;
      
      stk.peek()).handler.xmlValue(path, tag, v);
    }
  }
  

  public String xmlSave(String path)
  {
    for (int i = 0; i < tlist.size(); i++) {
      String s = tlist.elementAt(i)).path;
      
      if (path.equals(s)) break;
    }
    if (i == tlist.size()) return "?";
    System.out.print(path + "\n");
    


    String xml = tlist.elementAt(i)).handler.xmlPrintBegin();
    xml = xml + tlist.elementAt(i)).handler.xmlPrint();
    
    for (int k = 0; k < tlist.size(); k++) {
      String s = tlist.elementAt(k)).path;
      
      if ((s.startsWith(path)) && (s.lastIndexOf('/') == path.length()))
      {
        xml = xml + xmlSave(s);
      }
    }
    
    xml = xml + tlist.elementAt(i)).handler.xmlPrintEnd();
    

    return xml;
  }
  
  public void saveInFile(File file) {
    String path = file.getAbsolutePath();
    String extensao = new XmlFileFilter().getExtension();
    


    Random x = new Random();
    int n = x.nextInt() % 9999;
    n = n < 0 ? -n : n;
    String s = "0000" + n;
    s = s.substring(s.length() - 4);
    String xml = file.getName().substring(0, file.getName().length() - extensao.length()) + s + ".xml";
    



    try
    {
      File outfile = new File(fmeComum.tmpDir + "/" + xml);
      


      FileOutputStream out1 = new FileOutputStream(outfile);
      OutputStreamWriter out = new OutputStreamWriter(out1, "ISO-8859-15");
      out.write("<?xml version='1.0' encoding='ISO-8859-15'?>\n");
      out.write(xmlSave("//fme"));
      out.flush();
      out.close();
      

      try
      {
        int BUFFER = 2048;
        byte[] data = new byte['ࠀ'];
        File f_zip = new File(path);
        

        FileOutputStream dest = new FileOutputStream(f_zip);
        ZipOutputStream zip_out = new ZipOutputStream(new BufferedOutputStream(dest));
        


        String[] files = { fmeComum.tmpDir + "/" + xml };
        for (int i = 0; i < files.length; i++) {
          FileInputStream fi = new FileInputStream(files[i]);
          BufferedInputStream origin = new BufferedInputStream(fi, 2048);
          ZipEntry entry = new ZipEntry("fme.xml");
          zip_out.putNextEntry(entry);
          int count;
          while ((count = origin.read(data, 0, 2048)) != -1) { int count;
            zip_out.write(data, 0, count); }
          origin.close();
        }
        zip_out.close();
        
        outfile.delete();
      }
      catch (IOException e2) {
        e2.printStackTrace();
        JOptionPane.showMessageDialog(null, "Erro a criar o ficheiro Zip!");
      }
      




      CBData.LastFile = file;
    }
    catch (IOException e1)
    {
      e1.printStackTrace();
      JOptionPane.showMessageDialog(null, "Erro a criar o ficheiro Xml!");
    }
  }
  
  public static void Read(String http)
  {
    DefaultHandler handler = new CParse();
    SAXParserFactory factory = SAXParserFactory.newInstance();
    try {
      SAXParser saxParser = factory.newSAXParser();
      saxParser.parse(http, handler);
    } catch (Throwable t) {
      JOptionPane.showMessageDialog(null, "Erro ao ler ficheiro!");
      t.printStackTrace();
    }
  }
  
  public static void Open(File file) {
    String path = file.getAbsolutePath();
    String extensao = new XmlFileFilter().getExtension();
    
    String xml;
    if (!file.getAbsolutePath().endsWith(extensao)) {
      path = path + extensao;
      
      file = new File(path);
      xml = file.getName() + ".xml";
    }
    else
    {
      xml = file.getName().substring(0, file.getName().length() - extensao.length()) + ".xml";
    }
    
    String xml = fmeComum.tmpDir + "/" + xml;
    
    if (!new File(path).exists()) {
      JOptionPane.showMessageDialog(null, path + "\nO ficheiro não foi encontrado!");
      return;
    }
    



    try
    {
      ZipInputStream in = new ZipInputStream(new FileInputStream(path));
      

      ZipEntry entry = in.getNextEntry();
      

      File xml_ = new File(xml);
      OutputStream out = new FileOutputStream(xml_);
      

      byte[] buf = new byte['Ѐ'];
      int len;
      while ((len = in.read(buf)) > 0) { int len;
        out.write(buf, 0, len);
      }
      

      out.close();
      in.close();
      


      InputStream in_xml = new FileInputStream(xml);
      
      DefaultHandler handler = new CParse();
      SAXParserFactory factory = SAXParserFactory.newInstance();
      try {
        SAXParser saxParser = factory.newSAXParser();
        
        saxParser.parse(in_xml, handler);
      } catch (Throwable t) {
        if (!CBData.config_ok) {
          JOptionPane.showMessageDialog(null, "Ficheiro inválido!\nEste ficheiro não é do Aviso nº " + fmeApp.comum.aviso() + ".");
          CBData.config_ok = true;
          file = null;
        } else {
          JOptionPane.showMessageDialog(null, "Erro ao abrir ficheiro!");
        }
        t.printStackTrace();
      }
      in_xml.close();
      
      xml_.delete();
    }
    catch (IOException e)
    {
      System.out.print(e);
    }
    CBData.LastFile = file;
  }
}
