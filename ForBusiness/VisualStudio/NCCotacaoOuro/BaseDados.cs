using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data.SqlClient;
using System.Data;

namespace NCCotacaoOuro
{
    class BaseDados
    {
        public String Servidor;
        public String BDados;
        public String Utilizador;
        public String Password;
        public SqlConnection tmpconn;

        public Boolean RunQuery(String SqlQuery)
        {
            SqlConnectionStringBuilder connBuilder = new SqlConnectionStringBuilder();
            connBuilder.DataSource = Servidor;
            connBuilder.InitialCatalog = BDados;
            connBuilder.IntegratedSecurity = false;
            connBuilder.UserID = Utilizador;
            connBuilder.Password = Password;

            SqlConnection conn = new SqlConnection(connBuilder.ToString());
            conn.Open();
            SqlCommand myCommand = new SqlCommand(SqlQuery, conn);

            try
            {
                myCommand.ExecuteNonQuery();
                conn.Close();
                return true;
            }
            catch (Exception e)
            {
                Console.WriteLine(e);
                return false;
            }
        }

        public void Open()
        {
            SqlConnectionStringBuilder connBuilder = new SqlConnectionStringBuilder();
            connBuilder.DataSource = Servidor;
            connBuilder.InitialCatalog = BDados;
            connBuilder.IntegratedSecurity = false;
            connBuilder.UserID = Utilizador;
            connBuilder.Password = Password;

            tmpconn = new SqlConnection(connBuilder.ToString());
            tmpconn.Open();
        }

        public void Close()
        {
            tmpconn.Close();
        }
    }
}
