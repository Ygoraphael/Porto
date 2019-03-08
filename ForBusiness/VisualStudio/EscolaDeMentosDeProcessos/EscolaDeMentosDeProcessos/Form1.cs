using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace EscolaDeMentosDeProcessos
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        struct Processo
        {
            public int tChegada;
            public int tProcessador;
            public int tSaida;
            public int estado;

            public Processo(int tc, int tp)
            {
                tChegada = tc;
                tProcessador = tp;
                tSaida = 0;
                estado = 0;
            }
        }

        List<Int32> aExecutar;
        Processo[] listaProcessos;
        int tempo;
        int nProcessos;
        int delta1Chegada;
        int delta2Chegada;
        int delta1Execucao;
        int delta2Execucao;
        int processoExecutar;
        int tempoProcessamento;

        private void button1_Click(object sender, EventArgs e)
        {
            processoExecutar = -1;
            aExecutar = new List<int>();
            nProcessos = Int32.Parse(textBox1.Text);
            delta1Chegada = Int32.Parse(textBox2.Text);
            delta2Chegada = Int32.Parse(textBox3.Text);
            delta1Execucao = Int32.Parse(textBox4.Text);
            delta2Execucao = Int32.Parse(textBox5.Text);
            listaProcessos = new Processo[nProcessos];
            tempoProcessamento = 0;
            dataGridView1.Rows.Clear();
            listBox1.Items.Clear();
            listBox2.Items.Clear();

            tempo = -1;
            
            Random a = new Random();
            for (int i = 0; i < nProcessos; i++)
            {
                listaProcessos[i] = new Processo(a.Next(delta1Chegada, delta2Chegada), a.Next(delta1Execucao, delta2Execucao));
                dataGridView1.Rows.Add(i, listaProcessos[i].tChegada, listaProcessos[i].tProcessador, listaProcessos[i].tSaida, listaProcessos[i].estado);
            }

            timer1.Enabled = true;
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            tempo++;
            label4.Text = "tempo: " + tempo;

            //verificar se processo deve estar no estado 1
            for (int i = 0; i < nProcessos; i++)
            {
                if (listaProcessos[i].tChegada == tempo)
                {
                    listBox1.Items.Add("\nChegou o processo " + i + " Tempo Chegada: " + tempo);
                    //Estado 1 - à espera
                    listaProcessos[i].estado = 1;
                    dataGridView1[4, i].Value = 1;
                    aExecutar.Add(i);
                    listBox2.Items.Add("\nProcesso " + i);
                }
            }

            //verificar se está a executar alguma coisa. se não estiver, executa
            if (processoExecutar == -1)
            {
                if (aExecutar.Count > 0)
                {
                    int idExec = aExecutar.ElementAt(0);
                    aExecutar.RemoveAt(0);
                    listBox2.Items.RemoveAt(0);
                    label6.Text = "A executar processo " + idExec;
                    processoExecutar = idExec;
                    //Estado 2 - em execucao
                    listaProcessos[idExec].estado = 2;
                    dataGridView1[4, idExec].Value = 2;
                    tempoProcessamento = 0;
                    label7.Text = "Tempo execução " + tempoProcessamento;
                }
            }
            else
            {
                tempoProcessamento++;
                label7.Text = "Tempo execução " + tempoProcessamento;
                //verificar se processo já terminou
                if (tempoProcessamento == listaProcessos[processoExecutar].tProcessador)
                {
                    //terminou processo
                    listaProcessos[processoExecutar].estado = 3;
                    dataGridView1[4, processoExecutar].Value = 3;
                    dataGridView1[3, processoExecutar].Value = tempo;
                    processoExecutar = -1;
                    tempoProcessamento = 0;
                    label6.Text = "A executar processo ";
                }
            }
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            timer1.Enabled = false;
        }

        private void button2_Click(object sender, EventArgs e)
        {
            timer1.Enabled = false;
        }



    }
}
