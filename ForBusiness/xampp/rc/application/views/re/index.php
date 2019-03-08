<form class="re" id="filterDoc" method="POST">
    <div class="form-row">
        <div class="col-sm-3">
            <label for="doc">Documento</label>
            <select class="form-control" name="doc" onchange="$('.re').submit()">
                <?php foreach ($tsre as $tsre_) : ?>
                    <?php if( isset($post["doc"]) && $tsre_["ndoc"] == $post["doc"] ) : ?>
                    <option selected value="<?= $tsre_["ndoc"] ?>"><?= $tsre_["nmdoc"] ?></option>
                    <?php else : ?>
                    <option value="<?= $tsre_["ndoc"] ?>"><?= $tsre_["nmdoc"] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col">
            <label for="rno">Nº</label><br>
            <input class="form-control col-sm-1" name="rno" type="number" value="<?= $rno ?>" style="display: inline-block;" />
            <button class="btn btn-primary" type="button" onclick="$('.re').submit()" style="display: inline-block;"><i class="fa fa-search"></i></button>
            <div class="dropdown show" style="display: inline-block;">
                <a class="dropdown-toggle btn btn-primary " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" onclick="$('#numreg').val('1'); $('.re').submit()">Último registo alterado</a>
                    <a class="dropdown-item" onclick="$('#numreg').val('5'); $('.re').submit()">Últimos 5 registos alterados</a>
                    <a class="dropdown-item" onclick="$('#numreg').val('50'); $('.re').submit()">Últimos 50 registos alterados</a>
                    <a class="dropdown-item" onclick="$('#numreg').val('100'); $('.re').submit()">Últimos 100 registos alterados</a>
                </div>
            </div>
            <input id="tabFilterData" name="tabFilterData" type="hidden">
            <input id="numreg" name="numreg" type="hidden">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#filtroavancado_collapse" aria-expanded="false" aria-controls="filtroavancado_collapse">Filtro Avançado</button>
        </div>
    </div>
    <div class="collapse" id="filtroavancado_collapse">
        <div class="card card-body">
            <div class="form-row">
                <div class="col-sm-1">
                    <select onchange="" id="log_op" class="form-control">
                        <option></option>
                        <option value="and">E</option>
                        <option value="or">OU</option>
                        <option value="and(">E (</option>
                        <option value="or(">OU (</option>
                        <option value=")and(">) E (</option>
                        <option value=")or(">) OU (</option>
                        <option value="(">(</option>
                        <option value=")">)</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select onchange="" id="val1" class="form-control">
                        <?php $dicDataTit = array(); ?>
                        <?php foreach ($dic as $dic_) : ?>
                        <?php if( !in_array($dic_["titulo"], $dicDataTit) ) : ?>
                        <?php $dicDataTit[] = $dic_["titulo"]; ?>
                            <option value='<?= $dic_["nomecampo"] ?>'><?= $dic_["titulo"] ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select onchange="" id="comp_op" class="form-control">
                        <option value="=">IGUAL</option>
                        <option value=">=">MAIOR OU IGUAL</option>
                        <option value="<=">MENOR OU IGUAL</option>
                        <option value="<>">DIFERENTE</option>
                        <option value="%x%">CONTÉM</option>
                        <option value="n%x%">NÃO CONTÉM</option>
                        <option value="x%">COMEÇA POR</option>
                        <option value="%x">TERMINA EM</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value='' id="val2">
                </div>
                <div class="col">
                    <a class="btn btn-success white btnDocAddFilter"><i class="fa fa-plus"></i></a>
                    <a class="btn btn-primary white btnDocSearchFilter"><i class="fa fa-search"></i> Pesquisar</a>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12">
                    <table id="TabFiltro" class="table table-striped bootstrap-datatable">
                        <thead>
                            <tr>
                                <th class="col-sm-10"></th>
                                <th class="hidden"></th>
                                <th class="hidden"></th>
                                <th class="hidden"></th>
                                <th class="hidden"></th>
                                <th class="col-sm-2"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
<br>
<div class="row-fluid">
    <div class="table-responsive">
        <table class="table table-striped dtinit" tab-ordercol="1" tab-order="asc" tab-numrow="100">
            <thead>
                <tr>
                    <th>Doc.</th>
                    <th>Nº</th>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>   
            <tbody>
                <?php foreach ( $re as $re_ ) : ?>
                <tr>
                    <td><?= $re_["nmdoc"] ?></td>
                    <td><?= $re_["rno"] ?></td>
                    <td><?= substr($re_["rdata"],0,10) ?></td>
                    <td><?= $re_["nome"] ?></td>
                    <td><?= number_format($re_["etotal"], 2, ".", "") ?></td>
                    <td><a href="<?= base_url() ?>re/reg/<?= $re_["restamp"] ?>" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>