namespace Agronomia.view
{
    partial class FrmColetaGerminacao
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
            this.cODIGERDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.tRATAMCOGDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.rEPETICOGDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pLAACOCOGDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.dATCOGCOGDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.sEMGERCOGDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.nAOGERCOGDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pORGERCOGDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cOLETAGERMINACAOBindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.panel1 = new System.Windows.Forms.Panel();
            this.btnCan = new System.Windows.Forms.Button();
            this.btnDel = new System.Windows.Forms.Button();
            this.btnEdit = new System.Windows.Forms.Button();
            this.btnAdd = new System.Windows.Forms.Button();
            this.panel2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.cOLETAGERMINACAOBindingSource)).BeginInit();
            this.panel1.SuspendLayout();
            this.SuspendLayout();
            // 
            // panel2
            // 
            this.panel2.Controls.Add(this.GridView);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel2.Location = new System.Drawing.Point(20, 60);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(866, 345);
            this.panel2.TabIndex = 8;
            // 
            // GridView
            // 
            this.GridView.AllowUserToAddRows = false;
            this.GridView.AllowUserToDeleteRows = false;
            this.GridView.AutoGenerateColumns = false;
            this.GridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.GridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.cODIGERDataGridViewTextBoxColumn,
            this.tRATAMCOGDataGridViewTextBoxColumn,
            this.rEPETICOGDataGridViewTextBoxColumn,
            this.pLAACOCOGDataGridViewTextBoxColumn,
            this.dATCOGCOGDataGridViewTextBoxColumn,
            this.sEMGERCOGDataGridViewTextBoxColumn,
            this.nAOGERCOGDataGridViewTextBoxColumn,
            this.pORGERCOGDataGridViewTextBoxColumn});
            this.GridView.DataSource = this.cOLETAGERMINACAOBindingSource;
            this.GridView.Location = new System.Drawing.Point(5, 12);
            this.GridView.Name = "GridView";
            this.GridView.ReadOnly = true;
            this.GridView.Size = new System.Drawing.Size(853, 327);
            this.GridView.TabIndex = 0;
            // 
            // cODIGERDataGridViewTextBoxColumn
            // 
            this.cODIGERDataGridViewTextBoxColumn.DataPropertyName = "CODI_GER";
            this.cODIGERDataGridViewTextBoxColumn.HeaderText = "GERMINAÇÃO";
            this.cODIGERDataGridViewTextBoxColumn.Name = "cODIGERDataGridViewTextBoxColumn";
            this.cODIGERDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // tRATAMCOGDataGridViewTextBoxColumn
            // 
            this.tRATAMCOGDataGridViewTextBoxColumn.DataPropertyName = "TRATAM_COG";
            this.tRATAMCOGDataGridViewTextBoxColumn.HeaderText = "TRATAMENTO";
            this.tRATAMCOGDataGridViewTextBoxColumn.Name = "tRATAMCOGDataGridViewTextBoxColumn";
            this.tRATAMCOGDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // rEPETICOGDataGridViewTextBoxColumn
            // 
            this.rEPETICOGDataGridViewTextBoxColumn.DataPropertyName = "REPETI_COG";
            this.rEPETICOGDataGridViewTextBoxColumn.HeaderText = "REPETIÇÃO";
            this.rEPETICOGDataGridViewTextBoxColumn.Name = "rEPETICOGDataGridViewTextBoxColumn";
            this.rEPETICOGDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pLAACOCOGDataGridViewTextBoxColumn
            // 
            this.pLAACOCOGDataGridViewTextBoxColumn.DataPropertyName = "PLAACO_COG";
            this.pLAACOCOGDataGridViewTextBoxColumn.HeaderText = "PLANO DE ACOMPANHAMENTO";
            this.pLAACOCOGDataGridViewTextBoxColumn.Name = "pLAACOCOGDataGridViewTextBoxColumn";
            this.pLAACOCOGDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // dATCOGCOGDataGridViewTextBoxColumn
            // 
            this.dATCOGCOGDataGridViewTextBoxColumn.DataPropertyName = "DATCOG_COG";
            this.dATCOGCOGDataGridViewTextBoxColumn.HeaderText = "DATA DE COLETA DE DADOS";
            this.dATCOGCOGDataGridViewTextBoxColumn.Name = "dATCOGCOGDataGridViewTextBoxColumn";
            this.dATCOGCOGDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // sEMGERCOGDataGridViewTextBoxColumn
            // 
            this.sEMGERCOGDataGridViewTextBoxColumn.DataPropertyName = "SEMGER_COG";
            this.sEMGERCOGDataGridViewTextBoxColumn.HeaderText = "SEMENTES GERMINADAS";
            this.sEMGERCOGDataGridViewTextBoxColumn.Name = "sEMGERCOGDataGridViewTextBoxColumn";
            this.sEMGERCOGDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // nAOGERCOGDataGridViewTextBoxColumn
            // 
            this.nAOGERCOGDataGridViewTextBoxColumn.DataPropertyName = "NAOGER_COG";
            this.nAOGERCOGDataGridViewTextBoxColumn.HeaderText = "NAO GERMINADAS";
            this.nAOGERCOGDataGridViewTextBoxColumn.Name = "nAOGERCOGDataGridViewTextBoxColumn";
            this.nAOGERCOGDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pORGERCOGDataGridViewTextBoxColumn
            // 
            this.pORGERCOGDataGridViewTextBoxColumn.DataPropertyName = "PORGER_COG";
            this.pORGERCOGDataGridViewTextBoxColumn.HeaderText = "PORCENTAGEM DE GERMINAÇÃO %";
            this.pORGERCOGDataGridViewTextBoxColumn.Name = "pORGERCOGDataGridViewTextBoxColumn";
            this.pORGERCOGDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cOLETAGERMINACAOBindingSource
            // 
            this.cOLETAGERMINACAOBindingSource.DataSource = typeof(Agronomia.COLETAGERMINACAO);
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.btnCan);
            this.panel1.Controls.Add(this.btnDel);
            this.panel1.Controls.Add(this.btnEdit);
            this.panel1.Controls.Add(this.btnAdd);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.panel1.Location = new System.Drawing.Point(20, 502);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(866, 31);
            this.panel1.TabIndex = 7;
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(783, 3);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 3;
            this.btnCan.Text = "&Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            this.btnCan.Click += new System.EventHandler(this.btnCan_Click);
            // 
            // btnDel
            // 
            this.btnDel.Location = new System.Drawing.Point(702, 3);
            this.btnDel.Name = "btnDel";
            this.btnDel.Size = new System.Drawing.Size(75, 23);
            this.btnDel.TabIndex = 2;
            this.btnDel.Text = "&Deletar";
            this.btnDel.UseVisualStyleBackColor = true;
            this.btnDel.Click += new System.EventHandler(this.btnDel_Click);
            // 
            // btnEdit
            // 
            this.btnEdit.Location = new System.Drawing.Point(621, 3);
            this.btnEdit.Name = "btnEdit";
            this.btnEdit.Size = new System.Drawing.Size(75, 23);
            this.btnEdit.TabIndex = 1;
            this.btnEdit.Text = "&Editar";
            this.btnEdit.UseVisualStyleBackColor = true;
            this.btnEdit.Click += new System.EventHandler(this.btnEdit_Click);
            // 
            // btnAdd
            // 
            this.btnAdd.Location = new System.Drawing.Point(540, 3);
            this.btnAdd.Name = "btnAdd";
            this.btnAdd.Size = new System.Drawing.Size(75, 23);
            this.btnAdd.TabIndex = 0;
            this.btnAdd.Text = "&Adicionar";
            this.btnAdd.UseVisualStyleBackColor = true;
            this.btnAdd.Click += new System.EventHandler(this.btnAdd_Click);
            // 
            // FrmColetaGerminacao
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(906, 553);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel1);
            this.Name = "FrmColetaGerminacao";
            this.Text = "Coleta Germinação";
            this.Load += new System.EventHandler(this.FrmColetaGerminacao_Load);
            this.panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.cOLETAGERMINACAOBindingSource)).EndInit();
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
        private System.Windows.Forms.BindingSource cOLETAGERMINACAOBindingSource;
        private System.Windows.Forms.DataGridViewTextBoxColumn cODIGERDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn tRATAMCOGDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn rEPETICOGDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pLAACOCOGDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn dATCOGCOGDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn sEMGERCOGDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn nAOGERCOGDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pORGERCOGDataGridViewTextBoxColumn;
    }
}