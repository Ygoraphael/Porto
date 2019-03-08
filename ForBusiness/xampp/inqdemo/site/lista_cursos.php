<?php
if (JFactory::getUser()->guest == 0) {
    // header("Location: http://{$_SERVER['HTTP_HOST']}");
    ?> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

    <style>
        label{display:inline-block;width:100px;margin-bottom:10px;}
    </style>

    <div class="span12">
        <?php if (isset($_SESSION['msg'])) { ?>
            <div class="alert <?= $_SESSION['msg']['type'] ?>">
                <p><i class="icon-info"></i> <?= $_SESSION['msg']['msg'] ?></p>
            </div>

            <?php
            unset($_SESSION['msg']);
        }
        ?>
        <div class="text-center">
            <a href='http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/cadastrar-curso'>Adicionar Cursos</a> |
            <a href='http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/adminitracao-de-cursos'>Lista de Cursos</a> |
            <a href='http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/listar-acoes'>ações</a> 
        </div>
        <?php
        include_once 'db_config.php';
        date_default_timezone_set('Europe/Lisbon');
        $query = "SELECT * FROM cursos";

        $result = $conn->query($query);

        if ($result) {
            ?>

            <table id="curso-list">
                <thead>
                    <tr>
                        <th>Código Curso</th>
                        <th>Nome Curso</th>
                        <th>Preço</th>
                        <th>Objetivos</th>
                        <th>Contexto</th>
                        <th>PublicoTarget</th>
                        <th>Info</th>
                        <!--<th>Acreditações</th>-->
						<th>Editar</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while ($contact = $result->fetch_row()) { ?>
                        <tr>
                            <td class="CC">
                                <a href="index.php/<?php echo $contact[1]; ?>"> <?php echo $contact [1]; ?></a>
                            </td>
                            <td class="NomeCurso"><?php echo $contact[2]; ?></td>
                            <td class="Preco"><?php echo $contact[7]; ?></td>
                            <td class="Objectivos"><?php echo $contact[3]; ?></td>
                            <td class="Contexto"><?php echo $contact[4]; ?></td>
                            <td class="PublicoTarget"><?php echo $contact[5]; ?></td>
                            <td class="Info"><?php echo $contact[6]; ?></td>
							<!--<td class="acreditacoes"><?php echo $contact[9]; ?></td>-->
                            <td>
                                <a  href="#edit-curso-modal" role="button"  id="<?php echo $contact[1]; ?>" data-toggle="modal" class="btn-small btn-warning pull-left btn-edit-curso">
                                    <i class="icon-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
        }
        $result->close();
        ?>
    </div>

<?php } else { ?>
    <div class="container">
        <div class="span-lg-12" style="text-align: center">
            <h4 class="text-warning">Você não tem permissão pra acessar essa pagina, por favor, acesse o painel de controle.</h4>
        </div>
    </div>

<?php } ?>

<div style="margin-top: 40px;" id="edit-curso-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><i class="icon-pencil"></i> Editar Curso</h3>
    </div>
    <div class="modal-body" id="content-modal">
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button class="btn btn-success"  data-dismiss="modal" aria-hidden="true"id="btn-save-curso">Salvar Alterações</button>
    </div>
</div>