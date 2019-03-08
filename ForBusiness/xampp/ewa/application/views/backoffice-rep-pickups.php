<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
    <div class="col-md-12 col-sm-12">
        <h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
    </div>
</div>
<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
    <div class="panel panel-default">
        <div class="col-xs-12">
            <form action="#" class="form-horizontal group-border-dashed clearfix" >
                <div class="form-group">
                    <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Initial Date", $_SESSION['lang_u']); ?></label>
                    <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                        <input type="date" class="form-control" id="date_i" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Final Date", $_SESSION['lang_u']); ?></label>
                    <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                        <input type="date" class="form-control" id="date_f" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Initial Hour", $_SESSION['lang_u']); ?></label>
                    <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                        <input data-inputmask="'mask': '29:59'" style="width:100px" type="text" id="hour_i" class="form-control" value="00:00" />
                    </div>
                    <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Final Hour", $_SESSION['lang_u']); ?></label>
                    <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                        <input data-inputmask="'mask': '29:59'" style="width:100px" type="text" id="hour_f" class="form-control" value="23:59" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Zone", $_SESSION['lang_u']); ?></label>
                    <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                        <select class="form-control" id="zone" name="">
                            <option value=""></option>
                            <?php foreach ($pickups_zones as $pickups_zone) { ?>
                                <option value="<?php echo $pickups_zone["u_pickup_zonestamp"]; ?>"><?php echo $pickups_zone["name"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Pickup", $_SESSION['lang_u']); ?></label>
                    <div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
                        <select class="form-control" id="pickup" name="">
                            <option value=""></option>
                            <?php foreach ($pickups as $pickup) { ?>
                                <option value="<?php echo $pickup["u_pickupstamp"]; ?>"><?php echo $pickup["name"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary col-lg-12" onclick="atualiza_tabela(); return false;"><i class="white halflings-icon search"></i><?php echo $this->translation->Translation_key("Name", $_SESSION['lang_u']); ?>Mostrar</button>
                </div>
                <button type="button" id="btnConfig" class="btn btn-xs btn-primary pull-right"><i class="fa fa-gears"></i> <?php echo $this->translation->Translation_key("Configuration", $_SESSION['lang_u']); ?></button>
                <br>
                <div class="clearfix"></div>
                <br>
            </form>
            <table id="tab-pp" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th data-name="<?php
                        $_SESSION['fields'] = null;
                        $i = 0;
                        $_SESSION['fields'][$i] = $this->translation->Translation_key("Zone", $_SESSION['lang_u']);
                        ?>"id="<?php echo $i++; ?>"><?php echo $this->translation->Translation_key("Zone", $_SESSION['lang_u']); ?></th>
                        <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Pickup", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>"><?php echo $this->translation->Translation_key("Pickup", $_SESSION['lang_u']); ?></th>
                        <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Date", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>"><?php echo $this->translation->Translation_key("Date", $_SESSION['lang_u']); ?></th>
                        <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Session", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>"><?php echo $this->translation->Translation_key("Session", $_SESSION['lang_u']); ?></th>
                        <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Name", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>"><?php echo $this->translation->Translation_key("Name", $_SESSION['lang_u']); ?></th>
                        <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Room", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>"><?php echo $this->translation->Translation_key("Room", $_SESSION['lang_u']); ?></th>
                        <th data-name="<?php $_SESSION['fields'][$i] = $this->translation->Translation_key("Qtt", $_SESSION['lang_u']); ?>" id="<?php echo $i++; ?>">Qtt</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-center" id="total_qtt">Total Qtt</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal fade bs-example-modal-sm" id="listTh" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">

</div>
<script>
    var table = $('#tab-pp');
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
                {"className": "text-center", "targets": [5, 6]},
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
                    text: '<i class="fa fa-copy"></i> Copy',
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
                    text: '<i class="fa fa-print"></i> Print',
                    titleAttr: 'Print'
                }
            ],
            "autoWidth": false,
            "ordering": false
        });
        atualiza_tabela();
    })

    function atualiza_tabela()
    {
        $(".loading-overlay").show();

        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>backoffice/ajax/get_rep_pickups",
            data: {
                "date_i": jQuery("#date_i").val().replace(/\-/g, ''),
                "date_f": jQuery("#date_f").val().replace(/\-/g, ''),
                "zone": jQuery("#zone").val(),
                "pickup": jQuery("#pickup").val(),
                "hour_i": jQuery("#hour_i").val(),
                "hour_f": jQuery("#hour_f").val()
            },
            success: function (data)
            {
                data = JSON.parse(data);

                t.clear().draw();

                var total_qtt = 0;

                $.each(data, function (index, value) {
                    var dados = new Array();
                    dados.push(value["zone"]);
                    dados.push(value["pickup"]);
                    dados.push(value["date"].substr(0, 10));
                    dados.push(value["session"]);
                    dados.push(value["name"]);
                    dados.push(value["room"]);
                    dados.push(parseFloat(value["qtt"]).toFixed(2));

                    t.row.add(dados).draw();
                    total_qtt = parseFloat(total_qtt) + parseFloat(value["qtt"]);

                });

                $("#total_qtt").html(parseFloat(total_qtt).toFixed(2));

                $("#select_all").prop("checked", false);
                $(".loading-overlay").hide();
            }
        });
    }
</script>
