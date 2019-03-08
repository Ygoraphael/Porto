using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Management;
using System.Security.Cryptography;
using System.Security;
using System.Collections;
using System.IO;
using System.Globalization;

namespace EOR_DRIS
{
    public partial class License : Form
    {
        public License()
        {
            InitializeComponent();
            this.ActiveControl = textBox10;
        }

        private static string fingerPrint = string.Empty;
        public static string Value()
        {
            if (string.IsNullOrEmpty(fingerPrint))
            {
                fingerPrint = GetHash("CPU >> " + cpuId() + "\nBIOS >> " + 
			    biosId() + "\nBASE >> " + baseId()
                +"\nDISK >> "+ diskId() + "\nVIDEO >> " + 
			    videoId() +"\nMAC >> "+ macId() );
            }
            return fingerPrint;
        }
        private static string GetHash(string s)
        {
            MD5 sec = new MD5CryptoServiceProvider();
            ASCIIEncoding enc = new ASCIIEncoding();
            byte[] bt = enc.GetBytes(s);
            return GetHexString(sec.ComputeHash(bt));
        }
        private static string GetHexString(byte[] bt)
        {
            string s = string.Empty;
            for (int i = 0; i < bt.Length; i++)
            {
                byte b = bt[i];
                int n, n1, n2;
                n = (int)b;
                n1 = n & 15;
                n2 = (n >> 4) & 15;
                if (n2 > 9)
                    s += ((char)(n2 - 10 + (int)'A')).ToString();
                else
                    s += n2.ToString();
                if (n1 > 9)
                    s += ((char)(n1 - 10 + (int)'A')).ToString();
                else
                    s += n1.ToString();
                if ((i + 1) != bt.Length && (i + 1) % 2 == 0) s += "-";
            }
            return s;
        }
        #region Original Device ID Getting Code
        //Return a hardware identifier
        private static string identifier
		(string wmiClass, string wmiProperty, string wmiMustBeTrue)
        {
            string result = "";
            System.Management.ManagementClass mc = 
		new System.Management.ManagementClass(wmiClass);
            System.Management.ManagementObjectCollection moc = mc.GetInstances();
            foreach (System.Management.ManagementObject mo in moc)
            {
                if (mo[wmiMustBeTrue].ToString() == "True")
                {
                    //Only get the first one
                    if (result == "")
                    {
                        try
                        {
                            result = mo[wmiProperty].ToString();
                            break;
                        }
                        catch
                        {
                        }
                    }
                }
            }
            return result;
        }
        //Return a hardware identifier
        private static string identifier(string wmiClass, string wmiProperty)
        {
            string result = "";
            System.Management.ManagementClass mc = 
		new System.Management.ManagementClass(wmiClass);
            System.Management.ManagementObjectCollection moc = mc.GetInstances();
            foreach (System.Management.ManagementObject mo in moc)
            {
                //Only get the first one
                if (result == "")
                {
                    try
                    {
                        result = mo[wmiProperty].ToString();
                        break;
                    }
                    catch
                    {
                    }
                }
            }
            return result;
        }
        private static string cpuId()
        {
            //Uses first CPU identifier available in order of preference
            //Don't get all identifiers, as it is very time consuming
            string retVal = identifier("Win32_Processor", "UniqueId");
            if (retVal == "") //If no UniqueID, use ProcessorID
            {
                retVal = identifier("Win32_Processor", "ProcessorId");
                if (retVal == "") //If no ProcessorId, use Name
                {
                    retVal = identifier("Win32_Processor", "Name");
                    if (retVal == "") //If no Name, use Manufacturer
                    {
                        retVal = identifier("Win32_Processor", "Manufacturer");
                    }
                    //Add clock speed for extra security
                    retVal += identifier("Win32_Processor", "MaxClockSpeed");
                }
            }
            return retVal;
        }
        //BIOS Identifier
        private static string biosId()
        {
            return identifier("Win32_BIOS", "Manufacturer")
            + identifier("Win32_BIOS", "SMBIOSBIOSVersion")
            + identifier("Win32_BIOS", "IdentificationCode")
            + identifier("Win32_BIOS", "SerialNumber")
            + identifier("Win32_BIOS", "ReleaseDate")
            + identifier("Win32_BIOS", "Version");
        }
        //Main physical hard drive ID
        private static string diskId()
        {
            return identifier("Win32_DiskDrive", "Model")
            + identifier("Win32_DiskDrive", "Manufacturer")
            + identifier("Win32_DiskDrive", "Signature")
            + identifier("Win32_DiskDrive", "TotalHeads");
        }
        //Motherboard ID
        private static string baseId()
        {
            return identifier("Win32_BaseBoard", "Model")
            + identifier("Win32_BaseBoard", "Manufacturer")
            + identifier("Win32_BaseBoard", "Name")
            + identifier("Win32_BaseBoard", "SerialNumber");
        }
        //Primary video controller ID
        private static string videoId()
        {
            return identifier("Win32_VideoController", "DriverVersion")
            + identifier("Win32_VideoController", "Name");
        }
        //First enabled network card ID
        private static string macId()
        {
            return identifier("Win32_NetworkAdapterConfiguration", 
				"MACAddress", "IPEnabled");
        }
        #endregion

