<div class="row-fluid">
    <div class="table-responsive">
        <table class="table table-striped dtinit" tab-ordercol="1" tab-order="asc" tab-numrow="100">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Nome</th>
                    <th style="text-align:center">Por Liquidar (€)</th>
                    <th></th>
                </tr>
            </thead>   
            <tbody>
                <?php foreach ($cl as $key => $value): ?>
                    <tr>
                        <td><?= $value["no"] ?></td>
                        <td><?= $value["nome"] ?></td>
                        <td align="center"><?= number_format($value["esaldo"], 2) ?></td>
                        <td><a href="<?= base_url() ?>cl/reg/<?= $value["clstamp"] ?>" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>