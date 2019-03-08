﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.ComponentModel;
using System.Drawing;

namespace NCDataOnline
{
    public class DlgInput : Form
    {
        // Fields
        private Button button1;
        private Button button2;
        private IContainer components;
        public string inputText;
        private Panel panel2;
        private TableLayoutPanel tableLayoutPanel1;
        private TableLayoutPanel tableLayoutPanel2;
        private TextBox textBox1;
        private TextBox textBox2;

        // Methods
        public DlgInput()
        {
            this.inputText = string.Empty;
            this.components = null;
            this.InitializeComponent();
        }

        public DlgInput(string text, string title = "", string btnOK = "OK", string btnCancel = "Cancel", string defaultInput = "", bool passwordChars = false)
        {
            this.inputText = string.Empty;
            this.components = null;
            this.InitializeComponent();
            this.textBox1.Text = text;
            this.Text = title;
            this.button1.Text = btnOK;
            this.button2.Text = btnCancel;
            this.textBox2.Text = defaultInput;
            this.textBox2.UseSystemPasswordChar = passwordChars;
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

        protected override void Dispose(bool disposing)
        {
            if (disposing && (this.components != null))
            {
                this.components.Dispose();
            }
            base.Dispose(disposing);
        }

        private void DlgInput_FormClosing(object sender, FormClosingEventArgs e)
        {
            this.inputText = this.textBox2.Text;
        }

        private void DlgInput_Load(object sender, EventArgs e)
        {
            base.ActiveControl = this.textBox2;
        }

        private void InitializeComponent()
        {
            this.panel2 = new Panel();
            this.button2 = new Button();
            this.button1 = new Button();
            this.tableLayoutPanel1 = new TableLayoutPanel();
            this.tableLayoutPanel2 = new TableLayoutPanel();
            this.textBox1 = new TextBox();
            this.textBox2 = new TextBox();
            this.panel2.SuspendLayout();
            this.tableLayoutPanel1.SuspendLayout();
            this.tableLayoutPanel2.SuspendLayout();
            base.SuspendLayout();
            this.panel2.AutoSize = true;
            this.panel2.Controls.Add(this.button2);
            this.panel2.Controls.Add(this.button1);
            this.panel2.Dock = DockStyle.Fill;
            this.panel2.Location = new Point(3, 0x4c);
            this.panel2.Name = "panel2";
            this.panel2.Size = new Size(0x116, 0x1d);
            this.panel2.TabIndex = 0;
            this.button2.DialogResult = System.Windows.Forms.DialogResult.Cancel;
            this.button2.Location = new Point(0x8e, 3);
            this.button2.Name = "button2";
            this.button2.Size = new Size(0x4b, 0x17);
            this.button2.TabIndex = 2;
            this.button2.UseVisualStyleBackColor = true;
            this.button1.DialogResult = System.Windows.Forms.DialogResult.OK;
            this.button1.Location = new Point(0x3d, 3);
            this.button1.Name = "button1";
            this.button1.Size = new Size(0x4b, 0x17);
            this.button1.TabIndex = 1;
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new EventHandler(this.button1_Click);
            this.tableLayoutPanel1.AutoSize = true;
            this.tableLayoutPanel1.ColumnCount = 1;
            this.tableLayoutPanel1.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f));
            this.tableLayoutPanel1.Controls.Add(this.panel2, 0, 1);
            this.tableLayoutPanel1.Controls.Add(this.tableLayoutPanel2, 0, 0);
            this.tableLayoutPanel1.Dock = DockStyle.Fill;
            this.tableLayoutPanel1.Location = new Point(0, 0);
            this.tableLayoutPanel1.Name = "tableLayoutPanel1";
            this.tableLayoutPanel1.RowCount = 2;
            this.tableLayoutPanel1.RowStyles.Add(new RowStyle());
            this.tableLayoutPanel1.RowStyles.Add(new RowStyle());
            this.tableLayoutPanel1.Size = new Size(0x11c, 0x6a);
            this.tableLayoutPanel1.TabIndex = 3;
            this.tableLayoutPanel2.AutoSize = true;
            this.tableLayoutPanel2.ColumnCount = 1;
            this.tableLayoutPanel2.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f));
            this.tableLayoutPanel2.Controls.Add(this.textBox1, 0, 0);
            this.tableLayoutPanel2.Controls.Add(this.textBox2, 0, 1);
            this.tableLayoutPanel2.Dock = DockStyle.Fill;
            this.tableLayoutPanel2.Location = new Point(3, 3);
            this.tableLayoutPanel2.Name = "tableLayoutPanel2";
            this.tableLayoutPanel2.RowCount = 2;
            this.tableLayoutPanel2.RowStyles.Add(new RowStyle());
            this.tableLayoutPanel2.RowStyles.Add(new RowStyle());
            this.tableLayoutPanel2.Size = new Size(0x116, 0x43);
            this.tableLayoutPanel2.TabIndex = 1;
            this.textBox1.Anchor = AnchorStyles.Right | AnchorStyles.Left | AnchorStyles.Top;
            this.textBox1.BorderStyle = BorderStyle.None;
            this.textBox1.Cursor = Cursors.Default;
            this.textBox1.Location = new Point(20, 10);
            this.textBox1.Margin = new Padding(20, 10, 20, 3);
            this.textBox1.Multiline = true;
            this.textBox1.Name = "textBox1";
            this.textBox1.ReadOnly = true;
            this.textBox1.Size = new Size(0xee, 0x1c);
            this.textBox1.TabIndex = 1;
            this.textBox1.TabStop = false;
            this.textBox2.Location = new Point(20, 0x2c);
            this.textBox2.Margin = new Padding(20, 3, 20, 3);
            this.textBox2.Name = "textBox2";
            this.textBox2.Size = new Size(0xee, 20);
            this.textBox2.TabIndex = 0;
            base.AcceptButton = this.button1;
            this.AutoSize = true;
            base.CancelButton = this.button1;
            base.ClientSize = new Size(0x11c, 0x70);
            base.Controls.Add(this.tableLayoutPanel1);
            base.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog;
            base.MaximizeBox = false;
            base.MinimizeBox = false;
            base.Name = "DlgInput";
            base.Padding = new Padding(0, 0, 0, 6);
            base.StartPosition = FormStartPosition.CenterParent;
            base.FormClosing += new FormClosingEventHandler(this.DlgInput_FormClosing);
            base.Load += new EventHandler(this.DlgInput_Load);
            this.panel2.ResumeLayout(false);
            this.tableLayoutPanel1.ResumeLayout(false);
            this.tableLayoutPanel1.PerformLayout();
            this.tableLayoutPanel2.ResumeLayout(false);
            this.tableLayoutPanel2.PerformLayout();
            base.ResumeLayout(false);
            base.PerformLayout();
        }
    }


}
