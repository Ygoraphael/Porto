using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

namespace PHCHide
{
    public partial class Form1 : Form
    {

        string senha = "cenas";

        public Form1()
        {
            InitializeComponent();
            this.MinimumSize = new Size(164, 94);
            this.MaximumSize = new Size(164, 94);
            this.CenterToScreen();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            if (textBox1.Text == senha)
            {
                CodeManagement childForm = new CodeManagement();
                DialogResult dr = childForm.ShowDialog(this);
                this.Close();
            }
        }

        private void textBox1_Enter(object sender, EventArgs e)
        {
            
        }

        private void textBox1_KeyUp(object sender, KeyEventArgs e)
        {
            if (e.KeyCode.ToString() == "Return")
            {
                if (textBox1.Text == senha)
                {
                    CodeManagement childForm = new CodeManagement();
                    DialogResult dr = childForm.ShowDialog(this);
                    this.Close();
                }
            }
        }

        private void Form1_Shown(object sender, EventArgs e)
        {
            textBox1.Focus();
        }
    }
}
