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
    public partial class FrmCadColetaGerminacao : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmCadColetaGerminacao(COLETAGERMINACAO obj)
        {
            InitializeComponent();
            db = new ProAgroEntities();
            cbbGerminacao.DataSource = db.GERMINACAO.ToList();
            cbbGerminacao.DisplayMember = "ESPECI_GER";
            cbbGerminacao.ValueMember = "CODI_GER";
            if (obj == null)
            {
                cOLETAGERMINACAOBindingSource.DataSource = new COLETAGERMINACAO();
                db.COLETAGERMINACAO.Add(cOLETAGERMINACAOBindingSource.Current as COLETAGERMINACAO);
            }
            else
            {
                cOLETAGERMINACAOBindingSource.DataSource = obj;
                db.COLETAGERMINACAO.Attach(cOLETAGERMINACAOBindingSource.Current as COLETAGERMINACAO);
            }
        }
        private void FrmCadColetaGerminacao_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (DialogResult == DialogResult.OK)
            {
                if (string.IsNullOrEmpty(cbbGerminacao.Text))
                {
                    MessageBox.Show("Insira uma germinação por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    cbbGerminacao.Focus();
                    e.Cancel = true;
                    return;
                }
                else if (string.IsNullOrEmpty(txtDATCOG.Text))
                {
                    MessageBox.Show("Insira uma data de coleta por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    txtDATCOG.Focus();
                    e.Cancel = true;
                    return;
                }
                else if (string.IsNullOrEmpty(txtNAOGER.Text))
                {
                    MessageBox.Show("Insira quantidade de semente não germinada por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    txtNAOGER.Focus();
                    e.Cancel = true;
                    return;
                }
                else if (string.IsNullOrEmpty(txtPLAACO.Text))
                {
                    MessageBox.Show("Insira um plano de acompanhamento por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    txtPLAACO.Focus();
                    e.Cancel = true;
                    return;
                }
                else if (string.IsNullOrEmpty(txtPORGER.Text))
                {
                    MessageBox.Show("Insira uma porcentagem de coleta por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    txtPORGER.Focus();
                    e.Cancel = true;
                    return;
                }
                else if (string.IsNullOrEmpty(txtREPETI.Text))
                {
                    MessageBox.Show("Insira numero de repetição por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    txtREPETI.Focus();
                    e.Cancel = true;
                    return;
                }
                else if (string.IsNullOrEmpty(txtSEMGER.Text))
                {
                    MessageBox.Show("Insira quantidade de semente germinada por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    txtSEMGER.Focus();
                    e.Cancel = true;
                    return;
                }
                else if (string.IsNullOrEmpty(txtTRATAM.Text))
                {
                    MessageBox.Show("Insira numero de tratamentos por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    txtTRATAM.Focus();
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

        private void FrmCadColetaGerminacao_Load(object sender, EventArgs e)
        {

        }
    }
}
