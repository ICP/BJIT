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
		<?php if ($params->get('itemImage') || $params->get('itemIntroText')) { ?>
			<?php if ($params->get('itemImage') && isset($item->image)) { ?>
				<figure>
					<a href="<?php echo $item->link; ?>">
						<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
					</a>
				</figure>
			<?php } ?>
			<div class="desc">
				<?php if ($params->get('itemTitle')) { ?>
					<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
				<?php } ?>
				<?php if ($params->get('itemIntroText')) { ?>
					<p><?php echo $item->introtext; ?></p>
				<?php } ?>
				<?php if ($params->get('itemReadMore')) { ?>
					<a class="more" href="<?php echo $item->link; ?>">بیشتر...</a>
				<?php } ?>
			</div>
		<?php } ?>
	<?php } ?>
	</ul>
	<?php
}