<?php

// No direct access
defined('_JEXEC') or die;

$category = $this->category;
?>

<div class="container">
    <div class="float-left left-side">
		<div class="sub-container">
			<?php echo JEUtil::loadModule('jnt_hanhphuc_search_form'); ?>
		</div>
		
		<div class="sub-container">
			<div>
				<ul class="list-service-categories">
					<li>
						<h1 class="category-title"><?php echo $category->title; ?></h1>
						<div class="line-break-news"><span></span></div>
						<ul class="list-service-items fltlft">
							<?php 
                            foreach ($this->items as $user):
                                $link = JRoute::_(Jnt_HanhphucHelperRoute::getServicesRoute($user->id, $user->username));
                            ?>
                            
							<li class="fltlft">
								<div class="image fltlft">
                                    <a class="title" href="<?php echo $link; ?>">
									<?php
									$userLogo = $user->business_logo;
									
									if ($userLogo):
									?>
									<img src="<?php echo JURI::base(); ?>images/business/<?php echo $user->business_logo; ?>" />
									<?php else: ?>
									<img src="<?php echo JURI::base(); ?>images/no_business_logo.png" />
									<?php endif; ?>
                                    </a>
								</div>
								<div class="fltlft info">
									<h3>
										<a class="title" href="<?php echo $link; ?>">
											<?php echo $user->name; ?>
										</a>
									</h3>
									<p><strong>Địa chỉ</strong>: <?php echo $user->address . ', ' . $user->district_title . ', ' . $user->province_title; ?></p>
    								
								</div>
								<div class="clr"></div>
							</li>
							<?php endforeach; ?>
						</ul>
						<div class="clr"></div>
					</li>
				</ul>
				
				<?php if (!empty($this->items)): ?>
				<div class="pagination"><?php echo $this->pagination->getPagesLinks(); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
    </div>
</div>

<div class="clr"></div>