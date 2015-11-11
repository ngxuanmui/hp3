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
class Jnt_HanhPhucModelArticles extends JModelList
{

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 * @since	1.6
	 */
	public function getListQuery() {
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		
		$query->select('a.*')
				->from('#__hp_business_content a')
				->where('a.state = 1')
				->order('a.id DESC')
		;
		
		return $query;
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function populateState($ordering = 'ordering', $direction = 'ASC')
	{
		$app = JFactory::getApplication();
	
		// List state information
		$value = JRequest::getUInt('limit', CFG_LIST_USER_CONTENT);
		$this->setState('list.limit', $value);
	
		$value = JRequest::getUInt('limitstart', 0);
		$this->setState('list.start', $value);
	}
	
	/**
	 * Method to get the starting number of items for the data set.
	 *
	 * @return  integer  The starting number of items available in the data set.
	 *
	 * @since   11.1
	 */
	public function getStart()
	{
		$store = $this->getStoreId('getstart');
	
		// Try to load the data from internal storage.
		if (isset($this->cache[$store]))
		{
			return $this->cache[$store];
		}
	
		$start = $this->getState('list.start');
		$limit = $this->getState('list.limit');
		$total = $this->getTotal();
		
		if ($start > $total)
			$start ++;		
		elseif ($start > $total - $limit)
		{
			// original
			// $start = max(0, (int) (ceil($total / $limit) - 1) * $limit)
			
			// edit to ignore load content
			$start = max(0, (int) (ceil($total / $limit) - 1) * $limit);
		}
		
		// Add the total to the internal cache.
		$this->cache[$store] = $start;
	
		return $this->cache[$store];
	}
}
