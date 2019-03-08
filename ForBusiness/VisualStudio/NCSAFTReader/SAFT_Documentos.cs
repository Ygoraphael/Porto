using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Xml.Linq;
using System.Windows.Forms;
using System.Data;
using System.ComponentModel;
using System.IO;

namespace NCSAFTReader
{
    class SAFT_Documentos
    {

        public DataTable dt_documentos = new DataTable();
        public DataTable dt_documentos_linhas = new DataTable();
        public BackgroundWorker bw = new BackgroundWorker();
        public Form form1;

        public SAFT_Documentos(XDocument doc1, Form1 f1)
        {
            dt_documentos.Columns.Add("Nº");
            dt_documentos.Columns.Add("Estado");
            dt_documentos.Columns.Add("Data Doc");
            dt_documentos.Columns.Add("Data Assinatura");
            dt_documentos.Columns.Add("Tipo");
            dt_documentos.Columns.Add("Autofaturação");
            dt_documentos.Columns.Add("ID Cliente");
            dt_documentos.Columns.Add("Total S/IVA", typeof(double));
            dt_documentos.Columns.Add("Total IVA", typeof(double));
            dt_documentos.Columns.Add("Total C/IVA", typeof(double));
            dt_documentos.Columns.Add("Total Desconto", typeof(double));
            dt_documentos.Columns.Add("Linhas Negativas");
            dt_documentos.Columns.Add("index");

            dt_documentos_linhas.Columns.Add("index");
            dt_documentos_linhas.Columns.Add("Código");
            dt_documentos_linhas.Columns.Add("Descrição");
            dt_documentos_linhas.Columns.Add("Quant.", typeof(double));
            dt_documentos_linhas.Columns.Add("Unidade");
            dt_documentos_linhas.Columns.Add("Preço Unit.", typeof(double));
            dt_documentos_linhas.Columns.Add("Total", typeof(double));
            dt_documentos_linhas.Columns.Add("Cód. Taxa");
            dt_documentos_linhas.Columns.Add("Taxa");
            dt_documentos_linhas.Columns.Add("Total_DebCre", typeof(double));
            dt_documentos_linhas.Columns.Add("Tipo");
            dt_documentos_linhas.Columns.Add("Reference");
            dt_documentos_linhas.Columns.Add("Desconto");

            load_documentos(doc1, f1);
        }

        public void bw_DoWork(object sender, DoWorkEventArgs e)
        {
            List<object> genericlist = e.Argument as List<object>;

            Form1 f1 = (Form1)genericlist[0];
            String filename = (String)genericlist[1];
            int tmp_prog = 0;
            String text = "";
            Double s_iva = 0;
            Double t_iva = 0;
            Double t_liq = 0;
            int index = 0;

            List<Double> array_iva_taxas = new List<Double>();
            List<Double> array_iva_somas = new List<Double>();
            
            foreach (DataRow row in dt_documentos_linhas.Rows)
            {
                if ( dt_documentos.Rows[Convert.ToInt32(row.ItemArray[0])].ItemArray[1].Equals("Normal") )
                {
                    try
                    {
                        f1.progressBar1.BeginInvoke(
                            (MethodInvoker)delegate()
                            {
                                f1.progressBar1.Value = tmp_prog;
                            });

                        DataRow[] filteredRows = dt_documentos.Select(string.Format("{0} LIKE '{1}'", "index", row.ItemArray[0]));

                        s_iva = Convert.ToDouble(row.ItemArray[6]);

                        if (Convert.ToDouble(row.ItemArray[8]) > 0)
                        {
                            t_iva = s_iva * Convert.ToDouble(row.ItemArray[8]) / 100;
                        }
                        else
                        {
                            t_iva = 0;
                        }

                        t_liq = s_iva + t_iva;

                        text = filteredRows[0][0].ToString() + ";" + row.ItemArray[2] + ";" + row.ItemArray[3] + ";" +
                            row.ItemArray[5] + ";" +
                            Math.Round(s_iva, 2).ToString() + ";" +
                            Math.Round(t_iva, 2).ToString() + ";" +
                            Math.Round(t_liq, 2).ToString() + ";" +
                            row.ItemArray[8] + ";" + Convert.ToDouble(row.ItemArray[9]) + ";" + row.ItemArray[10] + ";" + row.ItemArray[11] + ";" + row.ItemArray[12] + "\n";

                        if (array_iva_taxas.Contains(Convert.ToDouble(row.ItemArray[8])))
                        {
                            index = array_iva_taxas.IndexOf(Convert.ToDouble(row.ItemArray[8]));
                            array_iva_somas[index] = array_iva_somas[index] + Convert.ToDouble(t_iva);
                        }
                        else
                        {
                            array_iva_taxas.Add(Convert.ToDouble(row.ItemArray[8]));
                            array_iva_somas.Add(t_iva);
                        }

                        File.AppendAllText(@"" + filename, text);
                        tmp_prog += 1;
                    }
                    catch (Exception exc)
                    {
                        Console.WriteLine("ERRO: " + exc.ToString());
                    }
                }
            }

            f1.progressBar1.BeginInvoke(
            (MethodInvoker)delegate()
            {
                f1.progressBar1.Value = tmp_prog;
            });

            text = "\n\nSomas IVA\n\n";
            File.AppendAllText(@"" + filename, text);

            for (int i = 0; i < array_iva_taxas.Count; i++ )
            {
                text = Math.Round(array_iva_taxas[i], 2) + ";" + Math.Round(array_iva_somas[i], 2) + "\n";
                File.AppendAllText(@"" + filename, text);
            }

            MessageBox.Show("Exportação Concluída");
        }

