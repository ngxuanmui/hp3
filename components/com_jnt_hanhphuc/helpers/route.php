<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_jnt_hanhphuc
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.helper');
jimport('joomla.application.categories');

/**
 * Content Component Route Helper
 *
 * @static
 * @package		Joomla.Site
 * @subpackage	com_jnt_hanhphuc
 * @since 1.5
 */
abstract class Jnt_HanhphucHelperRoute
{
	protected static $lookup;
	
	/**
	 * @param	int	The route of the content item
	 */
	public static function getAlbumRoute($id, $alias = null)
	{
		$needles = array(
			'albums' => array(1),
			'album'  => array((int) $id)
		);
		
		//Create the link
		$link = 'index.php?option=com_jnt_hanhphuc&view=album&id='. $id . ( (!empty($alias)) ? '-' . $alias : '' );
		
		if ($item = self::_findItem($needles)) {
			$link .= '&Itemid='.$item;
		}
		elseif ($item = self::_findItem()) {
			$link .= '&Itemid='.$item;
		}

		return $link;
	}

	/**
	 * @param	int	The route of the content item
	 */
	public static function getArticleRoute($id)
	{
		$needles = array(
			'articles' => array(1),
			'article'  => array((int) $id)
		);
		
		//Create the link
		$link = 'index.php?option=com_jnt_hanhphuc&view=article&id='. $id;
		
		if ($item = self::_findItem($needles)) {
			$link .= '&Itemid='.$item;
		}
		elseif ($item = self::_findItem()) {
			$link .= '&Itemid='.$item;
		}

		return $link;
	}

	/**
	 * @param	int	The route of the content item
	 */
	public static function getServicesRoute($id, $alias = null)
	{
		$needles = array(
			'services_user'  => array((int) 1)
		);
		
		//Create the link
		$link = 'index.php?option=com_jnt_hanhphuc&view=services_user&user='. $id . ( (!empty($alias)) ? '-' . $alias : '' );
		
		if ($item = self::_findItem($needles)) {
			$link .= '&Itemid='.$item;
		}
		elseif ($item = self::_findItem()) {
			$link .= '&Itemid='.$item;
		}

		return $link;
	}
	
	/**
	 * @param	int	The route of the content item
	 */
	public static function getSerivceItemRoute($id, $bid, $user)
	{
		$needles = array(
			'services_user'  => array((int) 1)
		);
		//Create the link
// 		$link = 'index.php?option=com_jnt_hanhphuc&view=service&id='. $id. '&bid=' . $bid . '&user=' . $user;
		
		$link = 'index.php?option=com_jnt_hanhphuc&view=service&id=' . $id . '&bid=' . $bid . '&user=' . $user;
			
		if ($item = self::_findItem($needles)) {
			$link .= '&Itemid='.$item;
		}
		elseif ($item = self::_findItem()) {
			$link .= '&Itemid='.$item;
		}
	
		return $link;
	}
	
	/**
	 * @param	int	The route of the content item
	 */
	public static function getItemRoute($view, $id, $catid = 0)
	{
		$needles = array(
				$view  => array((int) $id)
		);
		//Create the link
		$link = 'index.php?option=com_jnt_hanhphuc&view='.$view.'&id='. $id;
			
		if ($item = self::_findItem($needles)) {
			$link .= '&Itemid='.$item;
		}
		elseif ($item = self::_findItem()) {
			$link .= '&Itemid='.$item;
		}
	
		return $link;
	}

	public static function getCategoryRoute($catid)
	{
		if ($catid instanceof JCategoryNode)
		{
			$id = $catid->id;
			$category = $catid;
		}
		else
		{
			$id = (int) $catid;
			$category = JCategories::getInstance('JE_Content')->get($id);
		}

		if($id < 1)
		{
			$link = '';
		}
		else
		{
			$needles = array(
				'category' => array($id)
			);

			if ($item = self::_findItem($needles))
			{
				$link = 'index.php?Itemid='.$item;
			}
			else
			{
				//Create the link
				$link = 'index.php?option=com_jnt_hanhphuc&view=category&id='.$id;
				if($category)
				{
					$catids = array_reverse($category->getPath());
					$needles = array(
						'category' => $catids,
						'categories' => $catids
					);
					if ($item = self::_findItem($needles)) {
						$link .= '&Itemid='.$item;
					}
					elseif ($item = self::_findItem()) {
						$link .= '&Itemid='.$item;
					}
				}
			}
		}

		return $link;
	}

	protected static function _findItem($needles = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu('site');

		// Prepare the reverse lookup array.
		if (self::$lookup === null)
		{
			self::$lookup = array();

			$component	= JComponentHelper::getComponent('com_jnt_hanhphuc');
			$items		= $menus->getItems('component_id', $component->id);
			
			foreach ($items as $item)
			{
				if (isset($item->query) && isset($item->query['view']))
				{
					$view = $item->query['view'];
					if (!isset(self::$lookup[$view])) {
						self::$lookup[$view] = array();
					}
					if (isset($item->query['id'])) {
						self::$lookup[$view][$item->query['id']] = $item->id;
					}
				}
			}
		}
		
		if ($needles)
		{
			foreach ($needles as $view => $ids)
			{
				if (isset(self::$lookup[$view]))
				{
					foreach($ids as $id)
					{
						if (isset(self::$lookup[$view][(int)$id])) {
							return self::$lookup[$view][(int)$id];
						}
					}
				}
			}
		}
		else
		{
			$active = $menus->getActive();
			if ($active && $active->component == 'com_jnt_hanhphuc') {
				return $active->id;
			}
		}

		return null;
	}
}
