using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Diagnostics;
using System.Collections;

namespace EtmaAtividadesSplit
{
    class Program
    {
        static void Main(string[] args)
        {
            String cpath = AppDomain.CurrentDomain.BaseDirectory;
            string[] lines = System.IO.File.ReadAllLines(@"" + cpath + "atividades.csv", Encoding.GetEncoding(1252));
            int cline = 0;
            int cname = 1;
            int fline = 0;
            ArrayList clines = new ArrayList();
            string flinestr = "";

            foreach (string line in lines)
            {
                if( fline == 0 ) {
                    flinestr = line;
                    fline = 1;
                }

                if (cline == 0)
                {
                    //abre novo ficheiro
                    clines = new ArrayList();
                    clines.Add(flinestr);
                    cline++;
                }
                else if (cline == 3000)
                {
                    //fechar ficheiro
                    System.IO.File.WriteAllLines(@"" + cpath + "atividades_" + cname + ".csv", clines.Cast<string>());
                    cline = 0;
                    cname++;
                }
                else {
                    clines.Add(line);
                    cline++;
                }
            }

            if (cline > 0)
            {
                //fechar ficheiro
                System.IO.File.WriteAllLines(@"" + cpath + "atividades_" + cname + ".csv", clines.Cast<string>());
            }
        }
    }
}
