using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Xml.Linq;

namespace NCSAFTReader
{
    class SAFT_Cabecalho
    {
        public SAFT_Cabecalho(XDocument doc1, Form1 f1)
        {
            load_dados_header(doc1, f1);
            load_dados_headerdocumentos(doc1, f1);
        }

        public void load_dados_headerdocumentos(XDocument doc1, Form1 f1)
        {
            XNamespace ns = f1.ns_xsd; //"urn:OECD:StandardAuditFile-Tax:PT_1.02_01";
            double b = 0;

            string n_entradas = doc1.Root.Descendants(ns + "SourceDocuments").Descendants(ns + "NumberOfEntries").First().Value.ToString();

            b = Convert.ToDouble(doc1.Root.Descendants(ns + "SourceDocuments").Descendants(ns + "TotalDebit").First().Value.Replace(".", ","));
            string total_debito = Math.Round(b, 2).ToString();

            b = Convert.ToDouble(doc1.Root.Descendants(ns + "SourceDocuments").Descendants(ns + "TotalCredit").First().Value.Replace(".", ","));
            string total_credito = Math.Round(b, 2).ToString();

            f1.textBox7.Text = n_entradas;
            f1.textBox8.Text = total_debito;
            f1.textBox9.Text = total_credito;
        }

        public void load_dados_header(XDocument doc1, Form1 f1)
        {
            XNamespace ns = f1.ns_xsd; //"urn:OECD:StandardAuditFile-Tax:PT_1.02_01";

            string n_cont = doc1.Root.Descendants(ns + "Header").Descendants(ns + "TaxRegistrationNumber").First().Value.ToString();
            string nome = doc1.Root.Descendants(ns + "Header").Descendants(ns + "CompanyName").First().Value.ToString();
            string nome_comercial = doc1.Root.Descendants(ns + "Header").Descendants(ns + "BusinessName").First().Value.ToString();
            string morada = doc1.Root.Descendants(ns + "Header").Descendants(ns + "CompanyAddress").Descendants(ns + "AddressDetail").First().Value.ToString();
            string cidade = doc1.Root.Descendants(ns + "Header").Descendants(ns + "CompanyAddress").Descendants(ns + "City").First().Value.ToString();
            string cod_postal = doc1.Root.Descendants(ns + "Header").Descendants(ns + "CompanyAddress").Descendants(ns + "PostalCode").First().Value.ToString();

            f1.textBox3.Text = n_cont;
            f1.textBox1.Text = nome;
            f1.textBox2.Text = nome_comercial;
            f1.textBox4.Text = morada;
            f1.textBox6.Text = cidade;
            f1.textBox5.Text = cod_postal;
        }
    }
}
