<?php
/**
 * @version		$Id: default.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_jnt_hanhphuc
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Display all services
 */

// no direct access
defined('_JEXEC') or die;

$user = $this->user_info;
$profile = $user->profile;

define('CFG_THUMB_SERVICE_IMAGE', 300);

?>

<div class="container">
    <div class="float-left left-side">
		<div class="sub-container list-services relative">
			<div class="services-list relative">
				
				<h2><?php echo $this->category->title; ?></h2>
				<ul class="items">
					<?php foreach($this->items as $item):?>
					
					<?php 
					
					$thumb = 'images/users/'.$user->id.'/services/'.$item->id.'/thumb-'.CFG_THUMB_SERVICE_IMAGE.'-'.$item->img;
					$image = 'images/users/'.$user->id.'/services/'.$item->id.'/'.$item->img;
					
					$filepath = JPATH_ROOT . DS . $image;
					$thumbImage = JPATH_ROOT . DS . $thumb;
					
					$thumbImageLink = '';
					
					if (!file_exists($thumbImage) && file_exists($image))
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
						$phpThumb->setParameter('w', CFG_THUMB_SERVICE_IMAGE);
						
						$phpThumb->setParameter('config_output_format', 'jpeg');
						
						// set value to return
						if ($phpThumb->GenerateThumbnail())
						{
							if ($image)
							{
								if (!$phpThumb->RenderToFile($thumbImage))
								{
									// do something on failed
									die('Failed (size='.$width.'):<pre>'.implode("\n\n", $phpThumb->debugmessages).'</pre>');
								}
								
								$thumbImageLink = JURI::base() . $thumb;
						
								$phpThumb->purgeTempFiles();
							}
						} else {
							// do something with debug/error messages
							echo 'Failed (size='.CFG_THUMB_SERVICE_IMAGE.').<br>';
							echo '<div style="background-color:#FFEEDD; font-weight: bold; padding: 10px;">'.$phpThumb->fatalerror.'</div>';
							echo '<form><textarea rows="100" cols="300" wrap="off">'.htmlentities(implode("\n* ", $phpThumb->debugmessages)).'</textarea></form><hr>';
								
							die;
						}
					}
					?>
					
					
					<li class="service-business-detail">
							<a title="<?php echo htmlspecialchars($item->name); ?>" href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=service&id='.$item->category.'&bid='.$item->id.'&user=' . JRequest::getString('user'))?>">
								<?php if (!empty($thumbImageLink)): ?>
								<div class="img">
									<img src='<?php echo JURI::base() . $thumb; ?>' />
								</div>
								<?php else: ?>
								NO IMAGE
								<?php endif; ?>
							</a>
					</li>
					<?php endforeach;?>
				</ul>
				
				<div class="clr"></div>
				
				<div class="pagination">
					<?php echo $this->pagination->getPagesLinks()?>
				</div>
				
				<div class="clr"></div>
			</div>
			
		</div>
	</div>
	
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
    </div>
</div>

<div class="clr"></div>
