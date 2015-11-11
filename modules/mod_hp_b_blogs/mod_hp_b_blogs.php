<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_banners
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

//$headerText	= trim($params->get('header_text'));
//$footerText	= trim($params->get('footer_text'));
$moduleTitle = $params->get('mod_title', 'Blog doanh nghiệp');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$blogs = &modBusinessBlogHelper::getListBlogs($params);

require JModuleHelper::getLayoutPath('mod_hp_b_blogs', $params->get('layout', 'default'));
