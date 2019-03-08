using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Collections;
using System.Drawing.Printing;

namespace NCPHCTasks
{
    public partial class Main : Form
    {
        string bostamp = "";
        string obrano = "";
        string nmdos = "";
        string ndos = "";
        string no = "";
        string dataobra = "";
        string estado = "";
        string estimado = "";
        int real = 0;
        string mecanico = "";
        int tempo_corrido = 0;

        public Main(String userno, String username)
        {
            InitializeComponent();
            label1.Text = username;
            preenche_reparacoes();
            this.Text = "Main - " + username;
            timer2.Enabled = true;
            timer2.Interval = 1000;
            label4.Text = DateTime.Now.Date.ToString().Substring(0, 10);
            label5.Text = DateTime.Now.TimeOfDay.ToString().Substring(0, 8);
            label6.Text = "";
            dataGridView1.Columns[0].Visible = false;
            dataGridView1.Columns[7].Width = 80;
            dataGridView1.Columns[8].Width = 400;
            dataGridView1.Columns[13].Visible = false;
            dataGridView1.Columns[6].Visible = false;
            dataGridView1.Columns[14].Visible = false;
            mecanico = userno;
        }

        public void preenche_reparacoes()
        {
            BaseDados bd = new BaseDados();
            String command = @"select 
		                        bostamp,
		                        obrano NumFolhaObra,
		                        u_repprio Prioridade,
		                        dataopen DataEntrada,
		                        u_rephe HoraEntrada,
		                        dataopen DataInicioRep,
		                        u_repprev DuracaoPrev,
		                        tabela1 Estado,
		                        nome Cliente,
                                nmdos,
                                ndos,
                                no,
                                dataobra,
                                u_repreal,
                                u_repmec
	                        from 
		                        bo 
	                        where 
		                        tabela1 in ('Em Espera', 'Em Reparação') 
                                and nmdos like 'Folha de Obra%'
                                and fechada = 0 
                                and u_repprio != ''
	                        order by 
		                        u_repprio,
		                        dataopen,
		                        u_rephe,
		                        u_repprev ";
            DataTable dt = new DataTable();
            dt = bd.GetData(command);

            dataGridView1.Rows.Clear();

            if (dt.Rows.Count > 0)
            {
                foreach (DataRow dtRow in dt.Rows)
                {
                    dataGridView1.Rows.Add(
                        dtRow[0].ToString(),
                        dtRow[1].ToString(),
                        dtRow[2].ToString(),
                        dtRow[3].ToString().Substring(0, 10),
                        dtRow[4].ToString(),
                        dtRow[5].ToString(),
                        dtRow[6].ToString(),
                        dtRow[7].ToString(),
                        dtRow[8].ToString(),
                        dtRow[9].ToString(),
                        dtRow[10].ToString(),
                        dtRow[11].ToString(),
                        dtRow[12].ToString().Substring(6, 4) + dtRow[12].ToString().Substring(3, 2) + dtRow[12].ToString().Substring(0, 2),
                        dtRow[13].ToString(),
                        dtRow[14].ToString()
                    );
                }
                foreach (DataGridViewColumn column in dataGridView1.Columns)
                {
                    column.SortMode = DataGridViewColumnSortMode.NotSortable;
                }
            }
        }

        private void timer2_Tick(object sender, EventArgs e)
        {
            label4.Text = DateTime.Now.Date.ToString().Substring(0, 10);
            label5.Text = DateTime.Now.TimeOfDay.ToString().Substring(0, 8);
        }

