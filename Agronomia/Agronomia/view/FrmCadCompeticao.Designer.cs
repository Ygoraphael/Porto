namespace Agronomia.view
{
    partial class FrmCadCompeticao
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.components = new System.ComponentModel.Container();
            this.panel1 = new System.Windows.Forms.Panel();
            this.textBox1 = new System.Windows.Forms.TextBox();
            this.cOMPETICAOBindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.label2 = new System.Windows.Forms.Label();
            this.cbbCultura = new System.Windows.Forms.ComboBox();
            this.label1 = new System.Windows.Forms.Label();
            this.panel2 = new System.Windows.Forms.Panel();
            this.btnCan = new System.Windows.Forms.Button();
            this.btnGrava = new System.Windows.Forms.Button();
            this.panel1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.cOMPETICAOBindingSource)).BeginInit();
            this.panel2.SuspendLayout();
            this.SuspendLayout();
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.textBox1);
            this.panel1.Controls.Add(this.label2);
            this.panel1.Controls.Add(this.cbbCultura);
            this.panel1.Controls.Add(this.label1);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel1.Location = new System.Drawing.Point(20, 60);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(491, 192);
            this.panel1.TabIndex = 0;
            // 
            // textBox1
            // 
            this.textBox1.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cOMPETICAOBindingSource, "NOMECO_COM", true));
            this.textBox1.Location = new System.Drawing.Point(181, 25);
            this.textBox1.MaxLength = 60;
            this.textBox1.Name = "textBox1";
            this.textBox1.Size = new System.Drawing.Size(157, 20);
            this.textBox1.TabIndex = 3;
            // 
            // cOMPETICAOBindingSource
            // 
            this.cOMPETICAOBindingSource.DataSource = typeof(Agronomia.COMPETICAO);
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(178, 9);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(109, 13);
            this.label2.TabIndex = 2;
            this.label2.Text = "Nome da Competição";
            // 
            // cbbCultura
            // 
            this.cbbCultura.DataBindings.Add(new System.Windows.Forms.Binding("SelectedValue", this.cOMPETICAOBindingSource, "CODI_CUL", true));
            this.cbbCultura.FormattingEnabled = true;
            this.cbbCultura.Location = new System.Drawing.Point(15, 25);
            this.cbbCultura.Name = "cbbCultura";
            this.cbbCultura.Size = new System.Drawing.Size(157, 21);
            this.cbbCultura.TabIndex = 1;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(12, 9);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(40, 13);
            this.label1.TabIndex = 0;
            this.label1.Text = "Cultura";
            // 
            // panel2
            // 
            this.panel2.Controls.Add(this.btnCan);
            this.panel2.Controls.Add(this.btnGrava);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.panel2.Location = new System.Drawing.Point(20, 259);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(491, 35);
            this.panel2.TabIndex = 1;
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(260, 3);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 8;
            this.btnCan.Text = "&Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            this.btnCan.Click += new System.EventHandler(this.btnCan_Click);
            // 
            // btnGrava
            // 
            this.btnGrava.DialogResult = System.Windows.Forms.DialogResult.OK;
            this.btnGrava.Location = new System.Drawing.Point(172, 3);
            this.btnGrava.Name = "btnGrava";
            this.btnGrava.Size = new System.Drawing.Size(75, 23);
            this.btnGrava.TabIndex = 7;
            this.btnGrava.Text = "&Gravar";
            this.btnGrava.UseVisualStyleBackColor = true;
            // 
            // FrmCadCompeticao
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(531, 314);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel1);
            this.Name = "FrmCadCompeticao";
            this.Text = "Cadastro Competicao";
            this.FormClosing += new System.Windows.Forms.FormClosingEventHandler(this.FrmCadCompeticao_FormClosing);
            this.Load += new System.EventHandler(this.FrmCadCompeticao_Load);
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.cOMPETICAOBindingSource)).EndInit();
            this.panel2.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.TextBox textBox1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.ComboBox cbbCultura;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Panel panel2;
        private System.Windows.Forms.Button btnCan;
        private System.Windows.Forms.Button btnGrava;
        private System.Windows.Forms.BindingSource cOMPETICAOBindingSource;
    }
}