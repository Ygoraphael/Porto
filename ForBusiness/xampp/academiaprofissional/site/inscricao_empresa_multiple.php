<?php
include 'db_config.php';

if (!isset($_SESSION['type'])) {
    if (isset($_POST['NomeEmpresa'])) {
        if (!isset($_SESSION['empresa'])) {
            $_SESSION['empresa']['NomeEmpresa'] = (isset($_POST['NomeEmpresa']) ? $_POST['NomeEmpresa'] : '');
            $_SESSION['empresa']['NIF'] = (isset($_POST['NIF']) ? $_POST['NIF'] : '');
            $_SESSION['empresa']['Morada'] = (isset($_POST['Morada']) ? $_POST['Morada'] : '');
            $_SESSION['empresa']['CodigoPostal'] = (isset($_POST['CodigoPostal']) ? $_POST['CodigoPostal'] : '');
            $_SESSION['empresa']['Localidade'] = (isset($_POST['Localidade']) ? $_POST['Localidade'] : '');
            $_SESSION['empresa']['Email'] = (isset($_POST['Email']) ? $_POST['Email'] : '');
            $_SESSION['empresa']['Telemovel'] = (isset($_POST['Telemovel']) ? $_POST['Telemovel'] : '');
            $_SESSION['empresa']['PessoaContacto'] = (isset($_POST['PessoaContacto']) ? $_POST['PessoaContacto'] : '');

            $_SESSION['type'] = "empresa";
        } else {
            // enviou dados mas empresa ja existe
            return;
        }
    } else {
        // nao enviou dados
        return;
    }
}

$curso_nome = $_SESSION['curso_corrente']['nome'];

if (isset($_SESSION['type']) && ($_SESSION['type'] == 'empresa')) {
    echo "Adicione o(s) formando(s) a inscrever na ação {$curso_nome}:";
    ?>
    <div id="FormFields_" style="margin: 20px 0px;"></div>
    <div class="row">
        <div class="container">
            <table cellpadding="0" cellspacing="0" border="0" class="dataTable table table-striped" id="formandos"></table>
        </div>
    </div>
    <form id="formFormandos" method="post" action="<?= JURI::base() ?>index.php/finalizar-inscricao" accept-charset="utf-8">
        <input type="hidden" id="formandosData" name="formandosData" />
        <input type="submit" id="submitBut" />
    </form>
    <script>
        var columnDefs;
        var tableForm;
        
        jQuery("#submitBut").click(function (e) {
            e.preventDefault();
            EfetuarInscricao();
        });
        
        function EfetuarInscricao() {
            var valido = 1;
            var tmp_valido = 1;
            //verificar se existem formandos
            if (!tableForm.rows().count()) {
                valido = 0;
                tmp_valido = 0;
            }
            if (!tmp_valido) {
                alert("Não existem formandos para inscrever");
            }

            //verificar nome, email, nif (principal)
            tmp_valido = 1;
            tableForm.rows().every(function (rowIdx, tableLoop, rowLoop) {
                var data = this.data();

                jQuery.each(data, function (key, value) {
                    if (!value.toString().trim().length && ( key == 0 || key == 1 || key == 2 )) {
                        valido = 0;
                        tmp_valido = 0;
                        tmp_invalido = key;
                    }
                });
            });
            if (!tmp_valido && tmp_invalido == 0) {
                alert("Existem formandos com o campo Nome por preencher");
            }
            else if (!tmp_valido && tmp_invalido == 1) {
                alert("Existem formandos com o campo NIF por preencher");
            }
            else if (!tmp_valido && tmp_invalido == 2) {
                alert("Existem formandos com o campo Email por preencher");
            }

            if (valido) {
                var formandos = [];
                tableForm.rows().every(function (rowIdx, tableLoop, rowLoop) {
                    var data = this.data();
                    var formando = {};
                    jQuery.each(data, function (key, value) {
                        formando[columnDefs[key]["title"]] = value.toString().trim();
                    });
                    formandos.push(formando);
                });
                
                jQuery("#formandosData").val(JSON.stringify(formandos));
                jQuery("#formFormandos").submit();
            }
        }

        jQuery(document).ready(function () {
            columnDefs = [
                {title: "Nome", type: "text"},
                {title: "NIF", type: "text"},
                {title: "E-mail", type: "text"},
                {title: "Data nascimento", type: "date", visible: false},
				{title: "Escolaridade", type: "text", visible: false},
                {title: "Cartão cidadão", type: "text", visible: false},
                {title: "Validade cartão cidadão", type: "date", visible: false},
                {title: "Telemóvel", type: "text", visible: false},
                {title: "Carta condução", type: "text", visible: false},
                {title: "Data emissão carta condução", type: "date", visible: false},
                {title: "Data Renovação ADR", type: "date", visible: false},
                {title: "Morada", type: "text", visible: false},
                {title: "Cód. Postal", type: "text", visible: false},
                {title: "Localidade", type: "text", visible: false}
            ];
            tableForm = jQuery('#formandos').DataTable({
                "sPaginationType": "full_numbers",
                columns: columnDefs,
                dom: 'Bt',
                ordering: false,
                select: 'single',
                altEditor: true, // Enable altEditor
                buttons: [
                    {
                        text: 'Adicionar Formando',
                        name: 'add'        // do not change name
                    },
                    {
                        extend: 'selected', // Bind to Selected row
                        text: 'Editar Formando',
                        name: 'edit'        // do not change name
                    },
                    {
                        extend: 'selected', // Bind to Selected row
                        text: 'Remover Formando',
                        name: 'delete'      // do not change name
                    }
                ]
            });
        });
    </script>

    <?php
} else {
    header("Location: " . JURI::base() . "index.php/compras");
}