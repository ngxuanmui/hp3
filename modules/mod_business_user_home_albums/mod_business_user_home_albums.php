<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_business_user_home_albums
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$user = JFactory::getUser();

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$list = modBusinessUserHomeAlbumsHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

if (!class_exists('Jnt_HanhphucHelperRoute'))
	require_once JPATH_ROOT.'/components/com_jnt_hanhphuc/helpers/route.php';

if (empty($list))
	return false;

require JModuleHelper::getLayoutPath('mod_business_user_home_albums', $params->get('layout', 'default'));
