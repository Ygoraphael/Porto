using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Data.SqlClient;

namespace NCPHCTasks
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
            textBox1.Select();
        }

        private void fazlogin()
        {
            //inicia painel configuracao
            if ( textBox1.Text == "PHC!800" + System.DateTime.Now.Day )
            {
                PainelConfiguracao childForm = new PainelConfiguracao();
                DialogResult dr = childForm.ShowDialog(this);
            }
            else
            {
                BaseDados bd = new BaseDados();
                String command = "Select userno, username from us where UPPER(iniciais) = '" + textBox1.Text.ToUpper() + "'";
                DataTable dt = new DataTable();
                dt = bd.GetData( command );

                if (dt.Rows.Count > 0)
                {
                    Main childForm = new Main(dt.Rows[0][0].ToString(), dt.Rows[0][1].ToString());
                    this.Hide();
                    DialogResult dr = childForm.ShowDialog(this);
                    this.Close();
                }
                else
                {
                    MessageBox.Show("Nenhum utilizador encontrado", "Login", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
            }
        }

        private void Button1_Click(object sender, EventArgs e)
        {
            fazlogin();
        }

        private void textBox1_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (Convert.ToInt32(e.KeyChar) == 13)
            {
                fazlogin();
            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            this.Close();
        }
    }
}
