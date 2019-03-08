<?php
/**
 * @package Xpert Captions
 * @version 2.7
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
// no direct access
defined( '_JEXEC' ) or die('Restricted access');

$title = $params->get('title');
$intro = $params->get('intro');

?>
    <!--Xpert Captions by ThemeXpert- Start-->
    <div id="<?php echo $module_id;?>" class="xpert-captions">
        <?php foreach($items as $item):?>
            <div class="xc-block <?php echo $params->get('animation');?>">
                <div class="<?php echo ($params->get('effect_apply') == 'caption')? 'xc-overlay' : 'xc-backdrop' ;?>">

                    <?php if($title OR $intro ):?>
                        <div class="xc-details">

                            <?php if($title):?>
                                <h4>
                                <?php if($params->get('title_link')):?>
                                    <a href="<?php echo $item->link; ?>" target="<?php echo $params->get('target');?>">
                                <?php endif;?>

                                    <?php echo $item->title; ?>
                                <?php if($params->get('title_link')):?>
                                    </a>
                                <?php endif;?>
                                </h4>
                            <?php endif;?>

                            <?php if($params->get('category')):?>
                                <p class="xc_category">
                                    <?php if( $params->get('category_link') ) :?>
                                        <a href="<?php echo $item->catlink; ?>" target="<?php echo $params->get('target');?>">
                                    <?php endif; ?>

                                        <?php echo JText::_('In: ')?>
                                        <?php echo $item->catname;?>

                                    <?php if( $params->get('category_link') ) :?>
                                        </a>
                                    <?php endif;?>
                                </p>
                            <?php endif;?>

                            <?php if($intro):?>
                                <div class="xc_intro">
                                    <?php echo $item->introtext;?>
                                </div>
                            <?php endif;?>

                            <?php if($params->get('readmore')):?>
                                <p class="xc_readmore">
                                    <a class="btn" href="<?php echo $item->link;?>" target="<?php echo $params->get('target');?>">
                                        <?php echo JText::_('Readmore');?>
                                    </a>
                                </p>
                            <?php endif;?>

                        </div>
                    <?php endif;?>

                </div>

                <div class="<?php echo ($params->get('effect_apply') == 'caption')?'xc-backdrop' : 'xc-overlay' ;?>">
                    <img src="<?php echo $item->image;?>" alt="<?php echo $item->title;?>" />
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <!--Xpert Captions by ThemeXpert- End-->
