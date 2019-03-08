<div id="sticky-anchor" class="hide"></div>
<div class="col-lg-12 calendar-top-container nomarginpadding">
    <div class="title1 text-center">
        <h3 class="card-header white-text"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Select date'); ?></h3>
    </div>
    <div class="control1 well">
        <div class="row">
            <div class="col-xs-6">
                <label class="control-label" for="dpd1">Check in: </label>
                <input class="form-control" type="text" id="dpd1" />
            </div>
            <div class="col-xs-6">
                <label class="control-label" for="dpd2">Check out: </label>
                <input class="form-control" type="text" id="dpd2" />
            </div>
        </div>
    </div>
    <div class="title2 text-center" style="display:none;">
        <h3 class="card-header white-text"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Select time'); ?></h3>
    </div>
    <div class="control2" style="display:none;">
        <div class="form-group">
            <div class="col-xs-12 nomarginpadding">
                <select class="form-control timecontrol" id="res_hour" name="res_hour"></select>
            </div>
        </div>
    </div>
    <div class="title3 text-center" style="display:none;">
        <h3 class="card-header white-text"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Select options'); ?></h3>
    </div>
    <div class="control3 calendar-price" style="display:none;">
        <br>
        <form class="form-horizontal">
            <?php
            foreach ($tickets as $ticket) {
                ?>
                <div class="form-group">
                    <label for="category" class="col-sm-4 control-label"><?php echo $this->googletranslate->translate($_SESSION["language_code"], $ticket["name"]); ?> </label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="<?php echo $ticket["ticket"]; ?>">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </span>
                            <input type="text" onchange="update_lotation(jQuery(this))" design="<?php echo $this->googletranslate->translate($_SESSION["language_code"], $ticket["name"]); ?>" name="<?php echo $ticket["ticket"]; ?>" class="form-control input-number calendar-cat-picker" value="0" min="0" max="99">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="<?php echo $ticket["ticket"]; ?>">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php
            if (sizeof($extras)) {
                ?>
                <div class="form-group">
                    <div class="text-left col-sm-12"><b><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Optional Extras'); ?></b></div>
                </div>
                <?php
                foreach ($extras as $extra) {
                    ?>
                    <div class="form-group">
                        <label for="category" class="col-sm-4 control-label"><?php echo $this->googletranslate->translate($_SESSION["language_code"], $extra["design"]); ?> <small>(<i class="fa"><?php echo $_SESSION["i"]; ?></i><?php echo number_format($extra["price"], 2, '.', ''); ?>)</small></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="<?php echo $extra["ref"]; ?>">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </span>
                                <input type="text" onchange="update_lotation(jQuery(this), 1)" name="<?php echo $extra["ref"]; ?>" design="<?php echo $this->googletranslate->translate($_SESSION["language_code"], $extra["design"]); ?>" price="<?php echo number_format($extra["price"], 2, '.', ''); ?>" class="form-control input-number calendar-extra-picker text-center" value="0" min="0" max="<?php echo ($extra["varbilh"]) ? "99" : "1"; ?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="<?php echo $extra["ref"]; ?>">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            if (sizeof($pickups)) {
                ?>
                <div class="form-group">
                    <label for="pickup" class="col-sm-4 control-label" style="padding-top: 9px;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'PICKUP'); ?></label>
                    <div class="col-sm-8">
                        <div class="input-group col-xs-12">
                            <select class="form-control col-xs-12" id="pickup">
                                <option value="" disabled="" selected=""><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'SELECT PICKUP'); ?></option>
                                <?php
                                foreach ($pickups as $pickup) {
                                    ?>
                                    <option value="<?php echo $pickup['u_pickupstamp']; ?>"><?php echo $pickup['name']; ?></option>
                                    <?php
                                }
                                ?>	
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pickup" class="col-sm-4 control-label" style="padding-top: 9px;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'ROOM'); ?></label>
                    <div class="col-sm-8">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control col-xs-12" id="room" />
                        </div>
                    </div>
                </div>
                <?php
            }
            if (sizeof($planguages)) {
                ?>
                <div class="form-group">
                    <label for="language" class="col-sm-4 control-label" style="padding-top: 9px;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'LANGUAGE'); ?></label>
                    <div class="col-sm-8">
                        <div class="input-group col-sm-12">
                            <select class="form-control" id="language">
                                <option value="" disabled="" selected=""><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'SELECT LANGUAGE'); ?></option>
                                <?php
                                foreach ($planguages as $planguage) {
                                    ?>
                                    <option value="<?php echo $planguage['code']; ?>"><?php echo $planguage['language']; ?></option>
                                    <?php
                                }
                                ?>	
                            </select>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </form>
    </div>
    
    <div class="col-lg-12 calendar-total" style="margin-top:15px; display:none;">
        <div class="price-breakdown-container">	
            <div data-alerts-container="danger " id="message_error" style="display:none;" class="alert alert-dismissable alert-danger ">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Sorry, there are no tickets available for this day'); ?>
            </div>
            <div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
            <p class="price-breakdown-title"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Price Breakdown'); ?></p>
            <div class="price-details price-details-line"></div>
            <div class="price-details" style="margin-top:15px;">
                <div class="calendar-price-total clearfix">
                    <span class="price-total pull-right"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'TOTAL PRICE'); ?>: <b></b></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-12 but-1" style="display:none;">
        <a onclick="step(2); controls(2);" class="btn btn-primary"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Continue'); ?></a>
    </div>
    <div class="col-lg-12 but-2" style="margin:15px 0px; display:none;">
        <a onclick="step(1); controls(1);" class="btn btn-primary"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Go Back'); ?></a>
        <a onclick="step(3); controls(3);" class="btn btn-primary"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Continue'); ?></a>
    </div>
    <div class="col-lg-12 but-3" style="margin:15px 0px; display:none;">
        <a onclick="step(2); controls(2);" class="btn btn-primary"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Go Back'); ?></a>
        <a onclick="fcheckout();" class="btn btn-primary btn-checkout"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'BUY NOW'); ?></a>
    </div>
    <form method="POST" id="checkout_form" action="<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout">
        <input type="hidden" name="reservation_type" />
        <input type="hidden" name="reservation_data" />
        <input type="hidden" name="reservation_date" />
        <input type="hidden" name="reservation_session" />
        <input type="hidden" name="reservation_bostamp" />
        <input type="hidden" name="reservation_room" />
        <input type="hidden" name="reservation_pickup" />
        <input type="hidden" name="reservation_language" />
    </form>

    <script>
        var checkin;
        var checkout;

        function fcheckout() {
            var numItems = $('.calendar-cat-picker').length;
            var u_qttmin = <?php echo $row['u_qttmin']; ?>;
            var qtt = 0;
            $(".calendar-cat-picker").each(function () {
                qtt += Number(jQuery(this).val());

            });
            if (qtt >= u_qttmin) {
                var res_data = new Array();
                var res_date = ("0" + (checkin.date.getMonth() + 1)).slice(-2) + '/' + ("0" + (checkin.date.getDate())).slice(-2) + '/' + checkin.date.getFullYear();;
                var res_session = $("#res_hour option:selected").attr("ses_id");
                var res_pickup = $("#pickup").val();
                var res_room = $("#room").val();
                var res_language = $("#language").val();

                $(".calendar-cat-picker").each(function () {
                    var seat = 'ND';
                    var type = jQuery(this).attr("name");
                    var qtt = jQuery(this).val();

                    if (type.trim().length > 0 && qtt > 0) {
                        var tmp_res_seats = new Array();
                        tmp_res_seats.push(seat.trim());
                        tmp_res_seats.push(type.trim());
                        tmp_res_seats.push(qtt);
                        tmp_res_seats.push(0);
                        res_data.push(tmp_res_seats);
                    }
                });

                $(".calendar-extra-picker").each(function () {
                    var seat = jQuery(this).attr("price");
                    var type = jQuery(this).attr("name");
                    var qtt = jQuery(this).val();

                    if (type.trim().length > 0 && qtt > 0) {
                        var tmp_res_seats = new Array();
                        tmp_res_seats.push(seat.trim());
                        tmp_res_seats.push(type.trim());
                        tmp_res_seats.push(qtt);
                        tmp_res_seats.push(1);
                        res_data.push(tmp_res_seats);
                    }
                });

                jQuery("input[name='reservation_pickup']").val(res_pickup);
                jQuery("input[name='reservation_room']").val(res_room);
                jQuery("input[name='reservation_language']").val(res_language);
                jQuery("input[name='reservation_data']").val(JSON.stringify(res_data));
                jQuery("input[name='reservation_type']").val('tickets');
                jQuery("input[name='reservation_date']").val(res_date);
                jQuery("input[name='reservation_session']").val(res_session);
                jQuery("input[name='reservation_bostamp']").val('<?php echo $row["bostamp"]; ?>');
                $("#checkout_form").submit();
            } else {
                jQuery(document).trigger("add-alerts", [
                    {
                        "message": "You have to order a minimum limit of " + u_qttmin + " tickets for this product.",
                        "priority": 'error'
                    }
                ]);
            }
        }

        function update_lotation(input, onlyprices) {

            onlyprices = typeof onlyprices !== 'undefined' ? onlyprices : 0;

            if (!onlyprices) {
                var lot_total = 0;

                $('.calendar-cat-picker').each(function (i, obj) {
                    lot_total += parseFloat(jQuery(this).val());
                });

                $('.calendar-cat-picker').each(function (i, obj) {
                    if (input.attr("name") != jQuery(this).attr("name")) {
                        jQuery(this).attr("max", (parseFloat(jQuery(this).val()) + max_lotation - cur_lotation - lot_total));

                        if (parseFloat(jQuery(this).attr("max")) == parseFloat(jQuery(this).val()))
                            jQuery('.btn-number[data-type="plus"][data-field="' + jQuery(this).attr("name") + '"]').attr("disabled", "disabled");
                        else
                            jQuery('.btn-number[data-type="plus"][data-field="' + jQuery(this).attr("name") + '"]').removeAttr("disabled");
                    }
                });
            }

            var html = '';
            var price_total = 0;
            var currency = '<?php echo $_SESSION["i"]; ?>';

            jQuery('.calendar-cat-picker').each(function (i, obj) {
                var tam = jQuery(this).attr("design");
                var qtt = parseFloat(jQuery(this).val()).toFixed(2);
                var price = parseFloat(jQuery(this).attr("price")).toFixed(2);
                if (jQuery(this).val() > 0) {
                    html += '<div class="price-category clearfix"><span class="price-cat pull-left">' + tam + '</span><span class="price-qtt pull-left">' + qtt + ' x  <i class="fa">' + currency + '</i> ' + price + '</span>';
                    html += '<span class="price-total pull-right"><i class="fa">' + currency + '</i> ' + parseFloat(qtt * price).toFixed(2) + '</span></div>';
                }
                price_total += (qtt * price);
            });

            jQuery.each(jQuery(".calendar-extra-picker"), function (i, val) {
                if (jQuery(this).val() > 0)
                {
                    html += '<div class="price-category clearfix"><span class="price-cat pull-left">' + jQuery(this).attr("design") + '</span><span class="price-qtt pull-left">' + parseFloat($(this).val()).toFixed(2) + ' x <i class="fa">' + currency + '</i> ' + jQuery(this).attr("price") + '</span>';
                    html += '<span class="price-total pull-right"><i class="fa">' + currency + '</i> ' + parseFloat(jQuery(this).val() * jQuery(this).attr("price")).toFixed(2) + '</span></div>';

                    price_total += (jQuery(this).val() * jQuery(this).attr("price"));
                }
            });

            $(".price-details-line").html(html);
            $(".price-total b").html('<i class="fa">' + currency + '</i> ' + parseFloat(price_total).toFixed(2));

            if (parseFloat(price_total) > 0) {
                jQuery(".btn-checkout").css("display", "inline-block");
            } else {
                jQuery(".btn-checkout").css("display", "none");
            }
        }

        $('.btn-number').click(function (e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function () {

            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                $(this).val($(this).data('oldValue'));
            }
        });

        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        function update_prices() {
            $(".calendar-top-container").LoadingOverlay("show");
            
            jQuery(".price-details-line").html("");
            
            var product = '<?php echo $row["bostamp"]; ?>';
            var datedata = ("0" + (checkin.date.getMonth() + 1)).slice(-2) + '/' + ("0" + (checkin.date.getDate())).slice(-2) + '/' + checkin.date.getFullYear();
            var session = $("#res_hour option:selected").attr("ses_id");

            $.ajax({
                method: 'GET',
                data: {date: datedata},
                datatype: "json",
                url: '<?php echo base_url(); ?>calendar/prices?event=' + product + '&session=' + session,
                success: function (result) {
                    try
                    {
                        var parse = JSON.parse(result);

                        if (parse.length > 0)
                        {
                            for (p in parse)
                            {
                                var preco = parse[p];
                                jQuery(".calendar-cat-picker[name=" + preco["tam"].toString().trim() + "]").attr("price", parseFloat(preco["epv1"] *<?php echo $this->currency->multiplicador($_SESSION["ch"]); ?>).toFixed(2));
                            }
                            $(".calendar-top-container").LoadingOverlay("show");
                            $.ajax({
                                method: 'GET',
                                data: {date: datedata},
                                datatype: "json",
                                url: '<?php echo base_url(); ?>calendar/maxlotation?event=' + product + '&session=' + session + '&op=' +<?php echo $row["no"]; ?>,
                                success: function (result) {
                                    try
                                    {
                                        var parse = JSON.parse(result);
                                        cur_lotation = parseFloat(parse["current_lotation"]);
                                        max_lotation = parseFloat(parse["lotation"]);

                                        $('.calendar-cat-picker').each(function (i, obj) {
                                            jQuery(this).attr("max", max_lotation - cur_lotation);
                                            jQuery('.btn-number[data-type="plus"]').removeAttr("disabled");
                                            jQuery(this).val(0);

                                            if (parseFloat(jQuery(this).attr("max")) == parseFloat(jQuery(this).val())) {
                                                jQuery('.btn-number[data-type="plus"][data-field="' + jQuery(this).attr("name") + '"]').attr("disabled", "disabled");
                                                $("#message_error").show();
                                            }
                                        });

                                        $('.calendar-extra-picker').each(function (i, obj) {
                                            jQuery(this).attr("max", max_lotation - cur_lotation);
                                            jQuery('.btn-number[data-type="plus"]').removeAttr("disabled");
                                            jQuery(this).val(0);

                                            if (parseFloat(jQuery(this).attr("max")) == parseFloat(jQuery(this).val())) {
                                                jQuery('.btn-number[data-type="plus"][data-field="' + jQuery(this).attr("name") + '"]').attr("disabled", "disabled");
                                            }
                                        });

                                        jQuery(".calendar-but-2-2").css("display", "inline");
                                        
                                        jQuery(".but-1").hide();
                                        jQuery(".but-2").hide();
                                        jQuery(".but-3").show();
                                        jQuery(".calendar-total").show();
                                        
                                        $(".calendar-top-container").LoadingOverlay("hide");
                                    } catch (e)
                                    {
                                        $(".calendar-top-container").LoadingOverlay("hide");
                                    }

                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    $(".calendar-top-container").LoadingOverlay("hide");
                                }
                            });
                        } else {
                            jQuery(".calendar-but-2-2").css("display", "none");
                        }

                        $(".calendar-top-container").LoadingOverlay("hide");
                    } catch (e)
                    {
                        $(".calendar-top-container").LoadingOverlay("hide");
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $(".calendar-top-container").LoadingOverlay("hide");
                }
            });
        }

        function controls(id) {
            switch (id) {
                case 0:
                    jQuery(".but-1").hide();
                    jQuery(".but-2").hide();
                    jQuery(".but-3").hide();
                    break;
                case 1:
                    jQuery(".but-1").show();
                    jQuery(".but-2").hide();
                    jQuery(".but-3").hide();
                    break;
                case 2:
                    $(".calendar-top-container").LoadingOverlay("show");
                    jQuery(".calendar-total").hide();
                    var product = '<?php echo $row["bostamp"]; ?>';
                    var vdate = checkin.date.getFullYear() + '-' + ("0" + (checkin.date.getMonth() + 1)).slice(-2) + '-' + ("0" + (checkin.date.getDate())).slice(-2);
                    $('#res_hour').find('option').remove();
                    $('#res_minute').find('option').remove();

                    $.ajax({
                        method: 'POST',
                        data: {date: vdate, event: product},
                        url: '<?php echo base_url(); ?>calendar/rentalinit',
                        success: function (data) {
                            try
                            {
                                var parse = JSON.parse(data);
                                for (p in parse) {
                                    for( e in parse[p] ) {
                                        jQuery("#res_hour").append($("<option ses_id='" + p + "'></option>").attr("value", parse[p][e]).text(parse[p][e]));
                                    }
                                }
                                $(".calendar-top-container").LoadingOverlay("hide");
                                jQuery(".but-1").hide();
                                jQuery(".but-2").show();
                                jQuery(".but-3").hide();
                            } catch (e)
                            {
                                $(".calendar-top-container").LoadingOverlay("hide");
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $(".calendar-top-container").LoadingOverlay("hide");
                        }
                    });
                    break;
                case 3:
                    update_prices();
                    break;
            }
        }

        function step(id) {
            switch (id) {
                case 0:
                    break;
                case 1:
                    jQuery(".title1").show();
                    jQuery(".control1").show();
                    jQuery(".title2").hide();
                    jQuery(".control2").hide();
                    jQuery(".title3").hide();
                    jQuery(".control3").hide();
                    break;
                case 2:
                    jQuery(".title1").hide();
                    jQuery(".control1").hide();
                    jQuery(".title2").show();
                    jQuery(".control2").show();
                    jQuery(".title3").hide();
                    jQuery(".control3").hide();
                    break;
                case 3:
                    jQuery(".title1").hide();
                    jQuery(".control1").hide();
                    jQuery(".title2").hide();
                    jQuery(".control2").hide();
                    jQuery(".title3").show();
                    jQuery(".control3").show();
                    break;
            }
        }

        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        checkin = $('#dpd1').datepicker({
            format: 'dd/mm/yyyy',
            onRender: function (date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }

            if (checkout.date.valueOf() > ev.date.valueOf()) {
                controls(1);
            } else {
                controls(0);
            }

            checkin.hide();
            $('#dpd2')[0].focus();
        }).data('datepicker');

        checkout = $('#dpd2').datepicker({
            format: 'dd/mm/yyyy',
            onRender: function (date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            if (ev.date.valueOf() > checkin.date.valueOf()) {
                controls(1);
            } else {
                controls(0);
            }

            checkout.hide();
        }).data('datepicker');


    </script>
</div>
<iframe style="margin-top:20px; width: 100%; height:250px;"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $product[0]['u_latitude'] ?>,<?php echo $product[0]['u_longitud'] ?>&hl=es;z=14&amp;output=embed"></iframe>

<style>
    .alert>p, .alert>ul {
        list-style-type: none;
    }
</style>