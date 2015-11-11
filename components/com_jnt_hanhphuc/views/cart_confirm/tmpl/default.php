<?php
/**
 * @version		$Id: default.php 21020 2011-03-27 06:52:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');

$paymentMethods = FrontJntHanhphucHelper::getPaymentMethods();
?>

<div class="container">
    <div class="float-left left-side">
		<div class="sub-container list-services shopping-cart relative">
			<h2>Thông tin giỏ hàng</h2>
			
			<div>
		    	<?php
		    	$items = $this->order->items;
		    	if($items):
		    	?>
		    	<table class="gridtable" width="650">
		    		<thead>
		    			<tr>
			    			<th>Dịch vụ</th>
			    			<th>Doanh nghiệp cung cấp</th>
			    			<th width="50" nowrap="nowrap">Số lượng</th>
			    			<th width="120">Giá</th>
		    			</tr>
		    		</thead>
		    		<tbody>
			    	<?php foreach($items as $item): ?>
			    		<tr>
			    			<td><?php echo $item->name?></td>
			    			<td><?php echo $item->businessProfile->business_name?></td>
			    			<td class="txt-right"><?php echo $item->qty?></td>
			    			<td class="txt-right"><?php echo $item->current_price?></td>
			    		</tr>
			    	<?php endforeach;?>
		    		</tbody>
		    	</table>
		    	<?php else:?>
		    		<p>Bạn chưa có sản phẩm nào trong giỏ hàng</p>
		    	<?php endif;?>
		    </div>
		    <div>
		    	<?php if($this->order->price > 0):?>
		    		Tổng giá: <?php echo $this->order->price?>
		    	<?php endif;?>
		    </div>
		    
		    <div class="clr"></div>
		    
		    <div>
		    	<h3>Hình thức thanh toán:</h3>
		    	<p><?php echo $this->payMethodName?></p>
		    </div>
		    <div>
		    	<h3>Thông tin thanh toán</h3>
		    	<div class="payment_method_info">
		    		<?php echo nl2br($paymentMethods->get('payment_method_' . $this->payMethod)); ?>
		    	</div>
		    	<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=order.confirm')?>" method="post">
		    		<input type="hidden" name="option" value="com_jnt_hanhphuc"/>
		    		<input type="hidden" name="task" value="order.confirm"/>
		    		<input class="button" type="submit" value="Xác nhận thanh toán"/>
		    	</form>
		    </div>
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
    </div>
</div>

<div class="clr"></div>
