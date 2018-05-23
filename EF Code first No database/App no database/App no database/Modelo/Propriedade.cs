using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database.Modelo
{
    [Table("tblPropriedade")]
    public class PROPRIEDADE
    {/*
        public PROPRIEDADE()
        {
            this.EXPERIMENTO = new HashSet<EXPERIMENTO>();
        }
        */
        [Key]
        public int CODI_PRO { get; set; }
        public string NOMEPR_PRO { get; set; }
        public string MUNICI_PRO { get; set; }
        public string ESTADO_PRO { get; set; }
        public string ENDERE_PRO { get; set; }
        public string COMPLE_PRO { get; set; }
        public string TELEFO_PRO { get; set; }
        public string EMAILP_PROP { get; set; }
        public string NOMRES_PRO { get; set; }
        
        //public virtual ICollection<EXPERIMENTO> EXPERIMENTO { get; set; }
    }
}
