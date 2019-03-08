using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data.SqlClient;
using System.Data;
using System.IO;

namespace NCPonto.Classes
{
    class PicoFO
    {
        private string cartao;
        private string tipopico;
        private string stampboexistente="";
        private string stampbiexistente = "";
        private int numerofo;
        private string reftar = "";
        private string destar = "";
        string strconn = Properties.Settings.Default.StrCon;

        public PicoFO(string cartao)
        {
            Cartao = cartao;
            TipoPico = tipopico;
        }
        public PicoFO(string cartao, int numerofo, string reftar, string destar)
        {
            Cartao = cartao;
            TipoPico = tipopico;
            NumeroFO = numerofo;
            RefTar = reftar;
            DesTar = destar;
        }
        public string Cartao
        {
            get { return cartao; }
            set { cartao = value; }
        }
        public string RefTar
        {
            get { return reftar; }
            set { reftar = value; }
        }
        public string DesTar
        {
            get { return destar; }
            set { destar = value; }
        }
        public int NumeroFO
        {
            get { return numerofo; }
            set { numerofo = value; }
        }
        public string TipoPico
        {
            get { return tipopico; }
            set { tipopico = value; }
        }
        public bool ExisteCartao()
        {
            SqlConnection conn = new SqlConnection(strconn);
            string cb = "Select * from US where u_CodVal=@CodVal";
            SqlDataAdapter da = new SqlDataAdapter(cb, conn);
            da.SelectCommand.Parameters.Add(new SqlParameter("@CodVal", SqlDbType.VarChar)).Value = cartao;

            DataSet ds = new DataSet();
            da.Fill(ds, "US");
            if (ds.Tables["US"].Rows.Count > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        public string UtilizadorCartao()
        {
            SqlConnection conn = new SqlConnection(strconn);
            string cb = "Select * from US where u_CodVal=@CodVal";
            SqlDataAdapter da = new SqlDataAdapter(cb, conn);
            da.SelectCommand.Parameters.Add(new SqlParameter("@CodVal", SqlDbType.VarChar)).Value = cartao;

            DataSet ds = new DataSet();
            da.Fill(ds, "US");
            if (ds.Tables["US"].Rows.Count > 0)
            {
                DataRow dr = ds.Tables["US"].Rows[0];
                return dr["Username"].ToString();
            }
            else
            {
                return "";
            }
        }
        public string DataQuery(DateTime data)
        {
            return data.Year + "-" + data.Month + "-" + data.Day;
        }
        public bool VerSeExistePico(string NomeUtilizador, string TipoTicoProcurar, int numerofo)
        {
            bool EncontreiPico = false;
            DateTime dat = DateTime.Now;
            string datx = dat.Year + "-" + dat.Month + "-" + dat.Day;
            string fo = numerofo.ToString();

            if (ExisteCartao())
            {
                string tpico = "";
                if (TipoTicoProcurar == "Entrada")
                {
                    tpico = "Iniciado";
                }
                if (TipoTicoProcurar == "SAIDA")
                {
                    tpico = "Fechado";
                }
                SqlConnection conn = new SqlConnection(strconn);
                string cb = "Select bistamp, Lobs3, rdata, ref, design from BI (nolock) where ndos=60 and obrano=@ObraNo and LItem=@Utilizador and lobs3='Iniciado' and (rdata = CONVERT(DATETIME, '" + DataQuery(dat) + "', 102)) Order by lordem desc";
                SqlDataAdapter da = new SqlDataAdapter(cb, conn);
                da.SelectCommand.Parameters.Add(new SqlParameter("@CodVal", SqlDbType.VarChar)).Value = cartao;
                da.SelectCommand.Parameters.Add(new SqlParameter("@Utilizador", SqlDbType.VarChar)).Value = NomeUtilizador;
                da.SelectCommand.Parameters.Add(new SqlParameter("@ObraNo", SqlDbType.VarChar)).Value = fo;
                da.SelectCommand.Parameters.Add(new SqlParameter("@reftar", SqlDbType.VarChar)).Value = reftar.Trim();
                da.SelectCommand.Parameters.Add(new SqlParameter("@TipoPico", SqlDbType.VarChar)).Value = tpico;

                DataSet ds = new DataSet();
                da.Fill(ds, "BO");
                if (ds.Tables["BO"].Rows.Count > 0)
                {

                    DataRow dr = ds.Tables["BO"].Rows[0];
                    stampbiexistente = dr["bistamp"].ToString();
                    if (TipoTicoProcurar == "Entrada")
                    {                        
                        if (dr["LObs3"].ToString() == "Iniciado")
                        {
                            if (dr["ref"].ToString().Trim() == reftar.Trim())
                            {
                                EncontreiPico=true;
                            }
                            else
                            {
                                ActualizaSaida(NomeUtilizador, "", "");
                                EncontreiPico = false;
                            }
                        }
                        else
                        {
                            EncontreiPico = false;
                        }
                    }
                    if (TipoTicoProcurar == "SAIDA")
                    {
                        if (dr["LObs3"].ToString() == "Iniciado")
                        {
                            EncontreiPico = false;
                        }
                        else
                        {
                            EncontreiPico = true;
                        }
                    }
                    return EncontreiPico;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        public bool VerSeExistePicoDestaTarefa(string NomeUtilizador, string TipoTicoProcurar, int numerofo, string xtarefa)
        {
            //bool EncontreiPico = false;
            DateTime dat = DateTime.Now;
            string datx = dat.Year + "-" + dat.Month + "-" + dat.Day;
            string fo = numerofo.ToString();

            if (ExisteCartao())
            {
                string tpico = "";
                if (TipoTicoProcurar == "Entrada")
                {
                    tpico = "Iniciado";
                }
                if (TipoTicoProcurar == "SAIDA")
                {
                    tpico = "Fechado";
                }
                SqlConnection conn = new SqlConnection(strconn);
                string cb = "Select bistamp, Lobs3, rdata, ref, design from BI (nolock) where ndos=60 and obrano=@ObraNo and LItem=@Utilizador and lobs3='Iniciado' and ref=@xref and (rdata = CONVERT(DATETIME, '" + DataQuery(dat) + "', 102)) Order by lordem desc";
                SqlDataAdapter da = new SqlDataAdapter(cb, conn);
                da.SelectCommand.Parameters.Add(new SqlParameter("@CodVal", SqlDbType.VarChar)).Value = cartao;
                da.SelectCommand.Parameters.Add(new SqlParameter("@Utilizador", SqlDbType.VarChar)).Value = NomeUtilizador;
                da.SelectCommand.Parameters.Add(new SqlParameter("@ObraNo", SqlDbType.VarChar)).Value = fo;
                da.SelectCommand.Parameters.Add(new SqlParameter("@reftar", SqlDbType.VarChar)).Value = reftar.Trim();
                da.SelectCommand.Parameters.Add(new SqlParameter("@xref", SqlDbType.VarChar)).Value = xtarefa;
                da.SelectCommand.Parameters.Add(new SqlParameter("@TipoPico", SqlDbType.VarChar)).Value = tpico;

                DataSet ds = new DataSet();
                da.Fill(ds, "BO");
                if (ds.Tables["BO"].Rows.Count > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        public bool VerSeExistePicoAbertoDestaFO(string NomeUtilizador, string TipoTicoProcurar, int numerofo, string xtarefa)
        {
            DateTime dat = DateTime.Now;
            string datx = dat.Year + "-" + dat.Month + "-" + dat.Day;
            string fo = numerofo.ToString();

            if (ExisteCartao())
            {
                string tpico = "";
                if (TipoTicoProcurar == "Entrada")
                {
                    tpico = "Iniciado";
                }
                if (TipoTicoProcurar == "SAIDA")
                {
                    tpico = "Fechado";
                }
                SqlConnection conn = new SqlConnection(strconn);
                string cb = "Select obrano, bistamp, Lobs3, rdata, ref, design from BI (nolock) where ndos=60 and obrano=@ObraNo and LItem=@Utilizador and lobs3='Iniciado' and ref<>@xref and (rdata = CONVERT(DATETIME, '" + DataQuery(dat) + "', 102)) Order by lordem desc";
                SqlDataAdapter da = new SqlDataAdapter(cb, conn);
                da.SelectCommand.Parameters.Add(new SqlParameter("@CodVal", SqlDbType.VarChar)).Value = cartao;
                da.SelectCommand.Parameters.Add(new SqlParameter("@Utilizador", SqlDbType.VarChar)).Value = NomeUtilizador;
                da.SelectCommand.Parameters.Add(new SqlParameter("@ObraNo", SqlDbType.VarChar)).Value = fo;
                da.SelectCommand.Parameters.Add(new SqlParameter("@reftar", SqlDbType.VarChar)).Value = reftar.Trim();
                da.SelectCommand.Parameters.Add(new SqlParameter("@xref", SqlDbType.VarChar)).Value = xtarefa;
                da.SelectCommand.Parameters.Add(new SqlParameter("@TipoPico", SqlDbType.VarChar)).Value = tpico;

                DataSet ds = new DataSet();
                da.Fill(ds, "BO");
                if (ds.Tables["BO"].Rows.Count > 0)
                {
                    DataRow dr = ds.Tables["BO"].Rows[0];
                    DesTar = dr["design"].ToString().Trim();
                    NumeroFO = int.Parse(dr["obrano"].ToString());
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        public bool VerSeExistePicoAberto(string NomeUtilizador, string TipoTicoProcurar, int numerofo)
        {
            bool EncontreiPico = false;
            DateTime dat = DateTime.Now;
            string datx = dat.Year + "-" + dat.Month + "-" + dat.Day;
            string xfo = (dat.Year * 10000).ToString();
            string fo = numerofo.ToString();

            if (ExisteCartao())
            {
                string tpico = "";
                if (TipoTicoProcurar == "Entrada")
                {
                    tpico = "Iniciado";
                }
                if (TipoTicoProcurar == "SAIDA")
                {
                    tpico = "Fechado";
                }
                SqlConnection conn = new SqlConnection(strconn);
                string cb;
                SqlDataAdapter da;
                if (reftar.Trim().Equals("PINTURA"))
                {
                    cb = "select obrano, bistamp, Lobs3, rdata, ref, design from (Select obrano, bistamp, Lobs3, rdata, ref, design, case when obrano = @ObraNo or ref <> 'PINTURA' then 1 else 0 end same from BI (nolock) where ndos=60 and obrano not in (20110000, @ObraNo2) and LItem=@Utilizador and lobs3='Iniciado' and litem2<>'Sim') a where same = 1";
                    da = new SqlDataAdapter(cb, conn);
                }
                else
                {
                    cb = "Select obrano, bistamp, Lobs3, rdata, ref, design from BI (nolock) where ndos=60 and obrano<>@ObraNo2 and obrano<>'20110000' and LItem=@Utilizador and lobs3='Iniciado' and litem2<>'Sim' Order by lordem desc";
                    da = new SqlDataAdapter(cb, conn);
                }

                da.SelectCommand.Parameters.Add(new SqlParameter("@CodVal", SqlDbType.VarChar)).Value = cartao;
                da.SelectCommand.Parameters.Add(new SqlParameter("@Utilizador", SqlDbType.VarChar)).Value = NomeUtilizador;
                da.SelectCommand.Parameters.Add(new SqlParameter("@ObraNo", SqlDbType.VarChar)).Value = fo;
                da.SelectCommand.Parameters.Add(new SqlParameter("@ObraNo2", SqlDbType.VarChar)).Value = xfo;                
                da.SelectCommand.Parameters.Add(new SqlParameter("@reftar", SqlDbType.VarChar)).Value = reftar.Trim();
                da.SelectCommand.Parameters.Add(new SqlParameter("@TipoPico", SqlDbType.VarChar)).Value = tpico;

                DataSet ds = new DataSet();
                da.Fill(ds, "BO");
                if (ds.Tables["BO"].Rows.Count > 0)
                {
                    DataRow dr = ds.Tables["BO"].Rows[0];
                    stampbiexistente = dr["bistamp"].ToString();
                    if (TipoTicoProcurar == "Entrada")
                    {                        
                        if (dr["LObs3"].ToString() == "Iniciado")
                        {
                            EncontreiPico = true;
                            RefTar = dr["ref"].ToString();
                            NumeroFO = int.Parse(dr["obrano"].ToString());
                            DesTar = dr["design"].ToString();
                        }
                        else
                        {
                            EncontreiPico = false;
                        }
                    }
                    if (TipoTicoProcurar == "SAIDA")
                    {
                        if (dr["LObs3"].ToString() == "Iniciado")
                        {
                            EncontreiPico = false;
                        }
                        else
                        {
                            EncontreiPico = true;
                        }
                    }
                    return EncontreiPico;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        private bool ExisteDossierPonto()
        {
            DateTime dat = DateTime.Now;
            string fo = numerofo.ToString();

            if (ExisteCartao())
            {
                SqlConnection conn = new SqlConnection(strconn);
                string cb = "Select bostamp from BI (nolock) where ndos=60 and obrano=@ObraNo";
                SqlDataAdapter da = new SqlDataAdapter(cb, conn);
                da.SelectCommand.Parameters.Add(new SqlParameter("@ObraNo", SqlDbType.VarChar)).Value = fo;

                DataSet ds = new DataSet();
                da.Fill(ds, "BO");
                if (ds.Tables["BO"].Rows.Count > 0)
                {
                    DataRow dr = ds.Tables["BO"].Rows[0];
                    stampboexistente = dr["bostamp"].ToString();
                    return true;
                }
                else
                {                    
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        
        public void InsereEntrada(string NomeUtilizador, string turno, string TipoPico)
        {
            DateTime dat = DateTime.Now;
            string fo = numerofo.ToString();
            DateTime dataobra = DateTime.Now;
            string hora = dat.ToString("HH:mm");
            long tempoinicio = (dat.Hour * 60) + dat.Minute;
            string mat = "";
            string nome = "";
            string refer = reftar;
            string design = destar;
            Random random = new Random();
            random.Next(1000000, 9999999);
            string stamp = string.Format("FPT{0}", random.Next(1000000, 9999999).ToString());
            string bistamp = string.Format("BIFPT{0}", random.Next(1000000, 9999999).ToString());

            if (ExisteCartao() && !VerSeExistePico(NomeUtilizador,TipoPico,numerofo))
            {
                if (!ExisteDossierPonto())
                {
                    CriaDossierPontoBO(stamp, fo, 0, nome, dataobra, mat);
                    CriaDossierPontoBI(stamp, fo, 0, nome, dataobra, mat, "", hora, tempoinicio, NomeUtilizador, refer, design, 1000, tipopico, bistamp);
                }
                else
                {
                    CriaDossierPontoBI(stampboexistente, fo, 0, nome, dataobra, mat, "", hora, tempoinicio, NomeUtilizador, refer, design, 1000, tipopico, bistamp);
                }
            }
        }
        public void ActualizaSaida(string NomeUtilizador, string turno, string TipoPico)
        {
            DateTime dat = DateTime.Now;           
            string horafim = dat.ToString("HH:mm");
            long tempofim = (dat.Hour * 60) + dat.Minute;                                                           

            if (ExisteCartao() && !VerSeExistePico(NomeUtilizador, TipoPico,numerofo))
            {
                ActualizaDossierPontoBI(horafim, tempofim, stampbiexistente);
                ActualizaDossierPontoBITempoFinal(horafim, tempofim, stampbiexistente);             
            }
        }
        private void ActualizaDossierPontoBITempoFinal(string horafim, long tempofim, string bistamp)
        {
            SqlConnection conn = new SqlConnection(strconn);
            SqlCommand comm = conn.CreateCommand();

            comm.CommandTimeout = 0;
            comm.CommandText = "UPDATE BI SET qtt2=(BiNum2-BiNum1)/60 where bistamp=@bistamp";
            comm.Parameters.Add("@biStamp", SqlDbType.VarChar).Value = bistamp;
            try
            {
                conn.Open();
            }
            catch
            {
            }

            comm.ExecuteNonQuery();
            comm.Parameters.Clear();
            try
            {
                conn.Open();
            }
            catch
            {
            }
        }
        private void ActualizaDossierPontoBI(string horafim, long tempofim, string bistamp)
        {
            SqlConnection conn = new SqlConnection(strconn);
            SqlCommand comm = conn.CreateCommand();

            comm.CommandTimeout = 0;
            comm.CommandText = "UPDATE BI SET biStamp=@bistamp, LObs2=@LObs2, LObs3=@LObs3, BiNum2=@BiNum2 where bistamp=@bistamp";
            comm.Parameters.Add("@biStamp", SqlDbType.VarChar).Value = bistamp;
            comm.Parameters.Add("@LObs2", SqlDbType.VarChar).Value = horafim;
            comm.Parameters.Add("@LObs3", SqlDbType.VarChar).Value = "Fechado";
            comm.Parameters.Add("@BiNum2", SqlDbType.Int).Value = tempofim;

            try
            {
                conn.Open();
            }
            catch
            {
            }

            comm.ExecuteNonQuery();
            comm.Parameters.Clear();
            try
            {
                conn.Open();
            }
            catch
            {
            }
        }

        private void CriaDossierPontoBI(string stamp, string obrano, int no, string nome, DateTime data, string matricula, string oobistamp, string horainicio, long tempoinicio, string nomeutil, string refer, string design, long lordem, string tipopico, string bistamp)
        {
            string myp = System.IO.Directory.GetCurrentDirectory() + "\\Posto.txt";
            System.IO.StreamReader myFile = new System.IO.StreamReader(myp);
            string myPosto = myFile.ReadToEnd();
            myFile.Close();

            SqlConnection conn = new SqlConnection(strconn);
            SqlCommand comm = conn.CreateCommand();

            comm.CommandTimeout = 0;
            comm.CommandText = "INSERT INTO BI (POSIC, NDOS, NMDOS, biStamp, boStamp, ObraNO, No, Nome, DataObra, RData, LObs, LObs2, LObs3, BiNum1, BiNum2, LItem, Ref, Design, LOrdem, OOBIStamp) VALUES (@POSIC, @NDOS, @NMDOS, @BIStamp, @boStamp, @ObraNO, @No, @Nome, @DataObra, @RData, @LObs, @LObs2, @LObs3, @BiNum1, @BiNum2, @LItem, @Ref, @Design, @LOrdem, @OOBIStamp)";
            comm.Parameters.Add("@NDOS", SqlDbType.Int).Value = 60;
            comm.Parameters.Add("@NMDOS", SqlDbType.Char).Value = "Ponto";
            comm.Parameters.Add("@biStamp", SqlDbType.VarChar).Value = bistamp;
            comm.Parameters.Add("@boStamp", SqlDbType.VarChar).Value = stamp;
            comm.Parameters.Add("@ObraNO", SqlDbType.Int).Value = obrano;
            comm.Parameters.Add("@No", SqlDbType.Int).Value = no;
            comm.Parameters.Add("@Nome", SqlDbType.VarChar).Value = nome;
            comm.Parameters.Add("@DataObra", SqlDbType.DateTime).Value = data.ToShortDateString();
            comm.Parameters.Add("@BOAno", SqlDbType.Int).Value = data.Year;
            comm.Parameters.Add("@Moeda", SqlDbType.VarChar).Value = "PTE ou EURO";
            comm.Parameters.Add("@OOBIStamp", SqlDbType.VarChar).Value = oobistamp;
            comm.Parameters.Add("@RData", SqlDbType.DateTime).Value = data.ToShortDateString();
            comm.Parameters.Add("@LObs", SqlDbType.VarChar).Value = horainicio;
            comm.Parameters.Add("@LObs2", SqlDbType.VarChar).Value = "";
            comm.Parameters.Add("@LObs3", SqlDbType.VarChar).Value = "Iniciado";
            comm.Parameters.Add("@BiNum1", SqlDbType.Int).Value = tempoinicio;
            comm.Parameters.Add("@BiNum2", SqlDbType.Int).Value = 0;
            comm.Parameters.Add("@LItem", SqlDbType.VarChar).Value = nomeutil;
            comm.Parameters.Add("@Ref", SqlDbType.VarChar).Value = refer;
            comm.Parameters.Add("@Design", SqlDbType.VarChar).Value = design;
            comm.Parameters.Add("@LOrdem", SqlDbType.Int).Value = lordem;
            comm.Parameters.Add("@Posic", SqlDbType.Int).Value = myPosto;

            switch (tipopico)
            {
                case ("E1"):
                    comm.Parameters.Add("@u_entrada1", SqlDbType.VarChar).Value = horainicio;
                    comm.Parameters.Add("@u_ent1T", SqlDbType.Int).Value = tempoinicio;

                    comm.Parameters.Add("@u_entrada2", SqlDbType.VarChar).Value = "";
                    comm.Parameters.Add("@u_ent2T", SqlDbType.Int).Value = 0;
                    comm.Parameters.Add("@u_Saida1", SqlDbType.VarChar).Value = "";
                    comm.Parameters.Add("@u_sai1T", SqlDbType.Int).Value = 0;
                    comm.Parameters.Add("@u_Saida2", SqlDbType.VarChar).Value = "";
                    comm.Parameters.Add("@u_sai2T", SqlDbType.Int).Value = 0;
                    break;
                case ("E2"):
                    comm.Parameters.Add("@u_entrada2", SqlDbType.VarChar).Value = horainicio;
                    comm.Parameters.Add("@u_ent2T", SqlDbType.Int).Value = tempoinicio;

                    comm.Parameters.Add("@u_entrada1", SqlDbType.VarChar).Value = "";
                    comm.Parameters.Add("@u_ent1T", SqlDbType.Int).Value = 0;
                    comm.Parameters.Add("@u_Saida1", SqlDbType.VarChar).Value = "";
                    comm.Parameters.Add("@u_sai1T", SqlDbType.Int).Value = 0;
                    comm.Parameters.Add("@u_Saida2", SqlDbType.VarChar).Value = "";
                    comm.Parameters.Add("@u_sai2T", SqlDbType.Int).Value = 0;
                    break;
            }
            try
            {
                conn.Open();
            }
            catch
            {
            }

            comm.ExecuteNonQuery();
            comm.Parameters.Clear();
            try
            {
                conn.Open();
            }
            catch
            {
            }
        }

        private void CriaDossierPontoBO(string stamp, string obrano, int no, string nome, DateTime data, string matricula)
        {
            SqlConnection conn = new SqlConnection(strconn);
            SqlCommand comm = conn.CreateCommand();

            comm.CommandTimeout = 0;
            comm.CommandText = "INSERT INTO BO (NDOS, NMDOS, boStamp, ObraNO, No, Nome, DataObra, BOAno, Moeda) VALUES (@NDOS, @NMDOS, @boStamp, @ObraNO, @No, @Nome, @DataObra, @BOAno, @Moeda)";
            comm.Parameters.Add("@NDOS", SqlDbType.Int).Value = 60;
            comm.Parameters.Add("@NMDOS", SqlDbType.Char).Value = "Ponto";
            comm.Parameters.Add("@boStamp", SqlDbType.VarChar).Value = stamp;
            comm.Parameters.Add("@ObraNO", SqlDbType.Int).Value = obrano;
            comm.Parameters.Add("@No", SqlDbType.Int).Value = no;
            comm.Parameters.Add("@Nome", SqlDbType.VarChar).Value = nome;
            comm.Parameters.Add("@DataObra", SqlDbType.DateTime).Value = data.ToShortDateString();
            comm.Parameters.Add("@BOAno", SqlDbType.Int).Value = data.Year;
            comm.Parameters.Add("@Moeda", SqlDbType.VarChar).Value = "PTE ou EURO";
            try
            {
                conn.Open();
            }
            catch
            {
            }

            comm.ExecuteNonQuery();
            comm.Parameters.Clear();
            try
            {
                conn.Open();
            }
            catch
            {
            }
        }


    }
}