        public void linhastoexcel(Form1 f1)
        {
            SaveFileDialog saveFileDialog1 = new SaveFileDialog();
            saveFileDialog1.DefaultExt = "csv";
            saveFileDialog1.Filter = "Ficheiros Excel (*.csv)|*.csv";

            DialogResult result = saveFileDialog1.ShowDialog();

            if (result == DialogResult.OK)
            {
                string text = "Documento;Descrição;Quantidade;Preço Unitário;Total S/IVA;Total IVA;Total;Taxa IVA;Credit(+)Debit(-);Type;Reference;Desconto\n";
                System.IO.File.WriteAllText(@"" + saveFileDialog1.FileName, text, Encoding.UTF8);

                int total_prog = dt_documentos_linhas.Rows.Count;
                f1.progressBar1.Value = 0;
                f1.progressBar1.Maximum = total_prog;

                List<object> arguments = new List<object>();
                arguments.Add(f1);
                arguments.Add(saveFileDialog1.FileName);

                bw.DoWork += bw_DoWork;
                bw.RunWorkerAsync(arguments);
            }
        }

        public DataTable get_dt_linhas(string indice)
        {
            DataTable tmp = new DataTable();
            tmp.Columns.Add("index");
            tmp.Columns.Add("Código");
            tmp.Columns.Add("Descrição");
            tmp.Columns.Add("Quant.");
            tmp.Columns.Add("Unidade");
            tmp.Columns.Add("Preço Unit.");
            tmp.Columns.Add("Total");
            tmp.Columns.Add("Cód. Taxa");
            tmp.Columns.Add("Taxa");
            tmp.Columns.Add("Credito(+)Debito(-)");
            tmp.Columns.Add("Tipo");
            tmp.Columns.Add("Referencia");
            tmp.Columns.Add("Desconto");

            foreach (DataRow row in dt_documentos_linhas.Rows)
            {
                if( row[0].ToString() ==  indice)
                {
                    tmp.Rows.Add(row.ItemArray);
                }
            }

            return tmp;
        }

