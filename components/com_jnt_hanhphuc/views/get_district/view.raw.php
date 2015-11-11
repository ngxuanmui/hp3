<?php
/**
 * @version		$Id: view.html.php 21018 2011-03-25 17:30:03Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_jnt_hanhphuc
 * @since		1.5
 */
class Jnt_HanhPhucViewGet_District extends JView
{
	protected $items;
	
	function display($tpl = null) {
		
		$id = JRequest::getInt('id', 0);
		
        // Get some data from the models
		$this->items		= $this->get('Items');
		
		parent::display($tpl);
	}
}
