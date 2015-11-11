<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jnt_hanhphuc
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a list of albums.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_jnt_hanhphuc
 * @since       1.6
 */
class Jnt_HanhphucViewAlbums extends JViewLegacy
{
	protected $categories;
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 *
	 * @since   1.6
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$this->categories	= $this->get('CategoryOrders');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		// Get filter form.
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}	
		
		Jnt_HanhPhucHelper::addSubmenu('albums');
		
		$this->addToolbar();
		
		$this->sidebar = JHtmlSidebar::render();
		
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/jnt_hanhphuc.php';

		$canDo = Jnt_HanhphucHelper::getActions($this->state->get('filter.category_id'));
		$user = JFactory::getUser();
		JToolBarHelper::title(JText::_('Albums Manager'), 'article.png');
//		if (count($user->getAuthorisedCategories('com_jnt_hanhphuc', 'core.create')) > 0)
		if (($canDo->get('core.create')))
		{
			JToolBarHelper::addNew('album.add');
		}

		if (($canDo->get('core.edit')))
		{
			JToolBarHelper::editList('album.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			if ($this->state->get('filter.state') != 2)
			{
				JToolBarHelper::divider();
				JToolBarHelper::publish('albums.publish', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::unpublish('albums.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			}

			if ($this->state->get('filter.state') != -1)
			{
				JToolBarHelper::divider();
				if ($this->state->get('filter.state') != 2)
				{
					JToolBarHelper::archiveList('albums.archive');
				}
				elseif ($this->state->get('filter.state') == 2)
				{
					JToolBarHelper::unarchiveList('albums.publish');
				}
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolBarHelper::checkin('albums.checkin');
		}

		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete'))
		{
			JToolBarHelper::deleteList('', 'albums.delete', 'JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolBarHelper::trash('albums.trash');
			JToolBarHelper::divider();
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_jnt_hanhphuc');
		}
	}
}
