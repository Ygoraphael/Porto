using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database.Modelo
{
    [Table("tblColetaGerminacao")]
    public class COLETAGERMINACAO
    {
        [Key]
        public int CODI_COG { get; set; }
        public int CODI_GER { get; set; }
        public string TRATAM_COG { get; set; }
        public string REPETI_COG { get; set; }
        public int PLAACO_COG { get; set; }
        public DateTime DATCOG_COG { get; set; }
        public int SEMGER_COG { get; set; }
        public int NAOGER_COG { get; set; }
        public Nullable<decimal> PORGER_COG { get; set; }

        //public virtual GERMINACAO GERMINACAO { get; set; }
    }
}
