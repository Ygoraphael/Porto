<?php 
	include("classes/config.php");
	include("classes/medoo.min.php");
	include("classes/sqlserver.php");
	include("classes/slots.php");
	include("classes/graph.php");
	include("classes/table.php");
	include("header.php");
?>
<body>
	<div id="container" style="background:white;width:99%;height:99%;">
		<div style="float:left;width:20%;">
			<center>
			<table style="margin-top:10px;" class="pure-table pure-table-bordered" id="accounts">
			</table>
			</center>
		</div>
		<div style="float:left;width:80%;">
			<table style="width:100%;">
				<tr>
					<td style="width:10%;">Id</td>
					<td><input id="t01" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><input id="t02" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>Description</td>
					<td><input id="t03" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>IP/DNS</td>
					<td><input id="t04" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>Port</td>
					<td><input id="t05" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>Type</td>
					<td>
						<select id="t06" style="width:70%;">
							<option>SQLServer</option>
							<option>SQLite</option>
							<option>MySQL</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>DB Name</td>
					<td><input id="t07" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>DB User</td>
					<td><input id="t08" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>DB PW</td>
					<td><input id="t09" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button onclick="new_account()">Novo</button>
						<button onclick="save_account()">Gravar</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
<script>	
	function save_account() {
		jQuery.ajax({
			url : "save_account.php",
			type: "POST",
			data : { 
				"id":jQuery("#t01").val(),
				"name":jQuery("#t02").val(),
				"desc":jQuery("#t03").val(),
				"ip_dns":jQuery("#t04").val(),
				"port":jQuery("#t05").val(),
				"type":jQuery("#t06").val(),
				"db_name":jQuery("#t07").val(),
				"db_user":jQuery("#t08").val(),
				"db_pw":jQuery("#t09").val()
				},
			success: function(data, textStatus, jqXHR) {
				jQuery("#t01").val("");
				jQuery("#t02").val("");
				jQuery("#t03").val("");
				jQuery("#t04").val("");
				jQuery("#t05").val("");
				jQuery("#t06").val("");
				jQuery("#t07").val("");
				jQuery("#t08").val("");
				jQuery("#t09").val("");
				get_accounts();
				alert(data);
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}
		
	function new_account() {
		jQuery.ajax({
			url : "get_newid_account.php",
			type: "POST",
			success: function(data, textStatus, jqXHR) {
				jQuery("#t01").val(data.trim());
				jQuery("#t02").val("");
				jQuery("#t03").val("");
				jQuery("#t04").val("");
				jQuery("#t05").val("");
				jQuery("#t06").val("");
				jQuery("#t07").val("");
				jQuery("#t08").val("");
				jQuery("#t09").val("");
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}
	
	function get_accounts() {
		jQuery.ajax({
			url : "get_accounts.php",
			type: "POST",
			success: function(data, textStatus, jqXHR) {
				jQuery('#accounts').html(data);
				jQuery("#accounts tr").on( "click", function() {
					set_account(jQuery(this).children().first().html());
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}

	function set_account(id) {
		jQuery.ajax({
			url : "get_account_data.php",
			type: "POST",
			data : {"id":id},
			success: function(data, textStatus, jqXHR) {
				var ndata = JSON.parse(data);
				jQuery("#t01").val(ndata["id"]);
				jQuery("#t02").val(ndata["name"]);
				jQuery("#t03").val(ndata["desc"]);
				jQuery("#t04").val(ndata["ip_dns"]);
				jQuery("#t05").val(ndata["port"]);
				jQuery("#t06").val(ndata["type"]);
				jQuery("#t07").val(ndata["db_name"]);
				jQuery("#t08").val(ndata["db_user"]);
				jQuery("#t09").val(ndata["db_pw"]);
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}

	jQuery(document).ready(function() { 
		get_accounts();
	});
</script>
<?php
	include("footer.php");
?>