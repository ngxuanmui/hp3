<?php
/**
 * @version		$Id: default_head.php 15 2011-09-02 18:37:15Z cristian $
 * @package		fieldsattach
 * @subpackage		Components
 * @copyright		Copyright (C) 2011 - 2020 Open Source Cristian Grañó, Inc. All rights reserved.
 * @author		Cristian Grañó
 * @link		http://joomlacode.org/gf/project/fieldsattach_1_6/
 * @license		License GNU General Public License version 2 or later
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
 
?>
<tr>
	<th width="1%" class="nowrap center hidden-phone">
		<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
	</th>
	<th width="5%">
		<?php echo JText::_("JPUBLISHED");?>
		<!-- <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'state', $listDirn, $listOrder); ?>-->
	</th>
	
	<th width="1%" class="hidden-phone">
		<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
	</th>		
	<th>
		<?php echo JText::_('COM_FIELDSATTACH_FIELDSATTACH_HEADING_TITLE'); ?>
	</th>
        <th>
		<?php echo JText::_('COM_FIELDSATTACH_FIELDSATTACH_HEADING_NOTE'); ?>
	</th> 
         
	<th width="1%" class="nowrap hidden-phone">
		<!-- <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>-->
		<?php echo JText::_("JGRID_HEADING_ID");?>
	</th>
</tr>

