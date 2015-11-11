<?php

class Jnt_HanhphucModelAlbum extends JModelLegacy
{
	public function getItem()
	{
		$id = JRequest::getInt('id', 0);
		
		// Update hits 
		$this->updateHits($id);
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select('a.*')
				->from('#__hp_albums' . ' a')
				->where('a.id = ' . $id)
				->where('a.state = 1');
		
		// join category
// 		$query->select('c.title AS category_title');
// 		$query->join('INNER', '#__categories c ON c.id = a.catid');
		
		// join gmap info
		// $query->select('g.*');
		// $query->join('LEFT', '#__ntrip_gmap_info g ON a.id = g.item_id AND g.item_type = "'.$type.'"');
		
		$db->setQuery($query);
		
		$item = $db->loadObject();
		
		if ($db->getErrorMsg())
		{
			die($db->getErrorMsg());
		}
				
		return $item;
	}
	
	public function getOtherImages($type = 'albums')
	{
		if (!$type)
			$type = $this->itemType;
		
		$item = $this->getItem($type, false);
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select('*')
				->from('#__hp_images')
				->where('item_type = "' . $type . '"')
				->where('item_id = ' . (int) $item->id)
				->order('id ASC')
		;
		
		$db->setQuery($query);
		$rs = $db->loadObjectList();
		
		if ($db->getErrorMsg())
			die($db->getErrorMsg ());
		
		$thumb = true;
		
		if ($thumb)
		{
			foreach ($rs as & $item)
			{
				//$tmp = explode('/', $item->images);
		
				$image_name = $item->images;
		
				$imagePath = JPATH_ROOT . DS . 'images' . DS . 'albums' . DS . $item->item_id;
		
				// shift an el (image folder) in $tmp
// 				array_shift($tmp);
		
				// remove last el (file name) in $tmp
// 				array_pop($tmp);
		
				$image_path = $imagePath;
		
				$thumb_path = $imagePath . '/thumbs/';
		
				$thumb_image_path = $thumb_path . DS . $image_name;
		
				@JFolder::create($thumb_path);
				
				$thumbW = CFG_THUMBNAIL_WIDTH;
				$thumbH = CFG_THUMBNAIL_HEIGHT;
		
				// create thumb if not exist
				if (!file_exists($thumb_image_path) && file_exists($image_path . DS . $image_name))
					JEUtil::thumbnail($image_path, $thumb_path, $image_name, $thumbW, $thumbH);
		
				$item->thumb = JURI::root() . 'images/albums/'.$item->item_id.'/thumbs/' . 't-' . $thumbW . 'x' . $thumbH . '-' . $image_name;
			}
		}
		
		return $rs;
	}
	
	public function getOtherItems($type = 'albums')
	{
		if (!$type)
			$type = $this->itemType;
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		if (!is_object($item))
			$item = $this->getItem($type, false);
		
		$query->select('*')
				->from('#__hp_albums')
				->where('id != ' . (int) $item->id)
				->where('state = 1');
// 				->where('catid = ' . (int) $item->catid);
				
		
		$db->setQuery($query, 0, CFG_DEFAULT_NUMBER_OF_OTHER_ITEMS);
		$rs = $db->loadObjectList();
		
		if ($db->getErrorMsg())
			die($db->getErrorMsg ());
		
		return $rs;
	}
	
	protected function updateHits($itemId = 0)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->update('#__hp_albums')->set('hits = hits + 1')->where('id = ' . $itemId);
		
		$db->setQuery($query);
		
		$db->query();
		
		if ($db->getErrorMsg())
			die ($db->getErrorMsg());
	}
}