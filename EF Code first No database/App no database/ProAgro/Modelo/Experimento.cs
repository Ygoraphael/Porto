using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database.Modelo
{
    [Table("tblExperimento")]
    public class EXPERIMENTO
    {
        public EXPERIMENTO()
        {
            COLETAEXPERIMENTOs = new List<COLETAEXPERIMENTO>();
            //this.COMPETICAO = new HashSet<COMPETICAO>();
          //  this.GERMINACAO = new HashSet<GERMINACAO>();
        }
        [Key]
        public int CODI_EXP { get; set; }
        public int CODI_PRO { get; set; }
        public string CODI_COM { get; set; }
        public Nullable<int> NUMTRA_EXP { get; set; }
        public Nullable<int> NUMREP_EXP { get; set; }
        public Nullable<System.DateTime> DATINI_EXP { get; set; }
        public Nullable<decimal> DIAVAS_EXP { get; set; }
        public string DESTRA_EXP { get; set; }
        public int CODI_PAD { get; set; }
        public string EXPFIN_EXP { get; set; }
        public string TIPTRA_EXP { get; set; }
        public Nullable<decimal> PEIEA1_EXP { get; set; }
        public Nullable<decimal> PEIEA2_EXP { get; set; }
        public Nullable<decimal> PEIEA3_EXP { get; set; }
        public Nullable<decimal> PEQET1_EXP { get; set; }
        public Nullable<decimal> PEQET2_EXP { get; set; }
        public Nullable<decimal> PEQET3_EXP { get; set; }

        public virtual List<COLETAEXPERIMENTO> COLETAEXPERIMENTOs { get; set; }
        //public virtual ICollection<COMPETICAO> COMPETICAO { get; set; }
        //public virtual NOMEPADRAOVARIAVEIS NOMEPADRAOVARIAVEIS { get; set; }
       // public virtual PROPRIEDADE PROPRIEDADE { get; set; }
        //public virtual ICollection<GERMINACAO> GERMINACAO { get; set; }
    }
}
