<?php
/**
 * @version		$Id: category.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 */
class Jnt_HanhPhucModelArticle extends JModelLegacy
{

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 * @since	1.6
	 */
	public function getItem() {
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		
		$jInput = JFactory::getApplication()->input;
		
		$id = $jInput->getInt('id', 0);
		
		$query->select('*')
				->from('#__hp_business_content')
				->where('id = ' . $id)
				->where('state = 1')
		;
		
		$db->setQuery($query);
		$row = $db->loadObject();
		
		return $row;
	}
}
