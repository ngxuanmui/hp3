<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_hp_comment
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Comment model.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_hp_comment
 * @since       1.6
 */
class Hp_CommentModelComment extends JModelAdmin
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_HP_COMMENT_COMMENTS';

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->state != -2)
			{
				return;
			}
			$user = JFactory::getUser();

			if (!empty($record->catid))
			{
				return $user->authorise('core.delete', 'com_hp_comment.category.' . (int) $record->catid);
			}
			else
			{
				return parent::canDelete($record);
			}
		}
	}

	/**
	 * Method to test whether a record can have its state changed.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		// Check against the category.
		if (!empty($record->catid))
		{
			return $user->authorise('core.edit.state', 'com_hp_comment.category.' . (int) $record->catid);
		}
		// Default to component settings if category not known.
		else
		{
			return parent::canEditState($record);
		}
	}

	/**
	 * Returns a JTable object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate. [optional]
	 * @param   string  $prefix  A prefix for the table class name. [optional]
	 * @param   array   $config  Configuration array for model. [optional]
	 *
	 * @return  JTable  A database object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Comment', $prefix = 'Hp_CommentTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form. [optional]
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not. [optional]
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_hp_comment.comment', 'comment', array('control' => 'jform', 'load_data' => $loadData));
		
		if (empty($form))
		{
			return false;
		}
		
		return $form;
	}
	
	public function save($data)
	{
		$db = JFactory::getDbo();
		
		$table = '#__hp_comments';
		
		$obj = new stdClass();
		
		$obj->id 		= $data['reply_id'];
		$obj->parent_id = $data['id'];
		$obj->content 	= $data['reply_content'];
		
		
		if (empty($obj->id))
		{
			$obj->created 		= date('Y-m-d H:i:s');
			$obj->created_by	= JFactory::getUser()->id;
				
			$result = $db->insertObject($table, $obj);
		}
		else
		{
			$obj->modified 		= date('Y-m-d H:i:s');
			$obj->modified_by	= JFactory::getUser()->id;
				
			$result = $db->updateObject($table, $obj, 'id');
		}
		
		if ($result)
			return parent::save($data);
		
		return false;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_hp_comment.edit.comment.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}
		
		$parentId = is_object($data) ? $data->id : $data['id'];
		
		$subComment = $this->getSubComment($parentId);
		
		$data->reply_id = 0;
		$data->reply_content = '';
		
		if (!empty($subComment))
		{
			$data->reply_id = $subComment->id;
			$data->reply_content = $subComment->content;
		}

		return $data;
	}
	
	protected function getSubComment($parentId)
	{
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		
		$query->select('*')->from('#__hp_comments')->where('parent_id = ' . (int) $parentId);
		
		$db->setQuery($query);
		
		return $db->loadObject();
	}
}
