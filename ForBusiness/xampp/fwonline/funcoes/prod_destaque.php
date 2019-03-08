<section class="featured-products">
    <div class="container">
        <header class="text-center info_title elipse-border-top box-shadow-destaques" style="padding-top: 20px;">
            <h2 class="text-uppercase elipse-border-bottom" style="padding-bottom: 20px;"><small><?php echo JText::_('NOVOSCANAIS_PRODUCTS'); ?></small><?php echo JText::_('NOVOSCANAIS_FEATURED'); ?></h2>
        </header>
        <div class="owl-carousel owl-theme products-slider owl-loaded owl-drag info_title">
            <!-- Products Slider-->

            <?php
            $language = & JFactory::getLanguage();
            $language->load('mod_virtuemart_product');

            $db = JFactory::getDbo();

            $sql = "	select A.virtuemart_product_id, B.product_name, B.product_s_desc, B.slug, A.desconto, A.novidade, ";
            $sql .= "	ifnull(( select file_url from e506s_virtuemart_product_medias C inner join e506s_virtuemart_medias D on C.virtuemart_media_id = D.virtuemart_media_id where C.virtuemart_product_id = A.virtuemart_product_id order by C.ordering limit 1), 'images/stories/virtuemart/product/logotipo.png') file_url, ";
            $sql .= "	C.Modalidade, C.Genero, C.Linha, C.Categoria";
            $sql .= "	from e506s_virtuemart_products A ";
            $sql .= "	inner join e506s_virtuemart_products_" . str_replace('-', '_', strtolower(strval($language->getTag()))) . " B on A.virtuemart_product_id = B.virtuemart_product_id ";
            $sql .= "	inner join e506s_fastseller_product_type_4 C on A.virtuemart_product_id = C.product_id ";
            $sql .= "	where A.destaque = 1 and A.phc_ref <> ''";
            $sql .= "	limit 50 ";

            $db->setQuery($sql);
            $result = $db->loadObjectList();

            if (sizeof($result) > 0) {
                shuffle($result);
            }

            $cur_cell = 0;

            if (!class_exists('VmConfig'))
                require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
            VmConfig::loadConfig();
            if (!class_exists('VmModel'))
                require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'vmmodel.php');

            $productModel = VmModel::getModel('Product');

            while ($cur_cell < min(10, sizeof($result))) {

                $product_rel = $productModel->getProduct($result[$cur_cell]->virtuemart_product_id);
                $imagem = $result[$cur_cell]->file_url;

                if (strpos($product_rel->link, "en/produtos") === false) {
                    $p_link = $product_rel->link;
                } else {
                    $p_link = str_replace("en/produtos", "en/products", $product_rel->link);
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
                <div class="item">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center">
                            <img src="<?= $imagem ?>" alt="<?= $product_rel->product_name ?>" class="img-fluid">
                            <div class="hover-overlay d-flex align-items-center justify-content-center">
                                <div class="CTA d-flex align-items-center justify-content-center">
                                    <a href="<?= $p_link ?>" class="visit-product active">
                                        <i class="icon-search"></i>VER
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="title text-center">
                            <a href="<?= $p_link ?>">
                                <h3 class="h6 text-uppercase"><?= $product_rel->product_name ?></h3>
                                <h4 class="h8 text-uppercase"><?= $product_rel->category_name ?></h4>
                            </a>
                            <span class="price text-muted">€ <?= number_format($product_rel->prices["basePriceWithTax"], 2) ?></span>
                        </div>
                    </div>
                </div>
                <?php
                $cur_cell++;
            }
            ?>
        </div>
    </div>
</div>
</section>

    <?php if (0) { ?>
    <div class = "widget-box drop-shadow">
        <?php
        if ($result[$cur_cell]->desconto > 0) {
            ?>
            <div class="promotion"><span class="discount">- <?= $result[$cur_cell]->desconto ?>%</span></div>
            <?php
        }
        ?>
        <div class="linha_label">
            <span class="linha_label_txt <?= $linha_cor ?>">
    <?= $result[$cur_cell]->Linha ?>
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
    </div>
<?php } ?>
