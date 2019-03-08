<div class="row text-center" style="margin-bottom:50px">
    <div class="col-sm-12">
        <h1 class="nctitle">Trabalhos Em Curso</h1>
    </div>
</div>
<div class="row">
    <?php foreach ($ongoing_inter as $ogi) : ?>

        <?php
        $color = "success";
        $obs = array();

        //é um projeto?
        if (!strlen(trim($ogi["nome_projeto"]))) {
            //tem contrato?
            if ($ogi["contrato"] == 1) {
                //tem horas ?
                if ($ogi["hrestantes_csup"] > 0) {
                    //com esta intervenção, continua com horas?
                    $tmp_contador = intval($ogi["contador"]) / 3600;
                    if ($ogi["hrestantes_csup"] - $tmp_contador <= 0) {
                        $color = "danger";
                        $obs[] = "Com esta intervenção, contrato fica sem horas";
                    }
                } else {
                    $color = "danger";
                    $obs[] = "Contrato com horas a negativo";
                }
            }
        }

        //o cliente tem dividas criticas?
        if ($ogi["super_vencido"] > 0) {
            $color = "danger";
            $obs[] = "Cliente com saldo vencido há BASTANTE tempo";
        }
        else if($ogi["vencido"] > 0 && $color != "danger") {
            $color = "warning";
            $obs[] = "Cliente com saldo vencido";
        }
        ?>


        <div class="col-sm-4">
            <div class="card card-4-8 card-default nopadding border-<?= $color ?> well-<?= $color ?>">
                <div class="card-heading"><h4><?= $ogi["username"] ?></h4></div>
                <div class="card-body">
                    <div class="card-left act_tempo<?= $ogi["id"] ?>">
                        <?php
                        $tmp_contador = intval($ogi["contador"]);
                        $hours = $tmp_contador / 3600;
                        $tmp_contador = $tmp_contador % 3600;
                        $minutes = $tmp_contador / 60;
                        $tmp_contador = $tmp_contador % 60;
                        $seconds = $tmp_contador;
                        ?>
                        <h3><?= sprintf('%02u:%02u:%02u', intval($hours), intval($minutes), $seconds) ?></h3>
                    </div>
                    <div class="card-right">
                        <p><?= substr($ogi["nome_cliente"], 0, 48) ?></p>
                    </div>
                </div>
                <div class="card-footer"><h4>Proj: <?= strlen(trim($ogi["nome_projeto"])) ? trim($ogi["nome_projeto"]) : "--" ?></h4></div>
                <div class="card-footer"><p><b>Notas:</b> <?= count($obs) ? implode(" | ", $obs) : "N/A" ?></p></div>
            </div>
        </div>

    <?php endforeach; ?>
</div>

<?php foreach ($ongoing_inter as $ogi) : ?>
    <?= "<input type='hidden' class='cur_contador" . $ogi["id"] . "' value='" . $ogi["contador"] . "' />\n"; ?>
    <?= "<input type='hidden' class='cur_data" . $ogi["id"] . "' value='" . $ogi["data"] . "' />\n"; ?>
    <?= "<input type='hidden' class='cur_timer" . $ogi["id"] . "' value='' />\n"; ?>
<?php endforeach; ?>

<script>
	globalScript = {
		pad: function (n) {
			return ("0" + n).slice(-2);
		},
		myTimer: function (blabla, id, ajax) {
			if (ajax) {
				$.ajax({
					url: "ajax/get_timestamp",
					success: function (data) {
						current_timestamp = data;
						var blabla = current_timestamp - Math.round((new Date()).getTime() / 1000);
						globalScript.myTimer(blabla, id, 0);
						timerId = setInterval(
								function () {
									globalScript.myTimer(blabla, id, 0);
								}, 1000)
						jQuery(".cur_timer" + id).val(timerId);
					}
				})
			} else {
				var ts = Math.round((new Date()).getTime() / 1000) + parseInt(blabla);
				var current_contador = parseInt($(".cur_contador" + id).val()) + ts - parseInt($(".cur_data" + id).val());
				var hours = current_contador / 3600;
				current_contador = current_contador % 3600;
				var minutes = current_contador / 60;
				current_contador = current_contador % 60;
				var seconds = current_contador

				$(".act_tempo" + id + " h3").html(globalScript.pad(Math.floor(hours)) + ':' + globalScript.pad(Math.floor(minutes)) + ':' + globalScript.pad(Math.floor(seconds)));
			}
		},
		init: function () {
			<?php foreach ($ongoing_inter as $ogi) : ?>
			<?= ( $ogi["activo"] == 1 ) ? "globalScript.myTimer(0, " . $ogi["id"] . ", 1);\n" : ""; ?>
			<?php endforeach; ?>
		}
	}
	
    globalScript.init();
</script>

