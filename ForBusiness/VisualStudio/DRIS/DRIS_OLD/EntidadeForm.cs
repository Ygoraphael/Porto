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
    public partial class EntidadeForm : Form
    {

        public BaseDados db = new BaseDados();
        public string path_db = "";

        public EntidadeForm(string caminho_base_dados)
        {
            InitializeComponent();
            this.MinimumSize = new Size(722, 412);
            this.MaximumSize = new Size(722, 412);
            this.CenterToScreen();
            dataGridView1.MultiSelect = false;
            this.dataGridView1.SortCompare += new DataGridViewSortCompareEventHandler(dataGridView1_SortCompare);
            path_db = caminho_base_dados;
            carrega_entidades();
        }

        public void carrega_entidades()
        {
            db.Connect(path_db);
            string strSql = "SELECT id, nif, nome FROM CLIENTE";
            DataTable clientes = db.selectQuery(strSql);

            dataGridView1.DataSource = clientes;

            dataGridView1.Columns[0].Width = 40;
            dataGridView1.Columns[0].ReadOnly = true;
            dataGridView1.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;
            dataGridView1.Columns[1].Width = 100;
            dataGridView1.Columns[1].ReadOnly = true;
            dataGridView1.Columns[1].SortMode = DataGridViewColumnSortMode.NotSortable;
            dataGridView1.Columns[2].Width = 530;
            dataGridView1.Columns[2].ReadOnly = true;
            dataGridView1.Columns[2].SortMode = DataGridViewColumnSortMode.Automatic;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView1.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        public void carrega_entidades_dt(DataTable dt)
        {
            dataGridView1.DataSource = dt;

            dataGridView1.Columns[0].Width = 40;
            dataGridView1.Columns[0].ReadOnly = true;
            dataGridView1.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;
            dataGridView1.Columns[1].Width = 100;
            dataGridView1.Columns[1].ReadOnly = true;
            dataGridView1.Columns[1].SortMode = DataGridViewColumnSortMode.NotSortable;
            dataGridView1.Columns[2].Width = 530;
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
            muda_seleccao( dataGridView1.CurrentRow.Index );
        }

        private void muda_seleccao(int row)
        {
            db.Connect( path_db );

            string id_cliente = dataGridView1[0, row].Value.ToString();
            string strSql = "SELECT ifnull(id, '') id, ifnull(nome, '') nome, ifnull(morada, '') morada, ifnull(cod_postal, '') cod_postal, ifnull(telefone, '') telefone, ifnull(nif, '') nif FROM CLIENTE WHERE id = '" + id_cliente + "'";

            DataTable clientes = db.selectQuery(strSql);
            painel_entidade_tb_nif.Text = clientes.Rows[0][5].ToString();
            painel_entidade_tb_nome.Text = clientes.Rows[0][1].ToString();
            painel_entidade_tb_morada.Text = clientes.Rows[0][2].ToString();
            painel_entidade_tb_codpostal.Text = clientes.Rows[0][3].ToString();
            painel_entidade_tb_telefone.Text = clientes.Rows[0][4].ToString();
            textBox3.Text = clientes.Rows[0][0].ToString();
        }

        private void dataGridView1_ColumnHeaderMouseClick(object sender, DataGridViewCellMouseEventArgs e)
        {

        }

        private void dataGridView1_SortCompare(object sender, DataGridViewSortCompareEventArgs e)
        {
           
        }

        private void button1_Click(object sender, EventArgs e)
        {
            db.Connect(path_db);
            string strSql = "SELECT MAX(ID) + 1 FROM CLIENTE";
            DataTable clientes = db.selectQuery(strSql);
            textBox3.Text = clientes.Rows[0][0].ToString();
            painel_entidade_tb_nif.Text = "";
            painel_entidade_tb_nome.Text = "";
            painel_entidade_tb_morada.Text = "";
            painel_entidade_tb_codpostal.Text = "";
            painel_entidade_tb_telefone.Text = "";
        }

        private void button2_Click(object sender, EventArgs e)
        {
            db.Connect(path_db);
            string strSql = "SELECT * FROM CLIENTE WHERE ID = " + textBox3.Text;
            DataTable cliente = db.selectQuery(strSql);

            if (cliente.Rows.Count > 0)
            {
                strSql = "UPDATE CLIENTE SET";
                strSql += " NOME = '" + painel_entidade_tb_nome.Text + "',";
                strSql += " MORADA = '" + painel_entidade_tb_morada.Text + "',";
                strSql += " COD_POSTAL = '" + painel_entidade_tb_codpostal.Text + "',";
                strSql += " TELEFONE = '" + painel_entidade_tb_telefone.Text + "',";
                strSql += " NIF = '" + painel_entidade_tb_nif.Text + "'";
                strSql += " WHERE ID = " + textBox3.Text;
                db.runQuery(strSql);

                int tmp_row = dataGridView1.CurrentRow.Index;

                dataGridView1.DataSource = null;
                carrega_entidades();

                dataGridView1.Rows[tmp_row].Cells.OfType<DataGridViewCell>().First().Selected = true;
                muda_seleccao(dataGridView1.CurrentRow.Index);

                MessageBox.Show("Entidade Modificado Com Sucesso!", "Modificar Entidade", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            else
            {
                strSql = "INSERT INTO CLIENTE (NOME, MORADA, COD_POSTAL, TELEFONE, NIF, ID) VALUES (";
                strSql += "'" + painel_entidade_tb_nome.Text + "', ";
                strSql += "'" + painel_entidade_tb_morada.Text + "', ";
                strSql += "'" + painel_entidade_tb_codpostal.Text + "', ";
                strSql += "'" + painel_entidade_tb_telefone.Text + "', ";
                strSql += "'" + painel_entidade_tb_nif.Text + "', ";
                strSql += "" + textBox3.Text + ")";
                db.runQuery(strSql);

                dataGridView1.DataSource = null;
                carrega_entidades();

                dataGridView1.Rows.OfType<DataGridViewRow>().Last().Cells.OfType<DataGridViewCell>().First().Selected = true;
                muda_seleccao(dataGridView1.CurrentRow.Index);

                MessageBox.Show("Entidade Inserida Com Sucesso!", "Inserir Entidade", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
        }

        private void textBox1_KeyUp(object sender, KeyEventArgs e)
        {
            DataTable dt = new DataTable();
            dt = db.selectQuery("SELECT ID, NIF, NOME FROM CLIENTE WHERE NIF LIKE '%" + textBox1.Text + "%' AND NOME LIKE '%" + textBox2.Text + "%'");

            dataGridView1.DataSource = null;
            dataGridView1.Refresh();
            carrega_entidades_dt(dt);
        }

        private void textBox2_KeyUp(object sender, KeyEventArgs e)
        {
            DataTable dt = new DataTable();
            dt = db.selectQuery("SELECT ID, NIF, NOME FROM CLIENTE WHERE NIF LIKE '%" + textBox1.Text + "%' AND NOME LIKE '%" + textBox2.Text + "%'");

            dataGridView1.DataSource = null;
            dataGridView1.Refresh();
            carrega_entidades_dt(dt);
        }
    }
}
