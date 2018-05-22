using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace App_no_database
{
    public partial class FormConexaoBase : Form
    {
        public FormConexaoBase()
        {
            InitializeComponent();
        }

        private void btnConnect_Click(object sender, EventArgs e)
        {
            //string ConectionString = string.Format("Data Source={0};Initial Catalog={1};User ID={2}; Password{3}", cboServer.Text, txtDatabase.Text, txtUserName.Text, txtPassword.Text);
            string ConectionString = string.Format("Data Source={0};Initial Catalog={1};Integrated Security = True;", cboServer.Text, txtDatabase.Text);
            try
            {
                SqlHelper helper = new SqlHelper(ConectionString);
                if (helper.IsConection)
                    MessageBox.Show("Conexão efetuada com sucesso", "Mensagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            catch(Exception ex)
            {
                MessageBox.Show(ex.Message, "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void FormConexaoBase_Load(object sender, EventArgs e)
        {
            cboServer.Items.Add(".");
            cboServer.Items.Add("local");
            cboServer.Items.Add(@".\SQLEXPRESS");
            cboServer.Items.Add(string.Format(@"{0}\SQLEXPRESS", Environment.MachineName));
            cboServer.SelectedIndex = 3;
        }
    }
}
