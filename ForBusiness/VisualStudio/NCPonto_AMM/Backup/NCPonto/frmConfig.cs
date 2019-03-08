using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace NCPonto
{
    public partial class _frmConfig : Form
    {
        public _frmConfig()
        {
            InitializeComponent();
        }

        private void _frmConfig_Load(object sender, EventArgs e)
        {
            txtServidor.Text = Properties.Settings.Default.StrCon;
        }

        private void cmdLigarSql_Click(object sender, EventArgs e)
        {
        string myStringConnPHC = txtServidor.Text;
        SqlConnection myConPHC = new SqlConnection(myStringConnPHC);

        this.Cursor = Cursors.WaitCursor;
        try 
        {
            myConPHC.Open();
        }
        catch  
        {
            this.Cursor = Cursors.Default;
            MessageBox.Show("Erro ao ligar ao servidor SQL");
            this.Close();
        }    
        
        this.Cursor = Cursors.Default;
        Properties.Settings.Default.StrCon = txtServidor.Text;
        Properties.Settings.Default.Save();
        this.Close();
        }
    }
}
