/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package ncphcsync;

import java.awt.List;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.Iterator;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.stream.XMLEventFactory;
import javax.xml.stream.XMLEventReader;
import javax.xml.stream.XMLEventWriter;
import javax.xml.stream.XMLInputFactory;
import javax.xml.stream.XMLOutputFactory;
import javax.xml.stream.XMLStreamException;
import javax.xml.stream.events.Attribute;
import javax.xml.stream.events.Characters;
import javax.xml.stream.events.EndElement;
import javax.xml.stream.events.StartDocument;
import javax.xml.stream.events.StartElement;
import javax.xml.stream.events.XMLEvent;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.SAXException;

/**
 *
 * @author Tiago Loureiro
 */

class Table {
     private String tabela;
     private String nome;

     public Table(String tabela, String nome) {
        this.tabela = tabela;
        this.nome = nome;
     }
}

public class XmlConfGeral {
    
    public XmlConfGeral() {
    }
    
    public String AppPath() {
        return new File(".").getAbsolutePath() + "\\confgeral.xml";
    }
    
    @SuppressWarnings("empty-statement")
    public ArrayList LoadCfg() throws ParserConfigurationException, IOException, SAXException {
        ArrayList data = new ArrayList();
        
        DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
        DocumentBuilder builder = factory.newDocumentBuilder();
        Document document = builder.parse(new File(this.AppPath()));
        
        ArrayList<Table> tables = new ArrayList<Table>();
        
        NodeList nodeList = document.getDocumentElement().getChildNodes();
        
        for (int i = 0; i < nodeList.getLength(); i++) {
            Node node = nodeList.item(i);

            if (node.getNodeType() == Node.ELEMENT_NODE) {
                 Element elem = (Element) node;

                 System.out.println( elem.getChildNodes().item(0) );
                 
                 data.add(0, elem.getElementsByTagName("server")
                                     .item(0).getChildNodes().item(0).getNodeValue());
                 
                 data.add(1, elem.getElementsByTagName("database")
                                     .item(0).getChildNodes().item(0).getNodeValue());

                 data.add(2, elem.getElementsByTagName("user").item(0)
                                     .getChildNodes().item(0).getNodeValue());

                 data.add(3, elem.getElementsByTagName("password").item(0)
                                     .getChildNodes().item(0).getNodeValue());
                 
                 data.add(4, elem.getElementsByTagName("ftp_server").item(0)
                                     .getChildNodes().item(0).getNodeValue());
                 
                 data.add(5, elem.getElementsByTagName("ftp_folder").item(0)
                                     .getChildNodes().item(0).getNodeValue());
                 
                 data.add(6, elem.getElementsByTagName("ftp_user").item(0)
                                     .getChildNodes().item(0).getNodeValue());
                 
                 data.add(7, elem.getElementsByTagName("ftp_password").item(0)
                                     .getChildNodes().item(0).getNodeValue());
            }
        }
        
        
        
        
//        try {
//            XMLInputFactory inputFactory = XMLInputFactory.newInstance();
//            InputStream in = new FileInputStream(this.AppPath());
//            XMLEventReader eventReader = inputFactory.createXMLEventReader(in);
//            
//            while (eventReader.hasNext()) {
//                XMLEvent event = eventReader.nextEvent();
//                if (event.isStartElement()) {
//                    StartElement startElement = event.asStartElement();
//                    if ( "server".equals(startElement.getName().getLocalPart()) ) {
//                        event = eventReader.nextEvent();
//                        try {
//                            data.add(0, event.asCharacters().getData());
//                        }
//                        catch(Exception e){
//                            data.add(0, "");
//                        };
//                        continue;
//                    }
//                    if ( "database".equals(startElement.getName().getLocalPart()) ) {
//                        event = eventReader.nextEvent();
//                        try {
//                            data.add(1, event.asCharacters().getData());
//                        }
//                        catch(Exception e){
//                            data.add(1, "");
//                        };
//                        continue;
//                    }
//                    if ( "user".equals(startElement.getName().getLocalPart()) ) {
//                        event = eventReader.nextEvent();
//                        try {
//                            data.add(2, event.asCharacters().getData());
//                        }
//                        catch(Exception e){
//                            data.add(2, "");
//                        };
//                        continue;
//                    }
//                    if ( "password".equals(startElement.getName().getLocalPart()) ) {
//                        event = eventReader.nextEvent();
//                        try {
//                            data.add(3, event.asCharacters().getData());
//                        }
//                        catch(Exception e){
//                            data.add(3, "");
//                        };
//                        continue;
//                    }
//                    if ( "ftp_server".equals(startElement.getName().getLocalPart()) ) {
//                        event = eventReader.nextEvent();
//                        try {
//                            data.add(4, event.asCharacters().getData());
//                        }
//                        catch(Exception e){
//                            data.add(4, "");
//                        };
//                        continue;
//                    }
//                    if ( "ftp_folder".equals(startElement.getName().getLocalPart()) ) {
//                        event = eventReader.nextEvent();
//                        try {
//                            data.add(5, event.asCharacters().getData());
//                        }
//                        catch(Exception e){
//                            data.add(5, "");
//                        };
//                        continue;
//                    }
//                    if ( "ftp_user".equals(startElement.getName().getLocalPart()) ) {
//                        event = eventReader.nextEvent();
//                        try {
//                            data.add(6, event.asCharacters().getData());
//                        }
//                        catch(Exception e){
//                            data.add(6, "");
//                        };
//                        continue;
//                    }
//                    if ( "ftp_password".equals(startElement.getName().getLocalPart()) ) {
//                        event = eventReader.nextEvent();
//                        try {
//                            data.add(7, event.asCharacters().getData());
//                        }
//                        catch(Exception e){
//                            data.add(7, "");
//                        };
//                        continue;
//                    }
//                    if ( "tables".equals(startElement.getName().getLocalPart()) ) {
//                        
//                        
//                        while (eventReader.hasNext()) {
//                            event = eventReader.nextEvent();
//                        }
//                        
//                        
//                        
//                        event = eventReader.nextEvent();
//                        try {
//                            data.add(7, event.asCharacters().getData());
//                        }
//                        catch(Exception e){
//                            data.add(7, "");
//                        };
//                        continue;
//                    }
//                }
//            }
//        } catch (FileNotFoundException e) {
//        } catch (XMLStreamException e) {
//        }
        return data;
    }
    
