<form>
    <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="white halflings-icon circle-arrow-left"></i> Voltar</a>
    <br><br>
    <div class="row-fluid">
        <div class="col-sm-4">
            <h3><?= $re["nmdoc"]; ?> nº <?= $re["rno"]; ?></h3>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nome</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $re["nome"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nº Cliente</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $re["no"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Estabelecimento</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $re["estab"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Data</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= substr($re["rdata"], 0, 10); ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nº Cont.</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $re["ncont"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Morada</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $re["morada"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Cód. Postal</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $re["codpost"]; ?>'>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Localidade</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $re["local"]; ?>'>
        </div>
    </div>
    <div class="row-fluid">
        <div class="table-responsive">
            <table class="table table-striped" tab-ordercol="1" tab-order="asc" tab-numrow="10000">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Documento</th>
                        <th>Por Regularizar</th>
                        <th>Regularizado</th>
                        <th>Desconto</th>
                    </tr>
                </thead>   
                <tbody>
                    <?php foreach ($rl as $key => $value): ?>
                        <tr>
                            <td><?= $value["nrdoc"] ?></td>
                            <td><?= $value["cdesc"] ?></td>
                            <td><?= number_format($value["eval"], 2, '.', '') ?></td>
                            <td><?= number_format($value["evori"], 2, '.', '') ?></td>
                            <td><?= number_format($value["desconto"], 2, '.', '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Desconto Financeiro</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($re["efinv"], 2); ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Valor IRS</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($re["evirs"], 2); ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Total Documento</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($re["etotal"], 2); ?>'>
    </div>       
</form>