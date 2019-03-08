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
    public partial class Preferencias : Form
    {
        public Preferencias()
        {
            InitializeComponent();
            this.MinimumSize = new Size(651, 300);
            this.MaximumSize = new Size(651, 300);
            this.CenterToScreen();
        }

        private void button3_Click(object sender, EventArgs e)
        {
            this.Close();
        }
    }
}
