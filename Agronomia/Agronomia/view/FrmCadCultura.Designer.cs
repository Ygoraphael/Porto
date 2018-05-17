namespace Agronomia.view
{
    partial class FrmCadCultura
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
            System.Windows.Forms.Label oBSERV_CULLabel;
            this.Cultura = new System.Windows.Forms.GroupBox();
            this.cULTIV_CULTextBox = new System.Windows.Forms.TextBox();
            this.cULTURABindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.gERMIN_CULTextBox = new System.Windows.Forms.TextBox();
            this.lOTECU_CULTextBox = new System.Windows.Forms.TextBox();
            this.m100SE_CULTextBox = new System.Windows.Forms.TextBox();
            this.txtNomeCultura = new System.Windows.Forms.TextBox();
            this.oBSERV_CULTextBox = new System.Windows.Forms.TextBox();
            this.pROSEM_CULTextBox = new System.Windows.Forms.TextBox();
            this.pUREZA_CULTextBox = new System.Windows.Forms.TextBox();
            this.sAFRAC_CULTextBox = new System.Windows.Forms.TextBox();
            this.tRAQUI_CULTextBox = new System.Windows.Forms.TextBox();
            this.vALIDA_CULDateTimePicker = new System.Windows.Forms.DateTimePicker();
            this.btnCan = new System.Windows.Forms.Button();
            this.btnGrava = new System.Windows.Forms.Button();
            this.label10 = new System.Windows.Forms.Label();
            this.label9 = new System.Windows.Forms.Label();
            this.label8 = new System.Windows.Forms.Label();
            this.label7 = new System.Windows.Forms.Label();
            this.label6 = new System.Windows.Forms.Label();
            this.label5 = new System.Windows.Forms.Label();
            this.label4 = new System.Windows.Forms.Label();
            this.label3 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.label1 = new System.Windows.Forms.Label();
            oBSERV_CULLabel = new System.Windows.Forms.Label();
            this.Cultura.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.cULTURABindingSource)).BeginInit();
            this.SuspendLayout();
            // 
            // oBSERV_CULLabel
            // 
            oBSERV_CULLabel.AutoSize = true;
            oBSERV_CULLabel.Location = new System.Drawing.Point(21, 148);
            oBSERV_CULLabel.Name = "oBSERV_CULLabel";
            oBSERV_CULLabel.Size = new System.Drawing.Size(83, 13);
            oBSERV_CULLabel.TabIndex = 46;
            oBSERV_CULLabel.Text = "OBSERVAÇÃO:";
            // 
            // Cultura
            // 
            this.Cultura.Controls.Add(this.cULTIV_CULTextBox);
            this.Cultura.Controls.Add(this.gERMIN_CULTextBox);
            this.Cultura.Controls.Add(this.lOTECU_CULTextBox);
            this.Cultura.Controls.Add(this.m100SE_CULTextBox);
            this.Cultura.Controls.Add(this.txtNomeCultura);
            this.Cultura.Controls.Add(oBSERV_CULLabel);
            this.Cultura.Controls.Add(this.oBSERV_CULTextBox);
            this.Cultura.Controls.Add(this.pROSEM_CULTextBox);
            this.Cultura.Controls.Add(this.pUREZA_CULTextBox);
            this.Cultura.Controls.Add(this.sAFRAC_CULTextBox);
            this.Cultura.Controls.Add(this.tRAQUI_CULTextBox);
            this.Cultura.Controls.Add(this.vALIDA_CULDateTimePicker);
            this.Cultura.Controls.Add(this.btnCan);
            this.Cultura.Controls.Add(this.btnGrava);
            this.Cultura.Controls.Add(this.label10);
            this.Cultura.Controls.Add(this.label9);
            this.Cultura.Controls.Add(this.label8);
            this.Cultura.Controls.Add(this.label7);
            this.Cultura.Controls.Add(this.label6);
            this.Cultura.Controls.Add(this.label5);
            this.Cultura.Controls.Add(this.label4);
            this.Cultura.Controls.Add(this.label3);
            this.Cultura.Controls.Add(this.label2);
            this.Cultura.Controls.Add(this.label1);
            this.Cultura.Dock = System.Windows.Forms.DockStyle.Fill;
            this.Cultura.Location = new System.Drawing.Point(0, 0);
            this.Cultura.Name = "Cultura";
            this.Cultura.Size = new System.Drawing.Size(393, 334);
            this.Cultura.TabIndex = 11;
            this.Cultura.TabStop = false;
            this.Cultura.Text = "Cultura";
            // 
            // cULTIV_CULTextBox
            // 
            this.cULTIV_CULTextBox.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cULTURABindingSource, "CULTIV_CUL", true));
            this.cULTIV_CULTextBox.Location = new System.Drawing.Point(186, 121);
            this.cULTIV_CULTextBox.MaxLength = 30;
            this.cULTIV_CULTextBox.Name = "cULTIV_CULTextBox";
            this.cULTIV_CULTextBox.Size = new System.Drawing.Size(200, 20);
            this.cULTIV_CULTextBox.TabIndex = 4;
            // 
            // cULTURABindingSource
            // 
            this.cULTURABindingSource.DataSource = typeof(Agronomia.CULTURA);
            // 
            // gERMIN_CULTextBox
            // 
            this.gERMIN_CULTextBox.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cULTURABindingSource, "GERMIN_CUL", true));
            this.gERMIN_CULTextBox.Location = new System.Drawing.Point(186, 41);
            this.gERMIN_CULTextBox.MaxLength = 4;
            this.gERMIN_CULTextBox.Name = "gERMIN_CULTextBox";
            this.gERMIN_CULTextBox.Size = new System.Drawing.Size(200, 20);
            this.gERMIN_CULTextBox.TabIndex = 1;
            // 
            // lOTECU_CULTextBox
            // 
            this.lOTECU_CULTextBox.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cULTURABindingSource, "LOTECU_CUL", true));
            this.lOTECU_CULTextBox.Location = new System.Drawing.Point(186, 67);
            this.lOTECU_CULTextBox.MaxLength = 60;
            this.lOTECU_CULTextBox.Name = "lOTECU_CULTextBox";
            this.lOTECU_CULTextBox.Size = new System.Drawing.Size(200, 20);
            this.lOTECU_CULTextBox.TabIndex = 2;
            // 
            // m100SE_CULTextBox
            // 
            this.m100SE_CULTextBox.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cULTURABindingSource, "M100SE_CUL", true));
            this.m100SE_CULTextBox.Location = new System.Drawing.Point(186, 93);
            this.m100SE_CULTextBox.MaxLength = 7;
            this.m100SE_CULTextBox.Name = "m100SE_CULTextBox";
            this.m100SE_CULTextBox.Size = new System.Drawing.Size(200, 20);
            this.m100SE_CULTextBox.TabIndex = 3;
            // 
            // txtNomeCultura
            // 
            this.txtNomeCultura.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cULTURABindingSource, "NOMCUL_CUL", true));
            this.txtNomeCultura.Location = new System.Drawing.Point(186, 13);
            this.txtNomeCultura.MaxLength = 60;
            this.txtNomeCultura.Name = "txtNomeCultura";
            this.txtNomeCultura.Size = new System.Drawing.Size(200, 20);
            this.txtNomeCultura.TabIndex = 0;
            // 
            // oBSERV_CULTextBox
            // 
            this.oBSERV_CULTextBox.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cULTURABindingSource, "OBSERV_CUL", true));
            this.oBSERV_CULTextBox.Location = new System.Drawing.Point(186, 145);
            this.oBSERV_CULTextBox.MaxLength = 250;
            this.oBSERV_CULTextBox.Name = "oBSERV_CULTextBox";
            this.oBSERV_CULTextBox.Size = new System.Drawing.Size(200, 20);
            this.oBSERV_CULTextBox.TabIndex = 5;
            // 
            // pROSEM_CULTextBox
            // 
            this.pROSEM_CULTextBox.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cULTURABindingSource, "PROSEM_CUL", true));
            this.pROSEM_CULTextBox.Location = new System.Drawing.Point(186, 171);
            this.pROSEM_CULTextBox.MaxLength = 60;
            this.pROSEM_CULTextBox.Name = "pROSEM_CULTextBox";
            this.pROSEM_CULTextBox.Size = new System.Drawing.Size(200, 20);
            this.pROSEM_CULTextBox.TabIndex = 6;
            // 
            // pUREZA_CULTextBox
            // 
            this.pUREZA_CULTextBox.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cULTURABindingSource, "PUREZA_CUL", true));
            this.pUREZA_CULTextBox.Location = new System.Drawing.Point(186, 197);
            this.pUREZA_CULTextBox.MaxLength = 4;
            this.pUREZA_CULTextBox.Name = "pUREZA_CULTextBox";
            this.pUREZA_CULTextBox.Size = new System.Drawing.Size(200, 20);
            this.pUREZA_CULTextBox.TabIndex = 7;
            // 
            // sAFRAC_CULTextBox
            // 
            this.sAFRAC_CULTextBox.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cULTURABindingSource, "SAFRAC_CUL", true));
            this.sAFRAC_CULTextBox.Location = new System.Drawing.Point(186, 223);
            this.sAFRAC_CULTextBox.MaxLength = 9;
            this.sAFRAC_CULTextBox.Name = "sAFRAC_CULTextBox";
            this.sAFRAC_CULTextBox.Size = new System.Drawing.Size(200, 20);
            this.sAFRAC_CULTextBox.TabIndex = 8;
            // 
            // tRAQUI_CULTextBox
            // 
            this.tRAQUI_CULTextBox.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.cULTURABindingSource, "TRAQUI_CUL", true));
            this.tRAQUI_CULTextBox.Location = new System.Drawing.Point(186, 249);
            this.tRAQUI_CULTextBox.MaxLength = 100;
            this.tRAQUI_CULTextBox.Name = "tRAQUI_CULTextBox";
            this.tRAQUI_CULTextBox.Size = new System.Drawing.Size(200, 20);
            this.tRAQUI_CULTextBox.TabIndex = 10;
            // 
            // vALIDA_CULDateTimePicker
            // 
            this.vALIDA_CULDateTimePicker.DataBindings.Add(new System.Windows.Forms.Binding("Value", this.cULTURABindingSource, "VALIDA_CUL", true));
            this.vALIDA_CULDateTimePicker.Location = new System.Drawing.Point(186, 275);
            this.vALIDA_CULDateTimePicker.Name = "vALIDA_CULDateTimePicker";
            this.vALIDA_CULDateTimePicker.Size = new System.Drawing.Size(200, 20);
            this.vALIDA_CULDateTimePicker.TabIndex = 11;
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(302, 301);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 12;
            this.btnCan.Text = "&Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            this.btnCan.Click += new System.EventHandler(this.btnCan_Click);
            // 
            // btnGrava
            // 
            this.btnGrava.DialogResult = System.Windows.Forms.DialogResult.OK;
            this.btnGrava.Location = new System.Drawing.Point(195, 301);
            this.btnGrava.Name = "btnGrava";
            this.btnGrava.Size = new System.Drawing.Size(75, 23);
            this.btnGrava.TabIndex = 12;
            this.btnGrava.Text = "&Gravar";
            this.btnGrava.UseVisualStyleBackColor = true;
            // 
            // label10
            // 
            this.label10.AutoSize = true;
            this.label10.Location = new System.Drawing.Point(21, 174);
            this.label10.Name = "label10";
            this.label10.Size = new System.Drawing.Size(72, 13);
            this.label10.TabIndex = 19;
            this.label10.Text = "PRODUZIDO";
            // 
            // label9
            // 
            this.label9.AutoSize = true;
            this.label9.Location = new System.Drawing.Point(21, 252);
            this.label9.Name = "label9";
            this.label9.Size = new System.Drawing.Size(131, 13);
            this.label9.TabIndex = 18;
            this.label9.Text = "TRATAMENTO QUÍMICO";
            // 
            // label8
            // 
            this.label8.AutoSize = true;
            this.label8.Location = new System.Drawing.Point(21, 96);
            this.label8.Name = "label8";
            this.label8.Size = new System.Drawing.Size(145, 13);
            this.label8.TabIndex = 17;
            this.label8.Text = "MASSA DE 100 SEMENTES";
            // 
            // label7
            // 
            this.label7.AutoSize = true;
            this.label7.Location = new System.Drawing.Point(21, 226);
            this.label7.Name = "label7";
            this.label7.Size = new System.Drawing.Size(42, 13);
            this.label7.TabIndex = 16;
            this.label7.Text = "SAFRA";
            // 
            // label6
            // 
            this.label6.AutoSize = true;
            this.label6.Location = new System.Drawing.Point(21, 282);
            this.label6.Name = "label6";
            this.label6.Size = new System.Drawing.Size(133, 13);
            this.label6.TabIndex = 15;
            this.label6.Text = "VALIDADE DA SEMENTE";
            // 
            // label5
            // 
            this.label5.AutoSize = true;
            this.label5.Location = new System.Drawing.Point(21, 200);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(51, 13);
            this.label5.TabIndex = 14;
            this.label5.Text = "PUREZA";
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Location = new System.Drawing.Point(21, 44);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(152, 13);
            this.label4.TabIndex = 13;
            this.label4.Text = "GERMINAÇÃO DA SEMENTE";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(21, 70);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(89, 13);
            this.label3.TabIndex = 12;
            this.label3.Text = "LOTE CULTURA";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(21, 124);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(60, 13);
            this.label2.TabIndex = 11;
            this.label2.Text = "CULTIVAR";
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(21, 16);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(93, 13);
            this.label1.TabIndex = 10;
            this.label1.Text = "NOME CULTURA";
            // 
            // FrmCadCultura
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(393, 334);
            this.Controls.Add(this.Cultura);
            this.Name = "FrmCadCultura";
            this.Text = "Cadastro Cultura";
            this.FormClosing += new System.Windows.Forms.FormClosingEventHandler(this.FrmCadCultura_FormClosing);
            this.Load += new System.EventHandler(this.FrmCadCultura_Load);
            this.Cultura.ResumeLayout(false);
            this.Cultura.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.cULTURABindingSource)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.GroupBox Cultura;
        private System.Windows.Forms.Button btnCan;
        private System.Windows.Forms.Button btnGrava;
        private System.Windows.Forms.Label label10;
        private System.Windows.Forms.Label label9;
        private System.Windows.Forms.Label label8;
        private System.Windows.Forms.Label label7;
        private System.Windows.Forms.Label label6;
        private System.Windows.Forms.Label label5;
        private System.Windows.Forms.Label label4;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.TextBox cULTIV_CULTextBox;
        private System.Windows.Forms.BindingSource cULTURABindingSource;
        private System.Windows.Forms.TextBox gERMIN_CULTextBox;
        private System.Windows.Forms.TextBox lOTECU_CULTextBox;
        private System.Windows.Forms.TextBox m100SE_CULTextBox;
        private System.Windows.Forms.TextBox txtNomeCultura;
        private System.Windows.Forms.TextBox oBSERV_CULTextBox;
        private System.Windows.Forms.TextBox pROSEM_CULTextBox;
        private System.Windows.Forms.TextBox pUREZA_CULTextBox;
        private System.Windows.Forms.TextBox sAFRAC_CULTextBox;
        private System.Windows.Forms.TextBox tRAQUI_CULTextBox;
        private System.Windows.Forms.DateTimePicker vALIDA_CULDateTimePicker;
    }
}