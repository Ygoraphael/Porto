<form class="form-horizontal">
    <div class="row step">
        <div class="step-text">1. Dados Cliente</div><div class="step-bar"></div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-2 nopaddingleft form-group">
            <button type="button" class="btn btn-primary col-sm-12" onclick="novo_cliente(); return false;"><i class="white halflings-icon plus-sign"></i> NOVO CLIENTE</button>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft form-group">
            <button type="button" class="btn btn-primary col-sm-12" data-remodal-target="modal"><i class="halflings-icon white zoom-in"></i> CLIENTE EXISTENTE</button>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft form-group">
            <button type="button" class="btn btn-primary col-sm-12" data-remodal-target="modal-enc" onclick="recuperar_encomenda(); return false;"><i class="white halflings-icon plus-sign"></i> RECUPERAR ENCOMENDA</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 nopaddingleft">
            <div class="form-group">
                <label for="nome">Cliente</label>
                <input type="text" class="form-control" id="nome" disabled />
            </div>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft">
            <div class="form-group">
                <label for="no">Nº</label>
                <input type="text" class="form-control" disabled id="no" disabled />
            </div>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft">
            <div class="form-group">
                <label for="ncont">NIF</label>
                <input type="text" class="form-control" disabled id="ncont" disabled />
            </div>
        </div>
        <div class="col-sm-12 col-md-6 nopaddingleft">
            <div class="form-group">
                <label for="morada">Morada</label>
                <input type="text" class="form-control" id="morada" disabled />
            </div>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft">
            <div class="form-group">
                <label for="codpost">Cód. Postal</label>
                <input type="text" class="form-control" id="codpost" disabled />
            </div>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft">
            <div class="form-group">
                <label for="local">Localidade</label>
                <input type="text" class="form-control" id="local" disabled />
            </div>
        </div>
        <div class="col-sm-12 col-md-6 nopaddingleft">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" />
            </div>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft">
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" />
            </div>
        </div>
        <div class="col-sm-12 col-md-10 nopaddingleft">
            <div class="form-group">
                <label for="nome_ent">Nome Contacto Entrega</label>
                <input type="text" class="form-control" id="nome_ent" />
            </div>
        </div>
        <div class="col-sm-12 col-md-6 nopaddingleft">
            <div class="form-group">
                <label for="morada_ent">Morada</label>
                <input type="text" class="form-control" id="morada_ent" />
            </div>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft">
            <div class="form-group">
                <label for="codpost_ent">Cód. Postal</label>
                <input type="text" class="form-control" id="codpost_ent" />
            </div>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft">
            <div class="form-group">
                <label for="local_ent">Localidade</label>
                <input type="text" class="form-control" id="local_ent" />
            </div>
        </div>
        <div class="col-sm-12 col-md-6 nopaddingleft">
            <div class="form-group">
                <label for="email_ent">Email</label>
                <input type="text" class="form-control" id="email_ent" />
            </div>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft">
            <div class="form-group">
                <label for="telefone_ent">Telefone</label>
                <input type="text" class="form-control" id="telefone_ent" />
            </div>
        </div>
    </div>
    <div class="row step" style="margin-top:20px">
        <div class="step-text">2. Encomenda</div><div class="step-bar"></div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-2 nopaddingleft form-group">
            <button type="button" class="btn btn-primary col-sm-12" onclick="FiltraArtigos(); return false;"><i class="white halflings-icon plus-sign"></i> NOVO ARTIGO</button>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-striped dtinit" tab-ordercol="0" tab-order="asc" tab-numrow="100" tab-sort="false" tab-paginate="false" tab-filter="false" tab-info="false">
                <thead>
                    <tr>
                        <th>Referência</th>
                        <th>Designação</th>
                        <th>Qtd</th>
                        <th>Preço Unit.</th>
                        <th>IVA</th>
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
                <input type="text" class="form-control" value="€ 0.00" id="totaldesc" disabled />
            </div>
        </div>
        <div class="col-sm-12 col-md-3 nopaddingleft">
            <div class="form-group">
                <label for="totalliq">Total Líquido</label>
                <input type="text" class="form-control" value="€ 0.00" id="totalliq" disabled />
            </div>
        </div>
        <div class="col-sm-12 col-md-3 nopaddingleft">
            <div class="form-group">
                <label for="totaliva">IVA</label>
                <input type="text" class="form-control" value="€ 0.00" id="totaliva" disabled />
            </div>
        </div>
        <div class="col-sm-12 col-md-3 nopaddingleft">
            <div class="form-group">
                <label for="totaldocumento"><b>Total Documento</b></label>
                <input type="text" class="form-control" value="€ 0.00" id="totaldocumento" disabled />
            </div>
        </div>
        <div class="col-sm-12 col-md-4 nopaddingleft">
            <div class="form-group">
                <label for="tpdesc">Condições Pagamento</label>
                <select class="tpdesc form-control" id="tpdesc">
                    <?php foreach ($tpdesc as $pag) : ?>
                        <?php $selected = (trim($pag["descricao"]) == 'P. Pagamento') ? 'selected' : ''; ?>
                        <option desc="<?= trim($pag["u_desconto"]); ?>" <?= $selected; ?> value="<?= trim($pag["tpstamp"]); ?>"><?= trim($pag["descricao"]); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 nopaddingleft">
            <div class="form-group">
                <label for="obs">Notas Internas</label>
                <textarea class="form-control" id="obs" maxlength="254" rows="11" class="col-sm-12"></textarea>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 nopaddingleft">
            <div class="form-group">
                <label for="obsint">Observações Cliente</label>
                <textarea class="form-control" id="obsint" maxlength="254" rows="11" class="col-sm-12"></textarea>
            </div>
        </div>
    </div>
    <div class="row step" style="margin-top:20px">
        <div class="step-text">3. Confirmação</div><div class="step-bar"></div>
    </div>
    <div id="signature-pad" class="m-signature-pad">
        <canvas width=290 height=200></canvas><br>
        <button type="submit" class="btn btn-primary" id="clear_sign" onclick="return false;">LIMPAR</button>
    </div>
    <div class="row step" style="margin-top:20px">
        <div class="step-text">4. Finalizar</div><div class="step-bar"></div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-2 nopaddingleft form-group">
            <button type="button" class="btn btn-secondary col-sm-12" onclick="GuardaEncomendaTmp(); return false;">GRAVAR</button>
        </div>
        <div class="col-sm-12 col-md-2 nopaddingleft form-group">
            <button type="button" class="btn btn-primary col-sm-12" id="save_sign" onclick="return false;">FINALIZAR</button>
        </div>
    </div>
</form>