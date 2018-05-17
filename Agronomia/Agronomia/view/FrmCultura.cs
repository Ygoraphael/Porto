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
    public partial class FrmCultura : MetroFramework.Forms.MetroForm
    {

        ProAgroEntities db;
        public FrmCultura()
        {
            InitializeComponent();
        }

        private void FrmCultura_Load(object sender, EventArgs e)
        {
            db = new ProAgroEntities();
            cULTURABindingSource.DataSource = db.CULTURA.ToList();
        }


        private void btnAdd_Click(object sender, EventArgs e)
        {
            using (FrmCadCultura frm = new FrmCadCultura(null))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    cULTURABindingSource.DataSource = db.CULTURA.ToList();
                }
            }
        }

        private void btnEdit_Click(object sender, EventArgs e)
        {
            if (cULTURABindingSource.Current == null)
            {
                MessageBox.Show("Não há registro para ser editado!", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            using (FrmCadCultura frm = new FrmCadCultura(cULTURABindingSource.Current as CULTURA))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    cULTURABindingSource.DataSource = db.CULTURA.ToList();
                }
            }
        }

        private void btnDel_Click(object sender, EventArgs e)
        {
            if (cULTURABindingSource.Current != null)
            {
                if (MessageBox.Show("Voce realmente quer deletar este registro?", "Messagem", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    db.CULTURA.Remove(cULTURABindingSource.Current as CULTURA);
                    cULTURABindingSource.RemoveCurrent();
                    db.SaveChanges();
                }
            }
        }

        private void btnCan_Click(object sender, EventArgs e)
        {
            Close();
        }
    }
}