        public void load_documentos(XDocument doc1, Form1 f1)
        {
            XNamespace ns = f1.ns_xsd; //"urn:OECD:StandardAuditFile-Tax:PT_1.02_01";
            int index = 0;

            string c01 = "";
            string c02 = "";
            string c03 = "";
            string c04 = "";
            string c05 = "";
            string c06 = "";
            string c07 = "";
            string c08 = "";
            string c09 = "";
            string c10 = "";
            string c11 = "";

            string l01 = "";
            string l03 = "";
            string l04 = "";
            string l05 = "";
            string l06 = "";
            string l07 = "";
            string l08 = "";
            string l10 = "";
            string l11 = "";
            string l12 = "";
            string l13 = "";
            //desconto
            string l14 = "";

            foreach (XElement xe in doc1.Root.Descendants(ns + "SourceDocuments").Descendants(ns + "SalesInvoices").Elements(ns + "Invoice"))
            {
                c01 = "";
                c02 = "";
                c03 = "";
                c04 = "";
                c05 = "";
                c06 = "";
                c07 = "";
                c08 = "";
                c09 = "";
                c10 = "";
                c11 = "";

                try
                {
                    c01 = xe.Element(ns + "InvoiceNo").Value.ToString();
                }
                catch { }

                if (ns.ToString().Contains("1.01_01"))
                {
                    try
                    {
                        switch (xe.Element(ns + "InvoiceStatus").Value.ToString())
                        {
                            case "N":
                                c02 = "Normal";
                                break;
                            case "S":
                                c02 = "Autofaturação";
                                break;
                            case "A":
                                c02 = "Documento Anulado";
                                break;
                            case "R":
                                c02 = "Documento de resumo doutros documentos criados noutras aplicações e gerado nesta aplicação";
                                break;
                            case "F":
                                c02 = "Documento Faturado";
                                break;
                            default:
                                c02 = "";
                                break;
                        }
                    }
                    catch { }
                }
                else
                {
                    try
                    {
                        switch (xe.Element(ns + "DocumentStatus").Element(ns + "InvoiceStatus").Value.ToString())
                        {
                            case "N":
                                c02 = "Normal";
                                break;
                            case "S":
                                c02 = "Autofaturação";
                                break;
                            case "A":
                                c02 = "Documento Anulado";
                                break;
                            case "R":
                                c02 = "Documento de resumo doutros documentos criados noutras aplicações e gerado nesta aplicação";
                                break;
                            case "F":
                                c02 = "Documento Faturado";
                                break;
                            default:
                                c02 = "";
                                break;
                        }
                    }
                    catch { }
                }

                try
                {
                    c04 = xe.Element(ns + "InvoiceType").Value.ToString();
                }
                catch { }

                try
                {
                    c03 = xe.Element(ns + "InvoiceDate").Value.ToString();
                }
                catch { }

                try
                {
                    c11 = xe.Element(ns + "SystemEntryDate").Value.ToString();
                }
                catch { }
                
                try
                {
                    switch (xe.Element(ns + "SelfBillingIndicator").Value.ToString())
                    {
                        case "0":
                            c05 = "Não";
                            break;
                        case "1":
                            c05 = "Sim";
                            break;
                        default:
                            c05 = "";
                            break;
                    }
                }
                catch { }
                try
                {
                    c06 = xe.Element(ns + "CustomerID").Value.ToString();
                }
                catch { }
                try
                {
                    double b = Convert.ToDouble(xe.Element(ns + "DocumentTotals").Element(ns + "NetTotal").Value.Replace(".", ","));
                    //c07 = Math.Round(b, 2).ToString();
                    c07 = b.ToString();
                }
                catch { }
                try
                {
                    double b = Convert.ToDouble(xe.Element(ns + "DocumentTotals").Element(ns + "TaxPayable").Value.Replace(".", ","));
                    //c08 = Math.Round(b, 2).ToString();
                    c08 = b.ToString();
                }
                catch { }
                try
                {
                    double b = Convert.ToDouble(xe.Element(ns + "DocumentTotals").Element(ns + "GrossTotal").Value.Replace(".", ","));
                    //c09 = Math.Round(b, 2).ToString();
                    c09 = b.ToString();
                }
                catch { }
                try
                {
                    c10 = xe.Element(ns + "DocumentTotals").Element(ns + "Settlement").Element(ns + "SettlementAmount").Value.ToString();
                }
                catch {
                    c10 = "0";
                }

                //linhas
                string neg_line = "Não";

                foreach (XElement xee in xe.Elements(ns + "Line"))
                {
                    l01 = "";
                    l03 = "";
                    l04 = "";
                    l05 = "";
                    l06 = "";
                    l07 = "";
                    l08 = "";
                    l10 = "";
                    l11 = "";
                    l12 = "";
                    l13 = "";
                    //desconto
                    l14 = "";

                    l01 = index.ToString();
                    try
                    {
                        l03 = xee.Element(ns + "ProductCode").Value.ToString();
                    }
                    catch { }
                    try
                    {
                        l04 = xee.Element(ns + "ProductDescription").Value.ToString();
                    }
                    catch { }
                    try
                    {
                        l05 = xee.Element(ns + "Quantity").Value.ToString().Replace(".", ",");
                    }
                    catch { }
                    try
                    {
                        l06 = xee.Element(ns + "UnitOfMeasure").Value.ToString();
                    }
                    catch { }
                    try
                    {
                        l07 = xee.Element(ns + "UnitPrice").Value.ToString().Replace(".", ",");
                    }
                    catch { }

                    if ( c04=="NC" || c04=="ND" ) {
                        try
                        {
                            l13 = xee.Element(ns + "References").Element(ns + "Reference").Value.ToString();
                        }
                        catch { }
                    }

                    try
                    {
                        l08 = xee.Element(ns + "CreditAmount").Value.ToString().Replace(".", ",");
                        l12 = xee.Element(ns + "CreditAmount").Value.ToString().Replace(".", ",");
                    }
                    catch 
                    {
                        try
                        {
                            l08 = xee.Element(ns + "DebitAmount").Value.ToString().Replace(".", ",");
                            l12 = "-" + xee.Element(ns + "DebitAmount").Value.ToString().Replace(".", ",");
                        }
                        catch
                        {

                        }
                    }

                    try
                    {
                        l10 = xee.Element(ns + "Tax").Element(ns + "TaxCode").Value.ToString();
                    }
                    catch { }
                    try
                    {
                        l11 = xee.Element(ns + "Tax").Element(ns + "TaxPercentage").Value.ToString().Replace(".", ",");
                    }
                    catch { }
                    try
                    {
                        l14 = xee.Element(ns + "SettlementAmount").Value.ToString().Replace(".", ",");
                    }
                    catch { }

                    if (l14 == "")
                    {
                        l14 = "0";
                    }

                    if (Convert.ToDouble(l05) < 0 || Convert.ToDouble(l07) < 0)
                    {
                        neg_line = "Sim";
                    }

                    dt_documentos_linhas.Rows.Add(l01, l03, l04, Convert.ToDouble(l05).ToString(), l06, Convert.ToDouble(l07).ToString(), l08, l10, Convert.ToDouble(l11).ToString(), l12, c04, l13, Convert.ToDouble(l14));
                }


                dt_documentos.Rows.Add(c01, c02, c03, c11, c04, c05, c06, c07, c08, c09, c10, neg_line, index.ToString());
                index++;
            }
        }
    }
}
