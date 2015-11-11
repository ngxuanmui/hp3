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
$archived	= $this->state->get('filter.state') == 2 ? true : false;
$trashed	= $this->state->get('filter.state') == -2 ? true : false;
?>
<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=services'); ?>" method="post" name="adminForm" id="adminForm">
	
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
						<th width="1%" class="center">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th width="1%" class="nowrap center">
							<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 's.state', $listDirn, $listOrder); ?>
						</th>
		                <th>
		                    <?php echo JHtml::_('searchtools.sort', 'Name', 'name', $listDirn, $listOrder); ?>
		                </th>
						<th width="15%">
							<?php echo JHtml::_('searchtools.sort', 'Category', 'c.title', $listDirn, $listOrder); ?>
						</th>
						<th width="5%">
							<?php echo JHtml::_('searchtools.sort', 'User', 'username', $listDirn, $listOrder); ?>
						</th>
						<th width="5%" class="nowrap">
							<?php echo JHtml::_('searchtools.sort', 'Price', 'price', $listDirn, $listOrder); ?>
						</th>
						<th width="5%" class="nowrap">
							<?php echo JHtml::_('searchtools.sort', 'Current price', 'current_price', $listDirn, $listOrder); ?>
						</th>
		                <th width="10%">
		                    <?php echo JHtml::_('searchtools.sort', 'Promotion', 'promotion', $listDirn, $listOrder); ?>
		                </th>
						<th width="1%" class="nowrap hidden-phone">
							<?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 's.id', $listDirn, $listOrder); ?>
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
						<td class="center">
							<div class="btn-group">
								<?php echo JHtml::_('jgrid.published', $item->state, $i, 'services.', $canChange, 'cb', null, null); ?>
								<?php
								// Create dropdown items
								$action = $archived ? 'unarchive' : 'archive';
								JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'services');

								$action = $trashed ? 'untrash' : 'trash';
								JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'services');

								// Render dropdown list
								echo JHtml::_('actionsdropdown.render', $this->escape($item->name));
								?>
							</div>
						</td>
						<td class="left">
							<a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=service.edit&id='.(int) $item->id); ?>">
								<?php echo $item->name;?>
							</a>
						</td>
						<td class="left nowrap">
							<?php echo $item->category;?>
						</td>
						<td class="left">
							<?php echo $item->username;?>
						</td>
						<td class="right nowrap" style="text-align: right;">
							<?php echo number_format($item->price);?>
						</td>
		                <td class="right nowrap" style="text-align: right;">
		                    <?php echo number_format($item->current_price);?>
		                </td>
		                <td class="left">
		                    <?php echo $item->promotion;?>
		                </td>
						<td class="center hidden-phone">
							<?php echo (int) $item->id; ?>
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
