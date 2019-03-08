namespace NCPonto
{
    partial class frmPicarFO
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
            this.timer1 = new System.Windows.Forms.Timer(this.components);
            this.lblTipoMov = new System.Windows.Forms.Label();
            this.panel1 = new System.Windows.Forms.Panel();
            this.lblDesTar = new System.Windows.Forms.Label();
            this.lblRefTar = new System.Windows.Forms.Label();
            this.lblFO = new System.Windows.Forms.Label();
            this.groupBox2 = new System.Windows.Forms.GroupBox();
            this.txtCartao = new System.Windows.Forms.TextBox();
            this.lblHora = new System.Windows.Forms.Label();
            this.lblNomeUtil = new System.Windows.Forms.Label();
            this.img = new System.Windows.Forms.PictureBox();
            this.cmdVoltar = new System.Windows.Forms.Button();
            this.lblTurno = new System.Windows.Forms.Label();
            this.groupBox1 = new System.Windows.Forms.GroupBox();
            this.tmrRegEntrada = new System.Windows.Forms.Timer(this.components);
            this.tmrRegSaida = new System.Windows.Forms.Timer(this.components);
            this.panel1.SuspendLayout();
            this.groupBox2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.img)).BeginInit();
            this.groupBox1.SuspendLayout();
            this.SuspendLayout();
            // 
            // timer1
            // 
            this.timer1.Interval = 1000;
            this.timer1.Tick += new System.EventHandler(this.timer1_Tick);
            // 
            // lblTipoMov
            // 
            this.lblTipoMov.Font = new System.Drawing.Font("Microsoft Sans Serif", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblTipoMov.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(128)))), ((int)(((byte)(128)))), ((int)(((byte)(255)))));
            this.lblTipoMov.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.lblTipoMov.Location = new System.Drawing.Point(6, 30);
            this.lblTipoMov.Name = "lblTipoMov";
            this.lblTipoMov.Size = new System.Drawing.Size(481, 44);
            this.lblTipoMov.TabIndex = 0;
            this.lblTipoMov.Text = "Tipo de Movimento";
            this.lblTipoMov.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            // 
            // panel1
            // 
            this.panel1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(192)))), ((int)(((byte)(192)))), ((int)(((byte)(255)))));
            this.panel1.Controls.Add(this.lblDesTar);
            this.panel1.Controls.Add(this.lblRefTar);
            this.panel1.Controls.Add(this.lblFO);
            this.panel1.Controls.Add(this.groupBox2);
            this.panel1.Controls.Add(this.img);
            this.panel1.Location = new System.Drawing.Point(0, 116);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(794, 478);
            this.panel1.TabIndex = 1;
            this.panel1.Paint += new System.Windows.Forms.PaintEventHandler(this.panel1_Paint);
            // 
            // lblDesTar
            // 
            this.lblDesTar.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblDesTar.Location = new System.Drawing.Point(12, 33);
            this.lblDesTar.Name = "lblDesTar";
            this.lblDesTar.Size = new System.Drawing.Size(296, 22);
            this.lblDesTar.TabIndex = 9;
            this.lblDesTar.Text = "0";
            // 
            // lblRefTar
            // 
            this.lblRefTar.AutoSize = true;
            this.lblRefTar.Location = new System.Drawing.Point(12, 290);
            this.lblRefTar.Name = "lblRefTar";
            this.lblRefTar.Size = new System.Drawing.Size(13, 13);
            this.lblRefTar.TabIndex = 8;
            this.lblRefTar.Text = "0";
            this.lblRefTar.Visible = false;
            // 
            // lblFO
            // 
            this.lblFO.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblFO.Location = new System.Drawing.Point(12, 17);
            this.lblFO.Name = "lblFO";
            this.lblFO.Size = new System.Drawing.Size(107, 22);
            this.lblFO.TabIndex = 7;
            this.lblFO.Text = "0";
            // 
            // groupBox2
            // 
            this.groupBox2.Controls.Add(this.txtCartao);
            this.groupBox2.Controls.Add(this.lblHora);
            this.groupBox2.Controls.Add(this.lblNomeUtil);
            this.groupBox2.Location = new System.Drawing.Point(314, 33);
            this.groupBox2.Name = "groupBox2";
            this.groupBox2.Size = new System.Drawing.Size(463, 258);
            this.groupBox2.TabIndex = 6;
            this.groupBox2.TabStop = false;
            // 
            // txtCartao
            // 
            this.txtCartao.Font = new System.Drawing.Font("Microsoft Sans Serif", 48F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.txtCartao.Location = new System.Drawing.Point(39, 81);
            this.txtCartao.Name = "txtCartao";
            this.txtCartao.PasswordChar = '|';
            this.txtCartao.Size = new System.Drawing.Size(384, 80);
            this.txtCartao.TabIndex = 2;
            this.txtCartao.TextChanged += new System.EventHandler(this.txtCartao_TextChanged);
            this.txtCartao.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.txtCartao_KeyPress);
            // 
            // lblHora
            // 
            this.lblHora.AutoSize = true;
            this.lblHora.Font = new System.Drawing.Font("Microsoft Sans Serif", 36F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblHora.Location = new System.Drawing.Point(45, 187);
            this.lblHora.Name = "lblHora";
            this.lblHora.Size = new System.Drawing.Size(0, 55);
            this.lblHora.TabIndex = 4;
            // 
            // lblNomeUtil
            // 
            this.lblNomeUtil.AutoSize = true;
            this.lblNomeUtil.Font = new System.Drawing.Font("Microsoft Sans Serif", 24F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblNomeUtil.Location = new System.Drawing.Point(32, 27);
            this.lblNomeUtil.Name = "lblNomeUtil";
            this.lblNomeUtil.Size = new System.Drawing.Size(275, 37);
            this.lblNomeUtil.TabIndex = 1;
            this.lblNomeUtil.Text = "Passe o cartão...";
            // 
            // img
            // 
            this.img.Location = new System.Drawing.Point(86, 79);
            this.img.Name = "img";
            this.img.Size = new System.Drawing.Size(193, 178);
            this.img.TabIndex = 0;
            this.img.TabStop = false;
            // 
            // cmdVoltar
            // 
            this.cmdVoltar.Font = new System.Drawing.Font("Microsoft Sans Serif", 36F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.cmdVoltar.Image = global::NCPonto.Properties.Resources.tras;
            this.cmdVoltar.ImageAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.cmdVoltar.Location = new System.Drawing.Point(15, 456);
            this.cmdVoltar.Name = "cmdVoltar";
            this.cmdVoltar.Size = new System.Drawing.Size(762, 132);
            this.cmdVoltar.TabIndex = 2;
            this.cmdVoltar.Text = "Voltar ao início";
            this.cmdVoltar.UseVisualStyleBackColor = true;
            this.cmdVoltar.Click += new System.EventHandler(this.cmdVoltar_Click);
            // 
            // lblTurno
            // 
            this.lblTurno.Font = new System.Drawing.Font("Microsoft Sans Serif", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.lblTurno.ForeColor = System.Drawing.Color.White;
            this.lblTurno.ImageAlign = System.Drawing.ContentAlignment.MiddleRight;
            this.lblTurno.Location = new System.Drawing.Point(383, 30);
            this.lblTurno.Name = "lblTurno";
            this.lblTurno.Size = new System.Drawing.Size(394, 46);
            this.lblTurno.TabIndex = 5;
            this.lblTurno.Tag = "E1";
            this.lblTurno.Text = "Turno da Manhã";
            this.lblTurno.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            this.lblTurno.Click += new System.EventHandler(this.lblTurno_Click);
            // 
            // groupBox1
            // 
            this.groupBox1.Anchor = System.Windows.Forms.AnchorStyles.None;
            this.groupBox1.BackColor = System.Drawing.Color.Transparent;
            this.groupBox1.Controls.Add(this.lblTurno);
            this.groupBox1.Controls.Add(this.cmdVoltar);
            this.groupBox1.Controls.Add(this.panel1);
            this.groupBox1.Controls.Add(this.lblTipoMov);
            this.groupBox1.Location = new System.Drawing.Point(13, 13);
            this.groupBox1.Name = "groupBox1";
            this.groupBox1.Size = new System.Drawing.Size(794, 594);
            this.groupBox1.TabIndex = 0;
            this.groupBox1.TabStop = false;
            // 
            // tmrRegEntrada
            // 
            this.tmrRegEntrada.Interval = 1000;
            this.tmrRegEntrada.Tick += new System.EventHandler(this.tmrRegEntrada_Tick);
            // 
            // tmrRegSaida
            // 
            this.tmrRegSaida.Interval = 1000;
            this.tmrRegSaida.Tick += new System.EventHandler(this.tmrRegSaida_Tick);
            // 
            // frmPicarFO
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.Black;
            this.ClientSize = new System.Drawing.Size(819, 619);
            this.ControlBox = false;
            this.Controls.Add(this.groupBox1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedToolWindow;
            this.MaximizeBox = false;
            this.MinimizeBox = false;
            this.Name = "frmPicarFO";
            this.ShowIcon = false;
            this.ShowInTaskbar = false;
            this.StartPosition = System.Windows.Forms.FormStartPosition.Manual;
            this.WindowState = System.Windows.Forms.FormWindowState.Maximized;
            this.Load += new System.EventHandler(this.frmPicarFO_Load);
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            this.groupBox2.ResumeLayout(false);
            this.groupBox2.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.img)).EndInit();
            this.groupBox1.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Timer timer1;
        private System.Windows.Forms.Label lblTipoMov;
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.GroupBox groupBox2;
        private System.Windows.Forms.TextBox txtCartao;
        private System.Windows.Forms.Label lblHora;
        private System.Windows.Forms.Label lblNomeUtil;
        private System.Windows.Forms.PictureBox img;
        private System.Windows.Forms.Button cmdVoltar;
        private System.Windows.Forms.Label lblTurno;
        private System.Windows.Forms.GroupBox groupBox1;
        private System.Windows.Forms.Timer tmrRegEntrada;
        private System.Windows.Forms.Timer tmrRegSaida;
        private System.Windows.Forms.Label lblRefTar;
        private System.Windows.Forms.Label lblFO;
        private System.Windows.Forms.Label lblDesTar;
    }
}