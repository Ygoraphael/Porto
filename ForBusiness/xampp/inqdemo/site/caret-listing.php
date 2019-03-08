
<div class="dropdown">
    <a href="#" id="btn_caret" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-shopping-cart" style="font-size: 32px; color: #666;"></i>
    </a>
    <ul class="dropdown-menu text-center" style="padding: 5px;">

        <?php
        if (empty($_SESSION['caret'])) {
            ?>
            <li>Não há itens</li>

            <?php
        } else {
            $total_qtd = 0;
            $total = 0;
            ?>
            <li>
                <table class="table table-responsive">
                    <thead>
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
                                $qtd = count($curso['aluno']);
                                $valor = count($curso['aluno']) * $curso['preco'];
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
                                <td><b><?= $valor; ?>€</b> </td>
                            </tr>
                            <?php
                            $total_qtd += $qtd;
                            $total += $valor;
                        }
                        ?>
                        <tr>
                            <td  style="text-align:center"><b>Total (S/IVA):</b></td>
                            <td style="text-align: center"><b><?= $total_qtd; ?></b></td>
                            <td class="text-right"><b><?= $total; ?>€</b></td>
                        </tr>
                    </tbody>
                </table></li>

            <li style="border-top: 1px dotted #ccc; padding-top: 5px">
                <a href="/inqdemo/index.php/compras" class="btn-small btn-success pull-right" style="color:#fff">Finalizar Compras</a>
            </li>
        <?php } ?>
        <!-- dropdown menu links -->
    </ul>
</div>

