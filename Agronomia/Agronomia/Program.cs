using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Windows.Forms;
using Agronomia.view;
using Agronomia.TelaPrincipal;
namespace Agronomia
{
    static class Program
    {
        /// <summary>
        /// Ponto de entrada principal para o aplicativo.
        /// </summary>
        [STAThread]
        static void Main()
        {
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            /*FrmLogin login = new FrmLogin();
            login.ShowDialog();
            if (login.Logado)
            {*/
            TCarregamento frm = new TCarregamento();
            frm.ShowDialog();
                Application.Run(new FrmPrincipal());
            //}
        }
    }
}
