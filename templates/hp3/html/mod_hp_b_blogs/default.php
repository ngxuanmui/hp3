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
		  maxSlides: 6,
		  slideWidth: 70,
		  slideMargin: 0,
		  nextSelector: '#slider-next',
		  prevSelector: '#slider-prev'
		  });
	});
</script>

<div class="module-business-blog <?php echo $moduleclass_sfx?> padding-5">
	
    <div class="row bussiness-blog-box box relative">
        <?php if(!empty($blogs)): ?>
        <a href="#" id="slider-prev" class="pull-left"></a>
        <a href="#" id="slider-next" class="pull-right"></a>
        <ul class="b_blogs">
        <?php 
        foreach($blogs as $blog): 
        	$link = JRoute::_(Jnt_HanhphucHelperRoute::getServicesRoute($blog->userid, $blog->username));
        ?>
        	<li class="col-md-4">
		        <a href="<?php echo $link; ?>" class="image pull-left" title="<?php echo $blog->business_name; ?>">
		        	<?php /* <img src="<?php echo JURI::base() . 'images/business/' . $blog->business_logo ?>" /> */ ?>
		        	<img src="http://hanhphuc.vn/images/business/3669/logo/logo.jpg" class="img-responsive" />
		        </a>
		        <?php endforeach; ?>
				
				<div class="clear"></div>
			</li>
		</ul>
        
		<?php endif; ?>
    </div>

</div>
