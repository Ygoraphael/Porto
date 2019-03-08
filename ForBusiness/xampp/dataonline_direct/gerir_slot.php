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
	<div id="container" class="clearfix" style="background:white;width:99%;min-height:99%;">
		<div style="float:left;width:30%;">
			<center>
				<select id="accounts" style="margin-top:10px; width:85%; height:30px;"></select>
				<select id="pages" style="margin-top:10px; width:85%; height:30px;"></select>
				<table style="margin-top:10px;text-align:center;" class="pure-table pure-table-bordered" id="slots"></table>
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
					<td>Slot Num</td>
					<td><input disabled id="t03" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>Query</td>
					<td><textarea id="t04" style="width:70%;height:200px;"></textarea></td>
				</tr>
				<tr>
					<td>
						Field1
					</td>
					<td>
					<table style="width:70%;">
						<tr>
							<td><input id="t05" type="textbox" style="width:80%;"/></td>
							<td>Formatação</td>
							<td><input id="f05" type="textbox" style="width:80%;"/></td>
							<td>Label</td>
							<td><input id="l05" type="textbox" style="width:80%;"/></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td>
						Field2
					</td>
					<td>
					<table style="width:70%;">
						<tr>
							<td><input id="t06" type="textbox" style="width:80%;"/></td>
							<td>Formatação</td>
							<td><input id="f06" type="textbox" style="width:80%;"/></td>
							<td>Label</td>
							<td><input id="l06" type="textbox" style="width:80%;"/></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td>
						Field3
					</td>
					<td>
					<table style="width:70%;">
						<tr>
							<td><input id="t07" type="textbox" style="width:80%;"/></td>
							<td>Formatação</td>
							<td><input id="f07" type="textbox" style="width:80%;"/></td>
							<td>Label</td>
							<td><input id="l07" type="textbox" style="width:80%;"/></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td>
						Field4
					</td>
					<td>
					<table style="width:70%;">
						<tr>
							<td><input id="t08" type="textbox" style="width:80%;"/></td>
							<td>Formatação</td>
							<td><input id="f08" type="textbox" style="width:80%;"/></td>
							<td>Label</td>
							<td><input id="l08" type="textbox" style="width:80%;"/></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td>Title</td>
					<td><input id="t09" type="textbox" style="width:70%;"/></td>
				</tr>
				<tr>
					<td>Type</td>
					<td>
						<select onchange="changemodel()" id="t10" style="width:30%;">
							<option>2d_graph</option>
							<option>table</option>
							<option>label</option>
							<option>button</option>
						</select>
						<a style="margin-left:20px; margin-right:5px;">Model<a>
						<select id="t11" style="width:25%;">
							<option>Axis</option>
							<option>Pie</option>
						</select>
				</tr>
				<tr>
					<td>
						Size
					</td>
					<td>
					<table style="float:left">
						<tr>
							<td>W</td>
							<td>
								<select id="t12">
									<option>150</option>
									<option>200</option>
									<option>250</option>
									<option>300</option>
									<option>350</option>
									<option>400</option>
									<option>450</option>
									<option>500</option>
									<option>550</option>
									<option>600</option>
									<option>650</option>
									<option>700</option>
									<option>750</option>
									<option>800</option>
								</select>
							</td>
							<td>H</td>
							<td>
								<select id="t13">
									<option>150</option>
									<option>200</option>
									<option>250</option>
									<option>300</option>
									<option>350</option>
									<option>400</option>
									<option>450</option>
									<option>500</option>
									<option>550</option>
									<option>600</option>
									<option>650</option>
									<option>700</option>
									<option>750</option>
									<option>800</option>
								</select>
							</td>
						</tr>
					</table>
					<a style="margin-left:20px; margin-right:5px;">Page<a><input type="text" id="t14" style="width:15%;" value="1">
					<a style="margin-left:20px; margin-right:5px;">Order<a><input type="text" id="t16" style="width:15%;" value="0">
					</td>
				</tr>
				<tr>
					<td>Link</td>
					<td>
						<input type="text" id="t15" style="width:30%;" value="dataonline/index.php?a=1&p=1">
						<a style="margin-left:20px; margin-right:5px;">Class<a><input type="text" id="t18" style="width:30%;" value="1">
					</td>
				</tr>
				<tr>
					<td>Style</td>
					<td>
						<textarea type="text" id="t17" style="width:70%; height:200px;" value=""></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button onclick="new_slot()">Novo</button>
						<button onclick="duplicate_slot()">Duplicar</button>
						<button onclick="delete_slot()">Apagar</button>
						<button onclick="save_slot()">Gravar</button>
					</td>
				</tr>
			</table>
			<br><br><br><br>
		</div>
	</div>
