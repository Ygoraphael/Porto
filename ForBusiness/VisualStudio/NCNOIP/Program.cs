﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.IO;
using Microsoft.Win32;

namespace NCNOIP
{
    class Program
    {
        static void Main(string[] args)
        {
            string path = Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly().Location);
            string name = Path.GetFileNameWithoutExtension(System.Reflection.Assembly.GetEntryAssembly().Location);
            try
            {
                name = name.Substring(7, name.Length - 7);
            }
            catch (Exception e)
            {
                Console.WriteLine("Nao existe ficheiro de configuração no nome do executavels.\nPressionar ENTER para continuar.");
                Console.Read();
                return;
            }

            string[] main_lines;
            try
            {
                main_lines = System.IO.File.ReadAllLines(@"" + path + "\\" + name + ".cfg");
            }
            catch (Exception e)
            {
                Console.WriteLine("Nao existe ficheiro " + path + "\\" + name + ".cfg" + "\n.Crie um e volte a tentar.\nPressionar ENTER para continuar.");
                Console.Read();
                return;
            }
            string[] fields;
            string address;
            string main_address = "";
            string ODBC_PATH = "SOFTWARE\\ODBC\\ODBC.INI\\";
            string driverName = "";
            string dsnName = name;
            string database = "";
            string description = "DSN criada com NCNOIP";
            string port = "";
            string instance = "";
            string user = "";
            string password = "";
            bool trustedConnection = false;


            foreach (string line in main_lines)
            {
                fields = line.Split('=');

                switch (fields[0])
                {
                    case "address":
                        main_address = fields[1].Trim();
                        break;
                    case "driverName":
                        driverName = fields[1].Trim();
                        break;
                    case "database":
                        database = fields[1].Trim();
                        break;
                    case "port":
                        port = fields[1].Trim();
                        break;
                    case "instance":
                        instance = fields[1].Trim();
                        break;
                    case "user":
                        user = fields[1].Trim();
                        break;
                    case "password":
                        password = fields[1].Trim();
                        break;
                    default:
                        break;
                }
            }

            try
            {
                address = Dns.GetHostAddresses(main_address)[0].ToString();
                string server = address + "\\" + instance + ", " + port;

                // Lookup driver path from driver name         
                string driverPath = "C:\\WINDOWS\\System32\\sqlsrv32.dll";

                var datasourcesKey = Registry.LocalMachine.CreateSubKey(ODBC_PATH + "ODBC Data Sources");
                if (datasourcesKey == null)
                {
                    throw new Exception("ODBC Registry key does not exist");
                }
                datasourcesKey.SetValue(dsnName, driverName);
                // Create new key in odbc.ini with dsn name and add values        
                var dsnKey = Registry.LocalMachine.CreateSubKey(ODBC_PATH + dsnName);
                if (dsnKey == null)
                {
                    throw new Exception("ODBC Registry key for DSN was not created");
                }

                dsnKey.SetValue("Database", database);
                dsnKey.SetValue("Description", description);
                dsnKey.SetValue("Driver", driverPath);
                dsnKey.SetValue("LastUser", user);
                dsnKey.SetValue("Server", server);
                dsnKey.SetValue("Database", database);
                dsnKey.SetValue("username", user);
                dsnKey.SetValue("password", password);
                dsnKey.SetValue("AnsiNPW", "no");
                dsnKey.SetValue("QuotedId", "no");
                dsnKey.SetValue("AutoTranslate", "no");
                dsnKey.SetValue("Trusted_Connection", trustedConnection ? "Yes" : "No");
            }
            catch(Exception e)
            {
                Console.WriteLine("Endereco nao encontrado.\nVerifique se introduziu correctamente..\nPressionar ENTER para continuar.");
                Console.Read();
                return;
            }
        }
    }
}