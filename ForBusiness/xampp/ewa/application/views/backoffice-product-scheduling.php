<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php echo $this->template->partial->view('backoffice-product-top-bar', $data = array(), $overwrite = false); ?>
<div class="main-content col-sm-12">
    <div class="col-lg-12">
        <div class="row form-group">
            <div class="col-xs-12">
                <?php echo $this->template->partial->view('backoffice-product-menu', $data = array(), $overwrite = true); ?>
            </div>
        </div>
        <div class="row setup-content" id="step-1">
            <div class="col-xs-12">
                <div class="col-md-12 well text-center">
                    <form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed clearfix">
                        <span>
                            <h3><?php echo $this->translation->Translation_key("SCHEDULING", $_SESSION['lang_u']); ?></h3>
                            <table id="scheduling_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->translation->Translation_key("Id", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Alt. Price", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Max. Lot.", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Starting hour", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Fixed date", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Fixed date end", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Mon", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Tue", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Wed", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Thu", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Fri", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Sat", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Sun", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Limit hour", $_SESSION['lang_u']); ?></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($u_psess as $session) { ?>
                                        <tr>
                                            <td stamp="<?php echo $session["u_psessstamp"]; ?>"><?php echo $session["id"]; ?></td>
                                            <td><input type="checkbox" <?php echo $session["price"] ? "checked" : ""; ?>></td>
                                            <td><input type="number" style="width:100px" step="1" class="form-control" value="<?php echo number_format($session["lotation"], 0, ".", ""); ?>"></td>
                                            <td><input data-inputmask="'mask': '29:59'" style="width:100px" type="text" class="form-control" value="<?php echo $session["ihour"]; ?>"></td>
                                            <td><input type="date" class="form-control" value="<?php echo ($session["fixday"] == "1900-01-01") ? "" : $session["fixday"]; ?>"></td>
                                            <td><input type="date" class="form-control" value="<?php echo ($session["fixday_end"] == "1900-01-01") ? "" : $session["fixday_end"]; ?>"></td>
                                            <td><input type="checkbox" <?php echo $session["mon"] ? "checked" : ""; ?>></td>
                                            <td><input type="checkbox" <?php echo $session["tue"] ? "checked" : ""; ?>></td>
                                            <td><input type="checkbox" <?php echo $session["wed"] ? "checked" : ""; ?>></td>
                                            <td><input type="checkbox" <?php echo $session["thu"] ? "checked" : ""; ?>></td>
                                            <td><input type="checkbox" <?php echo $session["fri"] ? "checked" : ""; ?>></td>
                                            <td><input type="checkbox" <?php echo $session["sat"] ? "checked" : ""; ?>></td>
                                            <td><input type="checkbox" <?php echo $session["sun"] ? "checked" : ""; ?>></td>
                                            <td><input data-inputmask="'mask': '29:59'" style="width:100px" type="text" class="form-control" value="<?php echo $session["fhour"]; ?>"></td>
                                            <td class="text-center"><a href="#" onclick="delete_session(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
                                            <?php if ($session["price"]) { ?>
                                                <td class="text-center"><a href="<?php echo base_url() . "backoffice/product_price/" . $product["u_sefurl"] . "/" . $session["id"]; ?>" onclick="" class="btn btn-default"><span class="glyphicon glyphicon-euro"></span></a></td>
                                            <?php } else { ?>
                                                <td class="text-center"></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="col-lg-12 col-sm-12">
                                <button type="button" id="scheduling_table_add" class="btn btn-default btn-lg pull-left"><?php echo $this->translation->Translation_key("Add session", $_SESSION['lang_u']); ?></button>
                                <a href="<?php echo base_url() . "backoffice/product_price/" . $product["u_sefurl"] . "/0"; ?>" id="scheduling_table_price" class="btn btn-default btn-lg pull-left" ><?php echo $this->translation->Translation_key("Product Pricing", $_SESSION['lang_u']); ?></a>
                            </div>

                            <h3><?php echo $this->translation->Translation_key("DATE EXCLUSIONS", $_SESSION['lang_u']); ?></h3>
                            <table id="exclusion_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->translation->Translation_key("Starting Month", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Starting Day", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Ending Month", $_SESSION['lang_u']); ?></th>
                                        <th><?php echo $this->translation->Translation_key("Ending Day", $_SESSION['lang_u']); ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $excl_id = 0;
                                    $year = 2016;
                                    foreach ($u_pexcl as $exclusion) {
                                        ?>
                                        <tr>
                                            <td stamp="<?php echo $exclusion["u_pexclstamp"]; ?>" excl_id="<?php echo $excl_id; ?>"><input type="number" id="smonth<?php echo $excl_id; ?>" min="1" max="12" step="1" class="form-control" value="<?php echo number_format($exclusion["imonth"], 0, ".", ""); ?>"></td>
                                            <td><input type="number" min="1" max="<?php echo date('t', strtotime($year . '-' . $exclusion["imonth"] . '-01')); ?>"  step="1" id="sday<?php echo $excl_id; ?>" class="form-control" value="<?php echo number_format($exclusion["iday"], 0, ".", ""); ?>"></td>
                                            <td><input type="number" min="1" max="12" step="1" id="fmonth<?php echo $excl_id; ?>" class="form-control" value="<?php echo number_format($exclusion["fmonth"], 0, ".", ""); ?>"></td>
                                            <td><input type="number" min="1" max="<?php echo date('t', strtotime($year . '-' . $exclusion["fmonth"] . '-01')); ?>" step="1"id="fday<?php echo $excl_id; ?>" class="form-control" value="<?php echo number_format($exclusion["fday"], 0, ".", ""); ?>"></td>
                                            <td class="text-center"><a href="#" onclick="delete_exclusion(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
                                        </tr>
                                        <?php
                                        $excl_id++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="col-lg-12 col-sm-12">
                                <button type="button" id="exclusion_table_add" class="btn btn-default btn-lg pull-left"><?php echo $this->translation->Translation_key("Add exclusion", $_SESSION['lang_u']); ?></button> 
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 control-label"></label>
                                    <div class="input-group col-lg-8 col-sm-6">
                                        <div class="am-checkbox clearfix">
                                            <input name="bo3.u_quicksel" id="u_quicksel" type="checkbox" <?php echo $product["u_quicksel"] ? "checked" : ""; ?>>
                                            <label class="pull-left" for="u_quicksel"><?php echo $this->translation->Translation_key("Quick-sell product", $_SESSION['lang_u']); ?></label>
                                        </div>
                                        <small class="pull-left"><?php echo $this->translation->Translation_key("No day selection (current day selected), no session selection, no stock calculation and main product's pricing used", $_SESSION['lang_u']); ?></small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 control-label"></label>
                                    <div class="input-group col-lg-8 col-sm-6">
                                        <div class="am-checkbox clearfix">
                                            <input name="bo3.u_multiday" id="u_multiday" type="checkbox" <?php echo $product["u_multiday"] ? "checked" : ""; ?>>
                                            <label class="pull-left" for="u_multiday"><?php echo $this->translation->Translation_key("Rental Multi-day Product", $_SESSION['lang_u']); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 control-label"></label>
                                    <div class="input-group col-lg-8 col-sm-6">
                                        <div class="am-checkbox clearfix">
                                            <input name="bo3.u_rentint" id="u_rentint" type="checkbox" <?php echo $product["u_rentint"] ? "checked" : ""; ?>>
                                            <label class="pull-left" for="u_rentint"><?php echo $this->translation->Translation_key("Rental Interval Activated", $_SESSION['lang_u']); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 control-label"></label>
                                    <div class="input-group col-lg-8 col-sm-6">
                                        <div class="am-checkbox clearfix">
                                            <input name="bo3.u_rentdur" id="u_rentdur" type="checkbox" <?php echo $product["u_rentdur"] ? "checked" : ""; ?>>
                                            <label class="pull-left" for="u_rentdur"><?php echo $this->translation->Translation_key("Rental Duration By Interval Activated", $_SESSION['lang_u']); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Rental Interval", $_SESSION['lang_u']); ?></label>
                                    <div class="input-group col-lg-2 col-sm-2">
                                        <input type="number" min="0" step="1" class="form-control" id="u_minnotic" name="bo3.u_minnotic" value="<?php echo $product["u_minnotic"]; ?>">
                                    </div>
                                    <div class="input-group col-lg-4 col-sm-3">
                                        <select class="form-control" id="u_minnott" name="bo3.u_minnott">
                                            <option value="" <?php echo trim($product["u_minnott"]) == "" ? "selected" : ""; ?>></option>
                                            <option value="Hours" <?php echo trim($product["u_minnott"]) == "Hours" ? "selected" : ""; ?>><?php echo $this->translation->Translation_key("Hours", $_SESSION['lang_u']); ?></option>
                                            <option value="Minutes" <?php echo trim($product["u_minnott"]) == "Minutes" ? "selected" : ""; ?>><?php echo $this->translation->Translation_key("Minutes", $_SESSION['lang_u']); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Estimated duration", $_SESSION['lang_u']); ?></label>
                                    <div class="input-group col-lg-2 col-sm-2">
                                        <input type="number" step="0.01" class="form-control" id="u_estimdur" name="bo3.u_estimdur" value="<?php echo $product["u_estimdur"]; ?>">
                                    </div>
                                    <div class="input-group col-lg-4 col-sm-3">
                                        <select class="form-control" id="u_estidurt" name="bo3.u_estidurt">
                                            <option value="" <?php echo trim($product["u_estidurt"]) == "" ? "selected" : ""; ?>></option>
                                            <option value="Hours" <?php echo trim($product["u_estidurt"]) == "Hours" ? "selected" : ""; ?>><?php echo $this->translation->Translation_key("Hours", $_SESSION['lang_u']); ?></option>
                                            <option value="Minutes" <?php echo trim($product["u_estidurt"]) == "Minutes" ? "selected" : ""; ?>><?php echo $this->translation->Translation_key("Minutes", $_SESSION['lang_u']); ?></option>
                                            <option value="Days" <?php echo trim($product["u_estidurt"]) == "Days" ? "selected" : ""; ?>><?php echo $this->translation->Translation_key("Days", $_SESSION['lang_u']); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Product color", $_SESSION['lang_u']); ?></label>
                                    <div id="cp2" class="input-group col-lg-8 col-sm-6 colorpicker-component">
                                        <input type="text" class="form-control" id="u_color" name="bo3.u_color" value="<?php echo $product["u_color"]; ?>">
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                        </span>
                    </form>
                    <p style="margin-bottom:50px"></p>
                    <div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
                    <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"] . "/" . $back; ?>" class="btn btn-primary btn-lg pull-left"><span class="glyphicon glyphicon-chevron-left"></span> <?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?></a>
                    <button data-step-control="save"  class="btn btn-info btn-lg pull-left"><?php echo $this->translation->Translation_key("SAVE PRODUCT", $_SESSION['lang_u']); ?></button>
                    <button data-step-control="cancel"  class="btn btn-default btn-lg pull-left"><?php echo $this->translation->Translation_key("CANCEL", $_SESSION['lang_u']); ?></button>
                    <a href="<?php echo base_url() . "backoffice/product/" . $product["u_sefurl"] . "/" . $next; ?>"  class="btn btn-primary btn-lg pull-right"><?php echo $this->translation->Translation_key("NEXT", $_SESSION['lang_u']); ?> <span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->template->partial->view('backoffice-product-script', $data = array(), $overwrite = true); ?>
</div>