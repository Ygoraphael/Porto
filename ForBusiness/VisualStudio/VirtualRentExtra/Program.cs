using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Timers;
using System.Data;
using System.Diagnostics;

namespace VirtualRentExtra
{
    class Program
    {
        public static Config configuracao;
        public static BaseDados bd;

        static void Main(string[] args)
        {
            initialize();
        }

        static void initialize()
        {
            configuracao = new Config();
            bd = new BaseDados();

            System.Timers.Timer aTimer = new System.Timers.Timer();
            aTimer.Elapsed += new ElapsedEventHandler(OnTimedEvent);
            aTimer.Interval = Convert.ToInt32(configuracao.get_data("correct_time")) * 1000;
            aTimer.Enabled = true;
            Console.Read();
        }

        private static void OnTimedEvent(object source, ElapsedEventArgs e)
        {
            atualizar_mesreferencia();
        }

        static public void DebugTable(DataTable table)
        {
            Debug.WriteLine("--- DebugTable(" + table.TableName + ") ---");
            int zeilen = table.Rows.Count;
            int spalten = table.Columns.Count;

            // Header
            for (int i = 0; i < table.Columns.Count; i++)
            {
                string s = table.Columns[i].ToString();
                Debug.Write(String.Format("{0,-20} | ", s));
            }
            Debug.Write(Environment.NewLine);
            for (int i = 0; i < table.Columns.Count; i++)
            {
                Debug.Write("---------------------|-");
            }
            Debug.Write(Environment.NewLine);

            // Data
            for (int i = 0; i < zeilen; i++)
            {
                DataRow row = table.Rows[i];
                //Debug.WriteLine("{0} {1} ", row[0], row[1]);
                for (int j = 0; j < spalten; j++)
                {
                    string s = row[j].ToString();
                    if (s.Length > 20) s = s.Substring(0, 17) + "...";
                    Debug.Write(String.Format("{0,-20} | ", s));
                }
                Debug.Write(Environment.NewLine);
            }
            for (int i = 0; i < table.Columns.Count; i++)
            {
                Debug.Write("---------------------|-");
            }
            Debug.Write(Environment.NewLine);
        }

        static String AtribuiMes(String mes)
        {
            switch (mes)
            {
                case "Janeiro":
                    Console.WriteLine("");
                    break;
                case "Fevereiro":
                    Console.WriteLine("");
                    break;
            }
            return "";
        }

        static void atualizar_mesreferencia()
        {

            DataTable dt = bd.select_query("select ID, MesReferencia, AnoMesRef from Servicos");
            foreach (DataRow dr in dt.Rows)
            {

            }
        }
    }
}
