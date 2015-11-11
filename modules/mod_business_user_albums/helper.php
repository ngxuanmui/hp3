<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_business_user_albums
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Site
 * @subpackage	mod_business_user_albums
 * @since		1.5
 */
class modBusinessUserAlbumsHelper
{
	static function getList(&$params)
	{
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		
		$query->select('a.*')
				->from('#__hp_albums a')
				->where('a.state = 1')
				->order('a.id DESC')
		;
		
		$arrViews = array('services', 'service');
		
		$userId = JRequest::getInt('user', 0);
		$view = JRequest::getString('view');
		
		if ($userId && in_array($view, $arrViews))
			$query -> where('a.created_by = ' . (int) $userId);
		else 
			return false;
		
		$db->setQuery($query, 0, 15);
		
		$rs = $db->loadObjectList();
		
		$thumb = true;
		
		if ($thumb)
		{
			foreach ($rs as & $item)
			{
				$tmp = explode('/', $item->images);
		
				$image_name = end($tmp);
		
				$imagePath = JPATH_ROOT . DS . 'images' . DS . 'albums' . DS . $item->id;
		
				// shift an el (image folder) in $tmp
								array_shift($tmp);
		
				// remove last el (file name) in $tmp
								array_pop($tmp);
		
				$image_path = $imagePath;
		
				$thumb_path = $imagePath . '/thumbs/';
		
				$thumb_image_path = $thumb_path . DS . $image_name;
		
				@JFolder::create($thumb_path);
		
				$thumbW = CFG_THUMBNAIL_WIDTH;
				$thumbH = CFG_THUMBNAIL_HEIGHT;
		
				// create thumb if not exist
				if (!file_exists($thumb_image_path) && file_exists($image_path . DS . $image_name))
					JEUtil::thumbnail($image_path, $thumb_path, $image_name, $thumbW, $thumbH);
		
				$item->thumb = JURI::root() . 'images/albums/'.$item->id.'/thumbs/' . 't-' . $thumbW . 'x' . $thumbH . '-' . $image_name;
			}
		}
		
// 		var_dump($rs);
		
		return $rs;
	}
}
