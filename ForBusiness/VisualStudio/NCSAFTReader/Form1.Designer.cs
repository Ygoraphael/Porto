namespace NCSAFTReader
{
    partial class Form1
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
            System.Windows.Forms.TreeNode treeNode1 = new System.Windows.Forms.TreeNode("Artigos");
            System.Windows.Forms.TreeNode treeNode2 = new System.Windows.Forms.TreeNode("Clientes");
            System.Windows.Forms.TreeNode treeNode3 = new System.Windows.Forms.TreeNode("Documentos");
            System.Windows.Forms.TreeNode treeNode4 = new System.Windows.Forms.TreeNode("Fornecedores");
            System.Windows.Forms.TreeNode treeNode5 = new System.Windows.Forms.TreeNode("Taxas IVA");
            System.Windows.Forms.TreeNode treeNode6 = new System.Windows.Forms.TreeNode("Tabelas", new System.Windows.Forms.TreeNode[] {
            treeNode1,
            treeNode2,
            treeNode3,
            treeNode4,
            treeNode5});
            this.treeView1 = new System.Windows.Forms.TreeView();
            this.menuStrip1 = new System.Windows.Forms.MenuStrip();
            this.ficheiroToolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.abrirToolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.despejarLinhasToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.sairToolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.verToolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.validadorToolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.versãoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.sAFTPT10101ToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.sAFTPT10201GeralToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.sAFTPT10201SimplificadoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.sAFTPT10301GeralToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.sAFTPT10301SimplificadoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.ficheiroToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.abrirToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.sairToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.verToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.validadorToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.tabControl1 = new System.Windows.Forms.TabControl();
            this.tabPage1 = new System.Windows.Forms.TabPage();
            this.textBox6 = new System.Windows.Forms.TextBox();
            this.textBox5 = new System.Windows.Forms.TextBox();
            this.textBox4 = new System.Windows.Forms.TextBox();
            this.textBox3 = new System.Windows.Forms.TextBox();
            this.textBox2 = new System.Windows.Forms.TextBox();
            this.textBox1 = new System.Windows.Forms.TextBox();
            this.label6 = new System.Windows.Forms.Label();
            this.label5 = new System.Windows.Forms.Label();
            this.label4 = new System.Windows.Forms.Label();
            this.label3 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.label1 = new System.Windows.Forms.Label();
            this.tabPage2 = new System.Windows.Forms.TabPage();
            this.textBox9 = new System.Windows.Forms.TextBox();
            this.textBox8 = new System.Windows.Forms.TextBox();
            this.textBox7 = new System.Windows.Forms.TextBox();
            this.label9 = new System.Windows.Forms.Label();
            this.label8 = new System.Windows.Forms.Label();
            this.label7 = new System.Windows.Forms.Label();
            this.dataGridView1 = new System.Windows.Forms.DataGridView();
            this.dataGridView2 = new System.Windows.Forms.DataGridView();
            this.openFileDialog1 = new System.Windows.Forms.OpenFileDialog();
            this.dataGridView3 = new System.Windows.Forms.DataGridView();
            this.No = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.Erro = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.label10 = new System.Windows.Forms.Label();
            this.textBox10 = new System.Windows.Forms.TextBox();
            this.dataGridView4 = new System.Windows.Forms.DataGridView();
            this.pictureBox1 = new System.Windows.Forms.PictureBox();
            this.progressBar1 = new System.Windows.Forms.ProgressBar();
            this.menuStrip1.SuspendLayout();
            this.tabControl1.SuspendLayout();
            this.tabPage1.SuspendLayout();
            this.tabPage2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView1)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView2)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView3)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView4)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).BeginInit();
            this.SuspendLayout();
            // 
            // treeView1
            // 
            this.treeView1.Location = new System.Drawing.Point(4, 27);
            this.treeView1.Name = "treeView1";
            treeNode1.Name = "Node1";
            treeNode1.Text = "Artigos";
            treeNode2.Name = "Node2";
            treeNode2.Text = "Clientes";
            treeNode3.Name = "Node3";
            treeNode3.Text = "Documentos";
            treeNode4.Name = "Node4";
            treeNode4.Text = "Fornecedores";
            treeNode5.Name = "Node5";
            treeNode5.Text = "Taxas IVA";
            treeNode6.Name = "Node0";
            treeNode6.Text = "Tabelas";
            this.treeView1.Nodes.AddRange(new System.Windows.Forms.TreeNode[] {
            treeNode6});
            this.treeView1.Scrollable = false;
            this.treeView1.ShowPlusMinus = false;
            this.treeView1.Size = new System.Drawing.Size(153, 165);
            this.treeView1.TabIndex = 0;
            this.treeView1.NodeMouseClick += new System.Windows.Forms.TreeNodeMouseClickEventHandler(this.treeView1_NodeMouseClick);
            // 
            // menuStrip1
            // 
            this.menuStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.ficheiroToolStripMenuItem1,
            this.verToolStripMenuItem1,
            this.versãoToolStripMenuItem});
            this.menuStrip1.Location = new System.Drawing.Point(0, 0);
            this.menuStrip1.Name = "menuStrip1";
            this.menuStrip1.Size = new System.Drawing.Size(868, 24);
            this.menuStrip1.TabIndex = 1;
            this.menuStrip1.Text = "menuStrip1";
            // 
            // ficheiroToolStripMenuItem1
            // 
            this.ficheiroToolStripMenuItem1.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.abrirToolStripMenuItem1,
            this.despejarLinhasToolStripMenuItem,
            this.sairToolStripMenuItem1});
            this.ficheiroToolStripMenuItem1.Name = "ficheiroToolStripMenuItem1";
            this.ficheiroToolStripMenuItem1.Size = new System.Drawing.Size(56, 20);
            this.ficheiroToolStripMenuItem1.Text = "Ficheiro";
            // 
            // abrirToolStripMenuItem1
            // 
            this.abrirToolStripMenuItem1.Name = "abrirToolStripMenuItem1";
            this.abrirToolStripMenuItem1.Size = new System.Drawing.Size(157, 22);
            this.abrirToolStripMenuItem1.Text = "Abrir";
            this.abrirToolStripMenuItem1.Click += new System.EventHandler(this.abrirToolStripMenuItem1_Click);
            // 
            // despejarLinhasToolStripMenuItem
            // 
            this.despejarLinhasToolStripMenuItem.Name = "despejarLinhasToolStripMenuItem";
            this.despejarLinhasToolStripMenuItem.Size = new System.Drawing.Size(157, 22);
            this.despejarLinhasToolStripMenuItem.Text = "Linhas Para Excel";
            this.despejarLinhasToolStripMenuItem.Click += new System.EventHandler(this.despejarLinhasToolStripMenuItem_Click);
            // 
            // sairToolStripMenuItem1
            // 
            this.sairToolStripMenuItem1.Name = "sairToolStripMenuItem1";
            this.sairToolStripMenuItem1.Size = new System.Drawing.Size(157, 22);
            this.sairToolStripMenuItem1.Text = "Sair";
            this.sairToolStripMenuItem1.Click += new System.EventHandler(this.sairToolStripMenuItem1_Click);
            // 
            // verToolStripMenuItem1
            // 
            this.verToolStripMenuItem1.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.validadorToolStripMenuItem1});
            this.verToolStripMenuItem1.Name = "verToolStripMenuItem1";
            this.verToolStripMenuItem1.Size = new System.Drawing.Size(35, 20);
            this.verToolStripMenuItem1.Text = "Ver";
            // 
            // validadorToolStripMenuItem1
            // 
            this.validadorToolStripMenuItem1.Name = "validadorToolStripMenuItem1";
            this.validadorToolStripMenuItem1.Size = new System.Drawing.Size(152, 22);
            this.validadorToolStripMenuItem1.Text = "Validador";
            this.validadorToolStripMenuItem1.Click += new System.EventHandler(this.validadorToolStripMenuItem1_Click);
            // 
            // versãoToolStripMenuItem
            // 
            this.versãoToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.toolStripMenuItem1,
            this.sAFTPT10101ToolStripMenuItem,
            this.sAFTPT10201GeralToolStripMenuItem,
            this.sAFTPT10201SimplificadoToolStripMenuItem,
            this.sAFTPT10301GeralToolStripMenuItem,
            this.sAFTPT10301SimplificadoToolStripMenuItem});
            this.versãoToolStripMenuItem.Name = "versãoToolStripMenuItem";
            this.versãoToolStripMenuItem.Size = new System.Drawing.Size(52, 20);
            this.versãoToolStripMenuItem.Text = "Versão";
            // 
            // toolStripMenuItem1
            // 
            this.toolStripMenuItem1.Name = "toolStripMenuItem1";
            this.toolStripMenuItem1.Size = new System.Drawing.Size(216, 22);
            this.toolStripMenuItem1.Text = "SAFTPT1.01_01 - Geral";
            this.toolStripMenuItem1.Click += new System.EventHandler(this.toolStripMenuItem1_Click);
            // 
            // sAFTPT10101ToolStripMenuItem
            // 
            this.sAFTPT10101ToolStripMenuItem.Name = "sAFTPT10101ToolStripMenuItem";
            this.sAFTPT10101ToolStripMenuItem.Size = new System.Drawing.Size(216, 22);
            this.sAFTPT10101ToolStripMenuItem.Text = "SAFTPT1.01_01 - Simplificado";
            this.sAFTPT10101ToolStripMenuItem.Click += new System.EventHandler(this.sAFTPT10101ToolStripMenuItem_Click);
            // 
            // sAFTPT10201GeralToolStripMenuItem
            // 
            this.sAFTPT10201GeralToolStripMenuItem.Name = "sAFTPT10201GeralToolStripMenuItem";
            this.sAFTPT10201GeralToolStripMenuItem.Size = new System.Drawing.Size(216, 22);
            this.sAFTPT10201GeralToolStripMenuItem.Text = "SAFTPT1.02_01 - Geral";
            this.sAFTPT10201GeralToolStripMenuItem.Click += new System.EventHandler(this.sAFTPT10201GeralToolStripMenuItem_Click);
            // 
            // sAFTPT10201SimplificadoToolStripMenuItem
            // 
            this.sAFTPT10201SimplificadoToolStripMenuItem.Name = "sAFTPT10201SimplificadoToolStripMenuItem";
            this.sAFTPT10201SimplificadoToolStripMenuItem.Size = new System.Drawing.Size(216, 22);
            this.sAFTPT10201SimplificadoToolStripMenuItem.Text = "SAFTPT1.02_01 - Simplificado";
            this.sAFTPT10201SimplificadoToolStripMenuItem.Click += new System.EventHandler(this.sAFTPT10201SimplificadoToolStripMenuItem_Click);
            // 
            // sAFTPT10301GeralToolStripMenuItem
            // 
            this.sAFTPT10301GeralToolStripMenuItem.Name = "sAFTPT10301GeralToolStripMenuItem";
            this.sAFTPT10301GeralToolStripMenuItem.Size = new System.Drawing.Size(216, 22);
            this.sAFTPT10301GeralToolStripMenuItem.Text = "SAFTPT1.03_01 - Geral";
            this.sAFTPT10301GeralToolStripMenuItem.Click += new System.EventHandler(this.sAFTPT10301GeralToolStripMenuItem_Click);
            // 
            // sAFTPT10301SimplificadoToolStripMenuItem
            // 
            this.sAFTPT10301SimplificadoToolStripMenuItem.Checked = true;
            this.sAFTPT10301SimplificadoToolStripMenuItem.CheckState = System.Windows.Forms.CheckState.Checked;
            this.sAFTPT10301SimplificadoToolStripMenuItem.Name = "sAFTPT10301SimplificadoToolStripMenuItem";
            this.sAFTPT10301SimplificadoToolStripMenuItem.Size = new System.Drawing.Size(216, 22);
            this.sAFTPT10301SimplificadoToolStripMenuItem.Text = "SAFTPT1.03_01 - Simplificado";
            this.sAFTPT10301SimplificadoToolStripMenuItem.Click += new System.EventHandler(this.sAFTPT10301SimplificadoToolStripMenuItem_Click);
            // 
            // ficheiroToolStripMenuItem
            // 
            this.ficheiroToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.abrirToolStripMenuItem,
            this.sairToolStripMenuItem});
            this.ficheiroToolStripMenuItem.Name = "ficheiroToolStripMenuItem";
            this.ficheiroToolStripMenuItem.Size = new System.Drawing.Size(56, 20);
            this.ficheiroToolStripMenuItem.Text = "Ficheiro";
            // 
            // abrirToolStripMenuItem
            // 
            this.abrirToolStripMenuItem.Name = "abrirToolStripMenuItem";
            this.abrirToolStripMenuItem.Size = new System.Drawing.Size(97, 22);
            this.abrirToolStripMenuItem.Text = "Abrir";
            // 
            // sairToolStripMenuItem
            // 
            this.sairToolStripMenuItem.Name = "sairToolStripMenuItem";
            this.sairToolStripMenuItem.Size = new System.Drawing.Size(97, 22);
            this.sairToolStripMenuItem.Text = "Sair";
            // 
            // verToolStripMenuItem
            // 
            this.verToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.validadorToolStripMenuItem});
            this.verToolStripMenuItem.Name = "verToolStripMenuItem";
            this.verToolStripMenuItem.Size = new System.Drawing.Size(35, 20);
            this.verToolStripMenuItem.Text = "Ver";
            // 
            // validadorToolStripMenuItem
            // 
            this.validadorToolStripMenuItem.Name = "validadorToolStripMenuItem";
            this.validadorToolStripMenuItem.Size = new System.Drawing.Size(118, 22);
            this.validadorToolStripMenuItem.Text = "Validador";
            // 
            // tabControl1
            // 
            this.tabControl1.Controls.Add(this.tabPage1);
            this.tabControl1.Controls.Add(this.tabPage2);
            this.tabControl1.Location = new System.Drawing.Point(161, 27);
            this.tabControl1.Name = "tabControl1";
            this.tabControl1.SelectedIndex = 0;
            this.tabControl1.Size = new System.Drawing.Size(407, 165);
            this.tabControl1.TabIndex = 2;
            // 
            // tabPage1
            // 
            this.tabPage1.Controls.Add(this.textBox6);
            this.tabPage1.Controls.Add(this.textBox5);
            this.tabPage1.Controls.Add(this.textBox4);
            this.tabPage1.Controls.Add(this.textBox3);
            this.tabPage1.Controls.Add(this.textBox2);
            this.tabPage1.Controls.Add(this.textBox1);
            this.tabPage1.Controls.Add(this.label6);
            this.tabPage1.Controls.Add(this.label5);
            this.tabPage1.Controls.Add(this.label4);
            this.tabPage1.Controls.Add(this.label3);
            this.tabPage1.Controls.Add(this.label2);
            this.tabPage1.Controls.Add(this.label1);
            this.tabPage1.Location = new System.Drawing.Point(4, 22);
            this.tabPage1.Name = "tabPage1";
            this.tabPage1.Padding = new System.Windows.Forms.Padding(3);
            this.tabPage1.Size = new System.Drawing.Size(399, 139);
            this.tabPage1.TabIndex = 0;
            this.tabPage1.Text = "Dados Empresa";
            this.tabPage1.UseVisualStyleBackColor = true;
            // 
            // textBox6
            // 
            this.textBox6.Location = new System.Drawing.Point(99, 109);
            this.textBox6.Name = "textBox6";
            this.textBox6.ReadOnly = true;
            this.textBox6.Size = new System.Drawing.Size(289, 20);
            this.textBox6.TabIndex = 11;
            // 
            // textBox5
            // 
            this.textBox5.Location = new System.Drawing.Point(99, 90);
            this.textBox5.Name = "textBox5";
            this.textBox5.ReadOnly = true;
            this.textBox5.Size = new System.Drawing.Size(289, 20);
            this.textBox5.TabIndex = 10;
            // 
            // textBox4
            // 
            this.textBox4.Location = new System.Drawing.Point(99, 69);
            this.textBox4.Name = "textBox4";
            this.textBox4.ReadOnly = true;
            this.textBox4.Size = new System.Drawing.Size(289, 20);
            this.textBox4.TabIndex = 9;
            // 
            // textBox3
            // 
            this.textBox3.Location = new System.Drawing.Point(99, 48);
            this.textBox3.Name = "textBox3";
            this.textBox3.ReadOnly = true;
            this.textBox3.Size = new System.Drawing.Size(289, 20);
            this.textBox3.TabIndex = 8;
            // 
            // textBox2
            // 
            this.textBox2.Location = new System.Drawing.Point(99, 27);
            this.textBox2.Name = "textBox2";
            this.textBox2.ReadOnly = true;
            this.textBox2.Size = new System.Drawing.Size(289, 20);
            this.textBox2.TabIndex = 7;
            // 
            // textBox1
            // 
            this.textBox1.Location = new System.Drawing.Point(99, 7);
            this.textBox1.Name = "textBox1";
            this.textBox1.ReadOnly = true;
            this.textBox1.Size = new System.Drawing.Size(289, 20);
            this.textBox1.TabIndex = 6;
            // 
            // label6
            // 
            this.label6.AutoSize = true;
            this.label6.Location = new System.Drawing.Point(54, 114);
            this.label6.Name = "label6";
            this.label6.Size = new System.Drawing.Size(43, 13);
            this.label6.TabIndex = 5;
            this.label6.Text = "Cidade:";
            // 
            // label5
            // 
            this.label5.AutoSize = true;
            this.label5.Location = new System.Drawing.Point(33, 93);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(64, 13);
            this.label5.TabIndex = 4;
            this.label5.Text = "Cód. Postal:";
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Location = new System.Drawing.Point(51, 72);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(46, 13);
            this.label4.TabIndex = 3;
            this.label4.Text = "Morada:";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(16, 51);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(81, 13);
            this.label3.TabIndex = 2;
            this.label3.Text = "Nº Contribuinte:";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(10, 30);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(87, 13);
            this.label2.TabIndex = 1;
            this.label2.Text = "Nome Comercial:";
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(59, 9);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(38, 13);
            this.label1.TabIndex = 0;
            this.label1.Text = "Nome:";
            // 
            // tabPage2
            // 
            this.tabPage2.Controls.Add(this.textBox9);
            this.tabPage2.Controls.Add(this.textBox8);
            this.tabPage2.Controls.Add(this.textBox7);
            this.tabPage2.Controls.Add(this.label9);
            this.tabPage2.Controls.Add(this.label8);
            this.tabPage2.Controls.Add(this.label7);
            this.tabPage2.Location = new System.Drawing.Point(4, 22);
            this.tabPage2.Name = "tabPage2";
            this.tabPage2.Padding = new System.Windows.Forms.Padding(3);
            this.tabPage2.Size = new System.Drawing.Size(399, 139);
            this.tabPage2.TabIndex = 1;
            this.tabPage2.Text = "Dados Documentos";
            this.tabPage2.UseVisualStyleBackColor = true;
            // 
            // textBox9
            // 
            this.textBox9.Location = new System.Drawing.Point(112, 55);
            this.textBox9.Name = "textBox9";
            this.textBox9.ReadOnly = true;
            this.textBox9.Size = new System.Drawing.Size(247, 20);
            this.textBox9.TabIndex = 5;
            // 
            // textBox8
            // 
            this.textBox8.Location = new System.Drawing.Point(112, 34);
            this.textBox8.Name = "textBox8";
            this.textBox8.ReadOnly = true;
            this.textBox8.Size = new System.Drawing.Size(247, 20);
            this.textBox8.TabIndex = 4;
            // 
            // textBox7
            // 
            this.textBox7.Location = new System.Drawing.Point(112, 13);
            this.textBox7.Name = "textBox7";
            this.textBox7.ReadOnly = true;
            this.textBox7.Size = new System.Drawing.Size(247, 20);
            this.textBox7.TabIndex = 3;
            // 
            // label9
            // 
            this.label9.AutoSize = true;
            this.label9.Location = new System.Drawing.Point(4, 58);
            this.label9.Name = "label9";
            this.label9.Size = new System.Drawing.Size(102, 13);
            this.label9.TabIndex = 2;
            this.label9.Text = "Total Crédito S/IVA:";
            // 
            // label8
            // 
            this.label8.AutoSize = true;
            this.label8.Location = new System.Drawing.Point(6, 37);
            this.label8.Name = "label8";
            this.label8.Size = new System.Drawing.Size(100, 13);
            this.label8.TabIndex = 1;
            this.label8.Text = "Total Débito S/IVA:";
            // 
            // label7
            // 
            this.label7.AutoSize = true;
            this.label7.Location = new System.Drawing.Point(39, 16);
            this.label7.Name = "label7";
            this.label7.Size = new System.Drawing.Size(67, 13);
            this.label7.TabIndex = 0;
            this.label7.Text = "Nº Entradas:";
            // 
            // dataGridView1
            // 
            this.dataGridView1.AllowUserToAddRows = false;
            this.dataGridView1.AllowUserToDeleteRows = false;
            this.dataGridView1.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dataGridView1.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dataGridView1.Location = new System.Drawing.Point(4, 439);
            this.dataGridView1.Name = "dataGridView1";
            this.dataGridView1.ReadOnly = true;
            this.dataGridView1.RowHeadersVisible = false;
            this.dataGridView1.Size = new System.Drawing.Size(428, 279);
            this.dataGridView1.TabIndex = 3;
            // 
            // dataGridView2
            // 
            this.dataGridView2.AllowUserToAddRows = false;
            this.dataGridView2.AllowUserToDeleteRows = false;
            this.dataGridView2.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dataGridView2.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dataGridView2.Location = new System.Drawing.Point(4, 198);
            this.dataGridView2.Name = "dataGridView2";
            this.dataGridView2.ReadOnly = true;
            this.dataGridView2.RowHeadersVisible = false;
            this.dataGridView2.Size = new System.Drawing.Size(865, 235);
            this.dataGridView2.TabIndex = 4;
            this.dataGridView2.SelectionChanged += new System.EventHandler(this.dataGridView2_SelectionChanged);
            // 
            // openFileDialog1
            // 
            this.openFileDialog1.FileName = "openFileDialog1";
            // 
            // dataGridView3
            // 
            this.dataGridView3.AllowUserToAddRows = false;
            this.dataGridView3.AllowUserToDeleteRows = false;
            this.dataGridView3.AutoSizeRowsMode = System.Windows.Forms.DataGridViewAutoSizeRowsMode.AllCells;
            this.dataGridView3.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dataGridView3.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dataGridView3.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.No,
            this.Erro});
            this.dataGridView3.Location = new System.Drawing.Point(4, 198);
            this.dataGridView3.Name = "dataGridView3";
            this.dataGridView3.ReadOnly = true;
            this.dataGridView3.RowHeadersVisible = false;
            this.dataGridView3.Size = new System.Drawing.Size(240, 211);
            this.dataGridView3.TabIndex = 5;
            // 
            // No
            // 
            this.No.HeaderText = "No";
            this.No.Name = "No";
            this.No.ReadOnly = true;
            // 
            // Erro
            // 
            this.Erro.HeaderText = "Erro";
            this.Erro.Name = "Erro";
            this.Erro.ReadOnly = true;
            // 
            // label10
            // 
            this.label10.AutoSize = true;
            this.label10.Location = new System.Drawing.Point(479, 4);
            this.label10.Name = "label10";
            this.label10.Size = new System.Drawing.Size(107, 13);
            this.label10.TabIndex = 6;
            this.label10.Text = "ESTADO SAF-T(PT):";
            // 
            // textBox10
            // 
            this.textBox10.Location = new System.Drawing.Point(592, 2);
            this.textBox10.Name = "textBox10";
            this.textBox10.ReadOnly = true;
            this.textBox10.Size = new System.Drawing.Size(274, 20);
            this.textBox10.TabIndex = 7;
            // 
            // dataGridView4
            // 
            this.dataGridView4.AllowUserToAddRows = false;
            this.dataGridView4.AllowUserToDeleteRows = false;
            this.dataGridView4.BackgroundColor = System.Drawing.SystemColors.ActiveBorder;
            this.dataGridView4.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dataGridView4.Location = new System.Drawing.Point(438, 439);
            this.dataGridView4.Name = "dataGridView4";
            this.dataGridView4.ReadOnly = true;
            this.dataGridView4.RowHeadersVisible = false;
            this.dataGridView4.Size = new System.Drawing.Size(428, 279);
            this.dataGridView4.TabIndex = 8;
            // 
            // pictureBox1
            // 
            this.pictureBox1.BackColor = System.Drawing.SystemColors.Control;
            this.pictureBox1.Location = new System.Drawing.Point(575, 29);
            this.pictureBox1.Name = "pictureBox1";
            this.pictureBox1.Size = new System.Drawing.Size(291, 163);
            this.pictureBox1.TabIndex = 9;
            this.pictureBox1.TabStop = false;
            // 
            // progressBar1
            // 
            this.progressBar1.Location = new System.Drawing.Point(227, 4);
            this.progressBar1.Name = "progressBar1";
            this.progressBar1.Size = new System.Drawing.Size(246, 16);
            this.progressBar1.Step = 1;
            this.progressBar1.Style = System.Windows.Forms.ProgressBarStyle.Continuous;
            this.progressBar1.TabIndex = 10;
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(868, 716);
            this.Controls.Add(this.progressBar1);
            this.Controls.Add(this.pictureBox1);
            this.Controls.Add(this.dataGridView4);
            this.Controls.Add(this.textBox10);
            this.Controls.Add(this.label10);
            this.Controls.Add(this.dataGridView3);
            this.Controls.Add(this.dataGridView2);
            this.Controls.Add(this.dataGridView1);
            this.Controls.Add(this.tabControl1);
            this.Controls.Add(this.treeView1);
            this.Controls.Add(this.menuStrip1);
            this.MainMenuStrip = this.menuStrip1;
            this.Name = "Form1";
            this.Text = "NCSAFTReader";
            this.SizeChanged += new System.EventHandler(this.Form1_SizeChanged);
            this.menuStrip1.ResumeLayout(false);
            this.menuStrip1.PerformLayout();
            this.tabControl1.ResumeLayout(false);
            this.tabPage1.ResumeLayout(false);
            this.tabPage1.PerformLayout();
            this.tabPage2.ResumeLayout(false);
            this.tabPage2.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView1)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView2)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView3)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView4)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        public System.Windows.Forms.TreeView treeView1;
        public System.Windows.Forms.MenuStrip menuStrip1;
        public System.Windows.Forms.ToolStripMenuItem ficheiroToolStripMenuItem;
        public System.Windows.Forms.ToolStripMenuItem abrirToolStripMenuItem;
        public System.Windows.Forms.ToolStripMenuItem sairToolStripMenuItem;
        public System.Windows.Forms.TabControl tabControl1;
        public System.Windows.Forms.TabPage tabPage1;
        public System.Windows.Forms.TabPage tabPage2;
        public System.Windows.Forms.DataGridView dataGridView1;
        public System.Windows.Forms.TextBox textBox6;
        public System.Windows.Forms.TextBox textBox5;
        public System.Windows.Forms.TextBox textBox4;
        public System.Windows.Forms.TextBox textBox3;
        public System.Windows.Forms.TextBox textBox2;
        public System.Windows.Forms.TextBox textBox1;
        public System.Windows.Forms.Label label6;
        public System.Windows.Forms.Label label5;
        public System.Windows.Forms.Label label4;
        public System.Windows.Forms.Label label3;
        public System.Windows.Forms.Label label2;
        public System.Windows.Forms.Label label1;
        public System.Windows.Forms.TextBox textBox9;
        public System.Windows.Forms.TextBox textBox8;
        public System.Windows.Forms.TextBox textBox7;
        public System.Windows.Forms.Label label9;
        public System.Windows.Forms.Label label8;
        public System.Windows.Forms.Label label7;
        public System.Windows.Forms.DataGridView dataGridView2;
        public System.Windows.Forms.OpenFileDialog openFileDialog1;
        public System.Windows.Forms.ToolStripMenuItem verToolStripMenuItem;
        public System.Windows.Forms.ToolStripMenuItem validadorToolStripMenuItem;
        public System.Windows.Forms.DataGridView dataGridView3;
        public System.Windows.Forms.Label label10;
        public System.Windows.Forms.TextBox textBox10;
        public System.Windows.Forms.DataGridViewTextBoxColumn No;
        public System.Windows.Forms.DataGridViewTextBoxColumn Erro;
        public System.Windows.Forms.ToolStripMenuItem ficheiroToolStripMenuItem1;
        public System.Windows.Forms.ToolStripMenuItem abrirToolStripMenuItem1;
        public System.Windows.Forms.ToolStripMenuItem sairToolStripMenuItem1;
        public System.Windows.Forms.ToolStripMenuItem verToolStripMenuItem1;
        public System.Windows.Forms.ToolStripMenuItem validadorToolStripMenuItem1;
        public System.Windows.Forms.ToolStripMenuItem versãoToolStripMenuItem;
        public System.Windows.Forms.ToolStripMenuItem sAFTPT10101ToolStripMenuItem;
        public System.Windows.Forms.ToolStripMenuItem sAFTPT10201GeralToolStripMenuItem;
        public System.Windows.Forms.ToolStripMenuItem sAFTPT10201SimplificadoToolStripMenuItem;
        public System.Windows.Forms.ToolStripMenuItem sAFTPT10301GeralToolStripMenuItem;
        public System.Windows.Forms.ToolStripMenuItem sAFTPT10301SimplificadoToolStripMenuItem;
        public System.Windows.Forms.DataGridView dataGridView4;
        private System.Windows.Forms.PictureBox pictureBox1;
        private System.Windows.Forms.ToolStripMenuItem toolStripMenuItem1;
        private System.Windows.Forms.ToolStripMenuItem despejarLinhasToolStripMenuItem;
        public System.Windows.Forms.ProgressBar progressBar1;
    }
}

