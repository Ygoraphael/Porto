using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database.Modelo
{
    [Table("tblColetaExperimento")]
    public class COLETAEXPERIMENTO
    {
        [Key]
        public int CODI_COE { get; set; }
        public int CODI_EXP { get; set; }
        public string TRATAM_COE { get; set; }
        public string REPETI_COE { get; set; }
        public System.DateTime DATCOL_COE { get; set; }
        public string ESTADI_COE { get; set; }
        public Nullable<int> INDIUV_COE { get; set; }
        public Nullable<decimal> PRESSA_COE { get; set; }
        public Nullable<int> PONORV_COE { get; set; }
        public Nullable<decimal> TEMMAX_COE { get; set; }
        public Nullable<decimal> TEMMIN_COE { get; set; }
        public Nullable<decimal> PLUVIO_COE { get; set; }
        public Nullable<decimal> VELVEN_COE { get; set; }
        public Nullable<int> UMIDAD_COE { get; set; }
        public Nullable<decimal> TENSIO_COE { get; set; }
        public Nullable<decimal> IRRQNT_COE { get; set; }
        public string VALRE1_EXP { get; set; }
        public string VALRE2_EXP { get; set; }
        public string VALRE3_EXP { get; set; }
        public string VALRE4_EXP { get; set; }
        public string VALRE5_EXP { get; set; }
        public string VALRE6_EXP { get; set; }
        public string VALRE7_EXP { get; set; }
        public string VALRE8_EXP { get; set; }
        public string VALRE9_EXP { get; set; }
        public string VALREA_EXP { get; set; }
        public string OBSGER_COE { get; set; }

        //public virtual EXPERIMENTO EXPERIMENTO { get; set; }
    }
}
