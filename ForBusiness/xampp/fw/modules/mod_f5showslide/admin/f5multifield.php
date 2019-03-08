<?php
/**
 * @copyright	Copyright (C) 2014 TemplateF5. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
jimport('joomla.form.formfield');
$doc = JFactory::getDocument();
//JHTML :: _ ('jquery.framework');
$doc->addScript(JURI::root(true) ."/customJS/jquery.js");
//JHtml::_('jquery.ui');
$doc->addScript(JURI::root(true) ."/modules/mod_f5showslide/admin/jquery-ui.js");
$doc->addScript(JURI::root(true) ."/modules/mod_f5showslide/admin/f5multifield.js");
$script = array();
    		$script[] = '	function jInsertFieldValue(value,id) {';
    		$script[] = '		var old_id = document.getElementById(id).value;';
    		$script[] = '		if (old_id != id) {';
    		$script[] = '			document.getElementById(id).value = value;';
    		$script[] = '		}';
    		$script[] = '	}';
    		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
			JHtml::_('script', 'jui/jquery.minicolors.min.js', false, true);
		JHtml::_('stylesheet', 'jui/jquery.minicolors.css', false, true);
		JFactory::getDocument()->addScriptDeclaration("
				jQuery(document).ready(function (){
					jQuery('.f5Slide .minicolors').each(function() {
						jQuery(this).minicolors({
							control: jQuery(this).attr('data-control') || 'hue',
							position: jQuery(this).attr('data-position') || 'right',
							theme: 'bootstrap'
						});
					});
				});
			"
		);
?>
<?php
class JFormFieldF5multifield extends JFormField {
	protected $type = 'F5multifield';
	public function getInput() {
		JHTML::_('behavior.modal');
	$f5slideheader = '<div class="f5SlideHeaderBtn"> <div class="f5FieldDivNameSlide"></div><div class="f5RemoveSlideBtn"><a href="#removeSlide" class="btn btn-primary">'.JText::_('MOD_F5SHOWSLIDE_XML_F5DELETESLIDE_LABEL').'</a></div><div class="f5UpSlideBtn"><a href="#upSlide" class="btn btn-primary">'.JText::_('MOD_F5SHOWSLIDE_XML_F5UPSLIDE_LABEL').'</a></div><div class="f5DownSlideBtn"><a href="#downSlide" class="btn btn-primary">'.JText::_('MOD_F5SHOWSLIDE_XML_F5DOWNSLIDE_LABEL').'</a></div><div class="f5AddElementBtn"><a href="#addfield" class="btn btn-primary">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CREATEELEMENT_LABEL').'</a></div></div>';
	$f5elementheader = '<div class="f5RemoveElementBtn"><a href="#removeElement" class="btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5DELETEELEMENT_LABEL').'</a></div><div class="f5UpElementBtn"><a href="#upElement" class="btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5UPELEMENT_LABEL').'</a></div><div class="f5DownElementBtn"><a href="#downElement" class="btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5DOWNELEMENT_LABEL').'</a></div>';
	$f5elementtype = '<div class="f5DivElementTypeHeader"> <label for="f5FieldSlideName">'.JText::_('MOD_F5SHOWSLIDE_XML_F5NAMESLIDE_LABEL').'</label> <input type="text" name="f5FieldSlideName" class="f5FieldSlideName"><div class="f5ElementCancelBtn"><a href="#cancel" class="btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CANCEL_LABEL').'</a></div><div class="f5SlideCancelBtn"><a href="#cancel" class="btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CANCEL_LABEL').'</a></div><br><label for="f5FieldName">'.JText::_('MOD_F5SHOWSLIDE_XML_F5NAMEELEMENT_LABEL').'</label> <input type="text" name="f5FieldName" class="f5FieldName"> <label for="f5FieldSelectType">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TIPEELEMENT_LABEL').'</label> <select name="f5FieldSelectType"class="f5FieldSelectType" id="f5FieldSelectType"><option value="">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTELEMENT_LABEL').'</option> <option value="1">'.JText::_('MOD_F5SHOWSLIDE_XML_F5BACKGROUND_LABEL').'</option> <option value="2">'.JText::_('MOD_F5SHOWSLIDE_XML_F5IMG_LABEL').'</option><option value="3" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TEXT_LABEL').'</option><option value="4">'.JText::_('MOD_F5SHOWSLIDE_XML_F5VIDEO_LABEL').'</option><option value="5">'.JText::_('MOD_F5SHOWSLIDE_XML_F5HTML_LABEL').'</option> </select><br><label for="f5FieldTransTimeSlide">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TRANSTIMESLIDE_LABEL').'</label> <input type="number" name="jform[params][f5FieldTransTimeSlide]" id="jform_params_f5FieldTransTimeSlide" value="" max="1000000" step="10" min="0" class="f5FieldTransTimeSlide"><br><label for="f5FieldOnceSlideTransType">'.JText::_('MOD_F5SHOWSLIDE_XML_F5ONCESLIDETRANTYPE_LABEL').'</label> <select name = "f5FieldOnceSlideTransType" class="f5FieldOnceSlideTransType"> <option value="">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTTRANSITIONELEMENT_LABEL').'<option value="fade">Fade</option><option value="slideleft">Slideleft</option><option value="slideright">Slideright</option><option value="slideup">Slideup</option><option value="slidedown">Slidedown</option><option value="dropleft">Dropleft</option><option value="dropright">Dropright</option><option value="dropup">Dropup</option><option value="dropdown">Dropdown</option><option value="puff">Puff</option><option value="pulsate">Pulsate</option><option value="shakeleft">Shakehorizontal</option><option value="shakeup">Shakevertical</option><option value="bounceleft">Bounceleft</option><option value="bounceright">Bounceright</option><option value="bounceup">Bounceup</option><option value="bouncedown">Bouncedown</option> <option value="explode6">Explode 4</option><option value="explode12">Explode 9</option><option value="explode24">Explode 25</option><option value="explode48">Explode 49</option><option value="blindup">BlindUp</option><option value="blinddown">BlindDown</option><option value="blindleft">BlindLeft</option><option value="blindright">BlindRight</option><option value="fold">Fold</option><option value="rotatez">RotateZ '.JText::_('MOD_F5SHOWSLIDE_XML_F5RIGHT_LABEL').'</option><option value="rotatezl">RotateZ '.JText::_('MOD_F5SHOWSLIDE_XML_F5LEFT_LABEL').'</option><option value="rotatey">RotateY '.JText::_('MOD_F5SHOWSLIDE_XML_F5RIGHT_LABEL').'</option><option value="rotateyl">RotateY '.JText::_('MOD_F5SHOWSLIDE_XML_F5LEFT_LABEL').'</option><option value="rotatex">RotateX '.JText::_('MOD_F5SHOWSLIDE_XML_F5BUTTOM_LABEL').'</option><option value="rotatexl">RotateX '.JText::_('MOD_F5SHOWSLIDE_XML_F5TOP_LABEL').'</option></select><label for="f5FieldOnceSlideTransTime">'.JText::_('MOD_F5SHOWSLIDE_XML_F5ONCESLIDETRANTIME_LABEL').'</label> <select name = "f5FieldOnceSlideTransTime" class="f5FieldOnceSlideTransTime"> <option value="">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTTRANSITIONTIMEELEMENT_LABEL').'<option value="100">100 milliseconds</option><option value="200">200 milliseconds</option><option value="300">300 milliseconds</option><option value="500">500 milliseconds</option><option value="750">750 milliseconds</option><option value="1000">1000 milliseconds</option><option value="2000">2000 milliseconds</option><option value="3000">3000 milliseconds</option><option value="4000">4000 milliseconds</option><option value="5000">5000 milliseconds</option><option value="6000">6000 milliseconds</option><option value="7000">7000 milliseconds</option><option value="8000">8000 milliseconds</option><option value="9000">9000 milliseconds</option><option value="10000">10000 milliseconds</option></select></div>';
	$f5backgroundtype = '<div class="f5FieldDivBackgr"> <label for="f5FieldBackgrColor">'.JText::_('MOD_F5SHOWSLIDE_XML_F5BACKGROUND_LABEL').'</label> <input class="f5FieldBackgrColor" type="text" name="f5FieldBackgrColor" size="7" maxlength="7" aria-invalid="false"> <br/> <label for="f5FieldWidthBackgr" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5WIDTHELEMENT_LABEL').'</label> <input type="number" name="jform[params][f5FieldWidthBackgr]" id="jform_params_f5FieldWidthBackgr" value="50" max="100" step="1" min="0" class="f5FieldWidthBackgr f5FieldComun"> <label for="f5FieldHeightBackgr" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5HEIGHTELEMENT_LABEL').'</label> <input type="number" name="jform[params][f5FieldHeightBackgr]" id="jform_params_f5FieldHeightBackgr" value="50" max="100" step="1" min="0" class="f5FieldHeightBackgr f5FieldComun"> <br/><label for="f5FieldOpacityBackgr">'.JText::_('MOD_F5SHOWSLIDE_XML_F5OPACITY_LABEL').'</label><select name="f5FieldOpacityBackgr" class="f5FieldOpacityBackgr" ><option value="1">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITYDEFAULT_LABEL').'</option><option value="0.1">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY1_LABEL').'</option><option value="0.2">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY2_LABEL').'</option><option value="0.3">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY3_LABEL').'</option><option value="0.4">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY4_LABEL').'</option><option value="0.5">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY5_LABEL').'</option><option value="0.6">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY6_LABEL').'</option><option value="0.7">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY7_LABEL').'</option><option value="0.8">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY8_LABEL').'</option><option value="0.9">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY9_LABEL').'</option><option value="1">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY10_LABEL').'</option></select><br/> <label for="f5FieldUrlBackgr">'.JText::_('MOD_F5SHOWSLIDE_XML_URLELEMENT_LABEL').'</label> <input type="text" name="f5FieldUrlBackgr" class="f5FieldUrlBackgr"> <br/> </div>';
	$f5imagetype = '<div class="f5FieldDivImg"> <label for="f5FieldImage">'.JText::_('MOD_F5SHOWSLIDE_XML_F5IMAGE_LABEL').'</label> <input type="text" name="F5ImgType" id="f5FieldImage" value="" class="f5FieldImg"/><a class="modal btn f5FieldImg" rel="{handler: \'iframe\', size:{x: 800, y: 500}}" href="index.php?option=com_media&view=images&tmpl=component&asset=com_modules&author=&fieldid=f5FieldImage&folder=stories" title="Select"> Select</a><a title="Clear" class="btn f5FieldImg" href="#" onclick="javascript:document.getElementById("f5FieldImage").value="";return false;">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CLEAR_LABEL').'</a> <br/> <label for="f5FieldWidthImg" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5WIDTHIMGELEMENT_LABEL').'</label> <input type="number" name="jform[params][f5FieldWidthImg]" id="jform_params_f5FieldWidthImg" value="50" max="100" step="1" min="0" class="f5FieldWidthImg f5FieldComun"><br/> <label for="f5FieldOpacityImg">'.JText::_('MOD_F5SHOWSLIDE_XML_F5OPACITY_LABEL').'</label><select name="f5FieldOpacityImg" class="f5FieldOpacityImg" ><option value="1">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITYDEFAULT_LABEL').'</option><option value="0.1">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY1_LABEL').'</option>
<option value="0.2">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY2_LABEL').'</option><option value="0.3">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY3_LABEL').'</option><option value="0.4">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY4_LABEL').'</option><option value="0.5">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY5_LABEL').'</option><option value="0.6">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY6_LABEL').'</option><option value="0.7">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY7_LABEL').'</option><option value="0.8">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY8_LABEL').'</option><option value="0.9">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY9_LABEL').'</option><option value="1">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY10_LABEL').'</option></select><br/> <label for="f5FieldUrlImg">'.JText::_('MOD_F5SHOWSLIDE_XML_URLELEMENT_LABEL').'</label> <input type="text" name="f5FieldUrlImg" class="f5FieldUrlImg"> <br/> </div>';
	$f5texttype = '<div class="f5FieldDivText"> <label for="f5FieldText">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TEXT_LABEL').'</label> <textarea rows="4" cols="50" name="f5FieldText" class="f5FieldText"></textarea><br/><label for="f5FieldSelectTypeFont">'.JText::_('MOD_F5SHOWSLIDE_XML_FONTDEFAULT_LABEL').'</label> <select name ="f5FieldSelectTypeFont"class="f5FieldSelectTypeFont" ><option value="">'.JText::_('MOD_F5SHOWSLIDE_XML_FONTDEFAULT_SELECT').'</option> <option value="Verdana, Geneva, sans-serif">Verdana, Geneva, sans-serif</option> <option value="Georgia, Times, serif">Georgia, Times, serif</option><option value="Courier, monospace" >Courier, monospace</option><option value="Arial, Helvetica, sans-serif" >Arial, Helvetica, sans-serif</option><option value="Tahoma, Geneva, sans-serif" >Tahoma, Geneva, sans-serif</option><option value="Palatino, serif" >Palatino, serif</option><option value="calibri, candara, segoe, optima, arial, sans-serif" >Calibri</option></select><label for="f5FieldGoogleTypeFont" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_FONTGOOGLE_LABEL').'</label> <input type="text" name="f5FieldGoogleTypeFont" class="f5FieldGoogleTypeFont f5FieldComun" value=""><br/><label for="f5FieldSizeText">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SIZETEXT_LABEL').'</label> <input type="number" name="jform[params][f5FieldSizeText]" id="jform_params_f5FieldSizeText" value="14" max="1000" step="1" min="0" class="f5FieldSizeText"><br/> <label for="f5FieldWidthText" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5WIDTHELEMENT_LABEL').'</label> <input type="number" name="jform[params][f5FieldWidthText]" id="jform_params_f5FieldWidthText" value="50" max="100" step="1" min="0" class="f5FieldWidthText f5FieldComun"> <label for="f5FieldHeightText" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5HEIGHTELEMENT_LABEL').'</label> <input type="number" name="jform[params][f5FieldHeightText]" id="jform_params_f5FieldHeightText" value="50" max="100" step="1" min="0" class="f5FieldHeightText f5FieldComun"><br/><label for="f5FieldAlignText">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTALIGN_LABEL').'</label> <select name ="f5FieldAlignText"class="f5FieldAlignText" ><option value="justify">'.JText::_('MOD_F5SHOWSLIDE_XML_F5ALIGNTEXT_LABEL').'</option> <option value="justify">'.JText::_('MOD_F5SHOWSLIDE_XML_JUSTIFITYTEXT_LABEL').'</option> <option value="left">'.JText::_('MOD_F5SHOWSLIDE_XML_LEFTTEXT_LABEL').'</option><option value="right" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_RIGHTTEXT_LABEL').'</option><option value="center" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_CENTERTEXT_LABEL').'</option></select><br/> <label for="f5FieldColorText">'.JText::_('MOD_F5SHOWSLIDE_XML_F5COLORTEXT_LABEL').'</label> <input class="f5FieldColorText" type="text" name="f5FieldColorText" size="7" maxlength="7" aria-invalid="false"><br/><label for="f5FieldOpacityText">'.JText::_('MOD_F5SHOWSLIDE_XML_F5OPACITY_LABEL').'</label><select name = "f5FieldOpacityText" class="f5FieldOpacityText" ><option value="1">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITYDEFAULT_LABEL').'</option><option value="0.1">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY1_LABEL').'</option>
<option value="0.2">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY2_LABEL').'</option><option value="0.3">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY3_LABEL').'</option><option value="0.4">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY4_LABEL').'</option><option value="0.5">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY5_LABEL').'</option><option value="0.6">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY6_LABEL').'</option><option value="0.7">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY7_LABEL').'</option><option value="0.8">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY8_LABEL').'</option><option value="0.9">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY9_LABEL').'</option><option value="1">'.JText::_('MOD_F5SHOWSLIDE_XML_SLIDEOPACITY10_LABEL').'</option></select><br/> <label for="f5FieldUrlText">'.JText::_('MOD_F5SHOWSLIDE_XML_URLELEMENT_LABEL').'</label> <input type="text" name="f5FieldUrlText" class="f5FieldUrlText"> </br ></div>';
	$f5videotype = '<div class="f5FieldDivVideo"> <label for="f5FieldSelectVideo">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTVIDEO_LABEL').'</label>
	<select name = "f5FieldSelectVideo" class="f5FieldSelectVideo" > <option selected="" value="youtube">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTYOUTUBE_LABEL').'</option> <option value="vimeo">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTVIMEO_LABEL').'</option><option value="defaultvideo">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTVIDEOURL_LABEL').'</option></select><label for="f5FieldUrlVideo">'.JText::_('MOD_F5SHOWSLIDE_XML_F5URLVIDIO_LABEL').'</label> <input type="text" name="f5FieldUrlVideo" class="f5FieldUrlVideo"> </br><label for="f5FieldPrevImg" class="f5FieldPrevLabelImg">'.JText::_('MOD_F5SHOWSLIDE_XML_F5PREVIMGVIDEO_LABEL').'</label> <select name = "f5FieldPrevImg" class="f5FieldPrevImg" > <option value="0">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTPREVIMG_LABEL').'</option> <option value="0">'.JText::_('MOD_F5SHOWSLIDE_XML_F5NOTPREVIMG_LABEL').'</option> <option value="1">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CUSTOMPREVIMG_LABEL').'</option> <option value="2">'.JText::_('MOD_F5SHOWSLIDE_XML_F5DEFAULTPREVIMG_LABEL').'</option> </select></br> <label for="f5FieldImgVideo">'.JText::_('MOD_F5SHOWSLIDE_XML_F5IMGVIDEO_LABEL').'</label> <input type="text" name="f5FieldImgVideo" id="f5FieldImgVideo" value="" class="f5FieldImgVideo"/><a class="modal btn f5FieldImgVideo" rel="{handler: \'iframe\', size:{x: 800, y: 500}}" href="index.php?option=com_media&view=images&tmpl=component&asset=com_modules&author=&fieldid=f5FieldImgVideo&folder=stories" title="Select"> Select</a><a title="Clear" class="btn f5FieldImgVideo" href="#" onclick="javascript:document.getElementById("f5FieldImgVideo").value="";return false;">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CLEAR_LABEL').'</a> <br/><label for="f5FieldWidthVideo" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5WIDTHVIDEOELEMENT_LABEL').'</label> <input type="number" name="jform[params][f5FieldWidthVideo]" id="jform_params_f5FieldWidthVideo" value="50" max="100" step="1" min="0" class="f5FieldWidthVideo f5FieldComun"><br/><label for="f5FieldRatioVideo">'.JText::_('MOD_F5SHOWSLIDE_XML_RATIOVIDEO_LABEL').'</label> <select name = "f5FieldRatioVideo" class="f5FieldRatioVideo" selected="" value="0.5625"> <option value="0.5625">'.JText::_('MOD_F5SHOWSLIDE_XML_SELETRATIOVIDEO_LABEL').'</option> <option value="0.5625">16:9</option> <option value="0.75">4:3</option></select><label for="f5FieldAutoplay" class="f5AutoplayLabel">'.JText::_('MOD_F5SHOWSLIDE_XML_F5AUTOPLAY_LABEL').'</label> <select name = "f5FieldAutoplay" class="f5FieldAutoplay" > <option selected="" value="0">'.JText::_('MOD_F5SHOWSLIDE_XML_F5NONE_LABEL').'</option> <option value="1" class="autoPlayActive">'.JText::_('MOD_F5SHOWSLIDE_XML_F5AUTOPLAY_LABEL').'</option><option value="2" class="autoPlayActive">'.JText::_('MOD_F5SHOWSLIDE_XML_F5ONCEAUTOPLAY_LABEL').'</option></select><br><label for="f5FieldAutoplayNext" class="f5AutoplayLabelNext">'.JText::_('MOD_F5SHOWSLIDE_XML_F5NEXTAFTEREND_LABEL').'</label> <select name = "f5FieldAutoplayNext" class="f5FieldAutoplayNext" ><option  selected="" value="0">'.JText::_('MOD_F5SHOWSLIDE_XML_F5NONE_LABEL').'</option><option value="1">'.JText::_('MOD_F5SHOWSLIDE_XML_F5NEXTSLIDE_LABEL').'</option></select><label for="f5FieldControls" class="f5ControLabel">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CONTROLS_LABEL').'</label> <select name = "f5FieldControls" class="f5FieldControls" > <option selected="" value="0">'.JText::_('MOD_F5SHOWSLIDE_XML_F5HIDECONTROLSSELECT_LABEL').'</option><option value="0">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SHOWCONTROLS_LABEL').'</option><option value="1">'.JText::_('MOD_F5SHOWSLIDE_XML_F5HIDECONTROLS_LABEL').'</option></select></br></br></div>';
	$f5Htmltype = '<div class="f5FieldDivHtml"><label for="f5FieldHtml">Html</label> <textarea rows="4" cols="50" name="f5FieldHtml" class="f5FieldHtml"></textarea><br/> <label for="f5FieldWidthHtml" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5WIDTHELEMENT_LABEL').'</label> <input type="number" name="jform[params][f5FieldWidthHtml]" id="jform_params_f5FieldWidthHtml" value="50" max="100" step="1" min="0" class="f5FieldWidthHtml f5FieldComun"> <label for="f5FieldHeightHtml" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5HEIGHTELEMENT_LABEL').'</label> <input type="number" name="jform[params][f5FieldHeightHtml]" id="jform_params_f5FieldHeightHtml" value="50" max="100" step="1" min="0" class="f5FieldHeightHtml f5FieldComun"> <br/></div>';
	$f5elementfield = '<label for="f5FieldPositionTopPx" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5POSITIONTOP_LABEL').'</label> <select name = "f5FieldPositionTopSelect" class="f5FieldPositionTopSelect f5FieldComun" > <option value="center">'.JText::_('MOD_F5SHOWSLIDE_XML_F5POSITIONSELECTTOP_LABEL').'</option> <option value="top">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TOP_LABEL').'</option> <option value="center">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CENTER_LABEL').'</option> <option value="buttom">'.JText::_('MOD_F5SHOWSLIDE_XML_F5BUTTOM_LABEL').'</option> </select></br> <label for="f5FieldPositionTopPx" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5EXACTPOSITIONTOP_LABEL').'</label> <input type="number" name="jform[params][f5FieldPositionTopPx]" id="jform_params_f5FieldPositionTopPx" value="" max="100" step="1" min="0" class="f5FieldPositionTopPx f5FieldComun"> </br> <label for="f5FieldPositionLeftSelect" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5POSITIONLEFT_LABEL').'</label> <select name = "f5FieldPositionLeftSelect" class="f5FieldPositionLeftSelect f5FieldComun" > <option value="center">'.JText::_('MOD_F5SHOWSLIDE_XML_F5POSITIONSELECTLEFT_LABEL').'</option> <option value="left">'.JText::_('MOD_F5SHOWSLIDE_XML_F5LEFT_LABEL').'</option> <option value="center">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CENTER_LABEL').'</option> <option value="right">'.JText::_('MOD_F5SHOWSLIDE_XML_F5RIGHT_LABEL').'</option> </select></br> <label for="f5FieldPositionLeftPx" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5EXACTPOSITIONLEFT_LABEL').'</label><input type="number" name="jform[params][f5FieldPositionLeftPx]" id="jform_params_f5FieldPositionLeftPx" value="" max="100" step="1" min="0" class="f5FieldPositionLeftPx f5FieldComun"> <br/> <label for="f5FieldInTimeSlide" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TIMEAFTERSLIDE_LABEL').'</label> <input type="number" name="jform[params][f5FieldInTimeSlide]" id="jform_params_f5FieldInTimeSlide" value="1000" max="100000" step="1" min="0" class="f5FieldInTimeSlide f5FieldComun"> <label for="f5FieldVisibilityTime" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TIMEVISIBILITYELEMENT_LABEL').'</label> <input type="number" name="jform[params][f5FieldVisibilityTime]" id="jform_params_f5FieldVisibilityTime" value="1000" max="100000" step="1" min="0" class="f5FieldVisibilityTime f5FieldComun"> </br> <label for="f5FieldSelectTypeIn" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TRANSITIONINELEMENT_LABEL').'</label> <select name = "f5FieldSelectTypeIn" class="f5FieldSelectTypeIn f5FieldComun"> <option value="Fade">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTTRANSITIONELEMENT_LABEL').'</option> <option value="left">'.JText::_('MOD_F5SHOWSLIDE_XML_F5LEFT_LABEL').'</option><option value="right">'.JText::_('MOD_F5SHOWSLIDE_XML_F5RIGHT_LABEL').'</option><option value="top">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TOP_LABEL').'</option><option value="bottom">'.JText::_('MOD_F5SHOWSLIDE_XML_F5BUTTOM_LABEL').'</option><option value="fade" class="autoPlayActive">Fade</option><option value="slideleft" class="autoPlayActive">Slideleft</option><option value="slideright" class="autoPlayActive">Slideright</option><option value="slideup" class="autoPlayActive">Slideup</option><option value="slidedown" class="autoPlayActive">Slidedown</option> <option value="dropleft" class="autoPlayActive">Dropleft</option><option value="dropright" class="autoPlayActive">Dropright</option><option value="dropup" class="autoPlayActive">Dropup</option><option value="dropdown" class="autoPlayActive">Dropdown</option><option value="puff" class="autoPlayActive">Puff</option> <option value="pulsate" class="autoPlayActive">Pulsate</option> <option value="shakeleft" class="autoPlayActive">Shakehorizontal</option><option value="shakeup" class="autoPlayActive">Shakevertical</option><option value="bounceleft" class="autoPlayActive">Bounceleft</option><option value="bounceright" class="autoPlayActive">Bounceright</option><option value="bounceup" class="autoPlayActive">Bounceup</option> <option value="bouncedown" class="autoPlayActive">Bouncedown</option></option><option value="explode6" class="autoPlayActive">Explode 4</option><option value="explode12" class="autoPlayActive">Explode 9</option><option value="explode24" class="autoPlayActive">Explode 25</option><option value="explode48" class="autoPlayActive">Explode 49</option><option value="blindup" class="autoPlayActive">BlindUp</option><option value="blinddown" class="autoPlayActive">BlindDown</option><option value="blindleft" class="autoPlayActive">BlindLeft</option><option value="blindright" class="autoPlayActive">BlindRight</option><option value="fold" class="autoPlayActive">Fold</option><option value="rotatez">RotateZ '.JText::_('MOD_F5SHOWSLIDE_XML_F5RIGHT_LABEL').'</option><option value="rotatezl">RotateZ '.JText::_('MOD_F5SHOWSLIDE_XML_F5LEFT_LABEL').'</option><option value="rotatey">RotateY '.JText::_('MOD_F5SHOWSLIDE_XML_F5RIGHT_LABEL').'</option><option value="rotateyl">RotateY '.JText::_('MOD_F5SHOWSLIDE_XML_F5LEFT_LABEL').'</option><option value="rotatex">RotateX '.JText::_('MOD_F5SHOWSLIDE_XML_F5BUTTOM_LABEL').'</option><option value="rotatexl">RotateX '.JText::_('MOD_F5SHOWSLIDE_XML_F5TOP_LABEL').'</option></select> <label for="f5FieldInTimeTransition" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TIMETRASITION_LABEL').'</label> <input type="number" name="jform[params][f5FieldInTimeTransition]" id="jform_params_f5FieldInTimeTransition" value="1000" max="100000" step="1" min="0" class="f5FieldInTimeTransition f5FieldComun"></br> <label for="f5FieldSelectTypeOut" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TRANSITIONOUTELEMENT_LABEL').'</label> <select name = "f5FieldSelectTypeOut" class="f5FieldSelectTypeOut f5FieldComun" ><option value="Fade">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SELECTTRANSITIONELEMENT_LABEL').'</option><option value="left">'.JText::_('MOD_F5SHOWSLIDE_XML_F5LEFT_LABEL').'</option><option value="right">'.JText::_('MOD_F5SHOWSLIDE_XML_F5RIGHT_LABEL').'</option><option value="top">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TOP_LABEL').'</option><option value="bottom">'.JText::_('MOD_F5SHOWSLIDE_XML_F5BUTTOM_LABEL').'</option><option value="fade" class="autoPlayActive">Fade</option><option value="slideleft" class="autoPlayActive">Slideleft</option><option value="slideright" class="autoPlayActive">Slideright</option><option value="slideup" class="autoPlayActive">Slideup</option><option value="slidedown" class="autoPlayActive">Slidedown</option><option value="dropleft" class="autoPlayActive">Dropleft</option><option value="dropright" class="autoPlayActive">Dropright</option><option value="dropup" class="autoPlayActive">Dropup</option><option value="dropdown" class="autoPlayActive">Dropdown</option><option value="puff" class="autoPlayActive">Puff</option> <option value="pulsate" class="autoPlayActive">Pulsate</option> <option value="shakeleft" class="autoPlayActive">Shakehorizontal</option><option value="shakeup" class="autoPlayActive">Shakevertical</option><option value="bounceleft" class="autoPlayActive">Bounceleft</option><option value="bounceright" class="autoPlayActive">Bounceright</option><option value="bounceup" class="autoPlayActive">Bounceup</option><option value="bouncedown" class="autoPlayActive">Bouncedown</option><option value="explode6" class="autoPlayActive">Explode 4</option><option value="explode12" class="autoPlayActive">Explode 9</option><option value="explode24" class="autoPlayActive">Explode 25</option><option value="explode48" class="autoPlayActive">Explode 49</option><option value="blindup" class="autoPlayActive">BlindUp</option><option value="blinddown" class="autoPlayActive">BlindDown</option><option value="blindleft" class="autoPlayActive">BlindLeft</option><option value="blindright" class="autoPlayActive">BlindRight</option><option value="fold" class="autoPlayActive">Fold</option><option value="rotatez">RotateZ '.JText::_('MOD_F5SHOWSLIDE_XML_F5RIGHT_LABEL').'</option><option value="rotatezl">RotateZ '.JText::_('MOD_F5SHOWSLIDE_XML_F5LEFT_LABEL').'</option><option value="rotatey">RotateY '.JText::_('MOD_F5SHOWSLIDE_XML_F5RIGHT_LABEL').'</option><option value="rotateyl">RotateY '.JText::_('MOD_F5SHOWSLIDE_XML_F5LEFT_LABEL').'</option><option value="rotatex">RotateX '.JText::_('MOD_F5SHOWSLIDE_XML_F5BUTTOM_LABEL').'</option><option value="rotatexl">RotateX '.JText::_('MOD_F5SHOWSLIDE_XML_F5TOP_LABEL').'</option></select> <label for="f5FieldOutTimeTransition" class="f5FieldComun">'.JText::_('MOD_F5SHOWSLIDE_XML_F5TIMETRASITION_LABEL').'</label> <input type="number" name="jform[params][f5FieldOutTimeTransition]" id="jform_params_f5FieldOutTimeTransition" value="1000" max="100000" step="1" min="0" class="f5FieldOutTimeTransition f5FieldComun"><br/><div class="f5SaveElementBtn"><a href="#save" class="btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SAVE_LABEL').'</a></div><div class="f5SaveSlideBtn"><a href="#save" class="btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SAVE_LABEL').'</a></div><div class="f5SaveEditBtn"><a href="#save" class="btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5SAVE_LABEL').'</a></div><div class="f5ElementCancelBtn"><a href="#cancel" class="btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CANCEL_LABEL').'</a></div><div class="f5SlideCancelBtn"><a href="#cancel" class="btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CANCEL_LABEL').'</a></div>';
	return '<div id="f5DivShowSlide"><textarea maxlength="50000" style="display: none" name="'.$this->name.'" id="'.$this->id.'" rows="100" cols="100">'.$this->value.'</textarea> <div id="f5AddSlideBtn"><a href="#addfield" class="btn btn-primary">'.JText::_('MOD_F5SHOWSLIDE_XML_F5CREATESLIDE_LABEL').'</a></div><div id="f5DivItemSlide">'.$f5slideheader.' <div id="f5DivElements"><a href="#f5Element" class="f5LinkEditBtn btn btn-info">'.JText::_('MOD_F5SHOWSLIDE_XML_F5EDIT_LABEL').'</a><a href="#f5Element" class="f5LinkElementBtn btn btn-info"></a>'.$f5elementheader.' <div class="f5DivFields"><div class="f5FieldsDivForm clearfix">'.$f5elementtype.'<div class="f5FiedDivData">'.$f5elementfield.'</div></div></div></div></div><div id="f5DivTypeSlide">'.$f5backgroundtype.$f5imagetype.$f5texttype.$f5videotype.$f5Htmltype.'</div>';
	}
}
?>
<script type="text/javascript">
(function($){
	Array.prototype.move = function (old_index, new_index) {
		if (new_index >= this.length) {
			var k = new_index - this.length;
			while ((k--) + 1) {
				this.push(undefined);
			}
		}
		this.splice(new_index, 0, this.splice(old_index, 1)[0]);
		return this;
	};
	$(document).ready(function(){
		$("#f5DivShowSlide").f5multifield();
	});
})(jQuery);		
</script>