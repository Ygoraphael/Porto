namespace Agronomia.TelaPrincipal
{
    partial class TGerminacao
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(TGerminacao));
            this.Tteste = new MetroFramework.Controls.MetroTile();
            this.Tcoleta = new MetroFramework.Controls.MetroTile();
            this.Tsairr = new MetroFramework.Controls.MetroTile();
            this.SuspendLayout();
            // 
            // Tteste
            // 
            this.Tteste.CustomBackground = true;
            this.Tteste.CustomForeColor = true;
            this.Tteste.Location = new System.Drawing.Point(23, 63);
            this.Tteste.Name = "Tteste";
            this.Tteste.Size = new System.Drawing.Size(219, 66);
            this.Tteste.TabIndex = 0;
            this.Tteste.Text = "Teste de Germinação";
            this.Tteste.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.Tteste.TileImage = ((System.Drawing.Image)(resources.GetObject("Tteste.TileImage")));
            this.Tteste.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.Tteste.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.Tteste.UseTileImage = true;
            this.Tteste.Click += new System.EventHandler(this.Tteste_Click);
            // 
            // Tcoleta
            // 
            this.Tcoleta.CustomBackground = true;
            this.Tcoleta.CustomForeColor = true;
            this.Tcoleta.Location = new System.Drawing.Point(23, 147);
            this.Tcoleta.Name = "Tcoleta";
            this.Tcoleta.Size = new System.Drawing.Size(219, 66);
            this.Tcoleta.TabIndex = 0;
            this.Tcoleta.Text = "Coleta de Germinação";
            this.Tcoleta.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.Tcoleta.TileImage = ((System.Drawing.Image)(resources.GetObject("Tcoleta.TileImage")));
            this.Tcoleta.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.Tcoleta.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.Tcoleta.UseTileImage = true;
            this.Tcoleta.Click += new System.EventHandler(this.Tcoleta_Click);
            // 
            // Tsairr
            // 
            this.Tsairr.CustomBackground = true;
            this.Tsairr.CustomForeColor = true;
            this.Tsairr.DialogResult = System.Windows.Forms.DialogResult.Cancel;
            this.Tsairr.Location = new System.Drawing.Point(28, 220);
            this.Tsairr.Name = "Tsairr";
            this.Tsairr.Size = new System.Drawing.Size(95, 66);
            this.Tsairr.TabIndex = 0;
            this.Tsairr.Text = "Sair";
            this.Tsairr.TextAlign = System.Drawing.ContentAlignment.BottomRight;
            this.Tsairr.TileImage = ((System.Drawing.Image)(resources.GetObject("Tsairr.TileImage")));
            this.Tsairr.TileImageAlign = System.Drawing.ContentAlignment.BottomLeft;
            this.Tsairr.TileTextFontWeight = MetroFramework.MetroTileTextWeight.Bold;
            this.Tsairr.UseTileImage = true;
            // 
            // TGerminacao
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(284, 322);
            this.Controls.Add(this.Tsairr);
            this.Controls.Add(this.Tcoleta);
            this.Controls.Add(this.Tteste);
            this.Name = "TGerminacao";
            this.Text = "Germinação";
            this.Load += new System.EventHandler(this.TGerminacao_Load);
            this.ResumeLayout(false);

        }

        #endregion

        private MetroFramework.Controls.MetroTile Tteste;
        private MetroFramework.Controls.MetroTile Tcoleta;
        private MetroFramework.Controls.MetroTile Tsairr;
    }
}