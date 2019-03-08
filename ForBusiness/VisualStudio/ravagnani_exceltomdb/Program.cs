using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data.OleDb;

namespace ravagnani_exceltomdb
{
    class Program
    {
        static void Main(string[] args)
        {
            string filename = System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetExecutingAssembly().Location) + "\\precos_em_falta.csv";
            string filename2 = System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetExecutingAssembly().Location) + "\\ravagnani2Data.mdb";
            string[] lines = System.IO.File.ReadAllLines(@"" + filename);
            string ConnStr = @"Provider=Microsoft.ACE.OLEDB.12.0;Data Source=" + filename2 + ";Jet OLEDB:Database Password=password";
            OleDbConnection MyConn = new OleDbConnection(ConnStr);

            int num_lines = 0;

            int first = 0;

            foreach (string line in lines)
            {

                if (num_lines % 100 == 0)
                {
                    MyConn.Open();
                }

                if (first == 0)
                {
                    first++;
                }
                else
                {
                    string[] words = line.Split(';');

                    if (words[1].Length > 0 && words[0].Replace("'", "").Trim().Length > 0)
                    {
                        string StrCmd = "UPDATE ItemSellingPrices SET TaxIncludedPrice = '" + Convert.ToDouble(words[1]).ToString() + "', UnitPrice = '" + (Convert.ToDouble(words[1]) / 1.23).ToString() + "' WHERE ItemID = '" + words[0].Replace("'", "") + "' AND PriceLineID = 3";
                        OleDbCommand Cmd = new OleDbCommand(StrCmd, MyConn);
                        OleDbDataReader ObjReader = Cmd.ExecuteReader();
                    }

                }

                if (num_lines % 100 == 99 || num_lines == lines.Length - 1)
                {
                    MyConn.Close();
                }

                num_lines++;
                Console.WriteLine(num_lines + " de " + lines.Length.ToString());
            }
        }
    }
}
