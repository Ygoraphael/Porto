namespace App_no_database.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class ADICIONATELEFONEESTUDANTE : DbMigration
    {
        public override void Up()
        {
            AddColumn("dbo.Student", "Telefone", c => c.String());
        }
        
        public override void Down()
        {
            DropColumn("dbo.Student", "Telefone");
        }
    }
}
