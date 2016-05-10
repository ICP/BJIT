<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_syndicate
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$items = ModScheduleHelper::getItems($params);

if (is_null($items))
	return;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
if (!class_exists('jDateTime'))
	include JPATH_LIBRARIES . DS . 'vendor' . DS . 'jdate' . DS . 'jdatetime.class.php';
new jDateTime(false);
$jdate = jDateTime::date('Y-m-d', time());
require JModuleHelper::getLayoutPath('mod_schedule', $params->get('layout', 'default'));