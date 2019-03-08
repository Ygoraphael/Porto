using System;
using System.Collections.Generic;
using System.Linq;
using System.Windows.Forms;

namespace SQLPROFILER
{
    static class Program
    {
        [STAThread]
        static void Main()
        {
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);

            Form[] arrayform = new Form[10];

            for (int i = 0; i < 3; i++)
            {
                MessageBox.Show("O nome do cliente tem de ser preenchido!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