        //pausa rep
        private void pausa_rep()
        {
            BaseDados bd = new BaseDados();
            bd.Open();
            String command = "";

            command = "SELECT u_repult, u_repreal FROM BO WHERE bostamp = '" + bostamp + "'";
            DataTable dt = new DataTable();
            dt = bd.GetData(command);
            if (dt.Rows.Count > 0)
            {
                DateTime datet = Convert.ToDateTime(dt.Rows[0][0].ToString());
                if (datet.Year != 1900)
                {
                    DateTime saveNow = DateTime.Now;
                    TimeSpan deltaDate = saveNow - datet;

                    command = "UPDATE bo SET u_repreal = u_repreal + " + (int)deltaDate.TotalSeconds + ", u_repult = '" + saveNow.ToString("yyyy-MM-dd HH:mm:ss.000") + "' WHERE bostamp = '" + bostamp + "'";
                    bd.RunQueryWOC(command);
                    real = Convert.ToInt32(dt.Rows[0][1]) + (int)deltaDate.TotalSeconds;
                }
                else
                {
                    command = "UPDATE bo SET u_repreal = " + real + " WHERE bostamp = '" + bostamp + "'";
                    bd.RunQueryWOC(command);
                }

                if (radioButton1.Checked)
                {
                    estado = "Em Espera";
                    label9.Text = "Em Espera";
                    command = "UPDATE bo SET tabela1 = 'Em Espera', u_repmec = '" + mecanico + "' WHERE bostamp = '" + bostamp + "'";
                    bd.RunQueryWOC(command);
                }
                else if (radioButton3.Checked)
                {
                    estado = "Em Garantia";
                    label9.Text = "Em Garantia";
                    command = "UPDATE bo SET tabela1 = 'Em Garantia', u_repmec = '" + mecanico + "' WHERE bostamp = '" + bostamp + "'";
                    bd.RunQueryWOC(command);
                }
                else if (radioButton4.Checked)
                {
                    estado = "Falta Peças";
                    label9.Text = "Falta Peças";
                    command = "UPDATE bo SET tabela1 = 'Falta Peças', u_repmec = '" + mecanico + "' WHERE bostamp = '" + bostamp + "'";
                    bd.RunQueryWOC(command);
                }
                timer1.Enabled = false;
            }

            bd.Close();
            grava_contagem();
            tempo_corrido = 0;
        }

        //inicia rep
        private void inicia_rep()
        {
            BaseDados bd = new BaseDados();
            bd.Open();
            String command = "";

            DateTime saveNow = DateTime.Now;
            command = "UPDATE bo SET tabela1 = 'Em Reparação', u_repult = '" + saveNow.ToString("yyyy-MM-dd HH:mm:ss.000") + "', u_repmec = '" + mecanico + "' WHERE bostamp = '" + bostamp + "'";
            bd.RunQueryWOC(command);
            estado = "Em Reparação";
            label9.Text = "Em Reparação";
            timer1.Enabled = true;
            timer1.Interval = 1000;

            bd.Close();
        }

        private void grava_contagem()
        {
            BaseDados bd = new BaseDados();
            bd.Open();
            String command = "";

            DateTime saveNow = DateTime.Now;
            command = @"INSERT INTO 
                            u_reparacoes (repstamp, userno, bostamp, obrano, tempo, data) 
                        VALUES 
                        (
                            '" + gen_stamp() + @"', 
                            '" + mecanico + @"', 
                            '" + bostamp + @"',
                            " + obrano + @",
                            " + tempo_corrido + @",
                            '" + saveNow.ToString("yyyy-MM-dd HH:mm:ss.000") + @"'
                        )";
            bd.RunQueryWOC(command);
            bd.Close();
        }

        //muda estado
        private void muda_estado()
        {
            if (bostamp != "")
            {
                BaseDados bd = new BaseDados();
                bd.Open();
                String command = "";

                if (estado.ToUpper() == "EM REPARAÇÃO")
                {
                    if (radioButton1.Checked)
                    {
                        pausa_rep();
                    }
                    else if (radioButton2.Checked)
                    {
                        inicia_rep();
                    }
                    else if (radioButton3.Checked)
                    {
                        pausa_rep();
                    }
                    else if (radioButton4.Checked)
                    {
                        pausa_rep();
                    }
                }
                else if (estado.ToUpper() == "EM ESPERA")
                {
                    if (radioButton2.Checked)
                    {
                        inicia_rep();
                    }
                    else if (radioButton3.Checked)
                    {
                        DateTime saveNow = DateTime.Now;
                        command = "UPDATE bo SET tabela1 = 'Em Garantia', u_repmec = '" + mecanico + "' WHERE bostamp = '" + bostamp + "'";
                        bd.RunQueryWOC(command);
                        estado = "Em Garantia";
                        label9.Text = "Em Garantia";
                    }
                    else if (radioButton4.Checked)
                    {
                        DateTime saveNow = DateTime.Now;
                        command = "UPDATE bo SET tabela1 = 'Falta Peças', u_repmec = '" + mecanico + "' WHERE bostamp = '" + bostamp + "'";
                        bd.RunQueryWOC(command);
                        estado = "Falta Peças";
                        label9.Text = "Falta Peças";
                    }
                }
                //else if (estado.ToUpper() == "EM GARANTIA")
                //{
                //    if (radioButton1.Checked)
                //    {
                //        pausa_rep();
                //    }
                //    else if (radioButton2.Checked)
                //    {
                //        inicia_rep();
                //    }
                //}
                

                preenche_reparacoes();
                bd.Close();
            }
        }

