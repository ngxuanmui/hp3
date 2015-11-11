<?php
/**
 * @version		$Id: default.php $
 * @package		Joomla.Site
 * @subpackage	com_je_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		muinx
 * This component was generated by http://joomlavietnam.net/ - 2012
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

?>

<script type="text/javascript"
	src="<?php echo JURI::base(); ?>media/jquery.bxslider/jquery.bxslider.min.js"></script>

	
		<div class="col-md-12 col-sm-12 col-xs-12">
			<?php 
					$modules = JModuleHelper::getModules('homepage-slider');
					foreach($modules as $module)
					{
						echo JModuleHelper::renderModule($module);
					}
			?>
		</div>
		
	
    <div class="row">
    	<div class="col-md-9 col-sm-8 col-xs-12">
    	
    		<?php echo JEUtil::loadModule('jnt_hanhphuc_search_form'); ?>
    		
    		<div class="row">
    			<?php echo JEUtil::loadModule('business_services'); ?>
    		</div>
    	</div>
    	<div class="col-md-3 col-sm-4 hidden-xs right">
    		<?php #echo JEUtil::loadModule('right', 'module-padding'); ?>
    		<h5 class="right-sub-title">DỊCH VỤ CƯỚI</h5>
    		<?php 
				echo JEUtil::loadModule('right-sub', 'module-padding');
			?>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12">
    
    	<?php 
				echo JEUtil::loadModule('business_user_home_albums');
			?>
			</div>
    </div>

	<div class="row">
    	<?php 
    	$articles = $this->articles;
    	
    	foreach ( $articles as $item ) :
			if (isset ( $item ['sub'] )) :
		?>
			<div class="col-md-4 col-sm-4">
			
				<h3>
				    <?php
						$linkToCategory = '#';
						
						$firstCategory = array_shift ( $item ['sub'] );
						echo '<a href="' . $linkToCategory . '">' . $firstCategory->title . '</a>';
						
						$tmp = array_reverse ( $item ['sub'] );
						array_pop ( $tmp );
						$categories = array_reverse ( $tmp );
						
						$check = 0;
						?>
				    <span>
					    <?php foreach ($categories as $cat): ?>
					    <a href="#"><?php echo $cat->title; ?></a>

					    <?php
							$check ++;
							
							if ($check > 1)
								break;
						endforeach
						;
						?>
				    </span>
				</h3>
			
			
	  			<?php
	  			$listArticles = $item['articles'][$firstCategory->id];
	  			
	  			$slug = $listArticles [0]->alias ? ($listArticles [0]->id . ':' . $listArticles [0]->alias) : $listArticles [0]->id;
	  			?>
	  			<h4>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($slug, $listArticles[0]->catid)); ?>">
					<?php echo $listArticles[0]->title; ?>
				</a>
				</h4>
				<?php echo $listArticles[0]->introtext; ?>
								
								
	  		</div>
	  <?php 
	  		endif; 
	  endforeach; 
	  ?>
	</div>

	<div class="business-blogger">
	<?php echo JEUtil::loadModule('business_blog'); ?>
	</div>
