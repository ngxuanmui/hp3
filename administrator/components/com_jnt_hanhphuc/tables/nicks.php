<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Album table
 *
 * @package		Joomla.Administrator
 * @subpackage	com_ntrip
 * @since		1.5
 */
class Jnt_HanhphucTableNicks extends JTable
{
	/**
	 * Constructor
	 *
	 * @since	1.5
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__hp_business_nicks', 'id', $_db);
	}
	
	/**
	 * method to store a row
	 *
	 * @param boolean $updateNulls True to update fields even if they are null.
	 */
	function store($updateNulls = false)
	{
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();
		
		if (empty($this->id))
		{
			// Store the row
			parent::store($updateNulls);
		}
		else
		{			
			// Get the old row
			$oldrow = JTable::getInstance('Nicks', 'Jnt_HanhphucTable');
			if (!$oldrow->load($this->id) && $oldrow->getError())
			{
				$this->setError($oldrow->getError());
			}

			// Store the new row
			parent::store($updateNulls);
		}
		return count($this->getErrors())==0;
	}
}