        //pausar
        private void button2_Click(object sender, EventArgs e)
        {
            
        }

        private string gen_stamp()
        {
            BaseDados bd = new BaseDados();
            String command = @"select suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5) stamp";
            DataTable dt = new DataTable();
            dt = bd.GetData(command);
            return dt.Rows[0][0].ToString();
        }

        private void seleciona_radioestado()
        {
            int num = 0;

            if (estado == "Em Espera")
            {
                num = 1;
            }
            else if (estado == "Em Reparação")
            {
                num = 2;
            }
            else if (estado == "Em Garantia")
            {
                num = 3;
            }
            else if (estado == "Em Garantia")
            {
                num = 4;
            }

            radioButton1.Checked = false;
            radioButton2.Checked = false;
            radioButton3.Checked = false;
            radioButton4.Checked = false;

            if (num == 1) radioButton1.Checked = true;
            if (num == 2) radioButton2.Checked = true;
            if (num == 3) radioButton3.Checked = true;
            if (num == 4) radioButton4.Checked = true;
        }

        private void seleciona_fo()
        {
            label6.Text = obrano;
            label9.Text = estado;

            seleciona_radioestado();

            label8.Text = estimado;
            TimeSpan span = new TimeSpan(0, 0, real);
            label11.Text = (span.Hours.ToString("00") + ":" + span.Minutes.ToString("00") + ":" + span.Seconds.ToString("00"));
            

            BaseDados bd = new BaseDados();
            String command = @"select 
                                bistamp,
                                ref,
		                        design,
                                qtt,
                                lobs
	                        from 
		                        bi 
	                        where 
		                        bostamp = '" + bostamp + "'";
            DataTable dt = new DataTable();
            dt = bd.GetData(command);

            dataGridView2.Rows.Clear();

            if (dt.Rows.Count > 0)
            {
                foreach (DataRow dtRow in dt.Rows)
                {
                    dataGridView2.Rows.Add(
                        dtRow[0].ToString(),
                        dtRow[1].ToString(),
                        dtRow[2].ToString(),
                        dtRow[3].ToString(),
                        dtRow[4].ToString()
                    );
                }
                foreach (DataGridViewColumn column in dataGridView2.Columns)
                {
                    column.SortMode = DataGridViewColumnSortMode.NotSortable;
                }
            }

            muda_estado();
        }

