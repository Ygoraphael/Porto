using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Data.SQLite;
using System.IO;

namespace XDArtigosPrecos
{
    public partial class Form1 : Form
    {
        OpenFileDialog openFileDialog1 = new OpenFileDialog();
        SaveFileDialog savefile = new SaveFileDialog();
        SQLiteConnection m_dbConnection;
        SQLiteCommand command;
        string sql;
        SQLiteDataReader reader;
        StringBuilder csv;
        StreamReader Sreader;

        public Form1()
        {
            InitializeComponent();
        }

        //seleccionar ficheiro sqlite
        private void button1_Click(object sender, EventArgs e)
        {
            openFileDialog1.Filter = "Ficheiro SQLite (*.db)|*.db";
            DialogResult result = openFileDialog1.ShowDialog();
            if (result == DialogResult.OK)
            {
                string file = openFileDialog1.FileName;
                textBox1.Text = file;
            }
        }

        //seleccionar ficheiro Excel
        private void button2_Click(object sender, EventArgs e)
        {
            savefile.FileName = "artigosxd.csv";
            savefile.Filter = "Ficheiro Excel (*.csv)|*.csv";

            if (savefile.ShowDialog() == DialogResult.OK)
            {
                textBox2.Text = savefile.FileName;
            }
        }

        //Criar Excel
        private void button3_Click(object sender, EventArgs e)
        {
            if (textBox1.Text.Trim().Length > 0 && textBox2.Text.Trim().Length > 0)
            {
                m_dbConnection = new SQLiteConnection("Data Source=" + textBox1.Text + ";Version=3;");
                m_dbConnection.Open();
                sql = "select Id, Description, ShortName1, RetailPrice1 from Items";
                command = new SQLiteCommand(sql, m_dbConnection);
                reader = command.ExecuteReader();
                csv = new StringBuilder();
                var newLine = string.Format("{0};{1};{2};{3}", "Id", "Description", "ShortName1", "RetailPrice1");
                csv.AppendLine(newLine);

                while (reader.Read())
                {
                    newLine = string.Format("{0};{1};{2};{3}", reader["Id"], reader["Description"], reader["ShortName1"], reader["RetailPrice1"]);
                    csv.AppendLine(newLine);
                }

                File.WriteAllText(textBox2.Text, csv.ToString(), Encoding.UTF8);
                MessageBox.Show("Ficheiro Excel criado com sucesso!");
            }
            else 
            {
                MessageBox.Show("Tem de indicar o qual o ficheiro Excel e qual o ficheiro SQLite");
            }
        }

        //Atualizar Artigos
        private void button4_Click(object sender, EventArgs e)
        {
            if (textBox1.Text.Trim().Length > 0 && textBox2.Text.Trim().Length > 0)
            {
                m_dbConnection = new SQLiteConnection("Data Source=" + textBox1.Text + ";Version=3;");
                m_dbConnection.Open();
                Sreader = new StreamReader(File.OpenRead(@"" + textBox2.Text));
                while (!Sreader.EndOfStream)
                {
                    var line = Sreader.ReadLine();
                    var values = line.Split(';');

                    sql = string.Format("update Items set RetailPrice1={0} where Id={1}", values[3].Replace(',', '.'), values[0]);
                    Console.WriteLine(sql);
                    command = new SQLiteCommand(sql, m_dbConnection);
                    command.ExecuteNonQuery();
                }
                Sreader.Close();
                MessageBox.Show("Base Dados SQLite atualizada com sucesso!");
            }
            else
            {
                MessageBox.Show("Tem de indicar o qual o ficheiro Excel e qual o ficheiro SQLite");
            }
        }
    }
}
