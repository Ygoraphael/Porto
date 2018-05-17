namespace Agronomia.view
{
    partial class FrmUsuario
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
            this.lOGINUSUDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.sENHAUSUDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.nOMEUSUDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.tELEFONEUSUDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.cOMPLEMENTOUSUDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.sTATUSDataGridViewTextBoxColumn = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.uSUARIOBindingSource = new System.Windows.Forms.BindingSource(this.components);
            this.panel1 = new System.Windows.Forms.Panel();
            this.btnCan = new System.Windows.Forms.Button();
            this.btnDel = new System.Windows.Forms.Button();
            this.btnEdit = new System.Windows.Forms.Button();
            this.btnAdd = new System.Windows.Forms.Button();
            this.panel2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.uSUARIOBindingSource)).BeginInit();
            this.panel1.SuspendLayout();
            this.SuspendLayout();
            // 
            // panel2
            // 
            this.panel2.Controls.Add(this.GridView);
            this.panel2.Dock = System.Windows.Forms.DockStyle.Top;
            this.panel2.Location = new System.Drawing.Point(0, 0);
            this.panel2.Name = "panel2";
            this.panel2.Size = new System.Drawing.Size(676, 345);
            this.panel2.TabIndex = 6;
            // 
            // GridView
            // 
            this.GridView.AllowUserToAddRows = false;
            this.GridView.AllowUserToDeleteRows = false;
            this.GridView.AutoGenerateColumns = false;
            this.GridView.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.GridView.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.lOGINUSUDataGridViewTextBoxColumn,
            this.sENHAUSUDataGridViewTextBoxColumn,
            this.nOMEUSUDataGridViewTextBoxColumn,
            this.tELEFONEUSUDataGridViewTextBoxColumn,
            this.cOMPLEMENTOUSUDataGridViewTextBoxColumn,
            this.sTATUSDataGridViewTextBoxColumn});
            this.GridView.DataSource = this.uSUARIOBindingSource;
            this.GridView.Location = new System.Drawing.Point(5, 12);
            this.GridView.Name = "GridView";
            this.GridView.ReadOnly = true;
            this.GridView.Size = new System.Drawing.Size(659, 327);
            this.GridView.TabIndex = 0;
            // 
            // lOGINUSUDataGridViewTextBoxColumn
            // 
            this.lOGINUSUDataGridViewTextBoxColumn.DataPropertyName = "LOGIN_USU";
            this.lOGINUSUDataGridViewTextBoxColumn.HeaderText = "LOGIN";
            this.lOGINUSUDataGridViewTextBoxColumn.Name = "lOGINUSUDataGridViewTextBoxColumn";
            this.lOGINUSUDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // sENHAUSUDataGridViewTextBoxColumn
            // 
            this.sENHAUSUDataGridViewTextBoxColumn.DataPropertyName = "SENHA_USU";
            this.sENHAUSUDataGridViewTextBoxColumn.HeaderText = "SENHA";
            this.sENHAUSUDataGridViewTextBoxColumn.Name = "sENHAUSUDataGridViewTextBoxColumn";
            this.sENHAUSUDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // nOMEUSUDataGridViewTextBoxColumn
            // 
            this.nOMEUSUDataGridViewTextBoxColumn.DataPropertyName = "NOME_USU";
            this.nOMEUSUDataGridViewTextBoxColumn.HeaderText = "NOME";
            this.nOMEUSUDataGridViewTextBoxColumn.Name = "nOMEUSUDataGridViewTextBoxColumn";
            this.nOMEUSUDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // tELEFONEUSUDataGridViewTextBoxColumn
            // 
            this.tELEFONEUSUDataGridViewTextBoxColumn.DataPropertyName = "TELEFONE_USU";
            this.tELEFONEUSUDataGridViewTextBoxColumn.HeaderText = "TELEFONE";
            this.tELEFONEUSUDataGridViewTextBoxColumn.Name = "tELEFONEUSUDataGridViewTextBoxColumn";
            this.tELEFONEUSUDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // cOMPLEMENTOUSUDataGridViewTextBoxColumn
            // 
            this.cOMPLEMENTOUSUDataGridViewTextBoxColumn.DataPropertyName = "COMPLEMENTO_USU";
            this.cOMPLEMENTOUSUDataGridViewTextBoxColumn.HeaderText = "COMPLEMENTO";
            this.cOMPLEMENTOUSUDataGridViewTextBoxColumn.Name = "cOMPLEMENTOUSUDataGridViewTextBoxColumn";
            this.cOMPLEMENTOUSUDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // sTATUSDataGridViewTextBoxColumn
            // 
            this.sTATUSDataGridViewTextBoxColumn.DataPropertyName = "STATUS";
            this.sTATUSDataGridViewTextBoxColumn.HeaderText = "STATUS";
            this.sTATUSDataGridViewTextBoxColumn.Name = "sTATUSDataGridViewTextBoxColumn";
            this.sTATUSDataGridViewTextBoxColumn.ReadOnly = true;
            // 
            // uSUARIOBindingSource
            // 
            this.uSUARIOBindingSource.DataSource = typeof(Agronomia.USUARIO);
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
            this.panel1.Size = new System.Drawing.Size(676, 31);
            this.panel1.TabIndex = 5;
            // 
            // btnCan
            // 
            this.btnCan.Location = new System.Drawing.Point(596, 3);
            this.btnCan.Name = "btnCan";
            this.btnCan.Size = new System.Drawing.Size(75, 23);
            this.btnCan.TabIndex = 3;
            this.btnCan.Text = "&Cancelar";
            this.btnCan.UseVisualStyleBackColor = true;
            this.btnCan.Click += new System.EventHandler(this.btnCan_Click);
            // 
            // btnDel
            // 
            this.btnDel.Location = new System.Drawing.Point(515, 3);
            this.btnDel.Name = "btnDel";
            this.btnDel.Size = new System.Drawing.Size(75, 23);
            this.btnDel.TabIndex = 2;
            this.btnDel.Text = "&Deletar";
            this.btnDel.UseVisualStyleBackColor = true;
            this.btnDel.Click += new System.EventHandler(this.btnDel_Click);
            // 
            // btnEdit
            // 
            this.btnEdit.Location = new System.Drawing.Point(434, 3);
            this.btnEdit.Name = "btnEdit";
            this.btnEdit.Size = new System.Drawing.Size(75, 23);
            this.btnEdit.TabIndex = 1;
            this.btnEdit.Text = "&Editar";
            this.btnEdit.UseVisualStyleBackColor = true;
            this.btnEdit.Click += new System.EventHandler(this.btnEdit_Click);
            // 
            // btnAdd
            // 
            this.btnAdd.Location = new System.Drawing.Point(353, 3);
            this.btnAdd.Name = "btnAdd";
            this.btnAdd.Size = new System.Drawing.Size(75, 23);
            this.btnAdd.TabIndex = 0;
            this.btnAdd.Text = "&Adicionar";
            this.btnAdd.UseVisualStyleBackColor = true;
            this.btnAdd.Click += new System.EventHandler(this.btnAdd_Click);
            // 
            // FrmUsuario
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(676, 380);
            this.Controls.Add(this.panel2);
            this.Controls.Add(this.panel1);
            this.Name = "FrmUsuario";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Usuarios";
            this.Load += new System.EventHandler(this.FrmUsuarios_Load);
            this.panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.GridView)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.uSUARIOBindingSource)).EndInit();
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
        private System.Windows.Forms.BindingSource uSUARIOBindingSource;
        private System.Windows.Forms.DataGridViewTextBoxColumn lOGINUSUDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn sENHAUSUDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn nOMEUSUDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn tELEFONEUSUDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn cOMPLEMENTOUSUDataGridViewTextBoxColumn;
        private System.Windows.Forms.DataGridViewTextBoxColumn sTATUSDataGridViewTextBoxColumn;
    }
}