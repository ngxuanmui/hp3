<?php
/**
 * @version		$Id: default.php 21020 2011-03-27 06:52:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');

// Create shortcuts to some parameters.
?>

<div class="float-left left-side">
		<div class="sub-container">
			<div>
			    <p class="search-text">GIỚI THIỆU DOANH NGHIỆP</p>
				<div class="line-break-search">
					<span></span>
				</div>
			    <div style="margin: 20px 0; ">
			        <?php echo $this->data->content ?>
			    </div>
			    <?php 
			    $user = JFactory::getUser();
			    if($user->id == $this->businessInfo->id && $user->id = $this->data->business_id):
			    ?>
			    <div class="business-intro-manager">
			        <a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=intro&layout=edit&bid='.$this->data->business_id) ?>">Chỉnh sửa</a>
			    </div>
			    <?php endif; ?>
			</div>
	</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
	</div>	
	<div class="clr"></div>