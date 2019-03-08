using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Xml.Linq;
using System.Windows.Forms;
using System.Data;

namespace NCSAFTReader
{
    class SAFT_Artigos
    {
        public DataTable dt_artigos = new DataTable();

        public SAFT_Artigos(XDocument doc1, Form1 f1)
        {
            //dt_artigos.Columns.Add("ID");
            //dt_artigos.Columns.Add("ID Taxa");
            //dt_artigos.Columns.Add("Nome");
            //dt_artigos.Columns.Add("Morada");
            //dt_artigos.Columns.Add("Cidade");
            //dt_artigos.Columns.Add("Cód. Postal");
            //dt_artigos.Columns.Add("País");
            //dt_artigos.Columns.Add("Telefone");
            //dt_artigos.Columns.Add("Autofaturação");

            //load_clientes(doc1, f1);
        }

        public void load_clientes(XDocument doc1, Form1 f1)
        {
            //XNamespace ns = "urn:OECD:StandardAuditFile-Tax:PT_1.02_01";;

            //string c_id = "";
            //string ct_id = "";
            //string cn = "";
            //string ad = "";
            //string city = "";
            //string postcode = "";
            //string country = "";
            //string telephone = "";
            //string autofac = "";

            //foreach (XElement xe in doc1.Root.Descendants(ns + "MasterFiles").Elements(ns+"Customer") )
            //{
            //    c_id = "";
            //    ct_id = "";
            //    cn = "";
            //    ad = "";
            //    city = "";
            //    postcode = "";
            //    country = "";
            //    telephone = "";
            //    autofac = "";

            //    try
            //    {
            //        c_id = xe.Element(ns + "CustomerID").Value.ToString();
            //    }
            //    catch { }
            //    try
            //    {
            //        ct_id = xe.Element(ns + "CustomerTaxID").Value.ToString();
            //    }
            //    catch { }
            //    try
            //    {
            //        cn = xe.Element(ns + "CompanyName").Value.ToString();
            //    }
            //    catch { }
            //    try
            //    {
            //        ad = xe.Element(ns + "BillingAddress").Element(ns + "AddressDetail").Value.ToString();
            //    }
            //    catch { }
            //    try
            //    {
            //        city = xe.Element(ns + "BillingAddress").Element(ns + "City").Value.ToString();
            //    }
            //    catch { }
            //    try
            //    {
            //        postcode = xe.Element(ns + "BillingAddress").Element(ns + "PostalCode").Value.ToString();
            //    }
            //    catch { }
            //    try
            //    {
            //        country = xe.Element(ns + "BillingAddress").Element(ns + "Country").Value.ToString();
            //    }
            //    catch { }
            //    try
            //    {
            //        telephone = xe.Element(ns + "Telephone").Value.ToString();
            //    }
            //    catch { }
            //    try
            //    {
            //        autofac = xe.Element(ns + "SelfBillingIndicator").Value.ToString();
            //    }
            //    catch { }

            //    dt_artigos.Rows.Add(c_id, ct_id, cn, ad, city, postcode, country, telephone, autofac);
            //}
        }
    }
}
