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
<div class="module <?php echo $moduleclass_sfx ?>">
    <div class="tab">
        <span class="icons"><?php echo $moduleTitle ?></span>
    </div>
    <?php if(empty($serviceCategories)): ?>
    <?php else: ?>
    <div class="content service-content">
        <?php foreach($serviceCategories as $category): ?>
        <h2 class="margin-top-10 float-left"><?php echo $category->title ?></h2>
        <div class="clr"></div>
        <ul class="float-left service one-edge-shadow">
            <?php foreach($category->services as $service): ?>
            <li>
                <a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=service&id='.$service->cat_id.'&bid='.$service->business_id) ?>"><img src="<?php echo !empty($service->image) ? $service->image : 'images/sampledata/sample.png' ?>" /></a>
                <p><a href="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&view=service&id='.$service->cat_id.'&bid='.$service->business_id) ?>"><?php echo !empty($sevice->business_name) ? $sevice->business_name : 'Tên nhà cung cấp' ?></a></p>
            </li>
            <?php endforeach ?>
        </ul>
        <div class="clr"></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>