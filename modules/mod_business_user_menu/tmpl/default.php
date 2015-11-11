<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_business_user_menu
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$user = JFactory::getUser();
?>

<ul class="menu business-user-menu">
	<li class="item-238">
		<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=services&user='.$user->id.'-'.$user->username, false); ?>">
			Xem trang Nhà cung cấp
		</a>
	</li>
	<li class="item-238">
		<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&amp;view=intro&amp;layout=edit', false); ?>">
			Giới thiệu doanh nghiệp
		</a>
	</li>
	<li class="item-239">
		<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&amp;view=business_services', false); ?>">
			Quản lý Dịch vụ
		</a>
	</li>
	<li class="item-244">
		<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&amp;view=user_man_albums', false); ?>">
			Album ảnh
		</a>
	</li>
	<li class="item-244">
		<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&amp;view=user_man_online_nicks&layout=edit', false); ?>">
			Quản lý tài khoản chát Online
		</a>
	</li>
	<li class="item-244">
		<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&amp;view=user_man_contents', false); ?>">
			Quản lý tin khuyến mại
		</a>
	</li>
	<li class="item-244">
		<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&amp;view=user_man_comments', false); ?>">
			Quản lý bình luận
		</a>
	</li>
	<li class="item-244">
		<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&amp;view=user_man_orders', false); ?>">
			Quản lý Đơn hàng
		</a>
	</li>	
	<li class="item-244">
		<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&amp;view=user_man_addresses', false); ?>">
			Quản lý Địa chỉ
		</a>
	</li>
</ul>
