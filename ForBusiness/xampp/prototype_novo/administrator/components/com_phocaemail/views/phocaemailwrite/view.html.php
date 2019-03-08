<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined( '_JEXEC' ) or die();
jimport( 'joomla.application.component.view' );
jimport( 'joomla.filesystem.folder');
jimport( 'joomla.filesystem.file');

class PhocaEmailCpViewPhocaEmailWrite extends JView
{
	//public function display($tpl = null) {
	function display($tpl = null) {
		
		$tmpl = array();
		JHtml::stylesheet( 'administrator/components/com_phocaemail/assets/phocaemail.css' );

		//JHTML::_('behavior.tooltip');
		$app			= JFactory::getApplication();
		$doc 			= JFactory::getDocument();
		$user			= JFactory::getUser();
		$tmpl['path']	= PhocaEmailHelper::getPath();
		//$db			= JFactory::getDBO();
		$params 						= JComponentHelper::getParams('com_phocaemail') ;
		$param['display_users_list']	= $params->get('display_users_list', 0);
		$param['display_groups_list']	= $params->get('display_groups_list', 0);
		$param['display_users_list_cc']	= $params->get('display_users_list_cc', 0);
		$param['display_users_list_bcc']= $params->get('display_users_list_bcc', 0);
		$param['display_select_article']= $params->get('display_select_article', 0);
		
		JHTML::_('behavior.modal', 'a.modal-button');
		$js = "
		function jSelectArticle(id, title, object) {
			/* If the modal window will be refreshed, the object=article will be lost
			   and standard Joomla! id will be set, so correct it */
			if (object == 'id') {
				object = 'article';
			}
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = title;
			document.getElementById(object + '_name_display').value = title;
			document.getElementById('sbox-window').close();
		}";
		$doc->addScriptDeclaration($js);
		
		$tmplGet = JRequest::getVar( 'tmpl', '', 'get', 'string' );
		if ($tmplGet == 'component'){
			$css ='#system-message ul {margin-left: -35px;}
			#system-message dt {display:none;}
			#system-message ul li{
				height:30px;
				font-weight:bold;
				list-style-type:none;
				padding-top: 10px
			}';
			$doc->addStyleDeclaration($css);
		}
		
		// - - - - - - - - - - -
		// Third Extension
		// - - - - - - - - - - -
		$r['ext']	= JRequest::getVar( 'ext', '', 'get', 'string' );
		
		if ($r['ext'] == 'virtuemart') {
			// - - - - - - - - - - 
			// VirtueMart
			$context = 'com_phocaemail.vm.write.';
			$r['order_id']		= JRequest::getVar( 'order_id', '', 'get', 'string' );
			$r['delivery_id']	= JRequest::getVar( 'delivery_id', '', 'get', 'string');
			if (JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'phocapdf'.DS.'virtuemart'.DS.'virtuemarthelper.php')) {
				require_once(JPATH_ROOT.DS.'plugins'.DS.'phocapdf'.DS.'virtuemart'.DS.'virtuemarthelper.php');
			} else {
				return JError::raiseError('Error', 'Phoca PDF VirtueMart Plugin Helper file could not be found in system');
			}
			
			$d	= JRequest::get('request');
			$r	= PhocaPDFVirtueMartHelper::getDeliveryData($d, $r['order_id'], $r['delivery_id']);
			
			if($r['type'] == 'invoice') {
				$tmpl['attachment'][0]['file']		= $r['ainvoice'];
				$tmpl['attachment'][0]['checked']	= $r['ainvoicech'];
				$tmpl['attachment'][0]['pdf']		= 1;
			} else if ($r['type'] == 'receipt') {
				$tmpl['attachment'][0]['file']		= $r['areceipt'];
				$tmpl['attachment'][0]['checked']	= $r['areceiptch'];
				$tmpl['attachment'][0]['pdf']		= 1;
			}
			$tmpl['attachment'][1]['file']		= $r['adelnote'];
			$tmpl['attachment'][1]['checked']	= $r['adelnotech'];
			$tmpl['attachment'][1]['pdf']		= 1;
			
