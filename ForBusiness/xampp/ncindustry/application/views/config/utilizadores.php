<div class="bs-example widget-shadow" data-example-id="bordered-table"> 
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Utilizador</th>
                <th class="text-center">Ponto</th>
                <th class="text-center">Picking</th>
                <th class="text-center">Tarefas</th>
                <th class="text-center">Ativo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($u_ncius as $user) { ?>
            <tr>
                <th scope="row"><?php echo $user["usercode"]; ?></th>
                <td class="text-center"><?php echo $user["ponto"]   ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                <td class="text-center"><?php echo $user["picking"] ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                <td class="text-center"><?php echo $user["tarefas"] ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                <td class="text-center"><?php echo $user["ativo"] ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                <td class="text-center"><a href="<?php echo base_url() ?>config/utilizador/<?php echo $user["usstamp"]; ?>" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></a></td>
            </tr>
            <?php } ?>
            
        </tbody>
    </table>
</div>

<div class="clearfix"> </div>