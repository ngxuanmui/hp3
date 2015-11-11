<?php
/**
 * @version		$Id: view.html.php 21148 2011-04-14 17:30:08Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of banners.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class Jnt_HanhPhucViewServices extends JViewLegacy {
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null) {
		// Initialise variables.
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		// Get filter form.
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}		
		
		Jnt_HanhPhucHelper::addSubmenu('services');
		
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
    protected function addToolbar() {

        $canDo = Jnt_HanhPhucHelper::getActions($this->state->get('filter.category_id'));
        $user = JFactory::getUser();
        JToolBarHelper::title(JText::_('Hanhphuc.vn: Manager Services'), 'banners.png');
        if (count($user->getAuthorisedCategories('com_jnt_hanhphuc', 'core.create')) > 0)
        {
            JToolBarHelper::addNew('service.add');
        }

        if (($canDo->get('core.edit')))
        {
            JToolBarHelper::editList('service.edit');
        }

        if ($canDo->get('core.edit.state'))
        {
            if ($this->state->get('filter.state') != 2)
            {
                JToolBarHelper::divider();
                JToolBarHelper::publish('services.publish', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::unpublish('services.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            }

            if ($this->state->get('filter.state') != -1)
            {
                JToolBarHelper::divider();
                if ($this->state->get('filter.state') == 2)
                {
                    JToolBarHelper::unarchiveList('banners.publish');
                }
            }
        }

        if ($canDo->get('core.edit.state'))
        {
            JToolBarHelper::checkin('services.checkin');
        }

        if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete'))
        {
            JToolBarHelper::deleteList('', 'services.delete', 'JTOOLBAR_EMPTY_TRASH');
            JToolBarHelper::divider();
        }
        elseif ($canDo->get('core.edit.state'))
        {
            JToolBarHelper::trash('services.trash');
            JToolBarHelper::divider();
        }

        if ($canDo->get('core.admin'))
        {
            JToolBarHelper::preferences('com_jnt_hanhphuc');
        }
    }
}
