<div id="wrapper" class="clearfix">
				<?php 
				foreach($this->items as $item): 
					$item->slug = $item->id . ':' . $item->alias;
				
					$link = JRoute::_(Jnt_HanhphucHelperRoute::getItemRoute('album', $item->slug));
				?>
				<div class="tack">
					<div class="tackHolder">
							
						<a
							href="<?php echo $link; ?>"
							title="<?php echo $this->escape($item->name); ?>">
							<?php if ($item->images): ?>
						    <img src="<?php echo JURI::base().$item->images; ?>"
								style="float: left; margin-right: 10px; width: 50%;" />
						    <?php endif; ?>
						</a>
					</div>
					<p class="description">
					<?php echo $this->escape($item->name); ?>					
					</p>
					<div class="clear"></div>
				</div>
				<?php endforeach; ?>
			</div>
			
			<div class="clear"></div>