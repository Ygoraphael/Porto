<div class="dropdown">
    <?php
    $qtd_total = 0;
    if (!empty($_SESSION['caret'])) {
        foreach ($_SESSION['caret'] as $id => $curso) {
            if (isset($_SESSION['empresa']))
                $qtd = count($curso['formando']);
            else
                $qtd = 1;
            $qtd_total += $qtd;
        }
    }
    ?>
    <a href="#" id="btn_caret" class="dropdown-toggle" data-toggle="dropdown">
        <?php if ($qtd_total) { ?>
            <span class="numberitems"><?= $qtd_total; ?></span>
        <?php } ?>
        <i class="icon-shopping-cart" style="font-size: 32px; color: #666;"></i>
    </a>
    <ul class="dropdown-menu text-center" style="padding: 5px;width: 500px;left: -352px;">

        <?php
        if (empty($_SESSION['caret'])) {
            ?>
            <li>Não há itens</li>
            <?php
        } else {
            $total_qtd = 0;
            $total = 0;
            $total_qtd_curso = 0;
            ?>
            <li>
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th><b>Produto</b></th>
                            <th style="text-align: center"><b>Qtd.</b></th>
                            <th style="text-align: left"><b>Valor</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['caret'] as $id => $curso) {
                            if (isset($_SESSION['empresa'])) {
                                $qtd = count($curso['formando']);
                                $valor = $qtd * $curso['preco'];
                            } else {
                                $valor = $curso['preco'];
                                $qtd = 1;
                            }
                            ?>
                            <tr>
                                <td style="text-align: center"><a href="index.php/<?= $id; ?>"><?= $curso['nome']; ?> (<?= $curso['tipologia']; ?>)</a></td>
                                <td style="text-align: center"><?php
                                    echo $qtd;
                                    ?></td>
                                <td style="text-align: left"><b><?= $valor; ?>€</b> </td>
                            </tr>
                            <?php
                            $total_qtd += $qtd;
                            $total += $valor;
                            if( $curso['tipologia'] == "curso" )
                                $total_qtd_curso += $qtd;
                        }
                        ?>
                        <tr>
                            <td  style="text-align:center"><b>Total (S/IVA):</b></td>
                            <td style="text-align: center"><b><?= $total_qtd; ?></b></td>
                            <td class="text-left"><b><?= $total; ?>€</b></td>
                        </tr>
                    </tbody>
                </table>
            </li>
            <li style="border-top: 1px dotted #ccc; padding-top: 5px">
                <div class="btn-group inline">
                    <a href="index.php/limpar-compras" class="btn btn-small btn-success pull-left btn-space" style="color:#fff; width:220px;">Limpar Inscrições</a>
                    <a href="index.php/compras" class="btn btn-small btn-success pull-right btn-space" style="color:#fff; width:220px;">Finalizar Inscrições</a>
                </div>
            </li>
        <?php } ?>
        <!-- dropdown menu links -->
    </ul>
</div>

