<?php

//require thumb lib
// require_once JPATH_ROOT . DS . 'jelibs/phpthumb/ThumbLib.inc.php';

class JEUtil
{
	/* show comment form */
	public static function showForm($itemId, $itemType, $title = '')
	{
		JModelLegacy::addIncludePath(JPATH_ROOT.'/components/com_hp_comment/models', 'Hp_CommentModel');
	
		$model = JModelLegacy::getInstance('Comment', 'Hp_CommentModel');
		
		$listComments = $model->getListComments($itemId, $itemType, $title);
	
		include_once JPATH_ROOT . DS . 'components/com_hp_comment/views/forms/comment.php';
	}
	
	public static function thumbnail($image_path, $thumb_path, $image_name, $thumbnail_width = 0, $thumbnail_height = 0)
	{
		require_once(JPATH_ROOT . '/jelibs/phpthumb/phpthumb.class.php');
	
		// create phpThumb object
		$phpThumb = new phpThumb();
	
		// this is very important when using a single object to process multiple images
		$phpThumb->resetObject();
	
		// set data source
		$phpThumb->setSourceFilename($image_path . DS . $image_name);
	
		// set parameters (see "URL Parameters" in phpthumb.readme.txt)
		if ($thumbnail_width)
			$phpThumb->setParameter('w', $thumbnail_width);
	
		if ($thumbnail_height)
			$phpThumb->setParameter('h', $thumbnail_height);
		
		$phpThumb->setParameter('zc', 'l');
	
		// set parameters
		$phpThumb->setParameter('config_output_format', 'jpeg');
	
		// generate & output thumbnail
		$output_filename = str_replace('/', DS, $thumb_path) . DS . 't-' . $thumbnail_width . 'x' . $thumbnail_height . '-' . $image_name; # .'_'.$thumbnail_width.'.'.$phpThumb->config_output_format;
	
		$capture_raw_data = false;
	
		if ($phpThumb->GenerateThumbnail()) {
			//			$output_size_x = ImageSX($phpThumb->gdimg_output);
			//			$output_size_y = ImageSY($phpThumb->gdimg_output);
			//			if ($output_filename || $capture_raw_data) {
			////				if ($capture_raw_data && $phpThumb->RenderOutput()) {
			////					// RenderOutput renders the thumbnail data to $phpThumb->outputImageData, not to a file or the browser
			////					mysql_query("INSERT INTO `table` (`thumbnail`) VALUES ('".mysql_escape_string($phpThumb->outputImageData)."') WHERE (`id` = '".$id."')");
			////				} elseif ($phpThumb->RenderToFile($output_filename)) {
			////					// do something on success
			////					echo 'Successfully rendered:<br><img src="'.$output_filename.'">';
			////				} else {
			////					// do something with debug/error messages
			////					echo 'Failed (size='.$thumbnail_width.'):<pre>'.implode("\n\n", $phpThumb->debugmessages).'</pre>';
			////				}
			//				$phpThumb->purgeTempFiles();
			//			} else {
			$phpThumb->RenderToFile($output_filename);
			//			}
		} else {
			// do something with debug/error messages
			//			echo 'Failed (size='.$thumbnail_width.').<br>';
			//			echo '<div style="background-color:#FFEEDD; font-weight: bold; padding: 10px;">'.$phpThumb->fatalerror.'</div>';
			//			echo '<form><textarea rows="10" cols="60" wrap="off">'.htmlentities(implode("\n* ", $phpThumb->debugmessages)).'</textarea></form><hr>';
		}
	
		return $output_filename;
	}
	
	public static function convertAlias( $str )
	{
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
	
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
	
		$str = str_replace(
				array('"', "'", '#', '!', '@', '$', '%', '^', '&', '*', '(', ')', '+'),
				'',
				$str
		);
		
		$str = str_replace(' ', '-', $str);
	
		return strtolower($str);
	}
	
	function getRandomString($length = 7)
	{
	    $validCharacters = "abcdefghijkmnpqrstuxyvwzABCDEFGHIJKLMNPQRSTUXYVWZ23456789";
	    $validCharNumber = strlen($validCharacters);
	 
	    $result = "";
	 
	    for ($i = 0; $i < $length; $i++)
	    {
	        $index = mt_rand(0, $validCharNumber - 1);
	        $result .= $validCharacters[$index];
	    }
	 
	    return $result;
	}
	
	public function resizeImage($file, $thumbFile, $thumbW = null, $thumbH = null, $crop = true)
	{
		if(!$thumbW) $thumbW = 220;
		if(!$thumbH) $thumbH = 60;
		
		if(!file_exists( $thumbFile ) && is_file($file))
		{
			//make thumb
			$thumb =  PhpThumbFactory::create($file);
			$thumb -> resize($thumbW);
			
			if($crop)
				$thumb->crop(0, 0, $thumbW, $thumbH);
				
			$thumb -> save($thumbFile);
		}
	}
	
	function is_serialized($data)
	{
	    if (trim($data) == "")
	        return false;
	    
	    if (preg_match("/^(i|s|a|o|d)(.*);/si",$data))
	        return true;
	    
	    return false;
	}
	
	function thumb($images, $pathUpload, $pathThumb, $thumbW, $thumbH = null, $crop = true)
	{
		//get array of image
		$images = unserialize($images);
		$thumbFile = array();
		
		$path = '';
		
		foreach ($images as $img)
		{
			$newPathThumb = null;
			//explode image by path seperate
			$tmp = explode('/', $img);
			
			//remove last element in array
			$imgFile = array_pop($tmp);

			//re-build path
			$path = implode('/', $tmp);
			
			$newPathThumb = $pathThumb . $path;
			
			$thumbFile[] = $path . '/thumbnail-' . $imgFile;
			
			//make dir if not exist
			if(!is_dir($newPathThumb))
				mkdir($newPathThumb, 0777, true);
			
			$createThumbFile = $newPathThumb . '/thumbnail-' . $imgFile;
			
			//make thumb
			$file = $pathUpload . $img;
						
			if(!file_exists( $createThumbFile ) && is_file($file))
			{
				$thumb =  PhpThumbFactory::create($file);
				$thumb -> resize($thumbW);
				
				if($crop)
				{
					$thumb->crop(0, 0, $thumbW, $thumbH);
				}
					
				$thumb -> save($createThumbFile);
			}
			
			
		}
		
		return $thumbFile;
	}
	
	public static function loadModule($pos, $class = '', $showTitle = false, $lineBreak = true, $params = null)
	{
		$modules = JModuleHelper::getModules($pos);

		foreach($modules as $module)
		{
			if ($module->showtitle && $showTitle)
			{
				echo '<div class="module-title '.$class.'">' . $module->title . '</div>';
				if ($lineBreak)
					echo '<div class="line-break"></div>';
			}
			
			if (!empty($params))
			{
				$tmpParams = json_decode($module->params, true);
				$p = array_merge($tmpParams, $params);
                
                $module->params = json_encode($p);
                
                //var_dump($module->params);
			}
			
			echo JModuleHelper::renderModule($module);
		}
	}
	
	public function getAdminInfo()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select('*')->from('#__users')->where('usertype = "deprecated"');
		$db->setQuery($query);
		
		$obj = $db->loadObject();
		
		return $obj;
	}
}