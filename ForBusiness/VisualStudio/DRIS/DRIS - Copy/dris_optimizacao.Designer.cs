namespace EOR_DRIS
{
    partial class dris_optimizacao
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
            System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle1 = new System.Windows.Forms.DataGridViewCellStyle();
            this.grafico_optimizacao_dris = new ZedGraph.ZedGraphControl();
            this.dris_recomendacao = new System.Windows.Forms.DataGridView();
            this.dris_recomendacao_sensibilidade = new System.Windows.Forms.DataGridView();
            this.dris_recomendacao_max_min = new System.Windows.Forms.DataGridView();
            this.dris_optimizacao_ibn = new System.Windows.Forms.DataGridView();
            this.dris_recomendacao_gravar = new System.Windows.Forms.Button();
            this.dris_recomendacao_sair = new System.Windows.Forms.Button();
            this.label4 = new System.Windows.Forms.Label();
            this.dris_recomendacao_calcular = new System.Windows.Forms.Button();
            this.label1 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.dris_valores_adicionar = new System.Windows.Forms.DataGridView();
            this.label5 = new System.Windows.Forms.Label();
            this.grafico_optimizacao_dris2 = new ZedGraph.ZedGraphControl();
            this.label7 = new System.Windows.Forms.Label();
            this.label8 = new System.Windows.Forms.Label();
            this.dris_amostra_dados = new System.Windows.Forms.DataGridView();
            this.label6 = new System.Windows.Forms.Label();
            this.label9 = new System.Windows.Forms.Label();
            this.label10 = new System.Windows.Forms.Label();
            this.label11 = new System.Windows.Forms.Label();
            this.tbar_dris_lim = new System.Windows.Forms.TrackBar();
            this.label12 = new System.Windows.Forms.Label();
            this.tb_ind_dris_lim = new System.Windows.Forms.TextBox();
            this.dg_cores = new System.Windows.Forms.DataGridView();
            ((System.ComponentModel.ISupportInitialize)(this.dris_recomendacao)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dris_recomendacao_sensibilidade)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dris_recomendacao_max_min)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dris_optimizacao_ibn)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dris_valores_adicionar)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dris_amostra_dados)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.tbar_dris_lim)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dg_cores)).BeginInit();
            this.SuspendLayout();
            // 
            // grafico_optimizacao_dris
            // 
            this.grafico_optimizacao_dris.Location = new System.Drawing.Point(3, 347);
            this.grafico_optimizacao_dris.Name = "grafico_optimizacao_dris";
            this.grafico_optimizacao_dris.ScrollGrace = 0D;
            this.grafico_optimizacao_dris.ScrollMaxX = 0D;
            this.grafico_optimizacao_dris.ScrollMaxY = 0D;
            this.grafico_optimizacao_dris.ScrollMaxY2 = 0D;
            this.grafico_optimizacao_dris.ScrollMinX = 0D;
            this.grafico_optimizacao_dris.ScrollMinY = 0D;
            this.grafico_optimizacao_dris.ScrollMinY2 = 0D;
            this.grafico_optimizacao_dris.Size = new System.Drawing.Size(343, 224);
            this.grafico_optimizacao_dris.TabIndex = 0;
            // 
            // dris_recomendacao
            // 
            this.dris_recomendacao.AllowUserToAddRows = false;
            this.dris_recomendacao.AllowUserToDeleteRows = false;
            this.dris_recomendacao.AllowUserToResizeColumns = false;
            this.dris_recomendacao.AllowUserToResizeRows = false;
            this.dris_recomendacao.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dris_recomendacao.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dris_recomendacao.Location = new System.Drawing.Point(3, 213);
            this.dris_recomendacao.Name = "dris_recomendacao";
            this.dris_recomendacao.ReadOnly = true;
            this.dris_recomendacao.RowHeadersVisible = false;
            this.dris_recomendacao.Size = new System.Drawing.Size(657, 64);
            this.dris_recomendacao.TabIndex = 22;
            // 
            // dris_recomendacao_sensibilidade
            // 
            this.dris_recomendacao_sensibilidade.AllowUserToAddRows = false;
            this.dris_recomendacao_sensibilidade.AllowUserToDeleteRows = false;
            this.dris_recomendacao_sensibilidade.AllowUserToResizeColumns = false;
            this.dris_recomendacao_sensibilidade.AllowUserToResizeRows = false;
            this.dris_recomendacao_sensibilidade.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dris_recomendacao_sensibilidade.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dris_recomendacao_sensibilidade.EditMode = System.Windows.Forms.DataGridViewEditMode.EditOnEnter;
            this.dris_recomendacao_sensibilidade.Location = new System.Drawing.Point(2, 57);
            this.dris_recomendacao_sensibilidade.Name = "dris_recomendacao_sensibilidade";
            this.dris_recomendacao_sensibilidade.RowHeadersVisible = false;
            this.dris_recomendacao_sensibilidade.Size = new System.Drawing.Size(657, 42);
            this.dris_recomendacao_sensibilidade.TabIndex = 23;
            this.dris_recomendacao_sensibilidade.CellEndEdit += new System.Windows.Forms.DataGridViewCellEventHandler(this.dris_recomendacao_sensibilidade_CellEndEdit);
            // 
            // dris_recomendacao_max_min
            // 
            this.dris_recomendacao_max_min.AllowUserToAddRows = false;
            this.dris_recomendacao_max_min.AllowUserToDeleteRows = false;
            this.dris_recomendacao_max_min.AllowUserToResizeColumns = false;
            this.dris_recomendacao_max_min.AllowUserToResizeRows = false;
            this.dris_recomendacao_max_min.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dris_recomendacao_max_min.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dris_recomendacao_max_min.EditMode = System.Windows.Forms.DataGridViewEditMode.EditOnEnter;
            this.dris_recomendacao_max_min.Location = new System.Drawing.Point(2, 10);
            this.dris_recomendacao_max_min.Name = "dris_recomendacao_max_min";
            this.dris_recomendacao_max_min.RowHeadersVisible = false;
            this.dris_recomendacao_max_min.Size = new System.Drawing.Size(657, 42);
            this.dris_recomendacao_max_min.TabIndex = 24;
            this.dris_recomendacao_max_min.CellEndEdit += new System.Windows.Forms.DataGridViewCellEventHandler(this.dris_recomendacao_max_min_CellEndEdit);
            // 
            // dris_optimizacao_ibn
            // 
            this.dris_optimizacao_ibn.AllowUserToAddRows = false;
            this.dris_optimizacao_ibn.AllowUserToDeleteRows = false;
            this.dris_optimizacao_ibn.AllowUserToResizeColumns = false;
            this.dris_optimizacao_ibn.AllowUserToResizeRows = false;
            this.dris_optimizacao_ibn.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dris_optimizacao_ibn.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dris_optimizacao_ibn.Location = new System.Drawing.Point(665, 213);
            this.dris_optimizacao_ibn.Name = "dris_optimizacao_ibn";
            this.dris_optimizacao_ibn.ReadOnly = true;
            this.dris_optimizacao_ibn.RowHeadersVisible = false;
            this.dris_optimizacao_ibn.Size = new System.Drawing.Size(127, 64);
            this.dris_optimizacao_ibn.TabIndex = 26;
            // 
            // dris_recomendacao_gravar
            // 
            this.dris_recomendacao_gravar.Location = new System.Drawing.Point(720, 513);
            this.dris_recomendacao_gravar.Name = "dris_recomendacao_gravar";
            this.dris_recomendacao_gravar.Size = new System.Drawing.Size(57, 36);
            this.dris_recomendacao_gravar.TabIndex = 27;
            this.dris_recomendacao_gravar.Text = "Gravar";
            this.dris_recomendacao_gravar.UseVisualStyleBackColor = true;
            this.dris_recomendacao_gravar.Click += new System.EventHandler(this.dris_recomendacao_gravar_Click);
            // 
            // dris_recomendacao_sair
            // 
            this.dris_recomendacao_sair.Location = new System.Drawing.Point(790, 513);
            this.dris_recomendacao_sair.Name = "dris_recomendacao_sair";
            this.dris_recomendacao_sair.Size = new System.Drawing.Size(57, 36);
            this.dris_recomendacao_sair.TabIndex = 28;
            this.dris_recomendacao_sair.Text = "Sair";
            this.dris_recomendacao_sair.UseVisualStyleBackColor = true;
            this.dris_recomendacao_sair.Click += new System.EventHandler(this.dris_recomendacao_sair_Click);
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Location = new System.Drawing.Point(796, 237);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(42, 13);
            this.label4.TabIndex = 32;
            this.label4.Text = "IBN Ini.";
            // 
            // dris_recomendacao_calcular
            // 
            this.dris_recomendacao_calcular.Location = new System.Drawing.Point(720, 463);
            this.dris_recomendacao_calcular.Name = "dris_recomendacao_calcular";
            this.dris_recomendacao_calcular.Size = new System.Drawing.Size(127, 44);
            this.dris_recomendacao_calcular.TabIndex = 34;
            this.dris_recomendacao_calcular.Text = "Calcular";
            this.dris_recomendacao_calcular.UseVisualStyleBackColor = true;
            this.dris_recomendacao_calcular.Click += new System.EventHandler(this.dris_recomendacao_calcular_Click);
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(663, 79);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(69, 13);
            this.label1.TabIndex = 35;
            this.label1.Text = "Sensibilidade";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(665, 33);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(43, 13);
            this.label2.TabIndex = 36;
            this.label2.Text = "Máximo";
            // 
            // dris_valores_adicionar
            // 
            this.dris_valores_adicionar.AllowUserToAddRows = false;
            this.dris_valores_adicionar.AllowUserToDeleteRows = false;
            this.dris_valores_adicionar.AllowUserToResizeColumns = false;
            this.dris_valores_adicionar.AllowUserToResizeRows = false;
            this.dris_valores_adicionar.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dris_valores_adicionar.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dris_valores_adicionar.Location = new System.Drawing.Point(3, 283);
            this.dris_valores_adicionar.Name = "dris_valores_adicionar";
            this.dris_valores_adicionar.ReadOnly = true;
            this.dris_valores_adicionar.RowHeadersVisible = false;
            this.dris_valores_adicionar.Size = new System.Drawing.Size(657, 42);
            this.dris_valores_adicionar.TabIndex = 38;
            // 
            // label5
            // 
            this.label5.AutoSize = true;
            this.label5.Location = new System.Drawing.Point(663, 307);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(161, 13);
            this.label5.TabIndex = 39;
            this.label5.Text = "Conc. Adicionar Recomendação";
            // 
            // grafico_optimizacao_dris2
            // 
            this.grafico_optimizacao_dris2.Location = new System.Drawing.Point(363, 347);
            this.grafico_optimizacao_dris2.Name = "grafico_optimizacao_dris2";
            this.grafico_optimizacao_dris2.ScrollGrace = 0D;
            this.grafico_optimizacao_dris2.ScrollMaxX = 0D;
            this.grafico_optimizacao_dris2.ScrollMaxY = 0D;
            this.grafico_optimizacao_dris2.ScrollMaxY2 = 0D;
            this.grafico_optimizacao_dris2.ScrollMinX = 0D;
            this.grafico_optimizacao_dris2.ScrollMinY = 0D;
            this.grafico_optimizacao_dris2.ScrollMinY2 = 0D;
            this.grafico_optimizacao_dris2.Size = new System.Drawing.Size(342, 224);
            this.grafico_optimizacao_dris2.TabIndex = 41;
            // 
            // label7
            // 
            this.label7.AutoSize = true;
            this.label7.Location = new System.Drawing.Point(157, 329);
            this.label7.Name = "label7";
            this.label7.Size = new System.Drawing.Size(34, 13);
            this.label7.TabIndex = 42;
            this.label7.Text = "Inicial";
            // 
            // label8
            // 
            this.label8.AutoSize = true;
            this.label8.Location = new System.Drawing.Point(488, 329);
            this.label8.Name = "label8";
            this.label8.Size = new System.Drawing.Size(92, 13);
            this.label8.TabIndex = 43;
            this.label8.Text = "Após Optimização";
            // 
            // dris_amostra_dados
            // 
            this.dris_amostra_dados.AllowUserToAddRows = false;
            this.dris_amostra_dados.AllowUserToDeleteRows = false;
            this.dris_amostra_dados.AllowUserToResizeColumns = false;
            this.dris_amostra_dados.AllowUserToResizeRows = false;
            this.dris_amostra_dados.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dris_amostra_dados.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dris_amostra_dados.EditMode = System.Windows.Forms.DataGridViewEditMode.EditOnEnter;
            this.dris_amostra_dados.Location = new System.Drawing.Point(2, 105);
            this.dris_amostra_dados.Name = "dris_amostra_dados";
            this.dris_amostra_dados.ReadOnly = true;
            this.dris_amostra_dados.RowHeadersVisible = false;
            this.dris_amostra_dados.Size = new System.Drawing.Size(657, 64);
            this.dris_amostra_dados.TabIndex = 44;
            // 
            // label6
            // 
            this.label6.AutoSize = true;
            this.label6.Location = new System.Drawing.Point(0, 173);
            this.label6.Name = "label6";
            this.label6.Size = new System.Drawing.Size(189, 13);
            this.label6.TabIndex = 45;
            this.label6.Text = "Valores DRIS Inicial e Recomendação";
            // 
            // label9
            // 
            this.label9.AutoSize = true;
            this.label9.Location = new System.Drawing.Point(665, 128);
            this.label9.Name = "label9";
            this.label9.Size = new System.Drawing.Size(113, 13);
            this.label9.TabIndex = 46;
            this.label9.Text = "Valores Amostra Inicial";
            // 
            // label10
            // 
            this.label10.AutoSize = true;
            this.label10.Location = new System.Drawing.Point(665, 149);
            this.label10.Name = "label10";
            this.label10.Size = new System.Drawing.Size(162, 13);
            this.label10.TabIndex = 47;
            this.label10.Text = "Valores Amostra Recomendação";
            // 
            // label11
            // 
            this.label11.AutoSize = true;
            this.label11.Location = new System.Drawing.Point(796, 259);
            this.label11.Name = "label11";
            this.label11.Size = new System.Drawing.Size(51, 13);
            this.label11.TabIndex = 48;
            this.label11.Text = "IBN Rec.";
            // 
            // tbar_dris_lim
            // 
            this.tbar_dris_lim.Location = new System.Drawing.Point(725, 403);
            this.tbar_dris_lim.Maximum = 14;
            this.tbar_dris_lim.Name = "tbar_dris_lim";
            this.tbar_dris_lim.Size = new System.Drawing.Size(118, 42);
            this.tbar_dris_lim.TabIndex = 49;
            this.tbar_dris_lim.Value = 7;
            this.tbar_dris_lim.ValueChanged += new System.EventHandler(this.tb_dris_lim_ValueChanged);
            // 
            // label12
            // 
            this.label12.AutoSize = true;
            this.label12.Location = new System.Drawing.Point(740, 361);
            this.label12.Name = "label12";
            this.label12.Size = new System.Drawing.Size(84, 13);
            this.label12.TabIndex = 50;
            this.label12.Text = "Limite Índ. DRIS";
            // 
            // tb_ind_dris_lim
            // 
            this.tb_ind_dris_lim.Location = new System.Drawing.Point(727, 377);
            this.tb_ind_dris_lim.Name = "tb_ind_dris_lim";
            this.tb_ind_dris_lim.ReadOnly = true;
            this.tb_ind_dris_lim.Size = new System.Drawing.Size(111, 20);
            this.tb_ind_dris_lim.TabIndex = 51;
            this.tb_ind_dris_lim.Text = "-4,5";
            // 
            // dg_cores
            // 
            this.dg_cores.AllowUserToAddRows = false;
            this.dg_cores.AllowUserToDeleteRows = false;
            this.dg_cores.AllowUserToOrderColumns = true;
            this.dg_cores.AllowUserToResizeColumns = false;
            this.dg_cores.AllowUserToResizeRows = false;
            this.dg_cores.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dg_cores.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dg_cores.ColumnHeadersVisible = false;
            this.dg_cores.Location = new System.Drawing.Point(3, 189);
            this.dg_cores.MultiSelect = false;
            this.dg_cores.Name = "dg_cores";
            this.dg_cores.ReadOnly = true;
            this.dg_cores.RowHeadersVisible = false;
            dataGridViewCellStyle1.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.dg_cores.RowsDefaultCellStyle = dataGridViewCellStyle1;
            this.dg_cores.ShowCellErrors = false;
            this.dg_cores.ShowCellToolTips = false;
            this.dg_cores.ShowEditingIcon = false;
            this.dg_cores.ShowRowErrors = false;
            this.dg_cores.Size = new System.Drawing.Size(657, 21);
            this.dg_cores.TabIndex = 52;
            this.dg_cores.TabStop = false;
            this.dg_cores.CellFormatting += new System.Windows.Forms.DataGridViewCellFormattingEventHandler(this.dg_cores_CellFormatting);
            this.dg_cores.SelectionChanged += new System.EventHandler(this.dg_cores_SelectionChanged);
            // 
            // dris_optimizacao
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(855, 573);
            this.Controls.Add(this.dg_cores);
            this.Controls.Add(this.tb_ind_dris_lim);
            this.Controls.Add(this.label12);
            this.Controls.Add(this.tbar_dris_lim);
            this.Controls.Add(this.label11);
            this.Controls.Add(this.label10);
            this.Controls.Add(this.label9);
            this.Controls.Add(this.label6);
            this.Controls.Add(this.dris_amostra_dados);
            this.Controls.Add(this.label8);
            this.Controls.Add(this.label7);
            this.Controls.Add(this.grafico_optimizacao_dris2);
            this.Controls.Add(this.label5);
            this.Controls.Add(this.dris_valores_adicionar);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.dris_recomendacao_calcular);
            this.Controls.Add(this.label4);
            this.Controls.Add(this.dris_recomendacao_sair);
            this.Controls.Add(this.dris_recomendacao_gravar);
            this.Controls.Add(this.dris_optimizacao_ibn);
            this.Controls.Add(this.dris_recomendacao_max_min);
            this.Controls.Add(this.dris_recomendacao_sensibilidade);
            this.Controls.Add(this.dris_recomendacao);
            this.Controls.Add(this.grafico_optimizacao_dris);
            this.Name = "dris_optimizacao";
            this.Text = "dris_optimizacao";
            ((System.ComponentModel.ISupportInitialize)(this.dris_recomendacao)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dris_recomendacao_sensibilidade)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dris_recomendacao_max_min)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dris_optimizacao_ibn)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dris_valores_adicionar)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dris_amostra_dados)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.tbar_dris_lim)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dg_cores)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private ZedGraph.ZedGraphControl grafico_optimizacao_dris;
        private System.Windows.Forms.DataGridView dris_recomendacao;
        private System.Windows.Forms.DataGridView dris_recomendacao_sensibilidade;
        private System.Windows.Forms.DataGridView dris_recomendacao_max_min;
        private System.Windows.Forms.DataGridView dris_optimizacao_ibn;
        private System.Windows.Forms.Button dris_recomendacao_gravar;
        private System.Windows.Forms.Button dris_recomendacao_sair;
        private System.Windows.Forms.Label label4;
        private System.Windows.Forms.Button dris_recomendacao_calcular;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.DataGridView dris_valores_adicionar;
        private System.Windows.Forms.Label label5;
        private ZedGraph.ZedGraphControl grafico_optimizacao_dris2;
        private System.Windows.Forms.Label label7;
        private System.Windows.Forms.Label label8;
        private System.Windows.Forms.DataGridView dris_amostra_dados;
        private System.Windows.Forms.Label label6;
        private System.Windows.Forms.Label label9;
        private System.Windows.Forms.Label label10;
        private System.Windows.Forms.Label label11;
        private System.Windows.Forms.TrackBar tbar_dris_lim;
        private System.Windows.Forms.Label label12;
        private System.Windows.Forms.TextBox tb_ind_dris_lim;
        private System.Windows.Forms.DataGridView dg_cores;
    }
}