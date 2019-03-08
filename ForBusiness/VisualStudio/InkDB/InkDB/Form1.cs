using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Data.SQLite;

namespace InkDB
{
    public partial class Form1 : Form
    {
        SQLiteConnection sqlite;
        string path;
        string curFile;
        string tinteiro_id = "";
        string caminho_imagens;
        string strSql;

        public Form1()
        {
            InitializeComponent();
            path = "\\\\ncserver\\LojaOnline";
            curFile = path + "\\hotinker.db";

            sqlite = new SQLiteConnection("Data Source=" + curFile + ";Version=3;");

            DataTable dt = selectQuery("Select id, referencia from consumiveis");
            dataGridView1.DataSource = dt;
            dataGridView1.Columns[0].Width = 40;
            dataGridView1.Columns[1].Width = 150;
            foreach (DataGridViewColumn column in dataGridView1.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        public DataTable selectQuery(string query)
        {
            SQLiteDataAdapter ad;
            DataTable dt = new DataTable();

            try
            {
                SQLiteCommand cmd;
                sqlite.Open();
                cmd = sqlite.CreateCommand();
                cmd.CommandText = query;
                ad = new SQLiteDataAdapter(cmd);
                ad.Fill(dt);
            }
            catch (SQLiteException ex)
            {
                Console.WriteLine(ex);
            }

            sqlite.Close();
            return dt;
        }

        public void runQuery(string query)
        {
            try
            {
                SQLiteCommand cmd;
                sqlite.Open();
                cmd = sqlite.CreateCommand();
                cmd.CommandText = query;
                cmd.ExecuteNonQuery();
            }
            catch (SQLiteException ex)
            {
                Console.WriteLine(ex);
            }

            sqlite.Close();
        }

        private void dataGridView1_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            tinteiro_id = dataGridView1.Rows[e.RowIndex].Cells[0].Value.ToString();
            preenche_dados(tinteiro_id);
        }

        private void preenche_dados(string id)
        {
            DataTable dt = selectQuery("Select * from consumiveis A inner join tipo B on A.tipo = B.id where A.id = '"+id+"'");
            textBox1.Text = dt.Rows[0][1].ToString();
            textBox6.Text = dt.Rows[0][2].ToString();
            textBox2.Text = dt.Rows[0][3].ToString();
            textBox4.Text = dt.Rows[0][4].ToString();
            textBox5.Text = dt.Rows[0][10].ToString();
            textBox3.Text = dt.Rows[0][7].ToString();
            textBox7.Text = dt.Rows[0][6].ToString();
            comboBox1.SelectedItem = dt.Rows[0][8].ToString();

            caminho_imagens = path + "\\images\\";

            try
            {
                pictureBox1.Image = new Bitmap(caminho_imagens + textBox7.Text);
            }
            catch
            {
                pictureBox1.Image = new Bitmap(caminho_imagens + "noimage.png");
            }
            
        }

        private void dataGridView1_CellEnter(object sender, DataGridViewCellEventArgs e)
        {
            tinteiro_id = dataGridView1.Rows[e.RowIndex].Cells[0].Value.ToString();
            preenche_dados(tinteiro_id);
        }

        private void button1_Click(object sender, EventArgs e)
        {
            strSql = "UPDATE consumiveis set descricao = '" + textBox6.Text + "', capacidade = '" + textBox3.Text + "', imagem = '" + textBox7.Text + "', cor = '"+comboBox1.SelectedItem.ToString()+"' ";
            strSql += "WHERE id = '" + tinteiro_id + "'";
            runQuery(strSql);
            preenche_dados(tinteiro_id);
        }
    }
}
