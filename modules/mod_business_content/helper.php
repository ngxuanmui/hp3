<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_business_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

/**
 * @package		Joomla.Site
 * @subpackage	mod_business_content
 * @since		1.5
 */
class modBusinessContentHelper
{
	static function getList(&$params)
	{
		$limit		= $params->get('limit', 5);
		
		$db		= JFactory::getDbo();
		
		// query all
		$query = modBusinessContentHelper::getQuery($params, false);
		
		// check user content
		$checkUserContent = modBusinessContentHelper::checkUserContent($params);
		
		if ($checkUserContent)
			$query = modBusinessContentHelper::getQuery($params, true);
		
		$db->setQuery($query, 0, $limit);
		
		$rows = $db->loadObjectList('id');
		
		return $rows;
	}
	
	static function getQuery($params, $byUser = true, $count = false)
	{
		$db		= JFactory::getDbo();
		$rows	= array();
		$query	= $db->getQuery(true);
		
		if ($count)
			$query->select('COUNT(c.id) AS count_id');
		else
			$query->select('c.*');
		
		$query->from('#__hp_business_content c')
				->where('c.state = 1')
		;
		
		$featured	= $params->get('featured', 0);
		
		if ($featured)
			$query->where('c.featured = 1');
		
		// join over user to get username
		$query->select('u.username, u.name');
		$query->join('INNER', '#__users u ON u.id = c.created_by');
		
		// filter by user id
		$userId = JRequest::getInt('user');
		
		if ($userId && $byUser)
			$query->where('c.created_by = ' . $userId);
		
		// Filter by start and end dates.
		$nullDate	= $db->Quote($db->getNullDate());
		$nowDate	= $db->Quote(JFactory::getDate()->toSql());
		
		$query->where('(c.publish_up = '.$nullDate.' OR c.publish_up <= '.$nowDate.')');
		$query->where('(c.publish_down = '.$nullDate.' OR c.publish_down >= '.$nowDate.')');
		
		$query->order('c.id DESC');
		
// 		echo $query->dump();
		
		return $query;
	}
	
	static function checkUserContent($params)
	{
		$db		= JFactory::getDbo();
		
		$query = modBusinessContentHelper::getQuery($params, true, true);
		
		$db->setQuery($query);
		
		$obj = $db->loadObject();
		
		if ($db->getErrorMsg())
			die ($db->getErrorMsg());
		
		if (!empty($obj->count_id))
			return true;
		
		return false;
	}
}
