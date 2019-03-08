using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.IO;
using System.Windows.Forms;

namespace UnikeyDynDNS
{
    class Program
    {
        static void Main(string[] args)
        {
            string path = Path.GetDirectoryName(Application.ExecutablePath);
            string[] main_lines;
            try
            {
                main_lines = System.IO.File.ReadAllLines(@"" + path + "\\main.cfg");
            }
            catch (Exception e)
            {
                Console.WriteLine("Nao existe ficheiro main.cfg\nCrie um e volte a tentar.\nPressionar ENTER para continuar.");
                Console.Read();
                return;
            }
            string[] fields;
            string main_address = "";
            foreach (string line in main_lines)
            {
                fields = line.Split('=');

                switch (fields[0])
                {
                    case "address":
                        main_address = fields[1].Trim();
                        break;
                    default:
                        break;
                }
            }

            string address;

            try
            {
                address = Dns.GetHostAddresses(main_address)[0].ToString();
            }
            catch(Exception e)
            {
                Console.WriteLine("Endereco nao encontrado.\nVerifique se introduziu correctamente..\nPressionar ENTER para continuar.");
                Console.Read();
                return;
            }

            string[] lines = new string[12];
            lines[0] = "[Header]";
            lines[1] = "FileType =NetUniKey.ini";
            lines[2] = "FileVersion  =1";
            lines[3] = "[General]";
            lines[4] = "WorkingMode  =4";
            lines[5] = "AccessMode =0";
            lines[6] = "[ServerSetting]";
            lines[7] = "SearchingMode  =1";
            lines[8] = "ServerIP =" + address.ToString();
            lines[9] = "Port  =5680";
            lines[10] = "TimeOut  =5";
            lines[11] = "AutoStart =0";

            System.IO.File.WriteAllLines(@"" + path + "\\NetUniKey.ini", lines);
        }
    }
}
