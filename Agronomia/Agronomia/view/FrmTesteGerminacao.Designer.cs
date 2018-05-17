namespace Agronomia.view
{
    partial class FrmTesteGerminacao
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
            this.cODIEXPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cODIRESDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cODICULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.eSPECIGERDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.dATAMOGERDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.nUMTRAGERDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.nUMREPGERDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pEPAGEGERDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.tEMPETGERDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.qUAGUAGERDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.qSETOTGERDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.qSEREPGERDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cOLETAGERMINACAODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cULTURADataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.eXPERIMENTODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.gERMINACAOBindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.panel1 = new System.Windows.Forms.Panel();
            this.btnCan = new System.Windows.Forms.Button();
            this.btnDel = new System.Windows.Forms.Button();
            this.btnEdit = new System.Windows.Forms.Button();
            this.btnAdd = new System.Windows.Forms.Button();
            this.panel2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.gERMINACAOBindingSource)).BeginInit();
            this.panel1.SuspendLayout();
            this.SuspendLayout();
            // 
            // panel2
            // 
            this.panel2.Controls.Add(this.GridView);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel2.Location = new System.Drawing.Point(0, 0);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(940, 345);
            this.panel2.TabIndex = 8;
            // 
            // GridView
            // 
            this.GridView.AllowUserToAddRows = false;
            this.GridView.AllowUserToDeleteRows = false;
            this.GridView.AutoGenerateColumns = false;
            this.GridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.GridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.cODIEXPDataGridViewTextBoxColumn,
            this.cODIRESDataGridViewTextBoxColumn,
            this.cODICULDataGridViewTextBoxColumn,
            this.eSPECIGERDataGridViewTextBoxColumn,
            this.dATAMOGERDataGridViewTextBoxColumn,
            this.nUMTRAGERDataGridViewTextBoxColumn,
            this.nUMREPGERDataGridViewTextBoxColumn,
            this.pEPAGEGERDataGridViewTextBoxColumn,
            this.tEMPETGERDataGridViewTextBoxColumn,
            this.qUAGUAGERDataGridViewTextBoxColumn,
            this.qSETOTGERDataGridViewTextBoxColumn,
            this.qSEREPGERDataGridViewTextBoxColumn,
            this.cOLETAGERMINACAODataGridViewTextBoxColumn,
            this.cULTURADataGridViewTextBoxColumn,
            this.eXPERIMENTODataGridViewTextBoxColumn});
            this.GridView.DataSource = this.gERMINACAOBindingSource;
            this.GridView.Location = new System.Drawing.Point(5, 12);
            this.GridView.Name = "GridView";
            this.GridView.ReadOnly = true;
            this.GridView.Size = new System.Drawing.Size(933, 327);
            this.GridView.TabIndex = 0;
            // 
            // cODIEXPDataGridViewTextBoxColumn
            // 
            this.cODIEXPDataGridViewTextBoxColumn.DataPropertyName = "CODI_EXP";
            this.cODIEXPDataGridViewTextBoxColumn.HeaderText = "CODIGO EXPERIMENTO";
            this.cODIEXPDataGridViewTextBoxColumn.Name = "cODIEXPDataGridViewTextBoxColumn";
            this.cODIEXPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cODIRESDataGridViewTextBoxColumn
            // 
            this.cODIRESDataGridViewTextBoxColumn.DataPropertyName = "CODI_RES";
            this.cODIRESDataGridViewTextBoxColumn.HeaderText = "RESPONSAVEL";
            this.cODIRESDataGridViewTextBoxColumn.Name = "cODIRESDataGridViewTextBoxColumn";
            this.cODIRESDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cODICULDataGridViewTextBoxColumn
            // 
            this.cODICULDataGridViewTextBoxColumn.DataPropertyName = "CODI_CUL";
            this.cODICULDataGridViewTextBoxColumn.HeaderText = "CULTURA";
            this.cODICULDataGridViewTextBoxColumn.Name = "cODICULDataGridViewTextBoxColumn";
            this.cODICULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // eSPECIGERDataGridViewTextBoxColumn
            // 
            this.eSPECIGERDataGridViewTextBoxColumn.DataPropertyName = "ESPECI_GER";
            this.eSPECIGERDataGridViewTextBoxColumn.HeaderText = "NME BOTANICO";
            this.eSPECIGERDataGridViewTextBoxColumn.Name = "eSPECIGERDataGridViewTextBoxColumn";
            this.eSPECIGERDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // dATAMOGERDataGridViewTextBoxColumn
            // 
            this.dATAMOGERDataGridViewTextBoxColumn.DataPropertyName = "DATAMO_GER";
            this.dATAMOGERDataGridViewTextBoxColumn.HeaderText = "DATA AMOSTRAGEM";
            this.dATAMOGERDataGridViewTextBoxColumn.Name = "dATAMOGERDataGridViewTextBoxColumn";
            this.dATAMOGERDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // nUMTRAGERDataGridViewTextBoxColumn
            // 
            this.nUMTRAGERDataGridViewTextBoxColumn.DataPropertyName = "NUMTRA_GER";
            this.nUMTRAGERDataGridViewTextBoxColumn.HeaderText = "NUMERO DE TRATAMENTO";
            this.nUMTRAGERDataGridViewTextBoxColumn.Name = "nUMTRAGERDataGridViewTextBoxColumn";
            this.nUMTRAGERDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // nUMREPGERDataGridViewTextBoxColumn
            // 
            this.nUMREPGERDataGridViewTextBoxColumn.DataPropertyName = "NUMREP_GER";
            this.nUMREPGERDataGridViewTextBoxColumn.HeaderText = "NUMERO REPETIÇÃO";
            this.nUMREPGERDataGridViewTextBoxColumn.Name = "nUMREPGERDataGridViewTextBoxColumn";
            this.nUMREPGERDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pEPAGEGERDataGridViewTextBoxColumn
            // 
            this.pEPAGEGERDataGridViewTextBoxColumn.DataPropertyName = "PEPAGE_GER";
            this.pEPAGEGERDataGridViewTextBoxColumn.HeaderText = "PESO PAPEL GERMINADOR";
            this.pEPAGEGERDataGridViewTextBoxColumn.Name = "pEPAGEGERDataGridViewTextBoxColumn";
            this.pEPAGEGERDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // tEMPETGERDataGridViewTextBoxColumn
            // 
            this.tEMPETGERDataGridViewTextBoxColumn.DataPropertyName = "TEMPET_GER";
            this.tEMPETGERDataGridViewTextBoxColumn.HeaderText = "TEMPERATURA";
            this.tEMPETGERDataGridViewTextBoxColumn.Name = "tEMPETGERDataGridViewTextBoxColumn";
            this.tEMPETGERDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // qUAGUAGERDataGridViewTextBoxColumn
            // 
            this.qUAGUAGERDataGridViewTextBoxColumn.DataPropertyName = "QUAGUA_GER";
            this.qUAGUAGERDataGridViewTextBoxColumn.HeaderText = "QUANTIDADE DE ÁGUA";
            this.qUAGUAGERDataGridViewTextBoxColumn.Name = "qUAGUAGERDataGridViewTextBoxColumn";
            this.qUAGUAGERDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // qSETOTGERDataGridViewTextBoxColumn
            // 
            this.qSETOTGERDataGridViewTextBoxColumn.DataPropertyName = "QSETOT_GER";
            this.qSETOTGERDataGridViewTextBoxColumn.HeaderText = "SOMA TOTAL DE SEMENTES";
            this.qSETOTGERDataGridViewTextBoxColumn.Name = "qSETOTGERDataGridViewTextBoxColumn";
            this.qSETOTGERDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // qSEREPGERDataGridViewTextBoxColumn
            // 
            this.qSEREPGERDataGridViewTextBoxColumn.DataPropertyName = "QSEREP_GER";
            this.qSEREPGERDataGridViewTextBoxColumn.HeaderText = "QUANTIDADE DE SEMENTES POR REPETIÇÃO";
            this.qSEREPGERDataGridViewTextBoxColumn.Name = "qSEREPGERDataGridViewTextBoxColumn";
            this.qSEREPGERDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cOLETAGERMINACAODataGridViewTextBoxColumn
            // 
            this.cOLETAGERMINACAODataGridViewTextBoxColumn.DataPropertyName = "COLETAGERMINACAO";
            this.cOLETAGERMINACAODataGridViewTextBoxColumn.HeaderText = "COLETAGERMINACAO";
            this.cOLETAGERMINACAODataGridViewTextBoxColumn.Name = "cOLETAGERMINACAODataGridViewTextBoxColumn";
            this.cOLETAGERMINACAODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cULTURADataGridViewTextBoxColumn
            // 
            this.cULTURADataGridViewTextBoxColumn.DataPropertyName = "CULTURA";
            this.cULTURADataGridViewTextBoxColumn.HeaderText = "CULTURA";
            this.cULTURADataGridViewTextBoxColumn.Name = "cULTURADataGridViewTextBoxColumn";
            this.cULTURADataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // eXPERIMENTODataGridViewTextBoxColumn
            // 
            this.eXPERIMENTODataGridViewTextBoxColumn.DataPropertyName = "EXPERIMENTO";
            this.eXPERIMENTODataGridViewTextBoxColumn.HeaderText = "EXPERIMENTO";
            this.eXPERIMENTODataGridViewTextBoxColumn.Name = "eXPERIMENTODataGridViewTextBoxColumn";
            this.eXPERIMENTODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // gERMINACAOBindingSource
            // 
            this.gERMINACAOBindingSource.DataSource = typeof(Agronomia.GERMINACAO);
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.btnCan);
            this.panel1.Controls.Add(this.btnDel);
            this.panel1.Controls.Add(this.btnEdit);
            this.panel1.Controls.Add(this.btnAdd);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.panel1.Location = new System.Drawing.Point(0, 343);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(940, 31);
            this.panel1.TabIndex = 7;
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(863, 3);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 3;
            this.btnCan.Text = "Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            // 
            // btnDel
            // 
            this.btnDel.Location = new System.Drawing.Point(782, 3);
            this.btnDel.Name = "btnDel";
            this.btnDel.Size = new System.Drawing.Size(75, 23);
            this.btnDel.TabIndex = 2;
            this.btnDel.Text = "Deletar";
            this.btnDel.UseVisualStyleBackColor = true;
            // 
            // btnEdit
            // 
            this.btnEdit.Location = new System.Drawing.Point(701, 3);
            this.btnEdit.Name = "btnEdit";
            this.btnEdit.Size = new System.Drawing.Size(75, 23);
            this.btnEdit.TabIndex = 1;
            this.btnEdit.Text = "Editar";
            this.btnEdit.UseVisualStyleBackColor = true;
            // 
            // btnAdd
            // 
            this.btnAdd.Location = new System.Drawing.Point(620, 3);
            this.btnAdd.Name = "btnAdd";
            this.btnAdd.Size = new System.Drawing.Size(75, 23);
            this.btnAdd.TabIndex = 0;
            this.btnAdd.Text = "Adicionar";
            this.btnAdd.UseVisualStyleBackColor = true;
            // 
            // FrmTesteGerminacao
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(940, 374);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel1);
            this.Name = "FrmTesteGerminacao";
            this.Text = "FrmTesteGerminacao";
            this.Load += new System.EventHandler(this.FrmTesteGerminacao_Load);
            this.panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.gERMINACAOBindingSource)).EndInit();
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
        private System.Windows.Forms.DataGridViewTextBoxColumn cODIEXPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn cODIRESDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn cODICULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn eSPECIGERDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn dATAMOGERDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn nUMTRAGERDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn nUMREPGERDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pEPAGEGERDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn tEMPETGERDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn qUAGUAGERDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn qSETOTGERDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn qSEREPGERDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn cOLETAGERMINACAODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn cULTURADataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn eXPERIMENTODataGridViewTextBoxColumn;
        private System.Windows.Forms.BindingSource gERMINACAOBindingSource;
    }
}