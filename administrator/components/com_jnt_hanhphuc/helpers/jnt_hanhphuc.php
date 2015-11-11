<?php
/**
 * @version		$Id: banners.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Banners component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_jnt_hanhphuc
 * @since		1.6
 */
class Jnt_HanhPhucHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName) {
		
		
		JHtmlSidebar::addEntry(
			'Album Categories',
			'index.php?option=com_categories&extension=com_jnt_hanhphuc.albums',
			$vName == 'categories.albums'
		);
		
		JHtmlSidebar::addEntry(
			'Service Categories',
			'index.php?option=com_categories&extension=com_jnt_hanhphuc',
			$vName == 'categories'
		);
		
		JHtmlSidebar::addEntry(
			'Albums',
			'index.php?option=com_jnt_hanhphuc&view=albums',
			$vName == 'albums'
		);
		
		JHtmlSidebar::addEntry(
			'User Content',
			'index.php?option=com_jnt_hanhphuc&view=articles',
			$vName == 'articles'
		);

        JHtmlSidebar::addEntry(
            'Services',
            'index.php?option=com_jnt_hanhphuc&view=services',
            $vName == 'services'
        );
		
		JHtmlSidebar::addEntry(
			'Orders',
			'index.php?option=com_jnt_hanhphuc&view=orders',
			$vName == 'orders'
		);
		