			$param['display_users_list'] 		= 0;
			$param['display_users_list_cc'] 	= 0;
			$param['display_users_list_bcc'] 	= 0;
			$param['display_select_article'] 	= 0;
			
		} else {
			// - - - - - - - - - -
			// Common
			$context = 'com_phocaemail.write.';
			$r['from'] 		= $app->getUserStateFromRequest( $context.'from', 'from', $user->email, 'string' );
			$r['fromname'] 	= $app->getUserStateFromRequest( $context.'fromname', 'fromname', $user->name, 'string' );
			$r['to'] 		= $app->getUserStateFromRequest( $context.'to', 'to', '', 'string' );
			$r['cc'] 		= $app->getUserStateFromRequest( $context.'cc', 'cc', '', 'string' );
			$r['bcc'] 		= $app->getUserStateFromRequest( $context.'bcc', 'bcc', '', 'string' );
			$r['subject'] 	= $app->getUserStateFromRequest( $context.'subject', 'subject', '', 'string' );
			$r['message'] 	= $app->getUserStateFromRequest( $context.'message', 'message', '', 'string' );
			// Option - can be disabled
			$r['article_id']= $app->getUserStateFromRequest( $context.'article_id', 'article_id', '', 'int' );
			$r['article_name']= $app->getUserStateFromRequest( $context.'article_name', 'article_name', JText::_('COM_PHOCAEMAIL_SELECT_ARTICLE'), 'string' );
			$r['togroups'] 	= $app->getUserStateFromRequest( $context.'togroups', 'togroups', '', 'array' );
			$r['tousers'] 	= $app->getUserStateFromRequest( $context.'tousers', 'tousers', '', 'array' );
			$r['ccusers'] 	= $app->getUserStateFromRequest( $context.'ccusers', 'ccusers', '', 'array' );
			$r['bccusers'] 	= $app->getUserStateFromRequest( $context.'bccusers', 'bccusers', '', 'array' );
		
			$tmpl['grouplist'] 		= PhocaEmailHelper::groupsList('togroups[]',$r['togroups'], '', true );
			$tmpl['userlist'] 		= PhocaEmailHelper::usersList('tousers[]',$r['tousers'],1, NULL,'name',0 );
			$tmpl['ccuserlist'] 	= PhocaEmailHelper::usersList('ccusers[]',$r['ccusers'],1, NULL,'name',0 );
			$tmpl['bccuserlist'] 	= PhocaEmailHelper::usersList('bccusers[]',$r['bccusers'],1, NULL,'name',0 );
			
			$attachment			= JFolder::files ($tmpl['path']['path_abs_nods'], '.', false, false, array('index.html'));
			if(!empty($attachment)) {
				foreach ($attachment as $key => $value){
					$tmpl['attachment'][$key]['file'] 		= $value;
					$tmpl['attachment'][$key]['checked'] 	= '';
					$tmpl['attachment'][$key]['pdf'] 		= 0;
				}
			}
			
			
		}

		$tmpl['editor'] 	=&JFactory::getEditor();
			
		$this->assignRef('tmpl',	$tmpl);
		$this->assignRef('r',	$r);
		$this->assignRef('param',	$param);
		$this->addToolbar();
		parent::display($tpl);
	}
	
	//protected function addToolbar() {
	function addToolbar() {
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'phocaemailwrite.php';

		$state	= $this->get('State');
		$canDo	= PhocaEmailWriteHelper::getActions();
		JToolBarHelper::title( JText::_( 'COM_PHOCAEMAIL_WRITE' ), 'write.png' );
		
		if ($canDo->get('core.admin')) {
			//JToolBarHelper::preferences('com_phocaemail');
			JToolBarHelper::custom( 'phocaemailwrite.send', 'email', '', 'COM_PHOCAEMAIL_SEND', false);
			JToolBarHelper::cancel( 'phocaemailwrite.cancel', 'COM_PHOCAEMAIL_CANCEL' );
			JToolBarHelper::divider();
		}
		
		JToolBarHelper::help( 'screen.phocaemail', true );
	}
}
?>