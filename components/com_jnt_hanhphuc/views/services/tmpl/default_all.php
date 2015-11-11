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

<script>
jQuery(function($){
    $('.item-container').hover(
        function() {
            
            var $link = $(this).find('a.item-link:first').attr('href');
            var $title = $(this).find('a.item-link:first').attr('title');
            var $img = "<div class='service-view absolute'><a title='"+$title+"' href='"+$link+"'><img src='images/xem.png' class='absolute' /></a></div>";
            
            $( this ).append( $( "<span class='service-mouse-hover transparent absolute'></span>" + $img ) );
            $( this ).find( "span:last" ).fadeIn();
            $( this ).find( "div:last img" ).fadeIn();
        }, function() {
            $( this ).find( "span:last" ).fadeOut().remove();
            $( this ).find( "div:last" ).fadeOut().remove();
        }
    );
});
</script>

<div class="container">
    <div class="float-left left-side">
		<div class="sub-container list-services relative">
        
            <h1><?php echo $this->category->title; ?></h1>
        
			<div class="services-list relative">

				<ul class="items">
					<?php foreach($this->items as $idx => $item):
// 					var_dump($item); die;
					?>
                    
                    <?php 
    				
					$thumb = 'images/users/'.$item->business_id.'/services/'.$item->id.'/thumb-'.CFG_THUMB_SERVICE_IMAGE.'-'.$item->img;
					$image = 'images/users/'.$item->business_id.'/services/'.$item->id.'/'.$item->img;
					
					$filepath = JPATH_ROOT . DS . $image;
					$thumbImage = JPATH_ROOT . DS . $thumb;
					
					$thumbImageLink = '';
                    
					if (false && !file_exists($thumbImage) && file_exists($filepath) && is_file($filepath))
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
								if (!$phpThumb->RenderToFile($thumbImage))
								{
									// do something on failed
									die('Failed (size='.$width.'):<pre>'.implode("\n\n", $phpThumb->debugmessages).'</pre>');
								}
                                
								$thumbImageLink = JURI::base() . $thumb;
						
								$phpThumb->purgeTempFiles();
						} else {
                            
							// do something with debug/error messages
							echo 'Failed (size='.CFG_THUMB_SERVICE_IMAGE.').<br>';
							echo '<div style="background-color:#FFEEDD; font-weight: bold; padding: 10px;">'.$phpThumb->fatalerror.'</div>';
							echo '<form><textarea rows="100" cols="300" wrap="off">'.htmlentities(implode("\n* ", $phpThumb->debugmessages)).'</textarea></form><hr>';
								
							die;
						}
					}
                    elseif (file_exists($thumbImage))
                        $thumbImageLink = JURI::base() . $thumb;
                    else
                        $thumbImageLink = '';
                    
                    
                    $id = $item->cat_id . '-' . $item->cat_alias;
                    $bid = $item->id . '-' . JEUtil::convertAlias($item->alias);
                    $username = $item->business_id . '-' . $item->business_username;
                    
                    $link = JRoute::_(Jnt_HanhphucHelperRoute::getSerivceItemRoute($id, $bid, $username));
                        
					?>
                    
					<li class="service-business-detail <?php if (($idx + 1)%3 == 0) echo 'last-item' ?>">
                        <div class="item-container relative">
    						<a class="item-link" title="<?php echo htmlspecialchars($item->name); ?>" href="<?php echo $link; ?>">
								<?php if (!empty($thumbImageLink)): ?>
								<div class="img">
									<img src='<?php echo JURI::base() . $thumb; ?>' />
								</div>
								<?php else: ?>
								<img src='<?php echo JURI::base()?>images/no-image-available.png' />
								<?php endif; ?>
							</a>
                            
                            <p class="item-title"><?php echo $item->name; ?></p>
                            <p class="item-price"><strong>Giá</strong>: <?php echo number_format($item->current_price); ?> VNĐ</p>
                        </div>
                        
                        <div class="item-provider">
                            <a href="<?php echo JRoute::_(Jnt_HanhphucHelperRoute::getServicesRoute($item->business_id, $item->business_username)); ?>" class="item-provider-link">
                                <?php echo $item->business_username; ?>
                            </a>
                        </div>
                            <div class="clr"></div>
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
