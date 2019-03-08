<div class="row">
    <?php $this->load->view('dashboard/weather') ?>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="statcard text-white p-4 bg-primary">
            <h3 class="statcard-number">
                <?php
                $fat_diff_perc = 0;
                $fat_diff_delta = '';
                $fat_cur_month = 0;
                $fat_last_month = 0;
                
                if (count($cur_month_sales)) {
                    echo number_format($cur_month_sales[0]["valor"], 2, '.', '');
                    $fat_cur_month = $cur_month_sales[0]["valor"];
                }
                else {
                    echo number_format($fat_cur_month, 2, '.', '');
                }
                
                if (count($last_month_sales)) {
                    $fat_last_month = $last_month_sales[0]["valor"];
                }
                if ($fat_last_month != 0) {
                    $tmp = round((floatval($fat_cur_month) - floatval($fat_last_month)) / floatval($fat_last_month) * 100, 0);
                    $fat_diff_perc = abs($tmp);
                    if ($tmp >= 0) {
                        $fat_diff_delta = 'fa-long-arrow-up';
                    } else {
                        $fat_diff_delta = 'fa-long-arrow-down';
                    }
                } else {
                    $fat_diff_perc = 0;
                    $fat_diff_delta = 'fa-long-arrow-up';
                }
                ?>
                <small class="delta-indicator delta-positive small"><?= $fat_diff_perc ?>%</small>
                <i class="fa <?= $fat_diff_delta ?>" aria-hidden="true"></i>
            </h3>
            <span class="statcard-desc">Faturação Mensal - face ao mês anterior</span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="statcard text-white p-4 bg-warning">
            <h3 class="statcard-number">
                <?php
                $purc_diff_perc = 0;
                $purc_diff_delta = '';
                $purc_cur_month = 0;
                $purc_last_month = 0;
                
                if (count($cur_month_purchases)) {
                    echo number_format($cur_month_purchases[0]["valor"], 2, '.', '');
                    $purc_cur_month = $cur_month_purchases[0]["valor"];
                }
                else {
                    echo number_format($purc_cur_month, 2, '.', '');
                }
                
                if (count($last_month_purchases)) {
                    $purc_last_month = $last_month_purchases[0]["valor"];
                }
                if ($purc_last_month != 0) {
                    $tmp = round((floatval($purc_cur_month) - floatval($purc_last_month)) / floatval($purc_last_month) * 100, 0);
                    $purc_diff_perc = abs($tmp);
                    if ($tmp >= 0) {
                        $purc_diff_delta = 'fa-long-arrow-up';
                    } else {
                        $purc_diff_delta = 'fa-long-arrow-down';
                    }
                } else {
                    $purc_diff_perc = 0;
                    $purc_diff_delta = 'fa-long-arrow-up';
                }
                ?>
                <small class="delta-indicator delta-positive small"><?= $purc_diff_perc ?>%</small>
                <i class="fa <?= $purc_diff_delta ?>" aria-hidden="true"></i>
            </h3>
            <span class="statcard-desc">Compras Mensal - face ao mês anterior</span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="statcard text-white p-4 bg-success">
            <h3 class="statcard-number">
                <?php
                if (count($best_seller_stfami)) {
                    echo $best_seller_stfami[0]["ref"];
                } else {
                    echo "N/D";
                }
                ?>
            </h3>
            <span class="statcard-desc">Família Mais Vendida (<?= date('Y') ?>)</span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="statcard text-white p-4 bg-danger">
            <h3 class="statcard-number">
                <?php
                if (count($best_seller_st)) {
                    echo $best_seller_st[0]["ref"];
                } else {
                    echo "N/D";
                }
                ?>
            </h3>
            <span class="statcard-desc">Artigo Mais Vendido (<?= date('Y') ?>)</span>
        </div>
    </div>
</div>
<?php $this->load->view('dashboard/indicadores_gestao') ?>
<?php $this->load->view('dashboard/objetivos_mensais') ?>
<?php $this->load->view('dashboard/vendedor/year_sales') ?>
<?php $this->load->view('dashboard/year_sales_comparison') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Top 50 Clientes em Divida | Vendedor - <?= $salesman_data[0]["cmdesc"] ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dtinit" tab-ordercol="2" tab-order="desc" tab-numrow="10" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align:center">Nº</th>
                                <th style="text-align:center">Nome</th>
                                <th style="text-align:center">Saldo</th>
                                <th style="text-align:center"></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th style="text-align:center">Nº</th>
                                <th style="text-align:center">Nome</th>
                                <th style="text-align:center">Saldo</th>
                                <th style="text-align:center"></th>
                                
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($rankdiv_salesman as $key => $value): ?>
                                <tr>
                                    <td align="center"><?= $value["no"] ?></td>
                                    <td align="center"><?= $value["nome"] ?></td>
                                    <td align="center"><?= number_format($value["esaldo"], 2) ?></td>
                                    <td align="center" style="padding-top:2px"><a href="<?= base_url() ?>cl/reg/<?= $value["clstamp"] ?>" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>