using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace EOR_DRIS
{
    public partial class dris_optimizacao : Form
    {
        dris DrisMethod;
        int amostra_dris_optimizar = 0;
        string[] dris_limites = {"-1,0", "-1,5", "-2,0", "-2,5", "-3,0", "-3,5", "-4,0", "-4,5", "-5,0", "-5,5", "-6,0", "-6,5", "-7,0", "-7,5", "-8,0"};
        

        public dris_optimizacao(ComboBox amostra_combobox, dris DrisMethodRef)
        {
            InitializeComponent();
            this.MinimumSize = new Size(863, 600);
            this.MaximumSize = new Size(863, 600);
            this.CenterToScreen();
            //imagem de fundo
            this.BackgroundImage = Properties.Resources.bg;

            //carrega dados da amostra
            amostra_dris_optimizar = amostra_combobox.SelectedIndex;
            DrisMethod = DrisMethodRef;
            DrisMethod.carrega_dados_amostra_recomendacao(amostra_dris_optimizar, dris_recomendacao, dris_recomendacao_sensibilidade, dris_recomendacao_max_min, dris_optimizacao_ibn, grafico_optimizacao_dris, dris_amostra_dados, dg_cores);

        }

        private void dris_recomendacao_sair_Click(object sender, EventArgs e)
        {
            DrisMethod.copy_tmp_amostra_data_to_amostra_data(amostra_dris_optimizar);
            this.Close();
        }

        //botao para calcular os valores optimos
        private void dris_recomendacao_calcular_Click(object sender, EventArgs e)
        {
            DrisMethod.copy_tmp_amostra_data_to_amostra_data(amostra_dris_optimizar);
            DrisMethod.calcula_ibn_optimo(dris_recomendacao_sensibilidade, dris_recomendacao_max_min, amostra_dris_optimizar, grafico_optimizacao_dris2, dris_recomendacao, dris_optimizacao_ibn, dris_valores_adicionar, dris_amostra_dados, tb_ind_dris_lim.Text);
        }

        private void dris_recomendacao_gravar_Click(object sender, EventArgs e)
        {
            DrisMethod.amostras_calculadas[amostra_dris_optimizar] = "1";
            DrisMethod.copy_amostra_data_to_tmp_amostra_data(amostra_dris_optimizar);
            DrisMethod.save_sensibilidade(dris_recomendacao_sensibilidade, amostra_dris_optimizar);
            this.Close();
        }

        private void dris_recomendacao_sensibilidade_CellEndEdit(object sender, DataGridViewCellEventArgs e)
        {
            int number = 0;
            double number2 = 0;

            DataGridViewCell cell = dris_recomendacao_sensibilidade.Rows[e.RowIndex].Cells[e.ColumnIndex];
            string cell_value = cell.Value.ToString().Replace(".", ",");

            if (int.TryParse(cell_value, out number))
            {
                cell.Value = Convert.ToInt32(number).ToString();
            }
            else if (double.TryParse(cell_value, out number2))
            {
                cell.Value = Convert.ToDouble(number2).ToString();
            }
            else
            {
                cell.Value = "";
            }
        }

        private void tb_dris_lim_ValueChanged(object sender, EventArgs e)
        {
            tb_ind_dris_lim.Text = dris_limites[tbar_dris_lim.Value];
        }

        private void dris_recomendacao_max_min_CellEndEdit(object sender, DataGridViewCellEventArgs e)
        {
            int number = 0;
            double number2 = 0;

            DataGridViewCell cell = dris_recomendacao_max_min.Rows[e.RowIndex].Cells[e.ColumnIndex];
            string cell_value = cell.Value.ToString().Replace(".", ",");

            if (int.TryParse(cell_value, out number))
            {
                cell.Value = Convert.ToInt32(number).ToString();
            }
            else if (double.TryParse(cell_value, out number2))
            {
                cell.Value = Convert.ToDouble(number2).ToString();
            }
            else
            {
                cell.Value = "";
            }
        }

        private void dg_cores_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (e.Value == null)
            {
                return;
            }
            //1-vermelho; 2-verde; 3-amarelo
            string[] lista = e.Value.ToString().Split(';');

            if (lista[1] == "1")
            {
                e.Value = lista[0];
                e.CellStyle.BackColor = Color.Red;
            }
            else if (lista[1] == "2")
            {
                e.Value = lista[0];
                e.CellStyle.BackColor = Color.Green;
            }
            else if (lista[1] == "3")
            {
                e.Value = lista[0];
                e.CellStyle.BackColor = Color.Yellow;
            }
        }

        private void dg_cores_SelectionChanged(object sender, EventArgs e)
        {
            dg_cores.ClearSelection();
        }

    }
}
