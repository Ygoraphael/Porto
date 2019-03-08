using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data.SqlClient;
using System.Data.Odbc;

namespace PHCMainInter
{
    class Program
    {

        public static OdbcConnection oODBCConnection;
        public static string db_database;

        public void DbConnect(string odbc, string db, string user, string pw)
        {
            string sConnString = "Dsn=" + odbc + ";" + "Uid=" + user + ";" + "Pwd=" + pw;
            oODBCConnection = new System.Data.Odbc.OdbcConnection(sConnString);
            db_database = db;
        }

        static void Main(string[] args)
        {
            string queryString = "USE " + db_database + "; SELECT ncont FROM e1;";
            OdbcCommand command = new OdbcCommand(queryString);
            command.Connection = oODBCConnection;
            oODBCConnection.Open();
            string tmp = "";

            OdbcDataReader myReader = command.ExecuteReader();
            if (myReader.HasRows)
            {
                tmp = myReader.GetString( myReader.GetOrdinal("ncont") );
                System.IO.File.WriteAllText(@"C:\Users\Tiago Loureiro\Desktop\WriteText.txt", tmp);
            }
        }
    }
}
