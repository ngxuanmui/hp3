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

$jqueryFileUploadPath = JURI::root() . 'media/hp/jquery-ui-upload/';
?>

<div class="container">
    <div class="float-left left-side">
		<div class="sub-container relative">
			<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&layout=edit&task=user_man_online_nicks.apply'); ?>" method="post" name="userForm" id="album-form" class="form-validate" enctype="multipart/form-data">
				
					<fieldset class="userform">
						<legend><?php echo 'Nick chat online'; ?></legend>
						<ul class="adminformlist">
							<li><?php echo $this->form->getLabel('nick_yahoo_alias'); ?>
							<?php echo $this->form->getInput('nick_yahoo_alias'); ?></li>
							
							<li><?php echo $this->form->getLabel('nick_yahoo'); ?>
							<?php echo $this->form->getInput('nick_yahoo'); ?></li>

							<li><?php echo $this->form->getLabel('nick_skype_alias'); ?>
							<?php echo $this->form->getInput('nick_skype_alias'); ?></li>

							<li><?php echo $this->form->getLabel('nick_skype'); ?>
							<?php echo $this->form->getInput('nick_skype'); ?></li>
							
							<li><?php echo $this->form->getLabel('id'); ?>
							<?php echo $this->form->getInput('id'); ?></li>
						</ul>
						<div class="clr"> </div>
						
						<input type="hidden" name="task" value="user_man_online_nicks.apply" />
						<?php echo JHtml::_('form.token'); ?>
						
						<div class="user-toolbar">
							<button id="btn-apply" class="button" rel="user_man_online_nicks.apply">Cập nhật</button>
						</div>

					</fieldset>
				
			</form>
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
	</div>
</div>

<div class="clr"></div>