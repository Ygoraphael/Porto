namespace Agronomia.view
{
    partial class FrmCompeticao
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
            this.cODICULDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.nOMECOCOMDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cOMPETICAOBindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.panel1 = new System.Windows.Forms.Panel();
            this.btnCan = new System.Windows.Forms.Button();
            this.btnDel = new System.Windows.Forms.Button();
            this.btnEdit = new System.Windows.Forms.Button();
            this.btnAdd = new System.Windows.Forms.Button();
            this.panel2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.cOMPETICAOBindingSource)).BeginInit();
            this.panel1.SuspendLayout();
            this.SuspendLayout();
            // 
            // panel2
            // 
            this.panel2.Controls.Add(this.GridView);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel2.Location = new System.Drawing.Point(20, 60);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(469, 345);
            this.panel2.TabIndex = 8;
            // 
            // GridView
            // 
            this.GridView.AllowUserToAddRows = false;
            this.GridView.AllowUserToDeleteRows = false;
            this.GridView.AutoGenerateColumns = false;
            this.GridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.GridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.cODICULDataGridViewTextBoxColumn,
            this.nOMECOCOMDataGridViewTextBoxColumn});
            this.GridView.DataSource = this.cOMPETICAOBindingSource;
            this.GridView.Location = new System.Drawing.Point(5, 12);
            this.GridView.Name = "GridView";
            this.GridView.ReadOnly = true;
            this.GridView.Size = new System.Drawing.Size(316, 327);
            this.GridView.TabIndex = 0;
            // 
            // cODICULDataGridViewTextBoxColumn
            // 
            this.cODICULDataGridViewTextBoxColumn.DataPropertyName = "CODI_CUL";
            this.cODICULDataGridViewTextBoxColumn.HeaderText = "CULTURA";
            this.cODICULDataGridViewTextBoxColumn.Name = "cODICULDataGridViewTextBoxColumn";
            this.cODICULDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // nOMECOCOMDataGridViewTextBoxColumn
            // 
            this.nOMECOCOMDataGridViewTextBoxColumn.DataPropertyName = "NOMECO_COM";
            this.nOMECOCOMDataGridViewTextBoxColumn.HeaderText = "NOME COMPETICAO";
            this.nOMECOCOMDataGridViewTextBoxColumn.Name = "nOMECOCOMDataGridViewTextBoxColumn";
            this.nOMECOCOMDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cOMPETICAOBindingSource
            // 
            this.cOMPETICAOBindingSource.DataSource = typeof(Agronomia.COMPETICAO);
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.btnCan);
            this.panel1.Controls.Add(this.btnDel);
            this.panel1.Controls.Add(this.btnEdit);
            this.panel1.Controls.Add(this.btnAdd);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.panel1.Location = new System.Drawing.Point(20, 424);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(469, 31);
            this.panel1.TabIndex = 7;
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(246, 5);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 3;
            this.btnCan.Text = "&Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            this.btnCan.Click += new System.EventHandler(this.btnCan_Click);
            // 
            // btnDel
            // 
            this.btnDel.Location = new System.Drawing.Point(165, 5);
            this.btnDel.Name = "btnDel";
            this.btnDel.Size = new System.Drawing.Size(75, 23);
            this.btnDel.TabIndex = 2;
            this.btnDel.Text = "&Deletar";
            this.btnDel.UseVisualStyleBackColor = true;
            this.btnDel.Click += new System.EventHandler(this.btnDel_Click);
            // 
            // btnEdit
            // 
            this.btnEdit.Location = new System.Drawing.Point(84, 5);
            this.btnEdit.Name = "btnEdit";
            this.btnEdit.Size = new System.Drawing.Size(75, 23);
            this.btnEdit.TabIndex = 1;
            this.btnEdit.Text = "&Editar";
            this.btnEdit.UseVisualStyleBackColor = true;
            this.btnEdit.Click += new System.EventHandler(this.btnEdit_Click);
            // 
            // btnAdd
            // 
            this.btnAdd.Location = new System.Drawing.Point(3, 5);
            this.btnAdd.Name = "btnAdd";
            this.btnAdd.Size = new System.Drawing.Size(75, 23);
            this.btnAdd.TabIndex = 0;
            this.btnAdd.Text = "&Adicionar";
            this.btnAdd.UseVisualStyleBackColor = true;
            this.btnAdd.Click += new System.EventHandler(this.btnAdd_Click);
            // 
            // FrmCompeticao
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(509, 475);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel1);
            this.Name = "FrmCompeticao";
            this.Text = "Competicao";
            this.Load += new System.EventHandler(this.FrmCompeticao_Load);
            this.panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.cOMPETICAOBindingSource)).EndInit();
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
        private System.Windows.Forms.DataGridViewTextBoxColumn cODICULDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn nOMECOCOMDataGridViewTextBoxColumn;
        private System.Windows.Forms.BindingSource cOMPETICAOBindingSource;
    }
}