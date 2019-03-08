using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.ComponentModel;
using System.Drawing;

namespace NCDataOnlineService
{
    public class DlgWeb : Form
    {
        // Fields
        private IContainer components;
        private WebBrowser webBrowser1;

        // Methods
        public DlgWeb()
        {
            this.components = null;
            this.InitializeComponent();
        }

        public DlgWeb(string url, string title = "")
        {
            this.components = null;
            this.InitializeComponent();
            this.webBrowser1.Url = new Uri(url);
            this.Text = title;
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing && (this.components != null))
            {
                this.components.Dispose();
            }
            base.Dispose(disposing);
        }

        private void InitializeComponent()
        {
            ComponentResourceManager manager = new ComponentResourceManager(typeof(DlgWeb));
            this.webBrowser1 = new WebBrowser();
            base.SuspendLayout();
            this.webBrowser1.Dock = DockStyle.Fill;
            this.webBrowser1.Location = new Point(0, 0);
            this.webBrowser1.MinimumSize = new Size(20, 20);
            this.webBrowser1.Name = "webBrowser1";
            this.webBrowser1.Size = new Size(0x270, 0x1ba);
            this.webBrowser1.TabIndex = 0;
            base.ClientSize = new Size(0x270, 0x1ba);
            base.Controls.Add(this.webBrowser1);
            base.Name = "DlgWeb";
            base.StartPosition = FormStartPosition.CenterParent;
            base.ResumeLayout(false);
        }
    }


}
