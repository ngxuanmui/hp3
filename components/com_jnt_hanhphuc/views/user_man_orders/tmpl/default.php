<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jnt_hanhphuc
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

$items = $this->items;
?>

<div class="container">
    <div class="float-left left-side">
		<div class="sub-container list-items relative">
			<div class="list-items-container" style="padding: 10px 0; margin-top: 0">
				<form method="post" action="<?php echo ''; ?>" name="userForm">
					<table class="list-user-hotels" cellpadding="10" border="0" cellspacing="0" width="98%">
						<tr class="oven">
							<th>Order ID</th>
							<th>Khách hàng</th>
							<th>Ngày lập</th>
							<th>Tổng tiền</th>
							<th>Trạng thái</th>
						</tr>
						<?php foreach ($items as $key => $item): ?>
						<tr class="<?php if (($key+1) %2 == 0) echo 'oven' ?>">
							<td>
								<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=user_man_order_items&order_id='. $item->order_id . '&Itemid=' . JRequest::getInt('Itemid'), false); ?>">
									<?php echo $item->order_id; ?>
								</a>
							</td>
							<td><?php echo $item->user_created; ?></td>
							<td><?php echo $item->created; ?></td>
							<td><?php echo number_format($item->private_order_price) . ' VNĐ'; ?></td>
							<td><?php echo ($item->order_state == 1) ? 'Yes' : 'No'; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="clear">
						<div class="pagination fltleft" style="background: #fff;"><?php echo $this->pagination->getPagesLinks();//$this->pagination->getListFooter(); ?></div>
						
						<div class="clear"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
	</div>
</div>

<div class="clear"></div>