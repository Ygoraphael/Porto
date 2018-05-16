namespace App_no_database.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class InitialCreate : DbMigration
    {
        public override void Up()
        {
            CreateTable(
                "dbo.Student",
                c => new
                    {
                        StudentiId = c.Int(nullable: false, identity: true),
                        Name = c.String(),
                    })
                .PrimaryKey(t => t.StudentiId);
            
            CreateTable(
                "dbo.Subject",
                c => new
                    {
                        SubjectId = c.Int(nullable: false, identity: true),
                        Name = c.String(),
                        Student_StudentiId = c.Int(),
                    })
                .PrimaryKey(t => t.SubjectId)
                .ForeignKey("dbo.Student", t => t.Student_StudentiId)
                .Index(t => t.Student_StudentiId);
            
        }
        
        public override void Down()
        {
            DropForeignKey("dbo.Subject", "Student_StudentiId", "dbo.Student");
            DropIndex("dbo.Subject", new[] { "Student_StudentiId" });
            DropTable("dbo.Subject");
            DropTable("dbo.Student");
        }
    }
}
