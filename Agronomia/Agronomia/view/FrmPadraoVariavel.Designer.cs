namespace Agronomia.view
{
    partial class FrmPadraoVariavel
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
            this.nOMEPADRAOVARIAVEISBindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.lAVAR1PRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.lAVAR2PRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.lAVAR3PRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.lAVAR4PRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.lAVAR5PRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.lAVAR6PRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.lAVAR7PRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.lAVAR8PRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.lAVAR9PRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.lAVARAPRODataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.panel2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).BeginInit();
            this.panel1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.nOMEPADRAOVARIAVEISBindingSource)).BeginInit();
            this.SuspendLayout();
            // 
            // panel2
            // 
            this.panel2.Controls.Add(this.GridView);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel2.Location = new System.Drawing.Point(0, 0);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(1046, 345);
            this.panel2.TabIndex = 10;
            // 
            // GridView
            // 
            this.GridView.AllowUserToAddRows = false;
            this.GridView.AllowUserToDeleteRows = false;
            this.GridView.AutoGenerateColumns = false;
            this.GridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.GridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.lAVAR1PRODataGridViewTextBoxColumn,
            this.lAVAR2PRODataGridViewTextBoxColumn,
            this.lAVAR3PRODataGridViewTextBoxColumn,
            this.lAVAR4PRODataGridViewTextBoxColumn,
            this.lAVAR5PRODataGridViewTextBoxColumn,
            this.lAVAR6PRODataGridViewTextBoxColumn,
            this.lAVAR7PRODataGridViewTextBoxColumn,
            this.lAVAR8PRODataGridViewTextBoxColumn,
            this.lAVAR9PRODataGridViewTextBoxColumn,
            this.lAVARAPRODataGridViewTextBoxColumn});
            this.GridView.DataSource = this.nOMEPADRAOVARIAVEISBindingSource;
            this.GridView.Location = new System.Drawing.Point(5, 12);
            this.GridView.Name = "GridView";
            this.GridView.ReadOnly = true;
            this.GridView.Size = new System.Drawing.Size(1039, 327);
            this.GridView.TabIndex = 0;
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.btnCan);
            this.panel1.Controls.Add(this.btnDel);
            this.panel1.Controls.Add(this.btnEdit);
            this.panel1.Controls.Add(this.btnAdd);
            this.panel1.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.panel1.Location = new System.Drawing.Point(0, 347);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(1046, 31);
            this.panel1.TabIndex = 9;
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(962, 3);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 3;
            this.btnCan.Text = "&Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            this.btnCan.Click += new System.EventHandler(this.btnCan_Click);
            // 
            // btnDel
            // 
            this.btnDel.Location = new System.Drawing.Point(881, 3);
            this.btnDel.Name = "btnDel";
            this.btnDel.Size = new System.Drawing.Size(75, 23);
            this.btnDel.TabIndex = 2;
            this.btnDel.Text = "&Deletar";
            this.btnDel.UseVisualStyleBackColor = true;
            this.btnDel.Click += new System.EventHandler(this.btnDel_Click);
            // 
            // btnEdit
            // 
            this.btnEdit.Location = new System.Drawing.Point(800, 3);
            this.btnEdit.Name = "btnEdit";
            this.btnEdit.Size = new System.Drawing.Size(75, 23);
            this.btnEdit.TabIndex = 1;
            this.btnEdit.Text = "&Editar";
            this.btnEdit.UseVisualStyleBackColor = true;
            this.btnEdit.Click += new System.EventHandler(this.btnEdit_Click);
            // 
            // btnAdd
            // 
            this.btnAdd.Location = new System.Drawing.Point(719, 3);
            this.btnAdd.Name = "btnAdd";
            this.btnAdd.Size = new System.Drawing.Size(75, 23);
            this.btnAdd.TabIndex = 0;
            this.btnAdd.Text = "&Adicionar";
            this.btnAdd.UseVisualStyleBackColor = true;
            this.btnAdd.Click += new System.EventHandler(this.btnAdd_Click);
            // 
            // nOMEPADRAOVARIAVEISBindingSource
            // 
            this.nOMEPADRAOVARIAVEISBindingSource.DataSource = typeof(Agronomia.NOMEPADRAOVARIAVEIS);
            // 
            // lAVAR1PRODataGridViewTextBoxColumn
            // 
            this.lAVAR1PRODataGridViewTextBoxColumn.DataPropertyName = "LAVAR1_PRO";
            this.lAVAR1PRODataGridViewTextBoxColumn.HeaderText = "Variavel 1";
            this.lAVAR1PRODataGridViewTextBoxColumn.Name = "lAVAR1PRODataGridViewTextBoxColumn";
            this.lAVAR1PRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // lAVAR2PRODataGridViewTextBoxColumn
            // 
            this.lAVAR2PRODataGridViewTextBoxColumn.DataPropertyName = "LAVAR2_PRO";
            this.lAVAR2PRODataGridViewTextBoxColumn.HeaderText = "Variavel 2";
            this.lAVAR2PRODataGridViewTextBoxColumn.Name = "lAVAR2PRODataGridViewTextBoxColumn";
            this.lAVAR2PRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // lAVAR3PRODataGridViewTextBoxColumn
            // 
            this.lAVAR3PRODataGridViewTextBoxColumn.DataPropertyName = "LAVAR3_PRO";
            this.lAVAR3PRODataGridViewTextBoxColumn.HeaderText = "Variavel 3";
            this.lAVAR3PRODataGridViewTextBoxColumn.Name = "lAVAR3PRODataGridViewTextBoxColumn";
            this.lAVAR3PRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // lAVAR4PRODataGridViewTextBoxColumn
            // 
            this.lAVAR4PRODataGridViewTextBoxColumn.DataPropertyName = "LAVAR4_PRO";
            this.lAVAR4PRODataGridViewTextBoxColumn.HeaderText = "Variavel 4";
            this.lAVAR4PRODataGridViewTextBoxColumn.Name = "lAVAR4PRODataGridViewTextBoxColumn";
            this.lAVAR4PRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // lAVAR5PRODataGridViewTextBoxColumn
            // 
            this.lAVAR5PRODataGridViewTextBoxColumn.DataPropertyName = "LAVAR5_PRO";
            this.lAVAR5PRODataGridViewTextBoxColumn.HeaderText = "Variavel 5";
            this.lAVAR5PRODataGridViewTextBoxColumn.Name = "lAVAR5PRODataGridViewTextBoxColumn";
            this.lAVAR5PRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // lAVAR6PRODataGridViewTextBoxColumn
            // 
            this.lAVAR6PRODataGridViewTextBoxColumn.DataPropertyName = "LAVAR6_PRO";
            this.lAVAR6PRODataGridViewTextBoxColumn.HeaderText = "Variavel 6";
            this.lAVAR6PRODataGridViewTextBoxColumn.Name = "lAVAR6PRODataGridViewTextBoxColumn";
            this.lAVAR6PRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // lAVAR7PRODataGridViewTextBoxColumn
            // 
            this.lAVAR7PRODataGridViewTextBoxColumn.DataPropertyName = "LAVAR7_PRO";
            this.lAVAR7PRODataGridViewTextBoxColumn.HeaderText = "Variavel 7";
            this.lAVAR7PRODataGridViewTextBoxColumn.Name = "lAVAR7PRODataGridViewTextBoxColumn";
            this.lAVAR7PRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // lAVAR8PRODataGridViewTextBoxColumn
            // 
            this.lAVAR8PRODataGridViewTextBoxColumn.DataPropertyName = "LAVAR8_PRO";
            this.lAVAR8PRODataGridViewTextBoxColumn.HeaderText = "Variavel 8";
            this.lAVAR8PRODataGridViewTextBoxColumn.Name = "lAVAR8PRODataGridViewTextBoxColumn";
            this.lAVAR8PRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // lAVAR9PRODataGridViewTextBoxColumn
            // 
            this.lAVAR9PRODataGridViewTextBoxColumn.DataPropertyName = "LAVAR9_PRO";
            this.lAVAR9PRODataGridViewTextBoxColumn.HeaderText = "Variavel 9";
            this.lAVAR9PRODataGridViewTextBoxColumn.Name = "lAVAR9PRODataGridViewTextBoxColumn";
            this.lAVAR9PRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // lAVARAPRODataGridViewTextBoxColumn
            // 
            this.lAVARAPRODataGridViewTextBoxColumn.DataPropertyName = "LAVARA_PRO";
            this.lAVARAPRODataGridViewTextBoxColumn.HeaderText = "Variavel 10";
            this.lAVARAPRODataGridViewTextBoxColumn.Name = "lAVARAPRODataGridViewTextBoxColumn";
            this.lAVARAPRODataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // FrmPadraoVariavel
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1046, 378);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel1);
            this.Name = "FrmPadraoVariavel";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Nomes do Padrao Variavel utilizado no experimento";
            this.Load += new System.EventHandler(this.FrmPadraoVariavel_Load);
            this.panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).EndInit();
            this.panel1.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.nOMEPADRAOVARIAVEISBindingSource)).EndInit();
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
        private System.Windows.Forms.DataGridViewTextBoxColumn lAVAR1PRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn lAVAR2PRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn lAVAR3PRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn lAVAR4PRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn lAVAR5PRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn lAVAR6PRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn lAVAR7PRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn lAVAR8PRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn lAVAR9PRODataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn lAVARAPRODataGridViewTextBoxColumn;
        private System.Windows.Forms.BindingSource nOMEPADRAOVARIAVEISBindingSource;
    }
}