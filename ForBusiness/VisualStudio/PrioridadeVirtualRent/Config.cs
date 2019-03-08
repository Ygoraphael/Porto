using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;
using System.Collections;

namespace PrioridadeVirtualRent
{
    class Config
    {
        public bool ConfExist()
        {
            string path = Application.StartupPath;
            string curFile = @"" + path + "\\vrp.prop";

            return File.Exists(curFile) ? true : false;
        }

        public string get_data(string prop)
        {
            string path = Application.StartupPath;
            string curFile = @"" + path + "\\vrp.prop";

            if (!ConfExist())
            {
                string[] lines = { "basedados=" };
                System.IO.File.WriteAllLines(@"" + curFile, lines);
                return "";
            }

            string line = "";
            string[] tmp = null;

            System.IO.StreamReader file = new System.IO.StreamReader(curFile);
            while( (line = file.ReadLine()) != null )
            {
                try 
                {
                    tmp = line.Split('=');
                    if (tmp[0] == prop)
                    {
                        file.Close();
                        return tmp[1];
                    }
                }
                catch{}
            }

            file.Close();
            return "";
        }

        public void set_data(string prop, string value)
        {
            string path = Application.StartupPath;
            string curFile = @"" + path + "\\vrp.prop";

            if (!ConfExist())
            {
                string[] lines = { "basedados=" };
                System.IO.File.WriteAllLines(@"" + curFile, lines);
            }
            else
            {
                string line = "";
                string[] tmp = null;
                StringBuilder sb = new StringBuilder();

                System.IO.StreamReader file = new System.IO.StreamReader(curFile);
                while ((line = file.ReadLine()) != null)
                {
                    try
                    {
                        tmp = line.Split('=');
                        if (tmp[0] == prop)
                        {
                            sb.AppendLine(prop + "=" + value);
                        }
                        else
                        {
                            sb.AppendLine(tmp[0] + "=" + tmp[1]);
                        }
                    }
                    catch { }
                }

                file.Close();

                using (StreamWriter outfile = new StreamWriter(@"" + curFile))
                {
                    outfile.Write(sb.ToString());
                }
            }
        }
    }
}
