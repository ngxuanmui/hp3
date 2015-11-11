<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_hp_comment
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Content Component Controller
 *
 * @package		Joomla.Site
 * @subpackage	com_hp_comment
 * @since		1.5
 */

require_once JPATH_ROOT . DS . 'components/com_hp_comment/helpers/simple_captcha/captcha.php';

class Hp_CommentController extends JControllerLegacy
{
	function __construct($config = array())
	{
		parent::__construct($config);
	}

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;

		$safeurlparams = array('catid'=>'INT', 'id'=>'INT', 'cid'=>'ARRAY', 'year'=>'INT', 'month'=>'INT', 'limit'=>'UINT', 'limitstart'=>'UINT',
			'showall'=>'INT', 'return'=>'BASE64', 'filter'=>'STRING', 'filter_order'=>'CMD', 'filter_order_Dir'=>'CMD', 'filter-search'=>'STRING', 'print'=>'BOOLEAN', 'lang'=>'CMD');

		parent::display($cachable, $safeurlparams);

		return $this;
	}
	
	public function captcha()
	{
		
		$captcha = new SimpleCaptcha();
		$captcha->resourcesPath = JPATH_ROOT . DS . 'components' . DS . 'com_hp_comment' . DS . 'helpers' . DS . 'simple_captcha' . DS . 'resources';
		$captcha->CreateImage();
		
		exit();
	}
	
	public function check_captcha()
	{
		if (JFactory::getUser()->id)
		{
			echo 'OK';
			exit();
		}
		
		$captcha = new SimpleCaptcha();
		
// 		var_dump(JFactory::getSession()->get($captcha->session_var), JRequest::getString('captcha_code'));
		
		if (JFactory::getSession()->get($captcha->session_var) == JRequest::getString('captcha_code'))
			echo 'OK';
		else
			echo 'FAILED';
		
		exit();
	}
	
}
