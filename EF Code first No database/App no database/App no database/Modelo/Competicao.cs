using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database.Modelo
{
    [Table("tblCompeticao")]
    public class COMPETICAO
    {
        [Key]
        public int CODI_COM { get; set; }
        public int CODI_CUL { get; set; }
        public string NOMECO_COM { get; set; }
        public int CODI_EXP { get; set; }

        //public virtual CULTURA CULTURA { get; set; }
        //public virtual EXPERIMENTO EXPERIMENTO { get; set; }
    }
}
