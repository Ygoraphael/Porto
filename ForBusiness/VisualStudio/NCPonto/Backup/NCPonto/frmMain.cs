using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;

namespace NCPonto
{
    public partial class frmMain : Form
    {
        public frmMain()
        {
            InitializeComponent();
        }

        private void frmMain_Load(object sender, EventArgs e)
        {
            timer1.Enabled = true;                        
        }

        private void btnSaida_Click(object sender, EventArgs e)
        {
            AbreFrmPico("SAIR DO SERVIÇO");
        }

        private void btnEntrada_Click(object sender, EventArgs e)
        {
            AbreFrmPico("ENTRAR AO SERVIÇO");
        }
        private void AbreFrmPico(string titulo)
        {
            frmPicar frm = new frmPicar(titulo);
            frm.ShowDialog();
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            DateTime dat = DateTime.Now;
            lblHora.Text = dat.ToString("HH:mm:ss");
        }

        private void button1_Click(object sender, EventArgs e)
        {
            frmFO frm = new frmFO("INICIAR TAREFA");
            frm.ShowDialog();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            frmFO frm = new frmFO("TERMINAR TAREFA");
            frm.ShowDialog();
        }

    }
}
