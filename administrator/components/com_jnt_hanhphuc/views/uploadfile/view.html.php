<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('HotelsHelper', JPATH_COMPONENT.'/helpers/hotels.php');

/**
 * View to edit a hotel.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_ntrip
 * @since		1.5
 */
class NtripViewUploadFile extends JViewLegacy
{
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		parent::display($tpl);
	}
}
