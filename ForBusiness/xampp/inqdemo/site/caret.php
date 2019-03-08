<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$total = 0;
$total_qtd = 0;
?>

<div class="container">
    <div class="span12">
        <div class="page-header">
            <h1><small><i class="icon-shopping-cart"></i> checkout</small></h1>
        </div>
        <div class="page-section">
            <?php 
            if (!empty($_SESSION['caret'])) {
                ?>

                <table class="table table-striped">
                    <thead style="background-color: #ccc !important">
                        <tr>
                            <th><b>Curso</b></th>
                            <th style="text-align: center"><b>QTD</b></th>
                            <th style="text-align: left"><b>Valor</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['caret'] as $id => $curso) {
                            if (isset($_SESSION['empresa'])) {
                                $qtd = count($curso['aluno']['id']);
                                $valor = count($curso['aluno']['id']) * $curso['preco'];
                            } else {
                                $valor = $curso['preco'];
                                $qtd = 1;
                            }
                            ?>
                            <tr>
                                <td style="text-align: center"><a href="index.php/<?= $id; ?>"><?= $curso['nome']; ?></a></td>
                                <td style="text-align: center"><?php
                                    echo $qtd;
                                    ?></td>
                                <td><b><?= $valor; ?>€</b> <a href="#" id="<?= $id; ?>" class="btn_remove_curso pull-right" title="Remover Curso" alt="remover curso"><i class="icon-remove-circle"></i></a></td>
                            </tr>
                            <?php
                            $total_qtd += $qtd;
                            $total += $valor;
                        }
                        ?>
                        <?php

                        if ($total_qtd < 2) {
                            $valorfinal = $total;
                        } elseif ($total_qtd == 2) {
                            $valorfinal = $total * 0.90;
                        } elseif ($total_qtd > 2) {
                            $valorfinal = $total * 0.80;
                        } 

                        ?>



                        <tr>
                            <td style="text-align:center"><b>Total (sem IVA):</b></td>
                            <td style="text-align: center"><b><?= $total_qtd; ?></b></td>
                            <td class="text-right"><b><?= $valorfinal; ?>€</b></td>
                        </tr>
						<tr>
                            <td style="text-align:center"><b>Total a pagar (com IVA à taxa legal em vigor):</b></td>
							<td style="text-align: center"></td>
                            <td class="text-right"><b><?= number_format($valorfinal * 1.23,2,",",".") ; ?>€</b></td>
                        </tr>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="alert alert-block">
                    <h3>Seu carrinho está vazio!</h3>
                    Escolha um de nossos curso, aproveite nossas promoções.
                </div>
            <?php } ?>
        </div>  
    </div>
</div>
<div class="clearfix"></div>
<div class="span12">
    <a href="/inqdemo/index.php?option=com_jumi&view=application&fileid=29" class="btn btn-success pull-right">Concluir</a>
</div>
<div class="clearfix"></div>