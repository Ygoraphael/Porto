<?php
/**
* @version   $Id: index.php 9769 2013-04-26 17:40:14Z kevin $
 * @author RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );

$jquery = '';
jimport('joomla.version');
$version = new JVersion();
if(version_compare($version->getShortVersion(), '3.0', '>=')){
    JHtml::_('jquery.framework');
} else {
    JHTML::_('behavior.mootools');
    JFactory::getDocument()->addScript($this->baseurl.'/templates/'.$this->template.'/js/jq.min.js');
}
        
// load and inititialize gantry class
require_once(dirname(__FILE__) . '/lib/gantry/gantry.php');
$gantry->init();

// get the current preset
$gpreset = str_replace(' ','',strtolower($gantry->get('name')));
?>
<!doctype html>
<html xml:lang="<?php echo $gantry->language; ?>" lang="<?php echo $gantry->language;?>" >
<head>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<?php if ($gantry->get('layout-mode') == '960fixed') : ?>
	<meta name="viewport" content="width=960px">
	<?php elseif ($gantry->get('layout-mode') == '1200fixed') : ?>
	<meta name="viewport" content="width=1200px">
	<?php else : ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="HandheldFriendly" content="true" />
        <script type="text/javascript">
        if(navigator.appVersion.indexOf("MSIE 9.")!=-1){
            document.documentElement.className += " ie9";
        } else if(navigator.appVersion.indexOf("MSIE 8.")!=-1){
            document.documentElement.className += " ie8";
        } else if(navigator.appVersion.indexOf("MSIE 7.")!=-1){
            document.documentElement.className += " ie7";
        }
        </script>
	<?php endif; ?>
    <?php
        
        $gantry->displayHead();
        
        // Family weight H1,H2...
        
        // Family1 is for the titles
    
        $font_family = $gantry->get('font1-family1');
        
        if (strpos($font_family, ':')) {
                $explode = explode(':', $font_family);

                $delimiter = $explode[0];
                $name      = $explode[1];
                $variant   = isset($explode[2]) ? $explode[2] : null;
        } else {
                $delimiter = false;
                $name      = $font_family;
                $variant   = null;
        }

        if (isset($variant) && $variant) $variant = ':' . $variant;
        else if($gantry->get('font1-weight1')){ $variant = ':' . $gantry->get('font1-weight1'); }

        switch ($delimiter) {
                // google fonts
                case 'g':
                        $variant = $variant ? $variant : '';
                        $gantry->addStyle('//fonts.googleapis.com/css?family=' . str_replace(" ", "+", $name) . $variant);
                        break;
                default:
                        break;
        }
        
        $gantry->addInlineStyle("\nh1,h2,h3,h4,h5,h6,.title { font-family: '" . $name . "', 'Helvetica', arial, sans-serif; font-weight: " . $gantry->get('font1-weight1') . "; }\n");
        
        // Family1 Body End
       
        // Family2 is for the body
    
        $font_family = $gantry->get('font2-family2');
        
        if (strpos($font_family, ':')) {
                $explode = explode(':', $font_family);

                $delimiter = $explode[0];
                $name      = $explode[1];
                $variant   = isset($explode[2]) ? $explode[2] : null;
        } else {
                $delimiter = false;
                $name      = $font_family;
                $variant   = null;
        }

        if (isset($variant) && $variant) $variant = ':' . $variant;
        else if($gantry->get('font2-weight2')){ $variant = ':' . $gantry->get('font2-weight2'); }

        switch ($delimiter) {
                // google fonts
                case 'g':
                        $variant = $variant ? $variant : '';
                        $gantry->addStyle('//fonts.googleapis.com/css?family=' . str_replace(" ", "+", $name) . $variant);
                        break;
                default:
                        break;
        }
        
        $gantry->addInlineStyle("\nbody { font-family: '" . $name . "', 'Helvetica', arial, sans-serif; font-weight: " . $gantry->get('font2-weight2') . "; }\n");
        
        // Family2 Body End
        
        // Family3 is for the menu
    
        $font_family = $gantry->get('font3-family3');
        
        if (strpos($font_family, ':')) {
                $explode = explode(':', $font_family);

                $delimiter = $explode[0];
                $name      = $explode[1];
                $variant   = isset($explode[2]) ? $explode[2] : null;
        } else {
                $delimiter = false;
                $name      = $font_family;
                $variant   = null;
        }

        if (isset($variant) && $variant) $variant = ':' . $variant;
        else if($gantry->get('font3-weight3')){ $variant = ':' . $gantry->get('font3-weight3'); }
        
        switch ($delimiter) {
                // google fonts
                case 'g':
                        $variant = $variant ? $variant : '';
                        $gantry->addStyle('//fonts.googleapis.com/css?family=' . str_replace(" ", "+", $name) . $variant);
                        break;
                default:
                        break;
        }
        
        $gantry->addInlineStyle("\n.gf-menu, .gf-menu .item, .breadcrumb { font-family: '" . $name . "', 'Helvetica', arial, sans-serif; font-weight: " . $gantry->get('font3-weight3') . ";}\n");
        
        // Family3 Menu End
        
        $gantry->addStyle('grid-responsive.css', 5);
        $gantry->addLess('bootstrap.less', 'bootstrap.css', 6);

        if ($gantry->browser->name == 'ie') {
            if ($gantry->browser->shortversion == 9) {
                $gantry->addInlineScript("if (typeof RokMediaQueries !== 'undefined') window.addEvent('domready', function(){ RokMediaQueries._fireEvent(RokMediaQueries.getQuery()); });");
            }
            if ($gantry->browser->shortversion == 8) {
                $gantry->addScript('html5shim.js');
            }
        }
        if ($gantry->get('layout-mode', 'responsive') == 'responsive')
            $gantry->addScript('rokmediaqueries.js');
        if ($gantry->get('loadtransition')) {
            $gantry->addScript('load-transition.js');
            $hidden = ' class="rt-hidden"';
        }

        // bavkground-slider
        if($gantry->get('backgroundslider') && $gantry->countModules('showcase')){
            jimport('joomla.filesystem.file');
            jimport('joomla.filesystem.folder');
            $folder = JPATH_SITE . '/templates/'.$gantry->getCurrentTemplate().'/images/slider/';
            $app = JFactory::getApplication();
            $menu = $app->getMenu();
            $custom_folder = JPATH_SITE.'/media/'.$gantry->getCurrentTemplate().'/slider/'.intval($menu->getActive()->id).'/';
            
            if(JFolder::exists($custom_folder)){
                $folder = $custom_folder;
            }
            if (@file_exists($folder) && @is_readable($folder) && @is_dir($folder) && $handle = @opendir($folder)) {
                $gantry->addInlineScript('
                    var slider_stack = [];
                ');
                while (false !== ($file = @readdir($handle))) {
                    if ($file != "." && $file != "..") {
                        switch(strtolower(JFile::getExt($folder.$file))){
                            case 'jpg':
                            case 'jpeg':
                            case 'png':
                                $img = @getimagesize($folder.$file);
                                if($img){
                                    $height = $img[1];
                                    
                                    $gantry->addInlineScript('
                                        slider_stack.push({url:"'.$gantry->baseUrl.str_replace(JPATH_SITE.'/','',$folder).$file.'",width:"'.$img[0].'",height:"'.$height.'",active:false});
                                    ');
                                }
                                break;
                        }
                    }
                }
                @closedir($handle);
                $gantry->addInlineScript('
                    var pimages = new Array(slider_stack.length);
                    for (i = 0; i < slider_stack.length; i++) {
                        pimages[i] = new Image();
                        pimages[i].src = slider_stack[i].url;
                    }
                    jQuery(document).ready(
                        function(){
                            if(typeof slider_stack[0] !== "undefined" && slider_stack[0]){
                                jQuery("#ct-showcase-slider").fadeOut(0);
                                jQuery("#ct-showcase-slider").css("background-image","url("+slider_stack[0].url+")");
                                jQuery("#ct-showcase-slider").css("min-height",slider_stack[0].height+"px");
                                jQuery("#rt-showcase").css("min-height",slider_stack[0].height+"px");
                                jQuery("#ct-showcase-slider").fadeIn('.intval($gantry->get('sliderfadetime')).');
                            }
                            var slider_stack_iterator = 1;
                            setInterval(function(){
                                if(slider_stack_iterator+1 > slider_stack.length){
                                    slider_stack_iterator = 0;
                                }
                                jQuery("#ct-showcase-slider").fadeOut(0);
                                jQuery("#ct-showcase-slider").css("background-image","url("+slider_stack[slider_stack_iterator].url+")");
                                jQuery("#ct-showcase-slider").css("min-height",slider_stack[slider_stack_iterator].height+"px");
                                jQuery("#rt-showcase").css("min-height",slider_stack[slider_stack_iterator].height+"px");
                                jQuery("#ct-showcase-slider").fadeIn('.intval($gantry->get('sliderfadetime')).');
                                slider_stack_iterator++;
                            },'.intval($gantry->get('slidertime')).');
                        }
                    );
                ');
            }
        }
    ?>
        <script type="text/javascript">
        <!--
            // windows phone IE10 snap mode fix
            (function() {
                    if ("-ms-user-select" in document.documentElement.style && ( navigator.userAgent.match(/IEMobile\/10\.0/) || navigator.userAgent.match(/IEMobile\/11\.0/) ) ) {
                            var msViewportStyle = document.createElement("style");
                            msViewportStyle.appendChild(
                                    document.createTextNode("@-ms-viewport{width:auto!important}")
                            );
                            document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
                    }
            })();
        //-->
        </script>
        
        <script type="text/javascript">
        <!--
        jQuery(document).ready(function(){
            setTimeout(function(){
                    ct_set_center();
                    if(jQuery('#rt-showcase').size() !== 0){
                        jQuery('#rt-mainbody-surround').css('margin-top','0');
                        jQuery('#rt-mainbody-surround').css('padding-top','0');
                    }
                    if(jQuery('.gf-menu-device-wrapper-sidemenu').size() === 0){

                        jQuery('.gf-menu-toggle').addClass('ct-toggle-disabled');
                        jQuery('#ct-menu').prepend(jQuery('.responsive-type-selectbox'));
                        
                    }
                    jQuery('#ct-menu').prepend(
                        jQuery('#rt-logo-img').clone().attr('id','rt-logo-img-responsive')
                    );
                    jQuery('#rt-logo-img-responsive').css("cursor","pointer");
                    jQuery('#rt-logo-img-responsive').click(
                            function(){
                                location.href = jQuery('#rt-logo').attr('href');
                            }
                    );
                }
                
            ,1);
            <?php
            if(!$gantry->get('fixedheader')){
            ?>
            jQuery('#ct-menu-surround').css('position','absolute');
            <?php
            } else {
                $gantry->addInlineStyle('
                    #ct-menu-surround  #rt-logo {
                        display: none;
                    }

                    #ct-menu-surround  #rt-logo-small {
                        display: none;
                    }
                ');
            }
            if($gantry->get('centeredmenu')){
            ?>
            // default state not displayed
            jQuery('#rt-logo').css('display','none');
            jQuery('#rt-logo-small').css('display','none');
            
            // add some effects to the logos
            jQuery('#ct-menu-surround').addClass('ct-centered-menu');
            
            jQuery('#rt-logo').addClass('animated').addClass('flipInY');
            jQuery('#rt-logo-small').addClass('animated').addClass('pulse');
            
            // adjust centered logo width and center
            <?php
            if($gantry->get('centeredlogoinsidemenu')){
            ?>
            jQuery('#ct-menu-surround .gf-menu').css('padding-left','<?php echo intval($gantry->get('centeredlogoinsidemenupleft'))?>px');
            jQuery('#ct-menu-surround .gf-menu').css('padding-right','<?php echo intval($gantry->get('centeredlogoinsidemenupright'))?>px');
            jQuery('#ct-menu-surround #rt-logo-img').css('margin-top','<?php echo intval($gantry->get('centeredlogoinsidemenutopdistancelarge'))?>px');
            jQuery('#rt-logo-small-img').css('margin-top','<?php echo intval($gantry->get('centeredlogoinsidemenutopdistancesmall'))?>px');
            
            var menuRootLevelSize = jQuery('#ct-menu-surround .gf-menu.l1 > li').size();
            jQuery('#ct-menu-surround .gf-menu.l1 > li').each(
                function(i){
                    if((menuRootLevelSize/2)-1 <= i){
                        jQuery('#ct-logo-block').remove();
                        jQuery(this).after('<li id="ct-logo-block"></li>');
                        jQuery('#rt-logo').appendTo('#ct-logo-block');
                        jQuery('#rt-logo-small').appendTo('#ct-logo-block');
                        jQuery('#rt-logo').css('display','block');
                        jQuery('#rt-logo-small').css('display','none');
                        jQuery('#ct-menu-surround .logo-block').css('display','none');
                        if(typeof jQuery('#rt-logo').get(0) === "undefined"){
                            jQuery('#ct-logo-block').css('display','none');
                        }
                        return false;
                    }
                }
            );      
            <?php
            }else{
            ?>
            jQuery('#ct-logo-block').css('padding-right','13px');
            jQuery('#rt-logo').appendTo('#ct-logo-block');
            jQuery('#rt-logo-small').appendTo('#ct-logo-block');
            jQuery('#rt-logo').css('display','block');
            jQuery('#rt-logo-small').css('display','none');
            jQuery('#ct-menu-surround .logo-block').css('display','none');
            if(typeof jQuery('#rt-logo').get(0) === "undefined"){
                jQuery('#ct-logo-block').css('display','none');
            }
            <?php
            }
            ?>
                    
            // manage centered logo disappear on scrolling
            function ct_set_center(){
                <?php
                $is_front = 'true';
                $app = JFactory::getApplication();
                $menu = $app->getMenu();
                if ($menu->getActive() == $menu->getDefault(JFactory::getLanguage()->getTag())) {
                        $is_front = 'false';
                }
                ?>
                if(jQuery(this).scrollTop() > 1 || <?php echo $is_front;?>){
                        jQuery('#rt-logo').css('display','none');
                        <?php
                        if($gantry->get('centeredlogoinsidemenu')){
                        ?>
                        jQuery('#rt-logo-small').css('display','block');
                        <?php
                        }
                        ?>
                        if(typeof jQuery('#rt-logo-small').get(0) === "undefined"){
                            jQuery('#ct-logo-block').css('display','none');
                        }
                        jQuery('#ct-logo-block').addClass('ct-logo-block-small');
                } else if(jQuery(this).scrollTop() <= 1){
                        jQuery('#rt-logo').css('display','block');
                        jQuery('#rt-logo-small').css('display','none');
                        jQuery('#ct-logo-block').css('display','block');
                        jQuery('#ct-logo-block').removeClass('ct-logo-block-small');
                }
                jQuery('#ct-menu-surround .gf-menu').sport_menu_center();
            }
            
            var is_iOS = navigator.userAgent.match(/iPhone/i) != null || navigator.userAgent.match(/iPod/i) != null || navigator.userAgent.match(/iPad/i) != null;
            if(is_iOS){
                jQuery(window).bind('touchmove',ct_set_center);
                jQuery(window).bind('touchend',ct_set_center);
            }else{
                jQuery(window).scroll(ct_set_center);
            }
            
            // keep the entire menu centered
            jQuery.fn.sport_menu_center = function ()
            {
                var newWidth = 0;
                jQuery('#ct-menu-surround .gf-menu.l1 > li').each(
                        function(){
                            newWidth += jQuery(this).width();
                        }
                );
                if(newWidth > 0){
                    jQuery('#ct-menu-surround .gf-menu').width(newWidth);
                }
                return this;
            };
            
            jQuery('#ct-menu-surround .gf-menu').sport_menu_center();
            jQuery(window).resize(function(){
                jQuery('#ct-menu-surround .gf-menu').sport_menu_center();
            });
            <?php
            }
            ?>
            
            // enable the menu if everything is setup
            jQuery('#ct-menu').css("display","block");
            
            // find closest rt-container and prepend the modules with class suffix ct-first
            jQuery('.ct-first-showcase').closest('.rt-container').prepend(jQuery('.ct-first-showcase'));
            jQuery('.ct-first-feature').closest('.rt-container').prepend(jQuery('.ct-first-feature'));
            jQuery('.ct-first-bottom').closest('.rt-container').prepend(jQuery('.ct-first-bottom'));
            <?php
            if($gantry->get('totupbutton')){
            ?>
            jQuery('body').append('<div id="toTop"><li class="icon-chevron-up"></li></div>');
            jQuery(window).scroll(function () {
                    if (jQuery(this).scrollTop() != 0) {
                            jQuery('#toTop').fadeIn();
                    } else {
                            jQuery('#toTop').fadeOut();
                    }
            });
            window.addEvent("domready",function(){var b=document.id("toTop");if(b){var a=new Fx.Scroll(window);b.setStyle("outline","none").addEvent("click",function(c){c.stop(); a.toTop();});}});
            <?php
            }
            ?>
        });
        //-->
        </script>
</head>
<body <?php echo $gantry->displayBodyTag(); ?>>
    
    
    <?php /** Begin MENU **/ if ($gantry->countModules('menu')) : ?>
    <div id="ct-menu-surround">
        <div id="ct-menu">
            <div class="rt-container">
                    <?php echo $gantry->displayModules('menu','standard','standard'); ?>
                    <div class="clear"></div>
            </div>
        </div>
        <div id="ct-logo-block"></div>
    </div>
    
   <?php /** End Menu **/ endif; ?>
    
    <?php /** Begin Top Surround **/ if ($gantry->countModules('top') or $gantry->countModules('header')) : ?>
    <header id="rt-top-surround">
		<?php /** Begin Top **/ if ($gantry->countModules('top')) : ?>
		<div id="rt-top" <?php echo $gantry->displayClassesByTag('rt-top'); ?>>
			<div class="rt-container">
				<?php echo $gantry->displayModules('top','standard','standard'); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php /** End Top **/ endif; ?>
		<?php /** Begin Header **/ if ($gantry->countModules('header')) : ?>
		<div id="rt-header">
			<div class="rt-container">
				<?php echo $gantry->displayModules('header','standard','standard'); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php /** End Header **/ endif; ?>
    </header>
    <?php /** End Top Surround **/ endif; ?>
    
    
    
    
	<?php /** Begin Showcase **/ if ($gantry->countModules('showcase')) : ?>
        <div id="ct-showcase-slider-wrap">
            <div id="ct-showcase-slider">
            </div>
        </div>
	<div id="rt-showcase">
		<div class="rt-showcase-pattern">
			<div class="rt-container">
				<?php echo $gantry->displayModules('showcase','standard','standard'); ?>
				<div class="clear"></div>
			</div>
		</div>
	</div>
    
        <?php /** End Showcase **/ endif; ?>
        <div id="ct-showcase-divider"></div>
	<div id="rt-transition"<?php if ($gantry->get('loadtransition')) echo $hidden; ?>>
                <div id="rt-mainbody-surround">
                        <?php /** Begin Drawer **/ if ($gantry->countModules('drawer')) : ?>
                        <div id="rt-drawer">
                            <div class="rt-container">
                                <?php echo $gantry->displayModules('drawer','standard','standard'); ?>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <?php /** End Drawer **/ endif; ?>
			<?php /** Begin Feature **/ if ($gantry->countModules('feature')) : ?>
			<div id="rt-feature">
				<div class="rt-container">
					<?php echo $gantry->displayModules('feature','standard','standard'); ?>
					<div class="clear"></div>
				</div>
                                <div id="ct-feature-divider"></div>
			</div>
                        
			<?php /** End Feature **/ endif; ?>
			<?php /** Begin Utility **/ if ($gantry->countModules('utility')) : ?>
			<div id="rt-utility">
				<div class="rt-container">
					<?php echo $gantry->displayModules('utility','standard','standard'); ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php /** End Utility **/ endif; ?>
			<?php /** Begin Breadcrumbs **/ if ($gantry->countModules('breadcrumb')) : ?>
			<div id="rt-breadcrumbs">
				<div class="rt-container">
					<?php echo $gantry->displayModules('breadcrumb','standard','standard'); ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php /** End Breadcrumbs **/ endif; ?>
			<?php /** Begin Main Top **/ if ($gantry->countModules('maintop')) : ?>
			<div id="rt-maintop">
				<div class="rt-container">
					<?php echo $gantry->displayModules('maintop','standard','standard'); ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php /** End Main Top **/ endif; ?>
			<?php /** Begin Full Width**/ if ($gantry->countModules('fullwidth')) : ?>
			<div id="rt-fullwidth">
				<?php echo $gantry->displayModules('fullwidth','basic','basic'); ?>
					<div class="clear"></div>
				</div>
			<?php /** End Full Width **/ endif; ?>
			<?php /** Begin Main Body **/ ?>
			<div class="rt-container">
		    		<?php echo $gantry->displayMainbody('mainbody','sidebar','standard','standard','standard','standard','standard'); ?>
		    	</div>
			<?php /** End Main Body **/ ?>
			<?php /** Begin Main Bottom **/ if ($gantry->countModules('mainbottom')) : ?>
			<div id="rt-mainbottom">
				<div class="rt-container">
					<?php echo $gantry->displayModules('mainbottom','standard','standard'); ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php /** End Main Bottom **/ endif; ?>
			<?php /** Begin Extension **/ if ($gantry->countModules('extension')) : ?>
			<div id="rt-extension">
				<div class="rt-container">
					<?php echo $gantry->displayModules('extension','standard','standard'); ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php /** End Extension **/ endif; ?>
		</div>
	</div>
	<?php /** Begin Bottom **/ if ($gantry->countModules('bottom')) : ?>
	<div id="rt-bottom">
		<div class="rt-container">
			<?php echo $gantry->displayModules('bottom','standard','standard'); ?>
			<div class="clear"></div>
		</div>
	</div>
        <div id="ct-bottom-divider"></div>
	<?php /** End Bottom **/ endif; ?>
	<?php /** Begin Footer Section **/ if ($gantry->countModules('footer') or $gantry->countModules('copyright')) : ?>
	<footer id="rt-footer-surround">
		<?php /** Begin Footer **/ if ($gantry->countModules('footer')) : ?>
		<div id="rt-footer">
			<div class="rt-container">
				<?php echo $gantry->displayModules('footer','standard','standard'); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php /** End Footer **/ endif; ?>
		<?php /** Begin Copyright **/ if ($gantry->countModules('copyright')) : ?>
		<div id="rt-copyright">
			<div class="rt-container">
				<?php //echo $gantry->displayModules('copyright','standard','standard'); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php /** End Copyright **/ endif; ?>
	</footer>
	<?php /** End Footer Surround **/ endif; ?>
	<?php /** Begin Debug **/ if ($gantry->countModules('debug')) : ?>
	<div id="rt-debug">
		<div class="rt-container">
			<?php echo $gantry->displayModules('debug','standard','standard'); ?>
			<div class="clear"></div>
		</div>
	</div>
	<?php /** End Debug **/ endif; ?>
	<?php /** Begin Analytics **/ if ($gantry->countModules('analytics')) : ?>
	<?php echo $gantry->displayModules('analytics','basic','basic'); ?>
	<?php /** End Analytics **/ endif; ?>
	</body>
</html>
<?php
$gantry->finalize();
?>
