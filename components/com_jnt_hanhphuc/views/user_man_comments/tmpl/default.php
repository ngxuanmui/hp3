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

$arrItems = array('article' => 'Tin khuyến mại', 'service' => 'Sản phẩm', 'user' => 'Doanh nghiệp');

?>

<div class="container">
    <div class="float-left left-side">
		<div class="sub-container list-items relative">
			<div class="list-items-container" style="padding: 10px 0; margin-top: 0">
				<form method="post" action="<?php echo ''; ?>" name="userForm">
					<table class="gridtable" cellpadding="10" border="0" cellspacing="0" width="98%">
						<tr class="oven">
							<th>Tiêu đề</th>
							<th width="1%" nowrap="nowrap">Trạng thái</th>
						</tr>
						<?php if (!empty($items)): ?>
						<?php
						foreach ($items as $key => $item):
							$itemType = $item->item_type;
							
							switch ($itemType)
							{
								case 'article':
									$link = JRoute::_('index.php?option=com_jnt_hanhphuc&view=article&id=' . $item->item_id . ':' . $item->comment_alias);
									break;
									
								case 'service':
									$link = JRoute::_('index.php?option=com_jnt_hanhphuc&view=service&bid=' . $item->item_id);
									break;
							
								default:
									$link = JRoute::_('index.php?option=com_jnt_hanhphuc&view=services&user='.$item->item_id.'-'.$item->comment_alias);
									break;
							}
						?>
						<tr class="<?php if (($key+1) %2 == 0) echo 'oven' ?>">
							<td>
								<div>
									Bình luận trong: <?php echo $arrItems[$item->item_type]; ?>
									(<a href="<?php echo $link; ?>">
										<?php echo $item->comment_for; ?>
									</a>)
								</div>
								<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=user_man_comment.edit&id='. $item->id . '&Itemid=' . JRequest::getInt('Itemid'), false); ?>">
									<?php echo $item->content; ?>
								</a>
								<?php
								$sub = $item->sub;
								
								if (!empty($sub)):
								?>
								<ul style="margin-left: 20px;">
									<?php foreach ($sub as $sub_item): ?>
									<li>
										<?php echo $sub_item->content; ?>
									</li>
									<?php endforeach; ?>
								</ul>
								<?php endif; ?>
							</td>
							<td><?php echo ($item->state == 1) ? 'Yes' : 'No'; ?></td>
						</tr>
						<?php endforeach; ?>
						<?php else: ?>
						<tr>
							<td colspan="5">
								Chưa có bình luận nào
							</td>
						</tr>
						<?php endif; ?>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
	</div>
</div>

<div class="clear"></div>