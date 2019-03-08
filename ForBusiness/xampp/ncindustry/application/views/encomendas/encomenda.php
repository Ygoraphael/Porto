<div class="forms">
    <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
        <div class="form-body col-xs-12 col-sm-6">
            <form>
                <input type="hidden" readonly name="bo.bostamp" id="bo_bostamp" value="<?= $enc["bostamp"]; ?>">
                <div class="form-group">
                    <label>Documento</label>
                    <input type="text" readonly class="form-control" value="<?= $enc["nmdos"]; ?>">
                </div>
                <div class="form-group">
                    <label>Nº Documento</label>
                    <input type="text" readonly class="form-control" value="<?= $enc["obrano"]; ?>">
                </div>
                <div class="form-group">
                    <label>Data Documento</label>
                    <input type="date" readonly class="form-control" value="<?= substr($enc["dataobra"], 0, 10); ?>">
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <input type="text" readonly class="orderSatus form-control" value="<?= $enc["tabela1"] ?>">
                </div>
                <button onclick="saveOrder(); return false;" class="savebut btn btn-default <?= ($enc["tabela1"] == "CONCLUÍDO") ? "hidden" : "" ?>"><?= lang('save') ?></button>
                <button onclick="openOrder(); return false;" class="openbut btn btn-default <?= ($enc["tabela1"] == "CONCLUÍDO") ? "" : "hidden" ?>" style="background:#f0ad4e"><?= lang('open') ?></button>
                <button onclick="closeOrder(); return false;" class="closebut btn btn-default <?= ($enc["tabela1"] == "CONCLUÍDO") ? "hidden" : "" ?>" style="background:#f0ad4e"><?= lang('close') ?></button>
                <?php if (strlen(trim($enc["obstab2"]))): ?>
                    <button onclick="return false;" data-toggle="collapse" class="btn btn-default" data-target="#email_anexo"><?= lang('SEE_EMAIL_ATTACH') ?></button>
                <?php endif ?>
            </form> 
        </div>
        <div class="form-body col-xs-12 col-sm-6">
            <form>
                <div class="form-group">
                    <label>Cliente</label>
                    <input type="text" readonly class="form-control" value="<?= $enc["nome"]; ?>">
                </div>
                <div class="form-group">
                    <label>NIF</label>
                    <input type="text" readonly class="form-control" value="<?= $enc["ncont"]; ?>">
                </div>
                <div class="form-group">
                    <label>Morada</label>
                    <input type="text" readonly class="form-control" value="<?= $enc["morada"]; ?>">
                </div>
                <div class="form-group">
                    <label>Localidade</label>
                    <input type="text" readonly class="form-control" value="<?= $enc["local"]; ?>">
                </div>
                <div class="form-group">
                    <label>Cód. Postal</label>
                    <input type="text" readonly class="form-control" value="<?= $enc["codpost"]; ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" readonly class="form-control" value="<?= $enc["email"]; ?>">
                </div>
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" readonly class="form-control" value="<?= $enc["telefone"]; ?>">
                </div>
            </form> 
        </div>
        <?php if (strlen(trim($enc["obstab2"]))): ?>
			<iframe class="col-xs-12 collapse" height="315" style="margin-bottom:15px;" id="email_anexo" src="<?= base_url() ?>ajax/email/<?= $enc["bostamp"] ?>" frameborder="0"></iframe>
        <?php endif ?>
        <div class="form-body col-xs-12 col-sm-6 nopaddingtop">
            <form class='form-inline'>
                <div class="form-group">
                    <input type="text" id="picksearch" class="form-control text-center" placeholder="Cód. Barras ou Ref.">
                </div>
                <button onclick="SearchInsert(); return false;" class="selectBut btn btn-default <?= ($enc["tabela1"] == "CONCLUÍDO") ? "hidden" : "" ?>"><?= lang('select') ?></button>
            </form>
            <div class="checkbox">
                <label><input type="checkbox" id="check_qtt"> <?= lang('ASK_QTT') ?></label>
            </div>
        </div>
        <div class="clearfix"> </div>	
    </div>
