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

JFormHelper::loadFieldClass('list');

class JFormFieldLayoutType extends JFormFieldList
{
	
	protected $type = 'layouttype';

	public function getInput()
	{
		$document = JFactory::getDocument();
		$script   = "jQuery(document).ready(function($){
				generateTemplate = function(changeConfirm, showSpin){
					var templateType = $('#jform_template_type').val();
					if(changeConfirm && templateType == 2 && !confirm('" . JText::_('COM_JUFORM_GENERATE_NEW_TEMPLATE_USING_NEW_TEMPLATE_PARAMS_ARE_YOU_SURE') . "')){
						return false;
					}

					var formData = $('#adminForm :not(#task, #jform_template_code)').serialize();
					$.ajax({
						url: 'index.php?option=com_juform&task=form.generateTemplate',
						data: formData,
						type: 'POST',
						dataType: 'html',
						beforeSend: function () {
							if(showSpin){
								showSpinner();
							}
						}
					}).done(function(data) {
						if(data){
							if(Joomla.editors.instances['jform_template_code'])
							{
								Joomla.editors.instances['jform_template_code'].setValue(data);
							}
							else
							{
								$('#jform_template_code').val(data);
							}
						}

						if(showSpin){
							hideSpinner();
						}
					});
				};

				$('#" . $this->id . "').change(function(){
					if($(this).val() == 1){
						$('#jform_template_code').next('.CodeMirror.CodeMirror-wrap').css('opacity', 0.7);
						generateTemplate(true, true);
					}else{
						Joomla.editors.instances['jform_template_code'].setOption('readOnly', false);
						$('#jform_template_code').next('.CodeMirror.CodeMirror-wrap').css('opacity', 1);
					}
				});

				function triggerCodeMirror(){
					jQuery(window).trigger('resize');
					 var evt = document.createEvent('UIEvents');
				     evt.initUIEvent('resize', true, false, window, 0);
				     window.dispatchEvent(evt);
				}

				jQuery('ul.nav-tabs li a[href=\"#design\"]').on('click', function(){
					 triggerCodeMirror();
				});
			});
		";
		$document->addScriptDeclaration($script);

		return parent::getInput();
	}
}
