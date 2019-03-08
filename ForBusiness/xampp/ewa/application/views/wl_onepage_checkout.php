<?php
//ONE PAGE CHECKOUT
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<div class="col-lg-12">
    <div data-alerts="alerts" data-titles="" data-ids="myid" data-fade="3000"></div>
    <legend><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Checkout'); ?></legend>

    <div class="col-lg-12">

        <div class="row rowStep1">
            <div class="checkoutCont">
                <div class="headingWrap">
                    <h3 class="headingTop text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Insert Client Personal Data'); ?></h3>	
                </div>
                <form id='client_data_form' data-toggle="validator" role="form">
                    <div class="form-group">
                        <label for="client_name"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Name'); ?></label>
                        <input type="text" class="form-control" id="client_name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="client_address"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Address'); ?></label>
                        <input type="text" class="form-control" id="client_address" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <label for="client_postcode"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Post Code'); ?></label>
                        <input type="text" class="form-control" id="client_postcode" placeholder="Post Code">
                    </div>
                    <div class="form-group">
                        <label for="client_city"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'City'); ?></label>
                        <input type="text" class="form-control" id="client_city" placeholder="City">
                    </div>
                    <div class="form-group">
                        <label for="client_country"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Country'); ?></label>
                        <select id="client_country" name="client_country" class="input-medium bfh-countries form-control input-md" data-country="PT"></select>
                    </div>
                    <div class="form-group">
                        <label for="client_country"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Phone Number'); ?></label>
                        <input type="text" class="form-control" id="client_phone" placeholder="Phone Number">
                    </div>
                    <div class="form-group">
                        <label for="client_vat"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Tax identification number'); ?></label>
                        <input type="text" class="form-control" id="client_vat" placeholder="Tax identification number">
                    </div>
                    <div class="form-group">
                        <label for="client_email"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Email address'); ?></label>
                        <input type="email" class="form-control" id="client_email" required placeholder="Email address">
                    </div>
                </form>
            </div>
        </div>

        <div class="checkoutCont">
            <div class="headingWrap">
                <h3 class="headingTop text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Select Your Payment Method'); ?></h3>	
            </div>
            <div class="checkoutWrap">
                <div class="btn-group checkoutBtnGroup btn-group-justified" data-toggle="buttons">
                    <?php
                    $active = "active";
                    $def_payment_id = "";
                    foreach ($PaymentMethods as $PaymentMethod) {
                        if ($def_payment_id == "")
                            $def_payment_id = $PaymentMethod["id"];
                        ?>
                        <div class="col-lg-12 nomarginpadding">
                            <div class="col-lg-2 centered">
                                <label payment_id="<?php echo $PaymentMethod["id"]; ?>" class="btn paymentMethod <?php echo $active; ?>">
                                    <div class="method" style="background-image: url('<?php echo base_url() . $PaymentMethod["img_path"]; ?>'); max-width:100%;"></div>
                                    <input type="radio" name="payment_method" value="<?php echo $PaymentMethod["id"]; ?>" checked> 
                                </label>
                            </div>
                            <div class="col-lg-10 text-left nomarginpadding">
                                <div class="col-lg-12 text-left PaymentName nomarginpadding">
                                    <b><?php echo $PaymentMethod["name"]; ?></b>
                                </div>
                                <div style="margin-top:15px;" class="col-lg-12 text-left nomarginpadding">
                                    <?php echo $PaymentMethod["desc"]; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $active = '';
                    }
                    ?>
                    <div class="col-lg-12 nomarginpadding">
                        <div class="col-lg-2 centered">
                            <label payment_id="4" class="btn paymentMethod">
                                <div class="method" style="background-image: url('<?php echo base_url(); ?>img/multibanco.png'); max-width:100%;"></div>
                                <input type="radio" name="payment_method" value="4" checked> 
                            </label>
                        </div>
                        <div class="col-lg-10 text-left nomarginpadding">
                            <div class="col-lg-12 text-left PaymentName nomarginpadding">
                                <b>Multibanco - TPA</b>
                            </div>
                            <div style="margin-top:15px;" class="col-lg-12 text-left nomarginpadding">
                                Multibanco - TPA
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 nomarginpadding">
                        <div class="col-lg-2 centered">
                            <label payment_id="5" class="btn paymentMethod">
                                <div class="method" style="background-image: url('<?php echo base_url(); ?>img/cash.png'); max-width:100%;"></div>
                                <input type="radio" name="payment_method" value="5" checked> 
                            </label>
                        </div>
                        <div class="col-lg-10 text-left nomarginpadding">
                            <div class="col-lg-12 text-left PaymentName nomarginpadding">
                                <b><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Cash'); ?></b>
                            </div>
                            <div style="margin-top:15px;" class="col-lg-12 text-left nomarginpadding">
                                <?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Cash'); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function cart_refresh(obj) {
            obj.parent().children().eq(1).fadeIn('slow');
        }
    </script>


    <div class="checkoutCont">
        <div class="headingWrap">
            <h3 class="headingTop text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Confirm your order'); ?></h3>	
        </div>
        <div class="ajaxcart">
            <?php echo $this->template->partial->view('wl_cart', $data = array(), $overwrite = true); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="checkoutCont">

        <?php if ($_SESSION['type'] == 'agent') { ?>

            <div class="footerNavWrap clearfix ButStep3 ">
                <form id="cart-form" method="POST" accept-charset="UTF-8" action="<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout_confirm">
                    <input type="hidden" name="PaymentType" value="<?php echo $def_payment_id; ?>"/>
                    <input type="hidden" name="pay_client_name" value=""/>
                    <input type="hidden" name="pay_client_address" value=""/>
                    <input type="hidden" name="pay_client_postcode" value=""/>
                    <input type="hidden" name="pay_client_city" value=""/>
                    <input type="hidden" name="pay_client_country" value=""/>
                    <input type="hidden" name="pay_client_phone" value=""/>
                    <input type="hidden" name="pay_client_vat" value=""/>
                    <input type="hidden" name="pay_client_email" value=""/>
                    <input type="hidden" name="pay_transaction_id" value=""/>
                    <input type="hidden" name="pay_checked_cash" value=""/>
                    <input type="hidden" name="pay_parcial" value="0"/>
                    <div onclick="agent_payment_validation();" class="btn pull-right btn-fyi"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'CONFIRM'); ?> <span class="glyphicon glyphicon-ok"></span></div>
                </form>

            </div>
        <?php } ?>

    </div>
