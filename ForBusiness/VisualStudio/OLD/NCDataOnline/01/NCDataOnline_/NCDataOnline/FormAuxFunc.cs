using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Drawing;

namespace NCDataOnline
{
    public static class FormAuxFunc
    {
        // Methods
        public static void ClearForm(Control control)
        {
            foreach (Control control2 in control.Controls)
            {
                string str2;
                if (control2.GetType() == typeof(TextBox))
                {
                    switch (control2.Name)
                    {
                        case "key":
                            control2.Text = "0000-0000-0000-0000";
                            goto Label_01CE;

                        case "hash":
                            control2.Text = "12345678123456781234567812345678";
                            goto Label_01CE;

                        case "intervaloQuery":
                        case "intervaloFicheiro":
                        case "intervaloFicheiroXls":
                            control2.Text = "15";
                            goto Label_01CE;

                        case "etiqueta":
                            control2.Text = "val";
                            goto Label_01CE;

                        case "val1":
                        case "val2":
                        case "val3":
                        case "val4":
                        case "val5":
                        case "val6":
                        case "val7":
                        case "val8":
                        case "val9":
                        case "val10":
                            control2.Text = control2.Name;
                            goto Label_01CE;
                    }
                    control2.Text = string.Empty;
                }

            Label_01CE:
                if (((control2.GetType() == typeof(ComboBox)) && ((str2 = control2.Name) != null)) && (str2 == "conexao"))
                {
                    ((ComboBox)control2).Items.Clear();
                }
                if (control2.GetType() == typeof(CheckBox))
                {
                    string str3;
                    if (((str3 = control2.Name) != null) && (((str3 == "activoQuery") || (str3 == "activoFicheiro")) || (str3 == "activoFicheiroXls")))
                    {
                        ((CheckBox)control2).Checked = true;
                    }
                    else
                    {
                        ((CheckBox)control2).Checked = false;
                    }
                }
                if (control2.Controls.Count > 0)
                {
                    ClearForm(control2);
                }
            }
        }

        public static void ExceptionMessage(Exception ex, Icon icon = null, FormStartPosition startPosition = FormStartPosition.CenterScreen)
        {
            DlgMessage message = new DlgMessage("Ocorreu uma excepção:" + Environment.NewLine + ex.Message + Environment.NewLine + Environment.NewLine + ex.StackTrace, "", "OK");
            if (icon == null)
            {
                message.ShowInTaskbar = false;
            }
            else
            {
                message.Icon = icon;
                message.ShowInTaskbar = true;
                message.StartPosition = startPosition;
            }
            message.ShowDialog();
        }

        public static ListBox GetSelectedTabListBox(TabControl tabControl)
        {
            new ListBox();
            foreach (Control control in tabControl.SelectedTab.Controls)
            {
                if (control.GetType() == typeof(ListBox))
                {
                    return (ListBox)control;
                }
            }
            return null;
        }

        public static void UpdateConnectionComboBox(ListBox connections, ComboBox conexao)
        {
            foreach (object obj2 in connections.Items)
            {
                if (!conexao.Items.Contains(obj2))
                {
                    conexao.Items.Add(obj2);
                }
            }
            if (conexao.Items.Count > connections.Items.Count)
            {
                List<object> list = new List<object>();
                foreach (object obj3 in conexao.Items)
                {
                    if (!connections.Items.Contains(obj3))
                    {
                        list.Add(obj3);
                    }
                }
                foreach (object obj4 in list)
                {
                    conexao.Items.Remove(obj4);
                }
            }
            if ((conexao.Items.Count > 0) && (conexao.SelectedIndex == -1))
            {
                conexao.SelectedIndex = 0;
            }
        }
    }


}
