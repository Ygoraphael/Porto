using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Data.SQLite;

namespace PHCHide
{
    public partial class CodeManagement : Form
    {

        public static BD db = new BD();
        string bd_path = "C:\\teste.db";

        public CodeManagement()
        {
            InitializeComponent();
            this.MinimumSize = new Size(357, 300);
            this.MaximumSize = new Size(357, 300);
            this.CenterToScreen();
            carrega_programacao();
        }

        public void carrega_programacao()
        {
            db.Connect(bd_path);
            string strSql = "select id, (select nome from ecra where id = id_ecra) ecra, nome from code";
            DataTable amostras = db.selectQuery(strSql);

            dataGridView1.DataSource = amostras;

            dataGridView1.Columns[0].Width = 50;
            dataGridView1.Columns[0].ReadOnly = true;
            dataGridView1.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;
            dataGridView1.Columns[1].Width = 50;
            dataGridView1.Columns[1].ReadOnly = true;
            dataGridView1.Columns[1].SortMode = DataGridViewColumnSortMode.NotSortable;
            dataGridView1.Columns[2].Width = 137;
            dataGridView1.Columns[2].ReadOnly = true;
            dataGridView1.Columns[2].SortMode = DataGridViewColumnSortMode.Automatic;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView1.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            string id = dataGridView1[0, dataGridView1.CurrentRow.Index].Value.ToString();

            CodeEdit childForm = new CodeEdit(bd_path, id, 0);
            DialogResult dr = childForm.ShowDialog(this);

            dataGridView1.DataSource = null;
            carrega_programacao();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            string id = db.newid("code");

            CodeEdit childForm = new CodeEdit(bd_path, id, 1);
            DialogResult dr = childForm.ShowDialog(this);

            dataGridView1.DataSource = null;
            carrega_programacao();
        }

        private void button3_Click(object sender, EventArgs e)
        {
            string id = dataGridView1[0, dataGridView1.CurrentRow.Index].Value.ToString();
            db.runQuery("delete from code where id = " + id);

            dataGridView1.DataSource = null;
            carrega_programacao();
        }

    }
}
