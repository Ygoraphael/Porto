		
<div class="col-md-3 col-md-offset-1 anim hvr-grow">
    <div class="widget-box drop-shadow">
        <?php
        if ($result[$cur_cell]->desconto > 0) {
            ?>
            <div class="promotion"><span class="discount">- <?php echo $result[$cur_cell]->desconto; ?>%</span></div>
            <?php
        }
        switch ($result[$cur_cell]->Linha) {
            case 'PRO':
                $linha_cor = 'back_black';
                break;
            case 'RACE':
                $linha_cor = 'back_red';
                break;
            case 'SPORT':
                $linha_cor = 'back_orange';
                break;
        }
        ?>
        <div class="linha_label">
            <span class="linha_label_txt <?php echo $linha_cor; ?>">
                <?php echo $result[$cur_cell]->Linha; ?>
            </span>
        </div>

        <div style="position:absolute; top:0;">
            <?php
            echo '<br> <br>';
            if ($result[$cur_cell]->novidade > 0) {
                ?>
                <div class="new_prod">
                    <span class="new_prod_label">
                        <?php echo JText::_('COM_VIRTUEMART_NEW'); ?>
                    </span>
                </div>
                <?php
            }
            ?>
        </div>
        <!-- img & price -->
        <a href="<?php echo $p_link; ?>" title="<?php echo $product_rel->product_name ?>">
            <img class="img-fluid" src="<?php echo $imagem; ?>" alt="<?php echo $product_rel->product_name ?>">
            <p style="text-align:center; color:black; padding-top:15px;">
                <?php echo $product_rel->category_name; ?><br>
                <?php echo $product_rel->product_name ?> <br>
                € <?php echo number_format($product_rel->prices["basePriceWithTax"], 2); ?>
            </p>
        </a>
        <!-- img & price -->
        <div class="hide hidden-sizes">
            <ul>
                <li class="btn-danger">XS</li>
                <li class="btn-success">S</li>
                <li class="btn-success">M</li>
                <li class="btn-danger">L</li>
                <li class="btn-danger">XL</li>
                <li class="btn-danger">2XL</li>
                <li class="btn-danger">3XL</li>
                <li class="btn-danger">4XL</li>
            </ul>
            <div class="container">
                <div class="row ">
                    <div class="col-md-6">
                        <div style="margin-left:10px;">
                            <div class="row">
                                <div class="rcorners1"></div>
                                <div class="cenas">EM STOCK</div>
                            </div>
                            <div class="row">
                                <div class="rcorners2"></div>
                                <div class="cenas">FORA DE STOCK</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="btn-destaques btn-danger">
                            <a href="<?php echo $p_link; ?>" title="<?php echo $product_rel->product_name ?>">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="" style="text-align:center; padding:1px;">
            <?php
            if ($language->getTag() == "en-GB") {
                $query = $db->getQuery(true);
                $query->select($db->quoteName(array('en_gb')));
                $query->from($db->quoteName('#__filtros'));
                $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($result[$cur_cell]->Categoria) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('categoria'));

                $db->setQuery($query);
                $db->execute();
                $num_rows = $db->getNumRows();

                if ($num_rows > 0) {
                    $results = $db->loadRowList();
                    echo '<span style="font-size:10px">' . $results[0][0] . '</span> &#8226;';
                } else {
                    ?>
                    <span style="font-size:10px"><?php echo $result[$cur_cell]->Categoria; ?></span> &#8226;
                    <?php
                }
            } else {
                ?>
                <span style="font-size:10px"><?php echo $result[$cur_cell]->Categoria; ?></span> &#8226;
                <?php
            }
            ?>
            <?php
            if ($language->getTag() == "en-GB") {
                $query = $db->getQuery(true);
                $query->select($db->quoteName(array('en_gb')));
                $query->from($db->quoteName('#__filtros'));
                $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($result[$cur_cell]->Modalidade) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('modalidade'));

                $db->setQuery($query);
                $db->execute();
                $num_rows = $db->getNumRows();

                if ($num_rows > 0) {
                    $results = $db->loadRowList();
                    echo '<span style="font-size:10px">' . $results[0][0] . '</span> &#8226;';
                } else {
                    ?>
                    <span style="font-size:10px"><?php echo $result[$cur_cell]->Modalidade; ?></span> &#8226;
                    <?php
                }
            } else {
                ?>
                <span style="font-size:10px"><?php echo $result[$cur_cell]->Modalidade; ?></span> &#8226;
                <?php
            }
            ?>
            <span style="font-size:10px">
            <?php
            if ($result[$cur_cell]->Genero == "MALE;FEMALE" or $result[$cur_cell]->Genero == "MASCULINO;FEMININO") {
                if ($language->getTag() == "en-GB") {
                    echo "GENDERLESS";
                } else {
                    echo "UNISSEXO";
                }
            } else {
                if ($language->getTag() == "en-GB") {
                    if ($result[$cur_cell]->Genero == "MASCULINO")
                        echo "MALE";
                    if ($result[$cur_cell]->Genero == "FEMININO")
                        echo "FEMALE";
                }
                else {
                    echo $result[$cur_cell]->Genero;
                }
            }
            ?></span> &#8226;
                <?php
                if ($language->getTag() == "en-GB") {
                    $query = $db->getQuery(true);
                    $query->select($db->quoteName(array('en_gb')));
                    $query->from($db->quoteName('#__filtros'));
                    $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($result[$cur_cell]->Linha) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('linha'));

                    $db->setQuery($query);
                    $db->execute();
                    $num_rows = $db->getNumRows();

                    if ($num_rows > 0) {
                        $results = $db->loadRowList();
                        echo '<span style="font-size:10px">' . $results[0][0] . '</span>';
                    } else {
                        ?>
                    <span style="font-size:10px"><?php echo $result[$cur_cell]->Linha; ?></span>
                    <?php
                }
            } else {
                ?>
                <span style="font-size:10px"><?php echo $result[$cur_cell]->Linha; ?></span>
                <?php
            }
            ?>
        </div>
    </div>
</div>