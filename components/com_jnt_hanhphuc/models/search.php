<?php
/**
 * @version		$Id: category.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 */
class Jnt_HanhPhucModelSearch extends JModelList {
/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 * @since	1.6
	 */
	protected function ___getListQuery() {
		$app = JFactory::getApplication();
		$type 		= $app->getUserState('business.service.search.type');
		$city 		= $app->getUserState('business.service.search.city');
		$district 	= $app->getUserState('business.service.search.district');
		$search 	= $app->getUserState('business.service.search.search');
		
		$db = JFactory::getDbo();
		$query = "SELECT s.*, c.id as cat_id, c.title as cat_title FROM #__hp_business_service s JOIN #__categories c ON s.category = c.id WHERE s.state = 1";
		
		
		if($type) {
			//TODO: tim theo loai hinh dich vu
			$query .= ' AND s.category = '.$type . ' OR s.category IN (SELECT id FROM #__categories WHERE parent_id = '.$type.')';
		} else {
			//TODO: tim theo dia diem
			$query .= " AND s.business_id IN (SELECT user_id FROM #__user_profiles up 
													WHERE (up.profile_key = 'profile.business_city' AND up.profile_value like ".$db->quote("%$city%").")
															AND (up.profile_key = 'profile.business_district' AND up.profile_value LIKE ".$db->quote("%$district%").")
											 )";
		}
		
// 		if($search) {
// 			$query .= " AND s.business_id IN (SELECT user_id FROM #__user_profiles p WHERE p.profile_key = 'profile.business_name' AND p.profile_value like ".$db->quote("%$search%").")";
// 		}
		
        return $query;
	}
	
	protected function getListQuery()
	{
		$catId = JRequest::getInt('catid');
		$province = JRequest::getInt('province');
		$district = JRequest::getInt('district');
		$search = JRequest::getString('search');
		
		if (empty($catId) && empty($province) && empty($district) && empty($search))
		{
			$link = JRoute::_('index.php?option=com_jnt_hanhphuc&view=categories');
			$msg = 'Vui lòng chọn ít nhất 1 điều kiện tìm kiếm';
			
			$app = JFactory::getApplication();
			$app->redirect($link, $msg, 'warning');
			
			return true;
		}
		
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('DISTINCT u.id, u.*')
				->from('#__users u')
// 				->where('id IN (SELECT DISTINCT business_id FROM #__hp_business_service WHERE state = 1 AND category = '. (int) $catId .' ORDER BY id DESC)')
// 				->join('INNER', '#__hp_business_service i ON u.id = i.business_id')
// 				->where('i.category = ' . $catId . ' OR i.category IN (SELECT id FROM #__categories WHERE parent_id = '.$catId.')')
				->order('u.id DESC')
		;
		
// 		// join over profile
// 		$query->select('p.business_logo, p.business_address, p.business_phone')
// 				->join('INNER', '#__hp_business_profile p ON u.id = p.user_id')
// 		;
		
// 		// join over location: province
// 		$query->select('province.title AS province_title')
// 				->join('INNER', '#__location_province province ON p.business_city = province.id')
// 		;
		
// 		// join over location: district
// 		$query->select('ward.title AS ward_title')
// 				->join('INNER', '#__location_ward ward ON p.business_district = ward.id')
// 		;

		// join over profile
		$query->select('p.business_logo')
		->join('INNER', '#__hp_business_profile p ON u.id = p.user_id')
		;
		
		// join over addresses
		$query->select('ua.subname, ua.address, ua.phone')->join('INNER', '#__user_addresses ua ON ua.created_by = u.id');
		
		
		// join over location: province
		$query->select('province.title AS province_title')
		->join('INNER', '#__location_province province ON ua.city = province.id')
		;
		
		// join over location: district
		$query->select('district.title AS district_title')
		->join('INNER', '#__location_district district ON ua.district = district.id')
		;
		
		if ($catId)
			$query->where('u.id IN (SELECT DISTINCT business_id FROM #__hp_business_service WHERE state = 1 AND category = '. (int) $catId .' ORDER BY id DESC)');
		
// 		if ($search)
// 			$query->where('(username LIKE ' . $db->quote('%' . $search . '%') . ' OR name LIKE '  . $db->quote('%' . $search . '%') . ' OR id IN (SELECT DISTINCT business_id FROM #__hp_business_service WHERE state = 1 AND name LIKE '  . $db->quote('%' . $search . '%') . ')) ');
		
		if ($search)
			$query->where('(u.username LIKE ' . $db->quote('%' . $search . '%') . ' OR u.name LIKE '  . $db->quote('%' . $search . '%') . ') ');
		
		if ($province)
			$query->where('u.id IN (SELECT DISTINCT user_id FROM #__hp_business_profile WHERE business_city = '.$province.')');
		
		if ($district)
			$query->where('u.id IN (SELECT DISTINCT user_id FROM #__hp_business_profile WHERE business_district = '.$district.')');
		
// 		echo $query;
		
		return $query;
	}

	/**
	 * Method to get an array of data items.
	 *
	 * @return	mixed	An array of data items on success, false on failure.
	 * @since	1.6
	 */
	public function ___getItems() {
		$serviceInfos = parent::getItems();
		$businessInfos = array();
		
		$introModel = JModel::getInstance('Intro', 'Jnt_HanhPhucModel');
		foreach($serviceInfos as $serviceInfo) {
			$businessInfo = $introModel->getBusinessInfo($serviceInfo->business_id);
			$businessInfo->serviceInfo = $serviceInfo;
			$businessInfos[] = $businessInfo;
		}
		return $businessInfos;
	}
	
	public function getCategories() {
		$db = JFactory::getDbo();
		$db->setQuery(
			'SELECT * FROM #__categories c WHERE c.published = 1 AND c.extension = '.$db->quote('com_jnt_hanhphuc').' ORDER BY c.lft'
		);
		return $db->loadObjectList();
	}
	
/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null) {
		$app = JFactory::getApplication();
		
		$type = JRequest::getInt('type', 0);
		$city = JRequest::getString('city', '');
		$district = JRequest::getString('district', '');
		$search = JRequest::getString('search', '');
		
		$app->setUserState('business.service.search.type', $type);
		$app->setUserState('business.service.search.city', $city);
		$app->setUserState('business.service.search.district', $district);
		$app->setUserState('business.service.search.search', $search);
		
		parent::populateState($ordering, $direction);
	}
}