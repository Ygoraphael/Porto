using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace NCDataOnline
{
    public partial class Splash : Form
    {
        Timer tmr;

        public Splash()
        {
            InitializeComponent();
        }

        private void Splash_Shown(object sender, EventArgs e)
        {
            tmr = new Timer();
            tmr.Interval = 4000;
            tmr.Start();
            tmr.Tick += tmr_Tick;
        }

        void tmr_Tick(object sender, EventArgs e)
        {
            tmr.Stop();
            Form1 mf = new Form1();
            mf.Show();
            this.Hide();
        }
    }
}
