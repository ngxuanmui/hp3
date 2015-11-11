<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_popular
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_je_content/helpers/route.php';

abstract class modHPArticlesPopularHelper
{
    public static function getList(&$params)
    {
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	
	$query->select('*')->from('#__je_content')->where('state = 1')->order('hits DESC');
	
	$db->setQuery($query, 0, 5);
	$items = $db->loadObjectList();
	
	return $items;
    }
}
