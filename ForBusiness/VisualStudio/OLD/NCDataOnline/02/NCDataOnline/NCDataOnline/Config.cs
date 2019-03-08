using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;

namespace NCDataOnline
{
    public class Config
    {
        // Fields
        private Settings appSettings = new Settings(new Dictionary<string, string>(), "settings", true, "78x3s65a6de9d241", "d2c7cb7s5a74a48c");
        private ConfigData data = new ConfigData();
        private bool hasChanged;
        private List<string> ignoreChanges = new List<string>();
        private string key = "d2c7cb525a74a48c";
        private string salt = "78x3s65a6dc9d2x1";

        // Methods
        public bool AskAndSave(TabControl tabs)
        {
            if (this.hasChanged && this.data.HasName())
            {
                DlgQuestion question = new DlgQuestion("Foram realizadas alterações à configuração com nome: " + this.data.name + Environment.NewLine + "O que deseja fazer?", "", "Gravar", "Descartar", "Voltar", true);
                switch (question.ShowDialog())
                {
                    case DialogResult.Yes:
                        return this.Save(tabs);

                    case DialogResult.Cancel:
                        return false;
                }
            }
            return true;
        }

        public void ChangesMade()
        {
            if (this.data.HasName() && (this.ignoreChanges.Count == 0))
            {
                this.hasChanged = true;
            }
        }

        public bool CheckAndSetName(string name, out string messageText)
        {
            messageText = string.Empty;
            string texto = name.Trim();
            if (texto == string.Empty)
            {
                messageText = "O nome não pode ser uma string vazia.";
                return false;
            }
            this.data.name = texto;
            if (File.Exists(Util.CleanString(texto) + ".config"))
            {
                this.data.name = string.Empty;
                messageText = "Já existe uma configuração com o mesmo nome.";
                return false;
            }
            return true;
        }

        public void DeleteConfig(string file)
        {
            if (file != string.Empty)
            {
                File.Delete(file);
                File.Delete(file.Replace(".config", ".log"));
            }
        }

        public string GetConnection(string obj)
        {
            return this.data.query[obj]["conexao"];
        }

        public string GetName()
        {
            return this.data.name;
        }

        public string GetNextFreeSlotId()
        {
            List<int> list = new List<int>();
            foreach (KeyValuePair<string, Dictionary<string, string>> pair in this.data.query)
            {
                int result = -1;
                int.TryParse(pair.Value["destinoidQuery"], out result);
                if ((result != -1) && !list.Contains(result))
                {
                    list.Add(result);
                }
            }
            for (int i = 1; i <= 0x20; i++)
            {
                if (!list.Contains(i))
                {
                    return i.ToString();
                }
            }
            return string.Empty;
        }

        public bool HasChanges()
        {
            return this.hasChanged;
        }

        public bool HasConfigFiles()
        {
            DirectoryInfo info = new DirectoryInfo(Util.GetDirectoryPath());
            return (info.GetFiles("*.config").Length > 0);
        }

        public string[] ListOfConfigFiles()
        {
            DirectoryInfo info = new DirectoryInfo(Util.GetDirectoryPath());
            List<string> list = new List<string>();
            foreach (FileInfo info2 in info.GetFiles("*.config"))
            {
                list.Add(info2.Name);
            }
            return list.ToArray();
        }

        public string[] ListOfConnections()
        {
            return this.data.conexao.Keys.ToArray<string>();
        }

        public void Load(string file, TabControl tabs)
        {
            try
            {
                this.StartIgnoringChanges("_Load");
                string str = file.Trim();
                if (str != string.Empty)
                {
                    string cyphertext = Util.ReadAllText(str, 60, 0x3e8);
                    bool flag = true;
                    this.appSettings.GetSettingFromFile("UsesCrypt", out flag);
                    if (flag)
                    {
                        cyphertext = StringCipher.Decrypt(cyphertext, this.salt, this.key);
                    }
                    this.data = Json.Deserialize<ConfigData>(cyphertext);
                    foreach (TabPage page in tabs.TabPages)
                    {
                        this.WriteFormData(page, 0, true);
                    }
                }
            }
            catch (Exception exception)
            {
                new DlgMessage("Ocorreu uma excepção ao fazer Load de uma configuração:" + Environment.NewLine + exception.Message, "", "OK") { ShowInTaskbar = false }.ShowDialog();
            }
            finally
            {
                this.StopIgnoringChanges("_Load");
            }
        }

