using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace NCPHCTasks
{
    public partial class DadosCliente : Form
    {

        public DadosCliente(String no)
        {
            InitializeComponent();
            mostradados(no);
        }

        public void mostradados(String no)
        {
            BaseDados bd = new BaseDados();
            bd.Open();
            DataTable dt = new DataTable();
            dt = bd.GetData("select nome, morada, local, codpost, telefone, tlmvl, email, ncont from cl where no = " + no);
            if (dt.Rows.Count > 0)
            {
                textBox1.Text = dt.Rows[0][0].ToString();
                textBox2.Text = dt.Rows[0][1].ToString();
                textBox3.Text = dt.Rows[0][2].ToString();
                textBox4.Text = dt.Rows[0][3].ToString();
                textBox5.Text = dt.Rows[0][4].ToString();
                textBox6.Text = dt.Rows[0][5].ToString();
                textBox7.Text = dt.Rows[0][6].ToString();
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            this.Close();
        }
    }
}
