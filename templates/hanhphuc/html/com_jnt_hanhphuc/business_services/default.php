<?php
/**
 * @version		$Id: default.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$businessInfo = $this->businessInfo;
?>

    <div class="float-left left-side">
		<div class="sub-container">
			<p class="search-text">Quản lý dịch vụ</p>
			<div class="line-break-search">
				<span></span>
			</div>
			
			<table class="user-gridtable" style="width: 100%; margin: 10px 0;">
				<tr>
					<th>#</th>
					<th>Tiêu đề</th>
					<th>Tóm tắt</th>
					<th>Thao tác</th>
				</tr>
				<?php if($this->items):?>
				<?php foreach($this->items as $key => $item):?>
				<tr>
					<td><?php echo $key + 1; ?></td>
					<td>
						<strong><?php echo $item->name . ' ('. $item->cat_title . ')'; ?></strong>
					</td>
					<td><?php echo JHtml::_('string.truncate', strip_tags($item->description), 200); ?></td>
					<td>
						<a href = "<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=business_service&layout=edit&id='.$item->id) ?>">Chỉnh sửa</a>
						|
						<a href="#">Xóa</a>
					</td>
				</tr>
				<?php endforeach;?>
				<tr>
					<td colspan="5">
						<?php echo $this->pagination->getPagesLinks()?>
					</td>
				</tr>
				<?php else:?>
				<tr>
					<td colspan="5">Bạn chưa có dịch vụ nào trên website hanhphuc.vn</td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="5">
						<a href = "<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=business_service.add') ?>">Add news</a>
					</td>
				</tr>
			</table>
			
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
	</div>	
	<div class="clr"></div>
