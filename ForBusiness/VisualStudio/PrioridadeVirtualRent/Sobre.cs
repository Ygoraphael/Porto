using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace PrioridadeVirtualRent
{
    public partial class Sobre : Form
    {
        public Sobre()
        {
            InitializeComponent();
            this.CenterToScreen();
            this.MinimumSize = new Size(300, 300);
            this.MaximumSize = new Size(300, 300);
        }
    }
}
