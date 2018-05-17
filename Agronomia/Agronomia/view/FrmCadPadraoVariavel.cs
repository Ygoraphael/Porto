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
    public partial class FrmCadPadraoVariavel : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmCadPadraoVariavel(NOMEPADRAOVARIAVEIS obj)
        {
            InitializeComponent();
            db = new ProAgroEntities();
            if (obj == null)
            {
                nOMEPADRAOVARIAVEISBindingSource.DataSource = new NOMEPADRAOVARIAVEIS();
                db.NOMEPADRAOVARIAVEIS.Add(nOMEPADRAOVARIAVEISBindingSource.Current as NOMEPADRAOVARIAVEIS);
            }
            else
            {
                nOMEPADRAOVARIAVEISBindingSource.DataSource = obj;
                db.NOMEPADRAOVARIAVEIS.Attach(nOMEPADRAOVARIAVEISBindingSource.Current as NOMEPADRAOVARIAVEIS);
            }
        }
        private void FrmCadPadraoVariavel_FormClosing(object sender, FormClosingEventArgs e)
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

        private void FrmCadPadraoVariavel_Load(object sender, EventArgs e)
        {

        }
    }
}
