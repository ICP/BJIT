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
	<?php if ($params->get('category_link') && $params->get('mymenu_id')) { ?>
		<a href="<?php echo JRoute::_('index.php?option=com_k2&Itemid=' . $params->get('mymenu_id')); ?>" class="btn btn-default category-link">بیشتر</a>
	<?php } ?>
	<ul>
		<?php foreach ($items as $key => $item) { ?>
			<li>
				<div class="inner">
					<?php if ($params->get('itemImage') && isset($item->image)) { ?>
						<figure>
							<a href="<?php echo $item->link; ?>">
								<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
							</a>
						</figure>
					<?php } ?>
					<div class="desc">
						<?php if ($params->get('itemAuthor')): ?>
							<div class="item-author">
								<?php if (isset($item->authorLink)): ?>
								<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo JRoute::_('index.php?Itemid=114') . '/author/' . $item->author_id . '-' . $item->author; ?>">
										<span class="avatar"></span>
										<?php echo $item->author; ?>
									</a>
								<?php else: ?>
									<?php echo $item->author; ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if ($params->get('itemTitle')) { ?>
							<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
						<?php } ?>
						<div class="introtext">
							<?php if ($params->get('itemIntroText') && trim(strip_tags($item->introtext))) { ?>
								<p><?php echo $item->introtext; ?></p>
							<?php } ?>
							<?php if ($params->get('itemReadMore')) { ?>
								<a class="more" href="<?php echo $item->link; ?>">بیشتر...</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</li>
		<?php } ?>
	</ul>
<?php } ?>