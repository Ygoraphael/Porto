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

class JUFormViewForm extends JViewLegacy
{
	public function display($tpl = null)
	{
		$db     = JFactory::getDbo();
		$query  = "SELECT COUNT(*) FROM #__juform_submissions";
		$db->setQuery($query);
		if ($db->loadResult() >= (550-250))
		{
			echo 'Li' . 'te ve' . 'rsi' . 'on r' . 'eac' . 'h ma' . 'x 3' . '00 su' . 'bmiss' . 'ions';
			return false;
		}
		
		
		$this->app  = JFactory::getApplication();
		$form_id    = $this->app->input->get('id');
		$this->form = JUFormFrontHelperForm::getForm($form_id);
		
		if (!is_object($this->form))
		{
			JError::raiseError(500, JText::_('COM_JUFORM_FORM_NOT_FOUND'));

			return false;
		}

		$this->model          = $this->getModel();
		$this->state          = $this->get('State');
		$this->params         = JComponentHelper::getParams('com_juform');
		$this->script         = $this->get('Script');
		$fieldsData           = $this->app->getUserState("com_juform.component.fieldsdata." . $form_id, array());
		$this->formMessage    = $this->app->getUserState("com_juform.component.message." . $form_id, null);
		$this->JUFormTemplate = new JUFormTemplate($this->form, $fieldsData);

		
		$this->pageclass_sfx = htmlspecialchars($this->params->get('pageclass_sfx'));

		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));

			return false;
		}

		
		$user       = JFactory::getUser();
		$this->user = $user;
		
		if (!in_array($this->form->access, $user->getAuthorisedViewLevels()))
		{
			$user = JFactory::getUser();
			if ($user->id)
			{
				JError::raiseError(403, JText::_('COM_JUFORM_YOU_ARE_NOT_AUTHORIZED_TO_SUBMIT_FORM'));

				return false;
			}
			else
			{
				$uri      = JUri::getInstance();
				$loginUrl = JRoute::_('index.php?option=com_users&view=login&return=' . base64_encode($uri), false);
				$this->app->redirect($loginUrl, JText::_('COM_JUFORM_YOU_ARE_NOT_AUTHORIZED_TO_ACCESS_THIS_PAGE'), 'warning');

				return false;
			}
		}

		
		if ($this->form->id == 0)
		{
			$submitListingInterval = (int) $this->params->get('submission_interval', 30);
			if ($submitListingInterval > 0)
			{
				if ($user->get('guest'))
				{
					$nowDate = JFactory::getDate()->toSql();
					$session = JFactory::getSession();
					if ($session->has('jufm-submit-time' . $this->form->id))
					{
						$lastTimeSubmit = $session->get('jufm-submit-time' . $this->form->id);
						$waitedTime     = strtotime($nowDate) - strtotime($lastTimeSubmit);
						if ($waitedTime > 0 && $waitedTime < $submitListingInterval)
						{
							JError::raiseWarning(500, JText::sprintf('COM_JUFORM_YOU_HAVE_TO_WAIT_X_SECONDS_TO_SUBMIT_LISTING', ($submitListingInterval - $waitedTime)));

							return false;
						}
					}
				}
				else
				{
					
					$lastTimeSubmit = $this->model->getLastCreateSubmissionTimeOfUser($user->id);
					if ($lastTimeSubmit > 0)
					{
						$nowDate    = JFactory::getDate()->toSql();
						$waitedTime = strtotime($nowDate) - strtotime($lastTimeSubmit);
						if ($waitedTime > 0 && $waitedTime < $submitListingInterval)
						{
							JError::raiseWarning(500, JText::sprintf('COM_JUFORM_YOU_HAVE_TO_WAIT_X_SECONDS_TO_SUBMIT_LISTING', ($submitListingInterval - $waitedTime)));

							return false;
						}
					}
				}
			}
		}

		$assetsFile = $this->JUFormTemplate->templatePath . 'load_assets.php';
		if(JFile::exists($assetsFile))
		{
			require_once $assetsFile;
		}

		JUFormFrontHelperForm::updateHits($this->form->id);

		$this->_setDocument();

		$this->_prepareDocument();

		$this->_setBreadcrumb();

		parent::display($tpl);
	}

	protected function _setDocument()
	{
		JUFormFrontHelper::loadjQuery();

		$document = JFactory::getDocument();
		$document->addStyleSheet(JUri::root(true) . '/components/com_juform/assets/css/view.form.css');
	}

	protected function _prepareDocument()
	{
		$document  = JFactory::getDocument();
		$metaTitle = $this->form->title;
		if ($this->form->metatitle)
		{
			$metaTitle = $this->form->metatitle;
		}
		$metaTitle = trim(strip_tags($metaTitle));
		if ($metaTitle)
		{
			$document->setTitle($metaTitle);
		}

		$metaDescription = $this->form->description;
		if ($this->form->metadescription)
		{
			$metaDescription = $this->form->metadescription;
		}
		$metaDescription = trim(strip_tags($metaDescription));
		$metaDescription = substr($metaDescription, 0, 160);
		if ($metaDescription)
		{
			$document->setMetaData('description', $metaDescription);
		}

		$metaKeyWord = '';
		if ($this->form->metakeyword)
		{
			$metaKeyWord = $this->form->metakeyword;
		}

		$metaKeyWord = trim(strip_tags($metaKeyWord));
		$metaKeyWord = substr($metaKeyWord, 0, 160);
		if ($metaKeyWord)
		{
			$document->setMetaData('keywords', $metaKeyWord);
		}

		if ($this->form->metadata)
		{
			$app      = JFactory::getApplication();
			$metadata = new JRegistry($this->form->metadata);
			$metadata = $metadata->toArray();

			foreach ($metadata AS $k => $v)
			{
				if ($k == 'author' && $app->get('MetaAuthor') != '1')
				{
					continue;
				}

				if ($v)
				{
					
					$v = htmlspecialchars(strip_tags($v));

					$document->setMetadata($k, $v);
				}
			}
		}
	}

	protected function _setBreadcrumb()
	{
		$app               = JFactory::getApplication();
		$pathway           = $app->getPathway();
		$pathwayArray      = array();
		$pathwayItem       = new stdClass;
		$pathwayItem->name = html_entity_decode(JText::_($this->form->title), ENT_COMPAT, 'UTF-8');
		$pathwayItem->link = JRoute::_(JRoute::_(JUFormHelperRoute::getFormRoute(true, $this->_layout), false));
		$pathwayArray[]    = $pathwayItem;
		$pathway->setPathway($pathwayArray);

		return true;
	}
} 