        public void ReadFormData(TabPage form, string selectedItem = "")
        {
            string key = string.Empty;
            string text = form.Text;
            if (text != null)
            {
                if (!(text == "Geral"))
                {
                    if (!(text == "Conexão"))
                    {
                        if ((((ListBox)form.Controls["listBox3"]).Items.Count > 0) && (((ListBox)form.Controls["listBox3"]).SelectedItem != null))
                        {
                            key = ((ListBox)form.Controls["listBox3"]).SelectedItem.ToString();
                            if (selectedItem != "")
                            {
                                key = selectedItem;
                            }
                            if (!this.data.query.ContainsKey(key))
                            {
                                this.data.query.Add(key, new Dictionary<string, string>());
                            }
                            this.data.query[key] = this.ReadFormTo(form);
                        }
                        return;
                    }
                    else
                    {
                        if ((((ListBox)form.Controls["listBox2"]).Items.Count > 0) && (((ListBox)form.Controls["listBox2"]).SelectedItem != null))
                        {
                            key = ((ListBox)form.Controls["listBox2"]).SelectedItem.ToString();
                            if (selectedItem != "")
                            {
                                key = selectedItem;
                            }
                            if (!this.data.conexao.ContainsKey(key))
                            {
                                this.data.conexao.Add(key, new Dictionary<string, string>());
                            }
                            this.data.conexao[key] = this.ReadFormTo(form);
                        }
                    }
                }
                else
                {
                    this.data.geral = this.ReadFormTo(form);
                    return;
                }
            }
        }

        private Dictionary<string, string> ReadFormTo(Control control)
        {
            Action<KeyValuePair<string, string>> action = null;
            Dictionary<string, string> tmp = new Dictionary<string, string>();
            foreach (Control control2 in control.Controls)
            {
                if (control2.GetType() == typeof(TextBox))
                {
                    tmp.Add(control2.Name, control2.Text);
                }
                if (control2.GetType() == typeof(ComboBox))
                {
                    if (((ComboBox) control2).Items.Count > 0)
                    {
                        tmp.Add(control2.Name, control2.Text);
                    }
                    else
                    {
                        tmp.Add(control2.Name, "");
                    }
                }
                if (control2.GetType() == typeof(CheckBox))
                {
                    tmp.Add(control2.Name, ((CheckBox) control2).Checked.ToString());
                }
                if (control2.Controls.Count > 0)
                {
                    if (action == null)
                    {
                        action = delegate (KeyValuePair<string, string> x) {
                            tmp[x.Key] = x.Value;
                        };
                    }
                    this.ReadFormTo(control2).ToList<KeyValuePair<string, string>>().ForEach(action);
                }
            }
            return tmp;
        }

        public void RemoveSelectedItem(TabPage form)
        {
            string text = form.Text;
            if (text != null)
            {
                if (!(text == "Conexão"))
                {
                    if (!(text == "Query"))
                    {
                        if (!(text == "Ficheiro JSON"))
                        {
                            if (text == "Ficheiro XLS")
                            {
                                this.RemoveSelectedItem(this.data.ficheiroXls, (ListBox) form.Controls["listBox5"]);
                            }
                            return;
                        }
                        this.RemoveSelectedItem(this.data.ficheiroJson, (ListBox) form.Controls["listBox4"]);
                        return;
                    }
                }
                else
                {
                    this.RemoveSelectedItem(this.data.conexao, (ListBox) form.Controls["listBox2"]);
                    return;
                }
                this.RemoveSelectedItem(this.data.query, (ListBox) form.Controls["listBox3"]);
            }
        }

        private void RemoveSelectedItem(Dictionary<string, Dictionary<string, string>> configData, ListBox listBox)
        {
            string key = string.Empty;
            int index = -1;
            if (listBox.Items.Count > 0)
            {
                key = listBox.SelectedItem.ToString();
                index = listBox.SelectedIndex;
                if (listBox.Items.Count > 1)
                {
                    if (index != 0)
                    {
                        listBox.SelectedItem = listBox.Items[0];
                    }
                    else
                    {
                        listBox.SelectedItem = listBox.Items[1];
                    }
                }
                configData.Remove(key);
                listBox.Items.RemoveAt(index);
            }
        }

