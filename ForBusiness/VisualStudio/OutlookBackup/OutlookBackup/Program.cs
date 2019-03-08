using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Configuration;
using System.Diagnostics;
using System.Management;
using System.Net.Sockets;
using System.Net.NetworkInformation;
using System.Net;
using System.Security.Principal;
using System.IO;
using System.Runtime.InteropServices;
using System.IO.Compression;


namespace OutlookBackup
{
    class Program
    {
        static void Main(string[] args)
        {
            string _PstLocation = System.Configuration.ConfigurationManager.AppSettings["PstLocation"];
            string _Email = System.Configuration.ConfigurationManager.AppSettings["Email"];
            string _LastBackup = System.Configuration.ConfigurationManager.AppSettings["LastBackup"];
            string _DestinyIP = System.Configuration.ConfigurationManager.AppSettings["DestinyIP"];
            string _DestinyMAC = System.Configuration.ConfigurationManager.AppSettings["DestinyMAC"];
            string _DestinyFolder = System.Configuration.ConfigurationManager.AppSettings["DestinyFolder"];
            string _DestinyFolderUsername = System.Configuration.ConfigurationManager.AppSettings["DestinyFolderUsername"];
            string _DestinyFolderDomain = System.Configuration.ConfigurationManager.AppSettings["DestinyFolderDomain"];
            string _DestinyFolderPassword = System.Configuration.ConfigurationManager.AppSettings["DestinyFolderPassword"];

            DateTime dt = Convert.ToDateTime(_LastBackup);
            DateTime now = DateTime.Now;

            //verificar se é necessário o backup
            if (dt.Date < now.Date)
            {
                //verificar se consegue fazer ping a file server
                if (PingHost(_DestinyIP))
                {
                    //verificar se MAC bate certo com o MAC do file server
                    if (GetMacAddress(_DestinyIP).ToString().Trim().Equals(_DestinyMAC.ToString().Trim()))
                    {
                        string domain_user = "";
                        try
                        {

                            Console.WriteLine("Outlook backup in process");

                            if (_DestinyFolderDomain.ToString().Trim().Length > 0)
                            {
                                domain_user = _DestinyFolderDomain + "\\" + _DestinyFolderUsername;
                            }
                            else
                            {
                                domain_user = _DestinyFolderUsername;
                            }
                            string result = PinvokeWindowsNetworking.connectToRemote(@"\\" + _DestinyIP, @"" + _DestinyFolderUsername, _DestinyFolderPassword);
                            string extension = Path.GetExtension(_PstLocation);
                            string file_date = now.Date.ToShortDateString().Trim().Replace('/', '-');

                            File.Copy(@"" + _PstLocation, @"\\" + _DestinyIP + "\\" + _DestinyFolder + "\\" + _Email + "_" + file_date + extension, true);
                            File.SetCreationTime(@"\\" + _DestinyIP + "\\" + _DestinyFolder + "\\" + _Email + "_" + file_date + extension, now);
                            File.SetLastWriteTime(@"\\" + _DestinyIP + "\\" + _DestinyFolder + "\\" + _Email + "_" + file_date + extension, now);

                            foreach (var fi in new DirectoryInfo(@"\\" + _DestinyIP + "\\" + _DestinyFolder).GetFiles().OrderByDescending(x => x.LastWriteTime).Skip(5))
                            {
                                fi.Delete();
                            }

                            SetLastBackup();

                            Console.WriteLine("Outlook backup completed");
                        }
                        catch (Exception ex)
                        {
                            Console.WriteLine(ex);
                            return;
                        }
                    }
                    else
                    {
                        Console.WriteLine("mac address not the same");
                    }
                }
                else
                {
                    Console.WriteLine("cant find ip");
                }
            }
            else
            {
                Console.WriteLine("backup not needed");
            }
            return;
        }

        static void SetLastBackup()
        {
            string appPath = System.IO.Path.GetDirectoryName(System.Reflection.Assembly.GetExecutingAssembly().Location);
            string configFile = System.IO.Path.Combine(appPath, "OutlookBackup.exe.config");
            ExeConfigurationFileMap configFileMap = new ExeConfigurationFileMap();
            configFileMap.ExeConfigFilename = configFile;
            System.Configuration.Configuration config = ConfigurationManager.OpenMappedExeConfiguration(configFileMap, ConfigurationUserLevel.None);
            config.AppSettings.Settings["LastBackup"].Value = DateTime.Now.ToString("yyyy-MM-dd");
            config.Save(); 
        }

        static string GetMacAddress(string ipAddress)
        {
            string macAddress = string.Empty;
            System.Diagnostics.Process pProcess = new System.Diagnostics.Process();
            pProcess.StartInfo.FileName = "arp";
            pProcess.StartInfo.Arguments = "-a " + ipAddress;
            pProcess.StartInfo.UseShellExecute = false;
            pProcess.StartInfo.RedirectStandardOutput = true;
            pProcess.StartInfo.CreateNoWindow = true;
            pProcess.Start();
            string strOutput = pProcess.StandardOutput.ReadToEnd();
            string[] substrings = strOutput.Split('-');
            if (substrings.Length >= 8)
            {
                macAddress = substrings[3].Substring(Math.Max(0, substrings[3].Length - 2))
                         + "-" + substrings[4] + "-" + substrings[5] + "-" + substrings[6]
                         + "-" + substrings[7] + "-"
                         + substrings[8].Substring(0, 2);
                return macAddress;
            }

            else
            {
                return "-";
            }
        }

        static bool PingHost(string _HostURI)
        {
            Ping x = new Ping();
            PingReply reply = x.Send(IPAddress.Parse(_HostURI));

            if (reply.Status == IPStatus.Success)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
