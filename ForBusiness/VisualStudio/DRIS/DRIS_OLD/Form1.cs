using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Reflection;
using System.Drawing.Drawing2D;
using ZedGraph;
using System.Data.SQLite;
using System.IO;
using EOR_DRIS;
using NPOI.HSSF.UserModel;
using NPOI.SS.UserModel;

namespace EOR_DRIS
{
    public partial class Form1 : Form
    {
        dris DrisMethod = new dris();
        BaseDados DrisDB = new BaseDados();
        DataTable dt_clientes;
        DataTable dt_culturas;
        DataTable dt_referencias;
        DataTable dt_amostras;
        ImageHelper imagemParcela = new ImageHelper();
        string cliente_seleccionado = "";
        string cultura_seleccionada = "";
        string referencia_seleccionada = "";
        string amostra_seleccionada = "";
        string relatorio_seleccionado = "";
        int trigger_cliente_new = 0;
        int projecto_gravado = 0;
        int id_imagem_amostra = 0;
        int fase_actual = 0;
        int relacoes_calculadas = 0;
        public string utilizador_seleccionado = "";
        public string caminho_base_dados = "";
        AlertForm alert;
        int validaPrograma = 0;

        public Form1()
        {
            License lic_form = new License();
            if (validaPrograma == 1)
            {
                if (lic_form.LicExist_bool())
                {
                    if (!lic_form.lic_is_valid())
                    {
                        string message = "Licença Inválida.";
                        message += Environment.NewLine;
                        message += "Contacte Novoscanais.";

                        MsgBox msg_box = new MsgBox("Erro Licença", message);
                        DialogResult dr = msg_box.ShowDialog(this);

                        Environment.Exit(0);
                    }
                }
                else
                {
                    string message = "Licença não existe.";
                    message += Environment.NewLine;
                    message += "Contacte Novoscanais.";

                    MsgBox msg_box = new MsgBox("Erro Licença", message);
                    DialogResult dr = msg_box.ShowDialog(this);

                    Environment.Exit(0);
                }
            }
            InitializeComponent();
            this.MinimumSize = new Size(863, 462);
            this.MaximumSize = new Size(863, 462);
            this.CenterToScreen();
            if ( validaPrograma == 1 )
                label_lic.Text = "Licenciado a " + lic_form.get_lic_user();
            else
                label_lic.Text = "Licenciado a EOR";
            //imagem de fundo
            this.BackgroundImage = Properties.Resources.bg;
            //inicializar paineis invisiveis
            goto_panel(1);
            //configuracao
            while( !checkIfConfExists() )
            {
                CriaConf msg_box = new CriaConf();
                DialogResult dr = msg_box.ShowDialog(this);
            }
            string path = Application.StartupPath;
            string curFile = @"" + path + "\\posto.cfg";

            System.IO.StreamReader ficheiro_conf = new System.IO.StreamReader(curFile);
            string linha_conf = ficheiro_conf.ReadLine();
            string[] words = linha_conf.Split('=');

            caminho_base_dados = words[1];

            linha_conf = ficheiro_conf.ReadLine();
            words = linha_conf.Split('=');

            utilizador_seleccionado = words[1];

            //base de dados
            if (!DrisDB.checkIfExistsDB(caminho_base_dados))
            {
                string message = "A base de dados não existe.";
                message += Environment.NewLine;
                message += "Contacte Novoscanais.";

                MsgBox msg_box = new MsgBox("Erro Base de Dados", message);
                DialogResult dr = msg_box.ShowDialog(this);

                Environment.Exit(0);
            }

            DrisDB.Connect(caminho_base_dados);
            preencher_clientes();
            preencher_culturas();
            fase_actual = 1;

            DrisMethod.caminho_base_dados = caminho_base_dados;
        }

        public bool checkIfConfExists()
        {
            string path = Application.StartupPath;
            string curFile = @"" + path + "\\posto.cfg";

            return File.Exists(curFile) ? true : false;
        }

        public void preencher_clientes()
        {
            dt_clientes = DrisDB.selectQuery("SELECT * FROM CLIENTE");
        }

        public void preencher_culturas()
        {
            painel_dados_cb_cultura.Items.Clear();
            dt_culturas = DrisDB.selectQuery("SELECT * FROM CULTURA");
            foreach (DataRow dtRow in dt_culturas.Rows)
            {
                painel_dados_cb_cultura.Items.Add(new ComboBoxItem(dtRow[1].ToString(), dtRow[0].ToString()));
            }
        }

        //botao proximo na fase1
        private void button2_Click(object sender, EventArgs e)
        {
            //tabControl1.SelectedIndex = 1;
        }
        //botao proximo na fase2
        private void button3_Click(object sender, EventArgs e)
        {
            //tabControl1.SelectedIndex = 2;
        }
        //botao proximo na fase3
        private void button4_Click(object sender, EventArgs e)
        {
            //tabControl1.SelectedIndex = 3;
        }
        //botao fase3_beaufils
        private void button8_Click(object sender, EventArgs e)
        {
            unselect_all_model();
            select_model(1);
        }
        //botao fase3_jones
        private void button9_Click(object sender, EventArgs e)
        {
            unselect_all_model();
            select_model(2);
        }
        //botao fase3_elwaligascho
        private void button10_Click(object sender, EventArgs e)
        {
            unselect_all_model();
            select_model(3);
        }

        private void unselect_all_model()
        {
            bot_modelo_beaufils.BackColor = default(Color);
            bot_modelo_jones.BackColor = default(Color);
            bot_modelo_elwaligascho.BackColor = default(Color);
        }

        private void select_model(int model)
        {
            unselect_all_model();
            if(model == 1) {
                bot_modelo_beaufils.BackColor = Color.FromArgb(34, 255, 0);
            }
            else if (model == 2) {
                bot_modelo_jones.BackColor = Color.FromArgb(34, 255, 0);
            }
            else if (model == 3) {
                bot_modelo_elwaligascho.BackColor = Color.FromArgb(34, 255, 0);
            }
        }
        
