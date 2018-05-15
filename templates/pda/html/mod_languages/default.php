<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_languages
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<ul>
	<?php foreach ($list as $language): ?>
		<?php if ($params->get('show_active', 0) || !$language->active): ?>
			<li class="<?php echo $language->active ? 'active' : ''; ?>" dir="<?php echo JLanguage::getInstance($language->lang_code)->isRTL() ? 'rtl' : 'ltr' ?>"><a href="<?php echo $language->link; ?>"><?php
					$langCode = $language->sef == "fa" ? 'فا' : $language->sef;
					echo $params->get('full_name', 1) ? $language->title_native : $langCode;
					?></a></li>
		<?php endif; ?>
<?php endforeach; ?>
</ul>
