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

$jqueryFileUploadPath = JURI::root() . 'media/jquery-ui-upload/';
?>

<style>
</style>

<script type="text/javascript">
	var ITEM_TYPE = 'albums';
	var ITEM_ID = <?php echo ($this->item->id) ? $this->item->id : 0; ?>;
	Joomla.submitbutton = function(task)
	{
		if (task == 'album.cancel' || document.formvalidator.isValid(document.id('album-form'))) {
			Joomla.submitform(task, document.getElementById('album-form'));
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&layout=edit&id='.(int) $this->item->id); ?>"
	method="post" name="adminForm" id="album-form" class="form-validate"
	enctype="multipart/form-data">
	
	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
	
	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('Service Detail', true)); ?>
		<div class="row-fluid">
			<div class="span9">
			
				<?php echo $this->form->getControlGroup('images'); ?>
				
				<?php 
				$introImages = ($this->item->images) ? $this->item->images : false;
				
				if ($introImages): 
				?>
				<div class="control-group">
					
				
					<?php echo $this->form->getControlGroup('del_image'); ?>
					
					<div class="control-label">
						<label id="jform_images_uploaded-lbl">Intro Image Uploaded</label>
					</div>
					
					<div class="controls">
						<a
							href="<?php echo JUri::root() . $introImages; ?>" class="modal"> <img
							src="<?php echo JUri::root() . $introImages; ?>"
							style="width: 100px;" />
						</a>
					</div>
				</div>
					
				<?php endif; ?>
			
			
				<?php echo $this->form->getInput('description'); ?>
			</div>
			<div class="span3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'otherparams', JText::_('Images', true)); ?>
		
		
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
							<td width="80" style="background: #FAFAFA;"><img
								src="<?php echo $path . 'thumbnail/' . $img->images; ?>"
								style="width: 70px;" /> <input type="hidden"
								name="current_images[<?php echo $img->id; ?>]"
								value="<?php echo $img->images; ?>" /></td>
							<td valign="top">
							<?php echo $img->images . '<br><input type="text" size="40" name="current_desc['.$img->id.']" value="' . $img->description . '" placeholder="Input Description" />'; ?>
						</td>
							<td width="50" valign="top"><a href="javascript:;"
								class="delete-file">Del</a></td>
						</tr>
					    <?php endforeach; ?>
					</table>
					<?php endif; ?>
				    </div>
			</li>
		</ul>
		
		
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