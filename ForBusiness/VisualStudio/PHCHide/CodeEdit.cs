using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Data.SqlClient;

namespace PHCHide
{
    public partial class CodeEdit : Form
    {

        String id;
        String bd_path;
        int ins_upd;
        BD db = new BD();

        public CodeEdit(String val1, String val2, int val3)
        {
            InitializeComponent();
            id = val2;
            bd_path = val1;
            ins_upd = val3;
            preenche_dados();
        }

        public void preenche_dados()
        {
            if (ins_upd == 0)
            {
                db.Connect(bd_path);
                string strSql = "select id, (select nome from ecra where id = id_ecra) ecra, nome, codigo from code where id = " + id;

                DataTable linha = db.selectQuery(strSql);

                textBox1.Text = linha.Rows[0][0].ToString();
                textBox2.Text = linha.Rows[0][2].ToString();
                richTextBox1.Text = linha.Rows[0][3].ToString();
            }
            else
            {
                textBox1.Text = id;
                textBox2.Text = "";
                richTextBox1.Text = "";
            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            if (ins_upd == 0)
            {
                db.Connect(bd_path);
                string cmd = "update code set nome = @v1, codigo = @v2 where id = " + textBox1.Text;
                db.ExecuteNonQueryCmd(cmd, textBox2.Text, richTextBox1.Text);
                MessageBox.Show("Alterações Gravadas com Sucesso!", "Alterar Código", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            else
            {
                db.Connect(bd_path);
                string cmd = "insert into code (id, nome, codigo, id_ecra) values ("+textBox1.Text+", @v1, @v2, 1)";
                db.ExecuteNonQueryCmd(cmd, textBox2.Text, richTextBox1.Text);
                MessageBox.Show("Codigo Inserido com Sucesso!", "Inserir Código", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            this.Close();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            this.Close();
        }
    }
}
