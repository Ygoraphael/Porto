using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using Agronomia.view;
namespace Agronomia
{
    public partial class FrmPrincipal : Form
    {
        public FrmPrincipal()
        {
            InitializeComponent();
        }

        private void btnUsuário_Click(object sender, EventArgs e)
        {
            FrmUsuario frmUsu = new FrmUsuario();
            frmUsu.ShowDialog();
        }

        private void btnPropriedade_Click(object sender, EventArgs e)
        {
            FrmPropriedade frmPropriedade = new FrmPropriedade();
            frmPropriedade.ShowDialog();
        }

        private void btnPadrao_Click(object sender, EventArgs e)
        {
            FrmPadraoVariavel frmPadrao = new FrmPadraoVariavel();
            frmPadrao.ShowDialog();
        }

        private void btnGerminacao_Click(object sender, EventArgs e)
        {
            FrmGerminacao frmGerminacao = new FrmGerminacao();
            frmGerminacao.ShowDialog();
        }

        private void btnCompeticao_Click(object sender, EventArgs e)
        {
            FrmCompeticao frm = new FrmCompeticao();
            frm.ShowDialog();
        }

        private void btnCultura_Click(object sender, EventArgs e)
        {
            FrmCultura frm = new FrmCultura();
            frm.ShowDialog();
        }

        private void btnColetaGerminacao_Click(object sender, EventArgs e)
        {
            FrmColetaGerminacao frm = new FrmColetaGerminacao();
            frm.ShowDialog();
        }

        private void btnCadastroExperimento_Click(object sender, EventArgs e)
        {
            FrmExperimento frm = new FrmExperimento();
            frm.ShowDialog();
        }

        private void btnColetaExperimento_Click(object sender, EventArgs e)
        {
            FrmColetaExperimento frm = new FrmColetaExperimento();
            frm.ShowDialog();
        }

        private void btnSair_Click(object sender, EventArgs e)
        {
            Close();
        }
    }
}
