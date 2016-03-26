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
$date = new JDate('now');

?>
<div class="copyright-text">
&copy;&nbsp;<?php echo JHTML::_('date', $date, JText::_('Y')); ?>.&nbsp;
کلیه حقوق این وب‌سایت  متعلق به&nbsp;<a href="<?php echo JURI::base(); ?>">شبکه مستند سیما</a>&nbsp;می‌باشد.
</div>