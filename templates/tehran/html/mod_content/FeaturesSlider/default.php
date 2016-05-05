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
	<?php if (count($items > 2)) { ?>
		<section class="box cols cols-2 featured-items _border-bottom">
			<div>
				<?php foreach ($items as $key => $item) { ?>
				<?php $media = !empty($item->video) ? ' video' : ''; ?>
					<?php if ($key < 2) { ?>
						<article class="item<?php echo $media; ?>">
							<figure class="img">
								<a href="<?php echo $item->link; ?>">
									<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
								</a>
							</figure>
							<div class="desc">
								<?php if ($params->get('itemTitle')) { ?>
									<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
								<?php } ?>
								<time class="created"><?php echo JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC3')); ?></time>
							</div>
						</article>
					<?php } ?>
				<?php } ?>
			</div>
		</section>
		<section class="box thumbs carousel full-row">
			<div>
				<ul>
					<?php foreach ($items as $key => $item) { ?>
					<?php $media = !empty($item->video) ? ' video' : ''; ?>
						<?php if ($key > 1) { ?>
							<li class="<?php echo $media; ?>">
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
										<time class="created"><?php echo JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC3')); ?></time>
									</div>
								<?php } ?>
							</li>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</section>
		<?php
	}
}