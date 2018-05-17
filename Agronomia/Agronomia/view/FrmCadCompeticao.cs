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
    public partial class FrmCadCompeticao : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmCadCompeticao(COMPETICAO obj)
        {
            InitializeComponent();
            db = new ProAgroEntities();
            cbbCultura.DataSource = db.CULTURA.ToList();
            cbbCultura.DisplayMember = "NOMCUL_CUL";
            cbbCultura.ValueMember = "CODI_CUL";
            if (obj == null)
            {
                cOMPETICAOBindingSource.DataSource = new COMPETICAO();
                db.COMPETICAO.Add(cOMPETICAOBindingSource.Current as COMPETICAO);
            }
            else
            {
                cOMPETICAOBindingSource.DataSource = obj;
                db.COMPETICAO.Attach(cOMPETICAOBindingSource.Current as COMPETICAO);
            }
        }
        private void FrmCadCompeticao_FormClosing(object sender, FormClosingEventArgs e)
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

        private void FrmCadCompeticao_Load(object sender, EventArgs e)
        {

        }
    }
}
