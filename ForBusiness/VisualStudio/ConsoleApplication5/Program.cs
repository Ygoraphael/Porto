using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Web;
using Spire.Xls;

namespace ConsoleApplication5
{
    class Program
    {
        static void Main(string[] args)
        {
            Workbook workbook = new Workbook();
            workbook.LoadFromFile("C:\\Users\\Tiago Loureiro\\Desktop\\boletim_analitico20140320165743.xls", Spire.Xls.ExcelVersion.Version97to2003);
            workbook.SaveToFile("C:\\Users\\Tiago Loureiro\\Desktop\\result.pdf", Spire.Xls.FileFormat.PDF);

        }
    }
}
