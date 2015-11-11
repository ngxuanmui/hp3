<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$item = $this->item;

?>

<div class="container">
    <div class="float-left left-side">
		<div class="sub-container content">
			<?php if (is_object($item)): ?>
			<h1><?php echo $item->title; ?></h1>
			<div class="view-content">
				<?php echo $item->content; ?>
			</div>
			<div class="com-comments">
	    		<?php JEUtil::showForm($item->id, 'article', $item->title); ?>
	    	</div>
			<?php else: ?>
			<div class="view-content">
				<h1>Bài viết không tồn tại.</h1>
			</div>
			<?php endif; ?>
		</div>
		
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
    </div>
</div>

<div class="clr"></div>
