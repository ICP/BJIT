<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_feed
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_feed
 *
 * @package     Joomla.Site
 * @subpackage  mod_feed
 * @since       1.5
 */
class ModExternalFeedHelper
{
	/**
	 * Retrieve feed information
	 *
	 * @param   \Joomla\Registry\Registry  $params  module parameters
	 *
	 * @return  JFeedReader|string
	 */
	public static function getItems($params)
	{
		return true;
	}
}
