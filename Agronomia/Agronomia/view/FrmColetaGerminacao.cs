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
    public partial class FrmColetaGerminacao : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmColetaGerminacao()
        {
            InitializeComponent();
        }

        private void FrmColetaGerminacao_Load(object sender, EventArgs e)
        {
            db = new ProAgroEntities();
            cOLETAGERMINACAOBindingSource.DataSource = db.COLETAGERMINACAO.ToList();
        }


        private void btnAdd_Click(object sender, EventArgs e)
        {
            using (FrmCadColetaGerminacao frm = new FrmCadColetaGerminacao(null))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    cOLETAGERMINACAOBindingSource.DataSource = db.COLETAGERMINACAO.ToList();
                }
            }
        }

        private void btnEdit_Click(object sender, EventArgs e)
        {
            if (cOLETAGERMINACAOBindingSource.Current == null)
            {
                MessageBox.Show("Não há registro para ser editado!", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            using (FrmCadColetaGerminacao frm = new FrmCadColetaGerminacao(cOLETAGERMINACAOBindingSource.Current as COLETAGERMINACAO))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    cOLETAGERMINACAOBindingSource.DataSource = db.COLETAGERMINACAO.ToList();
                }
            }
        }

        private void btnDel_Click(object sender, EventArgs e)
        {
            if (cOLETAGERMINACAOBindingSource.Current != null)
            {
                if (MessageBox.Show("Voce realmente quer deletar este registro?", "Messagem", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    db.COLETAGERMINACAO.Remove(cOLETAGERMINACAOBindingSource.Current as COLETAGERMINACAO);
                    cOLETAGERMINACAOBindingSource.RemoveCurrent();
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
