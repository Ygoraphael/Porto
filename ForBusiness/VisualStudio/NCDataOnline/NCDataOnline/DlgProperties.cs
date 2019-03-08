using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Drawing;
using System.Windows.Forms;
using System.ComponentModel;

namespace NCDataOnline
{
    public class DlgProperties : Form
    {
        // Fields
        private Settings appSettings = new Settings(new Dictionary<string, string>(), "settings", true, "78x3s65a6de9d241", "d2c7cb7s5a74a48c");
        private CheckBox authCheck;
        private Button button1;
        private Button button2;
        private Button button3;
        private CheckBox crypthCheck;
        private TextBox ficheiroChave;
        private GroupBox groupBox1;
        private GroupBox groupBox2;
        private Label label1;
        private Label label2;
        private Label label3;
        private TextBox urlCheck;
        private TextBox urlPush;

        // Methods
        public DlgProperties()
        {
            this.InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            this.appSettings.SetSettingToFile("AuthenticationKeyFile", this.ficheiroChave.Text, false);
            this.appSettings.SetSettingToFile("UsesAuthentication", this.authCheck.Checked.ToString(), false);
            this.appSettings.SetSettingToFile("UsesCrypt", this.crypthCheck.Checked.ToString(), false);
            this.appSettings.SetSettingToFile("PostRegcheckURL", this.urlCheck.Text, false);
            this.appSettings.SetSettingToFile("PostPushURL", this.urlPush.Text, false);
            base.Close();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            base.Close();
        }

        private void button3_Click(object sender, EventArgs e)
        {
            DlgInput input = new DlgInput("Nova chave de utilizador para o sincronizador", "", "Gravar", "Cancelar", "", true)
            {
                ShowInTaskbar = false
            };
            if (input.ShowDialog() == DialogResult.OK)
            {
                try
                {
                    if (input.inputText.Length >= 3)
                    {
                        new User().GravarChave(input.inputText);
                    }
                    else
                    {
                        new DlgMessage("Chave inválida." + Environment.NewLine + "A chave deve ter no mínimo 3 caracteres.", "", "OK").ShowDialog();
                    }
                }
                catch (Exception exception)
                {
                    new DlgMessage("Não foi possível gerar uma nova chave de utilizador:" + Environment.NewLine + exception.Message, "", "OK").ShowDialog();
                }
            }
        }

