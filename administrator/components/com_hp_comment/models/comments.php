<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of comment records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_hp_comment
 * @since		1.6
 */
class Hp_CommentModelComments extends JModelList
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
				'cid', 'a.cid', 'client_name',
				'name', 'a.name',
				'alias', 'a.alias',
				'state', 'a.state',
				'ordering', 'a.ordering',
				'language', 'a.language',
				'catid', 'a.catid', 'category_title',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'created', 'a.created',
				'impmade', 'a.impmade',
				'imptotal', 'a.imptotal',
				'clicks', 'a.clicks',
				'publish_up', 'a.publish_up',
				'publish_down', 'a.publish_down',
				'state', 'sticky', 'a.sticky',
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
				'a.id AS id, a.content, a.item_type,'.
				'a.checked_out AS checked_out, a.created_by,'.
				'a.checked_out_time AS checked_out_time,' .
				'a.state AS state, a.ordering AS ordering'
			)
		);
		$query->from($db->quoteName('#__hp_comments').' AS a');
		
		// Join over the users for the author.
		$query->select('ua.name AS author_name');
		$query->join('LEFT', '#__users AS ua ON ua.id = a.created_by');
		
		// select title
		$strCase = ' CASE a.item_type';
		
		$strCase .= ' WHEN "user" THEN (SELECT username FROM #__users WHERE id = a.item_id)';
		
		$strCase .= ' WHEN "service" THEN (SELECT name FROM #__hp_business_service WHERE id = a.item_id)';
		
		$strCase .= ' WHEN "article" THEN (SELECT title FROM #__hp_business_content WHERE id = a.item_id)';
		
		$strCase .= ' WHEN "album" THEN (SELECT name FROM #__hp_albums WHERE id = a.item_id)';
		
		$strCase .= ' END AS comment_for';
		
		$query->select($strCase);
		
		// select alias
		$strCase = ' CASE a.item_type';
		
		$strCase .= ' WHEN "user" THEN (SELECT username FROM #__users WHERE id = a.item_id)';
		
		$strCase .= ' WHEN "service" THEN (SELECT alias FROM #__hp_business_service WHERE id = a.item_id)';
		
		$strCase .= ' WHEN "article" THEN (SELECT alias FROM #__hp_business_content WHERE id = a.item_id)';
		
		$strCase .= ' WHEN "album" THEN (SELECT alias FROM #__hp_albums WHERE id = a.item_id)';
		
		$strCase .= ' END AS comment_alias';
		
		$query->select($strCase);

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = '.(int) $published);
		} elseif ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.name LIKE '.$search.' OR a.alias LIKE '.$search.')');
			}
		}
		
		$query->where('a.parent_id = 0');

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'ordering');
		$orderDirn	= $this->state->get('list.direction', 'ASC');
		if ($orderCol == 'ordering' || $orderCol == 'category_title') {
			$orderCol = 'c.title '.$orderDirn.', a.ordering';
		}
		if($orderCol == 'client_name')
			$orderCol = 'cl.name';
		$query->order($db->escape($orderCol.' '.$orderDirn));

		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}
	
	public function getItems()
	{
		$items = parent::getItems();
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		
		foreach ($items as & $item)
		{
			$query->clear()
					->select('*')
					->from('#__hp_comments')
					->where('parent_id = ' . $item->id)
			;
			
			$db->setQuery($query);

			$item->sub = $db->loadObjectList();
		}
		
		return $items;
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
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.access');
		$id	.= ':'.$this->getState('filter.state');
		$id	.= ':'.$this->getState('filter.category_id');
		$id .= ':'.$this->getState('filter.language');

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
	public function getTable($type = 'Comment', $prefix = 'CommentsTable', $config = array())
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

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $state);

		$categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id', '');
		$this->setState('filter.category_id', $categoryId);

		$clientId = $this->getUserStateFromRequest($this->context.'.filter.client_id', 'filter_client_id', '');
		$this->setState('filter.client_id', $clientId);

		$language = $this->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
		$this->setState('filter.language', $language);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_hp_comment');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.id', 'desc');
	}
}
