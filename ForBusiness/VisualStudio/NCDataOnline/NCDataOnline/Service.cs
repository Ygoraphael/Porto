using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.ServiceProcess;
using System.Diagnostics;


namespace NCDataOnline
{
    public static class Service
    {
        // Methods
        public static bool Install(string name, string info, string executavel)
        {
            if (ServiceController.GetServices().FirstOrDefault<ServiceController>(s => (s.ServiceName == name)) == null)
            {
                Process.Start("cmd.exe", "/C install \"" + executavel + "\" \"" + name + "\" \"" + info + "\"");
                return true;
            }
            return false;
        }

        public static bool Start(string name)
        {
            if (ServiceController.GetServices().FirstOrDefault<ServiceController>(s => (s.ServiceName == name)) != null)
            {
                Process.Start("cmd.exe", "/C sc start \"" + name + "\"");
                return true;
            }
            return false;
        }

        public static bool State(string name, out string state)
        {
            state = string.Empty;
            if (ServiceController.GetServices().FirstOrDefault<ServiceController>(s => (s.ServiceName == name)) != null)
            {
                ServiceController controller = new ServiceController(name);
                state = controller.Status.ToString();
                return true;
            }
            return false;
        }

        public static bool Stop(string name)
        {
            if (ServiceController.GetServices().FirstOrDefault<ServiceController>(s => (s.ServiceName == name)) != null)
            {
                Process.Start("cmd.exe", "/C sc stop \"" + name + "\"");
                return true;
            }
            return false;
        }

        public static bool Uninstall(string name, string executavel)
        {
            if ((ServiceController.GetServices().FirstOrDefault<ServiceController>(s => (s.ServiceName == name)) != null) && Stop(name))
            {
                Process.Start("cmd.exe", "/C uninstall \"" + executavel + "\" \"" + name + "\"");
                return true;
            }
            return false;
        }
    }


}
