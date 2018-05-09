using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace App_no_database
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            using (var db = new StudentContext())
            {
                var lstudent = new Student() { Name = "Ygor raphael" };

                var lmathSubj = new Subject() { Name = "Matematicas" };
                var lPortSubj = new Subject() { Name = "Portugues" };

                lstudent.Sunbjects.Add(lmathSubj);
                lstudent.Sunbjects.Add(lPortSubj);

                db.Students.Add(lstudent);
                db.SaveChanges();
            }
        }
    }
}
