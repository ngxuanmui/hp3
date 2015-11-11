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
		<div class="sub-container relative">
			<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=user_man_hotel.apply&id='.(int) $this->item->id); ?>" method="post" name="userForm" id="user-content-form" class="form-validate" enctype="multipart/form-data">
				
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

							<li><?php echo $this->form->getLabel('state'); ?>
							<?php echo $this->form->getInput('state'); ?></li>
							 */?>

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
								<?php echo $this->form->getLabel('images'); ?>
								<?php echo $this->form->getInput('images'); ?>
							</li>
							
							<li>
								<?php echo $this->form->getLabel('publish_up'); ?>
								<?php echo $this->form->getInput('publish_up'); ?>
							</li>
							
							<li>
								<?php echo $this->form->getLabel('publish_down'); ?>
								<?php echo $this->form->getInput('publish_down'); ?>
							</li>

							<?php 
							$introImages = ($this->item->images) ? $this->item->images : false; 
							?>

							<?php if ($introImages): ?>
							<li class="control-group form-inline">
								<?php echo $this->form->getLabel('del_image'); ?>
								<?php echo $this->form->getInput('del_image'); ?>
							</li>

							<li>
								<label>Intro image uploaded</label>
								<a href="<?php echo JUri::root() . $introImages; ?>" class="modal">
									<img src="<?php echo JUri::root() . $introImages; ?>" style="width: 100px;" />
								</a>
							</li>
							<?php endif; ?>

							<li><?php echo $this->form->getLabel('id'); ?>
							<?php echo $this->form->getInput('id'); ?></li>
						</ul>
						<div class="clr"> </div>

						<?php echo $this->form->getLabel('introtext'); ?>
						<?php echo $this->form->getInput('introtext'); ?>

						<div class="clr"> </div>
						
						<?php echo $this->form->getLabel('content'); ?>
						<?php echo $this->form->getInput('content'); ?>
						
            			<?php echo $this->form->getInput('images2content'); ?>
						
						<div class="clr"> </div>
						
						<input type="hidden" name="task" value="user_man_content.apply" />
						<?php echo JHtml::_('form.token'); ?>
						
						<?php echo HP_User_Toolbar::buttonEdit('user_man_content'); ?>

					</fieldset>
				
			</form>
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
	</div>
</div>

<div class="clr"></div>