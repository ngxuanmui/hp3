<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_business_services
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_jnt_hanhphuc/helpers/route.php';
?>
	
		<?php 
		if (!empty($list)):
			foreach ($list as $i => $item) : 
				$slug = $item->id.':'.$item->alias;
				$link = JRoute::_(Jnt_HanhphucHelperRoute::getArticleRoute($slug));
		?>
		<div class="col-xs-6 col-md-4 col-sm-6" style="padding-bottom: 5px;">
			<div class="servicebox">
				<div class="brand pull-left">
					<a href="#" class="pull-left">
						<span class="brand-img pull-left">img</span>
						<span class="pull-left"><?php echo $item->business_name; ?></span>
					</a>
				</div>
				
				<?php if ($item->img): ?>
				
					<?php 
					/* <img src='<?php echo JURI::base()?>images/users/<?php echo $item->user_id; ?>/services/<?php echo $item->id?>/<?php echo $item->img; ?>' class="img-responsive" /> */
					?>	
					
					<img alt="Sample Image" src="http://hanhphuc.vn/images/users/892/services/496/52.jpg" class="img-responsive" />
							
				<?php endif; ?>
				
						<h5><a href="<?php echo $link; ?>"><?php echo $item->name; ?></a></h5>
						
						<p>Giá: <?php echo number_format($item->current_price); ?> vnđ</p>
			</div>
		</div>
		<?php 
			endforeach; 
		?>
		<?php endif; ?>