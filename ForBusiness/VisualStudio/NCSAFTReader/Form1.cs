using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Xml.Linq;
using System.Net;
using System.Threading;
using System.IO;

namespace NCSAFTReader
{
    public partial class Form1 : Form
    {

        Validador validador = new Validador();
        string versao_saft = "xsd_03_simplificado";
        SAFT_Cabecalho cabecalho;
        SAFT_Clientes clientes;
        SAFT_Artigos artigos;
        SAFT_Documentos documentos;
        string mostra_o_que = "Tabelas";
        public string ns_xsd = "urn:OECD:StandardAuditFile-Tax:PT_1.03_01";

        public Form1()
        {
            InitializeComponent();
            this.WindowState = FormWindowState.Maximized;
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.Sizable;
            treeView1.ExpandAll();
            esconde_validador();
            textBox10.Text = "";

            BackgroundWorker backgroundWorker1 = new BackgroundWorker();
            backgroundWorker1.WorkerReportsProgress = true;
            backgroundWorker1.WorkerSupportsCancellation = true;
            backgroundWorker1.DoWork += new System.ComponentModel.DoWorkEventHandler(backgroundWorker1_DoWork);
            backgroundWorker1.RunWorkerAsync();
        }

        private void backgroundWorker1_DoWork(object sender, DoWorkEventArgs e)
        {
            load_image_ads();
        }

        private void load_image_ads()
        {
            System.Net.ServicePointManager.Expect100Continue = false;
            WebRequest request = WebRequest.Create("http://novoscanais.no-ip.info/img/ads_ncsaftreader.gif");
            request.Proxy = null;

            using (var response = (HttpWebResponse)request.GetResponse())
            {
                Stream stream = response.GetResponseStream();

                pictureBox1.Image = Bitmap.FromStream(stream);
                pictureBox1.SizeMode = PictureBoxSizeMode.StretchImage;
            }
        }

        private void actualiza_sizes()
        {
            dataGridView2.Size = new Size(this.Width - 15, Convert.ToInt32(this.Height * 0.3));

            dataGridView1.Size = new Size(Convert.ToInt32(this.Width*0.69), Convert.ToInt32(this.Height * 0.38));
            dataGridView4.Size = new Size(Convert.ToInt32(this.Width*0.29), Convert.ToInt32(this.Height * 0.38));
            dataGridView4.Location = new Point(Convert.ToInt32(this.Width * 0.69) + 15, dataGridView4.Location.Y);

            dataGridView3.Size = new Size(this.Width - 15, Convert.ToInt32(this.Height * 0.69));
            tabControl1.Size = new Size(407, 165);

            pictureBox1.Size = new Size(291, 163);
            pictureBox1.Location = new Point(pictureBox1.Location.X, pictureBox1.Location.Y);

            dataGridView3.Columns[0].Width = Convert.ToInt32(this.Width * 0.1) - 20;
            dataGridView3.Columns[1].Width = Convert.ToInt32(this.Width * 0.9) - 20;
        }

        private void Form1_SizeChanged(object sender, EventArgs e)
        {
            actualiza_sizes();
        }

        void mostra_validador()
        {
            dataGridView2.Visible = false;
            dataGridView1.Visible = false;
            dataGridView4.Visible = false;
            dataGridView3.Visible = true;
            actualiza_sizes();
        }

        void esconde_validador()
        {
            dataGridView2.Visible = true;
            dataGridView1.Visible = true;
            dataGridView4.Visible = true;
            dataGridView3.Visible = false;
            actualiza_sizes();
        }

        private void sairToolStripMenuItem1_Click(object sender, EventArgs e)
        {
            Environment.Exit(0);
        }

        private void abrirToolStripMenuItem1_Click(object sender, EventArgs e)
        {
            openFileDialog1.InitialDirectory = Environment.GetFolderPath(Environment.SpecialFolder.Desktop);
            openFileDialog1.Title = "Ficheiro SAFT(PT)";
            openFileDialog1.FileName = "";
            openFileDialog1.Filter = "XML (*.xml)|*.xml";

            DialogResult result = openFileDialog1.ShowDialog();

            if (result == DialogResult.OK)
            {
                textBox10.Text = "A Validar SAFT";
                Application.DoEvents();

                validador.carrega_saft(openFileDialog1.FileName);

                if (validador.valida_saft(versao_saft))
                {
                    textBox10.Text = "Ficheiro SAF-T Válido";
                    //carrega dados
                    XDocument doc1 = validador.get_xml_doc();
                    //carrega cabecalho
                    cabecalho = new SAFT_Cabecalho(doc1, this);
                    clientes = new SAFT_Clientes(doc1, this);
                    artigos = new SAFT_Artigos(doc1, this);
                    documentos = new SAFT_Documentos(doc1, this);
                }
                else
                {
                    textBox10.Text = "Ficheiro SAF-T Inválido";
                    DataTable dt = validador.get_errors();
                    dataGridView3.AutoGenerateColumns = false;
                    dataGridView3.Columns[0].DataPropertyName = "No";
                    dataGridView3.Columns[1].DataPropertyName = "Erro";
                    dataGridView3.DataSource = dt;
                    dataGridView3.DefaultCellStyle.WrapMode = DataGridViewTriState.True;
                }
            }

            actualiza_sizes();
        }

