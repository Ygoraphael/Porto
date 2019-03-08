using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Newtonsoft.Json;

namespace NCDataOnline
{
    public static class Json
    {
        // Methods
        public static T Deserialize<T>(string json)
        {
            return JsonConvert.DeserializeObject<T>(json);
        }

        public static string Serialize<T>(T obj, bool indented = false)
        {
            return JsonConvert.SerializeObject(obj, indented ? Formatting.Indented : Formatting.None);
        }
    }


}
