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
    public partial class Utilizador : Form
    {

        public BaseDados db = new BaseDados();
        public string path_db = "";

        public Utilizador(string caminho_base_dados)
        {
            InitializeComponent();
            this.MinimumSize = new Size(574, 300);
            this.MaximumSize = new Size(574, 300);
            this.CenterToScreen();
            dataGridView1.MultiSelect = false;
            path_db = caminho_base_dados;
            carrega_utilizadores();
        }

        public void carrega_utilizadores()
        {
            db.Connect(path_db);
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

        private void dataGridView1_SelectionChanged(object sender, EventArgs e)
        {
            muda_seleccao(dataGridView1.CurrentRow.Index);
        }

        private void muda_seleccao(int row)
        {
            db.Connect(path_db);
            string id_user = dataGridView1[0, row].Value.ToString();
            string strSql = "SELECT nome, assinatura_digital FROM FUNCIONARIO WHERE id = '" + id_user + "'";
            DataTable users = db.selectQuery(strSql);
            textBox1.Text = users.Rows[0][0].ToString();

            try
            {
                UpdatePictureBox(Convert.ToInt32(users.Rows[0][1].ToString()));
            }
            catch
            {
                pictureBox1.InitialImage = null;
                pictureBox1.Image = null;
            }
        }

        private void button4_Click(object sender, EventArgs e)
        {
            db.Connect(path_db);
            string id_user = dataGridView1[0, dataGridView1.CurrentRow.Index].Value.ToString();
            ImageHelper imagem_assinatura = new ImageHelper();
            int id_assinatura = imagem_assinatura.InsertImage();

            if (id_assinatura > 0)
            {
                string strSql = "UPDATE FUNCIONARIO set assinatura_digital = '" + id_assinatura + "' WHERE id = '" + id_user + "'";
                db.runQuery(strSql);
                UpdatePictureBox(id_assinatura);
            }
        }

        private void UpdatePictureBox(int id)
        {
            db.Connect(path_db);
            string strSql = "SELECT * FROM ImageStore WHERE image_id = '" + id + "'";
            DataTable tmp = db.selectQuery(strSql);

            byte[] imageBytes = (byte[])tmp.Rows[0][2];
            MemoryStream ms = new MemoryStream(imageBytes);
            System.Drawing.Bitmap bmap = new System.Drawing.Bitmap(ms);
            pictureBox1.Image = (System.Drawing.Image)bmap;
            pictureBox1.SizeMode = PictureBoxSizeMode.StretchImage;
            pictureBox1.Size = new System.Drawing.Size(253, 145);
        }

        private void button1_Click(object sender, EventArgs e)
        {
            db.Connect(path_db);
            string strSql = "insert into funcionario (nome, assinatura_digital) values ('SEM NOME', '')";
            db.runQuery(strSql);

            carrega_utilizadores();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            int selected_row = dataGridView1.CurrentRow.Index;
            string id_user = dataGridView1[0, selected_row].Value.ToString();

            if (id_user == "1")
            {
                MessageBox.Show("Não pode modificar o utilizador Administrador do Sistema!", "Modificar Utilizador", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            else
            {
                db.Connect(path_db);
                string strSql = "update funcionario set nome = '" + textBox1.Text + "' where id = '" + id_user + "'";
                db.runQuery(strSql);
                carrega_utilizadores();

                muda_seleccao(dataGridView1.CurrentRow.Index);
                MessageBox.Show("Utilizador gravado com sucesso!", "Gravar Utilizador", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            string id_user = dataGridView1[0, dataGridView1.CurrentRow.Index].Value.ToString();
            string nome_user = dataGridView1[1, dataGridView1.CurrentRow.Index].Value.ToString();

            if (id_user == "1")
            {
                MessageBox.Show("Não pode apagar o utilizador Administrador do Sistema!", "Apagar Utilizador", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            else
            {

                DialogResult dr = MessageBox.Show("Tem a certeza que deseja apagar o utilizador " + nome_user + "?", "Apagar Utilizador", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);

                if (dr.ToString() == "OK")
                {
                    Console.WriteLine("Ok");
                }
                else
                {
                    Console.WriteLine("Cancel");
                }
            }
        }
    }
}
