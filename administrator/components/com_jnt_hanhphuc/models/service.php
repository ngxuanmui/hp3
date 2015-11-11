<?php
    /**
     * @version		$Id: banner.php 20228 2011-01-10 00:52:54Z eddieajau $
     * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
     * @license		GNU General Public License version 2 or later; see LICENSE.txt
     */

// No direct access.
    defined('_JEXEC') or die;

    jimport('joomla.application.component.modeladmin');

    /**
     * Banner model.
     *
     * @package		Joomla.Administrator
     * @subpackage	com_cl_diamond
     * @since		1.6
     */
class Jnt_HanhPhucModelService extends JModelAdmin {
    /**
     * @var		string	The prefix to use with controller messages.
     * @since	1.6
     */
    protected $text_prefix = 'COM_JNT_HANHPHUC_SERVICE';

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param	type	The table type to instantiate
     * @param	string	A prefix for the table class name. Optional.
     * @param	array	Configuration array for model. Optional.
     * @return	JTable	A database object
     * @since	1.6
     */
    public function getTable($type = 'Service', $prefix = 'Jnt_HanhPhucTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param	array	$data		Data for the form.
     * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
     * @return	mixed	A JForm object on success, false on failure
     * @since	1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_jnt_hanhphuc.service', 'service', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return	mixed	The data for the form.
     * @since	1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_jnt_hanhphuc.edit.service.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }
        if(!empty($data->payment_type)) {
            $data->payment_type = json_decode($data->payment_type);
        }

        return $data;
    }

    public function save($data) {
        if(!empty($data['payment_type'])) {
            $data['payment_type'] = json_encode($data['payment_type']);
        }
        return parent::save($data);
    }


}