<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>


<div class="row-fluid">
    <table id="TabMetaTags" class="table table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Content</th>
                <th></th>
            </tr>
        </thead>   
        <tbody>
        </tbody>
    </table>
</div>
<form method="post" id="theForm" action="metatagnew">
    <input id="theFormid" type="hidden" name="id" value="1">
</form>
<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>

    $("#delete").click(function (event) {
        var values = new Array();
        $.each($("input:checkbox:checked"), function () {
            values.push($(this).attr('stamp'));
        });
        if (values.length <= 0) {
            alert("Select page!");
        } else {
            if (confirm("Are you sure?")) {
                $(".loading-overlay").show();
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>admin/ajax/delete_metatag",
                    data: {
                        "id": values
                    },
                    success: function (data)
                    {
                        $(".loading-overlay").hide();
                        location.reload();
                    }
                });
            }
        }

    });

    var table;

    $(document).ready(function () {
        table = $('#TabMetaTags').DataTable({
            dom: 'lBfrtip',
            buttons: [

            ],
            oLanguage: {
                sSearch: "Procurar:",
                oPaginate: {
                    sFirst: "Primeiro",
                    sLast: "Último",
                    sNext: "Seguinte",
                    sPrevious: "Anterior"
                },
                "sInfo": "A mostrar _START_ até _END_ registos de um total de _TOTAL_ registos",
                "sLengthMenu": "Mostrar _MENU_ registos"
            },
            "iDisplayLength": 100,
            sPaginationType: "full_numbers"
        });


        var obj = <?php echo json_encode($pages->result()); ?>;
        table.rows().remove().draw();

        $.each(obj, function (index, value) {
            var dados = new Array();
            dados.push("<div class='am-checkbox'><input stamp='" + value["id"] + "' id='check" + value["id"] + "' type='checkbox'><label for='check" + value["id"] + "'></label></div>");
            dados.push("<a onclick='edit_item(" + value["id"] + ")'>" + value["name"] + "</a>");
            dados.push(value["content"]);
            dados.push("<td'><div class='text-center'><a onclick='edit_item(" + value["id"] + ")' class='btn btn-default'><span class='glyphicon glyphicon-search'></span></a></div></td>");


            table.row.add(dados).draw();
        });
        table.columns.adjust();


    });


    function edit_item(id) {
        $('#theFormid').val(id);
        $('#theForm').submit();
    }



</script>