        //proxima rep
        private void proxima_rep()
        {
            preenche_reparacoes();

            if (dataGridView1.Rows.Count > 0)
            {
                for (int i = 0; i < dataGridView1.Rows.Count; i++)
                {
                    if (dataGridView1.Rows[i].Cells[7].Value.ToString() == "Em Reparação" && dataGridView1.Rows[i].Cells[14].Value.ToString() == mecanico)
                    {
                        bostamp = dataGridView1.Rows[i].Cells[0].Value.ToString();
                        obrano = dataGridView1.Rows[i].Cells[1].Value.ToString();
                        nmdos = dataGridView1.Rows[i].Cells[9].Value.ToString();
                        ndos = dataGridView1.Rows[i].Cells[10].Value.ToString();
                        no = dataGridView1.Rows[i].Cells[11].Value.ToString();
                        dataobra = dataGridView1.Rows[i].Cells[12].Value.ToString();
                        estado = "Em Reparação";
                        TimeSpan span = new TimeSpan(0, Convert.ToInt32(dataGridView1.Rows[i].Cells[6].Value), 0);
                        estimado = (span.Hours.ToString("00") + ":" + span.Minutes.ToString("00") + ":" + span.Seconds.ToString("00"));
                        real = Convert.ToInt32(dataGridView1.Rows[i].Cells[13].Value);

                        seleciona_fo();
                        inicia_rep();
                        dataGridView1.ClearSelection();
                        dataGridView1.Rows[i].Selected = true;
                        break;
                    }
                    if (dataGridView1.Rows[i].Cells[7].Value.ToString() == "Em Espera")
                    {
                        bostamp = dataGridView1.Rows[i].Cells[0].Value.ToString();
                        obrano = dataGridView1.Rows[i].Cells[1].Value.ToString();
                        nmdos = dataGridView1.Rows[i].Cells[9].Value.ToString();
                        ndos = dataGridView1.Rows[i].Cells[10].Value.ToString();
                        no = dataGridView1.Rows[i].Cells[11].Value.ToString();
                        dataobra = dataGridView1.Rows[i].Cells[12].Value.ToString();
                        estado = "Em Reparação";
                        TimeSpan span = new TimeSpan(0, Convert.ToInt32(dataGridView1.Rows[i].Cells[6].Value), 0);
                        estimado = (span.Hours.ToString("00") + ":" + span.Minutes.ToString("00") + ":" + span.Seconds.ToString("00"));
                        real = Convert.ToInt32(dataGridView1.Rows[i].Cells[13].Value);

                        seleciona_fo();
                        inicia_rep();
                        dataGridView1.ClearSelection();
                        dataGridView1.Rows[i].Selected = true;
                        break;
                    }
                }
            }
            else
            {
                bostamp = "";
                obrano = "";
                nmdos = "";
                ndos = "";
                no = "";
                dataobra = "";
                estado = "";
                estimado = "";
                real = 0;
                dataGridView2.Rows.Clear();
                label6.Text = "";
                textBox1.Text = "";
                textBox2.Text = "";
                textBox3.Text = "";
                label11.Text = "";
                label8.Text = "";
                label9.Text = "";
                radioButton1.Checked = false;
                radioButton2.Checked = false;
                radioButton3.Checked = false;
                radioButton4.Checked = false;
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            proxima_rep();
        }

        private void dataGridView2_KeyDown(object sender, KeyEventArgs e)
        {
        }

        private void dataGridView2_MouseClick(object sender, MouseEventArgs e)
        {
        }

        private void dataGridView2_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
        }

        void myDataGrid_CellEnter(object sender, DataGridViewCellEventArgs e)
        {
        }

        private void dataGridView2_CellBeginEdit(object sender, DataGridViewCellCancelEventArgs e)
        {

        }

        private void dataGridView2_CellDoubleClick(object sender, DataGridViewCellEventArgs e)
        {
        }

        private void adiciona_linha(string referencia, string designacao, string qtt, string lobs)
        {
            dataGridView2.Rows.Add(gen_stamp(), referencia, designacao, qtt, lobs);
            dataGridView2.Rows.OfType<DataGridViewRow>().Last().Selected = true;
        }

        //nova linha
        private void button5_Click(object sender, EventArgs e)
        {
            if(bostamp != "") adiciona_linha("", "", "", "");
        }

        //botao x vermelho
        private void button4_Click(object sender, EventArgs e)
        {
            if (bostamp != "") mostra_linha();
        }

        //apagar linha
        private void button6_Click(object sender, EventArgs e)
        {
            if (bostamp != "")
            {
                if (dataGridView2.Rows.Count > 0)
                {
                    int rowindex = dataGridView2.SelectedCells[0].RowIndex;

                    if (dataGridView2.Rows[rowindex].Cells[4].Value.ToString() != "HISTORICO")
                    {
                        if (rowindex != 0)
                        {
                            dataGridView2.Rows[rowindex - 1].Selected = true;
                        }

                        dataGridView2.Rows.RemoveAt(rowindex);
                        textBox1.Text = "";
                        textBox2.Text = "";
                        textBox3.Text = "";
                    }
                }
            }
        }

        //editar linha
        private void button9_Click(object sender, EventArgs e)
        {
            if (bostamp != "")
            {
                int rowindex = dataGridView2.SelectedCells[0].RowIndex;
                if (dataGridView2.Rows[rowindex].Cells[4].Value.ToString() != "HISTORICO")
                {
                    dataGridView2.Rows[rowindex].Cells[1].Value = textBox1.Text;
                    dataGridView2.Rows[rowindex].Cells[2].Value = textBox2.Text;
                    dataGridView2.Rows[rowindex].Cells[3].Value = textBox3.Text;
                }
                else
                {
                    mostra_linha();
                }
            }
        }

