using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace NCDataOnlineService
{
    public class ThreadSafe
    {
        // Methods
        public static string DisableToolStripButton(ToolStrip toolStrip, ToolStripButton toolStripButton, string text)
        {
            string str = string.Empty;
            if (toolStrip.InvokeRequired)
            {
                ToolStripCallback method = new ToolStripCallback(ThreadSafe.DisableToolStripButton);
                return (toolStrip.Invoke(method, new object[] { toolStrip, toolStripButton, text }) as string);
            }
            toolStripButton.Enabled = false;
            str = toolStripButton.Text;
            toolStripButton.Text = text;
            return str;
        }

        public static string EnableToolStripButton(ToolStrip toolStrip, ToolStripButton toolStripButton, string text)
        {
            string str = string.Empty;
            if (toolStrip.InvokeRequired)
            {
                ToolStripCallback method = new ToolStripCallback(ThreadSafe.EnableToolStripButton);
                return (toolStrip.Invoke(method, new object[] { toolStrip, toolStripButton, text }) as string);
            }
            toolStripButton.Enabled = true;
            str = toolStripButton.Text;
            toolStripButton.Text = text;
            return str;
        }

        public static bool FocusControl(Control control)
        {
            if (control.InvokeRequired)
            {
                Type1Callback<Control, bool> method = new Type1Callback<Control, bool>(ThreadSafe.FocusControl);
                control.Invoke(method, new object[] { control });
            }
            else
            {
                control.Focus();
            }
            return true;
        }

        public static bool GetCheckedValue(CheckBox control)
        {
            if (control.InvokeRequired)
            {
                Type1Callback<CheckBox, bool> method = new Type1Callback<CheckBox, bool>(ThreadSafe.GetCheckedValue);
                return (bool)control.Invoke(method, new object[] { control });
            }
            return control.Checked;
        }

        public static bool GetEnableValue(CheckBox control)
        {
            if (control.InvokeRequired)
            {
                Type1Callback<CheckBox, bool> method = new Type1Callback<CheckBox, bool>(ThreadSafe.GetEnableValue);
                return (bool)control.Invoke(method, new object[] { control });
            }
            return control.Enabled;
        }

        public static string GetTextControl(Control control)
        {
            if (control.InvokeRequired)
            {
                Type1Callback<Control, string> method = new Type1Callback<Control, string>(ThreadSafe.GetTextControl);
                return (control.Invoke(method, new object[] { control }) as string);
            }
            return control.Text;
        }

        public static void SetCheckedValue(CheckBox control, bool value)
        {
            if (control.InvokeRequired)
            {
                Type2Callback<CheckBox, bool> method = new Type2Callback<CheckBox, bool>(ThreadSafe.SetCheckedValue);
                control.Invoke(method, new object[] { control, value });
            }
            else
            {
                control.Checked = value;
            }
        }

        public static void SetEnableValue(Control control, bool value)
        {
            if (control.InvokeRequired)
            {
                Type2Callback<Control, bool> method = new Type2Callback<Control, bool>(ThreadSafe.SetEnableValue);
                control.Invoke(method, new object[] { control, value });
            }
            else
            {
                control.Enabled = value;
            }
        }

        public static void SetTextControl(Control control, string value)
        {
            if (control.InvokeRequired)
            {
                Type2Callback<Control, string> method = new Type2Callback<Control, string>(ThreadSafe.SetTextControl);
                control.Invoke(method, new object[] { control, value });
            }
            else
            {
                control.Text = value;
            }
        }
    }


}
