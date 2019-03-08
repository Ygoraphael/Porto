<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-bar-chart"></i> Faturação Anual <?= date('Y') - 1 ?>/<?= date('Y') ?> | Vendedor - <?= $salesman_data[0]["cmdesc"] ?></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-9 my-auto">
                        <canvas id="FatCompBarChart" width="100" height="50"></canvas>
                    </div>
                    <div class="col-sm-3 text-center my-auto">
                        <div class="h4 mb-0 text-primary"><?= $salesman_previous_year_sales_total ?> €</div>
                        <div class="small text-muted"><?= date('Y') - 1 ?></div>
                        <hr>
                        <div class="h4 mb-0 text-warning"><?= $salesman_year_sales_total ?> €</div>
                        <div class="small text-muted"><?= date('Y') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-pie-chart"></i> Top 5 Zonas Mais Vendas <?= date('Y') ?></div>
            <div class="card-body">
                <canvas id="AreaTopSales" width="100%" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
    var ctx = document.getElementById("FatCompBarChart");
    var myLineChart = new Chart(ctx, {
    type: 'bar',
            data: {
            labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
                    datasets: [{
                    label: "Faturação",
                            backgroundColor: "rgba(2,117,216,1)",
                            borderColor: "rgba(2,117,216,1)",
<?php
$data_str = "";
$max_valor = 0;
for ($i = 1; $i < 13; $i++) {
    $found = 0;
    foreach ($salesman_previous_year_sales as $monthdata) {
        if ($monthdata["mes"] == $i) {
            $data_str .= $monthdata["valor"] . ', ';
            $found++;
            if ($monthdata["valor"] > $max_valor) {
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
                    },
                    {
                    label: "Faturação",
                            backgroundColor: "rgba(255,193,7,1)",
                            borderColor: "rgba(255,193,7,1)",
<?php
$data_str = "";
for ($i = 1; $i < 13; $i++) {
    $found = 0;
    foreach ($salesman_year_sales as $monthdata) {
        if ($monthdata["mes"] == $i) {
            $data_str .= $monthdata["valor"] . ', ';
            $found++;
            if ($monthdata["valor"] > $max_valor) {
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
                    maxTicksLimit: 6
                    }
            }],
                    yAxes: [{
                    ticks: {
                    min: 0,
                            stepSize : <?= $max_valor/4 ?>,
                            max: <?= $max_valor ?>,
                            maxTicksLimit: 5
                    },
                            gridLines: {
                            display: true
                            }
                    }],
                    
            },
                    legend: {
                    display: false
                    }
            }
    })

    var ctx = document.getElementById("AreaTopSales");
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            <?php
            $data_str = "";
            foreach ($top5_area_salesman_year_sales as $monthdata) {
                $data_str .= "'" . $monthdata["zona"] . "', ";
            }
            ?>
            labels: [<?= $data_str ?>],
            datasets: [{
                <?php
                $data_str = "";
                foreach ($top5_area_salesman_year_sales as $monthdata) {
                    $data_str .= $monthdata["valor"] . ', ';
                }
                ?>
                data: [<?= $data_str ?>],
                backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#fd7e14']
            }]
        },
    });
})
</script>