using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Agronomia.TelaPrincipal
{
    public partial class TCadastro : MetroFramework.Forms.MetroForm
    {
        public TCadastro()
        {
            InitializeComponent();
        }

        private void TCadastro_Load(object sender, EventArgs e)
        {

        }

        private void Ccadastro_Click(object sender, EventArgs e)
        {
            view.FrmUsuario frmUsu = new view.FrmUsuario();
            frmUsu.ShowDialog();
        }

        private void Cpropriedade_Click(object sender, EventArgs e)
        {
            view.FrmPropriedade frmPropriedade = new view.FrmPropriedade();
            frmPropriedade.ShowDialog();
        }

        private void Ccultura_Click(object sender, EventArgs e)
        {
            view.FrmCultura frm = new view.FrmCultura();
            frm.ShowDialog();
        }

        private void Cpadrao_Click(object sender, EventArgs e)
        {
            view.FrmPadraoVariavel frmPadrao = new view.FrmPadraoVariavel();
            frmPadrao.ShowDialog();
        }
    }
}
