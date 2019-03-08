<div class="forms">
    <div class="col-xs-12">
        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
            <img src="<?php echo base_url() . $st["imagem"]; ?>" class="img-responsive">
            <div class="clearfix"> </div>	
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
            <div class="form-body">
                <form>
                    <div class="form-group">
                        <label>Referência</label>
                        <input type="text" class="form-control" value="<?php echo $st["ref"]; ?>">
                    </div>
                    <div class="form-group">
                        <label>Designação</label>
                        <input type="text" class="form-control" value="<?php echo $st["design"]; ?>">
                    </div>
                    <div class="form-group">
                        <label>Stock Atual</label>
                        <input type="text" class="form-control" value="<?php echo number_format($st["stock"], 2, '.', ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Família</label>
                        <input type="text" class="form-control" value="<?php echo $st["familia"]; ?>">
                    </div>
                    <div class="form-group">
                        <label>Volume</label>
                        <input type="text" class="form-control" value="<?php echo number_format($st["volume"], 2, '.', ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Peso Líquido</label>
                        <input type="text" class="form-control" value="<?php echo number_format($st["peso"], 2, '.', ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Peso Bruto</label>
                        <input type="text" class="form-control" value="<?php echo number_format($st["pbruto"], 2, '.', ''); ?>">
                    </div>
                </form> 
            </div>
            <div class="clearfix"> </div>	
        </div>
    </div>    
</div>
<div class="clearfix"> </div>