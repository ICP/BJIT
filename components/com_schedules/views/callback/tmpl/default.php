<?php
/**
 * @version     1.0.0
 * @package     com_schedules
 * @copyright   Copyright (C) 2012,  Pooya TV. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Farid Roshan <faridv@gmail.com> - http://www.faridr.ir
 */

// no direct access
defined('_JEXEC') or die;

// header("Content-type: text/xml; charset=utf-8");
include_once JPATH_COMPONENT_SITE . '/assets/jdf.php';

$request = JRequest::getVar('q', null);
switch ($request) {
	default:
	case 'homepage':
		$view = 'homepage';
		break;
}

require JPATH_COMPONENT_SITE . '/views/callback/tmpl/output/' . $view . '.class.php';

JFactory::getApplication()->close();