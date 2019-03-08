using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;
using NPOI.HSSF.Extractor;
using NPOI.HSSF.UserModel;
using NPOI.SS.UserModel;
using System.Windows.Forms;
using ZedGraph;
using System.Drawing;
using System.Data;
using System.Drawing.Imaging;
using System.Data.SQLite;
using System.Globalization;
using System.ComponentModel;
using Excel;
using PdfSharp.Pdf;
using PdfSharp.Drawing;
using System.Diagnostics;
using Microsoft.Office.Interop.Excel;

namespace EOR_DRIS
{
    public partial class dris
    {
        public int tmp_nutrientes_num = 0;
        public int nutrientes_num = 0;
        public int amostras_num = 0;
        public int referencias_num = 0;
        public int referencias_combin_num = 0;

        public int referencias_id = 0;
        public int amostras_id = 0;

        public string[] tmp_nutrientes_lista = null;
        public string[] nutrientes_lista = null;
        public string[] nutrientes_unidades = null;

        public string[][] amostra_data = null;
        public string[] amostra_data_nomes = null;

        public string[][] referencia_data = null;

        public string[][] normas_dris = null;

        public string[][] amostras_combinacoes_dris = null;

        public string[][] amostras_indices_dris = null;

        public string[] ibn_amostra = null;

        public string[][] tmp_amostra_data = null;
        public string[][] sensibilidade_array = null;

        BaseDados DrisDB = new BaseDados();

        public string caminho_base_dados = "";

        public string template_a_usar = "";
        public string template_calculos = "";

        public int numero_paginas_template = 40;


        //inicial
        public string[][] inicial_amostra_data = null;
        public string[][] inicial_amostras_indices_dris = null;
        public string[] inicial_ibn_amostra = null;

        public string[] amostras_calculadas = null;

        static HSSFWorkbook hssfworkbook;
        public string path_amostra = @"";
        public string path_referencia = @"";
        public string path_projecto = "";
        public string id_projecto = "";

        public void initialize_projecto(string identificacao_proj, string caminho_referencia, string caminho_amostra, int ref_type, int am_type)
        {
            id_projecto = identificacao_proj;
            path_amostra = @"" + caminho_amostra;
            path_referencia = @"" + caminho_referencia;
            //TOCHANGE - caminho directorio da aplicacao
            path_projecto = @"" + System.Windows.Forms.Application.StartupPath + "\\" + id_projecto + ".xls";
            cria_ficheiro_resultado();
            referencias_id = ref_type;
            amostras_id = am_type;
        }

        public void carrega_amostras_calculadas_check()
        {
            amostras_calculadas = new string[amostras_num];
            for(int i=0; i<amostras_num;i++)
            {
                amostras_calculadas[i] = "0";
            }
        }

        public void amostra_dados_to_array()
        {
            amostra_data = new string[amostras_num][];
            sensibilidade_array = new string[amostras_num][];
            amostra_data_nomes = new string[amostras_num];

            if (amostras_id == 0)
            {
                //abrir ficheiro xls
                FileStream file = new FileStream(path_amostra, FileMode.Open, FileAccess.Read);
                hssfworkbook = new HSSFWorkbook(file);
                ISheet sheet = hssfworkbook.GetSheet("Resultados");
                IRow dataRow = null;
                ICell dataCell = null;

                for (int i = 3; i < 3 + amostras_num; i++)
                {
                    dataRow = sheet.GetRow(i);
                    amostra_data[i - 3] = new string[nutrientes_num];

                    for (int j = 1; j < 1 + nutrientes_num; j++)
                    {
                        dataCell = dataRow.GetCell(j);
                        amostra_data[i - 3][j - 1] = dataCell.NumericCellValue.ToString().Trim();
                    }

                    dataCell = dataRow.GetCell(0);
                    amostra_data_nomes[i - 3] = dataCell.ToString().Trim();
                }

                //fechar documento
                file.Close();
            }
            else
            {
                get_bd_amostra_dados();
            }
        }

        public void get_bd_amostra_dados()
        {
            amostra_data = new string[amostras_num][];
            amostra_data_nomes = new string[amostras_num];

            DrisDB.Connect(caminho_base_dados);
            System.Data.DataTable d_tmp = new System.Data.DataTable();

            string sql = "SELECT ";
            sql += "* ";
            sql += "FROM AMOSTRA_DADOS_REQ ";
            sql += "WHERE ";
            sql += "ID_AMOSTRA_DADOS IN ";
            sql += "(";
            sql += "SELECT ";
            sql += "B.ID ";
            sql += "FROM ";
            sql += "AMOSTRA A INNER JOIN AMOSTRA_DADOS B ";
            sql += "ON A.ID = B.ID_AMOSTRA ";
            sql += "WHERE ";
            sql += "A.ID = '" + amostras_id + "' ";
            sql += ")";

            int tmp = 0;
            d_tmp = DrisDB.selectQuery(sql);
            
            for (int i = 0; i < amostras_num; i++)
            {
                amostra_data[i] = new string[nutrientes_num];
                for (int j = 0; j < nutrientes_num; j++)
                {
                    amostra_data[i][j] = d_tmp.Rows[tmp][2].ToString();
                    tmp++;
                }
            }

            sql = "SELECT ";
            sql += "* ";
            sql += "FROM AMOSTRA_DADOS ";
            sql += "WHERE ";
            sql += "ID_AMOSTRA = '" + amostras_id + "'";
            d_tmp = DrisDB.selectQuery(sql);

            tmp = 0;
            foreach (DataRow row in d_tmp.Rows)
            {
                amostra_data_nomes[tmp] = row[2].ToString();
                tmp++;
            }

        }

        public void cria_ficheiro_resultado()
        {
            hssfworkbook = new HSSFWorkbook();
            ISheet sheet = hssfworkbook.CreateSheet("Resultado");
            FileStream file = new FileStream(path_projecto, FileMode.Create);
            
            //1a linha
            IRow dataRow = sheet.CreateRow(0);
            dataRow.CreateCell(2).SetCellValue("REFERÊNCIA");
            NPOI.SS.Util.CellRangeAddress cellRange = new NPOI.SS.Util.CellRangeAddress(0, 0, 2, 20);
            sheet.AddMergedRegion(cellRange);
            ICell r1c1 = dataRow.GetCell(2);
            r1c1.CellStyle.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;

            //2a linha
            dataRow = sheet.CreateRow(1);
            dataRow.CreateCell(2).SetCellValue("A");
            cellRange = new NPOI.SS.Util.CellRangeAddress(1, 1, 2, 9);
            sheet.AddMergedRegion(cellRange);

            dataRow.CreateCell(10).SetCellValue("B");
            cellRange = new NPOI.SS.Util.CellRangeAddress(1, 1, 10, 17);
            sheet.AddMergedRegion(cellRange);

            dataRow.CreateCell(18).SetCellValue("CRITÉRIO LETZSCH");
            cellRange = new NPOI.SS.Util.CellRangeAddress(1, 1, 18, 20);
            sheet.AddMergedRegion(cellRange);

            //3a linha
            dataRow = sheet.CreateRow(2);
            dataRow.CreateCell(2).SetCellValue("Média A/B");
            dataRow.CreateCell(3).SetCellValue("Média B/A");
            dataRow.CreateCell(4).SetCellValue("SD A/B");
            dataRow.CreateCell(5).SetCellValue("SD B/A");
            dataRow.CreateCell(6).SetCellValue("CV A/B");
            dataRow.CreateCell(7).SetCellValue("CV B/A");
            dataRow.CreateCell(8).SetCellValue("VAR A/B");
            dataRow.CreateCell(9).SetCellValue("VAR B/A");
            dataRow.CreateCell(10).SetCellValue("Média A/B");
            dataRow.CreateCell(11).SetCellValue("Média B/A");
            dataRow.CreateCell(12).SetCellValue("SD A/B");
            dataRow.CreateCell(13).SetCellValue("SD B/A");
            dataRow.CreateCell(14).SetCellValue("CV A/B");
            dataRow.CreateCell(15).SetCellValue("CV B/A");
            dataRow.CreateCell(16).SetCellValue("VAR A/B");
            dataRow.CreateCell(17).SetCellValue("VAR B/A"); 
            dataRow.CreateCell(18).SetCellValue("VAR (A/B)");
            dataRow.CreateCell(19).SetCellValue("VAR (B/A)");
            dataRow.CreateCell(20).SetCellValue("Escolha");

            //centrar tudo
            for (int i = 0; i <= 2; i++)
            {
                dataRow = sheet.GetRow(i);

                for (int j = 0; j <= 22; j++)
                {
                    r1c1 = dataRow.GetCell(j);
                    if (r1c1 != null)
                        r1c1.CellStyle.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;
                }
            }

            hssfworkbook.Write(file);
            file.Close();
        }

        public void nutrients_filter(DataGridView dg)
        {
            List<string> tmp_array = new List<string>();
            List<string> tmp_array2 = new List<string>();
            int tmp_len = 0;

            for (int i = 0; i < nutrientes_num; i++)
            {
                if (dg.Rows[i].Cells[1].Value.ToString() == "Sim")
                {
                    tmp_array.Add(dg.Rows[i].Cells[0].Value.ToString());
                    tmp_array2.Add(nutrientes_unidades[i]);
                    tmp_len += 1;
                }
            }

            tmp_nutrientes_lista = tmp_array.ToArray();
            tmp_nutrientes_num = tmp_len;
            nutrientes_unidades = tmp_array2.ToArray();
        }

        public void nutrients_selector(DataGridView dg)
        {
            get_amostra_num_nutrientes();
            Console.WriteLine("Num nutrientes: {0}", nutrientes_num);
            get_amostra_nutrientes_to_array();

            System.Data.DataTable dt = new System.Data.DataTable();
            dt.Columns.Add(new DataColumn("Nut.", typeof(String)));
            dt.Columns.Add(new DataColumn("Act.", typeof(String)));

            for (int i = 0; i < nutrientes_num; i++)
            {
                dt.Rows.Add(nutrientes_lista[i], "Sim");
            }

            dg.DataSource = dt;
            dg.Columns[0].Width = 40;
            dg.Columns[1].Width = 40;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dg.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }

        }

        public void read_excel_to_array_amostra()
        {
            amostra_dados_to_array();
            amostra_dados_array_filter();
        }

        public bool search_array_value(string[] tmp_array, string value)
        {
            for (int i = 0; i < tmp_array.Length; i++)
            {
                if (tmp_array[i] == value)
                {
                    return true;
                }
            }

            return false;
        }

        public void amostra_dados_array_filter()
        {
            List<List<string>> tmp_list = new List<List<string>>();
            List<string> tmp_tmp_list = new List<string>();

            for (int j = 0; j < amostras_num; j++)
            {
                tmp_tmp_list = new List<string>();

                for (int i = 0; i < nutrientes_num; i++)
                {
                    if( search_array_value(tmp_nutrientes_lista, nutrientes_lista[i]) )
                    {
                        tmp_tmp_list.Add(amostra_data[j][i]);
                    }
                }

                tmp_list.Add(tmp_tmp_list);
            }

            //passar para array
            amostra_data = new string[amostras_num][];

            for (int j = 0; j < amostras_num; j++)
            {
                amostra_data[j] = new string[tmp_nutrientes_num];
                amostra_data[j] = tmp_list[j].ToArray();
            }

        }

        public void print_string_array(string[] lista)
        {
            foreach (string i in lista)
            {
                System.Console.Write("{0} ", i);
            }
        }

        public void print_string_array_2d(string[][] lista)
        {
            foreach (string[] j in lista)
            {
                foreach (string i in j)
                {
                    System.Console.Write("{0} ", i);
                }
                System.Console.WriteLine("");
            }
        }

        public void get_amostra_nutrientes_to_array() 
        {
            if (amostras_id == 0)
            {
                //abrir ficheiro xls
                FileStream file = new FileStream(path_amostra, FileMode.Open, FileAccess.Read);
                hssfworkbook = new HSSFWorkbook(file);

                ISheet sheet = hssfworkbook.GetSheet("Resultados");
                IRow dataRow;
                ICell dataCell = null;
                nutrientes_lista = new string[nutrientes_num];
                nutrientes_unidades = new string[nutrientes_num];

                for (int i = 1; i <= nutrientes_num; i++)
                {
                    dataRow = sheet.GetRow(1);
                    dataCell = dataRow.GetCell(i);
                    nutrientes_lista[i - 1] = dataCell.ToString().Trim();

                    dataRow = sheet.GetRow(2);
                    dataCell = dataRow.GetCell(i);
                    nutrientes_unidades[i - 1] = dataCell.ToString().Trim();
                }

                //fechar documento
                file.Close();
            }
            else
            {
                get_bd_nutrientes();
            }
        }

        public void get_bd_nutrientes()
        {
            nutrientes_lista = new string[nutrientes_num];
            nutrientes_unidades = new string[nutrientes_num];

            DrisDB.Connect(caminho_base_dados);
            System.Data.DataTable d_tmp = new System.Data.DataTable();

            string sql = "SELECT ";
            sql += "NUTRIENTE, UNIDADE ";
            sql += "FROM AMOSTRA_DADOS_REQ ";
            sql += "WHERE ";
            sql += "ID_AMOSTRA_DADOS =";
            sql += "(";
            sql += "SELECT ";
            sql += "B.ID ";
            sql += "FROM ";
            sql += "AMOSTRA A INNER JOIN AMOSTRA_DADOS B ";
            sql += "ON A.ID = B.ID_AMOSTRA ";
            sql += "WHERE ";
            sql += "A.ID = '" + amostras_id + "' ";
            sql += "LIMIT 1";
            sql += ")";

            int tmp = 0;
            d_tmp = DrisDB.selectQuery(sql);
            foreach (DataRow row in d_tmp.Rows)
            {
                nutrientes_lista[tmp] = row[0].ToString();
                nutrientes_unidades[tmp] = row[1].ToString();
                tmp++;
            }
            
        }

        public void get_amostra_num_nutrientes()
        {
            if (amostras_id == 0)
            {
                //abrir ficheiro xls
                FileStream file = new FileStream(path_amostra, FileMode.Open, FileAccess.Read);
                hssfworkbook = new HSSFWorkbook(file);

                ISheet sheet = hssfworkbook.GetSheet("Resultados");
                IRow dataRow = sheet.GetRow(0);

                string tmp = "";
                int tmp_int = 0;

                while (true)
                {
                    try
                    {
                        tmp = dataRow.GetCell(tmp_int).ToString();
                        if (tmp.Length > 0)
                        {
                            tmp_int++;
                        }
                        else
                        {
                            break;
                        }
                    }
                    catch
                    {
                        break;
                    }
                }

                nutrientes_num = tmp_int - 1;

                //fechar documento
                file.Close();
            }
            else
            {
                get_bd_num_nutrientes();
            }
        }

        public void get_bd_num_nutrientes()
        {
            DrisDB.Connect(caminho_base_dados);
            System.Data.DataTable d_tmp = new System.Data.DataTable();

            d_tmp = DrisDB.selectQuery("SELECT NUM_NUTRIENTES FROM AMOSTRA WHERE ID = '" + amostras_id + "'");

            nutrientes_num = Convert.ToInt32( d_tmp.Rows[0][0].ToString() );

        }

        public int get_column_last_row_index(int column_index, int tipo_ficheiro)
        {
            FileStream file = null;
            //abrir ficheiro xls
            if(tipo_ficheiro == 1)
                file = new FileStream(path_amostra, FileMode.Open, FileAccess.Read);
            if(tipo_ficheiro == 2)
                file = new FileStream(path_referencia, FileMode.Open, FileAccess.Read);

            hssfworkbook = new HSSFWorkbook(file);
            ISheet sheet = hssfworkbook.GetSheet("Resultados");
            int temp = 0;
            IRow dataRow = sheet.GetRow(temp);
            string tmp = "";

            while (true)
            {
                try
                {
                    tmp = dataRow.GetCell(0).ToString();
                    if (tmp.Length > 0)
                    {
                        temp++; 
                        dataRow = sheet.GetRow(temp);
                    }
                    else
                    {
                        break;
                    }
                }
                catch
                {
                    break;
                }
            }

            return temp;
        }

        public void get_num_amostras()
        {

            if (amostras_id == 0)
            {
                //abrir ficheiro xls
                FileStream file = new FileStream(path_amostra, FileMode.Open, FileAccess.Read);
                hssfworkbook = new HSSFWorkbook(file);

                ISheet sheet = hssfworkbook.GetSheet("Resultados");
                amostras_num = get_column_last_row_index(0, 1) - 3;

                //fechar documento
                file.Close();
                Console.WriteLine("Num Amostras: {0}", amostras_num);
            }
            else
            {
                get_bd_num_amostras();
            }
        }

        public void get_bd_num_amostras()
        {
            DrisDB.Connect(caminho_base_dados);
            System.Data.DataTable d_tmp = new System.Data.DataTable();

            d_tmp = DrisDB.selectQuery("SELECT COUNT(*) FROM AMOSTRA_DADOS WHERE ID_AMOSTRA = '" + amostras_id + "'");
            Console.WriteLine("YWAH: " + d_tmp.Rows[0][0].ToString());
            amostras_num = Convert.ToInt32(d_tmp.Rows[0][0].ToString());

        }

        public void get_num_referencias()
        {
            if (referencias_id == 0)
            {
                //abrir ficheiro xls
                FileStream file = new FileStream(path_referencia, FileMode.Open, FileAccess.Read);
                hssfworkbook = new HSSFWorkbook(file);

                ISheet sheet = hssfworkbook.GetSheet("Resultados");
                referencias_num = get_column_last_row_index(0, 2) - 3;

                //fechar documento
                file.Close();
                Console.WriteLine("Num Referencias: {0}", referencias_num);
            }
            else
            {
                get_bd_num_referencias();
            }
        }

        public void get_bd_num_referencias()
        {
            DrisDB.Connect(caminho_base_dados);
            System.Data.DataTable d_tmp = new System.Data.DataTable();

            d_tmp = DrisDB.selectQuery("SELECT COUNT(*) FROM REFERENCIA_DADOS WHERE ID_REFERENCIA = '" + referencias_id + "'");

            referencias_num = Convert.ToInt32(d_tmp.Rows[0][0].ToString()) / nutrientes_num;
        }

