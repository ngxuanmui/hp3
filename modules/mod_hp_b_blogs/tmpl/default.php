<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_banners
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

?>

<script type="text/javascript">
jQuery(document).ready(function(){
	  jQuery('.b_blogs').bxSlider({
		  pager: false,
		  maxSlides: 8, 
		  minSlides: 8,
		  slideWidth: 70,
		  slideMargin: 0,
		  nextSelector: '#slider-next',
		  prevSelector: '#slider-prev'
		  });
	});
</script>

<div class="module-business-blog <?php echo $moduleclass_sfx?> padding-5">
    <h2><?php echo $moduleTitle ?></h2>
	
	<div class="line-break-bussiness-blog"><span></span></div>
	
    <div class="bussiness-blog-box box">
        <?php if(!empty($blogs)): ?>
        <a href="#" id="slider-prev"></a>
        <ul class="b_blogs">
        <?php 
        foreach($blogs as $blog): 
        	$link = JRoute::_(Jnt_HanhphucHelperRoute::getServicesRoute($blog->userid, $blog->username));
        ?>
        	<li style="width: 100px;">
		        <a href="<?php echo $link; ?>" class="image float-left" title="<?php echo $blog->business_name; ?>">
		        	<img src="<?php echo JURI::base() . 'images/business/' . $blog->business_logo ?>" />
		        </a>
		        <?php endforeach; ?>
				
				<div class="clear"></div>
			</li>
		</ul>
        <a href="#" id="slider-next"></a>
		<?php endif; ?>
		
		<div class="clr"></div>
    </div>

</div>