		JHtmlSidebar::addEntry(
			'Users',
			'index.php?option=com_jnt_hanhphuc&view=users',
			$vName == 'users'
		);
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0) {
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_jnt_hanhphuc';
		} else {
			$assetName = 'com_jnt_hanhphuc.category.'.(int) $categoryId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
	
	static function copyTempFiles($itemId, $images = array(), $itemType = 'hotels')
	{
	    $tmpFolder = JPATH_ROOT . DS . 'tmp' . DS . JFactory::getUser()->id . DS . JFactory::getSession()->getId() . DS;
	    $tmpThumbFolder = $tmpFolder . 'thumbnail' . DS;
	    
	    $destFolder = JPATH_ROOT . DS . 'images' . DS . $itemType . DS . $itemId . DS;	    
	    $destThumbFolder = $destFolder . 'thumbnail' . DS;
	    
	    jimport( 'joomla.filesystem.folder' );
	    
	    // make folder	    
	    JFolder::create($destFolder, 0777);
	    
	    // make thumb
	    JFolder::create($destThumbFolder, 0777);
	    
	    foreach ($images as $img)
	    {
			$src = $tmpFolder . $img;
			$dest = $destFolder . $img;
			
			copy($src, $dest);
			copy($tmpThumbFolder . $img, $destThumbFolder . $img);
	    }
	    
	    // delete tmp folder
	    if (is_dir($tmpFolder))
			JFolder::delete($tmpFolder);
	}
	
	static function insertImages($itemId, $images = array(), $desc = array(), $itemType = 'hotels')
	{
	    $db = JFactory::getDbo();
		
		$created = date('Y-m-d H:i:s');
		$created_by = JFactory::getUser()->id;
	    
	    foreach ($images as $key => $img)
	    {
			$query = $db->getQuery(true);
			$query->insert('#__hp_images (item_id, item_type, title, description, images, created, created_by)')
				->values($itemId . ', "' . $itemType . '", "", "'.$desc[$key].'", "' . $img . '", "'.$created.'", "'.$created_by.'"' );

			$db->setQuery($query);
			$db->query();

			if ($db->getErrorMsg())
				die($db->getErrorMsg ());
	    }
	    
	    return true;
	}
	
	static function updateImages($itemId, $curentImages = array(), $currentDesc = array(), $itemType = 'albums')
	{
	    $db = JFactory::getDbo();
	    
	    // get old images
	    $images = Jnt_HanhphucHelper::getImages($itemId, $itemType);
		
// 		var_dump($images, $curentImages, $currentDesc);
		
// 		die;
	    
	    foreach ($images as $img)
	    {
			$image = $img->images;
			
			$query = $db->getQuery(true);

			if (!in_array($img->id, array_keys($curentImages)))
			{
				// delete image
				$destFolder = JPATH_ROOT . DS . 'images' . DS . $itemType . DS . $itemId . DS;	    
				$destThumbFolder = $destFolder . 'thumbnail' . DS;

				@unlink($destThumbFolder . $image);
				@unlink($destFolder . $image);

				// delete rec in db
				
				$query->delete('#__hp_images')
					->where('id = ' . $img->id);
			}
			else
			{
				$query->update('#__hp_images')->set('description = "'.$currentDesc[$img->id].'"')->where('id = ' . $img->id);				
			}
			
			$db->setQuery($query);
			$db->query();
	    }
	}
	
	static function getImages($itemId, $itemType = 'albums')
	{
	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);
	    
	    $query->select('*')
		    ->from('#__hp_images')
		    ->where('item_id = ' . $itemId)
		    ->where('item_type = "'.$itemType.'"');
	    
	    $db->setQuery($query);
	    $rs = $db->loadObjectList('id');
	    
	    return $rs;
	}

	static function uploadImages($field, $item, $delImage = 0, $itemType = 'albums', $width = 0, $height = 0)
	{
		$jFileInput = new JInput($_FILES);
		$file = $jFileInput->get('jform', array(), 'array');
		
		// If there is no uploaded file, we have a problem...
		if (!is_array($file)) {
//			JError::raiseWarning('', 'No file was selected.');
			return '';
		}

		// Build the paths for our file to move to the components 'upload' directory
		$fileName = $file['name'][$field];
		$tmp_src    = $file['tmp_name'][$field];
		
		$image = '';
		$oldImage = '';
		$flagDelete = false;
		
//		$item = $this->getItem();
		
		// if delete old image checked or upload new file
		if ($delImage || $fileName)
		{			
			$oldImage = JPATH_ROOT . DS . str_replace('/', DS, $item->images);
			
			// unlink file
			if (is_file($oldImage))
				@unlink($oldImage);
			
			$flagDelete = true;
			
			$image = '';
		}
		
		$date = date('Y') . DS . date('m') . DS . date('d');
		
		$dest = JPATH_ROOT . DS . 'images' . DS . $itemType . DS . $date . DS . $item->id . DS;
		
		// Make directory
		@mkdir($dest, 0777, true);
		
		if (isset($fileName) && $fileName) {
			
			$filepath = JPath::clean($dest.$fileName);

			/*
			if (JFile::exists($filepath)) {
				JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_FILE_EXISTS'));	// File exists
			}
			*/

			// Move uploaded file
			jimport('joomla.filesystem.file');
			
			if (!JFile::upload($tmp_src, $filepath))
			{
				JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_UNABLE_TO_UPLOAD_FILE')); // Error in upload
				return '';
			}
			
			
			
			// if upload success, resize image
			if ($width)
			{
				require_once JPATH_ROOT . DS . 'jelibs/phpthumb/phpthumb.class.php';
				
				// create phpThumb object
				$phpThumb = new phpThumb();
				
				if (include_once(JPATH_ROOT . DS . 'jelibs/phpthumb/phpThumb.config.php')) {
					foreach ($PHPTHUMB_CONFIG as $key => $value) {
						$keyname = 'config_'.$key;
						$phpThumb->setParameter($keyname, $value);
					}
				}
				
				// this is very important when using a single object to process multiple images
				$phpThumb->resetObject();
				
				$phpThumb->setSourceFilename($filepath);
				
				// set parameters (see "URL Parameters" in phpthumb.readme.txt)
				$phpThumb->setParameter('w', $width);
				
				if ($height)
					$phpThumb->setParameter('h', $height);
				
				$phpThumb->setParameter('config_output_format', 'jpeg');
				
				// set value to return
				$image = 'images/'.$itemType.'/' . str_replace(DS, '/', $date) . '/' . $item->id . '/' . $fileName;
				
				if ($phpThumb->GenerateThumbnail()) 
				{
					if ($image) 
					{
						if (!$phpThumb->RenderToFile($filepath)) 
						{
							// do something on failed
							die('Failed (size='.$width.'):<pre>'.implode("\n\n", $phpThumb->debugmessages).'</pre>');
						}
						
						$phpThumb->purgeTempFiles();
					}
				} else {
					// do something with debug/error messages
					echo 'Failed (size='.$width.').<br>';
					echo '<div style="background-color:#FFEEDD; font-weight: bold; padding: 10px;">'.$phpThumb->fatalerror.'</div>';
					echo '<form><textarea rows="100" cols="300" wrap="off">'.htmlentities(implode("\n* ", $phpThumb->debugmessages)).'</textarea></form><hr>';
					
					die;
				}
			}
			else
			{
				// set value to return
				$image = 'images/'.$itemType.'/' . str_replace(DS, '/', $date) . '/' . $item->id . '/' . $fileName;
			}
			
		}
		else
			if (!$flagDelete)
			    $image = $item->images;
		
		return $image;
	}
	
	public static function copyFilesOnSave($content = '', $type = 'hotels', $itemId = 0)
	{
		if(!$content || !$itemId)
			return false;
	
		$date = date('Y') . DS . date('m') . DS . date('d');
	
		$dest = JPATH_ROOT . DS . 'images' . DS . 'loca_items' . DS . $type . DS . $itemId . DS;
		@mkdir($dest, 0777, true);
	
		$doc=new DOMDocument();
	
		$doc->loadHTML($content);
	
		// just to make xpath more simple
		$xml=simplexml_import_dom($doc);
	
		$images=$xml->xpath('//img');
	
		$tmpSearch = array();
		$tmpReplace = array();
	
		foreach ($images as $img)
		{
			// Explode src to get file name
			$imgSrc = explode('/', $img['src']);
			
			if($imgSrc[0] == 'tmp')
			{
				// Search & Replace
				$tmpSearch[] = $img['src'];
				$tmpReplace[] = 'images/loca_items/'.$type.'/' . $itemId . '/' . end($imgSrc);
				
				$src = str_replace('/', DS, JPATH_ROOT.'/'.$img['src']);
				
				JFile::copy($src, $dest.end($imgSrc));
			}
				
		}
	
		$content = str_replace($tmpSearch, $tmpReplace, $content);
	
		return $content;
	}
}