        private void mostra_linha()
        {
            try
            {
                int rowindex = dataGridView2.SelectedCells[0].RowIndex;

                textBox1.Text = dataGridView2.Rows[rowindex].Cells[1].Value.ToString();
                textBox2.Text = dataGridView2.Rows[rowindex].Cells[2].Value.ToString();
                textBox3.Text = dataGridView2.Rows[rowindex].Cells[3].Value.ToString();
            }
            catch (Exception er) { }
        }

        private void dataGridView2_CellClick(object sender, DataGridViewCellEventArgs e)
        {
        }

        private void dataGridView2_SelectionChanged(object sender, EventArgs e)
        {
            mostra_linha();
        }

        //cancelar
        private void button8_Click(object sender, EventArgs e)
        {
            if (bostamp != "") seleciona_fo();
        }

        //campo quantidade
        private void textBox3_KeyPress(object sender, KeyPressEventArgs e)
        {
            // permite 0-9, backspace, and decimal
            if (((e.KeyChar < 48 || e.KeyChar > 57) && e.KeyChar != 8 && e.KeyChar != 44))
            {
                e.Handled = true;
                return;
            }

            // apenas 1 decimal
            if (e.KeyChar == 44)
            {
                if ((sender as TextBox).Text.IndexOf(e.KeyChar) != -1)
                    e.Handled = true;
            }
        }

        //campo referencia
        private void textBox1_DoubleClick(object sender, EventArgs e)
        {
            if (bostamp != "")
            {
                EscolherArtigo childForm = new EscolherArtigo();
                DialogResult dr = childForm.ShowDialog(this);

                if (childForm.rfr != "")
                {
                    textBox1.Text = childForm.rfr;
                    textBox2.Text = childForm.des;
                    textBox3.Text = "0,0";
                }
            }
        }

