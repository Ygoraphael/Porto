<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
				<button onclick="PaymentReference(); return false;" class="btn btn-info btn-lg pull-right">Generate Payment Reference</button>
				<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary btn-lg pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
			</div>
		</div>
		<p style="margin-bottom:5px"></p>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<div class="main-content col-sm-12">
		   <div class="panel panel-default">
			  <div class="col-md-11">
				 <div class="panel panel-default">
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-6 control-label">Value to Reimburse</label>
					   <div class="col-sm-6"><input id="value" type="text" name="value" class="form-control activeInput" value="0"></div>
					</div>
				 </div>	
			  </div>
		   </div>
		   
		   <div class="panel panel-default">
			  <div class="col-md-11">
				 <table cellpadding="3" width="300px" cellspacing="0" style="margin-top: 10px;border: 1px solid #45829F">
					<tr>
						<td style="border-bottom: 1px solid #45829F; background-color: #45829F; color: White" colspan="3">Payment by ATM or Homebanking</td>
					</tr>
					<tr>
						<td rowspan="3"><img src="<?php echo base_url(); ?>img/logoMB.png" height=90 alt="" /></td>
						<td style="font-weight:bold; text-align:left">Entity:</td>
						<td style="text-align:left"><input id="Entidade" type="text" name="value" class="form-control activeInput mb" value="" readonly></td>
					</tr>
					<tr>
						<td style="font-weight:bold; text-align:left">Reference:</td>
						<td style="text-align:left"><input id="Ref" type="text" name="value" class="form-control activeInput mb" value="" readonly></td>
					</tr>
					<tr>
						<td style="font-weight:bold; text-align:left">Value:</td>
						<td style="text-align:left"><input id="Valor" type="text" name="value" class="form-control activeInput mb" value="" readonly></td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #45829F; background-color: #45829F; height:10px; color: White" colspan="3"></td>
					</tr>
				</table>
			  </div>
		   </div>

		</div>
	</div>
</div>

<form method="post" id="theForm" action="">
	<input id="theFormid" type="hidden" name="id" value="1">
</form>
<style>
.mb{
	border: none;
    background: none !important;
}

</style>
<script>
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }

    if (vars.length >= 4) {
        var valor = StringFormatVerify(vars.VALOR);
        
        if ((isNaN(vars.ENTIDADE)) || (String(vars.ENTIDADE).length != 5))
        {
            alert('Entidade inválida!');
            return;
        }
        if ((isNaN(vars.SUBENTIDADE)) || (String(vars.SUBENTIDADE).length > 3) || (String(vars.SUBENTIDADE) == "")) {
            alert('SubEntidade inválida!');
            return;
        }
        if ((isNaN(vars.ID)) || (String(vars.ID).length > 4) || (String(vars.ID) == "")) {
            alert('ID inválido!');
            return;
        }
        if (isNaN(valor)) {
            alert('Valor inválido!');
            return;
        }
        else if (valor <= 0) {
            alert('Valor inválido!');
            return;
        }
        
        valor = formatAsMoney(valor);
        GetPaymentRef(vars.ENTIDADE, vars.SUBENTIDADE, vars.ID, valor);
    }
}

function GetPaymentRef(_ENTIDADE, _SUBENTIDADE, _ID, _VALOR) {

    var ENT_CALC = (51 * parseInt(String(_ENTIDADE).charAt(0)) +
    73 * parseInt(String(_ENTIDADE).charAt(1)) +
    17 * parseInt(String(_ENTIDADE).charAt(2)) +
    89 * parseInt(String(_ENTIDADE).charAt(3)) +
    38 * parseInt(String(_ENTIDADE).charAt(4)));
    
    var iCHECKDIGITS = 0;
    var sTMP = "";

    sTMP = String(Right("000" + _SUBENTIDADE.toString(), 3) + Right("0000" + _ID.toString(), 4) + Right("00000000" + (parseFloat(_VALOR) * 100).toFixed(0), 8));
    	
	//Calculate check digits
    iCHECKDIGITS =
        98 - (parseInt(ENT_CALC) +
        3 * parseInt(sTMP.charAt(14)) +
        30 * parseInt(sTMP.charAt(13)) +
        9 * parseInt(sTMP.charAt(12)) +
        90 * parseInt(sTMP.charAt(11)) +
        27 * parseInt(sTMP.charAt(10)) +
        76 * parseInt(sTMP.charAt(9)) +
        81 * parseInt(sTMP.charAt(8)) +
        34 * parseInt(sTMP.charAt(7)) +
        49 * parseInt(sTMP.charAt(6)) +
        5 * parseInt(sTMP.charAt(5)) +
        50 * parseInt(sTMP.charAt(4)) +
        15 * parseInt(sTMP.charAt(3)) +
        53 * parseInt(sTMP.charAt(2)) +
        45 * parseInt(sTMP.charAt(1)) +
        62 * parseInt(sTMP.charAt(0))) % 97;

    var _PaymentRef = Right("000" + _SUBENTIDADE, 3) + " " + Mid(Right("0000" + _ID, 4), 0, 3) + " " + Mid(Right("0000" + _ID, 4), 3, 1) + Right("00" + iCHECKDIGITS.toString(), 2);

	$("#Entidade").val(_ENTIDADE);
	$("#Ref").val(_PaymentRef);
	$("#Valor").val(_VALOR+" €");
}

//Mid Function
function Mid(value, index, n)
{
    var result = String(value).substring(index, index + n);
    return result;
}
//Right function
function Right(value, n) {
    var result = String(value).substring(String(value).length, String(value).length - n);
    return result;
}

function formatAsMoney(mnt) {
    mnt -= 0;
    mnt = (Math.round(mnt * 100)) / 100;
    return (mnt == Math.floor(mnt)) ? mnt + '.00' : ((mnt * 10 == Math.floor(mnt * 10)) ? mnt + '0' : mnt);
}

function StringFormatVerify(value)
{
    var count = 0;
    var result = "";
    for (var i = 0; i <= String(value).length; i++)
    {
        if ((String(value).charAt(i) == ".") || (String(value).charAt(i) == ",")) count++;
    }
    if (count > 1) {

        for (var i = 0; i <= String(value).length; i++) {
            if (count > 1) {
                if ((String(value).charAt(i) == ".") || (String(value).charAt(i) == ",")) {
                    count--;
                }
                else { 
                    result +=String(value).charAt(i);
                }
            }
            else
            { 
                result +=String(value).charAt(i);
            }
        }

    }
    else {
        result = value;
    }
    return String(result).replace(",",".");
}
  

function PaymentReference(){
	$(".loading-overlay").show();
	
	var value = $("#value").val();
	var id = Math.floor(Math.random() * (9999 - 1 + 1) + 1);
	var entity = '11989';
	var subentity = '500';
	if (value>1){
		GetPaymentRef(entity, subentity, id, value);
	}

	$(".loading-overlay").hide();
	
}
</script>