    public void SaveCfg(ConfGeral c) throws XMLStreamException, FileNotFoundException {
        XMLOutputFactory outputFactory = XMLOutputFactory.newInstance();
        XMLEventWriter eventWriter = outputFactory.createXMLEventWriter(new FileOutputStream(this.AppPath()));
        XMLEventFactory eventFactory = XMLEventFactory.newInstance();
        XMLEvent end = eventFactory.createDTD("\n");
        StartDocument startDocument = eventFactory.createStartDocument();
        eventWriter.add(startDocument);
        
        StartElement configStartElement = eventFactory.createStartElement("", "", "config");
        eventWriter.add(configStartElement);
        eventWriter.add(end);
    
        createNode(eventWriter, "server", c.jTextField1.getText());
        createNode(eventWriter, "database", c.jTextField2.getText());
        createNode(eventWriter, "user", c.jTextField3.getText());
        createNode(eventWriter, "password", c.jTextField4.getText());
        createNode(eventWriter, "synctype", ""); //ftp
        createNode(eventWriter, "ftp_server", c.jTextField5.getText());
        createNode(eventWriter, "ftp_folder", c.jTextField6.getText());
        createNode(eventWriter, "ftp_user", c.jTextField7.getText());
        createNode(eventWriter, "ftp_password", c.jTextField8.getText());
        
        configStartElement = eventFactory.createStartElement("", "", "tables");
        eventWriter.add(configStartElement);
        eventWriter.add(end);
        
        int tmp = 0;
        String name = "";
        String table = "";
        while(tmp < c.jTable2.getModel().getRowCount())
        {
            name = c.jTable2.getModel().getValueAt(tmp, 0).toString();
            table = c.jTable2.getModel().getValueAt(tmp, 1).toString();
            
            configStartElement = eventFactory.createStartElement("", "", "table_entry");
            eventWriter.add(configStartElement);
            eventWriter.add(end);

            createNode(eventWriter, "name", name );
            createNode(eventWriter, "table", table );

            eventWriter.add( eventFactory.createEndElement("", "", "table_entry") );
            tmp++;
        }

        eventWriter.add( eventFactory.createEndElement("", "", "tables") );

        eventWriter.add( eventFactory.createEndElement("", "", "config") );
        eventWriter.add(end);
        eventWriter.add(eventFactory.createEndDocument());
        eventWriter.close();
    }
    
    public void CreateEmptyCfg() throws XMLStreamException, FileNotFoundException {
        XMLOutputFactory outputFactory = XMLOutputFactory.newInstance();
        XMLEventWriter eventWriter = outputFactory.createXMLEventWriter(new FileOutputStream(this.AppPath()));
        XMLEventFactory eventFactory = XMLEventFactory.newInstance();
        XMLEvent end = eventFactory.createDTD("\n");
        StartDocument startDocument = eventFactory.createStartDocument();
        eventWriter.add(startDocument);
        
        StartElement configStartElement = eventFactory.createStartElement("", "", "config");
        eventWriter.add(configStartElement);
        eventWriter.add(end);
    
        createNode(eventWriter, "server", "");
        createNode(eventWriter, "database", "");
        createNode(eventWriter, "user", "");
        createNode(eventWriter, "password", "");
        createNode(eventWriter, "synctype", ""); //ftp
        createNode(eventWriter, "ftp_server", "");
        createNode(eventWriter, "ftp_folder", "");
        createNode(eventWriter, "ftp_user", "");
        createNode(eventWriter, "ftp_password", "");
        
        configStartElement = eventFactory.createStartElement("", "", "tables");
        eventWriter.add(configStartElement);
        eventWriter.add(end);
        
        configStartElement = eventFactory.createStartElement("", "", "table_entry");
        eventWriter.add(configStartElement);
        eventWriter.add(end);
        
        createNode(eventWriter, "name", "" );
        createNode(eventWriter, "table", "" );
        
        eventWriter.add( eventFactory.createEndElement("", "", "table_entry") );
        
        eventWriter.add( eventFactory.createEndElement("", "", "tables") );

        eventWriter.add( eventFactory.createEndElement("", "", "config") );
        eventWriter.add(end);
        eventWriter.add(eventFactory.createEndDocument());
        eventWriter.close();
    }
    
    private void createNode(XMLEventWriter eventWriter, String name, String value) throws XMLStreamException {
        XMLEventFactory eventFactory = XMLEventFactory.newInstance();
        XMLEvent end = eventFactory.createDTD("\n");
        XMLEvent tab = eventFactory.createDTD("\t");
        StartElement sElement = eventFactory.createStartElement("", "", name);
        eventWriter.add(tab);
        eventWriter.add(sElement);
        
        Characters characters = eventFactory.createCharacters(value);
        eventWriter.add(characters);
        
        EndElement eElement = eventFactory.createEndElement("", "", name);
        eventWriter.add(eElement);
        eventWriter.add(end);
    }
    
    public Boolean Exists() {
        File f = new File(this.AppPath());
        if(f.exists()) {
            return true;
        }
        return false;
    }
}
