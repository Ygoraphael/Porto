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
    public partial class frmPicarFO : Form
    {
        private string operacao;
        private int temporestante =1;        
        public frmPicarFO(string titulo, int numerofo, string reftar, string destar)
        {
            InitializeComponent();
            timer1.Enabled = true;
            operacao = titulo;
            lblTipoMov.Text = titulo;

            lblDesTar.Text = destar;
            lblRefTar.Text = reftar;
            lblFO.Text = numerofo.ToString();
            DateTime dat = DateTime.Now;

            if (operacao == "INICIAR TAREFA")
            {
                img.Image = NCPonto.Properties.Resources.fo;
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
                img.Image = NCPonto.Properties.Resources.fosai1;
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
                Classes.PicoFO pico = new Classes.PicoFO(txtCartao.Text,int.Parse(lblFO.Text),lblRefTar.Text, lblDesTar.Text);
                if (pico.ExisteCartao())
                {
                    lblNomeUtil.Text = pico.UtilizadorCartao();
                    txtCartao.Visible = false;
                    if (operacao == "INICIAR TAREFA")
                    {
                        if (pico.VerSeExistePicoAberto(lblNomeUtil.Text, "Entrada", int.Parse(lblFO.Text)))
                        {
                            string mens;
                            if (pico.NumeroFO == int.Parse(lblFO.Text) && pico.RefTar == lblRefTar.Text)
                            {
                                mens = string.Format("ATENÇÃO: A tarefa <{1}> já se encontra aberta na Folha de Obra nº {0}!", pico.NumeroFO, pico.DesTar);
                                MessageBox.Show(mens);
                            }
                            else
                            {
                                mens = string.Format("ATENÇÃO: Não pode abrir a tarefa porque a Folha de Obra nº {0} ainda está em curso na tarefa <{1}> !", pico.NumeroFO, pico.DesTar);
                                MessageBox.Show(mens);
                            }
                            this.Close();
                        }
                        else
                        {

                            if (!pico.VerSeExistePico(lblNomeUtil.Text, "Entrada", int.Parse(lblFO.Text)))
                            {
                                tmrRegEntrada.Enabled = true;

                               
                            }
                            else
                            {

                                this.Close();
                            }
                        }
                        
                    }
                    if (operacao == "TERMINAR TAREFA")
                    {
                        if (!pico.VerSeExistePicoDestaTarefa(lblNomeUtil.Text, "SAIDA", int.Parse(lblFO.Text), lblRefTar.Text) && (!pico.VerSeExistePicoAbertoDestaFO(lblNomeUtil.Text, "Entrada", int.Parse(lblFO.Text),lblRefTar.Text)))
                        {
                            string mens = string.Format("Impossível terminar esta tarefa porque ela não foi iniciada!", lblDesTar.Text, lblFO.Text);
                            MessageBox.Show(mens);
                            this.Close();
                        }
                        else
                        {
                            if (pico.VerSeExistePicoAbertoDestaFO(lblNomeUtil.Text, "Entrada", int.Parse(lblFO.Text),lblRefTar.Text))
                            {
                                string mens = string.Format("ATENÇÃO: Não pode encerrar esta tarefa porque está em curso <{0}> na Folha de Obra nº {1}", pico.DesTar, pico.NumeroFO);
                                MessageBox.Show(mens);                                
                                this.Close();
                            }
                            else
                            {
                                if (!pico.VerSeExistePico(lblNomeUtil.Text, "SAIDA", int.Parse(lblFO.Text)))
                                {
                                    tmrRegSaida.Enabled = true;
                                }
                                else
                                {
                                    this.Close();
                                }
                            }
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
            Classes.PicoFO pico = new Classes.PicoFO(txtCartao.Text, int.Parse(lblFO.Text), lblRefTar.Text, lblDesTar.Text);
            pico.TipoPico = lblTurno.Tag.ToString();
            if (TipoPico == "ENTRADA")
            {
                pico.InsereEntrada(lblNomeUtil.Text, lblTurno.Text, TipoPico);
            }
            if (TipoPico == "SAIDA")
            {
                pico.ActualizaSaida(lblNomeUtil.Text, lblTurno.Text, TipoPico);                             
            }

        }
        private void timer1_Tick(object sender, EventArgs e)
        {
            DateTime dat = DateTime.Now;
            lblHora.Text = dat.ToString("HH:mm:ss");
        }

        private void lblTurno_Click(object sender, EventArgs e)
        {
            if (operacao == "INICIAR TAREFA")
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

                // ver se picou ponto na entrada da FO
                Classes.Pico picopico = new Classes.Pico(txtCartao.Text);
                picopico.TipoPico = "E1";
                if (!picopico.VerSeExistePico(lblNomeUtil.Text, "Entrada"))
                {
                    tmrRegEntrada.Enabled = false;
                    DialogResult resp = MessageBox.Show("Atenção: Não existe pico de Entrada. Deseja registar nesta hora?", "PICO INEXISTENTE", MessageBoxButtons.YesNo);
                    if (resp == DialogResult.Yes)
                    {
                        picopico.InsereEntrada(lblNomeUtil.Text, lblTurno.Text, "E1");
                    }
                }
                else
                {
                    this.Close();
                }
                // ... fim 

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

        private void frmPicarFO_Load(object sender, EventArgs e)
        {

        }

        private void panel1_Paint(object sender, PaintEventArgs e)
        {

        }    
    }
}