</div>
<div class="row    style="margin-bottom:15px;">
     <div class="pull-left" style="margin-right:15px;">
        <img src="<?php echo base_url() ?>img/redunicre.png" border="0" style="height:184px">
    </div>
    <div class="pull-left" style="margin-right:15px;">
        <a onclick="verified_popup()"><img class="" src="<?php echo base_url() ?>img/VerifiedByVisa-Learnmore.gif" border="0" style="height:88px;margin-bottom:5px;"></a><br>
        <a onclick="return windowpop('http://www.mastercard.com/us/business/en/corporate/securecode/sc_popup.html?language=pt', 560, 400)">
            <img class="" src="<?php echo base_url() ?>img/sc_learn_156x83.gif" border="0" style="height:88px">
        </a>
    </div>
</div>
</div>
</div>

<script>
    function windowpop(url, width, height) {
        var leftPosition, topPosition;
        //Allow for borders.
        leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
        //Allow for title and status bars.
        topPosition = (window.screen.height / 2) - ((height / 2) + 50);
        //Open the window.
        window.open(url, "Window2", "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
    }

    function verified_popup() {
        var dialog = bootbox.dialog({
            message: '<p class="text-center"><img class="" src="<?php echo base_url() ?>img/verified1.png" border="0"></p>',
            closeButton: true,
            onEscape: true,
            backdrop: true
        });
    }

    function checkvoucher() {
        var voucher_code = jQuery("#vouchercode").val().toString().trim();

        if (voucher_code != "") {

            $("body").LoadingOverlay("show");

            $.ajax({
                method: 'POST',
                data: {"bostamp": "<?php echo $reservation_bostamp; ?>", "voucher": voucher_code, "op":<?php echo $op; ?>},
                datatype: "json",
                url: '<?php echo base_url(); ?>calendar/check_voucher_wl',
                success: function (data) {
                    data = JSON.parse(data);

                    if (data['success'] == 1) {
                        $("body").LoadingOverlay("hide");

                        jQuery("#voucher_row").css("display", "table-row");
                        jQuery("#voucher_row").children().eq(1).html(voucher_code);

                        jQuery(document).trigger("set-alert-id-voucher_alert", [
                            {
                                "message": data['message'],
                                "priority": 'success'
                            }
                        ]);

                        $.ajax({
                            method: 'POST',
                            data: {},
                            url: '<?php echo base_url(); ?>wl/<?php echo $op; ?>/print_cart',
                            success: function (data) {
                                $(".ajaxcart").html(data);
                            }
                        });
                    } else {
                        $("body").LoadingOverlay("hide");

                        jQuery("#voucher_row").css("display", "none");
                        jQuery("#voucher_row").children().eq(1).html("");

                        jQuery(document).trigger("set-alert-id-voucher_alert", [
                            {
                                "message": data['message'],
                                "priority": 'error'
                            }
                        ]);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    jQuery("#voucher_row").css("display", "none");
                    jQuery("#voucher_row").children().eq(1).html("");
                    $("body").LoadingOverlay("hide");
                }
            });
        } else {
            jQuery(document).trigger("set-alert-id-voucher_alert", [
                {
                    "message": "You must enter a voucher's code",
                    "priority": 'error'
                }
            ]);
        }
    }

    function agent_payment_validation() {
        var check_amount = checkOrderAmount();

        if (check_amount) {
            alert("Sorry, you can not finalize the purchase because the purchase value must be greater than 0.");
            return false;
        } else {
            var payment_id = jQuery("input[name='PaymentType']").val();

            jQuery("input[name='pay_client_name']").val(jQuery("#client_name").val());
            jQuery("input[name='pay_client_address']").val(jQuery("#client_address").val());
            jQuery("input[name='pay_client_postcode']").val(jQuery("#client_postcode").val());
            jQuery("input[name='pay_client_city']").val(jQuery("#client_city").val());
            jQuery("input[name='pay_client_country']").val(jQuery("#client_country").val());
            jQuery("input[name='pay_client_phone']").val(jQuery("#client_phone").val());
            jQuery("input[name='pay_client_vat']").val(jQuery("#client_vat").val());
            jQuery("input[name='pay_client_email']").val(jQuery("#client_email").val());
            jQuery("input[name='pay_transaction_id']").val(jQuery("#info_payment_4_val").val());
            jQuery("input[name='pay_checked_cash']").val(jQuery("#info_payment_5_val").val());

            if (payment_id == 4) {
                jQuery("#cart-form").attr("action", "<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout_confirm_tpa_cash");
                $('.info_payment_4').validator()
                result = true;
                $('.info_payment_4').validator('validate');
                $('.info_payment_4 .form-group').each(function () {
                    if ($(this).hasClass('has-error')) {
                        result = false;
                    }
                });
                if (result) {
                    $('#cart-form').submit();
                }
            } else if (payment_id == 5) {
                jQuery("#cart-form").attr("action", "<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout_confirm_tpa_cash");
                $('.info_payment_5').validator()
                result = true;
                $('.info_payment_5').validator('validate');
                $('.info_payment_5 .form-group').each(function () {
                    if ($(this).hasClass('has-error')) {
                        result = false;
                    }
                });

                if (checkplafond() == "false") {
                    result = false;
                }

                if ($('#info_payment_5_val').prop("checked") == false) {
                    result = false;
                }
                if (result) {
                    $('#cart-form').submit();
                }
            } else if (payment_id == 6) {
                jQuery("#cart-form").attr("action", "<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout_confirm_agent");
                $('#cart-form').submit();
            } else if (payment_id == 1 || payment_id == 3) {
                jQuery("#cart-form").attr("action", "<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout_confirm_agent");
                $('#cart-form').submit();
            }
        }
    }

    jQuery("label.paymentMethod").click(function () {
        var pay_meth = jQuery(this).find("input").val();
        jQuery("[name='PaymentType']").val(pay_meth);
        if (pay_meth == 4) {
            jQuery(".info_payment_4").removeClass("hide");
            jQuery(".info_payment_5").addClass("hide");
        } else if (pay_meth == 5) {
            jQuery(".info_payment_4").addClass("hide");
            jQuery(".info_payment_5").removeClass("hide");
        } else {
            jQuery(".info_payment_4").addClass("hide");
            jQuery(".info_payment_5").addClass("hide");
        }

        if (pay_meth != 5) {
            jQuery("[name='pay_parcial']").val(0);
        }
    })

    jQuery(document).ready(function () {
        $('#client_data_form').validator()
        $("#cart-form").on("submit", function () {
            var payment_id = jQuery("input[name='PaymentType']").val();

<?php
if (isset($_SESSION["type"]) && $_SESSION["type"] == "client" && isset($user) &&
        (
        trim(trim($user["invoice_address_street"]) . " " . trim($user["invoice_address_addinfo"])) == "" ||
        trim($user["phone_no"]) == "" ||
        trim($user["email"]) == "" ||
        trim(trim($user["first_name"]) . " " . trim($user["last_name"])) == ""
        )) {
    ?>
                if (payment_id == 1) {
                    var dialog = bootbox.dialog({
                        message: '<p class="text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Sorry, when credit card payment is selected, you must have filled in your name, address, phone number and email address in the customer area.'); ?></p>',
                        closeButton: true,
                        onEscape: true,
                        backdrop: true,
                        buttons: {
                            confirm: {
                                label: 'Client Area',
                                className: 'btn-success',
                                callback: function (result) {
                                    window.location.href = "<?php echo base_url() ?>wl/<?php echo $op; ?>/account?rdr=c";
                                }
                            },
                            cancel: {
                                label: 'Close',
                                className: 'btn-danger'
                            }
                        }
                    });

                    return false;
                }
<?php } ?>

<?php if (isset($_SESSION["type"]) && $_SESSION["type"] == "agent") { ?>
                if (payment_id == 1 && (jQuery("#client_name").val().toString().trim().length == 0 || jQuery("#client_address").val().toString().trim().length == 0 || jQuery("#client_email").val().toString().trim().length == 0 || jQuery("#client_phone").val().toString().trim().length == 0)) {
                    var dialog = bootbox.dialog({
                        message: '<p class="text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Sorry, when credit card payment is selected, you must have filled in client name, address, phone number and email address.'); ?></p>',
                        closeButton: true,
                        onEscape: true,
                        backdrop: true,
                        buttons: {
                            confirm: {
                                label: '<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Back to client data'); ?>',
                                className: 'btn-success',
                                callback: function (result) {
                                    GoToStep(2);

                                }
                            },
                            cancel: {
                                label: '<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Back to payment method'); ?>',
                                className: 'btn-success',
                                callback: function (result) {
                                    GoToStep(2);
                                }
                            }
                        }
                    });

                    return false;
                }
<?php } ?>

<?php if (isset($_SESSION["type"]) && $_SESSION["type"] == "client") { ?>
                if (parseFloat($(".total_val").attr("total")) >= 1000 && '<?php echo trim($user["invoice_address_street"]); ?>' == '') {
                    alert("<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Homepage'); ?>Sorry, you can not finalize the purchase because you must have filled in the address when the purchase value is greater than or equal to 1000.");
                    return false;
                }
<?php } else if (isset($_SESSION["type"]) && $_SESSION["type"] == "agent") {
    ?>
                if (parseFloat($(".total_val").attr("total")) >= 1000 && jQuery("#client_address").val().toString().trim() == '') {
                    alert("<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Homepage'); ?>Sorry, you can not finalize the purchase because you must have filled in the address when the purchase value is greater than or equal to 1000.");
                    return false;
                }
<?php } else {
    ?>
                return false;
<?php } ?>
        })
    })

    function GoToStep(num) {
        if (num == 2) {
<?php
if ($_SESSION['type'] == 'agent') {
    ?>
                result = true;
                $('#client_data_form').validator('validate');
                $('#client_data_form .form-group').each(function () {
                    if ($(this).hasClass('has-error')) {
                        result = false;
                    }
                });
                if (result) {
    <?php
}
?>
                jQuery(".bs-wizard").children().eq(0).removeClass("disabled");
                jQuery(".bs-wizard").children().eq(0).removeClass("complete");
                jQuery(".bs-wizard").children().eq(1).removeClass("disabled");
                jQuery(".bs-wizard").children().eq(1).removeClass("complete");
                jQuery(".bs-wizard").children().eq(2).removeClass("disabled");
                jQuery(".bs-wizard").children().eq(2).removeClass("complete");

                jQuery(".bs-wizard").children().eq(0).addClass("complete");
                jQuery(".bs-wizard").children().eq(1).addClass("complete");
                jQuery(".bs-wizard").children().eq(2).addClass("disabled");





            }

        }

    }
</script>