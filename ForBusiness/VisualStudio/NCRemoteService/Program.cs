using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.Net.Sockets;
using System.Threading;
using Newtonsoft.Json;
using System.IO;
using System.Security.Cryptography;
using System.Text.RegularExpressions;

namespace NCRemoteService
{
    class Program
    {
        static Socket listener;
        static Socket clientSocket;
        static byte[] clientBuffer = new byte[1024];

        static void Main(string[] args)
        {
            listener = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.IP);
            listener.Bind(new IPEndPoint(IPAddress.Any, 4444));
            listener.Listen(100);

            listener.BeginAccept(new AsyncCallback(onClientConnect), null);
            while(true) {
            }
        }

        static void onClientConnect(IAsyncResult ar)
        {
            clientSocket = listener.EndAccept(ar);
            clientSocket.BeginReceive(clientBuffer, 0, 1024, 0, new AsyncCallback(DoShake), null);
        }

        static string ComputeWebSocketHandshakeSecurityHash09(String secWebSocketKey)
        {
            const String MagicKEY = "258EAFA5-E914-47DA-95CA-C5AB0DC85B11";
            String secWebSocketAccept = String.Empty;
            String ret = secWebSocketKey + MagicKEY;
            SHA1 sha = new SHA1CryptoServiceProvider();
            byte[] sha1Hash = sha.ComputeHash(Encoding.ASCII.GetBytes(ret));
            secWebSocketAccept = Convert.ToBase64String(sha1Hash);
            return secWebSocketAccept;
        }

        static void DoShake(IAsyncResult ar)
        {
            Console.WriteLine("DoShake");
            int receivedByteCount = clientSocket.EndReceive(ar);
            var utf8_handshake = Encoding.UTF8.GetString(clientBuffer, 0, clientBuffer.Length);
            string[] handshakeText = utf8_handshake.Split(new string[] { Environment.NewLine }, StringSplitOptions.RemoveEmptyEntries);
            string key = "";
            string accept = "";

            foreach (string line in handshakeText)
            {
                if (line.Contains("Sec-WebSocket-Key:"))
                {
                    key = line.Substring(line.IndexOf(":") + 2);
                }
            }

            Console.WriteLine(key);

            if (key != "")
            {
                accept = ComputeWebSocketHandshakeSecurityHash09(key);
            }

            Console.WriteLine(accept);

            var stringShake = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" +
                              "Upgrade: WebSocket\r\n" +
                              "Connection: Upgrade\r\n";

            stringShake += "Sec-WebSocket-Accept: " + accept + "\r\n" + "\r\n";

            Console.WriteLine(stringShake);

            byte[] response = Encoding.UTF8.GetBytes(stringShake);
            clientSocket.Send(response);
        }
    }
}
