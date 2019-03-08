using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Drawing;
using System.IO;
using System.Windows.Forms;

namespace NCDataOnline
{
    public partial class Form1 : Form
    {
        private Title title = new Title();
        private Settings appSettings = new Settings(new Dictionary<string, string>
		{
			
			{
				"UsesAuthentication",
				"True"
			},
			
			{
				"AuthenticationKeyFile",
				"app.key"
			},
			
			{
				"UsesCrypt",
				"True"
			},
			
			{
				"ConfigModifiedDate",
				"01-12-2014"
			},
			
			{
				"PostRegcheckURL",
				"https://dashboard.novoscanais.com/dashboard/[%hash%]/regcheck"
			},
			
			{
				"PostPushURL",
				"https://dashboard.novoscanais.com/dashboard/[%hash%]/push"
			}
		}, "settings", true, "78x3s65a6de9d241", "d2c7cb7s5a74a48c");
        private Config appConfig = new Config();
        private User appUser = new User();
        private Dictionary<string, string> lastSelected = new Dictionary<string, string>
		{
			
			{
				"listBox2",
				string.Empty
			},
			
			{
				"listBox3",
				string.Empty
			},
			
			{
				"listBox4",
				string.Empty
			},
			
			{
				"listBox5",
				string.Empty
			}
		};
        
