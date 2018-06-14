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
	<ul class="item-titles">
		<?php foreach ($items as $key => $item) { ?>
			<li data-index="<?php echo $key; ?>" class="<?php echo $key == 0 ? 'active' : ''; ?>">
				<h3><?php echo explode(':', $item->title)[0]; ?></h3>
				<div class="circle">
					<?php echo explode(':', $item->title)[1]; ?>
				</div>
			</li>
		<?php } ?>
	</ul>
	<ul class="item-bodies">
		<?php foreach ($items as $key => $item) { ?>
			<li data-index="<?php echo $key; ?>" class="<?php echo $key == 0 ? 'active' : ''; ?>">
				<div class="desc">
					<div class="introtext"><?php echo $item->introtext; ?></div>
					<div class="item-text"><?php echo $item->fulltext; ?></div>
				</div>
			</li>
		<?php } ?>
	</ul>
	<?php
}