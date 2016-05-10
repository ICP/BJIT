<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_feed
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
// require_once __DIR__ . '/helper.php';

// Check if feed URL has been set
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
if (!empty ($params->get('feed'))) {
	require JModuleHelper::getLayoutPath('mod_external_feed', $params->get('layout', 'default'));
}