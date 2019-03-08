<form>
    <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="white halflings-icon circle-arrow-left"></i> Voltar</a>
    <br><br>
    <div class="row-fluid">
        <div class="col-sm-4">
            <h3><?= $ft["nmdoc"]; ?> nº <?= $ft["fno"]; ?></h3>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nome</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $ft["nome"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nº Cliente</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $ft["no"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Estabelecimento</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $ft["estab"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Data Documento</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= substr($ft["fdata"], 0, 10); ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Data Vencimento</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= substr($ft["pdata"], 0, 10); ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nº Cont.</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $ft["ncont"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Morada</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $ft["morada"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Cód. Postal</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $ft["codpost"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Localidade</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $ft["local"]; ?>'>
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
                    <?php foreach ($fi as $key => $value): ?>
                        <tr>
                            <td><?= $value["ref"] ?></td>
                            <td><?= $value["design"] ?></td>
                            <td><?= number_format($value["qtt"], 2, '.', '') ?></td>
                            <td><?= number_format($value["epv"], 2, '.', '') ?></td>
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
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($ft["ettiliq"], 2); ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Total Desconto Financeiro</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($ft["efinv"], 2); ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Total Desconto Comercial</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($ft["edescc"], 2); ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Total IVA</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($ft["ettiva"], 2); ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Total Documento</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($ft["etotal"], 2); ?>'>
    </div>       
</form>