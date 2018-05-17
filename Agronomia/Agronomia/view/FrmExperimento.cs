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
    public partial class FrmExperimento : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmExperimento()
        {
            InitializeComponent();
        }

        private void FrmExperimento_Load(object sender, EventArgs e)
        {
            db = new ProAgroEntities();
            eXPERIMENTOBindingSource.DataSource = db.EXPERIMENTO.ToList();
        }


        private void btnAdd_Click(object sender, EventArgs e)
        {
            using (FrmCadExperimento frm = new FrmCadExperimento(null))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    eXPERIMENTOBindingSource.DataSource = db.EXPERIMENTO.ToList();
                }
            }
        }

        private void btnEdit_Click(object sender, EventArgs e)
        {
            if (eXPERIMENTOBindingSource.Current == null)
            {
                MessageBox.Show("Não há registro para ser editado!", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            using (FrmCadExperimento frm = new FrmCadExperimento(eXPERIMENTOBindingSource.Current as EXPERIMENTO))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    eXPERIMENTOBindingSource.DataSource = db.EXPERIMENTO.ToList();
                }
            }
        }

        private void btnDel_Click(object sender, EventArgs e)
        {
            if (eXPERIMENTOBindingSource.Current != null)
            {
                if (MessageBox.Show("Voce realmente quer deletar este registro?", "Messagem", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    db.EXPERIMENTO.Remove(eXPERIMENTOBindingSource.Current as EXPERIMENTO);
                    eXPERIMENTOBindingSource.RemoveCurrent();
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
