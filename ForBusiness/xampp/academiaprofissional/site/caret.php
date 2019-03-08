<div class="container">
    <div class="span12">
        <div class="page-header">
            <h1><small><i class="icon-shopping-cart"></i> Carrinho de Compras</small></h1>
        </div>
        <div class="page-section">
            <?php if (!empty($_SESSION['caret'])) { ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead style="background-color: #ccc !important">
                            <tr>
                                <th style="text-align: left"><b>Produto</b></th>
                                <th style="text-align: center"><b>Qtd.</b></th>
                                <th style="text-align: right"><b>Preço Unit.</b></th>
                                <th style="text-align: right"><b>Total</b></th>
                                <th style="text-align: left"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $total = 0;
                            $total_qtd = 0;
                            $total_qtd_curso = 0;

                            $formandos_qtt = array();
                            foreach ($_SESSION['caret'] as $id => $curso) {
                                if (isset($_SESSION['empresa'])) {
                                    $qtd = count($curso['formando']);
                                    $valor = $qtd * $curso['preco'];

                                    foreach ($curso['formando'] as $qfor) {
                                        if (array_key_exists($qfor['NIF'], $formandos_qtt)) {
                                            if ($curso['tipologia'] == "curso")
                                                $formandos_qtt[$qfor['NIF']] = $formandos_qtt[$qfor['NIF']] + 1;
                                        }
                                        else {
                                            if ($curso['tipologia'] == "curso")
                                                $formandos_qtt[$qfor['NIF']] = 1;
                                        }
                                    }
                                } else {
                                    $valor = $curso['preco'];
                                    $qtd = 1;

                                    if (array_key_exists($_SESSION['caret_user']['NIF'], $formandos_qtt)) {
                                        if ($curso['tipologia'] == "curso")
                                            $formandos_qtt[$_SESSION['caret_user']['NIF']] = $formandos_qtt[$_SESSION['caret_user']['NIF']] + 1;
                                    }
                                    else {
                                        if ($curso['tipologia'] == "curso")
                                            $formandos_qtt[$_SESSION['caret_user']['NIF']] = 1;
                                    }
                                }
                                ?>
                                <tr>
                                    <td style="text-align: left"><a href="index.php/<?= $curso['cc']; ?>"><?= $curso['nome']; ?> (<?= $curso['tipologia']; ?>)</a></td>
                                    <td style="text-align: center"><?php echo $qtd; ?></td>
                                    <td style="text-align: right"><b><?= number_format($curso['preco'], 2, ",", "."); ?> €</b></td>
                                    <td style="text-align: right"><b><?= number_format($valor, 2, ",", "."); ?> €</b></td>
                                    <td>
                                        <a style="width:100%; text-align: center" href="#" id="<?= $id; ?>" class="btn_remove_curso pull-right" ><i class="icon-remove-circle"></i></a>
                                    </td>
                                </tr>
                                <?php
                                $total_qtd += $qtd;
                                $total += $valor;
                                if ($curso['tipologia'] == "curso")
                                    $total_qtd_curso += $qtd;
                            }
                            ?>
                            <?php
                            $formultiplecourse = 0;
                            foreach ($formandos_qtt as $fq) {
                                if ($fq > 1)
                                    $formultiplecourse = 1;
                            }

                            $desc_perc = 0;

                            //if ($total_qtd_curso <= 1) {
                            //    $desconto = 0;
                            //} elseif ($formultiplecourse) {
                            //    $desconto = $total - ($total * 0.80);
                            //    $desc_perc = 20;
                            //} elseif ($total_qtd_curso == 2) {
                            //    $desconto = $total - ($total * 0.90);
                            //    $desc_perc = 10;
                            //} elseif ($total_qtd_curso >= 3) {
                            //    $desconto = $total - ($total * 0.80);
                            //    $desc_perc = 20;
                            //}
                            $desconto = 0;
                            ?>
                        </tbody>
                    </table>
                </div>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td style="width:70%; text-align:right"><b>Total (sem IVA):</b></td>
                            <td style="text-align:right; padding-right:15px;" class="text-right"><b><?= number_format($total, 2, ",", "."); ?> €</b></td>
                        </tr>
                        <tr>
                            <td style="text-align:right"><b>Desconto (%):</b></td>
                            <td style="text-align:right; padding-right:15px;" class="text-right"><b><?= number_format($desc_perc, 2, ",", "."); ?></b></td>
                        </tr>
                        <tr>
                            <td style="text-align:right"><b>Total a pagar (com IVA à taxa legal em vigor):</b></td>
                            <td style="text-align:right; padding-right:15px;" class="text-right"><b><?= number_format(($total - $desconto) * 1.23, 2, ",", "."); ?> €</b></td>
                        </tr>
                    </tbody>
                </table>
<?php } else { ?>
                <div class="alert alert-block">
                    <h3>Carrinho de compras vazio!</h3>
                    Escolha um dos nossos cursos, aproveite as nossas promoções.
                </div>
<?php } ?>
        </div>  
    </div>
</div>
<div class="clearfix"></div>
<div class="span12"></div>
<style>
.pulse {
  display: block;
  cursor: pointer;
  animation: pulse 2s infinite;
}
.pulse:hover {
  animation: none;
}

@-webkit-keyframes pulse {
  0% {
    -webkit-box-shadow: 0 0 0 0 rgba(0,255,0, 0.6);
  }
  70% {
      -webkit-box-shadow: 0 0 0 20px rgba(255,0,0, 0);
  }
  100% {
      -webkit-box-shadow: 0 0 0 0 rgba(255,0,0, 0);
  }
}
@keyframes pulse {
  0% {
    -moz-box-shadow: 0 0 0 0 rgba(0,255,0, 0.6);
    box-shadow: 0 0 0 0 rgba(0,255,0, 0.6);
  }
  70% {
      -moz-box-shadow: 0 0 0 10px rgba(255,0,0, 0);
      box-shadow: 0 0 0 20px rgba(255,0,0, 0);
  }
  100% {
      -moz-box-shadow: 0 0 0 0 rgba(255,0,0, 0);
      box-shadow: 0 0 0 0 rgba(255,0,0, 0);
  }
}
</style>
<div class="span12">
    <a href="<?= JURI::base() ?>" class="col-xs-12 col-sm-3 btn btn-alert">Continuar a Comprar</a>
    <a href="<?= JURI::base() ?>index.php/concluir-compra" class="col-xs-12 col-sm-3 btn btn-success pull-right pulse">Finalizar Inscrições</a>
</div>
<div class="clearfix"></div>
