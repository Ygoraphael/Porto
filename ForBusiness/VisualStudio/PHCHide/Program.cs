using System;
using System.Collections.Generic;
using System.Windows.Forms;
using System.Data;
using System.Runtime.InteropServices;
using System.ComponentModel;
using System.IO;
using System.Data.Odbc;
using System.Data.SqlClient;

namespace PHCHide
{
    public class Program
    {
        /// <summary>
        /// The main entry point for the application.
        /// </summary>
        /// 

        //[DllImport("kernel32.dll")]
        //static extern bool AttachConsole(int dwProcessId);
        //private const int ATTACH_PARENT_PROCESS = -1;

        //[STAThread]
        //static void Main(string[] args)
        //{
        //    if (args.Length == 0)
        //    {
        //        Application.EnableVisualStyles();
        //        Application.SetCompatibleTextRenderingDefault(false);
        //        Application.Run(new Form1());
        //    }
        //    else
        //    {
        //        Application.EnableVisualStyles();
        //        Application.SetCompatibleTextRenderingDefault(false);
        //        AttachConsole(ATTACH_PARENT_PROCESS);

        //        if (args[0].ToString() == "-i")
        //        {
        //            string bd_path = "C:\\teste.db";
        //            BD db = new BD();

        //            db.Connect(bd_path);
        //            string strSql = "select codigo from code where id = " + args[1].ToString();

        //            DataTable linha = db.selectQuery(strSql);

        //            if (linha.Rows.Count > 0)
        //            {
        //                Console.WriteLine(linha.Rows[0][0].ToString());
        //            }
        //            else
        //            {
        //                Console.WriteLine("");
        //            }
        //        }
        //    }
            //OdbcConnection conn = new OdbcConnection();
            //conn.ConnectionString =
            //"Dsn=phc_2013;" +
            //"Uid=sa;" +
            //"Pwd=tl123;" +
            //"Database=vmflex2012;";
            //conn.Open();
            //OdbcCommand cmd = new OdbcCommand("CREATE TABLE hgghgdf(sssf varchar(max))", conn);
            //cmd.ExecuteNonQuery();
            //cmd = new OdbcCommand("insert into hgghgdf (sssf) values (?)", conn);
            //cmd.Parameters.Add("?", OdbcType.VarChar).Value = "msg('working')";
            //cmd.ExecuteNonQuery();
        //}

        private void worker_DoWork(object sender, DoWorkEventArgs e)
        {
            object[] parameters = e.Argument as object[];
            e.Result = true;

            System.Threading.Thread.Sleep(1000);

            while (File.Exists(parameters[0].ToString()) || File.Exists(parameters[1].ToString()))
            {
                try
                {
                    File.Delete(parameters[0].ToString());
                    File.Delete(parameters[1].ToString());
                }
                catch (Exception)
                {
                }
            }
        }

        public string Exec(String id)
        {

            var parse = new VisualFoxpro.FoxApplication();
            
            string comando = "define class FunctionObject as Custom" +
                "cMethod = []" + 
                "procedure INIT(pcParameters as String, pcMethod as String)" +
                "this.cMethod = iif(vartype(pcParameters)='C','lparameters '+pcParameters+CR_LF,'') + pcMethod" +
                "endproc" +
                "function call(p01,p02,p03,p04,p05)" + 
                "local lcParamString as String" + 
                "lcParamString = left(',p01,p02,p03,p04,p05',4*(PCOUNT()))" + 
                "return execscript(this.cMethod &lcParamString)" + 
                "endfunc" + 
                "enddefine";

            string foxCommand = comando;
            parse.DoCmd(foxCommand);

            comando = "loDistanceFunc = createobject('FunctionObject', 'pnA,pnB', 'return sqrt(pnA*pnA+pnB*pnB)')";
            foxCommand = comando;
            parse.DoCmd(foxCommand);

            comando = "return loDistanceFunc";
            foxCommand = comando;
            parse.DoCmd(foxCommand);

            System.IO.File.WriteAllLines(@"C:\code.txt", lines);

            string[] lines2 = { 
                                "execscript( filetostr('c:\\code.txt') )",
                                "ERASE c:\\code.txt"
                             };
            System.IO.File.WriteAllLines(@"C:\main_meu.prg", lines2);

            
            foxCommand = "ERASE c:\\main_meu.prg";
            parse.DoCmd(foxCommand);

            //BackgroundWorker worker = new BackgroundWorker();
            //worker.DoWork += new DoWorkEventHandler(worker_DoWork);
            //object paramObj1 = "c:\\code.txt";
            //object paramObj2 = "c:\\main_meu.fxp";
            //object[] parameters = new object[] { paramObj1, paramObj2 };
            //worker.RunWorkerAsync(parameters);

            return "c:\\main_meu.fxp";

            //var parse = new VisualFoxpro.FoxApplication();
            //string foxCommand = "compile c:\\code.prg";
            //parse.DoCmd(foxCommand);
            //foxCommand = "ERASE c:\\code.prg";
            //parse.DoCmd(foxCommand);

            //string[] lines2 = { "do C:\\code.fxp", "ERASE C:\\code.fxp" };
            //System.IO.File.WriteAllLines(@"C:\main_meu.prg", lines2);

            //foxCommand = "compile c:\\main_meu.prg";
            //parse.DoCmd(foxCommand);
            //foxCommand = "ERASE c:\\main_meu.prg";
            //parse.DoCmd(foxCommand);

            //File.Move(@"C:\main_meu.fxp", @"C:\main_meu");

            //BackgroundWorker worker = new BackgroundWorker();
            //worker.DoWork += new DoWorkEventHandler(worker_DoWork);
            //object paramObj1 = "c:\\main_meu";
            //object paramObj2 = "c:\\code.fxp";
            //object[] parameters = new object[] { paramObj1, paramObj2 };
            //worker.RunWorkerAsync(parameters);

            //return "c:\\main_meu";




            //Application.EnableVisualStyles();
            //Application.SetCompatibleTextRenderingDefault(false);
            //Application.Run(new Form1());

            //string bd_path = "C:\\teste.db";
            //BD db = new BD();

            //db.Connect(bd_path);
            //string strSql = "select codigo from code where id = " + id;

            //DataTable linha = db.selectQuery(strSql);

            //if (linha.Rows.Count > 0)
            //{
            //    var parse = new VisualFoxpro.FoxApplication();

            //    return linha.Rows[0][0].ToString();
            //}
            //else
            //{
            //    return "";
            //}
        }
    }
}