        private bool save_fo()
        {
            int ordem = 10000;
            BaseDados bd = new BaseDados();
            String command = "BEGIN TRAN T1;";
            bd.Open();
            bd.RunQueryWOC(command);
            ArrayList bistamps = new ArrayList();
            String tmp_string = "";
            DataTable dt = new DataTable();
            string epv1 = "";
            string ivaincl = "";
            string iva = "";

            try
            {
                foreach (DataGridViewRow row in dataGridView2.Rows) 
                {
                    bistamps.Add(row.Cells[0].Value.ToString());

                    command = "SELECT COUNT(*) FROM bi where bistamp = '" + row.Cells[0].Value.ToString() + "'";
                    dt = bd.GetData(command);
                    int rtotal = Convert.ToInt32(dt.Rows[0][0].ToString());

                    if (rtotal > 0)
                    {
                        command = @"
                            UPDATE 
                                bi 
                            SET 
                                ref = '" + row.Cells[1].Value.ToString() + @"',
                                design = '" + row.Cells[2].Value.ToString() + @"',
                                qtt = " + row.Cells[3].Value.ToString().Replace(',', '.') + @",
                                lordem = " + ordem + @",
                                lobs = '" + row.Cells[4].Value.ToString() + @"',
                                ettdeb = " + row.Cells[3].Value.ToString().Replace(',', '.') + @"*(epu*(1-(desconto/100)))
                            WHERE 
                                bistamp = '" + row.Cells[0].Value.ToString() + @"';";
                    }
                    else
                    {
                        command = "SELECT ISNULL(epv1,0), ISNULL(iva1incl,0) FROM st where ref = '" + row.Cells[1].Value.ToString() + "'";
                        dt = bd.GetData(command);
                        if (dt.Rows.Count > 0)
                        {
                            epv1 = dt.Rows[0][0].ToString().Replace(',', '.');
                            if (dt.Rows[0][1].ToString().ToUpper() == "TRUE")
                            {
                                ivaincl = "1";
                            }
                            else
                            {
                                ivaincl = "0";
                            }
                        }
                        else
                        {
                            epv1 = "0";
                            ivaincl = "0";
                        }

                        command = "select taxa from taxasiva where codigo = 2";
                        dt = bd.GetData(command);
                        if (dt.Rows.Count > 0)
                        {
                            iva = dt.Rows[0][0].ToString().Replace(',', '.');
                        }
                        else
                        {
                            iva = "0";
                        }

                        command = @"INSERT INTO 
                                    bi 
                                (bistamp, ref, design, qtt, nmdos, obrano, iva, tabiva, bostamp, ndos, no, dataobra, lordem, armazem, lobs, epu, edebito, eprorc, ettdeb, ivaincl) 
                                VALUES 
                                (
                                    '" + row.Cells[0].Value.ToString() + @"', 
                                    '" + row.Cells[1].Value.ToString() + @"',
                                    '" + row.Cells[2].Value.ToString() + @"',
                                    " + row.Cells[3].Value.ToString().Replace(',', '.') + @",
                                    '" + nmdos + @"',
                                    " + obrano + @",
                                    " + iva.ToString().Replace(',', '.') + @",
                                    " + "2" + @",
                                    '" + bostamp + @"',
                                    " + ndos + @",
                                    " + no + @",
                                    '" + dataobra + @"',
                                    " + ordem + @",
                                    1,
                                    '" + row.Cells[4].Value.ToString() + @"',
                                    "+epv1+@",
                                    " + epv1 + @",
                                    " + epv1 + @",
                                    " + row.Cells[3].Value.ToString().Replace(',', '.') + "*" + epv1 + @",
                                    " + ivaincl + @"
                                )";
                    }
                    ordem += 10000;
                    tmp_string += command + "\n";
                    Console.WriteLine(command);
                    if (!bd.RunQueryWOC(command))
                    {
                        throw new Exception();
                    }
                }

                String bistamps_str = "";
                foreach (String tmp in bistamps)
                {
                    bistamps_str += "'" + tmp + "', ";
                }
                bistamps_str = bistamps_str.Substring(0, bistamps_str.Length - 2);
                Console.WriteLine(bistamps_str);

                command = "DELETE FROM bi where bostamp = '" + bostamp + "' and bistamp not in (" + bistamps_str +") and lobs != 'HISTORICO'";
                if (!bd.RunQueryWOC(command))
                {
                    throw new Exception();
                }

                command = "COMMIT TRAN T1;";
                if (!bd.RunQueryWOC(command))
                {
                    throw new Exception();
                }

                bd.Close();
                return true;
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex);
                command = "ROLLBACK TRAN T1;";
                bd.RunQueryWOC(command);
                bd.Close();
                System.IO.StreamWriter file = new System.IO.StreamWriter(Application.StartupPath + "\\debugncphctask.txt");
                file.WriteLine(ex.ToString());
                file.WriteLine("------------");
                file.WriteLine(tmp_string);
                file.Close();
                return false;
            }
        }

