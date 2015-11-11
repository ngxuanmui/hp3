<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jnt_hanhphuc
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined ( '_JEXEC' ) or die ();

JHtml::addIncludePath ( JPATH_COMPONENT . '/helpers/html' );

$items = $this->items;

$firstItem = NULL;

if (is_array ( $items ))
	$firstItem = $items [0];

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
					<li>
						<span>Phương thức thanh toán</span>: <?php echo $firstItem->payment_method_name; ?></li>
					<li>
						<span>Địa chỉ</span>: <?php echo $firstItem->address; ?></li>
					<li>
						<span>Quận/Huyện</span>: <?php echo $firstItem->district; ?></li>
					<li>
						<span>Tỉnh/Thành</span>: <?php echo $firstItem->city; ?></li>
					<li>
						<span>Điện thoại</span>: <?php echo $firstItem->phone; ?></li>
					<li>
						<span>Email</span>: <a
							href="mailto:<?php echo $firstItem->email; ?>"><?php echo $firstItem->email; ?></a>
					</li>
				</ul>
				</div>
				<?php endif; ?>
			</div>
			
			<div class="sub-container list-items relative">
				<h2 class="txt-order-info">Thông tin đơn hàng</h2>
				<div class="list-items-container"
					style="margin-top: 0">
					<form method="post"
						action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=order.confirm_delivered'); ?>"
						name="userForm" enctype="multipart/form-data">
				    <?php $totalPrice = 0; ?>
				    <table class="list-user-hotels" cellpadding="10" border="0"
							cellspacing="0" width="623">
							<tr class="oven">
								<th>#</th>
								<th>Dịch vụ</th>
								<th>Số lượng</th>
								<th>Giá tiền</th>
								<th>Thành tiền</th>
								<th>Chuyển hàng</th>
							</tr>
					<?php foreach ($items as $key => $item): ?>
		    			<tr class="<?php if (($key + 1) % 2 == 0) echo 'oven' ?>">
								<td>
						    <?php echo $key + 1; ?>
		    			    </td>
								<td><?php echo $item->service_name; ?></td>
								<td><?php echo $item->qty; ?></td>
								<td><?php echo number_format($item->price) . ' VNĐ'; ?></td>
								<td>
						<?php
						$price = $item->qty * $item->price;
						
						$totalPrice += $price;
						
						echo number_format ( $price ) . ' VNĐ';
						?>
					    </td>
								<td>
						    <?php if ($item->delivered == 1): ?>
							Đã chuyển
							
						 <?php else :
							$allowDelivered = true;
						?>
							<input type="checkbox" name="delivered[]"
									value="<?php echo $item->id; ?>" />
						    <?php endif; ?>
		    			    </td>
						</tr>
					<?php endforeach; ?>
					
						<tr>
							<td colspan="10">Tổng thành tiền: <?php echo number_format($totalPrice) . ' VNĐ'; ?></td>
						</tr>
						</table>
						
					<div class="deliver-state">
					<h2>Thông tin giao hàng</h2>
					
					<div class="deliver-info-container">
				    
				    <?php if (!empty($this->files)): ?>
				    <div class="file-uploaded">
							<h3>File đã upload</h3>
	
							<ul>
					    <?php foreach ($this->files as $file): ?>
					    <li><strong>File</strong>: <a target="_blank"
									href="<?php echo JURI::root() . 'upload/orders/' . $firstItem->order_id . '/' . $file->file_upload; ?>">
						    <?php echo $file->file_upload; ?>
						</a>
						<?php if (!empty($file->description)): ?>
						<br>
						<strong>Chú thích</strong>: <?php echo $file->description; ?>
						<?php endif; ?>
					    </li>
					    <?php endforeach; ?>
					</ul>
	
						</div>
				    <?php endif; ?>
				    
				    
				    <?php if (!empty($this->notes)): ?>
				    <div>
							<h3>Ghi chú</h3>
	
							<ul class="noted">
					    <?php foreach ($this->notes as $note): ?>
					    <li><?php echo $note->note; ?></li>
					    <?php endforeach; ?>
					</ul>
	
						</div>
				    <?php endif; ?>
				    
				    <div class="upload-file">
							<div>
								<label>Upload file:</label> <input type="file" name="jform[file_upload]" />
							</div>
							<div>
								<label>Chú thích:</label> <input type="text" name="description" />
							</div>
							<div><label>Ghi chú:</label>
							
							<textarea name="business_note"></textarea>
							
							</div>
							
							<div class="clear"></div>
							
							<div class="pagination fltleft" style="background: #fff;"><?php echo $this->pagination->getPagesLinks(); //$this->pagination->getListFooter();  ?></div>
						</div>
				    </div>
				    
				    
				    </div>
				    
				    <div class="clear">
							<input type="hidden" name="order_id"
								value="<?php echo JRequest::getInt('order_id'); ?>" />
					<?php /*if ($allowDelivered):*/ ?>
		    			<input type="submit" name="btn-confirm" value="Cập nhật" class="btn-update" />
		    			| 
					<?php /*endif;*/ ?>
					<a
								href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=user_man_orders', false); ?>">Quản
								lý Đơn hàng</a>
							<div class="clear"></div>
						</div>
					</form>
				</div>
			</div>
			
		</div>

		
		<div class="clear"></div>
	</div>
</div>
<div class="float-right right-side">
	<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
    </div>
</div>

<div class="clear"></div>
