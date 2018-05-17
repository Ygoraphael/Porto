namespace Agronomia.view
{
    partial class FrmExperimento
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
            this.panel2 = new System.Windows.Forms.Panel();
            this.GridView = new System.Windows.Forms.DataGridView();
            this.cODIPRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cODICOMDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.nUMTRAEXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.nUMREPEXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.dATINIEXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.dIAVASEXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.dESTRAEXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cODIPADDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.eXPFINEXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.tIPTRAEXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pEIEA1EXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pEIEA2EXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pEIEA3EXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pEQET1EXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pEQET2EXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pEQET3EXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.eXPERIMENTOBindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.panel1 = new System.Windows.Forms.Panel();
            this.btnCan = new System.Windows.Forms.Button();
            this.btnDel = new System.Windows.Forms.Button();
            this.btnEdit = new System.Windows.Forms.Button();
            this.btnAdd = new System.Windows.Forms.Button();
            this.panel2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.eXPERIMENTOBindingSource)).BeginInit();
            this.panel1.SuspendLayout();
            this.SuspendLayout();
            // 
            // panel2
            // 
            this.panel2.Controls.Add(this.GridView);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel2.Location = new System.Drawing.Point(20, 60);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(1112, 402);
            this.panel2.TabIndex = 8;
            // 
            // GridView
            // 
            this.GridView.AllowUserToAddRows = false;
            this.GridView.AllowUserToDeleteRows = false;
            this.GridView.AutoGenerateColumns = false;
            this.GridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.GridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.cODIPRODataGridViewTextBoxColumn,
            this.cODICOMDataGridViewTextBoxColumn,
            this.nUMTRAEXPDataGridViewTextBoxColumn,
            this.nUMREPEXPDataGridViewTextBoxColumn,
            this.dATINIEXPDataGridViewTextBoxColumn,
            this.dIAVASEXPDataGridViewTextBoxColumn,
            this.dESTRAEXPDataGridViewTextBoxColumn,
            this.cODIPADDataGridViewTextBoxColumn,
            this.eXPFINEXPDataGridViewTextBoxColumn,
            this.tIPTRAEXPDataGridViewTextBoxColumn,
            this.pEIEA1EXPDataGridViewTextBoxColumn,
            this.pEIEA2EXPDataGridViewTextBoxColumn,
            this.pEIEA3EXPDataGridViewTextBoxColumn,
            this.pEQET1EXPDataGridViewTextBoxColumn,
            this.pEQET2EXPDataGridViewTextBoxColumn,
            this.pEQET3EXPDataGridViewTextBoxColumn});
            this.GridView.DataSource = this.eXPERIMENTOBindingSource;
            this.GridView.Location = new System.Drawing.Point(5, 12);
            this.GridView.Name = "GridView";
            this.GridView.ReadOnly = true;
            this.GridView.Size = new System.Drawing.Size(1145, 373);
            this.GridView.TabIndex = 0;
            // 
            // cODIPRODataGridViewTextBoxColumn
            // 
            this.cODIPRODataGridViewTextBoxColumn.DataPropertyName = "CODI_PRO";
            this.cODIPRODataGridViewTextBoxColumn.HeaderText = "PROPRIEDADE";
            this.cODIPRODataGridViewTextBoxColumn.Name = "cODIPRODataGridViewTextBoxColumn";
            this.cODIPRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cODICOMDataGridViewTextBoxColumn
            // 
            this.cODICOMDataGridViewTextBoxColumn.DataPropertyName = "CODI_COM";
            this.cODICOMDataGridViewTextBoxColumn.HeaderText = "COMPETIÇÃO";
            this.cODICOMDataGridViewTextBoxColumn.Name = "cODICOMDataGridViewTextBoxColumn";
            this.cODICOMDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // nUMTRAEXPDataGridViewTextBoxColumn
            // 
            this.nUMTRAEXPDataGridViewTextBoxColumn.DataPropertyName = "NUMTRA_EXP";
            this.nUMTRAEXPDataGridViewTextBoxColumn.HeaderText = "NUMERO DE TRATAMENTO";
            this.nUMTRAEXPDataGridViewTextBoxColumn.Name = "nUMTRAEXPDataGridViewTextBoxColumn";
            this.nUMTRAEXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // nUMREPEXPDataGridViewTextBoxColumn
            // 
            this.nUMREPEXPDataGridViewTextBoxColumn.DataPropertyName = "NUMREP_EXP";
            this.nUMREPEXPDataGridViewTextBoxColumn.HeaderText = "NUMERO DE REPETIÇÃO";
            this.nUMREPEXPDataGridViewTextBoxColumn.Name = "nUMREPEXPDataGridViewTextBoxColumn";
            this.nUMREPEXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // dATINIEXPDataGridViewTextBoxColumn
            // 
            this.dATINIEXPDataGridViewTextBoxColumn.DataPropertyName = "DATINI_EXP";
            this.dATINIEXPDataGridViewTextBoxColumn.HeaderText = "DATA DE INICIO";
            this.dATINIEXPDataGridViewTextBoxColumn.Name = "dATINIEXPDataGridViewTextBoxColumn";
            this.dATINIEXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // dIAVASEXPDataGridViewTextBoxColumn
            // 
            this.dIAVASEXPDataGridViewTextBoxColumn.DataPropertyName = "DIAVAS_EXP";
            this.dIAVASEXPDataGridViewTextBoxColumn.HeaderText = "DIAMETRO DO VASO";
            this.dIAVASEXPDataGridViewTextBoxColumn.Name = "dIAVASEXPDataGridViewTextBoxColumn";
            this.dIAVASEXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // dESTRAEXPDataGridViewTextBoxColumn
            // 
            this.dESTRAEXPDataGridViewTextBoxColumn.DataPropertyName = "DESTRA_EXP";
            this.dESTRAEXPDataGridViewTextBoxColumn.HeaderText = "DESCRIÇÃO DO TRATAMENTO";
            this.dESTRAEXPDataGridViewTextBoxColumn.Name = "dESTRAEXPDataGridViewTextBoxColumn";
            this.dESTRAEXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cODIPADDataGridViewTextBoxColumn
            // 
            this.cODIPADDataGridViewTextBoxColumn.DataPropertyName = "CODI_PAD";
            this.cODIPADDataGridViewTextBoxColumn.HeaderText = "PADDRÃO DE VARIAVEL";
            this.cODIPADDataGridViewTextBoxColumn.Name = "cODIPADDataGridViewTextBoxColumn";
            this.cODIPADDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // eXPFINEXPDataGridViewTextBoxColumn
            // 
            this.eXPFINEXPDataGridViewTextBoxColumn.DataPropertyName = "EXPFIN_EXP";
            this.eXPFINEXPDataGridViewTextBoxColumn.HeaderText = "STATUS DO EXPERIMENTO";
            this.eXPFINEXPDataGridViewTextBoxColumn.Name = "eXPFINEXPDataGridViewTextBoxColumn";
            this.eXPFINEXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // tIPTRAEXPDataGridViewTextBoxColumn
            // 
            this.tIPTRAEXPDataGridViewTextBoxColumn.DataPropertyName = "TIPTRA_EXP";
            this.tIPTRAEXPDataGridViewTextBoxColumn.HeaderText = "TIPO DE TRATAMENTO";
            this.tIPTRAEXPDataGridViewTextBoxColumn.Name = "tIPTRAEXPDataGridViewTextBoxColumn";
            this.tIPTRAEXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pEIEA1EXPDataGridViewTextBoxColumn
            // 
            this.pEIEA1EXPDataGridViewTextBoxColumn.DataPropertyName = "PEIEA1_EXP";
            this.pEIEA1EXPDataGridViewTextBoxColumn.HeaderText = "PERCENTUAL DO ELEMENTO NO ADUBO 1";
            this.pEIEA1EXPDataGridViewTextBoxColumn.Name = "pEIEA1EXPDataGridViewTextBoxColumn";
            this.pEIEA1EXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pEIEA2EXPDataGridViewTextBoxColumn
            // 
            this.pEIEA2EXPDataGridViewTextBoxColumn.DataPropertyName = "PEIEA2_EXP";
            this.pEIEA2EXPDataGridViewTextBoxColumn.HeaderText = "PERCENTUAL DO ELEMENTO NO ADUBO 2";
            this.pEIEA2EXPDataGridViewTextBoxColumn.Name = "pEIEA2EXPDataGridViewTextBoxColumn";
            this.pEIEA2EXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pEIEA3EXPDataGridViewTextBoxColumn
            // 
            this.pEIEA3EXPDataGridViewTextBoxColumn.DataPropertyName = "PEIEA3_EXP";
            this.pEIEA3EXPDataGridViewTextBoxColumn.HeaderText = "PERCENTUAL DO ELEMENTO NO ADUBO 3";
            this.pEIEA3EXPDataGridViewTextBoxColumn.Name = "pEIEA3EXPDataGridViewTextBoxColumn";
            this.pEIEA3EXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pEQET1EXPDataGridViewTextBoxColumn
            // 
            this.pEQET1EXPDataGridViewTextBoxColumn.DataPropertyName = "PEQET1_EXP";
            this.pEQET1EXPDataGridViewTextBoxColumn.HeaderText = "PERCENTUAL DA QUANTIDADE DO ELEMENTO NO TRATAMENTO 1 COM ADUBO 1";
            this.pEQET1EXPDataGridViewTextBoxColumn.Name = "pEQET1EXPDataGridViewTextBoxColumn";
            this.pEQET1EXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pEQET2EXPDataGridViewTextBoxColumn
            // 
            this.pEQET2EXPDataGridViewTextBoxColumn.DataPropertyName = "PEQET2_EXP";
            this.pEQET2EXPDataGridViewTextBoxColumn.HeaderText = "PERCENTUAL DA QUANTIDADE DO ELEMENTO NO TRATAMENTO 1 COM ADUBO 2";
            this.pEQET2EXPDataGridViewTextBoxColumn.Name = "pEQET2EXPDataGridViewTextBoxColumn";
            this.pEQET2EXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pEQET3EXPDataGridViewTextBoxColumn
            // 
            this.pEQET3EXPDataGridViewTextBoxColumn.DataPropertyName = "PEQET3_EXP";
            this.pEQET3EXPDataGridViewTextBoxColumn.HeaderText = "PERCENTUAL DA QUANTIDADE DO ELEMENTO NO TRATAMENTO 1 COM ADUBO 3";
            this.pEQET3EXPDataGridViewTextBoxColumn.Name = "pEQET3EXPDataGridViewTextBoxColumn";
            this.pEQET3EXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // eXPERIMENTOBindingSource
            // 
            this.eXPERIMENTOBindingSource.DataSource = typeof(Agronomia.EXPERIMENTO);
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.btnCan);
            this.panel1.Controls.Add(this.btnDel);
            this.panel1.Controls.Add(this.btnEdit);
            this.panel1.Controls.Add(this.btnAdd);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.panel1.Location = new System.Drawing.Point(20, 490);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(1112, 31);
            this.panel1.TabIndex = 7;
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(1075, 5);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 3;
            this.btnCan.Text = "&Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            this.btnCan.Click += new System.EventHandler(this.btnCan_Click);
            // 
            // btnDel
            // 
            this.btnDel.Location = new System.Drawing.Point(994, 5);
            this.btnDel.Name = "btnDel";
            this.btnDel.Size = new System.Drawing.Size(75, 23);
            this.btnDel.TabIndex = 2;
            this.btnDel.Text = "&Deletar";
            this.btnDel.UseVisualStyleBackColor = true;
            this.btnDel.Click += new System.EventHandler(this.btnDel_Click);
            // 
            // btnEdit
            // 
            this.btnEdit.Location = new System.Drawing.Point(913, 5);
            this.btnEdit.Name = "btnEdit";
            this.btnEdit.Size = new System.Drawing.Size(75, 23);
            this.btnEdit.TabIndex = 1;
            this.btnEdit.Text = "&Editar";
            this.btnEdit.UseVisualStyleBackColor = true;
            this.btnEdit.Click += new System.EventHandler(this.btnEdit_Click);
            // 
            // btnAdd
            // 
            this.btnAdd.Location = new System.Drawing.Point(832, 5);
            this.btnAdd.Name = "btnAdd";
            this.btnAdd.Size = new System.Drawing.Size(75, 23);
            this.btnAdd.TabIndex = 0;
            this.btnAdd.Text = "&Adicionar";
            this.btnAdd.UseVisualStyleBackColor = true;
            this.btnAdd.Click += new System.EventHandler(this.btnAdd_Click);
            // 
            // FrmExperimento
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1152, 541);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel1);
            this.Name = "FrmExperimento";
            this.Text = "Experimento";
            this.Load += new System.EventHandler(this.FrmExperimento_Load);
            this.panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.eXPERIMENTOBindingSource)).EndInit();
            this.panel1.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Panel panel2;
        private System.Windows.Forms.DataGridView GridView;
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.Button btnCan;
        private System.Windows.Forms.Button btnDel;
        private System.Windows.Forms.Button btnEdit;
        private System.Windows.Forms.Button btnAdd;
        private System.Windows.Forms.BindingSource eXPERIMENTOBindingSource;
        private System.Windows.Forms.DataGridViewTextBoxColumn cODIPRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn cODICOMDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn nUMTRAEXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn nUMREPEXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn dATINIEXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn dIAVASEXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn dESTRAEXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn cODIPADDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn eXPFINEXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn tIPTRAEXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pEIEA1EXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pEIEA2EXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pEIEA3EXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pEQET1EXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pEQET2EXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pEQET3EXPDataGridViewTextBoxColumn;
    }
}