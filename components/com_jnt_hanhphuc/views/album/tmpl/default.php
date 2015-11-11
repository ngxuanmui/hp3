<?php
// no direct access
defined('_JEXEC') or die;

$item = $this->item;

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::base() . 'media/hp/lightbox/css/lightbox.css');
?>

<script type='text/javascript' src='<?php echo JURI::base(); ?>/media/hp/html/js/jquery.masonry.min.js?ver=3.4.1'></script>
<script type='text/javascript' src='<?php echo JURI::base(); ?>/media/hp/html/js/jquery.infinitescroll.min.js?ver=3.4.1'></script>

<script type="text/javascript">
<!--
var USE_MASONRY = true;
var fileLoadingImage = '<?php echo JURI::base(); ?>media/hp/lightbox/images/loading.gif';
var fileCloseImage = '<?php echo JURI::base(); ?>media/hp/lightbox/images/close.png';

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

<script src="<?php echo JURI::base(); ?>media/hp/lightbox/js/lightbox.js"></script>

<div class="container">
	<div class="float-left left-side">
		<h1 class="content-title">
			Album ảnh: <?php echo $item->name; ?>
		</h1>

		<div class="line-break-news"></div>

		<div class="fulltext box">
		
			<?php if (!empty($this->otherImages)): ?>
			<div id="wrapper" class="clearfix">
				<?php
				foreach ($this->otherImages as $img):
					
				?>
				<div class="tack">
					<div class="tackHolder">
						<a title="<?php echo $this->escape($item->description); ?>" href="<?php echo JURI::base(); ?>images/albums/<?php echo $item->id; ?>/<?php echo $img->images; ?>" rel="lightbox[album]">
							<img src="<?php echo JURI::base(); ?>images/albums/<?php echo $item->id; ?>/thumbs/t-<?php echo CFG_THUMBNAIL_WIDTH . 'x' . CFG_THUMBNAIL_HEIGHT . '-' . $img->images; ?>" style="width: 190px;" />
						</a>
					</div>
					<p class="description">
					<?php echo $this->escape($item->description); ?>
					</p>
					<div class="clear"></div>
				</div>
				<?php endforeach; ?>
			</div>
			
			<div class="com-comments">
	    		<?php JEUtil::showForm($item->id, 'album', $item->name); ?>
	    	</div>

			<?php endif; ?>
			
			<div class="clear"></div>

		</div>

		</div>

		<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
    </div>
    
    <div class="clear"></div>
</div>

<div class="clear"></div>