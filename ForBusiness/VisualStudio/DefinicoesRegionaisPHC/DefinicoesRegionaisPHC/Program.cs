using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Globalization;
using System.Diagnostics;

namespace DefinicoesRegionaisPHC
{
    class Program
    {
        static void Main(string[] args)
        {
            //Get current culture 
            string sCurrentCulture = System.Threading.Thread.CurrentThread.CurrentCulture.Name;
            CultureInfo ci;
            ci = new CultureInfo(sCurrentCulture);
            ci.NumberFormat.NumberDecimalSeparator = ",";
            System.Threading.Thread.CurrentThread.CurrentCulture = ci;
        }
    }
}
