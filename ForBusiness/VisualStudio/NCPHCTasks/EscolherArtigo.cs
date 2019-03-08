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
    public partial class EscolherArtigo : Form
    {

        public string rfr = "";
        public string des = "";

        public EscolherArtigo()
        {
            InitializeComponent();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            if (dataGridView2.Rows.Count > 0)
            {
                int rowindex = dataGridView2.SelectedCells[0].RowIndex;
                rfr = dataGridView2.Rows[rowindex].Cells[0].Value.ToString();
                des = dataGridView2.Rows[rowindex].Cells[1].Value.ToString();
                this.Close();
            }
            else
            {
                MessageBox.Show("Nenhum artigo seleccionado", "Artigos", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        //lupa
        private void button3_Click(object sender, EventArgs e)
        {
            BaseDados bd = new BaseDados();
            String command = @"select 
                                ref,
		                        design
	                        from 
		                        st 
	                        where ";
            //referencia
            if (textBox1.Text.Trim() != "")
            {
                command += @"ref like '%" + textBox1.Text + "%' and";
            }

            //designacao
            if (textBox2.Text.Trim() != "")
            {
                command += @"design like '%" + textBox2.Text + "%' and";
            }

            command += @" 1=1";

            DataTable dt = new DataTable();
            dt = bd.GetData(command);

            dataGridView2.Rows.Clear();

            if (dt.Rows.Count > 0)
            {
                foreach (DataRow dtRow in dt.Rows)
                {
                    dataGridView2.Rows.Add(
                        dtRow[0].ToString(),
                        dtRow[1].ToString()
                    );
                }
            }
        }

        private void label1_Click(object sender, EventArgs e)
        {

        }
    }
}
