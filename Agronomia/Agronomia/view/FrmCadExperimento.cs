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
    public partial class FrmCadExperimento : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmCadExperimento(EXPERIMENTO obj)
        {
            InitializeComponent();
            db = new ProAgroEntities();
            cbbCompeticao.DataSource = db.COMPETICAO.ToList();
            cbbCompeticao.DisplayMember = "NOMECO_COM";
            cbbCompeticao.ValueMember   = "CODI_COM";

            cbbPropriedade.DataSource = db.PROPRIEDADE.ToList();
            cbbPropriedade.DisplayMember = "NOMEPR_PRO";
            cbbPropriedade.ValueMember   = "CODI_PRO";

            cbbPadraoVariavel.DataSource = db.NOMEPADRAOVARIAVEIS.ToList();
            cbbPadraoVariavel.DisplayMember = "CODI_PAD";
            cbbPadraoVariavel.ValueMember   = "CODI_PAD";

            if (obj == null)
            {
                eXPERIMENTOBindingSource.DataSource = new EXPERIMENTO();
                db.EXPERIMENTO.Add(eXPERIMENTOBindingSource.Current as EXPERIMENTO);
            }
            else
            {
                eXPERIMENTOBindingSource.DataSource = obj;
                db.EXPERIMENTO.Attach(eXPERIMENTOBindingSource.Current as EXPERIMENTO);
            }
        }
        private void FrmCadExperimento_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (DialogResult == DialogResult.OK)
            {
                if (string.IsNullOrEmpty(cbbPadraoVariavel.Text))
                {
                    MessageBox.Show("Informe um padrão de variavel por favor!", "Message", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    cbbPadraoVariavel.Focus();
                    e.Cancel = true;
                    return;
                }
                else if (string.IsNullOrEmpty(cbbPropriedade.Text))
                {
                    MessageBox.Show("Insira uma propriedade por favor!");
                    cbbPropriedade.Focus();
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

        private void FrmCadExperimento_Load(object sender, EventArgs e)
        {

        }
    }
}
