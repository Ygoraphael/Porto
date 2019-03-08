<?php
/* --------------------------------------------------------------
  # Copyright (C) joomla-monster.com
  # License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  # Website: http://www.joomla-monster.com
  # Support: info@joomla-monster.com
  --------------------------------------------------------------- */

defined('_JEXEC') or die;

//get logo and site description
$logo = htmlspecialchars($this->params->get('logo'));
$logotext = htmlspecialchars($this->params->get('logoText'));
$sitedescription = htmlspecialchars($this->params->get('siteDescription'));
$app = JFactory::getApplication();
$sitename = $app->getCfg('sitename');
?>

<?php if ($this->checkModules('top-bar') or $this->checkModules('top-menu-nav') or ( $logo != '') or ( $logotext != '') or ( $sitedescription != '')) : ?>
    <div id="jm-bar-wrapp" class="<?php echo $this->getClass('block#bar') ?>">
        <?php if ($this->checkModules('top-bar')) : ?>
            <section id="jm-top-bar" class="<?php echo $this->getClass('top-bar') ?>">
                <div id="jm-top-bar-in" class="container-fluid">
                    <jdoc:include type="modules" name="<?php echo $this->getPosition('top-bar'); ?>" style="jmmoduleraw"/>  
                </div>
            </section>
        <?php endif; ?> 

        <?php if ($this->checkModules('top-menu-nav') or ( $logo != '') or ( $logotext != '') or ( $sitedescription != '')) : ?>
            <section id="jm-bar">  
                <div id="jm-bar-in" class="container-fluid">
                    <?php if (($logo != '') or ( $logotext != '') or ( $sitedescription != '')) : ?>
                        <div id="jm-bar-left" class="pull-left clearfix" style="padding-top:5px">
                            <div id="jm-logo-sitedesc">
                                <?php if (($logo != '') or ( $logotext != '')) : ?>
                                    <div id="jm-logo">
                                        <a href="<?php echo JURI::base(); ?>" >
                                            <?php if ($logo != '') : ?>
                                                <img src="<?php echo JURI::base(), $logo; ?>" alt="<?php
                                                if (!$logotext) {
                                                    echo $sitename;
                                                } else {
                                                    echo $logotext;
                                                };
                                                ?>" />
                                                 <?php else : ?>
                                                     <?php echo '<span>' . $logotext . '</span>'; ?>
                                                 <?php endif; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if ($sitedescription != '') : ?>
                                    <div id="jm-sitedesc">
                                        <?php echo $sitedescription; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $jinput = JFactory::getApplication()->input;
                    $fileid = trim($jinput->get('fileid')) == "" ? "0" : $jinput->get('fileid');

                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    $query->select($db->quoteName(array('path')));
                    $query->from($db->quoteName('#__jumi'));
                    $query->where($db->quoteName('id') . ' = ' . $fileid);
                    $db->setQuery($query);
                    $results = $db->loadObjectList();

                    $mobilemenucurso = 0;

                    if (sizeof($results) && strtolower($jinput->get('option')) === "com_jumi" && strtolower($jinput->get('view')) === "application" && $results[0]->path == "/site/pagcursogeral.php") {
                        $mobilemenucurso = 1;
                    }

                    if ($mobilemenucurso) :
                        ?>
                        <nav class="navbar navbar-default hidden-xs hidden-sm" role="navigation" style="margin:0;" >
                            <div class="nopadding">
                                <div class="navbar-collapse">
                                    <ul class="nav navbar-nav pagcursonav" style="margin:25px 0px 0 5px;">
                                        <li class="h1"><a data-href="#apresentacao-curso" data-mob="0">Apresentação do Curso</a></li>
                                        <li class="h2"><a data-href="#precos-descontos" data-mob="0">Preços e Condições de Inscrição</a></li>
                                        <li class="h1"><a data-href="#cronograma" data-mob="0">Cronograma e Inscrições</a></li>
                                        <li class="h2"><a data-href="#exames-online" data-mob="0">Exames Online</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    <?php endif; ?>

                    <?php if ($this->checkModules('top-menu-nav')) : ?>
                        <div id="jm-bar-right" class="pull-right <?php echo $this->getClass('top-menu-nav') ?>">
                            <div id="jm-djmenu" class="clearfix">
                                <jdoc:include type="modules" name="<?php echo $this->getPosition('top-menu-nav'); ?>" style="jmmoduleraw"/>
                            </div>
                        </div> 
                    <?php endif; ?> 

                    <div class="clearfix"></div>

                    <?php
                    if ($mobilemenucurso) :
                        ?>
                        <nav class="navbar navbar-default hidden-md hidden-lg" role="navigation">
                            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
                        </nav>
                    <?php endif; ?>

                </div>
            </section>
        <?php endif; ?>
    </div>
<?php endif; ?>