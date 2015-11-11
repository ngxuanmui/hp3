<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_business_services
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

define('LIMIT_HOMEPAGE_SERVICES', 6);

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

/**
 * @package		Joomla.Site
 * @subpackage	mod_business_services
 * @since		1.5
 */
class modBusinessContentHelper
{
	static function getList(&$params)
	{
		$limit		= $params->get('limit', 5);
		
		$db		= JFactory::getDbo();
		
		$query = modBusinessContentHelper::getQuery();
		
		$db->setQuery($query, 0, LIMIT_HOMEPAGE_SERVICES);
		
		$rows = $db->loadObjectList('id');
		
		foreach ($rows as & $row)
		{
			$img = json_decode($row->image);
				
			$row->img = '';
				
			if (!empty($img[0]))
			{
				$row->img = $img[0];
			}
		}
		
		return $rows;
	}
	
	static function getQuery()
	{
		$db		= JFactory::getDbo();
		$rows	= array();
		$query	= $db->getQuery(true);
		
		$query->select('s.*');
		
		$query->from('#__hp_business_service s')
				->where('s.state = 1')
		;
		
// 		$featured	= $params->get('featured', 0);
		
// 		if ($featured)
// 			$query->where('c.featured = 1');
		
		// join over user to get username
		$query->select('u.username');
		$query->join('INNER', '#__users u ON u.id = s.business_id');
		
		$query->select('p.user_id, p.business_name');
		$query->join('INNER', '#__hp_business_profile p ON u.id = p.user_id');
		
		$query->order('s.id DESC');
		
// 		echo $query->dump();
		
		return $query;
	}
}
