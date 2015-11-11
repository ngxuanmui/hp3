<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_hp_comment
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'comment.cancel' || document.formvalidator.isValid(document.id('comment-form'))) {
			Joomla.submitform(task, document.getElementById('comment-form'));
		}
	}
</script>

<style>
<!--
.textarea_input { width: 400px; }
-->
</style>

<form action="<?php echo JRoute::_('index.php?option=com_hp_comment&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="comment-form" class="form-validate">
	
	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('Detail', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<?php echo $this->form->getControlGroup('content'); ?>
				<?php echo $this->form->getControlGroup('reply_content'); ?>
				<?php echo $this->form->getControlGroup('id'); ?>
				<?php echo $this->form->getControlGroup('reply_id'); ?>
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
