using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Google.GData.Calendar;
using Google.GData.Extensions;

namespace NCGoogleOutlookSync
{
    class Impegno
    {
        public DateTime _start;
        public DateTime _end;
        public string _title;
        public string _description;
        public string _uri;

        public Impegno(DateTime start, DateTime end, string title, string description, string uri)
        {
            _start = start;
            _end = end;
            _title = title;
            _description = description;
            _uri = uri;
        }
    }

    class Program
    {
        static void Main(string[] args)
        {
            EventQuery query = new EventQuery();
            CalendarService service = new CalendarService("appName");

            service.setUserCredentials("tmcloureiro@gmail.com", "pw");
            service.QueryClientLoginToken();

            query.Uri = new Uri("http://www.google.com/calendar/feeds/default/private/full");
            query.StartTime = DateTime.Now.AddDays(-31);
            query.EndTime = DateTime.Now.AddMonths(12);
            query.ExtraParameters = "max-results=100000";

            EventFeed calFeed = service.Query(query) as EventFeed;
            DateTime[] events = new DateTime[calFeed.Entries.Count];

            Console.WriteLine("***Eventos("+ calFeed.Entries.Count.ToString() + ")***");
            foreach(EventEntry entry in calFeed.Entries) 
            {
                foreach (When w in entry.Times)
                {
                    Console.WriteLine("--------");
                    Console.WriteLine(entry.Title.Text);
                    Console.WriteLine(w.StartTime);
                    Console.WriteLine(w.EndTime);
                    Console.WriteLine("--------");
                }
            }

            Console.WriteLine("***Eventos***");
            Console.WriteLine("Prima enter para encerrar");
            Console.Read();
        }
    }
}
