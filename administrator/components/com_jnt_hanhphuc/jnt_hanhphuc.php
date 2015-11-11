<?php
/**
 * @version		$Id: banners.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_banners')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

// Helper
JLoader::register('Jnt_HanhphucHelper', __DIR__ . '/helpers/jnt_hanhphuc.php');

$controller = JControllerLegacy::getInstance('Jnt_Hanhphuc');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
