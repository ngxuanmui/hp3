<?php
/**
 * @version		$Id: default.php 21020 2011-03-27 06:52:01Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('script','system/multiselect.js',false,true);

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= true;
$saveOrder	= $listOrder=='ordering';
?>
<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=orders'); ?>" method="post" name="adminForm" id="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php
		// Search tools bar
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
		?>
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php else : ?>

			<table class="table table-striped">
				<thead>
					<tr>
						<th width="1%">
							<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
						</th>
						<th width="5%">
							<?php echo JHtml::_('searchtools.sort',  'ID', 'id', $listDirn, $listOrder); ?>
						</th>
						<th width="5%">
							<?php echo JHtml::_('searchtools.sort', 'User', 'username', $listDirn, $listOrder); ?>
						</th>
						<th width="5%">
							<?php echo JHtml::_('searchtools.sort', 'Total Price', 'total_price', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap">
							<?php echo JHtml::_('searchtools.sort', 'Current Price', 'price', $listDirn, $listOrder); ?>
						</th>
						<th width="10%">
							<?php echo JHtml::_('searchtools.sort', 'Pay method', 'payment_method_name', $listDirn, $listOrder); ?>
						</th>
						<th width="5%">
							<?php echo JHtml::_('searchtools.sort', 'State', 'state', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap">
							<?php echo JHtml::_('searchtools.sort', 'Created', 'created_by', $listDirn, $listOrder); ?>
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
					$canCreate	= true;
					$canEdit	= true;
					$canCheckin	= true;
					$canChange	= true;
					?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="center">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<td>
						    <?php if ($item->checked_out) : ?>
								<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out, 'orders.', $canCheckin); ?>
							<?php endif; ?>
							<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=order.edit&id='.(int) $item->id); ?>">
								Order: <?php echo $this->escape($item->id); ?></a>
						</td>
						<td class="center">
							<?php echo $item->username;?>
						</td>
						<td class="center">
							<?php echo number_format($item->total_price);?>
						</td>
						<td class="center">
							<?php echo number_format($item->price);?>
						</td>
						<td class="center">
							<?php echo $item->payment_method_name;?>
						</td>
						<td class="center">
						    <?php if ($item->count_items == $item->count_delivered_items && $item->state != 1): ?>
							<?php echo JHtml::_('jgrid.published', $item->state, $i, 'orders.', $canChange, 'cb'); ?>
						    <?php elseif ($item->state == 1): ?>
							Done
						    <?php endif; ?>
						</td>
						<td class="center">
							<?php echo $item->username;?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

	<?php endif; ?>
		
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	
	</div>
</form>
