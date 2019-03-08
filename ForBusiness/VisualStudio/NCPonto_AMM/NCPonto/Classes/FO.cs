using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data.SqlClient;
using System.Data;

namespace NCPonto.Classes
{
    class FO
    {
        string strconn = Properties.Settings.Default.StrCon;
        private int numerofo;
        public FO(int numerofo)
        {
            NumeroFO = numerofo;
        }
        public int NumeroFO
        {
            get { return numerofo; }
            set { numerofo = value; }
        }        

        public string DataQuery(DateTime data)
        {
            return data.Year + "-" + data.Month + "-" + data.Day;
        }
        public DataSet MostraTarefas()
        {
            SqlConnection conn = new SqlConnection(strconn);
            string cb = "Select * from BO (nolock) where ndos=12 and fechada=0 and obrano=@ObraNo";
            SqlDataAdapter da = new SqlDataAdapter(cb, conn);
            da.SelectCommand.Parameters.Add(new SqlParameter("@ObraNo", SqlDbType.Int)).Value = numerofo;

            DataSet ds = new DataSet();
            da.Fill(ds, "BO");
            if (ds.Tables["BO"].Rows.Count > 0)
            {
                DataRow dr = ds.Tables["BO"].Rows[0];
                int ano = int.Parse(dr["boano"].ToString());
                DataSet dst = CarregaTarefas(numerofo, ano );
                
                return dst;
            }
            else
            {
                return new DataSet();
            }
        }

        public DataSet CarregaTarefas(int numerofo, int ano)
        {
            SqlConnection conn = new SqlConnection(strconn);
            string cb = "Select Design as Tarefa, Ref, bistamp from BI (nolock) where year(dataobra)=@boano and obrano=@ObraNO and ndos=12 and lobs3<>'Concluída' and Familia=@Familia";
            SqlDataAdapter da = new SqlDataAdapter(cb, conn);
            da.SelectCommand.Parameters.Add(new SqlParameter("@ObraNo", SqlDbType.VarChar)).Value = numerofo;
            da.SelectCommand.Parameters.Add(new SqlParameter("@Familia", SqlDbType.VarChar)).Value = "TRABALHOS";
            da.SelectCommand.Parameters.Add(new SqlParameter("@BOAno", SqlDbType.Int)).Value = ano;
            DataSet ds = new DataSet();
            da.Fill(ds, "BI");
            return ds;
        }

    }    
}
