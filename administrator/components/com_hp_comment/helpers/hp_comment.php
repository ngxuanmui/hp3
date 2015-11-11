<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Comments component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_hp_comment
 * @since		1.6
 */
class Hp_CommentHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
	{
		return false;
		
// 		JSubMenuHelper::addEntry(
// 			JText::_('COM_BANNERS_SUBMENU_BANNERS'),
// 			'index.php?option=com_hp_comment&view=comments',
// 			$vName == 'comments'
// 		);

// 		JSubMenuHelper::addEntry(
// 			JText::_('COM_BANNERS_SUBMENU_CATEGORIES'),
// 			'index.php?option=com_categories&extension=com_hp_comment',
// 			$vName == 'categories'
// 		);
// 		if ($vName=='categories') {
// 			JToolBarHelper::title(
// 				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_hp_comment')),
// 				'comments-categories');
// 		}

// 		JSubMenuHelper::addEntry(
// 			JText::_('COM_BANNERS_SUBMENU_CLIENTS'),
// 			'index.php?option=com_hp_comment&view=clients',
// 			$vName == 'clients'
// 		);

// 		JSubMenuHelper::addEntry(
// 			JText::_('COM_BANNERS_SUBMENU_TRACKS'),
// 			'index.php?option=com_hp_comment&view=tracks',
// 			$vName == 'tracks'
// 		);
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_hp_comment';
			$level = 'component';
		} else {
			$assetName = 'com_hp_comment.category.'.(int) $categoryId;
			$level = 'category';
		}

		$actions = JAccess::getActions('com_hp_comment', $level);

		foreach ($actions as $action) {
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
}
