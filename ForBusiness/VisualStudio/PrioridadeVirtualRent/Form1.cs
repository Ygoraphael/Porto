using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Configuration;
using System.Collections.Specialized;
using System.Diagnostics;

namespace PrioridadeVirtualRent
{
    public partial class Form1 : Form
    {
        string basedados_path;
        Config configuracao = new Config();
        BaseDados bd = new BaseDados();
        DataTable dt;
        DataTable dt_tmp;

        public Form1()
        {
            InitializeComponent();
            this.CenterToScreen();
            ler_configuracao();
        }

        public void ler_configuracao()
        {
            basedados_path = configuracao.get_data("basedados");
            if (basedados_path != "")
            {
                dt = bd.select_query(
                    @"
                SELECT 
                Servicos.ID, 
                (select TOP 1 Nome from Entidades where NUMERO = Servicos.Cliente) & '(' & Servicos.Cliente & ')' AS Cliente, 
                Format(DataRecepcao, 'yyyy-mm-dd') & ' ' & HoraRecepcao AS DataHoraRec,
                Servicos.MesReferencia, 
                (select TOP 1 Descricao from Tarefas where CODIGO = Servicos.TarefaActual ) AS Tarefa,
                Servicos.Prioridade,
                Servicos.EmCurso, 
                (select TOP 1 Nome from Utilizadores where NUMERO = Val(Servicos.UtilizadorActual) ) AS Utilizador
                FROM Servicos;
            ");

                dt_tmp = dt.Copy();

                dataGridView1.DataSource = dt_tmp;
                dataGridView1.Columns[0].Visible = false;
                dataGridView1.Columns[1].Width = Convert.ToInt32(dataGridView1.Width * 0.2);
                dataGridView1.Columns[2].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                dataGridView1.Columns[3].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                dataGridView1.Columns[4].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                dataGridView1.Columns[5].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                dataGridView1.Columns[6].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                dataGridView1.Columns[7].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                foreach (DataGridViewColumn column in dataGridView1.Columns)
                {
                    dataGridView1.Columns[column.Name].SortMode = DataGridViewColumnSortMode.Automatic;
                }
            }
        }

        private void preferênciasToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Preferencias childForm = new Preferencias();
            DialogResult dr = childForm.ShowDialog(this);
        }

        public void DebugTable(DataTable table)
        {
            Debug.WriteLine("--- DebugTable(" + table.TableName + ") ---");
            int zeilen = table.Rows.Count;
            int spalten = table.Columns.Count;

            // Header
            for (int i = 0; i < table.Columns.Count; i++)
            {
                string s = table.Columns[i].ToString();
                Debug.Write(String.Format("{0,-20} | ", s));
            }
            Debug.Write(Environment.NewLine);
            for (int i = 0; i < table.Columns.Count; i++)
            {
                Debug.Write("---------------------|-");
            }
            Debug.Write(Environment.NewLine);

            // Data
            for (int i = 0; i < zeilen; i++)
            {
                DataRow row = table.Rows[i];
                //Debug.WriteLine("{0} {1} ", row[0], row[1]);
                for (int j = 0; j < spalten; j++)
                {
                    string s = row[j].ToString();
                    if (s.Length > 20) s = s.Substring(0, 17) + "...";
                    Debug.Write(String.Format("{0,-20} | ", s));
                }
                Debug.Write(Environment.NewLine);
            }
            for (int i = 0; i < table.Columns.Count; i++)
            {
                Debug.Write("---------------------|-");
            }
            Debug.Write(Environment.NewLine);
        }

        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {

        }

        private void button1_Click(object sender, EventArgs e)
        {
            if (basedados_path != "")
            {
                bd.open();
                for (int i = 0; i < dataGridView1.Rows.Count; i++)
                {
                    bd.update_query(@"
                    update Servicos 
                    set 
                        Prioridade = '" + dataGridView1[5, i].Value.ToString() + "' " + @"
                    where ID = " + dataGridView1[0, i].Value.ToString());
                }
                bd.close();
                MessageBox.Show("Serviços Alterados Com Sucesso");
            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            if (basedados_path != "")
            {
                dataGridView1.DataSource = null;
                dataGridView1.Rows.Clear();
                dt_tmp = dt.Copy();

                dataGridView1.DataSource = dt_tmp;
                dataGridView1.Columns[0].Visible = false;
                dataGridView1.Columns[1].Width = Convert.ToInt32(dataGridView1.Width * 0.2);
                dataGridView1.Columns[2].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                dataGridView1.Columns[3].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                dataGridView1.Columns[4].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                dataGridView1.Columns[5].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                dataGridView1.Columns[6].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                dataGridView1.Columns[7].Width = Convert.ToInt32(dataGridView1.Width * 0.155);
                foreach (DataGridViewColumn column in dataGridView1.Columns)
                {
                    dataGridView1.Columns[column.Name].SortMode = DataGridViewColumnSortMode.Automatic;
                }
            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            if (basedados_path != "")
            {
                for (int i = 0; i < dataGridView1.Rows.Count; i++)
                {
                    dataGridView1[5, i].Value = textBox1.Text;
                }
            }
        }

        private void textBox1_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (((e.KeyChar < 48 || e.KeyChar > 57) && e.KeyChar != 8 && e.KeyChar != 44))
            {
                e.Handled = true;
                return;
            }

            if (e.KeyChar == 44)
            {
                if ((sender as TextBox).Text.IndexOf(e.KeyChar) != -1)
                    e.Handled = true;
            }
        }

        private void button4_Click(object sender, EventArgs e)
        {
            if (basedados_path != "")
            {
                foreach (DataGridViewCell r in dataGridView1.SelectedCells)
                {
                    Console.WriteLine(r.RowIndex);
                    dataGridView1[5, r.RowIndex].Value = textBox1.Text;
                }
            }
        }

        private void sairToolStripMenuItem_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void sobreToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Sobre childForm = new Sobre();
            DialogResult dr = childForm.ShowDialog(this);
        }
    }
}
