using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Net;
using System.Threading.Tasks;

namespace AtualizaArquivosPHC
{
    class Program
    {
        static void Main(string[] args)
        {
            string path = System.AppDomain.CurrentDomain.BaseDirectory.ToString();
            
            path = path + "ParamNC.txt";
            Console.WriteLine(path);
            System.IO.StreamReader file = new System.IO.StreamReader(@path);
            String llocalFile = "";
            String lremoteFile = "/Exec/";
            int counter = 0;
            string tmpline;
            while ((tmpline = file.ReadLine()) != null)
            {
                if (counter == 0)
                {
                    llocalFile = llocalFile + tmpline;
                }
                else {
                    if (counter == 1)
                    {
                        lremoteFile = lremoteFile + tmpline;
                    }
                }
                counter++;
            }

            if ((llocalFile != "") && (lremoteFile != "/Exec/"))
            { 
                String _host = "ftp.novoscanais.com";
                
                
                String lusername = "cliente@novoscanais.com";
                String lpassword = "nc2018!+";
                String lCompleteWay = "ftp://" + _host + lremoteFile;
                FtpWebResponse response;
                FtpWebRequest request;
                bool Atualizar = false;
                Atualizar = VerificaStatus(lusername, lpassword, lCompleteWay + "/Atualizar.txt");

                if (Atualizar)
                {
                    request = (FtpWebRequest)WebRequest.Create(lCompleteWay);
                    request.Credentials = new NetworkCredential(lusername, lpassword);
                    request.Method = WebRequestMethods.Ftp.ListDirectory;
                    response = (FtpWebResponse)request.GetResponse();
                    StreamReader streamReader = new StreamReader(response.GetResponseStream());
                    string line = streamReader.ReadLine();
                    while (!string.IsNullOrEmpty(line))
                    {
                        if ((line != ".") && (line != "..") && (line != ""))
                        {
                            Console.WriteLine("servidor" +lCompleteWay + "/" + line);
                            Console.WriteLine("local: "+llocalFile + "/" + line);
                            CopiaArquivos(lusername, lpassword, lCompleteWay + "/" + line, llocalFile + "/" + line);
                        }
                        line = streamReader.ReadLine();
                    }
                    streamReader.Close();
                }
                else
                {
                    Console.WriteLine("Sem atualizações!!!!!!!");
                }
            }
            Console.WriteLine("Finalizado!!!!!!!");
            Console.ReadKey();
        }


        public static bool VerificaStatus (String puser, String ppass, String pFtp)
        {
            bool retorno = false;
            using (WebClient client = new WebClient())
            {
                client.Credentials = new NetworkCredential(puser, ppass);
                String Texto = client.DownloadString(pFtp);
                if (Texto.ToUpper().Trim() == "TRUE")
                {
                    retorno = true;
                }
            }

            return retorno;
        }

        public static void CopiaArquivos(String puser, String ppass, String pFtp, String pLocalFiles)
        {
            using (WebClient client = new WebClient())
            {
                client.Credentials = new NetworkCredential(puser, ppass);
                byte[] fileData = client.DownloadData(pFtp);
                using (FileStream file = File.Create(pLocalFiles))
                {
                    file.Write(fileData, 0, fileData.Length);
                    file.Close();
                }
            }

        }

    }
}
