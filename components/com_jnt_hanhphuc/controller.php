<?php
/**
 * @version		$Id: controller.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_banners
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * HP Services Controller
 *
 * @package		Joomla.Site
 * @subpackage	com_banners
 * @since		1.5
 */
class Jnt_HanhPhucController extends JControllerLegacy
{
    public function __construct($config = array()) {
        parent::__construct($config);
        
        $this->default_view = 'categories';
    }

    public function display($cachable = false, $urlparams = false) {
    	
    	$safeurlparams = array('catid'=>'INT', 'id'=>'INT', 'cid'=>'ARRAY', 'year'=>'INT', 'month'=>'INT', 'limit'=>'UINT', 'limitstart'=>'UINT',
    			'showall'=>'INT', 'return'=>'BASE64', 'filter'=>'STRING', 'filter_order'=>'CMD', 'filter_order_Dir'=>'CMD', 'filter-search'=>'STRING', 'print'=>'BOOLEAN', 'lang'=>'CMD');
    	 
    	$arrRequiredLogin = array('user_man_albums', 'user_man_album', 'user_man_content', 'user_man_contents', 'user_man_online_nicks', 'user_man_order_items', 'user_man_orders');
    	
    	$view = JRequest::getString('view');
    	
    	// If the user is a guest, redirect to the login page.
    	$user = JFactory::getUser();
    	
    	if ($user->get('guest') == 1 && in_array($view, $arrRequiredLogin)) {
    		// Redirect to login page.
    		$this->setRedirect(JRoute::_('index.php?option=com_users&view=login', false));
    		return;
    	}
    	
        parent::display($cachable, $safeurlparams);
    }
}
