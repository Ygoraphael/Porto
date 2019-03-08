using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data.SqlClient;
using System.Windows.Forms;
using System.Data;

namespace NCPHCTasks
{
    class BaseDados
    {
        public String Servidor;
        public String BDados;
        public String Utilizador;
        public String Password;
        public SqlConnection tmpconn;

        public void Teste(String f_servidor, String f_basedados, String f_utilizador, String f_password)
        {
            SqlConnectionStringBuilder connBuilder = new SqlConnectionStringBuilder();
            connBuilder.DataSource = f_servidor;
            connBuilder.InitialCatalog = f_basedados;
            connBuilder.IntegratedSecurity = false;
            connBuilder.UserID = f_utilizador;
            connBuilder.Password = f_password;

            try
            {
                SqlConnection conn = new SqlConnection(connBuilder.ToString());
                conn.Open();
                MessageBox.Show("Ligação ao ServidorSQL efetuada com sucesso", "SQLServer", MessageBoxButtons.OK, MessageBoxIcon.Information);
                conn.Close();
            }
            catch(Exception e)
            {
                Console.WriteLine(e);
                MessageBox.Show("Não consegui ligar ao ServidorSQL", "SQLServer", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
        }

        public DataTable GetData(String SqlQuery)
        {
            Servidor = Properties.Settings.Default.servidor;
            BDados = Properties.Settings.Default.basedados;
            Utilizador = Properties.Settings.Default.utilizador;
            Password = Properties.Settings.Default.password;

            SqlConnectionStringBuilder connBuilder = new SqlConnectionStringBuilder();
            connBuilder.DataSource = Servidor;
            connBuilder.InitialCatalog = BDados;
            connBuilder.IntegratedSecurity = false;
            connBuilder.UserID = Utilizador;
            connBuilder.Password = Password;

            SqlDataReader myReader = null;
            DataTable dt = new DataTable();

            try
            {
                SqlConnection conn = new SqlConnection(connBuilder.ToString());
                conn.Open();
                SqlCommand myCommand = new SqlCommand(SqlQuery, conn);
                myReader = myCommand.ExecuteReader();
                dt.Load(myReader);
                conn.Close();
                return dt;
            }
            catch (Exception e)
            {
                Console.WriteLine(e);
                return dt;
            }
        }

        public Boolean RunQuery(String SqlQuery)
        {
            Servidor = Properties.Settings.Default.servidor;
            BDados = Properties.Settings.Default.basedados;
            Utilizador = Properties.Settings.Default.utilizador;
            Password = Properties.Settings.Default.password;

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
            Servidor = Properties.Settings.Default.servidor;
            BDados = Properties.Settings.Default.basedados;
            Utilizador = Properties.Settings.Default.utilizador;
            Password = Properties.Settings.Default.password;

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

        public Boolean RunQueryWOC(String SqlQuery)
        {

            SqlCommand myCommand = new SqlCommand(SqlQuery, tmpconn);

            try
            {
                myCommand.ExecuteNonQuery();
                return true;
            }
            catch (Exception e)
            {
                Console.WriteLine(e);
                return false;
            }
        }

    }
}
