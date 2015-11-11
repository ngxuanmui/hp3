<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Users list controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_users
 * @since       1.6
 */
class Jnt_HanhphucControllerUsers extends JControllerAdmin
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_USERS_USERS';

	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @return  UsersControllerUsers
	 *
	 * @since   1.6
	 * @see     JController
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('block',		'changeBlock');
		$this->registerTask('unblock',		'changeBlock');
		$this->registerTask('sticky_unpublish',	'sticky_publish');
		$this->registerTask('is_verify_user_unpublish',	'is_verify_user_publish');
		$this->registerTask('is_verify_transaction_unpublish',	'is_verify_transaction_publish');
	}

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since	1.6
	 */
	public function getModel($name = 'User', $prefix = 'Jnt_HanhphucModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}
	
	/**
	 * @since	1.6
	 */
	public function sticky_publish()
	{
		$this->_stick('sticky');
	}
	
	public function is_verify_user_publish()
	{
		$this->_stick('is_verify_user');
	}
	
	public function is_verify_transaction_publish()
	{
		$this->_stick('is_verify_transaction');
	}
	
	private function _stick($field = 'sticky')
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		// Initialise variables.
		$user	= JFactory::getUser();
		$ids	= JRequest::getVar('cid', array(), '', 'array');
		$values	= array($field . '_publish' => 1, $field . '_unpublish' => 0);
		$task	= $this->getTask();
		$value	= JArrayHelper::getValue($values, $task, 0, 'int');
		
		if (empty($ids)) {
			JError::raiseWarning(500, JText::_('COM_JNT_HANHPHUC_NO_BANNERS_SELECTED'));
		} else {
			// Get the model.
			$model	= $this->getModel();
		
			// Change the state of the records.
			if (!$model->stick($ids, $value, $field)) {
				JError::raiseWarning(500, $model->getError());
			} else {
				if ($value == 1) {
					$ntext = 'Success Tick!';
				} else {
					$ntext = 'Success Untick!';
				}
				$this->setMessage(JText::plural($ntext, count($ids)));
			}
		}
		
		$this->setRedirect('index.php?option=com_jnt_hanhphuc&view=users');
	}
}
