<form>
    <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="white halflings-icon circle-arrow-left"></i> Voltar</a>
    <a href="<?= base_url() ?>cl/cc/<?= $stamp; ?>" class="btn btn-primary"><i class="white halflings-icon book"></i> Conta Corrente</a>
    <br><br>
    <div class="form-group">
        <label for="exampleFormControlInput1">Número</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $cl["no"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Nome</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $cl["nome"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Nº Contribuinte</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $cl["ncont"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Saldo em Aberto</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= round($cl["esaldo"], 2); ?>'>
    </div>
    <div class="form-row">
        <div class="form-group col-sm-10">
            <label for="exampleFormControlInput1">Morada</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $cl["morada"]; ?>'>
        </div>
        <div class="form-group col-sm-2">
            <label for="exampleFormControlInput1"></label>
            <button class="form-control btn btn-primary" type="button" onclick="AbreMaps('<?= str_replace("/", "%2F", str_replace(" ", "+", $cl["morada"]) . ",+" . $cl["codpost"]); ?>'); return false;"><i class="fa fa-map" aria-hidden="true"></i></button>
        </div>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Localidade</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $cl["local"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Cód. Postal</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $cl["codpost"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Telefone</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $cl["telefone"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Telemóvel</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $cl["tlmvl"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Fax</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $cl["fax"]; ?>'>
    </div>
    <div class="form-row">
        <div class="form-group col-sm-10">
            <label for="exampleFormControlInput1">Email</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $cl["email"]; ?>'>
        </div>
        <div class="form-group col-sm-2">
            <label for="exampleFormControlInput1"></label>
            <button class="form-control btn btn-primary" type="button" onclick="EnviaEmail('<?= $cl["email"]; ?>')"><i class="fa fa-envelope-o" aria-hidden="true"></i></button>
        </div>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Observações</label>
        <textarea class="col-sm-12" style="height:400px;" readonly><?= $cl["obs"]; ?></textarea>
    </div>
</form>
<div class="row-fluid">
    <div class="col-sm-4">
        <h3>Não Regularizado</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-striped dtinit" tab-ordercol="1" tab-order="asc" tab-numrow="10000">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Número</th>
                    <th>Débito (€)</th>
                    <th>Crédito (€)</th>
                    <th>Data Documento</th>
                    <th>Data Vencimento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cc as $key => $value): ?>
                    <tr>
                        <td><?= $value["cmdesc"] ?></td>
                        <td><?= $value["nrdoc"] ?></td>
                        <td><?= number_format($value["edeb"], 2) ?></td>
                        <td><?= number_format($value["ecred"], 2) ?></td>
                        <td><?= substr($value["datalc"], 0, 10) ?></td>
                        <td><?= substr($value["dataven"], 0, 10) ?></td>
                        <td><a href="<?= base_url() ?>ft/reg/<?= $value["ftstamp"] ?>" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>