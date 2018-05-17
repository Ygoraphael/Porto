namespace Agronomia.view
{
    partial class FrmCadPropriedade
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
            this.panel3 = new System.Windows.Forms.Panel();
            this.mskEmail = new System.Windows.Forms.MaskedTextBox();
            this.pROPRIEDADEBindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.mskTelefone = new System.Windows.Forms.MaskedTextBox();
            this.txtNomeResponsavel = new System.Windows.Forms.TextBox();
            this.txtComplemento = new System.Windows.Forms.TextBox();
            this.txtEndereco = new System.Windows.Forms.TextBox();
            this.txtEstado = new System.Windows.Forms.TextBox();
            this.txtMunicipio = new System.Windows.Forms.TextBox();
            this.txtNomePropriedade = new System.Windows.Forms.TextBox();
            this.label8 = new System.Windows.Forms.Label();
            this.label7 = new System.Windows.Forms.Label();
            this.label6 = new System.Windows.Forms.Label();
            this.label5 = new System.Windows.Forms.Label();
            this.label4 = new System.Windows.Forms.Label();
            this.label3 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.label1 = new System.Windows.Forms.Label();
            this.btnCan = new System.Windows.Forms.Button();
            this.btnGrava = new System.Windows.Forms.Button();
            this.panel2 = new System.Windows.Forms.Panel();
            this.panel3.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.pROPRIEDADEBindingSource)).BeginInit();
            this.panel2.SuspendLayout();
            this.SuspendLayout();
            // 
            // panel3
            // 
            this.panel3.Controls.Add(this.mskEmail);
            this.panel3.Controls.Add(this.mskTelefone);
            this.panel3.Controls.Add(this.txtNomeResponsavel);
            this.panel3.Controls.Add(this.txtComplemento);
            this.panel3.Controls.Add(this.txtEndereco);
            this.panel3.Controls.Add(this.txtEstado);
            this.panel3.Controls.Add(this.txtMunicipio);
            this.panel3.Controls.Add(this.txtNomePropriedade);
            this.panel3.Controls.Add(this.label8);
            this.panel3.Controls.Add(this.label7);
            this.panel3.Controls.Add(this.label6);
            this.panel3.Controls.Add(this.label5);
            this.panel3.Controls.Add(this.label4);
            this.panel3.Controls.Add(this.label3);
            this.panel3.Controls.Add(this.label2);
            this.panel3.Controls.Add(this.label1);
            this.panel3.Location = new System.Drawing.Point(3, 3);
            this.panel3.Name = "panel3";
            this.panel3.Size = new System.Drawing.Size(296, 235);
            this.panel3.TabIndex = 9;
            // 
            // mskEmail
            // 
            this.mskEmail.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.pROPRIEDADEBindingSource, "EMAILP_PROP", true));
            this.mskEmail.Location = new System.Drawing.Point(131, 176);
            this.mskEmail.Name = "mskEmail";
            this.mskEmail.Size = new System.Drawing.Size(154, 20);
            this.mskEmail.TabIndex = 8;
            // 
            // pROPRIEDADEBindingSource
            // 
            this.pROPRIEDADEBindingSource.DataSource = typeof(Agronomia.PROPRIEDADE);
            // 
            // mskTelefone
            // 
            this.mskTelefone.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.pROPRIEDADEBindingSource, "TELEFO_PRO", true));
            this.mskTelefone.Location = new System.Drawing.Point(185, 150);
            this.mskTelefone.Mask = "0000-0000";
            this.mskTelefone.Name = "mskTelefone";
            this.mskTelefone.Size = new System.Drawing.Size(100, 20);
            this.mskTelefone.TabIndex = 5;
            // 
            // txtNomeResponsavel
            // 
            this.txtNomeResponsavel.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.pROPRIEDADEBindingSource, "NOMRES_PRO", true));
            this.txtNomeResponsavel.Location = new System.Drawing.Point(131, 206);
            this.txtNomeResponsavel.MaxLength = 40;
            this.txtNomeResponsavel.Name = "txtNomeResponsavel";
            this.txtNomeResponsavel.Size = new System.Drawing.Size(154, 20);
            this.txtNomeResponsavel.TabIndex = 7;
            // 
            // txtComplemento
            // 
            this.txtComplemento.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.pROPRIEDADEBindingSource, "COMPLE_PRO", true));
            this.txtComplemento.Location = new System.Drawing.Point(185, 120);
            this.txtComplemento.MaxLength = 40;
            this.txtComplemento.Name = "txtComplemento";
            this.txtComplemento.Size = new System.Drawing.Size(100, 20);
            this.txtComplemento.TabIndex = 4;
            // 
            // txtEndereco
            // 
            this.txtEndereco.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.pROPRIEDADEBindingSource, "ENDERE_PRO", true));
            this.txtEndereco.Location = new System.Drawing.Point(131, 94);
            this.txtEndereco.MaxLength = 100;
            this.txtEndereco.Name = "txtEndereco";
            this.txtEndereco.Size = new System.Drawing.Size(154, 20);
            this.txtEndereco.TabIndex = 3;
            // 
            // txtEstado
            // 
            this.txtEstado.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.pROPRIEDADEBindingSource, "ESTADO_PRO", true));
            this.txtEstado.Location = new System.Drawing.Point(185, 68);
            this.txtEstado.MaxLength = 2;
            this.txtEstado.Name = "txtEstado";
            this.txtEstado.Size = new System.Drawing.Size(100, 20);
            this.txtEstado.TabIndex = 2;
            // 
            // txtMunicipio
            // 
            this.txtMunicipio.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.pROPRIEDADEBindingSource, "MUNICI_PRO", true));
            this.txtMunicipio.Location = new System.Drawing.Point(131, 39);
            this.txtMunicipio.MaxLength = 50;
            this.txtMunicipio.Name = "txtMunicipio";
            this.txtMunicipio.Size = new System.Drawing.Size(154, 20);
            this.txtMunicipio.TabIndex = 1;
            // 
            // txtNomePropriedade
            // 
            this.txtNomePropriedade.DataBindings.Add(new System.Windows.Forms.Binding("Text", this.pROPRIEDADEBindingSource, "NOMEPR_PRO", true));
            this.txtNomePropriedade.Location = new System.Drawing.Point(131, 13);
            this.txtNomePropriedade.MaxLength = 100;
            this.txtNomePropriedade.Name = "txtNomePropriedade";
            this.txtNomePropriedade.Size = new System.Drawing.Size(154, 20);
            this.txtNomePropriedade.TabIndex = 0;
            // 
            // label8
            // 
            this.label8.AutoSize = true;
            this.label8.Location = new System.Drawing.Point(9, 209);
            this.label8.Name = "label8";
            this.label8.Size = new System.Drawing.Size(121, 13);
            this.label8.TabIndex = 7;
            this.label8.Text = "Nome do Responsável: ";
            // 
            // label7
            // 
            this.label7.AutoSize = true;
            this.label7.Location = new System.Drawing.Point(9, 179);
            this.label7.Name = "label7";
            this.label7.Size = new System.Drawing.Size(38, 13);
            this.label7.TabIndex = 6;
            this.label7.Text = "Email: ";
            // 
            // label6
            // 
            this.label6.AutoSize = true;
            this.label6.Location = new System.Drawing.Point(9, 149);
            this.label6.Name = "label6";
            this.label6.Size = new System.Drawing.Size(55, 13);
            this.label6.TabIndex = 5;
            this.label6.Text = "Telefone: ";
            // 
            // label5
            // 
            this.label5.AutoSize = true;
            this.label5.Location = new System.Drawing.Point(9, 123);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(77, 13);
            this.label5.TabIndex = 4;
            this.label5.Text = "Complemento: ";
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Location = new System.Drawing.Point(9, 97);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(59, 13);
            this.label4.TabIndex = 3;
            this.label4.Text = "Endereço: ";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(9, 71);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(46, 13);
            this.label3.TabIndex = 2;
            this.label3.Text = "Estado: ";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(9, 42);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(60, 13);
            this.label2.TabIndex = 1;
            this.label2.Text = "Município: ";
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(9, 16);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(116, 13);
            this.label1.TabIndex = 0;
            this.label1.Text = "Nome da Propriedade: ";
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(213, 3);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 9;
            this.btnCan.Text = "&Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            this.btnCan.Click += new System.EventHandler(this.btnCan_Click);
            // 
            // btnGrava
            // 
            this.btnGrava.DialogResult = System.Windows.Forms.DialogResult.OK;
            this.btnGrava.Location = new System.Drawing.Point(117, 3);
            this.btnGrava.Name = "btnGrava";
            this.btnGrava.Size = new System.Drawing.Size(75, 23);
            this.btnGrava.TabIndex = 8;
            this.btnGrava.Text = "&Gravar";
            this.btnGrava.UseVisualStyleBackColor = true;
            // 
            // panel2
            // 
            this.panel2.Controls.Add(this.btnCan);
            this.panel2.Controls.Add(this.btnGrava);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.panel2.Location = new System.Drawing.Point(0, 242);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(302, 36);
            this.panel2.TabIndex = 10;
            // 
            // FrmCadPropriedade
            // 
            this.AcceptButton = this.btnGrava;
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(302, 278);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel3);
            this.Name = "FrmCadPropriedade";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Cadastro Propriedade";
            this.FormClosing += new System.Windows.Forms.FormClosingEventHandler(this.FrmPropriedade_FormClosing);
            this.Load += new System.EventHandler(this.FrmCadPropriedade_Load);
            this.panel3.ResumeLayout(false);
            this.panel3.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.pROPRIEDADEBindingSource)).EndInit();
            this.panel2.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion
        private System.Windows.Forms.BindingSource pROPRIEDADEBindingSource;
        private System.Windows.Forms.Panel panel3;
        private System.Windows.Forms.TextBox txtNomeResponsavel;
        private System.Windows.Forms.TextBox txtComplemento;
        private System.Windows.Forms.TextBox txtEndereco;
        private System.Windows.Forms.TextBox txtEstado;
        private System.Windows.Forms.TextBox txtMunicipio;
        private System.Windows.Forms.TextBox txtNomePropriedade;
        private System.Windows.Forms.Label label8;
        private System.Windows.Forms.Label label7;
        private System.Windows.Forms.Label label6;
        private System.Windows.Forms.Label label5;
        private System.Windows.Forms.Label label4;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Button btnCan;
        private System.Windows.Forms.Button btnGrava;
        private System.Windows.Forms.Panel panel2;
        private System.Windows.Forms.MaskedTextBox mskTelefone;
        private System.Windows.Forms.MaskedTextBox mskEmail;
    }
}