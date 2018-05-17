namespace Agronomia.view
{
    partial class FrmPropriedade
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
            this.GridView = new System.Windows.Forms.DataGridView();
            this.panel2 = new System.Windows.Forms.Panel();
            this.panel1 = new System.Windows.Forms.Panel();
            this.btnCan = new System.Windows.Forms.Button();
            this.btnDel = new System.Windows.Forms.Button();
            this.btnEdit = new System.Windows.Forms.Button();
            this.btnAdd = new System.Windows.Forms.Button();
            this.nOMEPRPRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.mUNICIPRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.eSTADOPRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.eNDEREPRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cOMPLEPRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.tELEFOPRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.eMAILPPROPDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.nOMRESPRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.pROPRIEDADEBindingSource = new System.Windows.Forms.BindingSource(this.components);
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).BeginInit();
            this.panel2.SuspendLayout();
            this.panel1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.pROPRIEDADEBindingSource)).BeginInit();
            this.SuspendLayout();
            // 
            // GridView
            // 
            this.GridView.AllowUserToAddRows = false;
            this.GridView.AllowUserToDeleteRows = false;
            this.GridView.AutoGenerateColumns = false;
            this.GridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.GridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.nOMEPRPRODataGridViewTextBoxColumn,
            this.mUNICIPRODataGridViewTextBoxColumn,
            this.eSTADOPRODataGridViewTextBoxColumn,
            this.eNDEREPRODataGridViewTextBoxColumn,
            this.cOMPLEPRODataGridViewTextBoxColumn,
            this.tELEFOPRODataGridViewTextBoxColumn,
            this.eMAILPPROPDataGridViewTextBoxColumn,
            this.nOMRESPRODataGridViewTextBoxColumn});
            this.GridView.DataSource = this.pROPRIEDADEBindingSource;
            this.GridView.Location = new System.Drawing.Point(5, 12);
            this.GridView.Name = "GridView";
            this.GridView.ReadOnly = true;
            this.GridView.Size = new System.Drawing.Size(847, 327);
            this.GridView.TabIndex = 0;
            // 
            // panel2
            // 
            this.panel2.Controls.Add(this.GridView);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel2.Location = new System.Drawing.Point(0, 0);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(858, 345);
            this.panel2.TabIndex = 10;
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.btnCan);
            this.panel1.Controls.Add(this.btnDel);
            this.panel1.Controls.Add(this.btnEdit);
            this.panel1.Controls.Add(this.btnAdd);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.panel1.Location = new System.Drawing.Point(0, 349);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(858, 31);
            this.panel1.TabIndex = 9;
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(776, 3);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 3;
            this.btnCan.Text = "&Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            this.btnCan.Click += new System.EventHandler(this.btnCan_Click);
            // 
            // btnDel
            // 
            this.btnDel.Location = new System.Drawing.Point(695, 3);
            this.btnDel.Name = "btnDel";
            this.btnDel.Size = new System.Drawing.Size(75, 23);
            this.btnDel.TabIndex = 2;
            this.btnDel.Text = "&Deletar";
            this.btnDel.UseVisualStyleBackColor = true;
            this.btnDel.Click += new System.EventHandler(this.btnDel_Click);
            // 
            // btnEdit
            // 
            this.btnEdit.Location = new System.Drawing.Point(614, 3);
            this.btnEdit.Name = "btnEdit";
            this.btnEdit.Size = new System.Drawing.Size(75, 23);
            this.btnEdit.TabIndex = 1;
            this.btnEdit.Text = "&Editar";
            this.btnEdit.UseVisualStyleBackColor = true;
            this.btnEdit.Click += new System.EventHandler(this.btnEdit_Click);
            // 
            // btnAdd
            // 
            this.btnAdd.Location = new System.Drawing.Point(533, 3);
            this.btnAdd.Name = "btnAdd";
            this.btnAdd.Size = new System.Drawing.Size(75, 23);
            this.btnAdd.TabIndex = 0;
            this.btnAdd.Text = "&Adicionar";
            this.btnAdd.UseVisualStyleBackColor = true;
            this.btnAdd.Click += new System.EventHandler(this.btnAdd_Click);
            // 
            // nOMEPRPRODataGridViewTextBoxColumn
            // 
            this.nOMEPRPRODataGridViewTextBoxColumn.DataPropertyName = "NOMEPR_PRO";
            this.nOMEPRPRODataGridViewTextBoxColumn.HeaderText = "NOME PROPRIEDADE";
            this.nOMEPRPRODataGridViewTextBoxColumn.Name = "nOMEPRPRODataGridViewTextBoxColumn";
            this.nOMEPRPRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // mUNICIPRODataGridViewTextBoxColumn
            // 
            this.mUNICIPRODataGridViewTextBoxColumn.DataPropertyName = "MUNICI_PRO";
            this.mUNICIPRODataGridViewTextBoxColumn.HeaderText = "MUNICIPIO";
            this.mUNICIPRODataGridViewTextBoxColumn.Name = "mUNICIPRODataGridViewTextBoxColumn";
            this.mUNICIPRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // eSTADOPRODataGridViewTextBoxColumn
            // 
            this.eSTADOPRODataGridViewTextBoxColumn.DataPropertyName = "ESTADO_PRO";
            this.eSTADOPRODataGridViewTextBoxColumn.HeaderText = "ESTADO";
            this.eSTADOPRODataGridViewTextBoxColumn.Name = "eSTADOPRODataGridViewTextBoxColumn";
            this.eSTADOPRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // eNDEREPRODataGridViewTextBoxColumn
            // 
            this.eNDEREPRODataGridViewTextBoxColumn.DataPropertyName = "ENDERE_PRO";
            this.eNDEREPRODataGridViewTextBoxColumn.HeaderText = "ENDEREÇO";
            this.eNDEREPRODataGridViewTextBoxColumn.Name = "eNDEREPRODataGridViewTextBoxColumn";
            this.eNDEREPRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cOMPLEPRODataGridViewTextBoxColumn
            // 
            this.cOMPLEPRODataGridViewTextBoxColumn.DataPropertyName = "COMPLE_PRO";
            this.cOMPLEPRODataGridViewTextBoxColumn.HeaderText = "COMPLEMENTO";
            this.cOMPLEPRODataGridViewTextBoxColumn.Name = "cOMPLEPRODataGridViewTextBoxColumn";
            this.cOMPLEPRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // tELEFOPRODataGridViewTextBoxColumn
            // 
            this.tELEFOPRODataGridViewTextBoxColumn.DataPropertyName = "TELEFO_PRO";
            this.tELEFOPRODataGridViewTextBoxColumn.HeaderText = "TELEFONE";
            this.tELEFOPRODataGridViewTextBoxColumn.Name = "tELEFOPRODataGridViewTextBoxColumn";
            this.tELEFOPRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // eMAILPPROPDataGridViewTextBoxColumn
            // 
            this.eMAILPPROPDataGridViewTextBoxColumn.DataPropertyName = "EMAILP_PROP";
            this.eMAILPPROPDataGridViewTextBoxColumn.HeaderText = "EMAIL";
            this.eMAILPPROPDataGridViewTextBoxColumn.Name = "eMAILPPROPDataGridViewTextBoxColumn";
            this.eMAILPPROPDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // nOMRESPRODataGridViewTextBoxColumn
            // 
            this.nOMRESPRODataGridViewTextBoxColumn.DataPropertyName = "NOMRES_PRO";
            this.nOMRESPRODataGridViewTextBoxColumn.HeaderText = "NOME DO RESPONSAVEL";
            this.nOMRESPRODataGridViewTextBoxColumn.Name = "nOMRESPRODataGridViewTextBoxColumn";
            this.nOMRESPRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // pROPRIEDADEBindingSource
            // 
            this.pROPRIEDADEBindingSource.DataSource = typeof(Agronomia.PROPRIEDADE);
            // 
            // FrmPropriedade
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(858, 380);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel1);
            this.Name = "FrmPropriedade";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Propriedade";
            this.Load += new System.EventHandler(this.FrmPropriedade_Load);
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).EndInit();
            this.panel2.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.pROPRIEDADEBindingSource)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.DataGridView GridView;
        private System.Windows.Forms.DataGridViewTextBoxColumn nOMEPRPRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn mUNICIPRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn eSTADOPRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn eNDEREPRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn cOMPLEPRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn tELEFOPRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn eMAILPPROPDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn nOMRESPRODataGridViewTextBoxColumn;
        private System.Windows.Forms.BindingSource pROPRIEDADEBindingSource;
        private System.Windows.Forms.Panel panel2;
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.Button btnCan;
        private System.Windows.Forms.Button btnDel;
        private System.Windows.Forms.Button btnEdit;
        private System.Windows.Forms.Button btnAdd;
    }
}