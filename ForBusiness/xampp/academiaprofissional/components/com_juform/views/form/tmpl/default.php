<?php
/**
 * ------------------------------------------------------------------------
 * JUForm for Joomla 3.x
 * ------------------------------------------------------------------------
 *
 * @copyright      Copyright (C) 2010-2016 JoomUltra Co., Ltd. All Rights Reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 * @author         JoomUltra Co., Ltd
 * @website        http://www.joomultra.com
 * @----------------------------------------------------------------------@
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.calendar');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');

$document = JFactory::getDocument();
$document->addScript(JUri::root(true) . '/components/com_juform/assets/jqueryvalidation/jquery.validate.min.js');
$document->addScript(JUri::root(true) . '/components/com_juform/assets/jqueryvalidation/additional-methods.min.js');
$document->addScript(JUri::root(true) . '/components/com_juform/assets/js/view.form.js');

$form           = $this->form;
$formMessage    = $this->formMessage;
$JUFormTemplate = $this->JUFormTemplate;

$formAttributes           = array();
$formAttributes['name']   = 'ju-form';
$formAttributes['id']     = 'ju-form';
$formAttributes['method'] = 'POST';
$formAttributes['action'] = JRoute::_(JUFormHelperRoute::getFormRoute($form->id));

$formAttributes['enctype']='multipart/form-data';

$registry = new JRegistry($formAttributes);

if ($form->attributes)
{
	$registry->loadString($form->attributes);
}
$formIdStr        = $registry->get('id', 'ju-form');
$formAttributeStr = $registry->toString('ini');

$script = '
	jQuery(document).ready(function ($) {
		$("#' . $formIdStr . '").juformvalidate({formId: "' . $formIdStr . '"});
	});';
$document->addScriptDeclaration($script);

$JUFormTemplate->setupFieldAction($formIdStr);
$JUFormTemplate->setupFieldCalculation();

$JUFormTemplate->loadFormScript();
?>

<?php
ob_start();
?>
<form <?php echo $formAttributeStr; ?> >
	<div class="juform-message">
		<?php
		if ($formMessage)
		{ ?>
			<div class="alert alert-<?php echo $formMessage->type; ?> alert-dismissible" role="alert">
				<a class="close" data-dismiss="alert">&times;</a>
				<h4 class="alert-heading"><?php echo $formMessage->label; ?></h4>
				<?php echo implode("<br/>", $formMessage->messages); ?>
				<?php $this->app->setUserState("com_juform.component.message." . $form->id, null); ?>
			</div>
			<?php
		} ?>
	</div>
	<fieldset>
		<?php
		if ($form->show_title)
		{ ?>
			<legend><?php echo $form->title; ?></legend>
			<?php
		} ?>
		<?php $JUFormTemplate->getTemplate(); ?>
		<div class="hidden">
			<input type="hidden" name="form_id" value="<?php echo $form->id; ?>"/>
			<input type="hidden" name="task" value="form.save"/>
			<input type="hidden" name="hidden_field" value=""/>
			<?php if ($this->app->input->get('tmpl', '') == 'component')
			{ ?>
				<input type="hidden" name="tmpl" value="component"/>
				<?php
			} ?>
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</fieldset>
</form>

<?php
$formLayout = ob_get_contents();
ob_end_clean();

if (trim($form->php_ondisplay))
{
	eval($form->php_ondisplay);
}
?>

<div id="jufm-container-<?php echo $form->id; ?>" class="jubootstrap jufm-container <?php echo $this->pageclass_sfx; ?>">
	<?php echo $formLayout; ?>
</div>