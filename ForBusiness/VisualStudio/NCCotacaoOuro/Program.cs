using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using HtmlAgilityPack;
using System.IO;

namespace NCCotacaoOuro
{
    class Program
    {
        static void Main(string[] args)
        {
            //ligacao a base dados
            string path = Path.GetDirectoryName(System.Reflection.Assembly.GetEntryAssembly().Location);
            string[] main_lines;
            try
            {
                main_lines = System.IO.File.ReadAllLines(@"" + path + "\\nccotacaoouro.cfg");
            }
            catch (Exception e)
            {
                Console.WriteLine("Nao existe ficheiro " + path + "\\nccotacaoouro.cfg" + "\n.Crie um e volte a tentar.\nPressionar ENTER para continuar.");
                Console.Read();
                return;
            }
            string[] fields;
            string database = "";
            string serv = "";
            string user = "";
            string password = "";
            bool trustedConnection = false;


            foreach (string line in main_lines)
            {
                fields = line.Split('=');

                switch (fields[0])
                {
                    case "database":
                        database = fields[1].Trim();
                        break;
                    case "serv":
                        serv = fields[1].Trim();
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

            BaseDados bd = new BaseDados();
            bd.Servidor = serv;
            bd.BDados = database;
            bd.Utilizador = user;
            bd.Password = password;
            bd.Open();

            //ligar a apio
            var webGet = new HtmlWeb();
            var document = webGet.Load("http://www.apio.pt/cotacoes.php");
            var tabela = document.DocumentNode.SelectNodes("//table[@class='tabela-generica']//tbody//tr");
            DateTime saveNow = DateTime.Now;
            var data = saveNow.ToString("yyyy-MM-dd");

            if (tabela != null)
            {
                var content = tabela[0].SelectNodes("//td");
                String sqlquery = @"
                                    If Not Exists(select * from ncouro_cotacao where dia='" + content[4].InnerHtml.Trim() + @"')
                                    Begin
                                        insert into ncouro_cotacao (dia, ouro, prata) 
                                        values (
                                            '" + content[4].InnerHtml.Trim() + @"',
                                            '" + content[5].InnerHtml.Trim().Replace(',', '.') + @"',
                                            '" + content[6].InnerHtml.Trim().Replace(',', '.') + @"'
                                               )
                                    End";
                bd.RunQuery(sqlquery);
            }

            bd.Close();
        }
    }
}
