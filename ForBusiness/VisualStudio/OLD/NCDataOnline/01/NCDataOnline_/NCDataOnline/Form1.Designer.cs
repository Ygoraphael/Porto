using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.ComponentModel;
using System.Drawing;

namespace NCDataOnline
{
    partial class Form1
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;
        private ComponentResourceManager componentResourceManager = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(Form1));
            this.menuStrip1 = new System.Windows.Forms.MenuStrip();
            this.configuraçãoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.novaToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.abrirToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.guardarToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.guardarComoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.apagarToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem1 = new System.Windows.Forms.ToolStripSeparator();
            this.serviçoWindowsToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.iniciarToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.pararToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem2 = new System.Windows.Forms.ToolStripSeparator();
            this.estadoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem3 = new System.Windows.Forms.ToolStripSeparator();
            this.instalarToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.desinstalarToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem4 = new System.Windows.Forms.ToolStripSeparator();
            this.logToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.abrirToolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.limparToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem5 = new System.Windows.Forms.ToolStripSeparator();
            this.propriedadesToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem6 = new System.Windows.Forms.ToolStripSeparator();
            this.sairToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.ajudaToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.sobreToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.informaçãoDeSuporteToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem7 = new System.Windows.Forms.ToolStripSeparator();
            this.sobreOSincronizadorDeDadosToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.tabControl1 = new System.Windows.Forms.TabControl();
            this.tabPage1 = new System.Windows.Forms.TabPage();
            this.groupBox2 = new System.Windows.Forms.GroupBox();
            this.debug = new System.Windows.Forms.CheckBox();
            this.groupBox1 = new System.Windows.Forms.GroupBox();
            this.key = new System.Windows.Forms.TextBox();
            this.label5 = new System.Windows.Forms.Label();
            this.hash = new System.Windows.Forms.TextBox();
            this.label4 = new System.Windows.Forms.Label();
            this.listBox1 = new System.Windows.Forms.ListBox();
            this.tabPage2 = new System.Windows.Forms.TabPage();
            this.toolStrip1 = new System.Windows.Forms.ToolStrip();
            this.toolStripSeparator = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripSeparator2 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripSeparator1 = new System.Windows.Forms.ToolStripSeparator();
            this.groupBox4 = new System.Windows.Forms.GroupBox();
            this.trusted = new System.Windows.Forms.CheckBox();
            this.groupBox3 = new System.Windows.Forms.GroupBox();
            this.server = new System.Windows.Forms.TextBox();
            this.label10 = new System.Windows.Forms.Label();
            this.bd = new System.Windows.Forms.TextBox();
            this.password = new System.Windows.Forms.TextBox();
            this.label12 = new System.Windows.Forms.Label();
            this.label13 = new System.Windows.Forms.Label();
            this.label11 = new System.Windows.Forms.Label();
            this.user = new System.Windows.Forms.TextBox();
            this.listBox2 = new System.Windows.Forms.ListBox();
            this.contextMenuStrip1 = new System.Windows.Forms.ContextMenuStrip(this.components);
            this.novaConexãoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.gravarConexãoActivaToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem8 = new System.Windows.Forms.ToolStripSeparator();
            this.clonarConexãoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.eliminarConexãoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem9 = new System.Windows.Forms.ToolStripSeparator();
            this.testarConexãoToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem10 = new System.Windows.Forms.ToolStripSeparator();
            this.ajudaToolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.tabPage3 = new System.Windows.Forms.TabPage();
            this.toolStrip2 = new System.Windows.Forms.ToolStrip();
            this.toolStripSeparator3 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripSeparator4 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripSeparator5 = new System.Windows.Forms.ToolStripSeparator();
            this.listBox3 = new System.Windows.Forms.ListBox();
            this.contextMenuStrip2 = new System.Windows.Forms.ContextMenuStrip(this.components);
            this.toolStripMenuItem11 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem13 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripSeparator8 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripMenuItem14 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem15 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripSeparator9 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripMenuItem16 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripSeparator10 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripMenuItem17 = new System.Windows.Forms.ToolStripMenuItem();
            this.groupBox7 = new System.Windows.Forms.GroupBox();
            this.activoQuery = new System.Windows.Forms.CheckBox();
            this.ficheirosaida = new System.Windows.Forms.TextBox();
            this.label25 = new System.Windows.Forms.Label();
            this.groupBox6 = new System.Windows.Forms.GroupBox();
            this.label9 = new System.Windows.Forms.Label();
            this.val10 = new System.Windows.Forms.TextBox();
            this.label15 = new System.Windows.Forms.Label();
            this.val9 = new System.Windows.Forms.TextBox();
            this.label18 = new System.Windows.Forms.Label();
            this.val8 = new System.Windows.Forms.TextBox();
            this.label19 = new System.Windows.Forms.Label();
            this.val7 = new System.Windows.Forms.TextBox();
            this.label22 = new System.Windows.Forms.Label();
            this.val6 = new System.Windows.Forms.TextBox();
            this.label8 = new System.Windows.Forms.Label();
            this.val5 = new System.Windows.Forms.TextBox();
            this.label7 = new System.Windows.Forms.Label();
            this.val4 = new System.Windows.Forms.TextBox();
            this.label6 = new System.Windows.Forms.Label();
            this.val3 = new System.Windows.Forms.TextBox();
            this.label3 = new System.Windows.Forms.Label();
            this.val2 = new System.Windows.Forms.TextBox();
            this.label2 = new System.Windows.Forms.Label();
            this.val1 = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.etiqueta = new System.Windows.Forms.TextBox();
            this.groupBox5 = new System.Windows.Forms.GroupBox();
            this.resultadoQuery = new System.Windows.Forms.ComboBox();
            this.label33 = new System.Windows.Forms.Label();
            this.conexao = new System.Windows.Forms.ComboBox();
            this.label27 = new System.Windows.Forms.Label();
            this.label16 = new System.Windows.Forms.Label();
            this.sql = new System.Windows.Forms.TextBox();
            this.label17 = new System.Windows.Forms.Label();
            this.destinoidQuery = new System.Windows.Forms.TextBox();
            this.label26 = new System.Windows.Forms.Label();
            this.label14 = new System.Windows.Forms.Label();
            this.destinoQuery = new System.Windows.Forms.ComboBox();
            this.intervaloQuery = new System.Windows.Forms.TextBox();
            this.contextMenuStrip3 = new System.Windows.Forms.ContextMenuStrip(this.components);
            this.toolStripMenuItem18 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem20 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripSeparator11 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripMenuItem21 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem22 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripSeparator12 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripMenuItem24 = new System.Windows.Forms.ToolStripMenuItem();
            this.contextMenuStrip4 = new System.Windows.Forms.ContextMenuStrip(this.components);
            this.toolStripMenuItem23 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem26 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripSeparator15 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripMenuItem27 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem28 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripSeparator16 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripMenuItem29 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolTip1 = new System.Windows.Forms.ToolTip(this.components);
            this.backgroundWorker1 = new System.ComponentModel.BackgroundWorker();
            this.backgroundWorker2 = new System.ComponentModel.BackgroundWorker();
            this.toolStripSeparator13 = new System.Windows.Forms.ToolStripSeparator();
            this.toolStripSeparator14 = new System.Windows.Forms.ToolStripSeparator();
            this.newToolStripButton = new System.Windows.Forms.ToolStripButton();
            this.saveToolStripButton = new System.Windows.Forms.ToolStripButton();
            this.cutToolStripButton = new System.Windows.Forms.ToolStripButton();
            this.copyToolStripButton = new System.Windows.Forms.ToolStripButton();
            this.pasteToolStripButton = new System.Windows.Forms.ToolStripButton();
            this.helpToolStripButton = new System.Windows.Forms.ToolStripButton();
            this.viewpassword = new System.Windows.Forms.Button();
            this.toolStripButton1 = new System.Windows.Forms.ToolStripButton();
            this.toolStripButton3 = new System.Windows.Forms.ToolStripButton();
            this.toolStripButton4 = new System.Windows.Forms.ToolStripButton();
            this.toolStripButton5 = new System.Windows.Forms.ToolStripButton();
            this.toolStripButton6 = new System.Windows.Forms.ToolStripButton();
            this.toolStripButton7 = new System.Windows.Forms.ToolStripButton();
            this.escolherficheirosaida = new System.Windows.Forms.Button();
            this.verficheirosaida = new System.Windows.Forms.Button();
            this.limparficheirosaida = new System.Windows.Forms.Button();
            this.toolStripButton13 = new System.Windows.Forms.ToolStripButton();
            this.toolStripButton16 = new System.Windows.Forms.ToolStripButton();
            this.toolStripButton17 = new System.Windows.Forms.ToolStripButton();
            this.toolStripButton18 = new System.Windows.Forms.ToolStripButton();
            this.toolStripButton19 = new System.Windows.Forms.ToolStripButton();
            this.menuStrip1.SuspendLayout();
            this.tabControl1.SuspendLayout();
            this.tabPage1.SuspendLayout();
            this.groupBox2.SuspendLayout();
            this.groupBox1.SuspendLayout();
            this.tabPage2.SuspendLayout();
            this.toolStrip1.SuspendLayout();
            this.groupBox4.SuspendLayout();
            this.groupBox3.SuspendLayout();
            this.contextMenuStrip1.SuspendLayout();
            this.tabPage3.SuspendLayout();
            this.toolStrip2.SuspendLayout();
            this.contextMenuStrip2.SuspendLayout();
            this.groupBox7.SuspendLayout();
            this.groupBox6.SuspendLayout();
            this.groupBox5.SuspendLayout();
            this.contextMenuStrip3.SuspendLayout();
            this.contextMenuStrip4.SuspendLayout();
            this.SuspendLayout();
            // 
            // menuStrip1
            // 
            this.menuStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.configuraçãoToolStripMenuItem,
            this.ajudaToolStripMenuItem});
            this.menuStrip1.Location = new System.Drawing.Point(0, 0);
            this.menuStrip1.Name = "menuStrip1";
            this.menuStrip1.Size = new System.Drawing.Size(684, 24);
            this.menuStrip1.TabIndex = 0;
            this.menuStrip1.Text = "menuStrip1";
            // 
            // configuraçãoToolStripMenuItem
            // 
            this.configuraçãoToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.novaToolStripMenuItem,
            this.abrirToolStripMenuItem,
            this.guardarToolStripMenuItem,
            this.guardarComoToolStripMenuItem,
            this.apagarToolStripMenuItem,
            this.toolStripMenuItem1,
            this.serviçoWindowsToolStripMenuItem,
            this.toolStripMenuItem4,
            this.logToolStripMenuItem,
            this.toolStripMenuItem5,
            this.propriedadesToolStripMenuItem,
            this.toolStripMenuItem6,
            this.sairToolStripMenuItem});
            this.configuraçãoToolStripMenuItem.Name = "configuraçãoToolStripMenuItem";
            this.configuraçãoToolStripMenuItem.Size = new System.Drawing.Size(91, 20);
            this.configuraçãoToolStripMenuItem.Text = "Configuração";
            // 
            // novaToolStripMenuItem
            // 
            this.novaToolStripMenuItem.Name = "novaToolStripMenuItem";
            this.novaToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.novaToolStripMenuItem.Text = "Nova";
            this.novaToolStripMenuItem.Click += new System.EventHandler(this.novaToolStripMenuItem_Click);
            // 
            // abrirToolStripMenuItem
            // 
            this.abrirToolStripMenuItem.Name = "abrirToolStripMenuItem";
            this.abrirToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.abrirToolStripMenuItem.Text = "Abrir";
            this.abrirToolStripMenuItem.Click += new System.EventHandler(this.abrirToolStripMenuItem_Click);
            // 
            // guardarToolStripMenuItem
            // 
            this.guardarToolStripMenuItem.Name = "guardarToolStripMenuItem";
            this.guardarToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.guardarToolStripMenuItem.Text = "Guardar";
            this.guardarToolStripMenuItem.Click += new System.EventHandler(this.guardarToolStripMenuItem_Click);
            // 
            // guardarComoToolStripMenuItem
            // 
            this.guardarComoToolStripMenuItem.Name = "guardarComoToolStripMenuItem";
            this.guardarComoToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.guardarComoToolStripMenuItem.Text = "Guardar como...";
            this.guardarComoToolStripMenuItem.Click += new System.EventHandler(this.guardarComoToolStripMenuItem_Click);
            // 
            // apagarToolStripMenuItem
            // 
            this.apagarToolStripMenuItem.Name = "apagarToolStripMenuItem";
            this.apagarToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.apagarToolStripMenuItem.Text = "Apagar";
            this.apagarToolStripMenuItem.Click += new System.EventHandler(this.apagarToolStripMenuItem_Click);
            // 
            // toolStripMenuItem1
            // 
            this.toolStripMenuItem1.Name = "toolStripMenuItem1";
            this.toolStripMenuItem1.Size = new System.Drawing.Size(161, 6);
            // 
            // serviçoWindowsToolStripMenuItem
            // 
            this.serviçoWindowsToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.iniciarToolStripMenuItem,
            this.pararToolStripMenuItem,
            this.toolStripMenuItem2,
            this.estadoToolStripMenuItem,
            this.toolStripMenuItem3,
            this.instalarToolStripMenuItem,
            this.desinstalarToolStripMenuItem});
            this.serviçoWindowsToolStripMenuItem.Name = "serviçoWindowsToolStripMenuItem";
            this.serviçoWindowsToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.serviçoWindowsToolStripMenuItem.Text = "Serviço Windows";
            // 
            // iniciarToolStripMenuItem
            // 
            this.iniciarToolStripMenuItem.Name = "iniciarToolStripMenuItem";
            this.iniciarToolStripMenuItem.Size = new System.Drawing.Size(131, 22);
            this.iniciarToolStripMenuItem.Text = "Iniciar";
            this.iniciarToolStripMenuItem.Click += new System.EventHandler(this.iniciarToolStripMenuItem_Click);
            // 
            // pararToolStripMenuItem
            // 
            this.pararToolStripMenuItem.Name = "pararToolStripMenuItem";
            this.pararToolStripMenuItem.Size = new System.Drawing.Size(131, 22);
            this.pararToolStripMenuItem.Text = "Parar";
            this.pararToolStripMenuItem.Click += new System.EventHandler(this.pararToolStripMenuItem_Click);
            // 
            // toolStripMenuItem2
            // 
            this.toolStripMenuItem2.Name = "toolStripMenuItem2";
            this.toolStripMenuItem2.Size = new System.Drawing.Size(128, 6);
            // 
            // estadoToolStripMenuItem
            // 
            this.estadoToolStripMenuItem.Name = "estadoToolStripMenuItem";
            this.estadoToolStripMenuItem.Size = new System.Drawing.Size(131, 22);
            this.estadoToolStripMenuItem.Text = "Estado";
            this.estadoToolStripMenuItem.Click += new System.EventHandler(this.estadoToolStripMenuItem_Click);
            // 
            // toolStripMenuItem3
            // 
            this.toolStripMenuItem3.Name = "toolStripMenuItem3";
            this.toolStripMenuItem3.Size = new System.Drawing.Size(128, 6);
            // 
            // instalarToolStripMenuItem
            // 
            this.instalarToolStripMenuItem.Name = "instalarToolStripMenuItem";
            this.instalarToolStripMenuItem.Size = new System.Drawing.Size(131, 22);
            this.instalarToolStripMenuItem.Text = "Instalar";
            this.instalarToolStripMenuItem.Click += new System.EventHandler(this.instalarToolStripMenuItem_Click);
            // 
            // desinstalarToolStripMenuItem
            // 
            this.desinstalarToolStripMenuItem.Name = "desinstalarToolStripMenuItem";
            this.desinstalarToolStripMenuItem.Size = new System.Drawing.Size(131, 22);
            this.desinstalarToolStripMenuItem.Text = "Desinstalar";
            this.desinstalarToolStripMenuItem.Click += new System.EventHandler(this.desinstalarToolStripMenuItem_Click);
            // 
            // toolStripMenuItem4
            // 
            this.toolStripMenuItem4.Name = "toolStripMenuItem4";
            this.toolStripMenuItem4.Size = new System.Drawing.Size(161, 6);
            // 
            // logToolStripMenuItem
            // 
            this.logToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.abrirToolStripMenuItem1,
            this.limparToolStripMenuItem});
            this.logToolStripMenuItem.Name = "logToolStripMenuItem";
            this.logToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.logToolStripMenuItem.Text = "Log";
            // 
            // abrirToolStripMenuItem1
            // 
            this.abrirToolStripMenuItem1.Name = "abrirToolStripMenuItem1";
            this.abrirToolStripMenuItem1.Size = new System.Drawing.Size(111, 22);
            this.abrirToolStripMenuItem1.Text = "Abrir";
            this.abrirToolStripMenuItem1.Click += new System.EventHandler(this.abrirToolStripMenuItem1_Click);
            // 
            // limparToolStripMenuItem
            // 
            this.limparToolStripMenuItem.Name = "limparToolStripMenuItem";
            this.limparToolStripMenuItem.Size = new System.Drawing.Size(111, 22);
            this.limparToolStripMenuItem.Text = "Limpar";
            this.limparToolStripMenuItem.Click += new System.EventHandler(this.limparToolStripMenuItem_Click);
            // 
            // toolStripMenuItem5
            // 
            this.toolStripMenuItem5.Name = "toolStripMenuItem5";
            this.toolStripMenuItem5.Size = new System.Drawing.Size(161, 6);
            // 
            // propriedadesToolStripMenuItem
            // 
            this.propriedadesToolStripMenuItem.Name = "propriedadesToolStripMenuItem";
            this.propriedadesToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.propriedadesToolStripMenuItem.Text = "Propriedades";
            this.propriedadesToolStripMenuItem.Click += new System.EventHandler(this.propriedadesToolStripMenuItem_Click);
            // 
            // toolStripMenuItem6
            // 
            this.toolStripMenuItem6.Name = "toolStripMenuItem6";
            this.toolStripMenuItem6.Size = new System.Drawing.Size(161, 6);
            // 
            // sairToolStripMenuItem
            // 
            this.sairToolStripMenuItem.Name = "sairToolStripMenuItem";
            this.sairToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.sairToolStripMenuItem.Text = "Sair";
            this.sairToolStripMenuItem.Click += new System.EventHandler(this.sairToolStripMenuItem_Click);
            // 
            // ajudaToolStripMenuItem
            // 
            this.ajudaToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.sobreToolStripMenuItem,
            this.informaçãoDeSuporteToolStripMenuItem,
            this.toolStripMenuItem7,
            this.sobreOSincronizadorDeDadosToolStripMenuItem});
            this.ajudaToolStripMenuItem.Name = "ajudaToolStripMenuItem";
            this.ajudaToolStripMenuItem.Size = new System.Drawing.Size(50, 20);
            this.ajudaToolStripMenuItem.Text = "Ajuda";
            // 
            // sobreToolStripMenuItem
            // 
            this.sobreToolStripMenuItem.Name = "sobreToolStripMenuItem";
            this.sobreToolStripMenuItem.Size = new System.Drawing.Size(240, 22);
            this.sobreToolStripMenuItem.Text = "Tópicos de ajuda";
            this.sobreToolStripMenuItem.Click += new System.EventHandler(this.sobreToolStripMenuItem_Click);
            // 
            // informaçãoDeSuporteToolStripMenuItem
            // 
            this.informaçãoDeSuporteToolStripMenuItem.Name = "informaçãoDeSuporteToolStripMenuItem";
            this.informaçãoDeSuporteToolStripMenuItem.Size = new System.Drawing.Size(240, 22);
            this.informaçãoDeSuporteToolStripMenuItem.Text = "Informação de suporte";
            this.informaçãoDeSuporteToolStripMenuItem.Click += new System.EventHandler(this.informaçãoDeSuporteToolStripMenuItem_Click);
            // 
            // toolStripMenuItem7
            // 
            this.toolStripMenuItem7.Name = "toolStripMenuItem7";
            this.toolStripMenuItem7.Size = new System.Drawing.Size(237, 6);
            // 
            // sobreOSincronizadorDeDadosToolStripMenuItem
            // 
            this.sobreOSincronizadorDeDadosToolStripMenuItem.Name = "sobreOSincronizadorDeDadosToolStripMenuItem";
            this.sobreOSincronizadorDeDadosToolStripMenuItem.Size = new System.Drawing.Size(240, 22);
            this.sobreOSincronizadorDeDadosToolStripMenuItem.Text = "Sobre o Sincronizador de dados";
            this.sobreOSincronizadorDeDadosToolStripMenuItem.Click += new System.EventHandler(this.sobreOSincronizadorDeDadosToolStripMenuItem_Click);
            // 
            // tabControl1
            // 
            this.tabControl1.Controls.Add(this.tabPage1);
            this.tabControl1.Controls.Add(this.tabPage2);
            this.tabControl1.Controls.Add(this.tabPage3);
            this.tabControl1.Location = new System.Drawing.Point(0, 27);
            this.tabControl1.Name = "tabControl1";
            this.tabControl1.SelectedIndex = 0;
            this.tabControl1.Size = new System.Drawing.Size(690, 647);
            this.tabControl1.TabIndex = 1;
            this.tabControl1.SelectedIndexChanged += new System.EventHandler(this.tabControl1_SelectedIndexChanged);
            // 
            // tabPage1
            // 
            this.tabPage1.Controls.Add(this.groupBox2);
            this.tabPage1.Controls.Add(this.groupBox1);
            this.tabPage1.Controls.Add(this.listBox1);
            this.tabPage1.Location = new System.Drawing.Point(4, 22);
            this.tabPage1.Name = "tabPage1";
            this.tabPage1.Padding = new System.Windows.Forms.Padding(3);
            this.tabPage1.Size = new System.Drawing.Size(682, 621);
            this.tabPage1.TabIndex = 0;
            this.tabPage1.Text = "Geral";
            this.tabPage1.UseVisualStyleBackColor = true;
            // 
            // groupBox2
            // 
            this.groupBox2.Controls.Add(this.debug);
            this.groupBox2.Location = new System.Drawing.Point(192, 77);
            this.groupBox2.Name = "groupBox2";
            this.groupBox2.Size = new System.Drawing.Size(482, 48);
            this.groupBox2.TabIndex = 24;
            this.groupBox2.TabStop = false;
            this.groupBox2.Text = "Opções de execução";
            // 
            // debug
            // 
            this.debug.Appearance = System.Windows.Forms.Appearance.Button;
            this.debug.AutoSize = true;
            this.debug.Location = new System.Drawing.Point(399, 19);
            this.debug.Name = "debug";
            this.debug.Size = new System.Drawing.Size(77, 23);
            this.debug.TabIndex = 3;
            this.debug.Tag = "";
            this.debug.Text = "Modo debug";
            this.debug.UseVisualStyleBackColor = true;
            this.debug.CheckedChanged += new System.EventHandler(this.Control_Changed);
            // 
            // groupBox1
            // 
            this.groupBox1.Controls.Add(this.key);
            this.groupBox1.Controls.Add(this.label5);
            this.groupBox1.Controls.Add(this.hash);
            this.groupBox1.Controls.Add(this.label4);
            this.groupBox1.Location = new System.Drawing.Point(192, 6);
            this.groupBox1.Name = "groupBox1";
            this.groupBox1.Size = new System.Drawing.Size(482, 65);
            this.groupBox1.TabIndex = 23;
            this.groupBox1.TabStop = false;
            this.groupBox1.Text = "Identificação de Dashboard";
            // 
            // key
            // 
            this.key.Location = new System.Drawing.Point(9, 38);
            this.key.Name = "key";
            this.key.Size = new System.Drawing.Size(220, 20);
            this.key.TabIndex = 1;
            this.key.Tag = "";
            this.key.Text = "0000-0000-0000-0000";
            this.key.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label5
            // 
            this.label5.AutoSize = true;
            this.label5.Location = new System.Drawing.Point(6, 22);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(44, 13);
            this.label5.TabIndex = 20;
            this.label5.Text = "API key";
            // 
            // hash
            // 
            this.hash.Location = new System.Drawing.Point(256, 38);
            this.hash.Name = "hash";
            this.hash.Size = new System.Drawing.Size(220, 20);
            this.hash.TabIndex = 2;
            this.hash.Tag = "";
            this.hash.Text = "12345678123456781234567812345678";
            this.hash.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Location = new System.Drawing.Point(253, 22);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(85, 13);
            this.label4.TabIndex = 18;
            this.label4.Text = "Dashboard hash";
            // 
            // listBox1
            // 
            this.listBox1.Enabled = false;
            this.listBox1.FormattingEnabled = true;
            this.listBox1.Location = new System.Drawing.Point(6, 6);
            this.listBox1.Name = "listBox1";
            this.listBox1.Size = new System.Drawing.Size(180, 576);
            this.listBox1.TabIndex = 22;
            this.listBox1.SelectedIndexChanged += new System.EventHandler(this.listBox_SelectedIndexChanged);
            // 
            // tabPage2
            // 
            this.tabPage2.Controls.Add(this.toolStrip1);
            this.tabPage2.Controls.Add(this.groupBox4);
            this.tabPage2.Controls.Add(this.groupBox3);
            this.tabPage2.Controls.Add(this.listBox2);
            this.tabPage2.Location = new System.Drawing.Point(4, 22);
            this.tabPage2.Name = "tabPage2";
            this.tabPage2.Size = new System.Drawing.Size(682, 621);
            this.tabPage2.TabIndex = 1;
            this.tabPage2.Text = "Conexão";
            this.tabPage2.UseVisualStyleBackColor = true;
            // 
            // toolStrip1
            // 
            this.toolStrip1.Dock = System.Windows.Forms.DockStyle.None;
            this.toolStrip1.GripStyle = System.Windows.Forms.ToolStripGripStyle.Hidden;
            this.toolStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.newToolStripButton,
            this.saveToolStripButton,
            this.toolStripSeparator,
            this.cutToolStripButton,
            this.copyToolStripButton,
            this.toolStripSeparator2,
            this.pasteToolStripButton,
            this.toolStripSeparator1,
            this.helpToolStripButton});
            this.toolStrip1.Location = new System.Drawing.Point(0, 584);
            this.toolStrip1.Name = "toolStrip1";
            this.toolStrip1.Padding = new System.Windows.Forms.Padding(10, 0, 1, 0);
            this.toolStrip1.Size = new System.Drawing.Size(252, 25);
            this.toolStrip1.TabIndex = 43;
            this.toolStrip1.Text = "toolStrip1";
            // 
            // toolStripSeparator
            // 
            this.toolStripSeparator.Name = "toolStripSeparator";
            this.toolStripSeparator.Size = new System.Drawing.Size(6, 25);
            // 
            // toolStripSeparator2
            // 
            this.toolStripSeparator2.Name = "toolStripSeparator2";
            this.toolStripSeparator2.Size = new System.Drawing.Size(6, 25);
            // 
            // toolStripSeparator1
            // 
            this.toolStripSeparator1.Name = "toolStripSeparator1";
            this.toolStripSeparator1.Size = new System.Drawing.Size(6, 25);
            // 
            // groupBox4
            // 
            this.groupBox4.Controls.Add(this.trusted);
            this.groupBox4.Location = new System.Drawing.Point(192, 122);
            this.groupBox4.Name = "groupBox4";
            this.groupBox4.Size = new System.Drawing.Size(482, 48);
            this.groupBox4.TabIndex = 39;
            this.groupBox4.TabStop = false;
            this.groupBox4.Text = "Outras opções da conexão";
            // 
            // trusted
            // 
            this.trusted.Appearance = System.Windows.Forms.Appearance.Button;
            this.trusted.AutoSize = true;
            this.trusted.Location = new System.Drawing.Point(334, 19);
            this.trusted.Name = "trusted";
            this.trusted.Size = new System.Drawing.Size(142, 23);
            this.trusted.TabIndex = 6;
            this.trusted.Tag = "";
            this.trusted.Text = "Autenticação do Windows";
            this.trusted.UseVisualStyleBackColor = true;
            this.trusted.CheckedChanged += new System.EventHandler(this.Control_Changed);
            // 
            // groupBox3
            // 
            this.groupBox3.Controls.Add(this.viewpassword);
            this.groupBox3.Controls.Add(this.server);
            this.groupBox3.Controls.Add(this.label10);
            this.groupBox3.Controls.Add(this.bd);
            this.groupBox3.Controls.Add(this.password);
            this.groupBox3.Controls.Add(this.label12);
            this.groupBox3.Controls.Add(this.label13);
            this.groupBox3.Controls.Add(this.label11);
            this.groupBox3.Controls.Add(this.user);
            this.groupBox3.Location = new System.Drawing.Point(192, 6);
            this.groupBox3.Name = "groupBox3";
            this.groupBox3.Size = new System.Drawing.Size(482, 110);
            this.groupBox3.TabIndex = 38;
            this.groupBox3.TabStop = false;
            this.groupBox3.Text = "Dados Conexão Base de Dados";
            // 
            // server
            // 
            this.server.Location = new System.Drawing.Point(9, 38);
            this.server.Name = "server";
            this.server.Size = new System.Drawing.Size(220, 20);
            this.server.TabIndex = 1;
            this.server.Tag = "";
            this.server.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label10
            // 
            this.label10.AutoSize = true;
            this.label10.Location = new System.Drawing.Point(6, 22);
            this.label10.Name = "label10";
            this.label10.Size = new System.Drawing.Size(46, 13);
            this.label10.TabIndex = 29;
            this.label10.Text = "Servidor";
            // 
            // bd
            // 
            this.bd.Location = new System.Drawing.Point(256, 38);
            this.bd.Name = "bd";
            this.bd.Size = new System.Drawing.Size(220, 20);
            this.bd.TabIndex = 2;
            this.bd.Tag = "";
            this.bd.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // password
            // 
            this.password.Location = new System.Drawing.Point(256, 83);
            this.password.Name = "password";
            this.password.Size = new System.Drawing.Size(190, 20);
            this.password.TabIndex = 4;
            this.password.Tag = "";
            this.password.UseSystemPasswordChar = true;
            this.password.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label12
            // 
            this.label12.AutoSize = true;
            this.label12.Location = new System.Drawing.Point(253, 67);
            this.label12.Name = "label12";
            this.label12.Size = new System.Drawing.Size(53, 13);
            this.label12.TabIndex = 33;
            this.label12.Text = "Password";
            // 
            // label13
            // 
            this.label13.AutoSize = true;
            this.label13.Location = new System.Drawing.Point(253, 22);
            this.label13.Name = "label13";
            this.label13.Size = new System.Drawing.Size(78, 13);
            this.label13.TabIndex = 35;
            this.label13.Text = "Base de dados";
            // 
            // label11
            // 
            this.label11.AutoSize = true;
            this.label11.Location = new System.Drawing.Point(6, 67);
            this.label11.Name = "label11";
            this.label11.Size = new System.Drawing.Size(50, 13);
            this.label11.TabIndex = 31;
            this.label11.Text = "Utilizador";
            // 
            // user
            // 
            this.user.Location = new System.Drawing.Point(9, 83);
            this.user.Name = "user";
            this.user.Size = new System.Drawing.Size(220, 20);
            this.user.TabIndex = 3;
            this.user.Tag = "";
            this.user.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // listBox2
            // 
            this.listBox2.ContextMenuStrip = this.contextMenuStrip1;
            this.listBox2.FormattingEnabled = true;
            this.listBox2.Location = new System.Drawing.Point(6, 6);
            this.listBox2.Name = "listBox2";
            this.listBox2.Size = new System.Drawing.Size(180, 576);
            this.listBox2.TabIndex = 23;
            this.listBox2.SelectedIndexChanged += new System.EventHandler(this.listBox_SelectedIndexChanged);
            // 
            // contextMenuStrip1
            // 
            this.contextMenuStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.novaConexãoToolStripMenuItem,
            this.gravarConexãoActivaToolStripMenuItem,
            this.toolStripMenuItem8,
            this.clonarConexãoToolStripMenuItem,
            this.eliminarConexãoToolStripMenuItem,
            this.toolStripMenuItem9,
            this.testarConexãoToolStripMenuItem,
            this.toolStripMenuItem10,
            this.ajudaToolStripMenuItem1});
            this.contextMenuStrip1.Name = "contextMenuStrip1";
            this.contextMenuStrip1.Size = new System.Drawing.Size(165, 154);
            // 
            // novaConexãoToolStripMenuItem
            // 
            this.novaConexãoToolStripMenuItem.Name = "novaConexãoToolStripMenuItem";
            this.novaConexãoToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.novaConexãoToolStripMenuItem.Text = "Nova conexão";
            this.novaConexãoToolStripMenuItem.Click += new System.EventHandler(this.novoObj_Click);
            // 
            // gravarConexãoActivaToolStripMenuItem
            // 
            this.gravarConexãoActivaToolStripMenuItem.Name = "gravarConexãoActivaToolStripMenuItem";
            this.gravarConexãoActivaToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.gravarConexãoActivaToolStripMenuItem.Text = "Gravar";
            this.gravarConexãoActivaToolStripMenuItem.Click += new System.EventHandler(this.guardarToolStripMenuItem_Click);
            // 
            // toolStripMenuItem8
            // 
            this.toolStripMenuItem8.Name = "toolStripMenuItem8";
            this.toolStripMenuItem8.Size = new System.Drawing.Size(161, 6);
            // 
            // clonarConexãoToolStripMenuItem
            // 
            this.clonarConexãoToolStripMenuItem.Name = "clonarConexãoToolStripMenuItem";
            this.clonarConexãoToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.clonarConexãoToolStripMenuItem.Text = "Clonar conexão";
            this.clonarConexãoToolStripMenuItem.Click += new System.EventHandler(this.clonarObj_Click);
            // 
            // eliminarConexãoToolStripMenuItem
            // 
            this.eliminarConexãoToolStripMenuItem.Name = "eliminarConexãoToolStripMenuItem";
            this.eliminarConexãoToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.eliminarConexãoToolStripMenuItem.Text = "Eliminar conexão";
            this.eliminarConexãoToolStripMenuItem.Click += new System.EventHandler(this.apagarObj_Click);
            // 
            // toolStripMenuItem9
            // 
            this.toolStripMenuItem9.Name = "toolStripMenuItem9";
            this.toolStripMenuItem9.Size = new System.Drawing.Size(161, 6);
            // 
            // testarConexãoToolStripMenuItem
            // 
            this.testarConexãoToolStripMenuItem.Name = "testarConexãoToolStripMenuItem";
            this.testarConexãoToolStripMenuItem.Size = new System.Drawing.Size(164, 22);
            this.testarConexãoToolStripMenuItem.Text = "Testar conexão";
            this.testarConexãoToolStripMenuItem.Click += new System.EventHandler(this.testarConexao_Click);
            // 
            // toolStripMenuItem10
            // 
            this.toolStripMenuItem10.Name = "toolStripMenuItem10";
            this.toolStripMenuItem10.Size = new System.Drawing.Size(161, 6);
            // 
            // ajudaToolStripMenuItem1
            // 
            this.ajudaToolStripMenuItem1.Name = "ajudaToolStripMenuItem1";
            this.ajudaToolStripMenuItem1.Size = new System.Drawing.Size(164, 22);
            this.ajudaToolStripMenuItem1.Text = "Ajuda";
            // 
            // tabPage3
            // 
            this.tabPage3.Controls.Add(this.toolStrip2);
            this.tabPage3.Controls.Add(this.listBox3);
            this.tabPage3.Controls.Add(this.groupBox7);
            this.tabPage3.Controls.Add(this.groupBox6);
            this.tabPage3.Controls.Add(this.groupBox5);
            this.tabPage3.Location = new System.Drawing.Point(4, 22);
            this.tabPage3.Name = "tabPage3";
            this.tabPage3.Padding = new System.Windows.Forms.Padding(3);
            this.tabPage3.Size = new System.Drawing.Size(682, 621);
            this.tabPage3.TabIndex = 2;
            this.tabPage3.Text = "Query";
            this.tabPage3.UseVisualStyleBackColor = true;
            // 
            // toolStrip2
            // 
            this.toolStrip2.Dock = System.Windows.Forms.DockStyle.None;
            this.toolStrip2.GripStyle = System.Windows.Forms.ToolStripGripStyle.Hidden;
            this.toolStrip2.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.toolStripButton1,
            this.toolStripButton3,
            this.toolStripSeparator3,
            this.toolStripButton4,
            this.toolStripButton5,
            this.toolStripSeparator4,
            this.toolStripButton6,
            this.toolStripSeparator5,
            this.toolStripButton7});
            this.toolStrip2.Location = new System.Drawing.Point(0, 585);
            this.toolStrip2.Name = "toolStrip2";
            this.toolStrip2.Padding = new System.Windows.Forms.Padding(10, 0, 1, 0);
            this.toolStrip2.Size = new System.Drawing.Size(241, 25);
            this.toolStrip2.TabIndex = 76;
            this.toolStrip2.Text = "toolStrip2";
            // 
            // toolStripSeparator3
            // 
            this.toolStripSeparator3.Name = "toolStripSeparator3";
            this.toolStripSeparator3.Size = new System.Drawing.Size(6, 25);
            // 
            // toolStripSeparator4
            // 
            this.toolStripSeparator4.Name = "toolStripSeparator4";
            this.toolStripSeparator4.Size = new System.Drawing.Size(6, 25);
            // 
            // toolStripSeparator5
            // 
            this.toolStripSeparator5.Name = "toolStripSeparator5";
            this.toolStripSeparator5.Size = new System.Drawing.Size(6, 25);
            // 
            // listBox3
            // 
            this.listBox3.ContextMenuStrip = this.contextMenuStrip2;
            this.listBox3.FormattingEnabled = true;
            this.listBox3.Location = new System.Drawing.Point(6, 6);
            this.listBox3.Name = "listBox3";
            this.listBox3.Size = new System.Drawing.Size(180, 576);
            this.listBox3.TabIndex = 2;
            this.listBox3.SelectedIndexChanged += new System.EventHandler(this.listBox_SelectedIndexChanged);
            // 
            // contextMenuStrip2
            // 
            this.contextMenuStrip2.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.toolStripMenuItem11,
            this.toolStripMenuItem13,
            this.toolStripSeparator8,
            this.toolStripMenuItem14,
            this.toolStripMenuItem15,
            this.toolStripSeparator9,
            this.toolStripMenuItem16,
            this.toolStripSeparator10,
            this.toolStripMenuItem17});
            this.contextMenuStrip2.Name = "contextMenuStrip1";
            this.contextMenuStrip2.Size = new System.Drawing.Size(151, 154);
            // 
            // toolStripMenuItem11
            // 
            this.toolStripMenuItem11.Name = "toolStripMenuItem11";
            this.toolStripMenuItem11.Size = new System.Drawing.Size(150, 22);
            this.toolStripMenuItem11.Text = "Nova query";
            this.toolStripMenuItem11.Click += new System.EventHandler(this.novoObj_Click);
            // 
            // toolStripMenuItem13
            // 
            this.toolStripMenuItem13.Name = "toolStripMenuItem13";
            this.toolStripMenuItem13.Size = new System.Drawing.Size(150, 22);
            this.toolStripMenuItem13.Text = "Gravar";
            this.toolStripMenuItem13.Click += new System.EventHandler(this.guardarToolStripMenuItem_Click);
            // 
            // toolStripSeparator8
            // 
            this.toolStripSeparator8.Name = "toolStripSeparator8";
            this.toolStripSeparator8.Size = new System.Drawing.Size(147, 6);
            // 
            // toolStripMenuItem14
            // 
            this.toolStripMenuItem14.Name = "toolStripMenuItem14";
            this.toolStripMenuItem14.Size = new System.Drawing.Size(150, 22);
            this.toolStripMenuItem14.Text = "Clonar query";
            this.toolStripMenuItem14.Click += new System.EventHandler(this.clonarObj_Click);
            // 
            // toolStripMenuItem15
            // 
            this.toolStripMenuItem15.Name = "toolStripMenuItem15";
            this.toolStripMenuItem15.Size = new System.Drawing.Size(150, 22);
            this.toolStripMenuItem15.Text = "Eliminar query";
            this.toolStripMenuItem15.Click += new System.EventHandler(this.apagarObj_Click);
            // 
            // toolStripSeparator9
            // 
            this.toolStripSeparator9.Name = "toolStripSeparator9";
            this.toolStripSeparator9.Size = new System.Drawing.Size(147, 6);
            // 
            // toolStripMenuItem16
            // 
            this.toolStripMenuItem16.Name = "toolStripMenuItem16";
            this.toolStripMenuItem16.Size = new System.Drawing.Size(150, 22);
            this.toolStripMenuItem16.Text = "Executar SQL";
            this.toolStripMenuItem16.Click += new System.EventHandler(this.executarSql_Click);
            // 
            // toolStripSeparator10
            // 
            this.toolStripSeparator10.Name = "toolStripSeparator10";
            this.toolStripSeparator10.Size = new System.Drawing.Size(147, 6);
            // 
            // toolStripMenuItem17
            // 
            this.toolStripMenuItem17.Name = "toolStripMenuItem17";
            this.toolStripMenuItem17.Size = new System.Drawing.Size(150, 22);
            this.toolStripMenuItem17.Text = "Ajuda";
            // 
            // groupBox7
            // 
            this.groupBox7.Controls.Add(this.escolherficheirosaida);
            this.groupBox7.Controls.Add(this.verficheirosaida);
            this.groupBox7.Controls.Add(this.limparficheirosaida);
            this.groupBox7.Controls.Add(this.activoQuery);
            this.groupBox7.Controls.Add(this.ficheirosaida);
            this.groupBox7.Controls.Add(this.label25);
            this.groupBox7.Location = new System.Drawing.Point(192, 430);
            this.groupBox7.Name = "groupBox7";
            this.groupBox7.Size = new System.Drawing.Size(482, 93);
            this.groupBox7.TabIndex = 75;
            this.groupBox7.TabStop = false;
            this.groupBox7.Text = "Outras opções da query";
            // 
            // activoQuery
            // 
            this.activoQuery.AutoSize = true;
            this.activoQuery.Checked = true;
            this.activoQuery.CheckState = System.Windows.Forms.CheckState.Checked;
            this.activoQuery.Location = new System.Drawing.Point(9, 64);
            this.activoQuery.Name = "activoQuery";
            this.activoQuery.Size = new System.Drawing.Size(56, 17);
            this.activoQuery.TabIndex = 24;
            this.activoQuery.Tag = "activo";
            this.activoQuery.Text = "Activo";
            this.activoQuery.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            this.activoQuery.UseVisualStyleBackColor = true;
            this.activoQuery.CheckedChanged += new System.EventHandler(this.Control_Changed);
            // 
            // ficheirosaida
            // 
            this.ficheirosaida.Location = new System.Drawing.Point(9, 38);
            this.ficheirosaida.Name = "ficheirosaida";
            this.ficheirosaida.Size = new System.Drawing.Size(392, 20);
            this.ficheirosaida.TabIndex = 20;
            this.ficheirosaida.Tag = "";
            this.ficheirosaida.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label25
            // 
            this.label25.AutoSize = true;
            this.label25.Location = new System.Drawing.Point(6, 22);
            this.label25.Name = "label25";
            this.label25.Size = new System.Drawing.Size(89, 13);
            this.label25.TabIndex = 68;
            this.label25.Text = "Ficheiro de saída";
            // 
            // groupBox6
            // 
            this.groupBox6.Controls.Add(this.label9);
            this.groupBox6.Controls.Add(this.val10);
            this.groupBox6.Controls.Add(this.label15);
            this.groupBox6.Controls.Add(this.val9);
            this.groupBox6.Controls.Add(this.label18);
            this.groupBox6.Controls.Add(this.val8);
            this.groupBox6.Controls.Add(this.label19);
            this.groupBox6.Controls.Add(this.val7);
            this.groupBox6.Controls.Add(this.label22);
            this.groupBox6.Controls.Add(this.val6);
            this.groupBox6.Controls.Add(this.label8);
            this.groupBox6.Controls.Add(this.val5);
            this.groupBox6.Controls.Add(this.label7);
            this.groupBox6.Controls.Add(this.val4);
            this.groupBox6.Controls.Add(this.label6);
            this.groupBox6.Controls.Add(this.val3);
            this.groupBox6.Controls.Add(this.label3);
            this.groupBox6.Controls.Add(this.val2);
            this.groupBox6.Controls.Add(this.label2);
            this.groupBox6.Controls.Add(this.val1);
            this.groupBox6.Controls.Add(this.label1);
            this.groupBox6.Controls.Add(this.etiqueta);
            this.groupBox6.Location = new System.Drawing.Point(192, 248);
            this.groupBox6.Name = "groupBox6";
            this.groupBox6.Size = new System.Drawing.Size(482, 176);
            this.groupBox6.TabIndex = 74;
            this.groupBox6.TabStop = false;
            this.groupBox6.Text = "Etiquetas";
            // 
            // label9
            // 
            this.label9.AutoSize = true;
            this.label9.Location = new System.Drawing.Point(253, 152);
            this.label9.Name = "label9";
            this.label9.Size = new System.Drawing.Size(55, 13);
            this.label9.TabIndex = 21;
            this.label9.Text = "Coluna 10";
            // 
            // val10
            // 
            this.val10.Location = new System.Drawing.Point(316, 149);
            this.val10.Name = "val10";
            this.val10.Size = new System.Drawing.Size(160, 20);
            this.val10.TabIndex = 19;
            this.val10.Text = "val10";
            this.val10.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label15
            // 
            this.label15.AutoSize = true;
            this.label15.Location = new System.Drawing.Point(253, 126);
            this.label15.Name = "label15";
            this.label15.Size = new System.Drawing.Size(49, 13);
            this.label15.TabIndex = 19;
            this.label15.Text = "Coluna 9";
            // 
            // val9
            // 
            this.val9.Location = new System.Drawing.Point(316, 123);
            this.val9.Name = "val9";
            this.val9.Size = new System.Drawing.Size(160, 20);
            this.val9.TabIndex = 18;
            this.val9.Text = "val9";
            this.val9.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label18
            // 
            this.label18.AutoSize = true;
            this.label18.Location = new System.Drawing.Point(253, 100);
            this.label18.Name = "label18";
            this.label18.Size = new System.Drawing.Size(49, 13);
            this.label18.TabIndex = 17;
            this.label18.Text = "Coluna 8";
            // 
            // val8
            // 
            this.val8.Location = new System.Drawing.Point(316, 97);
            this.val8.Name = "val8";
            this.val8.Size = new System.Drawing.Size(160, 20);
            this.val8.TabIndex = 17;
            this.val8.Text = "val8";
            this.val8.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label19
            // 
            this.label19.AutoSize = true;
            this.label19.Location = new System.Drawing.Point(253, 74);
            this.label19.Name = "label19";
            this.label19.Size = new System.Drawing.Size(49, 13);
            this.label19.TabIndex = 15;
            this.label19.Text = "Coluna 7";
            // 
            // val7
            // 
            this.val7.Location = new System.Drawing.Point(316, 71);
            this.val7.Name = "val7";
            this.val7.Size = new System.Drawing.Size(160, 20);
            this.val7.TabIndex = 16;
            this.val7.Text = "val7";
            this.val7.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label22
            // 
            this.label22.AutoSize = true;
            this.label22.Location = new System.Drawing.Point(253, 48);
            this.label22.Name = "label22";
            this.label22.Size = new System.Drawing.Size(49, 13);
            this.label22.TabIndex = 13;
            this.label22.Text = "Coluna 6";
            // 
            // val6
            // 
            this.val6.Location = new System.Drawing.Point(316, 45);
            this.val6.Name = "val6";
            this.val6.Size = new System.Drawing.Size(160, 20);
            this.val6.TabIndex = 15;
            this.val6.Text = "val6";
            this.val6.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label8
            // 
            this.label8.AutoSize = true;
            this.label8.Location = new System.Drawing.Point(6, 152);
            this.label8.Name = "label8";
            this.label8.Size = new System.Drawing.Size(49, 13);
            this.label8.TabIndex = 11;
            this.label8.Text = "Coluna 5";
            // 
            // val5
            // 
            this.val5.Location = new System.Drawing.Point(69, 149);
            this.val5.Name = "val5";
            this.val5.Size = new System.Drawing.Size(160, 20);
            this.val5.TabIndex = 14;
            this.val5.Text = "val5";
            this.val5.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label7
            // 
            this.label7.AutoSize = true;
            this.label7.Location = new System.Drawing.Point(6, 126);
            this.label7.Name = "label7";
            this.label7.Size = new System.Drawing.Size(49, 13);
            this.label7.TabIndex = 9;
            this.label7.Text = "Coluna 4";
            // 
            // val4
            // 
            this.val4.Location = new System.Drawing.Point(69, 123);
            this.val4.Name = "val4";
            this.val4.Size = new System.Drawing.Size(160, 20);
            this.val4.TabIndex = 13;
            this.val4.Text = "val4";
            this.val4.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label6
            // 
            this.label6.AutoSize = true;
            this.label6.Location = new System.Drawing.Point(6, 100);
            this.label6.Name = "label6";
            this.label6.Size = new System.Drawing.Size(49, 13);
            this.label6.TabIndex = 7;
            this.label6.Text = "Coluna 3";
            // 
            // val3
            // 
            this.val3.Location = new System.Drawing.Point(69, 97);
            this.val3.Name = "val3";
            this.val3.Size = new System.Drawing.Size(160, 20);
            this.val3.TabIndex = 12;
            this.val3.Text = "val3";
            this.val3.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(6, 74);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(49, 13);
            this.label3.TabIndex = 5;
            this.label3.Text = "Coluna 2";
            // 
            // val2
            // 
            this.val2.Location = new System.Drawing.Point(69, 71);
            this.val2.Name = "val2";
            this.val2.Size = new System.Drawing.Size(160, 20);
            this.val2.TabIndex = 11;
            this.val2.Text = "val2";
            this.val2.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(6, 48);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(49, 13);
            this.label2.TabIndex = 3;
            this.label2.Text = "Coluna 1";
            // 
            // val1
            // 
            this.val1.Location = new System.Drawing.Point(69, 45);
            this.val1.Name = "val1";
            this.val1.Size = new System.Drawing.Size(160, 20);
            this.val1.TabIndex = 10;
            this.val1.Text = "val1";
            this.val1.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(6, 22);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(47, 13);
            this.label1.TabIndex = 1;
            this.label1.Text = "Principal";
            // 
            // etiqueta
            // 
            this.etiqueta.Location = new System.Drawing.Point(69, 19);
            this.etiqueta.Name = "etiqueta";
            this.etiqueta.Size = new System.Drawing.Size(160, 20);
            this.etiqueta.TabIndex = 9;
            this.etiqueta.Text = "val";
            this.etiqueta.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // groupBox5
            // 
            this.groupBox5.Controls.Add(this.resultadoQuery);
            this.groupBox5.Controls.Add(this.label33);
            this.groupBox5.Controls.Add(this.conexao);
            this.groupBox5.Controls.Add(this.label27);
            this.groupBox5.Controls.Add(this.label16);
            this.groupBox5.Controls.Add(this.sql);
            this.groupBox5.Controls.Add(this.label17);
            this.groupBox5.Controls.Add(this.destinoidQuery);
            this.groupBox5.Controls.Add(this.label26);
            this.groupBox5.Controls.Add(this.label14);
            this.groupBox5.Controls.Add(this.destinoQuery);
            this.groupBox5.Controls.Add(this.intervaloQuery);
            this.groupBox5.Location = new System.Drawing.Point(192, 6);
            this.groupBox5.Name = "groupBox5";
            this.groupBox5.Size = new System.Drawing.Size(482, 236);
            this.groupBox5.TabIndex = 73;
            this.groupBox5.TabStop = false;
            this.groupBox5.Text = "Recolha de dados";
            // 
            // resultadoQuery
            // 
            this.resultadoQuery.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.resultadoQuery.FormattingEnabled = true;
            this.resultadoQuery.Items.AddRange(new object[] {
            "Apenas um registo",
            "Vários registos"});
            this.resultadoQuery.Location = new System.Drawing.Point(9, 208);
            this.resultadoQuery.Name = "resultadoQuery";
            this.resultadoQuery.Size = new System.Drawing.Size(220, 21);
            this.resultadoQuery.TabIndex = 6;
            this.resultadoQuery.SelectedIndexChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label33
            // 
            this.label33.AutoSize = true;
            this.label33.Location = new System.Drawing.Point(6, 192);
            this.label33.Name = "label33";
            this.label33.Size = new System.Drawing.Size(55, 13);
            this.label33.TabIndex = 73;
            this.label33.Text = "Resultado";
            // 
            // conexao
            // 
            this.conexao.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.conexao.FormattingEnabled = true;
            this.conexao.Location = new System.Drawing.Point(9, 38);
            this.conexao.Name = "conexao";
            this.conexao.Size = new System.Drawing.Size(220, 21);
            this.conexao.TabIndex = 3;
            this.conexao.Tag = "";
            this.conexao.SelectedIndexChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label27
            // 
            this.label27.AutoSize = true;
            this.label27.Location = new System.Drawing.Point(368, 192);
            this.label27.Name = "label27";
            this.label27.Size = new System.Drawing.Size(70, 13);
            this.label27.TabIndex = 72;
            this.label27.Text = "ID de destino";
            // 
            // label16
            // 
            this.label16.AutoSize = true;
            this.label16.Location = new System.Drawing.Point(6, 22);
            this.label16.Name = "label16";
            this.label16.Size = new System.Drawing.Size(49, 13);
            this.label16.TabIndex = 60;
            this.label16.Text = "Conexão";
            // 
            // sql
            // 
            this.sql.Font = new System.Drawing.Font("Courier New", 8.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.sql.Location = new System.Drawing.Point(9, 83);
            this.sql.Multiline = true;
            this.sql.Name = "sql";
            this.sql.ScrollBars = System.Windows.Forms.ScrollBars.Both;
            this.sql.Size = new System.Drawing.Size(467, 100);
            this.sql.TabIndex = 5;
            this.sql.Tag = "";
            this.sql.WordWrap = false;
            this.sql.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label17
            // 
            this.label17.AutoSize = true;
            this.label17.Location = new System.Drawing.Point(6, 67);
            this.label17.Name = "label17";
            this.label17.Size = new System.Drawing.Size(28, 13);
            this.label17.TabIndex = 62;
            this.label17.Text = "SQL";
            // 
            // destinoidQuery
            // 
            this.destinoidQuery.Location = new System.Drawing.Point(371, 208);
            this.destinoidQuery.Name = "destinoidQuery";
            this.destinoidQuery.Size = new System.Drawing.Size(105, 20);
            this.destinoidQuery.TabIndex = 8;
            this.destinoidQuery.Tag = "";
            this.destinoidQuery.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // label26
            // 
            this.label26.AutoSize = true;
            this.label26.Location = new System.Drawing.Point(253, 192);
            this.label26.Name = "label26";
            this.label26.Size = new System.Drawing.Size(80, 13);
            this.label26.TabIndex = 70;
            this.label26.Text = "Tipo de destino";
            // 
            // label14
            // 
            this.label14.AutoSize = true;
            this.label14.Location = new System.Drawing.Point(253, 22);
            this.label14.Name = "label14";
            this.label14.Size = new System.Drawing.Size(104, 13);
            this.label14.TabIndex = 58;
            this.label14.Text = "Intervalo em minutos";
            // 
            // destinoQuery
            // 
            this.destinoQuery.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.destinoQuery.FormattingEnabled = true;
            this.destinoQuery.Items.AddRange(new object[] {
            "Widget ID",
            "Slot"});
            this.destinoQuery.Location = new System.Drawing.Point(256, 208);
            this.destinoQuery.Name = "destinoQuery";
            this.destinoQuery.Size = new System.Drawing.Size(105, 21);
            this.destinoQuery.TabIndex = 7;
            this.destinoQuery.Tag = "";
            this.destinoQuery.SelectedIndexChanged += new System.EventHandler(this.Control_Changed);
            // 
            // intervaloQuery
            // 
            this.intervaloQuery.Location = new System.Drawing.Point(256, 38);
            this.intervaloQuery.Name = "intervaloQuery";
            this.intervaloQuery.Size = new System.Drawing.Size(220, 20);
            this.intervaloQuery.TabIndex = 4;
            this.intervaloQuery.Tag = "";
            this.intervaloQuery.Text = "15";
            this.intervaloQuery.TextChanged += new System.EventHandler(this.Control_Changed);
            // 
            // contextMenuStrip3
            // 
            this.contextMenuStrip3.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.toolStripMenuItem18,
            this.toolStripMenuItem20,
            this.toolStripSeparator11,
            this.toolStripMenuItem21,
            this.toolStripMenuItem22,
            this.toolStripSeparator12,
            this.toolStripMenuItem24});
            this.contextMenuStrip3.Name = "contextMenuStrip1";
            this.contextMenuStrip3.Size = new System.Drawing.Size(198, 126);
            // 
            // toolStripMenuItem18
            // 
            this.toolStripMenuItem18.Name = "toolStripMenuItem18";
            this.toolStripMenuItem18.Size = new System.Drawing.Size(197, 22);
            this.toolStripMenuItem18.Text = "Novo ficheiro de dados";
            this.toolStripMenuItem18.Click += new System.EventHandler(this.novoObj_Click);
            // 
            // toolStripMenuItem20
            // 
            this.toolStripMenuItem20.Name = "toolStripMenuItem20";
            this.toolStripMenuItem20.Size = new System.Drawing.Size(197, 22);
            this.toolStripMenuItem20.Text = "Gravar";
            this.toolStripMenuItem20.Click += new System.EventHandler(this.guardarToolStripMenuItem_Click);
            // 
            // toolStripSeparator11
            // 
            this.toolStripSeparator11.Name = "toolStripSeparator11";
            this.toolStripSeparator11.Size = new System.Drawing.Size(194, 6);
            // 
            // toolStripMenuItem21
            // 
            this.toolStripMenuItem21.Name = "toolStripMenuItem21";
            this.toolStripMenuItem21.Size = new System.Drawing.Size(197, 22);
            this.toolStripMenuItem21.Text = "Clonar ficheiro";
            this.toolStripMenuItem21.Click += new System.EventHandler(this.clonarObj_Click);
            // 
            // toolStripMenuItem22
            // 
            this.toolStripMenuItem22.Name = "toolStripMenuItem22";
            this.toolStripMenuItem22.Size = new System.Drawing.Size(197, 22);
            this.toolStripMenuItem22.Text = "Eliminar ficheiro";
            this.toolStripMenuItem22.Click += new System.EventHandler(this.apagarObj_Click);
            // 
            // toolStripSeparator12
            // 
            this.toolStripSeparator12.Name = "toolStripSeparator12";
            this.toolStripSeparator12.Size = new System.Drawing.Size(194, 6);
            // 
            // toolStripMenuItem24
            // 
            this.toolStripMenuItem24.Name = "toolStripMenuItem24";
            this.toolStripMenuItem24.Size = new System.Drawing.Size(197, 22);
            this.toolStripMenuItem24.Text = "Ajuda";
            // 
            // contextMenuStrip4
            // 
            this.contextMenuStrip4.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.toolStripMenuItem23,
            this.toolStripMenuItem26,
            this.toolStripSeparator15,
            this.toolStripMenuItem27,
            this.toolStripMenuItem28,
            this.toolStripSeparator16,
            this.toolStripMenuItem29});
            this.contextMenuStrip4.Name = "contextMenuStrip1";
            this.contextMenuStrip4.Size = new System.Drawing.Size(198, 126);
            // 
            // toolStripMenuItem23
            // 
            this.toolStripMenuItem23.Name = "toolStripMenuItem23";
            this.toolStripMenuItem23.Size = new System.Drawing.Size(197, 22);
            this.toolStripMenuItem23.Text = "Novo ficheiro de dados";
            this.toolStripMenuItem23.Click += new System.EventHandler(this.novoObj_Click);
            // 
            // toolStripMenuItem26
            // 
            this.toolStripMenuItem26.Name = "toolStripMenuItem26";
            this.toolStripMenuItem26.Size = new System.Drawing.Size(197, 22);
            this.toolStripMenuItem26.Text = "Gravar";
            this.toolStripMenuItem26.Click += new System.EventHandler(this.guardarToolStripMenuItem_Click);
            // 
            // toolStripSeparator15
            // 
            this.toolStripSeparator15.Name = "toolStripSeparator15";
            this.toolStripSeparator15.Size = new System.Drawing.Size(194, 6);
            // 
            // toolStripMenuItem27
            // 
            this.toolStripMenuItem27.Name = "toolStripMenuItem27";
            this.toolStripMenuItem27.Size = new System.Drawing.Size(197, 22);
            this.toolStripMenuItem27.Text = "Clonar ficheiro";
            this.toolStripMenuItem27.Click += new System.EventHandler(this.clonarObj_Click);
            // 
            // toolStripMenuItem28
            // 
            this.toolStripMenuItem28.Name = "toolStripMenuItem28";
            this.toolStripMenuItem28.Size = new System.Drawing.Size(197, 22);
            this.toolStripMenuItem28.Text = "Eliminar ficheiro";
            this.toolStripMenuItem28.Click += new System.EventHandler(this.apagarObj_Click);
            // 
            // toolStripSeparator16
            // 
            this.toolStripSeparator16.Name = "toolStripSeparator16";
            this.toolStripSeparator16.Size = new System.Drawing.Size(194, 6);
            // 
            // toolStripMenuItem29
            // 
            this.toolStripMenuItem29.Name = "toolStripMenuItem29";
            this.toolStripMenuItem29.Size = new System.Drawing.Size(197, 22);
            this.toolStripMenuItem29.Text = "Ajuda";
            // 
            // backgroundWorker1
            // 
            this.backgroundWorker1.DoWork += new System.ComponentModel.DoWorkEventHandler(this.backgroundWorker1_DoWork);
            this.backgroundWorker1.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this.backgroundWorker1_RunWorkerCompleted);
            // 
            // backgroundWorker2
            // 
            this.backgroundWorker2.DoWork += new System.ComponentModel.DoWorkEventHandler(this.backgroundWorker2_DoWork);
            this.backgroundWorker2.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this.backgroundWorker2_RunWorkerCompleted);
            // 
            // toolStripSeparator13
            // 
            this.toolStripSeparator13.Name = "toolStripSeparator13";
            this.toolStripSeparator13.Size = new System.Drawing.Size(6, 25);
            // 
            // toolStripSeparator14
            // 
            this.toolStripSeparator14.Name = "toolStripSeparator14";
            this.toolStripSeparator14.Size = new System.Drawing.Size(6, 25);
            // 
            // newToolStripButton
            // 
            this.newToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.newToolStripButton.Image = ((System.Drawing.Image)(resources.GetObject("newToolStripButton.Image")));
            this.newToolStripButton.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.newToolStripButton.Name = "newToolStripButton";
            this.newToolStripButton.Size = new System.Drawing.Size(23, 22);
            this.newToolStripButton.Text = "Nova conexão";
            this.newToolStripButton.Click += new System.EventHandler(this.novoObj_Click);
            // 
            // saveToolStripButton
            // 
            this.saveToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.saveToolStripButton.Image = ((System.Drawing.Image)(resources.GetObject("saveToolStripButton.Image")));
            this.saveToolStripButton.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.saveToolStripButton.Name = "saveToolStripButton";
            this.saveToolStripButton.Size = new System.Drawing.Size(23, 22);
            this.saveToolStripButton.Text = "Gravar";
            this.saveToolStripButton.Click += new System.EventHandler(this.guardarToolStripMenuItem_Click);
            // 
            // cutToolStripButton
            // 
            this.cutToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.cutToolStripButton.Image = ((System.Drawing.Image)(resources.GetObject("cutToolStripButton.Image")));
            this.cutToolStripButton.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.cutToolStripButton.Name = "cutToolStripButton";
            this.cutToolStripButton.Size = new System.Drawing.Size(23, 22);
            this.cutToolStripButton.Text = "Clonar conexão";
            this.cutToolStripButton.Click += new System.EventHandler(this.clonarObj_Click);
            // 
            // copyToolStripButton
            // 
            this.copyToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.copyToolStripButton.Image = ((System.Drawing.Image)(resources.GetObject("copyToolStripButton.Image")));
            this.copyToolStripButton.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.copyToolStripButton.Name = "copyToolStripButton";
            this.copyToolStripButton.Size = new System.Drawing.Size(23, 22);
            this.copyToolStripButton.Text = "Eliminar conexão";
            this.copyToolStripButton.Click += new System.EventHandler(this.apagarObj_Click);
            // 
            // pasteToolStripButton
            // 
            this.pasteToolStripButton.Image = ((System.Drawing.Image)(resources.GetObject("pasteToolStripButton.Image")));
            this.pasteToolStripButton.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.pasteToolStripButton.Name = "pasteToolStripButton";
            this.pasteToolStripButton.Size = new System.Drawing.Size(106, 22);
            this.pasteToolStripButton.Text = "Testar conexão";
            this.pasteToolStripButton.Click += new System.EventHandler(this.testarConexao_Click);
            // 
            // helpToolStripButton
            // 
            this.helpToolStripButton.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.helpToolStripButton.Image = ((System.Drawing.Image)(resources.GetObject("helpToolStripButton.Image")));
            this.helpToolStripButton.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.helpToolStripButton.Name = "helpToolStripButton";
            this.helpToolStripButton.Size = new System.Drawing.Size(23, 22);
            this.helpToolStripButton.Text = "Ajuda";
            this.helpToolStripButton.Click += new System.EventHandler(this.helpToolStripButton_Click);
            // 
            // viewpassword
            // 
            this.viewpassword.BackgroundImage = ((System.Drawing.Image)(resources.GetObject("viewpassword.BackgroundImage")));
            this.viewpassword.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Center;
            this.viewpassword.Location = new System.Drawing.Point(452, 81);
            this.viewpassword.Name = "viewpassword";
            this.viewpassword.Size = new System.Drawing.Size(24, 24);
            this.viewpassword.TabIndex = 5;
            this.toolTip1.SetToolTip(this.viewpassword, "Ver password");
            this.viewpassword.UseVisualStyleBackColor = true;
            this.viewpassword.MouseDown += new System.Windows.Forms.MouseEventHandler(this.viewpassword_MouseDown);
            this.viewpassword.MouseUp += new System.Windows.Forms.MouseEventHandler(this.viewpassword_MouseUp);
            // 
            // toolStripButton1
            // 
            this.toolStripButton1.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton1.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton1.Image")));
            this.toolStripButton1.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton1.Name = "toolStripButton1";
            this.toolStripButton1.Size = new System.Drawing.Size(23, 22);
            this.toolStripButton1.Text = "Nova query";
            this.toolStripButton1.Click += new System.EventHandler(this.novoObj_Click);
            // 
            // toolStripButton3
            // 
            this.toolStripButton3.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton3.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton3.Image")));
            this.toolStripButton3.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton3.Name = "toolStripButton3";
            this.toolStripButton3.Size = new System.Drawing.Size(23, 22);
            this.toolStripButton3.Text = "Gravar";
            this.toolStripButton3.Click += new System.EventHandler(this.guardarToolStripMenuItem_Click);
            // 
            // toolStripButton4
            // 
            this.toolStripButton4.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton4.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton4.Image")));
            this.toolStripButton4.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton4.Name = "toolStripButton4";
            this.toolStripButton4.Size = new System.Drawing.Size(23, 22);
            this.toolStripButton4.Text = "Clonar query";
            this.toolStripButton4.Click += new System.EventHandler(this.clonarObj_Click);
            // 
            // toolStripButton5
            // 
            this.toolStripButton5.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton5.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton5.Image")));
            this.toolStripButton5.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton5.Name = "toolStripButton5";
            this.toolStripButton5.Size = new System.Drawing.Size(23, 22);
            this.toolStripButton5.Text = "Eliminar query";
            this.toolStripButton5.Click += new System.EventHandler(this.apagarObj_Click);
            // 
            // toolStripButton6
            // 
            this.toolStripButton6.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton6.Image")));
            this.toolStripButton6.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton6.Name = "toolStripButton6";
            this.toolStripButton6.Size = new System.Drawing.Size(95, 22);
            this.toolStripButton6.Text = "Executar SQL";
            this.toolStripButton6.Click += new System.EventHandler(this.executarSql_Click);
            // 
            // toolStripButton7
            // 
            this.toolStripButton7.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton7.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton7.Image")));
            this.toolStripButton7.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton7.Name = "toolStripButton7";
            this.toolStripButton7.Size = new System.Drawing.Size(23, 22);
            this.toolStripButton7.Text = "Ajuda";
            this.toolStripButton7.Click += new System.EventHandler(this.toolStripButton7_Click);
            // 
            // escolherficheirosaida
            // 
            this.escolherficheirosaida.BackgroundImage = ((System.Drawing.Image)(resources.GetObject("escolherficheirosaida.BackgroundImage")));
            this.escolherficheirosaida.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Center;
            this.escolherficheirosaida.Location = new System.Drawing.Point(404, 35);
            this.escolherficheirosaida.Margin = new System.Windows.Forms.Padding(0);
            this.escolherficheirosaida.Name = "escolherficheirosaida";
            this.escolherficheirosaida.Size = new System.Drawing.Size(24, 24);
            this.escolherficheirosaida.TabIndex = 21;
            this.toolTip1.SetToolTip(this.escolherficheirosaida, "Escolher um ficheiro de saída");
            this.escolherficheirosaida.UseVisualStyleBackColor = true;
            this.escolherficheirosaida.Click += new System.EventHandler(this.escolherficheiro_Click);
            // 
            // verficheirosaida
            // 
            this.verficheirosaida.BackgroundImage = ((System.Drawing.Image)(resources.GetObject("verficheirosaida.BackgroundImage")));
            this.verficheirosaida.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Center;
            this.verficheirosaida.Location = new System.Drawing.Point(428, 35);
            this.verficheirosaida.Margin = new System.Windows.Forms.Padding(0);
            this.verficheirosaida.Name = "verficheirosaida";
            this.verficheirosaida.Size = new System.Drawing.Size(24, 24);
            this.verficheirosaida.TabIndex = 22;
            this.toolTip1.SetToolTip(this.verficheirosaida, "Abrir o ficheiro de saída");
            this.verficheirosaida.UseVisualStyleBackColor = true;
            this.verficheirosaida.Click += new System.EventHandler(this.verficheiro_Click);
            // 
            // limparficheirosaida
            // 
            this.limparficheirosaida.BackgroundImage = ((System.Drawing.Image)(resources.GetObject("limparficheirosaida.BackgroundImage")));
            this.limparficheirosaida.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Center;
            this.limparficheirosaida.Location = new System.Drawing.Point(452, 35);
            this.limparficheirosaida.Margin = new System.Windows.Forms.Padding(0);
            this.limparficheirosaida.Name = "limparficheirosaida";
            this.limparficheirosaida.Size = new System.Drawing.Size(24, 24);
            this.limparficheirosaida.TabIndex = 23;
            this.toolTip1.SetToolTip(this.limparficheirosaida, "Apagar dados do ficheiro de saída");
            this.limparficheirosaida.UseVisualStyleBackColor = true;
            this.limparficheirosaida.Click += new System.EventHandler(this.limparficheiro_Click);
            // 
            // toolStripButton13
            // 
            this.toolStripButton13.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton13.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton13.Image")));
            this.toolStripButton13.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton13.Name = "toolStripButton13";
            this.toolStripButton13.Size = new System.Drawing.Size(23, 22);
            this.toolStripButton13.Text = "Novo ficheiro de dados";
            this.toolStripButton13.Click += new System.EventHandler(this.novoObj_Click);
            // 
            // toolStripButton16
            // 
            this.toolStripButton16.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton16.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton16.Image")));
            this.toolStripButton16.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton16.Name = "toolStripButton16";
            this.toolStripButton16.Size = new System.Drawing.Size(23, 22);
            this.toolStripButton16.Text = "Gravar";
            this.toolStripButton16.Click += new System.EventHandler(this.guardarToolStripMenuItem_Click);
            // 
            // toolStripButton17
            // 
            this.toolStripButton17.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton17.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton17.Image")));
            this.toolStripButton17.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton17.Name = "toolStripButton17";
            this.toolStripButton17.Size = new System.Drawing.Size(23, 22);
            this.toolStripButton17.Text = "Clonar ficheiro";
            this.toolStripButton17.Click += new System.EventHandler(this.clonarObj_Click);
            // 
            // toolStripButton18
            // 
            this.toolStripButton18.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton18.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton18.Image")));
            this.toolStripButton18.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton18.Name = "toolStripButton18";
            this.toolStripButton18.Size = new System.Drawing.Size(23, 22);
            this.toolStripButton18.Text = "Eliminar ficheiro";
            this.toolStripButton18.Click += new System.EventHandler(this.apagarObj_Click);
            // 
            // toolStripButton19
            // 
            this.toolStripButton19.DisplayStyle = System.Windows.Forms.ToolStripItemDisplayStyle.Image;
            this.toolStripButton19.Image = ((System.Drawing.Image)(resources.GetObject("toolStripButton19.Image")));
            this.toolStripButton19.ImageTransparentColor = System.Drawing.Color.Magenta;
            this.toolStripButton19.Name = "toolStripButton19";
            this.toolStripButton19.Size = new System.Drawing.Size(23, 22);
            this.toolStripButton19.Text = "Ajuda";
            this.toolStripButton19.Click += new System.EventHandler(this.toolStripButton19_Click);
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.SystemColors.Window;
            this.BackgroundImageLayout = System.Windows.Forms.ImageLayout.None;
            this.ClientSize = new System.Drawing.Size(684, 662);
            this.Controls.Add(this.menuStrip1);
            this.Controls.Add(this.tabControl1);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.MainMenuStrip = this.menuStrip1;
            this.MaximizeBox = false;
            this.MaximumSize = new System.Drawing.Size(700, 700);
            this.MinimumSize = new System.Drawing.Size(700, 700);
            this.Name = "Form1";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Sincronizador de Dados";
            this.FormClosing += new System.Windows.Forms.FormClosingEventHandler(this.Form1_FormClosing);
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.Form1_FormClosed);
            this.Load += new System.EventHandler(this.Form1_Load);
            this.menuStrip1.ResumeLayout(false);
            this.menuStrip1.PerformLayout();
            this.tabControl1.ResumeLayout(false);
            this.tabPage1.ResumeLayout(false);
            this.groupBox2.ResumeLayout(false);
            this.groupBox2.PerformLayout();
            this.groupBox1.ResumeLayout(false);
            this.groupBox1.PerformLayout();
            this.tabPage2.ResumeLayout(false);
            this.tabPage2.PerformLayout();
            this.toolStrip1.ResumeLayout(false);
            this.toolStrip1.PerformLayout();
            this.groupBox4.ResumeLayout(false);
            this.groupBox4.PerformLayout();
            this.groupBox3.ResumeLayout(false);
            this.groupBox3.PerformLayout();
            this.contextMenuStrip1.ResumeLayout(false);
            this.tabPage3.ResumeLayout(false);
            this.tabPage3.PerformLayout();
            this.toolStrip2.ResumeLayout(false);
            this.toolStrip2.PerformLayout();
            this.contextMenuStrip2.ResumeLayout(false);
            this.groupBox7.ResumeLayout(false);
            this.groupBox7.PerformLayout();
            this.groupBox6.ResumeLayout(false);
            this.groupBox6.PerformLayout();
            this.groupBox5.ResumeLayout(false);
            this.groupBox5.PerformLayout();
            this.contextMenuStrip3.ResumeLayout(false);
            this.contextMenuStrip4.ResumeLayout(false);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private MenuStrip menuStrip1;
        private ToolStripMenuItem configuraçãoToolStripMenuItem;
        private ToolStripMenuItem novaToolStripMenuItem;
        private ToolStripMenuItem abrirToolStripMenuItem;
        private ToolStripMenuItem guardarToolStripMenuItem;
        private ToolStripMenuItem guardarComoToolStripMenuItem;
        private ToolStripMenuItem apagarToolStripMenuItem;
        private ToolStripSeparator toolStripMenuItem1;
        private ToolStripMenuItem serviçoWindowsToolStripMenuItem;
        private ToolStripMenuItem iniciarToolStripMenuItem;
        private ToolStripMenuItem pararToolStripMenuItem;
        private ToolStripSeparator toolStripMenuItem2;
        private ToolStripMenuItem estadoToolStripMenuItem;
        private ToolStripSeparator toolStripMenuItem3;
        private ToolStripMenuItem instalarToolStripMenuItem;
        private ToolStripMenuItem desinstalarToolStripMenuItem;
        private ToolStripSeparator toolStripMenuItem4;
        private ToolStripMenuItem logToolStripMenuItem;
        private ToolStripMenuItem abrirToolStripMenuItem1;
        private ToolStripMenuItem limparToolStripMenuItem;
        private ToolStripSeparator toolStripMenuItem5;
        private ToolStripMenuItem propriedadesToolStripMenuItem;
        private ToolStripSeparator toolStripMenuItem6;
        private ToolStripMenuItem sairToolStripMenuItem;
        private ToolStripMenuItem ajudaToolStripMenuItem;
        private ToolStripMenuItem sobreToolStripMenuItem;
        private ToolStripMenuItem informaçãoDeSuporteToolStripMenuItem;
        private ToolStripSeparator toolStripMenuItem7;
        private ToolStripMenuItem sobreOSincronizadorDeDadosToolStripMenuItem;
        private TabControl tabControl1;
        private TabPage tabPage1;
        private TabPage tabPage2;
        private TabPage tabPage3;
        private ListBox listBox1;
        private CheckBox debug;
        private Label label5;
        private TextBox key;
        private Label label4;
        private TextBox hash;
        private CheckBox trusted;
        private Label label13;
        private TextBox bd;
        private Label label12;
        private TextBox password;
        private Label label11;
        private TextBox user;
        private Label label10;
        private TextBox server;
        private ListBox listBox2;
        private Label label27;
        private TextBox destinoidQuery;
        private Label label26;
        private ComboBox destinoQuery;
        private Label label25;
        private TextBox ficheirosaida;
        private Label label17;
        private TextBox sql;
        private Label label16;
        private ComboBox conexao;
        private Label label14;
        private TextBox intervaloQuery;
        private CheckBox activoQuery;
        private ListBox listBox3;
        private GroupBox groupBox1;
        private GroupBox groupBox2;
        private GroupBox groupBox3;
        private Button viewpassword;
        private GroupBox groupBox4;
        private ContextMenuStrip contextMenuStrip1;
        private ToolStripMenuItem novaConexãoToolStripMenuItem;
        private ToolStripMenuItem gravarConexãoActivaToolStripMenuItem;
        private ToolStripSeparator toolStripMenuItem8;
        private ToolStripMenuItem clonarConexãoToolStripMenuItem;
        private ToolStripMenuItem eliminarConexãoToolStripMenuItem;
        private ToolStripSeparator toolStripMenuItem9;
        private ToolStripMenuItem testarConexãoToolStripMenuItem;
        private ToolStripSeparator toolStripMenuItem10;
        private ToolStripMenuItem ajudaToolStripMenuItem1;
        private GroupBox groupBox5;
        private GroupBox groupBox6;
        private Label label1;
        private TextBox etiqueta;
        private Label label9;
        private TextBox val10;
        private Label label15;
        private TextBox val9;
        private Label label18;
        private TextBox val8;
        private Label label19;
        private TextBox val7;
        private Label label22;
        private TextBox val6;
        private Label label8;
        private TextBox val5;
        private Label label7;
        private TextBox val4;
        private Label label6;
        private TextBox val3;
        private Label label3;
        private TextBox val2;
        private Label label2;
        private TextBox val1;
        private GroupBox groupBox7;
        private Button escolherficheirosaida;
        private Button verficheirosaida;
        private Button limparficheirosaida;
        private ToolStrip toolStrip1;
        private ToolStripButton newToolStripButton;
        private ToolStripButton saveToolStripButton;
        private ToolStripSeparator toolStripSeparator;
        private ToolStripButton cutToolStripButton;
        private ToolStripButton copyToolStripButton;
        private ToolStripSeparator toolStripSeparator2;
        private ToolStripButton pasteToolStripButton;
        private ToolStripSeparator toolStripSeparator1;
        private ToolStripButton helpToolStripButton;
        private ToolStrip toolStrip2;
        private ToolStripButton toolStripButton1;
        private ToolStripButton toolStripButton3;
        private ToolStripSeparator toolStripSeparator3;
        private ToolStripButton toolStripButton4;
        private ToolStripButton toolStripButton5;
        private ToolStripSeparator toolStripSeparator4;
        private ToolStripButton toolStripButton6;
        private ToolStripSeparator toolStripSeparator5;
        private ToolStripButton toolStripButton7;
        private ContextMenuStrip contextMenuStrip2;
        private ToolStripMenuItem toolStripMenuItem11;
        private ToolStripMenuItem toolStripMenuItem13;
        private ToolStripSeparator toolStripSeparator8;
        private ToolStripMenuItem toolStripMenuItem14;
        private ToolStripMenuItem toolStripMenuItem15;
        private ToolStripSeparator toolStripSeparator9;
        private ToolStripMenuItem toolStripMenuItem16;
        private ToolStripSeparator toolStripSeparator10;
        private ToolStripMenuItem toolStripMenuItem17;
        private ContextMenuStrip contextMenuStrip3;
        private ToolStripMenuItem toolStripMenuItem18;
        private ToolStripMenuItem toolStripMenuItem20;
        private ToolStripSeparator toolStripSeparator11;
        private ToolStripMenuItem toolStripMenuItem21;
        private ToolStripMenuItem toolStripMenuItem22;
        private ToolStripSeparator toolStripSeparator12;
        private ToolStripMenuItem toolStripMenuItem24;
        private ToolTip toolTip1;
        private ContextMenuStrip contextMenuStrip4;
        private ToolStripMenuItem toolStripMenuItem23;
        private ToolStripMenuItem toolStripMenuItem26;
        private ToolStripSeparator toolStripSeparator15;
        private ToolStripMenuItem toolStripMenuItem27;
        private ToolStripMenuItem toolStripMenuItem28;
        private ToolStripSeparator toolStripSeparator16;
        private ToolStripMenuItem toolStripMenuItem29;
        private BackgroundWorker backgroundWorker1;
        private BackgroundWorker backgroundWorker2;
        private ComboBox resultadoQuery;
        private Label label33;
        private ToolStripButton toolStripButton13;
        private ToolStripButton toolStripButton16;
        private ToolStripSeparator toolStripSeparator13;
        private ToolStripButton toolStripButton17;
        private ToolStripButton toolStripButton18;
        private ToolStripSeparator toolStripSeparator14;
        private ToolStripButton toolStripButton19;

    }
}
