<form>
    <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="white halflings-icon circle-arrow-left"></i> Voltar</a>
    <br><br>
    <div class="form-group">
        <label for="exampleFormControlInput1">Referência</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $st["ref"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Designação</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $st["design"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Referência Fornecedor</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $st["forref"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Marca</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $st["usr1"]; ?>'>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Modelo</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $st["usr2"]; ?>'>
    </div>       
    <div class="form-group">
        <label for="exampleFormControlInput1">Família</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= $st["familia"] . ' - ' . $st["faminome"]; ?>'>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-6 noPaddingLeft">
            <div class="form-group">
                <label for="exampleFormControlInput1">PVP (Iva Incluído)</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($st["epv1"], 2, '.', ''); ?>'>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Bronze</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($st["epv2"], 2, '.', ''); ?>'>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Prata</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($st["epv3"], 2, '.', ''); ?>'>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Ouro</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='€ <?= number_format($st["epv4"], 2, '.', ''); ?>'>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6 noPaddingRight">
            <div class="form-group">
                <label for="exampleFormControlInput1">Stock Atual</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= number_format($st["stock"], 2, '.', ''); ?>'>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Stock Por Armazém</label>
                <table class="table table-striped bootstrap-datatable">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Armazém</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sa as $sa_) : ?>
                            <?php
                            $sznome = "Armazém " . $sa_["armazem"];
                            foreach ($sz as $sz_) {
                                if ($sz_["no"] == $sa_["armazem"]) {
                                    $sznome = $sz_["nome"];
                                }
                            }
                            ?>
                            <tr>
                                <td><?= $sa_["armazem"] ?></td>
                                <td><?= $sznome ?></td>
                                <td><?= number_format($sa_["stock"], 2, ".", "") ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Peso [gr]</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" disabled value='<?= number_format($st["peso"], 2, '.', ''); ?>'>
    </div>
</form>