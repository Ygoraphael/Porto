<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="col-lg-12">
    <div class="row setup-content">
        <div class="col-xs-12">
            <div class="col-md-12 well text-center">
                <form action="#" class="form-horizontal group-border-dashed clearfix" >
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Initial Date", $_SESSION['lang_u']); ?></label>
                        <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                            <input type="date" class="form-control" id="date_i" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Agent", $_SESSION['lang_u']); ?></label>
                        <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                            <select class="form-control" id="agen" name="">
                                <option value=""></option>
                                <?php foreach ($agents as $agent) { ?>
                                    <option value="<?php echo $agent["flstamp"]; ?>"><?php echo $agent["nome"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Final Date", $_SESSION['lang_u']); ?></label>
                        <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                            <input type="date" class="form-control" id="date_f" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Product", $_SESSION['lang_u']); ?></label>
                        <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                            <select class="form-control" id="prod" name="">
                                <option value=""></option>
                                <?php foreach ($products as $product) { ?>
                                    <option value="<?php echo $product["bostamp"]; ?>"><?php echo $product["u_name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Ticket Type", $_SESSION['lang_u']); ?></label>
                        <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                            <select class="form-control" id="tick" name="">
                                <option value=""></option>
                                <?php foreach ($u_tick as $tick) { ?>
                                    <option value="<?php echo $tick["ticket"]; ?>"><?php echo $tick["ticket"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Location", $_SESSION['lang_u']); ?></label>
                        <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                            <select class="form-control" id="local" name="">
                                <option value=""></option>
                                <?php foreach ($locations as $location) { ?>
                                    <option value="<?php echo $location["u_locationstamp"]; ?>"><?php echo $location["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary col-lg-12" onclick="atualiza_tabela(); return false;"><i class="white halflings-icon search"></i><?php echo $this->translation->Translation_key("Mostrar", $_SESSION['lang_u']); ?> </button>
                    </div>
                    <button type="button" id="btnConfig" class="btn btn-xs btn-primary pull-right"><i class="fa fa-gears"></i> <?php echo $this->translation->Translation_key("Configuration", $_SESSION['lang_u']); ?></button>
                    <br>
                    <div class="clearfix"></div>
                    <br>
                </form>
                <style>
                    #tab-p * {
                        font-size: 11px;
                    }

                    #tab-p tr {
                        padding:0;
                    }
                </style>
                <table id="tab-pf" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th data-name="<?php
                            $_SESSION['fields'] = null;
                            $i = 0;
                            $_SESSION['fields'][$i] = $this->translation->Translation_key("Date", $_SESSION['lang_u']);
                            ?>"id="<?php echo $i++; ?>">Date</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Client Email", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Client Email</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Origin", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Origin</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Qtt", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Qtt</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Product Name", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Product Name</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Unit Price Avg.", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Unit Price Avg.</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Total Sales", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Total Sales</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Agent Fees", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Agent Fees</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Booking Fees", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Booking Fees</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Qtt", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Transaction Fees</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Transaction Fees", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Total to pay</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Status", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Status</th>
                            <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Total to receive", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Total to receive</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center" id="total_qtt">Qtt</th>
                            <th></th>
                            <th class="text-center" id="total_avg"></th>
                            <th class="text-center" id="total_sales"></th>
                            <th class="text-center" id="ag_fees"></th>
                            <th class="text-center" id="book_fees"></th>
                            <th class="text-center" id="trans_fees"></th>
                            <th class="text-center" id="total_pay"></th>
                            <th></th>
                            <th class="text-center" id="total_rec"><?php echo $this->translation->Translation_key("Total to receive", $_SESSION['lang_u']); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal fade bs-example-modal-sm" id="listTh" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">

</div>
<script>
    var table = $('#tab-pf');
    $('#btnConfig').click(function () {
        var fields = getTh();
        var table_id = table.attr('id');

        $.post("check_fields", {fields: fields, table: table_id}, function (data) {
            $("#listTh").html(data);
        }).done(function () {
            $('#listTh').modal('show');
        });
    });
    function getTh() {
        var fields = [];
        table.find('thead th').each(function ()
        {
            fields.push($(this).attr('id'));
        });
        return fields;
    }
    var t;

    jQuery(document).ready(function () {
        t = table.DataTable({
            dom: 'lBfrtip',
            "columnDefs": [
                {
                    "targets": [
<?php
if (isset($_SESSION['fields'])) {
    $c = '';
    foreach ($fields as $col) {
        $c .= $col['colunn_key'] . ',';
    }
    echo $c;
}
?>
                    ],
                    "visible": false,
                    "searchable": false
                }

            ],
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="fa fa-copy"></i> Copiar',
                    titleAttr: 'Copy'
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-text-o"></i> CSV',
                    titleAttr: 'CSV'
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    titleAttr: 'PDF'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Imprimir',
                    titleAttr: 'Print'
                }
            ],
            "autoWidth": false
        });
        atualiza_tabela();
    })

    function atualiza_tabela()
    {
        $(".loading-overlay").show();

        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>backoffice/ajax/get_fees",
            data: {
                "date_i": jQuery("#date_i").val().replace(/\-/g, ''),
                "date_f": jQuery("#date_f").val().replace(/\-/g, ''),
                "agen": jQuery("#agen").val(),
                "prod": jQuery("#prod").val(),
                "tick": jQuery("#tick").val(),
                "local": jQuery("#local").val()
            },
            success: function (data)
            {
                data = JSON.parse(data);
                t.clear().draw();
                total_qtt = 0;
                total_avg = 0;
                total_sales = 0;
                ag_fees = 0;
                book_fees = 0;
                trans_fees = 0;
                total_pay = 0;
                total_rec = 0;

                $.each(data, function (index, value) {
                    var dados = new Array();

                    dados.push(value["fdata"].substr(0, 10));
                    dados.push(value["email"]);
                    dados.push(value["site"]);
                    dados.push(parseFloat(value["qtt"]).toFixed(2));
                    dados.push(value["pdnome"]);
                    dados.push(parseFloat(value["epv"]).toFixed(2));
                    dados.push(parseFloat(value["ettiliq"]).toFixed(2));
                    dados.push(parseFloat(value["agcom"]).toFixed(2));
                    dados.push(parseFloat(value["s4bcom"]).toFixed(2));
                    dados.push(parseFloat(value["s4pcom"]).toFixed(2));
                    dados.push(parseFloat(value["tpag"]).toFixed(2));
                    if (value["processado"] == 1)
                        dados.push('<i class="glyphicon glyphicon-ok" style="color:green;"></i>');
                    else
                        dados.push('<i class="glyphicon glyphicon-remove" style="color:red;"></i>');
                    dados.push(parseFloat(value["trec"]).toFixed(2));

                    total_qtt += parseFloat(value["qtt"]);
                    /*total_sales += parseFloat(value["ettiliq"]);
                     ag_fees += parseFloat(value["agcom"]);
                     book_fees += parseFloat(value["s4bcom"]);
                     trans_fees += parseFloat(value["s4pcom"]);
                     total_pay += parseFloat(value["tpag"]);*/
                    total_rec += parseFloat(value["trec"]);

                    t.row.add(dados).draw();
                });

                jQuery("#total_qtt").html(total_qtt.toFixed(2));
                /*jQuery("#total_sales").html(total_sales.toFixed(2));
                 if( total_qtt != 0 )
                 jQuery("#total_avg").html((total_sales/total_qtt).toFixed(2));
                 else
                 jQuery("#total_avg").html((0).toFixed(2));
                 jQuery("#ag_fees").html(ag_fees.toFixed(2));
                 jQuery("#book_fees").html(book_fees.toFixed(2));
                 jQuery("#trans_fees").html(trans_fees.toFixed(2));
                 jQuery("#total_pay").html(total_pay.toFixed(2));*/
                jQuery("#total_rec").html(total_rec.toFixed(2));

                $(".loading-overlay").hide();
            }
        });
    }
</script>
