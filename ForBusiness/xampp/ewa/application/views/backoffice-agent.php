<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
    <div class="col-md-12 col-sm-12">
        <h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
        <button type="button" id="save" class="btn btn-info pull-right"><?php echo $this->translation->Translation_key("SAVE", $_SESSION['lang_u']); ?></button>
        <?php if ($acesso_assign_products) { ?>
            <a onclick="edit_item(2); return false;" type="button" class="btn btn-info pull-right"	style="margin-right:15px;"><?php echo $this->translation->Translation_key("Assign Products", $_SESSION['lang_u']); ?></a>
        <?php }
        if ($dissociate_op_agent) {
            ?>
            <a onclick="dissociate_op_agent(); return false;" type="button" class="btn btn-info pull-right"	style="margin-right:15px;"><?php echo $this->translation->Translation_key("Dissociate Agent", $_SESSION['lang_u']); ?></a>
        <?php }
        if ($acesso_manage_fees) {
            ?>
            <a onclick="edit_item(1)" type="button" class="btn btn-info pull-right" style="margin-right:15px;"><?php echo $this->translation->Translation_key("Manage Fees", $_SESSION['lang_u']); ?> / <?php echo $this->translation->Translation_key("Cash Parcial Payment", $_SESSION['lang_u']); ?></a>
<?php } ?>
        <a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span><?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?> </a>				
    </div>
</div>
<p style="margin-bottom:5px"></p>
<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
    <div class="panel panel-default">
        <div class="col-md-11">
            <div class="panel panel-default">
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Name", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8"><input id="nome" type="text" name="nome" class="form-control activeInput" value="<?php echo $agent[0]['nome']; ?>" readonly></div>
                </div>
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Agent", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8"><input id="ncont" type="text" name="ncont" class="form-control activeInput" value="<?php echo $agent[0]['ncont']; ?>" readonly></div>
                </div>
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Address", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8"><input id="morada" type="text" name="morada" class="form-control activeInput" value="<?php echo $agent[0]['morada']; ?>" readonly></div>
                </div>
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("City", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8"><input id="local" type="text" name="local" class="form-control activeInput" value="<?php echo $agent[0]['local']; ?>" readonly></div>
                </div>
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("PostCode", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8"><input id="codpost" type="text" name="local" class="form-control activeInput" value="<?php echo $agent[0]['codpost']; ?>" readonly></div>
                </div>
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Email", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8"><input id="email" type="text" name="email" class="form-control activeInput" value="<?php echo $agent[0]['email']; ?>" readonly></div>
                </div>
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Phone", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8"><input id="tlmvl" type="TEXT" name="tlmvl" class="form-control activeInput" value="<?php echo $agent[0]['tlmvl']; ?>" readonly></div>
                </div>
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Location", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8">
                        <select class="form-control" id="u_local" name="u_local">
                            <option value=""></option>
                            <?php foreach ($locations as $location) { ?>
                                <option value="<?php echo trim($location["u_locationstamp"]); ?>" <?php echo trim($location["u_locationstamp"]) == trim($agent[0]["gsecstamp"]) ? "selected" : ""; ?>><?php echo trim($location["name"]); ?></option>
<?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Cash Plafond", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8"><input id="plafond" type="number" min="0" name="plafond" class="form-control activeInput" value="<?php echo number_format($agent[0]['cashplafond'], 2, '.', ''); ?>" ></div>
                </div>
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Selling Limit", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8"><input id="limitevenda" type="number" min="0" name="limitevenda" class="form-control activeInput" value="<?php echo number_format($agent[0]['limitevenda'], 2, '.', ''); ?>" ></div>
                </div>
                <div class="form-group col-sm-6" style="height: 68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Automatic Invoice", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8">
                        <input id="faturaauto" type="checkbox" data-on="Enabled" data-off="Disabled" <?php echo $agent[0]['faturaauto'] ? "checked" : ""; ?> data-toggle="toggle">
                    </div>
                </div>
                <div class="form-group col-sm-6" style="height:68px;">
                    <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Checkout Type", $_SESSION['lang_u']); ?></label>
                    <div class="col-sm-8">
                        <input id="onepagecheckout" type="checkbox" data-on="One Page" data-off="Step"  <?php echo $agent[0]['onepage_checkout'] ? "checked" : ""; ?> data-toggle="toggle">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
</div>

<form method="post" id="theForm" action="">
    <input id="theFormid" type="hidden" name="id" value="1">
</form>
<script>
    function edit_item(id) {
        $('#theFormid').val(id);
        $('#theForm').submit()
    }

    jQuery("#save").click(function () {
        $(".loading-overlay").show();
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>backoffice/ajax/update_agent",
            data: {
                "u_locationstamp": jQuery("#u_local").val(),
                "agent": '<?php echo $agent[0]['no']; ?>',
                "plafond": jQuery("#plafond").val(),
                "limitevenda": jQuery("#limitevenda").val(),
                "faturaauto": jQuery("#faturaauto").prop("checked"),
                "onepagecheckout": jQuery("#onepagecheckout").prop("checked")
            },
            success: function (data)
            {
                if (data == 1) {
                    $(".loading-overlay").hide();
                    jQuery(document).trigger("add-alerts", [
                        {
                            "message": "Agent updated successfully",
                            "priority": 'success'
                        }
                    ]);
                } else {
                    $(".loading-overlay").hide();
                    jQuery(document).trigger("add-alerts", [
                        {
                            "message": "Error updating agent",
                            "priority": 'error'
                        }
                    ]);
                }
            }
        });
    });

    function dissociate_op_agent() {
        bootbox.confirm({
            message: "Do you really want to dissociate this agent with your account? This procedure is irreversible!",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result2) {
                if (result2) {
                    $(".loading-overlay").show();
                    jQuery.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>backoffice/ajax/dissociate_op_agent",
                        data: {
                            "vat": '<?php echo $agent[0]['ncont']; ?>'
                        },
                        success: function (data)
                        {
                            data = JSON.parse(data);

                            if (data['success'] == 1) {
                                location.replace('<?php echo base_url(); ?>backoffice/agents');
                            } else {
                                $(".loading-overlay").hide();
                                jQuery(document).trigger("add-alerts", [
                                    {
                                        "message": data['message'],
                                        "priority": 'error'
                                    }
                                ]);
                            }
                        }
                    });
                }
            }
        });
    }
</script>
