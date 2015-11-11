<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_hp_social
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$item = $params->get('item');
$itemType = $params->get('item_type');
$otherImages = $params->get('other_images');
$gmapInfo = $params->get('gmap');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_hp_social', $params->get('layout', 'default'));