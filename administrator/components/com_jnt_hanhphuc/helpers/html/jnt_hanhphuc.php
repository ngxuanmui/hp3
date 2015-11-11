<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

/**
 * Banner HTML class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 * @since       2.5
 */
abstract class JHtmlJnt_Hanhphuc
{
	
	/**
	 * Returns a pinned state on a grid
	 *
	 * @param   integer       $value			The state value.
	 * @param   integer       $i				The row index
	 * @param   boolean       $enabled		An optional setting for access control on the action.
	 * @param   string        $checkbox		An optional prefix for checkboxes.
	 *
	 * @return  string        The Html code
	 *
	 * @see JHtmlJGrid::state
	 *
	 * @since   2.5.5
	 */
	public static function pinned($value, $i, $enabled = true, $checkbox = 'cb')
	{
		$states	= array(
			1	=> array(
				'sticky_unpublish',
				'COM_BANNERS_BANNERS_PINNED',
				'COM_BANNERS_BANNERS_HTML_PIN_BANNER',
				'COM_BANNERS_BANNERS_PINNED',
				false,
				'publish',
				'publish'
			),
			0	=> array(
				'sticky_publish',
				'COM_BANNERS_BANNERS_UNPINNED',
				'COM_BANNERS_BANNERS_HTML_UNPIN_BANNER',
				'COM_BANNERS_BANNERS_UNPINNED',
				false,
				'unpublish',
				'unpublish'
			),
		);

		return JHtml::_('jgrid.state', $states, $value, $i, 'users.', $enabled, true, $checkbox);
	}
	
	public static function is_verify_user($value, $i, $enabled = true, $checkbox = 'cb')
	{
		$states	= array(
				1	=> array(
						'is_verify_user_unpublish',
						'User verified. Click to un-verify',
						'User un-verified. Click to verify',
						'COM_BANNERS_BANNERS_PINNED',
						false,
						'publish',
						'publish'
				),
				0	=> array(
						'is_verify_user_publish',
						'User un-verified. Click to verify',
						'User un-verified. Click to verify',
						'COM_BANNERS_BANNERS_UNPINNED',
						false,
						'unpublish',
						'unpublish'
				),
		);
	
		return JHtml::_('jgrid.state', $states, $value, $i, 'users.', $enabled, true, $checkbox);
	}
	
	public static function is_verify_transaction($value, $i, $enabled = true, $checkbox = 'cb')
	{
		$states	= array(
				1	=> array(
						'is_verify_transaction_unpublish',
						'User verified. Click to un-verify',
						'User un-verified. Click to verify',
						'COM_BANNERS_BANNERS_PINNED',
						false,
						'publish',
						'publish'
				),
				0	=> array(
						'is_verify_transaction_publish',
						'User un-verified. Click to verify',
						'User un-verified. Click to verify',
						'COM_BANNERS_BANNERS_UNPINNED',
						false,
						'unpublish',
						'unpublish'
				),
		);
	
		return JHtml::_('jgrid.state', $states, $value, $i, 'users.', $enabled, true, $checkbox);
	}

}
