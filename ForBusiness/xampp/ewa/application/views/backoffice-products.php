<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
    <div class="col-md-12 col-sm-12">
        <h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
        <?php if ($acesso_create) { ?>
            <button type="button" id="create_prod" class="btn btn-info pull-right"><?php echo $this->translation->Translation_key("Create product", $_SESSION['lang_u']); ?></button>
        <?php } ?>
    </div>
</div>
<p style="margin-bottom:5px"></p>
<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
    <div class="col-lg-12">
        <table id="tab-products" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo $this->translation->Translation_key("Code", $_SESSION['lang_u']); ?></th>
                    <th><?php echo $this->translation->Translation_key("Name", $_SESSION['lang_u']); ?></th>
                    <th><?php echo $this->translation->Translation_key("City", $_SESSION['lang_u']); ?></th>
                    <th><?php echo $this->translation->Translation_key("Country", $_SESSION['lang_u']); ?></th>
                    <th><?php echo $this->translation->Translation_key("Adv. Price", $_SESSION['lang_u']); ?></th>
                    <th><?php echo $this->translation->Translation_key("Status", $_SESSION['lang_u']); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td><?php echo $product["u_uniqcode"]; ?></td>
                        <td><?php echo $product["u_name"]; ?></td>
                        <td><?php echo $product["u_city"]; ?></td>
                        <td><?php echo $product["u_country"]; ?></td>
                        <td><?php echo $product["u_advprice"]; ?></td>
                        <td><?php echo ($product["logi8"]) ? "Disabled" : "Approved"; ?></td>
                        <td class="text-center"><a href="<?php echo base_url(); ?>backoffice/product/<?php echo $product["u_sefurl"]; ?>" class="btn btn-default <?php echo ($acesso_view) ? "" : "disabled" ?>"><span class="glyphicon glyphicon-search"></span></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <script>
            jQuery(document).ready(function () {
                var mostrar = "<?php echo $this->translation->Translation_key("To show", $_SESSION['lang_u']); ?>";
                var ate = "<?php echo $this->translation->Translation_key("Until", $_SESSION['lang_u']); ?>";
                var corpo = "<?php echo $this->translation->Translation_key("Records of a total of", $_SESSION['lang_u']); ?>";
                var records = "<?php echo $this->translation->Translation_key("Records", $_SESSION['lang_u']); ?>";
                jQuery('#tab-products').DataTable({
                    dom: 'lBfrtip',
                    buttons: [],
                    oLanguage: {
                        sSearch: "<?php echo $this->translation->Translation_key("Search", $_SESSION['lang_u']); ?>:",
                        oPaginate: {
                            sFirst: "<?php echo $this->translation->Translation_key("First", $_SESSION['lang_u']); ?>",
                            sLast: "<?php echo $this->translation->Translation_key("Last", $_SESSION['lang_u']); ?>",
                            sNext: "<?php echo $this->translation->Translation_key("Next", $_SESSION['lang_u']); ?>",
                            sPrevious: "<?php echo $this->translation->Translation_key("Previous", $_SESSION['lang_u']); ?>"
                        },
                        "sInfo": mostrar + " _START_ " + ate + " _END_ " + corpo + " _TOTAL_ " + records,
                        "sLengthMenu": mostrar + " _MENU_ " + records
                    },
                    "iDisplayLength": 10,
                    sPaginationType: "full_numbers"

                });
            });

            jQuery("#create_prod").click(function () {
                bootbox.prompt("Enter product's name", function (result) {
                    if (result) {
                        $(".loading-overlay").show();

                        var user = '<?php echo $user['no']; ?>';
                        var user2 = '<?php echo $user['nome']; ?>';
                        var user3 = '<?php echo $user['estab']; ?>';

                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>backoffice/ajax/create_product",
                            data: {
                                "name": result,
                                "user": user,
                                "user2": user2,
                                "user3": user3
                            },
                            success: function (data)
                            {
                                data = JSON.parse(data);

                                if (data['success']) {
                                    window.location.href = '<?php echo base_url(); ?>backoffice/product/' + data['sefurl'];
                                } else {
                                    $(".loading-overlay").hide();
                                    jQuery(document).trigger("add-alerts", [
                                        {
                                            "message": "Error creating product",
                                            "priority": 'error'
                                        }
                                    ]);
                                }
                            }
                        });
                    }
                });
            });
        </script>
    </div>
</div>