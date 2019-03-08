<form>
    <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="white halflings-icon circle-arrow-left"></i> Voltar</a>
    <br><br>
    <div class="row-fluid">
        <div class="col-sm-4">
            <h3><?= $bo["nmdos"]; ?> nº <?= $bo["obrano"]; ?></h3>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nome</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $bo["nome"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nº Cliente</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $bo["no"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Estabelecimento</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $bo["estab"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Data Documento</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= substr($bo["dataobra"], 0, 10); ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nº Cont.</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $bo["ncont"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Morada</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $bo["morada"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Cód. Postal</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $bo["codpost"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Localidade</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $bo["local"]; ?>'>
        </div>
    </div>
    <div class="row-fluid">
        <div class="table-responsive">
            <table class="table table-striped" tab-ordercol="1" tab-order="asc" tab-numrow="10000">
                <thead>
                    <tr>
                        <th>Ref</th>
                        <th>Designação</th>
                        <th>Qtd</th>
                        <th>Preço Unit.</th>
                        <th>Desc. 1</th>
                        <th>Desc. 2</th>
                        <th>IVA</th>
                        <th>Total</th>
                    </tr>
                </thead>   
                <tbody>
                    <?php foreach ($bi as $key => $value): ?>
                        <tr>
                            <td><?= $value["ref"] ?></td>
                            <td><?= $value["design"] ?></td>
                            <td><?= number_format($value["qtt"], 2, '.', '') ?></td>
                            <td><?= number_format($value["epu"], 2, '.', '') ?></td>
                            <td><?= number_format($value["desconto"], 2, '.', '') ?></td>
                            <td><?= number_format($value["desc2"], 2, '.', '') ?></td>
                            <td><?= number_format($value["iva"], 2, '.', '') ?></td>
                            <td><?= number_format($value["etiliquido"], 2, '.', '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Total Iliquido</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($bo["etotaldeb"], 2); ?>'>
    </div>    
</form>