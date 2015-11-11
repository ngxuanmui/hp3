<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_business_user_menu
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<div class="relative list-items">
	<ul>
		<?php 
		foreach ($list as $item): 
			$img = @getimagesize(JPATH_ROOT . DS . $item->images);
		
			$w = 100;
			
			$frameHeight = 70;
			
			$h = 0;
			
			if (!empty($img))
				$h = round(( $img[1] * $w ) / $img[0]);	

			if ($h < $frameHeight)
				$margin = round (($frameHeight - $h) / 2);
			
			$item->slug = $item->id . ':' . $item->alias;
			
			$link = JRoute::_(Jnt_HanhphucHelperRoute::getAlbumRoute($item->slug));
			
		?>
		<li>
			<div>
				<a href="<?php echo $link; ?>">
					<img src="<?php echo $item->thumb; ?>" alt="<?php echo $item->name; ?>" style="border: none; width: <?php echo $w . 'px'; ?>;" />
				</a>
			</div>
		</li>
			
		<?php endforeach; ?>
	</ul>
</div>

<div class="clr"></div>