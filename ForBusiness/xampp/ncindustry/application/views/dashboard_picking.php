<div class="row-one">
    <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="stats-left ">
            <h5>Hoje</h5>
            <h4>Enc. Novas</h4>
        </div>
        <div class="stats-right">
            <label> <?= $enc_novas[0]["total"] ?></label>
        </div>
        <div class="clearfix"> </div>	
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 states-mdl">
        <div class="stats-left">
            <h5>Hoje</h5>
            <h4>Enc. Fechadas</h4>
        </div>
        <div class="stats-right">
            <label> <?= $enc_fechadas[0]["total"] ?></label>
        </div>
        <div class="clearfix"> </div>	
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 states-last">
        <div class="stats-left">
            <h5>Global</h5>
            <h4>Enc. em Aberto</h4>
        </div>
        <div class="stats-right">
            <label> <?= $enc_abertas[0]["total"] ?></label>
        </div>
        <div class="clearfix"></div>	
    </div>
    <div class="clearfix"></div>	
</div>
<div class="charts">
    <div class="col-xs-12 charts-grids">
        <h4 class="title">Encomendas Existentes/Fechadas</h4>
        <canvas id="bar" height="80" width="400"> </canvas>
    </div>
    <div class="clearfix"></div>
</div>
<div class="row-one">
    <br>
    <div class="col-xs-12 charts-grids">
        <h4 class="title">TOP 10 Artigos Stock em Falta</h4>
        <table class="table stats-table ">
            <thead>
                <tr>
                    <th>Ref.</th>
                    <th>DESIGNAÇÃO</th>
                    <th>QTD. ENCOMENDADA</th>
                    <th>QTD. EM STOCK</th>
                    <th>QTD. EM FALTA</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($stock_falta)) {
                    foreach ($stock_falta as $stock) {
                ?>
                <tr>
                    <th scope="row"><?= $stock["ref"] ?></th>
                    <td><?= $stock["design"] ?></td>
                    <td><?= $stock["qtt"] ?></td>
                    <td><?= $stock["stock"] ?></td>
                    <td><?= $stock["stock_final"] ?></td>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
    <script>
        var barChartData = {
            labels: ["Jan", "Feb", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            datasets: [
                {
                    fillColor: "rgba(233, 78, 2, 0.9)",
                    strokeColor: "rgba(233, 78, 2, 0.9)",
                    highlightFill: "#e94e02",
                    highlightStroke: "#e94e02",
                    data: [<?php
if (count($enc_abertas_fechadas_mes)) {
    foreach ($enc_abertas_fechadas_mes as $encomenda) {
        echo $encomenda["aberto"] . ", ";
    }
}
?>]
                },
                {
                    fillColor: "rgba(79, 82, 186, 0.9)",
                    strokeColor: "rgba(79, 82, 186, 0.9)",
                    highlightFill: "#4F52BA",
                    highlightStroke: "#4F52BA",
                    data: [<?php
if (count($enc_abertas_fechadas_mes)) {
    foreach ($enc_abertas_fechadas_mes as $encomenda) {
        echo $encomenda["fechado"] . ", ";
    }
}
?>]
                }
            ]
        };

        var pieData = [
            {
                value: 90,
                color: "rgba(233, 78, 2, 1)",
                label: "Product 1"
            },
            {
                value: 50,
                color: "rgba(242, 179, 63, 1)",
                label: "Product 2"
            },
            {
                value: 60,
                color: "rgba(88, 88, 88,1)",
                label: "Product 3"
            },
            {
                value: 40,
                color: "rgba(79, 82, 186, 1)",
                label: "Product 4"
            }
        ];

        new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);

    </script>

</div>
<div class="clearfix"> </div>