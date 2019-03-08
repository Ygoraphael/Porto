<form method="GET">
    <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="white halflings-icon circle-arrow-left"></i> Voltar</a>
    <br><br>
    <div class="form-group">
        <label for="exampleFormControlInput1">Data Inicial</label>
        <input type="date" class="form-control" name="di" value='<?= $datai ?>'>
    </div>
    <div class="form-row">
        <div class="form-group col-sm-10">
            <label for="exampleFormControlInput1">Data Final</label>
            <input type="date" class="form-control" name="df" value='<?= $dataf ?>'>
        </div>
        <div class="form-group col-sm-2">
            <label for="exampleFormControlInput1"></label>
            <button type="submit" class="form-control btn btn-primary" type="button">Filtrar</button>
        </div>
    </div>
</form>
<div class="row-fluid">
    <div class="table-responsive">
        <table class="table table-striped dtinit" tab-ordercol="1" tab-order="asc" tab-numrow="10000">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Vencimento</th>
                    <th>Documento</th>
                    <th>Nº Doc.</th>
                    <th>Débito</th>
                    <th>Crédito</th>
                    <th>Saldo</th>
                    <th>Obs.</th>
                    <th>Inc. Documento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ccpre as $key => $value): ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Saldo Inicial</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?= number_format($value["saldo"], 2) ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php $saldo = $value["saldo"]; ?>
                <?php endforeach; ?>
                <?php foreach ($cc as $key => $value): ?>
                    <?php
                    $saldo -= floatval($value["ecred"]);
                    $saldo += floatval($value["edeb"]);
                    ?>
                    <tr>
                        <td><?= substr($value["datalc"], 0, 10) ?></td>
                        <td><?= substr($value["dataven"], 0, 10) ?></td>
                        <td><?= $value["cmdesc"] ?></td>
                        <td><?= $value["nrdoc"] ?></td>
                        <td><?= number_format($value["edeb"], 2) ?></td>
                        <td><?= number_format($value["ecred"], 2) ?></td>
                        <td><?= number_format($saldo, 2) ?></td>
                        <td><?= $value["obs"] ?></td>
                        <td><?= $value["ultdoc"] ?></td>
                        <?php if( strlen(trim($value["ftstamp"])) ): ?>
                        <td><a href="<?= base_url() ?>ft/reg/<?= $value["ftstamp"] ?>" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                        <?php elseif ( strlen(trim($value["restamp"])) ): ?>
                        <td><a href="<?= base_url() ?>re/reg/<?= $value["restamp"] ?>" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                        <?php else: ?>
                        <td></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>