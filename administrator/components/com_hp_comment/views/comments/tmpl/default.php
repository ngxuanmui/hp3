<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_hp_comment
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= $user->authorise('core.edit.state', 'com_hp_comment.category');
$saveOrder	= $listOrder=='ordering';
$params		= (isset($this->state->params)) ? $this->state->params : new JObject();
?>
<form action="<?php echo JRoute::_('index.php?option=com_hp_comment&view=comments'); ?>" method="post" name="adminForm" id="adminForm">
	<div id="j-main-container" class="span12">
		<?php
		// Search tools bar
		#echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
		?>
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php else : ?>
			<table class="table table-striped" id="articleList">
				<thead>
					<tr>
						<th width="1%">
							<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
						</th>
						<th>
							<?php echo JHtml::_('grid.sort',  'Content', 'a.content', $listDirn, $listOrder); ?>
						</th>
						<th width="5%">
							<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
						</th>
						<th width="5%" nowrap="nowrap">
							Comment Type
						</th>
						<th width="30%" nowrap="nowrap">
							Comment For
						</th>
						<th width="5%" nowrap="nowrap">
							Created by
						</th>
						<th width="1%" class="nowrap">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="13">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) :
					$ordering	= ($listOrder == 'ordering');
					$canCreate	= $user->authorise('core.create',		'');
					$canEdit	= $user->authorise('core.edit',			'');
					$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
					$canChange	= $user->authorise('core.edit.state',	'') && $canCheckin;
					?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="center">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<td>
							<?php if ($item->checked_out) : ?>
								<?php echo JHtml::_('jgrid.checkedout', $i, null, $item->checked_out_time, 'comments.', $canCheckin); ?>
							<?php endif; ?>
							<?php if ($canEdit) : ?>
								<a href="<?php echo JRoute::_('index.php?option=com_hp_comment&task=comment.edit&id='.(int) $item->id); ?>">
									<?php echo $this->escape($item->content); ?></a>
							<?php else : ?>
									<?php echo $this->escape($item->content); ?>
							<?php endif; ?>
							
								<?php
								$sub = $item->sub;
								
								if (!empty($sub)):
								?>
								<ul style="margin-left: 0px;">
									<?php foreach ($sub as $sub_item): ?>
									<li>
										<?php echo $sub_item->content; ?>
									</li>
									<?php endforeach; ?>
								</ul>
								<?php endif; ?>
						</td>
						<td class="center">
							<?php echo JHtml::_('jgrid.published', $item->state, $i, 'comments.', $canChange, 'cb', null, null); ?>
						</td>
						<td>
							<?php echo $item->item_type; ?>
						</td>
						<td>
							<?php echo $item->comment_for; ?>
						</td>
						<td class="left" nowrap="nowrap">
							<?php echo $item->author_name; ?>
						</td>
						<td class="center">
							<?php echo $item->id; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
</form>
