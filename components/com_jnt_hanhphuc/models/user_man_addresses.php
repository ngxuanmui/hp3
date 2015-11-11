<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of album records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_jnt_hanhphuc
 * @since		1.6
 */
class Jnt_HanhphucModelUser_Man_Addresses extends JModelList
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
				'id', 'a.id',
				'name', 'a.name',
				'alias', 'a.alias',
				'state', 'a.state',
				'ordering', 'a.ordering',
				'catid', 'a.catid', 'category_title',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'created', 'a.created',
				'publish_up', 'a.publish_up',
				'publish_down', 'a.publish_down',
				'state',
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
	protected function getListQuery()
	{
		// Initialise variables.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*'
			)
		);
		
		$query->select('p.title AS city_name');
		$query->join('LEFT', '#__location_province p ON p.id = a.city');
		
		$query->select('d.title AS district_name');
		$query->join('LEFT', '#__location_district d ON d.id = a.district');
		
		
		$query->from($db->quoteName('#__user_addresses').' AS a');

		// Join over the language
//		$query->select('l.title AS language_title');
//		$query->join('LEFT', $db->quoteName('#__languages').' AS l ON l.lang_code = a.language');

		// Join over the users for the checked out user.
// 		$query->select('uc.name AS editor');
// 		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the categories.
// 		$query->select('c.title AS category_title');
// 		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');

		// Filter by user
		$userId = JFactory::getUser()->id;
		
		$query->where('a.created_by = ' . (int) $userId);
		
// 		echo nl2br(str_replace('#__','jos_',$query));
		
		return $query;
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.state');

		return parent::getStoreId($id);
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
	public function getTable($type = 'Address', $prefix = 'Jnt_HanhphucTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		$state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $state);

		// Load the parameters.
		//$params = JComponentHelper::getParams('com_jnt_hanhphuc');
		//$this->setState('params', $params);

		// List state information.
		parent::populateState('a.id', 'desc');
	}
}
