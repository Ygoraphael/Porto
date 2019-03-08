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
        <?php 
        
        //Listagem de artigos escolhidos para o carrinho no checkout das tarefas
        foreach ($cart as $item): ?>
            <li class="row">
                <span class="quantity"><?php echo intval($item['qtt']) ?></span>
                <span class="itemName" style="font-size:15px;"><?php echo substr($item['design'], 0, 30); ?></span>
                <span class="remove"><button type="button" onclick="window.location.href = '<?= base_url(); ?>ponto/delete_tmp_tarefa_stamp/<?= $item['ststamp']; ?>'"class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button></span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php $this->load->view('footerscript'); ?>