<?php

/**------------------------------------------------------------------------

03.# mod_wdsfacebookwall - WDS Facebook Wall for Joomla! 2.5, 3.X

04.# ------------------------------------------------------------------------

05.# author    Robert Long

06.# copyright Copyright (C) 2013 Webdesignservices.net. All Rights Reserved.

07.# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

08.# Websites: http://www.webdesignservices.net

09.# Technical Support:  Support - https://www.webdesignservices.net/support/customer-support.html

10.------------------------------------------------------------------*/

// no direct access

	defined('_JEXEC') or die;



	require_once dirname(__FILE__).'/lib/facebook.php';

	

 if(!class_exists('mod_wdsfacebookwall',false)) {

	class mod_wdsfacebookwall

	{

		private $data;

		private $cacheFile;



		public function __construct() {

			$this->cacheFile = dirname(__FILE__) . '/cache';

		}



		public function getData($params) {

			  //  require '../src/facebook.php';



// Create our Application instance (replace this with your appId and secret).

$facebook = new Facebook(array(

  'appId'  => $params->get('App_KEY', '') ,

  'secret' => $params->get('App_Secret', '') ,

));



$user = $facebook->getUser();

$access_token = $facebook->getAccessToken();

if ($user) {

  try {

    // Proceed knowing you have a logged in user who's authenticated.

    $user_profile = $facebook->api('/me');

  } catch (FacebookApiException $e) {

    error_log($e);

    $user = null;

  }

}



//echo $access_token;



 

 



   

     

    //Get the contents of the Facebook page 

    $FBpage = file_get_contents('https://graph.facebook.com/'.$params->get('access_token', '').'/feed?access_token='.$access_token.'&limit='.$params->get('num_post', '')); 

 //echo  'https://graph.facebook.com/1573394260/feed?access_token='.$access_token.'&limit=5667';

    //Interpret data with JSON 

	 

    //Get the contents of the Facebook page num_post

   // $FBpage = file_get_contents('https://graph.facebook.com/100002435652054/posts?access_token=CAAGCxZC3DX8YBAMLJnqKHfOMkYVMdCCefiQUqQpokmgcVcFTef2wQTfKwPN2QQ0wbsaXajvzNYKc3JRo8r4YYBVlYH0hPEgYoTFZCtnwu4qszPe9eq94cKZA7ZCMJZCQbeuDudFjwU58eBGMr6pzLZBnBZC7cuv8lYZD'); 

//    //Interpret data with JSON 

	

    $FBdata =json_decode($FBpage); 



				return $FBdata;

			

		}

		

		public function addStyles($params) {

			$styles = '';

			$border = $params->get('border_color', '#ccc');

			$styles .= '#wds-tweets a {color: ' . $params->get('link_color', '#0084B4') . '}';

			$styles .= '#wds-container {background-color: ' . $params->get('bgd_color', '#fff') . '}';

			$styles .= '#wds-header {border-bottom-color: ' . $border . '}';

			$styles .= '#wds-header a{color: ' . $params->get('header_link_color', '#333') . '}';

			$styles .= '#wds-container {border-color: ' . $border . '}';

			$styles .= '.wds-copyright {border-top-color: ' . $border . '}';

			$styles .= '.wds-tweet-container {border-bottom-color: ' . $border . '}';

			$styles .= '#wds {color: ' . $params->get('text_color', '#333') . '}';

			$styles .= 'a .wds-display-name {color: ' . $params->get('header_link_color', '#333') . '}';

			$styles .= 'a .wds-screen-name {color: ' . $params->get('header_sub_color', '#666') . '}';

			$styles .= 'a:hover .wds-screen-name {color: ' . $params->get('header_sub_hover_color', '#999') . '}';

			//$styles .= '#wds-header, #wds-header a {color: ' . $params->get('search_title_color', '#333') . '}';

			if($params->get('width', '')) {

				$styles .= '#wds-container {width: ' . intval($params->get('width', '')) . 'px;}';

			}

			if($params->get('height', '')) {

				$styles .= '#wds {height: ' . intval($params->get('height', '')) . 'px !important; overflow: auto;}';

			}

			

			$doc = JFactory::getDocument();

		  if(($params->get('more_code', 1)==1) || ($params->get('more_code', 1)==2) )
	 { 
			$doc->addScript('modules/mod_wdsfacebookwall/js/jquery.min.js');
	 }
			//$doc->addStyleSheet(JURI::base() . 'modules/mod_wdsfacebookwall/css/wdstwitterwidget.css');

				$doc->addStyleSheet(JURI::base() . 'modules/mod_wdsfacebookwall/css/css_facbook.css');

			$doc->addStyleDeclaration($styles);



		}



		private function setCache() {

			JFile::write($this->cacheFile, serialize($this->data));

		}



		private function getCache() {

			if(file_exists($this->cacheFile)) {

				$cache = JFile::read($this->cacheFile);

				if($cache !== false)

					return unserialize(JFile::read($this->cacheFile));

			}

			return false;

		}



		// parse time in a twitter style

		private function getTime($date)

		{

			$timediff = time() - strtotime($date);

			if($timediff < 60)

				return $timediff . 's';

			else if($timediff < 3600)

				return intval(date('i', $timediff)) . 'm';

			else if($timediff < 86400)

				return round($timediff/60/60) . 'h';

			else

				return JHTML::_('date', $date, 'M d');

		}

	}

}