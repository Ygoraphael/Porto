using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data.OleDb;
using System.Data;

namespace VirtualRentExtra
{
    class BaseDados
    {
        Config configuracao = new Config();
        OleDbConnection conection;

        public BaseDados()
        {
            initialize_connection();
        }

        public void initialize_connection()
        {
            conection = new OleDbConnection("Provider=Microsoft.JET.OLEDB.4.0;" + "data source=" + configuracao.get_data("basedados") + "");
        }

        public DataTable select_query(string query)
        {
            var myDataTable = new DataTable();
            conection.Open();
            var command = new OleDbCommand(query, conection);
            var reader = command.ExecuteReader();

            myDataTable.Load(reader);
            conection.Close();
            return myDataTable;
        }

        public void open()
        {
            initialize_connection();
            conection.Open();
        }

        public void close()
        {
            conection.Close();
        }

        public void update_query(string query)
        {
            var command = new OleDbCommand(query, conection);
            command.ExecuteNonQuery();
        }
    }
}
