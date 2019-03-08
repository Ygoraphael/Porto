using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace WindowsFormsApplication4
{
    public partial class Form1 : Form
    {

        Timer timer1;

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

        Processo[] listaProcessos;
        int tempo;
        public Form1()
        {
            InitializeComponent();
        }

        private void InitializeComponent()
        {
            throw new NotImplementedException();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            listaProcessos = new Processo[100];

            tempo = 0;
            timer1.Enabled = true;

            Random a = new Random();
            for (int i = 0; i < 100; i++)
            {
                listaProcessos[i] = new Processo(a.Next(0, 1000), a.Next(1, 50));
            }

        }

        private void Form1_Load(object sender, EventArgs e)
        {
            timer1.Enabled = false;

        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            label1.Text = "tempo: " + tempo;
            tempo++;

            for (int i = 0; i < 100; i++)
            {
                if (listaProcessos[i].tChegada == tempo)
                {
                    listBox1.Items.Add("\nChegou o processo " + i + " TC: " + tempo);
                    listaProcessos[i].estado = 1;
                }
            }
        }
    }
}
