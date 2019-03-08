<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
				<button type="button" id="save" class="btn btn-info pull-right"><?php echo $this->translation->Translation_key("SAVE", $_SESSION['lang_u']); ?></button>
				<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span><?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?> </a>
			</div>
		</div>
		<p style="margin-bottom:5px"></p>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<div class="main-content col-sm-12">
			<div class="panel panel-default">
				<div class="col-md-12 dataintro">
					<div class="col-md-12 well text-center">
						<form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed clearfix" novalidate="true">
							<span>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Operator", $_SESSION['lang_u']); ?></label>
									<div class="input-group col-lg-8 col-sm-6">
										<select class="form-control" id="operator">
											<?php foreach($operators as $operator) { ?>
											<option value="<?php echo $operator["no"]; ?>"><?php echo $operator["nome"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Amount to Reimburse", $_SESSION['lang_u']); ?></label>
									<div class="input-group col-lg-3 col-sm-6">
										<span class="input-group-addon">€</span>
										<input type="number" step="0.01" min="0" max="999999" class="form-control" id="amount" value="0.00">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"></label>
									<div class="input-group col-lg-3 col-sm-6">
										<small class="pull-left"><?php echo $this->translation->Translation_key("This reimbursement will be processed when payment is made", $_SESSION['lang_u']); ?></small>
									</div>
								</div>
							</span>
						</form>
					</div>
				</div>
				<div class="col-md-12 datamb hide">
					<div class="register-box" style="max-width: 400px; width: 100%; margin: 15px auto;">
                        <div class="box box-primary">
                            <div class="register-box-body">
                                <div class="form-group has-feedback">
                                    <table border="0" style="width: 100%;">
                                        <tbody>
											<tr>
												<td style="text-align: center;">
													<img id="IDImg" src="" align="absmiddle" style="height:200px;width:200px;">
												</td>
											</tr>
										</tbody>
									</table>
                                </div>
                                <div id="divResult">
                                    <table style="border: 1px solid #0c629e; padding: 0px; border-collapse: collapse; width: 100%;">
                                        <tbody>
											<tr>
												<td style="border-bottom: 1px solid #0c629e; padding: 10px 0px; font-size: small; text-align: center; background: #0c629e; color: white;" colspan="5"><?php echo $this->translation->Translation_key("Reimbursement by Multibanco", $_SESSION['lang_u']); ?></td>
											</tr>
											<tr>
												<td style="height: 20px;" colspan="5"></td>
											</tr>
											<tr>
												<td style="width: 10px;" rowspan="3"></td>
												<td style="width: 85px; padding: 5px 0px;padding-right: 15px;" rowspan="3"><img src="<?php echo base_url(); ?>img/logoMB.png" align="absmiddle" style="height:80px;width:80px;"></td>
												<td style="border-bottom: 1px solid #ddd;padding: 5px 0px;"><?php echo $this->translation->Translation_key("ENTIDADE", $_SESSION['lang_u']); ?></td>
												<td style="border-bottom: 1px solid #ddd;padding: 5px 0px;text-align: right;"><b><span id="IDEntidade"></span></b></td>
												<td style="width: 20px;" rowspan="3"></td>
											</tr>
											<tr>
												<td style="border-bottom: 1px solid #ddd;padding: 5px 0px;"><?php echo $this->translation->Translation_key("REFERÊNCIA", $_SESSION['lang_u']); ?></td>
												<td style="border-bottom: 1px solid #ddd;padding: 5px 0px;text-align: right;"><b><span id="IDReferencia"></span></b></td>
											</tr>
											<tr>
												<td style="border-bottom: 1px solid #ddd;padding: 5px 0px;"><?php echo $this->translation->Translation_key("VALOR", $_SESSION['lang_u']); ?></td>
												<td style="border-bottom: 1px solid #ddd;padding: 5px 0px;text-align: right;"><b><span id="IDValor"></span> €</b></td>
											</tr>
											<tr>
												<td style="height: 20px;" colspan="5"></td>
											</tr>
										</tbody>
									</table>
                                </div>
                                <div style="text-align: center; width: 100%; margin-top: 30px">
                                    <div class="btn-group">
										<a onclick="OnCopyTableClick(); return false;" type="button" class="btn btn-primary pull-right" style="margin-right:15px;"><i class="fa fa-copy"></i><?php echo $this->translation->Translation_key("Copy to clipboard", $_SESSION['lang_u']); ?> </a>
                                    </div>
                                </div>
								<div style="text-align: center; width: 100%; margin-top: 15px">
									<div class="btn-group">
										<small<?php echo $this->translation->Translation_key("Email sent with this payment info", $_SESSION['lang_u']); ?>></small>
                                    </div>
                                </div>
								<div style="text-align: center; width: 100%; margin-top: 15px">
									<div class="btn-group">
										<small><b><?php echo $this->translation->Translation_key("NOTE: Payment must be made by", $_SESSION['lang_u']); ?> <?php echo Date('Y-m-d', strtotime("+3 days")); ?> 23:59</b></small>
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

<script>
jQuery( "#save" ).click(function() {
	
	if( parseFloat(jQuery("#amount").val()) <= 0 ) {
		bootbox.alert("Amount to Reimburse must be higher than 0");
	}
	else if( parseFloat(jQuery("#amount").val()) >= 1000000 ) {
		bootbox.alert("Amount to Reimburse must be lower than 1000000");
	}
	else {
		$(".loading-overlay").show();
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/agent_insert_reimbursement_mb",
			data: { 
				"operator" : jQuery("#operator").val(),
				"amount" : jQuery("#amount").val()
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				
				if( data["ref"] != '') {
					jQuery("#save").remove();
					
					jQuery("#IDEntidade").html(data["ent"]);
					jQuery("#IDReferencia").html(data["ref"]);
					jQuery("#IDValor").html(data["value"]);
					
					jQuery("#IDImg").attr("src", "https://chart.googleapis.com/chart?cht=qr&chs=150x150&chl=ENTIDADE:+" + data["ent"] + "%0AREFERENCIA:+" + data["ref"] + "%0AVALOR:+" + data["value"]);
					jQuery(".datamb").removeClass("hide");
					jQuery(".dataintro").remove();
					
					$(".loading-overlay").hide();
				}
				else {
					$(".loading-overlay").hide();
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Error inserting reimbursement",
						"priority": 'error'
					}
					]);
				}
			}
		});
	}
});

