using App_no_database.Modelo;
using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database.DBSET
{
    class ProAgroContext : DbContext
    {
        public ProAgroContext() : base("ProAgro") { }
        public DbSet<COLETAEXPERIMENTO> COLETAEXPERIMENTOs { get; set; }
        public DbSet<COLETAGERMINACAO> COLETAGERMINACAOs { get; set; }
        public DbSet<COMPETICAO> COMPETICAOs { get; set; }
        public DbSet<CULTURA> CULTURAs { get; set; }
        public DbSet<EXPERIMENTO> EXPERIMENTOs { get; set; }
        public DbSet<GERMINACAO> GERMINACAOs { get; set; }
        public DbSet<NOMEPADRAOVARIAVEIS> NOMEPADRAOVARIAVEISs { get; set; }
        public DbSet<PROPRIEDADE> PROPRIEDADEs { get; set; }
        public DbSet<USUARIO> USUARIOs { get; set; }
    }
    
}
