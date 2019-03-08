using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO.Ports;
using System.Diagnostics;
using System.Windows.Forms;
using System.Threading;

namespace ReadInputRFID
{
    class Program
    {
        public static string textread = "";

        static void Main(string[] args)
        {

            SerialPort RFID = new SerialPort("COM7");
            RFID.BaudRate = 9600;
            RFID.Parity = Parity.None;
            RFID.StopBits = StopBits.One;
            RFID.DataBits = 8;
            RFID.Handshake = Handshake.None;
            RFID.DtrEnable = true;

            RFID.Open();
            RFID.DataReceived += new SerialDataReceivedEventHandler(DataReceivedHandler);

            Console.WriteLine("Press any key to continue...");
            Console.WriteLine();
            Console.ReadKey();
            RFID.Close();
        }

        private static void DataReceivedHandler(object sender, SerialDataReceivedEventArgs e)
        {
            SerialPort sp = (SerialPort)sender;
            //string indata = sp.ReadExisting();
            //SendKeys.SendWait(indata);
            //Console.WriteLine(indata);
            Thread.Sleep(50);


            int dataLength = sp.BytesToRead;
            byte[] data = new byte[dataLength];
            int nbrDataRead = sp.Read(data, 0, dataLength);

            SendKeys.SendWait(BitConverter.ToString(data).Replace(" ", "").Replace("-", "") + "{ENTER}");
        }

        public static string ByteArrayToString(byte[] ba)
        {
            StringBuilder hex = new StringBuilder(ba.Length * 2);
            foreach (byte b in ba)
                hex.AppendFormat("{0:x2}", b);
            return hex.ToString();
        }
    }
}
