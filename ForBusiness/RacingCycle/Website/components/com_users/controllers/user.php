<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Registration controller class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class UsersControllerUser extends UsersController
{
	/**
	 * Method to log in a user.
	 *
	 * @since	1.6
	 */
    
    public function handleInvalid(){
        
        
        $str='<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>RacingCycle</title>
		<meta name="viewport" content="">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="robots" content="INDEX,FOLLOW">
		  <base href="https://racingcycle.net/index.php/en/login">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="keywords" content="racing,wheels,wheel,bike,on-line,Prototype,cycle,PROTOTYPE,prototype,mcfk,schmolke,thm,ax-lightness,rodas,espigão,avanço,rodas carbono,carbon wheels,mtb, road carbon wheels, rodas carbono montanha,guiador carbono,espigão carbono,sun race,carbon 29,29 carbono,29r carbon,team,mtb,uci">
  <meta name="description" content="Distributor of Bicycle Racing Parts ">
  <meta name="generator" content="Joomla! - Open Source Content Management">
  <title>Login</title>
  <link href="/templates/beez5/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
  <link rel="stylesheet" href="/media/mod_languages/css/template.css" type="text/css">
  <link rel="stylesheet" href="https://racingcycle.net/plugins/system/fmalertcookies/assets/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="https://racingcycle.net/plugins/system/fmalertcookies/assets/css/custom.css" type="text/css">
  <script src="/plugins/system/yt/includes/admin/js/jquery.min.js" type="text/javascript"></script>
  <script src="/plugins/system/yt/includes/admin/js/jquery-noconflict.js" type="text/javascript"></script>
  <script src="/media/system/js/mootools-core.js" type="text/javascript"></script>
  <script src="/media/system/js/core.js" type="text/javascript"></script>
  <script src="/media/system/js/mootools-more.js" type="text/javascript"></script>
  <script type="text/javascript">
function keepAlive() {	var myAjax = new Request({method: "get", url: "index.php"}).send();} window.addEvent("domready", function(){ keepAlive.periodical(3600000); });
  </script>

		<script>var $jq = jQuery.noConflict();</script>
		<link rel="icon" href="/images/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,300,700,800,400,600" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,500,600,700,800" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="/js/calendar/calendar-win2k-1.css">
		<link rel="stylesheet" type="text/css" href="/css/widgets.css" media="all">
		<link rel="stylesheet" type="text/css" href="/css/main.css" media="all">
		<link rel="stylesheet" type="text/css" href="/js/growler.css" media="all">
		<link rel="stylesheet" type="text/css" href="/js/modalbox.css" media="all">
		<link rel="stylesheet" type="text/css" href="/css/all.css" media="all">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="/css/fancybox.css" media="all">
		<link rel="stylesheet" type="text/css" href="/css/scrollingcart/scroll.css" media="all">
		<link rel="stylesheet" type="text/css" href="/css/print.css" media="print">
		<script type="text/javascript" src="/js/prototype/prototype.js"></script>
		<script type="text/javascript" src="/js/lib/ccard.js"></script>
		<script type="text/javascript" src="/js/prototype/validation.js"></script>
		<script type="text/javascript" src="/js/scriptaculous/builder.js"></script>
		<script type="text/javascript" src="/js/scriptaculous/effects.js"></script>
		<script type="text/javascript" src="/js/scriptaculous/dragdrop.js"></script>
		<script type="text/javascript" src="/js/scriptaculous/controls.js"></script>
		<script type="text/javascript" src="/js/scriptaculous/slider.js"></script>
		<script type="text/javascript" src="/js/varien/js.js"></script>
		<script type="text/javascript" src="/js/varien/form.js"></script>
		<script type="text/javascript" src="/js/varien/menu.js"></script>
		<script type="text/javascript" src="/js/mage/translate.js"></script>
		<script type="text/javascript" src="/js/mage/cookies.js"></script>
		<script type="text/javascript" src="/js/varien/product.js"></script>
		<script type="text/javascript" src="/js/varien/configurable.js"></script>
		<script type="text/javascript" src="/js/calendar/calendar.js"></script>
		<script type="text/javascript" src="/js/calendar/calendar-setup.js"></script>
		<script type="text/javascript" src="/js/growler.js"></script>
		<script type="text/javascript" src="/js/modalbox.js"></script>
		<script type="text/javascript" src="/js/ajaxcart.js"></script>
		<script type="text/javascript" src="/js/bundle.js"></script>
		<script type="text/javascript" src="/js/all.js"></script>
		<script type="text/javascript" src="/js/banner.js"></script>
		<script type="text/javascript" src="/js/nav.js"></script>
		<script type="text/javascript" src="/js/cart.js"></script>
		<script type="text/javascript" src="/js/totop.js"></script>
		<script type="text/javascript" src="/js/products-slider.js"></script>
		<script type="text/javascript" src="/js/left-nav.js"></script>
		<script type="text/javascript" src="/js/cat-slides.js"></script>
		<script type="text/javascript" src="/js/mob-nav.js"></script>
		<script type="text/javascript" src="/js/pro-img-slider.js"></script>
		<script type="text/javascript" src="/js/toggle.js"></script>
		<script type="text/javascript" src="/js/cloud-zoom.js"></script>
		<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.pack.js"></script>
		<script type="text/javascript" src="/js/jquery.lettering.js"></script>
		<script type="text/javascript" src="/js/easing.js"></script>
		<script type="text/javascript" src="/js/eislideshow.js"></script>
		<script type="text/javascript" src="/js/jquery.elevatezoom.js"></script>
		<link rel="stylesheet" href="/css/styles-fixed.css" type="text/css">
		<link rel="stylesheet" href="/css/responsive-fixed.css" type="text/css">
			</head>
            <style>body{height:530px !important}</style>
		<header>
			<div class="top-links">
				<div class="inner">
					<div class="lang-switcher">
						<div class="mod-languages">

	<ul class="lang-inline">
						<li class="" dir="ltr">
			<a href="/index.php/pt/">
							<img src="/media/mod_languages/images/pt.gif" alt="Português (PT)" title="Português (PT)">						</a>
			</li>
				</ul>

</div>

					</div>
					<p class="welcome-msg"><noscript><strong>JavaScript is currently disabled.</strong>Please enable it for a better experience of <a href="http://2glux.com/projects/jumi">Jumi</a>.</noscript></p>
					<div class="toplinks">
						<div class="links">
							<div class="company">
	<div class="click-nav">
		<ul class="no-js">
			<li>
				<a class="clicker" title="RacingCycle">RacingCycle</a>
				<ul class="link">
					<li><a title="About Us" href="/index.php/'.JText::_('JABOUT_LINK').'">'.JText::_('JABOUT_LABEL').'</a></li>
					<li><a title="Team" href="/index.php/'.JText::_('JTEAM_LINK').'">'.JText::_('JTEAM_LINK').'</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<div class="check">
	<a href="/index.php/'.JText::_('JCONTACTOS_LINK').'" title="Contacts">
	<span>'.JText::_('JCONTACTOS_LINK').'</span>
	</a>
</div>
<div class="login">
			<a href="/index.php/'.JText::_('JLANGUAGE_LINK')."/".JText::_('JLOG_IN_LINK').'">
			<span>'.JText::_('JLOG_IN_LINK').'</span>
		</a>
	</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header">
								<div class="logo">
					<a href="/index.php" title="RacingCycle">
						<div>
							<img alt="RacingCycle" src="/images/logo.png">
						</div>
					</a>
				</div>
			</div>
		</header>
		
					<section class="main-col col2-left-layout">
				<div class="main-container-inner">
					
<div class="breadcrumbs">
'.JText::_('JERROR_LAYOUT_HOME_PAGE').' —›  <span>'.JText::_('JLOGIN').'</span></div>

					<article class="col-main" style="margin-top: 5px; width:100%;">
						
						
<div id="system-message-container">
<dl id="system-message">
<dt class="error">'.JText::_('JERROR_ERROR').'</dt>
<dd class="error message">
	<ul>
        <li>'.JText::_('JINVALID_TOKEN').'</li>
        <li>'.JText::_('JPLEASE').' <a href="/index.php/'.JText::_('JLANGUAGE_LINK')."/".JText::_('JLOG_IN_LINK').'">
			<span>'.JText::_('JCLICK_HERE').'</span>
		</a> '.JText::_('JTO_TRY_AGAIN').'</li>
	</ul>
</dd>
</dl>
</div>
				                  
					</article>
									</div>
			</section>
					
		<footer>
			<div class="footer informative">
				<div class="footer-bottom">
					<div class="inner">
						<div class="coppyright">© 2018 <a href="https://www.novoscanais.com">novoscanais.com</a></div>
						
					</div>
				</div>
			</div>
		</footer><script>document.body.classList.add("cms-index-index cms-absolut-home");</script>';
        
        return $str;
        
    }
    
	public function login()
	{
		JSession::checkToken('post') or jexit($this->handleInvalid());

		$app = JFactory::getApplication();

		// Populate the data array:
		$data = array();
		$data['return'] = base64_decode(JRequest::getVar('return', '', 'POST', 'BASE64'));
		$data['username'] = JRequest::getVar('username', '', 'method', 'username');
		$data['password'] = JRequest::getString('password', '', 'post', JREQUEST_ALLOWRAW);

		// Set the return URL if empty.
		if (empty($data['return'])) {
			$data['return'] = 'index.php?option=com_users&view=profile';
		}

		// Set the return URL in the user state to allow modification by plugins
		$app->setUserState('users.login.form.return', $data['return']);

		// Get the log in options.
		$options = array();
		$options['remember'] = JRequest::getBool('remember', false);
		$options['return'] = $data['return'];

		// Get the log in credentials.
		$credentials = array();
		$credentials['username'] = $data['username'];
		$credentials['password'] = $data['password'];

		// Perform the log in.
		if (true === $app->login($credentials, $options)) {
			// Success
			$app->setUserState('users.login.form.data', array());
			//$app->redirect(JRoute::_($app->getUserState('users.login.form.return'), false));
			/* TIAGO - INICIO*/
			$user = JFactory::getUser();
			$session = JFactory::getSession();
			
			$query = "SELECT * FROM session_user where USERID ='".$user->id."'";	
		
			$db = JFactory::getDBO();
			 
			$db->setQuery($query);
			$result = $db->query();
			$result1 = $db->loadResult();
			
			if ($result1 != null){
				$rows = $db->loadObjectList();
				
				foreach( $rows as $row ) {
					$data = $row->data;
				}
				
				$session->set('vmcart', $data,'vm');
				
			}
			/* TIAGO - FIM*/
			$app->redirect("index.php");
		} else {
			// Login failed !
			$data['remember'] = (int)$options['remember'];
			$app->setUserState('users.login.form.data', $data);
			$app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
		}
	}

	/**
	 * Method to log out a user.
	 *
	 * @since	1.6
	 */
	public function logout()
	{
		JSession::checkToken('request') or jexit($this->handleInvalid());

		$app = JFactory::getApplication();

		// Perform the log in.
		$error = $app->logout();

		// Check if the log out succeeded.
		if (!($error instanceof Exception)) {
			// Get the return url from the request and validate that it is internal.
			$return = JRequest::getVar('return', '', 'method', 'base64');
			$return = base64_decode($return);
			if (!JURI::isInternal($return)) {
				$return = '';
			}

			// Redirect the user.
			$app->redirect("index.php");
			//$app->redirect(JRoute::_($return, false));
		} else {
			//$app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
			$app->redirect("index.php");
		}
	}

	/**
	 * Method to register a user.
	 *
	 * @since	1.6
	 */
	public function register()
	{
		JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));

		// Get the form data.
		$data	= JRequest::getVar('user', array(), 'post', 'array');

		// Get the model and validate the data.
		$model	= $this->getModel('Registration', 'UsersModel');
		$return	= $model->validate($data);

		// Check for errors.
		if ($return === false) {
			// Get the validation messages.
			$app	= &JFactory::getApplication();
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'notice');
				} else {
					$app->enqueueMessage($errors[$i], 'notice');
				}
			}

			// Save the data in the session.
			$app->setUserState('users.registration.form.data', $data);

			// Redirect back to the registration form.
			$this->setRedirect('index.php?option=com_users&view=registration');
			return false;
		}

		// Finish the registration.
		$return	= $model->register($data);

		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('users.registration.form.data', $data);

			// Redirect back to the registration form.
			$message = JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_users&view=registration', $message, 'error');
			return false;
		}

		// Flush the data from the session.
		$app->setUserState('users.registration.form.data', null);

		exit;
	}

	/**
	 * Method to login a user.
	 *
	 * @since	1.6
	 */
	public function remind()
	{
		// Check the request token.
		JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));

		$app	= JFactory::getApplication();
		$model	= $this->getModel('User', 'UsersModel');
		$data	= JRequest::getVar('jform', array(), 'post', 'array');

		// Submit the username remind request.
		$return	= $model->processRemindRequest($data);

		// Check for a hard error.
		if ($return instanceof Exception) {
			// Get the error message to display.
			if ($app->getCfg('error_reporting')) {
				$message = $return->getMessage();
			} else {
				$message = JText::_('COM_USERS_REMIND_REQUEST_ERROR');
			}

			// Get the route to the next page.
			$itemid = UsersHelperRoute::getRemindRoute();
			$itemid = $itemid !== null ? '&Itemid='.$itemid : '';
			$route	= 'index.php?option=com_users&view=remind'.$itemid;

			// Go back to the complete form.
			$this->setRedirect(JRoute::_($route, false), $message, 'error');
			return false;
		} elseif ($return === false) {
			// Complete failed.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getRemindRoute();
			$itemid = $itemid !== null ? '&Itemid='.$itemid : '';
			$route	= 'index.php?option=com_users&view=remind'.$itemid;

			// Go back to the complete form.
			$message = JText::sprintf('COM_USERS_REMIND_REQUEST_FAILED', $model->getError());
			$this->setRedirect(JRoute::_($route, false), $message, 'notice');
			return false;
		} else {
			// Complete succeeded.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getLoginRoute();
			$itemid = $itemid !== null ? '&Itemid='.$itemid : '';
			$route	= 'index.php?option=com_users&view=login'.$itemid;

			// Proceed to the login form.
			$message = JText::_('COM_USERS_REMIND_REQUEST_SUCCESS');
			$this->setRedirect(JRoute::_($route, false), $message);
			return true;
		}
	}

	/**
	 * Method to login a user.
	 *
	 * @since	1.6
	 */
	public function resend()
	{
		// Check for request forgeries
		JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));
	}
}
