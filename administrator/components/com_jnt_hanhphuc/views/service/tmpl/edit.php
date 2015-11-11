<?php
/**
 * @version		$Id: edit.php 20649 2011-02-10 09:15:04Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_services
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "service.cancel" || document.formvalidator.isValid(document.getElementById("service-form")))
		{
			Joomla.submitform(task, document.getElementById("service-form"));
		}
	};
');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=service&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="service-form" class="form-validate">
	
	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
	
	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('Service Detail', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<?php echo $this->form->getControlGroup('business_id'); ?>
				<?php echo $this->form->getControlGroup('current_price'); ?>
				<?php echo $this->form->getControlGroup('promotion'); ?>
				<?php echo $this->form->getControlGroup('payment_type'); ?>
				<?php echo $this->form->getInput('description'); ?>
			</div>
			<div class="span3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
			</div>
			<div class="span6">
				<?php echo $this->form->getControlGroups('metadata'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>
