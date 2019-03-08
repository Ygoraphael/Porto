using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.IO;
using System.Diagnostics;

namespace NCFTPCleaner
{
    class Program
    {

        static void Main(string[] args)
        {
            //age trade
            string Server = "ftp://novoscanais.com";
            string User = "agetrade@novoscanais.com";
            string Password = "age2030!+";

            string Directory = "/";
            FtpWebRequest request = null;
            FtpWebResponse response = null;
            Stream responseStream = null;
            StreamReader reader = null;

            String tipo = args[0];
            String executavel = args[1];
            String odbc = args[2];
            String basedados = args[3];
            String utilizador = args[4];
            String senha = args[5];


            //apagar tudo
            request = (FtpWebRequest)WebRequest.Create(Server + Directory);
            request.Method = System.Net.WebRequestMethods.Ftp.ListDirectory;
            request.Credentials = new System.Net.NetworkCredential(User, Password);
            response = (FtpWebResponse)request.GetResponse();
            responseStream = (Stream)response.GetResponseStream();
            reader = new StreamReader(responseStream);

            while (!reader.EndOfStream)
            {
                String strTemp = reader.ReadLine();
                String[] words = strTemp.Split(' ');
                String fileName = words[words.Length - 1];
                if (fileName.Length > 10 && fileName.Contains("importado"))
                {
                    request = (FtpWebRequest)WebRequest.Create(Server + Directory + strTemp);
                    Console.WriteLine(strTemp);
                    request.Method = System.Net.WebRequestMethods.Ftp.DeleteFile;
                    request.Credentials = new System.Net.NetworkCredential(User, Password);
                    request.GetResponse();

                }
            }
            reader.Close();
            response.Close();



            if (tipo == "sede")
            {
                request = (FtpWebRequest)WebRequest.Create(Server + Directory);
                request.Method = System.Net.WebRequestMethods.Ftp.ListDirectory;
                request.Credentials = new System.Net.NetworkCredential(User, Password);
                response = (FtpWebResponse)request.GetResponse();
                responseStream = (Stream)response.GetResponseStream();
                reader = new StreamReader(responseStream);

                while (!reader.EndOfStream)
                {
                    String strTemp = reader.ReadLine();
                    if (strTemp.Trim() == "__SD__")
                    {
                        Process p = new Process();
                        p.StartInfo.FileName = executavel;
                        p.StartInfo.Arguments = "POSGESTIMP " + odbc + " " + basedados + " " + utilizador + " " + senha;
                        p.StartInfo.CreateNoWindow = true;
                        p.Start();
                        p.WaitForExit();

                        p = new Process();
                        p.StartInfo.FileName = executavel;
                        p.StartInfo.Arguments = "GESTPOSEXP " + odbc + " " + basedados + " " + utilizador + " " + senha;
                        p.StartInfo.CreateNoWindow = true;
                        p.Start();
                        p.WaitForExit();

                        request = (FtpWebRequest)WebRequest.Create(Server + Directory + "__SD__");
                        request.Method = WebRequestMethods.Ftp.Rename;
                        request.Credentials = new System.Net.NetworkCredential(User, Password);
                        request.RenameTo = "__CLIMP__";
                        request.GetResponse();
                        break;
                    }
                }
            }
            else if (tipo == "loja")
            {
                request = (FtpWebRequest)WebRequest.Create(Server + Directory);
                request.Method = System.Net.WebRequestMethods.Ftp.ListDirectory;
                request.Credentials = new System.Net.NetworkCredential(User, Password);
                response = (FtpWebResponse)request.GetResponse();
                responseStream = (Stream)response.GetResponseStream();

                reader = new StreamReader(responseStream);
                while (!reader.EndOfStream)
                {
                    String strTemp = reader.ReadLine();
                    if (strTemp.Trim() == "__CLEXP__")
                    {
                        Process p = new Process();
                        p.StartInfo.FileName = executavel;
                        p.StartInfo.Arguments = "POSGESTEXP " + odbc + " " + basedados + " " + utilizador + " " + senha;
                        p.StartInfo.CreateNoWindow = true;
                        p.Start();
                        p.WaitForExit();

                        request = (FtpWebRequest)WebRequest.Create(Server + Directory + "__CLEXP__");
                        request.Method = WebRequestMethods.Ftp.Rename;
                        request.Credentials = new System.Net.NetworkCredential(User, Password);
                        request.RenameTo = "__SD__";
                        request.GetResponse();
                        break;
                    }
                    if (strTemp.Trim() == "__CLIMP__")
                    {
                        Process p = new Process();
                        p.StartInfo.FileName = executavel;
                        p.StartInfo.Arguments = "GESTPOSIMP " + odbc + " " + basedados + " " + utilizador + " " + senha;
                        p.StartInfo.CreateNoWindow = true;
                        p.Start();
                        p.WaitForExit();

                        request = (FtpWebRequest)WebRequest.Create(Server + Directory + "__CLIMP__");
                        request.Method = WebRequestMethods.Ftp.Rename;
                        request.Credentials = new System.Net.NetworkCredential(User, Password);
                        request.RenameTo = "__CLEXP__";
                        request.GetResponse();
                        break;
                    }
                }
            }
        }
    }
}
