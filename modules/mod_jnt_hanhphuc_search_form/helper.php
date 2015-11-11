<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_jnt_hanhphuc_search_form
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Site
 * @subpackage	mod_jnt_hanhphuc_search_form
 * @since		1.5
 */

if (!class_exists(''))
{
	require_once JPATH_ROOT .'/components/com_jnt_hanhphuc/helpers/front.jnt_hanhphuc.php';
}

class modJnt_Hanhphuc_Serach_FromHelper
{
	static function getList($params)
	{
		$app	= JFactory::getApplication();
		$db		= JFactory::getDbo();
		$result	= array();
		$query	= $db->getQuery(true);
		
		jimport('joomla.application.categories');
		
		$catObj = JCategories::getInstance('JNT_Hanhphuc');
		
		$categories = $catObj->get()->getChildren();
		
		foreach ($categories as & $cat)
		{
			$cat->subCategories = $cat->getChildren();
		}
		
		$result['categories'] = $categories;
		
		$result['provinces'] = FrontJntHanhphucHelper::getProvinces();
		
		return $result;
	}
}
