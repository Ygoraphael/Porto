<div class="forms">
    <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
        <div class="form-body">
            <form id="config">
                <input type="hidden" readonly name="u_ncidef.u_ncidefstamp" value="<?php echo $u_ncidef["u_ncidefstamp"]; ?>">
                <div class="checkbox">
                    <label><input name="u_ncidef.ponto" <?php echo $u_ncidef["ponto"] ? "checked" : ""; ?> type="checkbox"> Ponto</label>
                </div>
                <div class="checkbox">
                    <label><input name="u_ncidef.picking" <?php echo $u_ncidef["picking"] ? "checked" : ""; ?> type="checkbox"> Picking</label>
                </div>
                <div class="checkbox">
                    <label><input name="u_ncidef.tarefas" <?php echo $u_ncidef["tarefas"] ? "checked" : ""; ?> type="checkbox"> Tarefas</label>
                </div>
                <br>
                <h5>Configurações Ponto</h5>
                <hr/>
                <div class="form-group">
                    <label>Tipo</label>
                    <select name="u_ncidef.pontotipo" class="form-control1">
                        <option value="0" <?php echo $u_ncidef["pontotipo"] == "0" ? "selected" : "" ?> >Dossier</option>
                        <option value="1" <?php echo $u_ncidef["pontotipo"] == "1" ? "selected" : "" ?> >Tabela</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Dossier</label>
                    <select name="u_ncidef.ndosponto" value="<?php echo $u_ncidef["ndosponto"]; ?>" class="form-control1">
                        <?php foreach ($ts as $dos) { ?>
                            <option <?php echo $u_ncidef["ndosponto"] == $dos["ndos"] ? "selected" : "" ?> value="<?php echo $dos["ndos"]; ?>"><?php echo $dos["nmdos"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tabela</label>
                    <input type="text" class="form-control" name="u_ncidef.pontotabela" value="<?php echo $u_ncidef["pontotabela"]; ?>" placeholder="Tabela">
                </div>
                <br>
                <h5>Configurações Tarefas</h5>
                <hr/>
                <div class="form-group">
                    <label>Tipo</label>
                    <select name="u_ncidef.tarefastipo" class="form-control1">
                        <option value="0" <?php echo $u_ncidef["tarefastipo"] == "0" ? "selected" : "" ?> >Dytable</option>
                        <option value="1" <?php echo $u_ncidef["tarefastipo"] == "1" ? "selected" : "" ?> >Tabela</option>
                        <option value="2" <?php echo $u_ncidef["tarefastipo"] == "2" ? "selected" : "" ?> >Dossier</option>
                        <option value="3" <?php echo $u_ncidef["tarefastipo"] == "3" ? "selected" : "" ?> >Artigos</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tipo Registo</label>
                    <select name="u_ncidef.tarefa_registo_stipo" class="form-control1">
                        <option value="0" <?php echo $u_ncidef["tarefa_registo_stipo"] == "0" ? "selected" : "" ?> >Dossier</option>
                        <option value="1" <?php echo $u_ncidef["tarefa_registo_stipo"] == "1" ? "selected" : "" ?> >Tabela</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Dossier Produtos</label>
                    <select name="u_ncidef.ndostarefas" class="form-control1">
                        <?php foreach ($ts as $dos) { ?>
                            <option <?php echo $u_ncidef["ndostarefas"] == $dos["ndos"] ? "selected" : "" ?> value="<?php echo $dos["ndos"]; ?>"><?php echo $dos["nmdos"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Dossier Registo</label>
                    <select name="u_ncidef.ndostarefasreg" class="form-control1">
                        <?php foreach ($ts as $dos) { ?>
                            <option <?php echo $u_ncidef["ndostarefasreg"] == $dos["ndos"] ? "selected" : "" ?> value="<?php echo $dos["ndos"]; ?>"><?php echo $dos["nmdos"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tabela</label>
                    <input type="text" class="form-control" name="u_ncidef.tarefastabela" value="<?php echo $u_ncidef["tarefastabela"]; ?>" placeholder="Tabela">
                </div>
                <div class="form-group">
                    <label>Tabela Registo</label>
                    <input type="text" class="form-control" name="u_ncidef.registotarefas" value="<?php echo $u_ncidef["registotarefas"]; ?>" placeholder="Registo - Tarefa">
                </div>
                <div class="form-group">
                    <label>Tabela Registo (Linhas)</label>
                    <input type="text" class="form-control" name="u_ncidef.registotarefaslinhas" value="<?php echo $u_ncidef["registotarefaslinhas"]; ?>" placeholder="Registo - Tarefa (Linhas)">
                </div>
                <div class="checkbox">
                    <label><input name="u_ncidef.iniciar_tarefas" <?php echo $u_ncidef["iniciar_tarefas"] ? "checked" : ""; ?> type="checkbox"> Escolher tarefa ao iniciar tarefa</label>
                </div>
                <div class="checkbox">
                    <label><input name="u_ncidef.keypad" <?php echo $u_ncidef["keypad"] ? "checked" : ""; ?> type="checkbox"> Ativar Keypad</label>
                </div>
                
                <br>
                <h5>Configurações Picking</h5>
                <hr/>
                <div class="form-group">
                    <label>Dossier</label>
                    <select name="u_ncidef.ndospicking" class="form-control1">
                        <?php foreach ($ts as $dos) { ?>
                            <option <?php echo $u_ncidef["ndospicking"] == $dos["ndos"] ? "selected" : "" ?> value="<?php echo $dos["ndos"]; ?>"><?php echo $dos["nmdos"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <button onclick="save(); return false;" class="btn btn-default savebut">Gravar</button>
            </form> 
        </div>
        <div class="clearfix"> </div>	
    </div>
</div>

<div class="clearfix"> </div>
<script>

    var Resource = function () {
        this.baseUrl = '<?php echo base_url(); ?>';
        this.controller = 'config';

        this.update = function (item) {
            return $.ajax({
                method: "POST",
                url: this.baseUrl + this.controller + "/update_dados",
                data: {"item": item},
                dataType: "json"
            });
        };
    };

    var res = new Resource();

    function save() {
        $(".loading-overlay").show();

        var item = JSON.stringify($("form#config").serializeToJSON());

        $(".savebut").attr("disabled", "disabled");

        res.update(item).done(function (resp) {
            $(".savebut").removeAttr("disabled");

            // hide modal
            $(".loading-overlay").hide();
            // show notification
            toastr.success(resp.message);
        });
    }

</script>