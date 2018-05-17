using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Agronomia.view
{
    public partial class FrmLogin : Form
    {
        public Boolean Logado = false;
        public FrmLogin()
        {
            InitializeComponent();
        }

        private void btnCancelar_Click(object sender, EventArgs e)
        {
            MessageBox.Show("Deseja realmente fechar a aplicação?");
            Logado = false;
            Close();
        }

        private void btnEntrar_Click(object sender, EventArgs e)
        {
            if ((txtUsuario.Text == "") || (txtSenha.Text == ""))
            {
                MessageBox.Show("É necessário preencher usuário e senha!");
            }
            else
            {
                ProAgroEntities con = new ProAgroEntities();
                if (con != null)
                {
                    USUARIO usu = con.USUARIO.FirstOrDefault(C => C.LOGIN_USU == txtUsuario.Text && C.SENHA_USU == txtSenha.Text);
                    if (usu != null)
                    {
                        Logado = true;
                        this.Dispose();
                    }
                    else
                    {
                        MessageBox.Show("Usuário ou senha incorretos tente novamente!");
                    }
                }
                else
                {
                    MessageBox.Show("Não foi possível conectar a base de dados no momento!");
                }

            }

        }

        private void txtUsuario_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == 13)
            {
                txtSenha.Focus();
            }
        }

        private void txtSenha_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == 13)
            {
                btnEntrar.Focus();
            }
        }
    }
}
