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
    public partial class CriaConf : Form
    {

        public BaseDados db = new BaseDados();
        string file_location = "";

        public CriaConf()
        {
            InitializeComponent();
            this.MinimumSize = new Size(643, 300);
            this.MaximumSize = new Size(643, 300);
            this.CenterToScreen();
            dataGridView1.MultiSelect = false;
            //carrega_utilizadores();
        }

        public void carrega_utilizadores()
        {
            db = new BaseDados();
            db.Connect(textBox1.Text);
            string strSql = "SELECT id, nome FROM FUNCIONARIO";
            DataTable users = db.selectQuery(strSql);

            dataGridView1.DataSource = users;
            dataGridView1.Columns[0].Width = 50;
            dataGridView1.Columns[0].ReadOnly = true;
            dataGridView1.Columns[1].ReadOnly = true;
            dataGridView1.Columns[1].Width = 180;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView1.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            OpenFileDialog dlg = new OpenFileDialog();
            dlg.InitialDirectory = @"C:\\";
            dlg.Title = "Seleccionar base de dados";
            dlg.Filter = "Base Dados  (*.db )|*.db";
            dlg.ShowDialog();

            file_location = dlg.FileName;

            if (file_location == null || file_location == string.Empty)
            {
                textBox1.Text = "";
                dataGridView1.Rows.Clear();
                file_location = "";
                return;
            }
            else
            {
                textBox1.Text = file_location;
                //verifica se base de dados escolhida
                if (textBox1.Text.Trim() == "")
                {
                    DialogResult res = MessageBox.Show("Seleccione uma base de dados, por favor!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
                else
                {
                    string localizacao = textBox1.Text.Trim();
                    string[] words = localizacao.Split('\\');

                    if (words[words.Length - 1] != "dris.db")
                    {
                        DialogResult res = MessageBox.Show("Seleccione uma base de dados válida, por favor!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                    else
                    {
                        carrega_utilizadores();
                    }
                }
            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            Environment.Exit(0);
        }

        private void button4_Click(object sender, EventArgs e)
        {
            //verifica se utilizador seleccionado
            if (dataGridView1.CurrentCell.RowIndex < 0)
            {
                DialogResult res = MessageBox.Show("Seleccione um utilizador, por favor!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else
            {
                //cria ficheiro de configuracao
                string utilizador = dataGridView1.Rows[dataGridView1.CurrentCell.RowIndex].Cells[0].Value.ToString();
                string path = Application.StartupPath;
                string curFile = @"" + path + "\\posto.cfg";

                string text = "db-path=" + textBox1.Text + "\n";
                text += "user-id=" + utilizador + "\n";
                System.IO.File.WriteAllText(curFile, text);
                this.Close();
            }
        }
    }
}
