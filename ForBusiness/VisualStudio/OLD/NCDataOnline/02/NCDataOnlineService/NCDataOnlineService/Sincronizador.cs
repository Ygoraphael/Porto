using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using System.IO;
using System.Net;
using System.Collections.Specialized;
using System.Data.SqlClient;

namespace NCDataOnlineService
{
    public class Sincronizador
    {
        private ConfigData config = new ConfigData();
        private string configName = string.Empty;
        private string configFileName = string.Empty;
        private string configLogName = string.Empty;
        private static object key = new object();
        private Settings settings = new Settings(new Dictionary<string, string>(), "settings", true, "78x3s65a6de9d241", "d2c7cb7s5a74a48c");
        private Thread first;
        private Dictionary<string, System.Timers.Timer> timers = new Dictionary<string, System.Timers.Timer>();
        public void Start(string name)
        {
            try
            {
                this.configName = name;
                this.configLogName = Util.GetDirectoryPath() + Util.CleanString(this.configName) + ".log";
                this.configFileName = Util.GetDirectoryPath() + Util.CleanString(this.configName) + ".config";
                Log.Write("Windows Service do Sincronizador de Dados para NCDataOnline a arrancar", this.configLogName);
                this.UpdateConfig();
                this.first = new Thread((ThreadStart)delegate
                {
                    this.StartTimers();
                });
                this.first.IsBackground = true;
                this.first.Start();
            }
            catch (Exception ex)
            {
                this.ExceptionMessage(ex);
                this.Stop();
            }
        }
        public void Stop()
        {
            try
            {
                lock (Sincronizador.key)
                {
                    Log.Write("Windows Service do Sincronizador de Dados para NCDataOnline a parar", this.configLogName);
                    List<string> list = this.timers.Keys.ToList<string>();
                    foreach (string current in list)
                    {
                        if (this.timers[current] != null)
                        {
                            this.timers[current].Stop();
                            this.timers[current].Close();
                            this.timers[current] = null;
                        }
                    }
                    this.timers.Clear();
                    Log.Write("Windows Service do Sincronizador de Dados para NCDataOnline parou", this.configLogName);
                }
            }
            catch (Exception ex)
            {
                this.ExceptionMessage(ex);
            }
        }
        private void UpdateConfig()
        {
            if (!File.Exists(this.configFileName))
            {
                throw new Exception("Não existe ficheiro de configuração: " + this.configFileName);
            }
            DateTime lastWriteTime = File.GetLastWriteTime(this.configFileName);
            DateTime t = default(DateTime);
            DateTime.TryParse(this.settings.GetSettingFromFile("ConfigModifiedDate"), out t);
            if (t < lastWriteTime)
            {
                this.LoadConfig();
                this.PostRegcheck();
                this.settings.SetSettingToFile("ConfigModifiedDate", lastWriteTime.AddSeconds(1.0).ToString(), false);
                return;
            }
            if (this.config.geral.Count == 0)
            {
                this.LoadConfig();
            }
        }
        private void ExceptionMessage(Exception ex)
        {
            Log.Write(string.Concat(new string[]
			{
				"Ocorreu uma excepção:",
				Environment.NewLine,
				ex.Message,
				Environment.NewLine,
				Environment.NewLine,
				ex.StackTrace
			}), this.configLogName);
        }
        private void StartTimers()
        {
            lock (Sincronizador.key)
            {
                try
                {
                    foreach (KeyValuePair<string, Dictionary<string, string>> current in this.config.query)
                    {
                        if (this.config.geral["debug"] == "True")
                        {
                            this.RunQuery(current.Key);
                        }
                        else
                        {
                            this.timers.Add("query_" + current.Key, this.SetQueryTimer(current.Key));
                        }
                    }
                }
                catch (Exception ex)
                {
                    this.ExceptionMessage(ex);
                }
            }
        }
        private System.Timers.Timer SetQueryTimer(string name)
        {
            double num = 15.0;
            if (!this.config.query[name]["intervaloQuery"].Contains(",") && this.config.query[name]["intervaloQuery"].Contains("."))
            {
                this.config.query[name]["intervaloQuery"] = this.config.query[name]["intervaloQuery"].Replace(".", ",");
            }
            if (!double.TryParse(this.config.query[name]["intervaloQuery"], out num))
            {
                Log.Write("Query \"" + name + "\" tem um intervalo que não pode ser convertido para um número", this.configLogName);
                num = 15.0;
            }
            System.Timers.Timer timer = new System.Timers.Timer();
            timer.Interval = num * 60.0 * 1000.0;
            timer.Elapsed += delegate
            {
                this.RunQuery(name);
            };
            timer.Start();
            return timer;
        }
        private void LoadConfig()
        {
            try
            {
                if (File.Exists(this.configFileName))
                {
                    string text = Util.ReadAllText(this.configFileName, 60, 1000);
                    bool flag = true;
                    this.settings.GetSettingFromFile("UsesCrypt", out flag);
                    if (flag)
                    {
                        text = StringCipher.Decrypt(text, "78x3s65a6dc9d2x1", "d2c7cb525a74a48c");
                    }
                    this.config = Json.Deserialize<ConfigData>(text);
                }
            }
            catch (Exception ex)
            {
                this.ExceptionMessage(ex);
            }
        }
        private void PostRegcheck()
        {
            using (WebClient webClient = new WebClient())
            {
                NameValueCollection nameValueCollection = new NameValueCollection();
                nameValueCollection["api_key"] = this.config.geral["key"];
                nameValueCollection["register_check"] = Convert.ToBase64String(Encoding.ASCII.GetBytes(Util.ReadAllText(this.configFileName, 60, 1000)));
                string address = this.settings.GetSetting("PostRegcheckURL").Replace("[%hash%]", this.config.geral["hash"]);
                ServicePointManager.ServerCertificateValidationCallback += (sender, certificate, chain, sslPolicyErrors) => true;
                byte[] bytes = webClient.UploadValues(address, "POST", nameValueCollection);
                string @string = Encoding.ASCII.GetString(bytes);
                Dictionary<string, string> dictionary = Json.Deserialize<Dictionary<string, string>>(@string);
                if (!bool.Parse(dictionary["success"]))
                {
                    throw new Exception("Problemas no PostRegcheck: " + dictionary["error_message"]);
                }
            }
        }
        private void PostPush(string name, string json)
        {
            if (this.config.geral["hash"] == string.Empty || this.config.geral["key"] == string.Empty || this.config.query[name]["destinoidQuery"] == string.Empty)
            {
                throw new Exception("PostPush faltam dados necessários para efectuar o Push.");
            }
            using (WebClient webClient = new WebClient())
            {
                NameValueCollection nameValueCollection = new NameValueCollection();
                nameValueCollection["api_key"] = this.config.geral["key"];
                nameValueCollection["slot"] = this.config.query[name]["destinoidQuery"];
                nameValueCollection["data"] = json;
                string address = this.settings.GetSettingFromFile("PostPushURL").Replace("[%hash%]", this.config.geral["hash"]);
                byte[] bytes = webClient.UploadValues(address, "POST", nameValueCollection);
                ServicePointManager.ServerCertificateValidationCallback += (sender, certificate, chain, sslPolicyErrors) => true;
                string @string = Encoding.ASCII.GetString(bytes);
                Dictionary<string, string> dictionary = Json.Deserialize<Dictionary<string, string>>(@string);
                if (!bool.Parse(dictionary["success"]))
                {
                    Log.Write("Problemas no PostPush: " + dictionary["error_message"], this.configLogName);
                }
            }
        }
        private void RunQuery(string name)
        {
            lock (Sincronizador.key)
            {
                try
                {
                    this.UpdateConfig();
                    if (this.config.query[name]["activoQuery"] == "True")
                    {
                        if (this.config.query[name]["conexao"] == string.Empty || !this.config.conexao.ContainsKey(this.config.query[name]["conexao"]))
                        {
                            throw new Exception("RunQuery necessita uma conexão: " + this.config.query[name]["conexao"] + " não é uma conexão válida.");
                        }
                        this.DoQuery(name);
                    }
                }
                catch (SqlException ex)
                {
                    this.ExceptionMessage(ex);
                }
                catch (Exception ex2)
                {
                    this.ExceptionMessage(ex2);
                    if (this.config.geral["debug"] != "True")
                    {
                        this.timers[name].Stop();
                        this.timers[name].Close();
                    }
                }
            }
        }
        private void DoQuery(string name)
        {
            string text = this.config.query[name]["conexao"];
            string connectionString = SQL.MakeMSSQLConnectionString(this.config.conexao[text]["user"], this.config.conexao[text]["password"], this.config.conexao[text]["server"], (this.config.conexao[text]["trusted"] == "True") ? "yes" : "no", this.config.conexao[text]["bd"], "30");
            using (SqlConnection sqlConnection = new SqlConnection(connectionString))
            {
                sqlConnection.Open();
                SqlCommand sqlCommand = new SqlCommand(this.config.query[name]["sql"], sqlConnection);
                using (SqlDataReader sqlDataReader = sqlCommand.ExecuteReader())
                {
                    if (sqlDataReader.HasRows)
                    {
                        Dictionary<string, object> dictionary = new Dictionary<string, object>();
                        this.ReadDataFile(this.config.query[name]["ficheirosaida"], ref dictionary);
                        string text2 = this.config.query[name]["etiqueta"];
                        int num = 50;
                        int num2 = 10;
                        List<Dictionary<string, object>> list = new List<Dictionary<string, object>>();
                        int num3 = 1;
                        List<string> list2 = new List<string>();
                        while (num3 <= sqlDataReader.FieldCount && num3 <= num2)
                        {
                            string text3 = this.config.query[name]["val" + num3.ToString()];
                            if (!(text3 != string.Empty))
                            {
                                break;
                            }
                            list2.Add(text3);
                            num3++;
                        }
                        int num4 = 0;
                        while (sqlDataReader.Read() && sqlDataReader.FieldCount > 0 && num4 < num)
                        {
                            Dictionary<string, object> dictionary2 = new Dictionary<string, object>();
                            foreach (string current in list2)
                            {
                                dictionary2.Add(current, sqlDataReader[list2.IndexOf(current)]);
                            }
                            list.Add(dictionary2);
                            num4++;
                        }
                        if (!dictionary.ContainsKey(text2))
                        {
                            dictionary.Add(text2, null);
                        }
                        if ((this.config.query[name].ContainsKey("resultadoQuery") && this.config.query[name]["resultadoQuery"] == "Vários registos") || (!this.config.query[name].ContainsKey("resultadoQuery") && list.Count > 1))
                        {
                            dictionary[text2] = list;
                        }
                        else if ((this.config.query[name].ContainsKey("resultadoQuery") && this.config.query[name]["resultadoQuery"] == "Apenas um registo") || (!this.config.query[name].ContainsKey("resultadoQuery") && list.Count == 1))
                        {
                            dictionary[text2] = list[0];
                        }
                        else
                        {
                            dictionary[text2] = new Dictionary<string, object>();
                        }
                        this.WriteDataFile(this.config.query[name]["ficheirosaida"], dictionary);
                        Dictionary<string, object> obj = new Dictionary<string, object>
						{

							{
								text2,
								dictionary[text2]
							}
						};
                        string json = Json.Serialize<Dictionary<string, object>>(obj, this.config.geral["debug"] == "True");
                        this.PostPush(name, json);
                    }
                }
            }
        }
        private void ReadDataFile(string file, ref Dictionary<string, object> dados)
        {
            string text = string.Empty;
            if (File.Exists(file))
            {
                text = Util.ReadAllText(file, 60, 1000);
            }
            if (text != string.Empty)
            {
                dados = Json.Deserialize<Dictionary<string, object>>(text);
            }
        }
        private string WriteDataFile(string file, Dictionary<string, object> dados)
        {
            string text = Json.Serialize<Dictionary<string, object>>(dados, this.config.geral["debug"] == "True");
            if (file != string.Empty)
            {
                Util.WriteAllText(file, text, 60, 1000);
            }
            return text;
        }
    }
}
