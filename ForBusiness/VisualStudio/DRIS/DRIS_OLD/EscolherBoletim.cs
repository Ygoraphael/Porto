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
    public partial class EscolherBoletim : Form
    {

        public Form1 frm1;
        public dris drismeth;
        public List<string> lista_boletim = new List<string>();

        public EscolherBoletim(Form1 f1, dris DrisMethod)
        {
            InitializeComponent();
            this.MinimumSize = new Size(331, 282);
            this.MaximumSize = new Size(331, 282);
            this.CenterToScreen();

            frm1 = f1;
            drismeth = DrisMethod;

            load_values();

        }

        public void load_values()
        {
            DateTime date_now = DateTime.Now;

            DataTable dt = new DataTable();
            dt.Columns.Add(new DataColumn("Amostra.", typeof(String)));
            dt.Columns.Add(new DataColumn("Nº Boletim", typeof(String)));

            for (int k = 0; k < drismeth.amostras_num; k++)
            {
                if (k > 2)
                {
                    dt.Rows.Add(date_now.ToString("yyyy").Substring(2, 2) + drismeth.amostra_data_nomes[k], "");
                }
            }

            dataGridView1.DataSource = dt;
            dataGridView1.Columns[0].Width = 120;
            dataGridView1.Columns[0].ReadOnly = true;
            dataGridView1.Columns[1].Width = 120;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView1.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }

        }

        private void button2_Click(object sender, EventArgs e)
        {
            lista_boletim = new List<string>();
            this.Close();
        }

        private void button1_Click(object sender, EventArgs e)
        {

            lista_boletim = new List<string>();
            lista_boletim.Add("--");
            lista_boletim.Add("--");
            lista_boletim.Add("--");

            foreach (DataGridViewRow dr in dataGridView1.Rows)
            {
                string col1 = dr.Cells[0].Value.ToString();
                string col2 = dr.Cells[1].Value.ToString();

                if (col2.Length < 1)
                {
                    MessageBox.Show("Existem boletins por preencher", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Asterisk);
                    return;
                }
                else
                {
                    lista_boletim.Add(col2);
                }
            }

            this.Close();
        }
    }
}
