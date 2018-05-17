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
    public partial class FrmPropriedade : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmPropriedade()
        {
            InitializeComponent();
        }

        private void FrmPropriedade_Load(object sender, EventArgs e)
        {
            db = new ProAgroEntities();
            pROPRIEDADEBindingSource.DataSource = db.PROPRIEDADE.ToList();
        }


        private void btnAdd_Click(object sender, EventArgs e)
        {
            using (FrmCadPropriedade frm = new FrmCadPropriedade(null))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    pROPRIEDADEBindingSource.DataSource = db.PROPRIEDADE.ToList();
                }
            }
        }

        private void btnEdit_Click(object sender, EventArgs e)
        {
            if (pROPRIEDADEBindingSource.Current == null)
            {
                MessageBox.Show("Não há registro para ser editado!", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            using (FrmCadPropriedade frm = new FrmCadPropriedade(pROPRIEDADEBindingSource.Current as PROPRIEDADE))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    pROPRIEDADEBindingSource.DataSource = db.PROPRIEDADE.ToList();
                }
            }
        }

        private void btnDel_Click(object sender, EventArgs e)
        {
            if (pROPRIEDADEBindingSource.Current != null)
            {
                if (MessageBox.Show("Voce realmente quer deletar este registro?", "Messagem", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    db.PROPRIEDADE.Remove(pROPRIEDADEBindingSource.Current as PROPRIEDADE);
                    pROPRIEDADEBindingSource.RemoveCurrent();
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
