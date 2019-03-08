<div class="row-fluid">
    <div class="table-responsive">
        <table class="table table-striped dtinit" tab-ordercol="1" tab-order="asc" tab-numrow="50">
            <thead>
                <tr>
                    <th>Ref</th>
                    <th>Designação</th>
                    <th>Unidade</th>
                    <th>Peso[gr]</th>
                    <th>PVP</th>
                    <th>Stock</th>
                </tr>
            </thead>   
            <tbody>
                <?php foreach ($st as $key => $value): ?>
                    <tr>
                        <td><?= $value["ref"] ?></td>
                        <td><?= $value["design"] ?></td>
                        <td align="center"><?= $value["unidade"] ?></td>
                        <td align="center"><?= number_format($value["peso"], 2, ".", "") ?></td>
                        <td align="center"><?= number_format($value["epv1"], 2, ".", "") ?></td>
                        <td align="center"><?= number_format($value["stock"], 2, ".", "") ?></td>
                        <td><a href="<?= base_url() ?>st/reg/<?= $value["ststamp"] ?>" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>