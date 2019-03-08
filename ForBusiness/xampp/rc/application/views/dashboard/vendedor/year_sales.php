<?php if(count($salesman_year_sales)) : ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-area-chart"></i> Faturação Anual | Vendedor - <?= $salesman_data[0]["cmdesc"] ?></div>
            <div class="card-body">
                <canvas id="myAreaChart" width="100%" height="30"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
                datasets: [{
                        label: "Valor",
                        lineTension: 0.3,
                        backgroundColor: "rgba(2,117,216,0.2)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(2,117,216,1)",
                        pointHitRadius: 20,
                        pointBorderWidth: 2,
                        <?php
                        $data_str = "";
                        $max_valor = 0;
                        for ($i = 1; $i < 13; $i++) {
                            $found = 0;
                            foreach ($salesman_year_sales as $monthdata) {
                                if ($monthdata["mes"] == $i) {
                                    $data_str .= $monthdata["valor"] . ', ';
                                    $found++;
                                    if( $monthdata["valor"] > $max_valor ) {
                                        $max_valor = ceil($monthdata["valor"]);
                                    }
                                }
                            }
                            if (!$found) {
                                $data_str .= '0, ';
                            }
                        }
                        ?>
                        data: [<?= $data_str ?>]
                    }],
            },
            options: {
                scales: {
                    xAxes: [{
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                    yAxes: [{
                            ticks: {
                                min: 0,
                                max: <?= $max_valor ?>,
                                maxTicksLimit: 5
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)",
                            }
                        }]
                },
                legend: {
                    display: false
                }
            }
        })
    });
</script>
<?php endif; ?>