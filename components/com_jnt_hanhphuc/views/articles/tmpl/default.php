<?php
$limitStart = JRequest::getInt('limitstart', 0);

$next = (($limitStart / CFG_LIST_USER_CONTENT) + 1) * CFG_LIST_USER_CONTENT;
?>

<script type='text/javascript' src='<?php echo JURI::base(); ?>/media/hp/html/js/jquery.masonry.min.js?ver=3.4.1'></script>
<script type='text/javascript' src='<?php echo JURI::base(); ?>/media/hp/html/js/jquery.infinitescroll.min.js?ver=3.4.1'></script>

<script type="text/javascript">
<!--
var USE_MASONRY = true;

jQuery(function($){
	$('#wrapper').infinitescroll({
        navSelector : '.infinitescroll',
        nextSelector : '.infinitescroll a',
        itemSelector : '#wrapper .tack',
        loading: {
            img   : BASE_URL + "/media/hp/html/images/ajax-loader.gif",
            selector: '#selector',
            msgText: '',
            finishedMsg: ''
			}
		}, function(arrayOfNewElems) {
			var $newElems = $( arrayOfNewElems ).css({ opacity: 0 });
			// ensure that images load before adding to masonry layout
			$newElems.imagesLoaded(function(){
				// show elems now they're ready
				$newElems.css({ opacity: 1 });
				$('#wrapper').masonry( 'appended', $newElems, true ); 
			});
	});
});
//-->
</script>
<div class="container">
	<div class="float-left left-side">
		<h1 class="content-title">
			Thông tin khuyến mại
		</h1>

		<div class="line-break-news"></div>

		<div class="fulltext box">

			<div id="wrapper" class="clearfix">
				<?php 
				foreach($this->items as $item): 
					$item->slug = $item->id . ':' . $item->alias;
				
					$link = JRoute::_(Jnt_HanhphucHelperRoute::getArticleRoute($item->slug, $item->catid));
				?>
				<div class="tack">
					<div class="tackHolder">
							
						<a
							href="<?php echo $link; ?>"
							title="<?php echo $this->escape($item->title); ?>">
							<?php if ($item->images): ?>
						    <img src="<?php echo JURI::base().$item->images; ?>"
								style="float: left; margin-right: 10px; width: 190px;" />
						    <?php endif; ?>
						</a>
					</div>
					<p class="description">
					<?php echo $this->escape($item->title); ?>					
					</p>
					<div class="clear"></div>
				</div>
				<?php endforeach; ?>
			</div>
			
			<div class="clear"></div>
			
			<?php 
			$pagination = $this->pagination;
			
			$counter = $pagination->getPagesCounter();
			
			if (!empty($counter)):
			?>
			<div id="selector">
				<div class="infinitescroll">
					<a href="<?php echo 'index.php?option=com_jnt_hanhphuc&view=articles&limitstart=' . $next; ?>" >Next Page</a>
				</div>
			</div>

			<div class="pagination">
				<?php #echo $this->pagination->getPagesLinks(); ?>
			</div>

			<div class="clear"></div>
			<?php endif; ?>

		</div>

		</div>

		<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
    </div>
	</div>

	<div class="clear"></div>
