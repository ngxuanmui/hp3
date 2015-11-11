<?php
/**
 * @version		$Id: view.html.php 21018 2011-03-25 17:30:03Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_jnt_hanhphuc
 * @since		1.5
 */
class Jnt_HanhPhucViewCategory extends JViewLegacy {

	protected $category;
    protected $state;
	protected $items;
	protected $pagination;
    
	function display($tpl = null)
	{
        // Get some data from the models
        $this->category 	= $this->get('Category');
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument() {
		
	}
}