        public void read_excel_to_array_referencias()
        {
            referencia_data = new string[referencias_num][];

            if (referencias_id == 0)
            {

                //abrir ficheiro xls
                FileStream file = new FileStream(path_referencia, FileMode.Open, FileAccess.Read);
                hssfworkbook = new HSSFWorkbook(file);
                ISheet sheet = hssfworkbook.GetSheet("Resultados");
                IRow dataRow = null;
                ICell dataCell = null;

                for (int i = 3; i < 3 + referencias_num; i++)
                {
                    dataRow = sheet.GetRow(i);
                    referencia_data[i - 3] = new string[nutrientes_num + 1];

                    for (int j = 1; j <= 1 + nutrientes_num; j++)
                    {
                        dataCell = dataRow.GetCell(j);

                        if (dataCell.CellType == NPOI.SS.UserModel.CellType.Numeric)
                            referencia_data[i - 3][j - 1] = dataCell.NumericCellValue.ToString().Trim();
                        else
                            referencia_data[i - 3][j - 1] = dataCell.ToString().Trim();
                    }
                }
                //fechar documento
                file.Close();
            }
            else
            {
                get_bd_referencia_dados();
            }

            referencias_dados_array_filter();

            nutrientes_num = tmp_nutrientes_num;
            nutrientes_lista = tmp_nutrientes_lista;
        }

        public void get_bd_referencia_dados()
        {
            referencia_data = new string[referencias_num][];

            DrisDB.Connect(caminho_base_dados);
            System.Data.DataTable d_tmp = new System.Data.DataTable();

            string sql = "SELECT ";
            sql += "* ";
            sql += "FROM REFERENCIA_DADOS ";
            sql += "WHERE ";
            sql += "ID_REFERENCIA = '" + referencias_id + "' ";

            int tmp = 0;
            d_tmp = DrisDB.selectQuery(sql);

            for (int i = 0; i < referencias_num; i++)
            {
                referencia_data[i] = new string[nutrientes_num + 1];
                for (int j = 0; j < nutrientes_num; j++)
                {
                    referencia_data[i][j] = d_tmp.Rows[tmp][3].ToString();
                    tmp++;
                }
                referencia_data[i][nutrientes_num] = d_tmp.Rows[tmp-1][5].ToString();
            }

        }

        public void referencias_dados_array_filter()
        {
            List<List<string>> tmp_list = new List<List<string>>();
            List<string> tmp_tmp_list = new List<string>();

            for (int j = 0; j < referencias_num; j++)
            {
                tmp_tmp_list = new List<string>();

                for (int i = 0; i < nutrientes_num; i++)
                {
                    if (search_array_value(tmp_nutrientes_lista, nutrientes_lista[i]))
                    {
                        tmp_tmp_list.Add(referencia_data[j][i]);
                    }
                }

                tmp_tmp_list.Add(referencia_data[j][nutrientes_num]);

                tmp_list.Add(tmp_tmp_list);
            }

            //passar para array
            referencia_data = new string[referencias_num][];

            for (int j = 0; j < referencias_num; j++)
            {
                referencia_data[j] = new string[tmp_nutrientes_num + 1];
                referencia_data[j] = tmp_list[j].ToArray();
            }

        }

        //calcula factorial de um numero
        public int Factorial(int input)
        {
            int answer = 0;

            if (input > 0)
            {
                int count = 1;
                while (count <= input)
                {
                    if (count == 1)
                    {
                        answer = 1;
                        count++;
                    }
                    else
                    {
                        answer = count * answer;
                        count++;
                    }
                }
            }

            return answer;
        }

