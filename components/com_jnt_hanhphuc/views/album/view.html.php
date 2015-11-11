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
class Jnt_HanhphucViewAlbum extends JViewLegacy
{
	protected $item;
	protected $otherImages;
	protected $otherItems;

	function display($tpl = null)
	{
		$this->item = $this->get('Item');
		$this->otherImages = $this->get('OtherImages');
// 		$this->otherItems = $this->get('OtherItems');
		
		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		
	}
}
