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
    public partial class FrmUsuario : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmUsuario()
        {
            InitializeComponent();
        }

        private void FrmUsuarios_Load(object sender, EventArgs e)
        {
            db = new ProAgroEntities();
            uSUARIOBindingSource.DataSource = db.USUARIO.ToList();
        }


        private void btnAdd_Click(object sender, EventArgs e)
        {
            using (FrmCadUsuario frm = new FrmCadUsuario(null))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                      uSUARIOBindingSource.DataSource = db.USUARIO.ToList();
                }
            }
        }

        private void btnEdit_Click(object sender, EventArgs e)
        {
            if (uSUARIOBindingSource.Current == null)
            {
                MessageBox.Show("Não há registro para ser editado!", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            using (FrmCadUsuario frm = new FrmCadUsuario(uSUARIOBindingSource.Current as USUARIO))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    uSUARIOBindingSource.DataSource = db.USUARIO.ToList();
                }
            }
        }

        private void btnDel_Click(object sender, EventArgs e)
        {
            if (uSUARIOBindingSource.Current != null)
            {
                if (MessageBox.Show("Voce realmente quer deletar este registro?", "Messagem", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    db.USUARIO.Remove(uSUARIOBindingSource.Current as USUARIO);
                    uSUARIOBindingSource.RemoveCurrent();
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
