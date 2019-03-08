<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<body>
    <div class="login-body">
        <div class="container">
            <div data-alerts="alerts" data-titles='{"warning": "<em>Warning!</em>", "error": "<em>Error!</em>"}' data-ids="myid" data-fade="3000"></div>
            <article class="container-login center-block">
                <section>
                    <div id="login-form" class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12">
                        <div id="login-access" class="tab-pane fade active in">	
                            <p class="text-center" style="color:#fff;">
                                <b>WELCOME TO SOFT4BOOKING</b>
                            </p>
                            <form id="form1" method="post" accept-charset="utf-8" autocomplete="off" role="form" class="form-horizontal">
                                <div class="login">
                                    <div class="login-triangle"></div>
                                    <h2 class="login-header">Log in</h2>
                                    <div class="login-container ">
                                        <p><input type="text" name="no" id="no" placeholder="Company" value="" /></p>
                                        <p><input type="text" name="estab" id="estab" placeholder="ID" value="" /></p>
                                        <p><input type="password" name="password" id="password" placeholder="Password" value="" /></p>
                                        <div class="g-recaptcha" name="recaptcha" id="recaptcha" data-sitekey="6LcU7iMUAAAAAEFzWx2w5960ufTxFQtwPl_MewIy" data-theme="light" data-size="normal" align="center" tabindex="3"></div>
                                        <p><input id="btn-login" type="submit" value="ENTER"></p>
                                    </div>
                                </div>
                            </form>			
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </div>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
        jQuery(document).ready(function () {
            //jQuery('#login_form').validate(); //form validation

            jQuery(document).on('click', '#btn-login', function () {

                var url = "<?php echo base_url(); ?>backoffice_login/login";
                //if(jQuery('#login_form').valid()){
                jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: jQuery("#form1").serialize()<?php //echo $postRed;  ?><?php //echo $postDt;  ?>,
                    success: function (data)
                    {
                        var objData = jQuery.parseJSON(data);


                        if (objData.success) {
                            if (objData.redirect_page_success != '') {
                                window.location.href = objData.redirect_page_success;

                            } else {
                                window.location.href = "";
                            }
                        } else {
                            if (objData.redirect_page_error != '') {
                                window.location.href = objData.redirect_page_error;
                            } else {
                                jQuery(document).trigger("add-alerts", [
                                    {
                                        "message": objData.error,
                                        "priority": 'warning'
                                    }
                                ]);
                            }
                        }
                    }
                });
                //}
                return false;
            });
        });
    </script>
</body>