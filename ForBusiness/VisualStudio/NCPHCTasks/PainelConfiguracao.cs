using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Data.SqlClient;
using System.Configuration;


namespace NCPHCTasks
{
    public partial class PainelConfiguracao : Form
    {
        public PainelConfiguracao()
        {
            InitializeComponent();
            textBox1.Text = Properties.Settings.Default.servidor;
            textBox3.Text = Properties.Settings.Default.basedados;
            textBox4.Text = Properties.Settings.Default.utilizador;
            textBox5.Text = Properties.Settings.Default.password;
        }

        private void button3_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            BaseDados bd = new BaseDados();
            bd.Teste(textBox1.Text, textBox3.Text, textBox4.Text, textBox5.Text);
        }

        private void Button1_Click(object sender, EventArgs e)
        {
            Properties.Settings.Default.servidor = textBox1.Text;
            Properties.Settings.Default.basedados = textBox3.Text;
            Properties.Settings.Default.utilizador = textBox4.Text;
            Properties.Settings.Default.password = textBox5.Text;
            Properties.Settings.Default.Save();
        }
    }
}
