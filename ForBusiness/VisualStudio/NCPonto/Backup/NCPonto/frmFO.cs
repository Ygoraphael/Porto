using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace NCPonto
{
    public partial class frmFO : Form
    {
        private string operacao;
        DateTime dat = DateTime.Now;
        public frmFO(string titulo)

        {
            InitializeComponent();
            operacao = titulo;
            lblTipoMov.Text = titulo;
        }

        private void frmFO_Load(object sender, EventArgs e)
        {
            if (operacao == "INICIAR TAREFA")
            {
                cmdContinuar.Image = NCPonto.Properties.Resources.fo;
                if (dat.TimeOfDay.Hours < 13)
                {
                    lblTurno.Text = "Turno da Manhã";
                    lblTurno.Tag = "E1";
                }
                else
                {
                    lblTurno.Text = "Turno da Tarde";
                    lblTurno.Tag = "E2";
                }
            }
            else
            {
                cmdContinuar.Image = NCPonto.Properties.Resources.fosai1;
                if (dat.TimeOfDay.Hours <= 13)
                {
                    lblTurno.Text = "Turno da Manhã";
                    lblTurno.Tag = "S1";
                }
                else
                {
                    lblTurno.Text = "Turno da Tarde";
                    lblTurno.Tag = "S2";
                }
            }
        }
        private void Teclado(string tecla)
        {
            txtFO.Text = txtFO.Text + tecla;
        }

        private void txt0_Click(object sender, EventArgs e)
        {
            Teclado(txt0.Text);
        }

        private void txt1_Click(object sender, EventArgs e)
        {
            Teclado(txt1.Text);
        }

        private void txt2_Click(object sender, EventArgs e)
        {
            Teclado(txt2.Text);
        }

        private void txt3_Click(object sender, EventArgs e)
        {
            Teclado(txt3.Text);
        }

        private void txt4_Click(object sender, EventArgs e)
        {
            Teclado(txt4.Text);
        }

        private void txt5_Click(object sender, EventArgs e)
        {
            Teclado(txt5.Text);
        }

        private void txt6_Click(object sender, EventArgs e)
        {
            Teclado(txt6.Text);
        }

        private void txt7_Click(object sender, EventArgs e)
        {
            Teclado(txt7.Text);
        }

        private void txt8_Click(object sender, EventArgs e)
        {
            Teclado(txt8.Text);
        }

        private void txt9_Click(object sender, EventArgs e)
        {
            Teclado(txt9.Text);
        }

        private void txtM_Click(object sender, EventArgs e)
        {
            try
            {

                txtFO.Text = txtFO.Text.Substring(0, txtFO.Text.Length - 1);
            }

            catch
            {
            }

        }

        private void cmdVoltar_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void lblTurno_Click(object sender, EventArgs e)
        {
            if (operacao == "ENTRAR AO SERVIÇO")
            {
                if (lblTurno.Tag.ToString() == "E1")
                {
                    lblTurno.Text = "Turno da Tarde";
                    lblTurno.Tag = "E2";
                }
                else
                {
                    lblTurno.Text = "Turno da Manhã";
                    lblTurno.Tag = "E1";
                }
            }
            else
            {
                if (lblTurno.Tag.ToString() == "S1")
                {
                    lblTurno.Text = "Turno da Tarde";
                    lblTurno.Tag = "S2";
                }
                else
                {
                    lblTurno.Text = "Turno da Manhã";
                    lblTurno.Tag = "S1";
                }
            }
        }

        private void txtOk_Click(object sender, EventArgs e)
        {
            Classes.FO fo = new Classes.FO(int.Parse(txtFO.Text));
            dgvTarefas.DataSource = null;
            try
            {
                dgvTarefas.DataSource = fo.MostraTarefas().Tables[0];
                FormataGrade();
            }
            catch
            {
            }
        }
        private void FormataGrade()
        {
            dgvTarefas.Columns[0].AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
            dgvTarefas.Columns[1].Width = 0;
            dgvTarefas.Columns[1].Visible = false;
            dgvTarefas.Columns[2].Width = 0;
            dgvTarefas.Columns[2].Visible = false;
            dgvTarefas.CurrentRow.Selected = false;

            int rowHeight = 60;

            this.dgvTarefas.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.None;
            int numRows = this.dgvTarefas.Rows.Count;
            for (int i = 0; i < numRows; i++)
            {
                this.dgvTarefas.Rows[i].Height = rowHeight;

            }


        }

        private void cmdContinuar_Click(object sender, EventArgs e)
        {
            this.Tag = "S";
            if (lblTipoMov.Text=="INICIAR TAREFA")
            {
                if (dgvTarefas.SelectedRows.Count > 0)
                {
                AbreFrmPico("INICIAR TAREFA");
                }
            }
            else
                if (dgvTarefas.SelectedRows.Count > 0)
                {
                    AbreFrmPico("TERMINAR TAREFA");
                }
        }
        private void AbreFrmPico(string titulo)
        {
            int nfo = int.Parse(txtFO.Text);
            string rt = dgvTarefas.Rows[dgvTarefas.CurrentRow.Index].Cells[1].Value.ToString();
            string dt = dgvTarefas.Rows[dgvTarefas.CurrentRow.Index].Cells[0].Value.ToString();

            frmPicarFO frm = new frmPicarFO(titulo, nfo, rt, dt);            
            frm.ShowDialog();
        }

        private void frmFO_Activated(object sender, EventArgs e)
        {
            if (this.Tag == "S") 
            { 
                this.Close(); 
            }
        }

        private void dgvTarefas_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {

        }
    }
}