function OnCopyTableClick() {
	var elemToSelect = document.getElementById('divResult');
	var titleInfo, bodyInfo, typeInfo;

	//text data
	var ent = $('#IDEntidade').text();
	var ref = $('#IDReferencia').text();
	var valor = $('#IDValor').text();
	var strHtml = 'Reimbursement by Multibanco:\n\nEntidade: ' + ent + '\nReferência: ' + ref + '\nValor: ' + valor;

	if (window.getSelection) {
		var selection = window.getSelection();
		var rangeToSelect = document.createRange();
		rangeToSelect.selectNodeContents(elemToSelect);
		selection.removeAllRanges();
		selection.addRange(rangeToSelect);

		//copy to clipboard
		try {
			var successful = document.execCommand('copy');
			var msg = successful ? 'successful' : 'unsuccessful';
			if (msg = 'successful') {
				bodyInfo = strHtml + '<br><br>You can paste (CTRL + V) the information in your document, email, etc.';
			}

		} catch (err) {
			console.log(err);
		}

		//remove range select
		selection.removeAllRanges();
		bootbox.alert(bodyInfo);
	}
	else
	{
		bodyInfo = "\nYour browser does not support this feature.<br><br>We recommend running the process manually.";
		bootbox.alert(bodyInfo);
	}
}
</script>
