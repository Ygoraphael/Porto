<div class="text-center">
    <h4>Tarefas</h4>
</div>
<div class="text-left" style="margin-top:5px;">
    <ul>
        <li class="list-inline columnCaptions">
            <span>QTD.</span>
            <span>Produto</span>
            <span></span>
        </li>
        <?php foreach ($temp as $t):?>
            <li class="row">
                <span class="quantity"><?php echo $t['qtt'] ?></span>
                <span class="itemName" style="font-size:15px;"><?php echo substr($t['design'], 0, 30); ?></span>
				<span class="remove"><button class="btn btn-danger btn_delete " data-controller="ponto" data-id="<?php echo $t['ststamp'];?>" title="Apagar Tarefa"><i class="fa fa-times" aria-hidden="true"></i></button></span>
            </li>
        <?php  endforeach; ?>
    </ul>
</div>


<script>
$(document).ready(function () {
	$(document).on('click', '.btn_delete', function () {
		var btn = $(this);
		var src = <?php echo json_encode(base_url()); ?>;
		var id = btn.attr('data-id');
		var action = src + '/' + btn.attr('data-controller') + '/delete_tmp_tarefa6/'+id;
		bootbox.confirm({
			message: 'Are you sure you want to delete the registration',
			buttons: {
				confirm: {
					label: 'Eliminate',
					className: 'btn-success ',
				},
				cancel: {
					label: 'Cancel',
					className: 'btn-danger',
				}
			},
			callback: function (result) {
				if (result) {
					$.post(action,  function () {
					}).done(function (response) {
						console.log(action);
						window.location.reload();
					});
				}
			}
		});	
	});
})	
</script>