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


jimport('joomla.application.component.controllerform');


class JUFormControllerSubmission extends JControllerForm
{
	
	protected $text_prefix = 'COM_JUFORM_SUBMISSION';

	
	protected function allowAdd($data = array())
	{
		return false;
	}

	
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;
		if (!$recordId)
		{
			return false;
		}

		$record = JUFormHelper::getSubmissionById($recordId);
		if (!$record)
		{
			return false;
		}

		$user   = JFactory::getUser();
		$userId = $user->get('id');
		$asset  = 'com_juform';

		
		if ($user->authorise('core.edit', $asset))
		{
			return true;
		}
		
		
		if ($user->authorise('core.edit.own', $asset))
		{
			
			$ownerId = (int) isset($data['created_by']) ? $data['created_by'] : 0;
			if (empty($ownerId) && $recordId)
			{
				
				if (empty($record))
				{
					return false;
				}

				$ownerId = $record->created_by;
			}

			
			if ($ownerId == $userId)
			{
				return true;
			}
		}

		
		return parent::allowEdit($data, $key);
	}

	public function preview()
	{
		$app = JFactory::getApplication();
		$id  = $app->input->getInt('id', 0);
		if (parent::save($id))
		{
			$id = $app->getUserState('id_after_insert', 0);
			$this->setRedirect(
				JRoute::_(
					'index.php?option=com_juform&view=email&layout=preview&id=' . $id, false
				)
			);
		}
	}

	
	public function save($key = null, $urlVar = null)
	{
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/tables');

		
		$app     = JFactory::getApplication();
		$lang    = JFactory::getLanguage();
		$model   = $this->getModel();
		$table   = $model->getTable();
		$checkin = property_exists($table, 'checked_out');
		$context = "$this->option.edit.$this->context";
		$task    = $this->getTask();
		
		if (empty($key))
		{
			$key = $table->getKeyName();
		}

		
		if (empty($urlVar))
		{
			$urlVar = $key;
		}

		$recordId = $this->input->getInt($urlVar);

		$data['id']      = $recordId;
		$data['form_id'] = 0;
		$submission      = JUFormHelper::getSubmissionById($recordId);
		if ($submission)
		{
			$data['form_id'] = $submission->form_id;
		}

		$fieldsData = $app->input->post->get('fields', array(), 'array');

		
		if ($task == 'save2copy')
		{
			
			if ($checkin && $model->checkin($data[$key]) === false)
			{
				
				$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
				$this->setMessage($this->getError(), 'error');

				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_item
						. $this->getRedirectToItemAppend($recordId, $urlVar), false
					)
				);

				return false;
			}

			
			$data[$key] = 0;
			$task       = 'apply';
		}

		
		if (!$this->allowSave($data, $key))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_SAVE_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return false;
		}

		
		$validFieldsData = $model->validateFields($fieldsData, $data['form_id'], $data['id']);

		
		if ($validFieldsData === false)
		{
			
			$errors = $model->getErrors();

			
			for ($i = 0, $n = count($errors); $i < $n; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}
			
			$app->setUserState($context . '.data', $data);
			$app->setUserState($context . '.fieldsdata.' . $recordId, $fieldsData);

			
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return false;
		}

		$validData = array();
		
		$validData['data'] = $data;
		
		$validData['fieldsData'] = $validFieldsData;

		
		if (!$model->save($validData))
		{
			
			$app->setUserState($context . '.data', $data);
			$app->setUserState($context . '.fieldsdata.' . $recordId, $fieldsData);

			
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return false;
		}

		
		if ($checkin && $model->checkin($data[$key]) === false)
		{
			
			$app->setUserState($context . '.data', $data);
			$app->setUserState($context . '.fieldsdata.' . $recordId, $fieldsData);

			
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return false;
		}

		$this->setMessage(
			JText::_(
				($lang->hasKey($this->text_prefix . ($recordId == 0 && $app->isSite() ? '_SUBMIT' : '') . '_SAVE_SUCCESS')
					? $this->text_prefix
					: 'JLIB_APPLICATION') . ($recordId == 0 && $app->isSite() ? '_SUBMIT' : '') . '_SAVE_SUCCESS'
			)
		);

		$this->setMessage(
			JText::_(
				($lang->hasKey($this->text_prefix . ($recordId == 0 && $app->isSite() ? '_SUBMIT' : '') . '_SAVE_SUCCESS')
					? $this->text_prefix
					: 'JLIB_APPLICATION') . ($recordId == 0 && $app->isSite() ? '_SUBMIT' : '') . '_SAVE_SUCCESS'
			)
		);

		
		switch ($task)
		{
			case 'apply':
				
				$recordId = $model->getState($this->context . '.id');
				$this->holdEditId($context, $recordId);
				$app->setUserState($context . '.data', null);
				$app->setUserState($context . '.fieldsdata.' . $recordId, null);
				$model->checkout($recordId);

				
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_item
						. $this->getRedirectToItemAppend($recordId, $urlVar), false
					)
				);
				break;

			case 'save2new':
				
				$this->releaseEditId($context, $recordId);
				$app->setUserState($context . '.data', null);
				$app->setUserState($context . '.fieldsdata.' . $recordId, null);

				
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_item
						. $this->getRedirectToItemAppend(null, $urlVar), false
					)
				);
				break;

			default:
				
				$this->releaseEditId($context, $recordId);
				$app->setUserState($context . '.data', null);
				$app->setUserState($context . '.fieldsdata.' . $recordId, null);
				
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_list
						. $this->getRedirectToListAppend(), false
					)
				);
				break;
		}

		
		$this->postSaveHook($model, $validData);

		return true;
	}

	public function cancel($key = null)
	{
		$context      = "$this->option.edit.$this->context";
		$app          = JFactory::getApplication();
		$submissionId = $app->input->get('id', 0);
		$app->setUserState($context . '.fieldsdata.' . $submissionId, null);

		return parent::cancel($key);
	}
}
