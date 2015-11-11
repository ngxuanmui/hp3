<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_jnt_hanhphuc
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * HTML View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_jnt_hanhphuc
 * @since 1.5
 */
class Jnt_HanhphucViewAlbums extends JViewLegacy
{
	protected $items;
	protected $fields;
	protected $pagination;
	protected $category;

	function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->fields = $this->get('CustomField');
		$this->pagination = $this->get('Pagination');
		$this->category = $this->get('Category');
		
		$this->_prepareDocument();
		
		$layout = JRequest::getString('layout');
		
		if ($layout == 'mansory')
			$tpl = 'mansory';

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		
	}
}
