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
 * @subpackage	com_content
 * @since		1.5
 */
class Jnt_HanhPhucViewServices extends JView {

	protected $category;
    protected $state;
	protected $items;
	protected $pagination;
	protected $user_info;
	protected $addresses;
	protected $checkInfo;
    
	function display($tpl = null) {
		
		$id = JRequest::getInt('id', 0);
		
        // Get some data from the models
        $this->category 	= $this->get('Category');
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->user_info	= $this->get('UserInfo');
		$this->addresses	= $this->get('Addresses');
		$this->checkInfo	= $this->get('CheckPromotionsAndWeddingImages');
		
		$getMap = JRequest::getInt('getmap');
		
		if (!empty($getMap))
			$tpl = 'map';
		elseif (empty($this->user_info->id))
			$tpl = 'all';
		
		parent::display($tpl);
	}
}
