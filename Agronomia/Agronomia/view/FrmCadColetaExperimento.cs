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
    public partial class FrmCadColetaExperimento : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmCadColetaExperimento(COLETAEXPERIMENTO obj)
        {
            InitializeComponent();
            db = new ProAgroEntities();
            if (obj == null)
            {
                cOLETAEXPERIMENTOBindingSource.DataSource = new COLETAEXPERIMENTO();
                db.COLETAEXPERIMENTO.Add(cOLETAEXPERIMENTOBindingSource.Current as COLETAEXPERIMENTO);
            }
            else
            {
                cOLETAEXPERIMENTOBindingSource.DataSource = obj;
                db.COLETAEXPERIMENTO.Attach(cOLETAEXPERIMENTOBindingSource.Current as COLETAEXPERIMENTO);
            }
        }
        private void FrmCadColetaExperimento_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (DialogResult == DialogResult.OK)
            {
                if (string.IsNullOrEmpty(cbbTratamento.Text))
                {
                    MessageBox.Show("Insira um tratatemnto por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    cbbTratamento.Focus();
                    e.Cancel = true;
                    return;
                }
                else if (string.IsNullOrEmpty(cbbRepeticao.Text))
                {
                    MessageBox.Show("Insira uma repetição por favor!");
                    cbbRepeticao.Focus();
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

        private void groupBox2_Enter(object sender, EventArgs e)
        {

        }
    }
}
