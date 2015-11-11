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
class Jnt_HanhPhucModelServices extends JModelList {
    /**
     * Constructor.
     *
     * @param	array	An optional associative array of configuration settings.
     * @see		JController
     * @since	1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 's.id',
                'name', 's.name',
                'category', 'c.title',
                'username', 'u.username',
                'price', 's.price',
                'current_price', 's.current_price',
                'state', 's.state',
                'promotion', 's.promotion',
                'created_by', 'created.username',
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
        $db		= $this->getDbo();
        $query	= $db->getQuery(true);

        $query->select(
            $this->getState(
                'list.select',
                's.*'
            )
        );
        $query->select('u.username as username');
        $query->select('c.title as category');
        $query->select('created.username as created_by');
        $query->from('#__hp_business_service AS s');

        $query->innerJoin("#__categories c ON s.category = c.id AND c.extension = 'com_jnt_hanhphuc'");

        $query->leftJoin('#__users AS u ON s.business_id = u.id');
        $query->leftJoin('#__users AS created ON s.created_by = created.id');

        $published = $this->getState('filter.state');
        if(is_numeric($published)) {
            $query->where('s.state = '.(int) $published);
        }

        $categoryId = $this->getState('filter.category_id');
        if (is_numeric($categoryId)) {
            $query->where('s.category = '.(int) $categoryId);
        }

        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('s.id = '.(int) substr($search, 3));
            } else {
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('(s.name LIKE '.$search.'  OR s.promotion LIKE '.$search.' OR u.username LIKE '.$search.' OR created.username LIKE '.$search.')');
            }
        }


       // Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 's.name');
		$orderDirn = $this->state->get('list.direction', 'ASC');

		if ($orderCol == 'ordering' || $orderCol == 'category_title')
		{
			$orderCol = 's.name ' . $orderDirn . ', a.ordering';
		}

		$query->order($db->escape($orderCol . ' ' . $orderDirn));

//         echo nl2br(str_replace('#__','hp_',$query));
        
        return $query;
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
    public function getTable($type = 'Service', $prefix = 'Jnt_HanhPhucTable', $config = array()) {
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

        $categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id', '');
        $this->setState('filter.category_id', $categoryId);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_jnt_hanhphuc');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('id', 'DESC');
    }
}