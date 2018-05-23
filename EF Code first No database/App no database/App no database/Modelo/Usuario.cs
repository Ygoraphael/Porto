using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace App_no_database.Modelo
{
    [Table("tblUsuario")]
    public class USUARIO
    {
        [Key]
        public int CODI_USU { get; set; }
        public string LOGIN_USU { get; set; }
        public string SENHA_USU { get; set; }
        public string NOME_USU { get; set; }
        public string ENDERECO_USU { get; set; }
        public string TELEFONE_USU { get; set; }
        public string BAIRRO_USU { get; set; }
        public string COMPLEMENTO_USU { get; set; }
        public string CEP_USU { get; set; }
        public string ESTADO_USU { get; set; }
    }
}
