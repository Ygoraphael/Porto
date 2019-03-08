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
    public partial class Relatorio : Form
    {

        public BaseDados db = new BaseDados();
        public string path_db = "";
        
        public Relatorio(string caminho_base_dados)
        {
            InitializeComponent();
            this.MinimumSize = new Size(812, 426);
            this.MaximumSize = new Size(812, 426);
            this.CenterToScreen();
            path_db = caminho_base_dados;
            carrega_relatorios();
        }

        public void carrega_relatorios()
        {
            db.Connect(path_db);
            string strSql = "SELECT ID, (select nome from cliente where id = id_cliente) cliente, (select nome from cultura where id = id_cultura) cultura, id_referencia referencia, (select nome from funcionario where id = id_funcionario) funcionario, data_fecho DataFecho, Requisitante FROM RELATORIO";
            DataTable relatorios = db.selectQuery(strSql);

            dataGridView1.DataSource = relatorios;

            dataGridView1.Columns[0].Width = 60;
            dataGridView1.Columns[0].ReadOnly = true;
            dataGridView1.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;
            dataGridView1.Columns[1].Width = 220;
            dataGridView1.Columns[1].ReadOnly = true;
            dataGridView1.Columns[1].SortMode = DataGridViewColumnSortMode.NotSortable;
            dataGridView1.Columns[2].Width = 100;
            dataGridView1.Columns[2].ReadOnly = true;
            dataGridView1.Columns[2].SortMode = DataGridViewColumnSortMode.Automatic;
            dataGridView1.Columns[3].Width = 80;
            dataGridView1.Columns[3].ReadOnly = true;
            dataGridView1.Columns[3].SortMode = DataGridViewColumnSortMode.Automatic;
            dataGridView1.Columns[4].Width = 100;
            dataGridView1.Columns[4].ReadOnly = true;
            dataGridView1.Columns[4].SortMode = DataGridViewColumnSortMode.Automatic;
            dataGridView1.Columns[5].Width = 100;
            dataGridView1.Columns[5].ReadOnly = true;
            dataGridView1.Columns[5].SortMode = DataGridViewColumnSortMode.Automatic;
            dataGridView1.Columns[6].Width = 100;
            dataGridView1.Columns[6].ReadOnly = true;
            dataGridView1.Columns[6].SortMode = DataGridViewColumnSortMode.Automatic;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView1.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        private void dataGridView1_SelectionChanged(object sender, EventArgs e)
        {
            db.Connect(path_db);

            string id = dataGridView1[0, dataGridView1.CurrentRow.Index].Value.ToString();
            string strSql = "SELECT IDS_REQUISICAO FROM RELATORIO WHERE id = '" + id + "'";

            DataTable ids_req = db.selectQuery(strSql);
            string[] words = ids_req.Rows[0][0].ToString().Split(',');

            ids_req = new DataTable();
            ids_req.Clear();
            ids_req.Columns.Add("REQUISICAO");

            for (int i = 0; i < words.Count(); i++)
            {
                ids_req.Rows.Add(new Object[] { words[i].Trim() });
            }

            dataGridView2.DataSource = ids_req;

            dataGridView2.Columns[0].Width = 100;
            dataGridView2.Columns[0].ReadOnly = true;
            dataGridView2.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView2.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        private void dataGridView2_SelectionChanged(object sender, EventArgs e)
        {
            db.Connect(path_db);

            string id = dataGridView2[0, dataGridView2.CurrentRow.Index].Value.ToString();
            string strSql = "SELECT id, nome, ibn, ibn_medio, num_boletim, data_emissao FROM REQUISICAO WHERE id = " + id;

            DataTable req = db.selectQuery(strSql);

            dataGridView3.DataSource = req;

            dataGridView3.Columns[0].Width = 100;
            dataGridView3.Columns[0].ReadOnly = true;
            dataGridView3.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;

            dataGridView3.Columns[1].Width = 160;
            dataGridView3.Columns[1].ReadOnly = true;
            dataGridView3.Columns[1].SortMode = DataGridViewColumnSortMode.Programmatic;

            dataGridView3.Columns[2].Width = 100;
            dataGridView3.Columns[2].ReadOnly = true;
            dataGridView3.Columns[2].SortMode = DataGridViewColumnSortMode.Programmatic;

            dataGridView3.Columns[3].Width = 100;
            dataGridView3.Columns[3].ReadOnly = true;
            dataGridView3.Columns[3].SortMode = DataGridViewColumnSortMode.Programmatic;

            dataGridView3.Columns[4].Width = 100;
            dataGridView3.Columns[4].ReadOnly = true;
            dataGridView3.Columns[4].SortMode = DataGridViewColumnSortMode.Programmatic;

            dataGridView3.Columns[5].Width = 100;
            dataGridView3.Columns[5].ReadOnly = true;
            dataGridView3.Columns[5].SortMode = DataGridViewColumnSortMode.Programmatic;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView3.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        private void dataGridView3_SelectionChanged(object sender, EventArgs e)
        {
            db.Connect(path_db);

            string id = dataGridView3[0, dataGridView3.CurrentRow.Index].Value.ToString();
            string strSql = "SELECT nutriente NUT, valor_recomendacao VALREC, indice_dris, unidade FROM REQUISICAO_DADOS WHERE id_requisicao = " + id;

            DataTable req = db.selectQuery(strSql);

            dataGridView4.DataSource = req;

            dataGridView4.Columns[0].Width = 100;
            dataGridView4.Columns[0].ReadOnly = true;
            dataGridView4.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;

            dataGridView4.Columns[1].Width = 200;
            dataGridView4.Columns[1].ReadOnly = true;
            dataGridView4.Columns[1].SortMode = DataGridViewColumnSortMode.Programmatic;

            dataGridView4.Columns[2].Width = 170;
            dataGridView4.Columns[2].ReadOnly = true;
            dataGridView4.Columns[2].SortMode = DataGridViewColumnSortMode.Programmatic;

            dataGridView4.Columns[3].Width = 170;
            dataGridView4.Columns[3].ReadOnly = true;
            dataGridView4.Columns[3].SortMode = DataGridViewColumnSortMode.Programmatic;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView4.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }
    }
}
