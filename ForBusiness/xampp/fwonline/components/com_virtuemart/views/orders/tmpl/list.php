<?php
   /**
   *
   * Orderlist
   * NOTE: This is a copy of the edit_orderlist template from the user-view (which in turn is a slighly
   *       modified copy from the backend)
   *
   * @package	VirtueMart
   * @subpackage Orders
   * @author Oscar van Eijk
   * @link http://www.virtuemart.net
   * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
   * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
   * VirtueMart is free software. This version may have been modified pursuant
   * to the GNU General Public License, and as distributed it includes or
   * is derivative of works licensed under the GNU General Public License or
   * other free or open source software licenses.
   * @version $Id: list.php 5434 2012-02-14 07:59:10Z electrocity $
   */

   // Check to ensure this file is included in Joomla!
   defined('_JEXEC') or die('Restricted access');
   ?>
<div class="container">
  <br><br>
    
    <div class="row justify-content-center">
    
        <div class="col-xs-12">
        
             <h2 class="elipse-border-bottom" style="text-align:center; width:100%; padding-bottom:15px;padding-top:2%;"><?php echo JText::_('COM_VIRTUEMART_ORDERS_VIEW_DEFAULT_TITLE'); ?></h2>
            
        
        </div>
        
        
    </div>
  <br>
   <br>
   <div>
      <?php
         if (count($this->orderlist) == 0) {
         	//echo JText::_('COM_VIRTUEMART_ACC_NO_ORDER');
         	 echo shopFunctionsF::getLoginForm(false,true);
         } else {
          ?>
      <div class="row">
				<div class="col-md-1"></div>
         <div class="col-md-10">
            <div id="editcell">
               <table class=" table table-responsive" width="100%">
                  <thead>
                     <tr>
                        <th>
                           <?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_ORDER_NUMBER'); ?>
                        </th>
                        <th>
                           <?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_CDATE'); ?>
                        </th>
                        <th>
                           <?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_MDATE'); ?>
                        </th>
                        <th>
                           <?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_STATUS'); ?>
                        </th>
                        <th>
                           <?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_TRACKING'); ?>
                        </th> 
                        <th>
                           <?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_TOTAL'); ?>
                        </th>
                  </thead>
                  <?php
                     $k = 0;
                     foreach ($this->orderlist as $row) {
                     	$editlink = JRoute::_('index.php?option=com_virtuemart&view=orders&layout=details&order_number=' . $row->order_number, FALSE);
                     	?>
                  <tr class="<?php echo "row$k"; ?>">
                     <td align="left">
                        <a href="<?php echo $editlink; ?>" rel="nofollow"><?php echo $row->order_number; ?></a>
                     </td>
                     <td align="left">
                        <?php echo vmJsApi::date($row->created_on,'LC4',true); ?>
                     </td>
                      
                      <td align="left">
					       <?php echo JHTML::_('date', $row->modified_on); ?>
				      </td>
                     <td align="left">
                        <?php echo ShopFunctions::getOrderStatusName($row->order_status); ?>
                     </td>
                      
                      <td align="left">
					    <?php echo $row->order_tracking; ?>
				      </td>
                     <td align="left">
                        <?php echo $this->currency->priceDisplay($row->order_total, $row->currency); ?>
                     </td>
                  </tr>
                  <?php
                     $k = 1 - $k;
                     }
                     ?>
               </table>
            </div>
         </div>
				 <div class="col-md-1"></div>
      </div>
   </div>
</div>
<?php } ?>
