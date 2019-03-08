<?php
/**
 *
 * Modify user form view
 *
 * @package	VirtueMart
 * @subpackage User
 * @author Oscar van Eijk
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit.php 6472 2012-09-19 08:46:21Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

//AdminMenuHelper::startAdminArea($this);
// Implement Joomla's form validation
JHTML::_('behavior.formvalidation');
JHTML::stylesheet('vmpanels.css', JURI::root() . 'components/com_virtuemart/assets/css/'); // VM_THEMEURL
?>

<style type="text/css">
    .invalid {
        border-color: #f00;
        background-color: #ffd;
        color: #000;
    }
    label.invalid {
        background-color: #fff;
        color: #f00;
    }
</style>
<script language="javascript">
    function myValidator(f, t) {
        f.task.value = t;
        if (document.formvalidator.isValid(f)) {
            f.submit();
            //We must return here false, to prevent that the form is sent again. We cannot just return true without using f.submit, because then the task is not set
            return false;
        } else {
            var msg = '<?php echo addslashes(JText::_('COM_VIRTUEMART_USER_FORM_MISSING_REQUIRED_JS')); ?>';
            alert(msg);
        }
        return false;
    }
    function callValidatorForRegister(f, t) {

        var elem = jQuery('#username_field');
        elem.attr('class', "required");

        var elem = jQuery('#name_field');
        elem.attr('class', "required");
<?php if ($this->userDetails->JUser->guest) { ?>
            var elem = jQuery('#password_field');
            elem.attr('class', "required");

            var elem = jQuery('#password2_field');
            elem.attr('class', "required");
<?php } ?>
        return myValidator(f, t);
    }

</script>
<div class="container">
    <div class="row" style="margin-top:2%;">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h3><?php echo $this->page_title ?></h3>
        </div>
    </div>
</div>

<?php
if ($this->userDetails->virtuemart_user_id == 0) {
    echo shopFunctionsF::getLoginForm(false);
}
?>
<?php
$session = JFactory::getSession();
?>
<h2><?php
if ($this->userDetails->virtuemart_user_id == 0) {

    echo JText::_('COM_VIRTUEMART_YOUR_ACCOUNT_REG');
}
?></h2>
<form method="post" id="adminForm" name="userForm" action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=user', $this->useXHTML, $this->useSSL) ?>" class="form-validate">
    <?php if (1) { ?>

        <?php
        // Loading Templates in Tabs
//if($this->userDetails->virtuemart_user_id!=0) {

        if (1) { // do NOT delete this
            $tabarray = array();
            if ($this->userDetails->user_is_vendor) {
                if (!empty($this->add_product_link)) {
                    echo $this->add_product_link;
                }
                $tabarray['vendor'] = 'COM_VIRTUEMART_VENDOR';
            }


            $tabarray['shopper'] = 'COM_VIRTUEMART_SHOPPER_FORM_LBL';
            //$tabarray['user'] = 'COM_VIRTUEMART_USER_FORM_TAB_GENERALINFO';
            if (!empty($this->shipto)) {
                $tabarray['shipto'] = 'COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL';
            }
            if (($_ordcnt = count($this->orderlist)) > 0) {
                $tabarray['orderlist'] = 'COM_VIRTUEMART_YOUR_ORDERS';
            }
            echo '<div style="font-size:15px; margin-left:4vw; color:#eb4800"><i class="fa fa-paper-plane" aria-hidden="true"></i>' . $this->lists['shipTo'] . '</div>';

            shopFunctionsF::buildTabs($this, $tabarray);
        } else {
            echo $this->loadTemplate('shopper');
        }
        ?>
        <!--<div class="container" style="margin:20px;">
                <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                                <div class="buttonBar-right" style="text-align:center; padding:10px;">
                                <button class="btn btn-primary btn-block no-border-radius" style="background:#eb4800;" type="submit" onclick="javascript:return callValidatorForRegister(userForm, 'saveUser');" ><?php echo $this->button_lbl ?></button>
                                </div>
                                <div class="buttonBar-right" style="text-align:center; padding:10px;">
                                <button class="btn btn-primary btn-block no-border-radius" style="background:#eb4800;" type="reset" onclick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=user', FALSE); ?>'" ><?php echo JText::_('COM_VIRTUEMART_CANCEL'); ?></button>
                                </div>
<?php } ?>
                            <div class="buttonBar-right" style="text-align:center; padding:10px;">
                            <button class="btn btn-primary btn-block no-border-radius" style="background:#eb4800;" onclick="window.location.replace('<?php echo $session->get('last_url'); ?>'); return false;" ><?php echo jText::_("NC_VOLTAR") ?></button>
                            </div>
    
                    </div>
                    <div class="col-md-4"></div>
            </div>
    </div>//-->


</div>
</div>
<?php
// captcha addition
if (VmConfig::get('reg_captcha')) {
    JHTML::_('behavior.framework');
    JPluginHelper::importPlugin('captcha');
    $dispatcher = JDispatcher::getInstance();
    $dispatcher->trigger('onInit', 'dynamic_recaptcha_1');
    ?>
    <div id="dynamic_recaptcha_1"></div>
    <?php
}
// end of captcha addition
?>
<input type="hidden" name="option" value="com_virtuemart" />
<input type="hidden" name="controller" value="user" />
<?php echo JHTML::_('form.token'); ?>
</form>
