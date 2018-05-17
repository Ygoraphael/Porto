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
    public partial class FrmPrincipal : MetroFramework.Forms.MetroForm
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

        private void FrmPrincipal_Load(object sender, EventArgs e)
        {

        }

        private void button5_Click(object sender, EventArgs e)
        {

        }

        private void button6_Click(object sender, EventArgs e)
        {

        }

        private void TCadastros_Click(object sender, EventArgs e)
        {
            TelaPrincipal.TCadastro frm = new TelaPrincipal.TCadastro();
            frm.ShowDialog();
        }

        private void TExperimento_Click(object sender, EventArgs e)
        {
            TelaPrincipal.TExperimento frm = new TelaPrincipal.TExperimento();
            frm.ShowDialog();
        }

        private void TGerminacao_Click(object sender, EventArgs e)
        {
            TelaPrincipal.TGerminacao frm = new TelaPrincipal.TGerminacao();
            frm.ShowDialog();
        }

        private void pictureBox1_Click(object sender, EventArgs e)
        {

        }

        private void panel1_Paint(object sender, PaintEventArgs e)
        {

        }
    }
}