        //faz calculos para array dos valores das referencias para escolher as relacoes
        public void calcula_normas(DataGridView dg)
        {
            referencias_combin_num = (Factorial(nutrientes_num)) / (Factorial(2) * Factorial(nutrientes_num - 2));

            

            normas_dris = new string[referencias_combin_num][];
            int tmp_index = 0;

            for (int i = 0; i < nutrientes_num; i++)
            {
                for (int j = i+1; j < nutrientes_num; j++)
                {
                    normas_dris[tmp_index] = new string[22];
                    normas_dris[tmp_index][0] = nutrientes_lista[i];
                    normas_dris[tmp_index][1] = nutrientes_lista[j];

                    //media A
                    normas_dris[tmp_index][2] = Convert.ToString(calcula_media("A", i, j, 0));
                    normas_dris[tmp_index][3] = Convert.ToString(calcula_media("A", i, j, 1));
                    //desvio padrao A
                    normas_dris[tmp_index][4] = Convert.ToString(calcula_desviopadrao("A", i, j, 0, normas_dris[tmp_index][2]));
                    normas_dris[tmp_index][5] = Convert.ToString(calcula_desviopadrao("A", i, j, 1, normas_dris[tmp_index][3]));
                    //CV A
                    normas_dris[tmp_index][6] = Convert.ToString(Convert.ToDouble(normas_dris[tmp_index][4]) / Convert.ToDouble(normas_dris[tmp_index][2]));
                    normas_dris[tmp_index][7] = Convert.ToString(Convert.ToDouble(normas_dris[tmp_index][5]) / Convert.ToDouble(normas_dris[tmp_index][3]));
                    //VAR A
                    normas_dris[tmp_index][8] = Convert.ToString(Math.Pow(Convert.ToDouble(normas_dris[tmp_index][4]), 2));
                    normas_dris[tmp_index][9] = Convert.ToString(Math.Pow(Convert.ToDouble(normas_dris[tmp_index][5]), 2));

                    //media B
                    normas_dris[tmp_index][10] = Convert.ToString(calcula_media("B", i, j, 0));
                    normas_dris[tmp_index][11] = Convert.ToString(calcula_media("B", i, j, 1));
                    //desvio padrao B
                    normas_dris[tmp_index][12] = Convert.ToString(calcula_desviopadrao("B", i, j, 0, normas_dris[tmp_index][10]));
                    normas_dris[tmp_index][13] = Convert.ToString(calcula_desviopadrao("B", i, j, 1, normas_dris[tmp_index][11]));
                    //CV B
                    normas_dris[tmp_index][14] = Convert.ToString(Convert.ToDouble(normas_dris[tmp_index][12]) / Convert.ToDouble(normas_dris[tmp_index][10]));
                    normas_dris[tmp_index][15] = Convert.ToString(Convert.ToDouble(normas_dris[tmp_index][13]) / Convert.ToDouble(normas_dris[tmp_index][11]));
                    //VAR B
                    normas_dris[tmp_index][16] = Convert.ToString(Math.Pow(Convert.ToDouble(normas_dris[tmp_index][12]), 2));
                    normas_dris[tmp_index][17] = Convert.ToString(Math.Pow(Convert.ToDouble(normas_dris[tmp_index][13]), 2));

                    //calculo divisao das variancias CRITÉRIO LETZSCH
                    normas_dris[tmp_index][18] = Convert.ToString(Convert.ToDouble(normas_dris[tmp_index][8]) / Convert.ToDouble(normas_dris[tmp_index][16]));
                    normas_dris[tmp_index][19] = Convert.ToString(Convert.ToDouble(normas_dris[tmp_index][9]) / Convert.ToDouble(normas_dris[tmp_index][17]));

                    if (Convert.ToDouble(normas_dris[tmp_index][18]) > Convert.ToDouble(normas_dris[tmp_index][19]))
                    {
                        normas_dris[tmp_index][20] = String.Format("{0}/{1}", nutrientes_lista[i], nutrientes_lista[j]);
                        normas_dris[tmp_index][21] = "0";
                    }
                    else
                    {
                        normas_dris[tmp_index][20] = String.Format("{0}/{1}", nutrientes_lista[j], nutrientes_lista[i]);
                        normas_dris[tmp_index][21] = "1";
                    }

                    tmp_index += 1;
                }
            }

            //mostra dados para modificacao das relacoes
            System.Data.DataTable dt = new System.Data.DataTable();

            dt.Columns.Add(new DataColumn("Nut. A", typeof(String)));
            dt.Columns.Add(new DataColumn("Nut. B", typeof(String)));
            dt.Columns.Add(new DataColumn("Rel. Dir.", typeof(String)));
            dt.Columns.Add(new DataColumn("Rel. Inv.", typeof(String)));

            string tmp_rel0 = "";
            string tmp_rel1 = "";

            for (int i = 0; i < referencias_combin_num; i++)
            {
                if (normas_dris[i][21] == "0")
                {
                    tmp_rel0 = "X";
                    tmp_rel1 = "";
                }
                else
                {
                    tmp_rel0 = "";
                    tmp_rel1 = "X";
                }

                dt.Rows.Add(normas_dris[i][0], normas_dris[i][1], tmp_rel0, tmp_rel1);
            }

            dg.DataSource = dt;

            for (int i = 0; i < dg.Columns.Count; i++)
            {
                dg.Columns[i].Width = 280 / dg.Columns.Count;
            }

            //alinhamento ao centro
            dg.Columns[2].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dg.Columns[3].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter;

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dg.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }

        }

        //muda as relacoes para as que foram modificadas
        public void relacoes_selection_filter(DataGridView dg)
        {
            for (int i = 0; i < dg.RowCount; i++)
            {
                if (dg.Rows[i].Cells[2].Value.ToString() == "X")
                {
                    normas_dris[i][20] = String.Format("{0}/{1}", normas_dris[i][0], normas_dris[i][1]);
                    normas_dris[i][21] = "0";
                }
                else
                {
                    normas_dris[i][20] = String.Format("{0}/{1}", normas_dris[i][1], normas_dris[i][0]);
                    normas_dris[i][21] = "1";
                }
            }
        }

        //guarda os valores das normas no projecto Excel
        public void guarda_normas_projecto()
        {
            FileStream file = new FileStream(path_projecto, FileMode.Open, FileAccess.ReadWrite);
            HSSFWorkbook hssfworkbook = new HSSFWorkbook(file);
            file.Close();

            ISheet sheet = hssfworkbook.GetSheet("Resultado");
            
            double number;

            for (int i = 0; i < normas_dris.Length; i++)
            {
                IRow dataRow = sheet.CreateRow(i+3);
                for (int j = 0; j < normas_dris[i].Length - 1; j++)
                {
                    if (Double.TryParse(normas_dris[i][j], out number))
                    {
                        dataRow.CreateCell(j).SetCellType(NPOI.SS.UserModel.CellType.Numeric);
                        dataRow.CreateCell(j).SetCellValue(Convert.ToDouble(normas_dris[i][j]));
                    }
                    else
                    {
                        dataRow.CreateCell(j).SetCellType(NPOI.SS.UserModel.CellType.String);
                        dataRow.CreateCell(j).SetCellValue(normas_dris[i][j]);
                    }
                    
                }
            }

            file = new FileStream(path_projecto, FileMode.Open, FileAccess.ReadWrite);
            hssfworkbook.Write(file);
            //fechar documento
            file.Close();
        }

        //calcula a media de dois nutrientes com base na sua produtividade e no tipo da relacao(0-direta/1-inversa)
        public double calcula_media(string produtividade, int nutriente_i, int nutriente_j, int tipo)
        {
            double soma = 0;
            int tmp_num = 0;

            for (int i = 0; i < referencia_data.Length; i++)
            {
                if (referencia_data[i][nutrientes_num] == produtividade) 
                {
                    tmp_num += 1;

                    if (tipo == 0)
                    {
                        soma += Convert.ToDouble(referencia_data[i][nutriente_i]) / Convert.ToDouble(referencia_data[i][nutriente_j]);
                    }
                    else
                    {
                        soma += Convert.ToDouble(referencia_data[i][nutriente_j]) / Convert.ToDouble(referencia_data[i][nutriente_i]);
                    }

                }
            }

            return soma/tmp_num;
        }

        //calcula o desvio padrao de dois nutrientes com base na sua produtividade e no tipo da relacao(0-direta/1-inversa)
        public double calcula_desviopadrao(string produtividade, int nutriente_i, int nutriente_j, int tipo, string media)
        {
            double soma = 0;
            int tmp_num = 0;

            for (int i = 0; i < referencia_data.Length; i++)
            {
                if (referencia_data[i][nutrientes_num] == produtividade)
                {
                    tmp_num += 1;

                    if (tipo == 0)
                    {
                        soma += Math.Pow(((Convert.ToDouble(referencia_data[i][nutriente_i]) / Convert.ToDouble(referencia_data[i][nutriente_j])) - Convert.ToDouble(media)), 2);
                    }
                    else
                    {
                        soma += Math.Pow(((Convert.ToDouble(referencia_data[i][nutriente_j]) / Convert.ToDouble(referencia_data[i][nutriente_i])) - Convert.ToDouble(media)), 2);
                    }

                }
            }

            return Math.Sqrt( soma / (tmp_num - 1) );
        }

        //usando metodo de beaufils, guarda no array amostras_combinacoes_dris os valores de cada relacao
        public void calcula_metodo_beaufils()
        {
            double tmp_ab = 0;
            double tmp_A = 0;
            double tmp_B = 0;
            double tmp_cv_ab = 0;
            double tmp_final = 0;

            amostras_combinacoes_dris = new string[referencias_combin_num][];
            for (int i = 0; i < referencias_combin_num; i++)
            {
                //amostra_data
                amostras_combinacoes_dris[i] = new string[amostras_num];
                
                for (int j = 0; j < amostras_num; j++)
                {
                    
                    //relacao directa
                    if (normas_dris[i][21] == "0")
                    {
                        tmp_ab = Convert.ToDouble(normas_dris[i][2]);
                        tmp_A = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][0])]);
                        tmp_B = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][1])]);
                        tmp_cv_ab = Convert.ToDouble(normas_dris[i][6]);

                        //se A/B(amostra)<a/b(referencia)
                        if ( tmp_A / tmp_B < tmp_ab )
                        {
                            tmp_final = (1 - (tmp_ab / (tmp_A / tmp_B))) * ((100 * 0.1) / (tmp_cv_ab * 100)) * 100;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                        //se A/B(amostra)>a/b(referencia)
                        else if (tmp_A / tmp_B > tmp_ab)
                        {
                            tmp_final = (((tmp_A / tmp_B) / tmp_ab) - 1) * ((100 * 0.1) / (tmp_cv_ab * 100)) * 100;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                        //se A/B(amostra)=a/b(referencia)
                        else
                        {
                            tmp_final = 0;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                    }
                    //relacao inversa
                    else
                    {
                        tmp_ab = Convert.ToDouble(normas_dris[i][3]);
                        tmp_A = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][1])]);
                        tmp_B = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][0])]);
                        tmp_cv_ab = Convert.ToDouble(normas_dris[i][7]);

                        //se A/B(amostra)<a/b(referencia)
                        if (tmp_A / tmp_B < tmp_ab)
                        {
                            tmp_final = (1 - (tmp_ab / (tmp_A / tmp_B))) * ((0.1) / (tmp_cv_ab)) * 100;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                        //se A/B(amostra)>a/b(referencia)
                        else if (tmp_A / tmp_B > tmp_ab)
                        {
                            tmp_final = (((tmp_A / tmp_B) / tmp_ab) - 1) * ((0.1) / (tmp_cv_ab)) * 100;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                        //se A/B(amostra)=a/b(referencia)
                        else
                        {
                            tmp_final = 0;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                    }
                }
            }
        }

        public void calcula_metodo_jones()
        {
            double tmp_ab = 0;
            double tmp_A = 0;
            double tmp_B = 0;
            double tmp_s_ab = 0;
            double tmp_final = 0;

            amostras_combinacoes_dris = new string[referencias_combin_num][];
            for (int i = 0; i < referencias_combin_num; i++)
            {
                //amostra_data
                amostras_combinacoes_dris[i] = new string[amostras_num];

                for (int j = 0; j < amostras_num; j++)
                {

                    //relacao directa
                    if (normas_dris[i][21] == "0")
                    {
                        tmp_ab = Convert.ToDouble(normas_dris[i][2]);
                        tmp_A = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][0])]);
                        tmp_B = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][1])]);
                        tmp_s_ab = Convert.ToDouble(normas_dris[i][4]);

                        tmp_final = ((tmp_A / tmp_B) - tmp_ab) * (10 / tmp_s_ab);
                        amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                    }
                    //relacao inversa
                    else
                    {
                        tmp_ab = Convert.ToDouble(normas_dris[i][3]);
                        tmp_A = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][1])]);
                        tmp_B = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][0])]);
                        tmp_s_ab = Convert.ToDouble(normas_dris[i][5]);

                        tmp_final = ((tmp_A / tmp_B) - tmp_ab) * (10 / tmp_s_ab);
                        amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                    }
                }
            }
        }

        public void calcula_metodo_elwali_gascho()
        {
            double tmp_ab = 0;
            double tmp_A = 0;
            double tmp_B = 0;
            double tmp_cv_ab = 0;
            double tmp_s_ab = 0;
            double tmp_final = 0;

            amostras_combinacoes_dris = new string[referencias_combin_num][];
            for (int i = 0; i < referencias_combin_num; i++)
            {
                //amostra_data
                amostras_combinacoes_dris[i] = new string[amostras_num];

                for (int j = 0; j < amostras_num; j++)
                {

                    //relacao directa
                    if (normas_dris[i][21] == "0")
                    {
                        tmp_ab = Convert.ToDouble(normas_dris[i][2]);
                        tmp_A = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][0])]);
                        tmp_B = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][1])]);
                        tmp_cv_ab = Convert.ToDouble(normas_dris[i][6]);
                        tmp_s_ab = Convert.ToDouble(normas_dris[i][4]);

                        //se A/B(amostra)<a/b(referencia)
                        if (tmp_A / tmp_B < (tmp_ab - tmp_s_ab))
                        {
                            tmp_final = (1 - (tmp_ab / (tmp_A / tmp_B))) * ((100 * 0.1) / (tmp_cv_ab * 100)) * 100;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                        //se A/B(amostra)>a/b(referencia)
                        else if (tmp_A / tmp_B > (tmp_ab + tmp_s_ab))
                        {
                            tmp_final = (((tmp_A / tmp_B) / tmp_ab) - 1) * ((100 * 0.1) / (tmp_cv_ab * 100)) * 100;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                        //se A/B(amostra)=a/b(referencia)
                        else
                        {
                            tmp_final = 0;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                    }
                    //relacao inversa
                    else
                    {
                        tmp_ab = Convert.ToDouble(normas_dris[i][3]);
                        tmp_A = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][1])]);
                        tmp_B = Convert.ToDouble(amostra_data[j][get_index_nutriente(normas_dris[i][0])]);
                        tmp_cv_ab = Convert.ToDouble(normas_dris[i][7]);
                        tmp_s_ab = Convert.ToDouble(normas_dris[i][5]);

                        //se A/B(amostra)<a/b(referencia)
                        if (tmp_A / tmp_B < (tmp_ab - tmp_s_ab))
                        {
                            tmp_final = (1 - (tmp_ab / (tmp_A / tmp_B))) * ((0.1) / (tmp_cv_ab)) * 100;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                        //se A/B(amostra)>a/b(referencia)
                        else if (tmp_A / tmp_B > (tmp_ab + tmp_s_ab))
                        {
                            tmp_final = (((tmp_A / tmp_B) / tmp_ab) - 1) * ((0.1) / (tmp_cv_ab)) * 100;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                        //se A/B(amostra)=a/b(referencia)
                        else
                        {
                            tmp_final = 0;
                            amostras_combinacoes_dris[i][j] = tmp_final.ToString();
                        }
                    }
                }
            }
        }

        public void guarda_valores_dris_projecto()
        {
            FileStream file = new FileStream(path_projecto, FileMode.Open, FileAccess.ReadWrite);
            HSSFWorkbook hssfworkbook = new HSSFWorkbook(file);
            file.Close();

            ISheet sheet = hssfworkbook.GetSheet("Resultado");
            int tmp_col;

            for (int i = 0; i < amostras_combinacoes_dris.Length; i++)
            {
                tmp_col = 21;
                IRow dataRow = sheet.GetRow(i + 3);
                for (int j = 0; j < amostras_num; j++)
                {
                    dataRow.CreateCell(tmp_col).SetCellType(NPOI.SS.UserModel.CellType.Numeric);
                    dataRow.CreateCell(tmp_col).SetCellValue(Convert.ToDouble(amostras_combinacoes_dris[i][j]));
                    tmp_col += 2;
                }
            }

            file = new FileStream(path_projecto, FileMode.Open, FileAccess.ReadWrite);
            hssfworkbook.Write(file);
            //fechar documento
            file.Close();
        }

        //calcula os indices dris para cada nutriente com base na sua relacao
        public void calcula_indices_dris_nutrientes()
        {
            amostras_indices_dris = new string[nutrientes_num][];
            double tmp_indice;

            for (int i = 0; i < nutrientes_num; i++)
            {
                amostras_indices_dris[i] = new string[amostras_num];

                for (int j = 0; j < amostras_num; j++)
                {
                    tmp_indice = get_indice_dris_nutriente(nutrientes_lista[i], j);
                    amostras_indices_dris[i][j] = tmp_indice.ToString();
                }
            }
        }

        public double get_indice_dris_nutriente(string nutriente, int indice_amostra)
        {
            int tmp_numerador = 0;
            int tmp_denominador = 0;

            double soma_numerador = 0;
            double soma_denominador = 0;

            for (int k = 0; k < referencias_combin_num; k++)
            {
                if (normas_dris[k][0] == nutriente)
                {
                    //numerador
                    if (normas_dris[k][21] == "0")
                    {
                        tmp_numerador += 1;
                        soma_numerador += Convert.ToDouble(amostras_combinacoes_dris[k][indice_amostra]);
                    }
                    //denominador
                    else
                    {
                        tmp_denominador += 1;
                        soma_denominador += Convert.ToDouble(amostras_combinacoes_dris[k][indice_amostra]);
                    }

                }
                else if (normas_dris[k][1] == nutriente)
                {
                    //denominador
                    if (normas_dris[k][21] == "0")
                    {
                        tmp_denominador += 1;
                        soma_denominador += Convert.ToDouble(amostras_combinacoes_dris[k][indice_amostra]);
                    }
                    //numerador
                    else
                    {
                        tmp_numerador += 1;
                        soma_numerador += Convert.ToDouble(amostras_combinacoes_dris[k][indice_amostra]);
                    }

                }
            }

            return (soma_numerador-soma_denominador)/(tmp_numerador+tmp_denominador);
        }

        public int get_index_nutriente(string nome)
        {
            int tmp_index = 0;
            foreach (string i in nutrientes_lista)
            {
                if (i == nome)
                    return tmp_index;
                tmp_index++;
            }
            return -1;
        }

        public void guarda_indices_dris_projecto()
        {
            FileStream file = new FileStream(path_projecto, FileMode.Open, FileAccess.ReadWrite);
            HSSFWorkbook hssfworkbook = new HSSFWorkbook(file);
            file.Close();

            ISheet sheet = hssfworkbook.GetSheet("Resultado");
            int tmp_col;
            int tmp_lin = 0;
            int tmp_int = 1;

            for (int i = 0; i < nutrientes_num-1; i++)
            {
                tmp_col = 22;
                IRow dataRow = sheet.GetRow(tmp_lin + 3);
                for (int j = 0; j < amostras_num; j++)
                {
                    dataRow.CreateCell(tmp_col).SetCellType(NPOI.SS.UserModel.CellType.Numeric);
                    dataRow.CreateCell(tmp_col).SetCellValue(Convert.ToDouble(amostras_indices_dris[i][j]));
                    tmp_col += 2;
                }
                
                tmp_lin += (nutrientes_num - tmp_int);
                tmp_int += 1;
            }

            file = new FileStream(path_projecto, FileMode.Open, FileAccess.ReadWrite);
            hssfworkbook.Write(file);
            //fechar documento
            file.Close();
        }

        //aplica formatacao no ficheiro do projecto
        public void set_projecto_style()
        {
            //cabecalho
            limite_style(2, 21, 2, 20, 0, 0);
            limite_style(2, 10, 2, 9, 1, 0);
            limite_style(10, 18, 10, 17, 1, 0);
            limite_style(18, 21, 18, 20, 1, 0);

            for (int i = 2; i < 21; i++)
            {
                limite_style(i, i+1, i, i, 2, 1);
            }
        }

        public void limite_style(int inicio, int fim, int esquerda, int direita, int linha, int tudo)
        {
            FileStream file = new FileStream(path_projecto, FileMode.Open, FileAccess.ReadWrite);
            HSSFWorkbook hssfworkbook = new HSSFWorkbook(file);
            file.Close();

            ISheet sheet = hssfworkbook.GetSheet("Resultado");

            ICellStyle style_cima_baixo = hssfworkbook.CreateCellStyle();
            ICellStyle style_esq = hssfworkbook.CreateCellStyle();
            ICellStyle style_dir = hssfworkbook.CreateCellStyle();
            ICellStyle style_tudo = hssfworkbook.CreateCellStyle();

            style_cima_baixo.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;
            style_cima_baixo.BorderTop = NPOI.SS.UserModel.BorderStyle.Medium;
            style_cima_baixo.BorderBottom = NPOI.SS.UserModel.BorderStyle.Medium;

            style_esq.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;
            style_esq.BorderLeft = NPOI.SS.UserModel.BorderStyle.Medium;
            style_esq.BorderTop = NPOI.SS.UserModel.BorderStyle.Medium;
            style_esq.BorderBottom = NPOI.SS.UserModel.BorderStyle.Medium;

            style_dir.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;
            style_dir.BorderRight = NPOI.SS.UserModel.BorderStyle.Medium;
            style_dir.BorderTop = NPOI.SS.UserModel.BorderStyle.Medium;
            style_dir.BorderBottom = NPOI.SS.UserModel.BorderStyle.Medium;

            style_tudo.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;
            style_tudo.BorderTop = NPOI.SS.UserModel.BorderStyle.Medium;
            style_tudo.BorderBottom = NPOI.SS.UserModel.BorderStyle.Medium;
            style_tudo.BorderLeft = NPOI.SS.UserModel.BorderStyle.Medium;
            style_tudo.BorderRight = NPOI.SS.UserModel.BorderStyle.Medium;

            //cabecalho
            IRow dataRow = sheet.GetRow(linha);

            for (int i = inicio; i < fim; i++)
            {
                try
                {
                    if (tudo == 1)
                    {
                        dataRow.GetCell(i).CellStyle = style_tudo;
                    }
                    else if (i == esquerda)
                    {
                        dataRow.GetCell(i).CellStyle = style_esq;
                    }
                    else if (i == direita)
                    {
                        dataRow.GetCell(i).CellStyle = style_dir;
                    }
                    else
                    {
                        dataRow.GetCell(i).CellStyle = style_cima_baixo;
                    }
                }
                catch
                {
                    if (tudo == 1)
                    {
                        dataRow.CreateCell(i).CellStyle = style_tudo;
                    }
                    else if (i == esquerda)
                    {
                        dataRow.CreateCell(i).CellStyle = style_esq;
                    }
                    if (i == direita)
                    {
                        dataRow.CreateCell(i).CellStyle = style_dir;
                    }
                    else
                    {
                        dataRow.CreateCell(i).CellStyle = style_cima_baixo;
                    }
                }
            }

            file = new FileStream(path_projecto, FileMode.Open, FileAccess.ReadWrite);
            hssfworkbook.Write(file);
            //fechar documento
            file.Close();
        }

        public void preencher_dris_inicial(DataGridView dris_inicial, int indice_amostra, int tipo)
        {
            dris_inicial.Rows.Clear();
            for (int i = 0; i < nutrientes_num; i++)
            {
                if(tipo == 0)
                    dris_inicial.Rows.Add(nutrientes_lista[i], inicial_amostras_indices_dris[i][indice_amostra]);
                else
                    dris_inicial.Rows.Add(nutrientes_lista[i], amostras_indices_dris[i][indice_amostra]);
            }

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dris_inicial.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }
        }

        public void desenha_grafico_dris_inicial(ZedGraphControl zedGraphControl1, int indice_amostra)
        {

            zedGraphControl1.MasterPane.PaneList.Clear();
            
            zedGraphControl1.GraphPane = new GraphPane();
            GraphPane myPane = zedGraphControl1.GraphPane;

            myPane.Title.Text = "DRIS";
            myPane.YAxis.Title.Text = "Nutrientes";
            myPane.XAxis.Title.Text = "Índice";
            double tmp_value;

            double[] red_values = new double[nutrientes_num];
            double[] yellow_values = new double[nutrientes_num];
            double[] green_values = new double[nutrientes_num];
            double tmp_max = 0;

            for (int i = 0; i < amostras_indices_dris.Length; i++)
            {
                tmp_value = Convert.ToDouble(amostras_indices_dris[i][indice_amostra]);

                if (Math.Abs(tmp_value) > tmp_max)
                {
                    tmp_max = Math.Abs(tmp_value);
                }

                //critical, critical, i want to get physical
                if (tmp_value < -30 || tmp_value > 30)
                {
                    red_values[nutrientes_num - i - 1] = tmp_value;
                    yellow_values[nutrientes_num - i - 1] = 0;
                    green_values[nutrientes_num - i - 1] = 0;
                }
                //ligeiro
                if ((tmp_value >= -30 && tmp_value < -15) || (tmp_value > 15 && tmp_value <= 30))
                {
                    yellow_values[nutrientes_num - i - 1] = tmp_value;
                    green_values[nutrientes_num - i - 1] = 0;
                    red_values[nutrientes_num - i - 1] = 0;
                }
                //greeny
                if ((tmp_value >= -15 && tmp_value <= 0) || (tmp_value >= 0 && tmp_value <= 15))
                {
                    green_values[nutrientes_num - i - 1] = tmp_value;
                    red_values[nutrientes_num - i - 1] = 0;
                    yellow_values[nutrientes_num - i - 1] = 0;
                }
            }

            BarItem myCurve = myPane.AddBar("", red_values, null, System.Drawing.Color.Red);
            myCurve.Bar.Fill = new ZedGraph.Fill(System.Drawing.Color.Red, System.Drawing.Color.White, System.Drawing.Color.Red, 90f);

            BarItem myCurve2 = myPane.AddBar("", yellow_values, null, System.Drawing.Color.Yellow);
            myCurve2.Bar.Fill = new ZedGraph.Fill(System.Drawing.Color.Yellow, System.Drawing.Color.White, System.Drawing.Color.Yellow, 90f);

            BarItem myCurve3 = myPane.AddBar("", green_values, null, System.Drawing.Color.Green);
            myCurve3.Bar.Fill = new ZedGraph.Fill(System.Drawing.Color.Green, System.Drawing.Color.White, System.Drawing.Color.Green, 90f);

            String[] nut_copy = (String[])nutrientes_lista.Clone();

            Array.Reverse(nut_copy);

            myPane.YAxis.Scale.TextLabels = nut_copy;
            
            myPane.YAxis.Type = ZedGraph.AxisType.Text;

            myPane.BarSettings.Type = BarType.Stack;
            myPane.BarSettings.Base = BarBase.Y;

            myPane.Chart.Fill = new ZedGraph.Fill(System.Drawing.Color.White,
                System.Drawing.Color.FromArgb(255, 255, 166), 45.0F);

            myPane.XAxis.Scale.Min = -Math.Round(tmp_max) - 5;
            myPane.XAxis.Scale.Max = Math.Round(tmp_max) + 5;

            zedGraphControl1.AxisChange();
            myPane.Rect = zedGraphControl1.MasterPane.Rect;
            zedGraphControl1.MasterPane.Add(myPane);
            zedGraphControl1.Refresh();
        }

        public void preencher_combo_amostras(ComboBox cb)
        {
            cb.Items.Clear();
            for (int i = 0; i < amostras_num; i++)
            {
                cb.Items.Add(amostra_data_nomes[i]);
            }
            cb.SelectedIndex = 0;
        }

        public void calcula_ibn_amostras()
        {
            ibn_amostra = new string[amostras_num];
            double tmp_soma;

            for (int i = 0; i < amostras_num; i++)
            {
                tmp_soma = 0;
                for (int j = 0; j < nutrientes_num; j++)
                {
                    tmp_soma += Math.Abs(Convert.ToDouble(amostras_indices_dris[j][i]));
                }
                ibn_amostra[i] = tmp_soma.ToString();
            }
        }

        public void preencher_ibn_amostra(System.Windows.Forms.TextBox ibn_inicial_tb, System.Windows.Forms.TextBox ibn_medio_inicial_tb, int index_amostra, int tipo)
        {
            if (tipo == 0)
            {
                ibn_inicial_tb.Text = Math.Round(Convert.ToDouble(inicial_ibn_amostra[index_amostra]), 3).ToString();
                ibn_medio_inicial_tb.Text = Math.Round((Convert.ToDouble(inicial_ibn_amostra[index_amostra]) / nutrientes_num), 3).ToString();
            }
            else
            {
                ibn_inicial_tb.Text = Math.Round(Convert.ToDouble(ibn_amostra[index_amostra]), 3).ToString();
                ibn_medio_inicial_tb.Text = Math.Round((Convert.ToDouble(ibn_amostra[index_amostra]) / nutrientes_num), 3).ToString();
            }

        }

        public int get_grid_report(double real, double min, double max)
        {
            //1-vermelho; 2-verde; 3-amarelo
            double factor = 0.2;
            double c_min = min * factor;
            double c_max = max + (max * factor);
            double c_med = (max + min) / 2;
            double c_med1 = (min + c_med) / 2;
            double c_med2 = (c_med + max) / 2;

            if (real > max && real <= c_max)
            {
                return 3;
            }
            else if (real > c_max && real <= 2 * c_max)
            {
                return 3;
            }
            else if (real > 2 * c_max && real <= 3 * c_max)
            {
                return 3;
            }
            else if (real > 3 * c_max && real <= 4 * c_max)
            {
                return 1;
            }
            else if (real > 4 * c_max)
            {
                return 1;
            }
            else if (min - c_min <= real && real < min)
            {
                return 3;
            }
            else if (min - 2 * c_min <= real && real < min - c_min)
            {
                return 3;
            }
            else if (min - 3 * c_min <= real && real < min - 2 * c_min)
            {
                return 3;
            }
            else if (min - 4 * c_min <= real && real < min - 3 * c_min)
            {
                return 1;
            }
            else if (real < min - 4 * c_min)
            {
                return 1;
            }
            else if (min <= real && real <= c_med1)
            {
                return 2;
            }
            else if (c_med1 < real && real <= c_med2)
            {
                return 2;
            }
            else if (c_med2 < real && real <= max)
            {
                return 2;
            }

            return 0;
        }

        public void carrega_dados_amostra_recomendacao(int amostra_index, DataGridView grid_recomendacao, DataGridView grid_recomendacao_sensibilidade, DataGridView grid_recomendacao_max_min, DataGridView grid_optimizacao_ibn, ZedGraphControl grafico_recomendacao, DataGridView grid_dados_amostra, DataGridView dg_cores)
        {
            //grelha cores
            //1-vermelho; 2-verde; 3-amarelo

            System.Data.DataTable dt_cores = new System.Data.DataTable();

            for (int i = 0; i < nutrientes_num; i++)
            {
                dt_cores.Columns.Add(new DataColumn(nutrientes_lista[i], typeof(String)));
            }

            dt_cores.Rows.Add("");
            for (int i = 0; i < nutrientes_num; i++)
            {
                double valor_real = Convert.ToDouble( inicial_amostra_data[amostra_index][i] );
                double valor_min = Convert.ToDouble( inicial_amostra_data[0][i] );
                double valor_max = Convert.ToDouble( inicial_amostra_data[1][i] );
                int tipo = get_grid_report(valor_real, valor_min, valor_max);

                if( valor_real < valor_min )
                {
                    dt_cores.Rows[0][i] = "I";
                }
                else if (valor_real > valor_max)
                {
                    dt_cores.Rows[0][i] = "E";
                }
                else
                {
                    dt_cores.Rows[0][i] = "S";
                }

                if (tipo == 1)
                {
                    dt_cores.Rows[0][i] = dt_cores.Rows[0][i] + ";1";
                }
                else if (tipo == 2)
                {
                    dt_cores.Rows[0][i] = dt_cores.Rows[0][i] + ";2";
                }
                else if (tipo == 3)
                {
                    dt_cores.Rows[0][i] = dt_cores.Rows[0][i] + ";3";
                }
            }
            dg_cores.DataSource = dt_cores;

            for (int i = 0; i < dg_cores.Columns.Count; i++)
            {
                dg_cores.Columns[i].Width = 650 / dg_cores.Columns.Count;
            }
            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in dg_cores.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }



            //grelha base
            System.Data.DataTable dt = new System.Data.DataTable();

            for (int i = 0; i < nutrientes_num; i++)
            {
                dt.Columns.Add(new DataColumn(nutrientes_lista[i], typeof(String)));
            }

            dt.Rows.Add("");

            for (int i = 0; i < nutrientes_num; i++)
            {
                dt.Rows[0][i] = amostras_indices_dris[i][amostra_index];
            }

            grid_recomendacao.DataSource = dt;
            for (int i = 0; i < grid_recomendacao.Columns.Count; i++)
            {
                grid_recomendacao.Columns[i].Width = 650 / grid_recomendacao.Columns.Count;
            }

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in grid_recomendacao.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }


            //grelha sensibilidade
            System.Data.DataTable dt2 = new System.Data.DataTable();

            for (int i = 0; i < nutrientes_num; i++)
            {
                dt2.Columns.Add(new DataColumn(nutrientes_lista[i], typeof(String)));
            }

            dt2.Rows.Add("");

            grid_recomendacao_sensibilidade.DataSource = dt2;
            for (int i = 0; i < grid_recomendacao_sensibilidade.Columns.Count; i++)
            {
                grid_recomendacao_sensibilidade.Columns[i].Width = 650 / grid_recomendacao_sensibilidade.Columns.Count;
            }

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in grid_recomendacao_sensibilidade.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }


            //grelha grid_recomendacao_maximo
            System.Data.DataTable dt3 = new System.Data.DataTable();

            for (int i = 0; i < nutrientes_num; i++)
            {
                dt3.Columns.Add(new DataColumn(nutrientes_lista[i], typeof(String)));
            }

            dt3.Rows.Add("");

            grid_recomendacao_max_min.DataSource = dt3;
            for (int i = 0; i < grid_recomendacao_max_min.Columns.Count; i++)
            {
                grid_recomendacao_max_min.Columns[i].Width = 650 / grid_recomendacao_max_min.Columns.Count;
            }

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in grid_recomendacao_max_min.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }

            //grelha grid_dados_amostra
            System.Data.DataTable dt4 = new System.Data.DataTable();

            for (int i = 0; i < nutrientes_num; i++)
            {
                dt4.Columns.Add(new DataColumn(nutrientes_lista[i], typeof(String)));
            }

            dt4.Rows.Add("");

            for (int i = 0; i < nutrientes_num; i++)
            {
                dt4.Rows[0][i] = inicial_amostra_data[amostra_index][i];
            }

            grid_dados_amostra.DataSource = dt4;
            for (int i = 0; i < grid_dados_amostra.Columns.Count; i++)
            {
                grid_dados_amostra.Columns[i].Width = 650 / grid_dados_amostra.Columns.Count;
            }

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in grid_dados_amostra.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }

            //grelha ibn
            System.Data.DataTable dt5 = new System.Data.DataTable();
            dt5.Columns.Add(new DataColumn("IBN", typeof(String)));
            grid_optimizacao_ibn.DataSource = dt5;
            grid_optimizacao_ibn.Columns[0].Width = 118;

            dt5.Rows.Add("");

            dt5.Rows[0][0] = ibn_amostra[amostra_index];

            //desliga a ordenacao das colunas
            foreach (DataGridViewColumn column in grid_optimizacao_ibn.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.NotSortable;
            }

            //grafico

            string[] tmp_array = new string[nutrientes_num];
            for (int i = 0; i < nutrientes_num; i++)
            {
                tmp_array[i] = amostras_indices_dris[i][amostra_index];
            }

            desenha_grafico_recomendacao(grafico_recomendacao, tmp_array);
        }

        public void desenha_grafico_recomendacao(ZedGraphControl zd, string[] valores)
        {

            zd.MasterPane.PaneList.Clear();

            zd.GraphPane = new GraphPane();
            GraphPane myPane = zd.GraphPane;

            myPane.Title.Text = "DRIS";
            myPane.YAxis.Title.Text = "Nutrientes";
            myPane.XAxis.Title.Text = "Índice";
            double tmp_value;

            double[] red_values = new double[nutrientes_num];
            double[] yellow_values = new double[nutrientes_num];
            double[] green_values = new double[nutrientes_num];
            double tmp_max = 0;

            for (int i = 0; i < valores.Length; i++)
            {
                tmp_value = Convert.ToDouble(valores[i]);

                if (Math.Abs(tmp_value) > tmp_max)
                {
                    tmp_max = Math.Abs(tmp_value);
                }

                //critical, critical, i want to get physical
                if (tmp_value < -30 || tmp_value > 30)
                {
                    red_values[nutrientes_num - i - 1] = tmp_value;
                    yellow_values[nutrientes_num - i - 1] = 0;
                    green_values[nutrientes_num - i - 1] = 0;
                }
                //ligeiro
                if ((tmp_value >= -30 && tmp_value < -15) || (tmp_value > 15 && tmp_value <= 30))
                {
                    yellow_values[nutrientes_num - i - 1] = tmp_value;
                    green_values[nutrientes_num - i - 1] = 0;
                    red_values[nutrientes_num - i - 1] = 0;
                }
                //greeny
                if ((tmp_value >= -15 && tmp_value <= 0) || (tmp_value >= 0 && tmp_value <= 15))
                {
                    green_values[nutrientes_num - i - 1] = tmp_value;
                    red_values[nutrientes_num - i - 1] = 0;
                    yellow_values[nutrientes_num - i - 1] = 0;
                }
            }

            BarItem myCurve = myPane.AddBar("", red_values, null, System.Drawing.Color.Red);
            myCurve.Bar.Fill = new ZedGraph.Fill(System.Drawing.Color.Red, System.Drawing.Color.White, System.Drawing.Color.Red, 90f);

            BarItem myCurve2 = myPane.AddBar("", yellow_values, null, System.Drawing.Color.Yellow);
            myCurve2.Bar.Fill = new ZedGraph.Fill(System.Drawing.Color.Yellow, System.Drawing.Color.White, System.Drawing.Color.Yellow, 90f);

            BarItem myCurve3 = myPane.AddBar("", green_values, null, System.Drawing.Color.Green);
            myCurve3.Bar.Fill = new ZedGraph.Fill(System.Drawing.Color.Green, System.Drawing.Color.White, System.Drawing.Color.Green, 90f);

            String[] nut_copy = (String[])nutrientes_lista.Clone();

            Array.Reverse(nut_copy);

            myPane.YAxis.Scale.TextLabels = nut_copy;

            myPane.YAxis.Type = ZedGraph.AxisType.Text;

            myPane.BarSettings.Type = BarType.Stack;
            myPane.BarSettings.Base = BarBase.Y;

            myPane.Chart.Fill = new ZedGraph.Fill(System.Drawing.Color.White,
                System.Drawing.Color.FromArgb(255, 255, 166), 45.0F);

            myPane.XAxis.Scale.Min = -Math.Round(tmp_max) - 5;
            myPane.XAxis.Scale.Max = Math.Round(tmp_max) + 5;

            zd.AxisChange();
            myPane.Rect = zd.MasterPane.Rect;
            zd.MasterPane.Add(myPane);
            zd.Refresh();
        }

        public void copy_amostra_data_to_tmp_amostra_data(int amostra_index)
        {
            if (tmp_amostra_data == null)
            {
                tmp_amostra_data = new string[amostras_num][];
            }

            tmp_amostra_data[amostra_index] = new string[nutrientes_num];
            for (int j = 0; j < nutrientes_num; j++)
            {
                tmp_amostra_data[amostra_index][j] = amostra_data[amostra_index][j];
            }

            //volta a calcular
            calcula_metodo_beaufils();
            calcula_indices_dris_nutrientes();
            calcula_ibn_amostras();
        }

        public void copy_tmp_amostra_data_to_amostra_data(int amostra_index)
        {
            if (amostra_data == null)
            {
                amostra_data = new string[amostras_num][];
            }

            amostra_data[amostra_index] = new string[nutrientes_num];
            for (int j = 0; j < nutrientes_num; j++)
            {
                amostra_data[amostra_index][j] = inicial_amostra_data[amostra_index][j];
            }

            //volta a calcular
            calcula_metodo_beaufils();
            calcula_indices_dris_nutrientes();
            calcula_ibn_amostras();
        }

        public void save_sensibilidade(DataGridView dris_recomendacao_sensibilidade, int amostra_dris_optimizar)
        {
            double Num = 0;
            sensibilidade_array[amostra_dris_optimizar] = new string[nutrientes_num];
            for (int i = 0; i < dris_recomendacao_sensibilidade.Columns.Count; i++)
            {
                if (double.TryParse(dris_recomendacao_sensibilidade.Rows[0].Cells[i].Value.ToString(), out Num))
                {
                    sensibilidade_array[amostra_dris_optimizar][i] = dris_recomendacao_sensibilidade.Rows[0].Cells[i].Value.ToString();
                }
                else
                {
                    sensibilidade_array[amostra_dris_optimizar][i] = "";
                }
            }
        }

        //calcular para uma amostra os valores optimos com base nos filtros
        public void calcula_ibn_optimo(DataGridView dg_sensibilidade, DataGridView dg_max_min, int amostra_ind, ZedGraphControl grafico_recomendacao, DataGridView dris_recomendacao, DataGridView dris_optimizacao_ibn, DataGridView dris_valores_adicionar, DataGridView grid_dados_amostra, string dris_limit)
        {
            double Num = 0;

            //limita os dados pela sensibilidade
            for (int i = 0; i < dg_sensibilidade.Columns.Count; i++)
            {
                if (double.TryParse(dg_sensibilidade.Rows[0].Cells[i].Value.ToString(), out Num))
                {
                    tmp_amostra_data[amostra_ind][i] = dg_sensibilidade.Rows[0].Cells[i].Value.ToString();
                    amostra_data[amostra_ind][i] = dg_sensibilidade.Rows[0].Cells[i].Value.ToString();
                }
            }

            while (existe_nutriente_dris_mau(amostra_ind, dris_limit, dg_max_min))
            {
                for (int i = 0; i < nutrientes_num; i++)
                {
                    if (Convert.ToDouble(amostras_indices_dris[i][amostra_ind]) < 0.0)
                    {
                        calcula_melhor_dris(amostra_ind, i, dg_max_min.Rows[0].Cells[i].Value.ToString(), dg_max_min.Rows[0].Cells[i].Value.ToString());
                    }
                }
            }

            //grafico

            string[] tmp_array = new string[nutrientes_num];
            for (int i = 0; i < nutrientes_num; i++)
            {
                tmp_array[i] = amostras_indices_dris[i][amostra_ind];
            }

            desenha_grafico_recomendacao(grafico_recomendacao, tmp_array);

            //IBN
            System.Data.DataTable dt = new System.Data.DataTable();
            dt.Columns.Add(new DataColumn("IBN", typeof(String)));
            dris_optimizacao_ibn.DataSource = dt;
            dris_optimizacao_ibn.Columns[0].Width = 118;

            dt.Rows.Add("");
            dt.Rows.Add("");

            dt.Rows[0][0] = inicial_ibn_amostra[amostra_ind];
            dt.Rows[1][0] = ibn_amostra[amostra_ind];

            //DRIS
            dt = new System.Data.DataTable();
            for (int i = 0; i < nutrientes_num; i++)
            {
                dt.Columns.Add(new DataColumn(nutrientes_lista[i], typeof(String)));
            }
            dt.Rows.Add("");
            dt.Rows.Add("");

            for (int i = 0; i < nutrientes_num; i++)
            {
                dt.Rows[0][i] = inicial_amostras_indices_dris[i][amostra_ind];
                dt.Rows[1][i] = amostras_indices_dris[i][amostra_ind];
            }
            dris_recomendacao.DataSource = dt;
            for (int i = 0; i < dris_recomendacao.Columns.Count; i++)
            {
                dris_recomendacao.Columns[i].Width = 650 / dris_recomendacao.Columns.Count;
            }

            //Dados Amostra
            dt = new System.Data.DataTable();
            for (int i = 0; i < nutrientes_num; i++)
            {
                dt.Columns.Add(new DataColumn(nutrientes_lista[i], typeof(String)));
            }

            dt.Rows.Add("");
            dt.Rows.Add("");

            for (int i = 0; i < nutrientes_num; i++)
            {
                dt.Rows[0][i] = inicial_amostra_data[amostra_ind][i];
                dt.Rows[1][i] = amostra_data[amostra_ind][i];
            }

            grid_dados_amostra.DataSource = dt;

            for (int i = 0; i < grid_dados_amostra.Columns.Count; i++)
            {
                grid_dados_amostra.Columns[i].Width = 650 / grid_dados_amostra.Columns.Count;
            }

            //Concentracao Adicionar Recomendacao
            dt = new System.Data.DataTable();
            for (int i = 0; i < nutrientes_num; i++)
            {
                dt.Columns.Add(new DataColumn(nutrientes_lista[i], typeof(String)));
            }
            dt.Rows.Add("");
            for (int i = 0; i < nutrientes_num; i++)
            {
                dt.Rows[0][i] = Convert.ToDouble(amostra_data[amostra_ind][i]) - Convert.ToDouble(tmp_amostra_data[amostra_ind][i]);
            }
            dris_valores_adicionar.DataSource = dt;
            for (int i = 0; i < dris_valores_adicionar.Columns.Count; i++)
            {
                dris_valores_adicionar.Columns[i].Width = 650 / dris_valores_adicionar.Columns.Count;
            }
        }

        public string set_signal_string_double(string numero)
        {
            if (Convert.ToDouble(numero) > 0)
            {
                return "+";
            }
            else
            {
                return "-";
            }
        }

        public void calcula_melhor_dris(int indice_amostra, int indice_nutriente, string min, string max)
        {
            double currente = 0;
            double tmp = 0;
            double valor_usado = 50;
            string sinal_anterior = set_signal_string_double(amostras_indices_dris[indice_nutriente][indice_amostra]);
            double number;
            int force_break = 0;

            while (Convert.ToDouble(amostras_indices_dris[indice_nutriente][indice_amostra]) < -1.05 || Convert.ToDouble(amostras_indices_dris[indice_nutriente][indice_amostra]) > 1.05)
            {
                currente = Convert.ToDouble(amostras_indices_dris[indice_nutriente][indice_amostra]);

                if (currente < 0 && sinal_anterior == "-")
                {
                    tmp = valor_usado + (valor_usado / 2.0);

                    if (Double.TryParse(max, out number))
                    {
                        if (Convert.ToDouble(tmp_amostra_data[indice_amostra][indice_nutriente]) + tmp > Convert.ToDouble(max))
                        {
                            tmp = Convert.ToDouble(max) - Convert.ToDouble(tmp_amostra_data[indice_amostra][indice_nutriente]);
                            force_break++;
                        }
                    }

                    valor_usado = tmp;
                    tmp = Convert.ToDouble(tmp_amostra_data[indice_amostra][indice_nutriente]) + tmp;
                    amostra_data[indice_amostra][indice_nutriente] = tmp.ToString();
                    sinal_anterior = set_signal_string_double(amostras_indices_dris[indice_nutriente][indice_amostra]);
                }
                else if (currente < 0 && sinal_anterior == "+")
                {
                    tmp = valor_usado + (valor_usado / 2.0);

                    if (Double.TryParse(max, out number))
                    {
                        if (Convert.ToDouble(tmp_amostra_data[indice_amostra][indice_nutriente]) + tmp > Convert.ToDouble(max))
                        {
                            tmp = Convert.ToDouble(max) - Convert.ToDouble(tmp_amostra_data[indice_amostra][indice_nutriente]);
                            force_break++;
                        }
                    }

                    valor_usado = tmp;
                    tmp = Convert.ToDouble(tmp_amostra_data[indice_amostra][indice_nutriente]) + tmp;
                    amostra_data[indice_amostra][indice_nutriente] = tmp.ToString();
                    sinal_anterior = set_signal_string_double(amostras_indices_dris[indice_nutriente][indice_amostra]);
                }
                else if (currente > 0 && sinal_anterior == "-")
                {
                    tmp = valor_usado - (valor_usado/2.0);

                    valor_usado = tmp;
                    tmp = Convert.ToDouble(tmp_amostra_data[indice_amostra][indice_nutriente]) + tmp;
                    amostra_data[indice_amostra][indice_nutriente] = tmp.ToString();
                    sinal_anterior = set_signal_string_double(amostras_indices_dris[indice_nutriente][indice_amostra]);
                }
                else if (currente > 0 && sinal_anterior == "+")
                {
                    tmp = valor_usado - (valor_usado / 2.0);

                    valor_usado = tmp;
                    tmp = Convert.ToDouble(tmp_amostra_data[indice_amostra][indice_nutriente]) + tmp;
                    amostra_data[indice_amostra][indice_nutriente] = tmp.ToString();
                    sinal_anterior = set_signal_string_double(amostras_indices_dris[indice_nutriente][indice_amostra]);
                }

                //volta a calcular
                calcula_metodo_beaufils();
                calcula_indices_dris_nutrientes();
                calcula_ibn_amostras();
                if (force_break > 1)
                {
                    break;
                }
            }
        }

        //verifica se existe algum valor dris entre certo intervalo
        public bool existe_nutriente_dris_mau(int amostra_ind, string dris_limit, DataGridView dg)
        {
            double number;

            Console.WriteLine(amostras_indices_dris[0][3]);
            Console.WriteLine(amostras_indices_dris[1][3]);
            Console.WriteLine(amostras_indices_dris[2][3]);
            Console.WriteLine(amostras_indices_dris[3][3]);
            Console.WriteLine(amostras_indices_dris[4][3]);
            Console.WriteLine(amostras_indices_dris[5][3]);
            Console.WriteLine(amostras_indices_dris[6][3]);
            Console.WriteLine(amostras_indices_dris[7][3]);
            Console.WriteLine(amostras_indices_dris[8][3]);
            Console.WriteLine(amostras_indices_dris[9][3]);
            Console.WriteLine("\n\n");

            for (int i = 0; i < amostras_indices_dris.Length; i++)
            {
                if ((Double.TryParse(dg.Rows[0].Cells[i].Value.ToString(), out number)))
                {
                    if ((Convert.ToDouble(amostra_data[amostra_ind][i]) < number))
                    {
                        if (Convert.ToDouble(amostras_indices_dris[i][amostra_ind]) < Convert.ToDouble(dris_limit))
                        {
                            return true;
                        }
                    }
                }
                else
                {
                    if (Convert.ToDouble(amostras_indices_dris[i][amostra_ind]) < Convert.ToDouble(dris_limit))
                    {
                        return true;
                    }
                }
            }

            return false;
        }

        //copia dados iniciais
        public void copy_inicial_data()
        {
            inicial_amostra_data = new string[amostra_data.Length][];
            for (int i = 0; i < amostra_data.Length; i++)
            {
                inicial_amostra_data[i] = new string[amostra_data[i].Length];

                for (int j = 0; j < amostra_data[i].Length; j++)
                {
                    inicial_amostra_data[i][j] = amostra_data[i][j];
                }
            }

            inicial_amostras_indices_dris = new string[amostras_indices_dris.Length][];
            for (int i = 0; i < amostras_indices_dris.Length; i++)
            {
                inicial_amostras_indices_dris[i] = new string[amostras_indices_dris[i].Length];

                for (int j = 0; j < amostras_indices_dris[i].Length; j++)
                {
                    inicial_amostras_indices_dris[i][j] = amostras_indices_dris[i][j];
                }
            }

            inicial_ibn_amostra = new string[ibn_amostra.Length];
            for (int i = 0; i < ibn_amostra.Length; i++)
            {
                inicial_ibn_amostra[i] = ibn_amostra[i];
            }
        }

        //grava ficheiro PDF
        public void save_result_pdf_analitico( string pdfFilename )
        {
            DateTime date_now = DateTime.Now;
            string tmp_path = System.Windows.Forms.Application.StartupPath;
            string tmp_pdf1 = @"" + tmp_path + "\\tmp01.xls";
            object paramMissing = Type.Missing;

            Microsoft.Office.Interop.Excel.Application MSExcel = new Microsoft.Office.Interop.Excel.Application();
            Microsoft.Office.Interop.Excel._Workbook XLBook;

            MSExcel.DisplayAlerts = false;
            try
            {
                XLBook = MSExcel.Workbooks.Open(tmp_pdf1, 0, true, 5, "", "", true, 2, "", false, false, false, false, 1, false);
            }
            catch
            {
                MSExcel.Quit();
                return;
            }

            XLBook.Activate();

            XlFixedFormatType paramExportFormat = XlFixedFormatType.xlTypePDF;
            XlFixedFormatQuality paramExportQuality = XlFixedFormatQuality.xlQualityStandard;
            bool paramOpenAfterPublish = false;
            bool paramIncludeDocProps = true;
            bool paramIgnorePrintAreas = true;
            object paramFromPage = Type.Missing;
            object paramToPage = Type.Missing;

            XLBook.ExportAsFixedFormat(paramExportFormat,
            @"" + pdfFilename + "\\boletim_analitico" + date_now.ToString("yyyyMMddHHmmss") + ".pdf", paramExportQuality,
            paramIncludeDocProps, paramIgnorePrintAreas, paramFromPage,
            paramToPage, paramOpenAfterPublish,
            paramMissing);

            XLBook.Close(false, paramMissing, paramMissing);
            XLBook = null;
        }

        public void save_result_pdf_apreciacao(string pdfFilename)
        {
            DateTime date_now = DateTime.Now;
            string tmp_path = System.Windows.Forms.Application.StartupPath;
            string tmp_pdf1 = @"" + tmp_path + "\\tmp02.xls";
            object paramMissing = Type.Missing;

            Microsoft.Office.Interop.Excel.Application MSExcel = new Microsoft.Office.Interop.Excel.Application();
            Microsoft.Office.Interop.Excel._Workbook XLBook;

            MSExcel.DisplayAlerts = false;
            try
            {
                XLBook = MSExcel.Workbooks.Open(tmp_pdf1, 0, true, 5, "", "", true, 2, "", false, false, false, false, 1, false);
            }
            catch
            {
                MSExcel.Quit();
                return;
            }

            XLBook.Activate();

            XlFixedFormatType paramExportFormat = XlFixedFormatType.xlTypePDF;
            XlFixedFormatQuality paramExportQuality = XlFixedFormatQuality.xlQualityStandard;
            bool paramOpenAfterPublish = false;
            bool paramIncludeDocProps = true;
            bool paramIgnorePrintAreas = true;
            object paramFromPage = Type.Missing;
            object paramToPage = Type.Missing;

            XLBook.ExportAsFixedFormat(paramExportFormat,
            @"" + pdfFilename + "\\boletim_apreciacao" + date_now.ToString("yyyyMMddHHmmss") + ".pdf", paramExportQuality,
            paramIncludeDocProps, paramIgnorePrintAreas, paramFromPage,
            paramToPage, paramOpenAfterPublish,
            paramMissing);

            XLBook.Close(false, paramMissing, paramMissing);
            XLBook = null;
        }

        //grava grafico no Excel
        public void save_result_excel_analitico(ZedGraphControl zd_control, ComboBox cbox, DataGridView di, System.Windows.Forms.TextBox tb_ibn_i, System.Windows.Forms.TextBox tb_ibn_mi, DataGridView dr, System.Windows.Forms.TextBox tb_ibn_r, System.Windows.Forms.TextBox tb_ibn_mr, string cliente_sel, string relatorio_id, string caminho_documentos, int type_save)
        {
            DateTime date_now = DateTime.Now;
            NPOI.SS.UserModel.IDrawing patriarch;
            HSSFClientAnchor anchor;
            string default_path = System.Windows.Forms.Application.StartupPath;
            string template_resultados_path = @"" + default_path + "\\templates\\analitico\\template_001.xls";

            FileStream file = new FileStream(template_resultados_path, FileMode.Open, FileAccess.ReadWrite);
            HSSFWorkbook hssfworkbook = new HSSFWorkbook(file);
            file.Close();

            System.Data.DataTable d_tmp_cliente = new System.Data.DataTable();
            System.Data.DataTable d_tmp = new System.Data.DataTable();
            ISheet sheet;
            IRow dataRow;
            int selected_index = cbox.SelectedIndex;
            
            ICellStyle estilo_header = hssfworkbook.CreateCellStyle();
            ICellStyle estilo_body = hssfworkbook.CreateCellStyle();
            ICellStyle estilo_none = hssfworkbook.CreateCellStyle();
            NPOI.SS.UserModel.IFont fonte_header = hssfworkbook.CreateFont();
            NPOI.SS.UserModel.IFont fonte_body = hssfworkbook.CreateFont();
            NPOI.SS.Util.CellRangeAddress cellRange;

            estilo_header.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;
            estilo_header.BorderTop = NPOI.SS.UserModel.BorderStyle.Medium;
            estilo_header.BorderBottom = NPOI.SS.UserModel.BorderStyle.Medium;
            estilo_header.BorderLeft = NPOI.SS.UserModel.BorderStyle.Medium;
            estilo_header.BorderRight = NPOI.SS.UserModel.BorderStyle.Medium;
            
            fonte_header.Boldweight = (short)NPOI.SS.UserModel.FontBoldWeight.Bold;
            estilo_header.SetFont(fonte_header);

            estilo_none.BorderLeft = NPOI.SS.UserModel.BorderStyle.None;
            estilo_none.BorderRight = NPOI.SS.UserModel.BorderStyle.None;

            estilo_body.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;
            estilo_body.BorderBottom = NPOI.SS.UserModel.BorderStyle.Thin;
            estilo_body.BorderLeft = NPOI.SS.UserModel.BorderStyle.Thin;
            estilo_body.BorderRight = NPOI.SS.UserModel.BorderStyle.Thin;
            fonte_body.Boldweight = (short)NPOI.SS.UserModel.FontBoldWeight.Normal;
            estilo_body.SetFont(fonte_body);

            NPOI.SS.UserModel.IFont fonte_peqbold = hssfworkbook.CreateFont();
            fonte_peqbold.Boldweight = (short)NPOI.SS.UserModel.FontBoldWeight.Bold;
            fonte_peqbold.FontHeight = 180;

            NPOI.SS.UserModel.IFont fonte_bold = hssfworkbook.CreateFont();
            fonte_bold.Boldweight = (short)NPOI.SS.UserModel.FontBoldWeight.Bold;

            NPOI.SS.UserModel.IFont fonte_peq = hssfworkbook.CreateFont();
            fonte_peq.FontHeight = 180;

            string sql = "";
            //grava boletim analitico em excel
            DrisDB.Connect(caminho_base_dados);

            sql = "SELECT ";
            sql += "* ";
            sql += "FROM ";
            sql += "CLIENTE ";
            sql += "WHERE ";
            sql += "ID = '" + cliente_sel + "'";

            d_tmp_cliente = DrisDB.selectQuery(sql);

            string template_analitico_path = @"" + default_path + "\\templates\\analitico\\template_001.xls";

            file = new FileStream(template_analitico_path, FileMode.Open, FileAccess.ReadWrite);
            hssfworkbook = new HSSFWorkbook(file);
            file.Close();

            ICellStyle estilo_01 = hssfworkbook.CreateCellStyle();
            NPOI.SS.UserModel.IFont fonte_01 = hssfworkbook.CreateFont();
            int num_sheets = 1;

            //cabecalho dados
            System.Data.DataTable dados_tmps = new System.Data.DataTable();
            System.Data.DataTable boletins_numeros = new System.Data.DataTable();

            sql = "SELECT ";
            sql += "ids_requisicao ";
            sql += "FROM ";
            sql += "relatorio ";
            sql += "WHERE ";
            sql += "ID = '" + relatorio_id + "'";

            dados_tmps = DrisDB.selectQuery(sql);

            sql = "SELECT ";
            sql += "* ";
            sql += "FROM ";
            sql += "requisicao ";
            sql += "WHERE ";
            sql += "ID IN (" + dados_tmps.Rows[0][0].ToString() + ")";

            boletins_numeros = DrisDB.selectQuery(sql);

            int boletim_indice = 3;

            for (int k = 1; k <= amostras_num - 3; k++)
            {
                sheet = hssfworkbook.GetSheet( k.ToString() );

                estilo_01.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;

                estilo_01.BorderTop = NPOI.SS.UserModel.BorderStyle.Double;
                estilo_01.TopBorderColor = NPOI.HSSF.Util.HSSFColor.DarkBlue.Index;

                estilo_01.BorderBottom = NPOI.SS.UserModel.BorderStyle.Double;
                estilo_01.BottomBorderColor = NPOI.HSSF.Util.HSSFColor.DarkBlue.Index;

                estilo_01.BorderLeft = NPOI.SS.UserModel.BorderStyle.Double;
                estilo_01.LeftBorderColor = NPOI.HSSF.Util.HSSFColor.DarkBlue.Index;

                estilo_01.BorderRight = NPOI.SS.UserModel.BorderStyle.Double;
                estilo_01.RightBorderColor = NPOI.HSSF.Util.HSSFColor.DarkBlue.Index;

                fonte_01.Boldweight = (short)NPOI.SS.UserModel.FontBoldWeight.Bold;
                estilo_01.SetFont(fonte_01);

                NPOI.SS.UserModel.IFont fonte_02 = hssfworkbook.CreateFont();
                fonte_02.Boldweight = (short)NPOI.SS.UserModel.FontBoldWeight.Bold;
                fonte_02.FontHeight = 180;

                NPOI.SS.UserModel.IFont fonte_03 = hssfworkbook.CreateFont();
                fonte_03.FontHeight = 180;

                dataRow = sheet.CreateRow(8);
                dataRow.CreateCell(1).SetCellType(NPOI.SS.UserModel.CellType.String);

                cellRange = new NPOI.SS.Util.CellRangeAddress(8, 8, 1, 8);
                sheet.AddMergedRegion(cellRange);

                for (int i = 1; i < 9; i++)
                {
                    try
                    {
                        dataRow.GetCell(i).CellStyle = estilo_01;
                    }
                    catch
                    {
                        dataRow.CreateCell(i).CellStyle = estilo_01;
                    }
                }

                string texto = "Boletim N.º: " + boletins_numeros.Rows[boletim_indice][7];
                texto += "             ";
                texto += "Data da emissão: " + boletins_numeros.Rows[boletim_indice][8];
                texto += "             ";
                texto += "Página Nº 1 de 1";

                dataRow.GetCell(1).SetCellValue(texto);

                //1.
                texto = "Nome";
                texto += "                  ";
                texto += d_tmp_cliente.Rows[0][1].ToString();

                dataRow = sheet.CreateRow(12);
                dataRow.CreateCell(1).SetCellValue(texto);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(0, 5, fonte_02);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(5, texto.Length, fonte_03);

                texto = "Morada";
                texto += "               ";
                texto += d_tmp_cliente.Rows[0][2].ToString();

                dataRow = sheet.CreateRow(13);
                dataRow.CreateCell(1).SetCellValue(texto);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(0, 6, fonte_02);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(6, texto.Length, fonte_03);

                texto = "Cód. Postal";
                texto += "        ";
                texto += d_tmp_cliente.Rows[0][3].ToString();

                dataRow = sheet.CreateRow(14);
                dataRow.CreateCell(1).SetCellValue(texto);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(0, 11, fonte_02);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(11, texto.Length, fonte_03);

                texto = "Telefone";
                texto += "    ";
                texto += d_tmp_cliente.Rows[0][4].ToString();

                dataRow.CreateCell(6).SetCellValue(texto);
                dataRow.GetCell(6).RichStringCellValue.ApplyFont(0, 8, fonte_02);
                dataRow.GetCell(6).RichStringCellValue.ApplyFont(8, texto.Length, fonte_03);

                texto = "NIF";
                texto += "    ";
                texto += d_tmp_cliente.Rows[0][5].ToString();

                dataRow.CreateCell(8).SetCellValue(texto);
                dataRow.GetCell(8).RichStringCellValue.ApplyFont(0, 3, fonte_02);
                dataRow.GetCell(8).RichStringCellValue.ApplyFont(3, texto.Length, fonte_03);

                sql = "select ";
                sql += "A.REQUISITANTE, ";
                sql += "B.NOME, ";
                sql += "C.DATA_COLHEITA, ";
                sql += "C.DATA_RECEPCAO, ";
                sql += "C.M_VEGETAL, ";
                sql += "C.NOME, ";
                sql += "C.FREGUESIA, ";
                sql += "C.CONCELHO, ";
                sql += "D.NOME, ";
                sql += "C.REFERENCIA, ";
                sql += "A.PERIODO_ENSAIOS_I, ";
                sql += "A.PERIODO_ENSAIOS_F, ";
                sql += "C.PROPRIEDADE, ";
                sql += "A.ID_FUNCIONARIO ";
                sql += "from ";
                sql += "relatorio A inner join cultura B on A.ID_CULTURA = B.ID ";
                sql += "inner join amostra C on A.ID_AMOSTRA = C.ID ";
                sql += "inner join requisicao D on A.ID_AMOSTRA = D.ID_AMOSTRA ";
                sql += "where ";
                sql += "A.id = '" + relatorio_id + "'";
                
                d_tmp = DrisDB.selectQuery(sql);

                texto = "Requisitante";
                texto += "      ";
                texto += d_tmp.Rows[0][0].ToString();

                dataRow = sheet.CreateRow(15);
                dataRow.CreateCell(1).SetCellValue(texto);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(0, 12, fonte_02);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(12, texto.Length, fonte_03);

                texto = "Período de Ensaios";
                texto += "    ";
                texto += d_tmp.Rows[0][10].ToString() + " a " + d_tmp.Rows[0][11].ToString();

                dataRow.CreateCell(6).SetCellValue(texto);
                dataRow.GetCell(6).RichStringCellValue.ApplyFont(0, 18, fonte_02);
                dataRow.GetCell(6).RichStringCellValue.ApplyFont(18, texto.Length, fonte_03);

                //2.
                texto = "Propriedade";
                texto += "    ";
                texto += d_tmp.Rows[0][12].ToString();

                dataRow = sheet.CreateRow(17);
                dataRow.CreateCell(1).SetCellValue(texto);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(0, 11, fonte_02);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(11, texto.Length, fonte_03);

                texto = "Cultura";
                texto += "    ";
                texto += d_tmp.Rows[0][1].ToString();

                dataRow.CreateCell(7).SetCellValue(texto);
                dataRow.GetCell(7).RichStringCellValue.ApplyFont(0, 7, fonte_02);
                dataRow.GetCell(7).RichStringCellValue.ApplyFont(7, texto.Length, fonte_03);

                texto = "Parcela";
                texto += "    ";
                texto += d_tmp.Rows[0][5].ToString();

                dataRow = sheet.CreateRow(18);
                dataRow.CreateCell(1).SetCellValue(texto);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(0, 7, fonte_02);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(7, texto.Length, fonte_03);

                texto = "Freguesia";
                texto += "    ";
                texto += d_tmp.Rows[0][6].ToString();

                dataRow.CreateCell(4).SetCellValue(texto);
                dataRow.GetCell(4).RichStringCellValue.ApplyFont(0, 9, fonte_02);
                dataRow.GetCell(4).RichStringCellValue.ApplyFont(9, texto.Length, fonte_03);

                texto = "Concelho";
                texto += "    ";
                texto += d_tmp.Rows[0][7].ToString();

                dataRow.CreateCell(7).SetCellValue(texto);
                dataRow.GetCell(7).RichStringCellValue.ApplyFont(0, 8, fonte_02);
                dataRow.GetCell(7).RichStringCellValue.ApplyFont(8, texto.Length, fonte_03);

                texto = "Amostra";
                texto += "    ";
                texto += d_tmp.Rows[0][9].ToString();

                dataRow = sheet.CreateRow(19);
                dataRow.CreateCell(1).SetCellValue(texto);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(0, 7, fonte_02);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(7, texto.Length, fonte_03);

                texto = "Data Colheita";
                texto += "    ";
                texto += d_tmp.Rows[0][2].ToString();

                dataRow.CreateCell(7).SetCellValue(texto);
                dataRow.GetCell(7).RichStringCellValue.ApplyFont(0, 13, fonte_02);
                dataRow.GetCell(7).RichStringCellValue.ApplyFont(13, texto.Length, fonte_03);

                texto = "Data de Recepção";
                texto += "    ";
                texto += d_tmp.Rows[0][3].ToString();

                dataRow = sheet.CreateRow(20);
                dataRow.CreateCell(1).SetCellValue(texto);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(0, 16, fonte_02);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(16, texto.Length, fonte_03);

                texto = "Requisição nº";
                texto += "    ";
                texto += date_now.ToString("yyyy").Substring(2, 2) + boletins_numeros.Rows[boletim_indice][2];

                dataRow.CreateCell(4).SetCellValue(texto);
                dataRow.GetCell(4).RichStringCellValue.ApplyFont(0, 13, fonte_02);
                dataRow.GetCell(4).RichStringCellValue.ApplyFont(13, texto.Length, fonte_03);

                texto = "Mat. Vegetal";
                texto += "    ";
                texto += d_tmp.Rows[0][4].ToString();

                dataRow.CreateCell(7).SetCellValue(texto);
                dataRow.GetCell(7).RichStringCellValue.ApplyFont(0, 12, fonte_02);
                dataRow.GetCell(7).RichStringCellValue.ApplyFont(12, texto.Length, fonte_03);

                ICellStyle estilo_05 = hssfworkbook.CreateCellStyle();
                estilo_05.SetFont(fonte_01);

                dataRow = sheet.CreateRow(49);
                dataRow.CreateCell(5).SetCellValue("       Porto, " + date_now.ToString("dd") + " de " + date_now.ToString("MMMM", CultureInfo.CreateSpecificCulture("pt-PT")) + " de " + date_now.ToString("yyyy"));
                dataRow.GetCell(5).CellStyle = estilo_05;

                //3.
                int pos;
                string[] nut_macro_up = nutrientes_lista.Select(s => s.ToUpperInvariant()).ToArray();

                //macronutrientes
                pos = Array.IndexOf(nut_macro_up, "N");
                dataRow = sheet.GetRow(26);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString());
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString());
                    double real_val = Convert.ToDouble(amostra_data[k+2][pos].ToString());
                    insert_grid_report(sheet, 26, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val / 10);
                    dataRow.GetCell(7).SetCellValue(min_val / 10);
                    dataRow.GetCell(8).SetCellValue(max_val / 10);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                pos = Array.IndexOf(nut_macro_up, "P");
                dataRow = sheet.GetRow(27);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString());
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString());
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString());
                    insert_grid_report(sheet, 27, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val / 10);
                    dataRow.GetCell(7).SetCellValue(min_val / 10);
                    dataRow.GetCell(8).SetCellValue(max_val / 10);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                pos = Array.IndexOf(nut_macro_up, "K");
                dataRow = sheet.GetRow(28);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString());
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString());
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString());
                    insert_grid_report(sheet, 28, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val / 10);
                    dataRow.GetCell(7).SetCellValue(min_val / 10);
                    dataRow.GetCell(8).SetCellValue(max_val / 10);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                pos = Array.IndexOf(nut_macro_up, "CA");
                dataRow = sheet.GetRow(29);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString());
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString());
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString());
                    insert_grid_report(sheet, 29, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val / 10);
                    dataRow.GetCell(7).SetCellValue(min_val / 10);
                    dataRow.GetCell(8).SetCellValue(max_val / 10);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                pos = Array.IndexOf(nut_macro_up, "MG");
                dataRow = sheet.GetRow(30);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString());
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString());
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString());
                    insert_grid_report(sheet, 30, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val / 10);
                    dataRow.GetCell(7).SetCellValue(min_val / 10);
                    dataRow.GetCell(8).SetCellValue(max_val / 10);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                //micronutrientes
                pos = Array.IndexOf(nut_macro_up, "CU");
                dataRow = sheet.GetRow(32);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString()) / 10;
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString()) / 10;
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString()) / 10;
                    insert_grid_report(sheet, 32, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val);
                    dataRow.GetCell(7).SetCellValue(min_val);
                    dataRow.GetCell(8).SetCellValue(max_val);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                pos = Array.IndexOf(nut_macro_up, "FE");
                dataRow = sheet.GetRow(33);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString()) / 10;
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString()) / 10;
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString()) / 10;
                    insert_grid_report(sheet, 33, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val);
                    dataRow.GetCell(7).SetCellValue(min_val);
                    dataRow.GetCell(8).SetCellValue(max_val);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                pos = Array.IndexOf(nut_macro_up, "MN");
                dataRow = sheet.GetRow(34);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString()) / 10;
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString()) / 10;
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString()) / 10;
                    insert_grid_report(sheet, 34, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val);
                    dataRow.GetCell(7).SetCellValue(min_val);
                    dataRow.GetCell(8).SetCellValue(max_val);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                pos = Array.IndexOf(nut_macro_up, "ZN");
                dataRow = sheet.GetRow(35);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString()) / 10;
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString()) / 10;
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString()) / 10;
                    insert_grid_report(sheet, 35, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val);
                    dataRow.GetCell(7).SetCellValue(min_val);
                    dataRow.GetCell(8).SetCellValue(max_val);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                pos = Array.IndexOf(nut_macro_up, "B");
                dataRow = sheet.GetRow(37);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString()) / 10;
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString()) / 10;
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString()) / 10;
                    insert_grid_report(sheet, 37, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val);
                    dataRow.GetCell(7).SetCellValue(min_val);
                    dataRow.GetCell(8).SetCellValue(max_val);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                pos = Array.IndexOf(nut_macro_up, "S");
                dataRow = sheet.GetRow(38);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString());
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString());
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString());
                    insert_grid_report(sheet, 38, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val);
                    dataRow.GetCell(7).SetCellValue(min_val);
                    dataRow.GetCell(8).SetCellValue(max_val);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue(0);
                    dataRow.GetCell(7).SetCellValue(0);
                    dataRow.GetCell(8).SetCellValue(0);
                }

                pos = Array.IndexOf(nut_macro_up, "NA");
                dataRow = sheet.GetRow(39);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString());
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString());
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString());
                    insert_grid_report(sheet, 39, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val / 10);
                    dataRow.GetCell(7).SetCellValue(min_val / 10);
                    dataRow.GetCell(8).SetCellValue(max_val / 10);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }

                pos = Array.IndexOf(nut_macro_up, "MO");
                dataRow = sheet.GetRow(40);
                if (pos > -1)
                {
                    double min_val = Convert.ToDouble(amostra_data[0][pos].ToString()) / 10;
                    double max_val = Convert.ToDouble(amostra_data[1][pos].ToString()) / 10;
                    double real_val = Convert.ToDouble(amostra_data[k + 2][pos].ToString()) / 10;
                    insert_grid_report(sheet, 40, real_val, min_val, max_val);

                    dataRow.GetCell(3).SetCellValue(real_val);
                    dataRow.GetCell(7).SetCellValue(min_val);
                    dataRow.GetCell(8).SetCellValue(max_val);
                }
                else
                {
                    dataRow.GetCell(3).SetCellValue("--");
                    dataRow.GetCell(7).SetCellValue("--");
                    dataRow.GetCell(8).SetCellValue("--");
                }


                //insere banner
                int index = 0;
                Bitmap b = new Bitmap(default_path + "\\banner.png");
                MemoryStream ms = new MemoryStream();
                b.Save(ms, System.Drawing.Imaging.ImageFormat.Png);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 1, 1, 9, 5);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                //insere titulo
                b = new Bitmap(default_path + "\\titulo2.png");
                ms = new MemoryStream();
                b.Save(ms, System.Drawing.Imaging.ImageFormat.Png);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 1, 5, 9, 7);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                //insere foliar
                b = new Bitmap(default_path + "\\analise_foliar.png");
                ms = new MemoryStream();
                b.Save(ms, System.Drawing.Imaging.ImageFormat.Png);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 7, 10, 9, 11);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                //insere barra cores
                b = new Bitmap(default_path + "\\grau.png");
                ms = new MemoryStream();
                b.Save(ms, System.Drawing.Imaging.ImageFormat.Png);

                for (int ini = 0; ini < 5; ini++)
                {
                    patriarch = sheet.CreateDrawingPatriarch();
                    anchor = new HSSFClientAnchor(0, 0, 0, 0, 5, 26+ini, 7, 27+ini);
                    anchor.AnchorType = 2;
                    index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                    patriarch.CreatePicture(anchor, index);
                }

                for (int ini = 0; ini < 4; ini++)
                {
                    patriarch = sheet.CreateDrawingPatriarch();
                    anchor = new HSSFClientAnchor(0, 0, 0, 0, 5, 32 + ini, 7, 33 + ini);
                    anchor.AnchorType = 2;
                    index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                    patriarch.CreatePicture(anchor, index);
                }

                for (int ini = 0; ini < 4; ini++)
                {
                    patriarch = sheet.CreateDrawingPatriarch();
                    anchor = new HSSFClientAnchor(0, 0, 0, 0, 5, 37 + ini, 7, 38 + ini);
                    anchor.AnchorType = 2;
                    index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                    patriarch.CreatePicture(anchor, index);
                }


                //insere assinatura
                System.Data.DataTable dt_assinatura = DrisDB.selectQuery("SELECT * FROM ImageStore WHERE image_id IN (SELECT assinatura_digital from funcionario where id = '" + d_tmp.Rows[0][13].ToString() + "')");

                byte[] imageBytes = (byte[])dt_assinatura.Rows[0][2];
                ms = new MemoryStream(imageBytes);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 4, 46, 9, 48);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                num_sheets++;
                boletim_indice++;
            }

            for (int k = num_sheets; k <= numero_paginas_template; k++)
            {
                hssfworkbook.RemoveSheetAt(hssfworkbook.GetSheetIndex(hssfworkbook.GetSheet(k.ToString())));
            }

            string tmp_path = "";
            if (type_save == 0)
            {
                tmp_path = caminho_documentos + "\\boletim_analitico" + date_now.ToString("yyyyMMddHHmmss") + ".xls";
            }
            else
            {
                tmp_path = caminho_documentos;
            }

            file = new FileStream(@"" + tmp_path, FileMode.Create, FileAccess.ReadWrite);
            hssfworkbook.Write(file);
            file.Close();
            Console.WriteLine("Ficheiro Excel Analitico Criado");
        }

        public Double[] calcula_valores_recomendacao(string qtt, string apl_max, string min, string max)
        {
            Double[] result = new Double[3];

            //rotulo
            if (Convert.ToInt32(min) == 0 && Convert.ToInt32(max) == 0)
            {
                result[0] = Convert.ToDouble(qtt);
                result[1] = 1;
                result[2] = 0;
                return result;
            }
            if (Convert.ToDouble(qtt) <= Convert.ToDouble(min))
            {
                result[0] = Convert.ToDouble(min);
                result[1] = 1;
                result[2] = 0;
                return result;
            }
            if (Convert.ToDouble(qtt) <= Convert.ToDouble(max))
            {
                result[0] = Convert.ToDouble(qtt);
                result[1] = 1;
                result[2] = 0;
                return result;
            }

            for (int i = 2; i < Convert.ToInt32(apl_max); i++)
            {
                if ((Convert.ToDouble(qtt) > (i-1) * (Convert.ToDouble(max))) && (Convert.ToDouble(qtt) <= i * (Convert.ToDouble(max))))
                {
                    result[0] = Convert.ToDouble(qtt) / i;
                    result[1] = i;
                    result[2] = 0;
                    return result;
                }
            }

            result[0] = Convert.ToDouble(max);
            result[1] = Convert.ToDouble(apl_max);
            result[2] = 0;
            return result;
        }

        public void save_result_excel_apreciacao(ZedGraphControl zd_control, ComboBox cbox, DataGridView di, System.Windows.Forms.TextBox tb_ibn_i, System.Windows.Forms.TextBox tb_ibn_mi, DataGridView dr, System.Windows.Forms.TextBox tb_ibn_r, System.Windows.Forms.TextBox tb_ibn_mr, string cliente_sel, string relatorio_id, string caminho_documentos, int type_save, string num_colunas)
        {
            DateTime date_now = DateTime.Now;
            NPOI.SS.UserModel.IDrawing patriarch;
            HSSFClientAnchor anchor;
            string default_path = System.Windows.Forms.Application.StartupPath;
            string template_resultados_path = @"" + default_path + "\\templates\\apreciacao\\" + template_a_usar + "_" + num_colunas + ".xls";

            FileStream file = new FileStream(template_resultados_path, FileMode.Open, FileAccess.ReadWrite);
            HSSFWorkbook hssfworkbook = new HSSFWorkbook(file);
            file.Close();

            ISheet sheet;
            IRow dataRow;
            IRow dataRow_bak;
            MemoryStream ms;
            System.Drawing.Image image;
            int selected_index = cbox.SelectedIndex;
            string texto_inserir = "";

            ICellStyle estilo_header = hssfworkbook.CreateCellStyle();
            ICellStyle estilo_body = hssfworkbook.CreateCellStyle();
            ICellStyle estilo_none = hssfworkbook.CreateCellStyle();
            ICellStyle estilo_top = hssfworkbook.CreateCellStyle();
            NPOI.SS.UserModel.IFont fonte_header = hssfworkbook.CreateFont();
            NPOI.SS.UserModel.IFont fonte_body = hssfworkbook.CreateFont();

            estilo_header.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;
            estilo_header.BorderTop = NPOI.SS.UserModel.BorderStyle.Medium;
            estilo_header.BorderBottom = NPOI.SS.UserModel.BorderStyle.Medium;
            estilo_header.BorderLeft = NPOI.SS.UserModel.BorderStyle.Medium;
            estilo_header.BorderRight = NPOI.SS.UserModel.BorderStyle.Medium;

            fonte_header.Boldweight = (short)NPOI.SS.UserModel.FontBoldWeight.Bold;
            estilo_header.SetFont(fonte_header);

            estilo_none.BorderLeft = NPOI.SS.UserModel.BorderStyle.None;
            estilo_none.BorderRight = NPOI.SS.UserModel.BorderStyle.None;

            estilo_top.BorderLeft = NPOI.SS.UserModel.BorderStyle.None;
            estilo_top.BorderRight = NPOI.SS.UserModel.BorderStyle.None;
            estilo_top.BorderTop = NPOI.SS.UserModel.BorderStyle.Medium;

            estilo_body.Alignment = NPOI.SS.UserModel.HorizontalAlignment.Center;
            estilo_body.BorderBottom = NPOI.SS.UserModel.BorderStyle.Thin;
            estilo_body.BorderLeft = NPOI.SS.UserModel.BorderStyle.Thin;
            estilo_body.BorderRight = NPOI.SS.UserModel.BorderStyle.Thin;
            fonte_body.Boldweight = (short)NPOI.SS.UserModel.FontBoldWeight.Normal;
            estilo_body.SetFont(fonte_body);

            NPOI.SS.UserModel.IFont fonte_peqbold = hssfworkbook.CreateFont();
            fonte_peqbold.Boldweight = (short)NPOI.SS.UserModel.FontBoldWeight.Bold;
            fonte_peqbold.FontHeight = 180;

            NPOI.SS.UserModel.IFont fonte_bold = hssfworkbook.CreateFont();
            fonte_bold.Boldweight = (short)NPOI.SS.UserModel.FontBoldWeight.Bold;

            NPOI.SS.UserModel.IFont fonte_peq = hssfworkbook.CreateFont();
            fonte_peq.FontHeight = 180;

            DrisDB.Connect(caminho_base_dados);
            System.Data.DataTable d_tmp_cliente = new System.Data.DataTable();
            System.Data.DataTable d_tmp = new System.Data.DataTable();

            //cliente
            string sql = "SELECT ";
            sql += "* ";
            sql += "FROM ";
            sql += "CLIENTE ";
            sql += "WHERE ";
            sql += "ID = '" + cliente_sel + "'";

            d_tmp_cliente = DrisDB.selectQuery(sql);

            //requisicoes
            System.Data.DataTable dados_tmps1 = new System.Data.DataTable();

            sql = "SELECT ";
            sql += "ids_requisicao ";
            sql += "FROM ";
            sql += "relatorio ";
            sql += "WHERE ";
            sql += "ID = '" + relatorio_id + "'";

            dados_tmps1 = DrisDB.selectQuery(sql);

            sql = "SELECT ";
            sql += "* ";
            sql += "FROM ";
            sql += "requisicao ";
            sql += "WHERE ";
            sql += "ID IN (" + dados_tmps1.Rows[0][0].ToString() + ")";

            System.Data.DataTable top_bar = DrisDB.selectQuery(sql);

            string[] requisicoes = dados_tmps1.Rows[0][0].ToString().Split(',');
            int num_sheets2 = 1;

            for (int ii = 3; ii < amostras_num; ii++)
            {
                
                sql = "select ";
                sql += "A.REQUISITANTE, ";
                sql += "B.NOME, ";
                sql += "C.DATA_COLHEITA, ";
                sql += "C.DATA_RECEPCAO, ";
                sql += "C.M_VEGETAL, ";
                sql += "C.NOME, ";
                sql += "C.FREGUESIA, ";
                sql += "C.CONCELHO, ";
                sql += "D.NOME, ";
                sql += "C.REFERENCIA, ";
                sql += "A.PERIODO_ENSAIOS_I, ";
                sql += "A.PERIODO_ENSAIOS_F, ";
                sql += "C.PROPRIEDADE, ";
                sql += "A.ID_FUNCIONARIO ";
                sql += "from ";
                sql += "relatorio A inner join cultura B on A.ID_CULTURA = B.ID ";
                sql += "inner join amostra C on A.ID_AMOSTRA = C.ID ";
                sql += "inner join requisicao D on A.ID_AMOSTRA = D.ID_AMOSTRA ";
                sql += "where ";
                sql += "A.id = '" + relatorio_id + "'";

                d_tmp = DrisDB.selectQuery(sql);

                sheet = hssfworkbook.GetSheet((ii - 2).ToString());
                cbox.SelectedIndex = ii;
                amostra_changer(di, tb_ibn_i, tb_ibn_mi, dr, tb_ibn_r, tb_ibn_mr, ii, zd_control);


                //barra topo
                string texto = "             Boletim N.º: " + top_bar.Rows[ii][7];
                texto += "             ";
                texto += "Data da emissão: " + top_bar.Rows[ii][8].ToString().Replace('-', '/');
                texto += "             ";
                texto += "Página Nº 1 de 1";

                dataRow = sheet.GetRow(8);
                dataRow.GetCell(1).SetCellValue(texto);


                texto_inserir = "Parcela";
                texto_inserir += "    ";
                texto_inserir += d_tmp.Rows[0][5].ToString();

                dataRow = sheet.CreateRow(12);
                dataRow.CreateCell(1).SetCellValue(texto_inserir);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(0, 7, fonte_peqbold);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(7, texto_inserir.Length, fonte_peq);

                texto_inserir = "Cultura";
                texto_inserir += "    ";
                texto_inserir += d_tmp.Rows[0][1].ToString();

                dataRow.CreateCell(10).SetCellValue(texto_inserir);
                dataRow.GetCell(10).RichStringCellValue.ApplyFont(0, 7, fonte_peqbold);
                dataRow.GetCell(10).RichStringCellValue.ApplyFont(7, texto_inserir.Length, fonte_peq);

                dataRow = sheet.CreateRow(13);

                texto_inserir = "Referência da Amostra";
                texto_inserir += "    ";
                texto_inserir += d_tmp.Rows[0][9].ToString();

                dataRow.CreateCell(1).SetCellValue(texto_inserir);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(0, 21, fonte_peqbold);
                dataRow.GetCell(1).RichStringCellValue.ApplyFont(21, texto_inserir.Length, fonte_peq);

                dados_tmps1 = new System.Data.DataTable();

                sql = "SELECT ";
                sql += "nome ";
                sql += "FROM ";
                sql += "requisicao ";
                sql += "WHERE ";
                sql += "ID = '" + requisicoes[ii].Trim() + "'";

                dados_tmps1 = DrisDB.selectQuery(sql);

                texto_inserir = "Requisição Nº";
                texto_inserir += "    ";
                texto_inserir += date_now.ToString("yyyy").Substring(2, 2) + dados_tmps1.Rows[0][0].ToString();

                dataRow.CreateCell(5).SetCellValue(texto_inserir);
                dataRow.GetCell(5).RichStringCellValue.ApplyFont(0, 13, fonte_peqbold);
                dataRow.GetCell(5).RichStringCellValue.ApplyFont(13, texto_inserir.Length, fonte_peq);

                texto_inserir = "Mat. Vegetal";
                texto_inserir += "    ";
                texto_inserir += d_tmp.Rows[0][4].ToString();

                dataRow.CreateCell(10).SetCellValue(texto_inserir);
                dataRow.GetCell(10).RichStringCellValue.ApplyFont(0, 12, fonte_peqbold);
                dataRow.GetCell(10).RichStringCellValue.ApplyFont(12, texto_inserir.Length, fonte_peq);

                //texto_inserir = "Freguesia";
                //texto_inserir += "    ";
                //texto_inserir += d_tmp.Rows[0][6].ToString();

                //dataRow.CreateCell(5).SetCellValue(texto_inserir);
                //dataRow.GetCell(5).RichStringCellValue.ApplyFont(0, 9, fonte_peqbold);
                //dataRow.GetCell(5).RichStringCellValue.ApplyFont(9, texto_inserir.Length, fonte_peq);

                //texto_inserir = "Concelho";
                //texto_inserir += "    ";
                //texto_inserir += d_tmp.Rows[0][7].ToString();

                //dataRow.CreateCell(8).SetCellValue(texto_inserir);
                //dataRow.GetCell(8).RichStringCellValue.ApplyFont(0, 8, fonte_peqbold);
                //dataRow.GetCell(8).RichStringCellValue.ApplyFont(8, texto_inserir.Length, fonte_peq);

                //dataRow = sheet.CreateRow(14);

                //valores DRIS
                for (int j = 0; j < nutrientes_num; j++)
                {
                    dataRow = sheet.GetRow(j + 17);

                    dataRow.GetCell(7).SetCellValue(nutrientes_lista[j]);
                    dataRow.GetCell(8).SetCellValue(Convert.ToDouble(inicial_amostras_indices_dris[j][ii]));
                }

                //limpa celulas a mais
                //for (int j = nutrientes_num; j < 11; j++)
                //{

                //    if (j == nutrientes_num)
                //    {
                //        dataRow = sheet.GetRow(j + 17);
                //        dataRow.GetCell(7).CellStyle = estilo_top;
                //        dataRow.GetCell(8).CellStyle = estilo_top;
                //        dataRow.GetCell(9).CellStyle = estilo_top;
                //        dataRow.GetCell(10).CellStyle = estilo_top;
                //    }
                //    else
                //    {
                //        dataRow = sheet.GetRow(j + 17);
                //        dataRow.GetCell(7).CellStyle = estilo_none;
                //        dataRow.GetCell(8).CellStyle = estilo_none;
                //        dataRow.GetCell(9).CellStyle = estilo_none;
                //        dataRow.GetCell(10).CellStyle = estilo_none;
                //    }
                //}

                //ibn
                dataRow = sheet.GetRow(19);
                dataRow.GetCell(12).SetCellValue(Convert.ToDouble(inicial_ibn_amostra[ii]));

                //ibn medio
                dataRow = sheet.GetRow(24);
                dataRow.GetCell(12).SetCellValue(Convert.ToDouble((Convert.ToDouble(inicial_ibn_amostra[ii]) / nutrientes_num)));

                //excel novo para calculos
                FileStream file_calculos = new FileStream(@"" + default_path + "\\templates\\calculos\\" + template_calculos + "_" + num_colunas + ".xls", FileMode.Open, FileAccess.ReadWrite);
                HSSFWorkbook hssfworkbook_calculos = new HSSFWorkbook(file_calculos);
                file_calculos.Close();

                ISheet sheet_calculos;
                IRow dataRow_calculos;
                sheet_calculos = hssfworkbook_calculos.GetSheet("Folha1");

                hssfworkbook_calculos.ForceFormulaRecalculation = true;
                string tmp_value_add = "";
                double tmp_valor = 0;

                //valores a adicionar
                for (int j = 0; j < nutrientes_num; j++)
                {
                    //calculos
                    dataRow_calculos = sheet_calculos.GetRow(9 + j);

                    if (sensibilidade_array[ii][j] == "")
                    {
                        tmp_valor = Convert.ToDouble(amostra_data[ii][j]) - Convert.ToDouble(inicial_amostra_data[ii][j]);
                        dataRow_calculos.GetCell(0).SetCellValue(tmp_valor);
                    }
                    else
                    {
                        tmp_valor = Convert.ToDouble(amostra_data[ii][j]) - Convert.ToDouble(sensibilidade_array[ii][j]);
                        dataRow_calculos.GetCell(0).SetCellValue(tmp_valor);
                    }
                }


                HSSFFormulaEvaluator.EvaluateAllFormulaCells(hssfworkbook_calculos);

                Double[] tmp_array = new Double[3];
                string data_min = "";
                string data_max = "";

                dataRow_calculos = sheet_calculos.GetRow(6);

                if (num_colunas == "4")
                {
                    string pre_val = dataRow_calculos.GetCell(12).NumericCellValue.ToString();
                    string div_val = dataRow_calculos.GetCell(13).NumericCellValue.ToString();
                    string cresc_val = dataRow_calculos.GetCell(14).NumericCellValue.ToString();
                    string poscol_val = dataRow_calculos.GetCell(15).NumericCellValue.ToString();

                    for (int j = 0; j < 12; j++)
                    {
                        //preencher
                        dataRow_calculos = sheet_calculos.GetRow(8 + j);
                        dataRow = sheet.GetRow(j + 35);
                        dataRow_bak = sheet.GetRow(j + 56);

                        if (dataRow_calculos.GetCell(12).CellType == CellType.Numeric || dataRow_calculos.GetCell(12).CellType == CellType.Formula)
                        {

                            tmp_value_add = dataRow_calculos.GetCell(12).NumericCellValue.ToString();
                            if (dataRow_calculos.GetCell(12).NumericCellValue != 0)
                            {
                                data_min = dataRow_calculos.GetCell(16).NumericCellValue.ToString();
                                data_max = dataRow_calculos.GetCell(17).NumericCellValue.ToString();
                                tmp_array = calcula_valores_recomendacao(tmp_value_add, pre_val, data_min, data_max);
                                dataRow.GetCell(5).SetCellValue(Math.Round(tmp_array[0], 0) + "*(" + tmp_array[1] + ")**");
                            }
                            else
                            {
                                dataRow.GetCell(5).SetCellValue("---");
                            }
                        }
                        else
                        {
                            tmp_value_add = dataRow_calculos.GetCell(12).StringCellValue;
                            dataRow.GetCell(5).SetCellValue("---");
                        }

                        if (dataRow_calculos.GetCell(13).CellType == CellType.Numeric || dataRow_calculos.GetCell(13).CellType == CellType.Formula)
                        {
                            tmp_value_add = dataRow_calculos.GetCell(13).NumericCellValue.ToString();
                            if (dataRow_calculos.GetCell(13).NumericCellValue != 0)
                            {
                                data_min = dataRow_calculos.GetCell(16).NumericCellValue.ToString();
                                data_max = dataRow_calculos.GetCell(17).NumericCellValue.ToString();
                                tmp_array = calcula_valores_recomendacao(tmp_value_add, div_val, data_min, data_max);
                                dataRow.GetCell(7).SetCellValue(Math.Round(tmp_array[0], 0) + "*(" + tmp_array[1] + ")**");
                            }
                            else
                            {
                                dataRow.GetCell(7).SetCellValue("---");
                            }
                        }
                        else
                        {
                            tmp_value_add = dataRow_calculos.GetCell(13).StringCellValue;
                            dataRow.GetCell(7).SetCellValue("---");
                        }

                        if (dataRow_calculos.GetCell(14).CellType == CellType.Numeric || dataRow_calculos.GetCell(14).CellType == CellType.Formula)
                        {
                            tmp_value_add = dataRow_calculos.GetCell(14).NumericCellValue.ToString();
                            if (dataRow_calculos.GetCell(14).NumericCellValue != 0)
                            {
                                data_min = dataRow_calculos.GetCell(16).NumericCellValue.ToString();
                                data_max = dataRow_calculos.GetCell(17).NumericCellValue.ToString();
                                tmp_array = calcula_valores_recomendacao(tmp_value_add, cresc_val, data_min, data_max);
                                dataRow.GetCell(10).SetCellValue(Math.Round(tmp_array[0], 0) + "*(" + tmp_array[1] + ")**");
                            }
                            else
                            {
                                dataRow.GetCell(10).SetCellValue("---");
                            }
                        }
                        else
                        {
                            tmp_value_add = dataRow_calculos.GetCell(14).StringCellValue;
                            dataRow.GetCell(10).SetCellValue("---");
                        }

                        if (dataRow_calculos.GetCell(15).CellType == CellType.Numeric || dataRow_calculos.GetCell(15).CellType == CellType.Formula)
                        {
                            tmp_value_add = dataRow_calculos.GetCell(15).NumericCellValue.ToString();
                            if (dataRow_calculos.GetCell(15).NumericCellValue != 0)
                            {
                                data_min = dataRow_calculos.GetCell(16).NumericCellValue.ToString();
                                data_max = dataRow_calculos.GetCell(17).NumericCellValue.ToString();
                                tmp_array = calcula_valores_recomendacao(tmp_value_add, poscol_val, data_min, data_max);
                                dataRow.GetCell(13).SetCellValue(Math.Round(tmp_array[0], 0) + "*(" + tmp_array[1] + ")**");
                            }
                            else
                            {
                                dataRow.GetCell(13).SetCellValue("---");
                            }
                        }
                        else
                        {
                            tmp_value_add = dataRow_calculos.GetCell(15).StringCellValue;
                            dataRow.GetCell(13).SetCellValue("---");
                        }

                        dataRow_bak.GetCell(13).SetCellValue(Math.Round(Convert.ToDouble(dataRow_calculos.GetCell(10).NumericCellValue.ToString()), 2).ToString());
                    }
                }
                else
                {
                    string pre_val = dataRow_calculos.GetCell(12).NumericCellValue.ToString();
                    string div_val = dataRow_calculos.GetCell(13).NumericCellValue.ToString();
                    string end_val = dataRow_calculos.GetCell(14).NumericCellValue.ToString();
                    string cresc_val = dataRow_calculos.GetCell(15).NumericCellValue.ToString();
                    string poscol_val = dataRow_calculos.GetCell(16).NumericCellValue.ToString();

                    for (int j = 0; j < 12; j++)
                    {
                        //preencher
                        dataRow_calculos = sheet_calculos.GetRow(8 + j);
                        dataRow = sheet.GetRow(j + 35);
                        dataRow_bak = sheet.GetRow(j + 56);

                        if (dataRow_calculos.GetCell(12).CellType == CellType.Numeric || dataRow_calculos.GetCell(12).CellType == CellType.Formula)
                        {

                            tmp_value_add = dataRow_calculos.GetCell(12).NumericCellValue.ToString();
                            if (dataRow_calculos.GetCell(12).NumericCellValue != 0)
                            {
                                data_min = dataRow_calculos.GetCell(17).NumericCellValue.ToString();
                                data_max = dataRow_calculos.GetCell(18).NumericCellValue.ToString();
                                tmp_array = calcula_valores_recomendacao(tmp_value_add, pre_val, data_min, data_max);
                                dataRow.GetCell(5).SetCellValue(Math.Round(tmp_array[0], 0) + "*(" + tmp_array[1] + ")**");
                            }
                            else
                            {
                                dataRow.GetCell(5).SetCellValue("---");
                            }
                        }
                        else
                        {
                            tmp_value_add = dataRow_calculos.GetCell(12).StringCellValue;
                            dataRow.GetCell(5).SetCellValue("---");
                        }

                        if (dataRow_calculos.GetCell(13).CellType == CellType.Numeric || dataRow_calculos.GetCell(13).CellType == CellType.Formula)
                        {
                            tmp_value_add = dataRow_calculos.GetCell(13).NumericCellValue.ToString();
                            if (dataRow_calculos.GetCell(13).NumericCellValue != 0)
                            {
                                data_min = dataRow_calculos.GetCell(17).NumericCellValue.ToString();
                                data_max = dataRow_calculos.GetCell(18).NumericCellValue.ToString();
                                tmp_array = calcula_valores_recomendacao(tmp_value_add, div_val, data_min, data_max);
                                dataRow.GetCell(7).SetCellValue(Math.Round(tmp_array[0], 0) + "*(" + tmp_array[1] + ")**");
                            }
                            else
                            {
                                dataRow.GetCell(7).SetCellValue("---");
                            }
                        }
                        else
                        {
                            tmp_value_add = dataRow_calculos.GetCell(13).StringCellValue;
                            dataRow.GetCell(7).SetCellValue("---");
                        }

                        if (dataRow_calculos.GetCell(14).CellType == CellType.Numeric || dataRow_calculos.GetCell(14).CellType == CellType.Formula)
                        {
                            tmp_value_add = dataRow_calculos.GetCell(14).NumericCellValue.ToString();
                            if (dataRow_calculos.GetCell(14).NumericCellValue != 0)
                            {
                                data_min = dataRow_calculos.GetCell(17).NumericCellValue.ToString();
                                data_max = dataRow_calculos.GetCell(18).NumericCellValue.ToString();
                                tmp_array = calcula_valores_recomendacao(tmp_value_add, cresc_val, data_min, data_max);
                                dataRow.GetCell(8).SetCellValue(Math.Round(tmp_array[0], 0) + "*(" + tmp_array[1] + ")**");
                            }
                            else
                            {
                                dataRow.GetCell(8).SetCellValue("---");
                            }
                        }
                        else
                        {
                            tmp_value_add = dataRow_calculos.GetCell(14).StringCellValue;
                            dataRow.GetCell(8).SetCellValue("---");
                        }

                        if (dataRow_calculos.GetCell(15).CellType == CellType.Numeric || dataRow_calculos.GetCell(15).CellType == CellType.Formula)
                        {
                            tmp_value_add = dataRow_calculos.GetCell(15).NumericCellValue.ToString();
                            if (dataRow_calculos.GetCell(15).NumericCellValue != 0)
                            {
                                data_min = dataRow_calculos.GetCell(17).NumericCellValue.ToString();
                                data_max = dataRow_calculos.GetCell(18).NumericCellValue.ToString();
                                tmp_array = calcula_valores_recomendacao(tmp_value_add, poscol_val, data_min, data_max);
                                dataRow.GetCell(11).SetCellValue(Math.Round(tmp_array[0], 0) + "*(" + tmp_array[1] + ")**");
                            }
                            else
                            {
                                dataRow.GetCell(11).SetCellValue("---");
                            }
                        }
                        else
                        {
                            tmp_value_add = dataRow_calculos.GetCell(15).StringCellValue;
                            dataRow.GetCell(11).SetCellValue("---");
                        }

                        if (dataRow_calculos.GetCell(16).CellType == CellType.Numeric || dataRow_calculos.GetCell(16).CellType == CellType.Formula)
                        {
                            tmp_value_add = dataRow_calculos.GetCell(16).NumericCellValue.ToString();
                            if (dataRow_calculos.GetCell(16).NumericCellValue != 0)
                            {
                                data_min = dataRow_calculos.GetCell(17).NumericCellValue.ToString();
                                data_max = dataRow_calculos.GetCell(18).NumericCellValue.ToString();
                                tmp_array = calcula_valores_recomendacao(tmp_value_add, poscol_val, data_min, data_max);
                                dataRow.GetCell(13).SetCellValue(Math.Round(tmp_array[0], 0) + "*(" + tmp_array[1] + ")**");
                            }
                            else
                            {
                                dataRow.GetCell(13).SetCellValue("---");
                            }
                        }
                        else
                        {
                            tmp_value_add = dataRow_calculos.GetCell(15).StringCellValue;
                            dataRow.GetCell(13).SetCellValue("---");
                        }

                        dataRow_bak.GetCell(13).SetCellValue(Math.Round(Convert.ToDouble(dataRow_calculos.GetCell(10).NumericCellValue.ToString()), 2).ToString());
                    }
                }

                //assinatura
                DateTime data_agora = DateTime.Now;
                dataRow = sheet.GetRow(51);
                texto_inserir = "Porto, " + data_agora.ToString("dd") + " de " + data_agora.ToString("MMMM", CultureInfo.CreateSpecificCulture("pt-PT")) + " de " + data_agora.ToString("yyyy");
                dataRow.CreateCell(9).SetCellValue(texto_inserir);
                dataRow.GetCell(9).RichStringCellValue.ApplyFont(0, texto_inserir.Length, fonte_bold);

                //insere grafico
                int index = 0;
                desenha_grafico_dris_inicial_inicial(zd_control, ii);
                image = zd_control.GetImage();
                ms = new MemoryStream();
                image.Save(ms, System.Drawing.Imaging.ImageFormat.Png);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 1, 16, 6, 28);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                //insere assinatura
                System.Data.DataTable dt_assinatura = DrisDB.selectQuery("SELECT * FROM ImageStore WHERE image_id IN (SELECT assinatura_digital from funcionario where id = '" + d_tmp.Rows[0][13].ToString() + "')");

                byte[] imageBytes = (byte[])dt_assinatura.Rows[0][2];
                ms = new MemoryStream(imageBytes);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 9, 48, 13, 50);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                //insere banner
                Bitmap b = new Bitmap(default_path + "\\banner.png");
                ms = new MemoryStream();
                b.Save(ms, System.Drawing.Imaging.ImageFormat.Png);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 1, 1, 13, 5);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                //insere titulo
                b = new Bitmap(default_path + "\\titulo.png");
                ms = new MemoryStream();
                b.Save(ms, System.Drawing.Imaging.ImageFormat.Png);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 1, 5, 13, 7);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                //insere legenda
                b = new Bitmap(default_path + "\\legenda.png");
                ms = new MemoryStream();
                b.Save(ms, System.Drawing.Imaging.ImageFormat.Png);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 1, 15, 6, 17);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                //insere barra
                b = new Bitmap(default_path + "\\barra.png");
                ms = new MemoryStream();
                b.Save(ms, System.Drawing.Imaging.ImageFormat.Png);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 1, 28, 6, 30);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                //insere analise foliar
                b = new Bitmap(default_path + "\\analise_foliar.png");
                ms = new MemoryStream();
                b.Save(ms, System.Drawing.Imaging.ImageFormat.Png);

                patriarch = sheet.CreateDrawingPatriarch();
                anchor = new HSSFClientAnchor(0, 0, 0, 0, 9, 10, 13, 11);
                anchor.AnchorType = 2;
                index = hssfworkbook.AddPicture(ms.ToArray(), PictureType.PNG);
                patriarch.CreatePicture(anchor, index);

                num_sheets2++;
            }

            //limpa folhas a mais
            for (int k = num_sheets2; k <= numero_paginas_template; k++)
            {
                hssfworkbook.RemoveSheetAt(hssfworkbook.GetSheetIndex(hssfworkbook.GetSheet(k.ToString())));
            }

            //grava ficheiro
            if (type_save == 0)
            {
                file = new FileStream(@"" + caminho_documentos + "\\boletim_apreciacao" + date_now.ToString("yyyyMMddHHmmss") + ".xls", FileMode.Create, FileAccess.ReadWrite);
            }
            else
            {
                file = new FileStream(@"" + caminho_documentos, FileMode.Create, FileAccess.ReadWrite); ;
            }
            hssfworkbook.Write(file);
            file.Close();

            Console.WriteLine("Ficheiro Excel Apreciacao Criado");

            //poe como estava
            cbox.SelectedIndex = selected_index;
            amostra_changer(di, tb_ibn_i, tb_ibn_mi, dr, tb_ibn_r, tb_ibn_mr, selected_index, zd_control);
        }

        public void insert_grid_report(ISheet sheet, int line, double real, double min, double max)
        {
            double factor = 0.2;
            IRow dataRow;
            dataRow = sheet.GetRow(line);

            double c_min = min * factor;
            double c_max = max + (max * factor);
            double c_med = (max + min)/2;
            double c_med1 = (min + c_med) / 2;
            double c_med2 = (c_med + max) / 2;

            if (real > max && real <= c_max)
            {
                dataRow.GetCell(5).SetCellValue("                    E");
            }
            else if (real > c_max && real <= 2*c_max)
            {
                dataRow.GetCell(5).SetCellValue("                         E");
            }
            else if (real > 2*c_max && real <= 3*c_max)
            {
                dataRow.GetCell(5).SetCellValue("                              E");
            }
            else if (real > 3*c_max && real <= 4*c_max)
            {
                dataRow.GetCell(5).SetCellValue("                                   E");
            }
            else if (real > 4*c_max)
            {
                dataRow.GetCell(5).SetCellValue("                                        E");
            }
            else if (min - c_min <= real && real < min)
            {
                dataRow.GetCell(5).SetCellValue("I                    ");
            }
            else if (min - 2*c_min <= real && real < min - c_min)
            {
                dataRow.GetCell(5).SetCellValue("I                         ");
            }
            else if (min - 3 * c_min <= real && real < min - 2 * c_min)
            {
                dataRow.GetCell(5).SetCellValue("I                              ");
            }
            else if (min - 4 * c_min <= real && real < min - 3 * c_min)
            {
                dataRow.GetCell(5).SetCellValue("I                                   ");
            }
            else if (real < min - 4 * c_min)
            {
                dataRow.GetCell(5).SetCellValue("I                                        ");
            }
            else if (min <= real && real <= c_med1 )
            {
                dataRow.GetCell(5).SetCellValue("S           ");
            }
            else if (c_med1 < real && real <= c_med2)
            {
                dataRow.GetCell(5).SetCellValue("S");
            }
            else if (c_med2 < real && real <= max)
            {
                dataRow.GetCell(5).SetCellValue("           S");
            }


            
        }

        //ao mudar amostra na combobox
        public void amostra_changer(DataGridView di, System.Windows.Forms.TextBox tb_ibn_i, System.Windows.Forms.TextBox tb_ibn_mi, DataGridView dr, System.Windows.Forms.TextBox tb_ibn_r, System.Windows.Forms.TextBox tb_ibn_mr, int sel_index, ZedGraphControl zd1)
        {
            //inicial
            preencher_dris_inicial(di, sel_index, 0);
            preencher_ibn_amostra(tb_ibn_i, tb_ibn_mi, sel_index, 0);

            //recomendacao
            preencher_dris_inicial(dr, sel_index, 1);
            desenha_grafico_dris_inicial(zd1, sel_index);
            preencher_ibn_amostra(tb_ibn_r, tb_ibn_mr, sel_index, 1);
        }

        public void desenha_grafico_dris_inicial_inicial(ZedGraphControl zedGraphControl1, int indice_amostra)
        {

            zedGraphControl1.MasterPane.PaneList.Clear();

            zedGraphControl1.GraphPane = new GraphPane();
            GraphPane myPane = zedGraphControl1.GraphPane;

            myPane.Title.Text = "DRIS";
            myPane.YAxis.Title.Text = "Nutrientes";
            myPane.XAxis.Title.Text = "Índice";
            double tmp_value;

            double[] red_values = new double[nutrientes_num];
            double[] yellow_values = new double[nutrientes_num];
            double[] green_values = new double[nutrientes_num];
            double tmp_max = 0;

            for (int i = 0; i < amostras_indices_dris.Length; i++)
            {
                tmp_value = Convert.ToDouble(inicial_amostras_indices_dris[i][indice_amostra]);

                if (Math.Abs(tmp_value) > tmp_max)
                {
                    tmp_max = Math.Abs(tmp_value);
                }

                //critical, critical, i want to get physical
                if (tmp_value < -30 || tmp_value > 30)
                {
                    red_values[nutrientes_num - i - 1] = tmp_value;
                    yellow_values[nutrientes_num - i - 1] = 0;
                    green_values[nutrientes_num - i - 1] = 0;
                }
                //ligeiro
                if ((tmp_value >= -30 && tmp_value < -15) || (tmp_value > 15 && tmp_value <= 30))
                {
                    yellow_values[nutrientes_num - i - 1] = tmp_value;
                    green_values[nutrientes_num - i - 1] = 0;
                    red_values[nutrientes_num - i - 1] = 0;
                }
                //greeny
                if ((tmp_value >= -15 && tmp_value <= 0) || (tmp_value >= 0 && tmp_value <= 15))
                {
                    green_values[nutrientes_num - i - 1] = tmp_value;
                    red_values[nutrientes_num - i - 1] = 0;
                    yellow_values[nutrientes_num - i - 1] = 0;
                }
            }

            BarItem myCurve = myPane.AddBar("", red_values, null, System.Drawing.Color.Red);
            myCurve.Bar.Fill = new ZedGraph.Fill(System.Drawing.Color.Red, System.Drawing.Color.White, System.Drawing.Color.Red, 90f);

            BarItem myCurve2 = myPane.AddBar("", yellow_values, null, System.Drawing.Color.Yellow);
            myCurve2.Bar.Fill = new ZedGraph.Fill(System.Drawing.Color.Yellow, System.Drawing.Color.White, System.Drawing.Color.Yellow, 90f);

            BarItem myCurve3 = myPane.AddBar("", green_values, null, System.Drawing.Color.Green);
            myCurve3.Bar.Fill = new ZedGraph.Fill(System.Drawing.Color.Green, System.Drawing.Color.White, System.Drawing.Color.Green, 90f);

            String[] nut_copy = (String[])nutrientes_lista.Clone();

            Array.Reverse(nut_copy);

            myPane.YAxis.Scale.TextLabels = nut_copy;

            myPane.YAxis.Type = ZedGraph.AxisType.Text;

            myPane.BarSettings.Type = BarType.Stack;
            myPane.BarSettings.Base = BarBase.Y;

            myPane.Chart.Fill = new ZedGraph.Fill(System.Drawing.Color.White,
                System.Drawing.Color.FromArgb(255, 255, 166), 45.0F);

            myPane.XAxis.Scale.Min = -Math.Round(tmp_max) - 5;
            myPane.XAxis.Scale.Max = Math.Round(tmp_max) + 5;

            zedGraphControl1.AxisChange();
            myPane.Rect = zedGraphControl1.MasterPane.Rect;
            zedGraphControl1.MasterPane.Add(myPane);
            zedGraphControl1.Refresh();
        }

        public string save_referencia_bd(string cultura)
        {
            //TOCHANGE - criar separação entre novo e velho
            DrisDB.Connect(caminho_base_dados);
            System.Data.DataTable d_tmp = new System.Data.DataTable();
            string id_new_referencia = "";
            string sql = "";
            string[] words = path_referencia.Split('\\');
            words = words[words.Length - 1].Split('.');

            sql = "INSERT INTO REFERENCIA(ID_CULTURA, NOME, NUM_NUTRIENTES) VALUES ";
            sql += "('"+ cultura +"', ";
            sql += "'" + words[0] + "', ";
            sql += "'" + nutrientes_num +"')";

            DrisDB.runQuery(sql);
            d_tmp = DrisDB.selectQuery("SELECT MAX(ID) FROM REFERENCIA");

            id_new_referencia = d_tmp.Rows[0][0].ToString();

            SQLiteCommand cmd;
            DrisDB.sqlite.Open();
            cmd = DrisDB.sqlite.CreateCommand();

            using (SQLiteTransaction mytransaction = DrisDB.sqlite.BeginTransaction())
            {
                for (int i = 0; i < referencias_num; i++)
                {
                    for (int j = 0; j < nutrientes_num; j++)
                    {
                        sql = "INSERT INTO REFERENCIA_DADOS(ID_REFERENCIA, NUTRIENTE, VALOR, UNIDADE, PRODUTIVIDADE) VALUES (@field_a, @field_b, @field_c, @field_d, @field_e)";
                        using (var command = new SQLiteCommand(sql, DrisDB.sqlite))
                        {
                            command.Prepare();
                            command.Parameters.AddWithValue("@field_a", id_new_referencia);
                            command.Parameters.AddWithValue("@field_b", nutrientes_lista[j]);
                            command.Parameters.AddWithValue("@field_c", referencia_data[i][j]);
                            command.Parameters.AddWithValue("@field_d", nutrientes_unidades[j]);
                            command.Parameters.AddWithValue("@field_e", referencia_data[i][nutrientes_num]);
                            command.ExecuteNonQuery();
                        }
                    }
                }
                mytransaction.Commit();
            }

            return id_new_referencia;
        }

        public string save_amostra_bd(string referencia, string data_c, string data_r, string mat_veg, string nome, string freguesia, string concelho, string imagem, string cliente, string cultura, string referencia_sel, string propriedade)
        {
            DrisDB.Connect(caminho_base_dados);
            System.Data.DataTable d_tmp = new System.Data.DataTable();
            List<string> id_req_tmp = new List<string>();
            string id_new_amostra = "";
            string id_new_amostradados = "";
            string sql = "";

            sql = "INSERT INTO AMOSTRA(REFERENCIA, DATA_COLHEITA, DATA_RECEPCAO, M_VEGETAL, NUM_NUTRIENTES, NOME, FREGUESIA, CONCELHO, ID_IMAGEM, ID_CLIENTE, ID_CULTURA, PROPRIEDADE) VALUES ";
            sql += "('" + referencia + "', ";
            sql += "'" + data_c + "', ";
            sql += "'" + data_r + "', ";
            sql += "'" + mat_veg + "', ";
            sql += "'" + nutrientes_num + "', ";
            sql += "'" + nome + "' ,";
            sql += "'" + freguesia + "', ";
            sql += "'" + concelho + "', ";
            sql += "'" + imagem + "', ";
            sql += "'" + cliente + "', ";
            sql += "'" + cultura + "', ";
            sql += "'" + propriedade + "')";

            DrisDB.runQuery(sql);
            d_tmp = DrisDB.selectQuery("SELECT MAX(ID) FROM AMOSTRA");

            id_new_amostra = d_tmp.Rows[0][0].ToString();

            SQLiteCommand cmd;
            SQLiteDataAdapter ad;
            DrisDB.sqlite.Open();
            cmd = DrisDB.sqlite.CreateCommand();

            using (SQLiteTransaction mytransaction = DrisDB.sqlite.BeginTransaction())
            {
                for (int k = 0; k < amostras_num; k++)
                {
                    //guardar amostra requisicao
                    sql = "INSERT INTO AMOSTRA_DADOS(ID_AMOSTRA, NOME) VALUES (@field_a, @field_b)";
                    using (var command = new SQLiteCommand(sql, DrisDB.sqlite))
                    {
                        command.Prepare();
                        command.Parameters.AddWithValue("@field_a", id_new_amostra);
                        command.Parameters.AddWithValue("@field_b", amostra_data_nomes[k]);
                        command.ExecuteNonQuery();
                    }

                    d_tmp = new System.Data.DataTable();
                    sql = "SELECT MAX(ID) FROM AMOSTRA_DADOS";
                    using (var command = new SQLiteCommand(sql, DrisDB.sqlite))
                    {
                        command.Prepare();
                        ad = new SQLiteDataAdapter(command);
                        ad.Fill(d_tmp);
                        id_new_amostradados = d_tmp.Rows[0][0].ToString();
                    }

                    //guardar dados amostra requisicao
                    for (int j = 0; j < nutrientes_num; j++)
                    {
                        sql = "INSERT INTO AMOSTRA_DADOS_REQ(NUTRIENTE, VALOR, UNIDADE, ID_AMOSTRA_DADOS) VALUES (@field_a, @field_b, @field_c, @field_d)";
                        using (var command = new SQLiteCommand(sql, DrisDB.sqlite))
                        {
                            command.Prepare();
                            command.Parameters.AddWithValue("@field_a", nutrientes_lista[j]);
                            command.Parameters.AddWithValue("@field_b", inicial_amostra_data[k][j]);
                            command.Parameters.AddWithValue("@field_c", nutrientes_unidades[j]);
                            command.Parameters.AddWithValue("@field_d", id_new_amostradados);
                            command.ExecuteNonQuery();
                        }
                    }
                }

                mytransaction.Commit();
            }

            return id_new_amostra;
        }

        public string save_relatorio_bd(string referencia, string data_c, string data_r, string mat_veg, string nome, string freguesia, string concelho, string imagem, string cliente, string cultura, string referencia_sel, string id_new_amostra, string requisitante, List<string> req_boletim_nums, string utilizador)
        {
            DrisDB.Connect(caminho_base_dados);

            System.Data.DataTable d_tmp = new System.Data.DataTable();
            List<string> id_req_tmp = new List<string>();
            string sql = "";
            string id_new_requisicao = "";
            string id_relatorio = "";

            SQLiteCommand cmd;
            SQLiteDataAdapter ad;
            DrisDB.sqlite.Open();
            cmd = DrisDB.sqlite.CreateCommand();

            using (SQLiteTransaction mytransaction = DrisDB.sqlite.BeginTransaction())
            {
                for (int k = 0; k < amostras_num; k++)
                {
                    //guardar requisicao
                    sql = "INSERT INTO REQUISICAO(ID_AMOSTRA, NOME, IBN, IBN_MEDIO, GRAFICO_IMAGEM, TEXTO_RECOMENDACAO, NUM_BOLETIM, DATA_EMISSAO) VALUES (@field_a, @field_b, @field_c, @field_d, @field_e, @field_f, @field_g, @field_h)";
                    using (var command = new SQLiteCommand(sql, DrisDB.sqlite))
                    {
                        command.Prepare();
                        command.Parameters.AddWithValue("@field_a", id_new_amostra);
                        command.Parameters.AddWithValue("@field_b", amostra_data_nomes[k]);
                        command.Parameters.AddWithValue("@field_c", ibn_amostra[k]);
                        command.Parameters.AddWithValue("@field_d", (Convert.ToDouble(ibn_amostra[k]) / nutrientes_num).ToString());
                        command.Parameters.AddWithValue("@field_e", "");
                        command.Parameters.AddWithValue("@field_f", "texto teste");
                        command.Parameters.AddWithValue("@field_g", req_boletim_nums[k]);
                        command.Parameters.AddWithValue("@field_h", DateTime.Now.ToString("dd-MM-yyyy"));
                        command.ExecuteNonQuery();
                    }

                    d_tmp = new System.Data.DataTable();
                    sql = "SELECT MAX(ID) FROM REQUISICAO";
                    using (var command = new SQLiteCommand(sql, DrisDB.sqlite))
                    {
                        command.Prepare();
                        ad = new SQLiteDataAdapter(command);
                        ad.Fill(d_tmp);
                        id_new_requisicao = d_tmp.Rows[0][0].ToString();
                        id_req_tmp.Add(id_new_requisicao);
                    }

                    //guardar dados da requisicao
                    for (int j = 0; j < nutrientes_num; j++)
                    {
                        sql = "INSERT INTO REQUISICAO_DADOS(ID_REQUISICAO, NUTRIENTE, VALOR_RECOMENDACAO, INDICE_DRIS, UNIDADE) VALUES (@field_a, @field_b, @field_c, @field_d, @field_e)";
                        using (var command = new SQLiteCommand(sql, DrisDB.sqlite))
                        {
                            command.Prepare();
                            command.Parameters.AddWithValue("@field_a", id_new_requisicao);
                            command.Parameters.AddWithValue("@field_b", nutrientes_lista[j]);
                            command.Parameters.AddWithValue("@field_c", amostra_data[k][j]);
                            command.Parameters.AddWithValue("@field_d", amostras_indices_dris[j][k]);
                            command.Parameters.AddWithValue("@field_e", nutrientes_unidades[j]);
                            command.ExecuteNonQuery();
                        }
                    }
                }

                sql = "INSERT INTO RELATORIO(ID_CLIENTE, ID_CULTURA, ID_AMOSTRA, ID_REFERENCIA, NUM_NUTRIENTES, ID_FUNCIONARIO, DATA_FECHO, REQUISITANTE, IDS_REQUISICAO, PERIODO_ENSAIOS_I, PERIODO_ENSAIOS_F) VALUES (@field_a, @field_b, @field_c, @field_d, @field_e, @field_f, @field_g, @field_h, @field_i, @field_j, @field_k)";
                using (var command = new SQLiteCommand(sql, DrisDB.sqlite))
                {
                    command.Prepare();
                    command.Parameters.AddWithValue("@field_a", cliente);
                    command.Parameters.AddWithValue("@field_b", cultura);
                    command.Parameters.AddWithValue("@field_c", id_new_amostra);
                    command.Parameters.AddWithValue("@field_d", referencia_sel);
                    command.Parameters.AddWithValue("@field_e", nutrientes_num);
                    command.Parameters.AddWithValue("@field_f", utilizador);
                    command.Parameters.AddWithValue("@field_g", DateTime.Now.ToString("dd-MM-yyyy"));
                    command.Parameters.AddWithValue("@field_h", requisitante);
                    command.Parameters.AddWithValue("@field_i", String.Join(", ", id_req_tmp.ToArray()));
                    command.Parameters.AddWithValue("@field_j", data_c);
                    command.Parameters.AddWithValue("@field_k", data_r);
                    command.ExecuteNonQuery();
                }

                mytransaction.Commit();
            }

            d_tmp = new System.Data.DataTable();
            sql = "SELECT MAX(ID) FROM RELATORIO";
            using (var command = new SQLiteCommand(sql, DrisDB.sqlite))
            {
                command.Prepare();
                ad = new SQLiteDataAdapter(command);
                ad.Fill(d_tmp);
                id_relatorio = d_tmp.Rows[0][0].ToString();
            }

            return id_relatorio;
        }

        public string get_boletim_num()
        {
            DrisDB.Connect(caminho_base_dados);
            System.Data.DataTable d_tmp = new System.Data.DataTable();
            DateTime saveNow = DateTime.Now;

            string sql = "SELECT COUNT(*) FROM BOLETIM_ID WHERE ANO = '" + saveNow.ToString("yyyy") + "'";
            d_tmp = DrisDB.selectQuery(sql);

            if (d_tmp.Rows[0][0].ToString() == "0")
            {
                sql = "INSERT INTO BOLETIM_ID(ANO, NUM) VALUES ('"+saveNow.ToString("yyyy")+"', '2')";
                DrisDB.runQuery(sql);

                return "1/" + saveNow.ToString("yyyy").Substring(2, 2);
            }
            else
            {
                sql = "SELECT * FROM BOLETIM_ID WHERE ANO = '" + saveNow.ToString("yyyy") + "'";
                d_tmp = DrisDB.selectQuery(sql);
                string id = d_tmp.Rows[0][1].ToString() + "/" + saveNow.ToString("yyyy").Substring(2, 2);

                sql = "UPDATE BOLETIM_ID SET NUM = '"+(Convert.ToInt32(d_tmp.Rows[0][1].ToString()) + 1).ToString()+"' WHERE ANO = '"+saveNow.ToString("yyyy")+"'";
                DrisDB.runQuery(sql);

                return id;
            }
        }
    }
}