        private void validadorToolStripMenuItem1_Click(object sender, EventArgs e)
        {
            if (validadorToolStripMenuItem1.Checked)
            {
                validadorToolStripMenuItem1.Checked = false;
                esconde_validador();
            }
            else
            {
                validadorToolStripMenuItem1.Checked = true;
                mostra_validador();
            }
        }

        private void esconde_todas_versoes()
        {
            toolStripMenuItem1.Checked = false;
            sAFTPT10101ToolStripMenuItem.Checked = false;
            sAFTPT10201GeralToolStripMenuItem.Checked = false;
            sAFTPT10201SimplificadoToolStripMenuItem.Checked = false;
            sAFTPT10301GeralToolStripMenuItem.Checked = false;
            sAFTPT10301SimplificadoToolStripMenuItem.Checked = false;
        }

        private void sAFTPT10101ToolStripMenuItem_Click(object sender, EventArgs e)
        {
            esconde_todas_versoes();
            sAFTPT10101ToolStripMenuItem.Checked = true;
            versao_saft = "xsd_01_simplificado";
            ns_xsd = "urn:OECD:StandardAuditFile-Tax:PT_1.01_01";
        }

        private void toolStripMenuItem1_Click(object sender, EventArgs e)
        {
            esconde_todas_versoes();
            toolStripMenuItem1.Checked = true;
            versao_saft = "xsd_01_geral";
            ns_xsd = "urn:OECD:StandardAuditFile-Tax:PT_1.01_01";
        }

        private void sAFTPT10201GeralToolStripMenuItem_Click(object sender, EventArgs e)
        {
            esconde_todas_versoes();
            sAFTPT10201GeralToolStripMenuItem.Checked = true;
            versao_saft = "xsd_02_geral";
            ns_xsd = "urn:OECD:StandardAuditFile-Tax:PT_1.02_01";
        }

        private void sAFTPT10201SimplificadoToolStripMenuItem_Click(object sender, EventArgs e)
        {
            esconde_todas_versoes();
            sAFTPT10201SimplificadoToolStripMenuItem.Checked = true;
            versao_saft = "xsd_02_simplificado";
            ns_xsd = "urn:OECD:StandardAuditFile-Tax:PT_1.02_01";
        }

        private void sAFTPT10301GeralToolStripMenuItem_Click(object sender, EventArgs e)
        {
            esconde_todas_versoes();
            sAFTPT10301GeralToolStripMenuItem.Checked = true;
            versao_saft = "xsd_03_geral";
            ns_xsd = "urn:OECD:StandardAuditFile-Tax:PT_1.03_01";
        }

        private void sAFTPT10301SimplificadoToolStripMenuItem_Click(object sender, EventArgs e)
        {
            esconde_todas_versoes();
            sAFTPT10301SimplificadoToolStripMenuItem.Checked = true;
            versao_saft = "xsd_03_simplificado";
            ns_xsd = "urn:OECD:StandardAuditFile-Tax:PT_1.03_01";
        }

        private void limpa_datagridviews()
        {
            dataGridView2.DataSource = null;
            dataGridView1.DataSource = null;
            dataGridView4.DataSource = null;
        }

