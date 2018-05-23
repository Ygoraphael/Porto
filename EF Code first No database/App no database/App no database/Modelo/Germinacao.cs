using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database.Modelo
{
    [Table("tblGerminacao")]
    public partial class GERMINACAO
    {        /*
        public GERMINACAO()
        {
            this.COLETAGERMINACAO = new HashSet<COLETAGERMINACAO>();
        }*/
        [Key]
        public int CODI_GER { get; set; }
        public Nullable<int> CODI_EXP { get; set; }
        public int CODI_USU { get; set; }
        public string CODI_RES { get; set; }
        public int CODI_CUL { get; set; }
        public string ESPECI_GER { get; set; }
        public System.DateTime DATAMO_GER { get; set; }
        public int NUMTRA_GER { get; set; }
        public int NUMREP_GER { get; set; }
        public decimal PEPAGE_GER { get; set; }
        public decimal TEMPET_GER { get; set; }
        public Nullable<decimal> QUAGUA_GER { get; set; }
        public int QSETOT_GER { get; set; }
        public int QSEREP_GER { get; set; }

        //public virtual ICollection<COLETAGERMINACAO> COLETAGERMINACAO { get; set; }
        //public virtual CULTURA CULTURA { get; set; }
        //public virtual EXPERIMENTO EXPERIMENTO { get; set; }
    }
}
