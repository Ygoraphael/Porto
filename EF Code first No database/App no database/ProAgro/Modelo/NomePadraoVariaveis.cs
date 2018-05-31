using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database.Modelo
{
    [Table("tblNomePadraoVariaveis")]
    public class NOMEPADRAOVARIAVEIS
    {/*
        public NOMEPADRAOVARIAVEIS()
        {
            this.EXPERIMENTO = new HashSet<EXPERIMENTO>();
        }
        */
        [Key]
        public int CODI_PAD { get; set; }
        public string LAVAR1_PRO { get; set; }
        public string LAVAR2_PRO { get; set; }
        public string LAVAR3_PRO { get; set; }
        public string LAVAR4_PRO { get; set; }
        public string LAVAR5_PRO { get; set; }
        public string LAVAR6_PRO { get; set; }
        public string LAVAR7_PRO { get; set; }
        public string LAVAR8_PRO { get; set; }
        public string LAVAR9_PRO { get; set; }
        public string LAVARA_PRO { get; set; }

        //public virtual ICollection<EXPERIMENTO> EXPERIMENTO { get; set; }
    }
}
