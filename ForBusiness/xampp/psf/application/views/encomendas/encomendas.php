<div class="tables">
    <div class="bs-example widget-shadow" data-example-id="bordered-table"> 
        <div class="row">
            <div class="col-xs-12 col-md-6" style="padding-left:0;">
                <h4>Encomendas</h4>
                <div class="clearfix"> </div>	
            </div>
        </div>
        <div class="row" style="margin-bottom:15px;">
            <form class="form-horizontal forms">
                <div class="form-group">
                    <label for="selector1" class="col-sm-2 control-label">Estado</label>
                    <div class="col-sm-8">
                        <select name="status" id="selector1" class="form-control1">
                            <option value="0" <?= ($status == 0 ? "selected" : "") ?>>Em Aberto</option>
                            <option value="1" <?= ($status == 1 ? "selected" : "") ?>>Concluído</option>
                            <option value="2" <?= ($status == 2 ? "selected" : "") ?>>Faturado</option>
                            <option value="3" <?= ($status == 3 ? "selected" : "") ?>>Todos</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkbox" class="col-sm-2 control-label">Data Inicial</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" value="<?= $dti ?>" name="dti" placeholder="Data Inicial">
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkbox" class="col-sm-2 control-label">Data Final</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" value="<?= $dtf ?>" name="dtf" placeholder="Data Final">
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkbox" class="col-sm-2 control-label"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-default">PESQUISAR</button>
                    </div>
                </div>
            </form>
        </div>
        <table id="encTable" class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Criado</th>
                    <th>Alterado</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enc as $bo) { ?>
                    <tr>
                        <th scope="row"><a href="<?php echo base_url() ?>encomendas/encomenda/<?php echo $bo["bostamp"]; ?>" class=""><?php echo $bo["obrano"]; ?></a></th>
                        <td><?php echo $bo["nome"]; ?></td>
                        <td><?php echo substr($bo["ousrdata"], 0, 10) . " " . substr($bo["ousrhora"], 0, 5); ?></td>
                        <td><?php echo substr($bo["usrdata"], 0, 10) . " " . substr($bo["usrhora"], 0, 5); ?></td>
                        <td class="text-center"><?= $bo["tabela1"] == "EM ABERTO" ? "<p class='bg-success'>" . $bo["tabela1"] . "</p>" : "<p class='bg-danger'>" . $bo["tabela1"] . "</p>"; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="clearfix"> </div>
<script>
    $(document).ready(function () {
        $('#encTable').DataTable({
            dom: '<"pull-left"l><"pull-left space-left"B>frtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>