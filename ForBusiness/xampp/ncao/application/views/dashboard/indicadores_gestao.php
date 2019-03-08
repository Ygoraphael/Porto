<?php?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-th-list"></i> Indicadores de Gestão | Vendedor - <?= $salesman_data[0]["cmdesc"] ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered"   tab-numrow="13" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align:center">Indicadores de Gestão</th>
                                <th style="text-align:center"><?= date("Y") ?></th>
                                <th style="text-align:center"><?= date("Y")-1 ?></th>
                                <th style="text-align:center"><?= date("Y")-2 ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>  
                                <td align="center">Valor médio Faturado (€)</td>
                                <?php 
                                    for ($i = 0; $i <= 2; $i++) {
                                        foreach ($Average_Sales_Salesman_Three_Years[$i] as $key => $value): 
                                            echo '<td align="center">'.number_format($value["media"],2,'.','').'</td>';
                                        endforeach; 
                                     }
                                ?>
                            </tr>
                            <tr>  
                                <td align="center">Nº Faturas</td>
                                <?php
                                     for ($i = 0; $i <= 2; $i++) {
                                        foreach ($Count_Sales_Salesman_Three_Years[$i] as $key => $value): 
                                            echo '<td align="center">'.$value["nr"].'</td>';
                                        endforeach; 
                                     }
                                ?>
                            </tr>
                            <tr>  
                                <td align="center">Valor Máximo Faturado (€)</td>
                                <?php 
                                    for ($i = 0; $i <= 2; $i++) {
                                        foreach ($Max_Sales_Salesman_Three_Years[$i] as $key => $value): 
                                            echo '<td align="center">'.number_format($value["max"],2,'.','').'</td>';
                                        endforeach; 
                                     }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .green{
        color: #008000;
        font-size: 14px;
    }
    .red{
        color:#dc3545;
        font-size: 14px;
    }
</style>
