using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Configuration;

namespace PrioridadeVirtualRent
{
    public partial class Preferencias : Form
    {
        Config configuracao = new Config();

        public Preferencias()
        {
            InitializeComponent();
            this.CenterToScreen();
            textBox1.Text = configuracao.get_data("basedados");
        }

        private void button1_Click(object sender, EventArgs e)
        {
            OpenFileDialog openFileDialog1 = new OpenFileDialog();
            openFileDialog1.Filter = "Access (.mdb)|*.mdb";
            openFileDialog1.FilterIndex = 1;
            DialogResult result = openFileDialog1.ShowDialog();
            if (result == DialogResult.OK)
            {
                textBox1.Text = openFileDialog1.FileName.ToString();
            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            configuracao.set_data("basedados", textBox1.Text);
            MessageBox.Show("Dados Guardados Com Sucesso. Por favor reinicie a aplicação.");
        }
    }
}
