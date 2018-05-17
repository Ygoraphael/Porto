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
    public partial class FrmCompeticao : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmCompeticao()
        {
            InitializeComponent();
        }

        private void FrmCompeticao_Load(object sender, EventArgs e)
        {
            db = new ProAgroEntities();
            cOMPETICAOBindingSource.DataSource = db.COMPETICAO.ToList();
        }


        private void btnAdd_Click(object sender, EventArgs e)
        {
            using (FrmCadCompeticao frm = new FrmCadCompeticao(null))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    cOMPETICAOBindingSource.DataSource = db.COMPETICAO.ToList();
                }
            }
        }

        private void btnEdit_Click(object sender, EventArgs e)
        {
            if (cOMPETICAOBindingSource.Current == null)
            {
                MessageBox.Show("Não há registro para ser editado!", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            using (FrmCadCompeticao frm = new FrmCadCompeticao(cOMPETICAOBindingSource.Current as COMPETICAO))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    cOMPETICAOBindingSource.DataSource = db.COMPETICAO.ToList();
                }
            }
        }

        private void btnDel_Click(object sender, EventArgs e)
        {
            if (cOMPETICAOBindingSource.Current != null)
            {
                if (MessageBox.Show("Voce realmente quer deletar este registro?", "Messagem", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    db.COMPETICAO.Remove(cOMPETICAOBindingSource.Current as COMPETICAO);
                    cOMPETICAOBindingSource.RemoveCurrent();
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
