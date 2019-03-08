using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

using System.IO;
using System.Windows.Forms;

namespace Kribo.StoringImages.Model
{
    class dBFunctions
    {
        public static string ConnectionStringSQLite
        {
            get
            {
                string path = Application.StartupPath;
                string curFile = @"" + path + "\\posto.cfg";

                System.IO.StreamReader ficheiro_conf = new System.IO.StreamReader(curFile);
                string linha_conf = ficheiro_conf.ReadLine();
                string[] words = linha_conf.Split('=');

                string caminho_base_dados = words[1];

                string database = caminho_base_dados;
                string connectionString = @"Data Source=" + Path.GetFullPath(database);
                return connectionString;
            }
        }
    }
}
