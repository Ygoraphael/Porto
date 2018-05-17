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
    public partial class FrmCadUsuario : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmCadUsuario(USUARIO obj)
        {
            InitializeComponent();
            db = new ProAgroEntities();
            if (obj == null)
            {
                uSUARIOBindingSource.DataSource = new USUARIO();
                db.USUARIO.Add(uSUARIOBindingSource.Current as USUARIO);
            }
            else
            {
                uSUARIOBindingSource.DataSource = obj;
                db.USUARIO.Attach(uSUARIOBindingSource.Current as USUARIO);
            }
        }
        private void FrmCadUsuario_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (DialogResult == DialogResult.OK)
            {
                if (string.IsNullOrEmpty(txtLogin.Text))
                {
                    MessageBox.Show("Insira um login por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    txtLogin.Focus();
                    e.Cancel = true;
                    return;
                }

                else if (string.IsNullOrEmpty(txtSenha.Text))
                {
                    MessageBox.Show("Insira um Senha por favor!");
                    txtSenha.Focus();
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

        private void FrmCadUsuario_Load(object sender, EventArgs e)
        {

        }
    }
}
