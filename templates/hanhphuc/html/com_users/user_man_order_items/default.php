<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

$items = $this->items;

$firstItem = NULL;

if (is_array($items))
    $firstItem = $items[0];

$allowDelivered = false;

?>

<div class="container">
    <div class="float-left left-side">
    
    <h2 class="new-h2">Quản lý đơn hàng</h2>

		<div class="new-container">
			<div class="customer-info">
				<h2>Thông tin người mua</h2>
				<div class="customer-container">
				<?php if (isset($firstItem)): ?>
				<ul>
			    	<li>
						<span>Order ID</span>: <?php echo $firstItem->order_id; ?></li>
					<li>
						<span>Khách hàng</span>: <?php echo $firstItem->user_created; ?></li>
				</ul>
				</div>
				<?php endif; ?>
			</div>
	    
			<div class="sub-container list-items relative">
				<div class="list-items-container" style="padding: 10px 0; margin-top: 0">
				    <form method="post" action="<?php echo JRoute::_('index.php?option=com_users&task=order.confirm_delivered'); ?>" name="userForm">
						<table class="list-user-hotels" cellpadding="10" border="0" cellspacing="0" width="98%">
							<tr class="oven">
								<th>#</th>
								<th>Dịch vụ</th>
								<th>Doanh nghiệp</th>
								<th>Chuyển hàng</th>
							</tr>
							<?php foreach ($items as $key => $item): ?>
							<tr class="<?php if (($key+1) %2 == 0) echo 'oven' ?>">
								<td>
									<?php echo $key + 1; ?>
								</td>
								<td><?php echo $item->service_name; ?></td>
								<td><?php echo $item->user_business_name; ?></td>
								<td>
								    <?php if ($item->delivered == 1): ?>
								    Đã chuyển
								    <?php else: ?>
								    Chưa chuyển
								    <?php endif; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</table>
						<div class="clear">
							<div class="pagination fltleft" style="background: #fff;"><?php echo $this->pagination->getPagesLinks();//$this->pagination->getListFooter(); ?></div>
							<a href="<?php echo JRoute::_('index.php?option=com_users&view=user_man_orders', false); ?>" style="display: block; margin: 10px 0 0 50px;">Quản lý Đơn hàng</a>
							<div class="clear"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
	</div>
</div>

<div class="clear"></div>