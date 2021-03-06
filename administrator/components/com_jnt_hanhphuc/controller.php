<?php
/**
 * @version		$Id: controller.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Banners master display controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class Jnt_HanhPhucController extends JControllerLegacy {
    
    protected $default_view = 'services';
    
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false) {
		require_once JPATH_COMPONENT.'/helpers/jnt_hanhphuc.php';

		//$this->setRedirect(JRoute::_('index.php?option=com_categories&extension=com_jnt_hanhphuc'));
		//return true;
		
		// Load the submenu.
// 		Jnt_HanhPhucHelper::addSubmenu(JRequest::getCmd('view', 'services'));

		parent::display();

		return $this;
	}
}
