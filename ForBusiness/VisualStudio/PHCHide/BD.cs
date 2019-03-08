using System;
using System.Collections.Generic;
using System.Text;
using System.Data.SQLite;
using System.Windows.Forms;
using System.Data;
using System.Data.SqlClient;

namespace PHCHide
{

    public class BD
    {
        public SQLiteConnection sqlite;

        public void Connect(string path = "")
        {
            string curFile = "";
            if (path == "")
            {
                path = Application.StartupPath;
                curFile = path + "\\nc.db";
            }
            else
            {
                curFile = path;
            }

            sqlite = new SQLiteConnection("Data Source=" + curFile + ";Version=3;");
        }

        public string newid(string table)
        {
            SQLiteDataAdapter ad;
            DataTable dt = new DataTable();

            try
            {
                SQLiteCommand cmd;
                sqlite.Open();
                cmd = sqlite.CreateCommand();
                cmd.CommandText = "select max(id) + 1 from " + table;
                ad = new SQLiteDataAdapter(cmd);
                ad.Fill(dt);
            }
            catch (SQLiteException ex)
            {
                Console.WriteLine(ex);
            }

            sqlite.Close();
            return dt.Rows[0][0].ToString();
        }

        public int ExecuteNonQuery(string sql)
        {
            sqlite.Open();
            SQLiteCommand mycommand = new SQLiteCommand(sqlite);
            mycommand.CommandText = sql;
            int rowsUpdated = mycommand.ExecuteNonQuery();
            sqlite.Close();
            return rowsUpdated;
        }

        public void ExecuteNonQueryCmd(string sql, string arg1, string arg2)
        {
            SQLiteCommand cmd = new SQLiteCommand(sqlite);
            cmd.CommandText = sql;
            cmd.Parameters.AddWithValue("@v1", arg1);
            cmd.Parameters.AddWithValue("@v2", arg2);
            try {
                cmd.Connection.Open();
                cmd.ExecuteNonQuery();
            } 
            finally 
            {
                cmd.Connection.Close();
            }
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
            catch (SQLiteException ex)
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