</body>
<script>
	function changemodel() {
		if( jQuery("#t10").val() == "2d_graph" ) {
			jQuery("#t11").html("<option>Axis</option><option>Pie</option><option>Bar</option>");
			return;
		}
		if( jQuery("#t10").val() == "table" ) {
			jQuery("#t11").html("<option>---</option><option>---</option>");
			return;
		}
		if( jQuery("#t10").val() == "label" ) {
			jQuery("#t11").html("<option>---</option><option>---</option>");
			return;
		}
		if( jQuery("#t10").val() == "label" ) {
			jQuery("#t11").html("<option>---</option><option>---</option>");
			return;
		}
	}
	
	function clean_slot() {
		jQuery("#t01").val("");
		jQuery("#t02").val("");
		jQuery("#t03").val("");
		editAreaLoader.setValue("t04", "");
		jQuery("#t05").val("");
		jQuery("#t06").val("");
		jQuery("#t07").val("");
		jQuery("#t08").val("");
		jQuery("#l05").val("");
		jQuery("#l06").val("");
		jQuery("#l07").val("");
		jQuery("#l08").val("");
		jQuery("#f05").val("");
		jQuery("#f06").val("");
		jQuery("#f07").val("");
		jQuery("#f08").val("");
		jQuery("#t09").val("");
		jQuery("#t10").val("2d_graph");
		jQuery("#t11").val("Axis");
		jQuery("#t12").val("320");
		jQuery("#t13").val("200");
		jQuery("#t14").val("1");
		jQuery("#t15").val("index.php?a=1&p=1");
		jQuery("#t16").val("0");
		jQuery("#t17").val("");
		jQuery("#t18").val("");
	}
	
	function save_slot() {
		jQuery.ajax({
			url : "save_slot.php",
			type: "POST",
			data : { 
				"id":jQuery("#t01").val(),
				"id_account":jQuery("#t02").val(),
				"num":jQuery("#t03").val(),
				"query":editAreaLoader.getValue("t04"),
				"field1":jQuery("#t05").val(),
				"field2":jQuery("#t06").val(),
				"field3":jQuery("#t07").val(),
				"field4":jQuery("#t08").val(),
				"label1":jQuery("#l05").val(),
				"label2":jQuery("#l06").val(),
				"label3":jQuery("#l07").val(),
				"label4":jQuery("#l08").val(),
				"format1":jQuery("#f05").val(),
				"format2":jQuery("#f06").val(),
				"format3":jQuery("#f07").val(),
				"format4":jQuery("#f08").val(),
				"title":jQuery("#t09").val(),
				"type":jQuery("#t10").val(),
				"model":jQuery("#t11").val(),
				"width":jQuery("#t12").val(),
				"height":jQuery("#t13").val(),
				"page":jQuery("#t14").val(),
				"link":jQuery("#t15").val(),
				"order":jQuery("#t16").val(),
				"style":jQuery("#t17").val(),
				"class":jQuery("#t18").val()
				},
			success: function(data, textStatus, jqXHR) {
				clean_slot();
				get_slots();
				alert(data);
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}
	
	editAreaLoader.init({
		id: "t04"
		,start_highlight: true
		,allow_resize: "both"
		,allow_toggle: false
		,word_wrap: true
		,language: "en"
		,syntax: "sql"	
	});
	
	function next_slot() {
		jQuery.ajax({
			url : "get_slot_num.php",
			type: "POST",
			data : { "id" : jQuery("#accounts").val() },
			success: function(data, textStatus, jqXHR) {
				jQuery("#t03").val( data );
			}
		});
	}
	
	function new_slot() {
		jQuery.ajax({
			url : "get_newid_slot.php",
			type: "POST",
			success: function(data, textStatus, jqXHR) {
				jQuery("#t01").val(data.trim());
				jQuery("#t02").val(jQuery("#accounts").val());
				jQuery("#t03").val("");
				editAreaLoader.setValue("t04", "");
				jQuery("#t05").val("");
				jQuery("#t06").val("");
				jQuery("#t07").val("");
				jQuery("#t08").val("");
				jQuery("#l05").val("");
				jQuery("#l06").val("");
				jQuery("#l07").val("");
				jQuery("#l08").val("");
				jQuery("#f05").val("");
				jQuery("#f06").val("");
				jQuery("#f07").val("");
				jQuery("#f08").val("");
				jQuery("#t09").val("");
				jQuery("#t10").val("2d_graph");
				jQuery("#t11").val("Axis");
				jQuery("#t12").val("320");
				jQuery("#t13").val("200");
				jQuery("#t14").val("1");
				jQuery("#t15").val("index.php?a=1&p=1");
				jQuery("#t16").val("0");
				jQuery("#t17").val("");
				jQuery("#t18").val("");
				next_slot();
			}
		});
	}
	
	function duplicate_slot() {
		jQuery.ajax({
			url : "get_newid_slot.php",
			type: "POST",
			success: function(data, textStatus, jqXHR) {
				jQuery("#t01").val(data.trim());
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}
	
	function delete_slot() {
		jQuery.ajax({
			url : "delete_slot.php",
			type: "POST",
			data : { 
				"id":jQuery("#t01").val()
				},
			success: function(data, textStatus, jqXHR) {
				alert(data);
				get_slots();
				clean_slot();
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}
	
	function get_slots() {
		jQuery.ajax({
			url : "get_slots.php",
			type: "POST",
			data: { "id" : jQuery("#accounts").val() },
			success: function(data, textStatus, jqXHR) {
				jQuery('#slots').html(data);
				jQuery("#slots tr").on( "click", function() {
					set_slot(jQuery(this).children().first().html());
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
					get_slots();
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}
	
	function get_pages() {
		jQuery.ajax({
			url : "get_pages_sel.php",
			async : false, 
			type: "POST",
			success: function(data, textStatus, jqXHR) {
				jQuery('#pages').html(data);
				jQuery('#pages').on( "change", function() {
					get_slots();
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}

	function set_slot(id) {
		jQuery.ajax({
			url : "get_slot_data.php",
			async : false, 
			type: "POST",
			data : {"id":id},
			success: function(data, textStatus, jqXHR) {
				var ndata = JSON.parse(data);
				jQuery("#t01").val(ndata["id"]);
				jQuery("#t02").val(ndata["id_account"]);
				jQuery("#t03").val(ndata["num"]);
				editAreaLoader.setValue("t04", ndata["query"]);
				jQuery("#t05").val(ndata["field1"]);
				jQuery("#t06").val(ndata["field2"]);
				jQuery("#t07").val(ndata["field3"]);
				jQuery("#t08").val(ndata["field4"]);
				jQuery("#f05").val(ndata["format1"]);
				jQuery("#f06").val(ndata["format2"]);
				jQuery("#f07").val(ndata["format3"]);
				jQuery("#f08").val(ndata["format4"]);
				jQuery("#l05").val(ndata["label1"]);
				jQuery("#l06").val(ndata["label2"]);
				jQuery("#l07").val(ndata["label3"]);
				jQuery("#l08").val(ndata["label4"]);
				jQuery("#t09").val(ndata["title"]);
				jQuery("#t10").val(ndata["type"]);
				changemodel();
				jQuery("#t11").val(ndata["model"]);
				jQuery("#t12").val(ndata["width"]);
				jQuery("#t13").val(ndata["height"]);
				jQuery("#t14").val(ndata["page"]);
				jQuery("#t15").val(ndata["link"]);
				jQuery("#t16").val(ndata["order"]);
				jQuery("#t17").val(ndata["style"]);
				jQuery("#t18").val(ndata["class"]);
			},
			error: function (jqXHR, textStatus, errorThrown) {
			}
		});
	}	
	
	jQuery(document).ready(function() { 
		get_accounts();
		get_pages();
		get_slots();
	});
</script>
<?php
	include("footer.php");
?>