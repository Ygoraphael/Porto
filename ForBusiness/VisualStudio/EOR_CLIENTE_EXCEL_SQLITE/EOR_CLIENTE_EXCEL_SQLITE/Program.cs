using System;
using System.Collections.Generic;
using System.Text;
using System.Data;
using System.Data.SQLite;
using System.IO;
using System.Reflection;
using NPOI;
using NPOI.HSSF.UserModel;
using NPOI.SS.UserModel;

namespace EOR_CLIENTE_EXCEL_SQLITE
{
    class Program
    {

        static void Main(string[] args)
        {

            SQLiteConnection sqlite;
            //string path = Path.GetDirectoryName(Assembly.GetEntryAssembly().Location);
            //string curFile = path + "\\dris.db";

            //sqlite = new SQLiteConnection("Data Source=" + curFile + ";Version=3;");

            //Dictionary<string, List<string>> dic = new Dictionary<string, List<string>>();
            //List<string> tmp;
            //string temporary = "";
            //string[] words;
            //string excelpath = path + "\\clientes.csv";

            //using (StreamReader sr = new StreamReader(excelpath))
            //{
            //    while (sr.Peek() >= 0)
            //    {
                    
            //        temporary = sr.ReadLine();
            //        words = temporary.Split(';');

            //        if (dic.ContainsKey(words[4]))
            //        {
            //            if (dic[words[4]].Count < words.Length - 1)
            //            {
            //                tmp = new List<string>();
            //                tmp.Add(words[0]);
            //                tmp.Add(words[1]);
            //                tmp.Add(words[2]);
            //                tmp.Add(words[3]);

            //                dic.Remove(words[4]);
            //                dic.Add(words[4], tmp);
            //            }
            //        }
            //        else
            //        {
            //            tmp = new List<string>();
            //            tmp.Add(words[0]);
            //            tmp.Add(words[1]);
            //            tmp.Add(words[2]);
            //            tmp.Add(words[3]);
            //            dic.Add(words[4], tmp);
            //        }
            //    }
            //}

            //sqlite.Open();

            //foreach (KeyValuePair<string, List<string>> entry in dic)
            //{
            //    string sql = "insert into CLIENTE (nome, morada, cod_postal, telefone, nif) values (@text1, @text2, @text3, @text4, @text5)";
                
            //    SQLiteCommand command = new SQLiteCommand(sql, sqlite);

            //    command.Parameters.AddWithValue("@text1", entry.Value[0]);
            //    command.Parameters.AddWithValue("@text2", entry.Value[1]);
            //    command.Parameters.AddWithValue("@text3", entry.Value[2]);
            //    command.Parameters.AddWithValue("@text4", entry.Value[3]);
            //    command.Parameters.AddWithValue("@text5", entry.Key);
            //    command.ExecuteNonQuery();
            //}



            

            //string sql = "insert into CLIENTE (nome, morada) values ('teste', 'teste2')";

            //SQLiteCommand command = new SQLiteCommand(sql, sqlite);
            //command.ExecuteNonQuery();

            //sql = "insert into CLIENTE (nome, morada) values ('teste3', 'teste4')";
            //command = new SQLiteCommand(sql, sqlite);
            //command.ExecuteNonQuery();

            //sql = "insert into CLIENTE (nome, morada) values ('teste5', 'teste6')";
            //command = new SQLiteCommand(sql, sqlite);
            //command.ExecuteNonQuery();




            string path = Path.GetDirectoryName(Assembly.GetEntryAssembly().Location);
            string curFile = "C:\\Users\\Tiago Loureiro\\Documents\\Visual Studio 2010\\Projects\\DRIS\\DRIS\\bin\\Debug\\dris.db";

            sqlite = new SQLiteConnection("Data Source=" + curFile + ";Version=3;");

            string culturaspath = path + "\\culturas.txt";
            string temporary = "";
            sqlite.Open();

            using (StreamReader sr = new StreamReader(culturaspath))
            {
                while (sr.Peek() >= 0)
                {
                    temporary = sr.ReadLine();
                    string sql = "insert into CULTURA (NOME) values (@text1)";

                    SQLiteCommand command = new SQLiteCommand(sql, sqlite);

                    command.Parameters.AddWithValue("@text1", temporary);
                    command.ExecuteNonQuery();
                }
            }
        }
    }
}
