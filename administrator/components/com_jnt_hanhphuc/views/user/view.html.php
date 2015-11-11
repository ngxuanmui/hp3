<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;



require_once JPATH_ADMINISTRATOR . '/components/com_users/helpers/users.php';

/**
 * @package		Joomla.Administrator
 * @subpackage	com_users
 */
class Jnt_HanhphucViewUser extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $grouplist;
	protected $groups;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->form			= $this->get('Form');
		$this->item			= $this->get('Item');
// 		$this->grouplist	= $this->get('Groups');
// 		$this->groups		= $this->get('AssignedGroups');
		$this->state		= $this->get('State');

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
		JRequest::setVar('hidemainmenu', 1);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$canDo		= UsersHelper::getActions();


		$isNew	= ($this->item->id == 0);
		$isProfile = $this->item->id == $user->id;
		JToolBarHelper::title(JText::_($isNew ? 'COM_USERS_VIEW_NEW_USER_TITLE' : ($isProfile ? 'COM_USERS_VIEW_EDIT_PROFILE_TITLE' : 'User Manager: Edit User')), $isNew ? 'user-add' : ($isProfile ? 'user-profile' : 'user-edit'));
		if ($canDo->get('core.edit')||$canDo->get('core.create')) {
			JToolBarHelper::apply('user.apply');
			JToolBarHelper::save('user.save');
		}
		
		if (empty($this->item->id))  {
			JToolBarHelper::cancel('user.cancel');
		} else {
			JToolBarHelper::cancel('user.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
