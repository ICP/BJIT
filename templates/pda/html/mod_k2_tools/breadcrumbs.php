<?php
/**
 * @version		$Id: breadcrumbs.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;
?>

<ol class="breadcrumb">
<?php
$output = '';
if ($params->get('home')) {
	$output .= '<li><a href="' . JURI::root() . '">' . $params->get('home', JText::_('K2_HOME')) . '</a></li>';
	if (count($path)) {
		foreach ($path as $link) {
//			$output .= '<span class="bcSeparator">' . $params->get('seperator', '&raquo;') . '</span>' . $link;
			$output .= '<li>' . $link . '</li>';
		}
	}
//	if ($title) {
//		$output .= '<span class="bcSeparator">' . $params->get('seperator', '&raquo;') . '</span>' . $title;
//	}
} else {
//	if ($title) {
//		$output .= '<span class="bcTitle">' . JText::_('K2_YOU_ARE_HERE') . '</span>';
//	}
	if (count($path)) {
		foreach ($path as $link) {
//			$output .= $link . '<span class="bcSeparator">' . $params->get('seperator', '&raquo;') . '</span>';
			$output .= '<li>' . $link . '</li>';
		}
	}
	$output .= $title;
}

echo $output;
?>
</ol>
