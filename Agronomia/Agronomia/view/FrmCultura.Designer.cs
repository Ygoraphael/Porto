namespace Agronomia.view
{
    partial class FrmCultura
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
            this.panel1 = new System.Windows.Forms.Panel();
            this.btnCan = new System.Windows.Forms.Button();
            this.btnDel = new System.Windows.Forms.Button();
            this.btnEdit = new System.Windows.Forms.Button();
            this.btnAdd = new System.Windows.Forms.Button();
            this.nOMCULCULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cULTIVCULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.lOTECUCULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.gERMINCULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pUREZACULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.vALIDACULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.sAFRACCULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.m100SECULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.tRAQUICULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pROSEMCULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.oBSERVCULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cULTURABindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.panel2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).BeginInit();
            this.panel1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.cULTURABindingSource)).BeginInit();
            this.SuspendLayout();
            // 
            // panel2
            // 
            this.panel2.Controls.Add(this.GridView);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel2.Location = new System.Drawing.Point(0, 0);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(1155, 345);
            this.panel2.TabIndex = 8;
            // 
            // GridView
            // 
            this.GridView.AllowUserToAddRows = false;
            this.GridView.AllowUserToDeleteRows = false;
            this.GridView.AutoGenerateColumns = false;
            this.GridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.GridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.nOMCULCULDataGridViewTextBoxColumn,
            this.cULTIVCULDataGridViewTextBoxColumn,
            this.lOTECUCULDataGridViewTextBoxColumn,
            this.gERMINCULDataGridViewTextBoxColumn,
            this.pUREZACULDataGridViewTextBoxColumn,
            this.vALIDACULDataGridViewTextBoxColumn,
            this.sAFRACCULDataGridViewTextBoxColumn,
            this.m100SECULDataGridViewTextBoxColumn,
            this.tRAQUICULDataGridViewTextBoxColumn,
            this.pROSEMCULDataGridViewTextBoxColumn,
            this.oBSERVCULDataGridViewTextBoxColumn});
            this.GridView.DataSource = this.cULTURABindingSource;
            this.GridView.Location = new System.Drawing.Point(5, 12);
            this.GridView.Name = "GridView";
            this.GridView.ReadOnly = true;
            this.GridView.Size = new System.Drawing.Size(1150, 327);
            this.GridView.TabIndex = 0;
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.btnCan);
            this.panel1.Controls.Add(this.btnDel);
            this.panel1.Controls.Add(this.btnEdit);
            this.panel1.Controls.Add(this.btnAdd);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.panel1.Location = new System.Drawing.Point(0, 342);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(1155, 31);
            this.panel1.TabIndex = 7;
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(1068, 5);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 3;
            this.btnCan.Text = "&Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            this.btnCan.Click += new System.EventHandler(this.btnCan_Click);
            // 
            // btnDel
            // 
            this.btnDel.Location = new System.Drawing.Point(987, 5);
            this.btnDel.Name = "btnDel";
            this.btnDel.Size = new System.Drawing.Size(75, 23);
            this.btnDel.TabIndex = 2;
            this.btnDel.Text = "&Deletar";
            this.btnDel.UseVisualStyleBackColor = true;
            this.btnDel.Click += new System.EventHandler(this.btnDel_Click);
            // 
            // btnEdit
            // 
            this.btnEdit.Location = new System.Drawing.Point(906, 5);
            this.btnEdit.Name = "btnEdit";
            this.btnEdit.Size = new System.Drawing.Size(75, 23);
            this.btnEdit.TabIndex = 1;
            this.btnEdit.Text = "&Editar";
            this.btnEdit.UseVisualStyleBackColor = true;
            this.btnEdit.Click += new System.EventHandler(this.btnEdit_Click);
            // 
            // btnAdd
            // 
            this.btnAdd.Location = new System.Drawing.Point(825, 5);
            this.btnAdd.Name = "btnAdd";
            this.btnAdd.Size = new System.Drawing.Size(75, 23);
            this.btnAdd.TabIndex = 0;
            this.btnAdd.Text = "&Adicionar";
            this.btnAdd.UseVisualStyleBackColor = true;
            this.btnAdd.Click += new System.EventHandler(this.btnAdd_Click);
            // 
            // nOMCULCULDataGridViewTextBoxColumn
            // 
            this.nOMCULCULDataGridViewTextBoxColumn.DataPropertyName = "NOMCUL_CUL";
            this.nOMCULCULDataGridViewTextBoxColumn.HeaderText = "NOME CULTURA";
            this.nOMCULCULDataGridViewTextBoxColumn.Name = "nOMCULCULDataGridViewTextBoxColumn";
            this.nOMCULCULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cULTIVCULDataGridViewTextBoxColumn
            // 
            this.cULTIVCULDataGridViewTextBoxColumn.DataPropertyName = "CULTIV_CUL";
            this.cULTIVCULDataGridViewTextBoxColumn.HeaderText = "CULTIVAR";
            this.cULTIVCULDataGridViewTextBoxColumn.Name = "cULTIVCULDataGridViewTextBoxColumn";
            this.cULTIVCULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // lOTECUCULDataGridViewTextBoxColumn
            // 
            this.lOTECUCULDataGridViewTextBoxColumn.DataPropertyName = "LOTECU_CUL";
            this.lOTECUCULDataGridViewTextBoxColumn.HeaderText = "LOTE";
            this.lOTECUCULDataGridViewTextBoxColumn.Name = "lOTECUCULDataGridViewTextBoxColumn";
            this.lOTECUCULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // gERMINCULDataGridViewTextBoxColumn
            // 
            this.gERMINCULDataGridViewTextBoxColumn.DataPropertyName = "GERMIN_CUL";
            this.gERMINCULDataGridViewTextBoxColumn.HeaderText = "GERMINAÇÃO";
            this.gERMINCULDataGridViewTextBoxColumn.Name = "gERMINCULDataGridViewTextBoxColumn";
            this.gERMINCULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pUREZACULDataGridViewTextBoxColumn
            // 
            this.pUREZACULDataGridViewTextBoxColumn.DataPropertyName = "PUREZA_CUL";
            this.pUREZACULDataGridViewTextBoxColumn.HeaderText = "PUREZA";
            this.pUREZACULDataGridViewTextBoxColumn.Name = "pUREZACULDataGridViewTextBoxColumn";
            this.pUREZACULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // vALIDACULDataGridViewTextBoxColumn
            // 
            this.vALIDACULDataGridViewTextBoxColumn.DataPropertyName = "VALIDA_CUL";
            this.vALIDACULDataGridViewTextBoxColumn.HeaderText = "VALIDADE";
            this.vALIDACULDataGridViewTextBoxColumn.Name = "vALIDACULDataGridViewTextBoxColumn";
            this.vALIDACULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // sAFRACCULDataGridViewTextBoxColumn
            // 
            this.sAFRACCULDataGridViewTextBoxColumn.DataPropertyName = "SAFRAC_CUL";
            this.sAFRACCULDataGridViewTextBoxColumn.HeaderText = "SAFRA";
            this.sAFRACCULDataGridViewTextBoxColumn.Name = "sAFRACCULDataGridViewTextBoxColumn";
            this.sAFRACCULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // m100SECULDataGridViewTextBoxColumn
            // 
            this.m100SECULDataGridViewTextBoxColumn.DataPropertyName = "M100SE_CUL";
            this.m100SECULDataGridViewTextBoxColumn.HeaderText = "MASSA DE 100 SEMENTES";
            this.m100SECULDataGridViewTextBoxColumn.Name = "m100SECULDataGridViewTextBoxColumn";
            this.m100SECULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // tRAQUICULDataGridViewTextBoxColumn
            // 
            this.tRAQUICULDataGridViewTextBoxColumn.DataPropertyName = "TRAQUI_CUL";
            this.tRAQUICULDataGridViewTextBoxColumn.HeaderText = "TRATAMENTO QUIMICO";
            this.tRAQUICULDataGridViewTextBoxColumn.Name = "tRAQUICULDataGridViewTextBoxColumn";
            this.tRAQUICULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pROSEMCULDataGridViewTextBoxColumn
            // 
            this.pROSEMCULDataGridViewTextBoxColumn.DataPropertyName = "PROSEM_CUL";
            this.pROSEMCULDataGridViewTextBoxColumn.HeaderText = "PRODUZIDO POR";
            this.pROSEMCULDataGridViewTextBoxColumn.Name = "pROSEMCULDataGridViewTextBoxColumn";
            this.pROSEMCULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // oBSERVCULDataGridViewTextBoxColumn
            // 
            this.oBSERVCULDataGridViewTextBoxColumn.DataPropertyName = "OBSERV_CUL";
            this.oBSERVCULDataGridViewTextBoxColumn.HeaderText = "OBSERVAÇÃO";
            this.oBSERVCULDataGridViewTextBoxColumn.Name = "oBSERVCULDataGridViewTextBoxColumn";
            this.oBSERVCULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cULTURABindingSource
            // 
            this.cULTURABindingSource.DataSource = typeof(Agronomia.CULTURA);
            // 
            // FrmCultura
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1155, 373);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel1);
            this.Name = "FrmCultura";
            this.Text = "Cultura";
            this.Load += new System.EventHandler(this.FrmCultura_Load);
            this.panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).EndInit();
            this.panel1.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.cULTURABindingSource)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Panel panel2;
        private System.Windows.Forms.DataGridView GridView;
        private System.Windows.Forms.DataGridViewTextBoxColumn nOMCULCULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn cULTIVCULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn lOTECUCULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn gERMINCULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pUREZACULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn vALIDACULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn sAFRACCULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn m100SECULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn tRAQUICULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn pROSEMCULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn oBSERVCULDataGridViewTextBoxColumn;
        private System.Windows.Forms.BindingSource cULTURABindingSource;
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.Button btnCan;
        private System.Windows.Forms.Button btnDel;
        private System.Windows.Forms.Button btnEdit;
        private System.Windows.Forms.Button btnAdd;
    }
}