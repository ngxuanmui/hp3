<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jnt_hanhphuc
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Album model.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_jnt_hanhphuc
 * @since       1.6
 */
class Jnt_HanhphucModelUser_Man_Online_Nicks extends JModelAdmin
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_JNT_HANHPHUC_USER_MAN_ONLINE_NICKS';

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
		return true;
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
		return true;
	}
	
	public function getItem()
	{
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		
		$query->select('*')->from('#__hp_business_nicks')->where('user_id = ' . JFactory::getUser()->id);
		
		$db->setQuery($query);
		
		$obj = $db->loadObject();
		
		return $obj;
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
	public function getTable($type = 'Nicks', $prefix = 'Jnt_HanhphucTable', $config = array())
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
		$form = $this->loadForm('com_jnt_hanhphuc.user_man_online_nicks', 'user_man_online_nicks', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
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
		$data = JFactory::getApplication()->getUserState('com_jnt_hanhphuc.edit.online_nicks.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}
	
	public function save($data)
	{
		$user = JFactory::getUser();
		
		if ($user->guest)
			return false;
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		
		
		$table = '#__hp_business_nicks';
		$where = 'user_id = ' . $user->id;
		
		// check in table nicks
		$query->select('id')->from($table)->where($where);
				
		$db->setQuery($query);
		$check = $db->loadObject();
		
		if ($db->getErrorMsg())
			die ($db->getErrorMsg());
		
		if ($check->id)
		{
			//update
			$query->clear()
					->update($table)
					->set('nick_fb = "'.$data['nick_fb'].'", nick_yahoo = "'.$data['nick_yahoo'].'", nick_skype = "'.$data['nick_skype'].'"')
					->set('nick_fb_alias = "'.$data['nick_fb_alias'].'", nick_yahoo_alias = "'.$data['nick_yahoo_alias'].'", nick_skype_alias = "'.$data['nick_skype_alias'].'"')
					->where($where)
			;
		}
		else
		{
			$values = $user->id.', "'.$data['nick_fb'].'", "'.$data['nick_yahoo'].'", "'.$data['nick_skype'].'", "'.$data['nick_fb_alias'].'", "'.$data['nick_yahoo_alias'].'", "'.$data['nick_skype_alias'].'"';
			
			// insert
			$query->clear()
					->insert($table)->columns('user_id, nick_fb, nick_yahoo, nick_skype, nick_fb_alias, nick_yahoo_alias, nick_skype_alias')->values($values);
			;
		}
		
		$db->setQuery($query);
		$db->query();
		
		if ($db->getErrorMsg())
			die ($db->getErrorMsg());
		
		return true;
	}
}