        public Form1()
        {
            this.InitializeComponent();
            this.title.SetAppTitle(this.Text);
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            try
            {
                bool flag = true;
                this.appSettings.GetSettingFromFile("UsesAuthentication", out flag);
                if (flag)
                {
                    DlgInput dlgInput = new DlgInput("Chave Sincronizador", "", "Autenticar", "Cancelar", "", true);
                    dlgInput.Icon = base.Icon;
                    dlgInput.StartPosition = FormStartPosition.CenterScreen;
                    DialogResult dialogResult = dlgInput.ShowDialog();
                    if (dialogResult == DialogResult.OK)
                    {
                        if (!this.appUser.Autenticar(dlgInput.inputText))
                        {
                            new DlgMessage("Chave inválida.", "", "OK")
                            {
                                Icon = base.Icon,
                                StartPosition = FormStartPosition.CenterScreen
                            }.ShowDialog();
                            base.Close();
                        }
                    }
                    else
                    {
                        base.Close();
                    }
                }
                if (!this.appUser.IsSuperUser())
                {
                    this.propriedadesToolStripMenuItem.Enabled = false;
                }
                this.NoConfigActions();
                if (this.appConfig.HasConfigFiles())
                {
                    string[] array = this.appConfig.ListOfConfigFiles();
                    this.appConfig.Load(array[0], this.tabControl1);
                    this.AfterLoadingConfig();
                }
                this.intervaloQuery.LostFocus += new EventHandler(this.intervaloTextBox_LostFocus);
                this.destinoidQuery.LostFocus += new EventHandler(this.slotTextBox_LostFocus);
                this.val1.LostFocus += new EventHandler(this.etiquetasTextBox_LostFocus);
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, base.Icon, FormStartPosition.CenterScreen);
                base.Close();
            }
        }
        private void Form1_FormClosing(object sender, FormClosingEventArgs e)
        {
            try
            {
                if (!this.appConfig.AskAndSave(this.tabControl1))
                {
                    e.Cancel = true;
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void novaToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                if (this.appConfig.AskAndSave(this.tabControl1))
                {
                    this.NoConfigActions();
                    DlgInput dlgInput = new DlgInput("Nome para a nova configuração", "", "OK", "Cancelar", "", false);
                    dlgInput.ShowInTaskbar = false;
                    DialogResult dialogResult = dlgInput.ShowDialog();
                    DialogResult dialogResult2 = dialogResult;
                    if (dialogResult2 == DialogResult.OK)
                    {
                        string empty = string.Empty;
                        if (this.appConfig.CheckAndSetName(dlgInput.inputText, out empty))
                        {
                            this.appConfig.ChangesMade();
                            this.AfterLoadingConfig();
                        }
                        else
                        {
                            new DlgMessage(empty, "", "OK")
                            {
                                ShowInTaskbar = false
                            }.ShowDialog();
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void abrirToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                if (this.appConfig.HasConfigFiles())
                {
                    if (this.appConfig.AskAndSave(this.tabControl1))
                    {
                        string[] array = this.appConfig.ListOfConfigFiles();
                        DlgSelect dlgSelect = new DlgSelect("Escolha a configuração a abrir", array, array[0], "", "Abrir", "Cancelar");
                        dlgSelect.ShowInTaskbar = false;
                        DialogResult dialogResult = dlgSelect.ShowDialog();
                        DialogResult dialogResult2 = dialogResult;
                        if (dialogResult2 == DialogResult.OK)
                        {
                            this.NoConfigActions();
                            this.appConfig.Load(dlgSelect.selectedText, this.tabControl1);
                            this.AfterLoadingConfig();
                        }
                    }
                }
                else
                {
                    new DlgMessage("Não existem configurações.", "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void guardarToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                this.appConfig.Save(this.tabControl1);
                this.Text = this.title.GetAppTitle(this.appConfig);
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void guardarComoToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                if (this.appConfig.GetName() != string.Empty)
                {
                    DlgInput dlgInput = new DlgInput("Nome para a nova configuração", "", "Criar", "Cancelar", "", false);
                    dlgInput.ShowInTaskbar = false;
                    DialogResult dialogResult = dlgInput.ShowDialog();
                    if (dialogResult == DialogResult.OK)
                    {
                        string empty = string.Empty;
                        if (this.appConfig.CheckAndSetName(dlgInput.inputText, out empty))
                        {
                            this.appConfig.Save(this.tabControl1);
                            this.Text = this.title.GetAppTitle(this.appConfig);
                        }
                        else
                        {
                            new DlgMessage(empty, "", "OK")
                            {
                                ShowInTaskbar = false
                            }.ShowDialog();
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void apagarToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                if (this.appConfig.HasConfigFiles())
                {
                    string[] array = this.appConfig.ListOfConfigFiles();
                    DlgSelect dlgSelect = new DlgSelect("Configuração a apagar", array, array[0], "", "Apagar", "Cancelar");
                    dlgSelect.ShowInTaskbar = false;
                    DialogResult dialogResult = dlgSelect.ShowDialog();
                    if (dialogResult == DialogResult.OK)
                    {
                        Service.Uninstall(dlgSelect.selectedText, "NCDataOnlineService.exe");
                        this.appConfig.DeleteConfig(dlgSelect.selectedText);
                        if (dlgSelect.selectedText == Util.CleanString(this.appConfig.GetName()) + ".config")
                        {
                            this.NoConfigActions();
                        }
                    }
                }
                else
                {
                    new DlgMessage("Não existem configurações.", "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void iniciarToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                if (this.appConfig.AskAndSave(this.tabControl1) && !Service.Start(this.appConfig.GetName()))
                {
                    new DlgMessage("Não foi encontrado o serviço com nome: " + this.appConfig.GetName() + Environment.NewLine + "O serviço não arrancou.", "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void pararToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                if (!Service.Stop(this.appConfig.GetName()))
                {
                    new DlgMessage("Não foi encontrado o serviço com nome: " + this.appConfig.GetName(), "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void estadoToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                string empty = string.Empty;
                if (!Service.State(this.appConfig.GetName(), out empty))
                {
                    new DlgMessage("Não foi encontrado o serviço com nome: " + this.appConfig.GetName(), "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
                if (empty != string.Empty)
                {
                    new DlgMessage("O serviço com nome \"" + this.appConfig.GetName() + "\" está " + empty, "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void instalarToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                if (this.appConfig.Save(this.tabControl1))
                {
                    this.Text = this.title.GetAppTitle(this.appConfig);
                    string info = "Serviço do Sincronizador de Dados para o NCDataOnline. [Nome da configuração: " + this.appConfig.GetName() + "]";
                    if (!Service.Install(this.appConfig.GetName(), info, "NCDataOnlineService.exe"))
                    {
                        new DlgMessage("Foi encontrado um serviço com o nome: " + this.appConfig.GetName(), "", "OK")
                        {
                            ShowInTaskbar = false
                        }.ShowDialog();
                    }
                }
                else
                {
                    new DlgMessage("Não foi possível instalar o serviço pois existem erros na configuração.", "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void desinstalarToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                if (!Service.Uninstall(this.appConfig.GetName(), "NCDataOnlineService.exe"))
                {
                    new DlgMessage("Não foi encontrado o serviço com nome: " + this.appConfig.GetName(), "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void abrirToolStripMenuItem1_Click(object sender, EventArgs e)
        {
            try
            {
                string text = this.appConfig.GetName() + ".log";
                if (File.Exists(text))
                {
                    Process.Start(new ProcessStartInfo("cmd.exe", "/C tail \"" + text + "\"")
                    {
                        CreateNoWindow = true,
                        UseShellExecute = false
                    });
                }
                else
                {
                    new DlgMessage("Não existe ficheiro de log.", "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void limparToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                string path = this.appConfig.GetName() + ".log";
                if (File.Exists(path))
                {
                    File.WriteAllText(path, string.Empty);
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void propriedadesToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                bool flag = true;
                this.appSettings.GetSettingFromFile("UsesAuthentication", out flag);
                if ((flag && this.appUser.IsSuperUser()) || !flag)
                {
                    DlgProperties dlgProperties = new DlgProperties();
                    dlgProperties.ShowDialog();
                }
                else
                {
                    new DlgMessage("Acesso negado.", "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                    this.propriedadesToolStripMenuItem.Enabled = false;
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void sairToolStripMenuItem_Click(object sender, EventArgs e)
        {
            base.Close();
        }
        private void sobreToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                new DlgWeb(string.Format("file:///{0}\\docs\\index.htm", Directory.GetCurrentDirectory()), "Tópicos de Ajuda")
                {
                    StartPosition = FormStartPosition.CenterScreen,
                    ShowInTaskbar = true,
                    Icon = base.Icon
                }.Show();
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void informaçãoDeSuporteToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                new DlgWeb(string.Format("file:///{0}\\docs\\index.htm", Directory.GetCurrentDirectory()), "Tópicos de Ajuda")
                {
                    StartPosition = FormStartPosition.CenterScreen,
                    ShowInTaskbar = true,
                    Icon = base.Icon
                }.Show();
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void sobreOSincronizadorDeDadosToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                new DlgWeb(string.Format("file:///{0}\\docs\\index.htm", Directory.GetCurrentDirectory()), "Tópicos de Ajuda")
                {
                    StartPosition = FormStartPosition.CenterScreen,
                    ShowInTaskbar = true,
                    Icon = base.Icon
                }.Show();
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void novoObj_Click(object sender, EventArgs e)
        {
            try
            {
                ListBox selectedTabListBox = FormAuxFunc.GetSelectedTabListBox(this.tabControl1);
                string text = this.tabControl1.SelectedTab.Text;
                DlgInput dlgInput = new DlgInput("Nome para o novo objecto do tipo " + text, "", "OK", "Cancelar", "", false);
                dlgInput.ShowInTaskbar = false;
                DialogResult dialogResult = dlgInput.ShowDialog();
                if (dialogResult == DialogResult.OK)
                {
                    if (!selectedTabListBox.Items.Contains(dlgInput.inputText))
                    {
                        this.appConfig.ChangesMade();
                        this.Text = this.title.GetAppTitle(this.appConfig);
                        selectedTabListBox.Items.Add(dlgInput.inputText);
                        selectedTabListBox.SelectedItem = dlgInput.inputText;
                        FormAuxFunc.ClearForm(this.tabControl1.SelectedTab);
                        this.etiqueta.Text = Util.CleanString(dlgInput.inputText);
                        FormAuxFunc.UpdateConnectionComboBox(this.listBox2, this.conexao);
                        if (this.tabControl1.SelectedTab.Name == "tabPage3")
                        {
                            this.resultadoQuery.SelectedIndex = 1;
                            this.destinoidQuery.Text = this.appConfig.GetNextFreeSlotId();
                        }
                    }
                    else
                    {
                        new DlgMessage("Já existe um objecto do tipo " + text + " com o nome: " + dlgInput.inputText, "", "OK")
                        {
                            ShowInTaskbar = false
                        }.ShowDialog();
                    }
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void clonarObj_Click(object sender, EventArgs e)
        {
            try
            {
                ListBox selectedTabListBox = FormAuxFunc.GetSelectedTabListBox(this.tabControl1);
                string text = this.tabControl1.SelectedTab.Text;
                DlgInput dlgInput = new DlgInput("Nome para o novo objecto do tipo " + text, "", "OK", "Cancelar", "", false);
                dlgInput.ShowInTaskbar = false;
                DialogResult dialogResult = dlgInput.ShowDialog();
                if (dialogResult == DialogResult.OK)
                {
                    if (!selectedTabListBox.Items.Contains(dlgInput.inputText))
                    {
                        this.appConfig.ChangesMade();
                        this.Text = this.title.GetAppTitle(this.appConfig);
                        selectedTabListBox.Items.Add(dlgInput.inputText);
                        selectedTabListBox.SelectedItem = dlgInput.inputText;
                    }
                    else
                    {
                        new DlgMessage("Já existe um objecto do tipo " + text + " com o nome: " + dlgInput.inputText, "", "OK")
                        {
                            ShowInTaskbar = false
                        }.ShowDialog();
                    }
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void apagarObj_Click(object sender, EventArgs e)
        {
            try
            {
                ListBox selectedTabListBox = FormAuxFunc.GetSelectedTabListBox(this.tabControl1);
                if (selectedTabListBox.Items.Count > 0)
                {
                    this.appConfig.RemoveSelectedItem(this.tabControl1.SelectedTab);
                    if (selectedTabListBox.Items.Count == 0)
                    {
                        FormAuxFunc.ClearForm(this.tabControl1.SelectedTab);
                    }
                    this.appConfig.ChangesMade();
                    this.Text = this.title.GetAppTitle(this.appConfig);
                }
                FormAuxFunc.UpdateConnectionComboBox(this.listBox2, this.conexao);
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void testarConexao_Click(object sender, EventArgs e)
        {
            try
            {
                if (!this.backgroundWorker1.IsBusy)
                {
                    this.backgroundWorker1.RunWorkerAsync();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void helpToolStripButton_Click(object sender, EventArgs e)
        {
            try
            {
                new DlgWeb(string.Format("file:///{0}\\docs\\index.htm", Directory.GetCurrentDirectory()), "Tópicos de Ajuda")
                {
                    StartPosition = FormStartPosition.CenterScreen,
                    ShowInTaskbar = true,
                    Icon = base.Icon
                }.Show();
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void executarSql_Click(object sender, EventArgs e)
        {
            try
            {
                if (!this.backgroundWorker2.IsBusy)
                {
                    this.backgroundWorker2.RunWorkerAsync();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void toolStripButton7_Click(object sender, EventArgs e)
        {
            try
            {
                new DlgWeb(string.Format("file:///{0}\\docs\\index.htm", Directory.GetCurrentDirectory()), "Tópicos de Ajuda")
                {
                    StartPosition = FormStartPosition.CenterScreen,
                    ShowInTaskbar = true,
                    Icon = base.Icon
                }.Show();
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void toolStripButton14_Click(object sender, EventArgs e)
        {
            try
            {
                new DlgWeb(string.Format("file:///{0}\\docs\\index.htm", Directory.GetCurrentDirectory()), "Tópicos de Ajuda")
                {
                    StartPosition = FormStartPosition.CenterScreen,
                    ShowInTaskbar = true,
                    Icon = base.Icon
                }.Show();
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void toolStripButton19_Click(object sender, EventArgs e)
        {
            try
            {
                new DlgWeb(string.Format("file:///{0}\\docs\\index.htm", Directory.GetCurrentDirectory()), "Tópicos de Ajuda")
                {
                    StartPosition = FormStartPosition.CenterScreen,
                    ShowInTaskbar = true,
                    Icon = base.Icon
                }.Show();
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void viewpassword_MouseDown(object sender, MouseEventArgs e)
        {
            this.password.UseSystemPasswordChar = false;
        }
        private void viewpassword_MouseUp(object sender, MouseEventArgs e)
        {
            this.password.UseSystemPasswordChar = true;
        }
        private void escolherficheiro_Click(object sender, EventArgs e)
        {
            try
            {
                OpenFileDialog openFileDialog = new OpenFileDialog();
                openFileDialog.InitialDirectory = Util.GetDirectoryPath();
                openFileDialog.Multiselect = false;
                openFileDialog.Title = "Escolher ficheiro";
                DialogResult dialogResult = openFileDialog.ShowDialog();
                string name;
                if (dialogResult == DialogResult.OK && (name = this.tabControl1.SelectedTab.Name) != null && name == "tabPage3")
                {
                    this.ficheirosaida.Text = openFileDialog.FileName;
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void verficheiro_Click(object sender, EventArgs e)
        {
            try
            {
                string text = string.Empty;
                string name;
                if ((name = this.tabControl1.SelectedTab.Name) != null && name == "tabPage3")
                {
                    text = this.ficheirosaida.Text;
                }
                if (File.Exists(text))
                {
                    Process.Start(new ProcessStartInfo("cmd.exe", "/C tail \"" + text + "\"")
                    {
                        CreateNoWindow = true,
                        UseShellExecute = false
                    });
                }
                else
                {
                    new DlgMessage("O ficheiro \"" + text + "\" não existe.", "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void limparficheiro_Click(object sender, EventArgs e)
        {
            try
            {
                string text = string.Empty;
                string name;
                if ((name = this.tabControl1.SelectedTab.Name) != null && name == "tabPage3")
                {
                    text = this.ficheirosaida.Text;
                }
                if (File.Exists(text))
                {
                    Util.WriteAllText(text, string.Empty, 60, 1000);
                }
                else
                {
                    new DlgMessage("O ficheiro \"" + text + "\" não existe.", "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void listBox_SelectedIndexChanged(object sender, EventArgs e)
        {
            try
            {
                string name = ((ListBox)sender).Name;
                ListBox listBox = (ListBox)sender;
                try
                {
                    this.appConfig.StartIgnoringChanges(name + "_SelectedIndexChanged");
                    if (listBox.Items.Count > 0)
                    {
                        foreach (Control control in this.tabControl1.SelectedTab.Controls)
                        {
                            if (control.GetType() == typeof(GroupBox))
                            {
                                control.Enabled = true;
                            }
                        }
                        if (this.lastSelected[name] != string.Empty)
                        {
                            this.appConfig.ReadFormData(this.tabControl1.SelectedTab, this.lastSelected[name]);
                        }
                        this.appConfig.WriteFormData(this.tabControl1.SelectedTab, listBox.SelectedIndex, false);
                    }
                    else
                    {
                        foreach (Control control2 in this.tabControl1.SelectedTab.Controls)
                        {
                            if (control2.GetType() == typeof(GroupBox))
                            {
                                control2.Enabled = false;
                            }
                        }
                    }
                }
                catch (Exception ex)
                {
                    FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
                }
                finally
                {
                    this.appConfig.StopIgnoringChanges(name + "_SelectedIndexChanged");
                    if (listBox.Items.Count > 0)
                    {
                        this.lastSelected[name] = listBox.SelectedItem.ToString();
                    }
                    else
                    {
                        this.lastSelected[name] = string.Empty;
                    }
                    if (name == "listBox2")
                    {
                        FormAuxFunc.UpdateConnectionComboBox(listBox, this.conexao);
                    }
                }
            }
            catch (Exception ex2)
            {
                FormAuxFunc.ExceptionMessage(ex2, null, FormStartPosition.CenterParent);
            }
        }
        private void tabControl1_SelectedIndexChanged(object sender, EventArgs e)
        {
            try
            {
                if (this.listBox2.SelectedItem != null)
                {
                    this.appConfig.ReadFormData(this.tabControl1.TabPages["tabPage2"], this.listBox2.SelectedItem.ToString());
                }
                if (this.listBox3.SelectedItem != null)
                {
                    this.appConfig.ReadFormData(this.tabControl1.TabPages["tabPage3"], this.listBox3.SelectedItem.ToString());
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, null, FormStartPosition.CenterParent);
            }
        }
        private void Control_Changed(object sender, EventArgs e)
        {
            this.appConfig.ChangesMade();
            this.Text = this.title.GetAppTitle(this.appConfig);
        }
        private void intervaloTextBox_LostFocus(object sender, EventArgs e)
        {
            double num;
            if (double.TryParse(((Control)sender).Text.Replace('.', ','), out num))
            {
                if (num < 0.5)
                {
                    ((Control)sender).Text = "0.5";
                    return;
                }
                if (num > 1440.0)
                {
                    ((Control)sender).Text = "1440";
                    return;
                }
            }
            else
            {
                ((Control)sender).Text = "1";
            }
        }
        private void slotTextBox_LostFocus(object sender, EventArgs e)
        {
            if (((Control)sender).GetType() == typeof(TextBox))
            {
                string a = "Slot";
                if (a == "Slot")
                {
                    int num;
                    if (int.TryParse(((Control)sender).Text, out num))
                    {
                        if (num < 1)
                        {
                            ((Control)sender).Text = "1";
                        }
                        else if (num > 32)
                        {
                            ((Control)sender).Text = "32";
                        }
                    }
                    else
                    {
                        ((Control)sender).Text = "1";
                    }
                }
            }
            if (((Control)sender).GetType() == typeof(ComboBox))
            {
                string text = ((Control)sender).Text;
                string text2 = string.Empty;
                string name2;
                if ((name2 = this.tabControl1.SelectedTab.Name) != null && name2 == "tabPage3")
                {
                    text2 = this.destinoidQuery.Text;
                }
                if (text == "Slot")
                {
                    int num;
                    if (int.TryParse(text2, out num))
                    {
                        if (num < 1)
                        {
                            text2 = "1";
                        }
                        else if (num > 32)
                        {
                            text2 = "32";
                        }
                    }
                    else
                    {
                        text2 = "1";
                    }
                }
                string name3;
                if ((name3 = this.tabControl1.SelectedTab.Name) != null)
                {
                    if (!(name3 == "tabPage3"))
                    {
                        return;
                    }
                    this.destinoidQuery.Text = text2;
                }
            }
        }
        private void etiquetasTextBox_LostFocus(object sender, EventArgs e)
        {
            ((Control)sender).Text = Util.CleanString(((Control)sender).Text);
        }
        private void NoConfigActions()
        {
            this.guardarToolStripMenuItem.Enabled = false;
            this.guardarComoToolStripMenuItem.Enabled = false;
            this.serviçoWindowsToolStripMenuItem.Enabled = false;
            this.logToolStripMenuItem.Enabled = false;
            this.toolStrip1.Enabled = false;
            this.toolStrip2.Enabled = false;
            this.contextMenuStrip1.Enabled = false;
            this.contextMenuStrip2.Enabled = false;
            this.contextMenuStrip3.Enabled = false;
            this.contextMenuStrip4.Enabled = false;
            this.escolherficheirosaida.Enabled = false;
            this.verficheirosaida.Enabled = false;
            this.limparficheirosaida.Enabled = false;
            this.listBox1.Items.Clear();
            this.listBox2.Items.Clear();
            this.listBox3.Items.Clear();
            foreach (TabPage tabPage in this.tabControl1.TabPages)
            {
                FormAuxFunc.ClearForm(tabPage);
                foreach (Control control in tabPage.Controls)
                {
                    control.Enabled = false;
                }
            }
            List<object> list = new List<object>();
            list.AddRange(this.lastSelected.Keys);
            using (List<object>.Enumerator enumerator3 = list.GetEnumerator())
            {
                while (enumerator3.MoveNext())
                {
                    string text = (string)enumerator3.Current;
                    this.lastSelected[text] = string.Empty;
                }
            }
            this.appConfig = new Config();
            this.Text = this.title.GetAppTitle(this.appConfig);
        }
        private void AfterLoadingConfig()
        {
            foreach (TabPage tabPage in this.tabControl1.TabPages)
            {
                foreach (Control control in tabPage.Controls)
                {
                    control.Enabled = true;
                }
            }
            if (this.listBox2.Items.Count > 0)
            {
                this.lastSelected["listBox2"] = this.listBox2.SelectedItem.ToString();
            }
            else
            {
                foreach (Control control2 in this.tabControl1.TabPages[1].Controls)
                {
                    if (control2.GetType() == typeof(GroupBox))
                    {
                        control2.Enabled = false;
                    }
                }
            }
            if (this.listBox3.Items.Count > 0)
            {
                this.lastSelected["listBox3"] = this.listBox3.SelectedItem.ToString();
            }
            else
            {
                foreach (Control control3 in this.tabControl1.TabPages[2].Controls)
                {
                    if (control3.GetType() == typeof(GroupBox))
                    {
                        control3.Enabled = false;
                    }
                }
            }
            this.Text = this.title.GetAppTitle(this.appConfig);
            this.guardarToolStripMenuItem.Enabled = true;
            this.guardarComoToolStripMenuItem.Enabled = true;
            this.serviçoWindowsToolStripMenuItem.Enabled = true;
            this.logToolStripMenuItem.Enabled = true;
            this.toolStrip1.Enabled = true;
            this.toolStrip2.Enabled = true;
            this.contextMenuStrip1.Enabled = true;
            this.contextMenuStrip2.Enabled = true;
            this.contextMenuStrip3.Enabled = true;
            this.contextMenuStrip4.Enabled = true;
            this.escolherficheirosaida.Enabled = true;
            this.verficheirosaida.Enabled = true;
            this.limparficheirosaida.Enabled = true;
        }
        private void backgroundWorker1_DoWork(object sender, DoWorkEventArgs e)
        {
            string text = ThreadSafe.DisableToolStripButton(this.toolStrip1, this.pasteToolStripButton, "A testar...");
            try
            {
                string connString = SQL.MakeMSSQLConnectionString(ThreadSafe.GetTextControl(this.user), ThreadSafe.GetTextControl(this.password), ThreadSafe.GetTextControl(this.server), ThreadSafe.GetCheckedValue(this.trusted) ? "yes" : "no", ThreadSafe.GetTextControl(this.bd), "30");
                e.Result = SQL.TestarConexao(SQLConnType.MSSQL, connString);
            }
            finally
            {
                ThreadSafe.EnableToolStripButton(this.toolStrip1, this.pasteToolStripButton, text);
            }
        }
        private void backgroundWorker1_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            if (e.Result != null && e.Result.GetType() == typeof(bool))
            {
                if ((bool)e.Result)
                {
                    new DlgMessage("Conexão bem sucedida.", "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                    return;
                }
                new DlgMessage("A conexão falhou.", "", "OK")
                {
                    ShowInTaskbar = false
                }.ShowDialog();
            }
        }
        private void backgroundWorker2_DoWork(object sender, DoWorkEventArgs e)
        {
            string text = ThreadSafe.DisableToolStripButton(this.toolStrip2, this.toolStripButton6, "A executar...");
            try
            {
                string connString = SQL.MakeMSSQLConnectionString(ThreadSafe.GetTextControl(this.user), ThreadSafe.GetTextControl(this.password), ThreadSafe.GetTextControl(this.server), ThreadSafe.GetCheckedValue(this.trusted) ? "yes" : "no", ThreadSafe.GetTextControl(this.bd), "30");
                if (ThreadSafe.GetTextControl(this.sql) != string.Empty)
                {
                    DataTable result = SQL.ExecutarSQL(SQLConnType.MSSQL, connString, ThreadSafe.GetTextControl(this.sql));
                    e.Result = result;
                }
                else
                {
                    e.Result = "Tem de preencher o campo \"SQL\".";
                    ThreadSafe.FocusControl(this.sql);
                }
            }
            catch (Exception ex)
            {
                FormAuxFunc.ExceptionMessage(ex, base.Icon, FormStartPosition.CenterScreen);
            }
            finally
            {
                ThreadSafe.EnableToolStripButton(this.toolStrip2, this.toolStripButton6, text);
            }
        }
        private void backgroundWorker2_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            if (e.Result != null)
            {
                if (e.Result.GetType() == typeof(DataTable))
                {
                    new DlgDataGrid(e.Result as DataTable, "")
                    {
                        Icon = base.Icon,
                        StartPosition = FormStartPosition.CenterScreen,
                        ShowInTaskbar = true
                    }.Show();
                    return;
                }
                if (e.Result.GetType() == typeof(string))
                {
                    new DlgMessage(e.Result as string, "", "OK")
                    {
                        ShowInTaskbar = false
                    }.ShowDialog();
                }
            }
        }

        private void Form1_FormClosed(object sender, FormClosedEventArgs e)
        {
            Application.Exit();
        }

        private void tipo_basedados_TextChanged(object sender, EventArgs e)
        {
            this.appConfig.ChangesMade();
            this.Text = this.title.GetAppTitle(this.appConfig);
        }
    }
}
