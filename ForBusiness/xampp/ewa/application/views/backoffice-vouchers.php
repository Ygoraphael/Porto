<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
		<?php if($access_cvoucher){?>
		<button type="button" id="create_prod" class="btn btn-info pull-right"><?php echo $this->translation->Translation_key("Create Voucher", $_SESSION['lang_u']); ?></button>
		<?php }?>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<table id="tab-products" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><?php echo $this->translation->Translation_key("Code", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Description", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Value", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Type", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Date Validity", $_SESSION['lang_u']); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach( $vouchers as $voucher ) {?>
				<tr>
					<td><?php echo $voucher["code"]; ?></td>
					<td><?php echo $voucher["design"]; ?></td>
					<td><?php echo number_format($voucher["value"], 2, '.', ''); ?></td>
					<td><?php echo $voucher["type"]; ?></td>
					<td><?php echo substr($voucher["validity"],0,10); ?></td>
					<td class="text-center"><a onclick="edit_item('<?php echo $voucher["u_vouchstamp"]; ?>')" class="btn btn-default  <?php echo ($access_view)?"":"disabled" ?>"><span class="glyphicon glyphicon-search"></span></a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<form method="post" id="theForm" action="voucher">
		<input id="theFormid" type="hidden" name="id" value="1">
		</form>
		<script>
			jQuery(document).ready(function() {
				var mostrar = "<?php echo $this->translation->Translation_key("To show", $_SESSION['lang_u']); ?>";
				var ate = "<?php echo $this->translation->Translation_key("Until", $_SESSION['lang_u']); ?>";
				var corpo = "<?php echo $this->translation->Translation_key("Records of a total of", $_SESSION['lang_u']); ?>";
				var records = "<?php echo $this->translation->Translation_key("Records", $_SESSION['lang_u']); ?>";
				jQuery('#tab-products').DataTable({
		dom: 'lBfrtip',
		buttons: [	],
		oLanguage: {
			sSearch: "<?php echo $this->translation->Translation_key("Search", $_SESSION['lang_u']); ?>:",
			oPaginate: {
				sFirst:		"<?php echo $this->translation->Translation_key("First", $_SESSION['lang_u']); ?>",
				sLast:		"<?php echo $this->translation->Translation_key("Last", $_SESSION['lang_u']); ?>",
				sNext:		"<?php echo $this->translation->Translation_key("Next", $_SESSION['lang_u']); ?>",
				sPrevious:	"<?php echo $this->translation->Translation_key("Previous", $_SESSION['lang_u']); ?>"
			},
			"sInfo": mostrar+" _START_ "+ ate +" _END_ "+ corpo + " _TOTAL_ "+ records,
			"sLengthMenu":     mostrar+ " _MENU_ "+records
		},
		"iDisplayLength": 10,
		sPaginationType : "full_numbers"
		
	});
			});
			
			jQuery("#create_prod").click(function() {
				window.location.href = "<?php echo base_url(); ?>backoffice/voucher_new";
			});
			
			function edit_item(id){
				$('#theFormid').val(id);
				$('#theForm').submit()
			}
			
		</script>
	</div>
</div>