<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_search
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$db   =& JFactory::getDBO();
$lang =& JFactory::getLanguage()->getTag();
$db->setQuery('select id from heb17_menu where link like "%com_search%" order by id desc' );
$mitemid = ($db->getErrorNum()) ? 0 : intval($db->loadResult());

/* Checking user's platform for iphone version of website */
if (!defined('platform')) {
	if (!class_exists('Browser')) {
		require_once (JPATH_BASE . '/templates/pooya/libs/browser.php');
	}
	$browser = new Browser;
	$platform = strtolower($browser->getPlatform());
	$browser = strtolower($browser->getBrowser());
	$uiRequest = strtolower(JRequest::getVar('ui', null, 'GET'));
	$uiCookie = &JRequest::getVar('ui', null, 'cookie');
	$devices = array('ipod', 'ipad', 'iphone', 'android', 'blackberry');
	if (in_array($platform, $devices) || in_array($browser, $devices) || in_array($uiRequest, $devices) || in_array($uiCookie, $devices)){
		define('platform', 'iphone', true);
	}
} /* End of checking user's platform */

?>
<form action="<?php echo JRoute::_('index.php');?>" method="post">
	<div class="search">
		<?php
			$output = '<input name="searchword" id="mod-search-searchword" maxlength="'.$maxlength.'"  class="inputbox" type="text" size="'.$width.'" value="'.$text.'"  onblur="if (this.value==\'\') this.value=\''.$text.'\';" onfocus="if (this.value==\''.$text.'\') this.value=\'\';" />';

			if ($button) :
				if ($imagebutton) :
					$button = '<input type="image" value="'.$button_text.'" class="button" src="'.$img.'" onclick="this.form.searchword.focus();"/>';
				else :
					$button = '<input type="submit" value="'.$button_text.'" class="button" onclick="this.form.searchword.focus();"/>';
				endif;
			endif;
			
			/*
			if (platform == 'iphone') {
				$button = '<a onClick="this.form.searchword.focus();" href="" class="btn btn-small search-button"><span class="icon-search"></span></a>';
			}
			*/
			switch ($button_pos) :
				case 'top' :
					$button = $button.'<br />';
					$output = $button.$output;
					break;

				case 'bottom' :
					$button = '<br />'.$button;
					$output = $output.$button;
					break;

				case 'right' :
					$output = $output.$button;
					break;

				case 'left' :
				default :
					$output = $button.$output;
					break;
			endswitch;

			echo $output;
		?>
	<input type="hidden" name="task" value="search" />
	<input type="hidden" name="option" value="com_search" />
	<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
	</div>
</form>
