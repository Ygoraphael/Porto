<div class="forms">
    <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
        <div class="form-body">
            <form id="utilizador">
                <input type="hidden" readonly name="u_ncius.u_nciusstamp" value="<?php echo $u_ncius["u_nciusstamp"]; ?>">
                <div class="form-group">
                    <label>Utilizador</label>
                    <input type="text" class="form-control" readonly placeholder="Utilizador" value="<?php echo $u_ncius["usercode"]; ?>">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" class="form-control" name="u_ncius.u_pass" placeholder="Password" value="<?php echo $u_ncius["u_pass"]; ?>">
                </div>
                <div class="checkbox">
                    <label><input <?php echo $u_ncius["ativo"] ? "checked" : ""; ?> type="checkbox" name="u_ncius.ativo" > Com acesso a NCIndustry</label>
                </div>
                <br />
                <div class="checkbox">
                    <label><input <?php echo $u_ncius["ponto"] ? "checked" : ""; ?> type="checkbox" name="u_ncius.ponto" > Ponto</label>
                </div>
                <div class="checkbox">
                    <label><input <?php echo $u_ncius["picking"] ? "checked" : ""; ?> type="checkbox" name="u_ncius.picking" > Picking</label>
                </div>
                <div class="checkbox">
                    <label><input <?php echo $u_ncius["tarefas"] ? "checked" : ""; ?> type="checkbox" name="u_ncius.tarefas" > Tarefas</label>
                </div>

                <button onclick="save(); return false;" class="btn btn-default savebut">Gravar</button>
            </form> 
        </div>
        <div class="clearfix"> </div>	
    </div>
</div>
<div class="clearfix"> </div>
<script>

    var Utilizador = function () {
        this.baseUrl = '<?php echo base_url(); ?>';
        this.controller = 'config';

        this.update = function (item) {
            return $.ajax({
                method: "POST",
                url: this.baseUrl + this.controller + "/update_utilizador",
                data: {"item" : item},
                dataType: "json"
            });
        };
    };

    var utilizador = new Utilizador();

    function save() {
        $(".loading-overlay").show();
        
        var item = JSON.stringify( $("form#utilizador").serializeToJSON() );
        $(".savebut").attr("disabled", "disabled");
        
        utilizador.update(item).done(function (resp) {
            $(".savebut").removeAttr("disabled");

            // hide modal
            $(".loading-overlay").hide();
            // show notification
            toastr.success(resp.message);
        });
    }

</script>