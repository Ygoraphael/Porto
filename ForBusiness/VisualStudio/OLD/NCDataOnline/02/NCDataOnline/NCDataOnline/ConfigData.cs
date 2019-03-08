using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace NCDataOnline
{
    public class ConfigData
    {
        // Fields
        public Dictionary<string, Dictionary<string, string>> conexao = new Dictionary<string, Dictionary<string, string>>();
        public Dictionary<string, Dictionary<string, string>> ficheiroJson = new Dictionary<string, Dictionary<string, string>>();
        public Dictionary<string, Dictionary<string, string>> ficheiroXls = new Dictionary<string, Dictionary<string, string>>();
        public Dictionary<string, string> geral = new Dictionary<string, string>();
        public string name = string.Empty;
        public Dictionary<string, Dictionary<string, string>> query = new Dictionary<string, Dictionary<string, string>>();

        // Methods
        public bool HasName()
        {
            return (this.name != string.Empty);
        }
    }


}
