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


jimport('joomla.application.component.controlleradmin');
jimport('joomla.application.component.view');


class JUFormControllerForms extends JControllerAdmin
{
	protected $view_list = 'forms';

	
	protected $text_prefix = 'COM_JUFORM_FORMS';

	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->registerTask('unfeature', 'feature');
		$this->registerTask('inherit_access_unpublish', 'inherit_access_publish');
	}

	
	public function getModel($name = 'Form', $prefix = 'JUFormModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}
