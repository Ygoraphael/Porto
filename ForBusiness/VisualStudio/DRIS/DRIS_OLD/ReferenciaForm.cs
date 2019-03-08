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
    public partial class ReferenciaForm : Form
    {

        public BaseDados db = new BaseDados();
        public string path_db = "";

        public ReferenciaForm(string caminho_base_dados)
        {
            InitializeComponent();
            this.MinimumSize = new Size(722, 345);
            this.MaximumSize = new Size(722, 345);
            this.CenterToScreen();
            //dataGridView1.MultiSelect = false;
            //this.dataGridView1.SortCompare += new DataGridViewSortCompareEventHandler(dataGridView1_SortCompare);
            path_db = caminho_base_dados;
            carrega_referencias();
        }

        public void carrega_referencias()
        {
            db.Connect(path_db);
            string strSql = "SELECT ID, (select nome from CULTURA where id = ID_CULTURA) cultura, NOME FROM REFERENCIA";
            DataTable amostras = db.selectQuery(strSql);

            dataGridView1.DataSource = amostras;

            dataGridView1.Columns[0].Width = 70;
            dataGridView1.Columns[0].ReadOnly = true;
            dataGridView1.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;
            dataGridView1.Columns[1].Width = 160;
            dataGridView1.Columns[1].ReadOnly = true;
            dataGridView1.Columns[1].SortMode = DataGridViewColumnSortMode.NotSortable;
            dataGridView1.Columns[2].Width = 450;
            dataGridView1.Columns[2].ReadOnly = true;
            dataGridView1.Columns[2].SortMode = DataGridViewColumnSortMode.Automatic;

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

            string strSql = "SELECT NUTRIENTE, VALOR, UNIDADE, PRODUTIVIDADE FROM REFERENCIA_DADOS WHERE id_referencia = " + id;

            DataTable referencias_dados = db.selectQuery(strSql);
            dataGridView2.DataSource = referencias_dados;

            dataGridView2.Columns[0].Width = 140;
            dataGridView2.Columns[0].ReadOnly = true;
            dataGridView2.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;
            dataGridView2.Columns[1].Width = 160;
            dataGridView2.Columns[1].ReadOnly = true;
            dataGridView2.Columns[1].SortMode = DataGridViewColumnSortMode.NotSortable;
            dataGridView2.Columns[2].Width = 160;
            dataGridView2.Columns[2].ReadOnly = true;
            dataGridView2.Columns[2].SortMode = DataGridViewColumnSortMode.NotSortable;
            dataGridView2.Columns[3].Width = 160;
            dataGridView2.Columns[3].ReadOnly = true;
            dataGridView2.Columns[3].SortMode = DataGridViewColumnSortMode.NotSortable;

            
            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView2.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }
    }
}
