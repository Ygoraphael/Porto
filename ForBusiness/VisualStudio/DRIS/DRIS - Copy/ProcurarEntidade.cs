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
    public partial class ProcurarEntidade : Form
    {

        BaseDados DrisDB = new BaseDados();
        DataTable dt_clientes = new DataTable();
        public string selected_client = "";

        public ProcurarEntidade(DataTable dt, BaseDados DrisDB_t)
        {
            InitializeComponent();
            this.MinimumSize = new Size(863, 462);
            this.MaximumSize = new Size(863, 462);
            this.CenterToScreen();
            DrisDB = DrisDB_t;
            dt_clientes = dt;
            preenche_tudo(dt_clientes);

        }

        private void preenche_tudo(DataTable dt_novo)
        {
            DataTable dt = new DataTable();
            dt.Columns.Add(new DataColumn("Nome", typeof(String)));
            dt.Columns.Add(new DataColumn("Morada", typeof(String)));
            dt.Columns.Add(new DataColumn("Cod. Postal", typeof(String)));
            dt.Columns.Add(new DataColumn("Telefone", typeof(String)));
            dt.Columns.Add(new DataColumn("NIF", typeof(String)));
            dt.Columns.Add(new DataColumn("ID", typeof(String)));

            foreach (DataRow dtRow in dt_novo.Rows)
            {
                dt.Rows.Add(dtRow[1].ToString(), dtRow[2].ToString(), dtRow[3].ToString(), dtRow[4].ToString(), dtRow[5].ToString(), dtRow[0].ToString());
            }

            dataGridView1.DataSource = dt;
            dataGridView1.Columns[0].Width = 220;
            dataGridView1.Columns[1].Width = 310;
            dataGridView1.Columns[2].Width = 130;
            dataGridView1.Columns[3].Width = 80;
            dataGridView1.Columns[4].Width = 80;
            dataGridView1.Columns[5].Visible = false;
        }

        private void button2_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void textBox1_KeyUp(object sender, KeyEventArgs e)
        {
            DataTable dt = new DataTable();
            dt = DrisDB.selectQuery("SELECT * FROM CLIENTE WHERE NOME LIKE '%" + textBox1.Text + "%'");

            textBox2.Text = "";
            dataGridView1.DataSource = null;
            dataGridView1.Refresh();
            preenche_tudo(dt);
        }

        private void textBox2_KeyUp(object sender, KeyEventArgs e)
        {
            DataTable dt = new DataTable();
            dt = DrisDB.selectQuery("SELECT * FROM CLIENTE WHERE NIF LIKE '%" + textBox2.Text + "%'");

            textBox1.Text = "";
            dataGridView1.DataSource = null;
            dataGridView1.Refresh();
            preenche_tudo(dt);
        }

        private void dataGridView1_CellDoubleClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0)
            {
                selected_client = dataGridView1.Rows[e.RowIndex].Cells[5].Value.ToString();
                this.Close();
            }
        }
    }
}
