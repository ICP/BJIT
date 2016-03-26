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
?>
<nav id="menu" class="menu">
	<button class="btn btn-success hidden-md hidden-lg" data-target="#menu ul" data-toggle="slide"><i class="icon-menu"></i></button>
	<ul class="list-unstyled list-inline nav nav-tabs" role="tablist">
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

	$attrib = ' data-pageid="' . $item->id . '" role="presentation" class="'.trim($class) .'"';

	echo '<li'.$attrib.'>';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
			require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	endswitch;

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
</nav>