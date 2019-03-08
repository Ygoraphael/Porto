using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace OutlookBakCleaner
{
    class Program
    {
        static void Main(string[] args)
        {
            string path = "C:\\Users\\tml\\Desktop\\PastaTeste";
            
            if(Directory.Exists(path)) 
            {
                // This path is a directory
                ProcessDirectory(path);
            }
            else 
            {
                Console.WriteLine("{0} is not a valid file or directory.", path);
            }
        }

        public static void ProcessDirectory(string targetDirectory)
        {
            // Process the list of files found in the directory.
            string[] fileEntries = Directory.GetFiles(targetDirectory);
            List<string> filesGood = new List<string>();
            List<string> filesBad = new List<string>();

            foreach (string fileName in fileEntries)
            {
                int numChar = fileName.Trim().Length;
                if(  )

            }

            // Recurse into subdirectories of this directory.
            string[] subdirectoryEntries = Directory.GetDirectories(targetDirectory);
            foreach (string subdirectory in subdirectoryEntries)
                ProcessDirectory(subdirectory);
        }

    }
}
