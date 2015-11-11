<?php
/**
 * @version		$Id: contact.php 20982 2011-03-17 16:12:00Z chdemko $
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class Jnt_HanhPhucControllerLocation extends JController {
    public function getLocations() {
        $parent = JRequest::getInt('parent', 0);
        $type = JRequest::getInt('type', 'district');
        $parentColumn = JRequest::getString('parent_column', '');

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $table = '#__location';
        if($type == 'district') {
            $table .= '_district';
        } else {
            $table .= '_province';
        }

        $query->select('l.id as value, l.title as text');
        $query->from($table . ' as l');
        $query->order('l.title');

        if($parentColumn) {
            $parentValue = $parent;
            $query->where('l.'.$parentColumn. ' = '.$parentValue);
        }
        
        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();
        array_unshift($options, JHtml::_('select.option', '', JText::_('- Lựa chọn -')));
        echo json_encode($options);
        die;
    }
}