        public bool Save(TabControl tabs)
        {
            if (this.data.HasName())
            {
                foreach (TabPage page in tabs.TabPages)
                {
                    this.ReadFormData(page, "");
                }
                string messageText = string.Empty;
                if (!this.Verify(out messageText))
                {
                    new DlgMessage(messageText, "", "OK") { ShowInTaskbar = false }.ShowDialog();
                    return false;
                }
                bool result = false;
                string plaintext = Json.Serialize<ConfigData>(this.data, bool.TryParse(this.data.geral["debug"], out result) && result);
                bool flag2 = true;
                this.appSettings.GetSettingFromFile("UsesCrypt", out flag2);
                if (flag2)
                {
                    plaintext = StringCipher.Encrypt(plaintext, this.salt, this.key);
                }
                Util.WriteAllText(Util.CleanString(this.data.name) + ".config", plaintext, 60, 0x3e8);
                this.hasChanged = false;
            }
            return true;
        }

        public void StartIgnoringChanges(string ignorekey)
        {
            if (!this.ignoreChanges.Contains(ignorekey))
            {
                this.ignoreChanges.Add(ignorekey);
            }
        }

        public void StopIgnoringChanges(string ignorekey)
        {
            if (this.ignoreChanges.Contains(ignorekey))
            {
                this.ignoreChanges.Remove(ignorekey);
            }
        }

        private bool Verify(out string messageText)
        {
            
            messageText = string.Empty;
            Dictionary<string, string> dictionary3 = new Dictionary<string, string>();
            dictionary3.Add("key", "API key");
            dictionary3.Add("hash", "Dashboard hash");
            Dictionary<string, string> dictionary = dictionary3;
            Dictionary<string, string> dictionary4 = new Dictionary<string, string>();
            dictionary4.Add("conexao", "Conexão");
            dictionary4.Add("intervaloQuery", "Intervalo em minutos");
            dictionary4.Add("sql", "SQL");
            dictionary4.Add("destinoidQuery", "ID de destino");
            dictionary4.Add("etiqueta", "Etiqueta Principal");
            Dictionary<string, string> dictionary2 = dictionary4;
            foreach (KeyValuePair<string, string> pair in dictionary)
            {
                if (this.data.geral[pair.Key] == string.Empty)
                {
                    messageText = "Tem de preencher no separador Geral o campo \"" + pair.Value + "\".";
                    return false;
                }
            }
            foreach (KeyValuePair<string, string> pair2 in dictionary2)
            {
                foreach (KeyValuePair<string, Dictionary<string, string>> pair3 in this.data.query)
                {
                    Console.WriteLine(pair3.Value["activoQuery"]);
                    if ((pair3.Value["activoQuery"] == "True") && (pair3.Value[pair2.Key] == string.Empty))
                    {
                        messageText = "Tem de preencher na configuração de Query com nome \"" + pair3.Key + "\" o campo \"" + pair2.Value + "\" ou desactivar esta Query.";
                        return false;
                    }
                }
            }
            List<string> list = new List<string>();
            List<string> list2 = new List<string>();
            foreach (KeyValuePair<string, Dictionary<string, string>> pair4 in this.data.query)
            {
                if (pair4.Value["activoQuery"] == "True")
                {
                    if (list.Contains(pair4.Value["destinoidQuery"]))
                    {
                        messageText = "Só pode utilizar a slot " + pair4.Value["destinoidQuery"] + " uma vez por dashboard.";
                        return false;
                    }
                    list.Add(pair4.Value["destinoidQuery"]);
                }
            }
            return true;
        }

