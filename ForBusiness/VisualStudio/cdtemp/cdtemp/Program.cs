using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Runtime.InteropServices;

namespace cdtemp
{
    class Program
    {

        [DllImport("winmm.dll")]
        static extern Int32 mciSendString(String command, StringBuilder buffer, Int32 bufferSize, IntPtr hwndCallback);

        static void Main(string[] args)
        {

            while (true)
            {
                mciSendString("set CDAudio door open", null, 0, IntPtr.Zero);
                System.Threading.Thread.Sleep(5000);
                mciSendString("set CDAudio door closed", null, 0, IntPtr.Zero);
            }
        }
    }
}