        //gravar
        private void button7_Click(object sender, EventArgs e)
        {
            if (bostamp != "")
            {
                if (save_fo())
                {
                    MessageBox.Show("Gravado com sucesso", "Gravar", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    seleciona_fo();
                }
                else
                {
                    MessageBox.Show("Falhou ao gravar", "Gravar", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            tempo_corrido += 1;
            real += 1;
            TimeSpan span = new TimeSpan(0, 0, real);

            label11.Text = (span.Hours.ToString("00") + ":" + span.Minutes.ToString("00") + ":" + span.Seconds.ToString("00"));
        }

        private void radioButton1_Click(object sender, EventArgs e)
        {
            if (bostamp != "") muda_estado();
        }

        private void radioButton2_Click(object sender, EventArgs e)
        {
            if (bostamp != "") muda_estado();
        }

        private void radioButton3_Click(object sender, EventArgs e)
        {
            if (bostamp != "")
            {
                var mg = MessageBox.Show("Tem a certeza que deseja colocar a Folha de Obra nº " + obrano + " em garantia?\n A reparação deixará de estar disponivel!", "Em Garantia", MessageBoxButtons.YesNo, MessageBoxIcon.Information);
                if (mg == DialogResult.Yes)
                {
                    DateTime dtnow = DateTime.Now;
                    adiciona_linha("", "Garantia em " + dtnow.ToString("yyyy-MM-dd HH:mm") + " - " + label1.Text, "1,0", "HISTORICO");
                    save_fo();
                    muda_estado();
                    proxima_rep();
                }
                else
                {
                    if (label9.Text == "Em Reparação")
                    {
                        seleciona_radioestado();
                    }
                }
            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            if (bostamp != "")
            {
                var mg = MessageBox.Show("Tem a certeza que deseja terminar a Folha de Obra nº " + obrano + "?\n A reparação deixará de estar disponivel!", "Terminar", MessageBoxButtons.YesNo, MessageBoxIcon.Information);
                if (mg == DialogResult.Yes)
                {
                    if (bostamp != "")
                    {
                        BaseDados bd = new BaseDados();
                        bd.Open();
                        pausa_rep();

                        DataTable dt = new DataTable();
                        dt = bd.GetData("select u_repreal from bo where bostamp = '" + bostamp + "'");
                        Double tdecimal = (Convert.ToInt32(dt.Rows[0][0].ToString()) / 60.0) / 60.0;

                        adiciona_linha("MO", "Mão de obra", tdecimal.ToString(), "");

                        DateTime saveNow = DateTime.Now;
                        DateTime dtnow = DateTime.Now;
                        
                        adiciona_linha("", "Pronto em " + dtnow.ToString("yyyy-MM-dd HH:mm") + " - " + label1.Text, "1,0", "HISTORICO");
                        save_fo();
                        String command = "UPDATE bo SET tabela1 = 'Pronto' WHERE bostamp = '" + bostamp + "'";
                        bd.RunQueryWOC(command);
                        estado = "";
                        label9.Text = "";
                        bd.Close();
                        imprime_talao();
                        proxima_rep();
                    }
                }
            }
        }

        private void imprime_talao()
        {
            PrintDocument pdoc = null;
            PrintDialog pd = new PrintDialog();
            pdoc = new PrintDocument();
            PrinterSettings ps = new PrinterSettings();
            Font font = new Font("Courier New", 7);

            //PaperSize psize = new PaperSize( PaperKind.Standard9x11.ToString(), 100, 200 );
            pd.Document = pdoc;
            //pd.Document.DefaultPageSettings.PaperSize = psize;
            //pdoc.DefaultPageSettings.PaperSize.Height = 820;
            //pdoc.DefaultPageSettings.PaperSize.Width = 520;
            //pdoc.PrinterSettings.PrinterName = "PDF24 PDF";

            pdoc.PrintPage += new PrintPageEventHandler(pdoc_PrintPage);

            pdoc.PrintPage += new PrintPageEventHandler(pdoc_PrintPage);

            DialogResult result = pd.ShowDialog();
            if (result == DialogResult.OK)
            {
                PrintPreviewDialog pp = new PrintPreviewDialog();
                pp.Document = pdoc;
                pdoc.Print();
            }
        }

        String getstring(String variable, int length)
        {
            if (variable.Length == length)
            {
                return variable + '\t';
            }
            else if (variable.Length > length)
            {
                return variable.Substring(0, length) + '\t';
            }
            else
            {
                int numdelta = length - variable.Length;
                string tabs = new String('a', numdelta);
                return variable + tabs + '\t';
            }
        }

        String getmonetary(String variable, int length, int decimals, String last)
        {
            double valor = Math.Round(Convert.ToDouble(variable), decimals);
            if( valor == 0 )
            {
                return "\t" + last;
            }
            else
            {
                variable = valor.ToString();

                if (variable.Length == length)
                {
                    return variable + '\t' + last;
                }
                else if (variable.Length > length)
                {
                    return variable.Substring(0, length) + '\t' + last;
                }
                else
                {
                    int numdelta = length - variable.Length;
                    string tabs = new String(' ', numdelta) + new String(' ', numdelta);
                    return variable + tabs + '\t' + last;
                }
            }
        }

        void pdoc_PrintPage(object sender, PrintPageEventArgs e)
        {
            BaseDados bd = new BaseDados();
            bd.Open();

            String print_NMDOS = "";
            String print_OBRANO = "";
            String print_DATAOBRA = "";
            String print_DATAFECHO = "";
            String print_NOME = "";
            String print_NO = "";
            String print_MORADA = "";
            String print_CODPOST = "";
            String print_CLTLMVL = "";
            String print_U_FPRODUTO = "";
            String print_U_FMARCA = "";
            String print_U_FMODELO = "";
            String print_U_TOTAL = "";

            String command = @"select 
                                BO.NMDOS,
                                BO.OBRANO,
                                BO.DATAOBRA,
                                BO.DATAFECHO,
                                BO.NOME,
                                BO.NO,
                                BO.MORADA,
                                BO.CODPOST,
                                CL.TLMVL,
                                U_FPRODUTO,
                                U_FMARCA,
                                U_FMODELO,
                                BO.U_TOTAL
                            FROM
                                BO inner join CL on BO.NO = CL.NO
                            WHERE
                                BOSTAMP = '" + bostamp + @"'
		                        ";
            DataTable dt = new DataTable();
            dt = bd.GetData(command);

            dataGridView1.Rows.Clear();

            if (dt.Rows.Count > 0)
            {
                print_NMDOS = dt.Rows[0][0].ToString();
                print_OBRANO = dt.Rows[0][1].ToString();
                print_DATAOBRA = dt.Rows[0][2].ToString();
                print_DATAFECHO = dt.Rows[0][3].ToString();
                print_NOME = dt.Rows[0][4].ToString();
                print_NO = dt.Rows[0][5].ToString();
                print_MORADA = dt.Rows[0][6].ToString();
                print_CODPOST = dt.Rows[0][7].ToString();
                print_CLTLMVL = dt.Rows[0][8].ToString();
                print_U_FPRODUTO = dt.Rows[0][9].ToString();
                print_U_FMARCA = dt.Rows[0][10].ToString();
                print_U_FMODELO = dt.Rows[0][11].ToString();
                print_U_TOTAL = dt.Rows[0][12].ToString();
            }

            Graphics graphics = e.Graphics;
            Font font = new Font("Courier New", 10);
            float fontHeight = font.GetHeight();
            int startX = 50;
            int startY = 55;
            int Offset = 40;
            graphics.DrawString(print_NMDOS + " PRONTA", new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString(print_NMDOS + "  " + print_OBRANO, new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString("Entrada: " + print_DATAOBRA + "  Saida: " + print_DATAFECHO + " ", new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString("Cliente: " + print_NOME + " n. " + print_NO, new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString(print_MORADA, new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString(print_CODPOST, new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString("TLM: " + print_CLTLMVL, new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString("------------------------------------------", new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString("N. Serie:  " + print_U_FPRODUTO, new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString("Marca:     " + print_U_FMARCA, new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString("Modelo:    " + print_U_FMODELO, new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);
            Offset = Offset + 20;
            graphics.DrawString("Total Euro.....................: " + print_U_TOTAL, new Font("Arial", 6), new SolidBrush(Color.Black), startX, startY + Offset);

            bd.Close();
        }

        private void Main_FormClosing(object sender, FormClosingEventArgs e)
        {
            var res = MessageBox.Show(this, "Deseja mesmo fechar o programa?", "Sair", MessageBoxButtons.YesNo, MessageBoxIcon.Warning, MessageBoxDefaultButton.Button2);
            if (res != DialogResult.Yes)
            {
                e.Cancel = true;
                return;
            }
            else
            {
                radioButton1.Checked = true;
                pausa_rep();
            }
        }

        private void radioButton4_Click(object sender, EventArgs e)
        {
            if (bostamp != "")
            {
                var mg = MessageBox.Show("Tem a certeza que deseja colocar a Folha de Obra nº " + obrano + " em falta de peças?\n A reparação deixará de estar disponivel!", "Falta Peças", MessageBoxButtons.YesNo, MessageBoxIcon.Information);
                if (mg == DialogResult.Yes)
                {
                    DateTime dtnow = DateTime.Now;
                    adiciona_linha("", "Peças em " + dtnow.ToString("yyyy-MM-dd HH:mm") + " - " + label1.Text, "1,0", "HISTORICO");
                    save_fo();
                    muda_estado();
                    proxima_rep();
                }
                else
                {
                    if (label9.Text == "Em Reparação")
                    {
                        seleciona_radioestado();
                    }
                }
            }
        }

        private void button2_Click_1(object sender, EventArgs e)
        {
            if (bostamp != "")
            {
                DadosCliente childForm = new DadosCliente(no);
                DialogResult dr = childForm.ShowDialog(this);
            }
        }
    }
}
