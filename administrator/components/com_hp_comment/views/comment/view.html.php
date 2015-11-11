<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('Hp_CommentHelper', JPATH_COMPONENT.'/helpers/hp_comment.php');

/**
 * View to edit a comment.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_hp_comment
 * @since		1.5
 */
class Hp_CommentViewComment extends JViewLegacy
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
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		// Since we don't track these assets at the item level, use the category id.
		$canDo		= Hp_CommentHelper::getActions(0, 0);

		JToolBarHelper::title($isNew ? JText::_('Comment Manager: New') : JText::_('Comment Manager: Edit'), 'comments.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_hp_comment', 'core.create')) > 0)) {
			JToolBarHelper::apply('comment.apply');
			JToolBarHelper::save('comment.save');
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('comment.cancel');
		}
		else {
			JToolBarHelper::cancel('comment.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
