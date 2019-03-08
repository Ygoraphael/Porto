package fme;

import java.util.HashMap;
import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;








public class CParse
  extends DefaultHandler
{
  StringBuffer textBuffer;
  int Status;
  String a_tag;
  String path = new String("/");
  
  public CParse() {
    Status = 0;
  }
  
  void _path_grow(String tag) {
    path = (path + "/" + tag);
  }
  
  void _path_back(String tag)
  {
    path = path.substring(0, path.length() - tag.length() - 1);
  }
  

  public void startDocument()
    throws SAXException
  {}
  
  public void endDocument()
    throws SAXException
  {}
  
  public void startElement(String namespaceURI, String sName, String qName, Attributes attrs)
    throws SAXException
  {
    if ((!CBData.config_old.equals("")) && (!CBData.config_old.equals(CParseConfig.hconfig.get("fme-config")))) {
      String old = CBData.config_old;
      CBData.config_old = "";
      CBData.config_ok = false;
      throw new SAXException("\nconfig diferente...");
    }
    

    if (Status == 1)
    {
      _path_grow(a_tag);
      
      cbxml_dh.xmlBegin(path);
    }
    a_tag = qName;
    Status = 1;
    textBuffer = null;
  }
  



  public void endElement(String namespaceURI, String sName, String qName)
    throws SAXException
  {
    if ((Status == 1) && (qName == a_tag))
    {
      String v;
      String v;
      if (textBuffer == null) v = ""; else {
        v = textBuffer.toString();
      }
      
      cbxml_dh.xmlValue(path, qName, v);
    }
    
    if (Status == 0)
    {

      cbxml_dh.xmlEnd(path);
      _path_back(qName);
    }
    Status = 0;
    textBuffer = null;
  }
  
  public void characters(char[] buf, int offset, int len) throws SAXException {
    String s = new String(buf, offset, len);
    if (textBuffer == null) {
      textBuffer = new StringBuffer(s);
    } else {
      textBuffer.append(s);
    }
  }
}
