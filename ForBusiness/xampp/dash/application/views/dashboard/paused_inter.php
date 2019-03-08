<div class="row text-center" style="margin-bottom:50px">
    <div class="col-sm-12">
        <h1 class="nctitle">Trabalhos Em Pausa</h1>
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

<script>
	globalScript = {
		myTimer: function (blabla, id, ajax) {
		},
		init: function () {
		}
	}
	
    globalScript.init();
</script>

