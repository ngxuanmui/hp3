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
 * @subpackage	com_jnt_hanhphuc
 * @since		1.5
 */
class Jnt_HanhphucTableUser_Man_Address extends JTable
{
	/**
	 * Constructor
	 *
	 * @since	1.5
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__user_addresses', 'id', $_db);
		$date = JFactory::getDate();
		$this->created = $date->toSql();
	}

	/**
	 * Overloaded check function
	 *
	 * @return	boolean
	 * @see		JTable::check
	 * @since	1.5
	 */
	function x_check()
	{
		// Set name
		$this->title = htmlspecialchars_decode($this->title, ENT_QUOTES);

		// Set alias
		$this->alias = JApplication::stringURLSafe($this->alias);
		if (empty($this->alias)) {
			$this->alias = JApplication::stringURLSafe($this->title);
		}

		// Check the publish down date is not earlier than publish up.
		if ($this->publish_down > $this->_db->getNullDate() && $this->publish_down < $this->publish_up) {
			$this->setError(JText::_('JGLOBAL_START_PUBLISH_AFTER_FINISH'));
			return false;
		}

		// Set ordering
		if ($this->state < 0) {
			// Set ordering to 0 if state is archived or trashed
			$this->ordering = 0;
		}

		return true;
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
			// New newsfeed. A feed created and created_by field can be set by the user,
			// so we don't touch either of these if they are set.
			if (!intval($this->created)) {
				$this->created = $date->toSql();
			}
			if (empty($this->created_by)) {
				$this->created_by = $user->get('id');
			}
			
			// Verify that the alias is unique
// 			$table = JTable::getInstance('Album', 'Jnt_HanhphucTable');
// 			if ($table->load(array('alias'=>$this->alias, 'catid'=>$this->catid)) && ($table->id != $this->id || $this->id==0)) {
// 				$this->setError(JText::_('Error: Unique Alias'));
// 				return false;
// 			}
			
			// Store the row
			parent::store($updateNulls);
		}
		else
		{
			// Existing item
// 			$this->modified		= $date->toSql();
// 			$this->modified_by	= $user->get('id');
			
// 			// Get the old row
// 			$oldrow = JTable::getInstance('HP_Content', 'Jnt_HanhphucTable');
// 			if (!$oldrow->load($this->id) && $oldrow->getError())
// 			{
// 				$this->setError($oldrow->getError());
// 			}

			// Verify that the alias is unique
// 			$table = JTable::getInstance('Album', 'Jnt_HanhphucTable');
// 			if ($table->load(array('alias'=>$this->alias, 'catid'=>$this->catid)) && ($table->id != $this->id || $this->id==0)) {
// 				$this->setError(JText::_('Error: Unique Alias'));
// 				return false;
// 			}

			// Store the new row
			parent::store($updateNulls);
		}
		return count($this->getErrors())==0;
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param	mixed	An optional array of primary key values to update.  If not
	 *					set the instance property value is used.
	 * @param	integer The publishing state. eg. [0 = unpublished, 1 = published, 2=archived, -2=trashed]
	 * @param	integer The user id of the user performing the operation.
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Get an instance of the table
		$table = JTable::getInstance('HP_Content', 'Jnt_HanhphucTable');

		// For all keys
		foreach ($pks as $pk)
		{
			// Load the banner
			if(!$table->load($pk))
			{
				$this->setError($table->getError());
			}

			// Verify checkout
			if($table->checked_out==0 || $table->checked_out==$userId)
			{
				// Change the state
				$table->state = $state;
				$table->checked_out=0;
				$table->checked_out_time=$this->_db->getNullDate();

				// Check the row
				$table->check();

				// Store the row
				if (!$table->store())
				{
					$this->setError($table->getError());
				}
			}
		}
		return count($this->getErrors())==0;
	}
}
