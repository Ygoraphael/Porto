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
    public partial class FrmGerminacao : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmGerminacao()
        {
            InitializeComponent();
        }

        private void FrmGerminacao_Load(object sender, EventArgs e)
        {
            db = new ProAgroEntities();
            gERMINACAOBindingSource.DataSource = db.GERMINACAO.ToList();
        }


        private void btnAdd_Click(object sender, EventArgs e)
        {
            using (FrmCadGerminacao frm = new FrmCadGerminacao(null))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    gERMINACAOBindingSource.DataSource = db.GERMINACAO.ToList();                }
            }
        }

        private void btnEdit_Click(object sender, EventArgs e)
        {
            if (gERMINACAOBindingSource.Current == null)
            {
                MessageBox.Show("Não há registro para ser editado!", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            using (FrmCadGerminacao frm = new FrmCadGerminacao(gERMINACAOBindingSource.Current as GERMINACAO))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    gERMINACAOBindingSource.DataSource = db.GERMINACAO.ToList();
                }
            }
        }

        private void btnDel_Click(object sender, EventArgs e)
        {
            if (gERMINACAOBindingSource.Current != null)
            {
                if (MessageBox.Show("Voce realmente quer deletar este registro?", "Messagem", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    db.GERMINACAO.Remove(gERMINACAOBindingSource.Current as GERMINACAO);
                    gERMINACAOBindingSource.RemoveCurrent();
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
