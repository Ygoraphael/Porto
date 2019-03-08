using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data.Odbc;

namespace ConsoleApplication4
{
    class Program
    {
        static void Main(string[] args)
        {
            OdbcConnection conn = new OdbcConnection();
            conn.ConnectionString =
            "Dsn=phc_2013;" +
            "Uid=sa;" +
            "Pwd=tl123;" +
            "Database=vmflex2012;";
            conn.Open();

            OdbcCommand cmd = new OdbcCommand("CREATE TABLE hgghgdf(sssf varchar(max))", conn);
            //cmd.ExecuteNonQuery();

            cmd = new OdbcCommand("insert into hgghgdf (sssf) values (?)", conn);
            cmd.Parameters.Add("?", OdbcType.VarChar).Value = "msg('working')";

            cmd.ExecuteScalar();

            //cmd = new OdbcCommand("select nome from cl where no = 1043", conn);
            //OdbcDataReader dr = cmd.ExecuteReader();

            //while (dr.Read())
            //{
            //    Console.WriteLine(dr[0].ToString());
            //}
            Console.ReadLine();
        }
    }
}
