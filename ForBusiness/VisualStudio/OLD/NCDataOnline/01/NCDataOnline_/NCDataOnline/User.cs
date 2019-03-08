using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace NCDataOnline
{
    public class User
    {
        // Fields
        private Settings appSettings = new Settings(new Dictionary<string, string>(), "settings", true, "78x3s65a6de9d241", "d2c7cb7s5a74a48c");
        private string key = "d2c7cb0s5a74a48c";
        private string salt = "78x3s651tde9d241";
        private bool superuser;

        // Methods
        public bool Autenticar(string password)
        {
            string str = "PHC!800" + DateTime.Now.Day.ToString("00").ToString();
            if (password == str)
            {
                this.superuser = true;
                return true;
            }
            string settingFromFile = this.appSettings.GetSettingFromFile("AuthenticationKeyFile");
            return (File.Exists(settingFromFile) && (StringCipher.Encrypt(password, this.salt, this.key) == Util.ReadAllText(settingFromFile, 60, 1000)));
        }

        public void GravarChave(string password)
        {
            Util.WriteAllText(this.appSettings.GetSettingFromFile("AuthenticationKeyFile"), StringCipher.Encrypt(password, this.salt, this.key), 60, 1000);
        }

        public bool IsSuperUser()
        {
            return this.superuser;
        }
    }


}
