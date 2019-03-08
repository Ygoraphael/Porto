using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;

namespace EOR_DRIS
{
    public partial class AmostraForm : Form
    {
        public BaseDados db = new BaseDados();
        public string path_db = "";

        public AmostraForm(string caminho_base_dados)
        {
            InitializeComponent();
            this.MinimumSize = new Size(722, 483);
            this.MaximumSize = new Size(722, 483);
            this.CenterToScreen();
            //dataGridView1.MultiSelect = false;
            //this.dataGridView1.SortCompare += new DataGridViewSortCompareEventHandler(dataGridView1_SortCompare);
            path_db = caminho_base_dados;
            carrega_amostras();
        }

        public void carrega_amostras()
        {
            db.Connect(path_db);
            string strSql = "SELECT ID, REFERENCIA, (select nome from CLIENTE where id = ID_CLIENTE) CLIENTE FROM AMOSTRA";
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

        private void label5_Click(object sender, EventArgs e)
        {

        }

        private void label7_Click(object sender, EventArgs e)
        {

        }

        private void dataGridView1_SelectionChanged(object sender, EventArgs e)
        {
            muda_seleccao(dataGridView1.CurrentRow.Index);
        }

        private void muda_seleccao(int row)
        {
            db.Connect(path_db);

            string id = dataGridView1[0, row].Value.ToString();
            string strSql = "SELECT id, referencia, data_colheita, data_recepcao, m_vegetal, num_nutrientes, nome, freguesia, concelho, id_imagem, (select nome from cliente where id = id_cliente), (select nome from cultura where id = id_cultura), propriedade FROM AMOSTRA WHERE id = '" + id + "'";

            DataTable amostras = db.selectQuery(strSql);

            painel_entidade_tb_nif.Text = amostras.Rows[0][2].ToString();
            painel_entidade_tb_nome.Text = amostras.Rows[0][3].ToString();
            painel_entidade_tb_morada.Text = amostras.Rows[0][4].ToString();
            painel_entidade_tb_codpostal.Text = amostras.Rows[0][6].ToString();
            painel_entidade_tb_telefone.Text = amostras.Rows[0][7].ToString();

            textBox3.Text = amostras.Rows[0][11].ToString();
            textBox2.Text = amostras.Rows[0][12].ToString();
            textBox1.Text = amostras.Rows[0][8].ToString();
            textBox4.Text = amostras.Rows[0][10].ToString();

            strSql = "SELECT id, nome FROM AMOSTRA_DADOS WHERE id_amostra = " + id;

            DataTable amostras_dados = db.selectQuery(strSql);
            dataGridView3.DataSource = amostras_dados;

            dataGridView3.Columns[0].Width = 140;
            dataGridView3.Columns[0].ReadOnly = true;
            dataGridView3.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;
            dataGridView3.Columns[1].Width = 160;
            dataGridView3.Columns[1].ReadOnly = true;
            dataGridView3.Columns[1].SortMode = DataGridViewColumnSortMode.NotSortable;

            int imagem = Convert.ToInt32(amostras.Rows[0][9]);

            if (imagem > 0)
            {
                DataTable tmp = db.selectQuery("SELECT * FROM ImageStore WHERE image_id = '" + imagem + "'");

                foreach (DataRow dtRow in tmp.Rows)
                {
                    byte[] imageBytes = (byte[])dtRow[2];
                    MemoryStream ms = new MemoryStream(imageBytes);
                    System.Drawing.Bitmap bmap = new System.Drawing.Bitmap(ms);
                    pictureBox1.Image = (System.Drawing.Image)bmap;
                    pictureBox1.SizeMode = PictureBoxSizeMode.StretchImage;
                    pictureBox1.Size = new System.Drawing.Size(190, 103);
                }
            }
            else
            {
                pictureBox1.Image = null;
            }

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
            string strSql = "SELECT nutriente, valor, unidade FROM AMOSTRA_DADOS_REQ WHERE id_amostra_dados = '" + id + "'";

            DataTable amostras_dados_req = db.selectQuery(strSql);

            dataGridView2.DataSource = amostras_dados_req;

            dataGridView2.Columns[0].Width = 120;
            dataGridView2.Columns[0].ReadOnly = true;
            dataGridView2.Columns[0].SortMode = DataGridViewColumnSortMode.Programmatic;
            dataGridView2.Columns[1].Width = 120;
            dataGridView2.Columns[1].ReadOnly = true;
            dataGridView2.Columns[1].SortMode = DataGridViewColumnSortMode.NotSortable;
            dataGridView2.Columns[2].Width = 120;
            dataGridView2.Columns[2].ReadOnly = true;
            dataGridView2.Columns[2].SortMode = DataGridViewColumnSortMode.NotSortable;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dataGridView2.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

    }
}
