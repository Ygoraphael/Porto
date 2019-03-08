using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.IO;
using System.Reflection;
using System.Threading;

namespace NCDataOnlineService
{
    public class Util
    {
        // Methods
        public static string CleanString(string texto)
        {
            return Regex.Replace(texto.ToLower(), "[^a-z0-9]+", string.Empty);
        }

        public static string GetDirectoryPath()
        {
            return (new DirectoryInfo(Path.GetDirectoryName(Assembly.GetAssembly(typeof(Util)).Location)).FullName + @"\");
        }

        public static string ReadAllText(string file, int retries = 60, int retries_pause = 1000)
        {
            bool flag = true;
            int num = 0;
            while (flag && (num < retries))
            {
                flag = false;
                num++;
                try
                {
                    using (Stream stream = new FileStream(file, FileMode.Open))
                    {
                        using (StreamReader reader = new StreamReader(stream, Encoding.UTF8))
                        {
                            return reader.ReadToEnd();
                        }
                    }
                }
                catch
                {
                    flag = true;
                    Thread.Sleep(retries_pause);
                }
            }
            throw new Exception("Util.ReadAllText" + Environment.NewLine + file + " não foi lido correctamente");
        }

        public static void WriteAllText(string file, string text, int retries = 60, int retries_pause = 1000)
        {
            bool flag = true;
            int num = 0;
            while (flag && (num < retries))
            {
                flag = false;
                num++;
                try
                {
                    using (Stream stream = new FileStream(file, FileMode.Create))
                    {
                        using (StreamWriter writer = new StreamWriter(stream, Encoding.UTF8))
                        {
                            writer.Write(text);
                            writer.Flush();
                        }
                    }
                }
                catch
                {
                    flag = true;
                    Thread.Sleep(retries_pause);
                }
            }
            if (flag)
            {
                throw new Exception("Util.WriteAllText" + Environment.NewLine + " não foi possível escrever em " + file);
            }
        }
    }
}