        //aba1
        private void button11_Click(object sender, EventArgs e)
        {
            if (check_fase_change(1))
            {
                goto_panel(1);
            }
        }
        //aba2
        private void button12_Click(object sender, EventArgs e)
        {
            if (check_fase_change(2))
            {
                if (verifica_dados_cliente_correctos())
                {
                    if (trigger_cliente_new == 1)
                    {
                        if (painel_entidade_tb_morada.Text.Trim() == "" || painel_entidade_tb_codpostal.Text.Trim() == "" || painel_entidade_tb_telefone.Text.Trim() == "")
                        {
                            DialogResult res = MessageBox.Show("Existem campos por preencher!\nDeseja avançar mesmo assim?", "Dados Incorrectos", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
                            if (res.ToString() == "OK")
                            {
                                goto_panel(2);
                            }
                        }
                        else
                        {
                            goto_panel(2);
                        }
                    }
                    else
                    {
                        goto_panel(2);
                    }
                }
            }
        }

        public bool verifica_dados_ref_amostra()
        {
            if (cultura_seleccionada.Trim() == "")
            {
                MessageBox.Show("Tem de seleccionar uma cultura!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return false;
            }
            if (dados_rb_ref1.Checked)
            {
                if (dados_texto_importar_referencia.Text.Trim() == "")
                {
                    MessageBox.Show("Tem de seleccionar uma referência!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }
            }

            if (dados_rb_ref2.Checked)
            {
                if (referencia_seleccionada.Trim() == "")
                {
                    MessageBox.Show("Tem de seleccionar uma referência!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }
            }

            if (dados_rb_am1.Checked)
            {
                if (dados_texto_importar_amostra.Text.Trim() == "")
                {
                    MessageBox.Show("Tem de seleccionar uma amostra!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }

                if ( textBox1.Text.Trim() == "")
                {
                    MessageBox.Show("Tem de escrever uma referência para a nova amostra!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }

                if (textBox2.Text.Trim() == "")
                {
                    MessageBox.Show("Tem de escrever um nome para a nova amostra!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }

                if (textBox5.Text.Trim() == "")
                {
                    MessageBox.Show("Tem de escrever a matéria vegetal para a nova amostra!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }

                if (textBox7.Text.Trim() == "")
                {
                    MessageBox.Show("Tem de escrever a propriedade para a nova amostra!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }

                if (textBox4.Text.Trim() == "")
                {
                    MessageBox.Show("Tem de escrever a freguesia da parcela da nova amostra!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }

                if (textBox3.Text.Trim() == "")
                {
                    MessageBox.Show("Tem de escrever o concelho da parcela da nova amostra!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }

                if (id_imagem_amostra == 0)
                {
                    DialogResult dr = MessageBox.Show("Não importou nenhuma imagem para a parcela!\nDeseja continuar mesmo assim?", "Dados Incorrectos", MessageBoxButtons.OKCancel, MessageBoxIcon.Error);
                    if (dr.ToString() != "OK")
                    {
                        return false;
                    }
                }
                
            }
            
            if (dados_rb_am2.Checked)
            {
                
                if (amostra_seleccionada.Trim() == "")
                {
                    MessageBox.Show("Tem de seleccionar uma amostra!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }
            }
            
            return true;
        }

        //aba3
        private void button13_Click(object sender, EventArgs e)
        {
            if (check_fase_change(3))
            {
                if (verifica_dados_ref_amostra())
                {
                    goto_panel(3);
                }
            }
        }

        //aba4
        private void button14_Click(object sender, EventArgs e)
        {
            if (check_fase_change(4))
            {
                goto_panel(4);
            }
        }

        private void hide_all_panel()
        {
            painel_entidade.Visible = false;
            painel_dados.Visible = false;
            painel_modelo.Visible = false;
            painel_nutrientes.Visible = false;
            painel_resultado.Visible = false;
        }

        private void goto_panel(int num)
        {
            hide_all_panel();
            if (num == 1)
            {
                painel_entidade.Visible = true;
                greenify_panel_but(1);
                fase_actual = 1;
            }
            if (num == 2)
            {
                painel_dados.Visible = true;
                greenify_panel_but(2);
                fase_actual = 2;
            }
            if (num == 3)
            {
                painel_modelo.Visible = true;
                greenify_panel_but(3);

                int ref_t = 0;
                int am_t = 0;

                //referencia - 0 ficheiro / else - bd
                if (dados_rb_ref1.Checked)
                {
                    ref_t = 0;
                }
                else
                {
                    ref_t = Convert.ToInt32(referencia_seleccionada);
                }
                //amostra - 0 ficheiro / else - bd
                if (dados_rb_am1.Checked)
                {
                    am_t = 0;
                }
                else
                {
                    am_t = Convert.ToInt32(amostra_seleccionada);
                }


                DrisMethod.initialize_projecto("Proj00001", dados_texto_importar_referencia.Text, dados_texto_importar_amostra.Text, ref_t, am_t);
                fase_actual = 3;
            }
            if (num == 4)
            {
                painel_nutrientes.Visible = true;
                greenify_panel_but(4);
                DrisMethod.nutrients_selector(datagrid_nutrient_selector);
                fase_actual = 4;
            }
            if (num == 5)
            {
                amostra_combobox.DropDownStyle = ComboBoxStyle.DropDownList;
                painel_resultado.Visible = true;
                greenify_panel_but(5);
                //draw_graph();
                fase_actual = 5;
            }
        }

        private void greenify_panel_but(int num)
        {
            if (num == 1)
            {
                bot_painel_entidade.BackColor = Color.FromArgb(34, 255, 0);
            }
            if (num == 2)
            {
                bot_painel_dados.BackColor = Color.FromArgb(34, 255, 0);
            }
            if (num == 3)
            {
                bot_painel_modelo.BackColor = Color.FromArgb(34, 255, 0);
            }
            if (num == 4)
            {
                bot_painel_nutrientes.BackColor = Color.FromArgb(34, 255, 0);
            }
            if (num == 5)
            {
                bot_painel_resultado.BackColor = Color.FromArgb(34, 255, 0);
            }
        }

        private void ungreenify_panel_but()
        {
            bot_painel_entidade.BackColor = SystemColors.Control;
            bot_painel_dados.BackColor = SystemColors.Control;
            bot_painel_modelo.BackColor = SystemColors.Control;
            bot_painel_nutrientes.BackColor = SystemColors.Control;
            bot_painel_resultado.BackColor = SystemColors.Control;
        }

        private void bot_modelo_proximo_Click(object sender, EventArgs e)
        {

            Console.WriteLine(get_selected_model());

            if (get_selected_model() == 0)
            {
                MessageBox.Show("Seleccione um modelo para continuar!", "Seleccionar Modelo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else
            {
                if (check_fase_change(4))
                {
                    goto_panel(4);
                }
            }
        }

        private void bot_modelo_beaufils_Click(object sender, EventArgs e)
        {
            select_model(1);
        }

        private void bot_modelo_jones_Click(object sender, EventArgs e)
        {
            select_model(2);
        }

        private void bot_modelo_elwaligascho_Click(object sender, EventArgs e)
        {
            select_model(3);
        }

        public bool verifica_dados_cliente_correctos()
        {
            if (trigger_cliente_new == 1)
            {
                if (painel_entidade_tb_nome.Text.Trim() == "")
                {
                    MessageBox.Show("O nome do cliente tem de ser preenchido!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }
                else if (painel_entidade_tb_nif.Text.Trim() == "")
                {
                    MessageBox.Show("O NIF do cliente tem de ser preenchido!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }
                return true;
            }
            else
            {
                if (cliente_seleccionado == "")
                {
                    MessageBox.Show("Tem de seleccionar um cliente ou criar um novo!", "Dados Incorrectos", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }

        private void bot_entidade_proximo_Click(object sender, EventArgs e)
        {
            if (check_fase_change(2))
            {
                if (verifica_dados_cliente_correctos())
                {
                    if (trigger_cliente_new == 1)
                    {
                        if (painel_entidade_tb_morada.Text.Trim() == "" || painel_entidade_tb_codpostal.Text.Trim() == "" || painel_entidade_tb_telefone.Text.Trim() == "")
                        {
                            DialogResult res = MessageBox.Show("Existem campos por preencher!\nDeseja avançar mesmo assim?", "Dados Incorrectos", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
                            if (res.ToString() == "OK")
                            {
                                goto_panel(2);
                            }
                        }
                        else
                        {
                            goto_panel(2);
                        }
                    }
                    else
                    {
                        goto_panel(2);
                    }
                }
            }
        }

        private void bot_dados_proximo_Click(object sender, EventArgs e)
        {
            if (check_fase_change(3))
            {
                if (verifica_dados_ref_amostra())
                {
                    goto_panel(3);
                }
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            if (check_fase_change(5))
            {
                goto_panel(5);
            }
        }

        private bool check_fase_change(int fase)
        {
            if(fase_actual == fase)
            {
                return true;
            }
            else if (fase_actual == fase - 1)
            {
                return true;
            }
            else
            {
                if (fase_actual > fase)
                {
                    MessageBox.Show("A fase que quer aceder já foi fechada!", "Fase Fechada", MessageBoxButtons.OK, MessageBoxIcon.Stop);
                    return false;
                }
                else
                {
                    MessageBox.Show("Tem de fechar fases anteriores a pretendida para continuar!", "Fase Bloqueada", MessageBoxButtons.OK, MessageBoxIcon.Stop);
                    return false;
                }
            }
        }

        private void button5_Click(object sender, EventArgs e)
        {
            int total_sim = 0;

            foreach (DataGridViewRow row in this.datagrid_nutrient_selector.Rows)
            {
                if (row.Cells[1].Value.ToString() == "Sim")
                {
                    total_sim++;
                }
            }

            if (total_sim > 2)
            {
                if (relacoes_calculadas == 0)
                {
                    //filtra os nutrientes
                    DrisMethod.nutrients_filter(datagrid_nutrient_selector);

                    //carrega amostras
                    DrisMethod.get_num_amostras();
                    DrisMethod.read_excel_to_array_amostra();
                    //carrega referencias
                    DrisMethod.get_num_referencias();
                    DrisMethod.read_excel_to_array_referencias();

                    DrisMethod.calcula_normas(dg_relacoes_selector);

                    //carrega amostras para verificar se ja calculadas
                    DrisMethod.carrega_amostras_calculadas_check();

                    relacoes_calculadas++;
                }
                else
                {
                    MessageBox.Show("As relações dos nutrientes já foram calculadas!", "ERRO", MessageBoxButtons.OK, MessageBoxIcon.Stop);
                }
            }
            else
            {
                MessageBox.Show("Tem de ter pelo menos 3 nutrientes activos!", "ERRO", MessageBoxButtons.OK, MessageBoxIcon.Stop);
            }
        }

        private int get_selected_model()
        {
            int result = 0;

            if (bot_modelo_elwaligascho.BackColor == Color.FromArgb(34, 255, 0))
            {
                result = 3;
            }
            else if (bot_modelo_jones.BackColor == Color.FromArgb(34, 255, 0))
            {
                result = 2;
            }
            else if(bot_modelo_beaufils.BackColor == Color.FromArgb(34, 255, 0))
            {
                result = 1;
            }

            return result;
        }

        private void bot_nutrientes_finalizar_Click(object sender, EventArgs e)
        {
            if (check_fase_change(5))
            {
                if (dg_relacoes_selector.RowCount > 0)
                {
                    DrisMethod.relacoes_selection_filter(dg_relacoes_selector);
                    DrisMethod.guarda_normas_projecto();
                    //vv aqui faz selecao do metodo

                    if (get_selected_model() == 1)
                    {
                        DrisMethod.calcula_metodo_beaufils();
                    }
                    else if (get_selected_model() == 2)
                    {
                        DrisMethod.calcula_metodo_jones();
                    }
                    else if (get_selected_model() == 3)
                    {
                        DrisMethod.calcula_metodo_elwali_gascho();
                    }

                    //^^ aqui faz selecao do metodo
                    DrisMethod.guarda_valores_dris_projecto();
                    DrisMethod.calcula_indices_dris_nutrientes();
                    DrisMethod.calcula_ibn_amostras();
                    DrisMethod.guarda_indices_dris_projecto();
                    DrisMethod.set_projecto_style();

                    DrisMethod.copy_inicial_data();

                    DrisMethod.preencher_combo_amostras(amostra_combobox);
                    DrisMethod.preencher_ibn_amostra(ibn_inicial_tb, ibn_medio_inicial_tb, 0, 0);
                    DrisMethod.preencher_dris_inicial(dris_inicial, 0, 0);

                    DrisMethod.preencher_dris_inicial(dris_recomendacao, amostra_combobox.SelectedIndex, 0);
                    DrisMethod.desenha_grafico_dris_inicial(zedGraphControl1, amostra_combobox.SelectedIndex);
                    DrisMethod.preencher_ibn_amostra(ibn_recomendacao_tb, ibn_medio_recomendacao_tb, amostra_combobox.SelectedIndex, 0);

                    goto_panel(5);
                }
                else
                {
                    MessageBox.Show("Não existem relações para analisar", "ERRO", MessageBoxButtons.OK, MessageBoxIcon.Stop);
                }
            }
        }

        //sair
        private void sairToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Application.Exit();
        }

        //exportar para Excel
        private void bot_resultado_exp_excel_Click(object sender, EventArgs e)
        {
            if (projecto_gravado == 0)
            {
                MessageBox.Show("Feche o projecto antes de exportar por favor!", "Exportar", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else
            {
                SelExp childForm_Exportar = new SelExp();
                DialogResult dr = childForm_Exportar.ShowDialog(this);

                if (childForm_Exportar.resultado != null)
                {
                    alert = new AlertForm();
                    alert.Show();

                    DrisMethod.template_a_usar = childForm_Exportar.sel_template;
                    DrisMethod.template_calculos = childForm_Exportar.template_calculos;

                    //excel
                    if (childForm_Exportar.resultado[2].ToString() == "True")
                    {
                        if (childForm_Exportar.resultado[0].ToString() == "True")
                        {
                            DrisMethod.save_result_excel_analitico(zedGraphControl1, amostra_combobox, dris_inicial, ibn_inicial_tb, ibn_medio_inicial_tb, dris_recomendacao, ibn_recomendacao_tb, ibn_medio_recomendacao_tb, cliente_seleccionado, relatorio_seleccionado, childForm_Exportar.caminho_excel, 0);
                        }
                        if (childForm_Exportar.resultado[1].ToString() == "True")
                        {
                            DrisMethod.save_result_excel_apreciacao(zedGraphControl1, amostra_combobox, dris_inicial, ibn_inicial_tb, ibn_medio_inicial_tb, dris_recomendacao, ibn_recomendacao_tb, ibn_medio_recomendacao_tb, cliente_seleccionado, relatorio_seleccionado, childForm_Exportar.caminho_excel, 0, childForm_Exportar.num_colunas);
                        }
                    }
                    //pdf
                    if (childForm_Exportar.resultado[3].ToString() == "True")
                    {
                        string tmp_path = Application.StartupPath;
                        string tmp_pdf1 = @"" + tmp_path + "\\tmp01.xls";
                        string tmp_pdf2 = @"" + tmp_path + "\\tmp02.xls";

                        if (childForm_Exportar.resultado[0].ToString() == "True")
                        {
                            DrisMethod.save_result_excel_analitico(zedGraphControl1, amostra_combobox, dris_inicial, ibn_inicial_tb, ibn_medio_inicial_tb, dris_recomendacao, ibn_recomendacao_tb, ibn_medio_recomendacao_tb, cliente_seleccionado, relatorio_seleccionado, tmp_pdf1, 1);
                            DrisMethod.save_result_pdf_analitico(childForm_Exportar.caminho_pdf);
                            if (File.Exists(tmp_pdf1))
                            {
                                File.Delete(tmp_pdf1);
                            }
                        }
                        if (childForm_Exportar.resultado[1].ToString() == "True")
                        {
                            DrisMethod.save_result_excel_apreciacao(zedGraphControl1, amostra_combobox, dris_inicial, ibn_inicial_tb, ibn_medio_inicial_tb, dris_recomendacao, ibn_recomendacao_tb, ibn_medio_recomendacao_tb, cliente_seleccionado, relatorio_seleccionado, tmp_pdf2, 1, childForm_Exportar.num_colunas);
                            DrisMethod.save_result_pdf_apreciacao(childForm_Exportar.caminho_pdf);
                            if (File.Exists(tmp_pdf2))
                            {
                                File.Delete(tmp_pdf2);
                            }
                        }
                    }
                    alert.Close();
                    MessageBox.Show("Projecto exportado com sucesso!", "Exportar Projecto", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
            }
        }

        //quando se muda a combobox da amostra
        private void amostra_combobox_SelectionChangeCommitted(object sender, EventArgs e)
        {
            //inicial
            DrisMethod.preencher_dris_inicial(dris_inicial, amostra_combobox.SelectedIndex, 0);
            DrisMethod.preencher_ibn_amostra(ibn_inicial_tb, ibn_medio_inicial_tb, amostra_combobox.SelectedIndex, 0);

            //recomendacao
            DrisMethod.preencher_dris_inicial(dris_recomendacao, amostra_combobox.SelectedIndex, 1);
            DrisMethod.desenha_grafico_dris_inicial(zedGraphControl1, amostra_combobox.SelectedIndex);
            DrisMethod.preencher_ibn_amostra(ibn_recomendacao_tb, ibn_medio_recomendacao_tb, amostra_combobox.SelectedIndex, 1);
        }

        private void dris_inicial_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            dris_recomendacao.ClearSelection();
            dris_recomendacao.Rows[dris_inicial.CurrentCell.RowIndex].Selected = true;
            dris_inicial.Rows[dris_inicial.CurrentCell.RowIndex].Selected = true;
        }

        private void dris_recomendacao_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            dris_inicial.ClearSelection();
            dris_inicial.Rows[dris_recomendacao.CurrentCell.RowIndex].Selected = true;
            dris_recomendacao.Rows[dris_recomendacao.CurrentCell.RowIndex].Selected = true;
        }

        private void bot_optimizar_Click(object sender, EventArgs e)
        {
            if (DrisMethod.amostras_calculadas[amostra_combobox.SelectedIndex] == "0")
            {

                //faz copia dos dados da amostra
                DrisMethod.copy_amostra_data_to_tmp_amostra_data(amostra_combobox.SelectedIndex);

                dris_optimizacao childForm = new dris_optimizacao(amostra_combobox, DrisMethod);
                DialogResult dr = childForm.ShowDialog(this);

                //actualiza os valores e dados
                //inicial
                DrisMethod.preencher_dris_inicial(dris_inicial, amostra_combobox.SelectedIndex, 0);
                DrisMethod.preencher_ibn_amostra(ibn_inicial_tb, ibn_medio_inicial_tb, amostra_combobox.SelectedIndex, 0);

                //recomendacao
                DrisMethod.preencher_dris_inicial(dris_recomendacao, amostra_combobox.SelectedIndex, 1);
                DrisMethod.desenha_grafico_dris_inicial(zedGraphControl1, amostra_combobox.SelectedIndex);
                DrisMethod.preencher_ibn_amostra(ibn_recomendacao_tb, ibn_medio_recomendacao_tb, amostra_combobox.SelectedIndex, 1);

            }
            else
            {
                MessageBox.Show("A optimização já foi realizada para esta amostra", "EOR - DRIS",
                MessageBoxButtons.OK, MessageBoxIcon.Asterisk);
            }
        }

        private void datagrid_nutrient_selector_CellDoubleClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex != -1)
            {
                if (e.ColumnIndex != 0)
                {
                    if (datagrid_nutrient_selector.Rows[e.RowIndex].Cells[e.ColumnIndex].Value.ToString() == "Sim")
                    {
                        datagrid_nutrient_selector.Rows[e.RowIndex].Cells[e.ColumnIndex].Value = "Não";
                    }
                    else
                    {
                        datagrid_nutrient_selector.Rows[e.RowIndex].Cells[e.ColumnIndex].Value = "Sim";
                    }
                }
            }
        }

        private void dg_relacoes_selector_CellDoubleClick(object sender, DataGridViewCellEventArgs e)
        {

            if (e.RowIndex != -1)
            {

                if (dg_relacoes_selector.Rows[e.RowIndex].Cells[2].Value.ToString() == "X")
                {
                    dg_relacoes_selector.Rows[e.RowIndex].Cells[2].Value = "";
                    dg_relacoes_selector.Rows[e.RowIndex].Cells[3].Value = "X";
                }
                else if(dg_relacoes_selector.Rows[e.RowIndex].Cells[2].Value.ToString() == "")
                {
                    dg_relacoes_selector.Rows[e.RowIndex].Cells[2].Value = "X";
                    dg_relacoes_selector.Rows[e.RowIndex].Cells[3].Value = "";
                }
            }
        }

        private void dados_bot_importar_referencia_Click(object sender, EventArgs e)
        {
            OpenFileDialog openFileDialog1 = new OpenFileDialog();
            openFileDialog1.InitialDirectory = System.Environment.GetFolderPath(Environment.SpecialFolder.Desktop);
            openFileDialog1.Filter = "Ficheiros Excel (*.xls)|*.xls";
            openFileDialog1.FilterIndex = 2;
            openFileDialog1.RestoreDirectory = true;

            if (openFileDialog1.ShowDialog() == DialogResult.OK)
            {
                dados_texto_importar_referencia.Text = openFileDialog1.FileName.ToString();
            }
        }

        public void UpdatePictureBox(Int32 i)
        {
            if (i > 0)
            {
                Console.WriteLine("pic: {0}", i);
                DataTable tmp = DrisDB.selectQuery("SELECT * FROM ImageStore WHERE image_id = '" + i + "'");

                foreach (DataRow dtRow in tmp.Rows)
                {
                    byte[] imageBytes = (byte[])dtRow[2];
                    MemoryStream ms = new MemoryStream(imageBytes);
                    System.Drawing.Bitmap bmap = new System.Drawing.Bitmap(ms);
                    pictureBox7.Image = (System.Drawing.Image)bmap; 
                    pictureBox7.SizeMode = PictureBoxSizeMode.StretchImage;
                    pictureBox7.Size = new System.Drawing.Size(267, 138);
                }
            }
            else
            {
                pictureBox7.Image = null;
            }
        }

        private void dados_bot_importar_amostra_Click(object sender, EventArgs e)
        {
            OpenFileDialog openFileDialog1 = new OpenFileDialog();
            openFileDialog1.InitialDirectory = System.Environment.GetFolderPath(Environment.SpecialFolder.Desktop);
            openFileDialog1.Filter = "Ficheiros Excel (*.xls)|*.xls";
            openFileDialog1.FilterIndex = 2;
            openFileDialog1.RestoreDirectory = true;

            if (openFileDialog1.ShowDialog() == DialogResult.OK)
            {
                dados_texto_importar_amostra.Text = openFileDialog1.FileName.ToString();
            }
        }



        private void Form1_KeyDown(object sender, KeyEventArgs e)
        {
            if (e.Control && e.Alt && e.KeyCode == Keys.D0)
            {
                License childForm = new License();
                DialogResult dr = childForm.ShowDialog(this);
            }
        }

        private void painel_entidade_s_1_Click(object sender, EventArgs e)
        {
            ProcurarEntidade childForm = new ProcurarEntidade(dt_clientes, DrisDB);
            DialogResult dr = childForm.ShowDialog(this);

            if (childForm.selected_client != "")
            {
                DataTable dt = new DataTable();
                dt = DrisDB.selectQuery("SELECT * FROM CLIENTE WHERE ID ='" + childForm.selected_client + "'");

                painel_entidade_tb_nome.Enabled = false;
                painel_entidade_tb_codpostal.Enabled = false;
                painel_entidade_tb_morada.Enabled = false;
                painel_entidade_tb_nif.Enabled = false;
                painel_entidade_tb_telefone.Enabled = false;

                painel_entidade_tb_nome.Text = dt.Rows[0]["NOME"].ToString();
                painel_entidade_tb_codpostal.Text = dt.Rows[0]["COD_POSTAL"].ToString();
                painel_entidade_tb_morada.Text = dt.Rows[0]["MORADA"].ToString();
                painel_entidade_tb_nif.Text = dt.Rows[0]["NIF"].ToString();
                painel_entidade_tb_telefone.Text = dt.Rows[0]["TELEFONE"].ToString();

                cliente_seleccionado = childForm.selected_client;
                trigger_cliente_new = 0;
            }
        }

        private void bot_entidade_novaentidade_Click(object sender, EventArgs e)
        {
            painel_entidade_tb_nome.Enabled = true;
            painel_entidade_tb_codpostal.Enabled = true;
            painel_entidade_tb_morada.Enabled = true;
            painel_entidade_tb_nif.Enabled = true;
            painel_entidade_tb_telefone.Enabled = true;

            painel_entidade_tb_nome.Text = "";
            painel_entidade_tb_codpostal.Text = "";
            painel_entidade_tb_morada.Text = "";
            painel_entidade_tb_nif.Text = "";
            painel_entidade_tb_telefone.Text = "";

            trigger_cliente_new = 1;
        }

        public void preencher_referencias()
        {
            painel_dados_cb_referencia.Items.Clear();
            dt_referencias = DrisDB.selectQuery("SELECT * FROM REFERENCIA WHERE ID_CULTURA = '" + cultura_seleccionada + "'");
            foreach (DataRow dtRow in dt_referencias.Rows)
            {
                painel_dados_cb_referencia.Items.Add(new ComboBoxItem(dtRow[2].ToString(), dtRow[0].ToString()));
            }
        }

        public void preencher_amostras()
        {
            painel_dados_cb_amostra.Items.Clear();
            dt_amostras = DrisDB.selectQuery("SELECT * FROM AMOSTRA WHERE ID_CULTURA = '" + cultura_seleccionada + "' AND ID_CLIENTE = '" + cliente_seleccionado + "'");
            foreach (DataRow dtRow in dt_amostras.Rows)
            {
                painel_dados_cb_amostra.Items.Add(new ComboBoxItem(dtRow[1].ToString(), dtRow[0].ToString()));
            }
        }

        private void painel_dados_cb_cultura_SelectedIndexChanged(object sender, EventArgs e)
        {
            string hValue = ((ComboBoxItem)painel_dados_cb_cultura.SelectedItem).HiddenValue;
            cultura_seleccionada = hValue;
            preencher_referencias();
            preencher_amostras();
        }

        private void bot_resultado_fec_proj_Click(object sender, EventArgs e)
        {
            if (textBox6.Text.Trim() == "")
            {
                MessageBox.Show("Insira o requisitante, por favor!", "Fechar Projecto", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else
            {

                if (projecto_gravado == 0)
                {
                    //mostra janela para colocar numeros de boletim
                    EscolherBoletim childForm = new EscolherBoletim(this, DrisMethod);
                    DialogResult dr = childForm.ShowDialog(this);

                    if ( childForm.lista_boletim.Count() > 0)
                    {
                        string sql = "";
                        //guarda cliente
                        if (trigger_cliente_new == 1)
                        {
                            sql = "INSERT INTO CLIENTE(NOME, MORADA, COD_POSTAL, TELEFONE, NIF) ";
                            sql += "VALUES ('" + painel_entidade_tb_nome.Text + "', ";
                            sql += "'" + painel_entidade_tb_morada.Text + "',";
                            sql += "'" + painel_entidade_tb_codpostal.Text + "', ";
                            sql += "'" + painel_entidade_tb_telefone.Text + "', ";
                            sql += "'" + painel_entidade_tb_nif.Text + "')";
                            DrisDB.runQuery(sql);
                        }
                        //guarda referencia
                        if (dados_rb_ref1.Checked)
                        {
                            referencia_seleccionada = DrisMethod.save_referencia_bd(cultura_seleccionada);
                            Console.WriteLine("ID Ref. {0}", referencia_seleccionada);
                        }
                        //guarda amostra
                        if (dados_rb_am1.Checked)
                        {
                            amostra_seleccionada = DrisMethod.save_amostra_bd(textBox1.Text.Trim(), dateTimePicker1.Value.ToString("dd-MM-yyyy"), dateTimePicker2.Value.ToString("dd-MM-yyyy"), textBox5.Text, textBox2.Text, textBox4.Text, textBox3.Text, id_imagem_amostra.ToString(), cliente_seleccionado, cultura_seleccionada, referencia_seleccionada, textBox7.Text);
                        }

                        //guarda relatorio
                        relatorio_seleccionado = DrisMethod.save_relatorio_bd(referencia_seleccionada, dateTimePicker3.Value.ToString("dd-MM-yyyy"), dateTimePicker4.Value.ToString("dd-MM-yyyy"), textBox5.Text, textBox2.Text, textBox4.Text, textBox3.Text, id_imagem_amostra.ToString(), cliente_seleccionado, cultura_seleccionada, referencia_seleccionada, amostra_seleccionada, textBox6.Text.Trim(), childForm.lista_boletim, utilizador_seleccionado);

                        projecto_gravado++;

                        MessageBox.Show("Projecto Fechado com Sucesso!", "Fechar Projecto", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    }
                    
                }
                else
                {
                    MessageBox.Show("Este projecto já foi fechado!", "Fechar Projecto", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void button2_Click_1(object sender, EventArgs e)
        {
            id_imagem_amostra = imagemParcela.InsertImage();
            UpdatePictureBox(id_imagem_amostra);
        }

        private void painel_dados_cb_referencia_SelectedIndexChanged(object sender, EventArgs e)
        {
            referencia_seleccionada = ((ComboBoxItem)painel_dados_cb_referencia.SelectedItem).HiddenValue;
            Console.WriteLine(referencia_seleccionada);
        }

        private void painel_dados_cb_amostra_SelectedIndexChanged(object sender, EventArgs e)
        {
            amostra_seleccionada = ((ComboBoxItem)painel_dados_cb_amostra.SelectedItem).HiddenValue;
            Console.WriteLine(amostra_seleccionada);
        }

        private void loginToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Utilizador childForm = new Utilizador(caminho_base_dados);
            DialogResult dr = childForm.ShowDialog(this);
        }

        private void preferênciasToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Preferencias childForm = new Preferencias();
            DialogResult dr = childForm.ShowDialog(this);
        }

        private void sobreToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Sobre childForm = new Sobre();
            DialogResult dr = childForm.ShowDialog(this);
        }

        private void pictureBox4_Click(object sender, EventArgs e)
        {
            DialogResult dr = MessageBox.Show("Pretende realmente iniciar novo projecto?", "Novo Projecto", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
            if (dr.ToString() == "OK")
            {
                //vars
                dris DrisMethod = new dris();
                dt_clientes = new DataTable();
                dt_culturas = new DataTable();
                dt_referencias = new DataTable();
                dt_amostras = new DataTable();
                imagemParcela = new ImageHelper();
                cliente_seleccionado = "";
                cultura_seleccionada = "";
                referencia_seleccionada = "";
                amostra_seleccionada = "";
                relatorio_seleccionado = "";
                trigger_cliente_new = 0;
                projecto_gravado = 0;
                id_imagem_amostra = 0;
                fase_actual = 0;
                relacoes_calculadas = 0;
                utilizador_seleccionado = "";
                caminho_base_dados = "";

                //gui
                hide_all_panel();
                goto_panel(1);

                limpa_campos_entidade();
                limpa_campos_dados();
                limpa_campos_modelos();
                limpa_campos_nutrientes();
                limpa_campos_resultado();

                ungreenify_panel_but();
                greenify_panel_but(1);
            }
        }

        public void limpa_campos_resultado()
        {
            dateTimePicker3.Value = DateTime.Today;
            dateTimePicker4.Value = DateTime.Today;
            textBox6.Text = "";
        }

        public void limpa_campos_nutrientes()
        {
            datagrid_nutrient_selector.DataSource = null;
            dg_relacoes_selector.DataSource = null;
        }

        public void limpa_campos_modelos()
        {
            unselect_all_model();
        }

        public void limpa_campos_dados()
        {
            preencher_culturas();

            while(painel_dados_cb_referencia.Items.Count > 0)
            {
                painel_dados_cb_referencia.Items.RemoveAt(0);
            }

            while (painel_dados_cb_amostra.Items.Count > 0)
            {
                painel_dados_cb_amostra.Items.RemoveAt(0);
            }

            dados_rb_ref1.Checked = true;
            dados_rb_ref2.Checked = false;
            dados_rb_am1.Checked = true;
            dados_rb_am2.Checked = false;

            dados_texto_importar_referencia.Text = "";
            dados_texto_importar_amostra.Text = "";

            textBox1.Text = "";
            textBox2.Text = "";
            textBox5.Text = "";
            textBox7.Text = "";
            textBox4.Text = ""; 
            textBox3.Text = "";
            
            dateTimePicker1.Value = DateTime.Today;
            dateTimePicker2.Value = DateTime.Today;

            pictureBox7.Image = null;
        }

        public void limpa_campos_entidade()
        {
            painel_entidade_tb_nome.ReadOnly = true;
            painel_entidade_tb_nome.Text = "";
            painel_entidade_tb_nif.ReadOnly = true;
            painel_entidade_tb_nif.Text = "";
            painel_entidade_tb_morada.ReadOnly = true;
            painel_entidade_tb_morada.Text = "";
            painel_entidade_tb_codpostal.ReadOnly = true;
            painel_entidade_tb_codpostal.Text = "";
            painel_entidade_tb_telefone.ReadOnly = true;
            painel_entidade_tb_telefone.Text = "";
        }

        private void button1_Click_1(object sender, EventArgs e)
        {
            NovaCultura childForm = new NovaCultura(DrisDB);
            DialogResult dr = childForm.ShowDialog(this);
            limpa_campos_dados();
        }

        private void entidadesToolStripMenuItem_Click(object sender, EventArgs e)
        {
            EntidadeForm childForm = new EntidadeForm(caminho_base_dados);
            DialogResult dr = childForm.ShowDialog(this);
        }

        private void amostrasToolStripMenuItem_Click(object sender, EventArgs e)
        {
            AmostraForm childForm = new AmostraForm(caminho_base_dados);
            DialogResult dr = childForm.ShowDialog(this);
        }

        private void referênciasToolStripMenuItem_Click(object sender, EventArgs e)
        {
            ReferenciaForm childForm = new ReferenciaForm(caminho_base_dados);
            DialogResult dr = childForm.ShowDialog(this);
        }

        private void modelosToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Relatorio childForm = new Relatorio(caminho_base_dados);
            DialogResult dr = childForm.ShowDialog(this);
        }

        private void culturasToolStripMenuItem_Click(object sender, EventArgs e)
        {
            CulturaForm childForm = new CulturaForm(caminho_base_dados);
            DialogResult dr = childForm.ShowDialog(this);
        }

        private void button4_Click_1(object sender, EventArgs e)
        {
            
        }

        private void button6_Click(object sender, EventArgs e)
        {
            
        }

        private void button4_Click_2(object sender, EventArgs e)
        {
            OpenFileDialog openFileDialog1 = new OpenFileDialog();
            openFileDialog1.InitialDirectory = System.Environment.GetFolderPath(Environment.SpecialFolder.Desktop);
            openFileDialog1.Filter = "Ficheiros Excel (*.xls)|*.xls";
            openFileDialog1.FilterIndex = 2;
            openFileDialog1.RestoreDirectory = true;

            if (openFileDialog1.ShowDialog() == DialogResult.OK)
            {
                textBox8.Text = openFileDialog1.FileName.ToString();
            }
        }

        private void button6_Click_1(object sender, EventArgs e)
        {
            String linha = textBox9.Text;
            int number;

            if (linha.Trim().Length == 0)
            {
                MessageBox.Show("Tem de indicar uma linha do ficheiro Excel para recolher os dados", "Recolha Dados", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            else
            {
                bool result = Int32.TryParse(linha, out number);
                if (result)
                {
                    FileStream file = new FileStream(textBox8.Text, FileMode.Open, FileAccess.Read);
                    HSSFWorkbook hssfworkbook = new HSSFWorkbook(file);

                    ISheet sheet = hssfworkbook.GetSheet("CAB - Folhas 2");
                    IRow dataRow;
                    ICell dataCell = null;

                    dataRow = sheet.GetRow(number - 1);

                    string val1 = "";
                    string val2 = "";
                    string val3 = "";
                    string val4 = "";
                    string val5 = "";
                    string val6 = "";
                    string val7 = "";
                    string val8 = "";
                    string val9 = "";
                    string val10 = "";
                    string val11 = "";
                    string val12 = "";
                    string val13 = "";
                    string val14 = "";
                    string val15 = "";
                    string val16 = "";
                    DataTable dt = new DataTable();
                    string[] words = null;

                    //nome
                    try
                    {
                        dataCell = dataRow.GetCell(1);
                        val1 = dataCell.ToString().Trim();
                    }
                    catch(Exception ex)
                    {
                    }

                    //morada
                    try
                    {
                        dataCell = dataRow.GetCell(2);
                        val2 = dataCell.ToString().Trim();
                    }
                    catch (Exception ex)
                    {
                    }

                    //codpostal
                    try
                    {
                        dataCell = dataRow.GetCell(3);
                        val3 = dataCell.ToString().Trim();
                    }
                    catch (Exception ex)
                    {
                    }

                    //telefone
                    try
                    {
                        dataCell = dataRow.GetCell(4);
                        val4 = dataCell.ToString().Trim();
                    }
                    catch (Exception ex)
                    {
                    }

                    //nif
                    try
                    {
                        dataCell = dataRow.GetCell(5);
                        val5 = dataCell.ToString().Trim();
                    }
                    catch (Exception ex)
                    {
                    }

                    //requisitante
                    try
                    {
                        dataCell = dataRow.GetCell(6);
                        val6 = dataCell.ToString().Trim();
                        textBox6.Text = val6;
                    }
                    catch (Exception ex)
                    {
                    }

                    //p_ensaios
                    try
                    {
                        dataCell = dataRow.GetCell(7);
                        val7 = dataCell.ToString().Trim();

                        words = val7.Trim().Substring(0, 10).Replace("/", "-").Split('-');
                        dateTimePicker3.Value = Convert.ToDateTime(words[0] + "-" + words[1] + "-" + words[2]);

                        words = val7.Trim().Substring(13, 10).Replace("/", "-").Split('-');
                        dateTimePicker4.Value = Convert.ToDateTime(words[0] + "-" + words[1] + "-" + words[2]);
                    }
                    catch (Exception ex)
                    {
                    }

                    //propriedade
                    try
                    {
                        dataCell = dataRow.GetCell(8);
                        val8 = dataCell.ToString().Trim();
                        textBox7.Text = val8;
                    }
                    catch (Exception ex)
                    {
                    }

                    //cultura
                    try
                    {
                        dataCell = dataRow.GetCell(9);
                        val9 = dataCell.ToString().Trim();

                        dt = new DataTable();
                        dt = DrisDB.selectQuery("SELECT * FROM CULTURA WHERE nome ='" + val9.Trim() + "'");

                        if (dt.Rows.Count > 0)
                        {
                            painel_dados_cb_cultura.SelectedIndex = painel_dados_cb_cultura.FindString(val9.Trim());
                            cultura_seleccionada = dt.Rows[0]["ID"].ToString();
                        }
                    }
                    catch (Exception ex)
                    {
                    }

                    //parcela
                    try
                    {
                        dataCell = dataRow.GetCell(10);
                        val10 = dataCell.ToString().Trim();
                        textBox2.Text = val10;
                    }
                    catch (Exception ex)
                    {
                    }

                    //freguesia
                    try
                    {
                        dataCell = dataRow.GetCell(11);
                        val11 = dataCell.ToString().Trim();
                        textBox4.Text = val11;
                    }
                    catch (Exception ex)
                    {
                    }

                    //concelho
                    try
                    {
                        dataCell = dataRow.GetCell(12);
                        val12 = dataCell.ToString().Trim();
                        textBox3.Text = val12;
                    }
                    catch (Exception ex)
                    {
                    }

                    //ref. amostra
                    try
                    {
                        dataCell = dataRow.GetCell(13);
                        val13 = dataCell.ToString().Trim();
                        textBox1.Text = val13;
                    }
                    catch (Exception ex)
                    {
                    }

                    //d_colheita
                    try
                    {
                        dataCell = dataRow.GetCell(14);
                        val14 = dataCell.ToString().Trim();

                        words = val14.Trim().Replace("/", "-").Split('-');
                        dateTimePicker1.Value = Convert.ToDateTime(words[1] + "-" + words[0] + "-" + words[2]);
                    }
                    catch (Exception ex)
                    {
                    }

                    //d_recepcao
                    try
                    {
                        dataCell = dataRow.GetCell(15);
                        val15 = dataCell.ToString().Trim();

                        words = val15.Trim().Replace("/", "-").Split('-');
                        dateTimePicker2.Value = Convert.ToDateTime(words[1] + "-" + words[0] + "-" + words[2]);
                    }
                    catch (Exception ex)
                    {
                    }

                    //m_vegetal
                    try
                    {
                        dataCell = dataRow.GetCell(17);
                        val16 = dataCell.ToString().Trim();
                        textBox5.Text = val16;
                    }
                    catch (Exception ex)
                    {
                    }

                    //fechar documento
                    file.Close();

                    dt = new DataTable();
                    dt = DrisDB.selectQuery("SELECT * FROM CLIENTE WHERE nif ='" + val5 + "'");

                    if (dt.Rows.Count > 0)
                    {
                        DialogResult dr = MessageBox.Show("Já existe este contribuinte na base dados. Clique OK para importar os dados da base dados ou Cancel para importar a partir do Excel.", "Cliente Via Excel", MessageBoxButtons.OKCancel, MessageBoxIcon.Question);
                        if (dr.ToString() == "OK")
                        {
                            painel_entidade_tb_nome.Enabled = false;
                            painel_entidade_tb_codpostal.Enabled = false;
                            painel_entidade_tb_morada.Enabled = false;
                            painel_entidade_tb_nif.Enabled = false;
                            painel_entidade_tb_telefone.Enabled = false;

                            painel_entidade_tb_nome.Text = dt.Rows[0]["NOME"].ToString();
                            painel_entidade_tb_codpostal.Text = dt.Rows[0]["COD_POSTAL"].ToString();
                            painel_entidade_tb_morada.Text = dt.Rows[0]["MORADA"].ToString();
                            painel_entidade_tb_nif.Text = dt.Rows[0]["NIF"].ToString();
                            painel_entidade_tb_telefone.Text = dt.Rows[0]["TELEFONE"].ToString();

                            cliente_seleccionado = dt.Rows[0]["ID"].ToString();
                        }
                        else
                        {
                            dr = MessageBox.Show("Pretende substituir os dados do cliente na base de dados pelos dados do Excel? Se clicar No, nada irá ser feito.", "Cliente Via Excel", MessageBoxButtons.YesNo, MessageBoxIcon.Question);
                            if (dr.ToString() == "Yes")
                            {
                                DrisDB.runQuery("UPDATE CLIENTE Set nome = '" + val1 + "', morada = '" + val2 + "',  cod_postal = '" + val3 + "', telefone = '" + val4 + "' WHERE id =" + dt.Rows[0]["ID"].ToString());
                                trigger_cliente_new = 0;
                                cliente_seleccionado = dt.Rows[0]["ID"].ToString();

                                painel_entidade_tb_nome.Enabled = false;
                                painel_entidade_tb_codpostal.Enabled = false;
                                painel_entidade_tb_morada.Enabled = false;
                                painel_entidade_tb_nif.Enabled = false;
                                painel_entidade_tb_telefone.Enabled = false;

                                painel_entidade_tb_nome.Text = val1;
                                painel_entidade_tb_codpostal.Text = val3;
                                painel_entidade_tb_morada.Text = val2;
                                painel_entidade_tb_nif.Text = val5;
                                painel_entidade_tb_telefone.Text = val4;
                            }
                            else
                            {
                                trigger_cliente_new = 1;
                                cliente_seleccionado = "";

                                painel_entidade_tb_nome.Enabled = true;
                                painel_entidade_tb_codpostal.Enabled = true;
                                painel_entidade_tb_morada.Enabled = true;
                                painel_entidade_tb_nif.Enabled = true;
                                painel_entidade_tb_telefone.Enabled = true;

                                painel_entidade_tb_nome.Text = "";
                                painel_entidade_tb_codpostal.Text = "";
                                painel_entidade_tb_morada.Text = "";
                                painel_entidade_tb_nif.Text = "";
                                painel_entidade_tb_telefone.Text = "";
                            }
                        }
                    }
                    else
                    {
                        painel_entidade_tb_nome.Enabled = true;
                        painel_entidade_tb_codpostal.Enabled = true;
                        painel_entidade_tb_morada.Enabled = true;
                        painel_entidade_tb_nif.Enabled = true;
                        painel_entidade_tb_telefone.Enabled = true;

                        painel_entidade_tb_nome.Text = val1;
                        painel_entidade_tb_codpostal.Text = val3;
                        painel_entidade_tb_morada.Text = val2;
                        painel_entidade_tb_nif.Text = val5;
                        painel_entidade_tb_telefone.Text = val4;

                        trigger_cliente_new = 1;
                    }
                }
                else
                {
                    MessageBox.Show("O número da linha tem de ser um inteiro válido!", "Linha Excel", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

    }
}
