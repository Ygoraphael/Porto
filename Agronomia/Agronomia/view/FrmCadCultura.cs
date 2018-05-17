using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Agronomia.view
{
    public partial class FrmCadCultura : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmCadCultura(CULTURA obj)
        {
            InitializeComponent();
            db = new ProAgroEntities();
            if (obj == null)
            {
                cULTURABindingSource.DataSource = new CULTURA();
                db.CULTURA.Add(cULTURABindingSource.Current as CULTURA);
            }
            else
            {
                cULTURABindingSource.DataSource = obj;
                db.CULTURA.Attach(cULTURABindingSource.Current as CULTURA);
            }
        }
        private void FrmCadCultura_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (DialogResult == DialogResult.OK)
            {
                if (string.IsNullOrEmpty(txtNomeCultura.Text))
                {
                    MessageBox.Show("Insira um login por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    txtNomeCultura.Focus();
                    e.Cancel = true;
                    return;
                }
                db.SaveChanges();
                e.Cancel = false;
            }
            e.Cancel = false;
        }

        private void btnCan_Click(object sender, EventArgs e)
        {
            Close();
        }

        private void FrmCadCultura_Load(object sender, EventArgs e)
        {

        }
    }
}
