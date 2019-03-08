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
    public partial class CulturaForm : Form
    {
        public BaseDados db = new BaseDados();
        public string path_db = "";
        
        public CulturaForm(string caminho_base_dados)
        {
            InitializeComponent();
            this.MinimumSize = new Size(658, 300);
            this.MaximumSize = new Size(658, 300);
            this.CenterToScreen();
            
            path_db = caminho_base_dados;
            carrega_culturas();
        }

        private void muda_seleccao(int row)
        {
            db.Connect(path_db);

            string id_cultura = dataGridView1[0, row].Value.ToString();
            string strSql = "SELECT id, nome FROM CULTURA WHERE id = " + id_cultura;

            DataTable culturas = db.selectQuery(strSql);
            textBox1.Text = culturas.Rows[0][1].ToString();
            textBox2.Text = culturas.Rows[0][0].ToString();
        }

        public void carrega_culturas()
        {
            db.Connect(path_db);
            string strSql = "SELECT id, nome FROM CULTURA";
            DataTable clientes = db.selectQuery(strSql);

            dataGridView1.DataSource = clientes;

            dataGridView1.Columns[0].Width = 40;
            dataGridView1.Columns[0].ReadOnly = true;
            dataGridView1.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;
            dataGridView1.Columns[1].Width = 100;
            dataGridView1.Columns[1].ReadOnly = true;
            dataGridView1.Columns[1].SortMode = DataGridViewColumnSortMode.NotSortable;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView1.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            db.Connect(path_db);
            string strSql = "SELECT MAX(ID) + 1 FROM CULTURA";
            DataTable culturas = db.selectQuery(strSql);

            textBox2.Text = culturas.Rows[0][0].ToString();
            textBox1.Text = "";
        }

        private void button2_Click(object sender, EventArgs e)
        {
            db.Connect(path_db);
            string strSql = "SELECT * FROM CULTURA WHERE ID = " + textBox2.Text;
            DataTable cultura = db.selectQuery(strSql);

            if (cultura.Rows.Count > 0)
            {
                strSql = "UPDATE CULTURA SET";
                strSql += " NOME = '" + textBox1.Text + "'";
                strSql += " WHERE ID = " + textBox2.Text;
                db.runQuery(strSql);

                int tmp_row = dataGridView1.CurrentRow.Index;

                dataGridView1.DataSource = null;
                carrega_culturas();

                dataGridView1.Rows[tmp_row].Cells.OfType<DataGridViewCell>().First().Selected = true;
                muda_seleccao(dataGridView1.CurrentRow.Index);

                MessageBox.Show("Cultura Modificada Com Sucesso!", "Modificar Cultura", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            else
            {
                strSql = "INSERT INTO CULTURA (NOME, ID) VALUES (";
                strSql += "'" + textBox1.Text + "', ";
                strSql += "" + textBox2.Text + ")";
                db.runQuery(strSql);

                dataGridView1.DataSource = null;
                carrega_culturas();

                dataGridView1.Rows.OfType<DataGridViewRow>().Last().Cells.OfType<DataGridViewCell>().First().Selected = true;
                muda_seleccao(dataGridView1.CurrentRow.Index);

                MessageBox.Show("Cultura Inserida Com Sucesso!", "Inserir Cultura", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
        }

        private void dataGridView1_SelectionChanged(object sender, EventArgs e)
        {
            muda_seleccao(dataGridView1.CurrentRow.Index);
        }
    }
}
