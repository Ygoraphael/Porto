<div class="forms">
    <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
        <div class="form-body">
            <form id="email">
                <input type="hidden" readonly name="u_ncidef.u_ncidefstamp" value="<?php echo $u_ncidef["u_ncidefstamp"]; ?>">
                <div class="form-group">
                    <label>Email - Servidor</label>
                    <input type="text" class="form-control" name="u_ncidef.emailserver" value="<?php echo $u_ncidef["emailserver"]; ?>" placeholder="Servidor">
                </div>
                <div class="form-group">
                    <label>Email - Utilizador</label>
                    <input type="text" class="form-control" name="u_ncidef.emailuser" value="<?php echo $u_ncidef["emailuser"]; ?>" placeholder="Utilizador">
                </div>
                <div class="form-group">
                    <label>Email - Password</label>
                    <input type="text" class="form-control" name="u_ncidef.emailpw" value="<?php echo $u_ncidef["emailpw"]; ?>" placeholder="Password">
                </div>
                <div class="form-group">
                    <label>Email - Remetente</label>
                    <input type="text" class="form-control" name="u_ncidef.emailfrom" value="<?php echo $u_ncidef["emailfrom"]; ?>" placeholder="Remetente">
                </div>
                <div class="form-group">
                    <label>Email - Porta SMTP</label>
                    <input type="text" class="form-control" name="u_ncidef.emailport" value="<?php echo $u_ncidef["emailport"]; ?>" placeholder="Porta SMTP">
                </div>
                <div class="form-group">
                    <label>Email - Encriptação</label>
                    <select name="u_ncidef.emailenc" class="form-control1">
                        <option <?php echo $u_ncidef["emailenc"] == "0" ? "selected" : ""; ?> value="0">Nenhuma</option>
                        <option <?php echo $u_ncidef["emailenc"] == "1" ? "selected" : ""; ?> value="1">SSL</option>
                        <option <?php echo $u_ncidef["emailenc"] == "2" ? "selected" : ""; ?> value="2">TLS</option>
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

    var Email = function () {
        this.baseUrl = '<?php echo base_url(); ?>';
        this.controller = 'config';

        this.update = function (item) {
            return $.ajax({
                method: "POST",
                url: this.baseUrl + this.controller + "/update_dados",
                data: {"item" : item},
                dataType: "json"
            });
        };
    };

    var email = new Email();

    function save() {
        $(".loading-overlay").show();
        
        var item = JSON.stringify( $("form#email").serializeToJSON() );
        
        $(".savebut").attr("disabled", "disabled");
        
        email.update(item).done(function (resp) {
            $(".savebut").removeAttr("disabled");

            // hide modal
            $(".loading-overlay").hide();
            // show notification
            toastr.success(resp.message);
        });
    }

</script>