<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_random_image
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';


$items = ModUGCHelper::getItems($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$layout = '';
if (stristr($params->get('layout', 'request_title'), '_')) {
	$layoutParts = explode('_', $params->get('layout', 'request_title'));
	for ($i = 0; $i < count($layoutParts); $i++) {
		$layout .= ucfirst($layoutParts[$i]);
	}
} else {
	$layout = ucfirst($params->get('layout', 'request_title'));
}

require JModuleHelper::getLayoutPath('mod_ugc', $layout);
