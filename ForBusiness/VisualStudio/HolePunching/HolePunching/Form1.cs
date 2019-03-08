using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Net;
using System.Threading;
using System.Net.Sockets;

namespace HolePunching
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
            InitializeHolePunching();
        }

        static void InitializeHolePunching() {
            IPEndPoint localpt = new IPEndPoint(IPAddress.Loopback, 6000);

            ThreadPool.QueueUserWorkItem(delegate
            {
                UdpClient udpServer = new UdpClient();
                udpServer.ExclusiveAddressUse = false;
                udpServer.Client.SetSocketOption(SocketOptionLevel.Socket, SocketOptionName.ReuseAddress, true);
                udpServer.Client.Bind(localpt);

                IPEndPoint inEndPoint = new IPEndPoint(IPAddress.Any, 0);
                Console.WriteLine("Listening on " + localpt + ".");
                byte[] buffer = udpServer.Receive(ref inEndPoint);
                Console.WriteLine("Receive from " + inEndPoint + " " + Encoding.Unicode.GetString(buffer) + ".");
            });

            Thread.Sleep(1000);

            UdpClient udpServer2 = new UdpClient();
            udpServer2.ExclusiveAddressUse = false;
            udpServer2.Client.SetSocketOption(SocketOptionLevel.Socket, SocketOptionName.ReuseAddress, true);
            udpServer2.Client.Bind(localpt);

            byte[] mensagem = Encoding.Unicode.GetBytes("Isto é só para testar");

            udpServer2.Send(mensagem, mensagem.Length, localpt);

            Console.Read();
        }
    }

}