        private string LicExist()
        {
            string path = Application.StartupPath;
            string curFile = @"" + path + "\\lic.prop";

            return File.Exists(curFile) ? "Licença existe." : "Licença não existe.";
        }

        public Boolean LicExist_bool()
        {
            string path = Application.StartupPath;
            string curFile = @"" + path + "\\lic.prop";

            return File.Exists(curFile) ? true : false;
        }

        Dictionary<string, string> my_d = new Dictionary<string, string>()
        {
            {"!", "430"},
            {"\"", "788"},
            {"#", "625"},
            {"$", "983"},
            {"%", "343"},
            {"&", "180"},
            {"'", "538"},
            {"(", "375"},
            {")", "733"},
            {"*", "093"},
            {"+", "928"},
            {",", "288"},
            {"-", "124"},
            {".", "482"},
            {"/", "841"},
            {"0", "677"},
            {"1", "037"},
            {"2", "872"},
            {"3", "232"},
            {"4", "590"},
            {"5", "427"},
            {"6", "785"},
            {"7", "622"},
            {"8", "980"},
            {"9", "340"},
            {":", "177"},
            {";", "535"},
            {"<", "371"},
            {"=", "729"},
            {">", "090"},
            {"?", "924"},
            {"@", "284"},
            {"A", "121"},
            {"B", "479"},
            {"C", "837"},
            {"D", "674"},
            {"E", "034"},
            {"F", "869"},
            {"G", "229"},
            {"H", "587"},
            {"I", "424"},
            {"J", "782"},
            {"K", "618"},
            {"L", "976"},
            {"M", "337"},
            {"N", "173"},
            {"O", "531"},
            {"P", "368"},
            {"Q", "726"},
            {"R", "086"},
            {"S", "921"},
            {"T", "281"},
            {"U", "118"},
            {"V", "476"},
            {"W", "834"},
            {"X", "671"},
            {"Y", "031"},
            {"Z", "865"},
            {"[", "226"},
            {"\\", "584"},
            {"]", "420"},
            {"^", "778"},
            {"_", "615"},
            {"`", "973"},
            {"a", "333"},
            {"b", "170"},
            {"c", "528"},
            {"d", "365"},
            {"e", "723"},
            {"f", "083"},
            {"g", "918"},
            {"h", "278"},
            {"i", "114"},
            {"j", "473"},
            {"k", "831"},
            {"l", "667"},
            {"m", "027"},
            {"n", "862"},
            {"o", "222"},
            {"p", "580"},
            {"q", "417"},
            {"r", "775"},
            {"s", "612"},
            {"t", "970"},
            {"u", "330"},
            {"v", "167"},
            {"w", "525"},
            {"x", "361"},
            {"y", "720"},
            {"z", "080"},
            {"{", "914"},
            {"|", "274"},
            {"}", "111"},
            {"À", "469"},
            {"Á", "827"},
            {"Â", "664"},
            {"Ã", "024"},
            {"Ä", "859"},
            {"Å", "219"},
            {"Æ", "577"},
            {"Ç", "414"},
            {"È", "772"},
            {"É", "609"},
            {"Ê", "967"},
            {"Ë", "327"},
            {"Ì", "163"},
            {"Í", "521"},
            {"Î", "358"},
            {"Ï", "716"},
            {"Ð", "076"},
            {"Ñ", "911"},
            {"Ò", "271"},
            {"Ó", "108"},
            {"Ô", "466"},
            {"Õ", "824"},
            {"Ö", "661"},
            {"×", "021"},
            {"Ø", "856"},
            {"Ù", "216"},
            {"Ú", "574"},
            {"Û", "410"},
            {"Ü", "769"},
            {"Ý", "605"},
            {"Þ", "963"},
            {"ß", "323"},
            {"à", "160"},
            {"á", "518"},
            {"â", "355"},
            {"ã", "713"},
            {"ä", "073"},
            {"å", "908"},
            {"æ", "268"},
            {"ç", "105"},
            {"è", "463"},
            {"é", "821"},
            {"ê", "657"},
            {"ë", "018"},
            {"ì", "852"},
            {"í", "212"},
            {"î", "570"},
            {"ï", "407"},
            {"ð", "765"},
            {"ñ", "602"},
            {"ò", "960"},
            {"ó", "320"},
            {"ô", "157"},
            {"õ", "515"},
            {"ö", "352"},
            {"÷", "710"},
            {"ø", "070"},
            {"ù", "904"},
            {"ú", "265"},
            {"û", "101"},
            {"ü", "459"},
            {"ý", "817"},
            {"þ", "654"},
            {"ÿ", "014"},
            {" ", "052"}
        };

