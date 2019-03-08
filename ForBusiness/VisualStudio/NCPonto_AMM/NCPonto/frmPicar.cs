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
    public partial class frmPicar : Form
    {
        private string operacao;
        private int temporestante =1;        
        public frmPicar(string titulo)
        {
            InitializeComponent();
            timer1.Enabled = true;
            operacao = titulo;
            lblTipoMov.Text = titulo;
            DateTime dat = DateTime.Now;

            if (operacao == "ENTRAR AO SERVIÇO")
            {
                img.Image = NCPonto.Properties.Resources.entrar;
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
                img.Image = NCPonto.Properties.Resources.sair;

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

        private void cmdVoltar_Click(object sender, EventArgs e)
        {
            tmrRegEntrada.Enabled = false;
            tmrRegSaida.Enabled = false;
            this.Close();            
        }

        private void txtCartao_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == (char)Keys.Enter)
            {
                if (txtCartao.Text == "nc7")
                {
                    _frmConfig frc = new _frmConfig();
                    frc.ShowDialog();
                    this.Close();
                }
                Classes.Pico pico = new Classes.Pico(txtCartao.Text);
                if (pico.ExisteCartao())
                {
                    lblNomeUtil.Text = pico.UtilizadorCartao();
                    txtCartao.Visible = false;
                    if (operacao == "ENTRAR AO SERVIÇO")
                    {
                        if (!pico.VerSeExistePico(lblNomeUtil.Text, "Entrada"))
                        {
                            tmrRegEntrada.Enabled = true;
                        }
                        else
                        {
                            MessageBox.Show("Este cartão já tem uma entrada em aberto!");
                            this.Close();
                        }

                    }
                    if (operacao == "SAIR DO SERVIÇO")
                    {
                        if (!pico.VerSeExistePico(lblNomeUtil.Text, "SAIDA"))
                        {
                            tmrRegSaida.Enabled = true;
                        }
                        else
                        {
                            MessageBox.Show("Este cartão não tem nenhuma entrada em aberto!");
                            this.Close();
                        }
                    }
                }
                else
                {
                    MessageBox.Show("Cartão inválido!");
                    txtCartao.Text = "";
                    txtCartao.Focus();
                }
            }
        }

        private void GravaPico(string TipoPico)
        {
            Classes.Pico pico = new Classes.Pico(txtCartao.Text);
            pico.TipoPico = lblTurno.Tag.ToString();
            if (TipoPico == "ENTRADA")
            {
                pico.InsereEntrada(lblNomeUtil.Text, lblTurno.Text, TipoPico);
            }
            if (TipoPico == "SAIDA")
            {
                pico.ActualizaSaida(lblNomeUtil.Text, lblTurno.Text, TipoPico);
                // ver se existe folha aberta
                Classes.PicoFO picopicoFO = new Classes.PicoFO(txtCartao.Text,0,"", "");
                if (picopicoFO.VerSeExistePicoAberto(lblNomeUtil.Text, "Entrada", 0))
                {
                    tmrRegSaida.Enabled = false;
                    string mens = string.Format("A tarefa «{0}» da Folha de Obra nº {1} não foi encerrada. Deseja encerrar nesta hora?", picopicoFO.DesTar, picopicoFO.NumeroFO);
                    DialogResult resp = MessageBox.Show(mens, "FOLHA DE OBRA POR ENCERRAR", MessageBoxButtons.YesNo);
                    if (resp == DialogResult.Yes)
                    {
                        picopicoFO.ActualizaSaida(lblNomeUtil.Text, lblTurno.Text, TipoPico);
                    }

                    this.Close();
                }
                // fim...
            }

        }
        private void timer1_Tick(object sender, EventArgs e)
        {
            DateTime dat = DateTime.Now;
            lblHora.Text = dat.ToString("HH:mm:ss");
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

        private void tmrRegEntrada_Tick(object sender, EventArgs e)
        {
            temporestante -= 1;
            if (temporestante < 0)
            {
                GravaPico("ENTRADA");
                tmrRegEntrada.Enabled = false;
                this.Close();

            }
        }

        private void tmrRegSaida_Tick(object sender, EventArgs e)
        {
            temporestante -= 1;
            if (temporestante < 0)
            {
                GravaPico("SAIDA");
                tmrRegSaida.Enabled = false;
                this.Close();

            }
        }

        private void txtCartao_TextChanged(object sender, EventArgs e)
        {
            
        }    
    }
}
