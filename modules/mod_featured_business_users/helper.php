<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_featured_business_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_jnt_hanhphuc/helpers/route.php';

/**
 * @package		Joomla.Site
 * @subpackage	mod_featured_business_users
 * @since		1.5
 */
class modFeatured_Business_UsersHelper
{
	static function &getList($params)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$limit = $params->get('limit');

		$query->select('DISTINCT u.id, u.*')
				->from('#__users u')
// 				->where('id IN (SELECT DISTINCT business_id FROM #__hp_business_service WHERE state = 1 AND category = '. (int) $catId .' ORDER BY id DESC)')
				->join('INNER', '#__hp_business_service i ON u.id = i.business_id')
				->where('u.sticky = 1')
				->order('u.id DESC')
		;
		
		// join over profile
		$query->select('p.business_logo, p.business_address, p.business_phone')
		->join('INNER', '#__hp_business_profile p ON u.id = p.user_id')
		;
		
		// join over location: province
		$query->select('province.title AS province_title')
		->join('INNER', '#__location_province province ON p.business_city = province.id')
		;
		
		// join over location: district
		$query->select('ward.title AS ward_title')
		->join('INNER', '#__location_ward ward ON p.business_district = ward.id')
		;
		
		$option = JRequest::getString('option', '');
		$catId = JRequest::getInt('id', 0);
		$view = JRequest::getString('view', '');
		
		if ($option == 'com_jnt_hanhphuc' && $view == 'category' && $catId > 0)
		{
			$query->where('(i.category = ' . $catId . ' OR i.category IN (SELECT id FROM #__categories WHERE parent_id = ' . $catId . '))');
		}
		
		$db->setQuery($query, 0, $limit);

		$rs = $db->loadObjectList();
		
		return $rs;
	}
}
