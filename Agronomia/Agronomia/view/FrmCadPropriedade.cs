using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Data.Entity.Validation;

namespace Agronomia.view
{
    public partial class FrmCadPropriedade : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmCadPropriedade(PROPRIEDADE obj)
        {
            InitializeComponent();
            db = new ProAgroEntities();
            if (obj == null)
            {
                pROPRIEDADEBindingSource.DataSource = new PROPRIEDADE();
                db.PROPRIEDADE.Add(pROPRIEDADEBindingSource.Current as PROPRIEDADE);
            }
            else
            {
                pROPRIEDADEBindingSource.DataSource = obj;
                try
                {
                    db.PROPRIEDADE.Attach(pROPRIEDADEBindingSource.Current as PROPRIEDADE);
                }
                catch (DbEntityValidationException e)
                {
                    foreach (var eve in e.EntityValidationErrors)
                    {
                        foreach (var ve in eve.ValidationErrors)
                        {
                            MessageBox.Show(" Property: "+ve.PropertyName+" Erro:"+ve.ErrorMessage+ ".", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Error);
                        }
                    }
                    
                }
            }
        }
        private void FrmPropriedade_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (DialogResult == DialogResult.OK)
            {
                if (string.IsNullOrEmpty(txtNomePropriedade.Text))
                {
                    MessageBox.Show("Insira um nome de propriedade por favor!", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    txtNomePropriedade.Focus();
                    e.Cancel = true;
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

        private void FrmCadPropriedade_Load(object sender, EventArgs e)
        {

        }
    }
}
