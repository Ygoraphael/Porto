﻿using System;
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
    public partial class FrmPadraoVariavel : MetroFramework.Forms.MetroForm
    {
        ProAgroEntities db;
        public FrmPadraoVariavel()
        {
            InitializeComponent();
        }

        private void FrmPadraoVariavel_Load(object sender, EventArgs e)
        {
            db = new ProAgroEntities();
            nOMEPADRAOVARIAVEISBindingSource.DataSource = db.NOMEPADRAOVARIAVEIS.ToList();
        }

        private void btnAdd_Click(object sender, EventArgs e)
        {
            using (FrmCadPadraoVariavel frm = new FrmCadPadraoVariavel(null))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    nOMEPADRAOVARIAVEISBindingSource.DataSource = db.NOMEPADRAOVARIAVEIS.ToList();
                }
            }
        }

        private void btnEdit_Click(object sender, EventArgs e)
        {
            if (nOMEPADRAOVARIAVEISBindingSource.Current == null)
            {
                MessageBox.Show("Não há registro para ser editado!", "Messagem", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            using (FrmCadPadraoVariavel frm = new FrmCadPadraoVariavel(nOMEPADRAOVARIAVEISBindingSource.Current as NOMEPADRAOVARIAVEIS))
            {
                if (frm.ShowDialog() == DialogResult.OK)
                {
                    nOMEPADRAOVARIAVEISBindingSource.DataSource = db.NOMEPADRAOVARIAVEIS.ToList();
                }
            }
        }

        private void btnDel_Click(object sender, EventArgs e)
        {
            if (nOMEPADRAOVARIAVEISBindingSource.Current != null)
            {
                if (MessageBox.Show("Voce realmente quer deletar este registro?", "Messagem", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    db.NOMEPADRAOVARIAVEIS.Remove(nOMEPADRAOVARIAVEISBindingSource.Current as NOMEPADRAOVARIAVEIS);
                    nOMEPADRAOVARIAVEISBindingSource.RemoveCurrent();
                    db.SaveChanges();
                }
            }
        }

        private void btnCan_Click(object sender, EventArgs e)
        {
            Close();
        }
    }
}