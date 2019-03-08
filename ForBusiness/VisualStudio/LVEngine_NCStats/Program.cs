using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Diagnostics;
using System.IO;
using System.Management;
using System.Data.SqlClient;
using System.Data;

namespace LVEngine_NCStats
{
    class Program
    {

        static PerformanceCounter cpuCounter;
        static PerformanceCounter ramCounter;
        static SqlConnection cnn;
        static SqlCommand cmd;
        static SqlCommand cmd2;
        static SqlDataReader reader;

        static void Main(string[] args)
        {
            cpuCounter = new PerformanceCounter();
            ramCounter = new PerformanceCounter("Memory", "Available MBytes");

            while (true)
            {
                connect();
                cpu_data();
                disk_data();
                ram_data();
                disconnect();
                System.Threading.Thread.Sleep(1000);
            }
        }

        static string converte_to_gb(long valor)
        {
            int Bytes = 0;
            int KiloBytes = 1;
            int MegaBytes = 2;
            int GigaBytes = 3;
            int TeraBytes = 4;

            double formatDivideBy = 1;
            double freeSpace = -1;
            formatDivideBy = Math.Pow(1024, GigaBytes);
            freeSpace = valor / formatDivideBy;

            return Math.Round(freeSpace).ToString();
        }

        static void disk_data()
        {
            DriveInfo[] drives = DriveInfo.GetDrives();
            string espaco_total = "";
            string espaco_disponivel = "";

            foreach (DriveInfo drive in drives) 
            {
                if (drive.IsReady)
                {
                    espaco_total = converte_to_gb( drive.TotalSize );
                    espaco_disponivel = converte_to_gb( drive.TotalFreeSpace );
                    
                    cmd = new SqlCommand();
                    cmd.CommandText = "SELECT COUNT(*) contagem FROM DISK WHERE Label = '" + drive.Name + "'";
                    cmd.CommandType = CommandType.Text;
                    cmd.Connection = cnn;
                    reader = cmd.ExecuteReader(CommandBehavior.CloseConnection);

                    DataTable dt = new DataTable();
                    dt.Load(reader);
                    reader.Close();

                    for (int i = 0; i < dt.Rows.Count; i++)
                    {
                        if (Convert.ToInt32(dt.Rows[i]["contagem"]) > 0)
                        {
                            cmd.Connection.Open();
                            cmd.CommandText = "UPDATE DISK SET Total = " + espaco_total + ", Available = " + espaco_disponivel + " WHERE Label = '" + drive.Name + "'";
                            cmd.ExecuteNonQuery();
                        }
                        else
                        {
                            cmd.Connection.Open();
                            cmd.CommandText = "INSERT INTO DISK (Label, Total, Available) VALUES ('" + drive.Name + "', " + espaco_total + ", " + espaco_disponivel + ")";
                            cmd.ExecuteNonQuery();
                        }
                    }
                }
                
            }
        }

        static void ram_data()
        {
            ObjectQuery wql = new ObjectQuery("SELECT * FROM Win32_OperatingSystem");
            ManagementObjectSearcher searcher = new ManagementObjectSearcher(wql);
            ManagementObjectCollection results = searcher.Get();


            foreach (ManagementObject result in results)
            {
                cmd = new SqlCommand();
                cmd.CommandText = "SELECT COUNT(*) contagem FROM RAM";
                cmd.CommandType = CommandType.Text;
                cmd.Connection = cnn;
                reader = cmd.ExecuteReader(CommandBehavior.CloseConnection);

                DataTable dt = new DataTable();
                dt.Load(reader);
                reader.Close();

                for (int i = 0; i < dt.Rows.Count; i++)
                {
                    if (Convert.ToInt32(dt.Rows[i]["contagem"]) > 0)
                    {
                        cmd.Connection.Open();
                        cmd.CommandText = "UPDATE RAM SET Total = " + (Convert.ToInt32(result["TotalVisibleMemorySize"]) / 1024) + ", Free = " + (Convert.ToInt32(result["FreePhysicalMemory"]) / 1024);
                        cmd.ExecuteNonQuery();
                    }
                    else
                    {
                        cmd.Connection.Open();
                        cmd.CommandText = "INSERT INTO RAM (Total, Free) VALUES (" + (Convert.ToInt32(result["TotalVisibleMemorySize"]) / 1024) + ", " + (Convert.ToInt32(result["FreePhysicalMemory"]) / 1024) + ")";
                        cmd.ExecuteNonQuery();
                    }
                }
            }
        }

        static void cpu_data()
        {
            try
            {
                ManagementObjectSearcher searcher =
                    new ManagementObjectSearcher("root\\CIMV2",
                    "SELECT PercentProcessorTime FROM Win32_PerfFormattedData_Counters_ProcessorInformation WHERE NOT Name='_Total' AND NOT Name='0,_Total'");

                int cur_core = 0;

                foreach (ManagementObject queryObj in searcher.Get())
                {

                    cmd = new SqlCommand();
                    cmd.CommandText = "SELECT COUNT(*) contagem FROM CPU WHERE Core = " + cur_core;
                    cmd.CommandType = CommandType.Text;
                    cmd.Connection = cnn;
                    reader = cmd.ExecuteReader(CommandBehavior.CloseConnection);

                    DataTable dt = new DataTable();
                    dt.Load(reader);
                    reader.Close();

                    for (int i = 0; i < dt.Rows.Count; i++)
                    {
                        if (Convert.ToInt32(dt.Rows[i]["contagem"]) > 0)
                        {
                            cmd.Connection.Open();
                            cmd.CommandText = "UPDATE CPU SET Percentage = " + queryObj["PercentProcessorTime"] + " WHERE Core = " + cur_core;
                            cmd.ExecuteNonQuery();
                        }
                        else
                        {
                            cmd.Connection.Open();
                            cmd.CommandText = "INSERT INTO CPU (Core, Percentage) VALUES (" + cur_core + ", " + queryObj["PercentProcessorTime"] + ")";
                            cmd.ExecuteNonQuery();
                        }
                    }
                    cur_core++;
                }
            }
            catch (ManagementException e)
            {
                Console.WriteLine("An error occurred while querying for WMI data: " + e.Message);
            }
        }

        static bool connect()
        {
            string connectionString = null;
			connectionString = "Data Source=.\\SQLNC1, 15637;Initial Catalog=LVE;User ID=tl;Password=tl123" ;
            cnn = new SqlConnection(connectionString);

            try
            {
                cnn.Open();
                Console.WriteLine ("Connection Open ! ");
                return true;
            }
            catch (Exception ex)
            {
                Console.WriteLine ("Can not open connection ! ");
            }

            return false;
        }

        static bool disconnect()
        {
            try
            {
                cnn.Close();
                return true;
            }
            catch (Exception ex)
            {
                return false;
            }
        }
    }
}
