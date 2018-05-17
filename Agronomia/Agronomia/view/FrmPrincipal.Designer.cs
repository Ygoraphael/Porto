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
            this.btnColetaExperimento = new System.Windows.Forms.Button();
            this.groupBox2 = new System.Windows.Forms.GroupBox();
            this.btnCadastroExperimento = new System.Windows.Forms.Button();
            this.btnColetaGerminacao = new System.Windows.Forms.Button();
            this.groupBox1 = new System.Windows.Forms.GroupBox();
            this.btnGerminacao = new System.Windows.Forms.Button();
            this.groupBox3 = new System.Windows.Forms.GroupBox();
            this.btnPropriedade = new System.Windows.Forms.Button();
            this.btnCultura = new System.Windows.Forms.Button();
            this.btnCompeticao = new System.Windows.Forms.Button();
            this.btnPadrao = new System.Windows.Forms.Button();
            this.panel1 = new System.Windows.Forms.Panel();
            this.groupBox4 = new System.Windows.Forms.GroupBox();
            this.button6 = new System.Windows.Forms.Button();
            this.btnUsuário = new System.Windows.Forms.Button();
            this.button5 = new System.Windows.Forms.Button();
            this.menuStrip1 = new System.Windows.Forms.MenuStrip();
            this.arquivoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.btnSair = new System.Windows.Forms.ToolStripMenuItem();
            this.cadastrosToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.usuárioToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.propriedadeToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.padrãoVariavelToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.competiçãoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.culturaToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.germinaçãoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.btntesteGerminacao = new System.Windows.Forms.ToolStripMenuItem();
            this.coletaGerminaçãoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.experimentoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.experimentoToolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.coletaExperimentoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.groupBox2.SuspendLayout();
            this.groupBox1.SuspendLayout();
            this.groupBox3.SuspendLayout();
            this.panel1.SuspendLayout();
            this.groupBox4.SuspendLayout();
            this.menuStrip1.SuspendLayout();
            this.SuspendLayout();
            // 
            // btnColetaExperimento
            // 
            this.btnColetaExperimento.Location = new System.Drawing.Point(26, 138);
            this.btnColetaExperimento.Name = "btnColetaExperimento";
            this.btnColetaExperimento.Size = new System.Drawing.Size(121, 107);
            this.btnColetaExperimento.TabIndex = 3;
            this.btnColetaExperimento.Text = "Coleta Experi&mento";
            this.btnColetaExperimento.UseVisualStyleBackColor = true;
            this.btnColetaExperimento.Click += new System.EventHandler(this.btnColetaExperimento_Click);
            // 
            // groupBox2
            // 
            this.groupBox2.Controls.Add(this.btnCadastroExperimento);
            this.groupBox2.Controls.Add(this.btnColetaExperimento);
            this.groupBox2.Location = new System.Drawing.Point(676, 13);
            this.groupBox2.Name = "groupBox2";
            this.groupBox2.Size = new System.Drawing.Size(172, 266);
            this.groupBox2.TabIndex = 12;
            this.groupBox2.TabStop = false;
            this.groupBox2.Text = "EXPERIMENTO";
            // 
            // btnCadastroExperimento
            // 
            this.btnCadastroExperimento.Location = new System.Drawing.Point(26, 27);
            this.btnCadastroExperimento.Name = "btnCadastroExperimento";
            this.btnCadastroExperimento.Size = new System.Drawing.Size(121, 107);
            this.btnCadastroExperimento.TabIndex = 1;
            this.btnCadastroExperimento.Text = "&Experimento ";
            this.btnCadastroExperimento.UseVisualStyleBackColor = true;
            this.btnCadastroExperimento.Click += new System.EventHandler(this.btnCadastroExperimento_Click);
            // 
            // btnColetaGerminacao
            // 
            this.btnColetaGerminacao.Location = new System.Drawing.Point(26, 132);
            this.btnColetaGerminacao.Name = "btnColetaGerminacao";
            this.btnColetaGerminacao.Size = new System.Drawing.Size(121, 107);
            this.btnColetaGerminacao.TabIndex = 9;
            this.btnColetaGerminacao.Text = "Coleta da Germi&nação";
            this.btnColetaGerminacao.UseVisualStyleBackColor = true;
            this.btnColetaGerminacao.Click += new System.EventHandler(this.btnColetaGerminacao_Click);
            // 
            // groupBox1
            // 
            this.groupBox1.Controls.Add(this.btnGerminacao);
            this.groupBox1.Controls.Add(this.btnColetaGerminacao);
            this.groupBox1.Location = new System.Drawing.Point(485, 13);
            this.groupBox1.Name = "groupBox1";
            this.groupBox1.Size = new System.Drawing.Size(174, 266);
            this.groupBox1.TabIndex = 11;
            this.groupBox1.TabStop = false;
            this.groupBox1.Text = "GERMINAÇÃO";
            // 
            // btnGerminacao
            // 
            this.btnGerminacao.Location = new System.Drawing.Point(26, 19);
            this.btnGerminacao.Name = "btnGerminacao";
            this.btnGerminacao.Size = new System.Drawing.Size(121, 107);
            this.btnGerminacao.TabIndex = 2;
            this.btnGerminacao.Text = "Teste de &Germinação";
            this.btnGerminacao.UseVisualStyleBackColor = true;
            this.btnGerminacao.Click += new System.EventHandler(this.btnGerminacao_Click);
            // 
            // groupBox3
            // 
            this.groupBox3.Controls.Add(this.btnPropriedade);
            this.groupBox3.Controls.Add(this.btnCultura);
            this.groupBox3.Controls.Add(this.btnCompeticao);
            this.groupBox3.Controls.Add(this.btnPadrao);
            this.groupBox3.Location = new System.Drawing.Point(148, 13);
            this.groupBox3.Name = "groupBox3";
            this.groupBox3.Size = new System.Drawing.Size(319, 266);
            this.groupBox3.TabIndex = 13;
            this.groupBox3.TabStop = false;
            this.groupBox3.Text = "CADASTROS";
            // 
            // btnPropriedade
            // 
            this.btnPropriedade.Location = new System.Drawing.Point(33, 19);
            this.btnPropriedade.Name = "btnPropriedade";
            this.btnPropriedade.Size = new System.Drawing.Size(121, 107);
            this.btnPropriedade.TabIndex = 0;
            this.btnPropriedade.Text = "&Propriedades";
            this.btnPropriedade.UseVisualStyleBackColor = true;
            this.btnPropriedade.Click += new System.EventHandler(this.btnPropriedade_Click);
            // 
            // btnCultura
            // 
            this.btnCultura.Location = new System.Drawing.Point(33, 138);
            this.btnCultura.Name = "btnCultura";
            this.btnCultura.Size = new System.Drawing.Size(121, 107);
            this.btnCultura.TabIndex = 5;
            this.btnCultura.Text = "Cu&ltura";
            this.btnCultura.UseVisualStyleBackColor = true;
            this.btnCultura.Click += new System.EventHandler(this.btnCultura_Click);
            // 
            // btnCompeticao
            // 
            this.btnCompeticao.Location = new System.Drawing.Point(179, 23);
            this.btnCompeticao.Name = "btnCompeticao";
            this.btnCompeticao.Size = new System.Drawing.Size(121, 107);
            this.btnCompeticao.TabIndex = 10;
            this.btnCompeticao.Text = " &Competição";
            this.btnCompeticao.UseVisualStyleBackColor = true;
            this.btnCompeticao.Click += new System.EventHandler(this.btnCompeticao_Click);
            // 
            // btnPadrao
            // 
            this.btnPadrao.Location = new System.Drawing.Point(179, 138);
            this.btnPadrao.Name = "btnPadrao";
            this.btnPadrao.Size = new System.Drawing.Size(121, 107);
            this.btnPadrao.TabIndex = 6;
            this.btnPadrao.Text = "Padrão de &Variaveis";
            this.btnPadrao.UseVisualStyleBackColor = true;
            this.btnPadrao.Click += new System.EventHandler(this.btnPadrao_Click);
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.groupBox4);
            this.panel1.Controls.Add(this.groupBox3);
            this.panel1.Controls.Add(this.groupBox2);
            this.panel1.Controls.Add(this.groupBox1);
            this.panel1.Controls.Add(this.btnUsuário);
            this.panel1.Controls.Add(this.button5);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel1.Location = new System.Drawing.Point(0, 24);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(1050, 294);
            this.panel1.TabIndex = 2;
            // 
            // groupBox4
            // 
            this.groupBox4.Controls.Add(this.button6);
            this.groupBox4.Location = new System.Drawing.Point(872, 13);
            this.groupBox4.Name = "groupBox4";
            this.groupBox4.Size = new System.Drawing.Size(159, 266);
            this.groupBox4.TabIndex = 14;
            this.groupBox4.TabStop = false;
            this.groupBox4.Text = "RELATÓRIOS";
            // 
            // button6
            // 
            this.button6.Location = new System.Drawing.Point(20, 91);
            this.button6.Name = "button6";
            this.button6.Size = new System.Drawing.Size(121, 107);
            this.button6.TabIndex = 6;
            this.button6.Text = "&Relatório";
            this.button6.UseVisualStyleBackColor = true;
            // 
            // btnUsuário
            // 
            this.btnUsuário.Location = new System.Drawing.Point(12, 32);
            this.btnUsuário.Name = "btnUsuário";
            this.btnUsuário.Size = new System.Drawing.Size(121, 107);
            this.btnUsuário.TabIndex = 7;
            this.btnUsuário.Text = "Cadastro &Usuário";
            this.btnUsuário.UseVisualStyleBackColor = true;
            this.btnUsuário.Click += new System.EventHandler(this.btnUsuário_Click);
            // 
            // button5
            // 
            this.button5.Location = new System.Drawing.Point(12, 145);
            this.button5.Name = "button5";
            this.button5.Size = new System.Drawing.Size(121, 107);
            this.button5.TabIndex = 4;
            this.button5.Text = "&Analise de solo";
            this.button5.UseVisualStyleBackColor = true;
            // 
            // menuStrip1
            // 
            this.menuStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.arquivoToolStripMenuItem,
            this.cadastrosToolStripMenuItem,
            this.germinaçãoToolStripMenuItem,
            this.experimentoToolStripMenuItem});
            this.menuStrip1.Location = new System.Drawing.Point(0, 0);
            this.menuStrip1.Name = "menuStrip1";
            this.menuStrip1.Size = new System.Drawing.Size(1050, 24);
            this.menuStrip1.TabIndex = 3;
            this.menuStrip1.Text = "menuStrip1";
            // 
            // arquivoToolStripMenuItem
            // 
            this.arquivoToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.btnSair});
            this.arquivoToolStripMenuItem.Name = "arquivoToolStripMenuItem";
            this.arquivoToolStripMenuItem.Size = new System.Drawing.Size(61, 20);
            this.arquivoToolStripMenuItem.Text = "Arquivo";
            // 
            // btnSair
            // 
            this.btnSair.Name = "btnSair";
            this.btnSair.Size = new System.Drawing.Size(152, 22);
            this.btnSair.Text = "Sair";
            this.btnSair.Click += new System.EventHandler(this.btnSair_Click);
            // 
            // cadastrosToolStripMenuItem
            // 
            this.cadastrosToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.usuárioToolStripMenuItem,
            this.propriedadeToolStripMenuItem,
            this.padrãoVariavelToolStripMenuItem,
            this.competiçãoToolStripMenuItem,
            this.culturaToolStripMenuItem});
            this.cadastrosToolStripMenuItem.Name = "cadastrosToolStripMenuItem";
            this.cadastrosToolStripMenuItem.Size = new System.Drawing.Size(71, 20);
            this.cadastrosToolStripMenuItem.Text = "Cadastros";
            // 
            // usuárioToolStripMenuItem
            // 
            this.usuárioToolStripMenuItem.Name = "usuárioToolStripMenuItem";
            this.usuárioToolStripMenuItem.Size = new System.Drawing.Size(154, 22);
            this.usuárioToolStripMenuItem.Text = "Usuário";
            // 
            // propriedadeToolStripMenuItem
            // 
            this.propriedadeToolStripMenuItem.Name = "propriedadeToolStripMenuItem";
            this.propriedadeToolStripMenuItem.Size = new System.Drawing.Size(154, 22);
            this.propriedadeToolStripMenuItem.Text = "Propriedade";
            this.propriedadeToolStripMenuItem.Click += new System.EventHandler(this.btnPropriedade_Click);
            // 
            // padrãoVariavelToolStripMenuItem
            // 
            this.padrãoVariavelToolStripMenuItem.Name = "padrãoVariavelToolStripMenuItem";
            this.padrãoVariavelToolStripMenuItem.Size = new System.Drawing.Size(154, 22);
            this.padrãoVariavelToolStripMenuItem.Text = "Padrão Variavel";
            // 
            // competiçãoToolStripMenuItem
            // 
            this.competiçãoToolStripMenuItem.Name = "competiçãoToolStripMenuItem";
            this.competiçãoToolStripMenuItem.Size = new System.Drawing.Size(154, 22);
            this.competiçãoToolStripMenuItem.Text = "Competição";
            this.competiçãoToolStripMenuItem.Click += new System.EventHandler(this.btnCompeticao_Click);
            // 
            // culturaToolStripMenuItem
            // 
            this.culturaToolStripMenuItem.Name = "culturaToolStripMenuItem";
            this.culturaToolStripMenuItem.Size = new System.Drawing.Size(154, 22);
            this.culturaToolStripMenuItem.Text = "Cultura";
            this.culturaToolStripMenuItem.Click += new System.EventHandler(this.btnCultura_Click);
            // 
            // germinaçãoToolStripMenuItem
            // 
            this.germinaçãoToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.btntesteGerminacao,
            this.coletaGerminaçãoToolStripMenuItem});
            this.germinaçãoToolStripMenuItem.Name = "germinaçãoToolStripMenuItem";
            this.germinaçãoToolStripMenuItem.Size = new System.Drawing.Size(83, 20);
            this.germinaçãoToolStripMenuItem.Text = "Germinação";
            // 
            // btntesteGerminacao
            // 
            this.btntesteGerminacao.Name = "btntesteGerminacao";
            this.btntesteGerminacao.Size = new System.Drawing.Size(172, 22);
            this.btntesteGerminacao.Text = "Teste &Germinação";
            this.btntesteGerminacao.Click += new System.EventHandler(this.btnGerminacao_Click);
            // 
            // coletaGerminaçãoToolStripMenuItem
            // 
            this.coletaGerminaçãoToolStripMenuItem.Name = "coletaGerminaçãoToolStripMenuItem";
            this.coletaGerminaçãoToolStripMenuItem.Size = new System.Drawing.Size(172, 22);
            this.coletaGerminaçãoToolStripMenuItem.Text = "ColetaGermi&nação";
            this.coletaGerminaçãoToolStripMenuItem.Click += new System.EventHandler(this.btnColetaGerminacao_Click);
            // 
            // experimentoToolStripMenuItem
            // 
            this.experimentoToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.experimentoToolStripMenuItem1,
            this.coletaExperimentoToolStripMenuItem});
            this.experimentoToolStripMenuItem.Name = "experimentoToolStripMenuItem";
            this.experimentoToolStripMenuItem.Size = new System.Drawing.Size(85, 20);
            this.experimentoToolStripMenuItem.Text = "Experimento";
            // 
            // experimentoToolStripMenuItem1
            // 
            this.experimentoToolStripMenuItem1.Name = "experimentoToolStripMenuItem1";
            this.experimentoToolStripMenuItem1.Size = new System.Drawing.Size(177, 22);
            this.experimentoToolStripMenuItem1.Text = "Experimento";
            this.experimentoToolStripMenuItem1.Click += new System.EventHandler(this.btnCadastroExperimento_Click);
            // 
            // coletaExperimentoToolStripMenuItem
            // 
            this.coletaExperimentoToolStripMenuItem.Name = "coletaExperimentoToolStripMenuItem";
            this.coletaExperimentoToolStripMenuItem.Size = new System.Drawing.Size(177, 22);
            this.coletaExperimentoToolStripMenuItem.Text = "Coleta Experimento";
            this.coletaExperimentoToolStripMenuItem.Click += new System.EventHandler(this.btnColetaExperimento_Click);
            // 
            // FrmPrincipal
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1050, 324);
            this.Controls.Add(this.panel1);
            this.Controls.Add(this.menuStrip1);
            this.Name = "FrmPrincipal";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Principal";
            this.groupBox2.ResumeLayout(false);
            this.groupBox1.ResumeLayout(false);
            this.groupBox3.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            this.groupBox4.ResumeLayout(false);
            this.menuStrip1.ResumeLayout(false);
            this.menuStrip1.PerformLayout();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Button btnColetaExperimento;
        private System.Windows.Forms.GroupBox groupBox2;
        private System.Windows.Forms.Button btnCadastroExperimento;
        private System.Windows.Forms.Button btnColetaGerminacao;
        private System.Windows.Forms.GroupBox groupBox1;
        private System.Windows.Forms.Button btnGerminacao;
        private System.Windows.Forms.GroupBox groupBox3;
        private System.Windows.Forms.Button btnPropriedade;
        private System.Windows.Forms.Button btnCultura;
        private System.Windows.Forms.Button btnCompeticao;
        private System.Windows.Forms.Button btnPadrao;
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.GroupBox groupBox4;
        private System.Windows.Forms.Button button6;
        private System.Windows.Forms.Button btnUsuário;
        private System.Windows.Forms.Button button5;
        private System.Windows.Forms.MenuStrip menuStrip1;
        private System.Windows.Forms.ToolStripMenuItem cadastrosToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem usuárioToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem propriedadeToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem padrãoVariavelToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem germinaçãoToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem btntesteGerminacao;
        private System.Windows.Forms.ToolStripMenuItem competiçãoToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem culturaToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem coletaGerminaçãoToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem experimentoToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem experimentoToolStripMenuItem1;
        private System.Windows.Forms.ToolStripMenuItem coletaExperimentoToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem arquivoToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem btnSair;
    }
}

