using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace NCDataOnlineService
{
    public class Settings
    {
        // Fields
        private Dictionary<string, string> data = new Dictionary<string, string>();
        private string file = "settings";
        private bool isCrypt = true;
        private string key = "d2c7cb7s5a74a48c";
        private string salt = "78x3s65a6de9d241";

        // Methods
        public Settings(Dictionary<string, string> whatData, string whatFile = "settings", bool isItCrypted = true, string whatSalt = "78x3s65a6de9d241", string whatKey = "d2c7cb7s5a74a48c")
        {
            if (whatFile == string.Empty)
            {
                throw new Exception("Settings.Settings" + Environment.NewLine + "whatFile tem que ser diferente de vazio");
            }
            if (isItCrypted)
            {
                if (whatSalt.Length != 16)
                {
                    throw new Exception("Settings.Settings" + Environment.NewLine + "whatSalt tem que ter 16 caracteres");
                }
                if (whatKey.Length != 16)
                {
                    throw new Exception("Settings.Settings" + Environment.NewLine + "whatKey tem que ter 16 caracteres");
                }
            }
            this.data = whatData;
            this.file = whatFile;
            this.isCrypt = isItCrypted;
            this.salt = whatSalt;
            this.key = whatKey;
            this.Load();
            this.Save();
        }

        public string GetSetting(string name)
        {
            if (!this.data.ContainsKey(name))
            {
                throw new Exception("Settings.GetSetting" + Environment.NewLine + name + " não é um indice de data");
            }
            return this.data[name];
        }

        public void GetSetting(string name, out bool value)
        {
            if (!this.data.ContainsKey(name))
            {
                throw new Exception("Settings.GetSetting" + Environment.NewLine + name + " não é um indice de data");
            }
            bool.TryParse(this.data[name], out value);
        }

        public string GetSettingFromFile(string name)
        {
            this.Load();
            return this.GetSetting(name);
        }

        public void GetSettingFromFile(string name, out bool value)
        {
            this.Load();
            this.GetSetting(name, out value);
        }

        public void Load()
        {
            string path = Util.GetDirectoryPath() + this.file;
            if (File.Exists(path))
            {
                string cyphertext = Util.ReadAllText(path, 60, 1000);
                if (this.isCrypt)
                {
                    cyphertext = StringCipher.Decrypt(cyphertext, this.salt, this.key);
                }
                this.data = Json.Deserialize<Dictionary<string, string>>(cyphertext);
            }
        }

        public void Save()
        {
            string plaintext = Json.Serialize<Dictionary<string, string>>(this.data, false);
            if (this.isCrypt)
            {
                plaintext = StringCipher.Encrypt(plaintext, this.salt, this.key);
            }
            Util.WriteAllText(Util.GetDirectoryPath() + this.file, plaintext, 60, 1000);
        }

        public void SetSetting(string name, string value, bool create = false)
        {
            if (this.data.ContainsKey(name))
            {
                this.data[name] = value;
            }
            else
            {
                if (!create)
                {
                    throw new Exception("Settings.SetSetting" + Environment.NewLine + name + " não é um indice de data e não foi marcada a opção para criar novo indice");
                }
                this.data.Add(name, value);
            }
        }

        public void SetSettingToFile(string name, string value, bool create = false)
        {
            this.Load();
            this.SetSetting(name, value, create);
            this.Save();
        }
    }
}
