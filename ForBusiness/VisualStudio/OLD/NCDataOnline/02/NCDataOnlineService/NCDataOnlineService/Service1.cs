using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Linq;
using System.ServiceProcess;
using System.Text;
using System.Management;

namespace NCDataOnlineService
{
    public partial class Service1 : ServiceBase
    {
        private Sincronizador sincronizador = new Sincronizador();

        public Service1()
        {
            InitializeComponent();
        }

        protected override void OnStart(string[] args)
        {
            int id = Process.GetCurrentProcess().Id;
            string queryString = "SELECT * FROM Win32_Service where ProcessId = " + id;
            ManagementObjectSearcher managementObjectSearcher = new ManagementObjectSearcher(queryString);
            string name = string.Empty;
            using (ManagementObjectCollection.ManagementObjectEnumerator enumerator = managementObjectSearcher.Get().GetEnumerator())
            {
                while (enumerator.MoveNext())
                {
                    ManagementObject managementObject = (ManagementObject)enumerator.Current;
                    name = managementObject["Name"].ToString();
                }
            }
            this.sincronizador.Start(name);
        }

        protected override void OnStop()
        {
            this.sincronizador.Stop();
        }
    }
}
