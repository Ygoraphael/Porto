using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ConsoleApplication2
{
    class Program
    {
        static void Main(string[] args)
        {
            string[] lines = System.IO.File.ReadAllLines(@"C:\Users\Tiago Loureiro\Desktop\GeodisBM_25044182.xml");
            string[] lines2 = new string[lines.Length];
            int i = 0;

            foreach (string line in lines)
            {
                if (line.Trim().Length > 14)
                {
                    if (line.Trim().Substring(0, 15) == "<InvoiceNo>PS4A")
                    {
                        lines2[i] = "				<InvoiceNo>FT PS4A/" + line.Trim().Substring(15, 4) + "</InvoiceNo>";
                    }
                    else
                    {
                        lines2[i] = line;
                    }
                }
                else
                {
                    lines2[i] = line;
                }
                i++;
            }

            System.IO.File.WriteAllLines(@"C:\Users\Tiago Loureiro\Desktop\GeodisBM_25044182_novo.xml", lines2);
            Console.WriteLine("Finito");
            Console.Read();
        }
    }
}
