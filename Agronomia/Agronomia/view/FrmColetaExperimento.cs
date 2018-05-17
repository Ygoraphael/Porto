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
    public partial class FrmColetaExperimento : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmColetaExperimento()
        {
            InitializeComponent();
        }

        private void FrmColetaExperimento_Load(object sender, EventArgs e)
        {
            db = new ProAgroEntities();
            cOLETAEXPERIMENTOBindingSource.DataSource = db.COLETAEXPERIMENTO.ToList();
        }


        private void btnAdd_Click(object sender, EventArgs e)
        {
            using (FrmCadColetaExperimento frm = new FrmCadColetaExperimento(null))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    cOLETAEXPERIMENTOBindingSource.DataSource = db.COLETAEXPERIMENTO.ToList();
                }
            }
        }

        private void btnEdit_Click(object sender, EventArgs e)
        {
            if (cOLETAEXPERIMENTOBindingSource.Current == null)
            {
                MessageBox.Show("Não há registro para ser editado!", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            using (FrmCadColetaExperimento frm = new FrmCadColetaExperimento(cOLETAEXPERIMENTOBindingSource.Current as COLETAEXPERIMENTO))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    cOLETAEXPERIMENTOBindingSource.DataSource = db.COLETAEXPERIMENTO.ToList();
                }
            }
        }

        private void btnDel_Click(object sender, EventArgs e)
        {
            if (cOLETAEXPERIMENTOBindingSource.Current != null)
            {
                if (MessageBox.Show("Voce realmente quer deletar este registro?", "Messagem", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    db.COLETAEXPERIMENTO.Remove(cOLETAEXPERIMENTOBindingSource.Current as COLETAEXPERIMENTO);
                    cOLETAEXPERIMENTOBindingSource.RemoveCurrent();
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
