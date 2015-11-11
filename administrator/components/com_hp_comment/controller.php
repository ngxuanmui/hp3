<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Banners master display controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_hp_comment
 * @since		1.6
 */
class Hp_CommentController extends JControllerLegacy
{
	protected $default_view = 'comments';
	
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
// 		require_once JPATH_COMPONENT.'/helpers/comments.php';

// 		// Load the submenu.
// // 		Hp_CommentHelper::addSubmenu(JRequest::getCmd('view', 'comments'));

// 		$view	= JRequest::getCmd('view', 'comments');
// 		$layout = JRequest::getCmd('layout', 'default');
// 		$id		= JRequest::getInt('id');

// 		// Check for edit form.
// 		if ($view == 'comment' && $layout == 'edit' && !$this->checkEditId('com_hp_comment.edit.comment', $id)) {

// 			// Somehow the person just went to the form - we don't allow that.
// 			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
// 			$this->setMessage($this->getError(), 'error');
// 			$this->setRedirect(JRoute::_('index.php?option=com_hp_comment&view=comments', false));

// 			return false;
// 		}
// 		elseif ($view == 'client' && $layout == 'edit' && !$this->checkEditId('com_hp_comment.edit.client', $id)) {

// 			// Somehow the person just went to the form - we don't allow that.
// 			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
// 			$this->setMessage($this->getError(), 'error');
// 			$this->setRedirect(JRoute::_('index.php?option=com_hp_comment&view=clients', false));

// 			return false;
// 		}

		parent::display();

		return $this;
	}
}