        private void generate_list()
        {
            Random rnd = new Random();
            int rand_int;

            for (int i = 33; i < 126; i++)
            {
                rnd = new Random();
                rand_int = rnd.Next(001, 999);

                if (!my_d.ContainsValue(rand_int.ToString()))
                {
                    my_d.Add(Convert.ToChar(i).ToString(), rand_int.ToString());
                }
                else
                {
                    i--;
                }
            }

            for (int i = 192; i < 256; i++)
            {
                rnd = new Random();
                rand_int = rnd.Next(001, 999);

                if (!my_d.ContainsValue(rand_int.ToString()))
                {
                    my_d.Add(Convert.ToChar(i).ToString(), rand_int.ToString());
                }
                else
                {
                    i--;
                }
            }

            foreach (KeyValuePair<string, string> pair in my_d)
            {
                Console.WriteLine("{\"" + pair.Key + "\", \"" + pair.Value.PadLeft(3, '0') + "\"},");
            }
        }

        private string decode_hash()
        {
            string path = Application.StartupPath;
            string curFile = @"" + path + "\\lic.prop";

            System.IO.StreamReader file = new System.IO.StreamReader(curFile);
            string line = file.ReadLine();
            string tmp = "";
            string letter;

            for (int i = 0; i < line.Length; i=i+3)
            {
                try
                {
                    letter = line[i].ToString() + line[i + 1].ToString() + line[i + 2].ToString();
                    tmp += my_d.FirstOrDefault(x => x.Value == letter).Key;
                }
                catch
                {
                    tmp += "";
                }
            }

            file.Close();
            return tmp;
        }

        public Boolean lic_is_valid()
        {
            string hard_id = Value();
            string dec_hash = decode_hash();
            string[] words = dec_hash.Split(':');

            if (words[0] == hard_id)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        private void button4_Click(object sender, EventArgs e)
        {
            //generate_list();
            textBox1.Text = Value();
            textBox3.Text = LicExist();
            if (LicExist_bool())
            {
                string dec_hash = decode_hash();

                string[] words = dec_hash.Split(':');

                if (words.Length == 2)
                {
                    textBox2.Text = words[0];
                    textBox5.Text = words[1];
                    if (textBox2.Text == textBox1.Text)
                    {
                        textBox4.Text = "Licença Válida";
                    }
                    else
                    {
                        textBox4.Text = "Licença Inválida";
                    }
                }
                else
                {
                    textBox4.Text = "Licença Inválida";
                }

            }
        }

        public string get_lic_user()
        {
            string dec_hash = decode_hash();
            string[] words = dec_hash.Split(':');

            return textBox5.Text = words[1];
        }

        private string my_encode(string code)
        {
            string hash = "";

            for (int i = 0; i < code.Length; i++)
            {
                hash += my_d[code[i].ToString()];
            }

            return hash;
        }

        private void button2_Click(object sender, EventArgs e)
        {
            string code = textBox7.Text + ":" + textBox6.Text;
            string hash = my_encode(code);
            textBox8.Text = hash;

            string path = Application.StartupPath;
            string curFile = @"" + path + "\\lic.prop";

            using (System.IO.StreamWriter file = new System.IO.StreamWriter(@"" + curFile))
            {
                file.WriteLine(hash);
            }

            textBox9.Text = "Licença Criada";
        }

        private string get_current_date_string()
        {
            string parsedDate = DateTime.Now.ToString("ddMMyy");
            return parsedDate;
        }

        private void textBox10_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == (char)13)
            {
                string cur_date = get_current_date_string();

                if (textBox10.Text == "nc123!" + cur_date)
                {
                    panel1.Visible = false;
                }
                else
                {
                    panel1.Visible = true;
                    this.Close();
                }
            }
        }
    }
}
