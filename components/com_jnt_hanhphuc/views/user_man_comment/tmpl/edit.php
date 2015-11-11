<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_jnt_hanhphuc
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>

<style type="text/css">
<!--
form#user-content-form textarea { width: 644px; margin: 5px 0; padding: 5px; }
-->
</style>

<div class="container">
    <div class="float-left left-side">
		<div class="sub-container list-items relative">
			<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=user_man_comment.apply&id='.(int) $this->item->id); ?>" method="post" name="userForm" id="user-content-form" class="form-validate" enctype="multipart/form-data">
				
					<fieldset class="userform">
						<legend><?php echo empty($this->item->id) ? JText::_('Thêm mới Tin khuyến mại') : JText::sprintf('Thông tin chi tiết', $this->item->id); ?></legend>
						<ul class="adminformlist">
							<li><?php echo $this->form->getLabel('title'); ?>
							<?php echo $this->form->getInput('title'); ?></li>
							
							<li>
								<?php echo $this->form->getLabel('alias'); ?>
								<?php echo $this->form->getInput('alias'); ?>
							</li>

							<?php /*
							<li>
								<?php echo $this->form->getLabel(''); ?>
								<?php echo $this->form->getInput(''); ?>
							</li>

							<li>
								<?php echo $this->form->getLabel(''); ?>
								<?php echo $this->form->getInput(''); ?>
							</li>
							 */ ?>
							 
							 <li>
								<?php echo nl2br($this->item->content); ?>
							</li>

							<li>
								<?php echo $this->form->getLabel('reply_content'); ?>
								<?php echo $this->form->getInput('reply_content'); ?>
							</li>

							<li><?php echo $this->form->getLabel('id'); ?>
							<?php echo $this->form->getInput('id'); ?></li>
							
							<?php echo $this->form->getInput('reply_id'); ?></li>
						</ul>

						<div class="clr"> </div>
						
						<input type="hidden" name="task" value="user_man_comment.apply" />
						<?php echo JHtml::_('form.token'); ?>
						
						<?php echo HP_User_Toolbar::buttonEdit('user_man_comment'); ?>

					</fieldset>
				
			</form>
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
	</div>
</div>

<div class="clr"></div>