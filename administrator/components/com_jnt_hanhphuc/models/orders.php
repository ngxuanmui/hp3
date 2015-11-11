<?php
/**
 * @version		$Id: banners.php 20267 2011-01-11 03:44:44Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of banner records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class Jnt_HanhPhucModelOrders extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
			    'id'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery() {
		// Initialise variables.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'o.*'
			)
		);
		
		
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=o.checked_out');

		$query->from('`#__hp_order` AS o');
		
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'o.id');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		
		$query->order($db->escape($orderCol.' '.$orderDirn));

		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}
	
	public function getItems() {
	    $items = parent::getItems();
	    
	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);
	    
	    foreach ($items as & $item)
	    {
		// get all items in order
		$query->clear()
			->select('COUNT(id)')
			->from('#__hp_order_items')
			->where('order_id = ' . $item->id)
			;
		
		$db->setQuery($query);
		$item->count_items = $db->loadResult();
		
		// get all items which delivered in order
		$query->clear()
			->select('COUNT(id)')
			->from('#__hp_order_items')
			->where('order_id = ' . $item->id)
			->where('delivered = 1')
			;
		
		$db->setQuery($query);
		$item->count_delivered_items = $db->loadResult();
		
		if ($db->getErrorMsg())
		    die ($db->getErrorMsg ());
	    }
	    
	    return $items;
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Order', $prefix = 'Jnt_HanhPhucTable', $config = array()) {
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null) {
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $state);

		// List state information.
		parent::populateState('id', 'desc');
	}
}