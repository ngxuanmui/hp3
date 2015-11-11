<?php
/**
 * @version		$Id: view.html.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit a banner.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.5
 */
class Jnt_HanhPhucViewService extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= false;
		$canDo		= Jnt_HanhPhucHelper::getActions($this->state->get('filter.category_id'));

		JToolBarHelper::title($isNew ? 'Hanhphuc.vn: New Service' : 'Hanhphuc.vn: Service detail', 'banners.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('service.edit') || $canDo->get('core.create'))) {
			JToolBarHelper::apply('service.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('service.save', 'JTOOLBAR_SAVE');
			JToolbarHelper::save2new('service.save2new');
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('service.cancel','JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('service.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
