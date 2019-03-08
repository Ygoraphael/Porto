<?php
include 'db_config.php';

if (JFactory::getUser()->guest == 0) {
    ?>
    <h4>Listagem de Ações</h4>
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
          <ul class="nav nav-tabs custom-tabs">
            <li><a href='<?= JURI::base(); ?>index.php/cadastrar-curso'>Adicionar Curso</a> </li>
            <li><a href='<?= JURI::base(); ?>index.php/adicionar-acao'>Adicionar Ação</a></li>
            <li><a href='<?= JURI::base(); ?>index.php/adminitracao-de-cursos'>Listagem de Cursos</a> </li>
            <li><a href='<?= JURI::base(); ?>index.php/listar-acoes'>Listagem de Ações</a></li>
          </ul>
        </div>
        <?php
        $query = $db->getQuery(true);
        $query->select("*");
        $query->from($db->quoteName('acoes'));
        $query->order('RefCurso ASC');
        $db->setQuery($query);
        $results = $db->loadAssocList();
        ?><br>
        <table id="acao-list" class="table table-responsive dt">
            <thead>
                <tr>
                    <th class="text-left">Curso</th>
                    <th class="text-left">Inicio</th>
                    <th class="text-left">Fim</th>
                    <th class="text-left">Sessões</th>
                    <th class="text-left">Morada</th>
                    <th class="text-left">Localidade</th>
                    <th class="text-left">Exame</th>
                    <th class="text-left">Editar</th>
                </tr>
            </thead>
            <tbody>

                <?php if ($results) {
                    foreach ($results as $row) {
                        $curso = $row["RefCurso"];
                    ?>
                    <tr>
                        <td class="CC"><a href="index.php/<?php echo $curso; ?>"> <?php echo $curso; ?></a></td>
                        <td class="DataInicio"><?php echo substr(repStr($row["DataInicio"]), 0, 50); ?></td>
                        <td class="DataFim"><?php echo substr(repStr($row["DataFim"]), 0, 50); ?></td>
                        <td class="Sessoes"><?php echo substr(repStr($row["Sessoes"]), 0, 50); ?></td>
                        <td class="Morada"><?php echo substr(repStr($row["Morada"]), 0, 50); ?> ...</td>
                        <td class="Localidade"><?php echo substr(repStr($row["Localidade"]), 0, 50); ?> ...</td>
                        <td class="Exame"><?php echo $row["exame"] ? '<i class="icon-ok text-success"></i>' : '<i class="icon-remove text-danger"></i>'; ?></td>
                        <td>
                            <a href="#edit-acao-modal" role="button" id="<?php echo $row["ID"]; ?>" data-toggle="modal" class="btn-small btn-warning pull-left btn-edit-acao">
                                <i class="icon-edit"></i>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="container">
        <div class="span-lg-12" style="text-align: center">
            <h4 class="text-warning">Não tem permissão para aceder a esta página.</h4>
        </div>
    </div>
<?php } ?>

<div id="edit-acao-modal" class="editmod modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><i class="icon-pencil"></i> Editar Ação</h3>
    </div>
    <div class="modal-body" id="content-modal">
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button class="btn btn-success"  data-dismiss="modal" aria-hidden="true"id="btn-save-acao">Gravar Alterações</button>
    </div>
</div>
