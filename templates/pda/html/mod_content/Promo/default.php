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
	<div>
		<?php foreach ($items as $key => $item) { ?>
			<a href="<?php echo JURI::base(); ?>promotion">
				<span class="text"><?php echo strip_tags($item->introtext, '<strong>'); ?></span>
				<?php if ($params->get('itemImage') && isset($item->image)) { ?>
					<span class="img">
						<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
					</span>
				<?php } ?>
			</a>
		<?php } ?>
	</div>
<?php } ?>