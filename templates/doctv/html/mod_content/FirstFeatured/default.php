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
	<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&id=' . $params->get('category_link')); ?>" class="btn category-link">بیشتر</a>
	<ul>
		<?php foreach ($items as $key => $item) { ?>
			<li>
				<?php if ($key == 0) { ?>
					<?php if ($params->get('itemImage') || $params->get('itemIntroText')) { ?>
						<div class="moduleItemIntrotext">
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
							</div>
						</div>
					<?php } ?>
				<?php } else { ?>
					<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
				<?php } ?>
			</li>
		<?php } ?>
	</ul>
<?php } ?>

<?php if ($params->get('feed')): ?>
	<div class="k2FeedIcon">
		<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID=' . $module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
<?php endif; ?>
</div>
