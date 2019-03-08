<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="row">


    <?php if ($id_post != 0) { ?>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Detalhes</a></li>
        </ul>
        <form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Name</label>
                                            <div class="col-sm-9">
                                                <input id="name" type="text" class="form-control" value="<?php echo $tag_byid->name; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Content</label>
                                            <div class="col-sm-9">
                                                <input id="content" type="text" class="form-control" value="<?php echo $tag_byid->content; ?>">
                                            </div>
                                        </div>							
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <?php
    } else {
        ?>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Detalhes</a></li>
        </ul>
        <form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Name</label>
                                            <div class="col-sm-9">
                                                <input id="name" type="text" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Content</label>
                                            <div class="col-sm-9">
                                                <input id="content" type="text" class="form-control" value="">
                                            </div>
                                        </div>							
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </form>

<?php }
?>

</div>	


<form method="post" id="theForm" action="metatagnew">
    <input id="theFormid" type="hidden" name="id" value="1">
    <input id="theFormerror" type="hidden" name="error" value="1">
    <input id="text1" type="hidden" name="text1" value="">
    <input id="text2" type="hidden" name="text2" value="">
</form>												

<script src="<?php echo base_url(); ?>css/bo/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script>
    function criar_menuitem() {
        var name = $('#name').val();
        var content = $('#content').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("admin/create_metatag"); ?>',
            async: false,
            data: {name: name,
                content: content
            },
            success: function (data) {
                edit_item(data, 1, "Sucesso! ", "Metatag Inserida com successo");

            },
            error: function (data) {
                edit_item(data, 2, "Erro! ", "Falhou a inserir");
            }
        });
    }




    function update_menuitem() {
        var id =<?php
if (isset($tag_byid->id)) {
    echo $tag_byid->id;
} else {
    echo 0;
}
?>;
        var name = $('#name').val();
        var content = $('#content').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("admin/update_metatag"); ?>',
            async: false,
            data: {id: id,
                name: name,
                content: content
            },
            success: function (data) {
                edit_item(data, 1, "Sucesso! ", "Metatag Gravada com successo");

            },
            error: function (data) {
                edit_item(data, 2, "Erro! ", "Falhou ao Gravar!");
            }
        });
    }




    function edit_item(id, formerror, text1, text2) {
        $('#theFormid').val(id);
        $('#text1').val(text1);
        $('#text2').val(text2);
        $('#theFormerror').val(formerror);
        $('#theForm').submit();
    }


    $("#delete").click(function (event) {
        var values = new Array();
        var id =<?php
if (isset($tag_byid->id)) {
    echo $tag_byid->id;
} else {
    echo 0;
}
?>;
        values.push(id);
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
                    window.history.back();
                }
            });
        }
    });
</script>