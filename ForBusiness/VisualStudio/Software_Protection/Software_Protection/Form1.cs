using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;
using System.Management;

namespace Software_Protection
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click_1(object sender, EventArgs e)
        {

            //devices id
            List<string> lista_devices = new List<string>();

            ManagementObjectSearcher mosDisks = new ManagementObjectSearcher("SELECT * FROM Win32_DiskDrive");
            int i = 0;
            int j = 0;
            DataTable dt = new DataTable();

            foreach (ManagementObject moDisk in mosDisks.Get())
            {
                foreach (PropertyData prop in moDisk.Properties)
                {
                    dt.Columns.Add(new DataColumn(prop.Name, typeof(String)));
                }
                break;
            }

            foreach (ManagementObject moDisk in mosDisks.Get())
            {
                j = 0;
                dt.Rows.Add("");
                foreach (PropertyData prop in moDisk.Properties)
                {

                    if(prop.Name == "PNPDeviceID")
                    {
                        lista_devices.Add(prop.Value.ToString());
                    }

                    dt.Rows[i][j] = prop.Value;
                    j++;
                }
                i++;
            }

            dataGridView1.DataSource = dt;


            ManagementObjectSearcher s1 = new ManagementObjectSearcher("select * from Win32_logicaldisk WHERE VolumeName = 'NCSECURITYPEN'");
            int x = 0;
            int y = 0;

            DataTable dt1 = new DataTable();

            foreach (ManagementObject s1s in s1.Get())
            {
                foreach (PropertyData prop1 in s1s.Properties)
                {
                    dt1.Columns.Add(new DataColumn(prop1.Name, typeof(String)));
                }
                break;
            }

            foreach (ManagementObject s1s in s1.Get())
            {
                y = 0;
                dt1.Rows.Add("");
                foreach (PropertyData prop1 in s1s.Properties)
                {
                    dt1.Rows[x][y] = prop1.Value;
                    y++;
                }
                x++;
            }

            dataGridView2.DataSource = dt1;

            //buscar a letra
            string letra_pen = "";

            foreach (ManagementObject s1s in s1.Get())
            {
                foreach (PropertyData prop1 in s1s.Properties)
                {
                    if (prop1.Name == "DeviceID")
                    {
                        letra_pen = prop1.Value.ToString();
                    }
                }
                break;
            }

            if (letra_pen == "")
            {
                textBox5.Text = "Ficha Não Encontrada";
                return;
            }

            textBox1.Text = letra_pen;

            //abrir ficheiro
            string caminho_ficheiro = letra_pen + "\\ncsecurity.txt";
            Console.WriteLine(caminho_ficheiro);
            textBox2.Text = caminho_ficheiro;

            FileStream fileStream = new FileStream(@"" + caminho_ficheiro, FileMode.Open);
            try
            {
                byte[] bytes = new byte[fileStream.Length];
                int numBytesToRead = (int)fileStream.Length;
                int numBytesRead = 0;

                while (numBytesToRead > 0)
                {
                    int n = fileStream.Read(bytes, numBytesRead, numBytesToRead);

                    if (n == 0)
                        break;

                    numBytesRead += n;
                    numBytesToRead -= n;
                }
                numBytesToRead = bytes.Length;

                textBox3.Text = System.Text.Encoding.UTF8.GetString(bytes);
            }
            finally
            {
                fileStream.Close();
            }

            //mostra devices
            textBox4.Text = "";
            string[] dev_ids = new string[lista_devices.Count];
            i = 0;
            string[] words = null;

            dt = new DataTable();
            dt.Columns.Add(new DataColumn("Devices ID", typeof(String)));

            foreach (string dev in lista_devices)
            {
                words = dev.Split('\\');
                dt.Rows.Add("");
                dev_ids[i] = words[words.Length - 1];
                dt.Rows[i][0] = dev_ids[i];
                i++;
            }

            dataGridView3.DataSource = dt;
            dataGridView3.Columns[0].Width = 230;

            foreach (string dev in dev_ids)
            {
                if (dev == textBox3.Text)
                {
                    textBox4.Text = dev;
                    textBox5.Text = "Ficha Validada";
                    break;
                }

                textBox5.Text = "Ficha Não Validada";
            }
        }

    }
}
