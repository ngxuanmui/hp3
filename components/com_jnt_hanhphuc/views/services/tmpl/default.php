<?php
/**
 * @version		$Id: default.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$user = $this->user_info;
$profile = $user->profile;

$checkInfo = $this->checkInfo;

// check info
$hasAddresses = (!empty($this->addresses)) ? true : false;
$hasServices = (!empty($this->items)) ? true : false;
$hasPromotions = $checkInfo['has_promotions'];
$hasWeddingImages = $checkInfo['has_albums'];
$hasVerifyBusiness = $user->is_verify_user > 0 ? true : false;
$hasVerifyTransaction = $user->is_verify_transaction ? true : false;

?>

<script type="text/javascript">
<!--
jQuery(function($) {
	  $('a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html,body').animate({
	          scrollTop: target.offset().top
	        }, 1000);
	        return false;
	      }
	    }
	  });
	});
//-->
</script>

<div class="container">
    <div class="float-left left-side">
		<div class="sub-container list-services relative">
			<h1><?php echo $user->name; ?></h1>
			
			<div class="business-intro-desc">
			
				<?php if ($profile->business_logo != ''): ?>				
				<div class="business-intro-logo fltlft">
					<img src="<?php echo JURI::base();?>images/business/<?php echo $profile->business_logo; ?>" />
				</div>
				<?php endif; ?>
			
				<ul class="business-verify-info fltrgt">
					<li class="business-contact<?php if (!$hasAddresses) echo '-disable'; ?>">
						<?php if ($hasAddresses): ?>
						<a href="#contact-info">&nbsp</a>
						<?php endif; ?>
					</li>
					<li class="business-promotion<?php if (!$hasPromotions) echo '-disable'; ?>">
						<?php if ($hasPromotions): ?>
						<a href="#business-promotion">&nbsp</a>
						<?php endif; ?>
					</li>
					<li class="business-verify-business<?php if (!$hasVerifyBusiness) echo '-disable'; ?>">
						
					</li>
					<li class="business-wedding-image<?php if (!$hasWeddingImages) echo '-disable'; ?>">
						<?php if ($hasWeddingImages): ?>
						<a href="#business-user-albums">&nbsp</a>
						<?php endif; ?>
					</li>
					<li class="business-service<?php if (!$hasServices) echo '-disable'; ?>">
						<?php if ($hasServices): ?>
						<a href="#product-service">&nbsp</a>
						<?php endif; ?>
					</li>
					<li class="business-verify-transaction<?php if (!$hasVerifyTransaction) echo '-disable'; ?>">
						
					</li>
				</ul>
				
				<div class="clr"></div>
			
				<?php echo $user->info->content; ?>
				
				<?php if (!empty($profile->nick_skype) || !empty($profile->nick_yahoo)): ?>				
				<div>
					<strong>Liên hệ: </strong> 
					<?php if (!empty($profile->nick_skype)): ?>	
					<a href="skype:<?php echo $profile->nick_skype; ?>?call" class="skype"><?php echo $profile->nick_skype_alias ? $profile->nick_skype_alias : $profile->nick_skype; ?></a>
					<?php endif; ?>
					<?php if (!empty($profile->nick_yahoo)): ?>	
					<a href="ymsgr:SendIM?<?php echo $profile->nick_yahoo; ?>" class="yahoo"><?php echo $profile->nick_yahoo_alias ? $profile->nick_yahoo_alias : $profile->nick_yahoo; ?></a>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
			
			
			<?php if (count($this->items) > 0): ?>
			
			<div class="services-list relative">
				
				<div class="seperator absolute"></div>
				
				<h2 id="product-service">SẢN PHẨM VÀ DỊCH VỤ</h2>
				<ul class="items">
					<?php foreach($this->items as $item):?>
					<li class="service-business-detail">
							<a title="<?php echo htmlspecialchars($item->name); ?>" href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=service&id='.$item->category.'&bid='.$item->id.'&user=' . JRequest::getString('user'))?>">
								<?php if ($item->img): ?>
								<div class="img">
									<img src='<?php echo JURI::base()?>images/users/<?php echo $user->id?>/services/<?php echo $item->id?>/<?php echo $item->img; ?>' />
								</div>
								<?php else: ?>
								NO IMAGE
								<?php endif; ?>
							</a>
					</li>
					<?php endforeach;?>
				</ul>
				
				<div class="clr"></div>
				
				<div class="pagination">
					<?php echo $this->pagination->getPagesLinks()?>
				</div>
				
				<div class="clr"></div>
			</div>
			<?php endif; ?>
			
			<div class="business-info relative" id="contact-info">
				
				<div class="seperator absolute"></div>
					<h3 style="font-size: 14px; padding: 0 0 10px;"><?php echo $profile->business_name; ?></h3>
					
					<?php if (!empty($profile->business_sitename) || !empty($profile->business_website)): ?>
					<ul>
						<?php if (!empty($profile->business_sitename)): ?>
						<li>
							<?php 
							$business_sitename = $profile->business_sitename;
							
							if (strpos($business_sitename, 'facebook') === false)
								$business_sitename = 'https://www.facebook.com/' . $business_sitename;
							?>
							Facebook: <a href="<?php echo $business_sitename ?>" target="_blank"><?php echo $profile->business_sitename; ?></a></li>
						<?php endif; ?>
						
						<?php if (!empty($profile->business_website)): ?>
						<li>
							<?php 
							$business_website = $profile->business_website;
							
							if (strpos($business_website, '://') === false)
								$business_website = 'http://' . $business_website;
							?>
							Website: <a href="<?php echo $business_website; ?>" target="_blank"><?php echo $profile->business_website; ?></a></li>
						<?php endif; ?>
					</ul>
					<?php endif; ?>
					
					<?php if ($hasAddresses): ?>
					
					<div style="color: #CCC;">
					(Click vào địa chỉ để xem bản đồ)
					</div>
					
					<ul class="list-address">
						<?php foreach ($this->addresses as $add): ?>
						
						<?php 
						// map
						$address = $add->address . '+' . $add->district_title . '+' . $add->province_title;
						$address = base64_encode(urlencode($address));
						?>
						<li>
							<a href="#" class="show-map-address" rel="<?php echo $add->id; ?>" add="<?php echo $address; ?>">
								<?php 
								if (!empty($add->subname))
									echo $add->subname . ': ';
								?>
								<?php echo $add->address; ?>, <?php echo $add->district_title; ?>, <?php echo $add->province_title; ?>
							</a>
							
							<?php if (!empty($add->phone) || !empty($add->fax) || !empty($add->hotline)): ?>
							<div class="hidden address-content content-<?php echo $add->id; ?>">
								<?php if (!empty($add->phone)): ?>
								<span>Điện thoại: <?php echo $add->phone; ?></span>
								<?php endif; ?>
								
								<?php if (!empty($add->fax)): ?>
								<span>Fax: <?php echo $add->fax; ?></span>
								<?php endif; ?>
								
								<?php if (!empty($add->hotline)): ?>
								<span>Hot line: <?php echo $add->hotline; ?></span>
								<?php endif; ?>
							</div>
							<?php endif; ?>
						</li>
						<?php endforeach; ?>
						
						
					</ul>
					
					<div class="map-container not-display" style="width: 635px; display: none; ">
						<div id="map-canvas" style="width: 635px; height: 330px;"></div>
					</div>
					
					<?php endif; ?>
			
				<div class="clr"></div>
			</div>
			
			
			<div class="comments-container relative box">
		    	<div class="seperator absolute"></div>
		    	
		    	<div class="com-comments">
		    		<script type="text/javascript">
		    			var ITEM_ID_COMMENT = '<?php echo $user->id; ?>';
		    			var ITEM_TYPE_COMMENT = 'user';
		    		</script>
		    		<?php JEUtil::showForm($user->id, 'user', $user->name); ?>
		    	</div>
		    </div>
		</div>
	</div>
	
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
    </div>
</div>

<div class="clr"></div>
