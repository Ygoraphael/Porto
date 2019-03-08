using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace NCDataOnline
{
    public class Title
    {
        // Fields
        private string appTitle = string.Empty;

        // Methods
        public string GetAppTitle(Config appConfig)
        {
            string appTitle = this.appTitle;
            if (!(appConfig.GetName() != string.Empty))
            {
                return appTitle;
            }
            string str2 = " - ";
            if (appConfig.HasChanges())
            {
                str2 = " (modificado) - ";
            }
            return (appConfig.GetName() + str2 + appTitle);
        }

        public void SetAppTitle(string text)
        {
            this.appTitle = text;
        }
    }


}
