using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Xml.Linq;
using System.Windows.Forms;
using System.Data;

namespace NCSAFTReader
{
    class SAFT_Clientes
    {

        public DataTable dt_clientes = new DataTable();

        public SAFT_Clientes(XDocument doc1, Form1 f1)
        {
            dt_clientes.Columns.Add("ID");
            dt_clientes.Columns.Add("ID Taxa");
            dt_clientes.Columns.Add("Nome");
            dt_clientes.Columns.Add("Morada");
            dt_clientes.Columns.Add("Cidade");
            dt_clientes.Columns.Add("Cód. Postal");
            dt_clientes.Columns.Add("País");
            dt_clientes.Columns.Add("Telefone");
            dt_clientes.Columns.Add("Autofaturação");

            load_clientes(doc1, f1);
        }

        public DataTable get_dt_cliente(string stamp)
        {
            DataTable tmp = new DataTable();
            tmp.Columns.Add("Campo");
            tmp.Columns.Add("Valor");

            foreach (DataRow row in dt_clientes.Rows)
            {
                if (row[0].ToString() == stamp)
                {
                    tmp.Rows.Add("ID", row[0]);
                    tmp.Rows.Add("Nome", row[2]);
                    tmp.Rows.Add("Morada", row[3]);
                    tmp.Rows.Add("Cidade", row[4]);
                    tmp.Rows.Add("Cód. Postal", row[5]);
                    tmp.Rows.Add("País", row[6]);
                    tmp.Rows.Add("Telefone", row[7]);
                }
            }

            return tmp;
        }

        public void load_clientes(XDocument doc1, Form1 f1)
        {
            XNamespace ns = f1.ns_xsd; //"urn:OECD:StandardAuditFile-Tax:PT_1.02_01";

            string c_id = "";
            string ct_id = "";
            string cn = "";
            string ad = "";
            string city = "";
            string postcode = "";
            string country = "";
            string telephone = "";
            string autofac = "";

            foreach (XElement xe in doc1.Root.Descendants(ns + "MasterFiles").Elements(ns+"Customer") )
            {
                c_id = "";
                ct_id = "";
                cn = "";
                ad = "";
                city = "";
                postcode = "";
                country = "";
                telephone = "";
                autofac = "";

                try
                {
                    c_id = xe.Element(ns + "CustomerID").Value.ToString();
                }
                catch { }
                try
                {
                    ct_id = xe.Element(ns + "CustomerTaxID").Value.ToString();
                }
                catch { }
                try
                {
                    cn = xe.Element(ns + "CompanyName").Value.ToString();
                }
                catch { }
                try
                {
                    ad = xe.Element(ns + "BillingAddress").Element(ns + "AddressDetail").Value.ToString();
                }
                catch { }
                try
                {
                    city = xe.Element(ns + "BillingAddress").Element(ns + "City").Value.ToString();
                }
                catch { }
                try
                {
                    postcode = xe.Element(ns + "BillingAddress").Element(ns + "PostalCode").Value.ToString();
                }
                catch { }
                try
                {
                    country = xe.Element(ns + "BillingAddress").Element(ns + "Country").Value.ToString();
                }
                catch { }
                try
                {
                    telephone = xe.Element(ns + "Telephone").Value.ToString();
                }
                catch { }
                try
                {
                    autofac = xe.Element(ns + "SelfBillingIndicator").Value.ToString();
                }
                catch { }

                dt_clientes.Rows.Add(c_id, ct_id, cn, ad, city, postcode, country, telephone, autofac);
            }
        }
    }
}
