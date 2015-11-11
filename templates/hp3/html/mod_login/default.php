<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined ( '_JEXEC' ) or die ();

require_once JPATH_SITE . '/components/com_users/helpers/route.php';

JHtml::_ ( 'behavior.keepalive' );
JHtml::_ ( 'bootstrap.tooltip' );

?>
<form
	action="<?php echo JRoute::_(htmlspecialchars(JUri::getInstance()->toString()), true, $params->get('usesecure')); ?>"
	method="post" id="login-form" class="form-inline">

	<div class="row">
		<div class="col-md-12">
			<div class="pull-right">
				<input id="modlgn-username" type="text" name="username"
					class="input-small" tabindex="0" size="18"
					placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />

				<input id="modlgn-passwd" type="password" name="password"
					class="input-small" tabindex="0" size="18"
					placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />


				<button type="submit" tabindex="0" name="Submit"
					class="btn btn-primary"><?php echo JText::_('JLOGIN') ?></button>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="pull-right">
		<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
		<div id="form-login-remember" class="control-group checkbox">
					<label for="modlgn-remember" class="control-label"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
					<input id="modlgn-remember" type="checkbox" name="remember"
						class="inputbox" value="yes" />
				</div>
		<?php endif; ?>
				
		<?php
		$usersConfig = JComponentHelper::getParams ( 'com_users' );
		?>
			
			<?php if ($usersConfig->get('allowUserRegistration')) : ?>
					<a
					href="<?php echo JRoute::_('index.php?option=com_users&view=registration&Itemid=' . UsersHelperRoute::getRegistrationRoute()); ?>">
					<?php echo JText::_('MOD_LOGIN_REGISTER'); ?> <span
					class="icon-arrow-right"></span>
				</a>
			<?php endif; ?>
					<a
					href="<?php echo JRoute::_('index.php?option=com_users&view=remind&Itemid=' . UsersHelperRoute::getRemindRoute()); ?>">
					<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a> <a
					href="<?php echo JRoute::_('index.php?option=com_users&view=reset&Itemid=' . UsersHelperRoute::getResetRoute()); ?>">
					<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a> <input
					type="hidden" name="option" value="com_users" /> <input
					type="hidden" name="task" value="user.login" /> <input
					type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
		
	</div>
		</div>
	</div>

</form>
