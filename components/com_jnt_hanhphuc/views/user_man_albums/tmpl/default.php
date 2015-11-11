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
							<th>Tiêu đề</th>
							<th>Danh mục</th>
							<th>Trạng thái</th>
						</tr>
						<?php foreach ($items as $key => $item): ?>
						<tr class="<?php if (($key+1) %2 == 0) echo 'oven' ?>">
							<td>
								<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=user_man_album.edit&id='. $item->id . '&Itemid=' . JRequest::getInt('Itemid'), false); ?>">
									<?php echo $item->name; ?>
								</a>
							</td>
							<td><?php echo $item->category_title; ?></td>
							<td><?php echo ($item->state == 1) ? 'Yes' : 'No'; ?></td>
						</tr>
						<?php endforeach; ?>
						<tr>
							<td colspan="5">							
							</td>
						</tr>
					</table>
					<div class="clear">
						<div class="pagination fltleft" style="background: #fff;"><?php echo $this->pagination->getPagesLinks();//$this->pagination->getListFooter(); ?></div>
						<div class="fltright">
							<input type="hidden" name="task" value="" />
							<?php echo JHtml::_('form.token'); ?>
							<?php echo HP_User_Toolbar::buttonList('user_man_album'); ?>
						</div>
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