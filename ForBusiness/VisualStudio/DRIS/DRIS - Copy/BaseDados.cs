using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;
using System.Data;
using System.Data.SQLite;

namespace EOR_DRIS
{
    public class BaseDados
    {

        public SQLiteConnection sqlite;

        public Boolean checkIfExistsDB(string path = "")
        {
            string curFile = "";

            if (path == "")
            {
                path = Application.StartupPath;
                curFile = @"" + path + "\\dris.db";
            }
            else
            {
                curFile = @"" + path;
            }

            return File.Exists(curFile) ? true : false;

        }

        public void Connect(string path = "")
        {
            string curFile = "";
            if (path == "")
            {
                path = Application.StartupPath;
                curFile = path + "\\dris.db";
            }
            else
            {
                curFile = path;
            }

            sqlite = new SQLiteConnection("Data Source=" + curFile + ";Version=3;");
        }

        public DataTable selectQuery(string query)
        {
            SQLiteDataAdapter ad;
            DataTable dt = new DataTable();

            try
            {
                SQLiteCommand cmd;
                sqlite.Open();
                cmd = sqlite.CreateCommand();
                cmd.CommandText = query;
                ad = new SQLiteDataAdapter(cmd);
                ad.Fill(dt);
            }
            catch(SQLiteException ex)
            {
                Console.WriteLine(ex);
            }

            sqlite.Close();
            return dt;
        }

        public void runQuery(string query)
        {
            try
            {
                SQLiteCommand cmd;
                sqlite.Open();
                cmd = sqlite.CreateCommand();
                cmd.CommandText = query;
                cmd.ExecuteNonQuery();
            }
            catch (SQLiteException ex)
            {
                Console.WriteLine(ex);
            }

            sqlite.Close();
        }

    }
}
