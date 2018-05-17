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
    public partial class FrmCadGerminacao : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmCadGerminacao(GERMINACAO obj)
        {
            InitializeComponent();
           // cbbExperimento.ValueMember   = "CODI_EXP";
           // cbbExperimento.DisplayMember = "CODI_EXP";

            db = new ProAgroEntities();
            if (obj == null)
            {
             //   cbbExperimento.DataSource = db.EXPERIMENTO.ToList();
                //uSUARIOBindingSource.DataSource = new USUARIO();
                //db.USUARIO.Add(uSUARIOBindingSource.Current as USUARIO);
            }
            else
            {
             //   cbbExperimento.DataSource = db.GERMINACAO.Join
                //uSUARIOBindingSource.DataSource = obj;
                //db.USUARIO.Attach(uSUARIOBindingSource.Current as USUARIO);
            }
        }

        private void FrmCadGerminacao_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (DialogResult == DialogResult.OK)
            {
                db.SaveChanges();
                e.Cancel = false;
            }
            e.Cancel = false;
        }

        private void btnCan_Click(object sender, EventArgs e)
        {
            Close();
        }

        private void FrmCadGerminacao_Load(object sender, EventArgs e)
        {

        }
    }
}
