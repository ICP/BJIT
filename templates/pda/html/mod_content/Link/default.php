<?php
/**
 * @version		$Id: default.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<?php if (count($items)) { ?>
	<?php foreach ($items as $key => $item) { ?>
		<div class="link-item">
			<a href="<?php echo $item->link; ?>">
				<strong><?php echo $item->title; ?></strong>
				<span><?php echo strip_tags($item->introtext); ?></span>
			</a>
		</div>
	<?php } ?>
<?php }