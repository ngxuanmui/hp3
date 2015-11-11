<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.modal');

jimport('joomla.form.formfield');

?>

<style>
<!--
#jform_tos-lbl { width: 425px; }
#jform_tos-lbl a { font-weight: bold; }
.tos-invalid, .tos-invalid a { color: red; }
-->
</style>

<script type="text/javascript">
<!--
	window.addEvent('domready', function(){
		   document.formvalidator.setHandler('username', function(value) {
		      regex=/^[A-Za-z][A-Za-z0-9]{5,22}$/;
		      return regex.test(value);
		   });

		   document.formvalidator.setHandler('tos', function(value) {
			    var checkTos = document.getElementById("jform_tos").checked;
			    if (checkTos)
			    {
			    	$('jform_tos-lbl').removeClass('tos-invalid');
				    return true;
			    }
			    else
			    {
				    $('jform_tos-lbl').addClass('tos-invalid');
				    return false;
			    }
			   });
		});
//-->
</script>

<div class="container">
    <div class="float-left left-side">
    
		<h2 class="new-h2">Đăng ký thành viên</h2>
		<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate">
		<div class="new-container">
			<div class="registration">	
				
			<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
				<?php $fields = $this->form->getFieldset($fieldset->name);?>
				<?php if (count($fields)):?>
					<ul>				
						
					<?php foreach($fields as $field): // Iterate through the fields in the set and display them.?>
						<?php if ($field->fieldname == 'tos'): continue; endif; ?>
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<li>
							<label>
								<?php echo $field->label; ?>
								<?php if (!$field->required && $field->type!='Spacer'): ?>
									
								<?php endif; ?>
							</label>
							<div><?php echo ($field->type!='Spacer') ? $field->input : "&#160;"; ?></div>
							<div class="clr"></div>
						</li>
						<?php endif;?>
					<?php endforeach;?>
						
					</ul>
				<?php endif;?>
			<?php endforeach;?>
			
			<ul style="margin: 10px 0;">
				<li>
					<label>&nbsp;</label>
					<span style="float: left; margin-right: 5px;">
					<?php echo $this->form->getInput('tos'); ?> 
					</span>
					<span style="float: left;">
						<?php 
						$link = '<a href="tos.html" class="modal" rel="{handler: \'iframe\', size: {x: 500, y: 400}}">Nội quy thành viên</a>';
						printf($this->form->getLabel('tos'), $link);
						?>
					</span>
					<div class="clr"></div>
				</li>
			</ul>
					
			</div>
		</div>
		
		<ul>
						<li>
							<label>&nbsp;</label>
							<div>
								<button type="submit" class="validate btn-update"><?php echo JText::_('JREGISTER');?></button>
								<?php echo JText::_('COM_USERS_OR');?>
								<a href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
								<input type="hidden" name="option" value="com_users" />
								<input type="hidden" name="task" value="registration.register" />
								<?php echo JHtml::_('form.token');?>
							</div>
						</li>
					</ul>
		
		</form>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
    </div>
    <div class="clr"></div>
</div>
<script type="text/javascript">
    function changeUserType(type) {
        if(type == 1) {
            //console.log(jQuery("#jform_user_profile_name_of_yours").parent().parent().parent());
            jQuery("#jform_user_profile_name_of_yours").parent().parent().parent().hide();
            jQuery("#jform_business_profile_business_director").parent().parent().parent().show();
        } else {
            //console.log(jQuery("#jform_business_profile_business_director").parent().parent().parent());
            jQuery("#jform_business_profile_business_director").parent().parent().parent().hide();
            jQuery("#jform_user_profile_name_of_yours").parent().parent().parent().show();
        }
    }
    jQuery.noConflict();
    jQuery(document).ready(function($){
        $("#jform_user_type").change(function(){
            changeUserType($(this).val());
        });
        $("#jform_user_type").change();
    });
</script>