        public void WriteFormData(TabPage form, int listItemIndex = 0, bool refreshList = true)
        {
            string text = form.Text;
            if (text != null)
            {
                if (!(text == "Geral"))
                {
                    if (!(text == "Conexão"))
                    {
                        if (!(text == "Query"))
                        {
                            if (!(text == "Ficheiro JSON"))
                            {
                                if ((text == "Ficheiro XLS") && ((this.data.ficheiroXls.Count > 0) && (listItemIndex >= 0)))
                                {
                                    if (refreshList)
                                    {
                                        ((ListBox) form.Controls["listBox5"]).Items.Clear();
                                        ((ListBox) form.Controls["listBox5"]).Items.AddRange(this.data.ficheiroXls.Keys.ToArray<string>());
                                        ((ListBox) form.Controls["listBox5"]).SelectedIndex = listItemIndex;
                                    }
                                    if ((this.data.ficheiroXls.Count > listItemIndex) && (((ListBox) form.Controls["listBox5"]).SelectedItem != null))
                                    {
                                        foreach (KeyValuePair<string, string> pair5 in this.data.ficheiroXls[((ListBox) form.Controls["listBox5"]).SelectedItem.ToString()])
                                        {
                                            this.WriteFormTo(form, pair5);
                                        }
                                    }
                                }
                                return;
                            }
                            if ((this.data.ficheiroJson.Count > 0) && (listItemIndex >= 0))
                            {
                                if (refreshList)
                                {
                                    ((ListBox) form.Controls["listBox4"]).Items.Clear();
                                    ((ListBox) form.Controls["listBox4"]).Items.AddRange(this.data.ficheiroJson.Keys.ToArray<string>());
                                    ((ListBox) form.Controls["listBox4"]).SelectedIndex = listItemIndex;
                                }
                                if ((this.data.ficheiroJson.Count > listItemIndex) && (((ListBox) form.Controls["listBox4"]).SelectedItem != null))
                                {
                                    foreach (KeyValuePair<string, string> pair4 in this.data.ficheiroJson[((ListBox) form.Controls["listBox4"]).SelectedItem.ToString()])
                                    {
                                        this.WriteFormTo(form, pair4);
                                    }
                                }
                            }
                            return;
                        }
                        if ((this.data.query.Count > 0) && (listItemIndex >= 0))
                        {
                            if (refreshList)
                            {
                                ((ListBox) form.Controls["listBox3"]).Items.Clear();
                                ((ListBox) form.Controls["listBox3"]).Items.AddRange(this.data.query.Keys.ToArray<string>());
                                ((ListBox) form.Controls["listBox3"]).SelectedIndex = listItemIndex;
                            }
                            if ((this.data.query.Count > listItemIndex) && (((ListBox) form.Controls["listBox3"]).SelectedItem != null))
                            {
                                foreach (KeyValuePair<string, string> pair3 in this.data.query[((ListBox) form.Controls["listBox3"]).SelectedItem.ToString()])
                                {
                                    this.WriteFormTo(form, pair3);
                                }
                            }
                        }
                        return;
                    }
                }
                else
                {
                    foreach (KeyValuePair<string, string> pair in this.data.geral)
                    {
                        this.WriteFormTo(form, pair);
                    }
                    return;
                }
                if ((this.data.conexao.Count > 0) && (listItemIndex >= 0))
                {
                    if (refreshList)
                    {
                        ((ListBox) form.Controls["listBox2"]).Items.Clear();
                        ((ListBox) form.Controls["listBox2"]).Items.AddRange(this.data.conexao.Keys.ToArray<string>());
                        ((ListBox) form.Controls["listBox2"]).SelectedIndex = listItemIndex;
                    }
                    if ((this.data.conexao.Count > listItemIndex) && (((ListBox) form.Controls["listBox2"]).SelectedItem != null))
                    {
                        foreach (KeyValuePair<string, string> pair2 in this.data.conexao[((ListBox) form.Controls["listBox2"]).SelectedItem.ToString()])
                        {
                            this.WriteFormTo(form, pair2);
                        }
                    }
                }
            }
        }

        private bool WriteFormTo(Control control, KeyValuePair<string, string> pair)
        {
            foreach (Control control2 in control.Controls)
            {
                if (control2.Name == pair.Key)
                {
                    if (control2.GetType() == typeof(TextBox))
                    {
                        control2.Text = pair.Value;
                    }
                    if (control2.GetType() == typeof(ComboBox))
                    {
                        ((ComboBox) control2).SelectedItem = pair.Value;
                    }
                    if (control2.GetType() == typeof(CheckBox))
                    {
                        ((CheckBox) control2).Checked = bool.Parse(pair.Value);
                    }
                    return true;
                }
                if ((control2.Controls.Count > 0) && this.WriteFormTo(control2, pair))
                {
                    return true;
                }
            }
            return false;
        }
    }
}
