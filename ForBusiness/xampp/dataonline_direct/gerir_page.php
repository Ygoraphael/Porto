<?php 
	include("classes/config.php");
	include("classes/medoo.min.php");
	include("classes/sqlserver.php");
	include("classes/graph.php");
	include("classes/table.php");
	include("header.php");
?>
<body>
	<div id="container" class="clearfix" style="background:white;width:99%;min-height:99%;">
		<div style="float:left;width:30%;">
			<center>
			<select id="accounts" style="margin-top:10px; width:85%; height:30px;">
			</select>
			<table style="margin-top:10px;text-align:center;" class="pure-table pure-table-bordered" id="pages">
			</table>
			</center>
			<br>
		</div>
		<div style="float:left;width:70%;">
			<table style="width:100%;">
				<tr>
					<td style="width:10%;">Id</td>
					<td><input disabled id="t01" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>Id_account</td>
					<td><input disabled id="t02" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>Num</td>
					<td><input disabled id="t03" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>Style</td>
					<td><textarea type="text" id="t04" style="width:70%; height:200px;" value=""></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button onclick="new_page()">Novo</button>
						<button onclick="duplicate_page()">Duplicar</button>
						<button onclick="delete_page()">Apagar</button>
						<button onclick="save_page()">Gravar</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
<script>
	
	function clean_page() {
		jQuery("#t01").val("");
		jQuery("#t02").val("");
		jQuery("#t03").val("");
		jQuery("#t04").val("");
	}
	
	function save_page() {
		jQuery.ajax({
			url : "save_page.php",
			type: "POST",
			data : { 
				"id":jQuery("#t01").val(),
				"id_account":jQuery("#t02").val(),
				"num":jQuery("#t03").val(),
				"style":jQuery("#t04").val()
				},
			success: function(data, textStatus, jqXHR) {
				clean_page();
				get_pages();
				alert(data);
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}
	
	function next_page() {
		jQuery.ajax({
			url : "get_page_num.php",
			type: "POST",
			data : { "id" : jQuery("#accounts").val() },
			success: function(data, textStatus, jqXHR) {
				jQuery("#t03").val( data );
			}
		});
	}
	
	function new_page() {
		jQuery.ajax({
			url : "get_newid_page.php",
			type: "POST",
			success: function(data, textStatus, jqXHR) {
				jQuery("#t01").val(data.trim());
				jQuery("#t02").val(jQuery("#accounts").val());
				jQuery("#t03").val("");
				jQuery("#t04").val("");
				next_page();
			}
		});
	}
	
	function duplicate_page() {
		jQuery.ajax({
			url : "get_newid_page.php",
			type: "POST",
			success: function(data, textStatus, jqXHR) {
				jQuery("#t01").val(data.trim());
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}
	
	function delete_page() {
		jQuery.ajax({
			url : "delete_page.php",
			type: "POST",
			data : { 
				"id":jQuery("#t01").val()
				},
			success: function(data, textStatus, jqXHR) {
				alert(data);
				get_pages();
				clean_page();
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}
	
	function get_pages() {
		jQuery.ajax({
			url : "get_pages.php",
			type: "POST",
			data: { "id" : jQuery("#accounts").val() },
			success: function(data, textStatus, jqXHR) {
				jQuery('#pages').html(data);
				jQuery("#pages tr").on( "click", function() {
					set_page(jQuery(this).children().first().html());
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}
	
	function get_accounts() {
		jQuery.ajax({
			url : "get_accounts_sel.php",
			async : false, 
			type: "POST",
			success: function(data, textStatus, jqXHR) {
				jQuery('#accounts').html(data);
				jQuery('#accounts').on( "change", function() {
					get_pages();
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}

	function set_page(id) {
		jQuery.ajax({
			url : "get_page_data.php",
			async : false, 
			type: "POST",
			data : {"id":id},
			success: function(data, textStatus, jqXHR) {
				var ndata = JSON.parse(data);
				jQuery("#t01").val(ndata["id"]);
				jQuery("#t02").val(ndata["id_account"]);
				jQuery("#t03").val(ndata["num"]);
				jQuery("#t04").val(ndata["style"]);
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}	
	
	jQuery(document).ready(function() { 
		get_accounts();
		get_pages();
	});
</script>
<?php
	include("footer.php");
?>