        private void DlgProperties_Load(object sender, EventArgs e)
        {
            this.ficheiroChave.Text = this.appSettings.GetSettingFromFile("AuthenticationKeyFile");
            bool flag = true;
            this.appSettings.GetSettingFromFile("UsesAuthentication", out flag);
            this.authCheck.Checked = flag;
            bool flag2 = true;
            this.appSettings.GetSettingFromFile("UsesCrypt", out flag2);
            this.crypthCheck.Checked = flag2;
            this.urlCheck.Text = this.appSettings.GetSettingFromFile("PostRegcheckURL");
            this.urlPush.Text = this.appSettings.GetSettingFromFile("PostPushURL");
        }

        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(DlgProperties));
            this.groupBox1 = new System.Windows.Forms.GroupBox();
            this.crypthCheck = new System.Windows.Forms.CheckBox();
            this.authCheck = new System.Windows.Forms.CheckBox();
            this.button3 = new System.Windows.Forms.Button();
            this.label1 = new System.Windows.Forms.Label();
            this.ficheiroChave = new System.Windows.Forms.TextBox();
            this.button1 = new System.Windows.Forms.Button();
            this.button2 = new System.Windows.Forms.Button();
            this.groupBox2 = new System.Windows.Forms.GroupBox();
            this.label3 = new System.Windows.Forms.Label();
            this.urlPush = new System.Windows.Forms.TextBox();
            this.label2 = new System.Windows.Forms.Label();
            this.urlCheck = new System.Windows.Forms.TextBox();
            this.groupBox1.SuspendLayout();
            this.groupBox2.SuspendLayout();
            this.SuspendLayout();
            // 
            // groupBox1
            // 
            this.groupBox1.Controls.Add(this.crypthCheck);
            this.groupBox1.Controls.Add(this.authCheck);
            this.groupBox1.Controls.Add(this.button3);
            this.groupBox1.Controls.Add(this.label1);
            this.groupBox1.Controls.Add(this.ficheiroChave);
            this.groupBox1.Location = new System.Drawing.Point(12, 12);
            this.groupBox1.Name = "groupBox1";
            this.groupBox1.Size = new System.Drawing.Size(360, 109);
            this.groupBox1.TabIndex = 0;
            this.groupBox1.TabStop = false;
            this.groupBox1.Text = "Segurança";
            // 
            // crypthCheck
            // 
            this.crypthCheck.AutoSize = true;
            this.crypthCheck.Location = new System.Drawing.Point(9, 87);
            this.crypthCheck.Name = "crypthCheck";
            this.crypthCheck.Size = new System.Drawing.Size(194, 17);
            this.crypthCheck.TabIndex = 4;
            this.crypthCheck.Text = "Encriptar o ficheiro de configuração";
            this.crypthCheck.UseVisualStyleBackColor = true;
            // 
            // authCheck
            // 
            this.authCheck.AutoSize = true;
            this.authCheck.Location = new System.Drawing.Point(9, 64);
            this.authCheck.Name = "authCheck";
            this.authCheck.Size = new System.Drawing.Size(264, 17);
            this.authCheck.TabIndex = 3;
            this.authCheck.Text = "Pedir para introduzir chave ao abrir o sincronizador";
            this.authCheck.UseVisualStyleBackColor = true;
            // 
            // button3
            // 
            this.button3.Location = new System.Drawing.Point(254, 36);
            this.button3.Name = "button3";
            this.button3.Size = new System.Drawing.Size(100, 23);
            this.button3.TabIndex = 2;
            this.button3.Text = "Gerar chave";
            this.button3.UseVisualStyleBackColor = true;
            this.button3.Click += new System.EventHandler(this.button3_Click);
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(6, 22);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(232, 13);
            this.label1.TabIndex = 1;
            this.label1.Text = "Nome do ficheiro com a chave do sincronizador";
            // 
            // ficheiroChave
            // 
            this.ficheiroChave.Location = new System.Drawing.Point(9, 38);
            this.ficheiroChave.Name = "ficheiroChave";
            this.ficheiroChave.Size = new System.Drawing.Size(239, 20);
            this.ficheiroChave.TabIndex = 0;
            // 
            // button1
            // 
            this.button1.Location = new System.Drawing.Point(114, 247);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(75, 23);
            this.button1.TabIndex = 7;
            this.button1.Text = "Gravar";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // button2
            // 
            this.button2.Location = new System.Drawing.Point(195, 247);
            this.button2.Name = "button2";
            this.button2.Size = new System.Drawing.Size(75, 23);
            this.button2.TabIndex = 8;
            this.button2.Text = "Fechar";
            this.button2.UseVisualStyleBackColor = true;
            this.button2.Click += new System.EventHandler(this.button2_Click);
            // 
            // groupBox2
            // 
            this.groupBox2.Controls.Add(this.label3);
            this.groupBox2.Controls.Add(this.urlPush);
            this.groupBox2.Controls.Add(this.label2);
            this.groupBox2.Controls.Add(this.urlCheck);
            this.groupBox2.Location = new System.Drawing.Point(12, 127);
            this.groupBox2.Name = "groupBox2";
            this.groupBox2.Size = new System.Drawing.Size(360, 114);
            this.groupBox2.TabIndex = 3;
            this.groupBox2.TabStop = false;
            this.groupBox2.Text = "Endereços NCDataOnline";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(6, 67);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(81, 13);
            this.label3.TabIndex = 3;
            this.label3.Text = "Envio de dados";
            // 
            // urlPush
            // 
            this.urlPush.Location = new System.Drawing.Point(9, 83);
            this.urlPush.Name = "urlPush";
            this.urlPush.Size = new System.Drawing.Size(345, 20);
            this.urlPush.TabIndex = 6;
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(6, 22);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(122, 13);
            this.label2.TabIndex = 1;
            this.label2.Text = "Validação/Autenticação";
            // 
            // urlCheck
            // 
            this.urlCheck.Location = new System.Drawing.Point(9, 38);
            this.urlCheck.Name = "urlCheck";
            this.urlCheck.Size = new System.Drawing.Size(345, 20);
            this.urlCheck.TabIndex = 5;
            // 
            // DlgProperties
            // 
            this.ClientSize = new System.Drawing.Size(384, 282);
            this.Controls.Add(this.groupBox2);
            this.Controls.Add(this.button2);
            this.Controls.Add(this.button1);
            this.Controls.Add(this.groupBox1);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.MaximizeBox = false;
            this.MinimizeBox = false;
            this.Name = "DlgProperties";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterParent;
            this.Text = "Propriedades";
            this.Load += new System.EventHandler(this.DlgProperties_Load);
            this.groupBox1.ResumeLayout(false);
            this.groupBox1.PerformLayout();
            this.groupBox2.ResumeLayout(false);
            this.groupBox2.PerformLayout();
            this.ResumeLayout(false);

        }
    }


}
