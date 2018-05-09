using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database
{
    class ModelBD
    {
    }

    public class Student
    {
        public int StudentiId { get; set; }
        public string Name { get; set; }

        public virtual List<Subject> Sunbjects { get; set; }

        public Student()
        {
            this.Sunbjects = new List<Subject>();
        }
    }

    public class Subject
    {
        public int SubjectId { get; set; }
        public string Name { get; set; }

        public virtual Student Student { get; set; }
    }

    class StudentContext : DbContext
    {
        public DbSet<Student> Students { get; set; }
        public DbSet<Subject> Subjects { get; set; }
    }

}
