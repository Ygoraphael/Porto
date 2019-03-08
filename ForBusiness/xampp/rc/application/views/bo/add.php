<form class="form-horizontal">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    1. Dados Cliente
                </button>
            </h5>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-2 nopaddingleft form-group">
                        <button type="button" class="btn btn-primary col-sm-12 ncmodal callBoCl" data-controller="ajax" data-title="Selecionar cliente" data-method="ModalCl" data-save="fillcl()"><i class="white halflings-icon plus-sign"></i> CLIENTE EXISTENTE</button>
                    </div>
                    <div class="col-sm-12 col-md-2 nopaddingleft form-group">
                        <button type="button" class="btn btn-primary col-sm-12 newBoCl"><i class="halflings-icon white zoom-in"></i> CLIENTE GENÉRICO</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 nopaddingleft">
                        <div class="form-group">
                            <label for="nome">Cliente</label>
                            <input type="text" class="form-control" name="nome" id="nome" disabled />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 nopaddingleft">
                        <div class="form-group">
                            <label for="no">Nº</label>
                            <input type="text" class="form-control" disabled name="no" id="no" disabled />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 nopaddingleft">
                        <div class="form-group">
                            <label for="ncont">NIF</label>
                            <input type="text" class="form-control" disabled name="ncont" id="ncont" disabled />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 nopaddingleft">
                        <div class="form-group">
                            <label for="morada">Morada</label>
                            <input type="text" class="form-control" name="morada" id="morada" disabled />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 nopaddingleft">
                        <div class="form-group">
                            <label for="codpost">Cód. Postal</label>
                            <input type="text" class="form-control" name="codpost" id="codpost" disabled />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 nopaddingleft">
                        <div class="form-group">
                            <label for="local">Localidade</label>
                            <input type="text" class="form-control" name="local" id="local" disabled />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 nopaddingleft">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 nopaddingleft">
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" id="telefone" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    2. Encomenda
                </button>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-2 nopaddingleft form-group">
                        <button type="button" class="btn btn-primary col-sm-12 ncmodal callBoSt" data-controller="ajax" data-title="Selecionar artigo" data-method="ModalSt" data-save="fillst()"><i class="white halflings-icon plus-sign"></i> NOVO ARTIGO</button>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped dtinit docgrid" tab-ordercol="0" tab-order="asc" tab-numrow="100" tab-sort="false" tab-paginate="false" tab-filter="false" tab-info="false">
                            <thead>
                                <tr>
                                    <th>Referência</th>
                                    <th>Designação</th>
                                    <th>Qtd</th>
                                    <th>Preço Unit.</th>
                                    <th>Preço Total</th>
                                    <th>Desc.</th>
                                    <th>Preço Liq. Total</th>
                                    <th></th>
                                </tr>
                            </thead>   
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-3 nopaddingleft">
                        <div class="form-group">
                            <label for="totaldesc">Desconto</label>
                            <input type="text" class="form-control" value="€ 0.00" name="totaldesc" id="totaldesc" disabled />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 nopaddingleft">
                        <div class="form-group">
                            <label for="totalliq">Total Líquido</label>
                            <input type="text" class="form-control" value="€ 0.00" name="totalliq" id="totalliq" disabled />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 nopaddingleft">
                        <div class="form-group">
                            <label for="totaldocumento"><b>Total Documento</b></label>
                            <input type="text" class="form-control" value="€ 0.00" name="totaldocumento" id="totaldocumento" disabled />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 nopaddingleft">
                        <div class="form-group">
                            <label for="tpdesc">Condições Pagamento</label>
                            <select class="tpdesc form-control" name="tpdesc" id="tpdesc">
                                <?php foreach ($tpdesc as $pag) : ?>
                                    <?php $selected = (trim($pag["descricao"]) == 'Pronto Pagamento') ? 'selected' : ''; ?>
                                    <option <?= $selected; ?> value="<?= trim($pag["tpstamp"]); ?>"><?= trim($pag["descricao"]); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    3. Finalização
                </button>
            </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6 nopaddingleft">
                        <div class="form-group">
                            <label for="obs">Notas Internas</label>
                            <textarea class="form-control" name="obs" id="obs" maxlength="254" rows="11" class="col-sm-12"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 nopaddingleft">
                        <div class="form-group">
                            <label for="obsint">Observações Cliente</label>
                            <textarea class="form-control" name="obstab2" id="obstab2" maxlength="254" rows="11" class="col-sm-12"></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary saveOrder" onclick="return false;">FINALIZAR</button>
            </div>
        </div>
    </div>
</form>