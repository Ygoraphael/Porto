using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace EOR_DRIS
{
    public partial class SelExp : Form
    {
        public List<bool> resultado;
        public string caminho_excel = "";
        public string caminho_pdf = "";
        public string sel_template = "";
        public string template_calculos = "";
        public string num_colunas = "";

        public SelExp()
        {
            InitializeComponent();
            this.MinimumSize = new Size(346, 327);
            this.MaximumSize = new Size(346, 327);
            this.CenterToScreen();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            resultado = new List<bool>();
            caminho_excel = "";
            caminho_pdf = "";

            //documento 1
            if (checkBox1.Checked)
            {
                resultado.Add(true);
            }
            else
            {
                resultado.Add(false);
            }
            //documento 2
            if (checkBox2.Checked)
            {
                resultado.Add(true);
            }
            else
            {
                resultado.Add(false);
            }

            //excel
            if (checkBox3.Checked)
            {
                if (textBox1.Text.Trim() == "")
                {
                    MessageBox.Show("Indique por favor o local onde serão guardados os ficheiros Excel!", "Formato Excel", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return;
                }
                resultado.Add(true);
            }
            else
            {
                resultado.Add(false);
            }
            //pdf
            if (checkBox4.Checked)
            {
                if (textBox2.Text.Trim() == "")
                {
                    MessageBox.Show("Indique por favor o local onde serão guardados os ficheiros PDF!", "Formato PDF", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return;
                }
                resultado.Add(true);
            }
            else
            {
                resultado.Add(false);
            }

            int soma_trues_doc = 0;
            int soma_trues_for = 0;

            for (int i = 0; i < 2; i++)
            {
                if (resultado[i])
                {
                    soma_trues_doc++;
                }
            }

            for (int i = 2; i < 4; i++)
            {
                if (resultado[i])
                {
                    soma_trues_for++;
                }
            }

            if (soma_trues_doc == 0)
            {
                MessageBox.Show("Tem de seleccionar pelo menos um documento a exportar!", "Documento a Exportar", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else if (soma_trues_for == 0)
            {
                MessageBox.Show("Tem de seleccionar pelo menos um formato de exportação!", "Formato Exportação", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else if (comboBox1.Text.Trim() == "")
            {
                MessageBox.Show("Tem de seleccionar um template!", "Escolher Template", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else if (comboBox2.Text.Trim() == "")
            {
                MessageBox.Show("Tem de seleccionar um template para cálculos!", "Escolher Template Cálculos", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else
            {
                caminho_excel = textBox1.Text.Trim();
                caminho_pdf = textBox2.Text.Trim();
                sel_template = comboBox1.Text.Trim();
                template_calculos = comboBox2.Text.Trim();
                if (checkBox5.Checked == true)
                {
                    num_colunas = "4";
                }
                else
                {
                    num_colunas = "5";
                }
                this.Close();
            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            FolderBrowserDialog folderBrowserDialog1 = new FolderBrowserDialog();
            DialogResult result = folderBrowserDialog1.ShowDialog();
            if( result == DialogResult.OK )
            {
                textBox1.Text = folderBrowserDialog1.SelectedPath;
            }
        }

        private void button4_Click(object sender, EventArgs e)
        {
            FolderBrowserDialog folderBrowserDialog1 = new FolderBrowserDialog();
            DialogResult result = folderBrowserDialog1.ShowDialog();
            if (result == DialogResult.OK)
            {
                textBox2.Text = folderBrowserDialog1.SelectedPath;
            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void checkBox5_CheckedChanged(object sender, EventArgs e)
        {

        }

        private void checkBox5_Click(object sender, EventArgs e)
        {
            if (checkBox5.Checked == true)
            {
                checkBox6.Checked = false;
            }
            else
            {
                checkBox6.Checked = true;
            }
        }

        private void checkBox6_Click(object sender, EventArgs e)
        {
            if (checkBox6.Checked == true)
            {
                checkBox5.Checked = false;
            }
            else
            {
                checkBox5.Checked = true;
            }
        }
    }
}
