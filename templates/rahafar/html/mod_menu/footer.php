<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access.
defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
jimport('joomla.application.module.helper');
?>
<ul class="list-inline" role="tablist">
	<?php
	foreach ($list as $i => &$item) {
		$class = '';
		if (in_array($item->id, $path)) {
			$class .= ' active';
		}
		if ($item->deeper) {
			$class .= ' deeper';
		}
		if ($item->parent) {
			$class .= ' parent';
		}
		if (!empty($item->params->get('pageclass_sfx'))) {
			$class .= ' has-module';
		}

		$attrib = ' data-pageid="' . $item->id . '" role="presentation" class="' . trim($class) . '"';

		echo '<li' . $attrib . '>';

		// Render the menu item.
		switch ($item->type) :
			case 'separator':
			case 'url':
			case 'component':
				require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
				break;

			default:
				require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
				break;
		endswitch;

		
		if (!empty($item->params->get('pageclass_sfx'))) {
			$modules = JModuleHelper::getModules($item->params->get('pageclass_sfx'));
			foreach ($modules as $module) {
				echo JModuleHelper::renderModule($module, array('style' => 'default'));
			}
		}
		// The next item is deeper.
		if ($item->deeper) {
			echo '<ul class="child">';
		}
		// The next item is shallower.
		elseif ($item->shallower) {
			echo '</li>';
			echo str_repeat('</ul></li>', $item->level_diff);
		}
		// The next item is on the same level.
		else {
			echo '</li>';
		}
	}
	?></ul>