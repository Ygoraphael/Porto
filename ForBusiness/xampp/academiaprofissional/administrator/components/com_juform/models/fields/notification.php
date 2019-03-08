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

class JFormFieldNotification extends JFormField
{
	public $type = 'notification';

	public function getLabel()
	{
		return '';
	}

	public function getInput()
	{
		$document = JFactory::getDocument();
		$formId   = $this->form->getValue('id', 0);
		$script   = "
			jQuery(document).ready(function($){
				$('.email-add, .email-edit').fancybox({
					helpers : {
						title : null
					},
					closeBtn : false
				});

				$(document).on('click', '.email-remove', function(){
					var r = confirm('" . JText::_('COM_JUFORM_ARE_YOU_SURE_YOU_WANT_TO_REMOVE_THIS_EMAIL_NOTIFICATION') . "');
					if (r == false) {
					    return false;
					}
					
					var self = $(this);
					var emailId = self.closest('tr').attr('id').split('-')[1];
					if(emailId){
						$.ajax({
							url: 'index.php?option=com_juform&task=form.removeEmail&tmpl=component',
							data: {id: emailId},
							type: 'POST',
							beforeSend: function(){
								showSpinner();
							}
						}).done(function(result) {
							if(result){
								self.closest('tr').remove();
							}
							hideSpinner();
						});
					}
				});

				$('.email-list tbody').dragsort({ dragSelector: 'tr', dragEnd: saveEmailOrdering, placeHolderTemplate: '<tr class=\"placeHolder\"><td colspan=\"4\"></td></tr>', dragSelectorExclude : 'button, a'});
				function saveEmailOrdering() {
					var ids = $('.email-list tbody tr').map(function() { return $(this).attr('id').split('-')[1]; }).get();
					if(ids){
						$.ajax({
							type: 'POST',
							url : 'index.php?option=com_juform&tmpl=component&task=form.saveEmailOrdering',
							data: {emailIds : ids.join(',')},
							beforeSend: function () {
								showSpinner();
							}
						})
						.done(function (value) {
							hideSpinner();
						});
					}
				}

				changeEmailPublish = function(self, emailId){
					if(emailId){
						$.ajax({
							type: 'POST',
							url : 'index.php?option=com_juform&tmpl=component&task=form.changeEmailPublish',
							data: {emailId : emailId},
							beforeSend: function () {
								showSpinner();
							}
						})
						.done(function (value) {
							self = $(self);
							if(value == 1){
								self.find('i').removeClass('icon-unpublish').addClass('icon-publish');
							}else if(value == 0){
								self.find('i').removeClass('icon-publish').addClass('icon-unpublish');
							}
							hideSpinner();
						});
					}
				}
			});
		";
		$document->addScriptDeclaration($script);

		$html = '<div id="field-notification" class="field-notification">';
		$html .= '<a class="btn btn-primary btn-small email-add" data-fancybox-type="iframe" href="index.php?option=com_juform&task=form.generateFormEmail&formId=' . (int) $formId . '&tmpl=component"><i class="icon-plus"></i> ' . JText::_('COM_JUFORM_ADD_EMAIL') . '</a>';
		$html .= '<table class="email-list table table-striped">';
		$html .= '<thead>';
		$html .= '<th class="hidden-phone" style="width: 1%"><i class="icon-menu-2"></i></th>';
		$html .= '<th style="width: 35%">' . JText::_('COM_JUFORM_SUBJECT') . '</th>';
		$html .= '<th style="width: 20%">' . JText::_('COM_JUFORM_FROM') . '</th>';
		$html .= '<th style="width: 20%">' . JText::_('COM_JUFORM_RECIPIENTS') . '</th>';
		$html .= '<th class="center" style="width: 5%">' . JText::_('COM_JUFORM_PUBLISHED') . '</th>';
		$html .= '<th class="center" style="width: 20%">' . JText::_('COM_JUFORM_ACTIONS') . '</th>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= '<tr id="email-0" style="display: none;"><td></td></tr>';

		$form_id = $this->form->getValue('id');
		$emails  = JUFormFrontHelper::getEmails($form_id);
		foreach ($emails AS $email)
		{
			$html .= '<tr id="email-' . $email->id . '">';
			$html .= '<td class="hidden-phone">';
			$html .= '<i class="icon-menu"></i>';
			$html .= '</td>';
			$html .= '<td>';
			$html .= $email->subject;
			$html .= '</td>';
			$html .= '<td>';
			$html .= $email->from;
			$html .= '</td>';
			$html .= '<td>';
			$html .= $email->recipients;
			$html .= '</td>';
			$html .= '<td class="center">';
			if ($email->published)
			{
				$html .= '<a href="#" class="btn btn-micro active hasTooltip" onclick="changeEmailPublish(this, \'' . $email->id . '\'); return false;"><i class="icon-publish"></i></a>';
			}
			else
			{
				$html .= '<a href="#" class="btn btn-micro active hasTooltip" onclick="changeEmailPublish(this, \'' . $email->id . '\'); return false;"><i class="icon-unpublish"></i></a>';
			}
			$html .= '</td>';
			$html .= '<td class="center">';
			$html .= '<a class="btn btn-small email-edit" href="index.php?option=com_juform&task=form.generateFormEmail&formId=' . (int) $formId . '&emailId=' . (int) $email->id . '&tmpl=component" data-fancybox-type="iframe">' . JText::_('COM_JUFORM_EDIT') . '</a>';
			$html .= ' <button type="button" class="btn btn-small btn-danger email-remove">' . JText::_('COM_JUFORM_REMOVE') . '</button>';
			$html .= '</td>';
			$html .= '</tr>';
		}

		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';

		return $html;
	}
}

?>