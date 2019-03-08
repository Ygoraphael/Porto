namespace NCPonto
{
    partial class _frmConfig
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
            this.cmdLigarSql = new System.Windows.Forms.Button();
            this.txtServidor = new System.Windows.Forms.TextBox();
            this.ServPHC = new System.Windows.Forms.Label();
            this.GroupBox5 = new System.Windows.Forms.GroupBox();
            this.GroupBox5.SuspendLayout();
            this.SuspendLayout();
            // 
            // cmdLigarSql
            // 
            this.cmdLigarSql.Location = new System.Drawing.Point(693, 110);
            this.cmdLigarSql.Name = "cmdLigarSql";
            this.cmdLigarSql.Size = new System.Drawing.Size(99, 43);
            this.cmdLigarSql.TabIndex = 4;
            this.cmdLigarSql.Text = "Testar";
            this.cmdLigarSql.UseVisualStyleBackColor = true;
            this.cmdLigarSql.Click += new System.EventHandler(this.cmdLigarSql_Click);
            // 
            // txtServidor
            // 
            this.txtServidor.Location = new System.Drawing.Point(19, 32);
            this.txtServidor.Name = "txtServidor";
            this.txtServidor.Size = new System.Drawing.Size(734, 20);
            this.txtServidor.TabIndex = 0;
            // 
            // ServPHC
            // 
            this.ServPHC.AutoSize = true;
            this.ServPHC.Location = new System.Drawing.Point(16, 16);
            this.ServPHC.Name = "ServPHC";
            this.ServPHC.Size = new System.Drawing.Size(91, 13);
            this.ServPHC.TabIndex = 3;
            this.ServPHC.Text = "ConnectionString ";
            // 
            // GroupBox5
            // 
            this.GroupBox5.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.GroupBox5.Controls.Add(this.ServPHC);
            this.GroupBox5.Controls.Add(this.txtServidor);
            this.GroupBox5.Location = new System.Drawing.Point(12, 12);
            this.GroupBox5.Name = "GroupBox5";
            this.GroupBox5.Size = new System.Drawing.Size(769, 79);
            this.GroupBox5.TabIndex = 1;
            this.GroupBox5.TabStop = false;
            // 
            // _frmConfig
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(804, 176);
            this.Controls.Add(this.GroupBox5);
            this.Controls.Add(this.cmdLigarSql);
            this.Name = "_frmConfig";
            this.Text = "Configurar Ligação SQL";
            this.Load += new System.EventHandler(this._frmConfig_Load);
            this.GroupBox5.ResumeLayout(false);
            this.GroupBox5.PerformLayout();
            this.ResumeLayout(false);

        }

        #endregion

        internal System.Windows.Forms.Button cmdLigarSql;
        internal System.Windows.Forms.TextBox txtServidor;
        internal System.Windows.Forms.Label ServPHC;
        internal System.Windows.Forms.GroupBox GroupBox5;
    }
}