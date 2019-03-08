<?php?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-th"></i> Objetivos Mensais | Vendedor - <?= $salesman_data[0]["cmdesc"] ?></div>
            <div class="card-body">
                <?php 
                    drawObjectiveTable($salesman_year_sales,$Objective_Current_Year,date("Y"));
                    drawObjectiveTable($salesman_previous_year_sales,$Objective_Previous_Year,date("Y")-1);
                    drawObjectiveTable($salesman_previous_previous_year_sales,$Objective_Previous_Previous_Year,date("Y")-2);
                ?>
            </div>
        </div>
    </div>
</div>


<?php 

function drawObjectiveTable($sales, $objective, $year){
    
    echo '<div class="table-responsive">
            <table class="table table-bordered"   tab-numrow="13" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align:center" colspan="13" style="text-align:center">';
                            echo $year;
                            echo '</th>
                        </tr>
                        <tr>
                            <th style="text-align:center">Objetivos Mensais</th>
                            <th style="text-align:center">01</th>
                            <th style="text-align:center">02</th>
                            <th style="text-align:center">03</th>
                            <th style="text-align:center">04</th>
                            <th style="text-align:center">05</th>
                            <th style="text-align:center">06</th>
                            <th style="text-align:center">07</th>
                            <th style="text-align:center">08</th>
                            <th style="text-align:center">09</th>
                            <th style="text-align:center">10</th>
                            <th style="text-align:center">11</th>
                            <th style="text-align:center">12</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center">Objetivo (€)</td>';
                                for ($i = 1; $i <= 12; $i++) {
                                    $checker=false;
                                    foreach ($objective as $key => $value): 
                                        if($i==$value["mes"]){
                                            echo '<td align="center" style="font-size:14px">'.number_format($value["evalor"],2,'.','').'</td>';
                                            $checker=true;
                                        }
                                     endforeach;
                                    if($checker==false){
                                        echo'<td align="center" style="font-size:14px">0.00</td>';
                                    }
                                }
                            echo'</tr><tr>
                                <td align="center">Real (€)</td>';
                                for ($i = 1; $i <= 12; $i++) {
                                    $checker=0;
                                    $checkExistMonthObjective=0;
                                    $realVal=0;
                                    $objVal=0;   
                                    foreach ($sales as $key => $value):
                                        if($i==$value["mes"]){
                                            $realVal=$value["valor"];
                                            $checker=1; 
                                        }
                                    endforeach;
                                    foreach ($objective as $key => $value1): 
                                        if($i==$value1["mes"]){
                                            $objVal=$value1["evalor"]; 
                                            $checkExistMonthObjective=1; 
                                        }     
                                    endforeach;
                                    if($checker==0){
                                        if($checkExistMonthObjective==1){
                                            echo '<td align="center" class="red">0.00</td>';
                                        }else{
                                            echo '<td align="center" class="green">0.00</td>';
                                        }   
                                    }else{
                                        if($checkExistMonthObjective==0){
                                            echo '<td align="center" class="green">'.number_format($realVal,2,'.','').'</td>';  
                                        }else{
                                            if($realVal>$objVal){
                                                echo '<td align="center" class="green">'.number_format($realVal,2,'.','').'</td>';
                                            }else{
                                                echo '<td align="center" class="red">'. number_format($realVal,2,'.','').'</td>';
                                            }
                                        }
                                    }
                                }   
                        echo'</tr> 
                    </tbody>
                </table>
            </div>';
}

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

?>
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
