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
    	<p class="search-text">Quản lý Album ảnh</p>
			<div class="line-break-search">
				<span></span>
			</div>
			
		<div class="sub-container relative">
			<form action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=user_man_hotel.apply&id='.(int) $this->item->id); ?>" method="post" name="userForm" id="album-form" class="form-validate" enctype="multipart/form-data">
				
					<fieldset class="userform">
						
						<ul class="adminformlist">
							<li><?php echo $this->form->getLabel('name'); ?>
							<?php echo $this->form->getInput('name'); ?></li>

							<li><?php echo $this->form->getLabel('alias'); ?>
							<?php echo $this->form->getInput('alias'); ?></li>
							
							<li><?php echo $this->form->getLabel('catid'); ?>
							<?php echo $this->form->getInput('catid'); ?></li>

							<li>
								<?php echo $this->form->getLabel('images'); ?>
								<?php echo $this->form->getInput('images'); ?>
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

						<?php echo $this->form->getLabel('description'); ?>
						<?php echo $this->form->getInput('description'); ?>

						<div class="clr"> </div>
						
						<div class="">Thêm ảnh vào Album</div>

						<ul class="adminformlist">
							<li>
								<?php echo $this->form->getInput('uploadfile'); ?>
							</li>
							<li>
								<div id="tmp-uploaded">
								<?php 
								$images = $this->item->other_images;

								$path = JURI::root() . 'images/albums/' . $this->item->id . '/';

								if ($images):
								?>
								<table width="100%">
									<?php foreach ($images as $img): ?>
									<tr>
									<td width="80" style="background: #FAFAFA;">
										<img src="<?php echo $path . 'thumbnail/' . $img->images; ?>" />
										<input type="hidden" name="current_images[<?php echo $img->id; ?>]" value="<?php echo $img->images; ?>" />
									</td>
									<td valign="top">
										<?php echo $img->images . '<br><input type="text" size="40" name="current_desc['.$img->id.']" value="' . $img->description . '" placeholder="Input Description" />'; ?>
									</td>
									<td width="50" valign="top"><a href="javascript:;" class="delete-file">Del</a></td>
									</tr>
									<?php endforeach; ?>
								</table>
								<?php endif; ?>
								</div>
							</li>
						</ul>
						
						<div class="clr"> </div>
						
						<input type="hidden" name="task" value="user_man_album.apply" />
						<?php echo JHtml::_('form.token'); ?>
						
						<?php echo HP_User_Toolbar::buttonEdit('user_man_album'); ?>

					</fieldset>
				
			</form>
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
	</div>
</div>

<div class="clr"></div>