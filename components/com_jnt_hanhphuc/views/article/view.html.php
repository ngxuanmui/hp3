<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since		1.5
 */
class Jnt_HanhphucViewArticle extends JViewLegacy
{
	protected $item;

	function display($tpl = null)
	{
		// Initialise variables.
		$this->item		= $this->get('Item');

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$title = $this->item->title;
		
		$this->document->setTitle($this->item->title);
		
		if ($this->item->metadesc)
		{
			$this->document->setDescription($this->item->metadesc);
		}
		else
		{
			$this->document->setDescription(($this->item->content));
		}
		
		if ($this->item->metakey)
		{
			$this->document->setMetadata('keywords', $this->item->metakey);
		}
	}
}
