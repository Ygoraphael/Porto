using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace Goris_nomeimagensparaprodutos
{
    class Program
    {
        static void Main(string[] args)
        {
            //ouro
            DirectoryInfo d = new DirectoryInfo(@"C:\Users\Tiago Loureiro\Desktop\goris_artigos\ouro\");
            FileInfo[] Files = d.GetFiles("*");
            string text = "";
            string tmp = "";
            foreach (FileInfo file in Files)
            {
                tmp = file.Name.Replace("  ", ";").Replace(" ", ";").Replace("â‚¬", "€");
                text += tmp.Substring(0, tmp.Length - 4) + ";" + file.Name + "\n";
            }
            System.IO.File.WriteAllText(@"C:\Users\Tiago Loureiro\Desktop\goris_artigos\ouro.csv", text, Encoding.UTF8);

            //prata
            d = new DirectoryInfo(@"C:\Users\Tiago Loureiro\Desktop\goris_artigos\prata\");
            Files = d.GetFiles("*");
            text = "";
            foreach (FileInfo file in Files)
            {
                tmp = file.Name.Replace("  ", ";").Replace(" ", ";").Replace("â‚¬", "€");
                text += tmp.Substring(0, tmp.Length - 4) + ";" + file.Name + "\n";
            }
            System.IO.File.WriteAllText(@"C:\Users\Tiago Loureiro\Desktop\goris_artigos\prata.csv", text, Encoding.UTF8);


            Console.WriteLine(".::::Prime Enter Para Continuar::::.");
            Console.Read();
        }
    }
}
