package fme;



























class XMLDataHandler
{
  String tag;
  
























  XMLParser xml_dh;
  

























  XMLDataHandler() {}
  

























  public void xmlBegin(String path) {}
  

























  public void xmlEnd(String path) {}
  

























  public void xmlValue(String path, String tag, String v) {}
  

























  public String xmlPrintBegin()
  {
    return "<" + tag + ">";
  }
  
  public String xmlPrintEnd() {
    return "</" + tag + ">\n";
  }
  
  public String xmlPrint() {
    return "\n";
  }
  
  XMLDataHandler getHandler(String path) {
    return null;
  }
}
