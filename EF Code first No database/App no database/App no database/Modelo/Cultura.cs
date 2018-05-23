using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database.Modelo
{
    [Table("tblCultura")]
    public class CULTURA
    {
       /* public CULTURA()
        {
            this.COMPETICAO = new HashSet<COMPETICAO>();
            this.GERMINACAO = new HashSet<GERMINACAO>();
        }
        */
        [Key]
        public int CODI_CUL { get; set; }
        public string NOMCUL_CUL { get; set; }
        public string CULTIV_CUL { get; set; }
        public string LOTECU_CUL { get; set; }
        public Nullable<decimal> GERMIN_CUL { get; set; }
        public Nullable<decimal> PUREZA_CUL { get; set; }
        public Nullable<System.DateTime> VALIDA_CUL { get; set; }
        public string SAFRAC_CUL { get; set; }
        public Nullable<decimal> M100SE_CUL { get; set; }
        public string TRAQUI_CUL { get; set; }
        public string PROSEM_CUL { get; set; }
        public string OBSERV_CUL { get; set; }
                
        //public virtual ICollection<COMPETICAO> COMPETICAO { get; set; }
        //public virtual ICollection<GERMINACAO> GERMINACAO { get; set; }
    }
}
