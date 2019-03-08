using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace EOR_DRIS
{
    public partial class MsgBox : Form
    {
        public MsgBox(string title, string message)
        {
            InitializeComponent();
            this.Text = title;
            textBox1.Text = message;
            this.MinimumSize = new Size(403, 301);
            this.MaximumSize = new Size(403, 301);
            this.CenterToScreen();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void MsgBox_KeyDown(object sender, KeyEventArgs e)
        {
            if (e.Control && e.Alt && e.KeyCode == Keys.D0)
            {
                License childForm = new License();
                DialogResult dr = childForm.ShowDialog(this);
            }
        }
    }
}
