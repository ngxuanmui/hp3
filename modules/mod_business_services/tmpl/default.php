<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_business_services
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<div class="module-title module-padding" id="business-promotion">THÔNG TIN KHUYẾN MẠI</div>

<div class="line-break"></div>

<div class="box">
	
	
	<ul class="promotion-content">
		<?php 
		if (!empty($list)):
			foreach ($list as $item) : 
				$slug = $item->id.':'.$item->alias;
				$link = JRoute::_(Jnt_HanhphucHelperRoute::getArticleRoute($slug));
		?>
		<li>
			<div class="left-side-promotion-content fltlft">
				<?php if ($item->images): ?>
				<img src="<?php echo JURI::base(); ?><?php echo $item->images; ?>" width="70" />
				<?php endif; ?>
			</div>
			<div class="right-side-promotion-content fltrgt">
				<h1>
					<a href="<?php echo $link; ?>" class="promotion-title">
						<?php 
						echo $item->name ? $item->name : $item->username;
						
						echo  ' - ' . $item->title;
						
						?>
					</a>
				</h1>
				<div>
					<?php 
					$str = strip_tags($item->introtext);
					echo mb_substr($str, 0, 100);
					
					if (mb_strlen($str) > 100)
						echo ' ...';
					?>
				</div>
			</div>
			
			<div class="clr"></div>
				
		</li>
		<?php 
			endforeach; 
		else: 
		?>
		<li>
			Chưa có tin khuyến mại nào.
		</li>
		<?php endif; ?>
		
	</ul>
</div>