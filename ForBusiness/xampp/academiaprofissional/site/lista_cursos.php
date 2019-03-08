<?php
include_once 'db_config.php';

if (JFactory::getUser()->guest == 0) {
    ?>

    <div class="span12">
        <h4>Listagem de Cursos</h4>
        <?php if (isset($_SESSION['msg'])) { ?>
            <div class="alert <?= $_SESSION['msg']['type'] ?>">
                <p><i class="icon-info"></i> <?= $_SESSION['msg']['msg'] ?></p>
            </div>
            <?php
            unset($_SESSION['msg']);
        }
        ?>
        <div class="text-center">
          <ul class="nav nav-tabs custom-tabs">
            <li><a href='<?= JURI::base(); ?>index.php/cadastrar-curso'>Adicionar Curso</a> </li>
            <li><a href='<?= JURI::base(); ?>index.php/adicionar-acao'>Adicionar Ação</a></li>
            <li><a href='<?= JURI::base(); ?>index.php/adminitracao-de-cursos'>Listagem de Cursos</a> </li>
            <li><a href='<?= JURI::base(); ?>index.php/listar-acoes'>Listagem de Ações</a></li>
            </ul>
        </div>
        <br>
        <?php

        $query = $db->getQuery(true);
        $query->select("*");
        $query->from($db->quoteName('cursos'));
        $db->setQuery($query);
        $results = $db->loadAssocList();

        if ($results) {
            ?>
            <table id="curso-list" class="table table-responsive">
                <thead>
                    <tr>
                        <th>Código Curso</th>
                        <th>Nome Curso</th>
                        <th>Preço</th>
                        <th>Objetivos</th>
                        <th>Contexto</th>
                        <th>PublicoTarget</th>
                        <th>Info</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr>
                            <td class="CC"><a href="index.php/<?php echo repStr(strip_tags($row["CC"])); ?>"> <?php echo repStr($row ["CC"]); ?></a></td>
                            <td class="NomeCurso"><?php echo substr(repStr(strip_tags($row["NomeCurso"])), 0, 50); ?> ...</td>
                            <td class="Preco"><?php echo substr(repStr(strip_tags($row["Preco"])), 0, 50); ?> ...</td>
                            <td class="Objectivos"><?php echo substr(repStr(strip_tags($row["Objectivos"])), 0, 50); ?> ...</td>
                            <td class="Contexto"><?php echo substr(repStr(strip_tags($row["Contexto"])), 0, 50); ?> ...</td>
                            <td class="PublicoTarget"><?php echo substr(repStr(strip_tags($row["PublicoTarget"])), 0, 50); ?> ...</td>
                            <td class="Info"><?php echo substr(repStr(strip_tags($row["Info"])), 0, 50); ?> ...</td>
                            <td>
                                <a href="#edit-curso-modal" role="button" id="<?php echo repStr($row["CC"]); ?>" data-toggle="modal" class="btn-small btn-warning pull-left btn-edit-curso">
                                    <i class="icon-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
        }
        ?>
    </div>
<?php } else { ?>
    <div class="container">
        <div class="span-lg-12" style="text-align: center">
            <h4 class="text-warning">Você não tem permissão pra acessar essa pagina, por favor, acesse o painel de controle.</h4>
        </div>
    </div>
<?php } ?>

<div id="edit-curso-modal" class="editmod modal hide fade modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><i class="icon-pencil"></i> Editar Curso</h3>
    </div>
    <div class="modal-body" id="content-modal">
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button class="btn btn-success" data-dismiss="modal" aria-hidden="true" id="btn-save-curso">Salvar Alterações</button>
    </div>
</div>