</div>
<div class="clearfix"> </div>
<?php
$total_qtt_satisf = 0;
$total_qtt_falta = 0;
?>
<div class="tables">
    <div class="bs-example widget-shadow  table-responsive" data-example-id="bordered-table"> 
        <table class="table table-bordered enclinhas">
            <thead>
                <tr>
                    <th>Ref.</th>
                    <th>Designação</th>
                    <th>Ul.</th>
                    <th>Qtd.</th>
                    <th>Preço Unit.</th>
                    <th>Desc. %</th>
                    <th>Total</th>
                    <th>Qtd. Satisfeita</th>
                    <th>Qtd. Falta</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enclin as $lin) { ?>
                    <?php
                    $qtt_falta = floatval($lin["qtt"]) - floatval($lin["u_nciqttc"]);
                    $total_qtt_satisf += floatval($lin["u_nciqttc"]);
                    $total_qtt_falta += $qtt_falta;
                    ?>
                    <tr>
                        <th scope="row"><a data-stamp="<?= $lin["bistamp"]; ?>" onclick="ModalAjax('<?= base_url() ?>ajax/artigo/<?= $lin["ststamp"]; ?>', 'Artigo <?= $lin["ref"]; ?>')" ><?= $lin["ref"]; ?></a></th>
                        <td><?= $lin["design"]; ?></td>
                        <td><?= $lin["adjudicada"]; ?></td>
                        <td><?= number_format($lin["qtt"], 2, '.', ''); ?></td>
                        <td><?= number_format($lin["edebito"], 2, '.', ''); ?></td>
                        <td><?= number_format($lin["desconto"], 2, '.', ''); ?></td>
                        <td><?= number_format($lin["ettdeb"], 2, '.', ''); ?></td>
                        <td class=""><input onfocus="$(this).select()" type="number" min="0" max="<?= number_format($lin["qtt"], 2, '.', ''); ?>" step="1" class="form-control decimal_input" value="<?= number_format($lin["u_nciqttc"], 2, '.', ''); ?>"></td>
                        <td class='<?= $qtt_falta ? "bg-danger" : "bg-success" ?>'><?= number_format($qtt_falta, 2, '.', ''); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6">TOTAL</th>
                    <td class="total_valor"><?= number_format($enc["etotal"], 2, '.', ''); ?></td>
                    <td class="total_qttsatis"><?= number_format($total_qtt_satisf, 2, '.', ''); ?></td>
                    <td class="total_qttfalta"><?= number_format($total_qtt_falta, 2, '.', ''); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="clearfix"></div>
<script>
    var Resource = function () {
        this.baseUrl = '<?= base_url(); ?>';
        this.controller = 'ajax';

        this.get = function (search) {
            return $.ajax({
                method: "GET",
                url: this.baseUrl + this.controller + "/get_st_by_ref_barcode/" + search,
                dataType: "json"
            });
        };
    };

    var res = new Resource();

    $(".decimal_input").bind('keyup keydown mouseup change', function () {
        AtualizaQtdFalta();
    });

    function AtualizaQtdFalta() {
        var total_valor = 0;
        var total_qttsatis = 0;
        var total_qttfalta = 0;

        jQuery('.enclinhas tbody tr').each(function () {
            var qtt = parseFloat($(this).children().eq(3).html().toString().trim());
            var qtt_satisf = parseFloat($(this).children().eq(7).find("input").val());
            var valor = parseFloat($(this).children().eq(6).html().toString().trim());
            var diff = parseFloat(f2n(qtt - qtt_satisf));
            $(this).children().eq(8).html(diff.toFixed(2));

            total_valor = total_valor + valor;
            total_qttsatis = total_qttsatis + qtt_satisf;
            total_qttfalta = total_qttfalta + diff;

            if (diff === 0) {
                $(this).children().eq(8).removeClass('bg-danger');
                $(this).children().eq(8).addClass('bg-success');
            } else {
                $(this).children().eq(8).removeClass('bg-success');
                $(this).children().eq(8).addClass('bg-danger');
            }
        });

        $(".total_valor").html(total_valor.toFixed(2));
        $(".total_qttsatis").html(total_qttsatis.toFixed(2));
        $(".total_qttfalta").html(total_qttfalta.toFixed(2));
    }

    function SetQttSatArtigo(obj, qtt_satisf) {
        var tmp = parseFloat(obj.find("input").val());
        obj.find("input").val((tmp + parseFloat(qtt_satisf)).toFixed(2))
        AtualizaQtdFalta();
    }

    function SetQttArtigo(obj, qtt_satisf) {
        var tmp = parseFloat(obj.html());
        obj.html((tmp + parseFloat(qtt_satisf)).toFixed(2))
        AtualizaQtdFalta();
    }

    function openOrder() {
        var bostamp = jQuery("#bo_bostamp").val().toString().trim();
        DesejaContinuar("<?= lang('ask_open_order') ?>", function (result) {
            jQuery(".loading-overlay").show();
            jQuery.post('<?= base_url(); ?>' + 'ajax/status_abrir_encomenda', {bostamp: bostamp}, function (response) {
            }, 'json').done(function (response) {
                $(".openbut").addClass('hidden');
                $(".closebut").removeClass('hidden');
                $(".orderSatus").val('<?= lang('STATUS_OPEN') ?>');
                $(".savebut").removeClass('hidden');
                $(".selectBut").removeClass('hidden');
                jQuery(".loading-overlay").hide();
                toastr.success('<?= lang('order_open_success') ?>')
            });
        }, function (result) {});
    }

    function closeOrder() {
        var bostamp = jQuery("#bo_bostamp").val().toString().trim();
        DesejaContinuar("<?= lang('ask_close_order') ?>", function (result) {
            jQuery(".loading-overlay").show();
            jQuery.post('<?= base_url(); ?>' + 'ajax/status_fechar_encomenda', {bostamp: bostamp}, function (response) {
            }, 'json').done(function (response) {
                $(".openbut").removeClass('hidden');
                $(".closebut").addClass('hidden');
                $(".orderSatus").val('<?= lang('STATUS_CONCLUDED') ?>');
                $(".savebut").addClass('hidden');
                $(".selectBut").addClass('hidden');
                jQuery(".loading-overlay").hide();
                toastr.success('<?= lang('order_close_success') ?>')
            });
        }, function (result) {});
    }

    function saveOrder() {
        jQuery(".loading-overlay").show();
        jQuery('.enclinhas tbody tr').each(function () {
            var linha_ref = jQuery(this).children().eq(0).find("a").html().toString().trim();
            var qtt = parseFloat(jQuery(this).children().eq(3).html().toString().trim());
            var ul = parseFloat(jQuery(this).children().eq(2).html().toString().trim());
            var qtt_satisf = parseFloat(jQuery(this).children().eq(7).find("input").val());
            var bostamp = jQuery("#bo_bostamp").val().toString().trim();
            var cur_row = jQuery(this);

            if (linha_ref != "") {

                var stamp = jQuery(this).children().eq(0).find('a').attr("data-stamp").toString().trim();

                if (ul === 0) {
                    jQuery.post('<?= base_url(); ?>' + 'ajax/save_update_linha_encomenda', {stamp: stamp, bostamp: bostamp, qtt: qtt, qtt_satisf: qtt_satisf}, function (response) {
                    }, 'json').done(function (response) {});
                } else if (ul === 1) {
                    if (stamp.length) {
                        jQuery.post('<?= base_url(); ?>' + 'ajax/save_update_linha_encomenda', {stamp: stamp, bostamp: bostamp, qtt: qtt, qtt_satisf: qtt_satisf}, function (response) {
                        }, 'json').done(function (response) {

                        });
                    } else {
                        jQuery.post('<?= base_url(); ?>' + 'ajax/save_new_linha_encomenda', {bostamp: bostamp, ref: linha_ref, qtt: qtt, qtt_satisf: qtt_satisf}, function (response) {
                        }, 'json').done(function (response) {
                            cur_row.children().eq(0).find('a').attr("data-stamp", response);
                        });
                    }
                }
            }
        });
        jQuery(".loading-overlay").hide();
        toastr.success('<?= lang('save_success') ?>')
    }

    function ProcessarLinhas(resp_ref, qtt_por_atribuir) {
        var encontrado = false;
        jQuery('.enclinhas tbody tr').each(function () {
            if (qtt_por_atribuir > 0) {
                var ref = jQuery(this).children().eq(0).find("a").html().toString().trim();
                var ul = parseFloat(jQuery(this).children().eq(2).html());
                var qtt_por_satisfazer_linha = parseFloat(jQuery(this).children().eq(8).html().toString().trim());

                if (resp_ref == ref && ul == 0 && qtt_por_satisfazer_linha > 0) {
                    if (qtt_por_atribuir <= qtt_por_satisfazer_linha) {
                        SetQttSatArtigo(jQuery(this).children().eq(7), qtt_por_atribuir);
                        qtt_por_satisfazer_linha = qtt_por_satisfazer_linha - qtt_por_atribuir;
                        qtt_por_atribuir = 0;
                    } else if (qtt_por_atribuir > qtt_por_satisfazer_linha) {
                        SetQttSatArtigo(jQuery(this).children().eq(7), qtt_por_satisfazer_linha);
                        qtt_por_atribuir = qtt_por_atribuir - qtt_por_satisfazer_linha;
                    }
                }
            }
        })

        if (qtt_por_atribuir > 0) {
            jQuery('.enclinhas tbody tr').each(function () {
                var ref = jQuery(this).children().eq(0).find("a").html().toString().trim();
                var ul = parseFloat($(this).children().eq(2).html());
                var qtt_por_satisfazer_linha = parseFloat(jQuery(this).children().eq(8).html().toString().trim());
                if (resp_ref == ref && ul == 1) {
                    SetQttSatArtigo(jQuery(this).children().eq(7), qtt_por_atribuir);
                    SetQttArtigo(jQuery(this).children().eq(3), qtt_por_atribuir);
                    qtt_por_satisfazer_linha = qtt_por_satisfazer_linha + qtt_por_atribuir;
                    qtt_por_atribuir = 0;
                    encontrado = true;
                }
            })
            if (encontrado == false) {
                DesejaContinuar('<?= lang('product_not_exist_new_line') ?>', function (result) {
                    nova_linha(resp_ref, qtt_por_atribuir, qtt_por_atribuir);
                }, function (result) {});
            }
        }
    }

    function SearchInsert() {
        var search = jQuery("#picksearch").val().replace(/[&\/\\#+()$~%.'":*?<>{}]/g, '');

        if (search.toString().trim().length) {
            $(".loading-overlay").show();

            res.get(search).done(function (response) {
                if (response.length) {
                    jQuery.each(response, function (i, val) {
                        var resp_ref = val["ref"].toString().trim()

                        var qtt_por_atribuir = 1;
                        if ($("#check_qtt").is(":checked")) {
                            PedirQtt("<?= lang('enter_quantity') ?>", function (result) {
                                qtt_por_atribuir = result;
                                ProcessarLinhas(resp_ref, qtt_por_atribuir);
                            });
                        } else {
                            ProcessarLinhas(resp_ref, qtt_por_atribuir);
                        }
                    });
                }
                jQuery("#picksearch").val("");
                $(".loading-overlay").hide();
            });
        } else {
            toastr.error('<?= lang('field_not_empty_invalid_char') ?>');
        }
    }

    function nova_linha(search, qtd_lida, qtd_satisfeita) {
        var bostamp = $("#bo_bostamp").val().toString().trim();
        var counter = 0;
        var qtt_satisfeita = parseFloat(qtd_satisfeita).toFixed(2);
        var qtt_lida = parseFloat(qtd_lida).toFixed(2);
        $.post('<?= base_url(); ?>' + 'ajax/get_artigo', {ref: search}, function (response) {
        }, 'json').done(function (response) {
            var ststamp = response[0]['ststamp'];
            var ref = response[0]['ref'];
            var design = response[0]['design'];
            var epv1 = parseFloat(response[0]['epv1']).toFixed(2);
            var ettdeb = (qtt_lida * epv1).toFixed(2);
            var base = '<?= base_url(); ?>';
            var url = base + 'ajax/artigo/' + ststamp;

            var newRow = $("<tr>");
            var col = "";

            col += '<th scope="row"><a data-stamp="" onclick="ModalAjax(' + url + ', Artigo' + search + ')" >' + search + '</a></th>';
            col += '<td>' + design + '</td>';
            col += '<td>1</td>';
            col += '<td>' + qtt_lida + '</td>';
            col += '<td>' + epv1 + '</td>';
            col += '<td>0.00</td>';
            col += '<td>' + ettdeb + '</td>';
            if (qtt_satisfeita == 0) {
                col += '<td class=""><input type="number" min="0" max="' + qtt_lida + '" step="1" class="form-control decimal_input" value="0.00"></td>';
                col += '<td class="bg-danger">' + qtt_lida + '</td>'
            } else {
                col += '<td class=""><input type="number" min="0" max="' + qtt_lida + '" step="1" class="form-control decimal_input" value="' + qtt_satisfeita + '"></td>';
                col += '<td class="bg-success">0.00</td>'
            }

            newRow.append(col);
            $("table.table-bordered.enclinhas").append(newRow);
            counter++;

            jQuery('.enclinhas tfoot tr').each(function () {
                var total = parseFloat($(this).children().eq(1).html());
                var qtd_falta = parseFloat($(this).children().eq(3).html());

                var total_new = (parseFloat(total) + parseFloat(ettdeb)).toFixed(2);
                var qtd_falta_new = (parseFloat(qtd_falta) + parseFloat(qtt_lida)).toFixed(2);

                $(this).children().eq(1).html(total_new);
                $(this).children().eq(3).html(qtd_falta_new);
            });
        });
    }
</script>