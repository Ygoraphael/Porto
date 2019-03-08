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
    public partial class AlertForm : Form
    {

        public AlertForm()
        {
            InitializeComponent();
            this.MinimumSize = new Size(288, 154);
            this.MaximumSize = new Size(288, 154);
            this.CenterToScreen();
        }

        public string Message
        {
            set { labelMessage.Text = value; }
        }
    }
}
