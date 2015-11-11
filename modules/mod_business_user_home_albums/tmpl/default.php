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

<style type="text/css">
	.bx-pager-item { float: left; }
	.album-bxslider li { width: 269px; overflow: hidden; height: 150px; }
</style>

<script src="<?php echo JURI::base(); ?>media/hp/caroufredsel/jquery.carouFredSel-6.2.1-packed.js" type="text/javascript"></script>
<script type="text/javascript">
	jQuery(function($) {
		slider = $('.album-bxslider').bxSlider({
			auto: true, 
			controls: false, 
			pager: false,
			onSlideNext: function($slideElement, oldIndex, newIndex){
				changeCounterActive(newIndex);
			},
			onSlidePrev: function($slideElement, oldIndex, newIndex){
				changeCounterActive(newIndex);
			}
		});

		function changeCounterActive(newIndex)
		{
			$('#slider-slide-container span').removeClass('active');

			slideQty = slider.getSlideCount();

			idx = newIndex;

			if (newIndex > slideQty)
				idx = 0;

			var id = 's-' + idx;

			$('#' + id).addClass('active');
		}

		$('#slider-next').click(function(){
			slider.goToNextSlide();
		});

		$('#slider-prev').click(function(){
			slider.goToPrevSlide();
		});

		$('#slider-slide-container span').click(function(){
			var id = $(this).attr('id').replace('s-', '');

			$('#slider-slide-container span').removeClass('active');

			$(this).addClass('active');

			slider.goToSlide(id);
		});
	});
</script>

<div class="module-title module-padding">Album Ảnh cưới</div>
<div class="line-break"></div>
<div id="albums-wrapper" class="relative">
	<ul class="album-bxslider">
		<?php 
		foreach ($list as $item): 
			$img = getimagesize(JPATH_ROOT . DS . $item->images);
		
			$w = 269;
			
			$frameHeight = 150;
			
			$h = round(( $img[1] * $w ) / $img[0]);	

			if ($h < $frameHeight)
				$margin = round (($frameHeight - $h) / 2);
			
		?>
		<li><img src="<?php echo $item->thumb; ?>" alt="<?php echo $item->name; ?>" style="border: none; height: <?php echo $h . 'px'; ?>; width: <?php echo $w . 'px'; ?>; margin-top: <?php echo (int) $margin . 'px'; ?>" /></li>
		<?php endforeach; ?>
	</ul>
	
	
	<div id="slider-next" class="absolute"></div>
	<div id="slider-prev" class="absolute"></div>
	
	<div id="slider-slide-container" class="absolute">
		<?php for ($i = 0; $i < count($list); $i ++): ?>
		<span id="s-<?php echo $i; ?>" <?php if ($i == 0) echo 'class="active"'; ?>></span>
		<?php endfor; ?>
	</div>
</div>

<div class="clr"></div>