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

/*
 * This file will be called when displaying form
 * */

// Do custom code for this template here
$params = JComponentHelper::getParams('com_juform');
JUFormFrontHelper::loadBootstrap(3, $params->get('load_bootstrap', '2'));

//$formTemplateParams = new JRegistry($this->form->template_params);
//$templateParamsObj = $formTemplateParams->get($this->JUFormTemplate->templateFolder);
//$templateParams = new JRegistry($templateParamsObj);