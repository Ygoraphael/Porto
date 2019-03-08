<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<form class="config_check" method="">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button> 
                <h4 class="modal-title" id="mySmallModalLabel"><?php echo $this->translation->Translation_key("Config Fields", $_SESSION['lang_u']); ?></h4> 
            </div> 
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $content = '';
                        foreach ($_SESSION['fields'] as $key => $field) {
                            if (in_array($key, $_POST['fields'])) {
                                $fields['visible'][] = $key;
                                $check = 'checked';
                            } else {
                                $fields['invisible'][] = $key;
                                $check = '';
                            }
                            $content .= '<div class="form-group"><div class="am-checkbox clearfix">'
                                    . '<input name="' . $key . '" id="' . $key . $field . '" type="checkbox"' . $check . ' >'
                                    . '<label class="pull-left" for="' . $key . $field . '"></label>'
                                    . '<span style="float:left;">' . $field . '</span></div>'
                                    . '</div>';
                        }
                        $post['table'] = $_POST['table'];
                        $post['fields'] = $fields;
                        $post_encode = json_encode($post);
                        echo $content;
                        ?>
                    </div>
                </div>
            </div> 
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <small class=""><?php echo $this->translation->Translation_key("Choose the fields you want to see", $_SESSION['lang_u']); ?></small>
                    </div>
                    <br>
                    <br>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button type='button' class="save-fields btn btn-success pull-left"><?php echo $this->translation->Translation_key("Save", $_SESSION['lang_u']); ?></button>
                    </div>
                    <div class="col-lg-6">
                        <button type='button'id="save" data-dismiss="modal" aria-label="Close" class="btn btn-warning"><?php echo $this->translation->Translation_key("Cancel", $_SESSION['lang_u']); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<input type="hidden" id="config_fields" name="config_fields" value='<?php echo $post_encode
                        ?>'> 

<script type="text/javascript">
    $('.save-fields').click(function () {
        $(".config_check").submit();
    });
    $(".config_check").submit(function (event) {
        event.preventDefault();
        var form = JSON.stringify($(this).serializeToJSON());
        var fields = $('#config_fields').val();
        $.post("update_config_table", {form, field: fields}, function (data) {
        }).done(function () {
            window.location.reload();
        });
    });
</script>
