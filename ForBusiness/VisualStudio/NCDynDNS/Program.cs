using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.Text.RegularExpressions;
using System.IO;

namespace NCDynDNS
{
    class Program
    {
        static void Main(string[] args)
        {
            // dados servidor
            string url = "ftp://ftp.novoscanais.com";
            string user = "dyndns@novoscanais.com";
            string pw = "t5rPNGzg";
            // dados cliente
            string hash = System.AppDomain.CurrentDomain.FriendlyName.Substring(9, System.AppDomain.CurrentDomain.FriendlyName.Length - 4 - 9);
            string ip = getCurrentIp();
            
            // envia ip
            criaficheiro(hash, ip);
            ftp ftpClient = new ftp(@"" + url, user, pw);
            ftpClient.upload("/" + hash, @"" + System.IO.Path.GetTempPath() + hash + ".ncdyn");
            apagaficheiro(hash);
        }

        static void apagaficheiro(string hash)
        {
            string path = @"" + System.IO.Path.GetTempPath() + hash + ".ncdyn";
            if (File.Exists(path))
            {
                File.Delete(path);
            }
        }

        static void criaficheiro(string hash, string ip) {
            string path = @"" + System.IO.Path.GetTempPath() + hash + ".ncdyn";
            if (File.Exists(path))
            {
                File.Delete(path);
            }
            using (FileStream fs = File.Create(path))
            {
                Byte[] info = new UTF8Encoding(true).GetBytes(ip);
                fs.Write(info, 0, info.Length);
            }
        }

        static string getCurrentIp() {
            try {
                string externalIP;
                externalIP = (new WebClient()).DownloadString("http://checkip.dyndns.org/");
                externalIP = (new Regex(@"\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}")).Matches(externalIP)[0].ToString();
                return externalIP;
            }
            catch { return null; }
        }
    }
}
