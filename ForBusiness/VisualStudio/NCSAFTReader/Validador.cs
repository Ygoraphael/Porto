using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Xml.Schema;
using System.IO;
using System.Xml;
using System.Xml.Linq;
using System.Data;

namespace NCSAFTReader
{
    public class Validador
    {

        public string string_saft = "";
        public DataTable dt_errors = new DataTable();
        public XDocument doc1;

        public void carrega_saft(string caminho_saft)
        {
            System.IO.StreamReader myFile = new System.IO.StreamReader(caminho_saft, Encoding.Default, true);
            string_saft = myFile.ReadToEnd();
        }

        public bool valida_saft(string versao)
        {
            xsd xsd_schemas = new xsd();
            XmlSchemaSet schemas = new XmlSchemaSet();
            dt_errors = new DataTable();

            if (versao == "xsd_02_simplificado")
            {
                schemas.Add("urn:OECD:StandardAuditFile-Tax:PT_1.02_01", XmlReader.Create(new StringReader(xsd_schemas.xsd_02_simplificado)));
            }
            else if (versao == "xsd_02_geral")
            {
                schemas.Add("urn:OECD:StandardAuditFile-Tax:PT_1.02_01", XmlReader.Create(new StringReader(xsd_schemas.xsd_02_geral)));
            }
            else if (versao == "xsd_03_geral")
            {
                schemas.Add("urn:OECD:StandardAuditFile-Tax:PT_1.03_01", XmlReader.Create(new StringReader(xsd_schemas.xsd_03_geral)));
            }
            else if (versao == "xsd_03_simplificado")
            {
                schemas.Add("urn:OECD:StandardAuditFile-Tax:PT_1.03_01", XmlReader.Create(new StringReader(xsd_schemas.xsd_03_simplificado)));
            }
            else if (versao == "xsd_01_geral")
            {
                schemas.Add("urn:OECD:StandardAuditFile-Tax:PT_1.01_01", XmlReader.Create(new StringReader(xsd_schemas.xsd_01_geral)));
            }
            else if (versao == "xsd_01_simplificado")
            {
                schemas.Add("urn:OECD:StandardAuditFile-Tax:PT_1.01_01", XmlReader.Create(new StringReader(xsd_schemas.xsd_01_simplificado)));
            }
            else
            {
                return false;
            }

            doc1 = XDocument.Parse(string_saft);

            bool errors = false;

            int line = 0;
            dt_errors.Columns.Add("No");
            dt_errors.Columns.Add("Erro");

            string namespacexml = doc1.Root.GetDefaultNamespace().ToString();
            string portaria_a_usar = namespacexml.Substring(namespacexml.Length - 7, 7);

            if (versao == "xsd_02_simplificado" || versao == "xsd_02_geral")
            {
                if (namespacexml != "urn:OECD:StandardAuditFile-Tax:PT_1.02_01")
                {
                    dt_errors.Rows.Add(1, "Portaria usada inválida. Deve usar a portaria " + portaria_a_usar);
                    return false;
                }

            }
            else if (versao == "xsd_03_geral" || versao == "xsd_03_simplificado")
            {
                if (namespacexml != "urn:OECD:StandardAuditFile-Tax:PT_1.03_01")
                {
                    dt_errors.Rows.Add(1, "Portaria usada inválida. Deve usar portaria " + portaria_a_usar);
                    return false;
                }
            }
            else if (versao == "xsd_01_geral" || versao == "xsd_01_simplificado")
            {
                if (namespacexml != "urn:OECD:StandardAuditFile-Tax:PT_1.01_01")
                {
                    dt_errors.Rows.Add(1, "Portaria usada inválida. Deve usar a portaria" + portaria_a_usar);
                    return false;
                }
            }

            doc1.Validate(schemas, (o, e) =>
            {
                dt_errors.Rows.Add(line, e.Message);
                line++;
                errors = true;
            });

            if (errors)
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        public DataTable get_errors()
        {
            return dt_errors;
        }

        public XDocument get_xml_doc()
        {
            return doc1;
        }
    }
}
