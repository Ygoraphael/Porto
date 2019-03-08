using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using System.Data.SqlClient;

namespace NCDataOnline
{
    class SQL
    {
        public static DataTable ExecutarSQL(SQLConnType connType, string connString, string sql)
        {
            if (connType == SQLConnType .MSSQL)
            {
                using (SqlConnection connection = new SqlConnection(connString))
                {
                    using (SqlCommand command = new SqlCommand(sql, connection))
                    {
                        connection.Open();
                        using (SqlDataAdapter adapter = new SqlDataAdapter(command))
                        {
                            DataTable dataTable = new DataTable();
                            adapter.Fill(dataTable);
                            return dataTable;
                        }
                    }
                }
            }
            return null;
        }

        public static string MakeMSSQLConnectionString(string user_id, string password, string server, string trusted, string database, string timeout = "30")
        {
            string[] source = new string[] { "yes", "no" };
            if (!source.Contains<string>(trusted))
            {
                trusted = "no";
            }
            return ("user id=" + user_id + ";password=" + password + ";server=" + server + ";Trusted_Connection=" + trusted + ";database=" + database + ";connection timeout=" + timeout);
        }

        public static bool TestarConexao(SQLConnType connType, string connString)
        {
            try
            {
                if (connType == SQLConnType.MSSQL)
                {
                    using (SqlConnection connection = new SqlConnection(connString))
                    {
                        connection.Open();
                    }
                }
                return true;
            }
            catch
            {
                return false;
            }
        }

    }
}
