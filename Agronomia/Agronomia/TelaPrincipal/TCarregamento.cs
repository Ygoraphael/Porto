using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Agronomia.TelaPrincipal
{
    public partial class TCarregamento : MetroFramework.Forms.MetroForm
    {
        public TCarregamento()
        {
            InitializeComponent();
        }
       

        private void TCarregamento_Load(object sender, EventArgs e)
        {

        }

        private void timer1_Tick(object sender, EventArgs e)
        {
           
        }

        private void progressBar1_Click(object sender, EventArgs e)
        {
            
        }

        private void metroProgressBar1_Click(object sender, EventArgs e)
        {
          
            
        }

        private void timer1_Tick_1(object sender, EventArgs e)
        {
            progressBar1.Increment(3);
            if (progressBar1.Value == 100)
            {
                timer1.Stop();
                
                Close();
            }    
        }
    }
}
