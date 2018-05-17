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
    public partial class TExperimento : MetroFramework.Forms.MetroForm
    {
        public TExperimento()
        {
            InitializeComponent();
        }

        private void TExperimento_Load(object sender, EventArgs e)
        {

        }

        private void metroTile1_Click(object sender, EventArgs e)
        {
            view.FrmExperimento frm = new view.FrmExperimento();
            frm.ShowDialog();
        }
    }
}
