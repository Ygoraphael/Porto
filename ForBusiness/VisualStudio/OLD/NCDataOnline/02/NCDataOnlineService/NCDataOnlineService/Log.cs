using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace NCDataOnlineService
{
    public static class Log
    {
        // Fields
        private static object key = new object();

        // Methods
        public static void Write(string str, string logfile)
        {
            lock (key)
            {
                try
                {
                    FileInfo info = new FileInfo(logfile);
                    if (info.Length > 1048576)
                    {
                        string contents = Util.ReadAllText(logfile, 60, 1000);
                        File.WriteAllText(logfile + ".old", contents);
                        File.WriteAllText(logfile, "");
                    }
                }
                catch (Exception)
                {
                }
                StreamWriter writer = new StreamWriter(File.Open(logfile, FileMode.Append), Encoding.Default);
                writer.WriteLine(DateTime.Now.ToString("u") + ": " + str);
                writer.Close();
            }
        }
    }


}