        private void treeView1_NodeMouseClick(object sender, TreeNodeMouseClickEventArgs e)
        {
            if (e.Node.Name.ToString() == "Node0")
            {
                mostra_o_que = "Tabelas";
                limpa_datagridviews();
            }
            else if (e.Node.Name.ToString() == "Node1")
            {
                mostra_o_que = "Artigos";
                limpa_datagridviews();
                try
                {
                    dataGridView2.DataSource = artigos.dt_artigos;
                }
                catch { }
            }
            else if (e.Node.Name.ToString() == "Node2")
            {
                mostra_o_que = "Clientes";
                limpa_datagridviews();
                try
                {
                    dataGridView2.DataSource = clientes.dt_clientes;
                    dataGridView2.Columns[0].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[1].Width = Convert.ToInt32(this.Width * 0.07) - 20;
                    dataGridView2.Columns[2].Width = Convert.ToInt32(this.Width * 0.2) - 20;
                    dataGridView2.Columns[3].Width = Convert.ToInt32(this.Width * 0.28) - 20;
                    dataGridView2.Columns[4].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[5].Width = Convert.ToInt32(this.Width * 0.11) - 20;
                    dataGridView2.Columns[6].Width = Convert.ToInt32(this.Width * 0.07) - 20;
                    dataGridView2.Columns[7].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[8].Width = Convert.ToInt32(this.Width * 0.08) - 20;
                }
                catch { }

            }
            else if (e.Node.Name.ToString() == "Node3")
            {
                mostra_o_que = "Documentos";
                limpa_datagridviews();
                try
                {
                    dataGridView2.DataSource = documentos.dt_documentos;
                    dataGridView2.Columns[0].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[1].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[2].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[3].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[4].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[5].Width = Convert.ToInt32(this.Width * 0.15) - 20;
                    dataGridView2.Columns[6].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[7].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[8].Width = Convert.ToInt32(this.Width * 0.08) - 20;
                    dataGridView2.Columns[9].Width = Convert.ToInt32(this.Width * 0.1) - 20;
                    dataGridView2.Columns[10].Width = Convert.ToInt32(this.Width * 0.11) - 20;
                    dataGridView2.Columns[11].Visible = false;

                    dataGridView2.Columns[6].ValueType = typeof(double);
                    dataGridView2.Columns[7].ValueType = typeof(double);
                    dataGridView2.Columns[8].ValueType = typeof(double);

                    carrega_linhas_documentos();

                }
                catch { }
            }
            else if (e.Node.Name.ToString() == "Node4")
            {
                mostra_o_que = "Fornecedores";
                limpa_datagridviews();
            }
            else if (e.Node.Name.ToString() == "Node5")
            {
                mostra_o_que = "Taxas IVA";
                limpa_datagridviews();
            }
        }

        private void carrega_linhas_documentos()
        {
            string cur_index = dataGridView2.CurrentRow.Cells[12].Value.ToString();

            dataGridView1.DataSource = documentos.get_dt_linhas(cur_index);
            dataGridView1.Columns[0].Visible = false;
            dataGridView1.Columns[1].Width = Convert.ToInt32(this.Width * 0.12) - 20;
            dataGridView1.Columns[2].Width = Convert.ToInt32(this.Width * 0.25) - 20;
            dataGridView1.Columns[3].Width = Convert.ToInt32(this.Width * 0.07) - 20;
            dataGridView1.Columns[4].Width = Convert.ToInt32(this.Width * 0.07) - 20;
            dataGridView1.Columns[5].Width = Convert.ToInt32(this.Width * 0.09) - 20;
            dataGridView1.Columns[6].Width = Convert.ToInt32(this.Width * 0.09) - 20;
            dataGridView1.Columns[7].Width = Convert.ToInt32(this.Width * 0.07) - 20;
            dataGridView1.Columns[8].Width = Convert.ToInt32(this.Width * 0.06) - 20;
            dataGridView1.Columns[9].Width = Convert.ToInt32(this.Width * 0.06) - 20;
            dataGridView1.Columns[10].Width = Convert.ToInt32(this.Width * 0.06) - 20;
            dataGridView1.Columns[11].Width = Convert.ToInt32(this.Width * 0.06) - 20;
        }
        private void carrega_cliente_documentos()
        {
            string cur_index = dataGridView2.CurrentRow.Cells[6].Value.ToString();

            dataGridView4.DataSource = clientes.get_dt_cliente(cur_index);
            dataGridView4.Columns[0].Width = Convert.ToInt32(this.Width * 0.07) - 20;
            dataGridView4.Columns[1].Width = Convert.ToInt32(this.Width * 0.24) - 20;
        }

        private void dataGridView2_SelectionChanged(object sender, EventArgs e)
        {

            if (dataGridView2.CurrentRow != null)
            {
                if (mostra_o_que == "Documentos")
                {
                    try
                    {
                        carrega_linhas_documentos();
                    }
                    catch { }
                    try
                    {
                        carrega_cliente_documentos();
                    }
                    catch { }
                }
            }
        }

        private void despejarLinhasToolStripMenuItem_Click(object sender, EventArgs e)
        {
            documentos.linhastoexcel(this);
        }

        
    }
}
