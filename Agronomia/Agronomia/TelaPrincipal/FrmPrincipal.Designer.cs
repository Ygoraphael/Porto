namespace Agronomia
{
    partial class FrmPrincipal
    {
        /// <summary>
        /// Variável de designer necessária.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Limpar os recursos que estão sendo usados.
        /// </summary>
        /// <param name="disposing">true se for necessário descartar os recursos gerenciados; caso contrário, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Código gerado pelo Windows Form Designer

        /// <summary>
        /// Método necessário para suporte ao Designer - não modifique 
        /// o conteúdo deste método com o editor de código.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FrmPrincipal));
            this.panel1 = new System.Windows.Forms.Panel();
            this.TFerramentas = new MetroFramework.Controls.MetroTile();
            this.TAnalise = new MetroFramework.Controls.MetroTile();
            this.TRelatorio = new MetroFramework.Controls.MetroTile();
            this.TGerminacao = new MetroFramework.Controls.MetroTile();
            this.TExperimento = new MetroFramework.Controls.MetroTile();
            this.TCadastros = new MetroFramework.Controls.MetroTile();
            this.TSair = new MetroFramework.Controls.MetroTile();
            this.TAjuda = new MetroFramework.Controls.MetroTile();
            this.TQr = new MetroFramework.Controls.MetroTile();
            this.pictureBox1 = new System.Windows.Forms.PictureBox();
            this.label1 = new System.Windows.Forms.Label();
            this.panel1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).BeginInit();
            this.SuspendLayout();
            // 
            // panel1
            // 
            this.panel1.AutoSize = true;
            this.panel1.Controls.Add(this.label1);
            this.panel1.Controls.Add(this.pictureBox1);
            this.panel1.Controls.Add(this.TSair);
            this.panel1.Controls.Add(this.TAjuda);
            this.panel1.Controls.Add(this.TQr);
            this.panel1.Controls.Add(this.TFerramentas);
            this.panel1.Controls.Add(this.TAnalise);
            this.panel1.Controls.Add(this.TRelatorio);
            this.panel1.Controls.Add(this.TGerminacao);
            this.panel1.Controls.Add(this.TExperimento);
            this.panel1.Controls.Add(this.TCadastros);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel1.Location = new System.Drawing.Point(20, 60);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(877, 596);
            this.panel1.TabIndex = 2;
            this.panel1.Paint += new System.Windows.Forms.PaintEventHandler(this.panel1_Paint);
            // 
            // TFerramentas
            // 
            this.TFerramentas.CustomBackground = true;
            this.TFerramentas.CustomForeColor = true;
            this.TFerramentas.Location = new System.Drawing.Point(17, 337);
            this.TFerramentas.Name = "TFerramentas";
            this.TFerramentas.Size = new System.Drawing.Size(164, 62);
            this.TFerramentas.TabIndex = 16;
            this.TFerramentas.Text = "Ferramentas";
            this.TFerramentas.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.TFerramentas.TileImage = ((System.Drawing.Image)(resources.GetObject("TFerramentas.TileImage")));
            this.TFerramentas.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.TFerramentas.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.TFerramentas.UseTileImage = true;
            // 
            // TAnalise
            // 
            this.TAnalise.CustomBackground = true;
            this.TAnalise.CustomForeColor = true;
            this.TAnalise.Location = new System.Drawing.Point(17, 267);
            this.TAnalise.Name = "TAnalise";
            this.TAnalise.Size = new System.Drawing.Size(191, 62);
            this.TAnalise.TabIndex = 17;
            this.TAnalise.Text = "Análise de Solo";
            this.TAnalise.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.TAnalise.TileImage = ((System.Drawing.Image)(resources.GetObject("TAnalise.TileImage")));
            this.TAnalise.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.TAnalise.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.TAnalise.UseTileImage = true;
            // 
            // TRelatorio
            // 
            this.TRelatorio.CustomBackground = true;
            this.TRelatorio.CustomForeColor = true;
            this.TRelatorio.Location = new System.Drawing.Point(17, 207);
            this.TRelatorio.Name = "TRelatorio";
            this.TRelatorio.Size = new System.Drawing.Size(151, 60);
            this.TRelatorio.TabIndex = 18;
            this.TRelatorio.Text = "Relatórios";
            this.TRelatorio.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.TRelatorio.TileImage = ((System.Drawing.Image)(resources.GetObject("TRelatorio.TileImage")));
            this.TRelatorio.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.TRelatorio.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.TRelatorio.UseTileImage = true;
            // 
            // TGerminacao
            // 
            this.TGerminacao.BackColor = System.Drawing.Color.White;
            this.TGerminacao.CustomBackground = true;
            this.TGerminacao.CustomForeColor = true;
            this.TGerminacao.ForeColor = System.Drawing.SystemColors.ControlText;
            this.TGerminacao.Location = new System.Drawing.Point(17, 139);
            this.TGerminacao.Name = "TGerminacao";
            this.TGerminacao.Size = new System.Drawing.Size(164, 66);
            this.TGerminacao.TabIndex = 19;
            this.TGerminacao.Text = "Germinação";
            this.TGerminacao.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.TGerminacao.TileImage = ((System.Drawing.Image)(resources.GetObject("TGerminacao.TileImage")));
            this.TGerminacao.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.TGerminacao.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.TGerminacao.UseTileImage = true;
            this.TGerminacao.Click += new System.EventHandler(this.TGerminacao_Click);
            // 
            // TExperimento
            // 
            this.TExperimento.CustomBackground = true;
            this.TExperimento.CustomForeColor = true;
            this.TExperimento.Location = new System.Drawing.Point(17, 77);
            this.TExperimento.Name = "TExperimento";
            this.TExperimento.Size = new System.Drawing.Size(164, 61);
            this.TExperimento.TabIndex = 20;
            this.TExperimento.Text = "Experimento";
            this.TExperimento.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.TExperimento.TileImage = ((System.Drawing.Image)(resources.GetObject("TExperimento.TileImage")));
            this.TExperimento.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.TExperimento.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.TExperimento.UseTileImage = true;
            this.TExperimento.Click += new System.EventHandler(this.TExperimento_Click);
            // 
            // TCadastros
            // 
            this.TCadastros.CustomBackground = true;
            this.TCadastros.CustomForeColor = true;
            this.TCadastros.Location = new System.Drawing.Point(17, 5);
            this.TCadastros.Name = "TCadastros";
            this.TCadastros.Size = new System.Drawing.Size(151, 65);
            this.TCadastros.TabIndex = 21;
            this.TCadastros.Text = "Cadastros";
            this.TCadastros.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.TCadastros.TileImage = ((System.Drawing.Image)(resources.GetObject("TCadastros.TileImage")));
            this.TCadastros.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.TCadastros.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.TCadastros.UseTileImage = true;
            this.TCadastros.Click += new System.EventHandler(this.TCadastros_Click);
            // 
            // TSair
            // 
            this.TSair.CustomBackground = true;
            this.TSair.CustomForeColor = true;
            this.TSair.DialogResult = System.Windows.Forms.DialogResult.Cancel;
            this.TSair.Location = new System.Drawing.Point(17, 531);
            this.TSair.Name = "TSair";
            this.TSair.Size = new System.Drawing.Size(108, 62);
            this.TSair.TabIndex = 22;
            this.TSair.Text = "Sair";
            this.TSair.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.TSair.TileImage = ((System.Drawing.Image)(resources.GetObject("TSair.TileImage")));
            this.TSair.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.TSair.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.TSair.UseTileImage = true;
            // 
            // TAjuda
            // 
            this.TAjuda.CustomBackground = true;
            this.TAjuda.CustomForeColor = true;
            this.TAjuda.Location = new System.Drawing.Point(17, 466);
            this.TAjuda.Name = "TAjuda";
            this.TAjuda.Size = new System.Drawing.Size(120, 64);
            this.TAjuda.TabIndex = 23;
            this.TAjuda.Text = "Ajuda";
            this.TAjuda.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.TAjuda.TileImage = ((System.Drawing.Image)(resources.GetObject("TAjuda.TileImage")));
            this.TAjuda.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.TAjuda.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.TAjuda.UseTileImage = true;
            // 
            // TQr
            // 
            this.TQr.CustomBackground = true;
            this.TQr.CustomForeColor = true;
            this.TQr.Location = new System.Drawing.Point(17, 405);
            this.TQr.Name = "TQr";
            this.TQr.Size = new System.Drawing.Size(225, 58);
            this.TQr.TabIndex = 24;
            this.TQr.Text = "QR Code Experimento";
            this.TQr.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.TQr.TileImage = ((System.Drawing.Image)(resources.GetObject("TQr.TileImage")));
            this.TQr.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.TQr.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.TQr.UseTileImage = true;
            // 
            // pictureBox1
            // 
            this.pictureBox1.Image = ((System.Drawing.Image)(resources.GetObject("pictureBox1.Image")));
            this.pictureBox1.Location = new System.Drawing.Point(263, 4);
            this.pictureBox1.Name = "pictureBox1";
            this.pictureBox1.Size = new System.Drawing.Size(560, 535);
            this.pictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.AutoSize;
            this.pictureBox1.TabIndex = 25;
            this.pictureBox1.TabStop = false;
            this.pictureBox1.Click += new System.EventHandler(this.pictureBox1_Click);
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(741, 526);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(82, 13);
            this.label1.TabIndex = 26;
            this.label1.Text = "ProAgro System";
            // 
            // FrmPrincipal
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(917, 695);
            this.Controls.Add(this.panel1);
            this.Name = "FrmPrincipal";
            this.Style = MetroFramework.MetroColorStyle.Green;
            this.Text = "Principal";
            this.Load += new System.EventHandler(this.FrmPrincipal_Load);
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Panel panel1;
        private MetroFramework.Controls.MetroTile TSair;
        private MetroFramework.Controls.MetroTile TAjuda;
        private MetroFramework.Controls.MetroTile TQr;
        private MetroFramework.Controls.MetroTile TFerramentas;
        private MetroFramework.Controls.MetroTile TAnalise;
        private MetroFramework.Controls.MetroTile TRelatorio;
        private MetroFramework.Controls.MetroTile TGerminacao;
        private MetroFramework.Controls.MetroTile TExperimento;
        private MetroFramework.Controls.MetroTile TCadastros;
        private System.Windows.Forms.PictureBox pictureBox1;
        private System.Windows.Forms.Label label1;
    }
}

