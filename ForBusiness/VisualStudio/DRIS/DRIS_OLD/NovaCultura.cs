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
    public partial class NovaCultura : Form
    {

        BaseDados db;

        public NovaCultura(BaseDados DrisDB)
        {
            InitializeComponent();
            this.MinimumSize = new Size(302, 134);
            this.MaximumSize = new Size(302, 134);
            this.CenterToScreen();

            db = DrisDB;
        }

        private void button2_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            if (textBox1.Text.Trim() != "")
            {
                db.runQuery("INSERT INTO CULTURA (NOME) VALUES ('" + textBox1.Text.Trim() + "')");
                MessageBox.Show("Cultura Inserida Com Sucesso", "Nova Cultura", MessageBoxButtons.OK, MessageBoxIcon.Information);
                this.Close();
            }
            else
            {
                MessageBox.Show("Tem de preencher o nome da cultura", "Nova Cultura", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
