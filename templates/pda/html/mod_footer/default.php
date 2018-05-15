<?php
/**
 * @version		$Id: default.php 22338 2011-11-04 17:24:53Z github_bot $
 * @package		Joomla.Site
 * @subpackage	mod_footer
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$date = JHTML::_('date', new JDate('now'), JText::_('Y'));
$format = '&copy; %s %s. %s.';
$siteLink = '<a href="' . JURI::base() . '">' . JFactory::getConfig()->get( 'sitename' ) . '</a>';
switch(JLanguageHelper::getLanguages('lang_code')[JFactory::getLanguage()->getTag()]->sef) {
	default:
	case 'fa':
		$text = 'تمامی حقوق محفوظ است';
		break;
	case 'en':
		$text = 'All Rights Reserved';
		break;
}
?>
<div class="copyright-text">
	<?php echo sprintf($format, $date, $siteLink, $text); ?>
</div>
