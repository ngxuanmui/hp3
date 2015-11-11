<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
?>
<?php if ($type == 'logout') : ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form">
<?php if ($params->get('greeting')) : ?>
	<div class="login-greeting">
	<?php if($params->get('name') == 0) : {
		echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name')));
	} else : {
		echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username')));
	} endif; ?>
	
	<input type="submit" name="Submit" class="button logout-button" value="<?php echo JText::_('[ Thoát ]'); ?>" />
	</div>
<?php endif; ?>
	<div class="logout-button">
		
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<?php else : ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" >
	
	<fieldset class="userdata">
	<p id="form-login">
		<input id="modlgn-username" type="text" name="username" class="inputbox"  size="18" placeholder="Email đăng nhập" />
		
		<input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18" placeholder="Mật khẩu"  />
		
		<input type="submit" name="Submit" class="button login-button" value="&nbsp;" />
	</p>
	<p id="form-login-password">
		
	</p>
	<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
	<p id="form-login-options">
		<span class="remember">
			<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/> Ghi nhớ
		</span>
		
		<span class="options">
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
				Quên mật khẩu
			</a> |
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
				Quên tên đăng nhập
			</a> |
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
				Đăng ký
			</a>
		</span>
	</p>
	<?php endif; ?>
	
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHtml::_('form.token'); ?>
	</fieldset>
	
</form>
<?php endif; ?>
