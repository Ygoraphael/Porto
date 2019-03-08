using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.ComponentModel;
using System.Drawing;

namespace NCDataOnline
{
    public class DlgQuestion : Form
    {
        // Fields
        private Button button1;
        private Button button2;
        private Button button3;
        private IContainer components;
        private Panel panel2;
        private TableLayoutPanel tableLayoutPanel1;
        private TextBox textBox1;

        // Methods
        public DlgQuestion()
        {
            this.components = null;
            this.InitializeComponent();
        }

        public DlgQuestion(string question, string title = "", string btnYes = "Sim", string btnNo = "N\x00e3o", string btnCancel = "Cancelar", bool permiteCancelar = true)
        {
            this.components = null;
            this.InitializeComponent();
            this.textBox1.Text = question;
            this.Text = title;
            this.button1.Text = btnYes;
            this.button2.Text = btnNo;
            this.button3.Text = btnCancel;
            this.button3.Enabled = permiteCancelar;
            int num = (int)Math.Ceiling((double)base.CreateGraphics().MeasureString(this.textBox1.Text, this.textBox1.Font, this.textBox1.Width).Height);
            if (num > this.textBox1.Height)
            {
                this.textBox1.Height = num;
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            base.Close();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            base.Close();
        }

        private void button3_Click(object sender, EventArgs e)
        {
            base.Close();
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing && (this.components != null))
            {
                this.components.Dispose();
            }
            base.Dispose(disposing);
        }

        private void DlgQuestion_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (((e.CloseReason == CloseReason.UserClosing) && !this.button3.Enabled) && (base.DialogResult == DialogResult.Cancel))
            {
                e.Cancel = true;
            }
        }

        private void InitializeComponent()
        {
            this.tableLayoutPanel1 = new TableLayoutPanel();
            this.textBox1 = new TextBox();
            this.panel2 = new Panel();
            this.button3 = new Button();
            this.button2 = new Button();
            this.button1 = new Button();
            this.tableLayoutPanel1.SuspendLayout();
            this.panel2.SuspendLayout();
            base.SuspendLayout();
            this.tableLayoutPanel1.AutoSize = true;
            this.tableLayoutPanel1.ColumnCount = 1;
            this.tableLayoutPanel1.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f));
            this.tableLayoutPanel1.Controls.Add(this.textBox1, 0, 0);
            this.tableLayoutPanel1.Controls.Add(this.panel2, 0, 1);
            this.tableLayoutPanel1.Dock = DockStyle.Fill;
            this.tableLayoutPanel1.Location = new Point(0, 0);
            this.tableLayoutPanel1.Name = "tableLayoutPanel1";
            this.tableLayoutPanel1.RowCount = 2;
            this.tableLayoutPanel1.RowStyles.Add(new RowStyle());
            this.tableLayoutPanel1.RowStyles.Add(new RowStyle());
            this.tableLayoutPanel1.Size = new Size(0x11c, 0x6a);
            this.tableLayoutPanel1.TabIndex = 3;
            this.textBox1.Anchor = AnchorStyles.Right | AnchorStyles.Left | AnchorStyles.Top;
            this.textBox1.BorderStyle = BorderStyle.None;
            this.textBox1.Cursor = Cursors.Default;
            this.textBox1.Location = new Point(20, 10);
            this.textBox1.Margin = new Padding(20, 10, 20, 3);
            this.textBox1.Multiline = true;
            this.textBox1.Name = "textBox1";
            this.textBox1.ReadOnly = true;
            this.textBox1.Size = new Size(0xf4, 0x41);
            this.textBox1.TabIndex = 0;
            this.textBox1.TabStop = false;
            this.panel2.AutoSize = true;
            this.panel2.Controls.Add(this.button3);
            this.panel2.Controls.Add(this.button2);
            this.panel2.Controls.Add(this.button1);
            this.panel2.Dock = DockStyle.Fill;
            this.panel2.Location = new Point(3, 0x51);
            this.panel2.Name = "panel2";
            this.panel2.Size = new Size(0x116, 0x1d);
            this.panel2.TabIndex = 0;
            this.button3.DialogResult = System.Windows.Forms.DialogResult.Cancel;
            this.button3.Location = new Point(0xb7, 3);
            this.button3.Name = "button3";
            this.button3.Size = new Size(0x4b, 0x17);
            this.button3.TabIndex = 2;
            this.button3.UseVisualStyleBackColor = true;
            this.button3.Click += new EventHandler(this.button3_Click);
            this.button2.DialogResult = System.Windows.Forms.DialogResult.No;
            this.button2.Location = new Point(0x66, 3);
            this.button2.Name = "button2";
            this.button2.Size = new Size(0x4b, 0x17);
            this.button2.TabIndex = 1;
            this.button2.UseVisualStyleBackColor = true;
            this.button2.Click += new EventHandler(this.button2_Click);
            this.button1.DialogResult = System.Windows.Forms.DialogResult.Yes;
            this.button1.Location = new Point(0x15, 3);
            this.button1.Name = "button1";
            this.button1.Size = new Size(0x4b, 0x17);
            this.button1.TabIndex = 0;
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new EventHandler(this.button1_Click);
            this.AutoSize = true;
            base.CancelButton = this.button1;
            base.ClientSize = new Size(0x11c, 0x70);
            base.Controls.Add(this.tableLayoutPanel1);
            base.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog;
            base.MaximizeBox = false;
            base.MinimizeBox = false;
            base.Name = "DlgQuestion";
            base.Padding = new Padding(0, 0, 0, 6);
            base.StartPosition = FormStartPosition.CenterParent;
            base.FormClosing += new FormClosingEventHandler(this.DlgQuestion_FormClosing);
            this.tableLayoutPanel1.ResumeLayout(false);
            this.tableLayoutPanel1.PerformLayout();
            this.panel2.ResumeLayout(false);
            base.ResumeLayout(false);
            base.PerformLayout();
        }
    }
}
