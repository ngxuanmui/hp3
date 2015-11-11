<?php
/**
 * @version		$Id: edit.php 20649 2011-02-10 09:15:04Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access.
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
    Joomla.submitbutton = function(task)
    {
	if (task == 'banner.cancel' || document.formvalidator.isValid(document.id('banner-form'))) {
	    Joomla.submitform(task, document.getElementById('banner-form'));
	}
    }
    window.addEvent('domready', function() {
	document.id('jform_type0').addEvent('click', function(e) {
	    document.id('image').setStyle('display', 'block');
	    document.id('url').setStyle('display', 'block');
	    document.id('custom').setStyle('display', 'none');
	});
	document.id('jform_type1').addEvent('click', function(e) {
	    document.id('image').setStyle('display', 'none');
	    document.id('url').setStyle('display', 'block');
	    document.id('custom').setStyle('display', 'block');
	});
	if (document.id('jform_type0').checked == true) {
	    document.id('jform_type0').fireEvent('click');
	} else {
	    document.id('jform_type1').fireEvent('click');
	}
    });
</script>

<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=order&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="banner-form" class="form-validate">
    <div class="width-60 fltlft">
	<fieldset class="adminform">
	    <legend><?php echo empty($this->item->id) ? JText::_('Order detail') : JText::sprintf('Order detail %d', $this->item->id); ?></legend>
	    <ul class="adminformlist">
		<li><?php echo $this->form->getLabel('id'); ?>
		    <?php echo $this->form->getInput('id'); ?></li>

		<li><?php echo $this->form->getLabel('user_id'); ?>
		    <?php echo $this->form->getInput('user_id'); ?></li>

		<li><?php echo $this->form->getLabel('username'); ?>
		    <?php echo $this->form->getInput('username'); ?></li>

		<li><?php echo $this->form->getLabel('total_price'); ?>
		    <?php echo $this->form->getInput('total_price'); ?></li>

		<li><?php echo $this->form->getLabel('price'); ?>
		    <?php echo $this->form->getInput('price'); ?></li>

		<li><?php echo $this->form->getLabel('payment_method'); ?>
		    <?php echo $this->form->getInput('payment_method'); ?></li>

		<li><?php echo $this->form->getLabel('address'); ?>
		    <?php echo $this->form->getInput('address'); ?></li>

		<li><?php echo $this->form->getLabel('district'); ?>
		    <?php echo $this->form->getInput('district'); ?></li>

		<li><?php echo $this->form->getLabel('city'); ?>
		    <?php echo $this->form->getInput('city'); ?></li>

		<li><?php echo $this->form->getLabel('ipaddress'); ?>
		    <?php echo $this->form->getInput('ipaddress'); ?></li> 

	    </ul>
	    <div class="clr"> </div>

	</fieldset>
    </div>

    <div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start', 'order-sliders-' . $this->item->id, array('useCookie' => 1)); ?>

	<?php echo JHtml::_('sliders.panel', JText::_('Order state'), 'publishing-details'); ?>
	<fieldset class="panelform">
	    <ul class="adminformlist">

		<li><?php echo $this->form->getLabel('state'); ?>
		    <?php echo $this->form->getInput('state'); ?></li>

		<li><?php echo $this->form->getLabel('created'); ?>
		    <?php echo $this->form->getInput('created'); ?></li>
	    </ul>
	</fieldset>

	<?php echo JHtml::_('sliders.panel', JText::_('Order items'), 'order_items'); ?>
	<div>
	    <table class="adminlist">
		<thead>
		    <tr>
			<th>Service</th>
			<th>Business name</th>
			<th>Qty</th>
			<th>Origin price</th>
			<th>Price</th>
			<th>Delivered</th>
		    </tr>
		</thead>
		<tbody>
		    <?php foreach ($this->orderItems as $item): ?>
    		    <tr>
    			<td><?php echo $item->service_name ?></td>
    			<td><?php echo $item->business_name ?></td>
    			<td><?php echo $item->qty ?></td>
    			<td><?php echo $item->origin_price ?></td>
    			<td><?php echo $item->price ?></td>
    			<td>
				<?php $checked = ($item->delivered == 1) ? 'checked="checked"' : ''; ?>
    			    <input type="checkbox" name="delivered[<?php echo $item->id; ?>]" value="<?php echo $item->id; ?>" <?php echo $checked; ?> />
    			    <input type="hidden" name="item_delivered[<?php echo $item->id; ?>]" value="<?php echo $item->id; ?>" />
    			</td>
    		    </tr>
		    <?php endforeach; ?>
		</tbody>
	    </table>
	</div>
	
	<?php if (!empty($this->files)): ?>
	
	<?php echo JHtml::_('sliders.panel', JText::_('Files uploaded'), 'files_upload'); ?>
	
	<div>
	    <table>
		<tr>
		    <th>Del</th>
		    <th>File</th>
		</tr>
		<?php foreach ($this->files as $file): ?>
		<tr>
		    <td>
			<input type="checkbox" name="del_file" />
		    </td>
		    <td>
			File: 
			<a target="_blank" href="<?php echo JURI::root() . 'upload/orders/' . $firstItem->order_id . '/' . $file->file_upload; ?>">
			    <?php echo $file->file_upload; ?>
			</a>
			<?php if (!empty($file->description)): ?>
			<br>
			Chú thích: <?php echo $file->description; ?>
			<?php endif; ?>
		    </td>
		</tr>
		<?php endforeach; ?>
	    </table>
	</div>
	<?php endif; ?>
	
	<?php if (!empty($this->notes)): ?>
	
	<?php echo JHtml::_('sliders.panel', JText::_('Business Notes'), 'business_notes'); ?>
	
	<div>
	    <table>
		<tr>
		    <th>Del</th>
		    <th>Note</th>
		</tr>
		<?php foreach ($this->notes as $note): ?>
		<tr>
		    <td>
			<input type="checkbox" name="del_file" />
		    </td>
		    <td>
			<?php echo $note->note; ?>
		    </td>
		</tr>
		<?php endforeach; ?>
	    </table>
	</div>
	<?php endif; ?>

	<?php echo JHtml::_('sliders.end'); ?>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
    </div>

    <div class="clr"></div>
</form>
